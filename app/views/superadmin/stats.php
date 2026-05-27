<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Statistiques avancées | EduManager</title>
  <meta name="description" content="Analyse approfondie des performances académiques — EduManager">

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
    .sidebar-link {
      transition: background-color 0.15s ease, color 0.15s ease;
    }
    .sidebar-link:hover {
      background-color: rgba(255, 255, 255, 0.1);
    }
    .sidebar-link.active {
      background-color: rgba(153, 251, 227, 0.18);
      color: #99fbe3;
    }
    .kpi-card {
      border-left-width: 4px;
      transition: all 0.2s ease;
    }
    .kpi-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px -8px rgba(115, 0, 233, 0.15);
    }
    #sidebar-overlay {
      pointer-events: none;
      opacity: 0;
      transition: opacity 0.2s ease;
    }
    #sidebar-overlay.is-open {
      pointer-events: auto;
      opacity: 1;
    }
  </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">
  <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden" aria-hidden="true"></div>

  <!-- SIDEBAR – IDENTIQUE (avec Statistiques avancées actif) -->
  <aside id="sidebar" class="fixed left-0 top-0 z-50 flex h-full w-[260px] -translate-x-full flex-col bg-gradient-to-b from-primary to-[#5a00b8] text-white shadow-2xl transition-transform duration-200 lg:translate-x-0">
    <div class="flex h-16 items-center gap-3 border-b border-white/15 px-4">
      <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white/10 text-white transition group-hover:rotate-6">
        <svg width="30px" height="30px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="none" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.16"></g><g id="SVGRepo_iconCarrier"> <path d="m14.25 9.25v-3.25l-6.25-3.25-6.25 3.25 6.25 3.25 3.25-1.5v3.5c0 1-1.5 2-3.25 2s-3.25-1-3.25-2v-3.5"></path> </g></svg>
      </span>
      <div>
        <span class="font-heading block text-sm font-bold">EduManager</span>
        <span class="text-[10px] uppercase tracking-wider text-white/70">Super admin</span>
      </div>
    </div>

    <nav class="flex-1 space-y-0.5 overflow-y-auto px-2 py-4 text-sm" aria-label="Navigation">
      <a href="dashboard_superadmin.php" class="sidebar-link active flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h3A2.25 2.25 0 0 1 11.25 6v3A2.25 2.25 0 0 1 9 11.25H6A2.25 2.25 0 0 1 3.75 9V6Z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6A2.25 2.25 0 0 1 15.75 3.75h3A2.25 2.25 0 0 1 21 6v3A2.25 2.25 0 0 1 18.75 11.25h-3A2.25 2.25 0 0 1 13.5 9V6Z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 15A2.25 2.25 0 0 1 6 12.75h3A2.25 2.25 0 0 1 11.25 15v3A2.25 2.25 0 0 1 9 20.25H6A2.25 2.25 0 0 1 3.75 18v-3Z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 15A2.25 2.25 0 0 1 15.75 12.75h3A2.25 2.25 0 0 1 21 15v3A2.25 2.25 0 0 1 18.75 20.25h-3A2.25 2.25 0 0 1 13.5 18v-3Z" />
        </svg>
        Dashboard
      </a>
      <a href="etablissements.php" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5V8.25L12 4l8 4.25V19.5" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 19.5V12h6v7.5" />
        </svg>
        Établissements
      </a>
      <a href="users.php" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 20a8 8 0 0 1 15.659-2.165" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Z" />
        </svg>
        Utilisateurs
      </a>
      <a href="students.php" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 20a8 8 0 0 1 15.659-2.165" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Z" />
        </svg>
        Élèves
      </a>
      <a href="classes.php" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 20a8 8 0 0 1 15.659-2.165" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Z" />
        </svg>
        Classes
      </a>
      <a href="notes.php" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 20a8 8 0 0 1 15.659-2.165" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Z" />
        </svg>
        Notes
      </a>
      <a href="stats.php" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M7 16v-5M12 16V8m5 8V11" />
        </svg>
        Statistiques globales
      </a>
      <a href="profil.php" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M7 16v-5M12 16V8m5 8V11" />
        </svg>
        Mon compte
      </a>
      <a href="settings.php" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 3.084-1.756 3.51 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 3.084 0 3.51a1.724 1.724 0 0 0-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0-2.572 1.065c-.426 1.756-3.084 1.756-3.51 0a1.724 1.724 0 0 0-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0-1.065-2.572c-1.756-.426-1.756-3.084 0-3.51a1.724 1.724 0 0 0 1.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065Z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
        </svg>
        Paramètres systèmes
      </a>
      <div class="mt-6 border-t border-white/15 pt-4">
        <a href="login.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 text-red-200 hover:bg-red-500/20 hover:text-white">
          <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
          </svg>
          Déconnexion
        </a>
      </div>
    </nav>
  </aside>

  <div class="min-h-screen lg:pl-[260px]">
    <!-- HEADER IDENTIQUE -->
    <header class="sticky top-0 z-30 flex h-16 items-center gap-4 border-b border-slate-200/90 bg-white px-4 shadow-sm backdrop-blur-sm sm:px-6">
      <button type="button" id="btn-menu" class="inline-flex rounded-xl border border-slate-200 p-2 text-slate-700 hover:bg-slate-50 lg:hidden" aria-label="Ouvrir le menu">
        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
      </button>

      <div class="relative min-w-0 flex-1">
        <label for="global-search" class="sr-only">Rechercher</label>
        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" /></svg>
        </span>
        <input id="global-search" type="search" placeholder="Rechercher un élève, une classe…"
          class="w-full max-w-xl rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-4 text-sm text-slate-900 outline-none transition focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20">
      </div>

      <div class="flex shrink-0 items-center gap-3">
        <span class="hidden rounded-full border border-primary/15 bg-violet-50 px-3 py-1 text-xs font-semibold text-primary md:inline-flex">Plateforme</span>
        <button type="button" class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-2 py-1.5 pr-3 shadow-sm transition hover:border-primary/30">
          <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-primary/10 text-sm font-bold text-primary">SN</span>
          <span class="hidden text-left text-sm lg:block">
            <span class="block font-medium text-slate-900">Sèdjro Nazaire</span>
            <span class="text-xs text-slate-500">Super administrateur</span>
          </span>
        </button>
      </div>
    </header>

    <main class="px-4 py-6 sm:px-6 lg:px-8">
      <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
        <div>
          <h1 class="font-heading text-2xl font-bold text-slate-900 sm:text-3xl">Statistiques avancées</h1>
          <p class="mt-1 text-sm text-slate-600">Analyse académique – du primaire au doctorat</p>
        </div>
        <p class="text-xs font-medium text-slate-500">Année universitaire 2024-2025</p>
      </div>

      <!-- KPI Cards -->
      <section class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Moyenne générale -->
        <article class="kpi-card rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm hover:shadow-md" style="border-left-color: #7300e9;">
          <div class="flex items-start justify-between gap-2">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary">
              <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z" />
              </svg>
            </div>
          </div>
          <p class="mt-4 text-3xl font-bold tracking-tight text-slate-900">14.2</p>
          <p class="text-sm font-medium text-slate-500">Moyenne générale</p>
          <p class="mt-1 text-xs text-slate-400">/20 (tous niveaux)</p>
        </article>

        <!-- Taux de réussite global -->
        <article class="kpi-card rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm hover:shadow-md" style="border-left-color: #22c55e;">
          <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
          </div>
          <p class="mt-4 text-3xl font-bold tracking-tight text-slate-900">78.5%</p>
          <p class="text-sm font-medium text-slate-500">Taux de réussite</p>
          <p class="mt-1 text-xs text-slate-400">(moyenne ≥ 10/20)</p>
        </article>

        <!-- Meilleur élève -->
        <article class="kpi-card rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm hover:shadow-md" style="border-left-color: #f59e0b;">
          <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-orange-50 text-orange-700">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
            </svg>
          </div>
          <p class="mt-4 text-xl font-bold tracking-tight text-slate-900">DIALLO Aminata</p>
          <p class="text-sm font-medium text-slate-500">Meilleure moyenne</p>
          <p class="mt-1 text-xs text-slate-400">18.2 / 20 (Doctorat)</p>
        </article>

        <!-- Effectif total -->
        <article class="kpi-card rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm hover:shadow-md" style="border-left-color: #ec489a;">
          <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-pink-50 text-pink-600">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
          </div>
          <p class="mt-4 text-3xl font-bold tracking-tight text-slate-900">12 847</p>
          <p class="text-sm font-medium text-slate-500">Élèves inscrits</p>
          <p class="mt-1 text-xs text-slate-400">tous cycles confondus</p>
        </article>
      </section>

      <!-- Graphiques détaillés -->
      <section class="mt-10 space-y-8">
        <h2 class="font-heading text-lg font-bold text-slate-900">Performances par niveau & période</h2>
        <div class="grid gap-6 lg:grid-cols-2">
          <!-- Évolution des moyennes par trimestre (tous niveaux) -->
          <div class="rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm sm:p-6">
            <h3 class="font-heading text-base font-semibold text-slate-900">Moyenne générale par trimestre</h3>
            <p class="mt-1 text-xs text-slate-500">Évolution sur l'année (toutes classes)</p>
            <div class="mt-4 h-64">
              <canvas id="chart-quarterly"></canvas>
            </div>
          </div>

          <!-- Évolution par semestre -->
          <div class="rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm sm:p-6">
            <h3 class="font-heading text-base font-semibold text-slate-900">Moyenne par semestre</h3>
            <p class="mt-1 text-xs text-slate-500">Comparaison S1 vs S2 (tous niveaux)</p>
            <div class="mt-4 h-64">
              <canvas id="chart-semester"></canvas>
            </div>
          </div>

          <!-- Taux de réussite détaillé par classe (du primaire au doctorat) -->
          <div class="rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm sm:p-6 lg:col-span-2">
            <h3 class="font-heading text-base font-semibold text-slate-900">Taux de réussite par classe / cycle</h3>
            <p class="mt-1 text-xs text-slate-500">Pourcentage d'élèves ayant obtenu une moyenne ≥ 10/20</p>
            <div class="mt-4 h-80">
              <canvas id="chart-success-by-level"></canvas>
            </div>
          </div>

          <!-- Répartition des élèves par classe (jusqu'au doctorat) -->
          <div class="rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm sm:p-6 lg:col-span-2">
            <h3 class="font-heading text-base font-semibold text-slate-900">Répartition des effectifs par classe</h3>
            <p class="mt-1 text-xs text-slate-500">Du primaire au doctorat</p>
            <div class="mt-4 h-80">
              <canvas id="chart-distribution"></canvas>
            </div>
          </div>
        </div>
      </section>

      <!-- Tableau des meilleurs élèves par niveau -->
      <section class="mt-10 overflow-hidden rounded-2xl border border-slate-200/90 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-5 py-4 sm:px-6">
          <h2 class="font-heading text-lg font-bold text-slate-900">Top élèves par niveau</h2>
          <p class="mt-0.5 text-sm text-slate-500">Moyenne générale (toutes matières)</p>
        </div>
        <div class="overflow-x-auto">
          <table class="min-w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
              <tr>
                <th class="px-5 py-3 sm:px-6">Niveau</th>
                <th class="px-3 py-3">Élève</th>
                <th class="px-3 py-3">Moyenne /20</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              <tr class="hover:bg-primary/4"><td class="px-5 py-3 font-medium sm:px-6">Doctorat</td><td class="px-3 py-3">DIALLO Aminata</td><td class="px-3 py-3 font-semibold text-primary">18.2</td></tr>
              <tr class="hover:bg-primary/4"><td class="px-5 py-3 font-medium sm:px-6">Master 2</td><td class="px-3 py-3">KONE Ibrahim</td><td class="px-3 py-3 font-semibold text-primary">17.8</td></tr>
              <tr class="hover:bg-primary/4"><td class="px-5 py-3 font-medium sm:px-6">Licence 3</td><td class="px-3 py-3">ZINSOU Espoir</td><td class="px-3 py-3 font-semibold text-primary">17.5</td></tr>
              <tr class="hover:bg-primary/4"><td class="px-5 py-3 font-medium sm:px-6">Terminale</td><td class="px-3 py-3">KOUADIO Marie</td><td class="px-3 py-3 font-semibold text-primary">16.9</td></tr>
              <tr class="hover:bg-primary/4"><td class="px-5 py-3 font-medium sm:px-6">3ème</td><td class="px-3 py-3">AÏSSI Pélagie</td><td class="px-3 py-3 font-semibold text-primary">16.2</td></tr>
            </tbody>
          </table>
        </div>
      </section>

      <footer class="mt-12 pb-8 text-center text-xs text-slate-400">
        EduManager Super Admin · Données réelles simulées
      </footer>
    </main>
  </div>

  <script>
    (function () {
      const primary = "#7300e9";
      const accent = "#99fbe3";

      // Sidebar menu
      const sidebar = document.getElementById("sidebar");
      const overlay = document.getElementById("sidebar-overlay");
      const btnMenu = document.getElementById("btn-menu");
      function openMenu() { sidebar.classList.remove("-translate-x-full"); overlay.classList.add("is-open"); document.body.style.overflow = "hidden"; }
      function closeMenu() { sidebar.classList.add("-translate-x-full"); overlay.classList.remove("is-open"); document.body.style.overflow = ""; }
      btnMenu.addEventListener("click", openMenu);
      overlay.addEventListener("click", closeMenu);
      window.addEventListener("resize", () => { if (window.innerWidth >= 1024) closeMenu(); });

      // Charts
      if (typeof Chart !== "undefined") {
        Chart.defaults.font.family = "'Outfit', sans-serif";
        Chart.defaults.color = "#64748b";

        // 1. Évolution trimestrielle
        new Chart(document.getElementById("chart-quarterly"), {
          type: "line",
          data: {
            labels: ["T1", "T2", "T3"],
            datasets: [{
              label: "Moyenne générale",
              data: [13.2, 14.0, 14.2],
              borderColor: primary,
              backgroundColor: "rgba(115, 0, 233, 0.05)",
              fill: true,
              tension: 0.3,
              pointBackgroundColor: primary,
              pointBorderColor: "#fff",
              pointRadius: 5
            }]
          },
          options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: "bottom" } }, scales: { y: { min: 10, max: 16 } } }
        });

        // 2. Évolution semestrielle
        new Chart(document.getElementById("chart-semester"), {
          type: "bar",
          data: {
            labels: ["Semestre 1", "Semestre 2"],
            datasets: [{
              label: "Moyenne générale",
              data: [13.6, 14.4],
              backgroundColor: primary,
              borderRadius: 8
            }]
          },
          options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: "bottom" } }, scales: { y: { min: 10, max: 16 } } }
        });

        // 3. Taux de réussite par niveau (primaire → doctorat)
        const niveaux = [
          "Primaire", "6ème", "5ème", "4ème", "3ème",
          "Seconde", "Première", "Terminale",
          "Licence 1", "Licence 2", "Licence 3",
          "Master 1", "Master 2", "Doctorat"
        ];
        const tauxReussite = [92, 82, 75, 68, 79, 74, 81, 86, 72, 68, 74, 70, 73, 68];

        new Chart(document.getElementById("chart-success-by-level"), {
          type: "bar",
          data: {
            labels: niveaux,
            datasets: [{
              label: "Taux de réussite (%)",
              data: tauxReussite,
              backgroundColor: primary,
              borderRadius: 6,
              maxBarThickness: 35
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false }, tooltip: { callbacks: { label: (ctx) => ctx.raw + "%" } } },
            scales: { y: { beginAtZero: true, max: 100, ticks: { callback: (val) => val + "%" } }, x: { ticks: { rotation: -30, autoSkip: true } } }
          }
        });

        // 4. Répartition des effectifs par niveau (données réalistes)
        const effectifs = [1240, 342, 298, 315, 387, 412, 398, 356, 890, 845, 782, 512, 478, 345];
        new Chart(document.getElementById("chart-distribution"), {
          type: "doughnut",
          data: {
            labels: niveaux,
            datasets: [{
              data: effectifs,
              backgroundColor: [primary, accent, "#f59e0b", "#ef4444", "#10b981", "#8b5cf6", "#ec489a", "#06b6d4", "#f97316", "#84cc16", "#d946ef", "#14b8a6", "#f43f5e", "#3b82f6"],
              borderWidth: 2,
              borderColor: "#ffffff"
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: true,
            cutout: "55%",
            plugins: {
              legend: { position: "right", labels: { boxWidth: 12, font: { size: 11 } } },
              tooltip: { callbacks: { label: (ctx) => `${ctx.label}: ${ctx.raw} élèves` } }
            }
          }
        });
      }

      // Dummy search (UI consistency)
      const searchInput = document.getElementById("global-search");
      if (searchInput) searchInput.addEventListener("input", () => {});
    })();
  </script>
</body>
</html>
