<?php
// Get the route from the query string
$route = isset($_GET['route']) ? $_GET['route'] : 'home'; // Default route if none is provided

// Split the route into parts
$routeParts = explode('/', $route);
$page = $routeParts[0]; // The main route, e.g., 'test-connection'
$id = isset($routeParts[1]) ? $routeParts[1] : null; // The optional ID, if present

// Route handling
switch ($page) {
    case 'home':
        $data = [
            'views' => 'home.php',
            'title' => 'Home',
            'pakets' => $paketClass->all()
        ];
        require_once(__DIR__ . '/views/layouts/main.php');
        break;

    case 'detail':
        if (!$id) {
            $action->redirect('');
            break;
        }
        $paketData = $paketClass->show($id);
        $data = [
            'views' => 'detail.php',
            'title' => 'Detail Paket',
            'paketData' => $paketData,
            'metodePembayaran' => $metodePembayaranClass->all()
        ];
        require_once(__DIR__ . '/views/layouts/main.php');
        break;

    case 'order':
        $action->postMethodOnly();
        $data = $_POST;
        if (!isset($_SESSION['user'])) {
            $action->redirect('login');
            break;
        }

        $pembayaranClass->save($data, $_FILES);
        break;

    case 'login':
        $data = [
            'title' => 'Login Page'
        ];
        require_once(__DIR__ . '/views/auth/login.php');
        break;

    case 'login-action':
        $action->postMethodOnly();
        $data = $_POST;
        // Validate data
        $requiredFields = ['email' => 'string', 'password' => 'string', 'remember' => 'nullable|string'];
        $validationResult = $action->validate($requiredFields, $data);

        if (!empty($validationResult['errors'])) {
            $action->setFlashMessage('failed', 'Error: ' . implode(', ', $validationResult['errors']));
            $action->redirect('login');
            break;
        }

        $sanitizedData = $validationResult['data'];
        $authClass->login($sanitizedData);
        break;

    case 'register':
        $data = [
            'title' => 'Register Page'
        ];
        require_once(__DIR__ . '/views/auth/register.php');
        break;

    case 'register-action':
        $action->postMethodOnly();
        $data = $_POST;
        // Validate data
        $requiredFields = ['email' => 'string', 'nama' => 'string', 'password' => 'string'];
        $validationResult = $action->validate($requiredFields, $data);

        if (!empty($validationResult['errors'])) {
            $action->setFlashMessage('failed', 'Error: ' . implode(', ', $validationResult['errors']));
            $action->redirect('register');
            break;
        }

        $sanitizedData = $validationResult['data'];
        $authClass->register($sanitizedData);
        break;

    case 'logout':
        $authClass->logout();
        break;

    default:
        echo '404 Not Found';
        break;
}
