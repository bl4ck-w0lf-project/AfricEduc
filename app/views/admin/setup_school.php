<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <title>Configuration | EduManager Collège</title>
  <meta name="description" content="Assistant de configuration initiale de votre collège sur EduManager.">

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: "#7300e9",
            primaryDark: "#5c00bd",
            accent: "#99fbe3",
            danger: "#ef4444",
            warning: "#f59e0b",
            success: "#10b981"
          },
          fontFamily: {
            heading: ["Quicksand", "sans-serif"],
            body: ["Outfit", "sans-serif"]
          },
          animation: {
            'fade-in': 'fadeIn 0.3s ease-in-out'
          },
          keyframes: {
            fadeIn: {
              '0%': { opacity: '0' },
              '100%': { opacity: '1' }
            }
          }
        }
      }
    };
  </script>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: "Outfit", sans-serif;
      overflow-x: hidden;
    }
    
    h1, h2, h3, .font-heading {
      font-family: "Quicksand", sans-serif;
    }
    
    /* Sidebar styles */
    .sidebar-link {
      transition: all 0.2s ease;
    }
    .sidebar-link:hover {
      background-color: rgba(255, 255, 255, 0.1);
      transform: translateX(4px);
    }
    .sidebar-link.active {
      background-color: rgba(153, 251, 227, 0.2);
      color: #99fbe3;
      border-left: 3px solid #99fbe3;
    }
    
    /* Sous-menus */
    .submenu {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.35s ease;
    }
    .submenu.open {
      max-height: 320px;
    }
    
    /* Overlay sidebar mobile */
    .sidebar-overlay {
      position: fixed;
      inset: 0;
      background-color: rgba(15, 23, 42, 0.5);
      z-index: 40;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease, visibility 0.3s ease;
    }
    .sidebar-overlay.is-open {
      opacity: 1;
      visibility: visible;
    }
    
    /* Step panels */
    .step-panel {
      display: none;
      opacity: 0;
      transform: translateY(12px);
      transition: opacity 0.35s ease, transform 0.35s ease;
    }
    .step-panel.is-active {
      display: block;
      opacity: 1;
      transform: translateY(0);
    }
    
    /* Progress bar */
    .progress-fill {
      transition: width 0.45s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Toast notification */
    .toast {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background: #1e293b;
      color: white;
      padding: 12px 20px;
      border-radius: 12px;
      font-size: 0.875rem;
      z-index: 10000;
      opacity: 0;
      transition: opacity 0.3s;
      pointer-events: none;
    }
    .toast.show {
      opacity: 1;
    }
    
    /* Scrollbar personnalisée */
    ::-webkit-scrollbar {
      width: 6px;
    }
    ::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
    }
    ::-webkit-scrollbar-thumb {
      background: #7300e9;
      border-radius: 10px;
    }
    
    /* Responsive */
    @media (max-width: 1024px) {
      .sidebar {
        transform: translateX(-100%);
      }
      .sidebar.is-open {
        transform: translateX(0);
      }
    }
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 text-slate-800">

  <!-- Overlay sidebar mobile -->
  <div id="sidebar-overlay" class="sidebar-overlay"></div>

  <!-- Sidebar -->
  <aside id="sidebar" class="sidebar fixed left-0 top-0 z-50 h-full w-[280px] flex-col bg-gradient-to-b from-primary to-primaryDark text-white shadow-2xl transition-transform duration-300 lg:relative lg:translate-x-0 flex">
    <div class="flex h-16 items-center gap-3 border-b border-white/20 px-5">
      <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/20 shadow-lg">
        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8">
          <path d="M4 6.75C4 5.78 4.78 5 5.75 5h4.5c.46 0 .9.18 1.22.51l.56.56c.33.33.77.51 1.24.51h5.98c.97 0 1.75.78 1.75 1.75v8.92c0 .97-.78 1.75-1.75 1.75H5.75A1.75 1.75 0 0 1 4 17.25V6.75Z"/>
          <path d="M8 11.5h8M8 14.5h5"/>
        </svg>
      </span>
      <span class="font-heading text-xl font-bold tracking-tight">EduManager</span>
    </div>
    
    <nav class="flex-1 overflow-y-auto px-3 py-6 text-sm">
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 mb-1 hover:bg-white/10 transition">
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path d="M3.75 6A2.25 2.25 0 0 1 6 3.75h3A2.25 2.25 0 0 1 11.25 6v3A2.25 2.25 0 0 1 9 11.25H6A2.25 2.25 0 0 1 3.75 9V6ZM3.75 15A2.25 2.25 0 0 1 6 12.75h3A2.25 2.25 0 0 1 11.25 15v3A2.25 2.25 0 0 1 9 20.25H6A2.25 2.25 0 0 1 3.75 18v-3ZM13.5 6A2.25 2.25 0 0 1 15.75 3.75h3A2.25 2.25 0 0 1 21 6v3A2.25 2.25 0 0 1 18.75 11.25h-3A2.25 2.25 0 0 1 13.5 9V6ZM13.5 15A2.25 2.25 0 0 1 15.75 12.75h3A2.25 2.25 0 0 1 21 15v3A2.25 2.25 0 0 1 18.75 20.25h-3A2.25 2.25 0 0 1 13.5 18v-3Z"/>
        </svg>
        Dashboard
      </a>
      
      <div class="mt-2">
        <button type="button" class="sidebar-toggle flex w-full items-center justify-between gap-2 rounded-xl px-3 py-2.5 text-left text-white/95 hover:bg-white/10 transition" data-submenu="sub-ecole">
          <span class="flex items-center gap-3">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <path d="M4 19.5V8.25L12 4l8 4.25V19.5"/>
              <path d="M9 19.5V12h6v7.5"/>
            </svg>
            Mon école
          </span>
          <svg class="chevron h-4 w-4 transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="m6 9 6 6 6-6"/>
          </svg>
        </button>
        <div id="sub-ecole" class="submenu open pl-2">
          <a href="#" class="sidebar-link block rounded-lg py-2 pl-10 pr-3">Configuration</a>
          <a href="#" class="sidebar-link block rounded-lg py-2 pl-10 pr-3">Identité & contact</a>
        </div>
      </div>
      
      <div class="mt-1">
        <button type="button" class="sidebar-toggle flex w-full items-center justify-between gap-2 rounded-xl px-3 py-2.5 text-left text-white/95 hover:bg-white/10 transition" data-submenu="sub-org">
          <span class="flex items-center gap-3">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <path d="M3.75 21h16.5M4.5 3h15A1.5 1.5 0 0 1 21 4.5v13.5A1.5 1.5 0 0 1 19.5 19.5h-15A1.5 1.5 0 0 1 4.5 18v-13.5A1.5 1.5 0 0 1 4.5 3zm4.5 4.5h3M9 12h3m-3 4.5h3M15 7.5h3M15 12h3m-3 4.5h3"/>
            </svg>
            Organisation
          </span>
          <svg class="chevron h-4 w-4 transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="m6 9 6 6 6-6"/>
          </svg>
        </button>
        <div id="sub-org" class="submenu open pl-2">
          <a href="#" class="sidebar-link block rounded-lg py-2 pl-10 pr-3">Classes / Groupes</a>
          <a href="#" class="sidebar-link block rounded-lg py-2 pl-10 pr-3">Matières</a>
        </div>
      </div>
      
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 mt-1 hover:bg-white/10 transition">
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
          <path d="M6.5 17a4 4 0 1 1 8 0"/>
          <path d="M15 11a3 3 0 1 0-6 0 3 3 0 0 0 6 0Z"/>
        </svg>
        <span>Élèves</span>
      </a>
      
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 hover:bg-white/10 transition">Notes & Moyennes</a>
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 hover:bg-white/10 transition">Scolarité & Paiements</a>
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 hover:bg-white/10 transition">Agents</a>
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 hover:bg-white/10 transition">Bulletins & Documents</a>
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 hover:bg-white/10 transition">Statistiques</a>
      
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 mt-4 hover:bg-white/10 transition">
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/>
          <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        Paramètres
      </a>
      
      <div class="mt-8 border-t border-white/15 pt-4">
        <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 text-red-200 hover:bg-red-500/20 transition">Déconnexion</a>
      </div>
    </nav>
  </aside>

  <!-- Main content -->
  <div class="lg:ml-[280px] min-h-screen flex flex-col">
    <!-- Header -->
    <header class="sticky top-0 z-30 flex h-16 items-center justify-between gap-4 border-b border-slate-200 bg-white/95 px-4 backdrop-blur-md shadow-sm sm:px-6">
      <div class="flex items-center gap-3">
        <button id="btn-menu" class="inline-flex rounded-xl border border-slate-200 p-2 text-slate-700 hover:bg-slate-50 transition lg:hidden">
          <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M4 7h16M4 12h16M4 17h16"/>
          </svg>
        </button>
        <div>
          <p class="font-heading text-sm font-semibold text-primary sm:text-base" id="school-name-header">Collège Saint-Michel</p>
          <p class="text-xs text-slate-500" id="school-location">Cotonou, Bénin</p>
        </div>
      </div>
      <div class="flex items-center gap-3">
        <span class="hidden rounded-full border border-accent/50 bg-accent/20 px-3 py-1 text-xs font-medium text-slate-800 sm:inline-flex" id="school-year">Année 2025–2026</span>
        <button class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-2 py-1.5 pr-3 shadow-sm hover:shadow-md transition">
          <span id="header-avatar" class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-primary to-primaryDark text-sm font-bold text-white shadow-md">AK</span>
          <span class="hidden text-left text-sm sm:block">
            <span class="block font-medium text-slate-900">Aminata Kossi</span>
            <span class="text-xs text-slate-500">Administratrice</span>
          </span>
        </button>
      </div>
    </header>

    <!-- Main content area -->
    <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
      <!-- Assistant de configuration -->
      <div class="max-w-5xl mx-auto">
        <div class="mb-6">
          <h1 class="font-heading text-2xl font-bold text-slate-900 sm:text-3xl">Configuration initiale</h1>
          <p class="mt-1 text-sm text-slate-600">Paramétrez le système pédagogique de votre collège en quelques étapes.</p>
        </div>

        <!-- Progress bar -->
        <div class="mt-6">
          <div class="flex items-center justify-between gap-2 text-xs font-semibold text-slate-500 sm:text-sm" id="step-labels">
            <span class="step-label w-1/4 text-center text-primary cursor-pointer" data-step="1">1. Pédagogie</span>
            <span class="step-label w-1/4 text-center cursor-pointer" data-step="2">2. Devoirs</span>
            <span class="step-label w-1/4 text-center cursor-pointer" data-step="3">3. Conduite</span>
            <span class="step-label w-1/4 text-center cursor-pointer" data-step="4">4. Scolarité</span>
          </div>
          <div class="mt-3 h-2 overflow-hidden rounded-full bg-slate-200/80">
            <div id="progress-bar" class="progress-fill h-full rounded-full bg-primary" style="width: 25%;" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="4"></div>
          </div>
        </div>

        <!-- Formulaire -->
        <div class="mt-8 rounded-3xl border border-slate-200/80 bg-white p-6 shadow-xl shadow-violet-100/50 sm:p-10">
          <p id="step-banner" class="mb-6 text-center text-sm font-semibold text-primary">Étape 1/4 — Système pédagogique</p>

          <form id="setup-form" novalidate>
            <!-- Étape 1 : Pédagogie -->
            <div class="step-panel is-active" data-step="1">
              <h2 class="font-heading text-xl font-bold text-slate-900 sm:text-2xl">Comment fonctionne votre établissement ?</h2>
              <p class="mt-2 text-sm text-slate-600">Choisissez comment les périodes scolaires sont découpées.</p>
              
              <div class="mt-8 grid gap-4 sm:grid-cols-2">
                <label class="group relative cursor-pointer">
                  <input type="radio" name="period_system" value="semester" class="peer sr-only" checked>
                  <div class="rounded-2xl border-2 border-slate-200 bg-slate-50/50 p-5 transition peer-checked:border-primary peer-checked:bg-primary/[0.06] peer-checked:shadow-md hover:border-primary/40">
                    <div class="flex items-start gap-3">
                      <span class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                          <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h12v10H6a2 2 0 0 1-2-2V7Z" />
                        </svg>
                      </span>
                      <div>
                        <span class="font-heading font-bold text-slate-900">Semestre</span>
                        <p class="mt-1 text-sm text-slate-600">2 périodes par an (S1, S2)</p>
                      </div>
                    </div>
                  </div>
                </label>
                
                <label class="group relative cursor-pointer">
                  <input type="radio" name="period_system" value="trimester" class="peer sr-only">
                  <div class="rounded-2xl border-2 border-slate-200 bg-slate-50/50 p-5 transition peer-checked:border-primary peer-checked:bg-primary/[0.06] peer-checked:shadow-md hover:border-primary/40">
                    <div class="flex items-start gap-3">
                      <span class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-accent/50 text-slate-800">
                        <svg class="h-5 w-5 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h10" />
                        </svg>
                      </span>
                      <div>
                        <span class="font-heading font-bold text-slate-900">Trimestre</span>
                        <p class="mt-1 text-sm text-slate-600">3 périodes par an (T1, T2, T3)</p>
                      </div>
                    </div>
                  </div>
                </label>
              </div>
              
              <div class="formula-box mt-8 rounded-2xl border border-violet-100 bg-violet-50/60 px-4 py-4 sm:px-5">
                <p class="text-xs font-semibold uppercase tracking-wide text-primary">Formule annuelle (aperçu)</p>
                <p id="formula-period" class="mt-2 font-mono text-sm text-slate-800 sm:text-base">MA = (MGS1 × 1 + MGS2 × 2) / 3</p>
              </div>
              <p class="field-error mt-2 hidden text-sm text-red-600" id="err-step1"></p>
            </div>

            <!-- Étape 2 : Devoirs -->
            <div class="step-panel" data-step="2">
              <h2 class="font-heading text-xl font-bold text-slate-900 sm:text-2xl">Quels types de devoirs utilisez-vous ?</h2>
              <p class="mt-2 text-sm text-slate-600">Cochez les types de devoirs que vous souhaitez suivre.</p>
              
              <div class="mt-8 space-y-4">
                <label class="flex cursor-pointer items-center justify-between gap-4 rounded-2xl border border-slate-200 px-4 py-3 transition hover:border-primary/30">
                  <span class="font-medium text-slate-900">Interrogations <span class="text-slate-500">(MI)</span></span>
                  <input type="checkbox" name="hw_mi" value="1" checked class="peer sr-only hom-toggle">
                  <span class="relative h-7 w-12 shrink-0 rounded-full bg-slate-200 transition peer-checked:bg-primary after:absolute after:left-1 after:top-1 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition peer-checked:after:translate-x-5"></span>
                </label>
                
                <label class="flex cursor-pointer items-center justify-between gap-4 rounded-2xl border border-slate-200 px-4 py-3 transition hover:border-primary/30">
                  <span class="font-medium text-slate-900">Devoir 1 <span class="text-slate-500">(D1)</span></span>
                  <input type="checkbox" name="hw_d1" value="1" checked class="peer sr-only hom-toggle">
                  <span class="relative h-7 w-12 shrink-0 rounded-full bg-slate-200 transition peer-checked:bg-primary after:absolute after:left-1 after:top-1 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition peer-checked:after:translate-x-5"></span>
                </label>
                
                <label class="flex cursor-pointer items-center justify-between gap-4 rounded-2xl border border-slate-200 px-4 py-3 transition hover:border-primary/30">
                  <span class="font-medium text-slate-900">Devoir 2 <span class="text-slate-500">(D2)</span></span>
                  <input type="checkbox" name="hw_d2" value="1" checked class="peer sr-only hom-toggle">
                  <span class="relative h-7 w-12 shrink-0 rounded-full bg-slate-200 transition peer-checked:bg-primary after:absolute after:left-1 after:top-1 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition peer-checked:after:translate-x-5"></span>
                </label>
                
                <label class="flex cursor-pointer items-center justify-between gap-4 rounded-2xl border border-slate-200 px-4 py-3 transition hover:border-primary/30">
                  <span class="font-medium text-slate-900">Devoir hebdomadaire <span class="text-slate-500">(DH)</span></span>
                  <input type="checkbox" name="hw_dh" value="1" class="peer sr-only hom-toggle">
                  <span class="relative h-7 w-12 shrink-0 rounded-full bg-slate-200 transition peer-checked:bg-primary after:absolute after:left-1 after:top-1 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition peer-checked:after:translate-x-5"></span>
                </label>
              </div>
              <p class="field-error mt-6 hidden text-sm text-red-600" id="err-step2"></p>
            </div>

            <!-- Étape 3 : Conduite -->
            <div class="step-panel" data-step="3">
              <h2 class="font-heading text-xl font-bold text-slate-900 sm:text-2xl">Conduite &amp; paramètres</h2>
              <p class="mt-2 text-sm text-slate-600">Définissez si vous souhaitez inclure une note de conduite.</p>
              
              <div class="mt-6 rounded-2xl border border-slate-200 p-4 sm:p-5">
                <label class="flex cursor-pointer items-center justify-between gap-4">
                  <span class="font-medium text-slate-900">Activer la note de conduite</span>
                  <input type="checkbox" name="conduct_enabled" value="1" id="conduct_enabled" class="peer sr-only">
                  <span class="relative h-7 w-12 shrink-0 cursor-pointer rounded-full bg-slate-200 transition peer-checked:bg-primary after:pointer-events-none after:absolute after:left-1 after:top-1 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition peer-checked:after:translate-x-5"></span>
                </label>
                
                <div id="conduct-fields" class="mt-4 hidden space-y-4 border-t border-slate-100 pt-4">
                  <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                      <label for="conduct_coeff" class="block text-sm font-medium text-slate-700">Coefficient conduite</label>
                      <input type="number" name="conduct_coefficient" id="conduct_coeff" step="0.1" min="0.1" value="1" class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
                    </div>
                    <div>
                      <label for="conduct_max" class="block text-sm font-medium text-slate-700">Note max. conduite</label>
                      <input type="number" name="conduct_max" id="conduct_max" min="1" max="20" value="20" class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="formula-box mt-6 rounded-2xl border border-violet-100 bg-violet-50/60 px-4 py-4">
                <p class="text-xs font-semibold uppercase text-primary">Formule annuelle (rappel)</p>
                <p id="formula-period-full" class="mt-2 font-mono text-sm text-slate-800">MA = (MGS1 × 1 + MGS2 × 2) / 3</p>
              </div>
              <p class="field-error mt-2 hidden text-sm text-red-600" id="err-step3"></p>
            </div>

            <!-- Étape 4 : Scolarité et confirmation -->
            <div class="step-panel" data-step="4">
              <h2 class="font-heading text-xl font-bold text-slate-900 sm:text-2xl">Scolarité &amp; confirmation</h2>
              <p class="mt-2 text-sm text-slate-600">Vérifiez le récapitulatif puis validez.</p>
              
              <div class="mt-6">
                <label class="block text-sm font-medium text-slate-700">Devise</label>
                <input type="text" name="currency" value="FCFA" readonly class="mt-1 w-full max-w-md cursor-not-allowed rounded-xl border border-slate-200 bg-slate-100 px-4 py-2.5 text-slate-600">
                <p class="mt-1 text-xs text-slate-500">Paramètre fixe pour l'instant.</p>
              </div>
              
              <div class="mt-8 rounded-2xl border border-slate-200 bg-slate-50/80 p-5 sm:p-6">
                <h3 class="font-heading text-sm font-bold uppercase tracking-wide text-slate-500">Récapitulatif</h3>
                <dl id="summary-dl" class="mt-4 space-y-3 text-sm"></dl>
              </div>
              <p id="submit-error" class="mt-4 hidden rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert"></p>
            </div>

            <!-- Boutons navigation -->
            <div class="mt-10 flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">
              <button type="button" id="btn-prev" class="rounded-xl border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40">Précédent</button>
              <div class="flex flex-col gap-3 sm:flex-row sm:gap-3">
                <button type="button" id="btn-next" class="rounded-xl bg-primary px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-primary/25 transition hover:bg-violet-800">Suivant</button>
                <button type="submit" id="btn-submit" class="hidden items-center justify-center gap-2 rounded-xl bg-primary px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-primary/25 transition hover:bg-violet-800 disabled:opacity-60">
                  <span id="btn-submit-label">Confirmer</span>
                  <svg id="btn-submit-spinner" class="hidden h-5 w-5 animate-spin text-white" viewBox="0 0 24 24" fill="none">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" class="opacity-25" />
                    <path fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4Z" class="opacity-90" />
                  </svg>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
      
      <footer class="mt-12 pb-8 text-center text-xs text-slate-400">
        EduManager — Collège Saint-Michel · Dernière mise à jour : <span id="last-update"></span>
      </footer>
    </main>
  </div>

  <div id="toast" class="toast"></div>

  <script>
    (function() {
      // Variables
      let currentStep = 1;
      const totalSteps = 4;
      
      // Éléments DOM
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('sidebar-overlay');
      const btnMenu = document.getElementById('btn-menu');
      const prevBtn = document.getElementById('btn-prev');
      const nextBtn = document.getElementById('btn-next');
      const submitBtn = document.getElementById('btn-submit');
      const form = document.getElementById('setup-form');
      
      // === GESTION DU MENU HAMBURGER (FONCTIONNEL) ===
      function toggleSidebar(open) {
        if (open) {
          sidebar.classList.add('is-open');
          overlay.classList.add('is-open');
          document.body.style.overflow = 'hidden';
        } else {
          sidebar.classList.remove('is-open');
          overlay.classList.remove('is-open');
          document.body.style.overflow = '';
        }
      }
      
      if (btnMenu) {
        btnMenu.addEventListener('click', (e) => {
          e.stopPropagation();
          toggleSidebar(true);
        });
      }
      
      if (overlay) {
        overlay.addEventListener('click', () => {
          toggleSidebar(false);
        });
      }
      
      // Fermer sidebar quand on redimensionne au-delà de lg
      window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) {
          toggleSidebar(false);
          sidebar.classList.remove('is-open');
        }
      });
      
      // === GESTION DES SOUS-MENUS ===
      document.querySelectorAll('.sidebar-toggle').forEach(btn => {
        const submenuId = btn.getAttribute('data-submenu');
        const submenu = document.getElementById(submenuId);
        const chevron = btn.querySelector('.chevron');
        
        if (submenu) {
          btn.addEventListener('click', () => {
            const isOpen = submenu.classList.toggle('open');
            if (chevron) {
              chevron.style.transform = isOpen ? 'rotate(180deg)' : 'rotate(0deg)';
            }
          });
        }
      });
      
      // === FONCTIONS DU WIZARD ===
      function updateFormulaPeriod() {
        const radio = document.querySelector('input[name="period_system"]:checked');
        const period = radio ? radio.value : 'semester';
        const text = period === 'semester' 
          ? 'MA = (MGS1 × 1 + MGS2 × 2) / 3' 
          : 'MA = (MGT1 + MGT2 + MGT3) / 3';
        
        const formulaEl = document.getElementById('formula-period');
        const formulaFullEl = document.getElementById('formula-period-full');
        if (formulaEl) formulaEl.textContent = text;
        if (formulaFullEl) formulaFullEl.textContent = text;
        
        if (currentStep === totalSteps) buildSummary();
      }
      
      function toggleConductFields() {
        const conductEnabled = document.getElementById('conduct_enabled');
        const conductFields = document.getElementById('conduct-fields');
        if (conductEnabled && conductFields) {
          conductFields.classList.toggle('hidden', !conductEnabled.checked);
        }
        if (currentStep === totalSteps) buildSummary();
      }
      
      function buildSummary() {
        const radio = document.querySelector('input[name="period_system"]:checked');
        const period = radio ? radio.value : 'semester';
        const periodLabel = period === 'semester' ? 'Semestre (S1, S2)' : 'Trimestre (T1, T2, T3)';
        const formulaText = period === 'semester' 
          ? 'MA = (MGS1 × 1 + MGS2 × 2) / 3' 
          : 'MA = (MGT1 + MGT2 + MGT3) / 3';
        
        const hwMi = document.querySelector('input[name="hw_mi"]')?.checked || false;
        const hwD1 = document.querySelector('input[name="hw_d1"]')?.checked || false;
        const hwD2 = document.querySelector('input[name="hw_d2"]')?.checked || false;
        const hwDh = document.querySelector('input[name="hw_dh"]')?.checked || false;
        
        const activeHomeworks = [];
        if (hwMi) activeHomeworks.push('MI');
        if (hwD1) activeHomeworks.push('D1');
        if (hwD2) activeHomeworks.push('D2');
        if (hwDh) activeHomeworks.push('DH');
        const homeworksStr = activeHomeworks.length ? activeHomeworks.join(', ') : '—';
        
        const conductEnabled = document.getElementById('conduct_enabled')?.checked || false;
        const conductCoeff = document.getElementById('conduct_coeff')?.value || '1';
        const conductMax = document.getElementById('conduct_max')?.value || '20';
        const conductStr = conductEnabled ? `Oui (coef. ${conductCoeff}, max ${conductMax})` : 'Non';
        
        const currency = document.querySelector('input[name="currency"]')?.value || 'FCFA';
        
        const summaryDl = document.getElementById('summary-dl');
        if (summaryDl) {
          summaryDl.innerHTML = `
            <div class="flex flex-col gap-0.5 border-b border-slate-200/80 pb-3 last:border-0 sm:flex-row sm:justify-between">
              <dt class="font-medium text-slate-500">Système de périodes</dt>
              <dd class="text-slate-900">${escapeHtml(periodLabel)}</dd>
            </div>
            <div class="flex flex-col gap-0.5 border-b border-slate-200/80 pb-3 last:border-0 sm:flex-row sm:justify-between">
              <dt class="font-medium text-slate-500">Formule annuelle</dt>
              <dd class="text-slate-900">${escapeHtml(formulaText)}</dd>
            </div>
            <div class="flex flex-col gap-0.5 border-b border-slate-200/80 pb-3 last:border-0 sm:flex-row sm:justify-between">
              <dt class="font-medium text-slate-500">Devoirs suivis</dt>
              <dd class="text-slate-900">${escapeHtml(homeworksStr)}</dd>
            </div>
            <div class="flex flex-col gap-0.5 border-b border-slate-200/80 pb-3 last:border-0 sm:flex-row sm:justify-between">
              <dt class="font-medium text-slate-500">Note de conduite</dt>
              <dd class="text-slate-900">${escapeHtml(conductStr)}</dd>
            </div>
            <div class="flex flex-col gap-0.5 border-b border-slate-200/80 pb-3 last:border-0 sm:flex-row sm:justify-between">
              <dt class="font-medium text-slate-500">Devise</dt>
              <dd class="text-slate-900">${escapeHtml(currency)}</dd>
            </div>
          `;
        }
      }
      
      function escapeHtml(str) {
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
      }
      
      function validateStep(step) {
        const err1 = document.getElementById('err-step1');
        const err2 = document.getElementById('err-step2');
        const err3 = document.getElementById('err-step3');
        
        if (err1) err1.classList.add('hidden');
        if (err2) err2.classList.add('hidden');
        if (err3) err3.classList.add('hidden');
        
        if (step === 1) {
          if (!document.querySelector('input[name="period_system"]:checked')) {
            if (err1) {
              err1.textContent = 'Choisissez un système de périodes.';
              err1.classList.remove('hidden');
            }
            return false;
          }
          return true;
        }
        
        if (step === 2) {
          const hwMi = document.querySelector('input[name="hw_mi"]')?.checked || false;
          const hwD1 = document.querySelector('input[name="hw_d1"]')?.checked || false;
          const hwD2 = document.querySelector('input[name="hw_d2"]')?.checked || false;
          const hwDh = document.querySelector('input[name="hw_dh"]')?.checked || false;
          
          if (!hwMi && !hwD1 && !hwD2 && !hwDh) {
            if (err2) {
              err2.textContent = 'Activez au moins un type de devoir.';
              err2.classList.remove('hidden');
            }
            return false;
          }
          return true;
        }
        
        if (step === 3) {
          const conductEnabled = document.getElementById('conduct_enabled')?.checked || false;
          if (conductEnabled) {
            const coeff = parseFloat(document.getElementById('conduct_coeff')?.value);
            const max = parseFloat(document.getElementById('conduct_max')?.value);
            
            if (isNaN(coeff) || coeff <= 0) {
              if (err3) {
                err3.textContent = 'Coefficient de conduite invalide.';
                err3.classList.remove('hidden');
              }
              return false;
            }
            if (isNaN(max) || max < 1) {
              if (err3) {
                err3.textContent = 'Note max. conduite invalide.';
                err3.classList.remove('hidden');
              }
              return false;
            }
          }
          return true;
        }
        
        return true;
      }
      
      function showStep(step) {
        if (step < 1 || step > totalSteps) return;
        
        currentStep = step;
        
        // Afficher/masquer les panels
        document.querySelectorAll('.step-panel').forEach(panel => {
          const panelStep = parseInt(panel.getAttribute('data-step'), 10);
          panel.classList.toggle('is-active', panelStep === step);
        });
        
        // Mettre à jour les labels
        document.querySelectorAll('.step-label').forEach(label => {
          const labelStep = parseInt(label.getAttribute('data-step'), 10);
          if (labelStep === step) {
            label.classList.add('text-primary', 'font-bold');
            label.classList.remove('text-slate-500');
          } else {
            label.classList.remove('text-primary', 'font-bold');
            label.classList.add('text-slate-500');
          }
        });
        
        // Mettre à jour la barre de progression
        const progressPercent = (step / totalSteps) * 100;
        const progressBar = document.getElementById('progress-bar');
        if (progressBar) {
          progressBar.style.width = `${progressPercent}%`;
          progressBar.setAttribute('aria-valuenow', step);
        }
        
        // Mettre à jour le texte du banner
        const titles = [
          '',
          'Étape 1/4 — Système pédagogique',
          'Étape 2/4 — Types de devoirs',
          'Étape 3/4 — Conduite',
          'Étape 4/4 — Scolarité & Confirmation'
        ];
        const banner = document.getElementById('step-banner');
        if (banner) banner.textContent = titles[step];
        
        // Gérer les boutons
        if (prevBtn) prevBtn.disabled = (step === 1);
        if (nextBtn) nextBtn.classList.toggle('hidden', step === totalSteps);
        if (submitBtn) {
          submitBtn.classList.toggle('hidden', step !== totalSteps);
          submitBtn.classList.toggle('flex', step === totalSteps);
        }
        
        // Mettre à jour le récapitulatif si on est à la dernière étape
        if (step === totalSteps) {
          buildSummary();
        }
        
        // Scroll en haut doucement
        window.scrollTo({ top: 0, behavior: 'smooth' });
      }
      
      function showToast(message, isError = false) {
        const toast = document.getElementById('toast');
        toast.textContent = message;
        toast.style.backgroundColor = isError ? '#ef4444' : '#10b981';
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3000);
      }
      
      // === ÉVÉNEMENTS ===
      // Écouteurs pour les changements dans le formulaire
      document.querySelectorAll('input[name="period_system"]').forEach(radio => {
        radio.addEventListener('change', updateFormulaPeriod);
      });
      
      document.querySelectorAll('.hom-toggle').forEach(checkbox => {
        checkbox.addEventListener('change', () => {
          if (currentStep === totalSteps) buildSummary();
        });
      });
      
      const conductEnabled = document.getElementById('conduct_enabled');
      if (conductEnabled) {
        conductEnabled.addEventListener('change', toggleConductFields);
      }
      
      const conductCoeff = document.getElementById('conduct_coeff');
      const conductMax = document.getElementById('conduct_max');
      if (conductCoeff) conductCoeff.addEventListener('input', () => {
        if (currentStep === totalSteps) buildSummary();
      });
      if (conductMax) conductMax.addEventListener('input', () => {
        if (currentStep === totalSteps) buildSummary();
      });
      
      // Bouton Suivant
      if (nextBtn) {
        nextBtn.addEventListener('click', () => {
          if (validateStep(currentStep)) {
            if (currentStep < totalSteps) {
              showStep(currentStep + 1);
            }
          } else {
            showToast('Veuillez corriger les erreurs avant de continuer.', true);
          }
        });
      }
      
      // Bouton Précédent
      if (prevBtn) {
        prevBtn.addEventListener('click', () => {
          if (currentStep > 1) {
            showStep(currentStep - 1);
          }
        });
      }
      
      // Clic sur les labels pour navigation rapide
      document.querySelectorAll('.step-label').forEach(label => {
        label.addEventListener('click', () => {
          const step = parseInt(label.getAttribute('data-step'), 10);
          if (step && step < currentStep) {
            showStep(step);
          } else if (step && step > currentStep) {
            let allValid = true;
            for (let i = currentStep; i < step; i++) {
              if (!validateStep(i)) {
                allValid = false;
                showToast(`Veuillez compléter l'étape ${i} correctement.`, true);
                break;
              }
            }
            if (allValid) showStep(step);
          }
        });
      });
      
      // Soumission du formulaire
      if (form) {
        form.addEventListener('submit', (e) => {
          e.preventDefault();
          
          // Valider toutes les étapes
          for (let i = 1; i <= 3; i++) {
            if (!validateStep(i)) {
              showStep(i);
              showToast(`Veuillez corriger l'étape ${i} avant de valider.`, true);
              return;
            }
          }
          
          // Désactiver le bouton et afficher le spinner
          if (submitBtn) {
            submitBtn.disabled = true;
            const label = document.getElementById('btn-submit-label');
            const spinner = document.getElementById('btn-submit-spinner');
            if (label) label.textContent = 'Enregistrement...';
            if (spinner) spinner.classList.remove('hidden');
          }
          
          // Récupérer les données du formulaire
          const formData = {
            action: 'save_school_settings',
            period_system: document.querySelector('input[name="period_system"]:checked')?.value || 'semester',
            hw_mi: document.querySelector('input[name="hw_mi"]')?.checked ? '1' : '0',
            hw_d1: document.querySelector('input[name="hw_d1"]')?.checked ? '1' : '0',
            hw_d2: document.querySelector('input[name="hw_d2"]')?.checked ? '1' : '0',
            hw_dh: document.querySelector('input[name="hw_dh"]')?.checked ? '1' : '0',
            conduct_enabled: document.getElementById('conduct_enabled')?.checked ? '1' : '0',
            conduct_coefficient: document.getElementById('conduct_coeff')?.value || '1',
            conduct_max: document.getElementById('conduct_max')?.value || '20',
            currency: document.querySelector('input[name="currency"]')?.value || 'FCFA'
          };
          
          // Simuler un envoi (à remplacer par ton code PHP)
          console.log('Données à envoyer au serveur :', formData);
          
          // Simuler un délai réseau
          setTimeout(() => {
            // Stocker dans localStorage pour démonstration
            localStorage.setItem('college_config', JSON.stringify(formData));
            
            showToast('Configuration enregistrée avec succès ! Redirection...');
            
            // Rediriger après 1 seconde
            setTimeout(() => {
              window.location.href = 'dashboard.html';
            }, 1000);
          }, 800);
        });
      }
      
      // Initialiser
      function init() {
        updateFormulaPeriod();
        toggleConductFields();
        showStep(1);
        
        // Date de dernière mise à jour
        const lastUpdateSpan = document.getElementById('last-update');
        if (lastUpdateSpan) {
          const now = new Date();
          lastUpdateSpan.textContent = now.toLocaleTimeString('fr-FR');
        }
      }
      
      init();
    })();
  </script>
</body>
</html>