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
    .modal-content { transform: scale(0.95); transition: transform 0.2s ease; max-width: 90%; width: 28rem; background: white; border-radius: 1rem; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); }
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
    <!-- HEADER comme NDIGITMARKET -->
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
      <div class="flex items-center gap-3">
        <span class="hidden md:flex items-center gap-2 bg-accent/30 border border-accent/50 rounded-full px-3 py-1.5 text-xs font-medium text-slate-700">
          <i class="fas fa-calendar-alt text-primary"></i> Année 2025–2026
        </span>
        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-semibold text-sm shadow-md">
          AK
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
            <p class="text-2xl font-bold text-[#0F172A]">0</p>
            <p class="text-xs text-gray-400 mt-1">Classes totales</p>
          </div>
          <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-2">
              <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600">
                <i class="fas fa-user-graduate"></i>
              </div>
              <span class="text-[10px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">ÉLÈVES</span>
            </div>
            <p class="text-2xl font-bold text-[#0F172A]">0</p>
            <p class="text-xs text-gray-400 mt-1">Total élèves</p>
          </div>
          <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-2">
              <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                <i class="fas fa-chart-line"></i>
              </div>
              <span class="text-[10px] font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-full">MOYENNE</span>
            </div>
            <p class="text-2xl font-bold text-[#0F172A]">0 <span class="text-sm font-normal text-gray-400">/20</span></p>
            <p class="text-xs text-gray-400 mt-1">Moyenne générale</p>
          </div>
          <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-2">
              <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600">
                <i class="fas fa-clock"></i>
              </div>
              <span class="text-[10px] font-semibold text-purple-600 bg-purple-50 px-2 py-1 rounded-full">PRÉSENCE</span>
            </div>
            <p class="text-2xl font-bold text-[#0F172A]">0%</p>
            <p class="text-xs text-gray-400 mt-1">Taux de présence</p>
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
                  <th class="px-3 py-3">Nb élèves</th>
                  <th class="px-3 py-3">Moy. générale</th>
                  <th class="px-3 py-3">Taux réussite</th>
                  <th class="px-3 py-3">Présence</th>
                  <th class="px-3 py-3">Paiements OK</th>
                  <th class="px-5 py-3 text-right">Actions</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100">
                <!-- Aucune donnée pour le moment -->
                <tr>
                  <td colspan="7" class="px-5 py-8 text-center text-gray-400">
                    <i class="fas fa-inbox text-3xl block mb-2 text-gray-300"></i>
                    <p class="text-sm">Aucune classe n'a été créée pour le moment.</p>
                    <p class="text-xs mt-1">Cliquez sur <strong>"Nouvelle classe"</strong> pour commencer.</p>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <footer class="mt-12 pb-8 text-center text-xs text-slate-400">
        AfricEduc — <span id="footer-school">Collège Saint-Michel</span> · Dernière mise à jour : <span id="last-update"></span>
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
          <label class="block text-sm font-medium text-slate-700 mb-1">Nom de la classe <span class="text-red-500">*</span></label>
          <input type="text" id="class-name" class="w-full rounded-xl border border-slate-200 px-3 py-2.5 bg-gray-50 focus:outline-none focus:border-primary focus:bg-white" placeholder="Ex: 6ème A">
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">Nombre d'élèves <span class="text-red-500">*</span></label>
          <input type="number" id="class-students" class="w-full rounded-xl border border-slate-200 px-3 py-2.5 bg-gray-50 focus:outline-none focus:border-primary focus:bg-white" placeholder="0" min="0">
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">Moyenne générale (/20) <span class="text-red-500">*</span></label>
          <input type="number" step="0.1" id="class-avg" class="w-full rounded-xl border border-slate-200 px-3 py-2.5 bg-gray-50 focus:outline-none focus:border-primary focus:bg-white" placeholder="0" min="0" max="20">
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">Taux de réussite (%) <span class="text-red-500">*</span></label>
          <input type="number" id="class-success" class="w-full rounded-xl border border-slate-200 px-3 py-2.5 bg-gray-50 focus:outline-none focus:border-primary focus:bg-white" placeholder="0" min="0" max="100">
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">Taux de présence (%) <span class="text-red-500">*</span></label>
          <input type="number" id="class-presence" class="w-full rounded-xl border border-slate-200 px-3 py-2.5 bg-gray-50 focus:outline-none focus:border-primary focus:bg-white" placeholder="0" min="0" max="100">
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">Paiements OK</label>
          <input type="text" id="class-payments" class="w-full rounded-xl border border-slate-200 px-3 py-2.5 bg-gray-50 focus:outline-none focus:border-primary focus:bg-white" placeholder="ex: 12/14">
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
    <div class="modal-content bg-white rounded-2xl shadow-2xl p-6 max-w-2xl">
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
      <div id="detail-body" class="space-y-4">
        <div class="grid grid-cols-2 gap-4">
          <div class="bg-slate-50 rounded-xl p-4">
            <p class="text-xs font-semibold uppercase text-slate-500">Classe</p>
            <p class="text-slate-800 font-medium text-lg" id="detail-name">---</p>
          </div>
          <div class="bg-slate-50 rounded-xl p-4">
            <p class="text-xs font-semibold uppercase text-slate-500">Nb élèves</p>
            <p class="text-slate-800 font-medium text-lg" id="detail-students">---</p>
          </div>
          <div class="bg-slate-50 rounded-xl p-4">
            <p class="text-xs font-semibold uppercase text-slate-500">Moyenne générale</p>
            <p class="text-slate-800 font-medium text-lg" id="detail-avg">---</p>
          </div>
          <div class="bg-slate-50 rounded-xl p-4">
            <p class="text-xs font-semibold uppercase text-slate-500">Taux de réussite</p>
            <p class="text-slate-800 font-medium text-lg" id="detail-success">---</p>
          </div>
          <div class="bg-slate-50 rounded-xl p-4">
            <p class="text-xs font-semibold uppercase text-slate-500">Présence</p>
            <p class="text-slate-800 font-medium text-lg" id="detail-presence">---</p>
          </div>
          <div class="bg-slate-50 rounded-xl p-4">
            <p class="text-xs font-semibold uppercase text-slate-500">Paiements OK</p>
            <p class="text-slate-800 font-medium text-lg" id="detail-payments">---</p>
          </div>
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
    // ==================== GESTION DES MODALES ====================
    (function() {
      // Formulaire (Ajout/Modification)
      const formModal = document.getElementById('classFormModal');
      const formTitle = document.getElementById('formModalTitle');
      const closeFormBtn = document.getElementById('close-form-modal');
      const formCancel = document.getElementById('form-cancel');
      const form = document.getElementById('classForm');
      const submitBtn = form.querySelector('button[type="submit"]');

      function openFormModal(editMode = false, data = null) {
        formTitle.innerHTML = editMode 
          ? '<i class="fas fa-edit text-primary mr-2"></i>Modifier la classe' 
          : '<i class="fas fa-plus-circle text-primary mr-2"></i>Nouvelle classe';
        
        document.getElementById('class-id').value = data?.id || '';
        document.getElementById('class-name').value = data?.name || '';
        document.getElementById('class-students').value = data?.students || '';
        document.getElementById('class-avg').value = data?.avgGrade || '';
        document.getElementById('class-success').value = data?.successRate || '';
        document.getElementById('class-presence').value = data?.presence || '';
        document.getElementById('class-payments').value = data?.payments || '';

        formModal.classList.add('is-open');
        document.body.style.overflow = 'hidden';
      }

      function closeFormModal() {
        formModal.classList.remove('is-open');
        document.body.style.overflow = '';
        form.reset();
      }

      closeFormBtn.addEventListener('click', closeFormModal);
      formCancel.addEventListener('click', closeFormModal);
      formModal.addEventListener('click', (e) => { if (e.target === formModal) closeFormModal(); });

      // Détail
      const detailModal = document.getElementById('detailModal');
      const closeDetailBtn = document.getElementById('close-detail-modal');
      const detailCloseBtn = document.getElementById('detail-close-btn');

      function openDetailModal(data) {
        document.getElementById('detail-name').textContent = data?.name || '---';
        document.getElementById('detail-students').textContent = data?.students || '---';
        document.getElementById('detail-avg').textContent = data?.avgGrade ? data.avgGrade + ' /20' : '---';
        document.getElementById('detail-success').textContent = data?.successRate ? data.successRate + '%' : '---';
        document.getElementById('detail-presence').textContent = data?.presence ? data.presence + '%' : '---';
        document.getElementById('detail-payments').textContent = data?.payments || '---';

        detailModal.classList.add('is-open');
        document.body.style.overflow = 'hidden';
      }

      function closeDetailModal() {
        detailModal.classList.remove('is-open');
        document.body.style.overflow = '';
      }

      closeDetailBtn.addEventListener('click', closeDetailModal);
      detailCloseBtn.addEventListener('click', closeDetailModal);
      detailModal.addEventListener('click', (e) => { if (e.target === detailModal) closeDetailModal(); });

      // Suppression
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

      deleteConfirm.addEventListener('click', function() {
        if (!this.disabled && pendingDeleteId) {
          showToast('Classe supprimée avec succès');
          closeDeleteModal();
          // Ici tu peux ajouter l'appel API ou la suppression côté serveur
          // Exemple: window.location.reload();
        }
      });

      closeDeleteBtn.addEventListener('click', closeDeleteModal);
      deleteCancel.addEventListener('click', closeDeleteModal);
      deleteModal.addEventListener('click', (e) => { if (e.target === deleteModal) closeDeleteModal(); });

      // ==================== BOUTONS D'ACTION ====================
      // Nouvelle classe
      document.getElementById('btn-add-class').addEventListener('click', () => openFormModal());

      // Simuler des données pour la démo (boutons Voir, Modifier, Supprimer)
      // Dans la vraie vie, ces données viendront du backend
      const demoClasses = [
        { id: 1, name: '6ème A', students: 14, avgGrade: 12.4, successRate: 86, presence: 94, payments: '12/14' },
        { id: 2, name: '5ème B', students: 12, avgGrade: 11.8, successRate: 79, presence: 87, payments: '11/12' },
        { id: 3, name: '4ème A', students: 13, avgGrade: 12.1, successRate: 81, presence: 91, payments: '12/13' },
        { id: 4, name: 'Tle D', students: 11, avgGrade: 13.2, successRate: 91, presence: 96, payments: '9/11' }
      ];

      // Fonction pour peupler le tableau avec les données
      function populateTable() {
        const tbody = document.querySelector('#classes-table-body');
        if (!tbody) return;
        
        if (demoClasses.length === 0) {
          tbody.innerHTML = `
            <tr>
              <td colspan="7" class="px-5 py-8 text-center text-gray-400">
                <i class="fas fa-inbox text-3xl block mb-2 text-gray-300"></i>
                <p class="text-sm">Aucune classe n'a été créée pour le moment.</p>
                <p class="text-xs mt-1">Cliquez sur <strong>"Nouvelle classe"</strong> pour commencer.</p>
              </td>
            </tr>
          `;
          return;
        }

        tbody.innerHTML = demoClasses.map(c => `
          <tr class="hover:bg-slate-50/80">
            <td class="px-5 py-4 font-medium text-slate-900 sm:px-6">${c.name}</td>
            <td class="px-3 py-4">${c.students}</td>
            <td class="px-3 py-4">${c.avgGrade} /20</td>
            <td class="px-3 py-4"><span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-800">${c.successRate}% ↑</span></td>
            <td class="px-3 py-4"><span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-800">${c.presence}%</span></td>
            <td class="px-3 py-4">${c.payments}</td>
            <td class="px-5 py-4 text-right">
              <div class="table-actions flex justify-end gap-1.5">
                <button class="view-class-btn btn-icon bg-blue-50 text-blue-600 hover:bg-blue-100" data-id="${c.id}" title="Voir détails">
                  <i class="fas fa-eye text-xs"></i>
                </button>
                <button class="edit-class-btn btn-icon bg-amber-50 text-amber-600 hover:bg-amber-100" data-id="${c.id}" title="Modifier">
                  <i class="fas fa-edit text-xs"></i>
                </button>
                <button class="delete-class-btn btn-icon bg-red-50 text-red-600 hover:bg-red-100" data-id="${c.id}" title="Supprimer">
                  <i class="fas fa-trash text-xs"></i>
                </button>
              </div>
            </td>
          </tr>
        `).join('');

        // Attacher les événements
        document.querySelectorAll('.view-class-btn').forEach(btn => {
          btn.addEventListener('click', function() {
            const id = parseInt(this.dataset.id);
            const data = demoClasses.find(c => c.id === id);
            if (data) openDetailModal(data);
          });
        });

        document.querySelectorAll('.edit-class-btn').forEach(btn => {
          btn.addEventListener('click', function() {
            const id = parseInt(this.dataset.id);
            const data = demoClasses.find(c => c.id === id);
            if (data) openFormModal(true, data);
          });
        });

        document.querySelectorAll('.delete-class-btn').forEach(btn => {
          btn.addEventListener('click', function() {
            const id = parseInt(this.dataset.id);
            const data = demoClasses.find(c => c.id === id);
            if (data) openDeleteModal(id, data.name);
          });
        });
      }

      // Toast
      function showToast(msg, type = "success") {
        const toast = document.getElementById("toast");
        toast.innerText = msg;
        toast.style.backgroundColor = type === "error" ? "#ef4444" : "#10b981";
        toast.classList.add("show");
        setTimeout(() => toast.classList.remove("show"), 3000);
      }

      // Initialisation
      document.getElementById("last-update").innerText = new Date().toLocaleTimeString("fr-FR");
      populateTable();

      // Exposer la fonction pour une utilisation ultérieure (ex: après ajout)
      window.showToast = showToast;
      window.openFormModal = openFormModal;
      window.openDetailModal = openDetailModal;
      window.openDeleteModal = openDeleteModal;
      window.closeFormModal = closeFormModal;
      window.closeDetailModal = closeDetailModal;
      window.closeDeleteModal = closeDeleteModal;
    })();
  </script>
</body>
</html>