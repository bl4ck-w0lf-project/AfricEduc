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
            primary: "#0F9D72",
            primaryDark: "#0B7A58",
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
      border-color: #0F9D72;
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
      border-color: #0F9D72;
      background-color: #0F9D72;
      box-shadow: inset 0 0 0 3px white;
    }
    .radio-status:focus {
      outline: none;
      ring: 2px solid #0F9D72;
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
    
/* ===== HEADER BANNER ===== */
.header-banner {
  background: linear-gradient(135deg, #0F9D72 0%, #0B7A58 100%);
  border-radius: 1.5rem;
  padding: 1.8rem 2.5rem;
  color: white;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 1.5rem;
  box-shadow: 0 8px 32px rgba(15, 157, 114, 0.30);
  border: 1px solid rgba(255, 255, 255, 0.10);
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
  
  
}

/* Effets de lumière */
.header-banner::before {
  content: '';
  position: absolute;
  top: -50%;
  right: -20%;
  width: 400px;
  height: 400px;
  background: radial-gradient(circle, rgba(255, 255, 255, 0.06) 0%, transparent 70%);
  border-radius: 50%;
  pointer-events: none;
}

.header-banner::after {
  content: '';
  position: absolute;
  bottom: -30%;
  left: -10%;
  width: 300px;
  height: 300px;
  background: radial-gradient(circle, rgba(255, 255, 255, 0.04) 0%, transparent 70%);
  border-radius: 50%;
  pointer-events: none;
}

.header-banner:hover {
  box-shadow: 0 12px 40px rgba(15, 157, 114, 0.40);
  transform: translateY(-2px);
}

/* ===== GAUCHE ===== */
.header-left {
  flex: 1 1 300px;
  position: relative;
  z-index: 1;
}

.title-wrapper {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.icon-circle {
  width: 52px;
  height: 52px;
  background: rgba(255, 255, 255, 0.15);
  backdrop-filter: blur(4px);
  border-radius: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  border: 1px solid rgba(255, 255, 255, 0.15);
  flex-shrink: 0;
  transition: all 0.3s ease;
}

.icon-circle:hover {
  background: rgba(255, 255, 255, 0.25);
  transform: scale(1.05) rotate(-3deg);
}

.header-banner h2 {
  font-weight: 700;
  font-size: 1.6rem;
  margin: 0;
  letter-spacing: -0.5px;
}

.header-banner p {
  opacity: 0.85;
  font-size: 0.95rem;
  margin: 0;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

/* ===== DROITE ===== */
.header-right {
  display: flex;
  align-items: center;
  gap: 1.2rem;
  flex-wrap: wrap;
  position: relative;
  z-index: 1;
}

/* Badge année */
.badge-year {
  background: rgba(255, 255, 255, 0.20) !important;
  border: 1px solid rgba(255, 255, 255, 0.20) !important;
  font-weight: 600 !important;
  padding: 0.5rem 1.4rem !important;
  font-size: 0.85rem !important;
  border-radius: 9999px;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  color: white;
  white-space: nowrap;
}

/* ===== CARTE UTILISATEUR ===== */
.user-info-card {
  background: rgba(255, 255, 255, 0.08);
  backdrop-filter: blur(8px);
  border-radius: 1rem;
  padding: 0.6rem 1.2rem 0.6rem 0.8rem;
  border: 1px solid rgba(255, 255, 255, 0.08);
  min-width: 200px;
  transition: all 0.3s ease;
}

.user-info-card:hover {
  background: rgba(255, 255, 255, 0.14);
  border-color: rgba(255, 255, 255, 0.15);
}

.user-info-item {
  display: flex;
  align-items: center;
  gap: 0.8rem;
}

/* Avatar */
.user-avatar {
  width: 40px;
  height: 40px;
  background: rgba(255, 255, 255, 0.15);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1rem;
  color: white;
  flex-shrink: 0;
  border: 2px solid rgba(255, 255, 255, 0.10);
}

/* Détails utilisateur */
.user-details {
  flex: 1;
  min-width: 0;
}

.user-name {
  font-size: 0.875rem;
  font-weight: 600;
  color: white;
  margin: 0;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.user-role {
  font-size: 0.75rem;
  margin: 0;
  display: flex;
  align-items: center;
  gap: 0.25rem;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.user-role.text-emerald-200 {
  color: #a7f3d0;
}

.user-role.text-blue-200 {
  color: #bfdbfe;
}

.user-role.text-emerald-200 {
  color: #fde68a;
}

.user-role.text-rose-200 {
  color: #fecdd3;
}

.user-school {
  font-size: 0.625rem;
  color: rgba(255, 255, 255, 0.6);
  margin: 0;
  display: flex;
  align-items: center;
  gap: 0.25rem;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.user-address {
  font-size: 0.625rem;
  color: rgba(255, 255, 255, 0.5);
  margin: 0;
  display: flex;
  align-items: center;
  gap: 0.25rem;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 992px) {
  .header-banner {
    flex-direction: column;
    align-items: stretch;
    padding: 1.5rem 1.8rem;
  }

  .header-right {
    justify-content: space-between;
    width: 100%;
  }

  .user-info-card {
    flex: 1;
    min-width: unset;
  }
}

@media (max-width: 768px) {
  .header-banner {
    padding: 1.2rem 1.2rem;
    border-radius: 1rem;
  }

  .title-wrapper {
    flex-direction: column;
    align-items: flex-start;
    gap: 0.8rem;
  }

  .icon-circle {
    width: 44px;
    height: 44px;
    font-size: 1.2rem;
  }

  .header-banner h2 {
    font-size: 1.3rem;
  }

  .header-banner p {
    font-size: 0.85rem;
  }

  .header-right {
    flex-direction: column;
    align-items: stretch;
    gap: 0.8rem;
  }

  .badge-year {
    text-align: center;
    justify-content: center;
  }

  .user-info-card {
    padding: 0.6rem 1rem;
  }

  .user-info-item {
    gap: 0.6rem;
  }

  .user-avatar {
    width: 36px;
    height: 36px;
    font-size: 0.85rem;
  }

  .user-name {
    font-size: 0.8rem;
  }

  .user-role {
    font-size: 0.7rem;
  }

  .user-school,
  .user-address {
    font-size: 0.6rem;
  }
}

@media (max-width: 480px) {
  .header-banner h2 {
    font-size: 1.1rem;
  }

  .header-banner p {
    font-size: 0.78rem;
  }

  .icon-circle {
    width: 38px;
    height: 38px;
    font-size: 1rem;
    border-radius: 10px;
  }

  .user-info-card {
    padding: 0.5rem 0.8rem;
  }

  .user-avatar {
    width: 32px;
    height: 32px;
    font-size: 0.75rem;
  }
}
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 text-slate-800 antialiased">

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 lg:py-10">

 <?php include __DIR__ . '/../components/sidebar.php'; ?>
 

<!-- HEADER CORRIGÉ - À PLACER APRÈS <body> -->
<div class="header-banner mb-6 mt-10 max-w-7xl ">
  <!-- Partie gauche : Titre + description -->
          <div class="header-left">
            <div class="title-wrapper">
              <div>
                <h2>Identité & Contact</h2>
                <p>
                  Gérez les informations de votre établissement scolaire
                </p>
              </div>
            </div>
          </div>

  <!-- Partie droite : Infos utilisateur -->
            <div class="header-right">
              <span class="badge badge-year">
                <i class="fas fa-calendar-alt"></i> Année <?= date('Y') ?>
              </span>

              <div class="user-info-card">
                <!-- Nom utilisateur -->
                <div class="user-info-item">
                  <div class="user-avatar">
                    <i class="fas fa-user"></i>
                  </div>
                  <div class="user-details">
                    <p class="user-name"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Utilisateur') ?></p>
                    <p class="user-role text-emerald-200">
                      <i class="fas fa-user-graduate text-[10px]"></i>
                      <?= htmlspecialchars($_SESSION['user_role'] ?? 'Administrateur') ?>
                    </p>
                    <!-- <p class="user-school">
                      <i class="fa-solid fa-school text-[10px]"></i>
                      <?= htmlspecialchars($_SESSION['school_name'] ?? 'Mon École') ?>
                    </p>
                    <p class="user-address">
                      <i class="fas fa-map-pin text-[10px]"></i>
                      <?= htmlspecialchars($_SESSION['school_address'] ?? 'Cotonou, Bénin') ?>
                    </p> -->
                  </div>
                </div>
              </div>
            </div>
        </div>

  
  <!-- En-tête -->


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
            <img style="width:100%; height:100%;" src="/AfricEduc/public/<?= htmlspecialchars($school['logo']) ?>" class="w-full h-full object-cover" alt="Logo">
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