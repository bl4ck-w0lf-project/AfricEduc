<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Classes & Groupes | EduManager</title>
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
    /* Confirmation modal */
    .confirm-modal .modal-content { max-width: 24rem; }
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
          <a href="classes.html" class="sidebar-link active mt-1 block rounded-lg py-2 pl-10 pr-3">Classes / Groupes</a>
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
      <div id="dynamic-content">
        <!-- Contenu injecté dynamiquement -->
      </div>
      <footer class="mt-12 pb-8 text-center text-xs text-slate-400">
        EduManager — <span id="footer-school">Collège Saint-Michel</span> · Dernière mise à jour : <span id="last-update"></span>
      </footer>
    </main>
  </div>

  <!-- Modale générique (ajout / modification / visualisation) -->
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

  <!-- Modale de confirmation (suppression) -->
  <div id="confirm-modal" class="modal-overlay">
    <div class="modal-content bg-white rounded-2xl shadow-2xl p-6">
      <div class="flex justify-between items-center mb-4">
        <h3 class="font-heading text-xl font-bold text-slate-900">Confirmation</h3>
        <button id="close-confirm-modal" class="text-slate-400 hover:text-slate-600">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>
      <div id="confirm-body" class="text-slate-700">Êtes-vous sûr de vouloir supprimer cet élément ?</div>
      <div class="mt-6 flex gap-3 justify-end">
        <button id="confirm-cancel" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700">Annuler</button>
        <button id="confirm-ok" class="rounded-xl bg-red-600 px-4 py-2 text-sm font-semibold text-white">Supprimer</button>
      </div>
    </div>
  </div>

  <div id="toast" class="toast"></div>

  <script>
    // ==================== DONNÉES DE BASE (identique à index) ====================
    const collegeData = {
      schoolName: "Collège Saint-Michel",
      schoolLocation: "Cotonou, Bénin",
      classes: [
        { id: 1, name: "6ème A", students: 14, avgGrade: 12.4, successRate: 86, presence: 94, payments: "12/14" },
        { id: 2, name: "5ème B", students: 12, avgGrade: 11.8, successRate: 79, presence: 87, payments: "11/12" },
        { id: 3, name: "4ème A", students: 13, avgGrade: 12.1, successRate: 81, presence: 91, payments: "12/13" },
        { id: 4, name: "Tle D", students: 11, avgGrade: 13.2, successRate: 91, presence: 96, payments: "9/11" }
      ],
      students: []
    };
    const universityData = {
      schoolName: "Université d'Abomey-Calavi",
      schoolLocation: "Abomey-Calavi, Bénin",
      classes: [
        { id: 1, name: "Licence 1 Informatique", students: 45, avgGrade: 12.8, successRate: 74, presence: 88, payments: "38/45" },
        { id: 2, name: "Licence 2 Mathématiques", students: 38, avgGrade: 11.9, successRate: 68, presence: 85, payments: "30/38" },
        { id: 3, name: "Master 1 Droit", students: 30, avgGrade: 14.2, successRate: 83, presence: 92, payments: "27/30" },
        { id: 4, name: "Doctorat Physique", students: 12, avgGrade: 15.5, successRate: 92, presence: 95, payments: "11/12" }
      ],
      students: []
    };

    let typeEtablissement = "college";
    let currentData = JSON.parse(JSON.stringify(collegeData));
    let nextClassId = currentData.classes.length + 1;

    // Charger depuis localStorage
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
    nextClassId = currentData.classes.length + 1;

    // Variables pour la confirmation
    let pendingDeleteId = null;

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
      nextClassId = currentData.classes.length + 1;
      updateHeaderFooter();
      renderClassesPage();
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

    function escapeHtml(str) {
      if (!str) return "";
      return str.replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
      });
    }

    // Gestion centralisée des modales
    const modal = document.getElementById("modal-generic");
    const confirmModal = document.getElementById("confirm-modal");
    const closeModalBtn = document.getElementById("close-modal");
    const modalCloseBtn = document.getElementById("modal-close-btn");
    const closeConfirmModalBtn = document.getElementById("close-confirm-modal");
    const confirmCancelBtn = document.getElementById("confirm-cancel");
    const confirmOkBtn = document.getElementById("confirm-ok");

    function openModal(title, bodyHtml) {
      document.getElementById("modal-title").innerText = title;
      document.getElementById("modal-body").innerHTML = bodyHtml;
      modal.classList.add("is-open");
      document.body.style.overflow = "hidden";
    }

    function closeModal() {
      modal.classList.remove("is-open");
      document.body.style.overflow = "";
    }

    function openConfirmModal(message, onConfirm) {
      document.getElementById("confirm-body").innerHTML = message;
      confirmModal.classList.add("is-open");
      document.body.style.overflow = "hidden";
      const confirmHandler = () => {
        onConfirm();
        closeConfirmModal();
        confirmOkBtn.removeEventListener("click", confirmHandler);
      };
      confirmOkBtn.addEventListener("click", confirmHandler, { once: true });
    }

    function closeConfirmModal() {
      confirmModal.classList.remove("is-open");
      document.body.style.overflow = "";
    }

    closeModalBtn.addEventListener("click", closeModal);
    modalCloseBtn.addEventListener("click", closeModal);
    modal.addEventListener("click", (e) => { if (e.target === modal) closeModal(); });
    closeConfirmModalBtn.addEventListener("click", closeConfirmModal);
    confirmCancelBtn.addEventListener("click", closeConfirmModal);
    confirmModal.addEventListener("click", (e) => { if (e.target === confirmModal) closeConfirmModal(); });

    // Calcul de la moyenne globale sur toutes les classes
    function getGlobalAverage() {
      if (currentData.classes.length === 0) return 0;
      const sum = currentData.classes.reduce((acc, c) => acc + c.avgGrade, 0);
      return (sum / currentData.classes.length).toFixed(1);
    }

    // Modale de visualisation (détails)
    function openViewModal(classItem) {
      const isUniv = typeEtablissement === "universite";
      const bodyHtml = `
        <div class="space-y-4">
          <div class="border-b border-slate-100 pb-2">
            <p class="text-xs font-semibold uppercase text-slate-500">${isUniv ? "Filière / Département" : "Classe"}</p>
            <p class="text-slate-800 font-medium">${escapeHtml(classItem.name)}</p>
          </div>
          <div class="border-b border-slate-100 pb-2">
            <p class="text-xs font-semibold uppercase text-slate-500">Nb ${isUniv ? "étudiants" : "élèves"}</p>
            <p class="text-slate-800">${classItem.students}</p>
          </div>
          <div class="border-b border-slate-100 pb-2">
            <p class="text-xs font-semibold uppercase text-slate-500">Moyenne générale</p>
            <p class="text-slate-800">${classItem.avgGrade} /20</p>
          </div>
          <div class="border-b border-slate-100 pb-2">
            <p class="text-xs font-semibold uppercase text-slate-500">Taux de réussite</p>
            <p class="text-slate-800">${classItem.successRate}%</p>
          </div>
          <div class="border-b border-slate-100 pb-2">
            <p class="text-xs font-semibold uppercase text-slate-500">Présence</p>
            <p class="text-slate-800">${classItem.presence}%</p>
          </div>
          <div class="border-b border-slate-100 pb-2">
            <p class="text-xs font-semibold uppercase text-slate-500">Paiements OK</p>
            <p class="text-slate-800">${classItem.payments}</p>
          </div>
        </div>
      `;
      openModal(isUniv ? "Détails de la filière" : "Détails de la classe", bodyHtml);
    }

    // Modale d'ajout / modification
    function openClassModal(editMode = false, classItem = null) {
      const isUniv = typeEtablissement === "universite";
      const title = editMode ? (isUniv ? "Modifier la filière" : "Modifier la classe") : (isUniv ? "Ajouter une filière" : "Ajouter une classe");
      const bodyHtml = `
        <form id="class-form" class="space-y-4">
          <input type="hidden" id="class-id" value="${editMode ? classItem.id : ""}">
          <div>
            <label class="block text-sm font-medium text-slate-700">Nom ${isUniv ? "de la filière" : "de la classe"} *</label>
            <input type="text" id="class-name" value="${editMode ? escapeHtml(classItem.name) : ""}" class="w-full rounded-xl border border-slate-200 px-3 py-2" required>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700">Nombre d'${isUniv ? "étudiants" : "élèves"} *</label>
            <input type="number" id="class-students" value="${editMode ? classItem.students : ""}" class="w-full rounded-xl border border-slate-200 px-3 py-2" required min="0">
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700">Moyenne générale (/20) *</label>
            <input type="number" step="0.1" id="class-avg" value="${editMode ? classItem.avgGrade : ""}" class="w-full rounded-xl border border-slate-200 px-3 py-2" required min="0" max="20">
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700">Taux de réussite (%) *</label>
            <input type="number" id="class-success" value="${editMode ? classItem.successRate : ""}" class="w-full rounded-xl border border-slate-200 px-3 py-2" required min="0" max="100">
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700">Taux de présence (%) *</label>
            <input type="number" id="class-presence" value="${editMode ? classItem.presence : ""}" class="w-full rounded-xl border border-slate-200 px-3 py-2" required min="0" max="100">
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700">Paiements OK</label>
            <input type="text" id="class-payments" value="${editMode ? classItem.payments : ""}" class="w-full rounded-xl border border-slate-200 px-3 py-2" placeholder="ex: 12/14">
          </div>
          <div class="flex gap-3 pt-2">
            <button type="submit" class="flex-1 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white">Enregistrer</button>
            <button type="button" id="form-cancel" class="flex-1 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700">Annuler</button>
          </div>
        </form>
      `;

      openModal(title, bodyHtml);

      const form = document.getElementById("class-form");
      const cancelBtn = document.getElementById("form-cancel");
      cancelBtn?.addEventListener("click", closeModal);

      form?.addEventListener("submit", (e) => {
        e.preventDefault();
        const id = document.getElementById("class-id").value;
        const name = document.getElementById("class-name").value.trim();
        const students = parseInt(document.getElementById("class-students").value);
        const avgGrade = parseFloat(document.getElementById("class-avg").value);
        const successRate = parseInt(document.getElementById("class-success").value);
        const presence = parseInt(document.getElementById("class-presence").value);
        const payments = document.getElementById("class-payments").value.trim();

        if (!name || isNaN(students) || isNaN(avgGrade) || isNaN(successRate) || isNaN(presence) || !payments) {
          showToast("Veuillez remplir tous les champs", "error");
          return;
        }

        if (id) {
          const index = currentData.classes.findIndex(c => c.id === parseInt(id));
          if (index !== -1) {
            currentData.classes[index] = { ...currentData.classes[index], name, students, avgGrade, successRate, presence, payments };
          }
        } else {
          const newId = nextClassId++;
          currentData.classes.push({ id: newId, name, students, avgGrade, successRate, presence, payments });
        }
        closeModal();
        renderClassesPage();
        showToast(editMode ? "Modifié avec succès" : "Ajouté avec succès");
      });
    }

    // Rendu de la page Classes / Filières
    function renderClassesPage() {
      const container = document.getElementById("dynamic-content");
      if (!container) return;

      const isUniv = typeEtablissement === "universite";
      const totalClasses = currentData.classes.length;
      const globalAvg = getGlobalAverage();

      container.innerHTML = `
        <div class="mb-6">
          <h1 class="font-heading text-2xl font-bold text-slate-900 sm:text-3xl">${isUniv ? "Filières & Départements" : "Classes"}</h1>
          <p class="mt-1 text-sm text-slate-600">Gestion des ${isUniv ? "filières et départements" : "classes"}</p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 mb-6">
          <div class="kpi-card rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm" style="border-left-color: #7300e9;">
            <p class="text-xs font-semibold uppercase text-slate-500">Total ${isUniv ? "filières" : "classes"}</p>
            <p class="text-2xl font-bold text-slate-900">${totalClasses}</p>
          </div>
          <div class="kpi-card rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm" style="border-left-color: #99fbe3;">
            <p class="text-xs font-semibold uppercase text-slate-500">Moyenne générale</p>
            <p class="text-2xl font-bold text-slate-900">${globalAvg} /20</p>
          </div>
        </div>

        <div class="flex justify-end mb-4">
          <button id="btn-add-class" class="action-button inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primaryDark">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Ajouter ${isUniv ? "une filière" : "une classe"}
          </button>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-md">
          <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
              <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr>
                  <th class="px-5 py-3 sm:px-6">${isUniv ? "Filière / Département" : "Classe"}</th>
                  <th class="px-3 py-3">Nb ${isUniv ? "étudiants" : "élèves"}</th>
                  <th class="px-3 py-3">Moy. générale</th>
                  <th class="px-3 py-3">Taux réussite</th>
                  <th class="px-3 py-3">Présence (%)</th>
                  <th class="px-3 py-3">Paiements OK</th>
                  <th class="px-5 py-3 text-right">Actions</th>
                </tr>
              </thead>
              <tbody id="classes-table-body" class="divide-y divide-slate-100"></tbody>
            </table>
          </div>
        </div>
      `;

      const tbody = document.getElementById("classes-table-body");
      if (tbody) {
        tbody.innerHTML = currentData.classes.map(c => `
          <tr class="hover:bg-slate-50/80">
            <td class="px-5 py-4 font-medium text-slate-900 sm:px-6">${escapeHtml(c.name)}</td>
            <td class="px-3 py-4">${c.students}</td>
            <td class="px-3 py-4">${c.avgGrade} /20</td>
            <td class="px-3 py-4"><span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-800">${c.successRate}% ↑</span></td>
            <td class="px-3 py-4"><span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-800">${c.presence}%</span></td>
            <td class="px-3 py-4">${c.payments}</td>
            <td class="px-5 py-4 text-right">
              <div class="flex justify-end gap-2">
                <button class="view-class-btn text-slate-500 hover:text-primary transition" data-id="${c.id}" title="Voir détails">
                  <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                </button>
                <button class="edit-class-btn text-primary hover:underline" data-id="${c.id}">Modifier</button>
                <button class="delete-class-btn text-red-600 hover:underline" data-id="${c.id}">Supprimer</button>
              </div>
            </td>
          </tr>
        `).join("");
      }

      // Événements
      document.getElementById("btn-add-class")?.addEventListener("click", () => openClassModal());
      document.querySelectorAll(".view-class-btn").forEach(btn => {
        btn.addEventListener("click", (e) => {
          const id = parseInt(btn.getAttribute("data-id"));
          const classItem = currentData.classes.find(c => c.id === id);
          if (classItem) openViewModal(classItem);
        });
      });
      document.querySelectorAll(".edit-class-btn").forEach(btn => {
        btn.addEventListener("click", (e) => {
          const id = parseInt(btn.getAttribute("data-id"));
          const classItem = currentData.classes.find(c => c.id === id);
          if (classItem) openClassModal(true, classItem);
        });
      });
      document.querySelectorAll(".delete-class-btn").forEach(btn => {
        btn.addEventListener("click", (e) => {
          const id = parseInt(btn.getAttribute("data-id"));
          const classItem = currentData.classes.find(c => c.id === id);
          if (classItem) {
            openConfirmModal(`Supprimer définitivement "${escapeHtml(classItem.name)}" ?`, () => {
              currentData.classes = currentData.classes.filter(c => c.id !== id);
              renderClassesPage();
              showToast(`${typeEtablissement === "universite" ? "Filière" : "Classe"} supprimée`);
            });
          }
        });
      });
    }

    // ==================== INITIALISATION ====================
    function init() {
      updateHeaderFooter();
      renderClassesPage();
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
  </script>
</body>
</html>
