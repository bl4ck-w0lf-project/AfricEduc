<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EduManager · Statistiques</title>
  <meta name="description" content="Dashboard de statistiques scolaires - lecture seule.">

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: "#7300e9",
            "primary-dark": "#5c00ba",
            accent: "#99fbe3",
            "accent-dark": "#6ee7d6",
            urgent: "#ef4444",
            warning: "#f59e0b",
            success: "#10b981",
            info: "#3b82f6"
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

  <!-- Chart.js pour les graphiques -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

  <style>
    body { font-family: "Outfit", sans-serif; }
    h1, h2, h3, .font-heading { font-family: "Quicksand", sans-serif; }
    .sidebar-link { transition: all 0.2s ease; }
    .sidebar-link--active { background-color: rgba(153, 251, 227, 0.2); color: #99fbe3; }
    .sidebar-link:hover:not(.sidebar-link--locked) { background-color: rgba(255, 255, 255, 0.1); transform: translateX(4px); }
    #sidebar-overlay { pointer-events: none; opacity: 0; transition: opacity 0.2s ease; }
    #sidebar-overlay.is-open { pointer-events: auto; opacity: 1; }
    .kpi-card { transition: all 0.2s ease; }
    .kpi-card:hover { transform: translateY(-2px); box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.02); }
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-slate-50 to-slate-100 text-slate-800 antialiased">
  <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden"></div>

  <!-- Sidebar -->
  <aside id="sidebar" class="fixed left-0 top-0 z-50 flex h-full w-[280px] -translate-x-full flex-col border-r border-white/10 bg-gradient-to-b from-primary to-primary-dark text-white shadow-2xl transition-transform duration-300 lg:translate-x-0">
    <div class="flex h-16 items-center gap-3 border-b border-white/15 px-5">
      <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/20 backdrop-blur-sm">
        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6.75C4 5.78 4.78 5 5.75 5h4.5c.46 0 .9.18 1.22.51l.56.56c.33.33.77.51 1.24.51h5.98c.97 0 1.75.78 1.75 1.75v8.92c0 .97-.78 1.75-1.75 1.75H5.75A1.75 1.75 0 0 1 4 17.25V6.75Z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M8 11.5h8M8 14.5h5" />
        </svg>
      </span>
      <div>
        <span class="font-heading block text-sm font-bold tracking-tight">EduManager</span>
        <span class="text-[10px] font-medium uppercase tracking-wider text-white/70">Espace agent · Statistiques</span>
      </div>
    </div>

    <nav class="flex-1 space-y-0.5 overflow-y-auto px-3 py-6 text-sm" aria-label="Navigation agent">
      <a href="dashboard_agent.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0 opacity-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h3A2.25 2.25 0 0 1 11.25 6v3A2.25 2.25 0 0 1 9 11.25H6A2.25 2.25 0 0 1 3.75 9V6ZM13.5 6A2.25 2.25 0 0 1 15.75 3.75h3A2.25 2.25 0 0 1 21 6v3A2.25 2.25 0 0 1 18.75 11.25h-3A2.25 2.25 0 0 1 13.5 9V6ZM3.75 15A2.25 2.25 0 0 1 6 12.75h3A2.25 2.25 0 0 1 11.25 15v3A2.25 2.25 0 0 1 9 20.25H6A2.25 2.25 0 0 1 3.75 18v-3ZM13.5 15A2.25 2.25 0 0 1 15.75 12.75h3A2.25 2.25 0 0 1 21 15v3A2.25 2.25 0 0 1 18.75 20.25h-3A2.25 2.25 0 0 1 13.5 18v-3Z" /></svg>
        Tableau de bord
      </a>
      <a href="eleves.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0 opacity-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 0 0-4-4H8m0 0a4 4 0 0 1 8 0m-9 0a4 4 0 1 1 8 0M12 3a4 4 0 1 0 0 8 4 4 0 0 0 0-8Z" /></svg>
        Élèves
      </a>
      <a href="notes.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0 opacity-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6.5h16M6.5 4v5M17.5 4v5M5.75 20h12.5A1.75 1.75 0 0 0 20 18.25V7.75A1.75 1.75 0 0 0 18.25 6H5.75A1.75 1.75 0 0 0 4 7.75v10.5C4 19.22 4.78 20 5.75 20Z" /></svg>
        Notes & Moyennes
      </a>
      <a href="paiements.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0 opacity-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.5 8.5h17M6 5h12a2.5 2.5 0 0 1 2.5 2.5v9A2.5 2.5 0 0 1 18 19H6a2.5 2.5 0 0 1-2.5-2.5v-9A2.5 2.5 0 0 1 6 5Z" /><path stroke-linecap="round" d="M7.5 14h4M7.5 11h9" /></svg>
        Paiements
      </a>
      <a href="bulletins.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0 opacity-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3.75h10.5l3 4.5v9.75a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25l3-4.5Z" /><path stroke-linecap="round" d="M9 12h6M9 15.75h3" /></svg>
        Bulletins
      </a>
      <a href="statistiques.html" class="sidebar-link sidebar-link--active flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0 opacity-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18M7 16v-5m5 5v-8m5 8v-3"/></svg>
        Statistiques
      </a>
      <div class="mt-8 border-t border-white/15 pt-4">
        <a href="login.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 text-red-200 transition-all hover:bg-red-500/20 hover:text-white">
          <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" /></svg>
          Déconnexion
        </a>
      </div>
    </nav>
  </aside>

  <!-- Main content -->
  <div class="min-h-screen lg:pl-[280px]">
    <header class="sticky top-0 z-30 flex h-16 items-center justify-between gap-4 border-b border-slate-200/80 bg-white/95 px-4 backdrop-blur-md sm:px-6 shadow-sm">
      <div class="flex items-center gap-3">
        <button type="button" id="btn-menu" class="inline-flex rounded-xl border border-slate-200 p-2 text-slate-700 hover:bg-slate-50 lg:hidden transition-all" aria-label="Ouvrir le menu">
          <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
        </button>
        <div>
          <p class="font-heading text-sm font-semibold text-primary sm:text-base">Collège Saint-Michel</p>
          <p class="text-xs text-slate-500">Cotonou · Statistiques scolaires</p>
        </div>
      </div>
      <div class="flex items-center gap-3">
        <button type="button" class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-2 py-1.5 pr-3 shadow-sm transition-all hover:border-primary/30 hover:shadow-md">
          <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-accent to-accent-dark text-sm font-bold text-primary">JM</span>
          <span class="hidden text-left text-sm sm:block">
            <span class="block font-medium text-slate-900">José Mensah</span>
            <span class="text-xs text-slate-500">Agent · Secrétariat</span>
          </span>
        </button>
      </div>
    </header>

    <main class="px-4 py-6 sm:px-6 lg:px-8">
      <!-- Titre -->
      <div class="mb-6">
        <h1 class="font-heading text-2xl font-bold text-slate-900 sm:text-3xl">Statistiques scolaires</h1>
        <p class="mt-1 text-sm text-slate-600">Classements, performances et tendances – données calculées automatiquement.</p>
      </div>

      <!-- Filtres -->
      <div class="mb-6 flex flex-wrap items-center gap-3">
        <select id="filter-classe" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm">
          <option value="">Toutes les classes</option>
          <option value="6ème">6ème</option>
          <option value="5ème">5ème</option>
          <option value="4ème">4ème</option>
          <option value="3ème">3ème</option>
          <option value="Seconde">Seconde</option>
          <option value="Première">Première</option>
          <option value="Terminale">Terminale</option>
        </select>
        <select id="filter-periode" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm">
          <option value="Trimestre 1">Trimestre 1</option>
          <option value="Trimestre 2">Trimestre 2</option>
          <option value="Trimestre 3">Trimestre 3</option>
          <option value="Semestre 1">Semestre 1</option>
          <option value="Semestre 2">Semestre 2</option>
        </select>
      </div>

      <!-- KPIs généraux -->
      <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-8" id="kpi-container"></div>

      <!-- Section Graphiques -->
      <div class="grid gap-6 lg:grid-cols-2 mb-8">
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm">
          <h3 class="font-heading text-base font-semibold text-slate-900 mb-2">Moyennes par classe</h3>
          <div class="h-64">
            <canvas id="chart-moyennes-classes"></canvas>
          </div>
        </div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm">
          <h3 class="font-heading text-base font-semibold text-slate-900 mb-2">Répartition des mentions</h3>
          <div class="h-64">
            <canvas id="chart-mentions"></canvas>
          </div>
        </div>
      </div>

      <!-- Contenu dynamique : classements par classe -->
      <div id="stats-content" class="space-y-8"></div>

      <footer class="mt-12 pb-8 text-center text-xs text-slate-400">
        EduManager — Collège Saint-Michel · Statistiques en lecture seule
      </footer>
    </main>
  </div>

  <script>
    (function(){
      // Données mockées (simulant réponse API) avec toutes les classes de la 6ème à la Terminale
      const mockData = {
        classes: [
          {
            classe: "6ème",
            moyenne_classe: 12.8,
            total_eleves: 22,
            meilleure_moyenne: 15.0,
            moins_bonne_moyenne: 9.5,
            eleves: [
              { nom: "AGOSSOU Pélagie", moyenne_generale: 15.0, rang: 1 },
              { nom: "HOUETO David", moyenne_generale: 13.4, rang: 2 },
              { nom: "ZINSOU Laure", moyenne_generale: 12.1, rang: 3 },
              { nom: "TOSSOU Romain", moyenne_generale: 11.0, rang: 4 }
            ],
            top_3: [
              { nom: "AGOSSOU Pélagie", moyenne: 15.0 },
              { nom: "HOUETO David", moyenne: 13.4 },
              { nom: "ZINSOU Laure", moyenne: 12.1 }
            ]
          },
          {
            classe: "5ème",
            moyenne_classe: 11.9,
            total_eleves: 24,
            meilleure_moyenne: 14.7,
            moins_bonne_moyenne: 8.9,
            eleves: [
              { nom: "HOUNDONOU Jules", moyenne_generale: 14.7, rang: 1 },
              { nom: "DANSOU Félicienne", moyenne_generale: 13.2, rang: 2 },
              { nom: "KOUAKOU Paul", moyenne_generale: 12.0, rang: 3 },
              { nom: "ADJAKA Nicole", moyenne_generale: 10.5, rang: 4 }
            ],
            top_3: [
              { nom: "HOUNDONOU Jules", moyenne: 14.7 },
              { nom: "DANSOU Félicienne", moyenne: 13.2 },
              { nom: "KOUAKOU Paul", moyenne: 12.0 }
            ]
          },
          {
            classe: "4ème",
            moyenne_classe: 11.8,
            total_eleves: 30,
            meilleure_moyenne: 14.2,
            moins_bonne_moyenne: 8.0,
            eleves: [
              { nom: "N'GUESSAN Koffi", moyenne_generale: 14.2, rang: 1 },
              { nom: "AVOCÈ Sèdjro", moyenne_generale: 12.5, rang: 2 },
              { nom: "DANSOU Félicienne", moyenne_generale: 11.9, rang: 3 },
              { nom: "GNONLONFOUN Raïssa", moyenne_generale: 10.8, rang: 4 }
            ],
            top_3: [
              { nom: "N'GUESSAN Koffi", moyenne: 14.2 },
              { nom: "AVOCÈ Sèdjro", moyenne: 12.5 },
              { nom: "DANSOU Félicienne", moyenne: 11.9 }
            ]
          },
          {
            classe: "3ème",
            moyenne_classe: 13.9,
            total_eleves: 32,
            meilleure_moyenne: 16.5,
            moins_bonne_moyenne: 9.2,
            eleves: [
              { nom: "KOUADIO Marie", moyenne_generale: 15.2, rang: 1 },
              { nom: "ADJOVI Laure", moyenne_generale: 14.8, rang: 2 },
              { nom: "TOSSOU Marius", moyenne_generale: 14.1, rang: 3 },
              { nom: "HOUNSA Carine", moyenne_generale: 12.9, rang: 4 }
            ],
            top_3: [
              { nom: "KOUADIO Marie", moyenne: 15.2 },
              { nom: "ADJOVI Laure", moyenne: 14.8 },
              { nom: "TOSSOU Marius", moyenne: 14.1 }
            ]
          },
          {
            classe: "Seconde",
            moyenne_classe: 12.4,
            total_eleves: 28,
            meilleure_moyenne: 15.8,
            moins_bonne_moyenne: 8.5,
            eleves: [
              { nom: "TRAORÉ Ibrahim", moyenne_generale: 15.8, rang: 1 },
              { nom: "SOSSOU Marc", moyenne_generale: 14.2, rang: 2 },
              { nom: "GNONLONFOUN Raïssa", moyenne_generale: 13.1, rang: 3 },
              { nom: "HOUNDONOU Jules", moyenne_generale: 11.0, rang: 4 }
            ],
            top_3: [
              { nom: "TRAORÉ Ibrahim", moyenne: 15.8 },
              { nom: "SOSSOU Marc", moyenne: 14.2 },
              { nom: "GNONLONFOUN Raïssa", moyenne: 13.1 }
            ]
          },
          {
            classe: "Première",
            moyenne_classe: 12.0,
            total_eleves: 26,
            meilleure_moyenne: 14.5,
            moins_bonne_moyenne: 8.9,
            eleves: [
              { nom: "SOSSOU Marc", moyenne_generale: 14.5, rang: 1 },
              { nom: "KOUAKOU Paul", moyenne_generale: 13.2, rang: 2 },
              { nom: "ADJAKA Nicole", moyenne_generale: 12.0, rang: 3 },
              { nom: "YAO Awa", moyenne_generale: 11.1, rang: 4 }
            ],
            top_3: [
              { nom: "SOSSOU Marc", moyenne: 14.5 },
              { nom: "KOUAKOU Paul", moyenne: 13.2 },
              { nom: "ADJAKA Nicole", moyenne: 12.0 }
            ]
          },
          {
            classe: "Terminale",
            moyenne_classe: 13.1,
            total_eleves: 25,
            meilleure_moyenne: 16.9,
            moins_bonne_moyenne: 9.8,
            eleves: [
              { nom: "DIALLO Aminata", moyenne_generale: 16.9, rang: 1 },
              { nom: "YAO Awa", moyenne_generale: 15.4, rang: 2 },
              { nom: "GNAMIEN Bénédicte", moyenne_generale: 14.7, rang: 3 },
              { nom: "KOUASSI Jean", moyenne_generale: 12.8, rang: 4 }
            ],
            top_3: [
              { nom: "DIALLO Aminata", moyenne: 16.9 },
              { nom: "YAO Awa", moyenne: 15.4 },
              { nom: "GNAMIEN Bénédicte", moyenne: 14.7 }
            ]
          }
        ]
      };

      // Références DOM
      const kpiContainer = document.getElementById('kpi-container');
      const statsContent = document.getElementById('stats-content');
      const filterClasse = document.getElementById('filter-classe');
      const filterPeriode = document.getElementById('filter-periode');

      // Graphiques
      let barChart, doughnutChart;

      function initCharts(classes) {
        const ctxBar = document.getElementById('chart-moyennes-classes').getContext('2d');
        const ctxDoughnut = document.getElementById('chart-mentions').getContext('2d');

        // Détruire les anciens graphiques s'ils existent
        if (barChart) barChart.destroy();
        if (doughnutChart) doughnutChart.destroy();

        // Bar chart : moyennes par classe
        const labels = classes.map(c => c.classe);
        const data = classes.map(c => c.moyenne_classe);

        barChart = new Chart(ctxBar, {
          type: 'bar',
          data: {
            labels: labels,
            datasets: [{
              label: 'Moyenne de classe',
              data: data,
              backgroundColor: '#7300e9',
              borderRadius: 8
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: { display: false }
            },
            scales: {
              y: {
                beginAtZero: true,
                max: 20,
                grid: { color: 'rgba(148,163,184,0.2)' }
              }
            }
          }
        });

        // Doughnut chart : répartition des mentions (simulée)
        // On compte les élèves par mention dans toutes les classes filtrées
        const mentions = { 'Très bien': 0, 'Bien': 0, 'Assez bien': 0, 'Passable': 0, 'Insuffisant': 0 };
        classes.forEach(c => {
          c.eleves.forEach(e => {
            const moy = e.moyenne_generale;
            if (moy >= 16) mentions['Très bien']++;
            else if (moy >= 14) mentions['Bien']++;
            else if (moy >= 12) mentions['Assez bien']++;
            else if (moy >= 10) mentions['Passable']++;
            else mentions['Insuffisant']++;
          });
        });

        doughnutChart = new Chart(ctxDoughnut, {
          type: 'doughnut',
          data: {
            labels: Object.keys(mentions),
            datasets: [{
              data: Object.values(mentions),
              backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#f97316', '#ef4444'],
              borderWidth: 0
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: { position: 'bottom' }
            }
          }
        });
      }

      // Affichage des KPIs généraux
      function renderGlobalKPIs(classes) {
        const totalEleves = classes.reduce((sum, c) => sum + c.total_eleves, 0);
        const avgGenerale = (classes.reduce((sum, c) => sum + (c.moyenne_classe * c.total_eleves), 0) / totalEleves).toFixed(1);
        const bestClass = classes.reduce((best, c) => c.moyenne_classe > best.moyenne_classe ? c : best, classes[0]);
        const worstClass = classes.reduce((worst, c) => c.moyenne_classe < worst.moyenne_classe ? c : worst, classes[0]);

        kpiContainer.innerHTML = `
          <div class="kpi-card rounded-2xl border-l-4 border-l-primary bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase text-slate-500">Total élèves</p>
            <p class="text-3xl font-bold text-slate-900">${totalEleves}</p>
          </div>
          <div class="kpi-card rounded-2xl border-l-4 border-l-info bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase text-slate-500">Moyenne générale</p>
            <p class="text-3xl font-bold text-slate-900">${avgGenerale}<span class="text-lg font-normal text-slate-500">/20</span></p>
          </div>
          <div class="kpi-card rounded-2xl border-l-4 border-l-success bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase text-slate-500">Classe la plus performante</p>
            <p class="text-xl font-bold text-slate-900">${bestClass.classe}</p>
            <p class="text-sm text-slate-500">${bestClass.moyenne_classe.toFixed(1)}/20 · ${bestClass.total_eleves} élèves</p>
          </div>
          <div class="kpi-card rounded-2xl border-l-4 border-l-warning bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase text-slate-500">Classe la moins performante</p>
            <p class="text-xl font-bold text-slate-900">${worstClass.classe}</p>
            <p class="text-sm text-slate-500">${worstClass.moyenne_classe.toFixed(1)}/20 · ${worstClass.total_eleves} élèves</p>
          </div>
        `;
      }

      // Affichage des classements par classe
      function renderClassStats(classes) {
        let html = '';
        classes.forEach(c => {
          const top3 = c.top_3 || [];
          const podiumEmojis = ['🥇', '🥈', '🥉'];
          
          html += `
            <section class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm sm:p-6">
              <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                <h2 class="font-heading text-xl font-bold text-slate-900">${c.classe}</h2>
                <div class="flex gap-3 text-sm">
                  <span class="bg-primary/10 text-primary px-3 py-1 rounded-full font-medium">Moy. classe: ${c.moyenne_classe.toFixed(1)}/20</span>
                  <span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-full">${c.total_eleves} élèves</span>
                </div>
              </div>

              <!-- Top 3 -->
              <div class="mb-6 grid grid-cols-1 sm:grid-cols-3 gap-3">
                ${top3.map((e, idx) => `
                  <div class="flex items-center gap-3 rounded-xl border ${idx === 0 ? 'border-yellow-300 bg-yellow-50/50' : (idx === 1 ? 'border-slate-300 bg-slate-50' : 'border-amber-300 bg-amber-50/50')} p-3">
                    <span class="text-2xl">${podiumEmojis[idx]}</span>
                    <div>
                      <p class="font-medium text-slate-900">${e.nom}</p>
                      <p class="text-sm text-slate-600">${e.moyenne.toFixed(1)}/20</p>
                    </div>
                  </div>
                `).join('')}
              </div>

              <!-- Classement complet -->
              <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                  <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                      <th class="px-4 py-2">Rang</th>
                      <th class="px-4 py-2">Élève</th>
                      <th class="px-4 py-2">Moyenne générale</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-slate-100">
                    ${c.eleves.map(e => `
                      <tr>
                        <td class="px-4 py-3 font-medium ${e.rang === 1 ? 'text-yellow-600' : (e.rang === 2 ? 'text-slate-600' : (e.rang === 3 ? 'text-amber-600' : 'text-slate-500'))}">${e.rang}${e.rang === 1 ? 'er' : 'e'}</td>
                        <td class="px-4 py-3 font-medium text-slate-900">${e.nom}</td>
                        <td class="px-4 py-3 font-semibold text-primary">${e.moyenne_generale.toFixed(1)}/20</td>
                      </tr>
                    `).join('')}
                  </tbody>
                </table>
              </div>
            </section>
          `;
        });
        statsContent.innerHTML = html;
      }

      function filterAndRender() {
        const classeFilter = filterClasse.value;
        const periode = filterPeriode.value; // conservé pour cohérence API

        let filteredClasses = mockData.classes;
        if (classeFilter) {
          filteredClasses = filteredClasses.filter(c => c.classe === classeFilter);
        }

        renderGlobalKPIs(filteredClasses);
        renderClassStats(filteredClasses);
        initCharts(filteredClasses);
      }

      // Événements filtres
      filterClasse.addEventListener('change', filterAndRender);
      filterPeriode.addEventListener('change', filterAndRender);

      // Sidebar mobile
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('sidebar-overlay');
      const btnMenu = document.getElementById('btn-menu');
      btnMenu.addEventListener('click', () => { sidebar.classList.remove('-translate-x-full'); overlay.classList.add('is-open'); document.body.style.overflow = 'hidden'; });
      overlay.addEventListener('click', () => { sidebar.classList.add('-translate-x-full'); overlay.classList.remove('is-open'); document.body.style.overflow = ''; });
      window.addEventListener('resize', () => { if (window.innerWidth >= 1024) { sidebar.classList.remove('-translate-x-full'); overlay.classList.remove('is-open'); document.body.style.overflow = ''; } });

      // Initialisation
      filterAndRender();
    })();
  </script>
</body>
</html>
