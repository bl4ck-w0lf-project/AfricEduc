<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard | EduManager</title>
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
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 text-slate-800 antialiased">
  <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden"></div>

  <!-- Sidebar -->
  <aside id="sidebar" class="fixed left-0 top-0 z-50 flex h-full w-[260px] -translate-x-full flex-col bg-gradient-to-b from-primary to-primaryDark text-white shadow-2xl transition-transform duration-300 lg:translate-x-0">
    <div class="flex h-16 items-center gap-3 border-b border-white/20 px-4">
      <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/20 shadow-lg">
        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 6.75C4 5.78 4.78 5 5.75 5h4.5c.46 0 .9.18 1.22.51l.56.56c.33.33.77.51 1.24.51h5.98c.97 0 1.75.78 1.75 1.75v8.92c0 .97-.78 1.75-1.75 1.75H5.75A1.75 1.75 0 0 1 4 17.25V6.75Z"/><path d="M8 11.5h8M8 14.5h5"/></svg>
      </span>
      <span class="font-heading text-xl font-bold tracking-tight">EduManager</span>
    </div>
    <nav class="flex-1 overflow-y-auto px-3 py-6 text-sm">
      <a href="#" class="sidebar-link active flex items-center gap-3 rounded-xl px-3 py-2.5 mb-1">
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3.75 6A2.25 2.25 0 0 1 6 3.75h3A2.25 2.25 0 0 1 11.25 6v3A2.25 2.25 0 0 1 9 11.25H6A2.25 2.25 0 0 1 3.75 9V6ZM3.75 15A2.25 2.25 0 0 1 6 12.75h3A2.25 2.25 0 0 1 11.25 15v3A2.25 2.25 0 0 1 9 20.25H6A2.25 2.25 0 0 1 3.75 18v-3ZM13.5 6A2.25 2.25 0 0 1 15.75 3.75h3A2.25 2.25 0 0 1 21 6v3A2.25 2.25 0 0 1 18.75 11.25h-3A2.25 2.25 0 0 1 13.5 9V6ZM13.5 15A2.25 2.25 0 0 1 15.75 12.75h3A2.25 2.25 0 0 1 21 15v3A2.25 2.25 0 0 1 18.75 20.25h-3A2.25 2.25 0 0 1 13.5 18v-3Z"/></svg>
        Dashboard
      </a>
      <div class="mt-2">
        <button type="button" class="sidebar-toggle flex w-full items-center justify-between gap-2 rounded-xl px-3 py-2.5 text-left text-white/95 hover:bg-white/10" data-submenu="sub-ecole">
          <span class="flex items-center gap-3"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19.5V8.25L12 4l8 4.25V19.5"/><path d="M9 19.5V12h6v7.5"/></svg>Mon école</span>
          <svg class="chevron h-4 w-4 transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
        </button>
        <div id="sub-ecole" class="submenu open pl-2">
          <a href="#" class="sidebar-link mt-1 block rounded-lg py-2 pl-10 pr-3">Configuration</a>
          <a href="#" class="sidebar-link block rounded-lg py-2 pl-10 pr-3">Identité & contact</a>
        </div>
      </div>
      <div class="mt-1">
        <button type="button" class="sidebar-toggle flex w-full items-center justify-between gap-2 rounded-xl px-3 py-2.5 text-left text-white/95 hover:bg-white/10" data-submenu="sub-org">
          <span class="flex items-center gap-3"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3.75 21h16.5M4.5 3h15A1.5 1.5 0 0 1 21 4.5v13.5A1.5 1.5 0 0 1 19.5 19.5h-15A1.5 1.5 0 0 1 4.5 18v-13.5A1.5 1.5 0 0 1 4.5 3zm4.5 4.5h3M9 12h3m-3 4.5h3M15 7.5h3M15 12h3m-3 4.5h3"/></svg>Organisation</span>
          <svg class="chevron h-4 w-4 transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
        </button>
        <div id="sub-org" class="submenu open pl-2">
          <a href="#" class="sidebar-link mt-1 block rounded-lg py-2 pl-10 pr-3">Classes / Groupes</a>
          <a href="#" class="sidebar-link block rounded-lg py-2 pl-10 pr-3">Matières</a>
        </div>
      </div>
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 mt-1" id="nav-eleves">
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 17a4 4 0 1 1 8 0"/><path d="M15 11a3 3 0 1 0-6 0 3 3 0 0 0 6 0Z"/></svg>
        <span id="nav-eleves-label">Élèves</span>
      </a>
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">Notes & Moyennes</a>
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">Scolarité & Paiements</a>
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">Agents</a>
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">Bulletins & Documents</a>
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">Statistiques</a>
      <div class="mt-8 border-t border-white/15 pt-4">
        <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 text-red-200 hover:bg-red-500/20">Déconnexion</a>
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
          <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-primary to-primaryDark text-sm font-bold text-white shadow-md">AK</span>
          <span class="hidden text-left text-sm sm:block"><span class="block font-medium text-slate-900">Aminata Kossi</span><span class="text-xs text-slate-500">Administratrice</span></span>
        </button>
      </div>
    </header>

    <main class="px-4 py-6 sm:px-6 lg:px-8">
      <!-- Conteneur dynamique (tout le contenu sera injecté ici) -->
      <div id="dynamic-content">
        <!-- Le JavaScript va remplir cette div -->
      </div>
      <footer class="mt-12 pb-8 text-center text-xs text-slate-400">
        EduManager — <span id="footer-school">Collège Saint-Michel</span> · Données en temps réel · Dernière mise à jour : <span id="last-update"></span>
      </footer>
    </main>
  </div>

  <!-- Modale générique -->
  <div id="modal-generic" class="modal-overlay"><div class="modal-content bg-white rounded-2xl shadow-2xl p-6"><div class="flex justify-between items-center mb-4"><h3 class="font-heading text-xl font-bold text-slate-900" id="modal-title">Titre</h3><button id="close-modal" class="text-slate-400 hover:text-slate-600"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg></button></div><div id="modal-body" class="text-slate-700"></div><div class="mt-6 flex justify-end"><button id="modal-close-btn" class="rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white">Fermer</button></div></div></div>

  <div id="toast" class="toast"></div>

  <script>
    (function () {
      // ==================== 1. DONNÉES STATIQUES ====================
      const collegeData = {
        schoolName: "Collège Saint-Michel",
        schoolLocation: "Cotonou, Bénin",
        classes: [
          { name: "6ème A", students: 14, avgGrade: 12.4, successRate: 86, presence: 94, payments: "12/14" },
          { name: "5ème B", students: 12, avgGrade: 11.8, successRate: 79, presence: 87, payments: "11/12" },
          { name: "4ème A", students: 13, avgGrade: 12.1, successRate: 81, presence: 91, payments: "12/13" },
          { name: "Tle D", students: 11, avgGrade: 13.2, successRate: 91, presence: 96, payments: "9/11" }
        ],
        students: [
          { id: 1, nom: "KOUADIO", prenom: "Marie", classe: "3ème", etablissement: "Collège Saint-Michel", matricule: "CSM-001", notes: [{ matiere: "Mathématiques", note: 15, coeff:3 }, { matiere: "Français", note: 14, coeff:2 }, { matiere: "Anglais", note: 16, coeff:2 }, { matiere: "Physique-Chimie", note: 13, coeff:2 }, { matiere: "SVT", note: 14, coeff:1 }, { matiere: "Histoire-Géo", note: 12, coeff:1 }] },
          { id: 2, nom: "TRAORÉ", prenom: "Ibrahim", classe: "Seconde", etablissement: "Lycée Béhanzin", matricule: "LB-045", notes: [{ matiere: "Mathématiques", note: 12, coeff:3 }, { matiere: "Français", note: 10, coeff:2 }, { matiere: "Anglais", note: 11, coeff:2 }, { matiere: "Physique-Chimie", note: 9, coeff:2 }, { matiere: "SVT", note: 10, coeff:1 }, { matiere: "Histoire-Géo", note: 8, coeff:1 }] },
          { id: 3, nom: "DIALLO", prenom: "Aminata", classe: "Terminale", etablissement: "Université Partenaire Atlantique", matricule: "UPA-234", notes: [{ matiere: "Mathématiques", note: 18, coeff:3 }, { matiere: "Français", note: 17, coeff:2 }, { matiere: "Anglais", note: 19, coeff:2 }, { matiere: "Physique-Chimie", note: 16, coeff:2 }, { matiere: "SVT", note: 18, coeff:1 }, { matiere: "Histoire-Géo", note: 15, coeff:1 }] },
          { id: 4, nom: "N'GUESSAN", prenom: "Koffi", classe: "4ème", etablissement: "Cours Secondaire Ste Thérèse", matricule: "CST-089", notes: [{ matiere: "Mathématiques", note: 11, coeff:3 }, { matiere: "Français", note: 12, coeff:2 }, { matiere: "Anglais", note: 10, coeff:2 }, { matiere: "Physique-Chimie", note: 9, coeff:2 }, { matiere: "SVT", note: 13, coeff:1 }, { matiere: "Histoire-Géo", note: 11, coeff:1 }] },
          { id: 5, nom: "HOUNDONOU", prenom: "Jules", classe: "5ème", etablissement: "École Le Savoir", matricule: "ELS-067", notes: [{ matiere: "Mathématiques", note: 8, coeff:3 }, { matiere: "Français", note: 9, coeff:2 }, { matiere: "Anglais", note: 7, coeff:2 }, { matiere: "Physique-Chimie", note: 10, coeff:2 }, { matiere: "SVT", note: 9, coeff:1 }, { matiere: "Histoire-Géo", note: 8, coeff:1 }] }
        ]
      };

      const universityData = {
        schoolName: "Université d'Abomey-Calavi",
        schoolLocation: "Abomey-Calavi, Bénin",
        classes: [
          { name: "Licence 1 Informatique", students: 45, avgGrade: 12.8, successRate: 74, presence: 88, payments: "38/45" },
          { name: "Licence 2 Mathématiques", students: 38, avgGrade: 11.9, successRate: 68, presence: 85, payments: "30/38" },
          { name: "Master 1 Droit", students: 30, avgGrade: 14.2, successRate: 83, presence: 92, payments: "27/30" },
          { name: "Doctorat Physique", students: 12, avgGrade: 15.5, successRate: 92, presence: 95, payments: "11/12" }
        ],
        students: [
          { id: 1, nom: "KOUASSI", prenom: "Jean", classe: "Licence 1 Info", etablissement: "Université d'Abomey-Calavi", matricule: "UAC-001", notes: [{ matiere: "Algorithmique", note: 14, coeff:3 }, { matiere: "Maths Discrètes", note: 12, coeff:2 }, { matiere: "Anglais", note: 13, coeff:2 }] },
          { id: 2, nom: "YAO", prenom: "Awa", classe: "Master 1 Droit", etablissement: "Université d'Abomey-Calavi", matricule: "UAC-002", notes: [{ matiere: "Droit des contrats", note: 16, coeff:3 }, { matiere: "Droit pénal", note: 15, coeff:2 }, { matiere: "Anglais juridique", note: 14, coeff:2 }] },
          { id: 3, nom: "GNAMIEN", prenom: "Bénédicte", classe: "Licence 2 Maths", etablissement: "Université d'Abomey-Calavi", matricule: "UAC-003", notes: [{ matiere: "Algèbre", note: 11, coeff:3 }, { matiere: "Analyse", note: 10, coeff:2 }, { matiere: "Probabilités", note: 12, coeff:2 }] },
          { id: 4, nom: "HOUNKPATIN", prenom: "Cédric", classe: "Doctorat Physique", etablissement: "Université d'Abomey-Calavi", matricule: "UAC-004", notes: [{ matiere: "Mécanique quantique", note: 17, coeff:3 }, { matiere: "Physique statistique", note: 16, coeff:2 }, { matiere: "Anglais scientifique", note: 15, coeff:2 }] }
        ]
      };

      // ==================== 2. VARIABLES GLOBALES ====================
      let typeEtablissement = "college";
      let currentData = JSON.parse(JSON.stringify(collegeData));
      let nextId = currentData.students.length + 1;

      // Fonction pour calculer la moyenne d'un étudiant
      function getStudentAverage(student) {
        let total = 0, coeffSum = 0;
        student.notes.forEach(n => { total += n.note * n.coeff; coeffSum += n.coeff; });
        return coeffSum ? total / coeffSum : 0;
      }

      // ==================== 3. GESTION DU TYPE ====================
      function setType(type) {
        typeEtablissement = type;
        localStorage.setItem("typeEtablissement", type);
        if (type === "college") currentData = JSON.parse(JSON.stringify(collegeData));
        else currentData = JSON.parse(JSON.stringify(universityData));
        nextId = currentData.students.length + 1;
        renderDashboard();
        updateSwitchButtons();
      }

      // Mettre à jour l'apparence des boutons de switch
      function updateSwitchButtons() {
        const collegeBtn = document.getElementById("switch-college");
        const univBtn = document.getElementById("switch-universite");
        if (collegeBtn && univBtn) {
          const isUniv = typeEtablissement === "universite";
          collegeBtn.className = `px-2 py-1 text-xs font-semibold rounded ${!isUniv ? "bg-primary text-white" : "text-slate-600 hover:bg-slate-200"}`;
          univBtn.className = `px-2 py-1 text-xs font-semibold rounded ${isUniv ? "bg-primary text-white" : "text-slate-600 hover:bg-slate-200"}`;
        }
      }

      // ==================== 4. RENDU DYNAMIQUE COMPLET ====================
      function renderDashboard() {
        const container = document.getElementById("dynamic-content");
        if (!container) return;

        const isUniv = typeEtablissement === "universite";
        const totalStudents = currentData.students.length;
        const actifs = currentData.students.filter(s => getStudentAverage(s) >= 10).length;
        const difficiles = currentData.students.filter(s => getStudentAverage(s) < 10).length;

        // Mettre à jour les éléments statiques (header et footer)
        document.getElementById("school-name-header").innerText = currentData.schoolName;
        document.getElementById("school-location").innerText = currentData.schoolLocation;
        document.getElementById("nav-eleves-label").innerText = isUniv ? "Étudiants" : "Élèves";
        document.getElementById("footer-school").innerText = currentData.schoolName;

        // Génération du HTML
        container.innerHTML = `
          <section class="rounded-2xl border border-slate-200/80 bg-gradient-to-br from-white via-white to-primary/5 p-6 shadow-lg sm:p-8 animate-fade-in">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
              <div><h1 class="font-heading text-2xl font-bold text-slate-900 sm:text-3xl">Bonjour Aminata 👋 — <span class="text-primary">${currentData.schoolName}</span></h1>
                <p class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-slate-600"><span class="inline-flex items-center gap-1.5"><svg class="h-4 w-4 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6.75 3v2.25M17.25 3v2.25M3 9.75h18M5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V6.75A2.25 2.25 0 0 0 18.75 4.5H5.25A2.25 2.25 0 0 0 3 6.75v12A2.25 2.25 0 0 0 5.25 21Z"/></svg><span id="today-date-text"></span></span>
                  <span id="badge-config-ok" class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-800 ring-1 ring-emerald-200/80"><span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>École configurée</span>
                </p>
              </div>
              <div class="flex gap-2"><span class="inline-flex items-center gap-1 rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold text-primary"><svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg>Dernière synchro: aujourd'hui</span></div>
            </div>
          </section>

          <section class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">
            <div class="kpi-card rounded-2xl border border-slate-200/80 bg-white p-5 shadow-md"><div class="flex items-start justify-between gap-2"><span class="flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 17a4 4 0 1 1 8 0"/></svg></span><span class="inline-flex items-center gap-0.5 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700">+4%</span></div><p class="mt-4 text-3xl font-bold tracking-tight text-slate-900">${totalStudents}</p><p class="text-sm font-medium text-slate-500">${isUniv ? "Étudiants inscrits" : "Élèves inscrits"}</p></div>
            <div class="kpi-card rounded-2xl border border-slate-200/80 bg-white p-5 shadow-md"><div class="flex items-start justify-between gap-2"><span class="flex h-11 w-11 items-center justify-center rounded-xl bg-success/10 text-success"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 6v12m-3-9h6M9 9h6M9 15h6M19 5v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg></span><span class="inline-flex items-center gap-0.5 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700">+12%</span></div><p class="mt-4 text-3xl font-bold tracking-tight text-slate-900">2.45M</p><p class="text-sm font-medium text-slate-500">Revenus mensuels (F CFA)</p></div>
            <div class="kpi-card rounded-2xl border border-slate-200/80 bg-white p-5 shadow-md"><div class="flex items-start justify-between gap-2"><span class="flex h-11 w-11 items-center justify-center rounded-xl bg-accent/40 text-slate-800"><svg class="h-6 w-6 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg></span><span class="inline-flex items-center gap-0.5 rounded-full bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-600">stable</span></div><p class="mt-4 text-3xl font-bold tracking-tight text-slate-900">${actifs}</p><p class="text-sm font-medium text-slate-500">${isUniv ? "Étudiants actifs" : "Élèves actifs"}</p></div>
            <div class="kpi-card rounded-2xl border border-slate-200/80 bg-white p-5 shadow-md"><div class="flex items-start justify-between gap-2"><span class="flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 6.75h12M6 12h12m-12 5.25h12"/></svg></span><span class="inline-flex items-center gap-0.5 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700">+1</span></div><p class="mt-4 text-3xl font-bold tracking-tight text-slate-900">${currentData.classes.length}</p><p class="text-sm font-medium text-slate-500">${isUniv ? "Filières / Départements" : "Classes créées"}</p></div>
            <div class="kpi-card rounded-2xl border border-warning/30 bg-warning/5 p-5 shadow-md"><div class="flex items-start justify-between gap-2"><span class="flex h-11 w-11 items-center justify-center rounded-xl bg-warning/20 text-warning"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15h.008v.008H12v-.008z"/></svg></span><span class="inline-flex items-center gap-0.5 rounded-full bg-red-100 px-2 py-0.5 text-xs font-bold text-red-800">Alerte</span></div><p class="mt-4 text-3xl font-bold tracking-tight text-red-900">${difficiles}</p><p class="text-sm font-medium text-red-800/90">${isUniv ? "Étudiants en difficulté" : "Élèves en difficulté"}</p></div>
            <div class="kpi-card rounded-2xl border border-slate-200/80 bg-white p-5 shadow-md"><div class="flex items-start justify-between gap-2"><span class="flex h-11 w-11 items-center justify-center rounded-xl bg-success/10 text-success"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 12h3l3-9 3 18 3-12 3 3 3-3"/></svg></span><span class="inline-flex items-center gap-0.5 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700">+5%</span></div><p class="mt-4 text-3xl font-bold tracking-tight text-slate-900">87<span class="text-lg">%</span></p><p class="text-sm font-medium text-slate-500">Taux de paiement</p></div>
          </section>

          <section class="mt-10 space-y-8"><h2 class="font-heading text-lg font-bold text-slate-900">Indicateurs &amp; tendances</h2><div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-md sm:p-6"><h3 class="font-heading text-base font-semibold">Évolution des inscriptions par mois</h3><div class="mt-4 h-64"><canvas id="chart-inscriptions"></canvas></div></div>
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-md sm:p-6"><h3 class="font-heading text-base font-semibold">Évolution des absences</h3><div class="mt-4 h-64"><canvas id="chart-absences"></canvas></div></div>
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-md sm:p-6"><h3 class="font-heading text-base font-semibold">Performance par ${isUniv ? "filière" : "classe"}</h3><div class="mt-4 h-64"><canvas id="chart-performance"></canvas></div></div>
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-md sm:p-6"><h3 class="font-heading text-base font-semibold">Paiements vs Retards</h3><div class="mt-4 h-64"><canvas id="chart-paiements-vs-retards"></canvas></div></div>
          </div></section>

          <section class="mt-10 grid gap-6 lg:grid-cols-2">
            <div class="rounded-2xl border border-red-200/80 bg-white p-5 shadow-md sm:p-6"><div class="flex items-center justify-between gap-2 mb-4"><h3 class="font-heading text-base font-semibold text-red-900">⚠️ Paiements en retard</h3><span class="rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-bold text-red-800 animate-pulse">Urgent</span></div><ul class="divide-y divide-slate-100"><li class="priority-high flex items-center justify-between gap-3 py-3"><div><p class="font-medium">Kouassi Jean-Baptiste</p><p class="text-xs">3e A — échéance 15 fév. — <span class="text-red-600 font-semibold">+30 jours</span></p></div><div><span class="text-sm font-semibold text-red-700">85k F</span></div></li><li class="priority-high flex items-center justify-between gap-3 py-3"><div><p class="font-medium">Agbodji Chantal</p><p class="text-xs">5e B — échéance 28 fév. — <span class="text-red-600 font-semibold">+17 jours</span></p></div><div><span class="text-sm font-semibold text-red-700">40k F</span></div></li></ul></div>
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-md sm:p-6"><div class="flex items-center justify-between gap-2 mb-4"><h3 class="font-heading text-base font-semibold">📊 Derniers ${isUniv ? "étudiants" : "élèves"} ajoutés</h3><span class="rounded-full bg-primary/10 px-2.5 py-0.5 text-xs font-semibold text-primary">Cette semaine</span></div><ul id="recent-students-list" class="divide-y divide-slate-100"></ul></div>

            <div class="rounded-2xl border border-slate-200/80 bg-gradient-to-br from-primary/5 via-accent/10 to-primary/5 p-5 sm:col-span-2 sm:p-6">
              <h3 class="font-heading text-base font-semibold">⚡ Actions rapides</h3>
              <div class="mt-4 flex flex-wrap gap-3">
                <a href="#" id="btn-add-student" class="action-button inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primaryDark"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 4.5v15m7.5-7.5h-15"/></svg><span id="add-student-btn">${isUniv ? "Ajouter un étudiant" : "Ajouter un élève"}</span></a>
                <a href="#" id="btn-saisir-notes" class="action-button inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-800 shadow-sm hover:border-primary/40 hover:text-primary"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg>Saisir des notes</a>
                <a href="#" id="btn-paiement" class="action-button inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-800 shadow-sm hover:border-primary/40 hover:text-primary"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 4.5h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5z"/></svg>Enregistrer un paiement</a>
                <a href="#" id="btn-bulletin" class="action-button inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-800 shadow-sm hover:border-primary/40 hover:text-primary"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6.75 3.75h10.5l3 4.5v9.75a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25l3-4.5Z"/><path d="M9 12h6M9 15.75h3"/></svg>Générer un bulletin</a>
                <a href="#" id="btn-export" class="action-button inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-800 shadow-sm hover:border-primary/40 hover:text-primary"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>Exporter les données</a>
              </div>
            </div>
          </section>

          <section class="mt-10 overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-md">
            <div class="border-b border-slate-100 px-5 py-4 sm:px-6"><h2 class="font-heading text-lg font-bold text-slate-900">${isUniv ? "Récapitulatif par filière" : "Récapitulatif par classe"}</h2><p class="mt-1 text-sm text-slate-500">Vue consolidée — ${currentData.schoolName}</p></div>
            <div class="overflow-x-auto"><table class="min-w-full text-left text-sm"><thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500"><tr><th class="px-5 py-3 sm:px-6">${isUniv ? "Filière / Niveau" : "Classe"}</th><th class="px-3 py-3">Nb ${isUniv ? "étudiants" : "élèves"}</th><th class="px-3 py-3">Moy. générale</th><th class="px-3 py-3">Taux réussite</th><th class="px-3 py-3">Présence (%)</th><th class="px-3 py-3">Paiements OK</th><th class="px-5 py-3 text-right">Actions</th></tr></thead><tbody id="dynamic-table-body"></tbody></table></div>
          </section>
        `;

        // Remplir le tableau des classes/filières
        const tableBody = document.getElementById("dynamic-table-body");
        if (tableBody) {
          tableBody.innerHTML = currentData.classes.map(c => `
            <tr class="hover:bg-slate-50/80">
              <td class="px-5 py-4 font-medium text-slate-900 sm:px-6">${c.name}</td>
              <td class="px-3 py-4">${c.students}</td>
              <td class="px-3 py-4">${c.avgGrade} /20</td>
              <td class="px-3 py-4"><span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-800">${c.successRate}% ↑</span></td>
              <td class="px-3 py-4"><span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-800">${c.presence}%</span></td>
              <td class="px-3 py-4">${c.payments}</td>
              <td class="px-5 py-4 text-right"><a href="#" class="font-semibold text-primary">Détails →</a></td>
            </td>
          `).join("");
        }

        // Derniers élèves/étudiants
        const recentList = document.getElementById("recent-students-list");
        if (recentList) {
          const recent = [...currentData.students].slice(-3).reverse();
          recentList.innerHTML = recent.map(s => `<li class="flex items-center justify-between gap-3 py-3"><div><p class="font-medium">${s.nom} ${s.prenom}</p><p class="text-xs">${s.classe} — ${s.matricule}</p></div><span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700"><span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>Nouveau</span></li>`).join("");
        }

        // Graphiques (destruction des anciens pour éviter les doublons)
        if (typeof Chart !== "undefined") {
          const primary = "#7300e9", accent = "#99fbe3";
          const ctx1 = document.getElementById("chart-inscriptions")?.getContext("2d");
          const ctx2 = document.getElementById("chart-absences")?.getContext("2d");
          const ctx3 = document.getElementById("chart-performance")?.getContext("2d");
          const ctx4 = document.getElementById("chart-paiements-vs-retards")?.getContext("2d");
          if (ctx1) new Chart(ctx1, { type: "bar", data: { labels: ["Sep","Oct","Nov","Déc","Jan","Fév","Mar","Avr","Mai","Juin"], datasets: [{ label: "Nouvelles inscriptions", data: [18,4,2,1,6,3,5,2,4,5], backgroundColor: primary, borderRadius: 8 }] }, options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: "bottom" } } } });
          if (ctx2) new Chart(ctx2, { type: "line", data: { labels: ["Sep","Oct","Nov","Déc","Jan","Fév","Mar"], datasets: [{ label: "Nombre d'absences", data: [12,8,10,24,14,11,18], borderColor: "#f59e0b", backgroundColor: "rgba(245,158,11,0.1)", fill: true, tension: 0.4 }] }, options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: "bottom" } } } });
          if (ctx3) {
            const classNames = currentData.classes.map(c => c.name);
            const classAvgs = currentData.classes.map(c => c.avgGrade);
            new Chart(ctx3, { type: "bar", data: { labels: classNames, datasets: [{ label: "Moyenne générale /20", data: classAvgs, backgroundColor: [primary, accent, "#c4b5fd", "#a7f3d0"], borderRadius: 8 }] }, options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: "bottom" } }, scales: { y: { beginAtZero: true, max: 20 } } } });
          }
          if (ctx4) new Chart(ctx4, { type: "bar", data: { labels: ["Sep","Oct","Nov","Déc","Jan","Fév","Mar"], datasets: [{ label: "Attendu (k F CFA)", data: [450,450,450,450,450,450,450], backgroundColor: "rgba(115,0,233,0.3)", borderRadius: 8 }, { label: "Reçu (k F CFA)", data: [420,380,310,290,450,260,340], backgroundColor: primary, borderRadius: 8 }] }, options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: "bottom" } } } });
        }

        // Réattacher les événements des actions rapides (car le DOM a été régénéré)
        attachActions();
      }

      // ==================== 5. ACTIONS RAPIDES ====================
      function attachActions() {
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

        // Ajouter un élève/étudiant
        const btnAdd = document.getElementById("btn-add-student");
        if (btnAdd) {
          btnAdd.addEventListener("click", (e) => {
            e.preventDefault();
            const isUniv = typeEtablissement === "universite";
            openModal(isUniv ? "Ajouter un étudiant" : "Ajouter un élève", `
              <form id="add-student-form" class="space-y-3">
                <div><label class="block text-sm font-medium">Nom</label><input type="text" id="new-nom" class="w-full rounded-xl border p-2" required></div>
                <div><label class="block text-sm font-medium">Prénom</label><input type="text" id="new-prenom" class="w-full rounded-xl border p-2" required></div>
                <div><label class="block text-sm font-medium">${isUniv ? "Filière / Niveau" : "Classe"}</label><input type="text" id="new-classe" class="w-full rounded-xl border p-2" required></div>
                <div><label class="block text-sm font-medium">Établissement</label><input type="text" id="new-etab" value="${currentData.schoolName}" class="w-full rounded-xl border p-2" required></div>
                <div><label class="block text-sm font-medium">Matricule</label><input type="text" id="new-matricule" class="w-full rounded-xl border p-2" required></div>
                <button type="submit" class="mt-2 rounded-xl bg-primary px-4 py-2 text-white">Enregistrer</button>
              </form>
            `);
            const form = document.getElementById("add-student-form");
            form?.addEventListener("submit", (ev) => {
              ev.preventDefault();
              const nom = document.getElementById("new-nom").value.trim();
              const prenom = document.getElementById("new-prenom").value.trim();
              const classe = document.getElementById("new-classe").value.trim();
              const etablissement = document.getElementById("new-etab").value.trim();
              const matricule = document.getElementById("new-matricule").value.trim();
              if (!nom || !prenom || !classe || !etablissement || !matricule) {
                showToast("Veuillez remplir tous les champs", "error");
                return;
              }
              const newStudent = { id: nextId++, nom, prenom, classe, etablissement, matricule, notes: [] };
              currentData.students.push(newStudent);
              renderDashboard();
              closeModal();
              showToast(isUniv ? "Étudiant ajouté" : "Élève ajouté");
            });
          });
        }

        // Saisir des notes (simplifié, utilise currentData)
        const btnNotes = document.getElementById("btn-saisir-notes");
        if (btnNotes) {
          btnNotes.addEventListener("click", (e) => {
            e.preventDefault();
            const studentOptions = currentData.students.map(s => `<option value="${s.id}">${s.nom} ${s.prenom} (${s.matricule})</option>`).join("");
            openModal("Saisir une note", `
              <form id="note-form" class="space-y-3">
                <div><label class="block text-sm font-medium">Élève</label><select id="note-student" class="w-full rounded-xl border p-2">${studentOptions}</select></div>
                <div><label class="block text-sm font-medium">Matière</label><input type="text" id="note-matiere" class="w-full rounded-xl border p-2" required></div>
                <div><label class="block text-sm font-medium">Note /20</label><input type="number" step="0.1" min="0" max="20" id="note-value" class="w-full rounded-xl border p-2" required></div>
                <button type="submit" class="mt-2 rounded-xl bg-primary px-4 py-2 text-white">Enregistrer</button>
              </form>
            `);
            const form = document.getElementById("note-form");
            form?.addEventListener("submit", (ev) => {
              ev.preventDefault();
              const studentId = parseInt(document.getElementById("note-student").value);
              const matiere = document.getElementById("note-matiere").value.trim();
              const note = parseFloat(document.getElementById("note-value").value);
              if (!matiere || isNaN(note)) { showToast("Champs invalides", "error"); return; }
              const student = currentData.students.find(s => s.id === studentId);
              if (student) {
                const existing = student.notes.find(n => n.matiere === matiere);
                if (existing) existing.note = note;
                else student.notes.push({ matiere, coeff: 1, note });
                renderDashboard();
                closeModal();
                showToast(`Note ${note}/20 en ${matiere} enregistrée`);
              } else showToast("Élève non trouvé", "error");
            });
          });
        }

        // Paiement (simulation)
        const btnPaiement = document.getElementById("btn-paiement");
        if (btnPaiement) {
          btnPaiement.addEventListener("click", (e) => {
            e.preventDefault();
            const studentOptions = currentData.students.map(s => `<option value="${s.id}">${s.nom} ${s.prenom} (${s.matricule})</option>`).join("");
            openModal("Enregistrer un paiement", `
              <form id="paiement-form" class="space-y-3">
                <div><label class="block text-sm font-medium">Élève</label><select id="paiement-student" class="w-full rounded-xl border p-2">${studentOptions}</select></div>
                <div><label class="block text-sm font-medium">Montant (F CFA)</label><input type="number" id="paiement-montant" class="w-full rounded-xl border p-2" required></div>
                <div><label class="block text-sm font-medium">Référence</label><input type="text" id="paiement-ref" class="w-full rounded-xl border p-2" required></div>
                <button type="submit" class="mt-2 rounded-xl bg-primary px-4 py-2 text-white">Valider</button>
              </form>
            `);
            const form = document.getElementById("paiement-form");
            form?.addEventListener("submit", (ev) => {
              ev.preventDefault();
              const montant = document.getElementById("paiement-montant").value;
              const ref = document.getElementById("paiement-ref").value.trim();
              if (!montant || !ref) { showToast("Champs requis", "error"); return; }
              showToast(`Paiement de ${montant} F CFA (${ref}) enregistré`);
              closeModal();
            });
          });
        }

        // Générer bulletin PDF
        const btnBulletin = document.getElementById("btn-bulletin");
        if (btnBulletin) {
          btnBulletin.addEventListener("click", (e) => {
            e.preventDefault();
            const studentOptions = currentData.students.map(s => `<option value="${s.id}">${s.nom} ${s.prenom} (${s.matricule})</option>`).join("");
            openModal("Générer un bulletin", `
              <form id="bulletin-form" class="space-y-3">
                <div><label class="block text-sm font-medium">Élève</label><select id="bulletin-student" class="w-full rounded-xl border p-2">${studentOptions}</select></div>
                <button type="submit" class="mt-2 rounded-xl bg-primary px-4 py-2 text-white">Générer PDF</button>
              </form>
            `);
            const form = document.getElementById("bulletin-form");
            form?.addEventListener("submit", (ev) => {
              ev.preventDefault();
              const studentId = parseInt(document.getElementById("bulletin-student").value);
              const student = currentData.students.find(s => s.id === studentId);
              if (!student) { showToast("Élève non trouvé", "error"); return; }
              const moyenne = getStudentAverage(student);
              const mention = moyenne >= 16 ? "Très bien" : (moyenne >= 14 ? "Bien" : (moyenne >= 12 ? "Assez bien" : (moyenne >= 10 ? "Passable" : "Insuffisant")));
              const verdict = moyenne >= 10 ? "ADMIS" : "REDOUBLANT";
              const { jsPDF } = window.jspdf;
              const doc = new jsPDF();
              doc.setFont("helvetica", "bold");
              doc.setFontSize(16);
              doc.text("BULLETIN DE NOTES", 105, 20, { align: "center" });
              doc.setFontSize(10);
              doc.setFont("helvetica", "normal");
              doc.text(`${currentData.schoolName} - ${currentData.schoolLocation}`, 105, 30, { align: "center" });
              doc.text(`Année scolaire : ${document.getElementById("school-year").innerText}`, 105, 36, { align: "center" });
              doc.setFont("helvetica", "bold");
              doc.text("INFORMATIONS ÉLÈVE", 14, 50);
              doc.setFont("helvetica", "normal");
              doc.text(`Nom : ${student.nom} ${student.prenom}`, 14, 58);
              doc.text(`Matricule : ${student.matricule}`, 14, 66);
              doc.text(`Classe : ${student.classe}`, 14, 74);
              doc.text(`Établissement : ${student.etablissement}`, 14, 82);
              const rows = student.notes.map(n => [n.matiere, n.coeff, n.note.toFixed(1), (n.note * n.coeff).toFixed(1)]);
              doc.autoTable({
                startY: 92,
                head: [["Matière", "Coeff.", "Note /20", "Pondérée"]],
                body: rows,
                theme: "striped",
                headStyles: { fillColor: [115,0,233], textColor: 255 }
              });
              let finalY = doc.lastAutoTable.finalY + 8;
              doc.text(`Moyenne générale : ${moyenne.toFixed(2)} / 20`, 14, finalY);
              doc.text(`Mention : ${mention}`, 14, finalY + 8);
              doc.text(`Verdict : ${verdict}`, 14, finalY + 16);
              doc.save(`bulletin_${student.matricule}.pdf`);
              closeModal();
              showToast("Bulletin PDF généré");
            });
          });
        }

        // Export CSV
        const btnExport = document.getElementById("btn-export");
        if (btnExport) {
          btnExport.addEventListener("click", (e) => {
            e.preventDefault();
            const headers = ["ID","Nom","Prénom","Classe","Établissement","Matricule","Moyenne"];
            const rows = currentData.students.map(s => [s.id, s.nom, s.prenom, s.classe, s.etablissement, s.matricule, getStudentAverage(s).toFixed(2)]);
            const csv = [headers, ...rows].map(row => row.join(",")).join("\n");
            const blob = new Blob([csv], { type: "text/csv" });
            const url = URL.createObjectURL(blob);
            const a = document.createElement("a");
            a.href = url;
            a.download = "eleves.csv";
            a.click();
            URL.revokeObjectURL(url);
            showToast("Export CSV effectué");
          });
        }
      }

      // ==================== 6. INITIALISATION ====================
      function init() {
        // Récupérer le type stocké ou par défaut
        const storedType = localStorage.getItem("typeEtablissement");
        if (storedType === "college" || storedType === "universite") typeEtablissement = storedType;
        else {
          const urlParams = new URLSearchParams(window.location.search);
          const urlType = urlParams.get("type");
          if (urlType === "college" || urlType === "universite") typeEtablissement = urlType;
          localStorage.setItem("typeEtablissement", typeEtablissement);
        }
        setType(typeEtablissement);

        // Boutons de switch
        document.getElementById("switch-college")?.addEventListener("click", () => setType("college"));
        document.getElementById("switch-universite")?.addEventListener("click", () => setType("universite"));

        // Date et heure
        const now = new Date();
        document.getElementById("today-date-text").innerText = now.toLocaleDateString("fr-BJ", { weekday: "long", year: "numeric", month: "long", day: "numeric" });
        document.getElementById("last-update").innerText = new Date().toLocaleTimeString("fr-FR");

        // Sidebar toggles
        document.querySelectorAll(".sidebar-toggle").forEach(btn => {
          const id = btn.getAttribute("data-submenu");
          const panel = document.getElementById(id);
          const chev = btn.querySelector(".chevron");
          if (panel) btn.addEventListener("click", () => { const open = panel.classList.toggle("open"); if (chev) chev.style.transform = open ? "rotate(180deg)" : ""; });
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
      }

      init();
    })();
  </script>
</body>
</html>