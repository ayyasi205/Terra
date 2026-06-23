<!-- PAGE 3: TICKET -->
<div id="page-ticket" class="page">
  <div class="header-hero" style="padding: 32px 24px 44px; position: relative; border-radius: 0 0 var(--radius-lg) var(--radius-lg); background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);">
    <h3 style="font-weight: 800; margin: 0; font-size: 24px; color: white;">Tiket Pendakian Anda</h3>
    <p style="font-size: 13px; opacity: 0.9; margin-top: 4px; color: #E2E8F0; font-weight: 500;">Kelola rencana dan riwayat perjalanan Anda di sini</p>
  </div>

  <!-- Tab Buttons -->
  <div style="display: flex; background: var(--card-bg); border-radius: var(--radius-md); margin: -20px 24px 16px; padding: 4px; border: 1px solid var(--border-color); box-shadow: var(--shadow-md); position: relative; z-index: 10;">
    <button id="tab-active-tickets" onclick="switchTicketTab('active')" style="flex: 1; border: none; background: var(--primary); color: white; padding: 12px; border-radius: 12px; font-weight: 700; cursor: pointer; font-size: 13px; transition: var(--transition);">Tiket Aktif</button>
    <button id="tab-past-tickets" onclick="switchTicketTab('past')" style="flex: 1; border: none; background: transparent; color: var(--text-muted); padding: 12px; border-radius: 12px; font-weight: 700; cursor: pointer; font-size: 13px; transition: var(--transition);">Riwayat Tiket</button>
  </div>

  <!-- Dynamic Tickets Container -->
  <div id="tickets-list-container" style="margin-top: 8px; padding-bottom: 24px;"></div>
</div>
