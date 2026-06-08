<!-- views/identite.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Identité & Contact | EduManager</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: "#7300e9",
            primaryDark: "#5c00bd",
            accent: "#99fbe3",
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
    
    /* Style pour les boutons radio personnalisés */
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
      position: sticky;
      top: 0;
      z-index: 30;
      background-color: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(12px);
      border-bottom: 1px solid #e2e8f0;
    }
  </style>
</head>
<body>
<!-- HEADER CORRIGÉ - À PLACER APRÈS <body> -->
<header class="app-header">
  <div class="flex h-16 items-center justify-between gap-4 px-4 sm:px-6 lg:pl-64">
    <!-- lg:pl-64 au lieu de ml-14 lg:ml-0 pour que le header commence APRÈS la sidebar -->
    
    <div class="flex items-center gap-3">
      <div>
        <p class="font-heading text-sm font-semibold text-primary sm:text-base" id="school-name-header">
          <?= htmlspecialchars($_SESSION['school_name'] ?? 'École inconnue') ?>
        </p>
        <p class="text-xs text-slate-500" id="school-location">
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
          $words = explode(' ', trim($userName));
          $initials = '';
          foreach ($words as $w) {
              $initials .= strtoupper($w[0] ?? '');
          }
          $initials = substr($initials, 0, 2);
        ?>
        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-primary to-primaryDark text-sm font-bold text-white shadow-md">
          <?= $initials ?>
        </span>
        <span class="hidden text-left text-sm sm:block">
          <span class="block font-medium text-slate-900"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Utilisateur') ?></span>
          <span class="text-xs text-slate-500"><?= htmlspecialchars($_SESSION['user_role'] ?? 'Rôle') ?></span>
        </span>
      </button>
    </div>
  </div>
</header>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 lg:py-10">

  
  

 <?php include __DIR__ . '/../components/sidebar.php'; ?>
 

  
  <!-- En-tête -->
  <div class="mb-8 animate-[slideUp_0.4s_ease-out]">
    <div class="flex items-center gap-3 mb-2">
      <div class="w-1 h-8 bg-primary rounded-full"></div>
      <h1 class="font-heading text-2xl sm:text-3xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">
        Identité & Contact
      </h1>
    </div>
    <p class="text-slate-600 text-sm sm:text-base pl-4">Gérez les informations de votre établissement scolaire</p>
  </div>

  <!-- Messages PHP -->
  <?php if (isset($_SESSION['toast_message'])): ?>
    <div class="fixed bottom-6 right-6 z-50 animate-[fadeIn_0.3s_ease-out]" id="php-toast">
      <div class="rounded-2xl px-5 py-3 shadow-lg flex items-center gap-2 <?= isset($_SESSION['toast_error']) && $_SESSION['toast_error'] ? 'bg-red-500' : 'bg-emerald-500' ?> text-white">
        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <?php if (isset($_SESSION['toast_error']) && $_SESSION['toast_error']): ?>
            <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          <?php else: ?>
            <path d="M20 6L9 17l-5-5"/>
          <?php endif; ?>
        </svg>
        <span class="text-sm font-medium"><?= htmlspecialchars($_SESSION['toast_message']) ?></span>
      </div>
    </div>
    <script>setTimeout(() => { const t = document.getElementById('php-toast'); if(t) t.remove(); }, 3000);</script>
    <?php unset($_SESSION['toast_message'], $_SESSION['toast_error']); ?>
  <?php endif; ?>

  <!-- Grille principale -->
  <div class="grid gap-6 lg:gap-8 lg:grid-cols-3 animate-[fadeIn_0.5s_ease-out]">
    
    <!-- Formulaire coordonnées -->
    <div class="lg:col-span-2 settings-card bg-white rounded-2xl border border-slate-200/80 shadow-lg shadow-slate-200/50 p-6 sm:p-8">
      <div class="flex items-center gap-2 mb-6">
        <svg class="w-6 h-6 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path d="M3.75 21h16.5M4.5 3h15A1.5 1.5 0 0 1 21 4.5v13.5A1.5 1.5 0 0 1 19.5 19.5h-15A1.5 1.5 0 0 1 4.5 18v-13.5A1.5 1.5 0 0 1 4.5 3z"/>
          <path d="M8 7.5h8M8 12h8M8 16.5h5"/>
        </svg>
        <h2 class="font-heading text-xl font-bold text-slate-900">Coordonnées</h2>
      </div>
      
      <form method="POST" action="" enctype="multipart/form-data" class="space-y-5 flex-1">
        <input type="hidden" name="action" value="update_infos">
        
        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">Nom de l'école</label>
          <input type="text" name="name" value="<?= htmlspecialchars($school['name'] ?? '') ?>" 
                 placeholder="Ex: Collège Saint-Michel" 
                 class="input-focus-effect w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-primary transition-all">
        </div>
        
        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">Adresse complète</label>
          <input type="text" name="address" value="<?= htmlspecialchars($school['address'] ?? '') ?>" 
                 placeholder="Ex: 12 Avenue Jean-Paul II" 
                 class="input-focus-effect w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-primary transition-all">
        </div>
        
        <!-- Ligne téléphone + email côte à côte -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Téléphone</label>
            <input type="tel" name="phone" value="<?= htmlspecialchars($school['phone'] ?? '') ?>" 
                   placeholder="Ex: +229 21 30 00 00" 
                   class="input-focus-effect w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-primary transition-all">
          </div>
          
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Email de contact</label>
            <input type="email" name="email" value="<?= htmlspecialchars($school['email'] ?? '') ?>" 
                   placeholder="Ex: contact@ecole.edu" 
                   class="input-focus-effect w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-primary transition-all">
          </div>
        </div>
        
        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">Type d'établissement</label>
          <select name="subtype" class="input-focus-effect w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-900 focus:outline-none focus:border-primary transition-all">
            <option value="public" <?= (($school['subtype'] ?? '') == 'public') ? 'selected' : '' ?>>Public</option>
            <option value="prive" <?= (($school['subtype'] ?? '') == 'prive') ? 'selected' : '' ?>>Privé</option>
          </select>
        </div>
        
        <!-- Statut du compte - Boutons radio stylisés -->
        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-3">Statut du compte</label>
          <div class="flex flex-wrap gap-6">
            <label class="flex items-center gap-2 cursor-pointer group">
              <input type="radio" name="status" value="active" 
                     <?= (($school['status'] ?? 'active') == 'active') ? 'checked' : '' ?>
                     class="radio-status">
              <span class="flex items-center gap-1.5 text-sm font-medium text-slate-700 group-hover:text-primary transition-colors">
                Actif
              </span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer group">
              <input type="radio" name="status" value="inactive" 
                     <?= (($school['status'] ?? 'active') == 'inactive') ? 'checked' : '' ?>
                     class="radio-status">
              <span class="flex items-center gap-1.5 text-sm font-medium text-slate-700 group-hover:text-primary transition-colors">
                Inactif
              </span>
            </label>
          </div>
          <p class="text-xs text-slate-500 mt-2">Le statut détermine l'accès à la plateforme</p>
        </div>
        
        <button type="submit" 
                class="action-btn w-full sm:w-auto bg-gradient-to-r from-primary to-primaryDark hover:from-primaryDark hover:to-primaryDark text-white font-semibold px-6 py-3 rounded-xl shadow-md shadow-primary/30 transition-all duration-300 hover:shadow-lg hover:shadow-primary/40 hover:scale-[1.02] active:scale-95">
          <div class="flex items-center justify-center gap-2">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
              <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            Enregistrer les modifications
          </div>
        </button>
      </form>
    </div>

    <!-- Logo & identité - MÊME HAUTEUR que coordonnées -->
    <div class="w-[500px] settings-card bg-white rounded-2xl border border-slate-200/80 shadow-lg shadow-slate-200/50 p-6 sm:p-8">
      <div class="flex items-center gap-2 mb-6">
        <svg class="w-6 h-6 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path d="M4 19.5V8.25L12 4l8 4.25V19.5"/>
          <path d="M9 19.5V12h6v7.5"/>
        </svg>
        <h2 class="font-heading text-xl font-bold text-slate-900">Logo & identité</h2>
      </div>
      
      <form method="POST" action="" enctype="multipart/form-data" class="flex flex-col flex-1">
        <!-- Logo preview - hauteur automatique qui s'adapte -->
        <div id="logo-preview" class="mb-6 w-full rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 border-2 border-dashed border-slate-300 flex items-center justify-center overflow-hidden shadow-inner" style="aspect-ratio: 16/9;">
          <?php if (!empty($school['logo'])): ?>
            <img src="<?= htmlspecialchars($school['logo']) ?>" class="w-full h-full object-cover" alt="Logo">
          <?php else: ?>
            <svg class="w-24 h-24 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
              <path d="M4 19.5V8.25L12 4l8 4.25V19.5"/>
              <path d="M9 19.5V12h6v7.5"/>
            </svg>
          <?php endif; ?>
        </div>
        
        <!-- Boutons sur la même ligne -->
        <div class="flex flex-col sm:flex-row gap-3 justify-center w-full mt-4">
          <label class="action-btn cursor-pointer bg-white border-2 border-primary text-primary hover:bg-primary hover:text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300 flex items-center justify-center gap-2 flex-1">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
              <circle cx="12" cy="13" r="4"/>
            </svg>
            Changer le logo
            <input type="file" name="logo" accept="image/png, image/jpeg, image/jpg" class="hidden" onchange="this.form.submit()">
          </label>
          
          <!-- Bouton supprimer le logo -->
          <button type="submit" name="action" value="delete_logo" 
                  class="action-btn bg-red-50 border border-red-200 text-red-600 hover:bg-red-100 hover:border-red-300 px-5 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300 flex items-center justify-center gap-2 flex-1">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
            </svg>
            Supprimer le logo
          </button>
        </div>
        
        <p class="mt-4 text-xs text-slate-500 text-center">Formats acceptés : PNG, JPG (max 2 Mo)</p>
        
        <div class="mt-6 p-4 bg-gradient-to-r from-primary/5 to-accent/5 rounded-xl">
          <div class="flex gap-2">
            <svg class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-xs text-slate-600">Les informations de contact seront affichées sur les bulletins, certificats et documents officiels de l'école.</p>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Cartes récapitulatives -->
  <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-5 animate-[fadeIn_0.6s_ease-out]">
    <div class="bg-white rounded-xl border-l-4 border-primary p-5 shadow-sm hover:shadow-md transition-shadow">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center">
          <svg class="w-5 h-5 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path d="M3 9l9-6 9 6M5 9v9a2 2 0 002 2h10a2 2 0 002-2V9"/>
          </svg>
        </div>
        <div>
          <p class="text-xs font-semibold uppercase text-slate-500 tracking-wide">Établissement</p>
          <p class="text-sm font-medium text-slate-800 mt-0.5">
            <?= htmlspecialchars($school['name'] ?? '—') ?>
            <span class="text-xs text-slate-500 ml-2">(<?= htmlspecialchars($school['subtype'] ?? '—') ?>)</span>
          </p>
          <p class="text-xs text-slate-500 mt-1"><?= htmlspecialchars($school['address'] ?? '—') ?></p>
        </div>
      </div>
    </div>
    
    <div class="bg-white rounded-xl border-l-4 border-accent p-5 shadow-sm hover:shadow-md transition-shadow">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 bg-accent/20 rounded-xl flex items-center justify-center">
          <svg class="w-5 h-5 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
          </svg>
        </div>
        <div>
          <p class="text-xs font-semibold uppercase text-slate-500 tracking-wide">Contact</p>
          <p class="text-sm font-medium text-slate-800 mt-0.5">
            <?= htmlspecialchars($school['phone'] ?? '—') ?>
          </p>
          <p class="text-xs text-slate-500 mt-1"><?= htmlspecialchars($school['email'] ?? '—') ?></p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modale de confirmation pour suppression logo -->
<div id="confirm-modal" class="modal-overlay">
  <div class="modal-content p-6">
    <div class="flex items-center justify-between mb-4">
      <h3 class="font-heading text-xl font-bold text-slate-900">Confirmation</h3>
      <button id="close-confirm-modal" class="text-slate-400 hover:text-slate-600 transition-colors">
        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
    </div>
    <div id="confirm-body" class="text-slate-700">Êtes-vous sûr de vouloir supprimer le logo ?</div>
    <div class="mt-6 flex gap-3 justify-end">
      <button id="confirm-cancel" class="px-4 py-2 rounded-xl border border-slate-200 text-slate-700 font-medium hover:bg-slate-50 transition-all">Annuler</button>
      <button id="confirm-ok" class="px-4 py-2 rounded-xl bg-red-600 text-white font-medium hover:bg-red-700 transition-all">Supprimer</button>
    </div>
  </div>
</div>

<script>
  // Gestion de la modale de confirmation
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
  
  // Capture du bouton supprimer logo pour ouvrir la modale
  const deleteLogoBtn = document.querySelector('button[value="delete_logo"]');
  if (deleteLogoBtn) {
    deleteLogoBtn.addEventListener('click', (e) => {
      e.preventDefault();
      openModal('Voulez-vous vraiment supprimer le logo ?', () => {
        const form = deleteLogoBtn.closest('form');
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'action';
        input.value = 'delete_logo';
        form.appendChild(input);
        form.submit();
      });
    });
  }
</script>
</body>
</html>