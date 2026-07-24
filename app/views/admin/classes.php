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
          colors: { primary: "#7300e9", primaryDark: "#5c00bd", accent: "#99fbe3", danger: "#ef4444", warning: "#f59e0b", success: "#10b981" },
          fontFamily: { heading: ["Quicksand", "sans-serif"], body: ["Outfit", "sans-serif"] },
          animation: { 'fade-in': 'fadeIn 0.3s ease-in-out' },
          keyframes: { fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } } }
        }
      }
    };
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: "Outfit", sans-serif; }
    h1, h2, h3, .font-heading { font-family: "Quicksand", sans-serif; }
    .sidebar-link { transition: all 0.2s ease; }
    .sidebar-link:hover { background-color: rgba(255,255,255,0.1); transform: translateX(4px); }
    .sidebar-link.active { background-color: rgba(153,251,227,0.2); color: #99fbe3; border-left: 3px solid #99fbe3; }
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
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 text-slate-800 antialiased">

  <!-- Sidebar -->
  <?php include __DIR__ . '/../components/sidebar.php'; ?>

  <!-- Main content -->
  <div class="min-h-screen lg:pl-[260px]">
      <header class="flex items-center justify-between mb-6 bg-white/80 backdrop-blur-sm sticky top-0 z-30 py-4 px-4 md:px-6 rounded-2xl shadow-sm border border-gray-100/50">
          <div class="flex items-center gap-4">
              <button id="btn-menu" class="lg:hidden w-10 h-10 rounded-xl bg-gray-100 hover:bg-gray-200 transition flex items-center justify-center text-gray-700">
                  <i class="fas fa-bars text-xl"></i>
              </button>
              <div>
                  <h2 class="text-xl md:text-2xl font-bold text-[#0F172A]">Gestion des Classes</h2>
                  <p class="text-xs text-gray-400 hidden sm:block">Organiser, créer et gérer les classes du collège</p>
              </div>
          </div>
          <div class="flex items-center gap-4">
              <!-- Bloc école + adresse + année -->
              <div class="hidden md:flex flex-col items-end">
                  <div class="flex items-center gap-3">
                      <span class="flex items-center gap-2 bg-accent/30 border border-accent/50 rounded-full px-3 py-1.5 text-xs font-medium text-slate-700">
                          <i class="fas fa-calendar-alt text-primary"></i> Année <?= date('Y') ?>
                      </span>
                      
                  </div>
                  <p class="text-[15px] text-gray-400 mt-1 flex items-center gap-1">
                      <i class="fas fa-map-pin text-gray-300"></i>
                      <?= $_SESSION['school_address'] ?? 'Cotonou, Bénin' ?>
                  </p>
              </div>
              <!-- Avatar -->
              <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-semibold text-sm shadow-md">
                  <?= isset($_SESSION['user_name']) ? substr($_SESSION['user_name'], 0, 2) : 'AK' ?>
              </div>
          </div>
      </header>

    <main class="px-4 py-6 sm:px-6 lg:px-8">
      <!-- STATISTIQUES -->
      <section class="mb-6">
        <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
          <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider flex items-center gap-2">
            <i class="fas fa-chart-pie text-primary"></i> · Vue d'ensemble des classes
          </h3>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
          <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-2">
              <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                <i class="fas fa-chalkboard"></i>
              </div>
              <span class="text-[10px] font-semibold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-full">TOTAL</span>
            </div>
            <p class="text-2xl font-bold text-[#0F172A]" id="total-classes"><?= $stats['total_classes'] ?? 0 ?></p>
            <p class="text-xs text-gray-400 mt-1">Classes totales</p>
          </div>
          <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-2">
              <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600">
                <i class="fas fa-user-graduate"></i>
              </div>
              <span class="text-[10px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">ÉLÈVES</span>
            </div>
            <p class="text-2xl font-bold text-[#0F172A]" id="total-students"><?= $stats['total_students'] ?? 0 ?></p>
            <p class="text-xs text-gray-400 mt-1">Total élèves</p>
          </div>
          <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-2">
              <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                <i class="fas fa-chart-line"></i>
              </div>
              <span class="text-[10px] font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-full">CAPACITÉ</span>
            </div>
            <p class="text-2xl font-bold text-[#0F172A]" id="total-capacity"><?= $stats['total_capacity'] ?? 0 ?></p>
            <p class="text-xs text-gray-400 mt-1">Capacité totale</p>
          </div>
          <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-2">
              <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600">
                <i class="fas fa-clock"></i>
              </div>
              <span class="text-[10px] font-semibold text-purple-600 bg-purple-50 px-2 py-1 rounded-full">ANNÉE</span>
            </div>
            <p class="text-2xl font-bold text-[#0F172A]"><?= date('Y') ?></p>
            <p class="text-xs text-gray-400 mt-1">Année scolaire</p>
          </div>
        </div>
      </section>

      <!-- LISTE DES CLASSES -->
      <section>
        <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
          <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider flex items-center gap-2">
            <i class="fas fa-list text-primary"></i> · Liste des classes
          </h3>
          <button id="btn-add-class" class="action-button inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primaryDark">
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
                  <th class="px-5 py-3 text-right">Actions</th>
                </tr>
              </thead>
              <tbody id="classes-table-body" class="divide-y divide-slate-100">
                <?php if (empty($classes)): ?>
                  <tr>
                    <td colspan="6" class="px-5 py-8 text-center text-gray-400">
                      <i class="fas fa-inbox text-3xl block mb-2 text-gray-300"></i>
                      <p class="text-sm">Aucune classe n'a été créée pour le moment.</p>
                      <p class="text-xs mt-1">Cliquez sur <strong>"Nouvelle classe"</strong> pour commencer.</p>
                    </td>
                  </tr>
                <?php else: ?>
                  <?php foreach ($classes as $class): 
                    $classDisplay = $class['serie_name'] 
                      ? $class['level_name'] . ' ' . $class['serie_name']
                      : $class['level_name'] . ' ' . $class['group_name'];
                  ?>
                    <tr class="hover:bg-slate-50/80" data-id="<?= $class['id'] ?>">
                      <td class="px-5 py-4 font-medium text-slate-900 sm:px-6"><?= htmlspecialchars($classDisplay) ?></td>
                      <td class="px-3 py-4"><?= htmlspecialchars($class['level_name'] ?? '-') ?></td>
                      <td class="px-3 py-4"><?= htmlspecialchars($class['serie_name'] ?? '-') ?></td>
                      <td class="px-3 py-4"><?= $class['students_count'] ?? 0 ?></td>
                      <td class="px-3 py-4"><?= $class['max_students'] ?? 50 ?></td>
                      <td class="px-5 py-4 text-right">
                        <div class="table-actions flex justify-end gap-1.5">
                          <button class="view-class-btn btn-icon bg-blue-50 text-blue-600 hover:bg-blue-100" data-id="<?= $class['id'] ?>" title="Voir détails">
                            <i class="fas fa-eye text-xs"></i>
                          </button>
                          <button class="edit-class-btn btn-icon bg-amber-50 text-amber-600 hover:bg-amber-100" data-id="<?= $class['id'] ?>" title="Modifier">
                            <i class="fas fa-edit text-xs"></i>
                          </button>
                          <button class="delete-class-btn btn-icon bg-red-50 text-red-600 hover:bg-red-100" data-id="<?= $class['id'] ?>" title="Supprimer">
                            <i class="fas fa-trash text-xs"></i>
                          </button>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
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
      <div class="modal-content bg-white rounded-2xl shadow-2xl p-6 max-w-4xl">
          <div class="flex justify-between items-center mb-4 border-b border-gray-100 pb-4">
              <div>
                  <h3 class="font-heading text-xl font-bold text-slate-900">
                      <i class="fas fa-info-circle text-primary mr-2"></i>Détails de la classe
                  </h3>
                  <p class="text-xs text-gray-400">Informations complètes de la classe</p>
              </div>
              <button id="close-detail-modal" class="text-slate-400 hover:text-slate-600 w-9 h-9 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center">
                  <i class="fas fa-times"></i>
              </button>
          </div>
          <div id="detail-body" class="space-y-6">
              <!-- Contenu chargé via AJAX -->
              <div class="text-center py-8 text-gray-400">
                  <i class="fas fa-spinner fa-spin text-2xl"></i>
                  <p class="mt-2">Chargement...</p>
              </div>
          </div>
          <div class="mt-6 flex justify-end border-t border-gray-100 pt-4">
              <button id="detail-close-btn" class="rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white">Fermer</button>
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
    // ============================================================
    // GESTION DES MODALES AVEC FETCH
    // ============================================================
    (function() {
      const baseUrl = '/AfricEduc/public/index.php?url=classes';
      
      // ─── Toast ───
      function showToast(msg, type = 'success') {
        const toast = document.getElementById('toast');
        toast.textContent = msg;
        toast.style.backgroundColor = type === 'error' ? '#ef4444' : '#10b981';
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3000);
      }

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

            // ─── Soumission du formulaire ───
            form.addEventListener('submit', async function(e) {
              e.preventDefault();
              
              const id = document.getElementById('class-id').value;
              const formData = new FormData();
              formData.append('level_id', document.getElementById('level-id').value);
              formData.append('serie_id', document.getElementById('serie-id').value || '');
              formData.append('group_name', document.getElementById('group-name').value);
              formData.append('max_students', document.getElementById('max-students').value);
              formData.append('academic_year', document.getElementById('academic-year').value);
              
              if (id) {
                formData.append('id', id);
              }

              const action = id ? 'update' : 'store';
              const url = baseUrl + '&action=' + action;

              try {
                const response = await fetch(url, {
                  method: 'POST',
                  body: formData
                });
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
    detailBody.innerHTML = `
        <div class="text-center py-8 text-gray-400">
            <i class="fas fa-spinner fa-spin text-2xl"></i>
            <p class="mt-2">Chargement...</p>
        </div>
    `;
    detailModal.classList.add('is-open');
    document.body.style.overflow = 'hidden';

    try {
        const response = await fetch(baseUrl + '&action=get_class&id=' + id);
        const data = await response.json();

        if (data.error) {
            detailBody.innerHTML = `<p class="text-red-500">${data.error}</p>`;
            return;
        }

        const c = data.class;
        const subjects = data.subjects || [];
        const classDisplay = c.serie_name 
            ? c.level_name + ' ' + c.serie_name
            : c.level_name + ' ' + c.group_name;

        // Construction du HTML des matières (liste simple)
        let subjectsHtml = '';
        if (subjects.length > 0) {
            subjectsHtml = `
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                    <p class="text-xs font-semibold uppercase text-slate-500 flex items-center gap-2 mb-3">
                        <i class="fas fa-book-open text-primary"></i> Matières enseignées
                        <span class="ml-auto text-[10px] text-gray-400">${subjects.length} matières</span>
                    </p>
                    <ul class="space-y-2">
                        ${subjects.map(s => `
                            <li class="flex items-center justify-between bg-white rounded-lg px-3 py-2 border border-slate-100">
                                <span class="text-sm text-slate-700">${s.subject_name}</span>
                                <span class="text-sm font-semibold text-primary">Coef. ${s.coefficient}</span>
                            </li>
                        `).join('')}
                    </ul>
                </div>
            `;
        } else {
            subjectsHtml = `
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 text-center text-gray-400">
                    <i class="fas fa-book-open text-2xl block mb-2 text-gray-300"></i>
                    <p class="text-sm">Aucune matière associée</p>
                </div>
            `;
        }

        detailBody.innerHTML = `
            <!-- En-tête avec le nom de la classe -->
            <div class="bg-gradient-to-r from-primary/5 via-primary/10 to-accent/20 rounded-xl p-4 border border-primary/20">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase text-slate-500">Classe</p>
                        <h4 class="text-2xl font-bold text-slate-900">${classDisplay || '---'}</h4>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="px-3 py-1 bg-primary/10 text-primary text-xs font-semibold rounded-full">
                            <i class="fas fa-users mr-1"></i> ${c.students_count || 0} élèves
                        </span>
                        <span class="px-3 py-1 bg-emerald-50 text-emerald-700 text-xs font-semibold rounded-full">
                            <i class="fas fa-user-plus mr-1"></i> ${c.max_students || 50} places
                        </span>
                    </div>
                </div>
            </div>

            <!-- GRILLE 2 COLONNES BENTO -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Colonne gauche : Infos générales -->
                <div class="space-y-4">
                    <div class="bg-white rounded-xl p-4 border border-slate-200">
                        <p class="text-xs font-semibold uppercase text-slate-500 flex items-center gap-2">
                            <i class="fas fa-layer-group text-primary"></i> Niveau
                        </p>
                        <p class="text-slate-800 font-medium text-lg mt-1">${c.level_name || '---'}</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 border border-slate-200">
                        <p class="text-xs font-semibold uppercase text-slate-500 flex items-center gap-2">
                            <i class="fas fa-tag text-primary"></i> Série
                        </p>
                        <p class="text-slate-800 font-medium text-lg mt-1">${c.serie_name || 'Aucune'}</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 border border-slate-200">
                        <p class="text-xs font-semibold uppercase text-slate-500 flex items-center gap-2">
                            <i class="fas fa-calendar-alt text-primary"></i> Année scolaire
                        </p>
                        <p class="text-slate-800 font-medium text-lg mt-1">${c.academic_year || '---'}</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 border border-slate-200">
                        <p class="text-xs font-semibold uppercase text-slate-500 flex items-center gap-2">
                            <i class="fas fa-flag text-primary"></i> Cycle
                        </p>
                        <p class="text-slate-800 font-medium text-lg mt-1">
                            ${c.serie_name ? 'Second cycle (Lycée)' : 'Premier cycle (Collège)'}
                        </p>
                    </div>
                </div>

                <!-- Colonne droite : Matières enseignées -->
                <div>
                    ${subjectsHtml}
                </div>
            </div>
        `;
    } catch (error) {
        detailBody.innerHTML = `<p class="text-red-500">Erreur de chargement</p>`;
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
            
            const response = await fetch(baseUrl + '&action=delete', {
              method: 'POST',
              body: formData
            });
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

      document.querySelectorAll('.view-class-btn').forEach(btn => {
        btn.addEventListener('click', function() {
          openDetailModal(this.dataset.id);
        });
      });

      document.querySelectorAll('.edit-class-btn').forEach(btn => {
        btn.addEventListener('click', async function() {
          const id = this.dataset.id;
          try {
            const response = await fetch(baseUrl + '&action=get_class&id=' + id);
            const data = await response.json();
            if (data.class) {
              openFormModal(true, data.class);
            }
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

      // ─── Mise à jour de l'horodatage ───
      document.getElementById('last-update').textContent = new Date().toLocaleTimeString('fr-FR');

    })();
  </script>
</body>
</html>