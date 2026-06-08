
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard | AfricEduc</title>
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
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
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
      #clock {
      font-family: "Quicksand", sans-serif;
      letter-spacing: 2px;
  }

  .time-glow {
      box-shadow:
          0 0 20px rgba(115, 0, 233, 0.15),
          0 0 40px rgba(115, 0, 233, 0.08);
  }
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 text-slate-800 antialiased">
  

  <!-- Sidebar -->
 <?php include __DIR__ . '/../components/sidebar.php'; ?>

  <!-- Main content -->
  <div class="min-h-screen lg:pl-[260px]">
    <header class="sticky top-0 z-30 flex h-16 items-center justify-between gap-4 border-b border-slate-200 bg-white/95 px-4 backdrop-blur-md shadow-sm sm:px-6">
      <div class="flex items-center gap-3">
        <button id="btn-menu" class="inline-flex rounded-xl border border-slate-200 p-2 text-slate-700 hover:bg-slate-50 lg:hidden"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7h16M4 12h16M4 17h16"/></svg></button>
        <div><p class="font-heading text-sm font-semibold text-primary sm:text-base"><?= htmlspecialchars($_SESSION['school_name'] ?? 'École inconnue') ?> </p><p class="text-xs text-slate-500"><?= htmlspecialchars($_SESSION['school_address'] ?? 'Adresse non renseignée') ?></p></div>
      </div>
      <div class="flex items-center gap-3">
                <?php
        $currentYear = date("Y");
        $nextYear = $currentYear + 1;
        $schoolYear = $currentYear . "–" . $nextYear;
        ?>

        <span class="hidden rounded-full border border-accent/50 bg-accent/20 px-3 py-1 text-xs font-medium text-slate-800 sm:inline-flex" id="school-year">
          Année scolaire <?= $schoolYear ?>
        </span>
        <button class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-2 py-1.5 pr-3 shadow-sm">
            <?php
                $userName = $_SESSION['user_name'] ?? 'User';

                // on récupère les initiales
                $words = explode(' ', trim($userName));
                $initials = '';

                foreach ($words as $w) {
                    $initials .= strtoupper($w[0] ?? '');
                }

                // limite à 2 caractères max
                $initials = substr($initials, 0, 2);
            ?>
          <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-primary to-primaryDark text-sm font-bold text-white shadow-md"> <?= $initials ?></span>
          <span class="hidden text-left text-sm sm:block"><span class="block font-medium text-slate-900"><?= htmlspecialchars($_SESSION['user_name']) ?></span><span class="text-xs text-slate-500"><?= htmlspecialchars($_SESSION['user_role']) ?></span></span>
        </button>
      </div>
    </header>

    <main class="px-4 py-6 sm:px-6 lg:px-8">
      

    <?php if (!$isConfigured): ?>
        <div class="relative bg-gradient-to-r from-red-50 to-red-100 border border-red-200 rounded-2xl my-4 p-6 flex flex-col md:flex-row justify-between items-center gap-5 shadow-lg shadow-red-200/50 backdrop-blur-sm">
  
  <!-- Icône et texte -->
  <div class="flex items-center gap-4 w-full md:w-auto">
    <div class="bg-white/80 backdrop-blur-sm p-3 rounded-2xl shadow-md shadow-red-200">
      <i class="fa-solid fa-triangle-exclamation text-3xl md:text-4xl text-red-600"></i>
    </div>
    <div>
      <h3 class="font-bold text-gray-800 text-lg md:text-xl">Configuration requise</h3>
      <p class="text-gray-600 text-sm md:text-base">Votre école n’est pas encore configurée sur la plateforme.</p>
    </div>
  </div>

  <!-- Bouton CTA -->
  <a href="/AfricEduc/public/index.php?url=setup_school" 
     class="group relative bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-6 py-3 rounded-xl text-md font-semibold flex items-center gap-2 shadow-md shadow-red-400/40 transition-all duration-300 transform hover:scale-[1.02] active:scale-95">
    <i class="fa-solid fa-gear text-white group-hover:rotate-90 transition-transform duration-300"></i>
    Configurer maintenant
    <i class="fa-solid fa-arrow-right text-white text-xs group-hover:translate-x-1 transition-transform"></i>
  </a>

  <!-- Petit élément décoratif -->
  <div class="absolute -top-2 -right-2 w-20 h-20 bg-red-200 rounded-full blur-2xl opacity-40 pointer-events-none"></div>
  <div class="absolute -bottom-2 -left-2 w-16 h-16 bg-red-300 rounded-full blur-2xl opacity-30 pointer-events-none"></div>
</div> 
    <?php endif; ?>

      <!-- Conteneur dynamique (les données viendront de PHP) -->
      <div id="dynamic-content">
        <section class="rounded-2xl border border-slate-200/80 bg-gradient-to-br from-white via-white to-primary/5 p-6 shadow-lg sm:p-8 animate-fade-in">
          <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
               <?php
                      $heure = date("H");

                      if ($heure < 12) {
                          $salutation = "Bonjour";
                      } elseif ($heure < 18) {
                          $salutation = "Bon après-midi";
                      } else {
                          $salutation = "Bonsoir";
                      }
              ?>
            <div><h1 class="font-heading text-xl font-bold text-slate-900 sm:text-2xl"><?= $salutation ?>  <?= htmlspecialchars($_SESSION['user_name']) ?>
        (<?= htmlspecialchars($_SESSION['user_role']) ?>)    —  <span class="text-primary"><?= htmlspecialchars($_SESSION['school_name'] ?? 'Aucune école') ?></span></h1>
              <div class="mt-4 inline-flex flex-col gap-1 rounded-2xl bg-white/70 px-4 py-3 shadow-sm backdrop-blur border border-slate-200">
    
                    <div class="flex items-center gap-2 text-primary font-semibold text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 8v4l3 3"></path>
                            <circle cx="12" cy="12" r="9"></circle>
                        </svg>
                        Heure actuelle
                    </div>

                    <p id="clock" class="text-2xl font-bold text-slate-900 tracking-tight"></p>

                    <div class="flex items-center gap-2 text-slate-500 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M8 7V3m8 4V3M3 11h18M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span id="date"></span>
                    </div>

              </div>
            </div>
            <div class="flex gap-2"><span class="inline-flex items-center gap-1 rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold text-primary"><svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg>Dernière synchro: aujourd'hui</span></div>
          </div>
          
        </section>

        <section class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">
          <div class="kpi-card rounded-2xl border border-slate-200/80 bg-white p-5 shadow-md"><div class="flex items-start justify-between gap-2"><span class="flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 17a4 4 0 1 1 8 0"/></svg></span><span class="inline-flex items-center gap-0.5 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700">---</span></div><p class="mt-4 text-3xl font-bold tracking-tight text-slate-900">---</p><p class="text-sm font-medium text-slate-500">Élèves inscrits</p></div>
          <div class="kpi-card rounded-2xl border border-slate-200/80 bg-white p-5 shadow-md"><div class="flex items-start justify-between gap-2"><span class="flex h-11 w-11 items-center justify-center rounded-xl bg-success/10 text-success"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 6v12m-3-9h6M9 9h6M9 15h6M19 5v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg></span><span class="inline-flex items-center gap-0.5 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700">---</span></div><p class="mt-4 text-3xl font-bold tracking-tight text-slate-900">---</p><p class="text-sm font-medium text-slate-500">Revenus mensuels (F CFA)</p></div>
          <div class="kpi-card rounded-2xl border border-slate-200/80 bg-white p-5 shadow-md"><div class="flex items-start justify-between gap-2"><span class="flex h-11 w-11 items-center justify-center rounded-xl bg-accent/40 text-slate-800"><svg class="h-6 w-6 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg></span><span class="inline-flex items-center gap-0.5 rounded-full bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-600">---</span></div><p class="mt-4 text-3xl font-bold tracking-tight text-slate-900">---</p><p class="text-sm font-medium text-slate-500">Élèves actifs</p></div>
          <div class="kpi-card rounded-2xl border border-slate-200/80 bg-white p-5 shadow-md"><div class="flex items-start justify-between gap-2"><span class="flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 6.75h12M6 12h12m-12 5.25h12"/></svg></span><span class="inline-flex items-center gap-0.5 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700">---</span></div><p class="mt-4 text-3xl font-bold tracking-tight text-slate-900">---</p><p class="text-sm font-medium text-slate-500">Classes créées</p></div>
          <div class="kpi-card rounded-2xl border border-warning/30 bg-warning/5 p-5 shadow-md"><div class="flex items-start justify-between gap-2"><span class="flex h-11 w-11 items-center justify-center rounded-xl bg-warning/20 text-warning"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15h.008v.008H12v-.008z"/></svg></span><span class="inline-flex items-center gap-0.5 rounded-full bg-red-100 px-2 py-0.5 text-xs font-bold text-red-800">Alerte</span></div><p class="mt-4 text-3xl font-bold tracking-tight text-red-900">---</p><p class="text-sm font-medium text-red-800/90">Élèves en difficulté</p></div>
          <div class="kpi-card rounded-2xl border border-slate-200/80 bg-white p-5 shadow-md"><div class="flex items-start justify-between gap-2"><span class="flex h-11 w-11 items-center justify-center rounded-xl bg-success/10 text-success"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 12h3l3-9 3 18 3-12 3 3 3-3"/></svg></span><span class="inline-flex items-center gap-0.5 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700">---</span></div><p class="mt-4 text-3xl font-bold tracking-tight text-slate-900">---<span class="text-lg">%</span></p><p class="text-sm font-medium text-slate-500">Taux de paiement</p></div>
        </section>

        <section class="mt-10 space-y-8"><h2 class="font-heading text-lg font-bold text-slate-900">Indicateurs &amp; tendances</h2><div class="grid gap-6 lg:grid-cols-2">
          <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-md sm:p-6"><h3 class="font-heading text-base font-semibold">Évolution des inscriptions par mois</h3><div class="mt-4 h-64"><canvas id="chart-inscriptions"></canvas></div></div>
          <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-md sm:p-6"><h3 class="font-heading text-base font-semibold">Évolution des absences</h3><div class="mt-4 h-64"><canvas id="chart-absences"></canvas></div></div>
          <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-md sm:p-6"><h3 class="font-heading text-base font-semibold">Performance par classe</h3><div class="mt-4 h-64"><canvas id="chart-performance"></canvas></div></div>
          <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-md sm:p-6"><h3 class="font-heading text-base font-semibold">Paiements vs Retards</h3><div class="mt-4 h-64"><canvas id="chart-paiements-vs-retards"></canvas></div></div>
        </div></section>

        <section class="mt-10 grid gap-6 lg:grid-cols-2">
          <div class="rounded-2xl border border-red-200/80 bg-white p-5 shadow-md sm:p-6"><div class="flex items-center justify-between gap-2 mb-4"><h3 class="font-heading text-base font-semibold text-red-900">⚠️ Paiements en retard</h3><span class="rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-bold text-red-800 animate-pulse">Urgent</span></div><ul class="divide-y divide-slate-100"><li class="priority-high flex items-center justify-between gap-3 py-3"><div><p class="font-medium">---</p><p class="text-xs">--- — <span class="text-red-600 font-semibold">---</span></p></div><div><span class="text-sm font-semibold text-red-700">--- F</span></div></li><li class="priority-high flex items-center justify-between gap-3 py-3"><div><p class="font-medium">---</p><p class="text-xs">--- — <span class="text-red-600 font-semibold">---</span></p></div><div><span class="text-sm font-semibold text-red-700">--- F</span></div></li></ul></div>
          <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-md sm:p-6"><div class="flex items-center justify-between gap-2 mb-4"><h3 class="font-heading text-base font-semibold">📊 Derniers élèves ajoutés</h3><span class="rounded-full bg-primary/10 px-2.5 py-0.5 text-xs font-semibold text-primary">Cette semaine</span></div><ul id="recent-students-list" class="divide-y divide-slate-100"><li class="flex items-center justify-between gap-3 py-3"><div><p class="font-medium">---</p><p class="text-xs">---</p></div><span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700"><span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>Nouveau</span></li><li class="flex items-center justify-between gap-3 py-3"><div><p class="font-medium">---</p><p class="text-xs">---</p></div><span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700"><span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>Nouveau</span></li></ul></div>

          <div class="rounded-2xl border border-slate-200/80 bg-gradient-to-br from-primary/5 via-accent/10 to-primary/5 p-5 sm:col-span-2 sm:p-6">
            <h3 class="font-heading text-base font-semibold">⚡ Actions rapides</h3>
            <div class="mt-4 flex flex-wrap gap-3">
              <a href="#" id="btn-add-student" class="action-button inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primaryDark"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 4.5v15m7.5-7.5h-15"/></svg><span id="add-student-btn">Ajouter un élève</span></a>
              <a href="#" id="btn-saisir-notes" class="action-button inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-800 shadow-sm hover:border-primary/40 hover:text-primary"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg>Saisir des notes</a>
              <a href="#" id="btn-paiement" class="action-button inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-800 shadow-sm hover:border-primary/40 hover:text-primary"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 4.5h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5z"/></svg>Enregistrer un paiement</a>
              <a href="#" id="btn-bulletin" class="action-button inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-800 shadow-sm hover:border-primary/40 hover:text-primary"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6.75 3.75h10.5l3 4.5v9.75a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25l3-4.5Z"/><path d="M9 12h6M9 15.75h3"/></svg>Générer un bulletin</a>
              <a href="#" id="btn-export" class="action-button inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-800 shadow-sm hover:border-primary/40 hover:text-primary"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>Exporter les données</a>
            </div>
          </div>
        </section>

        <section class="mt-10 overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-md">
          <div class="border-b border-slate-100 px-5 py-4 sm:px-6"><h2 class="font-heading text-lg font-bold text-slate-900">Récapitulatif par classe</h2><p class="mt-1 text-sm text-slate-500">Vue consolidée — Collège Saint-Michel</p></div>
          <div class="overflow-x-auto"><table class="min-w-full text-left text-sm"><thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500"><tr><th class="px-5 py-3 sm:px-6">Classe</th><th class="px-3 py-3">Nb élèves</th><th class="px-3 py-3">Moy. générale</th><th class="px-3 py-3">Taux réussite</th><th class="px-3 py-3">Présence (%)</th><th class="px-3 py-3">Paiements OK</th><th class="px-5 py-3 text-right">Actions</th></tr></thead><tbody id="dynamic-table-body"><tr class="hover:bg-slate-50/80"><td class="px-5 py-4 font-medium text-slate-900 sm:px-6">---</td><td class="px-3 py-4">---</td><td class="px-3 py-4">--- /20</td><td class="px-3 py-4"><span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-800">---% ↑</span></td><td class="px-3 py-4"><span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-800">---%</span></td><td class="px-3 py-4">---</td><td class="px-5 py-4 text-right"><a href="#" class="font-semibold text-primary">Détails →</a></td></tr><tr class="hover:bg-slate-50/80"><td class="px-5 py-4 font-medium text-slate-900 sm:px-6">---</td><td class="px-3 py-4">---</td><td class="px-3 py-4">--- /20</td><td class="px-3 py-4"><span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-800">---% ↑</span></td><td class="px-3 py-4"><span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-800">---%</span></td><td class="px-3 py-4">---</td><td class="px-5 py-4 text-right"><a href="#" class="font-semibold text-primary">Détails →</a></td></tr></tbody></table></div>
        </section>
      </div>
      <footer class="mt-12 pb-8 text-center text-xs text-slate-400">
        AfricEduc — <span id="footer-school"><?= htmlspecialchars($_SESSION['school_name'] ?? 'Addresse école inconnue') ?> — <?= htmlspecialchars($_SESSION['school_address'] ?? 'Addresse école inconnue') ?> </span> · Données en temps réel · Dernière mise à jour : <span id="last-update"></span>
      </footer>
    </main>
  </div>

  <!-- Modale générique -->
  <div id="modal-generic" class="modal-overlay"><div class="modal-content bg-white rounded-2xl shadow-2xl p-6"><div class="flex justify-between items-center mb-4"><h3 class="font-heading text-xl font-bold text-slate-900" id="modal-title">Titre</h3><button id="close-modal" class="text-slate-400 hover:text-slate-600"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg></button></div><div id="modal-body" class="text-slate-700"></div><div class="mt-6 flex justify-end"><button id="modal-close-btn" class="rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white">Fermer</button></div></div></div>

  <div id="toast" class="toast"></div>

  <script>
    (function () {
      // Initialisation des graphiques avec des données neutres (pointillés)
      if (typeof Chart !== "undefined") {
        const primary = "#7300e9", accent = "#99fbe3";
        const ctx1 = document.getElementById("chart-inscriptions")?.getContext("2d");
        const ctx2 = document.getElementById("chart-absences")?.getContext("2d");
        const ctx3 = document.getElementById("chart-performance")?.getContext("2d");
        const ctx4 = document.getElementById("chart-paiements-vs-retards")?.getContext("2d");
        if (ctx1) new Chart(ctx1, { type: "bar", data: { labels: ["Sep","Oct","Nov","Déc","Jan","Fév","Mar","Avr","Mai","Juin"], datasets: [{ label: "Nouvelles inscriptions", data: [0,0,0,0,0,0,0,0,0,0], backgroundColor: primary, borderRadius: 8 }] }, options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: "bottom" } } } });
        if (ctx2) new Chart(ctx2, { type: "line", data: { labels: ["Sep","Oct","Nov","Déc","Jan","Fév","Mar"], datasets: [{ label: "Nombre d'absences", data: [0,0,0,0,0,0,0], borderColor: "#f59e0b", backgroundColor: "rgba(245,158,11,0.1)", fill: true, tension: 0.4 }] }, options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: "bottom" } } } });
        if (ctx3) new Chart(ctx3, { type: "bar", data: { labels: ["---", "---", "---", "---"], datasets: [{ label: "Moyenne générale /20", data: [0,0,0,0], backgroundColor: [primary, accent, "#c4b5fd", "#a7f3d0"], borderRadius: 8 }] }, options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: "bottom" } }, scales: { y: { beginAtZero: true, max: 20 } } } });
        if (ctx4) new Chart(ctx4, { type: "bar", data: { labels: ["Sep","Oct","Nov","Déc","Jan","Fév","Mar"], datasets: [{ label: "Attendu (k F CFA)", data: [0,0,0,0,0,0,0], backgroundColor: "rgba(115,0,233,0.3)", borderRadius: 8 }, { label: "Reçu (k F CFA)", data: [0,0,0,0,0,0,0], backgroundColor: primary, borderRadius: 8 }] }, options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: "bottom" } } } });
      }

      // Date et heure
      function updateClock() {
      const now = new Date();

        const time = now.toLocaleTimeString('fr-FR', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });

        document.getElementById("clock").innerText = time;
    }

    setInterval(updateClock, 1000);
    updateClock();

    function updateDateTime() {
    const now = new Date();

    document.getElementById("clock").innerText =
        now.toLocaleTimeString("fr-FR");

    document.getElementById("date").innerText =
        now.toLocaleDateString("fr-FR", {
            weekday: "long",
            year: "numeric",
            month: "long",
            day: "numeric"
        });
}

updateDateTime();
setInterval(updateDateTime, 1000);

      // Gestion modale
      const modal = document.getElementById("modal-generic");
      const modalTitle = document.getElementById("modal-title");
      const modalBody = document.getElementById("modal-body");
      function openModal(title, bodyHtml) { modalTitle.innerText = title; modalBody.innerHTML = bodyHtml; modal.classList.add("is-open"); document.body.style.overflow = "hidden"; }
      function closeModal() { modal.classList.remove("is-open"); document.body.style.overflow = ""; }
      document.getElementById("close-modal")?.addEventListener("click", closeModal);
      document.getElementById("modal-close-btn")?.addEventListener("click", closeModal);
      modal?.addEventListener("click", (e) => { if (e.target === modal) closeModal(); });

      function showToast(msg, type = "success") {
        const toast = document.getElementById("toast");
        toast.innerText = msg;
        toast.style.backgroundColor = type === "error" ? "#ef4444" : "#10b981";
        toast.classList.add("show");
        setTimeout(() => toast.classList.remove("show"), 3000);
      }

      // Actions rapides (simulation avec messages)
      document.getElementById("btn-add-student")?.addEventListener("click", (e) => {
        e.preventDefault();
        openModal("Ajouter un élève", `<form id="add-student-form" class="space-y-3"><div><label class="block text-sm font-medium">Nom</label><input type="text" id="new-nom" class="w-full rounded-xl border p-2" placeholder="---" required></div><div><label class="block text-sm font-medium">Prénom</label><input type="text" id="new-prenom" class="w-full rounded-xl border p-2" placeholder="---" required></div><div><label class="block text-sm font-medium">Classe</label><input type="text" id="new-classe" class="w-full rounded-xl border p-2" placeholder="---" required></div><div><label class="block text-sm font-medium">Établissement</label><input type="text" id="new-etab" value="Collège Saint-Michel" class="w-full rounded-xl border p-2" required></div><div><label class="block text-sm font-medium">Matricule</label><input type="text" id="new-matricule" class="w-full rounded-xl border p-2" placeholder="---" required></div><button type="submit" class="mt-2 rounded-xl bg-primary px-4 py-2 text-white">Enregistrer</button></form>`);
        const form = document.getElementById("add-student-form");
        form?.addEventListener("submit", (ev) => { ev.preventDefault(); showToast("Élève ajouté (simulation - connexion PHP requise)"); closeModal(); });
      });

      document.getElementById("btn-saisir-notes")?.addEventListener("click", (e) => {
        e.preventDefault();
        openModal("Saisir une note", `<form id="note-form" class="space-y-3"><div><label class="block text-sm font-medium">Élève</label><select id="note-student" class="w-full rounded-xl border p-2"><option>--- Sélectionner ---</option></select></div><div><label class="block text-sm font-medium">Matière</label><input type="text" id="note-matiere" class="w-full rounded-xl border p-2" placeholder="---" required></div><div><label class="block text-sm font-medium">Note /20</label><input type="number" step="0.1" min="0" max="20" id="note-value" class="w-full rounded-xl border p-2" required></div><button type="submit" class="mt-2 rounded-xl bg-primary px-4 py-2 text-white">Enregistrer</button></form>`);
        const form = document.getElementById("note-form");
        form?.addEventListener("submit", (ev) => { ev.preventDefault(); showToast("Note enregistrée (simulation - connexion PHP requise)"); closeModal(); });
      });

      document.getElementById("btn-paiement")?.addEventListener("click", (e) => {
        e.preventDefault();
        openModal("Enregistrer un paiement", `<form id="paiement-form" class="space-y-3"><div><label class="block text-sm font-medium">Élève</label><select id="paiement-student" class="w-full rounded-xl border p-2"><option>--- Sélectionner ---</option></select></div><div><label class="block text-sm font-medium">Montant (F CFA)</label><input type="number" id="paiement-montant" class="w-full rounded-xl border p-2" required></div><div><label class="block text-sm font-medium">Référence</label><input type="text" id="paiement-ref" class="w-full rounded-xl border p-2" required></div><button type="submit" class="mt-2 rounded-xl bg-primary px-4 py-2 text-white">Valider</button></form>`);
        const form = document.getElementById("paiement-form");
        form?.addEventListener("submit", (ev) => { ev.preventDefault(); showToast("Paiement enregistré (simulation - connexion PHP requise)"); closeModal(); });
      });

      document.getElementById("btn-bulletin")?.addEventListener("click", (e) => {
        e.preventDefault();
        openModal("Générer un bulletin", `<form id="bulletin-form" class="space-y-3"><div><label class="block text-sm font-medium">Élève</label><select id="bulletin-student" class="w-full rounded-xl border p-2"><option>--- Sélectionner ---</option></select></div><button type="submit" class="mt-2 rounded-xl bg-primary px-4 py-2 text-white">Générer PDF</button></form>`);
        const form = document.getElementById("bulletin-form");
        form?.addEventListener("submit", (ev) => { ev.preventDefault(); showToast("Bulletin PDF généré (simulation - données PHP requises)"); closeModal(); });
      });

      document.getElementById("btn-export")?.addEventListener("click", (e) => {
        e.preventDefault();
        showToast("Export CSV effectué (simulation - données PHP requises)");
      });
    })();
  </script>
</body>
</html>