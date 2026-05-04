<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Configuration initiale | EduManager</title>
  <meta name="description" content="Assistant de configuration initiale de votre établissement sur EduManager.">

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
    body {
      font-family: "Outfit", sans-serif;
    }
    h1, h2, h3, .font-heading {
      font-family: "Quicksand", sans-serif;
    }
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
    .submenu {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.35s ease;
    }
    .submenu.open {
      max-height: 320px;
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
    .progress-fill {
      transition: width 0.45s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .formula-box {
      font-variant-numeric: tabular-nums;
    }
    .action-button {
      transition: all 0.2s ease;
    }
    .action-button:hover {
      transform: scale(1.05);
    }
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
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 text-slate-800 antialiased">
  <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden"></div>

  <!-- Sidebar (identique au tableau de bord) -->
  <aside id="sidebar" class="fixed left-0 top-0 z-50 flex h-full w-[260px] -translate-x-full flex-col bg-gradient-to-b from-primary to-primaryDark text-white shadow-2xl transition-transform duration-300 lg:translate-x-0">
    <div class="flex h-16 items-center gap-3 border-b border-white/20 px-4">
      <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/20 shadow-lg">
        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 6.75C4 5.78 4.78 5 5.75 5h4.5c.46 0 .9.18 1.22.51l.56.56c.33.33.77.51 1.24.51h5.98c.97 0 1.75.78 1.75 1.75v8.92c0 .97-.78 1.75-1.75 1.75H5.75A1.75 1.75 0 0 1 4 17.25V6.75Z"/><path d="M8 11.5h8M8 14.5h5"/></svg>
      </span>
      <span class="font-heading text-xl font-bold tracking-tight">EduManager</span>
    </div>
    <nav class="flex-1 overflow-y-auto px-3 py-6 text-sm">
      <a href="index.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 mb-1">
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3.75 6A2.25 2.25 0 0 1 6 3.75h3A2.25 2.25 0 0 1 11.25 6v3A2.25 2.25 0 0 1 9 11.25H6A2.25 2.25 0 0 1 3.75 9V6ZM3.75 15A2.25 2.25 0 0 1 6 12.75h3A2.25 2.25 0 0 1 11.25 15v3A2.25 2.25 0 0 1 9 20.25H6A2.25 2.25 0 0 1 3.75 18v-3ZM13.5 6A2.25 2.25 0 0 1 15.75 3.75h3A2.25 2.25 0 0 1 21 6v3A2.25 2.25 0 0 1 18.75 11.25h-3A2.25 2.25 0 0 1 13.5 9V6ZM13.5 15A2.25 2.25 0 0 1 15.75 12.75h3A2.25 2.25 0 0 1 21 15v3A2.25 2.25 0 0 1 18.75 20.25h-3A2.25 2.25 0 0 1 13.5 18v-3Z"/></svg>
        Dashboard
      </a>
      <div class="mt-2">
        <button type="button" class="sidebar-toggle flex w-full items-center justify-between gap-2 rounded-xl px-3 py-2.5 text-left text-white/95 hover:bg-white/10" data-submenu="sub-ecole">
          <span class="flex items-center gap-3"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19.5V8.25L12 4l8 4.25V19.5"/><path d="M9 19.5V12h6v7.5"/></svg>Mon école</span>
          <svg class="chevron h-4 w-4 transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
        </button>
        <div id="sub-ecole" class="submenu open pl-2">
          <a href="config-ecole.html" class="sidebar-link block rounded-lg py-2 pl-10 pr-3">Configuration</a>
          <a href="identite.html" class="sidebar-link block rounded-lg py-2 pl-10 pr-3">Identité & contact</a>
        </div>
      </div>
      <div class="mt-1">
        <button type="button" class="sidebar-toggle flex w-full items-center justify-between gap-2 rounded-xl px-3 py-2.5 text-left text-white/95 hover:bg-white/10" data-submenu="sub-org">
          <span class="flex items-center gap-3"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3.75 21h16.5M4.5 3h15A1.5 1.5 0 0 1 21 4.5v13.5A1.5 1.5 0 0 1 19.5 19.5h-15A1.5 1.5 0 0 1 4.5 18v-13.5A1.5 1.5 0 0 1 4.5 3zm4.5 4.5h3M9 12h3m-3 4.5h3M15 7.5h3M15 12h3m-3 4.5h3"/></svg>Organisation</span>
          <svg class="chevron h-4 w-4 transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
        </button>
        <div id="sub-org" class="submenu open pl-2">
          <a href="classes.html" class="sidebar-link block rounded-lg py-2 pl-10 pr-3">Classes / Groupes</a>
          <a href="matieres.html" class="sidebar-link block rounded-lg py-2 pl-10 pr-3">Matières</a>
        </div>
      </div>
      <a href="eleves.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 mt-1">
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 17a4 4 0 1 1 8 0"/><path d="M15 11a3 3 0 1 0-6 0 3 3 0 0 0 6 0Z"/></svg>
        <span id="nav-eleves-label">Élèves</span>
      </a>
      <a href="notes.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">Notes & Moyennes</a>
      <a href="paiements.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">Scolarité & Paiements</a>
      <a href="agents.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">Agents</a>
      <a href="bulletins.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">Bulletins & Documents</a>
      <a href="statistiques.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">Statistiques</a>
      <a href="parametres.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 mt-2">
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        Paramètres
      </a>
      <div class="mt-8 border-t border-white/15 pt-4">
        <a href="login.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 text-red-200 hover:bg-red-500/20">Déconnexion</a>
      </div>
    </nav>
  </aside>

  <!-- Main content -->
  <div class="min-h-screen lg:pl-[260px]">
    <header class="sticky top-0 z-30 flex h-16 items-center justify-between gap-4 border-b border-slate-200 bg-white/95 px-4 backdrop-blur-md shadow-sm sm:px-6">
      <div class="flex items-center gap-3">
        <button id="btn-menu" class="inline-flex rounded-xl border border-slate-200 p-2 text-slate-700 hover:bg-slate-50 lg:hidden"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7h16M4 12h16M4 17h16"/></svg></button>
        <div><p class="font-heading text-sm font-semibold text-primary sm:text-base" id="school-name-header">Collège Saint-Michel</p><p class="text-xs text-slate-500" id="school-location">Cotonou, Bénin</p></div>
      </div>
      <div class="flex items-center gap-3">
        <div id="type-switch" class="hidden md:flex gap-1 bg-slate-100 p-1 rounded-lg">
          <button id="switch-college" class="px-2 py-1 text-xs font-semibold rounded bg-primary text-white">Collège</button>
          <button id="switch-universite" class="px-2 py-1 text-xs font-semibold rounded text-slate-600 hover:bg-slate-200">Université</button>
        </div>
        <span class="hidden rounded-full border border-accent/50 bg-accent/20 px-3 py-1 text-xs font-medium text-slate-800 sm:inline-flex" id="school-year">Année 2025–2026</span>
        <button class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-2 py-1.5 pr-3 shadow-sm">
          <span id="header-avatar" class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-primary to-primaryDark text-sm font-bold text-white shadow-md">AK</span>
          <span class="hidden text-left text-sm sm:block"><span class="block font-medium text-slate-900">Aminata Kossi</span><span class="text-xs text-slate-500">Administratrice</span></span>
        </button>
      </div>
    </header>

    <main class="px-4 py-6 sm:px-6 lg:px-8">
      <div id="dynamic-content"></div>
      <footer class="mt-12 pb-8 text-center text-xs text-slate-400">
        EduManager — <span id="footer-school">Collège Saint-Michel</span> · Dernière mise à jour : <span id="last-update"></span>
      </footer>
    </main>
  </div>

  <div id="toast" class="toast"></div>

  <script>
    (function() {
      // ==================== DONNÉES DE BASE ====================
      const collegeData = {
        schoolName: "Collège Saint-Michel",
        schoolLocation: "Cotonou, Bénin",
        type: "college",
        schoolYear: "2025–2026",
        admin: { nom: "Kossi", prenom: "Aminata", email: "admin@saintmichel.bj", photo: null }
      };
      const universityData = {
        schoolName: "Université d'Abomey-Calavi",
        schoolLocation: "Abomey-Calavi, Bénin",
        type: "universite",
        schoolYear: "2025–2026",
        admin: { nom: "Kossi", prenom: "Aminata", email: "admin@uac.bj", photo: null }
      };

      let typeEtablissement = localStorage.getItem("typeEtablissement") || "college";
      let currentData = typeEtablissement === "college" ? JSON.parse(JSON.stringify(collegeData)) : JSON.parse(JSON.stringify(universityData));

      // Charger les données personnalisées
      if (localStorage.getItem("customSchoolName")) {
        currentData.schoolName = localStorage.getItem("customSchoolName");
        currentData.schoolLocation = localStorage.getItem("customSchoolLocation") || currentData.schoolLocation;
        currentData.schoolYear = localStorage.getItem("customSchoolYear") || currentData.schoolYear;
      }
      if (localStorage.getItem("adminPhoto")) {
        currentData.admin.photo = localStorage.getItem("adminPhoto");
      }

      function setType(type) {
        typeEtablissement = type;
        localStorage.setItem("typeEtablissement", type);
        currentData = type === "college" ? JSON.parse(JSON.stringify(collegeData)) : JSON.parse(JSON.stringify(universityData));
        if (localStorage.getItem("customSchoolName")) {
          currentData.schoolName = localStorage.getItem("customSchoolName");
          currentData.schoolLocation = localStorage.getItem("customSchoolLocation") || currentData.schoolLocation;
          currentData.schoolYear = localStorage.getItem("customSchoolYear") || currentData.schoolYear;
        }
        if (localStorage.getItem("adminPhoto")) {
          currentData.admin.photo = localStorage.getItem("adminPhoto");
        }
        updateHeaderFooter();
        renderWizard();
        updateSwitchButtons();
      }

      function updateSwitchButtons() {
        const collegeBtn = document.getElementById("switch-college");
        const univBtn = document.getElementById("switch-universite");
        if (collegeBtn && univBtn) {
          const isUniv = typeEtablissement === "universite";
          collegeBtn.className = `px-2 py-1 text-xs font-semibold rounded ${!isUniv ? "bg-primary text-white" : "text-slate-600 hover:bg-slate-200"}`;
          univBtn.className = `px-2 py-1 text-xs font-semibold rounded ${isUniv ? "bg-primary text-white" : "text-slate-600 hover:bg-slate-200"}`;
        }
      }

      function updateHeaderFooter() {
        document.getElementById("school-name-header").innerText = currentData.schoolName;
        document.getElementById("school-location").innerText = currentData.schoolLocation;
        document.getElementById("footer-school").innerText = currentData.schoolName;
        document.getElementById("nav-eleves-label").innerText = typeEtablissement === "universite" ? "Étudiants" : "Élèves";
        document.getElementById("school-year").innerText = `Année ${currentData.schoolYear}`;
        const avatarSpan = document.getElementById("header-avatar");
        if (currentData.admin.photo) {
          avatarSpan.innerHTML = `<img src="${currentData.admin.photo}" alt="Admin" class="h-9 w-9 rounded-full object-cover">`;
        } else {
          avatarSpan.innerHTML = `${currentData.admin.prenom[0]}${currentData.admin.nom[0]}`;
        }
      }

      function showToast(msg, isError = false) {
        const toast = document.getElementById("toast");
        toast.innerText = msg;
        toast.style.backgroundColor = isError ? "#ef4444" : "#10b981";
        toast.classList.add("show");
        setTimeout(() => toast.classList.remove("show"), 3000);
      }

      // ==================== ASSISTANT DE CONFIGURATION ====================
      const STORAGE_KEY = "edumanager_school_setup_wizard";
      const API_URL = "app/controllers/SchoolSettingsController.php";
      let currentStep = 1;
      let totalSteps = 4; // sera mis à jour selon le type

      function renderWizard() {
        const isUniv = typeEtablissement === "universite";
        totalSteps = isUniv ? 3 : 4;
        const container = document.getElementById("dynamic-content");
        container.innerHTML = `
          <div class="mb-6">
            <h1 class="font-heading text-2xl font-bold text-slate-900 sm:text-3xl">Configuration initiale</h1>
            <p class="mt-1 text-sm text-slate-600">${isUniv ? 'Paramétrez le système de semestres et les UE suivies.' : 'Quelques étapes pour paramétrer le système pédagogique.'}</p>
          </div>

          <div class="mt-6">
            <div class="flex items-center justify-between gap-2 text-xs font-semibold text-slate-500 sm:text-sm" id="step-labels">
              ${isUniv ? `
                <span class="step-label w-1/3 text-center text-primary" data-step="1">1. Périodes</span>
                <span class="step-label w-1/3 text-center" data-step="2">2. Unités d'enseignement</span>
                <span class="step-label w-1/3 text-center" data-step="3">3. Scolarité</span>
              ` : `
                <span class="step-label w-1/4 text-center text-primary" data-step="1">1. Pédagogie</span>
                <span class="step-label w-1/4 text-center" data-step="2">2. Devoirs</span>
                <span class="step-label w-1/4 text-center" data-step="3">3. Conduite</span>
                <span class="step-label w-1/4 text-center" data-step="4">4. Scolarité</span>
              `}
            </div>
            <div class="mt-3 h-2 overflow-hidden rounded-full bg-slate-200/80">
              <div id="progress-bar" class="progress-fill h-full rounded-full bg-primary" style="width: ${100/totalSteps}%;" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="${totalSteps}"></div>
            </div>
          </div>

          <div class="mt-8 rounded-3xl border border-slate-200/80 bg-white p-6 shadow-xl shadow-violet-100/50 sm:p-10">
            <p id="step-banner" class="mb-6 text-center text-sm font-semibold text-primary">Étape 1/${totalSteps} — ${isUniv ? 'Système de périodes' : 'Système pédagogique'}</p>

            <form id="setup-form" novalidate>
              ${isUniv ? renderUniversitySteps() : renderCollegeSteps()}
              <div class="mt-10 flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">
                <button type="button" id="btn-prev" class="rounded-xl border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40">Précédent</button>
                <div class="flex flex-col gap-3 sm:flex-row sm:gap-3">
                  <button type="button" id="btn-next" class="rounded-xl bg-primary px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-primary/25 transition hover:bg-violet-800">Suivant</button>
                  <button type="submit" id="btn-submit" class="hidden items-center justify-center gap-2 rounded-xl bg-primary px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-primary/25 transition hover:bg-violet-800 disabled:opacity-60">
                    <span id="btn-submit-label">Confirmer</span>
                    <svg id="btn-submit-spinner" class="hidden h-5 w-5 animate-spin text-white" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                      <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" class="opacity-25" />
                      <path fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4Z" class="opacity-90" />
                    </svg>
                  </button>
                </div>
              </div>
            </form>
          </div>
        `;

        initWizard();
      }

      function renderCollegeSteps() {
        return `
          <div class="step-panel is-active" data-step="1" role="tabpanel">
            <h2 class="font-heading text-xl font-bold text-slate-900 sm:text-2xl">Comment fonctionne votre établissement ?</h2>
            <p class="mt-2 text-sm text-slate-600">Choisissez comment les périodes scolaires sont découpées.</p>
            <div class="mt-8 grid gap-4 sm:grid-cols-2">
              <label class="group relative cursor-pointer">
                <input type="radio" name="period_system" value="semester" class="peer sr-only" checked>
                <div class="rounded-2xl border-2 border-slate-200 bg-slate-50/50 p-5 transition peer-checked:border-primary peer-checked:bg-primary/[0.06] peer-checked:shadow-md hover:border-primary/40">
                  <div class="flex items-start gap-3"><span class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" /><path stroke-linecap="round" stroke-linejoin="round" d="M4 7h12v10H6a2 2 0 0 1-2-2V7Z" /></svg></span><div><span class="font-heading font-bold text-slate-900">Semestre</span><p class="mt-1 text-sm text-slate-600">2 périodes par an (S1, S2)</p></div></div>
                </div>
              </label>
              <label class="group relative cursor-pointer">
                <input type="radio" name="period_system" value="trimester" class="peer sr-only">
                <div class="rounded-2xl border-2 border-slate-200 bg-slate-50/50 p-5 transition peer-checked:border-primary peer-checked:bg-primary/[0.06] peer-checked:shadow-md hover:border-primary/40">
                  <div class="flex items-start gap-3"><span class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-accent/50 text-slate-800"><svg class="h-5 w-5 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h10" /></svg></span><div><span class="font-heading font-bold text-slate-900">Trimestre</span><p class="mt-1 text-sm text-slate-600">3 périodes par an (T1, T2, T3)</p></div></div>
                </div>
              </label>
            </div>
            <div class="formula-box mt-8 rounded-2xl border border-violet-100 bg-violet-50/60 px-4 py-4 sm:px-5">
              <p class="text-xs font-semibold uppercase tracking-wide text-primary">Formule annuelle (aperçu)</p>
              <p id="formula-period" class="mt-2 font-mono text-sm text-slate-800 sm:text-base"></p>
            </div>
            <p class="field-error mt-2 hidden text-sm text-red-600" id="err-step1"></p>
          </div>
          <div class="step-panel" data-step="2" role="tabpanel">
            <h2 class="font-heading text-xl font-bold text-slate-900 sm:text-2xl">Quels types de devoirs utilisez-vous ?</h2>
            <p class="mt-2 text-sm text-slate-600">Cochez les types de devoirs que vous souhaitez suivre.</p>
            <div class="mt-8 space-y-4">
              <label class="flex cursor-pointer items-center justify-between gap-4 rounded-2xl border border-slate-200 px-4 py-3 transition hover:border-primary/30"><span class="font-medium text-slate-900">Interrogations <span class="text-slate-500">(MI)</span></span><input type="checkbox" name="hw_mi" value="1" checked class="peer sr-only hom-toggle"><span class="relative h-7 w-12 shrink-0 rounded-full bg-slate-200 transition peer-checked:bg-primary after:absolute after:left-1 after:top-1 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition peer-checked:after:translate-x-5"></span></label>
              <label class="flex cursor-pointer items-center justify-between gap-4 rounded-2xl border border-slate-200 px-4 py-3 transition hover:border-primary/30"><span class="font-medium text-slate-900">Devoir 1 <span class="text-slate-500">(D1)</span></span><input type="checkbox" name="hw_d1" value="1" checked class="peer sr-only hom-toggle"><span class="relative h-7 w-12 shrink-0 rounded-full bg-slate-200 transition peer-checked:bg-primary after:absolute after:left-1 after:top-1 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition peer-checked:after:translate-x-5"></span></label>
              <label class="flex cursor-pointer items-center justify-between gap-4 rounded-2xl border border-slate-200 px-4 py-3 transition hover:border-primary/30"><span class="font-medium text-slate-900">Devoir 2 <span class="text-slate-500">(D2)</span></span><input type="checkbox" name="hw_d2" value="1" checked class="peer sr-only hom-toggle"><span class="relative h-7 w-12 shrink-0 rounded-full bg-slate-200 transition peer-checked:bg-primary after:absolute after:left-1 after:top-1 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition peer-checked:after:translate-x-5"></span></label>
              <label class="flex cursor-pointer items-center justify-between gap-4 rounded-2xl border border-slate-200 px-4 py-3 transition hover:border-primary/30"><span class="font-medium text-slate-900">Devoir hebdomadaire <span class="text-slate-500">(DH)</span></span><input type="checkbox" name="hw_dh" value="1" class="peer sr-only hom-toggle"><span class="relative h-7 w-12 shrink-0 rounded-full bg-slate-200 transition peer-checked:bg-primary after:absolute after:left-1 after:top-1 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition peer-checked:after:translate-x-5"></span></label>
            </div>
            <p class="field-error mt-6 hidden text-sm text-red-600" id="err-step2"></p>
          </div>
          <div class="step-panel" data-step="3" role="tabpanel">
            <h2 class="font-heading text-xl font-bold text-slate-900 sm:text-2xl">Conduite &amp; paramètres</h2>
            <p class="mt-2 text-sm text-slate-600">Définissez si vous souhaitez inclure une note de conduite.</p>
            <div class="mt-6 rounded-2xl border border-slate-200 p-4 sm:p-5">
              <label class="flex cursor-pointer items-center justify-between gap-4"><span class="font-medium text-slate-900">Activer la note de conduite</span><input type="checkbox" name="conduct_enabled" value="1" id="conduct_enabled" class="peer sr-only"><span class="relative h-7 w-12 shrink-0 cursor-pointer rounded-full bg-slate-200 transition peer-checked:bg-primary after:pointer-events-none after:absolute after:left-1 after:top-1 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition peer-checked:after:translate-x-5"></span></label>
              <div id="conduct-fields" class="mt-4 hidden space-y-4 border-t border-slate-100 pt-4">
                <div class="grid gap-4 sm:grid-cols-2">
                  <div><label for="conduct_coeff" class="block text-sm font-medium text-slate-700">Coefficient conduite</label><input type="number" name="conduct_coefficient" id="conduct_coeff" step="0.1" min="0.1" value="1" class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 outline-none focus:border-primary focus:ring-2 focus:ring-primary/20"></div>
                  <div><label for="conduct_max" class="block text-sm font-medium text-slate-700">Note max. conduite</label><input type="number" name="conduct_max" id="conduct_max" min="1" max="20" value="20" class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 outline-none focus:border-primary focus:ring-2 focus:ring-primary/20"></div>
                </div>
              </div>
            </div>
            <div class="formula-box mt-6 rounded-2xl border border-violet-100 bg-violet-50/60 px-4 py-4"><p class="text-xs font-semibold uppercase text-primary">Formule annuelle (rappel)</p><p id="formula-period-full" class="mt-2 font-mono text-sm text-slate-800"></p></div>
            <p class="field-error mt-2 hidden text-sm text-red-600" id="err-step3"></p>
          </div>
          <div class="step-panel" data-step="4" role="tabpanel">
            <h2 class="font-heading text-xl font-bold text-slate-900 sm:text-2xl">Scolarité &amp; confirmation</h2>
            <p class="mt-2 text-sm text-slate-600">Vérifiez le récapitulatif puis validez.</p>
            <div class="mt-6"><label class="block text-sm font-medium text-slate-700">Devise</label><input type="text" name="currency" value="FCFA" readonly class="mt-1 w-full max-w-md cursor-not-allowed rounded-xl border border-slate-200 bg-slate-100 px-4 py-2.5 text-slate-600"><p class="mt-1 text-xs text-slate-500">Paramètre fixe pour l’instant.</p></div>
            <div class="mt-8 rounded-2xl border border-slate-200 bg-slate-50/80 p-5 sm:p-6"><h3 class="font-heading text-sm font-bold uppercase tracking-wide text-slate-500">Récapitulatif</h3><dl id="summary-dl" class="mt-4 space-y-3 text-sm"></dl></div>
            <p id="submit-error" class="mt-4 hidden rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert"></p>
          </div>
        `;
      }

      function renderUniversitySteps() {
        return `
          <div class="step-panel is-active" data-step="1" role="tabpanel">
            <h2 class="font-heading text-xl font-bold text-slate-900 sm:text-2xl">Organisation des périodes</h2>
            <p class="mt-2 text-sm text-slate-600">Choisissez le découpage de l'année universitaire.</p>
            <div class="mt-8 grid gap-4 sm:grid-cols-2">
              <label class="group relative cursor-pointer">
                <input type="radio" name="period_system" value="semester" class="peer sr-only" checked>
                <div class="rounded-2xl border-2 border-slate-200 bg-slate-50/50 p-5 transition peer-checked:border-primary peer-checked:bg-primary/[0.06] peer-checked:shadow-md hover:border-primary/40">
                  <div class="flex items-start gap-3"><span class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" /><path stroke-linecap="round" stroke-linejoin="round" d="M4 7h12v10H6a2 2 0 0 1-2-2V7Z" /></svg></span><div><span class="font-heading font-bold text-slate-900">Semestre</span><p class="mt-1 text-sm text-slate-600">2 semestres par an (S1, S2)</p></div></div>
                </div>
              </label>
              <label class="group relative cursor-pointer">
                <input type="radio" name="period_system" value="trimester" class="peer sr-only">
                <div class="rounded-2xl border-2 border-slate-200 bg-slate-50/50 p-5 transition peer-checked:border-primary peer-checked:bg-primary/[0.06] peer-checked:shadow-md hover:border-primary/40">
                  <div class="flex items-start gap-3"><span class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-accent/50 text-slate-800"><svg class="h-5 w-5 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h10" /></svg></span><div><span class="font-heading font-bold text-slate-900">Trimestre</span><p class="mt-1 text-sm text-slate-600">3 trimestres par an (T1, T2, T3)</p></div></div>
                </div>
              </label>
            </div>
            <div class="formula-box mt-8 rounded-2xl border border-violet-100 bg-violet-50/60 px-4 py-4 sm:px-5">
              <p class="text-xs font-semibold uppercase tracking-wide text-primary">Formule annuelle (aperçu)</p>
              <p id="formula-period" class="mt-2 font-mono text-sm text-slate-800 sm:text-base"></p>
            </div>
            <p class="field-error mt-2 hidden text-sm text-red-600" id="err-step1"></p>
          </div>
          <div class="step-panel" data-step="2" role="tabpanel">
            <h2 class="font-heading text-xl font-bold text-slate-900 sm:text-2xl">Types d'unités d'enseignement (UE)</h2>
            <p class="mt-2 text-sm text-slate-600">Cochez les catégories d'UE que vous souhaitez suivre.</p>
            <div class="mt-8 space-y-4">
              <label class="flex cursor-pointer items-center justify-between gap-4 rounded-2xl border border-slate-200 px-4 py-3 transition hover:border-primary/30"><span class="font-medium text-slate-900">UE Fondamentale</span><input type="checkbox" name="ue_fondamentale" value="1" checked class="peer sr-only ue-toggle"><span class="relative h-7 w-12 shrink-0 rounded-full bg-slate-200 transition peer-checked:bg-primary after:absolute after:left-1 after:top-1 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition peer-checked:after:translate-x-5"></span></label>
              <label class="flex cursor-pointer items-center justify-between gap-4 rounded-2xl border border-slate-200 px-4 py-3 transition hover:border-primary/30"><span class="font-medium text-slate-900">UE Complémentaire</span><input type="checkbox" name="ue_complementaire" value="1" checked class="peer sr-only ue-toggle"><span class="relative h-7 w-12 shrink-0 rounded-full bg-slate-200 transition peer-checked:bg-primary after:absolute after:left-1 after:top-1 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition peer-checked:after:translate-x-5"></span></label>
              <label class="flex cursor-pointer items-center justify-between gap-4 rounded-2xl border border-slate-200 px-4 py-3 transition hover:border-primary/30"><span class="font-medium text-slate-900">UE Transversale</span><input type="checkbox" name="ue_transversale" value="1" class="peer sr-only ue-toggle"><span class="relative h-7 w-12 shrink-0 rounded-full bg-slate-200 transition peer-checked:bg-primary after:absolute after:left-1 after:top-1 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition peer-checked:after:translate-x-5"></span></label>
              <label class="flex cursor-pointer items-center justify-between gap-4 rounded-2xl border border-slate-200 px-4 py-3 transition hover:border-primary/30"><span class="font-medium text-slate-900">UE Optionnelle</span><input type="checkbox" name="ue_optionnelle" value="1" class="peer sr-only ue-toggle"><span class="relative h-7 w-12 shrink-0 rounded-full bg-slate-200 transition peer-checked:bg-primary after:absolute after:left-1 after:top-1 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition peer-checked:after:translate-x-5"></span></label>
            </div>
            <p class="field-error mt-6 hidden text-sm text-red-600" id="err-step2"></p>
          </div>
          <div class="step-panel" data-step="3" role="tabpanel">
            <h2 class="font-heading text-xl font-bold text-slate-900 sm:text-2xl">Scolarité &amp; confirmation</h2>
            <p class="mt-2 text-sm text-slate-600">Vérifiez le récapitulatif puis validez.</p>
            <div class="mt-6"><label class="block text-sm font-medium text-slate-700">Devise</label><input type="text" name="currency" value="FCFA" readonly class="mt-1 w-full max-w-md cursor-not-allowed rounded-xl border border-slate-200 bg-slate-100 px-4 py-2.5 text-slate-600"><p class="mt-1 text-xs text-slate-500">Paramètre fixe pour l’instant.</p></div>
            <div class="mt-8 rounded-2xl border border-slate-200 bg-slate-50/80 p-5 sm:p-6"><h3 class="font-heading text-sm font-bold uppercase tracking-wide text-slate-500">Récapitulatif</h3><dl id="summary-dl" class="mt-4 space-y-3 text-sm"></dl></div>
            <p id="submit-error" class="mt-4 hidden rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert"></p>
          </div>
        `;
      }

      function initWizard() {
        const form = document.getElementById("setup-form");
        const isUniv = typeEtablissement === "universite";

        function getPeriod() {
          const r = form.querySelector('input[name="period_system"]:checked');
          return r ? r.value : "semester";
        }

        function updateFormulaPeriod() {
          const p = getPeriod();
          const el = document.getElementById("formula-period");
          const full = document.getElementById("formula-period-full");
          const text = p === "semester" ? "MA = (MGS1 × 1 + MGS2 × 2) / 3" : "MA = (MGT1 + MGT2 + MGT3) / 3";
          if (el) el.textContent = text;
          if (full) full.textContent = text;
        }

        function getCollegeSettings() {
          return {
            hw_mi: form.querySelector('input[name="hw_mi"]')?.checked || false,
            hw_d1: form.querySelector('input[name="hw_d1"]')?.checked || false,
            hw_d2: form.querySelector('input[name="hw_d2"]')?.checked || false,
            hw_dh: form.querySelector('input[name="hw_dh"]')?.checked || false,
            conduct_enabled: document.getElementById("conduct_enabled")?.checked || false,
            conduct_coeff: document.getElementById("conduct_coeff")?.value || "1",
            conduct_max: document.getElementById("conduct_max")?.value || "20"
          };
        }

        function getUniversitySettings() {
          return {
            ue_fondamentale: form.querySelector('input[name="ue_fondamentale"]')?.checked || false,
            ue_complementaire: form.querySelector('input[name="ue_complementaire"]')?.checked || false,
            ue_transversale: form.querySelector('input[name="ue_transversale"]')?.checked || false,
            ue_optionnelle: form.querySelector('input[name="ue_optionnelle"]')?.checked || false
          };
        }

        function validateStep(n) {
          const err1 = document.getElementById("err-step1");
          const err2 = document.getElementById("err-step2");
          const err3 = document.getElementById("err-step3");
          [err1, err2, err3].forEach(e => { if (e) { e.classList.add("hidden"); e.textContent = ""; } });

          if (n === 1) {
            if (!form.querySelector('input[name="period_system"]:checked')) {
              err1.textContent = "Choisissez un système de périodes.";
              err1.classList.remove("hidden");
              return false;
            }
            return true;
          }
          if (n === 2) {
            if (isUniv) {
              const ue = getUniversitySettings();
              if (!ue.ue_fondamentale && !ue.ue_complementaire && !ue.ue_transversale && !ue.ue_optionnelle) {
                err2.textContent = "Activez au moins un type d'UE.";
                err2.classList.remove("hidden");
                return false;
              }
            } else {
              const hw = getCollegeSettings();
              if (!hw.hw_mi && !hw.hw_d1 && !hw.hw_d2 && !hw.hw_dh) {
                err2.textContent = "Activez au moins un type de devoir.";
                err2.classList.remove("hidden");
                return false;
              }
            }
            return true;
          }
          if (n === 3 && !isUniv) {
            if (document.getElementById("conduct_enabled")?.checked) {
              const c = parseFloat(document.getElementById("conduct_coeff").value);
              const mx = parseFloat(document.getElementById("conduct_max").value);
              if (isNaN(c) || c <= 0) { err3.textContent = "Coefficient de conduite invalide."; err3.classList.remove("hidden"); return false; }
              if (isNaN(mx) || mx < 1) { err3.textContent = "Note max. conduite invalide."; err3.classList.remove("hidden"); return false; }
            }
            return true;
          }
          return true;
        }

        function showStep(step) {
          currentStep = step;
          document.querySelectorAll(".step-panel").forEach(p => {
            const sn = parseInt(p.getAttribute("data-step"), 10);
            p.classList.toggle("is-active", sn === step);
          });
          document.querySelectorAll(".step-label").forEach(l => {
            const sn = parseInt(l.getAttribute("data-step"), 10);
            l.classList.toggle("text-primary", sn === step);
            l.classList.toggle("font-bold", sn === step);
            l.classList.toggle("text-slate-500", sn !== step);
          });

          const pct = (step / totalSteps) * 100;
          const bar = document.getElementById("progress-bar");
          bar.style.width = pct + "%";
          bar.setAttribute("aria-valuenow", String(step));

          const titles = isUniv ? 
            ["", "Étape 1/3 — Périodes", "Étape 2/3 — Unités d'enseignement", "Étape 3/3 — Scolarité & Confirmation"] :
            ["", "Étape 1/4 — Système pédagogique", "Étape 2/4 — Types de devoirs", "Étape 3/4 — Conduite", "Étape 4/4 — Scolarité & Confirmation"];
          document.getElementById("step-banner").textContent = titles[step];

          document.getElementById("btn-prev").disabled = step === 1;
          document.getElementById("btn-next").classList.toggle("hidden", step === totalSteps);
          document.getElementById("btn-submit").classList.toggle("hidden", step !== totalSteps);
          document.getElementById("btn-submit").classList.toggle("flex", step === totalSteps);

          if (step === totalSteps) buildSummary();
          saveLocal();
        }

        function buildSummary() {
          const p = getPeriod() === "semester" ? "Semestre (S1, S2)" : "Trimestre (T1, T2, T3)";
          const dl = document.getElementById("summary-dl");
          let rows = [["Système de périodes", p], ["Formule annuelle", document.getElementById("formula-period-full")?.textContent || (p === "semester" ? "MA = (MGS1 × 1 + MGS2 × 2) / 3" : "MA = (MGT1 + MGT2 + MGT3) / 3")]];
          
          if (isUniv) {
            const ue = getUniversitySettings();
            const ueList = [];
            if (ue.ue_fondamentale) ueList.push("Fondamentale");
            if (ue.ue_complementaire) ueList.push("Complémentaire");
            if (ue.ue_transversale) ueList.push("Transversale");
            if (ue.ue_optionnelle) ueList.push("Optionnelle");
            rows.push(["UE suivies", ueList.join(", ") || "—"]);
          } else {
            const hw = getCollegeSettings();
            const hwList = [];
            if (hw.hw_mi) hwList.push("MI");
            if (hw.hw_d1) hwList.push("D1");
            if (hw.hw_d2) hwList.push("D2");
            if (hw.hw_dh) hwList.push("DH");
            rows.push(["Devoirs suivis", hwList.join(", ") || "—"]);
            const conduct = document.getElementById("conduct_enabled")?.checked
              ? "Oui (coef. " + document.getElementById("conduct_coeff").value + ", max " + document.getElementById("conduct_max").value + ")"
              : "Non";
            rows.push(["Note de conduite", conduct]);
          }
          rows.push(["Devise", "FCFA"]);
          dl.innerHTML = rows.map(r => `<div class="flex flex-col gap-0.5 border-b border-slate-200/80 pb-3 last:border-0 sm:flex-row sm:justify-between"><dt class="font-medium text-slate-500">${r[0]}</dt><dd class="text-slate-900">${r[1]}</dd></div>`).join("");
        }

        function collectState() {
          const state = { period_system: getPeriod(), currency: "FCFA", currentStep };
          if (isUniv) {
            Object.assign(state, getUniversitySettings());
          } else {
            Object.assign(state, getCollegeSettings());
          }
          return state;
        }

        function saveLocal() {
          try { localStorage.setItem(STORAGE_KEY + (isUniv ? "_univ" : "_college"), JSON.stringify(collectState())); } catch (e) {}
        }

        function loadLocal() {
          try {
            const raw = localStorage.getItem(STORAGE_KEY + (isUniv ? "_univ" : "_college"));
            if (!raw) return false;
            const s = JSON.parse(raw);
            if (s.period_system) {
              const radio = form.querySelector(`input[name="period_system"][value="${s.period_system}"]`);
              if (radio) radio.checked = true;
            }
            if (isUniv) {
              form.querySelector('input[name="ue_fondamentale"]').checked = !!s.ue_fondamentale;
              form.querySelector('input[name="ue_complementaire"]').checked = !!s.ue_complementaire;
              form.querySelector('input[name="ue_transversale"]').checked = !!s.ue_transversale;
              form.querySelector('input[name="ue_optionnelle"]').checked = !!s.ue_optionnelle;
            } else {
              form.querySelector('input[name="hw_mi"]').checked = !!s.hw_mi;
              form.querySelector('input[name="hw_d1"]').checked = !!s.hw_d1;
              form.querySelector('input[name="hw_d2"]').checked = !!s.hw_d2;
              form.querySelector('input[name="hw_dh"]').checked = !!s.hw_dh;
              document.getElementById("conduct_enabled").checked = !!s.conduct_enabled;
              if (s.conduct_coefficient != null) document.getElementById("conduct_coeff").value = s.conduct_coefficient;
              if (s.conduct_max != null) document.getElementById("conduct_max").value = s.conduct_max;
              toggleConduct();
            }
            updateFormulaPeriod();
            const st = parseInt(s.currentStep, 10);
            if (st >= 1 && st <= totalSteps) showStep(st);
            return true;
          } catch (e) { return false; }
        }

        function toggleConduct() {
          if (isUniv) return;
          const on = document.getElementById("conduct_enabled").checked;
          document.getElementById("conduct-fields").classList.toggle("hidden", !on);
        }

        // Attacher événements
        document.getElementById("btn-next").addEventListener("click", () => {
          if (!validateStep(currentStep)) return;
          if (currentStep < totalSteps) showStep(currentStep + 1);
        });
        document.getElementById("btn-prev").addEventListener("click", () => {
          if (currentStep > 1) showStep(currentStep - 1);
        });
        form.querySelectorAll('input[name="period_system"]').forEach(r => r.addEventListener("change", () => { updateFormulaPeriod(); saveLocal(); }));
        if (!isUniv) {
          form.querySelectorAll(".hom-toggle").forEach(cb => cb.addEventListener("change", saveLocal));
          document.getElementById("conduct_enabled").addEventListener("change", () => { toggleConduct(); saveLocal(); });
          ["conduct_coeff", "conduct_max"].forEach(id => document.getElementById(id).addEventListener("input", saveLocal));
        } else {
          form.querySelectorAll(".ue-toggle").forEach(cb => cb.addEventListener("change", saveLocal));
        }
        window.addEventListener("beforeunload", saveLocal);

        form.addEventListener("submit", (ev) => {
          ev.preventDefault();
          for (let i = 1; i <= (isUniv ? 2 : 3); i++) if (!validateStep(i)) { showStep(i); return; }
          const errEl = document.getElementById("submit-error");
          errEl.classList.add("hidden");

          const btn = document.getElementById("btn-submit");
          const label = document.getElementById("btn-submit-label");
          const spin = document.getElementById("btn-submit-spinner");
          btn.disabled = true;
          label.textContent = "Enregistrement…";
          spin.classList.remove("hidden");

          const fd = new FormData();
          fd.append("action", "save_school_settings");
          fd.append("establishment_type", typeEtablissement);
          fd.append("period_system", getPeriod());
          if (isUniv) {
            const ue = getUniversitySettings();
            fd.append("ue_fondamentale", ue.ue_fondamentale ? "1" : "0");
            fd.append("ue_complementaire", ue.ue_complementaire ? "1" : "0");
            fd.append("ue_transversale", ue.ue_transversale ? "1" : "0");
            fd.append("ue_optionnelle", ue.ue_optionnelle ? "1" : "0");
          } else {
            const hw = getCollegeSettings();
            fd.append("hw_mi", hw.hw_mi ? "1" : "0");
            fd.append("hw_d1", hw.hw_d1 ? "1" : "0");
            fd.append("hw_d2", hw.hw_d2 ? "1" : "0");
            fd.append("hw_dh", hw.hw_dh ? "1" : "0");
            fd.append("conduct_enabled", hw.conduct_enabled ? "1" : "0");
            fd.append("conduct_coefficient", hw.conduct_coeff);
            fd.append("conduct_max", hw.conduct_max);
          }
          fd.append("currency", "FCFA");

          fetch(API_URL, { method: "POST", body: fd, headers: { Accept: "application/json" }, credentials: "same-origin" })
            .then(res => res.json().then(data => ({ ok: res.ok, data })).catch(() => ({ ok: res.ok, data: {} })))
            .then(result => {
              spin.classList.add("hidden");
              btn.disabled = false;
              label.textContent = "Confirmer";
              if (result.ok && (result.data.success === true || result.data.success === "true")) {
                localStorage.removeItem(STORAGE_KEY + (isUniv ? "_univ" : "_college"));
                window.location.href = "dashboard_admin.html";
              } else {
                errEl.textContent = (result.data && (result.data.message || result.data.error)) || "Le serveur n’a pas confirmé l’enregistrement.";
                errEl.classList.remove("hidden");
              }
            })
            .catch(() => {
              spin.classList.add("hidden");
              btn.disabled = false;
              label.textContent = "Confirmer";
              errEl.textContent = "Serveur injoignable. Réessayez plus tard.";
              errEl.classList.remove("hidden");
            });
        });

        updateFormulaPeriod();
        if (!isUniv) toggleConduct();
        if (!loadLocal()) showStep(1);
      }

      // ==================== INITIALISATION GÉNÉRALE ====================
      function init() {
        updateHeaderFooter();
        renderWizard();
        updateSwitchButtons();

        document.getElementById("switch-college")?.addEventListener("click", () => setType("college"));
        document.getElementById("switch-universite")?.addEventListener("click", () => setType("universite"));

        const sidebar = document.getElementById("sidebar"), overlay = document.getElementById("sidebar-overlay"), btnMenu = document.getElementById("btn-menu");
        btnMenu?.addEventListener("click", () => { sidebar.classList.remove("-translate-x-full"); overlay.classList.add("is-open"); document.body.style.overflow = "hidden"; });
        overlay?.addEventListener("click", () => { sidebar.classList.add("-translate-x-full"); overlay.classList.remove("is-open"); document.body.style.overflow = ""; });
        window.addEventListener("resize", () => { if (window.innerWidth >= 1024) { sidebar.classList.remove("-translate-x-full"); overlay.classList.remove("is-open"); document.body.style.overflow = ""; } });

        document.querySelectorAll(".sidebar-toggle").forEach(btn => {
          const id = btn.getAttribute("data-submenu"), panel = document.getElementById(id), chev = btn.querySelector(".chevron");
          if (panel) btn.addEventListener("click", () => { const open = panel.classList.toggle("open"); if (chev) chev.style.transform = open ? "rotate(180deg)" : ""; });
        });

        document.getElementById("last-update").innerText = new Date().toLocaleTimeString("fr-FR");
      }

      init();
    })();
  </script>
</body>
</html>
