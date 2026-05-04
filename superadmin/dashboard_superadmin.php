<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Super administration | EduManager</title>
  <meta name="description" content="Pilotage global de la plateforme EduManager — établissements, utilisateurs et indicateurs.">

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
    tbody tr:nth-child(even) {
      background-color: rgba(248, 250, 252, 0.85);
    }
    tbody tr:hover {
      background-color: rgba(115, 0, 233, 0.04) !important;
    }
  </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">
  <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden" aria-hidden="true"></div>

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
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M7 16v-5M12 16V8m5 8V11" />
        </svg>
        Statistiques globales
      </a>
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 3.084-1.756 3.51 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 3.084 0 3.51a1.724 1.724 0 0 0-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0-2.572 1.065c-.426 1.756-3.084 1.756-3.51 0a1.724 1.724 0 0 0-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0-1.065-2.572c-1.756-.426-1.756-3.084 0-3.51a1.724 1.724 0 0 0 1.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065Z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
        </svg>
        Paramètres système
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
          <h1 class="font-heading text-2xl font-bold text-slate-900 sm:text-3xl">Vue d’ensemble de la plateforme</h1>
          <p class="mt-1 text-sm text-slate-600">Écoles inscrites sur EduManager — Afrique de l’Ouest</p>
        </div>
        <p class="text-xs font-medium text-slate-500">Mise à jour · <span id="dash-date"></span></p>
      </div>

      <!-- KPI Cards - 5 cards properly aligned -->
      <section class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
        <!-- Établissements inscrits -->
        <article class="kpi-card rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm transition-all hover:shadow-md" style="border-left-color: #7300e9;">
          <div class="flex items-start justify-between gap-2">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary">
              <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5V8.25L12 4l8 4.25V19.5" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19.5V12h6v7.5" />
              </svg>
            </div>
            <span class="inline-flex items-center gap-0.5 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-bold text-emerald-700">
              <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m5 15 7-7 7 7"/></svg>
              +6,8%
            </span>
          </div>
          <p class="mt-4 text-3xl font-bold tracking-tight text-slate-900">47</p>
          <p class="text-sm font-medium text-slate-500">Établissements inscrits</p>
        </article>

        <!-- Total utilisateurs -->
        <article class="kpi-card rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm transition-all hover:shadow-md" style="border-left-color: #99fbe3;">
          <div class="flex items-start justify-between gap-2">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-accent/30 text-primary">
              <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 20a8 8 0 0 1 15.659-2.165" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Z" />
              </svg>
            </div>
            <span class="inline-flex items-center gap-0.5 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-bold text-emerald-700">
              <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m5 15 7-7 7 7"/></svg>
              +12,4%
            </span>
          </div>
          <p class="mt-4 text-3xl font-bold tracking-tight text-slate-900">189</p>
          <p class="text-sm font-medium text-slate-500">Utilisateurs</p>
          <p class="mt-1 text-xs text-slate-400">Admins + agents</p>
        </article>

        <!-- Élèves inscrits -->
        <article class="kpi-card rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm transition-all hover:shadow-md" style="border-left-color: #22c55e;">
          <div class="flex items-start justify-between gap-2">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
              <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
              </svg>
            </div>
            <span class="inline-flex items-center gap-0.5 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-bold text-emerald-700">
              <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m5 15 7-7 7 7"/></svg>
              +8,2%
            </span>
          </div>
          <p class="mt-4 text-3xl font-bold tracking-tight text-slate-900">4 250</p>
          <p class="text-sm font-medium text-slate-500">Élèves inscrits</p>
        </article>

        <!-- Établissements suspendus -->
        <article class="kpi-card rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm transition-all hover:shadow-md" style="border-left-color: #ef4444;">
          <div class="flex items-start justify-between gap-2">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-red-700">
              <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.746 3.746 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
              </svg>
            </div>
          </div>
          <p class="mt-4 text-3xl font-bold tracking-tight text-slate-900">3</p>
          <p class="text-sm font-medium text-slate-500">Établissements suspendus</p>
        </article>

        <!-- Classes enregistrées -->
        <article class="kpi-card rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm transition-all hover:shadow-md" style="border-left-color: #f59e0b;">
          <div class="flex items-start justify-between gap-2">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-orange-50 text-orange-700">
              <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 16v-5M12 16V8m5 8V11" />
              </svg>
            </div>
          </div>
          <p class="mt-4 text-3xl font-bold tracking-tight text-slate-900">187</p>
          <p class="text-sm font-medium text-slate-500">Classes enregistrées</p>
        </article>
      </section>

      <!-- Charts -->
      <section class="mt-10 space-y-8">
        <h2 class="font-heading text-lg font-bold text-slate-900">Analyse des inscriptions &amp; performances</h2>
        <div class="grid gap-6 lg:grid-cols-2">
          <!-- Inscriptions par mois -->
          <div class="rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm sm:p-6">
            <h3 class="font-heading text-base font-semibold text-slate-900">Inscriptions par mois</h3>
            <p class="mt-1 text-xs text-slate-500">Nouveaux établissements ayant souscrit sur EduManager</p>
            <div class="mt-4 h-64">
              <canvas id="chart-inscriptions"></canvas>
            </div>
          </div>

          <!-- Répartition des types -->
          <div class="rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm sm:p-6">
            <h3 class="font-heading text-base font-semibold text-slate-900">Répartition des types</h3>
            <p class="mt-1 text-xs text-slate-500">Part du parc clients actuel</p>
            <div class="mx-auto mt-4 flex h-64 max-w-xs items-center justify-center">
              <canvas id="chart-types"></canvas>
            </div>
          </div>

          <!-- Croissance utilisateurs -->
          <div class="rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm sm:p-6">
            <h3 class="font-heading text-base font-semibold text-slate-900">Croissance des utilisateurs</h3>
            <p class="mt-1 text-xs text-slate-500">Évolution mensuelle du nombre d'utilisateurs actifs</p>
            <div class="mt-4 h-64">
              <canvas id="chart-users-growth"></canvas>
            </div>
          </div>

          <!-- Taux de désinscription -->
          <div class="rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm sm:p-6">
            <h3 class="font-heading text-base font-semibold text-slate-900">Taux de désinscription (Churn)</h3>
            <p class="mt-1 text-xs text-slate-500">Établissements ayant quitté la plateforme par mois</p>
            <div class="mt-4 h-64">
              <canvas id="chart-churn"></canvas>
            </div>
          </div>

          <!-- Top 5 établissements -->
          <div class="rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm sm:p-6 lg:col-span-2">
            <h3 class="font-heading text-base font-semibold text-slate-900">Top 5 des établissements par nombre d’élèves</h3>
            <p class="mt-1 text-xs text-slate-500">Effectifs déclarés sur la plateforme</p>
            <div class="mt-4 h-72">
              <canvas id="chart-top5"></canvas>
            </div>
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
              <tr>
                <th class="whitespace-nowrap px-5 py-3 sm:px-6">Nom</th>
                <th class="whitespace-nowrap px-3 py-3">Type</th>
                <th class="whitespace-nowrap px-3 py-3">Sous-type</th>
                <th class="whitespace-nowrap px-3 py-3">Ville</th>
                <th class="whitespace-nowrap px-3 py-3">Admin</th>
                <th class="whitespace-nowrap px-3 py-3">Élèves</th>
                <th class="whitespace-nowrap px-3 py-3">Abonnement</th>
                <th class="whitespace-nowrap px-3 py-3">Statut</th>
                <th class="whitespace-nowrap px-5 py-3 text-right sm:px-6">Actions</th>
              </tr>
            </thead>
            <tbody id="table-body" class="divide-y divide-slate-100 text-slate-700"></tbody>
          </table>
        </div>
        <div class="flex flex-col items-center justify-between gap-3 border-t border-slate-100 px-5 py-4 sm:flex-row sm:px-6">
          <p class="text-xs text-slate-500" id="page-info">Page 1 sur 3</p>
          <div class="flex items-center gap-2">
            <button type="button" id="pager-prev" class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40">Précédent</button>
            <div id="pager-numbers" class="flex gap-1"></div>
            <button type="button" id="pager-next" class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40">Suivant</button>
          </div>
        </div>
      </section>

      <!-- Activité récente -->
      <section class="mt-10 rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm sm:p-6">
        <h2 class="font-heading text-lg font-bold text-slate-900">Activité récente sur la plateforme</h2>
        <p class="mt-1 text-sm text-slate-500">Événements métiers (données fictives)</p>
        <ul class="mt-4 divide-y divide-slate-100">
          <li class="flex flex-wrap items-start justify-between gap-2 py-3 first:pt-0">
            <div class="flex items-start gap-3">
              <span class="mt-0.5 flex h-7 w-7 items-center justify-center rounded-full bg-emerald-100 text-emerald-700">
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
              </span>
              <div>
                <p class="font-medium text-slate-900">Nouvel établissement · Institut Cardinal Gantin</p>
                <p class="text-xs text-slate-500">Abomey-Calavi · il y a 2 h</p>
              </div>
            </div>
            <span class="rounded-full bg-primary/10 px-2 py-0.5 text-xs font-semibold text-primary">Inscription</span>
          </li>
          <li class="flex flex-wrap items-start justify-between gap-2 py-3">
            <div class="flex items-start gap-3">
              <span class="mt-0.5 flex h-7 w-7 items-center justify-center rounded-full bg-slate-100 text-slate-700">
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" /></svg>
              </span>
              <div>
                <p class="font-medium text-slate-900">Connexion super admin · audit session</p>
                <p class="text-xs text-slate-500">IP Cotonou · il y a 5 h</p>
              </div>
            </div>
            <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-700">Sécurité</span>
          </li>
          <li class="flex flex-wrap items-start justify-between gap-2 py-3">
            <div class="flex items-start gap-3">
              <span class="mt-0.5 flex h-7 w-7 items-center justify-center rounded-full bg-red-100 text-red-700">
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>
              </span>
              <div>
                <p class="font-medium text-slate-900">Suspension · Groupe scolaire Les Phénix</p>
                <p class="text-xs text-slate-500">Impayé &gt; 60 j · hier</p>
              </div>
            </div>
            <span class="rounded-full bg-red-100 px-2 py-0.5 text-xs font-bold text-red-800">Suspension</span>
          </li>
          <li class="flex flex-wrap items-start justify-between gap-2 py-3">
            <div class="flex items-start gap-3">
              <span class="mt-0.5 flex h-7 w-7 items-center justify-center rounded-full bg-accent/50 text-slate-800">
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M6 14h6M12 14h6" /></svg>
              </span>
              <div>
                <p class="font-medium text-slate-900">Masse critique · 200 000 bulletins PDF générés (cumul)</p>
                <p class="text-xs text-slate-500">Seuil franchi · hier</p>
              </div>
            </div>
            <span class="rounded-full bg-accent/50 px-2 py-0.5 text-xs font-semibold text-slate-800">Métrique</span>
          </li>
          <li class="flex flex-wrap items-start justify-between gap-2 py-3 last:pb-0">
            <div class="flex items-start gap-3">
              <span class="mt-0.5 flex h-7 w-7 items-center justify-center rounded-full bg-emerald-100 text-emerald-700">
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
              </span>
              <div>
                <p class="font-medium text-slate-900">Réactivation · Lycée Moderne de Parakou</p>
                <p class="text-xs text-slate-500">Paiement régularisé · 29 mars</p>
              </div>
            </div>
            <span class="rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-800">Activation</span>
          </li>
        </ul>
      </section>

      <footer class="mt-12 pb-8 text-center text-xs text-slate-400">
        EduManager Super Admin · données illustratives
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

      var rowsData = [
        { nom: "Collège Saint-Michel", type: "Collège", sub: "Privé", ville: "Cotonou", admin: "A. Kossi", eleves: 612, abonnement: "Premium", statut: "actif" },
        { nom: "Lycée Béhanzin", type: "Collège", sub: "Public", ville: "Porto-Novo", admin: "M. Hounkpe", eleves: 892, abonnement: "Premium", statut: "actif" },
        { nom: "Complexe Les Lauriers", type: "Collège", sub: "Privé", ville: "Cotonou", admin: "S. Ahouanvo", eleves: 445, abonnement: "Standard", statut: "actif" },
        { nom: "Université Partenaire Atlantique", type: "Université", sub: "Privé", ville: "Abomey-Calavi", admin: "Dr. T. Mensah", eleves: 1240, abonnement: "Premium", statut: "actif" },
        { nom: "Cours Secondaire Ste Thérèse", type: "Collège", sub: "Privé", ville: "Parakou", admin: "Sr. B. Lawson", eleves: 328, abonnement: "Standard", statut: "suspendu" },
        { nom: "Institut Technique de Porto-Novo", type: "Collège", sub: "Public", ville: "Porto-Novo", admin: "I. Sossou", eleves: 756, abonnement: "Premium", statut: "actif" },
        { nom: "École Le Savoir", type: "Collège", sub: "Privé", ville: "Cotonou", admin: "G. Dossou", eleves: 189, abonnement: "Free", statut: "actif" },
        { nom: "Groupe scolaire Les Phénix", type: "Collège", sub: "Privé", ville: "Lokossa", admin: "K. Bio", eleves: 512, abonnement: "Premium", statut: "suspendu" },
        { nom: "Faculté des Sciences Lokossa", type: "Université", sub: "Public", ville: "Lokossa", admin: "Prof. Zinsou", eleves: 2104, abonnement: "Premium", statut: "actif" },
        { nom: "Centre Maria-Goretti", type: "Collège", sub: "Privé", ville: "Cotonou", admin: "P. Aïssi", eleves: 267, abonnement: "Standard", statut: "actif" },
        { nom: "Lycée Moderne de Parakou", type: "Collège", sub: "Public", ville: "Parakou", admin: "B. Orou", eleves: 1340, abonnement: "Premium", statut: "actif" },
        { nom: "Institut Cardinal Gantin", type: "Université", sub: "Privé", ville: "Abomey-Calavi", admin: "P. Adjovi", eleves: 890, abonnement: "Premium", statut: "actif" }
      ];

      var perPage = 5;
      var currentPage = 1;
      var totalPages = Math.max(1, Math.ceil(rowsData.length / perPage));

      function actionCellHtml(isSuspended) {
        var sBtn = isSuspended
          ? '<button type="button" class="rounded-lg bg-emerald-600 px-2 py-1 text-xs font-semibold text-white hover:bg-emerald-700 transition">Activer</button>'
          : '<button type="button" class="rounded-lg border border-red-200 bg-red-50 px-2 py-1 text-xs font-semibold text-red-700 hover:bg-red-100 transition">Suspendre</button>';
        return (
          '<div class="flex flex-wrap justify-end gap-2">' +
          '<button type="button" class="group rounded-lg p-1.5 text-slate-500 hover:bg-slate-100 hover:text-primary transition" title="Voir détails">' +
          '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">' +
          '<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />' +
          '<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />' +
          '</svg></button>' +
          sBtn +
          '<button type="button" class="rounded-lg bg-primary/10 px-2.5 py-1 text-xs font-semibold text-primary hover:bg-primary/20 transition">Accéder</button>' +
          '</div>'
        );
      }

      function renderTable() {
        var body = document.getElementById("table-body");
        var start = (currentPage - 1) * perPage;
        var slice = rowsData.slice(start, start + perPage);
        body.innerHTML = slice
          .map(function (r) {
            var badge =
              r.statut === "actif"
                ? '<span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-800"><span class="relative flex h-2 w-2"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span></span>Actif</span>'
                : '<span class="rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">Suspendu</span>';
            
            var aboBadge = r.abonnement === "Premium" 
              ? '<span class="rounded-full bg-primary/10 px-2 py-0.5 text-xs font-semibold text-primary">Premium</span>'
              : r.abonnement === "Standard"
              ? '<span class="rounded-full bg-accent/30 px-2 py-0.5 text-xs font-semibold text-slate-800">Standard</span>'
              : '<span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-600">Free</span>';
            
            return (
              "<tr>" +
              '<td class="px-5 py-4 font-medium text-slate-900 sm:px-6">' + r.nom + "</td>" +
              '<td class="px-3 py-4">' + r.type + "</td>" +
              '<td class="px-3 py-4">' + r.sub + "</td>" +
              '<td class="px-3 py-4">' + r.ville + "</td>" +
              '<td class="px-3 py-4">' + r.admin + "</td>" +
              '<td class="px-3 py-4 font-semibold">' + r.eleves.toLocaleString("fr-FR") + "</td>" +
              '<td class="px-3 py-4">' + aboBadge + "</td>" +
              '<td class="px-3 py-4">' + badge + "</td>" +
              '<td class="px-5 py-4 text-right sm:px-6">' + actionCellHtml(r.statut === "suspendu") + "</td>" +
              "</tr>"
            );
          })
          .join("");
        document.getElementById("page-info").textContent = "Page " + currentPage + " sur " + totalPages;
        document.getElementById("pager-prev").disabled = currentPage <= 1;
        document.getElementById("pager-next").disabled = currentPage >= totalPages;

        var nums = document.getElementById("pager-numbers");
        nums.innerHTML = "";
        for (var p = 1; p <= totalPages; p++) {
          var b = document.createElement("button");
          b.type = "button";
          b.textContent = String(p);
          b.className =
            "h-8 min-w-[2rem] rounded-lg text-xs font-semibold transition " +
            (p === currentPage ? "bg-primary text-white" : "border border-slate-200 text-slate-700 hover:bg-slate-50");
          b.addEventListener(
            "click",
            (function (page) {
              return function () {
                currentPage = page;
                renderTable();
              };
            })(p)
          );
          nums.appendChild(b);
        }
      }

      document.getElementById("pager-prev").addEventListener("click", function () {
        if (currentPage > 1) {
          currentPage--;
          renderTable();
        }
      });
      document.getElementById("pager-next").addEventListener("click", function () {
        if (currentPage < totalPages) {
          currentPage++;
          renderTable();
        }
      });
      renderTable();

      if (typeof Chart !== "undefined") {
        Chart.defaults.font.family = "'Outfit', sans-serif";
        Chart.defaults.color = "#64748b";

        new Chart(document.getElementById("chart-inscriptions"), {
          type: "bar",
          data: {
            labels: ["Jan", "Fév", "Mar", "Avr", "Mai", "Juin", "Juil", "Août", "Sep", "Oct", "Nov", "Déc"],
            datasets: [{
              label: "Nouveaux établissements",
              data: [2, 1, 3, 1, 2, 4, 1, 2, 9, 5, 3, 4],
              backgroundColor: primary,
              borderRadius: 8,
              maxBarThickness: 28
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: true, position: "bottom" } },
            scales: { y: { beginAtZero: true, grid: { color: "rgba(148,163,184,0.2)" }, ticks: { stepSize: 2 } }, x: { grid: { display: false } } }
          }
        });

        new Chart(document.getElementById("chart-types"), {
          type: "doughnut",
          data: {
            labels: ["Collèges publics", "Collèges privés", "Lycées Techniques", "Universités"],
            datasets: [{ data: [12, 24, 11, 30], backgroundColor: [primary, accent, "#00a36a", "#c400fa"], borderWidth: 2, borderColor: "#ffffff" }]
          },
          options: { responsive: true, maintainAspectRatio: false, cutout: "58%", plugins: { legend: { display: true, position: "bottom" } } }
        });

        new Chart(document.getElementById("chart-users-growth"), {
          type: "line",
          data: {
            labels: ["Sep", "Oct", "Nov", "Déc", "Jan", "Fév", "Mar"],
            datasets: [{
              label: "Utilisateurs actifs",
              data: [142, 148, 156, 162, 171, 180, 189],
              borderColor: primary,
              backgroundColor: "rgba(115, 0, 233, 0.05)",
              fill: true,
              tension: 0.3,
              pointBackgroundColor: primary,
              pointBorderColor: "#fff",
              pointRadius: 4,
              pointHoverRadius: 6
            }]
          },
          options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: "bottom" } } }
        });

        new Chart(document.getElementById("chart-churn"), {
          type: "line",
          data: {
            labels: ["Sep", "Oct", "Nov", "Déc", "Jan", "Fév", "Mar"],
            datasets: [{
              label: "Taux de désinscription (%)",
              data: [4.2, 3.8, 4.0, 3.5, 3.9, 4.8, 3.2],
              borderColor: "#ef4444",
              backgroundColor: "rgba(239, 68, 68, 0.05)",
              fill: true,
              tension: 0.3,
              pointBackgroundColor: "#ef4444",
              pointBorderColor: "#fff",
              pointRadius: 4,
              pointHoverRadius: 6
            }]
          },
          options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: "bottom" } } }
        });

        new Chart(document.getElementById("chart-top5"), {
          type: "bar",
          data: {
            labels: ["Faculté des Sciences Lokossa", "Lycée Moderne de Parakou", "Université Partenaire Atlantique", "Lycée Béhanzin", "Institut Technique Porto-Novo"],
            datasets: [{
              label: "Effectifs",
              data: [2104, 1340, 1240, 892, 756],
              backgroundColor: [primary, accent, "rgba(115, 0, 233, 0.55)", "rgba(153, 251, 227, 0.85)", "#c4b5fd"],
              borderRadius: 6,
              barThickness: 22
            }]
          },
          options: { indexAxis: "y", responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
        });
      }
    })();
  </script>
</body>
</html>