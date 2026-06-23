<?php if (isset($_SESSION['user_email'])): ?>
  <!-- Bottom Navigation Bar Simulator -->
  <div class="bottom-nav">
    <a class="bottom-nav-item active" data-tab="home" onclick="switchTab('home')">
      <svg viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
      Home
    </a>
    <a class="bottom-nav-item" data-tab="explore" onclick="switchTab('explore')">
      <svg viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
      Explore
    </a>
    <a class="bottom-nav-item" data-tab="ticket" onclick="switchTab('ticket')">
      <svg viewBox="0 0 24 24"><path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
      Ticket
    </a>
    <a class="bottom-nav-item" data-tab="tracking" onclick="switchTab('tracking')">
      <svg viewBox="0 0 24 24"><path d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
      Tracking
    </a>
    <a class="bottom-nav-item" data-tab="profile" onclick="switchTab('profile')">
      <svg viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
      Profile
    </a>
  </div>

  <!-- Embedded Data for JavaScript use -->
  <script>
    const mountainsData = <?= json_encode($data['mountains']) ?>;
    const userTickets = <?= json_encode($user_tickets) ?>;
    


    // Show toast success/error notifications on page load if set
    <?php if (!empty($success_message)): ?>
      window.addEventListener('load', () => {
        showToast('<?= addslashes($success_message) ?>', 'success');
        switchTab('ticket');
      });
    <?php endif; ?>
    
    <?php if (!empty($error_message) && isset($_POST['action_type'])): ?>
      window.addEventListener('load', () => {
        showToast('<?= addslashes($error_message) ?>', 'error');
        // Re-open booking view
        switchTab('explore');
        openBookingForm('<?= htmlspecialchars($_POST['mountain_id']) ?>');
      });
    <?php endif; ?>
  </script>
  <script src="app.js?v=2.0"></script>
<?php endif; ?>

</div> <!-- Close phone-container -->
</body>
</html>
