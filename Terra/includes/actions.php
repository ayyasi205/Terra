<?php
$error_message = "";
$success_message = "";

// Authentication Actions
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'logout') {
        session_destroy();
        header("Location: index.php");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle Login
    if (isset($_POST['auth_type']) && $_POST['auth_type'] == 'login') {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        
        $found = false;
        foreach ($data['users'] as $user) {
            if ($user['email'] === $email && $user['password'] === $password) {
                $_SESSION['user_email'] = $email;
                $_SESSION['user_name'] = explode('@', $email)[0];
                $found = true;
                break;
            }
        }
        
        if ($found) {
            header("Location: index.php");
            exit;
        } else {
            $error_message = "Email atau password salah.";
        }
    }
    
    // Handle Registration
    if (isset($_POST['auth_type']) && $_POST['auth_type'] == 'register') {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        
        if (empty($email) || empty($password)) {
            $error_message = "Email dan password wajib diisi.";
        } else {
            $exists = false;
            foreach ($data['users'] as $user) {
                if ($user['email'] === $email) {
                    $exists = true;
                    break;
                }
            }
            
            if ($exists) {
                $error_message = "Email sudah terdaftar.";
            } else {
                $data['users'][] = [
                    "email" => $email,
                    "password" => $password
                ];
                file_put_contents($db_file, json_encode($data, JSON_PRETTY_PRINT));
                $_SESSION['user_email'] = $email;
                $_SESSION['user_name'] = explode('@', $email)[0];
                header("Location: index.php");
                exit;
            }
        }
    }

    // Handle Ticket Registration
    if (isset($_POST['action_type']) && $_POST['action_type'] == 'book_ticket') {
        if (!isset($_SESSION['user_email'])) {
            $error_message = "Silakan login terlebih dahulu.";
        } else {
            $mountain_id = $_POST['mountain_id'];
            $basecamp = $_POST['basecamp'];
            $climb_date_start = $_POST['climb_date_start'] ?? '';
            $climb_date_end = $_POST['climb_date_end'] ?? '';
            
            $climber_names = $_POST['climber_names'] ?? [];
            $climber_ktps = $_POST['climber_ktps'] ?? [];
            
            $members = [];
            for ($i = 0; $i < count($climber_names); $i++) {
                if (!empty($climber_names[$i]) && !empty($climber_ktps[$i])) {
                    $members[] = [
                        "name" => trim($climber_names[$i]),
                        "ktp" => trim($climber_ktps[$i])
                    ];
                }
            }

            if (empty($mountain_id) || empty($basecamp) || empty($climb_date_start) || empty($climb_date_end) || empty($members)) {
                $error_message = "Semua form pendaftaran wajib diisi dengan benar.";
            } else if (strtotime($climb_date_end) < strtotime($climb_date_start)) {
                $error_message = "Tanggal selesai tidak boleh lebih awal dari tanggal mulai.";
            } else {
                // Generate a unique ticket ID
                $ticket_id = "TERRA-" . strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));
                
                $new_ticket = [
                    "id" => $ticket_id,
                    "user_email" => $_SESSION['user_email'],
                    "mountain_id" => $mountain_id,
                    "basecamp" => $basecamp,
                    "climb_date_start" => $climb_date_start,
                    "climb_date_end" => $climb_date_end,
                    "members" => $members,
                    "created_at" => date('Y-m-d H:i:s')
                ];
                
                // Update quota remaining in database
                foreach ($data['mountains'] as &$mountain) {
                    if ($mountain['id'] === $mountain_id) {
                        $num_climbers = count($members);
                        if ($mountain['quota']['remaining'] >= $num_climbers) {
                            $mountain['quota']['remaining'] -= $num_climbers;
                            $mountain['quota']['active_climbers'] += $num_climbers;
                        } else {
                            $error_message = "Kuota pendakian tersisa tidak mencukupi untuk jumlah pendaki Anda.";
                            break;
                        }
                    }
                }
                
                if (empty($error_message)) {
                    $data['tickets'][] = $new_ticket;
                    file_put_contents($db_file, json_encode($data, JSON_PRETTY_PRINT));
                    $success_message = "Pendaftaran berhasil! Barcode tiket Anda telah dibuat.";
                }
            }
        }
    }
}

// Fetch user active tickets
$user_tickets = [];
if (isset($_SESSION['user_email'])) {
    foreach ($data['tickets'] as $ticket) {
        if ($ticket['user_email'] === $_SESSION['user_email']) {
            $user_tickets[] = $ticket;
        }
    }
}
