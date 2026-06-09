<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Paramètres | EduManager</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: "#7300e9",
            primaryDark: "#5c00bd",
            accent: "#99fbe3",
            danger: "#ef4444",
            warning: "#f59e0b",
            success: "#10b981"
          },
          fontFamily: {
            heading: ["Quicksand", "sans-serif"],
            body: ["Outfit", "sans-serif"]
          },
          animation: {
            'fade-in': 'fadeIn 0.3s ease-in-out',
            'slide-up': 'slideUp 0.4s ease-out'
          },
          keyframes: {
            fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
            slideUp: { '0%': { opacity: '0', transform: 'translateY(10px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } }
          }
        }
      }
    };
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: "Outfit", sans-serif; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); min-height: 100vh; }
    h1, h2, h3, .font-heading { font-family: "Quicksand", sans-serif; }
    
    .settings-card {
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      height: 100%;
      display: flex;
      flex-direction: column;
    }
    .settings-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
    }
    
    .input-focus-effect:focus {
      box-shadow: 0 0 0 3px rgba(115, 0, 233, 0.1);
      border-color: #7300e9;
    }
    
    .action-btn {
      transition: all 0.2s ease;
    }
    .action-btn:active {
      transform: scale(0.98);
    }
    
    .radio-status {
      appearance: none;
      width: 18px;
      height: 18px;
      border: 2px solid #cbd5e1;
      border-radius: 50%;
      transition: all 0.2s ease;
      position: relative;
      cursor: pointer;
    }
    .radio-status:checked {
      border-color: #7300e9;
      background-color: #7300e9;
      box-shadow: inset 0 0 0 3px white;
    }
    .radio-status:focus {
      outline: none;
      ring: 2px solid #7300e9;
    }
    
    .toast {
      position: fixed;
      bottom: 24px;
      right: 24px;
      background: #1e293b;
      color: white;
      padding: 12px 20px;
      border-radius: 16px;
      font-size: 0.875rem;
      font-weight: 500;
      z-index: 10000;
      opacity: 0;
      transition: opacity 0.3s ease, transform 0.2s ease;
      pointer-events: none;
      transform: translateY(10px);
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    .toast.show {
      opacity: 1;
      transform: translateY(0);
    }
    
    .modal-overlay {
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.5);
      backdrop-filter: blur(4px);
      z-index: 9999;
      display: flex;
      align-items: center;
      justify-content: center;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.2s ease, visibility 0.2s ease;
    }
    .modal-overlay.is-open {
      opacity: 1;
      visibility: visible;
    }
    .modal-content {
      background: white;
      border-radius: 24px;
      max-width: 90%;
      width: 400px;
      transform: scale(0.95);
      transition: transform 0.2s ease;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    .modal-overlay.is-open .modal-content {
      transform: scale(1);
    }
    
    ::-webkit-scrollbar { width: 8px; height: 8px; }
    ::-webkit-scrollbar-track { background: #e2e8f0; border-radius: 10px; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    
    .app-header {
      position: fixed;
      top: 0;
      right: 0;
      left: 0;
      z-index: 40;
      background-color: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(12px);
      border-bottom: 1px solid #e2e8f0;
    }
    
    /* Password strength meter */
    .strength-meter {
      height: 4px;
      border-radius: 4px;
      transition: all 0.3s ease;
    }
    .strength-bar {
      height: 4px;
      border-radius: 4px;
      transition: width 0.3s ease;
    }
  </style>
</head>
<body>

<!-- Header -->
<header class="app-header">
  <div class="flex h-16 items-center justify-between gap-4 px-4 sm:px-6 lg:pl-[270px]">
    <div class="flex items-center gap-3">
      <div>
        <p class="font-heading text-sm font-semibold text-primary sm:text-base">
          <?= htmlspecialchars($_SESSION['school_name'] ?? 'École inconnue') ?>
        </p>
        <p class="text-xs text-slate-500">
          <?= htmlspecialchars($_SESSION['school_address'] ?? '') ?>
        </p>
      </div>
    </div>
    <div class="flex items-center gap-3">
      <?php
        $currentYear = date("Y");
        $nextYear = $currentYear + 1;
        $schoolYear = $currentYear . "–" . $nextYear;
      ?>
      <span class="hidden rounded-full border border-accent/50 bg-accent/20 px-3 py-1 text-xs font-medium text-slate-800 sm:inline-flex">
        Année scolaire <?= $schoolYear ?>
      </span>
      
      <button class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-2 py-1.5 pr-3 shadow-sm hover:shadow-md transition">
        <?php
          $userName = $_SESSION['user_name'] ?? 'User';
          $userAvatar = $_SESSION['user_avatar'] ?? null;
          $words = explode(' ', trim($userName));
          $initials = '';
          foreach ($words as $w) {
              $initials .= strtoupper($w[0] ?? '');
          }
          $initials = substr($initials, 0, 2);
        ?>
        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-primary to-primaryDark text-sm font-bold text-white shadow-md overflow-hidden">
          <?php if ($userAvatar): ?>
            <img src="<?= htmlspecialchars($userAvatar) ?>" class="w-full h-full object-cover">
          <?php else: ?>
            <?= $initials ?>
          <?php endif; ?>
        </span>
        <span class="hidden text-left text-sm sm:block">
          <span class="block font-medium text-slate-900"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Utilisateur') ?></span>
          <span class="text-xs text-slate-500"><?= htmlspecialchars($_SESSION['user_role'] ?? 'Rôle') ?></span>
        </span>
      </button>
    </div>
  </div>
</header>

<!-- Conteneur principal -->
<div class="flex" style="padding-top: 64px;">
  <?php include __DIR__ . '/../components/sidebar.php'; ?>
  
  <div class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 lg:py-10">
    
    <!-- En-tête -->
    <div class="mb-8 animate-[slideUp_0.4s_ease-out]">
      <div class="flex items-center gap-3 mb-2">
        <div class="w-1 h-8 bg-primary rounded-full"></div>
        <h1 class="font-heading text-2xl sm:text-3xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">
          Paramètres
        </h1>
      </div>
      <p class="text-slate-600 text-sm sm:text-base pl-4">Gérez votre profil et vos informations personnelles</p>
    </div>

    <!-- Messages PHP (Toast) -->
    <?php if (isset($_SESSION['toast_message'])): ?>
      <div class="fixed bottom-6 right-6 z-50 animate-[fadeIn_0.3s_ease-out]" id="php-toast">
        <div class="rounded-2xl px-5 py-3 shadow-lg flex items-center gap-2 <?= isset($_SESSION['toast_error']) && $_SESSION['toast_error'] ? 'bg-red-500' : 'bg-emerald-500' ?> text-white">
          <i class="fa-solid <?= isset($_SESSION['toast_error']) && $_SESSION['toast_error'] ? 'fa-circle-exclamation' : 'fa-circle-check' ?>"></i>
          <span class="text-sm font-medium"><?= htmlspecialchars($_SESSION['toast_message']) ?></span>
        </div>
      </div>
      <script>setTimeout(() => { const t = document.getElementById('php-toast'); if(t) t.remove(); }, 3000);</script>
      <?php unset($_SESSION['toast_message'], $_SESSION['toast_error']); ?>
    <?php endif; ?>

    <!-- Grille principale -->
    <div class="grid gap-6 lg:gap-8 lg:grid-cols-2 animate-[fadeIn_0.5s_ease-out]">
      
      <!-- Photo de profil -->
      <div class="settings-card bg-white rounded-2xl border border-slate-200/80 shadow-lg shadow-slate-200/50 p-6 sm:p-8">
        <div class="flex items-center gap-2 mb-6">
          <i class="fa-solid fa-camera text-primary text-xl"></i>
          <h2 class="font-heading text-xl font-bold text-slate-900">Photo de profil</h2>
        </div>
        
        <form method="POST" action="" enctype="multipart/form-data" class="flex flex-col items-center" id="avatar-form">
          <input type="hidden" name="action" value="update_avatar">
          
          <div class="mb-6 w-36 h-36 rounded-full bg-gradient-to-br from-slate-100 to-slate-200 border-4 border-primary/20 flex items-center justify-center overflow-hidden shadow-lg">
            <?php if (!empty($admin['avatar'])): ?>
              <img src="<?= htmlspecialchars($admin['avatar']) ?>" class="w-full h-full object-cover" alt="Avatar">
            <?php else: ?>
              <i class="fa-solid fa-user text-5xl text-primary"></i>
            <?php endif; ?>
          </div>
          
          <div class="flex flex-col sm:flex-row gap-3 justify-center w-full mt-2">
            <label class="action-btn cursor-pointer bg-white border-2 border-primary text-primary hover:bg-primary hover:text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300 flex items-center justify-center gap-2 flex-1">
              <i class="fa-solid fa-upload"></i>
              Changer la photo
              <input type="file" name="avatar" accept="image/png, image/jpeg, image/jpg" class="hidden" onchange="this.form.submit()">
            </label>
            
            <button type="button" id="delete-avatar-btn" 
                    class="action-btn bg-red-50 border border-red-200 text-red-600 hover:bg-red-100 hover:border-red-300 px-5 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300 flex items-center justify-center gap-2 flex-1">
              <i class="fa-solid fa-trash-can"></i>
              Supprimer
            </button>
          </div>
          <p class="mt-4 text-xs text-slate-500 text-center">Formats acceptés : PNG, JPG (max 2 Mo)</p>
        </form>
      </div>

      <!-- Informations personnelles -->
      <div class="settings-card bg-white rounded-2xl border border-slate-200/80 shadow-lg shadow-slate-200/50 p-6 sm:p-8">
        <div class="flex items-center gap-2 mb-6">
          <i class="fa-solid fa-user-gear text-primary text-xl"></i>
          <h2 class="font-heading text-xl font-bold text-slate-900">Mes informations</h2>
        </div>
        
        <form method="POST" action="" class="space-y-5 flex-1">
          <input type="hidden" name="action" value="update_profile">
          
          <!-- Nom complet -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
              <i class="fa-solid fa-user mr-2 text-primary"></i>Nom complet
            </label>
            <input type="text" name="name" value="<?= htmlspecialchars($admin['name'] ?? '') ?>" 
                   placeholder="Ex: Jean Dupont" 
                   class="input-focus-effect w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-primary transition-all">
          </div>
          
          <!-- Email -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
              <i class="fa-solid fa-envelope mr-2 text-primary"></i>Email
            </label>
            <input type="email" name="email" value="<?= htmlspecialchars($admin['email'] ?? '') ?>" 
                   placeholder="Ex: contact@ecole.edu" 
                   class="input-focus-effect w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-primary transition-all">
          </div>
          
          <!-- Nouveau mot de passe -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
              <i class="fa-solid fa-key mr-2 text-primary"></i>Nouveau mot de passe
            </label>
            <input type="password" id="password" name="password" placeholder="Laisser vide pour ne pas changer" 
                   class="input-focus-effect w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-primary transition-all">
            
            <!-- Jauge de force (UI uniquement) -->
            <div class="mt-2">
              <div class="strength-meter bg-slate-200 rounded-full overflow-hidden">
                <div id="strength-bar" class="strength-bar w-0 bg-slate-300"></div>
              </div>
              <p id="strength-text" class="text-xs text-slate-500 mt-1"></p>
            </div>
          </div>
          
          <!-- Confirmation mot de passe -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
              <i class="fa-solid fa-check-double mr-2 text-primary"></i>Confirmer le mot de passe
            </label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirmez votre nouveau mot de passe" 
                   class="input-focus-effect w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-primary transition-all">
          </div>
          
          <!-- Rôle -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
              <i class="fa-solid fa-badge mr-2 text-primary"></i>Rôle
            </label>
            <select name="role" class="input-focus-effect w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-900 focus:outline-none focus:border-primary transition-all">
              <option value="admin" <?= (($admin['role'] ?? '') == 'admin') ? 'selected' : '' ?>>Administrateur</option>
              <option value="agent" <?= (($admin['role'] ?? '') == 'agent') ? 'selected' : '' ?>>Agent</option>
            </select>
          </div>
          
          <!-- Statut -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-3">
              <i class="fa-solid fa-toggle-on mr-2 text-primary"></i>Statut du compte
            </label>
            <div class="flex flex-wrap gap-6">
              <label class="flex items-center gap-2 cursor-pointer group">
                <input type="radio" name="status" value="active" 
                       <?= (($admin['status'] ?? 'active') == 'active') ? 'checked' : '' ?>
                       class="radio-status">
                <span class="flex items-center gap-1.5 text-sm font-medium text-slate-700 group-hover:text-primary transition-colors">
                  <i class="fa-solid fa-circle-check text-emerald-500"></i>
                  Actif
                </span>
              </label>
              <label class="flex items-center gap-2 cursor-pointer group">
                <input type="radio" name="status" value="inactive" 
                       <?= (($admin['status'] ?? 'active') == 'inactive') ? 'checked' : '' ?>
                       class="radio-status">
                <span class="flex items-center gap-1.5 text-sm font-medium text-slate-700 group-hover:text-primary transition-colors">
                  <i class="fa-solid fa-circle-exclamation text-red-500"></i>
                  Inactif
                </span>
              </label>
            </div>
            <p class="text-xs text-slate-500 mt-2">Le statut détermine votre accès à la plateforme</p>
          </div>
          
          <button type="submit" 
                  class="action-btn w-full bg-gradient-to-r from-primary to-primaryDark hover:from-primaryDark hover:to-primaryDark text-white font-semibold px-6 py-3 rounded-xl shadow-md shadow-primary/30 transition-all duration-300 hover:shadow-lg hover:shadow-primary/40 hover:scale-[1.02] active:scale-95">
            <div class="flex items-center justify-center gap-2">
              <i class="fa-solid fa-floppy-disk"></i>
              Mettre à jour mon profil
            </div>
          </button>
        </form>
      </div>
    </div>

    <!-- Dernière connexion ET Email vérifié sur la même ligne -->
    <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-5 animate-[fadeIn_0.6s_ease-out]">
      
      <div class="bg-white rounded-xl border-l-4 border-primary p-5 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center">
            <i class="fa-solid fa-clock text-primary text-xl"></i>
          </div>
          <div>
            <p class="text-xs font-semibold uppercase text-slate-500 tracking-wide">Dernière connexion</p>
            <p class="text-sm font-medium text-slate-800 mt-0.5">
                    <?php if (!empty($admin['last_login'])): ?>
            <?php
                $dt = new DateTime($admin['last_login']);
                $formatter = new IntlDateFormatter(
                    'fr_FR',
                    IntlDateFormatter::FULL,
                    IntlDateFormatter::NONE
                );

                $date = mb_convert_case($formatter->format($dt), MB_CASE_TITLE, "UTF-8");
            ?>

            <?= $date . ' à ' . $dt->format('H:i:s') ?>

        <?php else: ?>
            Jamais connecté
        <?php endif; ?>
            </p>
          </div>
        </div>
      </div>
      
      <div class="bg-white rounded-xl border-l-4 border-accent p-5 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 bg-accent/20 rounded-xl flex items-center justify-center">
            <i class="fa-solid fa-envelope-circle-check text-primary text-xl"></i>
          </div>
          <div>
            <p class="text-xs font-semibold uppercase text-slate-500 tracking-wide">Email vérifié</p>
            <p class="text-sm font-medium text-slate-800 mt-0.5">
                <?= !empty($admin['email_verified_at']) 
                    ? 'Vérifié le ' . mb_convert_case(
                        (new IntlDateFormatter(
                            'fr_FR',
                            IntlDateFormatter::FULL,
                            IntlDateFormatter::NONE
                        ))->format(new DateTime($admin['email_verified_at'])),
                        MB_CASE_TITLE,
                        "UTF-8"
                      ) . ' à ' . (new DateTime($admin['email_verified_at']))->format('H:i:s')
                    : 'Non vérifié'
                ?>            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modale de confirmation pour suppression avatar -->
<div id="confirm-modal" class="modal-overlay">
  <div class="modal-content p-6">
    <div class="flex items-center justify-between mb-4">
      <h3 class="font-heading text-xl font-bold text-slate-900">Confirmation</h3>
      <button id="close-confirm-modal" class="text-slate-400 hover:text-slate-600 transition-colors">
        <i class="fa-solid fa-xmark text-xl"></i>
      </button>
    </div>
    <div id="confirm-body" class="text-slate-700 flex items-center gap-2">
      <i class="fa-solid fa-triangle-exclamation text-warning text-xl"></i>
      Êtes-vous sûr de vouloir supprimer votre photo de profil ?
    </div>
    <div class="mt-6 flex gap-3 justify-end">
      <button id="confirm-cancel" class="px-4 py-2 rounded-xl border border-slate-200 text-slate-700 font-medium hover:bg-slate-50 transition-all flex items-center gap-2">
        <i class="fa-solid fa-ban"></i> Annuler
      </button>
      <button id="confirm-ok" class="px-4 py-2 rounded-xl bg-red-600 text-white font-medium hover:bg-red-700 transition-all flex items-center gap-2">
        <i class="fa-solid fa-trash-can"></i> Supprimer
      </button>
    </div>
  </div>
</div>

<!-- JS uniquement pour la jauge de force et la modale de confirmation -->
<script>
  // ==================== JAUGE DE FORCE DU MOT DE PASSE (UI uniquement) ====================
  const passwordInput = document.getElementById('password');
  const confirmInput = document.getElementById('confirm_password');
  const strengthBar = document.getElementById('strength-bar');
  const strengthText = document.getElementById('strength-text');
  
  function checkPasswordStrength(password) {
    let strength = 0;
    let message = '';
    let width = 0;
    let color = '#cbd5e1';
    
    if (password.length === 0) {
      strengthBar.style.width = '0%';
      strengthBar.style.backgroundColor = '#cbd5e1';
      strengthText.innerHTML = '';
      return;
    }
    
    // Critères
    if (password.length >= 8) strength += 1;
    if (password.length >= 12) strength += 1;
    if (/[a-z]/.test(password)) strength += 1;
    if (/[A-Z]/.test(password)) strength += 1;
    if (/\d/.test(password)) strength += 1;
    if (/[^a-zA-Z0-9]/.test(password)) strength += 1;
    
    // Déterminer le niveau
    if (strength <= 2) {
      message = 'Très faible';
      width = 25;
      color = '#ef4444';
    } else if (strength <= 3) {
      message = 'Faible';
      width = 50;
      color = '#f59e0b';
    } else if (strength <= 5) {
      message = 'Moyen';
      width = 75;
      color = '#eab308';
    } else {
      message = 'Fort';
      width = 100;
      color = '#10b981';
    }
    
    strengthBar.style.width = width + '%';
    strengthBar.style.backgroundColor = color;
    strengthText.innerHTML = `<span style="color: ${color}"> Force : ${message}</span>`;
  }
  
  passwordInput.addEventListener('input', () => {
    checkPasswordStrength(passwordInput.value);
  });
  
  // ==================== MODALE DE CONFIRMATION ====================
  const modal = document.getElementById('confirm-modal');
  const closeBtn = document.getElementById('close-confirm-modal');
  const cancelBtn = document.getElementById('confirm-cancel');
  const okBtn = document.getElementById('confirm-ok');
  let pendingAction = null;
  
  function openModal(message, onConfirm) {
    document.getElementById('confirm-body').innerHTML = message;
    modal.classList.add('is-open');
    pendingAction = onConfirm;
  }
  
  function closeModal() {
    modal.classList.remove('is-open');
    pendingAction = null;
  }
  
  if (closeBtn) closeBtn.addEventListener('click', closeModal);
  if (cancelBtn) cancelBtn.addEventListener('click', closeModal);
  if (modal) modal.addEventListener('click', (e) => { if(e.target === modal) closeModal(); });
  if (okBtn) okBtn.addEventListener('click', () => {
    if(pendingAction) pendingAction();
    closeModal();
  });
  
  // Capture du bouton supprimer avatar
  const deleteAvatarBtn = document.getElementById('delete-avatar-btn');
  if (deleteAvatarBtn) {
    deleteAvatarBtn.addEventListener('click', (e) => {
      e.preventDefault();
      openModal('<i class="fa-solid fa-triangle-exclamation text-warning text-xl mr-2"></i> Voulez-vous vraiment supprimer votre photo de profil ?', () => {
        const form = document.getElementById('avatar-form');
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'action';
        input.value = 'delete_avatar';
        form.appendChild(input);
        form.submit();
      });
    });
  }
</script>
</body>
</html>