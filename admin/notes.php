<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notes & Moyennes | EduManager</title>
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
    .action-button { transition: all 0.2s ease; }
    .action-button:hover { transform: scale(1.05); }
    .modal-overlay { pointer-events: none; opacity: 0; transition: opacity 0.2s ease; position: fixed; inset: 0; z-index: 9999; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; }
    .modal-overlay.is-open { pointer-events: auto; opacity: 1; }
    .modal-content { transform: scale(0.95); transition: transform 0.2s ease; max-width: 90%; width: 28rem; background: white; border-radius: 1rem; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); }
    .modal-overlay.is-open .modal-content { transform: scale(1); }
    .toast { position: fixed; bottom: 20px; right: 20px; background: #1e293b; color: white; padding: 12px 20px; border-radius: 12px; font-size: 0.875rem; z-index: 10000; opacity: 0; transition: opacity 0.3s; pointer-events: none; }
    .toast.show { opacity: 1; }
    .note-badge { display: inline-flex; align-items: center; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.7rem; font-weight: 500; }
    .note-good { background-color: #dcfce7; color: #166534; }
    .note-average { background-color: #fef9c3; color: #854d0e; }
    .note-low { background-color: #fee2e2; color: #991b1b; }
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 text-slate-800 antialiased">
  <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden"></div>

  <!-- Sidebar (identique à la maquette) -->
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
      <a href="notes.html" class="sidebar-link active flex items-center gap-3 rounded-xl px-3 py-2.5">Notes & Moyennes</a>
      <a href="paiements.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">Scolarité & Paiements</a>
      <a href="agents.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">Agents</a>
      <a href="bulletins.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">Bulletins & Documents</a>
      <a href="statistiques.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">Statistiques</a>
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
    // ==================== DONNÉES STATIQUES (collège / université) ====================
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
      renderNotesPage();
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

    const modal = document.getElementById("modal-generic");
    const modalTitle = document.getElementById("modal-title");
    const modalBody = document.getElementById("modal-body");
    function openModal(title, bodyHtml) { modalTitle.innerText = title; modalBody.innerHTML = bodyHtml; modal.classList.add("is-open"); document.body.style.overflow = "hidden"; }
    function closeModal() { modal.classList.remove("is-open"); document.body.style.overflow = ""; }
    document.getElementById("close-modal")?.addEventListener("click", closeModal);
    document.getElementById("modal-close-btn")?.addEventListener("click", closeModal);
    modal?.addEventListener("click", (e) => { if (e.target === modal) closeModal(); });

    let currentStudent = null;
    let chart = null;

    function getNoteBadge(note) {
      if (note >= 14) return '<span class="note-badge note-good">Excellent</span>';
      if (note >= 10) return '<span class="note-badge note-average">Moyen</span>';
      return '<span class="note-badge note-low">Faible</span>';
    }

    function renderNotesTable(student) {
      const tbody = document.getElementById("notes-table-body");
      if (!tbody) return;
      if (!student || !student.notes.length) {
        tbody.innerHTML = `<tr><td colspan="4" class="px-5 py-8 text-center text-slate-500">Aucune note enregistrée</td></tr>`;
        return;
      }
      tbody.innerHTML = student.notes.map(n => `
        <tr class="hover:bg-slate-50/80">
          <td class="px-5 py-4 font-medium text-slate-900 sm:px-6">${escapeHtml(n.matiere)}</td>
          <td class="px-3 py-4">${n.coeff}</td>
          <td class="px-3 py-4">
            <span class="font-bold">${n.note.toFixed(1)}</span> /20
            ${getNoteBadge(n.note)}
          </td>
          <td class="px-3 py-4 text-slate-600">${(n.note * n.coeff).toFixed(1)}</td>
        </tr>
      `).join("");
    }

    function updateKPIs(student) {
      if (!student) return;
      const moyenne = getStudentAverage(student);
      document.getElementById("kpi-moyenne").innerText = moyenne.toFixed(1);
      let best = { matiere: "", note: -1 };
      let worst = { matiere: "", note: 21 };
      student.notes.forEach(n => {
        if (n.note > best.note) { best = { matiere: n.matiere, note: n.note }; }
        if (n.note < worst.note) { worst = { matiere: n.matiere, note: n.note }; }
      });
      document.getElementById("kpi-best").innerHTML = best.matiere ? `${escapeHtml(best.matiere)} <span class="text-xs font-normal">(${best.note.toFixed(1)}/20)</span>` : "-";
      document.getElementById("kpi-worst").innerHTML = worst.matiere ? `${escapeHtml(worst.matiere)} <span class="text-xs font-normal">(${worst.note.toFixed(1)}/20)</span>` : "-";
      // Mettre à jour le graphique
      if (chart) chart.destroy();
      const ctx = document.getElementById("student-chart")?.getContext("2d");
      if (ctx && student.notes.length) {
        chart = new Chart(ctx, {
          type: "bar",
          data: {
            labels: student.notes.map(n => n.matiere),
            datasets: [{
              label: "Note /20",
              data: student.notes.map(n => n.note),
              backgroundColor: "#7300e9",
              borderRadius: 8
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: "top" } },
            scales: { y: { beginAtZero: true, max: 20, grid: { color: "rgba(148,163,184,0.2)" } } }
          }
        });
      } else if (ctx) {
        chart = new Chart(ctx, { type: "bar", data: { labels: [], datasets: [] }, options: { responsive: true } });
      }
    }

    function openAddNoteModal(student) {
      const isUniv = typeEtablissement === "universite";
      const bodyHtml = `
        <form id="add-note-form" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-slate-700">Matière / UE</label>
            <input type="text" id="note-matiere" class="w-full rounded-xl border border-slate-200 px-3 py-2" required>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700">Coefficient</label>
            <input type="number" step="0.5" id="note-coeff" class="w-full rounded-xl border border-slate-200 px-3 py-2" required min="0.5">
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700">Note /20</label>
            <input type="number" step="0.1" id="note-value" class="w-full rounded-xl border border-slate-200 px-3 py-2" required min="0" max="20">
          </div>
          <div class="flex gap-3 pt-2">
            <button type="submit" class="flex-1 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white">Enregistrer</button>
            <button type="button" id="form-cancel" class="flex-1 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700">Annuler</button>
          </div>
        </form>
      `;
      openModal(isUniv ? "Ajouter une note (UE)" : "Ajouter une note", bodyHtml);
      const form = document.getElementById("add-note-form");
      const cancelBtn = document.getElementById("form-cancel");
      if (cancelBtn) cancelBtn.addEventListener("click", closeModal);
      if (form) {
        form.addEventListener("submit", (e) => {
          e.preventDefault();
          const matiere = document.getElementById("note-matiere").value.trim();
          const coeff = parseFloat(document.getElementById("note-coeff").value);
          const note = parseFloat(document.getElementById("note-value").value);
          if (!matiere || isNaN(coeff) || coeff <= 0 || isNaN(note) || note < 0 || note > 20) {
            showToast("Veuillez remplir correctement tous les champs", "error");
            return;
          }
          const existing = student.notes.find(n => n.matiere === matiere);
          if (existing) {
            existing.note = note;
            existing.coeff = coeff;
          } else {
            student.notes.push({ matiere, coeff, note });
          }
          renderNotesTable(student);
          updateKPIs(student);
          closeModal();
          showToast("Note ajoutée/modifiée avec succès");
        });
      }
    }

    // Fonction pour filtrer les options du select étudiant
    function filterStudentSelect(filterText) {
      const select = document.getElementById("student-select");
      if (!select) return;
      
      const students = currentData.students;
      const filter = filterText.trim().toLowerCase();
      
      // Sauvegarde de la valeur actuellement sélectionnée (si elle existe)
      const currentValue = select.value;
      
      // Reconstruire les options
      let optionsHtml = `<option value="">-- Choisir --</option>`;
      const filteredStudents = students.filter(s => 
        s.nom.toLowerCase().includes(filter) || 
        s.prenom.toLowerCase().includes(filter) ||
        `${s.prenom} ${s.nom}`.toLowerCase().includes(filter)
      );
      
      if (filteredStudents.length === 0) {
        optionsHtml += `<option value="" disabled>Aucun résultat</option>`;
      } else {
        filteredStudents.forEach(s => {
          optionsHtml += `<option value="${s.id}">${escapeHtml(s.nom)} ${escapeHtml(s.prenom)} (${escapeHtml(s.classe)})</option>`;
        });
      }
      
      select.innerHTML = optionsHtml;
      
      // Restaurer la sélection si l'étudiant est toujours présent
      if (currentValue) {
        const stillExists = Array.from(select.options).some(opt => opt.value === currentValue);
        if (stillExists) {
          select.value = currentValue;
        } else {
          // Si l'étudiant n'est plus dans la liste, on ne sélectionne rien
          select.value = "";
          // Déclencher le changement pour réinitialiser l'affichage
          select.dispatchEvent(new Event('change'));
        }
      }
    }

    function renderNotesPage() {
      const container = document.getElementById("dynamic-content");
      if (!container) return;

      const isUniv = typeEtablissement === "universite";
      const studentLabel = isUniv ? "étudiant" : "élève";
      
      // Génération initiale de toutes les options
      const allStudentsOptions = currentData.students.map(s => 
        `<option value="${s.id}">${escapeHtml(s.nom)} ${escapeHtml(s.prenom)} (${escapeHtml(s.classe)})</option>`
      ).join("");

      container.innerHTML = `
        <div class="mb-6">
          <h1 class="font-heading text-2xl font-bold text-slate-900 sm:text-3xl">Notes & Moyennes</h1>
          <p class="mt-1 text-sm text-slate-600">Gestion des notes par ${studentLabel}</p>
        </div>

        <!-- Section de sélection avec recherche -->
        <div class="flex flex-wrap items-end gap-4 mb-6">
          <div class="flex-1 min-w-[250px]">
            <label class="block text-sm font-medium text-slate-700 mb-1">Rechercher un ${studentLabel}</label>
            <div class="relative">
              <input type="text" id="student-search" placeholder="Nom, prénom..." 
                     class="w-full rounded-xl border border-slate-200 py-2 pl-9 pr-3 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary" />
              <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M21 21l-4.35-4.35M17 11a6 6 0 1 1-12 0 6 6 0 0 1 12 0z"/>
              </svg>
            </div>
          </div>
          <div class="flex-1 min-w-[250px]">
            <label class="block text-sm font-medium text-slate-700 mb-1">${studentLabel} sélectionné</label>
            <select id="student-select" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
              <option value="">-- Choisir --</option>
              ${allStudentsOptions}
            </select>
          </div>
          <div>
            <button id="btn-add-note" class="action-button inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primaryDark disabled:opacity-50 disabled:cursor-not-allowed" disabled>
              <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 4.5v15m7.5-7.5h-15"/></svg>
              Ajouter une note
            </button>
          </div>
        </div>

        <!-- KPI Cards -->
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 mb-8">
          <div class="kpi-card rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm" style="border-left-color: #7300e9;">
            <p class="text-xs font-semibold uppercase text-slate-500">Moyenne générale</p>
            <p id="kpi-moyenne" class="text-3xl font-bold text-slate-900">--<span class="text-lg font-normal text-slate-500"> /20</span></p>
          </div>
          <div class="kpi-card rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm" style="border-left-color: #22c55e;">
            <p class="text-xs font-semibold uppercase text-slate-500">Meilleure matière</p>
            <p id="kpi-best" class="text-xl font-bold text-slate-900">-</p>
          </div>
          <div class="kpi-card rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm" style="border-left-color: #ef4444;">
            <p class="text-xs font-semibold uppercase text-slate-500">Matière à améliorer</p>
            <p id="kpi-worst" class="text-xl font-bold text-slate-900">-</p>
          </div>
        </div>

        <!-- Graphique d'évolution -->
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-md mb-8">
          <h3 class="font-heading text-base font-semibold text-slate-900">Performances par matière</h3>
          <p class="mt-1 text-xs text-slate-500">Notes /20 (${isUniv ? "unités d'enseignement" : "matières"})</p>
          <div class="mt-4 h-64">
            <canvas id="student-chart"></canvas>
          </div>
        </div>

        <!-- Tableau des notes -->
        <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-md">
          <div class="px-5 py-4 border-b border-slate-100">
            <h3 class="font-heading text-base font-semibold text-slate-900">Détail des notes</h3>
          </div>
          <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
              <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr>
                  <th class="px-5 py-3 sm:px-6">Matière / UE</th>
                  <th class="px-3 py-3">Coefficient</th>
                  <th class="px-3 py-3">Note /20</th>
                  <th class="px-3 py-3">Pondérée</th>
                </tr>
              </thead>
              <tbody id="notes-table-body" class="divide-y divide-slate-100"></tbody>
            </table>
          </div>
        </div>
      `;

      const select = document.getElementById("student-select");
      const addBtn = document.getElementById("btn-add-note");
      const searchInput = document.getElementById("student-search");

      // Gestion du filtre de recherche d'étudiants
      if (searchInput) {
        searchInput.addEventListener("input", (e) => {
          filterStudentSelect(e.target.value);
        });
      }

      if (select) {
        select.addEventListener("change", (e) => {
          const id = parseInt(e.target.value);
          const student = currentData.students.find(s => s.id === id);
          currentStudent = student;
          
          if (student) {
            renderNotesTable(student);
            updateKPIs(student);
            addBtn.disabled = false;
          } else {
            document.getElementById("notes-table-body").innerHTML = `<tr><td colspan="4" class="px-5 py-8 text-center text-slate-500">Sélectionnez un ${studentLabel}</td></tr>`;
            document.getElementById("kpi-moyenne").innerText = "--";
            document.getElementById("kpi-best").innerText = "-";
            document.getElementById("kpi-worst").innerText = "-";
            if (chart) chart.destroy();
            addBtn.disabled = true;
          }
        });
      }
      
      if (addBtn) {
        addBtn.addEventListener("click", () => { 
          if (currentStudent) openAddNoteModal(currentStudent); 
        });
      }
    }

    function escapeHtml(str) {
      if (!str) return "";
      return str.replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
      });
    }

    function init() {
      updateHeaderFooter();
      renderNotesPage();
      updateSwitchButtons();

      document.getElementById("switch-college")?.addEventListener("click", () => setType("college"));
      document.getElementById("switch-universite")?.addEventListener("click", () => setType("universite"));

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
  </script>
</body>
</html>
