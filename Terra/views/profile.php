<!-- PAGE 5: PROFILE -->
<div id="page-profile" class="page">
  <div class="header-hero" style="padding: 44px 24px 32px; display: flex; flex-direction: column; align-items: center; text-align: center; border-radius: 0 0 var(--radius-lg) var(--radius-lg); background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);">
    
    <!-- Large Profile Picture Avatar -->
    <div style="width: 80px; height: 80px; border-radius: 50%; background: var(--accent); display: flex; justify-content: center; align-items: center; font-size: 32px; font-weight: 800; color: var(--primary); border: 4px solid rgba(255,255,255,0.2); box-shadow: var(--shadow-md); margin-bottom: 12px;">
      <?= strtoupper(substr($_SESSION['user_name'], 0, 1)) ?>
    </div>
    
    <div>
      <h3 style="font-weight: 800; margin: 0; font-size: 20px; color: #FFFFFF;"><?= htmlspecialchars($_SESSION['user_name']) ?></h3>
      <p style="font-size: 13px; opacity: 0.9; margin-top: 4px; color: #E2E8F0; font-weight: 500;"><?= htmlspecialchars($_SESSION['user_email']) ?></p>
    </div>

    <!-- Stats row dashboard -->
    <div style="display: flex; width: 100%; max-width: 320px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); border-radius: var(--radius-md); padding: 12px; margin-top: 20px; backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); justify-content: space-around;">
      <div style="text-align: center;">
        <span style="display: block; font-size: 10px; color: #E2E8F0; font-weight: 700; letter-spacing: 0.5px;">TOTAL TRIP</span>
        <strong style="font-size: 16px; color: #FFFFFF; font-weight: 800;"><?= count($user_tickets) ?></strong>
      </div>
      <div style="border-left: 1px solid rgba(255,255,255,0.15);"></div>
      <div style="text-align: center;">
        <span style="display: block; font-size: 10px; color: #E2E8F0; font-weight: 700; letter-spacing: 0.5px;">SELESAI</span>
        <strong style="font-size: 16px; color: var(--accent); font-weight: 800;">
          <?php 
            $past_count = 0;
            $today_ts = time();
            foreach ($user_tickets as $t) {
                $endDateStr = $t['climb_date_end'] ?? $t['climb_date_start'] ?? '';
                if (!empty($endDateStr) && strtotime($endDateStr) < $today_ts) {
                    $past_count++;
                }
            }
            echo $past_count;
          ?>
        </strong>
      </div>
      <div style="border-left: 1px solid rgba(255,255,255,0.15);"></div>
      <div style="text-align: center;">
        <span style="display: block; font-size: 10px; color: #E2E8F0; font-weight: 700; letter-spacing: 0.5px;">LEVEL</span>
        <strong style="font-size: 16px; color: #FFFFFF; font-weight: 800;">1</strong>
      </div>
    </div>
  </div>

  <div class="section-title" style="margin-top: 24px; margin-bottom: 12px;">Pencapaian Petualang</div>
  <div class="card" style="display: flex; align-items: center; justify-content: space-between; padding: 18px; margin: 0 24px 16px; box-shadow: var(--shadow-sm); border: 1px solid var(--border-color); background: var(--card-bg);">
    <div>
      <span class="badge-density density-sepi" style="font-size: 9px; padding: 3px 8px; border-radius: 50px; font-weight: 800; margin-bottom: 6px;">PEMULA</span>
      <h4 style="margin: 0; color: var(--primary); font-weight: 800; font-size: 15px;">Pendaki Pemula</h4>
      <p style="font-size: 12px; color: var(--text-muted); margin-top: 4px; font-weight: 500; line-height: 1.4;">Selesaikan 1 pendakian pertama untuk naik level berikutnya.</p>
    </div>
    <span style="font-size: 36px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">⛰️</span>
  </div>

  <div class="section-title" style="margin-bottom: 12px;">Pengaturan Akun</div>
  <div class="card" style="padding: 0; overflow: hidden; margin: 0 24px 32px; box-shadow: var(--shadow-sm); border: 1px solid rgba(15, 76, 58, 0.05); background: var(--card-bg);">
    <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-bottom: 1px solid var(--border-color); transition: var(--transition);">
      <span style="font-size: 14px; font-weight: 700; color: var(--text-dark);">Mode Gelap (Dark Mode)</span>
      <label class="switch-toggle">
        <input type="checkbox" id="dark-theme-toggle" onchange="toggleDarkTheme(this.checked)">
        <span class="switch-slider"></span>
      </label>
    </div>
    <div onclick="showToast('Fitur edit profil akan segera hadir.', 'info')" style="display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-bottom: 1px solid var(--border-color); cursor: pointer; transition: var(--transition);">
      <span style="font-size: 14px; font-weight: 700; color: var(--text-dark);">Edit Detail KTP & Profil</span>
      <span style="color: var(--text-muted); font-weight: bold;">&gt;</span>
    </div>
    <div onclick="switchTab('ticket')" style="display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-bottom: 1px solid var(--border-color); cursor: pointer; transition: var(--transition);">
      <span style="font-size: 14px; font-weight: 700; color: var(--text-dark);">Riwayat Pendakian</span>
      <span style="color: var(--text-muted); font-weight: bold;">&gt;</span>
    </div>
    <a href="Admin/admin.php" style="display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-bottom: 1px solid var(--border-color); text-decoration: none; color: var(--text-dark); cursor: pointer; transition: var(--transition);">
      <span style="font-size: 14px; font-weight: 700; color: var(--primary);">⚙️ Admin Panel</span>
      <span style="color: var(--primary); font-weight: bold;">&gt;</span>
    </a>
    <div onclick="logoutUser()" style="display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; color: #E53E3E; cursor: pointer; transition: var(--transition);">
      <span style="font-size: 14px; font-weight: 800;">Keluar dari Akun</span>
      <span style="color: #E53E3E; font-weight: bold;">&gt;</span>
    </div>
  </div>
</div>
<?php
// Inject server side helper to avoid breaking php Date syntax errors since PHP has no class "Date" (PHP uses DateTime or time())
// Let's write a small conditional logic inside PHP so it parses correctly.
// Oh wait! In php, "new Date()" throws a Fatal Error! Good catch.
// Let's rewrite the PHP past_count calculator cleanly:
/*
  $past_count = 0;
  $today_ts = strtotime(date('Y-m-d'));
  foreach ($user_tickets as $t) {
      $end_ts = strtotime($t['climb_date_end'] ?? $t['climb_date_start'] ?? '');
      if ($end_ts < $today_ts) $past_count++;
  }
  echo $past_count;
*/
?>
