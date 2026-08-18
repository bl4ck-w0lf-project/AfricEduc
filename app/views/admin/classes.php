<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Classes & Groupes | AfricEduc</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: "#0F9D72",
            primaryDark: "#0B7A58",
            primaryLight: "#E6F7F0",
            accent: "#99fbe3",
            danger: "#ef4444",
            warning: "#f59e0b",
            success: "#10b981"
          },
          fontFamily: { heading: ["Quicksand", "sans-serif"], body: ["Outfit", "sans-serif"] },
          animation: { 'fade-in': 'fadeIn 0.3s ease-in-out' },
          keyframes: { fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } } }
        }
      }
    };
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: "Outfit", sans-serif; background: #f8fafc; }
    h1, h2, h3, .font-heading { font-family: "Quicksand", sans-serif; }
    .sidebar-link { transition: all 0.2s ease; }
    .sidebar-link:hover { background-color: rgba(255,255,255,0.1); transform: translateX(4px); }
    .sidebar-link.active { background-color: rgba(15,157,114,0.2); color: #0F9D72; border-left: 3px solid #0F9D72; }
    .submenu { max-height: 0; overflow: hidden; transition: max-height 0.35s ease; }
    .submenu.open { max-height: 320px; }
    #sidebar-overlay { pointer-events: none; opacity: 0; transition: opacity 0.2s ease; }
    #sidebar-overlay.is-open { pointer-events: auto; opacity: 1; }
    .kpi-card { transition: all 0.2s ease; }
    .kpi-card:hover { transform: translateY(-2px); box-shadow: 0 12px 24px -12px rgba(0,0,0,0.15); }
    .action-button { transition: all 0.2s ease; }
    .action-button:hover { transform: scale(1.05); }
    .modal-overlay { pointer-events: none; opacity: 0; transition: opacity 0.2s ease; position: fixed; inset: 0; z-index: 9999; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; }
    .modal-overlay.is-open { pointer-events: auto; opacity: 1; }
    .modal-content { transform: scale(0.95); transition: transform 0.2s ease; max-width: 90%; width: 32rem; background: white; border-radius: 1rem; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); }
    .modal-overlay.is-open .modal-content { transform: scale(1); }
    .toast { position: fixed; bottom: 20px; right: 20px; background: #1e293b; color: white; padding: 12px 20px; border-radius: 12px; font-size: 0.875rem; z-index: 10000; opacity: 0; transition: opacity 0.3s; pointer-events: none; }
    .toast.show { opacity: 1; }
    .confirm-modal .modal-content { max-width: 24rem; }
    .table-actions .btn-icon { width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; transition: all 0.15s; }
    .table-actions .btn-icon:hover { transform: scale(1.08); }
    .modal-content { max-width: 90%; width: 56rem; max-height: 90vh; overflow-y: auto; }
    @media (min-width: 1024px) { .modal-content { width: 64rem; } }

    /* Pagination styles */
    .pagination .page-item { display: inline-flex; align-items: center; justify-content: center; min-width: 2.5rem; height: 2.5rem; border-radius: 0.75rem; font-size: 0.875rem; font-weight: 500; transition: all 0.15s; cursor: pointer; }
    .pagination .page-item.active { background: #0F9D72; color: white; }
    .pagination .page-item:not(.active):hover { background: #f1f5f9; }
    .pagination .page-item.disabled { opacity: 0.4; cursor: not-allowed; pointer-events: none; }

    /* Badge de statut / occupation */
    .occupancy-badge { padding: 0.2rem 0.6rem; border-radius: 9999px; font-size: 0.65rem; font-weight: 600; }
    .occupancy-badge.low { background: #dcfce7; color: #166534; }
    .occupancy-badge.medium { background: #fef9c3; color: #854d0e; }
    .occupancy-badge.high { background: #fee2e2; color: #991b1b; }

   
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
    /* Cartes KPI avec icônes colorées */
    .kpi-card { background: white; border-radius: 1.25rem; padding: 1.25rem; border: 1px solid #f1f5f9; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
    .kpi-card .icon-wrapper { width: 2.75rem; height: 2.75rem; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; }
    .kpi-card .icon-wrapper.green { background: #E6F7F0; color: #0F9D72; }
    .kpi-card .icon-wrapper.blue { background: #eff6ff; color: #2563eb; }
    .kpi-card .icon-wrapper.emerald { background: #fffbeb; color: #d97706; }
    .kpi-card .icon-wrapper.emerald { background: #f5f3ff; color: #7c3aed; }

    /* Boutons de pagination stylisés */
    .pagination-btn {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.6rem 1.2rem;
      border-radius: 0.75rem;
      font-weight: 500;
      font-size: 0.875rem;
      transition: all 0.2s ease;
      background: white;
      border: 1px solid #e2e8f0;
      color: #334155;
      cursor: pointer;
    }
    .pagination-btn:hover:not(.disabled) {
      background: #f1f5f9;
      border-color: #0F9D72;
      color: #0F9D72;
    }
    .pagination-btn.disabled {
      opacity: 0.4;
      cursor: not-allowed;
      pointer-events: none;
    }
    .pagination-btn i {
      font-size: 0.75rem;
    }
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 text-slate-800 antialiased">

  <!-- Sidebar -->
  <?php include __DIR__ . '/../components/sidebar.php'; ?>

  <!-- Main content -->
  <div class="min-h-screen lg:pl-[260px]">
    <main class="px-4 py-4 sm:px-6 lg:px-8">

      <!-- BANNIÈRE EN-TÊTE -->
     
        <div class="header-banner mb-6 mt-10">
  <!-- Partie gauche : Titre + description -->
          <div class="header-left">
            <div class="title-wrapper">
              <div>
                <h2>Gestion des Classes</h2>
                <p>
                  Organiser, créer et gérer les classes du collège
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

      <!-- STATISTIQUES -->
      <section class="mb-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
          <div class="kpi-card">
            <div class="flex items-center justify-between mb-2">
              <div class="icon-wrapper green">
                <i class="fas fa-chalkboard text-lg"></i>
              </div>
              <span class="text-[10px] font-semibold text-primary bg-primary/10 px-2 py-1 rounded-full">TOTAL</span>
            </div>
            <p class="text-2xl font-bold text-[#0F172A]" id="total-classes"><?= $stats['total_classes'] ?? 0 ?></p>
            <p class="text-xs text-gray-400 mt-1">Classes totales</p>
          </div>
          <div class="kpi-card">
            <div class="flex items-center justify-between mb-2">
              <div class="icon-wrapper blue">
                <i class="fas fa-user-graduate text-lg"></i>
              </div>
              <span class="text-[10px] font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-full">ÉLÈVES</span>
            </div>
            <p class="text-2xl font-bold text-[#0F172A]" id="total-students"><?= $stats['total_students'] ?? 0 ?></p>
            <p class="text-xs text-gray-400 mt-1">Total élèves</p>
          </div>
          <div class="kpi-card">
            <div class="flex items-center justify-between mb-2">
              <div class="icon-wrapper text-emerald-400 bg-emerald-400/10">
                <i class="fas fa-chart-line text-lg"></i>
              </div>
              <span class="text-[10px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">CAPACITÉ</span>
            </div>
            <p class="text-2xl font-bold text-[#0F172A]" id="total-capacity"><?= $stats['total_capacity'] ?? 0 ?></p>
            <p class="text-xs text-gray-400 mt-1">Capacité totale</p>
          </div>
          <div class="kpi-card">
            <div class="flex items-center justify-between mb-2">
              <div class="icon-wrapper text-emerald-400 bg-emerald-400/10">
                <i class="fas fa-clock text-lg"></i>
              </div>
              <span class="text-[10px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">ANNÉE</span>
            </div>
            <p class="text-2xl font-bold text-[#0F172A]"><?= date('Y') ?></p>
            <p class="text-xs text-gray-400 mt-1">Année scolaire</p>
          </div>
        </div>
      </section>

      <!-- LISTE DES CLASSES AVEC PAGINATION JS -->
      <section>
        <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
          <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider flex items-center gap-2">
            <i class="fas fa-list text-primary"></i> · Liste des classes
          </h3>
          <button id="btn-add-class" class="action-button inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primaryDark transition">
            <i class="fas fa-plus"></i> Nouvelle classe
          </button>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-md">
          <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
              <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr>
                  <th class="px-5 py-3 sm:px-6">Classe</th>
                  <th class="px-3 py-3">Niveau</th>
                  <th class="px-3 py-3">Série</th>
                  <th class="px-3 py-3">Élèves</th>
                  <th class="px-3 py-3">Capacité</th>
                  <th class="px-3 py-3">Occupation</th>
                  <th class="px-5 py-3 text-right">Actions</th>
                </tr>
              </thead>
              <tbody id="classes-table-body" class="divide-y divide-slate-100">
                <!-- Les lignes seront générées par JS -->
              </tbody>
            </table>
          </div>
        </div>

        <!-- PAGINATION JS -->
        <div id="pagination-container" class="flex items-center justify-between flex-wrap gap-4 mt-6">
          <div class="flex items-center gap-3">
            <button id="prev-page" class="pagination-btn disabled">
              <i class="fas fa-chevron-left"></i> Précédent
            </button>
            <button id="next-page" class="pagination-btn disabled">
              Suivant <i class="fas fa-chevron-right"></i>
            </button>
          </div>
          <div class="text-sm text-slate-500">
            <span id="page-indicator" class="text-sm font-medium text-slate-700">
              Page 1 sur 1
            </span>
          </div>
        </div>
      </section>

      <footer class="mt-12 pb-8 text-center text-xs text-slate-400">
        AfricEduc — <span id="footer-school"><?= $_SESSION['school_name'] ?? 'Mon École' ?></span> · Dernière mise à jour : <span id="last-update"></span>
      </footer>
    </main>
  </div>

  <!-- MODAL : AJOUTER / MODIFIER CLASSE -->
  <div id="classFormModal" class="modal-overlay">
    <div class="modal-content bg-white rounded-2xl shadow-2xl p-6 max-w-2xl">
      <div class="flex justify-between items-center mb-4 border-b border-gray-100 pb-4">
        <div>
          <h3 class="font-heading text-xl font-bold text-slate-900" id="formModalTitle">
            <i class="fas fa-plus-circle text-primary mr-2"></i>Nouvelle classe
          </h3>
          <p class="text-xs text-gray-400">Créer ou modifier une classe</p>
        </div>
        <button id="close-form-modal" class="text-slate-400 hover:text-slate-600 w-9 h-9 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <form id="classForm" class="space-y-4">
        <input type="hidden" id="class-id" value="">
        
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">Niveau <span class="text-red-500">*</span></label>
          <select id="level-id" class="w-full rounded-xl border border-slate-200 px-3 py-2.5 bg-gray-50 focus:outline-none focus:border-primary focus:bg-white">
            <option value="">Sélectionner un niveau</option>
            <?php foreach ($levels as $level): ?>
              <option value="<?= $level['id'] ?>"><?= htmlspecialchars($level['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">Série (optionnel)</label>
          <select id="serie-id" class="w-full rounded-xl border border-slate-200 px-3 py-2.5 bg-gray-50 focus:outline-none focus:border-primary focus:bg-white">
            <option value="">Aucune série</option>
            <?php foreach ($series as $serie): ?>
              <option value="<?= $serie['id'] ?>">Série <?= htmlspecialchars($serie['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">Groupe (pour collège)</label>
          <input type="text" id="group-name" class="w-full rounded-xl border border-slate-200 px-3 py-2.5 bg-gray-50 focus:outline-none focus:border-primary focus:bg-white" placeholder="Ex: A, B, C, D">
        </div>
        
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">Capacité maximale <span class="text-red-500">*</span></label>
          <input type="number" id="max-students" value="50" class="w-full rounded-xl border border-slate-200 px-3 py-2.5 bg-gray-50 focus:outline-none focus:border-primary focus:bg-white" min="1">
        </div>
        
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">Année scolaire <span class="text-red-500">*</span></label>
          <input type="number" id="academic-year" value="<?= date('Y') ?>" class="w-full rounded-xl border border-slate-200 px-3 py-2.5 bg-gray-50 focus:outline-none focus:border-primary focus:bg-white">
        </div>
        
        <div class="flex gap-3 pt-4 border-t border-gray-100">
          <button type="submit" class="flex-1 rounded-xl bg-primary px-4 py-2.5 text-sm font-semibold text-white hover:bg-primaryDark transition">
            <i class="fas fa-save mr-2"></i>Enregistrer
          </button>
          <button type="button" id="form-cancel" class="flex-1 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
            Annuler
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- MODAL : DÉTAIL CLASSE -->
  <div id="detailModal" class="modal-overlay">
    <div class="modal-content bg-white rounded-2xl shadow-2xl p-8 max-w-5xl w-full">
      <div class="flex justify-between items-center mb-6">
        <div>
          <h3 class="font-heading text-xl font-bold text-slate-900 flex items-center gap-2">
            <span class="text-primary">#</span> Détails de la classe
          </h3>
          <p class="text-xs text-gray-400 mt-0.5">Informations générales et matières associées</p>
        </div>
        <button id="close-detail-modal" class="text-gray-400 hover:text-gray-600 w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center transition">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div id="detail-body" class="space-y-6">
        <div class="text-center py-12 text-gray-400">
          <i class="fas fa-spinner fa-spin text-2xl text-primary"></i>
          <p class="mt-2 text-sm">Chargement...</p>
        </div>
      </div>
      <div class="mt-6 flex justify-end border-t border-gray-100 pt-4">
        <button id="detail-close-btn" class="px-6 py-2.5 rounded-xl bg-primary text-white text-sm font-medium hover:bg-primaryDark transition shadow-sm">
          <i class="fas fa-times mr-2"></i>Fermer
        </button>
      </div>
    </div>
  </div>

  <!-- MODAL : CONFIRMATION SUPPRESSION -->
  <div id="deleteModal" class="modal-overlay">
    <div class="modal-content bg-white rounded-2xl shadow-2xl p-6 max-w-md">
      <div class="flex justify-between items-center mb-4 border-b border-gray-100 pb-4">
        <div>
          <h3 class="font-heading text-xl font-bold text-slate-900 flex items-center gap-2">
            <i class="fas fa-trash text-red-500"></i> Supprimer la classe
          </h3>
          <p class="text-xs text-gray-400">Action irréversible</p>
        </div>
        <button id="close-delete-modal" class="text-slate-400 hover:text-slate-600 w-9 h-9 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="space-y-4">
        <div class="bg-red-50 rounded-xl p-4 border border-red-100">
          <p class="text-sm text-red-700">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            <strong>Attention :</strong> Cette action est irréversible. Toutes les données associées à cette classe seront supprimées.
          </p>
        </div>
        <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
          <p class="text-xs text-gray-500 mb-1">Classe à supprimer</p>
          <p class="text-sm font-bold text-[#0F172A]" id="delete-class-name">---</p>
        </div>
        <div>
          <label class="text-xs font-semibold text-gray-600 mb-1 block">Tapez "SUPPRIMER" pour confirmer</label>
          <input type="text" id="delete-confirm-input" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:border-red-500" placeholder="SUPPRIMER">
        </div>
      </div>
      <div class="mt-6 flex gap-3 justify-end border-t border-gray-100 pt-4">
        <button id="delete-cancel" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700">Annuler</button>
        <button id="delete-confirm" class="rounded-xl bg-red-500 px-4 py-2 text-sm font-semibold text-white opacity-50 cursor-not-allowed" disabled>
          <i class="fas fa-trash mr-2"></i>Supprimer
        </button>
      </div>
    </div>
  </div>

  <div id="toast" class="toast"></div>

  <script>
    (function() {
      const baseUrl = '/AfricEduc/public/index.php?url=classes';
      const PER_PAGE = 10; // Changé de 15 à 10
      
      // Récupération des données PHP dans une variable JS
      const classesData = <?= json_encode($classes ?? []) ?>;
      
      function showToast(msg, type = 'success') {
        const toast = document.getElementById('toast');
        toast.textContent = msg;
        toast.style.backgroundColor = type === 'error' ? '#ef4444' : '#10b981';
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3000);
      }

      // ─── Pagination JS ───
      let currentPage = 1;
      const totalClasses = classesData.length;
      const totalPages = Math.max(1, Math.ceil(totalClasses / PER_PAGE));
      
      const tableBody = document.getElementById('classes-table-body');
      const prevBtn = document.getElementById('prev-page');
      const nextBtn = document.getElementById('next-page');
      const pageIndicator = document.getElementById('page-indicator');

      function renderPage(page) {
        const start = (page - 1) * PER_PAGE;
        const end = Math.min(start + PER_PAGE, totalClasses);
        const pageItems = classesData.slice(start, end);
        
        if (pageItems.length === 0 || totalClasses === 0) {
          tableBody.innerHTML = `
            <tr>
              <td colspan="7" class="px-5 py-8 text-center text-gray-400">
                <i class="fas fa-inbox text-3xl block mb-2 text-gray-300"></i>
                <p class="text-sm">Aucune classe n'a été créée pour le moment.</p>
                <p class="text-xs mt-1">Cliquez sur <strong>"Nouvelle classe"</strong> pour commencer.</p>
              </td>
            </tr>
          `;
          prevBtn.classList.add('disabled');
          nextBtn.classList.add('disabled');
          pageIndicator.textContent = 'Page 1 sur 1';
          return;
        }

        let html = '';
        pageItems.forEach(classItem => {
          const classDisplay = classItem.serie_name 
            ? classItem.level_name + ' ' + classItem.serie_name
            : classItem.level_name + ' ' + classItem.group_name;
          const occupancy = classItem.max_students > 0 ? Math.round((classItem.students_count / classItem.max_students) * 100) : 0;
          const occupancyClass = occupancy < 60 ? 'low' : (occupancy < 85 ? 'medium' : 'high');
          
          html += `
            <tr class="hover:bg-slate-50/80" data-id="${classItem.id}">
              <td class="px-5 py-4 font-medium text-slate-900 sm:px-6">${classDisplay}</td>
              <td class="px-3 py-4">${classItem.level_name || '-'}</td>
              <td class="px-3 py-4">${classItem.serie_name || '-'}</td>
              <td class="px-3 py-4">${classItem.students_count || 0}</td>
              <td class="px-3 py-4">${classItem.max_students || 50}</td>
              <td class="px-3 py-4">
                <span class="occupancy-badge ${occupancyClass}">${occupancy}%</span>
              </td>
              <td class="px-5 py-4 text-right">
                <div class="table-actions flex justify-end gap-1.5">
                  <button class="view-class-btn btn-icon bg-primary/10 text-primary hover:bg-primary/20" data-id="${classItem.id}" title="Voir détails">
                    <i class="fas fa-eye text-xs"></i>
                  </button>
                  <button class="edit-class-btn btn-icon bg-emerald-50 text-emerald-600 hover:bg-emerald-100" data-id="${classItem.id}" title="Modifier">
                    <i class="fas fa-edit text-xs"></i>
                  </button>
                  <button class="delete-class-btn btn-icon bg-red-50 text-red-600 hover:bg-red-100" data-id="${classItem.id}" title="Supprimer">
                    <i class="fas fa-trash text-xs"></i>
                  </button>
                </div>
              </td>
            </tr>
          `;
        });
        tableBody.innerHTML = html;

        // Mise à jour des indicateurs
        pageIndicator.textContent = `Page ${page} sur ${totalPages}`;
        
        // Gestion des boutons
        if (page <= 1) {
          prevBtn.classList.add('disabled');
        } else {
          prevBtn.classList.remove('disabled');
        }
        
        if (page >= totalPages) {
          nextBtn.classList.add('disabled');
        } else {
          nextBtn.classList.remove('disabled');
        }
        
        // Réattacher les événements aux boutons d'action
        attachActionEvents();
      }

      function attachActionEvents() {
        document.querySelectorAll('.view-class-btn').forEach(btn => {
          btn.addEventListener('click', function() { openDetailModal(this.dataset.id); });
        });

        document.querySelectorAll('.edit-class-btn').forEach(btn => {
          btn.addEventListener('click', async function() {
            const id = this.dataset.id;
            try {
              const response = await fetch(baseUrl + '&action=get_class&id=' + id);
              const data = await response.json();
              if (data.class) openFormModal(true, data.class);
            } catch (error) {
              showToast('Erreur de chargement', 'error');
            }
          });
        });

        document.querySelectorAll('.delete-class-btn').forEach(btn => {
          btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const name = row.querySelector('td:first-child')?.textContent || 'Classe';
            openDeleteModal(this.dataset.id, name);
          });
        });
      }

      prevBtn.addEventListener('click', function() {
        if (currentPage > 1) {
          currentPage--;
          renderPage(currentPage);
        }
      });

      nextBtn.addEventListener('click', function() {
        if (currentPage < totalPages) {
          currentPage++;
          renderPage(currentPage);
        }
      });

      // ─── Formulaire ───
      const formModal = document.getElementById('classFormModal');
      const formTitle = document.getElementById('formModalTitle');
      const closeFormBtn = document.getElementById('close-form-modal');
      const formCancel = document.getElementById('form-cancel');
      const form = document.getElementById('classForm');
      let isEditMode = false;

      function openFormModal(editMode = false, data = null) {
        isEditMode = editMode;
        formTitle.innerHTML = editMode 
          ? '<i class="fas fa-edit text-primary mr-2"></i>Modifier la classe' 
          : '<i class="fas fa-plus-circle text-primary mr-2"></i>Nouvelle classe';
        document.getElementById('class-id').value = data?.id || '';
        document.getElementById('level-id').value = data?.level_id || '';
        document.getElementById('serie-id').value = data?.serie_id || '';
        document.getElementById('group-name').value = data?.group_name || '';
        document.getElementById('max-students').value = data?.max_students || 50;
        document.getElementById('academic-year').value = data?.academic_year || new Date().getFullYear();
        formModal.classList.add('is-open');
        document.body.style.overflow = 'hidden';
      }

      function closeFormModal() {
        formModal.classList.remove('is-open');
        document.body.style.overflow = '';
        form.reset();
        isEditMode = false;
      }

      closeFormBtn.addEventListener('click', closeFormModal);
      formCancel.addEventListener('click', closeFormModal);
      formModal.addEventListener('click', (e) => { if (e.target === formModal) closeFormModal(); });

      form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const id = document.getElementById('class-id').value;
        const formData = new FormData();
        formData.append('level_id', document.getElementById('level-id').value);
        formData.append('serie_id', document.getElementById('serie-id').value || '');
        formData.append('group_name', document.getElementById('group-name').value);
        formData.append('max_students', document.getElementById('max-students').value);
        formData.append('academic_year', document.getElementById('academic-year').value);
        if (id) formData.append('id', id);

        const action = id ? 'update' : 'store';
        const url = baseUrl + '&action=' + action;

        try {
          const response = await fetch(url, { method: 'POST', body: formData });
          const result = await response.json();
          if (result.success) {
            showToast(result.message);
            closeFormModal();
            setTimeout(() => location.reload(), 1000);
          } else {
            showToast(result.error || 'Erreur', 'error');
          }
        } catch (error) {
          showToast('Erreur de connexion', 'error');
        }
      });

      // ─── Détail ───
      const detailModal = document.getElementById('detailModal');
      const closeDetailBtn = document.getElementById('close-detail-modal');
      const detailCloseBtn = document.getElementById('detail-close-btn');
      const detailBody = document.getElementById('detail-body');

      async function openDetailModal(id) {
        detailBody.innerHTML = `<div class="text-center py-12 text-gray-400"><i class="fas fa-spinner fa-spin text-2xl text-primary"></i><p class="mt-2 text-sm">Chargement...</p></div>`;
        detailModal.classList.add('is-open');
        document.body.style.overflow = 'hidden';

        try {
          const response = await fetch(baseUrl + '&action=get_class&id=' + id);
          const data = await response.json();
          if (data.error) {
            detailBody.innerHTML = `<div class="text-center py-12 text-red-500"><i class="fas fa-exclamation-circle text-2xl"></i><p class="mt-2 text-sm">${data.error}</p></div>`;
            return;
          }

          const c = data.class;
          const subjects = data.subjects || [];
          const classDisplay = c.serie_name ? c.level_name + ' ' + c.serie_name : c.level_name + ' ' + c.group_name;
          const occupationRate = c.max_students > 0 ? Math.round((c.students_count / c.max_students) * 100) : 0;

          let subjectsHtml = '';
          if (subjects.length > 0) {
            subjectsHtml = `
              <div>
                <h4 class="text-sm font-semibold text-slate-700 mb-3 flex items-center gap-2">
                  <i class="fas fa-book-open text-primary text-xs"></i>
                  Matières enseignées
                  <span class="text-xs font-normal text-gray-400 ml-auto">${subjects.length} matières</span>
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                  ${subjects.map(s => `
                    <div class="flex items-center justify-between bg-gray-50 rounded-lg px-3 py-2.5 border border-gray-100">
                      <span class="text-sm text-slate-700 font-medium">${s.subject_name}</span>
                      <span class="text-xs font-semibold text-primary bg-primary/5 px-2 py-0.5 rounded-full">Coef ${s.coefficient}</span>
                    </div>
                  `).join('')}
                </div>
              </div>
            `;
          } else {
            subjectsHtml = `
              <div class="text-center py-6 text-gray-400 border border-dashed border-gray-200 rounded-xl">
                <i class="fas fa-book-open text-2xl text-gray-300 block mb-2"></i>
                <p class="text-sm">Aucune matière associée</p>
              </div>
            `;
          }

          detailBody.innerHTML = `
            <div class="flex items-center justify-between pb-4 border-b border-gray-100">
              <div>
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Classe</p>
                <h2 class="text-2xl font-bold text-slate-900">${classDisplay || '---'}</h2>
              </div>
              <div class="flex items-center gap-3">
                <span class="text-sm text-gray-500 flex items-center gap-1.5">
                  <i class="fas fa-user-graduate text-primary"></i>
                  ${c.students_count || 0} élèves
                </span>
                <span class="text-sm text-gray-500 flex items-center gap-1.5">
                  <i class="fas fa-chair text-primary"></i>
                  ${c.max_students || 50} places
                </span>
                <span class="text-sm font-medium ${occupationRate > 80 ? 'text-emerald-600' : 'text-emerald-600'}">
                  ${occupationRate}% occupé
                </span>
              </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wider flex items-center gap-1.5">
                  <i class="fas fa-layer-group text-primary"></i> Niveau
                </p>
                <p class="text-slate-800 font-medium text-base mt-1">${c.level_name || '---'}</p>
              </div>
              <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wider flex items-center gap-1.5">
                  <i class="fas fa-tag text-primary"></i> Série
                </p>
                <p class="text-slate-800 font-medium text-base mt-1">${c.serie_name || 'Aucune'}</p>
              </div>
              <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wider flex items-center gap-1.5">
                  <i class="fas fa-calendar-alt text-primary"></i> Année scolaire
                </p>
                <p class="text-slate-800 font-medium text-base mt-1">${c.academic_year || '---'}</p>
              </div>
              <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wider flex items-center gap-1.5">
                  <i class="fas fa-flag text-primary"></i> Cycle
                </p>
                <p class="text-slate-800 font-medium text-base mt-1">
                  ${c.serie_name ? 'Second cycle' : 'Premier cycle'}
                </p>
              </div>
            </div>

            ${subjectsHtml}
          `;
        } catch (error) {
          detailBody.innerHTML = `<div class="text-center py-12 text-red-500"><i class="fas fa-exclamation-circle text-2xl"></i><p class="mt-2 text-sm">Erreur de chargement</p></div>`;
        }
      }

      function closeDetailModal() {
        detailModal.classList.remove('is-open');
        document.body.style.overflow = '';
      }

      closeDetailBtn.addEventListener('click', closeDetailModal);
      detailCloseBtn.addEventListener('click', closeDetailModal);
      detailModal.addEventListener('click', (e) => { if (e.target === detailModal) closeDetailModal(); });

      // ─── Suppression ───
      const deleteModal = document.getElementById('deleteModal');
      const closeDeleteBtn = document.getElementById('close-delete-modal');
      const deleteCancel = document.getElementById('delete-cancel');
      const deleteConfirm = document.getElementById('delete-confirm');
      const deleteInput = document.getElementById('delete-confirm-input');
      const deleteName = document.getElementById('delete-class-name');
      let pendingDeleteId = null;

      function openDeleteModal(id, name) {
        pendingDeleteId = id;
        deleteName.textContent = name || 'Classe';
        deleteInput.value = '';
        deleteConfirm.disabled = true;
        deleteConfirm.classList.add('opacity-50', 'cursor-not-allowed');
        deleteModal.classList.add('is-open');
        document.body.style.overflow = 'hidden';
      }

      function closeDeleteModal() {
        deleteModal.classList.remove('is-open');
        document.body.style.overflow = '';
        pendingDeleteId = null;
      }

      deleteInput.addEventListener('input', function() {
        if (this.value === 'SUPPRIMER') {
          deleteConfirm.disabled = false;
          deleteConfirm.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
          deleteConfirm.disabled = true;
          deleteConfirm.classList.add('opacity-50', 'cursor-not-allowed');
        }
      });

      deleteConfirm.addEventListener('click', async function() {
        if (!this.disabled && pendingDeleteId) {
          try {
            const formData = new FormData();
            formData.append('id', pendingDeleteId);
            const response = await fetch(baseUrl + '&action=delete', { method: 'POST', body: formData });
            const result = await response.json();
            if (result.success) {
              showToast(result.message);
              closeDeleteModal();
              setTimeout(() => location.reload(), 1000);
            } else {
              showToast(result.error || 'Erreur', 'error');
            }
          } catch (error) {
            showToast('Erreur de connexion', 'error');
          }
        }
      });

      closeDeleteBtn.addEventListener('click', closeDeleteModal);
      deleteCancel.addEventListener('click', closeDeleteModal);
      deleteModal.addEventListener('click', (e) => { if (e.target === deleteModal) closeDeleteModal(); });

      // ─── Événements des boutons ───
      document.getElementById('btn-add-class').addEventListener('click', () => openFormModal());

      // ─── Initialisation ───
      document.getElementById('last-update').textContent = new Date().toLocaleTimeString('fr-FR');
      
      // Rendu initial de la pagination
      renderPage(1);

    })();
  </script>
</body>
</html>