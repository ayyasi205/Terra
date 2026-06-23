<?php
session_start();

// Path to database.json
$db_file = __DIR__ . '/../database.json';
if (!file_exists($db_file)) {
    $data = ["mountains" => [], "users" => [], "tickets" => []];
    file_put_contents($db_file, json_encode($data, JSON_PRETTY_PRINT));
} else {
    $data = json_decode(file_get_contents($db_file), true);
}

// Simple authentication check
if (!isset($_SESSION['user_email'])) {
    header("Location: ../index.php");
    exit;
}

$success_message = "";
$error_message = "";

// Handle Delete Action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id_to_delete = $_GET['id'];
    $found = false;
    foreach ($data['mountains'] as $key => $mt) {
        if ($mt['id'] === $id_to_delete) {
            unset($data['mountains'][$key]);
            $data['mountains'] = array_values($data['mountains']); // Reindex array
            $found = true;
            break;
        }
    }
    if ($found) {
        if (file_put_contents($db_file, json_encode($data, JSON_PRETTY_PRINT))) {
            $success_message = "Gunung berhasil dihapus!";
        } else {
            $error_message = "Gagal menghapus gunung.";
        }
    }
}

// Handle Add / Edit Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_action = $_POST['form_action'] ?? 'add';
    $mountain_id = trim($_POST['id']);
    
    // Auto-generate ID if empty (for adding)
    if (empty($mountain_id)) {
        $mountain_id = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', trim($_POST['name'])));
    }
    
    $name = trim($_POST['name']);
    $elevation = trim($_POST['elevation']);
    $location = trim($_POST['location']);
    $difficulty = $_POST['difficulty'] ?? 'Sedang';
    $estimated_duration = trim($_POST['estimated_duration']);
    $description = trim($_POST['description']);
    $image_url = trim($_POST['image_url']);
    $density = $_POST['density'] ?? 'Sedang';
    
    // Coords
    $lat = floatval($_POST['lat'] ?? 0);
    $lng = floatval($_POST['lng'] ?? 0);
    
    // Quota
    $quota_total = intval($_POST['quota_total'] ?? 100);
    $quota_active = intval($_POST['quota_active'] ?? 0);
    $quota_remaining = $quota_total - $quota_active;
    
    // Weather
    $weather_current = trim($_POST['weather_current']);
    $weather_temp = trim($_POST['weather_temp']);
    $weather_wind = trim($_POST['weather_wind']);
    $weather_humidity = trim($_POST['weather_humidity']);
    $weather_forecast = trim($_POST['weather_forecast']);
    
    // Warnings (split by newline or comma)
    $raw_warnings = trim($_POST['weather_warnings']);
    $warnings = [];
    if (!empty($raw_warnings)) {
        $warnings = array_filter(array_map('trim', preg_split('/[\r\n,]+/', $raw_warnings)));
    }
    
    // Routes JSON validation
    $routes_json = trim($_POST['routes_json']);
    $routes = [];
    if (!empty($routes_json)) {
        $decoded_routes = json_decode($routes_json, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded_routes)) {
            $routes = $decoded_routes;
        } else {
            $error_message = "Format JSON Rute & Map tidak valid. Silakan periksa kembali.";
        }
    }
    
    if (empty($error_message)) {
        if (empty($name)) {
            $error_message = "Nama gunung wajib diisi.";
        } else {
            $new_mountain = [
                "id" => $mountain_id,
                "name" => $name,
                "elevation" => $elevation,
                "location" => $location,
                "difficulty" => $difficulty,
                "estimated_duration" => $estimated_duration,
                "coords" => [$lat, $lng],
                "description" => $description,
                "image_url" => $image_url,
                "density" => $density,
                "weather" => [
                    "current" => $weather_current,
                    "temp" => $weather_temp,
                    "wind" => $weather_wind,
                    "humidity" => $weather_humidity,
                    "forecast" => $weather_forecast,
                    "warnings" => array_values($warnings)
                ],
                "quota" => [
                    "total" => $quota_total,
                    "active_climbers" => $quota_active,
                    "remaining" => $quota_remaining
                ],
                "routes" => $routes
            ];
            
            if ($form_action === 'edit') {
                // Update existing
                $updated = false;
                foreach ($data['mountains'] as $key => $mt) {
                    if ($mt['id'] === $_POST['original_id']) {
                        $data['mountains'][$key] = $new_mountain;
                        $updated = true;
                        break;
                    }
                }
                if ($updated) {
                    if (file_put_contents($db_file, json_encode($data, JSON_PRETTY_PRINT))) {
                        $success_message = "Data gunung berhasil diperbarui!";
                    } else {
                        $error_message = "Gagal menyimpan perubahan ke database.";
                    }
                } else {
                    $error_message = "Gunung yang akan diedit tidak ditemukan.";
                }
            } else {
                // Add new
                // Check if ID already exists
                $exists = false;
                foreach ($data['mountains'] as $mt) {
                    if ($mt['id'] === $mountain_id) {
                        $exists = true;
                        break;
                    }
                }
                
                if ($exists) {
                    $error_message = "ID Gunung atau Nama Gunung sudah terdaftar. Gunakan nama lain.";
                } else {
                    $data['mountains'][] = $new_mountain;
                    if (file_put_contents($db_file, json_encode($data, JSON_PRETTY_PRINT))) {
                        $success_message = "Gunung baru berhasil ditambahkan!";
                    } else {
                        $error_message = "Gagal menyimpan gunung baru.";
                    }
                }
            }
        }
    }
}

// Reload data after actions
$data = json_decode(file_get_contents($db_file), true);

// Get Selected Mountain for Edit
$editing_mountain = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    foreach ($data['mountains'] as $mt) {
        if ($mt['id'] === $_GET['id']) {
            $editing_mountain = $mt;
            break;
        }
    }
}

// Default JSON routes template for new mountain
$default_routes_json = json_encode([
    [
        "name" => "Via Jalur Utama",
        "duration" => "6-8 Jam",
        "map" => [
            "posts" => [
                [
                    "name" => "Basecamp",
                    "type" => "start",
                    "coords" => [10, 85]
                ],
                [
                    "name" => "Pos 1",
                    "type" => "post",
                    "coords" => [35, 70]
                ],
                [
                    "name" => "Pos 2 (Mata Air)",
                    "type" => "water",
                    "coords" => [60, 50]
                ],
                [
                    "name" => "Pos 3 (Camp Area)",
                    "type" => "camp",
                    "coords" => [80, 30]
                ],
                [
                    "name" => "Puncak",
                    "type" => "peak",
                    "coords" => [95, 10]
                ]
            ]
        ]
    ]
], JSON_PRETTY_PRINT);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TERRA Admin Panel - Kelola Gunung</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #0c1412;
            color: #e2e8f0;
            display: flex;
            min-height: 100vh;
            align-items: stretch;
            justify-content: flex-start;
            padding: 0;
            margin: 0;
            font-family: 'Outfit', sans-serif;
        }
        .admin-wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }
        .sidebar {
            width: 320px;
            background-color: #0f1a17;
            border-right: 1px solid rgba(255,255,255,0.08);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }
        .sidebar-header {
            padding: 24px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar-header h2 {
            margin: 0;
            font-size: 20px;
            font-weight: 800;
            color: #ECA823;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .sidebar-header p {
            margin: 4px 0 0;
            font-size: 12px;
            color: #7A8B87;
        }
        .mountain-list {
            flex: 1;
            overflow-y: auto;
            padding: 16px;
        }
        .mountain-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            border-radius: 12px;
            background: rgba(255,255,255,0.02);
            border: 1px solid rgba(255,255,255,0.04);
            margin-bottom: 12px;
            transition: all 0.2s ease;
            text-decoration: none;
            color: inherit;
        }
        .mountain-item:hover, .mountain-item.active {
            background: rgba(234, 168, 35, 0.08);
            border-color: rgba(234, 168, 35, 0.3);
        }
        .mountain-item img {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
            background: #2a3a35;
        }
        .mountain-item-info {
            flex: 1;
            min-width: 0;
        }
        .mountain-item-info h4 {
            margin: 0;
            font-size: 14px;
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .mountain-item-info p {
            margin: 2px 0 0;
            font-size: 11px;
            color: #7A8B87;
        }
        .main-content {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
            background-color: #0c1412;
        }
        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .content-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 800;
            color: #ffffff;
        }
        .admin-card {
            background: #12201c;
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.25);
            max-width: 900px;
        }
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .form-group-full {
            grid-column: span 2;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 18px;
        }
        .form-group label {
            font-size: 12px;
            font-weight: 700;
            color: #7A8B87;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        .form-group input, .form-group select, .form-group textarea {
            background: rgba(0,0,0,0.25);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 8px;
            padding: 12px 16px;
            color: #ffffff;
            font-size: 14px;
            outline: none;
            transition: all 0.2s ease;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            border-color: #ECA823;
            box-shadow: 0 0 0 3px rgba(234, 168, 35, 0.15);
        }
        .form-section-title {
            grid-column: span 2;
            font-size: 16px;
            font-weight: 800;
            color: #ECA823;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            padding-bottom: 8px;
            margin-top: 15px;
            margin-bottom: 10px;
        }
        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #ECA823;
            color: #0c1412;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .btn-action:hover {
            background: #ffb82b;
            transform: translateY(-1px);
        }
        .btn-danger {
            background: #e53e3e;
            color: white;
        }
        .btn-danger:hover {
            background: #f54e4e;
        }
        .btn-secondary {
            background: rgba(255,255,255,0.08);
            color: #ffffff;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .btn-secondary:hover {
            background: rgba(255,255,255,0.15);
        }
        .toast-admin {
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            max-width: 900px;
        }
        .toast-success {
            background: rgba(56, 161, 105, 0.15);
            border: 1px solid #38a169;
            color: #38a169;
        }
        .toast-error {
            background: rgba(229, 62, 62, 0.15);
            border: 1px solid #e53e3e;
            color: #e53e3e;
        }
        .btn-add-sidebar {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px;
            background: rgba(234, 168, 35, 0.1);
            border: 1px dashed #ECA823;
            color: #ECA823;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
            margin-bottom: 20px;
            transition: all 0.2s ease;
        }
        .btn-add-sidebar:hover {
            background: rgba(234, 168, 35, 0.2);
        }
        .back-link {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #7A8B87;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 12px;
            transition: color 0.2s ease;
        }
        .back-link:hover {
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h2>🏔️ TERRA Admin</h2>
                <p>Pengelolaan Data Gunung & Rute</p>
            </div>
            <div class="mountain-list">
                <a href="admin.php" class="btn-add-sidebar">
                    <span>➕</span> Tambah Gunung Baru
                </a>
                
                <?php foreach ($data['mountains'] as $mt): ?>
                    <a href="admin.php?action=edit&id=<?= urlencode($mt['id']) ?>" 
                       class="mountain-item <?= (isset($_GET['id']) && $_GET['id'] === $mt['id']) ? 'active' : '' ?>">
                        <img src="<?= htmlspecialchars(strpos($mt['image_url'], 'http') === 0 ? $mt['image_url'] : '../' . $mt['image_url']) ?>" alt="<?= htmlspecialchars($mt['name']) ?>">
                        <div class="mountain-item-info">
                            <h4><?= htmlspecialchars($mt['name']) ?></h4>
                            <p><?= htmlspecialchars($mt['location']) ?> • <?= htmlspecialchars($mt['elevation']) ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <a href="../index.php" class="back-link">
                ◀ Kembali ke Aplikasi Utama
            </a>
            
            <div class="content-header">
                <h1><?= $editing_mountain ? 'Edit Gunung: ' . htmlspecialchars($editing_mountain['name']) : 'Tambah Gunung Baru' ?></h1>
                <?php if ($editing_mountain): ?>
                    <a href="admin.php?action=delete&id=<?= urlencode($editing_mountain['id']) ?>" 
                       class="btn-action btn-danger" 
                       onclick="return confirm('Apakah Anda yakin ingin menghapus gunung ini?')">
                       🗑️ Hapus Gunung
                    </a>
                <?php endif; ?>
            </div>

            <?php if (!empty($success_message)): ?>
                <div class="toast-admin toast-success">
                    <span>✅</span> <?= htmlspecialchars($success_message) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error_message)): ?>
                <div class="toast-admin toast-error">
                    <span>❌</span> <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>

            <div class="admin-card">
                <form action="admin.php" method="POST">
                    <input type="hidden" name="form_action" value="<?= $editing_mountain ? 'edit' : 'add' ?>">
                    <?php if ($editing_mountain): ?>
                        <input type="hidden" name="original_id" value="<?= htmlspecialchars($editing_mountain['id']) ?>">
                    <?php endif; ?>

                    <div class="form-grid">
                        <div class="form-section-title">Informasi Utama</div>
                        
                        <div class="form-group">
                            <label>ID Gunung (Slug / URL Safe)</label>
                            <input type="text" name="id" placeholder="Contoh: semeru (kosongkan untuk auto-generate)" 
                                   value="<?= htmlspecialchars($editing_mountain['id'] ?? '') ?>" <?= $editing_mountain ? 'readonly style="background: rgba(255,255,255,0.05); color: #7A8B87;"' : '' ?>>
                        </div>

                        <div class="form-group">
                            <label>Nama Gunung *</label>
                            <input type="text" name="name" required placeholder="Contoh: Gunung Semeru" 
                                   value="<?= htmlspecialchars($editing_mountain['name'] ?? '') ?>">
                        </div>

                        <div class="form-group">
                            <label>Ketinggian (Elevation)</label>
                            <input type="text" name="elevation" placeholder="Contoh: 3.676 mdpl" 
                                   value="<?= htmlspecialchars($editing_mountain['elevation'] ?? '') ?>">
                        </div>

                        <div class="form-group">
                            <label>Lokasi (Provinsi)</label>
                            <input type="text" name="location" placeholder="Contoh: Jawa Timur" 
                                   value="<?= htmlspecialchars($editing_mountain['location'] ?? '') ?>">
                        </div>

                        <div class="form-group">
                            <label>Tingkat Kesulitan</label>
                            <select name="difficulty">
                                <option value="Mudah" <?= (isset($editing_mountain['difficulty']) && $editing_mountain['difficulty'] === 'Mudah') ? 'selected' : '' ?>>Mudah (Hijau)</option>
                                <option value="Sedang" <?= (!isset($editing_mountain['difficulty']) || $editing_mountain['difficulty'] === 'Sedang') ? 'selected' : '' ?>>Sedang (Oranye)</option>
                                <option value="Sulit" <?= (isset($editing_mountain['difficulty']) && $editing_mountain['difficulty'] === 'Sulit') ? 'selected' : '' ?>>Sulit (Merah)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Estimasi Durasi Pendakian</label>
                            <input type="text" name="estimated_duration" placeholder="Contoh: 3 Hari 2 Malam" 
                                   value="<?= htmlspecialchars($editing_mountain['estimated_duration'] ?? '') ?>">
                        </div>

                        <div class="form-group">
                            <label>Koordinat Latitude</label>
                            <input type="number" step="any" name="lat" placeholder="Contoh: -8.1075" 
                                   value="<?= htmlspecialchars($editing_mountain['coords'][0] ?? '') ?>">
                        </div>

                        <div class="form-group">
                            <label>Koordinat Longitude</label>
                            <input type="number" step="any" name="lng" placeholder="Contoh: 112.9224" 
                                   value="<?= htmlspecialchars($editing_mountain['coords'][1] ?? '') ?>">
                        </div>

                        <div class="form-group-full form-group">
                            <label>URL Gambar Gunung</label>
                            <input type="text" name="image_url" placeholder="Contoh: assets/images/merbabu.jpg atau URL https://..." 
                                   value="<?= htmlspecialchars($editing_mountain['image_url'] ?? '') ?>">
                        </div>

                        <div class="form-group-full form-group">
                            <label>Deskripsi Gunung</label>
                            <textarea name="description" rows="3" placeholder="Tuliskan deskripsi singkat mengenai gunung ini..."><?= htmlspecialchars($editing_mountain['description'] ?? '') ?></textarea>
                        </div>

                        <div class="form-section-title">Kuota Pendakian</div>

                        <div class="form-group">
                            <label>Total Kuota Harian</label>
                            <input type="number" name="quota_total" placeholder="Contoh: 300" 
                                   value="<?= htmlspecialchars($editing_mountain['quota']['total'] ?? 100) ?>">
                        </div>

                        <div class="form-group">
                            <label>Pendaki Aktif Saat Ini</label>
                            <input type="number" name="quota_active" placeholder="Contoh: 0" 
                                   value="<?= htmlspecialchars($editing_mountain['quota']['active_climbers'] ?? 0) ?>">
                        </div>

                        <div class="form-section-title">Informasi Cuaca & Peringatan</div>

                        <div class="form-group">
                            <label>Kepadatan Pendakian (Density)</label>
                            <select name="density">
                                <option value="Sepi" <?= (isset($editing_mountain['density']) && $editing_mountain['density'] === 'Sepi') ? 'selected' : '' ?>>Sepi (Hijau)</option>
                                <option value="Sedang" <?= (!isset($editing_mountain['density']) || $editing_mountain['density'] === 'Sedang') ? 'selected' : '' ?>>Sedang (Kuning)</option>
                                <option value="Ramai" <?= (isset($editing_mountain['density']) && $editing_mountain['density'] === 'Ramai') ? 'selected' : '' ?>>Ramai (Merah)</option>
                                <option value="Sangat Ramai" <?= (isset($editing_mountain['density']) && $editing_mountain['density'] === 'Sangat Ramai') ? 'selected' : '' ?>>Sangat Ramai (Ungu)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Cuaca Saat Ini</label>
                            <input type="text" name="weather_current" placeholder="Contoh: Cerah, Hujan Badai" 
                                   value="<?= htmlspecialchars($editing_mountain['weather']['current'] ?? 'Cerah') ?>">
                        </div>

                        <div class="form-group">
                            <label>Suhu Udara</label>
                            <input type="text" name="weather_temp" placeholder="Contoh: 14°C" 
                                   value="<?= htmlspecialchars($editing_mountain['weather']['temp'] ?? '15°C') ?>">
                        </div>

                        <div class="form-group">
                            <label>Kecepatan Angin</label>
                            <input type="text" name="weather_wind" placeholder="Contoh: 15 km/jam" 
                                   value="<?= htmlspecialchars($editing_mountain['weather']['wind'] ?? '10 km/jam') ?>">
                        </div>

                        <div class="form-group">
                            <label>Kelembaban Udara</label>
                            <input type="text" name="weather_humidity" placeholder="Contoh: 65%" 
                                   value="<?= htmlspecialchars($editing_mountain['weather']['humidity'] ?? '60%') ?>">
                        </div>

                        <div class="form-group">
                            <label>Prakiraan Cuaca Detil</label>
                            <input type="text" name="weather_forecast" placeholder="Contoh: Cerah berawan di pagi hari, hujan ringan menjelang sore." 
                                   value="<?= htmlspecialchars($editing_mountain['weather']['forecast'] ?? 'Cerah sepanjang hari.') ?>">
                        </div>

                        <div class="form-group-full form-group">
                            <label>Peringatan Cuaca (Pisahkan dengan baris baru atau koma)</label>
                            <textarea name="weather_warnings" rows="2" placeholder="Contoh:&#10;Peringatan Hujan Lebat di lereng&#10;Peringatan Angin Kencang di puncak"><?= htmlspecialchars(isset($editing_mountain['weather']['warnings']) ? implode("\n", $editing_mountain['weather']['warnings']) : '') ?></textarea>
                        </div>

                        <div class="form-section-title">Rute Pendakian & Peta Satelit (Format JSON)</div>

                        <div class="form-group-full form-group">
                            <label>JSON Data Rute</label>
                            <textarea name="routes_json" rows="12" style="font-family: monospace; background: #080c0a;" placeholder="JSON rute..."><?= htmlspecialchars(isset($editing_mountain['routes']) ? json_encode($editing_mountain['routes'], JSON_PRETTY_PRINT) : $default_routes_json) ?></textarea>
                            <span style="font-size: 12px; color: #7A8B87; margin-top: 6px;">Format peta menggunakan koordinat persentase (0-100) untuk render peta jalur satelit bawaan. Tipe post: <code>start</code> (basecamp), <code>post</code> (pos biasa), <code>water</code> (sumber air), <code>camp</code> (area camp), <code>peak</code> (puncak).</span>
                        </div>
                    </div>

                    <div style="margin-top: 30px; display: flex; gap: 12px;">
                        <button type="submit" class="btn-action">
                            💾 Simpan Perubahan
                        </button>
                        <a href="admin.php" class="btn-action btn-secondary">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
