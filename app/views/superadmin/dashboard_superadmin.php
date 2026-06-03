<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Super administration | AfricEduc</title>
  <meta name="description" content="Pilotage global de la plateforme AfricEduc — établissements, utilisateurs et indicateurs.">

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: "#7300e9",
            accent: "#99fbe3"
          },
          fontFamily: {
            heading: ["Quicksand", "sans-serif"],
            body: ["Outfit", "sans-serif"]
          }
        }
      }
    };
  </script>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">

  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

  <style>
    body {
      font-family: "Outfit", sans-serif;
    }
    h1, h2, h3, .font-heading {
      font-family: "Quicksand", sans-serif;
    }
    .sidebar-link { transition: all 0.2s ease; }
    .sidebar-link:hover { background-color: rgba(255,255,255,0.1); transform: translateX(4px); }
    .sidebar-link.active { background-color: rgba(153,251,227,0.2); color: #99fbe3; border-left: 3px solid #99fbe3; }
    .submenu { max-height: 0; overflow: hidden; transition: max-height 0.35s ease; }
    .submenu.open { max-height: 320px; }
    #sidebar-overlay { pointer-events: none; opacity: 0; transition: opacity 0.2s ease; }
    #sidebar-overlay.is-open { pointer-events: auto; opacity: 1; }

    .kpi-card {
      border-left-width: 4px;
      transition: all 0.2s ease;
    }
    .kpi-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px -8px rgba(115, 0, 233, 0.15);
    }
  
    tbody tr:nth-child(even) {
      background-color: rgba(248, 250, 252, 0.85);
    }
    tbody tr:hover {
      background-color: rgba(115, 0, 233, 0.04) !important;
    }
  </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">

    <!-- Sidebar -->
 <?php include __DIR__ . '/../components/sidebar.php'; ?>

  <div class="min-h-screen lg:pl-[260px]">
    <header class="sticky top-0 z-30 flex h-16 items-center gap-4 border-b border-slate-200/90 bg-white px-4 shadow-sm backdrop-blur-sm sm:px-6">
      <button type="button" id="btn-menu" class="inline-flex rounded-xl border border-slate-200 p-2 text-slate-700 hover:bg-slate-50 lg:hidden" aria-label="Ouvrir le menu">
        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
      </button>

      <div class="relative min-w-0 flex-1">
        <label for="global-search" class="sr-only">Rechercher un établissement</label>
        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" /></svg>
        </span>
        <input id="global-search" type="search" placeholder="Rechercher un établissement, une ville, un admin…"
          class="w-full max-w-xl rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-4 text-sm text-slate-900 outline-none transition focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20">
      </div>

      <div class="flex shrink-0 items-center gap-3">
        <span class="hidden rounded-full border border-primary/15 bg-violet-50 px-3 py-1 text-xs font-semibold text-primary md:inline-flex">Plateforme</span>
        <button type="button" class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-2 py-1.5 pr-3 shadow-sm transition hover:border-primary/30">
          <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-primary/10 text-sm font-bold text-primary"><?php echo $initials ?? 'SN'; ?></span>
          <span class="hidden text-left text-sm lg:block">
            <span class="block font-medium text-slate-900"><?php echo $adminName ?? 'Administrateur'; ?></span>
            <span class="text-xs text-slate-500">Super administrateur</span>
          </span>
        </button>
      </div>
    </header>

    <main class="px-4 py-6 sm:px-6 lg:px-8">
      
      <!-- BANNIÈRE DE BIENVENUE -->
      <section class="rounded-2xl border border-slate-200/80 bg-gradient-to-br from-white via-white to-primary/5 p-6 shadow-lg sm:p-8">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
          <div>
            <div class="flex flex-wrap items-center gap-3">
              <h1 class="font-heading text-2xl font-bold text-slate-900 sm:text-3xl">
                Bonjour <?php echo $adminName ?? 'Administrateur'; ?> 👋 — <span class="text-primary">AfricEduc</span>
              </h1>
              <span class="inline-flex items-center gap-1.5 rounded-full border border-primary/30 bg-primary/10 px-3 py-1 text-xs font-semibold text-primary shadow-sm">
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                Super Admin
              </span>
            </div>
            <p class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-slate-600">
              <span class="inline-flex items-center gap-1.5">
                <svg class="h-4 w-4 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                  <path d="M6.75 3v2.25M17.25 3v2.25M3 9.75h18M5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V6.75A2.25 2.25 0 0 0 18.75 4.5H5.25A2.25 2.25 0 0 0 3 6.75v12A2.25 2.25 0 0 0 5.25 21Z"/>
                </svg>
                <span id="dash-date"></span>
              </span>
              <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-800 ring-1 ring-emerald-200/80">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                Plateforme active
              </span>
            </p>
          </div>
          <div class="flex gap-2">
            <span class="inline-flex items-center gap-1 rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold text-primary shadow-sm">
              <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/>
              </svg>
              Dernière synchro: <?php echo $lastSync ?? 'aujourd\'hui'; ?>
            </span>
          </div>
        </div>
      </section>

      <!-- KPI Cards -->
      <section class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
        <article class="kpi-card rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm transition-all hover:shadow-md" style="border-left-color: #7300e9;">
          <div class="flex items-start justify-between gap-2">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary">
              <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5V8.25L12 4l8 4.25V19.5" /><path stroke-linecap="round" stroke-linejoin="round" d="M9 19.5V12h6v7.5" /></svg>
            </div>
            <span class="inline-flex items-center gap-0.5 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-bold text-emerald-700"><?php echo $evolutionEtablissements ?? '+0%'; ?></span>
          </div>
          <p class="mt-4 text-3xl font-bold tracking-tight text-slate-900"><?php echo $totalEtablissements ?? '--'; ?></p>
          <p class="text-sm font-medium text-slate-500">Établissements inscrits</p>
        </article>

        <article class="kpi-card rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm transition-all hover:shadow-md" style="border-left-color: #99fbe3;">
          <div class="flex items-start justify-between gap-2">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-accent/30 text-primary">
              <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M4 20a8 8 0 0 1 15.659-2.165" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Z" /></svg>
            </div>
            <span class="inline-flex items-center gap-0.5 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-bold text-emerald-700"><?php echo $evolutionUtilisateurs ?? '+0%'; ?></span>
          </div>
          <p class="mt-4 text-3xl font-bold tracking-tight text-slate-900"><?php echo $totalUtilisateurs ?? '--'; ?></p>
          <p class="text-sm font-medium text-slate-500">Utilisateurs</p>
          <p class="mt-1 text-xs text-slate-400">Admins + agents</p>
        </article>

        <article class="kpi-card rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm transition-all hover:shadow-md" style="border-left-color: #22c55e;">
          <div class="flex items-start justify-between gap-2">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
              <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
            </div>
            <span class="inline-flex items-center gap-0.5 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-bold text-emerald-700"><?php echo $evolutionEleves ?? '+0%'; ?></span>
          </div>
          <p class="mt-4 text-3xl font-bold tracking-tight text-slate-900"><?php echo $totalEleves ?? '--'; ?></p>
          <p class="text-sm font-medium text-slate-500">Élèves inscrits</p>
        </article>

        <article class="kpi-card rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm transition-all hover:shadow-md" style="border-left-color: #ef4444;">
          <div class="flex items-start justify-between gap-2">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-red-700">
              <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.746 3.746 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" /></svg>
            </div>
          </div>
          <p class="mt-4 text-3xl font-bold tracking-tight text-slate-900"><?php echo $etablissementsSuspendus ?? '--'; ?></p>
          <p class="text-sm font-medium text-slate-500">Établissements suspendus</p>
        </article>

        <article class="kpi-card rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm transition-all hover:shadow-md" style="border-left-color: #f59e0b;">
          <div class="flex items-start justify-between gap-2">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-orange-50 text-orange-700">
              <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18" /><path stroke-linecap="round" stroke-linejoin="round" d="M7 16v-5M12 16V8m5 8V11" /></svg>
            </div>
          </div>
          <p class="mt-4 text-3xl font-bold tracking-tight text-slate-900"><?php echo $totalClasses ?? '--'; ?></p>
          <p class="text-sm font-medium text-slate-500">Classes enregistrées</p>
        </article>
      </section>

      <!-- Charts -->
      <section class="mt-10 space-y-8">
        <h2 class="font-heading text-lg font-bold text-slate-900">Analyse des inscriptions &amp; performances</h2>
        <div class="grid gap-6 lg:grid-cols-2">
          <div class="rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm sm:p-6">
            <h3 class="font-heading text-base font-semibold text-slate-900">Inscriptions par mois</h3>
            <p class="mt-1 text-xs text-slate-500">Nouveaux établissements ayant souscrit sur AfricEduc</p>
            <div class="mt-4 h-64"><canvas id="chart-inscriptions"></canvas></div>
          </div>
          <div class="rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm sm:p-6">
            <h3 class="font-heading text-base font-semibold text-slate-900">Répartition des types</h3>
            <p class="mt-1 text-xs text-slate-500">Part du parc clients actuel</p>
            <div class="mx-auto mt-4 flex h-64 max-w-xs items-center justify-center"><canvas id="chart-types"></canvas></div>
          </div>
          <div class="rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm sm:p-6">
            <h3 class="font-heading text-base font-semibold text-slate-900">Croissance des utilisateurs</h3>
            <p class="mt-1 text-xs text-slate-500">Évolution mensuelle du nombre d'utilisateurs actifs</p>
            <div class="mt-4 h-64"><canvas id="chart-users-growth"></canvas></div>
          </div>
          <div class="rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm sm:p-6">
            <h3 class="font-heading text-base font-semibold text-slate-900">Taux de désinscription (Churn)</h3>
            <p class="mt-1 text-xs text-slate-500">Établissements ayant quitté la plateforme par mois</p>
            <div class="mt-4 h-64"><canvas id="chart-churn"></canvas></div>
          </div>
          <div class="rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm sm:p-6 lg:col-span-2">
            <h3 class="font-heading text-base font-semibold text-slate-900">Top 5 des établissements par nombre d’élèves</h3>
            <p class="mt-1 text-xs text-slate-500">Effectifs déclarés sur la plateforme</p>
            <div class="mt-4 h-72"><canvas id="chart-top5"></canvas></div>
          </div>
        </div>
      </section>

      <!-- Table établissements récents -->
      <section class="mt-10 overflow-hidden rounded-2xl border border-slate-200/90 bg-white shadow-sm">
        <div class="flex flex-col gap-2 border-b border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
          <div>
            <h2 class="font-heading text-lg font-bold text-slate-900">Établissements récents</h2>
            <p class="mt-0.5 text-sm text-slate-500">Gestion du statut, abonnement et accès</p>
          </div>
          <div class="flex gap-2">
            <button type="button" class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-50">📊 Exporter CSV</button>
          </div>
        </div>
        <div class="overflow-x-auto">
          <table class="min-w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
              <tr><th class="whitespace-nowrap px-5 py-3 sm:px-6">Nom</th><th class="whitespace-nowrap px-3 py-3">Type</th><th class="whitespace-nowrap px-3 py-3">Sous-type</th><th class="whitespace-nowrap px-3 py-3">Ville</th><th class="whitespace-nowrap px-3 py-3">Admin</th><th class="whitespace-nowrap px-3 py-3">Élèves</th><th class="whitespace-nowrap px-3 py-3">Abonnement</th><th class="whitespace-nowrap px-3 py-3">Statut</th><th class="whitespace-nowrap px-5 py-3 text-right sm:px-6">Actions</th></tr></thead>
            <tbody id="table-body" class="divide-y divide-slate-100 text-slate-700">
              <?php echo $tableRows ?? '<tr><td colspan="9" class="px-5 py-8 text-center text-slate-400">Aucune donnée disponible</td></tr>'; ?>
            </tbody>
          </table>
        </div>
        <div class="flex flex-col items-center justify-between gap-3 border-t border-slate-100 px-5 py-4 sm:flex-row sm:px-6">
          <p class="text-xs text-slate-500" id="page-info"><?php echo $paginationInfo ?? 'Page 1 sur 1'; ?></p>
          <div class="flex items-center gap-2">
            <button type="button" id="pager-prev" class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40">Précédent</button>
            <div id="pager-numbers" class="flex gap-1"><?php echo $paginationLinks ?? '<button class="h-8 min-w-[2rem] rounded-lg bg-primary text-white text-xs font-semibold">1</button>'; ?></div>
            <button type="button" id="pager-next" class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40">Suivant</button>
          </div>
        </div>
      </section>

      <!-- Activité récente -->
      <section class="mt-10 rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm sm:p-6">
        <h2 class="font-heading text-lg font-bold text-slate-900">Activité récente sur la plateforme</h2>
        <p class="mt-1 text-sm text-slate-500">Événements métiers</p>
        <ul class="mt-4 divide-y divide-slate-100">
          <?php echo $activiteListe ?? '<li class="py-4 text-center text-slate-400">Aucune activité récente</li>'; ?>
        </ul>
      </section>

      <footer class="mt-12 pb-8 text-center text-xs text-slate-400">
        AfricEduc Super Admin · données en temps réel
      </footer>
    </main>
  </div>

  <script>
    (function () {
      var primary = "#7300e9";
      var accent = "#99fbe3";

      document.getElementById("dash-date").textContent = new Date().toLocaleDateString("fr-BJ", {
        weekday: "long",
        day: "numeric",
        month: "long",
        year: "numeric"
      });

      var sidebar = document.getElementById("sidebar");
      var overlay = document.getElementById("sidebar-overlay");
      var btnMenu = document.getElementById("btn-menu");
      function openMenu() {
        sidebar.classList.remove("-translate-x-full");
        overlay.classList.add("is-open");
        document.body.style.overflow = "hidden";
      }
      function closeMenu() {
        sidebar.classList.add("-translate-x-full");
        overlay.classList.remove("is-open");
        document.body.style.overflow = "";
      }
      btnMenu.addEventListener("click", openMenu);
      overlay.addEventListener("click", closeMenu);
      window.addEventListener("resize", function () {
        if (window.innerWidth >= 1024) closeMenu();
      });

      if (typeof Chart !== "undefined") {
        Chart.defaults.font.family = "'Outfit', sans-serif";
        Chart.defaults.color = "#64748b";

        var chartInscriptionsData = <?php echo $chartInscriptionsData ?? 'null'; ?>;
        new Chart(document.getElementById("chart-inscriptions"), {
          type: "bar",
          data: chartInscriptionsData || { labels: [], datasets: [] },
          options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: true, position: "bottom" } }, scales: { y: { beginAtZero: true, grid: { color: "rgba(148,163,184,0.2)" } }, x: { grid: { display: false } } } }
        });

        var chartTypesData = <?php echo $chartTypesData ?? 'null'; ?>;
        new Chart(document.getElementById("chart-types"), {
          type: "doughnut",
          data: chartTypesData || { labels: [], datasets: [] },
          options: { responsive: true, maintainAspectRatio: false, cutout: "58%", plugins: { legend: { display: true, position: "bottom" } } }
        });

        var chartUsersGrowthData = <?php echo $chartUsersGrowthData ?? 'null'; ?>;
        new Chart(document.getElementById("chart-users-growth"), {
          type: "line",
          data: chartUsersGrowthData || { labels: [], datasets: [] },
          options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: "bottom" } } }
        });

        var chartChurnData = <?php echo $chartChurnData ?? 'null'; ?>;
        new Chart(document.getElementById("chart-churn"), {
          type: "line",
          data: chartChurnData || { labels: [], datasets: [] },
          options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: "bottom" } } }
        });

        var chartTop5Data = <?php echo $chartTop5Data ?? 'null'; ?>;
        new Chart(document.getElementById("chart-top5"), {
          type: "bar",
          data: chartTop5Data || { labels: [], datasets: [] },
          options: { indexAxis: "y", responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
        });
      }
    })();
  </script>
</body>
</html>