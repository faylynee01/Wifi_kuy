<?php
// Define the base URL (in case the application is in a subfolder, like localhost/wifikuy)
$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'); // Get the base path dynamically (e.g., /wifikuy)

// Get the full route from the query string (or default to 'home' if not provided)
$route = isset($_GET['route']) ? $_GET['route'] : 'home'; // Default route if none is provided

// If the route starts with the base path (in case it's running under a subfolder like localhost/wifikuy)
// Remove the base path to normalize the route
if (strpos($route, $basePath) === 0) {
    $route = substr($route, strlen($basePath));  // Strip out the base path part
}

// Remove leading slash if it exists
$route = ltrim($route, '/');

// Split the route into parts
$routeParts = explode('/', $route);
$page = $routeParts[0]; // The main route (e.g., 'test-connection')
$id = isset($routeParts[1]) ? $routeParts[1] : null; // The optional ID, if present

// Route handling
switch ($page) {
    case 'home':
        $data = [
            'views' => 'home.php',
            'title' => 'Home'
        ];
        require_once(__DIR__ . '/views/layouts/main.php');
        break;

    case 'test-connection':
        $action->testConnection();
        break;

    case 'view-item':
        if ($id) {
            echo "Displaying item with ID: " . htmlspecialchars($id);
        } else {
            echo 'No ID provided for viewing item. ';
        }
        break;


        // CRUD PENGATURAN

    case 'pengaturan':
        $data = [
            'views' => 'pengaturan.php',
            'pengaturan' => $pengaturanClass->pengaturanSekarang(),
            'title' => 'Pengaturan'
        ];
        require_once(__DIR__ . '/views/layouts/main.php');
        break;

    case 'simpan-pengaturan':
        $action->postMethodOnly();
        $requiredFields = [
            'nama_web' => 'string',
            'no_telp' => 'string', // Change to 'integer' if needed
            'email' => 'string'
        ];

        // Validate input data
        $validationResult = $action->validate($requiredFields, $_POST);

        if (!empty($validationResult['errors'])) {
            $action->setFlashMessage('failed', 'Error: ' . implode(', ', $validationResult['errors']));
            $action->redirect('pengaturan');
            break;
        }

        $sanitizedData = $validationResult['data'];
        $pengaturanClass->simpanPengaturan($sanitizedData);
        break;

        // CRUD Kelola Paket

    case 'kelola-paket':
        $data = [
            'views' => 'kelola-paket.php',
            'title' => 'Kelola Paket',
            'script' => 'kelola-paket.script.php',
            'pakets' => $paketClass->all()
        ];
        require_once(__DIR__ . '/views/layouts/main.php');
        break;

    case 'simpan-paket':
        $action->postMethodOnly();
        $requiredFields = [
            'id' => 'nullable|integer',
            'judul' => 'string',
            'kategori' => 'string', // Change to 'integer' if needed
            'tipe' => 'string',
            'harga' => 'integer'
        ];

        // Validate input data
        $validationResult = $action->validate($requiredFields, $_POST);

        if (!empty($validationResult['errors'])) {
            $action->setFlashMessage('failed', 'Error: ' . implode(', ', $validationResult['errors']));
            $action->redirect('kelola-paket');
            break;
        }

        $sanitizedData = $validationResult['data'];
        $paketClass->save($sanitizedData);
        break;

    case 'paket':
        if ($id) {
            header('Content-Type: application/json');
            echo json_encode($paketClass->show($id));
        } else {
            $action->setFlashMessage('failed', 'ID not found.');
        }
        break;

    case 'hapus-paket':
        if ($id) {
            if ($paketClass->delete($id)) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true
                ]);
                break;
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'failed'
            ]);
            break;
        }

        break;

        // CRUD Kelola Pengguna

    case 'kelola-pengguna':
        $data = [
            'views' => 'kelola-pengguna.php',
            'title' => 'Kelola Pengguna',
            'script' => 'kelola-pengguna.script.php',
            'users' => $penggunaClass->all()
        ];
        require_once(__DIR__ . '/views/layouts/main.php');
        break;

    case 'simpan-pengguna':
        $action->postMethodOnly();
        $requiredFields = [
            'id' => 'nullable|integer',
            'nama' => 'string',
            'email' => 'string', // Change to 'integer' if needed
            'password' => 'nullable|string',
            'role' => 'nullable|string'
        ];

        // Validate input data
        $validationResult = $action->validate($requiredFields, $_POST);

        if (!empty($validationResult['errors'])) {
            $action->setFlashMessage('failed', 'Error: ' . implode(', ', $validationResult['errors']));
            $action->redirect('metode-pembayaran');
            break;
        }

        $sanitizedData = $validationResult['data'];
        $penggunaClass->save($sanitizedData);
        break;

    case 'pengguna':
        if ($id) {
            header('Content-Type: application/json');
            echo json_encode($penggunaClass->show($id));
        } else {
            $action->setFlashMessage('failed', 'ID not found.');
        }
        break;

    case 'hapus-pengguna':
        if ($id) {
            if ($penggunaClass->delete($id)) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true
                ]);
                break;
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'failed'
            ]);
            break;
        }

        break;

        // CRUD Metode Pembayaran

    case 'metode-pembayaran':
        $data = [
            'views' => 'metode-pembayaran.php',
            'title' => 'Metode Pembayaran',
            'script' => 'metode-pembayaran.script.php',
            'metodes' => $metodePembayaranClass->all()
        ];
        require_once(__DIR__ . '/views/layouts/main.php');
        break;

    case 'simpan-metode':
        $action->postMethodOnly();
        $requiredFields = [
            'id' => 'nullable|integer',
            'nama' => 'string',
            'tipe' => 'string', // Change to 'integer' if needed
            'nomor_atau_norek' => 'string',
            'atas_nama' => 'string'
        ];

        // Validate input data
        $validationResult = $action->validate($requiredFields, $_POST);

        if (!empty($validationResult['errors'])) {
            $action->setFlashMessage('failed', 'Error: ' . implode(', ', $validationResult['errors']));
            $action->redirect('metode-pembayaran');
            break;
        }

        $sanitizedData = $validationResult['data'];
        $metodePembayaranClass->save($sanitizedData);
        break;

    case 'metode':
        if ($id) {
            header('Content-Type: application/json');
            echo json_encode($metodePembayaranClass->show($id));
        } else {
            $action->setFlashMessage('failed', 'ID not found.');
        }
        break;

    case 'hapus-metode':
        if ($id) {
            if ($metodePembayaranClass->delete($id)) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true
                ]);
                break;
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'failed'
            ]);
            break;
        }

        break;


        // KELOLA PEMBAYARAN

    case 'kelola-pembayaran':
        $data = [
            'views' => 'kelola-pembayaran.php',
            'title' => 'Kelola Pembayaran',
            'script' => 'kelola-pembayaran.script.php',
            'pembayarans' => $pembayaranClass->all()
        ];
        require_once(__DIR__ . '/views/layouts/main.php');
        break;

    case 'simpan-pembayaran':
        $action->postMethodOnly();
        $requiredFields = [
            'id' => 'nullable|integer',                  // For updating existing records, can be null
            'id_paket' => 'integer',                     // ID of the package
            'id_user' => 'integer',                      // User ID
            'tanggal_waktu' => 'string',
            'bukti_pembayaran' => 'nullable|string',     // File name for payment proof, can be null if no new file
            'id_metode_pembayaran' => 'integer',         // Payment method ID
            'status' => 'string',                        // Status of the payment (e.g., pending, completed)
            'invoice' => 'string',                       // Invoice code or reference number
            'kode_wifi' => 'nullable|string',            // Wi-Fi code, can be null
            'alasan' => 'nullable|string'                // Reason or notes, can be null
        ];


        // Validate input data
        $validationResult = $action->validate($requiredFields, $_POST);

        if (!empty($validationResult['errors'])) {
            $action->setFlashMessage('failed', 'Error: ' . implode(', ', $validationResult['errors']));
            $action->redirect('kelola-pembayaran');
            break;
        }

        $sanitizedData = $validationResult['data'];
        $pembayaranClass->save($sanitizedData);
        break;

    case 'pembayaran':
        if ($id) {
            header('Content-Type: application/json');
            echo json_encode($pembayaranClass->show($id));
        } else {
            $action->setFlashMessage('failed', 'ID not found.');
        }
        break;

    case 'hapus-pembayaran':
        if ($id) {
            if ($pembayaranClass->delete($id)) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true
                ]);
                break;
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'failed'
            ]);
            break;
        }

        break;

    default:
        echo '404 Not Found';
        break;
}
