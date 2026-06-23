<!-- PAGE 1: HOME -->
<div id="page-home" class="page active">
  <div class="header-hero" style="position: relative; overflow: hidden; height: 260px; padding: 48px 24px 24px;">
    <!-- Background Mountain Carousel -->
    <div class="carousel-container">
      <div class="carousel-slide active" style="background-image: url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=800&q=80');"></div>
      <div class="carousel-slide" style="background-image: url('https://images.unsplash.com/photo-1454496522488-7a8e488e8606?auto=format&fit=crop&w=800&q=80');"></div>
      <div class="carousel-slide" style="background-image: url('https://images.unsplash.com/photo-1434064511983-18c6dae20ed5?auto=format&fit=crop&w=800&q=80');"></div>
      <div class="carousel-overlay" style="background: linear-gradient(to bottom, rgba(15, 76, 58, 0.8) 0%, rgba(244, 247, 246, 0.3) 60%, var(--bg-light) 100%);"></div>
    </div>
    
    <div class="header-hero-content" style="display: flex; flex-direction: column; justify-content: flex-start; text-align: left; padding-top: 12px;">
      <div style="font-size: 13px; opacity: 0.9; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; color: var(--accent); margin-bottom: 4px;">Selamat Datang,</div>
      <h2 style="font-weight: 800; font-size: 28px; margin: 0; line-height: 1.2; color: #FFFFFF; text-shadow: 0 2px 8px rgba(0,0,0,0.3);"><?= htmlspecialchars($_SESSION['user_name']) ?> 👋</h2>
      <p style="font-size: 14px; opacity: 0.95; margin-top: 6px; font-weight: 500; color: #E2E8F0;">Siap untuk petualangan berikutnya?</p>
    </div>
  </div>

  <!-- Quick Menu Section (6 items styled with green SVG outline icons) -->
  <div class="quick-menu-grid" style="grid-template-columns: repeat(3, 1fr); gap: 12px; margin: 16px 24px 24px;">
    <div class="quick-menu-item" onclick="switchTab('explore')" style="padding: 16px 8px; border-radius: var(--radius-md);">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 8px;">
        <path d="M12 20h9M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
      </svg>
      <span class="quick-menu-title" style="font-size: 11px;">Registrasi</span>
    </div>
    <div class="quick-menu-item" onclick="switchTab('ticket')" style="padding: 16px 8px; border-radius: var(--radius-md);">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 8px;">
        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
        <rect x="7" y="7" width="3" height="3"/>
        <rect x="14" y="7" width="3" height="3"/>
        <rect x="7" y="14" width="3" height="3"/>
        <rect x="14" y="14" width="3" height="3"/>
      </svg>
      <span class="quick-menu-title" style="font-size: 11px;">QR Check-In</span>
    </div>
    <div class="quick-menu-item" onclick="switchTab('tracking')" style="padding: 16px 8px; border-radius: var(--radius-md);">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 8px;">
        <polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/>
        <line x1="9" y1="3" x2="9" y2="18"/>
        <line x1="15" y1="6" x2="15" y2="21"/>
      </svg>
      <span class="quick-menu-title" style="font-size: 11px;">Tracking</span>
    </div>
    <div class="quick-menu-item" onclick="switchTab('ticket'); switchTicketTab('past');" style="padding: 16px 8px; border-radius: var(--radius-md);">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 8px;">
        <circle cx="12" cy="12" r="10"/>
        <polyline points="12 6 12 12 16 14"/>
      </svg>
      <span class="quick-menu-title" style="font-size: 11px;">Riwayat</span>
    </div>
    <div class="quick-menu-item" onclick="scrollToElement('outdoor-safety-section')" style="padding: 16px 8px; border-radius: var(--radius-md);">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 8px;">
        <circle cx="12" cy="12" r="10"/>
        <line x1="12" y1="16" x2="12" y2="12"/>
        <line x1="12" y1="8" x2="12.01" y2="8"/>
      </svg>
      <span class="quick-menu-title" style="font-size: 11px;">Informasi</span>
    </div>
    <div class="quick-menu-item" onclick="switchTab('profile')" style="padding: 16px 8px; border-radius: var(--radius-md);">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 8px;">
        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
        <circle cx="12" cy="7" r="4"/>
      </svg>
      <span class="quick-menu-title" style="font-size: 11px;">Profil</span>
    </div>
  </div>

  <!-- Quick Active Ticket Display -->
  <?php if (count($user_tickets) > 0): ?>
    <?php 
      $latest_ticket = end($user_tickets);
      $latest_mt = null;
      foreach ($data['mountains'] as $m) {
          if ($m['id'] === $latest_ticket['mountain_id']) {
              $latest_mt = $m;
              break;
          }
      }
    ?>
    <?php if ($latest_mt): ?>
      <div class="section-title">Tiket Aktif Mendatang</div>
      <div class="card" onclick="switchTab('ticket')" style="cursor: pointer; border-left: 4px solid var(--accent); padding: 18px; margin-bottom: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; width: 100%;">
          <div>
            <h4 style="color: var(--primary); margin: 0; font-size: 16px; font-weight: 800;"><?= htmlspecialchars($latest_mt['name']) ?></h4>
            <p style="font-size: 12px; color: var(--text-muted); margin-top: 3px; font-weight: 500;"><?= htmlspecialchars($latest_ticket['basecamp']) ?></p>
            <span class="quota-pill" style="margin-top: 8px; font-size: 10px; background-color: rgba(236,168,35,0.12); color: #B06000;">📅 <?= htmlspecialchars($latest_ticket['climb_date_start'] ?? $latest_ticket['climb_date'] ?? '') ?></span>
          </div>
          <div style="text-align: right;">
            <span class="badge-density density-sepi" style="font-size: 9px; padding: 4px 8px; letter-spacing: 0.5px;">TERDAFTAR</span>
            <p style="font-size: 11px; color: var(--text-muted); margin-top: 10px; font-weight: 600;"><?= count($latest_ticket['members']) ?> Pendaki</p>
          </div>
        </div>
      </div>
    <?php endif; ?>
  <?php endif; ?>

  <!-- Recommendations Section -->
  <div class="section-title" style="margin-bottom: 8px;">Rekomendasi Gunung</div>
  <div id="home-recommendations-container" style="display: flex; gap: 16px; overflow-x: auto; padding: 4px 24px 20px; scrollbar-width: none; -ms-overflow-style: none;">
    <!-- Populated by JS -->
  </div>

  <!-- Nearest Mountains Section -->
  <div class="section-title" style="margin-bottom: 8px;">Gunung Terdekat</div>
  <div id="nearest-mountains-section">
    <div id="location-permission-card" class="card" style="text-align: center; padding: 24px; margin-top: 0;">
      <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 14px;">Aktifkan GPS untuk menemukan gunung terdekat dari posisi Anda saat ini.</p>
      <button onclick="requestUserLocation()" class="btn-primary" style="margin: 0 auto; background: var(--primary); color: white; padding: 10px 20px; font-size: 13px; width: auto; display: inline-flex; align-items: center; gap: 6px; border-radius: var(--radius-sm);">
        <span>🛰️</span> Aktifkan Lokasi
      </button>
    </div>
    <div id="nearest-mountains-list" style="display: none; padding-bottom: 8px;">
      <!-- Populated by JS -->
    </div>
  </div>

  <!-- Climbing History Section -->
  <div class="section-title" style="margin-bottom: 8px;">Riwayat Pendakian Saya</div>
  <div id="climbing-history-container" style="padding-bottom: 8px;">
    <!-- Populated by JS -->
  </div>

  <!-- Outdoor Safety Tips -->
  <div id="outdoor-safety-section" class="section-title">Tips Pendakian Aman</div>
  <div class="card safety-tip-card">
    <span style="font-size: 32px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">⛺</span>
    <div>
      <h5 style="margin: 0; font-size: 14px; font-weight: 700;">Peralatan Lengkap & Matang</h5>
      <p style="font-size: 12px; margin-top: 4px; line-height: 1.5;">Pastikan tenda, jaket anti-angin, dan kompor teruji dengan baik sebelum mendaki gunung.</p>
    </div>
  </div>
</div>

<script>
  function scrollToElement(elementId) {
    const el = document.getElementById(elementId);
    if (el) {
      el.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  }
</script>
