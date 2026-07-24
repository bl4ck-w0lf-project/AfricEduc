<?php
// app/views/admin/matieres.php
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matières | AfricEduc</title>
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
        .kpi-card { transition: all 0.2s ease; background: white; border: 1px solid #e2e8f0; }
        .kpi-card:hover { transform: translateY(-2px); box-shadow: 0 12px 24px -12px rgba(0,0,0,0.15); }
        .action-button { transition: all 0.2s ease; }
        .action-button:hover { transform: scale(1.05); }
        .modal-overlay { pointer-events: none; opacity: 0; transition: opacity 0.2s ease; position: fixed; inset: 0; z-index: 9999; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; }
        .modal-overlay.is-open { pointer-events: auto; opacity: 1; }
        .modal-content { transform: scale(0.95); transition: transform 0.2s ease; max-width: 90%; width: 40rem; background: white; border-radius: 1rem; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); }
        .modal-overlay.is-open .modal-content { transform: scale(1); }
        .toast { position: fixed; bottom: 20px; right: 20px; background: #1e293b; color: white; padding: 12px 20px; border-radius: 12px; font-size: 0.875rem; z-index: 10000; opacity: 0; transition: opacity 0.3s; pointer-events: none; }
        .toast.show { opacity: 1; }
        .table-actions .btn-icon { width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; transition: all 0.15s; }
        .table-actions .btn-icon:hover { transform: scale(1.08); }
        .toggle-btn.active { background-color: #7300e9; color: white; }
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
                    <h2 class="text-xl md:text-2xl font-bold text-[#0F172A]">Matières par Classe</h2>
                    <p class="text-xs text-gray-400 hidden sm:block">Gérer les matières de chaque classe</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="hidden md:flex flex-col items-end">
                    <div class="flex items-center gap-3">
                        <span class="flex items-center gap-2 bg-accent/30 border border-accent/50 rounded-full px-3 py-1.5 text-xs font-medium text-slate-700">
                            <i class="fas fa-calendar-alt text-primary"></i> Année <?= date('Y') ?>
                        </span>
                        <span class="flex items-center gap-2 bg-primary/10 border border-primary/20 rounded-full px-3 py-1.5 text-xs font-medium text-primary">
                            <i class="fas fa-school"></i> <?= $_SESSION['school_name'] ?? 'Mon École' ?>
                        </span>
                    </div>
                    <p class="text-[15px] text-gray-400 mt-1 flex items-center gap-1">
                        <i class="fas fa-map-pin text-gray-300"></i>
                        <?= $_SESSION['school_address'] ?? 'Cotonou, Bénin' ?>
                    </p>
                </div>
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
                        <i class="fas fa-chart-pie text-primary"></i> · Vue d'ensemble
                    </h3>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                    <div class="kpi-card rounded-2xl p-4 shadow-sm">
                        <div class="flex items-center justify-between mb-2">
                            <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                                <i class="fas fa-book"></i>
                            </div>
                            <span class="text-[10px] font-semibold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-full">TOTAL</span>
                        </div>
                        <p class="text-2xl font-bold text-[#0F172A]"><?= $stats['total_matieres'] ?? 0 ?></p>
                        <p class="text-xs text-gray-400 mt-1">Matières totales</p>
                    </div>
                    <div class="kpi-card rounded-2xl p-4 shadow-sm">
                        <div class="flex items-center justify-between mb-2">
                            <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600">
                                <i class="fas fa-layer-group"></i>
                            </div>
                            <span class="text-[10px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">CLASSES</span>
                        </div>
                        <p class="text-2xl font-bold text-[#0F172A]"><?= $stats['total_classes'] ?? 0 ?></p>
                        <p class="text-xs text-gray-400 mt-1">Classes avec matières</p>
                    </div>
                    <div class="kpi-card rounded-2xl p-4 shadow-sm">
                        <div class="flex items-center justify-between mb-2">
                            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                                <i class="fas fa-link"></i>
                            </div>
                            <span class="text-[10px] font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-full">LIENS</span>
                        </div>
                        <p class="text-2xl font-bold text-[#0F172A]"><?= $stats['total_curriculum_subjects'] ?? 0 ?></p>
                        <p class="text-xs text-gray-400 mt-1">Matières liées</p>
                    </div>
                    <div class="kpi-card rounded-2xl p-4 shadow-sm">
                        <div class="flex items-center justify-between mb-2">
                            <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <span class="text-[10px] font-semibold text-purple-600 bg-purple-50 px-2 py-1 rounded-full">MOYENNE</span>
                        </div>
                        <p class="text-2xl font-bold text-[#0F172A]"><?= $stats['avg_by_class'] ?? 0 ?></p>
                        <p class="text-xs text-gray-400 mt-1">Moy. matières/classe</p>
                    </div>
                </div>
            </section>

            <!-- LISTE DES CLASSES AVEC LEURS MATIÈRES -->
            <section>
                <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-list text-primary"></i> · Matières par classe
                    </h3>
                </div>

                <?php if (empty($classes)): ?>
                    <div class="text-center py-12 bg-white rounded-2xl border border-slate-200/80 shadow-sm">
                        <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-400">Aucune classe disponible</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($classes as $classe): ?>
                        <div class="mb-6 bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                            <!-- En-tête de la classe -->
                            <div class="flex items-center justify-between px-5 py-3 bg-slate-50 border-b border-slate-200">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                                        <i class="fas fa-chalkboard text-sm"></i>
                                    </div>
                                    <h4 class="font-heading font-bold text-slate-900"><?= htmlspecialchars($classe['nom']) ?></h4>
                                    <span class="text-xs text-gray-400">(<?= $classe['nb_matieres'] ?? 0 ?> matières)</span>
                                </div>
                                <button class="add-matiere-to-classe-btn inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-primary text-white text-xs font-semibold hover:bg-primaryDark transition" data-classe-id="<?= $classe['id'] ?>" data-classe-nom="<?= htmlspecialchars($classe['nom']) ?>">
                                    <i class="fas fa-plus"></i> Ajouter
                                </button>
                            </div>

                            <!-- Liste des matières de la classe -->
                            <div class="p-4">
                                <?php if (empty($classe['matieres'])): ?>
                                    <p class="text-center text-sm text-gray-400 py-4">
                                        <i class="fas fa-book-open text-gray-300 mr-2"></i>
                                        Aucune matière associée à cette classe
                                    </p>
                                <?php else: ?>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                                        <?php foreach ($classe['matieres'] as $matiere): ?>
                                            <div class="flex items-center justify-between bg-gray-50 rounded-lg px-3 py-2 border border-gray-100 hover:border-primary/30 transition group">
                                                <div class="flex items-center gap-2">
                                                    <span class="text-sm font-medium text-slate-700"><?= htmlspecialchars($matiere['name']) ?></span>
                                                    <span class="text-xs text-gray-400">coeff <?= $matiere['coefficient'] ?></span>
                                                </div>
                                                <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition">
                                                    <button class="edit-coeff-btn w-7 h-7 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 flex items-center justify-center" 
                                                            data-id="<?= $matiere['curriculum_subject_id'] ?>"
                                                            data-matiere="<?= htmlspecialchars($matiere['name']) ?>"
                                                            data-coeff="<?= $matiere['coefficient'] ?>">
                                                        <i class="fas fa-edit text-xs"></i>
                                                    </button>
                                                    <button class="remove-matiere-btn w-7 h-7 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 flex items-center justify-center" 
                                                            data-id="<?= $matiere['curriculum_subject_id'] ?>"
                                                            data-matiere="<?= htmlspecialchars($matiere['name']) ?>">
                                                        <i class="fas fa-times text-xs"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>

            <footer class="mt-12 pb-8 text-center text-xs text-slate-400">
                AfricEduc — <span id="footer-school"><?= $_SESSION['school_name'] ?? 'Mon École' ?></span> · Dernière mise à jour : <span id="last-update"></span>
            </footer>
        </main>
    </div>

    <!-- MODAL : AJOUTER UNE MATIÈRE À UNE CLASSE -->
    <div id="addMatiereModal" class="modal-overlay">
        <div class="modal-content bg-white rounded-2xl shadow-2xl p-6 max-w-2xl">
            <div class="flex justify-between items-center mb-4 border-b border-gray-100 pb-4">
                <div>
                    <h3 class="font-heading text-xl font-bold text-slate-900" id="addMatiereTitle">
                        <i class="fas fa-plus-circle text-primary mr-2"></i>Ajouter une matière
                    </h3>
                    <p class="text-xs text-gray-400" id="addMatiereSubtitle">Sélectionner une matière à ajouter à la classe</p>
                </div>
                <button id="close-add-modal" class="text-slate-400 hover:text-slate-600 w-9 h-9 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="addMatiereForm" class="space-y-4">
                <input type="hidden" id="add-classe-id" value="">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Matière <span class="text-red-500">*</span></label>
                    <select id="add-matiere-select" class="w-full rounded-xl border border-slate-200 px-3 py-2.5 bg-gray-50 focus:outline-none focus:border-primary focus:bg-white">
                        <option value="">Sélectionner une matière</option>
                        <?php foreach ($allMatieres as $matiere): ?>
                            <option value="<?= $matiere['id'] ?>"><?= htmlspecialchars($matiere['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Coefficient <span class="text-red-500">*</span></label>
                    <input type="number" step="0.5" id="add-coeff" class="w-full rounded-xl border border-slate-200 px-3 py-2.5 bg-gray-50 focus:outline-none focus:border-primary focus:bg-white" placeholder="Ex: 3" min="0.5" value="1">
                </div>
                <div class="flex gap-3 pt-4 border-t border-gray-100">
                    <button type="submit" class="flex-1 rounded-xl bg-primary px-4 py-2.5 text-sm font-semibold text-white hover:bg-primaryDark transition">
                        <i class="fas fa-save mr-2"></i>Ajouter
                    </button>
                    <button type="button" id="add-cancel" class="flex-1 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL : MODIFIER LE COEFFICIENT -->
    <div id="editCoeffModal" class="modal-overlay">
        <div class="modal-content bg-white rounded-2xl shadow-2xl p-6 max-w-md">
            <div class="flex justify-between items-center mb-4 border-b border-gray-100 pb-4">
                <div>
                    <h3 class="font-heading text-xl font-bold text-slate-900">
                        <i class="fas fa-edit text-primary mr-2"></i>Modifier le coefficient
                    </h3>
                    <p class="text-xs text-gray-400" id="editCoeffMatiere">Matière</p>
                </div>
                <button id="close-coeff-modal" class="text-slate-400 hover:text-slate-600 w-9 h-9 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editCoeffForm" class="space-y-4">
                <input type="hidden" id="edit-curriculum-subject-id" value="">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nouveau coefficient <span class="text-red-500">*</span></label>
                    <input type="number" step="0.5" id="edit-coeff-input" class="w-full rounded-xl border border-slate-200 px-3 py-2.5 bg-gray-50 focus:outline-none focus:border-primary focus:bg-white" min="0.5">
                </div>
                <div class="flex gap-3 pt-4 border-t border-gray-100">
                    <button type="submit" class="flex-1 rounded-xl bg-primary px-4 py-2.5 text-sm font-semibold text-white hover:bg-primaryDark transition">
                        <i class="fas fa-save mr-2"></i>Enregistrer
                    </button>
                    <button type="button" id="coeff-cancel" class="flex-1 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL : CONFIRMATION SUPPRESSION -->
    <div id="deleteModal" class="modal-overlay">
        <div class="modal-content bg-white rounded-2xl shadow-2xl p-6 max-w-md">
            <div class="flex justify-between items-center mb-4 border-b border-gray-100 pb-4">
                <div>
                    <h3 class="font-heading text-xl font-bold text-slate-900 flex items-center gap-2">
                        <i class="fas fa-trash text-red-500"></i> Retirer la matière
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
                        <strong>Attention :</strong> Cette matière sera retirée de la classe. Les notes associées seront supprimées.
                    </p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                    <p class="text-xs text-gray-500 mb-1">Matière à retirer</p>
                    <p class="text-sm font-bold text-[#0F172A]" id="delete-matiere-name">---</p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-600 mb-1 block">Tapez "RETIRER" pour confirmer</label>
                    <input type="text" id="delete-confirm-input" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:border-red-500" placeholder="RETIRER">
                </div>
            </div>
            <div class="mt-6 flex gap-3 justify-end border-t border-gray-100 pt-4">
                <button id="delete-cancel" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700">Annuler</button>
                <button id="delete-confirm" class="rounded-xl bg-red-500 px-4 py-2 text-sm font-semibold text-white opacity-50 cursor-not-allowed" disabled>
                    <i class="fas fa-trash mr-2"></i>Retirer
                </button>
            </div>
        </div>
    </div>

    <div id="toast" class="toast"></div>

    <script>
        // ============================================================
        // GESTION DES MATIÈRES PAR CLASSE AVEC FETCH
        // ============================================================
        (function() {
            const baseUrl = '/AfricEduc/public/index.php?url=matieres';

            function showToast(msg, type = 'success') {
                const toast = document.getElementById('toast');
                toast.textContent = msg;
                toast.style.backgroundColor = type === 'error' ? '#ef4444' : '#10b981';
                toast.classList.add('show');
                setTimeout(() => toast.classList.remove('show'), 3000);
            }

            // ─── AJOUTER UNE MATIÈRE À UNE CLASSE ───
            const addModal = document.getElementById('addMatiereModal');
            const closeAddBtn = document.getElementById('close-add-modal');
            const addCancel = document.getElementById('add-cancel');
            const addForm = document.getElementById('addMatiereForm');

            document.querySelectorAll('.add-matiere-to-classe-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const classeId = this.dataset.classeId;
                    const classeNom = this.dataset.classeNom;

                    document.getElementById('add-classe-id').value = classeId;
                    document.getElementById('addMatiereTitle').textContent = 'Ajouter une matière à ' + classeNom;
                    document.getElementById('addMatiereSubtitle').textContent = 'Sélectionner une matière à ajouter à ' + classeNom;
                    document.getElementById('add-matiere-select').value = '';

                    addModal.classList.add('is-open');
                    document.body.style.overflow = 'hidden';
                });
            });

            function closeAddModal() {
                addModal.classList.remove('is-open');
                document.body.style.overflow = '';
                addForm.reset();
            }

            closeAddBtn.addEventListener('click', closeAddModal);
            addCancel.addEventListener('click', closeAddModal);
            addModal.addEventListener('click', (e) => { if (e.target === addModal) closeAddModal(); });

            addForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                const classeId = document.getElementById('add-classe-id').value;
                const matiereId = document.getElementById('add-matiere-select').value;
                const coefficient = document.getElementById('add-coeff').value;

                if (!matiereId) {
                    showToast('Erreur', 'Veuillez sélectionner une matière', 'error');
                    return;
                }

                const formData = new FormData();
                formData.append('classe_id', classeId);
                formData.append('matiere_id', matiereId);
                formData.append('coefficient', coefficient);

                try {
                    const response = await fetch(baseUrl + '&action=add_matiere_to_classe', {
                        method: 'POST',
                        body: formData
                    });
                    const result = await response.json();

                    if (result.success) {
                        showToast(result.message);
                        closeAddModal();
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showToast(result.error || 'Erreur', 'error');
                    }
                } catch (error) {
                    showToast('Erreur de connexion', 'error');
                }
            });

            // ─── MODIFIER LE COEFFICIENT ───
            const coeffModal = document.getElementById('editCoeffModal');
            const closeCoeffBtn = document.getElementById('close-coeff-modal');
            const coeffCancel = document.getElementById('coeff-cancel');
            const coeffForm = document.getElementById('editCoeffForm');

            document.querySelectorAll('.edit-coeff-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const matiere = this.dataset.matiere;
                    const coeff = this.dataset.coeff;

                    document.getElementById('edit-curriculum-subject-id').value = id;
                    document.getElementById('editCoeffMatiere').textContent = 'Matière: ' + matiere;
                    document.getElementById('edit-coeff-input').value = coeff;

                    coeffModal.classList.add('is-open');
                    document.body.style.overflow = 'hidden';
                });
            });

            function closeCoeffModal() {
                coeffModal.classList.remove('is-open');
                document.body.style.overflow = '';
                coeffForm.reset();
            }

            closeCoeffBtn.addEventListener('click', closeCoeffModal);
            coeffCancel.addEventListener('click', closeCoeffModal);
            coeffModal.addEventListener('click', (e) => { if (e.target === coeffModal) closeCoeffModal(); });

            coeffForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                const id = document.getElementById('edit-curriculum-subject-id').value;
                const coefficient = document.getElementById('edit-coeff-input').value;

                const formData = new FormData();
                formData.append('id', id);
                formData.append('coefficient', coefficient);

                try {
                    const response = await fetch(baseUrl + '&action=update_coeff', {
                        method: 'POST',
                        body: formData
                    });
                    const result = await response.json();

                    if (result.success) {
                        showToast(result.message);
                        closeCoeffModal();
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showToast(result.error || 'Erreur', 'error');
                    }
                } catch (error) {
                    showToast('Erreur de connexion', 'error');
                }
            });

            // ─── RETIRER UNE MATIÈRE ───
            const deleteModal = document.getElementById('deleteModal');
            const closeDeleteBtn = document.getElementById('close-delete-modal');
            const deleteCancel = document.getElementById('delete-cancel');
            const deleteConfirm = document.getElementById('delete-confirm');
            const deleteInput = document.getElementById('delete-confirm-input');
            const deleteName = document.getElementById('delete-matiere-name');
            let pendingDeleteId = null;

            document.querySelectorAll('.remove-matiere-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    pendingDeleteId = this.dataset.id;
                    deleteName.textContent = this.dataset.matiere || 'Matière';
                    deleteInput.value = '';
                    deleteConfirm.disabled = true;
                    deleteConfirm.classList.add('opacity-50', 'cursor-not-allowed');
                    deleteModal.classList.add('is-open');
                    document.body.style.overflow = 'hidden';
                });
            });

            function closeDeleteModal() {
                deleteModal.classList.remove('is-open');
                document.body.style.overflow = '';
                pendingDeleteId = null;
            }

            deleteInput.addEventListener('input', function() {
                if (this.value === 'RETIRER') {
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

                        const response = await fetch(baseUrl + '&action=remove_matiere_from_classe', {
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

            document.getElementById('last-update').textContent = new Date().toLocaleTimeString('fr-FR');
        })();
    </script>
</body>
</html>