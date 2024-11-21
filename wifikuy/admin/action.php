<?php
include_once("../vendor/SMTPMailer.php");

class Action
{
    public $conn;

    public function __construct()
    {
        $this->conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
        if (!$this->conn) {
            die('Error: ' . mysqli_connect_error());
        }

        if (!isset($_SESSION['user'])) {
            try {
                $this->checkToken();
                header('Content-Type: application/json');
                header('location: ' . BASE_URL . '../login');
                exit();
            } catch (\Throwable $th) {
            }
        }

        if ($_SESSION['user']['role'] !== 'admin') {
            $this->redirect('../logout');
        }
    }

    public function checkToken()
    {
        // Check if remember_token cookie exists
        if (isset($_COOKIE['remember_token'])) {
            $remember_token = $_COOKIE['remember_token'];

            // Query the database for the token and expiration time
            $query = "SELECT * FROM tbl_user WHERE remember_token = '$remember_token' LIMIT 1";
            $result = mysqli_query($this->conn, $query);
            $user = mysqli_fetch_assoc($result);

            if ($user) {
                // Check if the token has expired
                if ($user['token_expires_at'] > time()) {
                    $_SESSION['user'] = $user;
                    return true; // Valid token
                } else {
                    // Token has expired
                    $this->redirect('../logout');
                    return false; // Token expired
                }
            }
        }

        return false; // No valid remember_token found
    }


    public function redirect($url = "")
    {
        header("Location: " . BASE_URL . $url);
        exit();
    }

    public function setFlashMessage($key, $message)
    {
        $_SESSION['flash'][$key] = $message;
    }

    public function getFlashMessage($key)
    {
        if (isset($_SESSION['flash'][$key])) {
            $message = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
            return $message;
        }

        return null;
    }

    public function validate(array $requiredFields, array $inputData)
    {
        $missingFields = [];
        $typeErrors = [];
        $sanitizedData = [];

        foreach ($requiredFields as $field => $rules) {
            $isNullable = strpos($rules, 'nullable') !== false;
            $expectedType = str_replace('nullable|', '', $rules); // Remove 'nullable|' if present

            if (empty($inputData[$field])) {
                if (!$isNullable) {
                    // Only mark as missing if it's not nullable
                    $missingFields[] = "'$field'";
                }
            } else {
                $value = $inputData[$field];

                if (!$this->isValidType($value, $expectedType)) {
                    $typeErrors[] = "Field '$field' must be of type $expectedType.";
                } else {
                    $sanitizedData[$field] = htmlspecialchars(trim($value));
                }
            }
        }

        $errors = [];
        if (!empty($missingFields)) {
            $errors[] = "Field(s) " . implode(', ', $missingFields) . " are required.";
        }
        if (!empty($typeErrors)) {
            $errors = array_merge($errors, $typeErrors);
        }

        return [
            'errors' => $errors,
            'data' => $sanitizedData
        ];
    }


    private function isValidType($value, $expectedType)
    {
        switch ($expectedType) {
            case 'string':
                return is_string($value);
            case 'integer':
                return is_int($value) || (is_string($value) && ctype_digit($value));
            case 'array':
                return is_array($value);
            default:
                return false; // Invalid expected type
        }
    }


    public function postMethodOnly()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); // Set the HTTP response code to 405
            die('Invalid request method. Only POST is allowed.');
        }
    }


    public function testConnection()
    {
        if ($this->conn) {
            echo 'Database connection is successful!';
        } else {
            echo 'Failed to connect to the database.';
        }
    }
}

class Pengaturan extends Action
{
    public function pengaturanSekarang()
    {
        $tbl = 'tbl_pengaturan';
        $query = "SELECT * FROM $tbl";
        $result = mysqli_query($this->conn, $query);

        return $result ? mysqli_fetch_assoc($result) : null;
    }

    public function simpanPengaturan(array $data = [])
    {
        $tbl = 'tbl_pengaturan';

        $queryCheck = "SELECT COUNT(*) AS total FROM $tbl";
        $result = mysqli_query($this->conn, $queryCheck);
        $row = mysqli_fetch_assoc($result);

        if ($row['total'] > 0) {
            $updateQuery = "UPDATE $tbl SET 
                        nama_web = '" . mysqli_real_escape_string($this->conn, $data['nama_web']) . "',
                        no_telp = '" . mysqli_real_escape_string($this->conn, $data['no_telp']) . "',
                        email = '" . mysqli_real_escape_string($this->conn, $data["email"]) . "'
                        WHERE id = 1"; // Use appropriate condition

            if (mysqli_query($this->conn, $updateQuery)) {
                $this->setFlashMessage("success", "Berhasil menyimpan pengaturan.");
                $this->redirect('pengaturan');
            } else {
                $this->setFlashMessage("failed", "Gagal menyimpan pengaturan.");
                $this->redirect('pengaturan');
            }
        } else {
            // No rows exist, insert a new one
            $insertQuery = "INSERT INTO $tbl (nama_web, no_telp, email) VALUES (
                        '" . mysqli_real_escape_string($this->conn, $data['nama_web']) . "',
                        '" . mysqli_real_escape_string($this->conn, $data['no_telp']) . "',
                        '" . mysqli_real_escape_string($this->conn, $data['email']) . "'
                        )";

            if (mysqli_query($this->conn, $insertQuery)) {
                $this->setFlashMessage("success", "Berhasil menyimpan pengaturan.");
                $this->redirect('pengaturan');
            } else {
                $this->setFlashMessage("failed", "Gagal menyimpan pengaturan.");
                $this->redirect('pengaturan');
            }
        }
    }
}

class Paket extends Action
{
    private $tbl = 'tbl_paket';

    // Store or update a record in tbl_paket

    public function terjual()
    {
        // We want to count the number of records with 'status' = 'diterima' and matching 'id_paket'
        $query = "SELECT COUNT(*) as total FROM tbl_pembayaran WHERE status = 'diterima'";
        $result = mysqli_query($this->conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result)['total'];
        } else {
            return 0; // Record not found or no accepted payments for this package
        }
    }

    public function uangMasuk()
    {
        // We want to sum the payments where 'status' = 'diterima' and join with 'tbl_paket' to get the price
        $query = "
        SELECT SUM(paket.harga) as total_uang 
        FROM tbl_pembayaran pembayaran
        LEFT JOIN tbl_paket paket ON paket.id = pembayaran.id_paket
        WHERE pembayaran.status = 'diterima'
    ";

        $result = mysqli_query($this->conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['total_uang']; // Return the total sum of accepted payments
        } else {
            return 0; // No payments with status 'diterima'
        }
    }



    public function save(array $data = [])
    {
        if (isset($data['id']) && !empty($data['id'])) {
            // Update existing record
            $query = "UPDATE $this->tbl SET 
                        judul = '" . mysqli_real_escape_string($this->conn, $data['judul']) . "',
                        kategori = '" . mysqli_real_escape_string($this->conn, $data['kategori']) . "',
                        tipe = '" . mysqli_real_escape_string($this->conn, $data['tipe']) . "',
                        harga = '" . mysqli_real_escape_string($this->conn, $data['harga']) . "'
                        WHERE id = " . (int)$data['id'];

            if (mysqli_query($this->conn, $query)) {
                $this->setFlashMessage("success", "Berhasil mengupdate paket.");
                $this->redirect('kelola-paket');
            } else {
                $this->setFlashMessage("failed", "Gagal mengupdate paket.");
                $this->redirect('kelola-paket');
            }
        } else {
            // Insert new record
            $query = "INSERT INTO $this->tbl (judul, kategori, tipe, harga) VALUES (
                        '" . mysqli_real_escape_string($this->conn, $data['judul']) . "',
                        '" . mysqli_real_escape_string($this->conn, $data['kategori']) . "',
                        '" . mysqli_real_escape_string($this->conn, $data['tipe']) . "',
                        '" . mysqli_real_escape_string($this->conn, $data['harga']) . "'
                        )";

            if (mysqli_query($this->conn, $query)) {
                $this->setFlashMessage("success", "Berhasil menambahkan paket.");
                $this->redirect('kelola-paket');
            } else {
                $this->setFlashMessage("failed", "Gagal menambahkan paket.");
                $this->redirect('kelola-paket');
            }
        }
    }

    public function show(int $id)
    {
        $query = "SELECT * FROM $this->tbl WHERE id = $id";
        $result = mysqli_query($this->conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        } else {
            $this->setFlashMessage('failed', "Record with ID $id not found.");
            return null; // Record not found
        }
    }

    // Get all records from tbl_paket
    public function all()
    {
        $query = "SELECT * FROM $this->tbl";
        $result = mysqli_query($this->conn, $query);

        $records = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $records[] = $row;
            }
        }

        return $records; // Return an array of all records or an empty array if none found
    }

    public function total()
    {
        $query = "SELECT COUNT(*) as total FROM $this->tbl";
        $result = mysqli_query($this->conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result)['total'];
        } else {
            return 0; // Record not found
        }
    }

    // Delete a record from tbl_paket by ID
    public function delete(int $id)
    {
        // Check if the record exists before deleting
        $record = $this->show($id);

        if ($record) {
            $query = "DELETE FROM $this->tbl WHERE id = $id";
            if (mysqli_query($this->conn, $query)) {
                $this->setFlashMessage('success', "Record with ID $id deleted successfully.");
                return true; // Successfully deleted
            } else {
                $this->setFlashMessage('failed', "Failed to delete record with ID $id.");
                return false; // Deletion failed
            }
        } else {
            $this->setFlashMessage('failed', "Record with ID $id not found.");
            return false; // Record not found
        }
    }
}

class MetodePembayaran extends Action
{
    private $tbl = 'tbl_metode_pembayaran';

    // Store or update a record in tbl_paket
    public function save(array $data = [])
    {
        if (isset($data['id']) && !empty($data['id'])) {
            // Update existing record
            $query = "UPDATE $this->tbl SET 
                        nama = '" . mysqli_real_escape_string($this->conn, $data['nama']) . "',
                        tipe = '" . mysqli_real_escape_string($this->conn, $data['tipe']) . "',
                        nomor_atau_norek = '" . mysqli_real_escape_string($this->conn, $data['nomor_atau_norek']) . "',
                        atas_nama = '" . mysqli_real_escape_string($this->conn, $data['atas_nama']) . "'
                        WHERE id = " . (int)$data['id'];

            if (mysqli_query($this->conn, $query)) {
                $this->setFlashMessage("success", "Berhasil mengupdate metode pembayaran.");
                $this->redirect('metode-pembayaran');
            } else {
                $this->setFlashMessage("failed", "Gagal mengupdate metode pembayaran.");
                $this->redirect('metode-pembayaran');
            }
        } else {
            // Insert new record
            $query = "INSERT INTO $this->tbl (nama, tipe, nomor_atau_norek, atas_nama) VALUES (
                        '" . mysqli_real_escape_string($this->conn, $data['nama']) . "',
                        '" . mysqli_real_escape_string($this->conn, $data['tipe']) . "',
                        '" . mysqli_real_escape_string($this->conn, $data['nomor_atau_norek']) . "',
                        '" . mysqli_real_escape_string($this->conn, $data['atas_nama']) . "'
                        )";

            if (mysqli_query($this->conn, $query)) {
                $this->setFlashMessage("success", "Berhasil menambahkan metode pembayaran.");
                $this->redirect('metode-pembayaran');
            } else {
                $this->setFlashMessage("failed", "Gagal menambahkan metode pembayaran.");
                $this->redirect('metode-pembayaran');
            }
        }
    }

    public function show(int $id)
    {
        $query = "SELECT * FROM $this->tbl WHERE id = $id";
        $result = mysqli_query($this->conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        } else {
            $this->setFlashMessage('failed', "Record with ID $id not found.");
            return null; // Record not found
        }
    }

    // Get all records from tbl_paket
    public function all()
    {
        $query = "SELECT * FROM $this->tbl";
        $result = mysqli_query($this->conn, $query);

        $records = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $records[] = $row;
            }
        }

        return $records; // Return an array of all records or an empty array if none found
    }

    public function total()
    {
        $query = "SELECT COUNT(*) as total FROM $this->tbl";
        $result = mysqli_query($this->conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result)['total'];
        } else {
            return 0; // Record not found
        }
    }

    // Delete a record from tbl_paket by ID
    public function delete(int $id)
    {
        // Check if the record exists before deleting
        $record = $this->show($id);

        if ($record) {
            $query = "DELETE FROM $this->tbl WHERE id = $id";
            if (mysqli_query($this->conn, $query)) {
                $this->setFlashMessage('success', "Record with ID $id deleted successfully.");
                return true; // Successfully deleted
            } else {
                $this->setFlashMessage('failed', "Failed to delete record with ID $id.");
                return false; // Deletion failed
            }
        } else {
            $this->setFlashMessage('failed', "Record with ID $id not found.");
            return false; // Record not found
        }
    }
}

class Pengguna extends Action
{
    private $tbl = 'tbl_user';

    public function save(array $data = [])
    {
        // Sanitize and prepare data
        $email = mysqli_real_escape_string($this->conn, $data['email']);
        $username = isset($data['username']) ? mysqli_real_escape_string($this->conn, $data['username']) : null;
        $nama = mysqli_real_escape_string($this->conn, $data['nama']);
        $role = mysqli_real_escape_string($this->conn, $data['role']); // Adding role
        $password = isset($data['password']) ? password_hash($data['password'], PASSWORD_BCRYPT) : null;

        if (isset($data['id']) && !empty($data['id'])) {
            // Update existing record
            $query = "UPDATE $this->tbl SET 
                        email = '$email',
                        username = '$username',
                        nama = '$nama',
                        role = '$role'"; // Include role in update

            if ($password) {
                $query .= ", password = '$password'";
            }

            $query .= " WHERE id = " . (int)$data['id'];

            if (mysqli_query($this->conn, $query)) {
                $this->setFlashMessage("success", "Berhasil mengupdate pengguna.");
                $this->redirect('kelola-pengguna');
            } else {
                $this->setFlashMessage("failed", "Gagal mengupdate pengguna.");
                $this->redirect('kelola-pengguna');
            }
        } else {
            // Check if email already exists for new records
            $checkEmailQuery = "SELECT * FROM $this->tbl WHERE email = '$email' LIMIT 1";
            $result = mysqli_query($this->conn, $checkEmailQuery);

            if (mysqli_num_rows($result) > 0) {
                return ['status' => 'error', 'message' => 'Email is already registered'];
            }

            // Insert new record
            $query = "INSERT INTO $this->tbl (email, username, nama, role, password) VALUES (
                        '$email',
                        '$username',
                        '$nama',
                        '$role',
                        '$password'
                        )";

            if (mysqli_query($this->conn, $query)) {
                $this->setFlashMessage("success", "Berhasil menambahkan pengguna.");
                $this->redirect('kelola-pengguna');
            } else {
                $this->setFlashMessage("failed", "Gagal menambahkan pengguna.");
                $this->redirect('kelola-pengguna');
            }
        }
    }

    public function show(int $id)
    {
        $query = "SELECT * FROM $this->tbl WHERE id = $id";
        $result = mysqli_query($this->conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        } else {
            $this->setFlashMessage('failed', "Record with ID $id not found.");
            return null; // Record not found
        }
    }

    // Get all records from tbl_paket
    public function all()
    {
        $query = "SELECT * FROM $this->tbl ORDER BY role ASC";
        $result = mysqli_query($this->conn, $query);

        $records = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $records[] = $row;
            }
        }

        return $records; // Return an array of all records or an empty array if none found
    }

    public function total()
    {
        $query = "SELECT COUNT(*) as total FROM $this->tbl";
        $result = mysqli_query($this->conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result)['total'];
        } else {
            return 0; // Record not found
        }
    }

    // Delete a record from tbl_paket by ID
    public function delete(int $id)
    {
        // Check if the record exists before deleting
        $record = $this->show($id);

        if ($record) {
            $query = "DELETE FROM $this->tbl WHERE id = $id";
            if (mysqli_query($this->conn, $query)) {
                $this->setFlashMessage('success', "Record with ID $id deleted successfully.");
                return true; // Successfully deleted
            } else {
                $this->setFlashMessage('failed', "Failed to delete record with ID $id.");
                return false; // Deletion failed
            }
        } else {
            $this->setFlashMessage('failed', "Record with ID $id not found.");
            return false; // Record not found
        }
    }
}

class Pembayaran extends Action
{
    private $tbl = 'tbl_pembayaran';  // The table for payment records
    private $smtp, $pengguna;

    public function __construct()
    {
        $this->smtp = new SMTPMailer();
        $this->pengguna = new Pengguna();
        $this->conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
        if (!$this->conn) {
            die('Error: ' . mysqli_connect_error());
        }
    }

    public function delete(int $id)
    {
        // Check if the record exists before deleting
        $record = $this->show($id);

        if ($record) {
            $query = "DELETE FROM $this->tbl WHERE id = $id";
            if (mysqli_query($this->conn, $query)) {
                $this->setFlashMessage('success', "Record with ID $id deleted successfully.");
                return true; // Successfully deleted
            } else {
                $this->setFlashMessage('failed', "Failed to delete record with ID $id.");
                return false; // Deletion failed
            }
        } else {
            $this->setFlashMessage('failed', "Record with ID $id not found.");
            return false; // Record not found
        }
    }

    // Handle file upload and payment data saving
    public function save(array $data = [], $file = "")
    {
        // Check if the ID is provided for updating an existing payment record
        $isUpdating = isset($data['id']) && !empty($data['id']);

        // Validate and upload the payment proof (bukti_pembayaran) if new file is provided
        $fileNewName = '';
        if (isset($file['bukti_pembayaran']) && $file['bukti_pembayaran']['error'] == 0) {
            // Get file details
            $fileName = $file['bukti_pembayaran']['name'];
            $fileTmpName = $file['bukti_pembayaran']['tmp_name'];
            $fileSize = $file['bukti_pembayaran']['size'];
            $fileError = $file['bukti_pembayaran']['error'];
            $fileType = $file['bukti_pembayaran']['type'];

            // Generate random file name with the original file extension
            $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
            $fileNewName = uniqid('', true) . '.' . $fileExt;

            // Define the file upload directory (make sure it exists)
            $uploadDir = 'uploads/pembayaran/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Create the directory if it doesn't exist
            }

            $uploadPath = $uploadDir . $fileNewName;

            // Validate file type (e.g., PNG, JPG, JPEG, GIF, PDF)
            $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
            if (!in_array($fileExt, $allowedExts)) {
                // Invalid file type
                $this->setFlashMessage('failed', 'Format file tidak valid. Harap unggah file gambar atau PDF.');
                $this->redirect('kelola-pembayaran');
                return;
            }

            // Move the uploaded file to the server directory
            if (!move_uploaded_file($fileTmpName, $uploadPath)) {
                // Error moving the file
                $this->setFlashMessage('failed', 'Gagal mengupload bukti pembayaran.');
                $this->redirect('kelola-pembayaran');
                return;
            }
        }

        // Prepare data for insertion or updating
        $id_paket = (int)$data['id_paket'];
        $id_user = (int)$data['id_user'];
        $tanggal_waktu = date('Y-m-d H:i:s'); // Current date and time
        $id_metode_pembayaran = (int)$data['id_metode_pembayaran'];
        $status = mysqli_real_escape_string($this->conn, $data['status']);
        $invoice = mysqli_real_escape_string($this->conn, $data['invoice']);
        $kode_wifi = mysqli_real_escape_string($this->conn, $data['kode_wifi']);
        $alasan = mysqli_real_escape_string($this->conn, $data['alasan']);

        // If a new file is uploaded, include the new file name
        $bukti_pembayaran = $fileNewName ? "'$fileNewName'" : "bukti_pembayaran"; // If no new file, keep old value

        if ($isUpdating) {
            // Update existing payment record
            $id = (int)$data['id']; // Get the payment ID for updating

            // If the status is rejected (ditolak) or accepted (diterima), handle the logic
            if ($status == 'ditolak' || $status == 'diterima') {
                // Retrieve the user's email from the session or database

                $user = $this->pengguna->show($id_user);

                $to = $user['email'];
                $subject = "Status Pembayaran Sewa Wifi";

                // Define the message based on the status
                if ($status == 'ditolak') {
                    // If the payment was rejected, include the reason and invoice
                    $message = "Pembayaran Anda dengan Invoice #$invoice telah ditolak. Alasan: $alasan. Silakan periksa kembali atau hubungi kami untuk informasi lebih lanjut.";
                } elseif ($status == 'diterima') {
                    // If the payment was accepted, provide the wifi code (kode_wifi) and invoice
                    $message = "Pembayaran Anda dengan Invoice #$invoice telah diterima. Berikut adalah kode WiFi Anda: $kode_wifi. Terima kasih atas pembayaran Anda.";
                }

                $headers = "From: sender@" . REAL_DOMAIN;

                // Send email via your SMTP class
                $this->smtp->from($headers);
                $this->smtp->addTo($to);
                $this->smtp->Subject($subject);
                $this->smtp->Body($message);
                $this->smtp->Send();
            }

            // Update the payment record in the database
            $query = "UPDATE $this->tbl SET
                      id_paket = $id_paket,
                      id_user = $id_user,
                      tanggal_waktu = '$tanggal_waktu',
                      bukti_pembayaran = $bukti_pembayaran,
                      id_metode_pembayaran = $id_metode_pembayaran,
                      status = '$status',
                      invoice = '$invoice',
                      kode_wifi = '$kode_wifi',
                      alasan = '$alasan'
                      WHERE id = $id";

            // Execute the query and provide feedback
            if (mysqli_query($this->conn, $query)) {
                $this->setFlashMessage('success', 'Pembayaran berhasil diperbarui.');
                $this->redirect('kelola-pembayaran');
            } else {
                $this->setFlashMessage('failed', 'Gagal memperbarui pembayaran.');
                $this->redirect('kelola-pembayaran');
            }
        } else {
            // Insert new payment record
            $query = "INSERT INTO $this->tbl (id_paket, id_user, tanggal_waktu, bukti_pembayaran, id_metode_pembayaran, status, invoice, kode_wifi, alasan) 
                  VALUES ($id_paket, $id_user, '$tanggal_waktu', $bukti_pembayaran, $id_metode_pembayaran, '$status', '$invoice', '$kode_wifi', '$alasan')";

            if (mysqli_query($this->conn, $query)) {
                $this->setFlashMessage('success', 'Pembayaran berhasil disimpan.');



                $this->redirect('kelola-pembayaran');
            } else {
                $this->setFlashMessage('failed', 'Gagal menyimpan pembayaran.');
                $this->redirect('kelola-pembayaran');
            }
        }
    }


    // Get all payment records (optional, if you want to list them)
    public function all()
    {
        // Table names
        $tbl_user = "tbl_user";
        $tbl_metode_pembayaran = "tbl_metode_pembayaran";
        $tbl_paket = "tbl_paket";

        // SQL query to join tables and get more detailed information
        $query = "SELECT 
                p.id AS id_pembayaran,
                p.id_paket, 
                p.id_user, 
                p.tanggal_waktu, 
                p.bukti_pembayaran, 
                p.id_metode_pembayaran, 
                p.status,
                p.invoice, 
                p.kode_wifi,  
                u.nama AS user_name, 
                u.email AS user_email, 
                m.nama AS nama_metode,
                pp.judul AS nama_paket,
                pp.tipe AS tipe_paket,
                pp.kategori AS kategori_paket
                FROM $this->tbl p
                LEFT JOIN $tbl_user u ON p.id_user = u.id
                LEFT JOIN $tbl_paket pp ON p.id_paket = pp.id
                LEFT JOIN $tbl_metode_pembayaran m ON p.id_metode_pembayaran = m.id
                ORDER BY tanggal_waktu DESC";

        // Execute the query
        $result = mysqli_query($this->conn, $query);

        // Initialize an array to store the results
        $records = [];
        if ($result) {
            // Fetch all rows and store them in the records array
            while ($row = mysqli_fetch_assoc($result)) {
                $records[] = $row;
            }
        }

        // Return the records, or an empty array if no results were found
        return $records;
    }

    public function show(int $id)
    {
        // Table names
        $tbl_user = "tbl_user";
        $tbl_metode_pembayaran = "tbl_metode_pembayaran";
        $tbl_paket = "tbl_paket";

        // Sanitize the $id to avoid SQL injection
        $id = mysqli_real_escape_string($this->conn, $id);

        // SQL query to join tables and get more detailed information
        $query = "SELECT 
                    p.id AS id_pembayaran, 
                    p.id_paket, 
                    p.id_user, 
                    p.tanggal_waktu, 
                    p.bukti_pembayaran, 
                    p.id_metode_pembayaran, 
                    p.status,
                    p.invoice, 
                    p.kode_wifi,
                    p.alasan, 
                    u.nama AS user_name, 
                    u.email AS user_email, 
                    m.nama AS nama_metode,
                    pp.judul AS nama_paket,
                    pp.tipe AS tipe_paket,
                    pp.kategori AS kategori_paket
                  FROM $this->tbl p
                  LEFT JOIN $tbl_user u ON p.id_user = u.id
                  LEFT JOIN $tbl_paket pp ON p.id_paket = pp.id
                  LEFT JOIN $tbl_metode_pembayaran m ON p.id_metode_pembayaran = m.id
                  WHERE p.id = '$id'";  // Make sure to use `p.id` for the payment ID

        // Execute the query
        $result = mysqli_query($this->conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        } else {
            $this->setFlashMessage('failed', "Record with ID $id not found.");
            return null; // Record not found
        }
    }
}



$action = new Action();
$pengaturanClass = new Pengaturan();
$paketClass = new Paket();
$metodePembayaranClass = new MetodePembayaran();
$penggunaClass = new Pengguna();
$pembayaranClass = new Pembayaran();
