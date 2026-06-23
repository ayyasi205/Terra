<!-- PAGE 2: EXPLORE -->
<div id="page-explore" class="page">
  
  <!-- Explore View 1: List Mountains -->
  <div id="explore-main-view">
    <div class="header-hero" style="padding: 32px 24px 44px; position: relative; margin-bottom: 24px; background: var(--header-bg);">
      <h3 style="font-weight: 800; margin: 0; font-size: 24px; color: white;">Jelajah & Registrasi</h3>
      <p style="font-size: 13px; opacity: 0.9; margin-top: 4px; color: #E2E8F0; font-weight: 500;">Temukan jalur ekspedisi gunung impianmu</p>
    </div>

    <!-- Real-Time Search Bar -->
    <div style="padding: 0 24px; margin-top: -38px; margin-bottom: 24px; position: relative; z-index: 10;">
      <div style="position: relative; display: flex; align-items: center; background: var(--card-bg); border-radius: var(--radius-md); box-shadow: var(--shadow-md); border: 1px solid var(--border-color); padding: 4px 18px;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2.5" style="margin-right: 12px; flex-shrink: 0;">
          <circle cx="11" cy="11" r="8"></circle>
          <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
        <input type="text" id="explore-search-input" placeholder="Cari gunung berdasarkan nama..." onkeyup="filterMountains()" style="width: 100%; border: none; outline: none; padding: 12px 0; font-size: 14px; background: transparent; color: var(--text-dark); font-weight: 600;">
      </div>
    </div>

    <div class="section-title" style="margin-bottom: 12px;">Daftar Gunung Tersedia</div>
    
    <div id="explore-mountain-list" style="padding-bottom: 24px;">
      <?php foreach ($data['mountains'] as $mt): ?>
        <?php 
          $densityClass = 'density-sedang';
          if ($mt['density'] === 'Sepi') $densityClass = 'density-sepi';
          if ($mt['density'] === 'Ramai') $densityClass = 'density-ramai';
          if ($mt['density'] === 'Sangat Ramai') $densityClass = 'density-sangat-ramai';
          
          $diffColor = '#B06000'; // Sedang
          $diffBg = '#FEF7E0';
          if ($mt['difficulty'] === 'Mudah') { $diffColor = '#137333'; $diffBg = '#E6F4EA'; }
          if ($mt['difficulty'] === 'Sulit') { $diffColor = '#C5221F'; $diffBg = '#FCE8E6'; }
        ?>
        <div class="card mountain-search-card" data-name="<?= strtolower(htmlspecialchars($mt['name'])) ?>" onclick="viewMountainDetails('<?= $mt['id'] ?>')" style="cursor: pointer; padding: 12px; margin: 0 24px 16px; border-radius: var(--radius-md); overflow: hidden; background: var(--card-bg); box-shadow: var(--shadow-sm); border: 1px solid var(--border-color); display: flex; flex-direction: column; gap: 0;">
          <div style="position: relative; width: 100%; height: 160px; border-radius: var(--radius-sm); overflow: hidden; margin-bottom: 12px; background-color: #eee;">
            <img src="<?= $mt['image_url'] ?>" style="width: 100%; height: 100%; object-fit: cover; transition: var(--transition);" alt="<?= htmlspecialchars($mt['name']) ?>">
            <span class="badge-density <?= $densityClass ?>" style="position: absolute; top: 12px; right: 12px; font-size: 9px; font-weight: 800; padding: 4px 10px; border-radius: 50px; box-shadow: 0 2px 8px rgba(0,0,0,0.15);"><?= htmlspecialchars($mt['density']) ?></span>
            <span style="position: absolute; bottom: 12px; left: 12px; font-size: 10px; font-weight: 700; color: #FFFFFF; background: rgba(15, 76, 58, 0.95); padding: 4px 8px; border-radius: 4px; backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px);">⛰️ <?= htmlspecialchars($mt['elevation']) ?></span>
          </div>
          
          <div style="padding: 0 4px 6px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
              <h4 style="margin: 0; color: var(--text-dark); font-size: 16px; font-weight: 800;"><?= htmlspecialchars($mt['name']) ?></h4>
              <span style="font-size: 10px; font-weight: 700; color: <?= $diffColor ?>; background: <?= $diffBg ?>; padding: 2px 8px; border-radius: 20px; text-transform: uppercase;"><?= htmlspecialchars($mt['difficulty'] ?? 'Sedang') ?></span>
            </div>
            
            <p style="font-size: 12px; color: var(--text-muted); margin: 0; font-weight: 500;"><?= htmlspecialchars($mt['location']) ?></p>
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px; border-top: 1px solid var(--border-color); padding-top: 10px; font-size: 12px;">
              <div style="color: var(--text-muted); font-weight: 500;">
                ⏱️ <span style="color: var(--text-dark); font-weight: 700;"><?= htmlspecialchars($mt['estimated_duration'] ?? '2 Hari') ?></span>
              </div>
              <div style="color: var(--text-muted); font-weight: 500;">
                Sisa Kuota: <span style="color: var(--primary); font-weight: 800; font-size: 13px;"><?= $mt['quota']['remaining'] ?></span>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
      
      <div id="explore-no-results" style="display: none; text-align: center; padding: 40px 24px; color: var(--text-muted);">
        <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="margin-bottom: 12px; opacity: 0.5;">
          <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>
        <p style="font-weight: 600;">Gunung tidak ditemukan</p>
        <p style="font-size: 12px; margin-top: 4px;">Coba gunakan kata kunci pencarian yang lain.</p>
      </div>
    </div>
  </div>

  <!-- Explore View 2: Detailed Mountain Page -->
  <div id="explore-detail-view" style="display: none;">
    <div style="position: relative; height: 260px; overflow: hidden; border-radius: 0 0 var(--radius-lg) var(--radius-lg); box-shadow: var(--shadow-md);">
      <img id="explore-detail-img" src="" style="width: 100%; height: 100%; object-fit: cover;" alt="Mountain Cover">
      <div class="carousel-overlay" style="background: linear-gradient(180deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.6) 100%);"></div>
      
      <div onclick="closeMountainDetails()" style="position: absolute; top: 16px; left: 16px; width: 40px; height: 40px; border-radius: 50%; background: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center; color: white; cursor: pointer; backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px); z-index: 10;">
        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"></path></svg>
      </div>

      <div style="position: absolute; bottom: 20px; left: 24px; right: 24px; z-index: 10;">
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
          <span id="explore-detail-density" class="badge-density" style="font-size: 9px; padding: 3px 8px; border-radius: 50px;"></span>
          <span id="explore-detail-elevation-badge" style="font-size: 10px; font-weight: 700; color: #ECA823; background: rgba(236,168,35,0.15); border: 1px solid rgba(236,168,35,0.3); padding: 2px 8px; border-radius: 4px; backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px);"></span>
        </div>
        <h2 id="explore-detail-title" style="margin: 0; color: #FFFFFF; font-weight: 800; font-size: 26px; text-shadow: 0 2px 6px rgba(0,0,0,0.4);"></h2>
        <p id="explore-detail-location" style="font-size: 13px; color: #E2E8F0; margin-top: 4px; font-weight: 500;"></p>
      </div>
    </div>

    <div style="padding: 20px 24px 40px;">
      <!-- Tab Navigation Headers -->
      <div class="detail-tabs-header">
        <button class="detail-tab-btn active" id="btn-tab-info" onclick="switchDetailTab('info')">Informasi</button>
        <button class="detail-tab-btn" id="btn-tab-jalur" onclick="switchDetailTab('jalur')">Jalur</button>
        <button class="detail-tab-btn" id="btn-tab-peta" onclick="switchDetailTab('peta')">Peta</button>
        <button class="detail-tab-btn" id="btn-tab-fasilitas" onclick="switchDetailTab('fasilitas')">Fasilitas</button>
      </div>

      <!-- Tab Content 1: Informasi -->
      <div id="detail-tab-content-info" class="detail-tab-content active">
        <p id="explore-detail-desc" style="font-size: 14px; line-height: 1.6; color: var(--text-dark); margin-bottom: 20px;"></p>

        <!-- Real-Time Quota Card -->
        <div class="card" style="margin: 0 0 20px 0; background: #EBF7F4; border-color: #C6E7DE; display: flex; justify-content: space-around; text-align: center; padding: 16px 8px; box-shadow: var(--shadow-sm);">
          <div>
            <p style="font-size: 10px; color: var(--primary-light); font-weight: 700; margin-bottom: 4px; letter-spacing: 0.5px;">KUOTA SISA</p>
            <strong id="explore-detail-quota-rem" style="font-size: 22px; color: var(--primary); font-weight: 800;">0</strong>
          </div>
          <div style="border-left: 1px solid #C6E7DE;"></div>
          <div>
            <p style="font-size: 10px; color: var(--primary-light); font-weight: 700; margin-bottom: 4px; letter-spacing: 0.5px;">DI GUNUNG</p>
            <strong id="explore-detail-quota-active" style="font-size: 22px; color: var(--primary); font-weight: 800;">0</strong>
          </div>
          <div style="border-left: 1px solid #C6E7DE;"></div>
          <div>
            <p style="font-size: 10px; color: var(--primary-light); font-weight: 700; margin-bottom: 4px; letter-spacing: 0.5px;">TOTAL KUOTA</p>
            <strong id="explore-detail-quota-tot" style="font-size: 22px; color: var(--primary); font-weight: 800;">0</strong>
          </div>
        </div>

        <!-- Weather Card -->
        <h4 style="color: var(--primary); font-weight: 800; font-size: 15px; margin-bottom: 12px;">Prakiraan Cuaca</h4>
        <div class="card" style="margin: 0 0 20px 0; padding: 16px; box-shadow: var(--shadow-sm);">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
            <div style="display: flex; align-items: center; gap: 10px;">
              <span style="font-size: 32px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">⛅</span>
              <div>
                <strong id="weather-status-text" style="font-size: 15px; color: var(--text-dark); font-weight: 700;">Cerah</strong>
                <p style="font-size: 12px; color: var(--text-muted); margin-top: 1px; font-weight: 500;">Kondisi Hari Ini</p>
              </div>
            </div>
            <div id="weather-temp" style="font-size: 26px; font-weight: 800; color: var(--primary);">14°C</div>
          </div>
          <div style="display: flex; justify-content: space-between; font-size: 12px; border-top: 1px solid #F1F5F9; padding-top: 12px; margin-bottom: 12px; font-weight: 600; color: var(--text-muted);">
            <div>🌀 Angin: <strong id="weather-wind" style="color: var(--text-dark);">12 km/jam</strong></div>
            <div>💧 Kelembaban: <strong id="weather-humidity" style="color: var(--text-dark);">65%</strong></div>
          </div>
          <p id="weather-forecast" style="font-size: 13px; color: var(--text-dark); background: var(--bg-light); padding: 12px; border-radius: 8px; margin: 0; line-height: 1.5; font-weight: 500;"></p>
          <div id="weather-warnings-container" style="margin-top: 12px;"></div>
        </div>
      </div>

      <!-- Tab Content 2: Jalur -->
      <div id="detail-tab-content-jalur" class="detail-tab-content">
        <h4 style="color: var(--primary); font-weight: 800; font-size: 15px; margin-bottom: 12px;">Pilihan Rute Resmi</h4>
        <div id="detail-routes-list" style="display: flex; flex-direction: column; gap: 12px;">
          <!-- Populated in JS details rendering -->
        </div>
      </div>

      <!-- Tab Content 3: Peta -->
      <div id="detail-tab-content-peta" class="detail-tab-content">
        <h4 style="color: var(--primary); font-weight: 800; font-size: 15px; margin-bottom: 12px;">Peta Satelit Interaktif</h4>
        <div id="detail-map" style="box-shadow: var(--shadow-sm);"></div>
        <div id="map-detail-drawer" class="map-detail-drawer" style="box-shadow: var(--shadow-sm);"></div>
      </div>

      <!-- Tab Content 4: Fasilitas -->
      <div id="detail-tab-content-fasilitas" class="detail-tab-content">
        <h4 style="color: var(--primary); font-weight: 800; font-size: 15px; margin-bottom: 12px;">Fasilitas Basecamp & Jalur</h4>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;" id="detail-facilities-grid">
          <!-- Populated in JS details rendering -->
        </div>
      </div>

      <button id="detail-book-btn" class="btn-primary" style="margin-top: 28px; padding: 16px; font-weight: 700; border-radius: var(--radius-md);">Daftar Mendaki Sekarang</button>
    </div>
  </div>

  <!-- Explore View 3: Registration Booking Wizard -->
  <div id="explore-booking-view" style="display: none; padding: 24px 24px 40px;">
    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 28px;">
      <div onclick="closeBookingForm()" style="width: 36px; height: 36px; border-radius: 50%; background: #E2E8F0; display: flex; justify-content: center; align-items: center; color: var(--text-dark); cursor: pointer; transition: var(--transition);">
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"></path></svg>
      </div>
      <div>
        <h3 id="booking-form-title" style="margin: 0; color: var(--primary); font-weight: 800; font-size: 20px; line-height: 1.2;">Gunung Merbabu</h3>
        <p style="font-size: 12px; margin: 2px 0 0; color: var(--text-muted); font-weight: 600;">Form Registrasi Pendakian</p>
      </div>
    </div>

    <!-- Wrap inside a styled Card -->
    <div class="card" style="margin: 0; padding: 20px; background: var(--card-bg); border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border: 1px solid var(--border-color);">
      <form method="POST" action="index.php">
        <input type="hidden" name="action_type" value="book_ticket">
        
        <!-- HIDDEN mountain dropdown to keep backend compatibility -->
        <select name="mountain_id" id="booking-mountain-select" required onchange="updateBookingBasecamps()" style="display: none;">
          <?php foreach ($data['mountains'] as $mt_opt): ?>
            <option value="<?= $mt_opt['id'] ?>"><?= htmlspecialchars($mt_opt['name']) ?></option>
          <?php endforeach; ?>
        </select>

        <div class="input-group" style="margin-bottom: 16px;">
          <label style="display:block; font-size:11px; font-weight:700; color:var(--text-muted); margin-bottom:6px; letter-spacing: 0.5px;">JALUR PENDAKIAN / BASECAMP</label>
          <select name="basecamp" id="booking-basecamp-select" required style="width:100%; padding:12px 14px; border:1px solid var(--border-color); border-radius:8px; outline:none; background: var(--bg-light); font-size: 13px; font-weight: 600; color: var(--text-dark);">
            <!-- Auto populated by JS -->
          </select>
        </div>

        <div class="input-group" style="margin-bottom: 16px;">
          <label style="display:block; font-size:11px; font-weight:700; color:var(--text-muted); margin-bottom:6px; letter-spacing: 0.5px;">TANGGAL MULAI PENDAKIAN</label>
          <input type="date" name="climb_date_start" id="booking-date-start" required min="<?= date('Y-m-d') ?>" onchange="calculateClimbDuration()" style="width:100%; padding:12px 14px; border:1px solid var(--border-color); border-radius:8px; outline:none; background: var(--bg-light); font-size: 13px; font-weight: 600; color: var(--text-dark);">
        </div>

        <div class="input-group" style="margin-bottom: 20px;">
          <label style="display:block; font-size:11px; font-weight:700; color:var(--text-muted); margin-bottom:6px; letter-spacing: 0.5px;">TANGGAL SELESAI PENDAKIAN</label>
          <input type="date" name="climb_date_end" id="booking-date-end" required min="<?= date('Y-m-d') ?>" onchange="calculateClimbDuration()" style="width:100%; padding:12px 14px; border:1px solid var(--border-color); border-radius:8px; outline:none; background: var(--bg-light); font-size: 13px; font-weight: 600; color: var(--text-dark);">
        </div>

        <!-- Durasi Pendakian Display Card -->
        <div id="duration-display-container" class="card" style="margin: 0 0 24px 0; background: #EBF7F4; border: 1px solid #C6E7DE; padding: 12px 16px; border-radius: var(--radius-sm); display: none;">
          <div style="display: flex; align-items: center; gap: 10px; font-size: 13px; color: var(--primary);">
            <span style="font-size: 18px;">⏳</span>
            <div>
              <span style="font-weight: 600; color: var(--primary-light);">Durasi Perjalanan:</span>
              <span id="climb-duration-text" style="font-weight: 800; margin-left: 4px; color: var(--primary); font-size: 14px;">-</span>
            </div>
          </div>
          <div id="duration-error-text" style="color: #E53E3E; font-size: 12px; font-weight: 700; margin-top: 6px; display: none;">Tanggal selesai tidak boleh lebih awal dari tanggal mulai!</div>
        </div>

        <div style="border-top: 1px solid #F1F5F9; padding-top: 20px;">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h4 style="margin: 0; color: var(--primary); font-weight: 800; font-size: 14px;">Daftar Pendaki Rombongan</h4>
            <button type="button" onclick="addMemberField()" style="background: var(--primary); color: white; border: none; padding: 6px 12px; border-radius: 6px; font-size: 11px; font-weight: 700; cursor: pointer; transition: var(--transition); display: flex; align-items: center; gap: 4px;">+ Tambah</button>
          </div>

          <!-- Climbers list -->
          <div id="booking-members" class="booking-members-list">
            <div class="member-row" id="member-row-1" style="background: var(--bg-light); border-radius: var(--radius-sm); padding: 14px; margin-bottom: 12px; border: 1px solid var(--border-color);">
              <div style="margin-bottom: 12px;">
                <label style="display:block; font-size:10px; font-weight:700; color:var(--text-muted); margin-bottom:4px;">NAMA KETUA / ROMBONGAN #1</label>
                <input type="text" name="climber_names[]" required placeholder="Nama lengkap sesuai KTP" style="width:100%; padding:10px; border:1px solid var(--border-color); border-radius:6px; outline:none; background: var(--bg-light); font-size: 13px; font-weight: 600; color: var(--text-dark);">
              </div>
              <div>
                <label style="display:block; font-size:10px; font-weight:700; color:var(--text-muted); margin-bottom:4px;">NOMOR KTP KETUA #1</label>
                <input type="text" name="climber_ktps[]" required placeholder="Nomor KTP (16 digit)" style="width:100%; padding:10px; border:1px solid var(--border-color); border-radius:6px; outline:none; background: var(--bg-light); font-size: 13px; font-weight: 600; color: var(--text-dark);">
              </div>
            </div>
          </div>
        </div>

        <button type="submit" class="btn-primary" style="margin-top: 24px; margin-bottom: 0; padding: 16px; border-radius: var(--radius-md); font-weight: 700;">Proses Pendaftaran</button>
      </form>
    </div>
  </div>
</div>

<script>
  function switchDetailTab(tabId) {
    // Hide all tab content
    document.querySelectorAll('.detail-tab-content').forEach(content => {
      content.classList.remove('active');
    });
    // Unactivate all tab buttons
    document.querySelectorAll('.detail-tab-btn').forEach(btn => {
      btn.classList.remove('active');
    });

    // Activate selected
    const activeContent = document.getElementById('detail-tab-content-' + tabId);
    if (activeContent) {
      activeContent.classList.add('active');
    }
    const activeBtn = document.getElementById('btn-tab-' + tabId);
    if (activeBtn) {
      activeBtn.classList.add('active');
    }

    // Recalculate Leaflet map sizes if tab is Peta
    if (tabId === 'peta' && typeof detailMap !== 'undefined' && detailMap) {
      setTimeout(() => {
        detailMap.invalidateSize();
      }, 200);
    }
  }
</script>
