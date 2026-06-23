<!-- PAGE 4: TRACKING -->
<div id="page-tracking" class="page">
  <div class="header-hero" style="padding: 32px 24px 44px; position: relative; border-radius: 0 0 var(--radius-lg) var(--radius-lg); background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);">
    <h3 style="font-weight: 800; margin: 0; font-size: 24px; color: white;">Offline GPS Tracking</h3>
    <p style="font-size: 13px; opacity: 0.9; margin-top: 4px; color: #E2E8F0; font-weight: 500;">Monitor posisi pendakian Anda tanpa koneksi internet</p>
  </div>

  <div class="section-title" style="margin-top: 24px; margin-bottom: 12px;">Peta Satelit & Rute Pendakian</div>

  <!-- Map Wrapper containing Leaflet and Coords -->
  <div class="tracking-map-wrapper" style="height: 480px; position: relative; margin: 16px 24px 0;">
    <div id="tracking-map" style="height: 100%; width: 100%;"></div>

    <!-- Top floating glass panel matching reference image -->
    <div class="glass-panel" style="position: absolute; top: 16px; left: 16px; right: 16px; z-index: 10; border-radius: var(--radius-md); padding: 12px 16px; border: 1px solid rgba(255,255,255,0.4);">
      <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px; text-align: center;">
        <div style="border-right: 1px solid rgba(15, 76, 58, 0.1);">
          <strong style="font-size: 13px; color: var(--primary); font-weight: 800; display: block;">1.842 mdpl</strong>
          <span style="font-size: 8px; color: var(--text-muted); font-weight: 700; display: block; margin-top: 2px;">Elevasi</span>
          <span style="font-size: 8px; color: var(--text-muted); font-weight: 500; display: block;">3.805 mdpl</span>
        </div>
        <div style="border-right: 1px solid rgba(15, 76, 58, 0.1);">
          <strong style="font-size: 13px; color: var(--primary); font-weight: 800; display: block;">7.2 km</strong>
          <span style="font-size: 8px; color: var(--text-muted); font-weight: 700; display: block; margin-top: 2px;">Jarak Tempuh</span>
        </div>
        <div>
          <strong style="font-size: 13px; color: var(--primary); font-weight: 800; display: block;">03:45:12</strong>
          <span style="font-size: 8px; color: var(--text-muted); font-weight: 700; display: block; margin-top: 2px;">Waktu</span>
        </div>
      </div>
    </div>

    <!-- Bottom floating coordinate panel -->
    <div class="floating-coords-panel glass-panel" style="bottom: 16px; left: 16px; right: 16px; border: 1px solid rgba(255,255,255,0.4);">
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; text-align: center;">
        <div style="border-right: 1px solid rgba(15, 76, 58, 0.1);">
          <span style="font-size: 9px; color: var(--text-muted); display: block; font-weight: 700; letter-spacing: 0.5px; margin-bottom: 2px;">Latitude</span>
          <strong id="gps-lat" style="font-size: 12px; color: var(--text-dark); font-weight: 800;">-7.546231</strong>
        </div>
        <div>
          <span style="font-size: 9px; color: var(--text-muted); display: block; font-weight: 700; letter-spacing: 0.5px; margin-bottom: 2px;">Longitude</span>
          <strong id="gps-lng" style="font-size: 12px; color: var(--text-dark); font-weight: 800;">110.437231</strong>
        </div>
      </div>
    </div>
  </div>

  <!-- Stacked Buttons Area under Map -->
  <div style="padding: 0 24px; margin-top: 16px; display: flex; flex-direction: column; gap: 12px;">
    <button onclick="centerToMyLocation()" class="btn-primary" style="margin: 0; background: var(--primary); color: white; border-radius: var(--radius-md); font-weight: 700; padding: 14px; display: flex; align-items: center; justify-content: center; gap: 6px; box-shadow: var(--shadow-sm);">
      Center to My Location
    </button>

    <div style="position: relative; width: 100%;">
      <!-- Styled select to match dark translucent button style -->
      <select id="offline-map-select" onchange="updateOfflineRoutes()" style="width:100%; padding:14px; border:none; border-radius:var(--radius-md); outline:none; background: #1a2e26; font-size: 13px; font-weight: 700; color: white; text-align: center; text-align-last: center; cursor: pointer; appearance: none; -webkit-appearance: none; box-shadow: var(--shadow-sm);">
        <option value="">Cari Peta Offline Gunung</option>
        <option value="semeru">Gunung Semeru</option>
        <option value="merbabu">Gunung Merbabu</option>
        <option value="merapi">Gunung Merapi</option>
        <option value="prau">Gunung Prau</option>
        <option value="rinjani">Gunung Rinjani</option>
      </select>
      <select id="offline-route-select" onchange="loadOfflineMountainMap()" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:8px; outline:none; background: var(--bg-light); font-size: 13px; font-weight: 600; color: var(--text-dark); display: none; margin-top: 8px;">
        <option value="">-- Pilih Jalur Pendakian --</option>
      </select>
    </div>
  </div>

  <div class="section-title" style="margin-bottom: 12px;">Status Pendakian Aktif</div>
  
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
    <div class="card" style="border-left: 4px solid var(--primary); padding: 20px; margin: 0 24px 32px; box-shadow: var(--shadow-sm);">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <div>
          <h4 style="margin: 0; color: var(--primary); font-weight: 800; font-size: 16px;"><?= htmlspecialchars($latest_mt ? $latest_mt['name'] : 'Gunung') ?></h4>
          <p style="font-size: 12px; color: var(--text-muted); margin-top: 3px; font-weight: 500;">Sistem mencatat posisi awal masuk pendakian</p>
        </div>
        <span class="badge-density density-sepi" style="background-color: #FEEBC8; color: #C05621; font-weight: 800; padding: 4px 10px; border-radius: 50px;">AKTIF</span>
      </div>

      <!-- Tracking Progress Flow -->
      <div style="background: var(--bg-light); border-radius: var(--radius-sm); padding: 16px; border: 1px solid var(--border-color);">
        <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 14px;">
          <div style="width: 28px; height: 28px; border-radius: 50%; background: var(--primary); color: white; display: flex; justify-content: center; align-items: center; font-size: 10px; font-weight: 800; box-shadow: 0 2px 5px rgba(15,76,58,0.2);">GPS</div>
          <div>
            <p style="font-size: 10px; color: var(--text-muted); margin: 0; font-weight: 700; letter-spacing: 0.5px;">POSISI SAAT INI</p>
            <p id="tracking-flow-current" style="font-weight: 700; color: var(--text-dark); margin: 2px 0 0 0; font-size: 13px;">Basecamp (Awal Masuk)</p>
          </div>
        </div>
        <div style="display: flex; align-items: center; gap: 14px;">
          <div style="width: 28px; height: 28px; border-radius: 50%; background: var(--accent); color: white; display: flex; justify-content: center; align-items: center; font-size: 11px; font-weight: 800; box-shadow: 0 2px 5px rgba(236,168,35,0.2);">&gt;&gt;</div>
          <div>
            <p style="font-size: 10px; color: var(--text-muted); margin: 0; font-weight: 700; letter-spacing: 0.5px;">TARGET POS BERIKUTNYA</p>
            <p id="tracking-flow-next" style="font-weight: 700; color: var(--text-dark); margin: 2px 0 0 0; font-size: 13px;">Pos 1 / Pos Terdekat</p>
          </div>
        </div>
      </div>
    </div>
  <?php else: ?>
    <div class="card" style="text-align: center; padding: 40px 24px; color: #7A8B87; margin: 0 24px 32px;">
      <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="margin-bottom: 12px; opacity: 0.5; color: var(--primary);">
        <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
      </svg>
      <p style="font-weight: 700; color: var(--text-dark);">Tidak ada aktivitas pendakian saat ini</p>
      <p style="font-size: 13px; margin-top: 4px; color: var(--text-muted); font-weight: 500;">Sinyal GPS pelacakan offline akan memplot rute secara otomatis pada hari pendakian yang terdaftar.</p>
    </div>
  <?php endif; ?>
</div>
