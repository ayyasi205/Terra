<?php
session_start();

require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/actions.php';

// Include HTML layout header
include __DIR__ . '/views/header.php';

if (!isset($_SESSION['user_email'])) {
    // Show auth screen if not logged in
    include __DIR__ . '/views/auth.php';
} else {
    // Show status bar simulator
    ?>
    <div class="status-bar" id="app-status-bar">
      <div>10:22</div>
      <div style="display: flex; gap: 4px; align-items: center;">
        <span>5G</span>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
      </div>
    </div>


    <!-- App Viewport -->
    <div class="app-viewport">
        <?php
        include __DIR__ . '/views/home.php';
        include __DIR__ . '/views/explore.php';
        include __DIR__ . '/views/ticket.php';
        include __DIR__ . '/views/tracking.php';
        include __DIR__ . '/views/profile.php';
        ?>
    </div>

    <!-- Ticket Detail Slide-Up Overlay -->
    <?php
    include __DIR__ . '/views/ticket_detail.php';
}

// Include footer, bottom navigation, and scripts
include __DIR__ . '/views/footer.php';
?>
