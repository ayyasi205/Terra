<!-- Authentication Screens (Login / Register) -->
<div class="auth-container" style="position: relative; overflow: hidden; background: #0c0e0d; justify-content: space-between; padding: 48px 24px 32px; min-height: 100vh; display: flex; flex-direction: column;">
  <!-- Starry mountain and tent background overlay -->
  <div style="background-image: url('https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?auto=format&fit=crop&w=800&q=80'); background-size: cover; background-position: center; position: absolute; top: 0; left: 0; right: 0; bottom: 0; opacity: 0.4; z-index: 1;"></div>
  
  <!-- Starry night vignette (pure dark-mode colors instead of green tint) -->
  <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(180deg, rgba(12, 14, 13, 0.65) 0%, #0c0e0d 100%); z-index: 2;"></div>

  <div style="z-index: 3; width: 100%; margin-top: auto; margin-bottom: auto;">
    <div class="auth-header" style="margin-bottom: 36px; text-align: center;">
      <!-- Stylized peak logo identical to reference image -->
      <svg width="84" height="84" viewBox="0 0 100 100" style="margin-bottom: 16px; filter: drop-shadow(0 4px 10px rgba(0,0,0,0.4));">
        <!-- Outer Chevron Peak -->
        <path d="M50 15 L90 85 H74 L50 38 L26 85 H10 Z" fill="#38A169" />
        <!-- Inner Caret Chevron -->
        <path d="M50 50 L70 82 H56 L50 70 L44 82 H30 Z" fill="#38A169" />
      </svg>
      <div class="auth-title" style="font-size: 32px; font-weight: 800; tracking-spacing: 2px; color: #FFFFFF; text-shadow: 0 2px 10px rgba(0,0,0,0.5);">TERRA</div>
      <div class="auth-subtitle" style="font-size: 13px; font-weight: 500; opacity: 0.7; color: #E2E8F0; letter-spacing: 0.5px; margin-top: 4px;">Tracking & Registration Adventure</div>
    </div>

    <?php if (!empty($error_message)): ?>
      <div class="warning-box" style="background: rgba(229, 62, 62, 0.2); border-left: 4px solid #E53E3E; color: #FC8181; margin-bottom: 24px; border-radius: var(--radius-sm); padding: 12px 16px; font-weight: 600; font-size: 13px;">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink: 0; margin-top: 1px;"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        <span><?= htmlspecialchars($error_message) ?></span>
      </div>
    <?php endif; ?>

    <!-- Form Login -->
    <div id="login-form-wrapper">
      <form class="auth-form" id="login-form" method="POST" action="index.php" onsubmit="return handleFormSubmit(this, 'login')">
        <input type="hidden" name="auth_type" value="login">
        
        <div class="input-group">
          <label style="color: rgba(255,255,255,0.7); font-size: 11px; font-weight: 700; margin-bottom: 6px; letter-spacing: 0.5px;">USERNAME / EMAIL</label>
          <input type="text" name="email" required placeholder="Masukkan email atau username" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); font-size: 14px; padding: 14px 16px; border-radius: var(--radius-md); color: #FFF; outline: none; width: 100%;">
          <span class="validation-error-text" style="display: none;"></span>
        </div>
        
        <div class="input-group" style="margin-top: 16px;">
          <label style="color: rgba(255,255,255,0.7); font-size: 11px; font-weight: 700; margin-bottom: 6px; letter-spacing: 0.5px;">PASSWORD</label>
          <div class="password-input-wrapper">
            <input type="password" name="password" id="login-password" required placeholder="Masukkan password Anda" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); font-size: 14px; padding: 14px 16px; border-radius: var(--radius-md); color: #FFF; outline: none; width: 100%;">
            <button type="button" class="toggle-password-btn" onclick="togglePasswordVisibility('login-password')">
              <svg id="eye-icon-login-password" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </button>
          </div>
          <span class="validation-error-text" style="display: none;"></span>
        </div>
        
        <button type="submit" class="btn-primary" style="margin-top: 24px; padding: 16px; border-radius: var(--radius-md); box-shadow: 0 4px 15px rgba(56, 161, 105, 0.2); font-weight: 700; background: var(--accent); color: var(--text-dark);">Masuk</button>
      </form>
      
      <div class="auth-toggle" onclick="toggleAuthForms(true)" style="margin-top: 24px; text-align: center; font-size: 13px; color: rgba(255,255,255,0.75);">
        Belum memiliki akun? <br>
        <span style="color: var(--accent); font-weight: 700; text-decoration: none; margin-top: 6px; display: inline-block; cursor: pointer;">Daftar Sekarang</span>
      </div>
    </div>

    <!-- Form Register -->
    <div id="register-form-wrapper" style="display: none;">
      <form class="auth-form" id="register-form" method="POST" action="index.php" onsubmit="return handleFormSubmit(this, 'register')">
        <input type="hidden" name="auth_type" value="register">
        
        <div class="input-group">
          <label style="color: rgba(255,255,255,0.7); font-size: 11px; font-weight: 700; margin-bottom: 6px; letter-spacing: 0.5px;">NAMA LENGKAP</label>
          <input type="text" name="fullname" id="reg-fullname" required placeholder="Masukkan nama lengkap Anda" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); font-size: 14px; padding: 14px 16px; border-radius: var(--radius-md); color: #FFF; outline: none; width: 100%;">
          <span class="validation-error-text" style="display: none;"></span>
        </div>

        <div class="input-group" style="margin-top: 14px;">
          <label style="color: rgba(255,255,255,0.7); font-size: 11px; font-weight: 700; margin-bottom: 6px; letter-spacing: 0.5px;">USERNAME</label>
          <input type="text" name="username" id="reg-username" required placeholder="Buat username unik" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); font-size: 14px; padding: 14px 16px; border-radius: var(--radius-md); color: #FFF; outline: none; width: 100%;">
          <span class="validation-error-text" style="display: none;"></span>
        </div>

        <div class="input-group" style="margin-top: 14px;">
          <label style="color: rgba(255,255,255,0.7); font-size: 11px; font-weight: 700; margin-bottom: 6px; letter-spacing: 0.5px;">ALAMAT EMAIL</label>
          <input type="email" name="email" id="reg-email" required placeholder="Contoh: nama@domain.com" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); font-size: 14px; padding: 14px 16px; border-radius: var(--radius-md); color: #FFF; outline: none; width: 100%;">
          <span class="validation-error-text" style="display: none;"></span>
        </div>

        <div class="input-group" style="margin-top: 14px;">
          <label style="color: rgba(255,255,255,0.7); font-size: 11px; font-weight: 700; margin-bottom: 6px; letter-spacing: 0.5px;">PASSWORD</label>
          <div class="password-input-wrapper">
            <input type="password" name="password" id="register-password" required placeholder="Buat password baru" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); font-size: 14px; padding: 14px 16px; border-radius: var(--radius-md); color: #FFF; outline: none; width: 100%;">
            <button type="button" class="toggle-password-btn" onclick="togglePasswordVisibility('register-password')">
              <svg id="eye-icon-register-password" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </button>
          </div>
          <span class="validation-error-text" style="display: none;"></span>
        </div>

        <div class="input-group" style="margin-top: 14px;">
          <label style="color: rgba(255,255,255,0.7); font-size: 11px; font-weight: 700; margin-bottom: 6px; letter-spacing: 0.5px;">KONFIRMASI PASSWORD</label>
          <div class="password-input-wrapper">
            <input type="password" name="confirm_password" id="register-confirm-password" required placeholder="Ulangi password baru" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); font-size: 14px; padding: 14px 16px; border-radius: var(--radius-md); color: #FFF; outline: none; width: 100%;">
            <button type="button" class="toggle-password-btn" onclick="togglePasswordVisibility('register-confirm-password')">
              <svg id="eye-icon-register-confirm-password" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </button>
          </div>
          <span class="validation-error-text" style="display: none;"></span>
        </div>
        
        <button type="submit" class="btn-primary" style="margin-top: 24px; padding: 16px; border-radius: var(--radius-md); font-weight: 700; background: var(--accent); color: var(--text-dark);">Daftar</button>
      </form>
      
      <div class="auth-toggle" onclick="toggleAuthForms(false)" style="margin-top: 24px; text-align: center; font-size: 13px; color: rgba(255,255,255,0.75);">
        Sudah memiliki akun? <br>
        <span style="color: var(--accent); font-weight: 700; text-decoration: none; margin-top: 6px; display: inline-block; cursor: pointer;">Masuk</span>
      </div>
    </div>
  </div>

  <!-- Bottom custom slogan from image -->
  <div style="z-index: 3; text-align: center; font-size: 14px; margin-top: 24px;">
    <span style="color: #FFFFFF; font-weight: 500;">Registrasi Mudah,</span>
    <span style="color: #38A169; font-weight: 700;">Pendakian Aman.</span>
  </div>
</div>

<script>
  function toggleAuthForms(showRegister) {
    document.querySelectorAll('.input-invalid').forEach(el => el.classList.remove('input-invalid'));
    document.querySelectorAll('.validation-error-text').forEach(el => el.style.display = 'none');

    if (showRegister) {
      document.getElementById('login-form-wrapper').style.display = 'none';
      document.getElementById('register-form-wrapper').style.display = 'block';
    } else {
      document.getElementById('login-form-wrapper').style.display = 'block';
      document.getElementById('register-form-wrapper').style.display = 'none';
    }
  }

  function togglePasswordVisibility(inputId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById('eye-icon-' + inputId);
    if (!input) return;

    if (input.type === 'password') {
      input.type = 'text';
      if (icon) {
        icon.innerHTML = `<path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-.901A5.022 5.022 0 0112 7c2.762 0 5 2.239 5 5 0 .744-.162 1.45-.452 2.082m-1.909 3.968A9.953 9.953 0 0112 19c-4.478 0-8.268-2.943-9.543-7 1.274-4.057 5.064-7 9.543-7 1.258 0 2.45.234 3.548.66m-3.548 6.34a3 3 0 11-4.243-4.243m1.414 5.656l5.656-5.656" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>`;
      }
    } else {
      input.type = 'password';
      if (icon) {
        icon.innerHTML = `<path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
      }
    }
  }

  function handleFormSubmit(formEl, mode) {
    let isValid = true;
    formEl.querySelectorAll('.input-invalid').forEach(el => el.classList.remove('input-invalid'));
    formEl.querySelectorAll('.validation-error-text').forEach(el => {
      el.style.display = 'none';
      el.innerText = '';
    });

    if (mode === 'login') {
      const emailInput = formEl.querySelector('input[name="email"]');
      const passwordInput = formEl.querySelector('input[name="password"]');

      if (!emailInput.value.trim()) {
        showInputError(emailInput, 'Email atau Username wajib diisi');
        isValid = false;
      }
      if (!passwordInput.value) {
        showInputError(passwordInput, 'Password wajib diisi');
        isValid = false;
      }
    } else if (mode === 'register') {
      const fullnameInput = document.getElementById('reg-fullname');
      const usernameInput = document.getElementById('reg-username');
      const emailInput = document.getElementById('reg-email');
      const passwordInput = document.getElementById('register-password');
      const confirmInput = document.getElementById('register-confirm-password');

      if (!fullnameInput.value.trim()) {
        showInputError(fullnameInput, 'Nama lengkap wajib diisi');
        isValid = false;
      }
      if (!usernameInput.value.trim()) {
        showInputError(usernameInput, 'Username wajib diisi');
        isValid = false;
      }
      if (!emailInput.value.trim() || !emailInput.value.includes('@')) {
        showInputError(emailInput, 'Masukkan alamat email yang valid');
        isValid = false;
      }
      if (passwordInput.value.length < 6) {
        showInputError(passwordInput, 'Password minimal 6 karakter');
        isValid = false;
      }
      if (passwordInput.value !== confirmInput.value) {
        showInputError(confirmInput, 'Konfirmasi password tidak cocok');
        isValid = false;
      }
    }

    if (isValid) {
      const submitBtn = formEl.querySelector('button[type="submit"]');
      if (submitBtn) {
        submitBtn.classList.add('btn-loading');
      }
      return true;
    }
    return false;
  }

  function showInputError(inputEl, msg) {
    inputEl.classList.add('input-invalid');
    const errText = inputEl.closest('.input-group').querySelector('.validation-error-text');
    if (errText) {
      errText.innerText = msg;
      errText.style.display = 'block';
    }
  }
</script>
