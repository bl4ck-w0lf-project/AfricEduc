<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Statistiques | EduManager</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
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
      <a href="statistiques.html" class="sidebar-link active flex items-center gap-3 rounded-xl px-3 py-2.5">Statistiques</a>
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
          <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-primary to-primaryDark text-sm font-bold text-white shadow-md">AK</span>
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
    (function () {
      // ==================== DONNÉES GLOBALES (collège / université) ====================
      const collegeData = {
        schoolName: "Collège Saint-Michel",
        schoolLocation: "Cotonou, Bénin",
        classes: [
          { name: "6ème A", students: 14, avgGrade: 12.4, successRate: 86, presence: 94 },
          { name: "5ème B", students: 12, avgGrade: 11.8, successRate: 79, presence: 87 },
          { name: "4ème A", students: 13, avgGrade: 12.1, successRate: 81, presence: 91 },
          { name: "Tle D", students: 11, avgGrade: 13.2, successRate: 91, presence: 96 }
        ],
        students: [
          { id: 1, nom: "KOUADIO", prenom: "Marie", classe: "3ème", notes: [{ note: 15, coeff:3 }, { note: 14, coeff:2 }, { note: 16, coeff:2 }] },
          { id: 2, nom: "TRAORÉ", prenom: "Ibrahim", classe: "Seconde", notes: [{ note: 12, coeff:3 }, { note: 10, coeff:2 }, { note: 11, coeff:2 }] },
          { id: 3, nom: "DIALLO", prenom: "Aminata", classe: "Terminale", notes: [{ note: 18, coeff:3 }, { note: 17, coeff:2 }, { note: 19, coeff:2 }] },
          { id: 4, nom: "N'GUESSAN", prenom: "Koffi", classe: "4ème", notes: [{ note: 11, coeff:3 }, { note: 12, coeff:2 }, { note: 10, coeff:2 }] },
          { id: 5, nom: "HOUNDONOU", prenom: "Jules", classe: "5ème", notes: [{ note: 8, coeff:3 }, { note: 9, coeff:2 }, { note: 7, coeff:2 }] }
        ]
      };
      const universityData = {
        schoolName: "Université d'Abomey-Calavi",
        schoolLocation: "Abomey-Calavi, Bénin",
        classes: [
          { name: "Licence 1 Informatique", students: 45, avgGrade: 12.8, successRate: 74, presence: 88 },
          { name: "Licence 2 Mathématiques", students: 38, avgGrade: 11.9, successRate: 68, presence: 85 },
          { name: "Master 1 Droit", students: 30, avgGrade: 14.2, successRate: 83, presence: 92 },
          { name: "Doctorat Physique", students: 12, avgGrade: 15.5, successRate: 92, presence: 95 }
        ],
        students: [
          { id: 1, nom: "KOUASSI", prenom: "Jean", classe: "Licence 1 Info", notes: [{ note: 14, coeff:3 }, { note: 12, coeff:2 }, { note: 13, coeff:2 }] },
          { id: 2, nom: "YAO", prenom: "Awa", classe: "Master 1 Droit", notes: [{ note: 16, coeff:3 }, { note: 15, coeff:2 }, { note: 14, coeff:2 }] },
          { id: 3, nom: "GNAMIEN", prenom: "Bénédicte", classe: "Licence 2 Maths", notes: [{ note: 11, coeff:3 }, { note: 10, coeff:2 }, { note: 12, coeff:2 }] },
          { id: 4, nom: "HOUNKPATIN", prenom: "Cédric", classe: "Doctorat Physique", notes: [{ note: 17, coeff:3 }, { note: 16, coeff:2 }, { note: 15, coeff:2 }] }
        ]
      };

      let typeEtablissement = "college";
      let currentData = JSON.parse(JSON.stringify(collegeData));

      const storedType = localStorage.getItem("typeEtablissement");
      if (storedType === "college" || storedType === "universite") typeEtablissement = storedType;
      else {
        const urlParams = new URLSearchParams(window.location.search);
        const urlType = urlParams.get("type");
        if (urlType === "college" || urlType === "universite") typeEtablissement = urlType;
        localStorage.setItem("typeEtablissement", typeEtablissement);
      }
      if (typeEtablissement === "college") currentData = JSON.parse(JSON.stringify(collegeData));
      else currentData = JSON.parse(JSON.stringify(universityData));

      function getStudentAverage(student) {
        let total = 0, coeffSum = 0;
        student.notes.forEach(n => { total += n.note * n.coeff; coeffSum += n.coeff; });
        return coeffSum ? total / coeffSum : 0;
      }

      function updateHeaderFooter() {
        const isUniv = typeEtablissement === "universite";
        document.getElementById("school-name-header").innerText = currentData.schoolName;
        document.getElementById("school-location").innerText = currentData.schoolLocation;
        document.getElementById("footer-school").innerText = currentData.schoolName;
        document.getElementById("nav-eleves-label").innerText = isUniv ? "Étudiants" : "Élèves";
      }

      function setType(type) {
        typeEtablissement = type;
        localStorage.setItem("typeEtablissement", type);
        if (type === "college") currentData = JSON.parse(JSON.stringify(collegeData));
        else currentData = JSON.parse(JSON.stringify(universityData));
        updateHeaderFooter();
        renderStatsPage();
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

      function showToast(msg, type = "success") {
        const toast = document.getElementById("toast");
        toast.innerText = msg;
        toast.style.backgroundColor = type === "error" ? "#ef4444" : "#10b981";
        toast.classList.add("show");
        setTimeout(() => toast.classList.remove("show"), 3000);
      }

      // ==================== RENDU DE LA PAGE STATISTIQUES AMÉLIORÉE ====================
      function renderStatsPage() {
        const container = document.getElementById("dynamic-content");
        if (!container) return;

        const isUniv = typeEtablissement === "universite";
        const studentLabel = isUniv ? "étudiants" : "élèves";
        const classLabel = isUniv ? "filière" : "classe";
        const classLabelPlural = isUniv ? "filières" : "classes";

        // KPI
        const totalStudents = currentData.students.length;
        let sumGrades = 0, successCount = 0, sumPresence = 0;
        currentData.students.forEach(s => {
          const avg = getStudentAverage(s);
          sumGrades += avg;
          if (avg >= 10) successCount++;
        });
        const globalAverage = totalStudents ? (sumGrades / totalStudents).toFixed(1) : "0.0";
        const globalSuccessRate = totalStudents ? ((successCount / totalStudents) * 100).toFixed(1) : "0";
        const avgPresence = currentData.classes.length ? (currentData.classes.reduce((acc, c) => acc + c.presence, 0) / currentData.classes.length).toFixed(1) : "0";

        // Meilleure et pire classe/filière
        const bestClass = [...currentData.classes].sort((a, b) => b.avgGrade - a.avgGrade)[0];
        const worstClass = [...currentData.classes].sort((a, b) => a.avgGrade - b.avgGrade)[0];

        // Top 5 meilleurs élèves
        const bestStudents = [...currentData.students]
          .map(s => ({ ...s, moyenne: getStudentAverage(s) }))
          .sort((a, b) => b.moyenne - a.moyenne)
          .slice(0, 5);

        // Top 5 en difficulté (moyenne < 10)
        const strugglingStudents = [...currentData.students]
          .map(s => ({ ...s, moyenne: getStudentAverage(s) }))
          .filter(s => s.moyenne < 10)
          .sort((a, b) => a.moyenne - b.moyenne)
          .slice(0, 5);

        // Évolution mensuelle (simulation)
        const monthlyLabels = ["Sep", "Oct", "Nov", "Déc", "Jan", "Fév", "Mar", "Avr", "Mai", "Juin"];
        const collegeMonthly = [18, 4, 2, 1, 6, 3, 5, 2, 4, 5];
        const universityMonthly = [25, 8, 4, 2, 10, 5, 8, 3, 6, 7];
        const monthlyInscriptions = isUniv ? universityMonthly : collegeMonthly;

        // Données pour l'évolution des moyennes (trimestres)
        const quarterlyLabels = ["T1", "T2", "T3"];
        const collegeQuarterly = [12.1, 12.8, 13.2];
        const universityQuarterly = [12.5, 13.1, 13.8];
        const quarterlyAverages = isUniv ? universityQuarterly : collegeQuarterly;

        // Répartition des mentions (admis / redoublant)
        const admitted = currentData.students.filter(s => getStudentAverage(s) >= 10).length;
        const notAdmitted = totalStudents - admitted;

        container.innerHTML = `
          <div class="mb-6">
            <h1 class="font-heading text-2xl font-bold text-slate-900 sm:text-3xl">Statistiques avancées</h1>
            <p class="mt-1 text-sm text-slate-600">Analyse des performances académiques – ${isUniv ? "Université" : "Collège"}</p>
          </div>

          <!-- KPI Cards (améliorées) -->
          <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5 mb-8">
            <div class="kpi-card rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm" style="border-left-color: #7300e9;">
              <p class="text-xs font-semibold uppercase text-slate-500">Moyenne générale</p>
              <p class="text-3xl font-bold text-slate-900">${globalAverage}<span class="text-lg font-normal text-slate-500"> /20</span></p>
            </div>
            <div class="kpi-card rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm" style="border-left-color: #22c55e;">
              <p class="text-xs font-semibold uppercase text-slate-500">Taux de réussite</p>
              <p class="text-3xl font-bold text-slate-900">${globalSuccessRate}<span class="text-lg font-normal text-slate-500">%</span></p>
            </div>
            <div class="kpi-card rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm" style="border-left-color: #f59e0b;">
              <p class="text-xs font-semibold uppercase text-slate-500">Total ${studentLabel}</p>
              <p class="text-3xl font-bold text-slate-900">${totalStudents}</p>
            </div>
            <div class="kpi-card rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm" style="border-left-color: #10b981;">
              <p class="text-xs font-semibold uppercase text-slate-500">Meilleure ${classLabel}</p>
              <p class="text-xl font-bold text-slate-900">${bestClass?.name || '-'}</p>
              <p class="text-xs text-slate-500">Moyenne ${bestClass?.avgGrade || 0}/20</p>
            </div>
            <div class="kpi-card rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm" style="border-left-color: #ef4444;">
              <p class="text-xs font-semibold uppercase text-slate-500">${isUniv ? "Filière" : "Classe"} à améliorer</p>
              <p class="text-xl font-bold text-slate-900">${worstClass?.name || '-'}</p>
              <p class="text-xs text-slate-500">Moyenne ${worstClass?.avgGrade || 0}/20</p>
            </div>
          </div>

          <!-- Graphiques avancés -->
          <div class="grid gap-6 lg:grid-cols-2 mb-8">
            <!-- Répartition par classe/filière -->
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-md">
              <h3 class="font-heading text-base font-semibold text-slate-900">Répartition par ${classLabel}</h3>
              <p class="mt-1 text-xs text-slate-500">Effectifs par ${classLabel}</p>
              <div class="mt-4 h-64"><canvas id="chart-class-distribution"></canvas></div>
            </div>

            <!-- Évolution des inscriptions -->
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-md">
              <h3 class="font-heading text-base font-semibold text-slate-900">Évolution des inscriptions</h3>
              <p class="mt-1 text-xs text-slate-500">Nouveaux ${studentLabel} par mois</p>
              <div class="mt-4 h-64"><canvas id="chart-monthly-enrollment"></canvas></div>
            </div>

            <!-- Évolution des moyennes trimestrielles -->
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-md">
              <h3 class="font-heading text-base font-semibold text-slate-900">Évolution des moyennes</h3>
              <p class="mt-1 text-xs text-slate-500">Moyennes trimestrielles (tous ${studentLabel})</p>
              <div class="mt-4 h-64"><canvas id="chart-quarterly-averages"></canvas></div>
            </div>

            <!-- Répartition des mentions -->
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-md">
              <h3 class="font-heading text-base font-semibold text-slate-900">Répartition des mentions</h3>
              <p class="mt-1 text-xs text-slate-500">Admis (≥10) vs Redoublants (<10)</p>
              <div class="mt-4 h-64"><canvas id="chart-mentions"></canvas></div>
            </div>
          </div>

          <!-- Top 5 meilleurs et en difficulté -->
          <div class="grid gap-6 lg:grid-cols-2 mb-8">
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-md">
              <h3 class="font-heading text-base font-semibold text-slate-900">🏆 Top 5 des meilleurs ${studentLabel}</h3>
              <p class="mt-1 text-xs text-slate-500">Moyenne générale la plus élevée</p>
              <div class="mt-4 h-64"><canvas id="chart-top-students"></canvas></div>
            </div>
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-md">
              <h3 class="font-heading text-base font-semibold text-slate-900">⚠️ Top 5 en difficulté</h3>
              <p class="mt-1 text-xs text-slate-500">Moyenne inférieure à 10/20</p>
              <div class="mt-4 h-64"><canvas id="chart-struggling-students"></canvas></div>
            </div>
          </div>

          <!-- Tableau des performances par classe/filière -->
          <div class="rounded-2xl border border-slate-200/80 bg-white shadow-md overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100">
              <h3 class="font-heading text-base font-semibold text-slate-900">Performances par ${classLabel}</h3>
            </div>
            <div class="overflow-x-auto">
              <table class="min-w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                  <tr>
                    <th class="px-5 py-3">${isUniv ? "Filière / Niveau" : "Classe"}</th>
                    <th class="px-3 py-3">Nb ${studentLabel}</th>
                    <th class="px-3 py-3">Moyenne /20</th>
                    <th class="px-3 py-3">Taux réussite (%)</th>
                    <th class="px-3 py-3">Présence (%)</th>
                  </tr>
                </thead>
                <tbody id="class-performance-body" class="divide-y divide-slate-100"></tbody>
              </table>
            </div>
          </div>
        `;

        // Remplir le tableau
        const tbody = document.getElementById("class-performance-body");
        if (tbody) {
          tbody.innerHTML = currentData.classes.map(c => `
            <tr class="hover:bg-slate-50/80">
              <td class="px-5 py-4 font-medium text-slate-900">${c.name}</td>
              <td class="px-3 py-4">${c.students}</td>
              <td class="px-3 py-4">${c.avgGrade} /20</td>
              <td class="px-3 py-4">${c.successRate}%</td>
              <td class="px-3 py-4">${c.presence}%</td>
            </tr>
          `).join("");
        }

        // Initialisation des graphiques
        initAllCharts(classLabel, studentLabel, monthlyLabels, monthlyInscriptions, quarterlyAverages, admitted, notAdmitted, bestStudents, strugglingStudents);
      }

      function initAllCharts(classLabel, studentLabel, monthlyLabels, monthlyInscriptions, quarterlyAverages, admitted, notAdmitted, bestStudents, strugglingStudents) {
        // 1. Répartition par classe/filière
        const classNames = currentData.classes.map(c => c.name);
        const classStudents = currentData.classes.map(c => c.students);
        const ctxDist = document.getElementById("chart-class-distribution")?.getContext("2d");
        if (ctxDist) {
          new Chart(ctxDist, {
            type: "bar",
            data: { labels: classNames, datasets: [{ label: `Nombre d'${studentLabel}`, data: classStudents, backgroundColor: "#7300e9", borderRadius: 8, maxBarThickness: 50 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: "top" } }, scales: { y: { beginAtZero: true } } }
          });
        }

        // 2. Évolution mensuelle
        const ctxMonthly = document.getElementById("chart-monthly-enrollment")?.getContext("2d");
        if (ctxMonthly) {
          new Chart(ctxMonthly, {
            type: "line",
            data: { labels: monthlyLabels, datasets: [{ label: `Nouveaux ${studentLabel}`, data: monthlyInscriptions, borderColor: "#7300e9", backgroundColor: "rgba(115,0,233,0.05)", fill: true, tension: 0.3, pointBackgroundColor: "#7300e9", pointBorderColor: "#fff", pointRadius: 4 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: "top" } }, scales: { y: { beginAtZero: true } } }
          });
        }

        // 3. Évolution des moyennes trimestrielles
        const ctxQuarterly = document.getElementById("chart-quarterly-averages")?.getContext("2d");
        if (ctxQuarterly) {
          new Chart(ctxQuarterly, {
            type: "line",
            data: { labels: ["T1", "T2", "T3"], datasets: [{ label: "Moyenne générale /20", data: quarterlyAverages, borderColor: "#f59e0b", backgroundColor: "rgba(245,158,11,0.05)", fill: true, tension: 0.3, pointBackgroundColor: "#f59e0b", pointBorderColor: "#fff", pointRadius: 4 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: "top" } }, scales: { y: { beginAtZero: true, max: 20 } } }
          });
        }

        // 4. Répartition des mentions
        const ctxMentions = document.getElementById("chart-mentions")?.getContext("2d");
        if (ctxMentions) {
          new Chart(ctxMentions, {
            type: "doughnut",
            data: { labels: ["Admis (≥10)", "Redoublants (<10)"], datasets: [{ data: [admitted, notAdmitted], backgroundColor: ["#10b981", "#ef4444"], borderWidth: 0 }] },
            options: { responsive: true, maintainAspectRatio: false, cutout: "60%", plugins: { legend: { position: "bottom" } } }
          });
        }

        // 5. Top 5 meilleurs (barres horizontales)
        const bestNames = bestStudents.map(s => `${s.nom} ${s.prenom}`.substring(0, 20));
        const bestScores = bestStudents.map(s => s.moyenne.toFixed(1));
        const ctxTop = document.getElementById("chart-top-students")?.getContext("2d");
        if (ctxTop) {
          new Chart(ctxTop, {
            type: "bar",
            data: { labels: bestNames, datasets: [{ label: "Moyenne /20", data: bestScores, backgroundColor: "#10b981", borderRadius: 6, maxBarThickness: 40 }] },
            options: { indexAxis: "y", responsive: true, maintainAspectRatio: false, plugins: { legend: { position: "top" } }, scales: { x: { beginAtZero: true, max: 20 } } }
          });
        }

        // 6. Top 5 en difficulté
        const strugglingNames = strugglingStudents.map(s => `${s.nom} ${s.prenom}`.substring(0, 20));
        const strugglingScores = strugglingStudents.map(s => s.moyenne.toFixed(1));
        const ctxStruggling = document.getElementById("chart-struggling-students")?.getContext("2d");
        if (ctxStruggling) {
          new Chart(ctxStruggling, {
            type: "bar",
            data: { labels: strugglingNames, datasets: [{ label: "Moyenne /20", data: strugglingScores, backgroundColor: "#ef4444", borderRadius: 6, maxBarThickness: 40 }] },
            options: { indexAxis: "y", responsive: true, maintainAspectRatio: false, plugins: { legend: { position: "top" } }, scales: { x: { beginAtZero: true, max: 20 } } }
          });
        }
      }

      // ==================== INITIALISATION ====================
      function init() {
        updateHeaderFooter();
        renderStatsPage();
        updateSwitchButtons();

        document.getElementById("switch-college")?.addEventListener("click", () => setType("college"));
        document.getElementById("switch-universite")?.addEventListener("click", () => setType("universite"));

        // Menu mobile
        const sidebar = document.getElementById("sidebar");
        const overlay = document.getElementById("sidebar-overlay");
        const btnMenu = document.getElementById("btn-menu");
        function openMenu() { sidebar.classList.remove("-translate-x-full"); overlay.classList.add("is-open"); document.body.style.overflow = "hidden"; }
        function closeMenu() { sidebar.classList.add("-translate-x-full"); overlay.classList.remove("is-open"); document.body.style.overflow = ""; }
        btnMenu?.addEventListener("click", openMenu);
        overlay?.addEventListener("click", closeMenu);
        window.addEventListener("resize", () => { if (window.innerWidth >= 1024) closeMenu(); });

        document.querySelectorAll(".sidebar-toggle").forEach(btn => {
          const id = btn.getAttribute("data-submenu");
          const panel = document.getElementById(id);
          const chev = btn.querySelector(".chevron");
          if (panel) btn.addEventListener("click", () => { const open = panel.classList.toggle("open"); if (chev) chev.style.transform = open ? "rotate(180deg)" : ""; });
        });

        document.getElementById("last-update").innerText = new Date().toLocaleTimeString("fr-FR");
      }

      init();
    })();
  </script>
</body>
</html>
