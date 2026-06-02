<?php
/**
 * Vue liste des élèves
 * @var array $students Liste des objets Student
 * @var string $title Titre de la page
 */
 session_start();
$title = $title ?? 'Gestion des élèves';
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($title) ?> | EduManager</title>
  <script src="https://cdn.tailwindcss.com"></script>
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
    .student-photo { width: 40px; height: 40px; object-fit: cover; border-radius: 9999px; }
    .status-badge { display: inline-flex; align-items: center; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.7rem; font-weight: 500; }
    .status-actif { background-color: #dcfce7; color: #166534; }
    .status-inactif { background-color: #fef9c3; color: #854d0e; }
    .status-exclu { background-color: #fee2e2; color: #991b1b; }
    .status-diplome { background-color: #dbeafe; color: #1e40af; }
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 text-slate-800 antialiased">
  <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden"></div>

  <!-- Sidebar -->
        <?php include __DIR__ . '/../components/sidebar.php'; ?>

  <!-- Main content -->
  <div class="min-h-screen lg:pl-[260px]">
    <header class="sticky top-0 z-30 flex h-16 items-center justify-between gap-4 border-b border-slate-200 bg-white/95 px-4 backdrop-blur-md shadow-sm sm:px-6">
      <div class="flex items-center gap-3">
        <button id="btn-menu" class="inline-flex rounded-xl border border-slate-200 p-2 text-slate-700 hover:bg-slate-50 lg:hidden"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7h16M4 12h16M4 17h16"/></svg></button>
        <div><p class="font-heading text-sm font-semibold text-primary sm:text-base" id="school-name-header"></p><p class="text-xs text-slate-500" id="school-location"></p></div>
      </div>
      <div class="flex items-center gap-3">
        <span class="hidden rounded-full border border-accent/50 bg-accent/20 px-3 py-1 text-xs font-medium text-slate-800 sm:inline-flex" id="school-year"></span>
        <button class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-2 py-1.5 pr-3 shadow-sm">
          <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-primary to-primaryDark text-sm font-bold text-white shadow-md"></span>
          <span class="hidden text-left text-sm sm:block"><span class="block font-medium text-slate-900"></span><span class="text-xs text-slate-500"></span></span>
        </button>
      </div>
    </header>

    <main class="px-4 py-6 sm:px-6 lg:px-8">
      <div id="dynamic-content">
        <!-- Header section -->
        <div class="mb-6">
          <h1 class="font-heading text-2xl font-bold text-slate-900 sm:text-3xl"><?= htmlspecialchars($title) ?></h1>
          <p class="mt-1 text-sm text-slate-600">Liste complète et suivi des élèves</p>
        </div>

        <!-- KPI Cards avec données dynamiques -->
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 mb-8">
          <div class="kpi-card rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm" style="border-left-color: #7300e9;">
            <p class="text-xs font-semibold uppercase text-slate-500">Total élèves</p>
            <p class="text-3xl font-bold text-slate-900"></p> 
          </div>
          <div class="kpi-card rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm" style="border-left-color: #22c55e;">
            <p class="text-xs font-semibold uppercase text-slate-500">Élèves actifs</p>
            <p class="text-3xl font-bold text-slate-900">
              
            </p>
          </div>
          <div class="kpi-card rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm" style="border-left-color: #ef4444;">
            <p class="text-xs font-semibold uppercase text-slate-500">Filles / Garçons</p>
            <p class="text-xl font-bold text-slate-900">
               F / 
             G
            </p>
          </div>
        </div>

        <!-- Filtres et bouton ajouter -->
        <div class="flex flex-wrap justify-between gap-4 mb-6">
          <div class="flex flex-wrap gap-3">
            <div class="relative">
              <input type="text" id="search-students" placeholder="Rechercher (nom, prénom, matricule)" class="w-64 rounded-xl border border-slate-200 bg-white px-4 py-2 pl-10 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
              <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z"/></svg>
              </span>
            </div>
            <div class="relative">
              <select id="filter-status" class="appearance-none rounded-xl border border-slate-200 bg-white px-4 py-2 pr-8 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
                <option value="">Tous les statuts</option>
                <option value="actif">Actifs</option>
                <option value="inactif">Inactifs</option>
                <option value="exclu">Exclus</option>
                <option value="diplome">Diplômés</option>
              </select>
              <svg class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m19 9-7 7-7-7"/></svg>
            </div>
            <button id="reset-filters" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Réinitialiser</button>
          </div>
          <a href="/students/create" class="action-button inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primaryDark">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Ajouter un élève
          </a>
        </div>

        <!-- Tableau des élèves -->
        <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-md">
          <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
              <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr>
                  <th class="px-5 py-4 sm:px-6">Photo</th>
                  <th class="px-3 py-4">Matricule</th>
                  <th class="px-3 py-4">Nom complet</th>
                  <th class="px-3 py-4">Contact</th>
                  <th class="px-3 py-4">Statut</th>
                  <th class="px-5 py-4 text-right">Actions</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100" id="students-table-body">
                <?php if (empty($students)): ?>
                  <tr>
                    <td colspan="6" class="px-5 py-12 text-center text-slate-500">
                      <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                      </svg>
                      <p class="mt-2">Aucun élève trouvé</p>
                      <a href="/students/create" class="mt-4 inline-flex items-center px-3 py-1 text-sm font-medium text-primary hover:underline">
                        Ajouter le premier élève
                      </a>
                    </td>
                  </tr>
                <?php else: ?>
                  <?php foreach ($students as $student): ?>
                    <tr class="hover:bg-slate-50/80 transition-all student-row" data-status="<?= htmlspecialchars($student['status']) ?>" data-name="<?= strtolower(htmlspecialchars($student['firstname'] . ' ' . $student['lastname'])) ?>" data-matricule="<?= strtolower(htmlspecialchars($student['matricule'])) ?>">
                      <td class="px-5 py-4">
                        <?php if (!empty($student['photo'])): ?>
                          <img src="/uploads/<?= htmlspecialchars($student['photo']) ?>" class="student-photo w-10 h-10 rounded-full object-cover">
                        <?php else: ?>
                          <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary to-primaryDark flex items-center justify-center text-white font-bold text-sm">
                            <?= strtoupper(substr($student['firstname'], 0, 1)) . strtoupper(substr($student['lastname'], 0, 1)) ?>
                          </div>
                        <?php endif; ?>
                      </td>
                      <td class="px-3 py-4 font-mono text-xs text-slate-600"><?= htmlspecialchars($student['matricule']) ?></td>
                      <td class="px-3 py-4">
                        <div class="font-medium text-slate-900"><?= htmlspecialchars($student['firstname'] . ' ' . $student['lastname']) ?></div>
                        <div class="text-xs text-slate-500"><?= $student['gender'] === 'M' ? 'Masculin' : 'Féminin' ?></div>
                      </td>
                      <td class="px-3 py-4">
                        <div class="text-sm"><?= htmlspecialchars($student['email'] ?? '-') ?></div>
                        <div class="text-xs text-slate-500"><?= htmlspecialchars($student['phone'] ?? '-') ?></div>
                      </td>
                      <td class="px-3 py-4">
                        <?php
                        $statusClass = match($student['status']) {
                          'actif' => 'status-actif',
                          'inactif' => 'status-inactif',
                          'exclu' => 'status-exclu',
                          'diplome' => 'status-diplome',
                          default => 'status-inactif'
                        };
                        ?>
                        <span class="status-badge <?= $statusClass ?>">
                          <?= ucfirst($student['status']) ?>
                        </span>
                      </td>
                      <td class="px-5 py-4 text-right">
                        <div class="flex justify-end gap-2">
                          <a href="/students/show?id=<?= $student['id'] ?>" class="text-slate-500 hover:text-primary transition" title="Voir détails">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                              <path d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                              <path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                          </a>
                          <a href="/students/edit?id=<?= $student['id'] ?>" class="text-primary hover:underline">Modifier</a>
                          <a href="/students/delete?id=<?= $student['id'] ?>" class="text-red-600 hover:underline" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élève ?')">Supprimer</a>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <footer class="mt-12 pb-8 text-center text-xs text-slate-400">
        EduManager — <span id="footer-school">Collège Saint-Michel</span> · Dernière mise à jour : <span id="last-update"></span>
      </footer>
    </main>
  </div>

  <!-- Modale générique -->
  <div id="modal-generic" class="modal-overlay">
    <div class="modal-content bg-white rounded-2xl shadow-2xl p-6">
      <div class="flex justify-between items-center mb-4">
        <h3 class="font-heading text-xl font-bold text-slate-900" id="modal-title">Titre</h3>
        <button id="close-modal" class="text-slate-400 hover:text-slate-600">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>
      <div id="modal-body" class="text-slate-700"></div>
      <div class="mt-6 flex justify-end">
        <button id="modal-close-btn" class="rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white">Fermer</button>
      </div>
    </div>
  </div>

  <div id="toast" class="toast"></div>

  <script>
    // Filtres côté client
    function filterStudents() {
      const searchTerm = document.getElementById('search-students')?.value.toLowerCase() || '';
      const statusFilter = document.getElementById('filter-status')?.value || '';
      const rows = document.querySelectorAll('.student-row');
      
      rows.forEach(row => {
        const name = row.dataset.name || '';
        const matricule = row.dataset.matricule || '';
        const status = row.dataset.status || '';
        
        const matchesSearch = name.includes(searchTerm) || matricule.includes(searchTerm);
        const matchesStatus = !statusFilter || status === statusFilter;
        
        row.style.display = matchesSearch && matchesStatus ? '' : 'none';
      });
    }

    function showToast(msg, type = 'success') {
      const toast = document.getElementById("toast");
      toast.innerText = msg;
      toast.style.backgroundColor = type === "error" ? "#ef4444" : "#10b981";
      toast.classList.add("show");
      setTimeout(() => toast.classList.remove("show"), 3000);
    }

    // Initialisation
    function init() {
      document.getElementById("last-update").innerText = new Date().toLocaleString("fr-FR");
      
      // Sidebar toggles
      document.querySelectorAll(".sidebar-toggle").forEach(btn => {
        const id = btn.getAttribute("data-submenu");
        const panel = document.getElementById(id);
        const chev = btn.querySelector(".chevron");
        if (panel) btn.addEventListener("click", () => { 
          const open = panel.classList.toggle("open"); 
          if (chev) chev.style.transform = open ? "rotate(180deg)" : ""; 
        });
      });

      // Menu mobile
      const sidebar = document.getElementById("sidebar");
      const overlay = document.getElementById("sidebar-overlay");
      const btnMenu = document.getElementById("btn-menu");
      function openMenu() { sidebar.classList.remove("-translate-x-full"); overlay.classList.add("is-open"); document.body.style.overflow = "hidden"; }
      function closeMenu() { sidebar.classList.add("-translate-x-full"); overlay.classList.remove("is-open"); document.body.style.overflow = ""; }
      btnMenu?.addEventListener("click", openMenu);
      overlay?.addEventListener("click", closeMenu);
      window.addEventListener("resize", () => { if (window.innerWidth >= 1024) closeMenu(); });

      // Filtres
      const searchInput = document.getElementById("search-students");
      const statusSelect = document.getElementById("filter-status");
      const resetBtn = document.getElementById("reset-filters");
      
      if (searchInput) searchInput.addEventListener("input", filterStudents);
      if (statusSelect) statusSelect.addEventListener("change", filterStudents);
      if (resetBtn) {
        resetBtn.addEventListener("click", () => {
          if (searchInput) searchInput.value = "";
          if (statusSelect) statusSelect.value = "";
          filterStudents();
          showToast("Filtres réinitialisés");
        });
      }

      // Modale
      const modal = document.getElementById("modal-generic");
      const modalTitle = document.getElementById("modal-title");
      const modalBody = document.getElementById("modal-body");
      window.openModal = function(title, bodyHtml) { 
        modalTitle.innerText = title; 
        modalBody.innerHTML = bodyHtml; 
        modal.classList.add("is-open"); 
        document.body.style.overflow = "hidden"; 
      };
      window.closeModal = function() { 
        modal.classList.remove("is-open"); 
        document.body.style.overflow = ""; 
      };
      document.getElementById("close-modal")?.addEventListener("click", () => window.closeModal());
      document.getElementById("modal-close-btn")?.addEventListener("click", () => window.closeModal());
      modal?.addEventListener("click", (e) => { if (e.target === modal) window.closeModal(); });
    }

    init();
  </script>
</body>
</html>
