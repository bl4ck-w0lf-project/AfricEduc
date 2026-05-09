<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Scolarité & Paiements | EduManager</title>
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
    .kpi-card { transition: all 0.2s ease; position: relative; overflow: hidden; }
    .kpi-card:hover { transform: translateY(-2px); box-shadow: 0 12px 24px -12px rgba(0,0,0,0.15); }
    .kpi-card::after {
      content: "";
      position: absolute;
      bottom: 10px;
      right: 10px;
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background-color: currentColor;
      opacity: 0.25;
    }
    .action-button { transition: all 0.2s ease; }
    .action-button:hover { transform: scale(1.05); }
    .modal-overlay { pointer-events: none; opacity: 0; transition: opacity 0.2s ease; position: fixed; inset: 0; z-index: 9999; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; }
    .modal-overlay.is-open { pointer-events: auto; opacity: 1; }
    .modal-content { transform: scale(0.95); transition: transform 0.2s ease; max-width: 90%; width: 32rem; background: white; border-radius: 1rem; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); max-height: 85vh; overflow-y: auto; }
    .modal-overlay.is-open .modal-content { transform: scale(1); }
    .toast { position: fixed; bottom: 20px; right: 20px; background: #1e293b; color: white; padding: 12px 20px; border-radius: 12px; font-size: 0.875rem; z-index: 10000; opacity: 0; transition: opacity 0.3s; pointer-events: none; }
    .toast.show { opacity: 1; }
    .badge-paid { background-color: #dcfce7; color: #166534; }
    .badge-late { background-color: #fee2e2; color: #991b1b; }
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 text-slate-800 antialiased">
  <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden"></div>

  <!-- Sidebar (identique) -->
  <aside id="sidebar" class="fixed left-0 top-0 z-50 flex h-full w-[260px] -translate-x-full flex-col bg-gradient-to-b from-primary to-primaryDark text-white shadow-2xl transition-transform duration-300 lg:translate-x-0">
    <div class="flex h-16 items-center gap-3 border-b border-white/20 px-4">
      <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/20 shadow-lg">
        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 6.75C4 5.78 4.78 5 5.75 5h4.5c.46 0 .9.18 1.22.51l.56.56c.33.33.77.51 1.24.51h5.98c.97 0 1.75.78 1.75 1.75v8.92c0 .97-.78 1.75-1.75 1.75H5.75A1.75 1.75 0 0 1 4 17.25V6.75Z"/><path d="M8 11.5h8M8 14.5h5"/></svg>
      </span>
      <span class="font-heading text-xl font-bold tracking-tight">EduManager</span>
    </div>
    <nav class="flex-1 overflow-y-auto px-3 py-6 text-sm">
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 mb-1">
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
      <a href="#" class="sidebar-link active flex items-center gap-3 rounded-xl px-3 py-2.5">Scolarité & Paiements</a>
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
      <div id="dynamic-content"></div>
      <footer class="mt-12 pb-8 text-center text-xs text-slate-400">
        EduManager — <span id="footer-school">Collège Saint-Michel</span> · Dernière mise à jour : <span id="last-update"></span>
      </footer>
    </main>
  </div>

  <!-- Modale générique -->
  <div id="modal-generic" class="modal-overlay"><div class="modal-content bg-white rounded-2xl shadow-2xl p-6"><div class="flex justify-between items-center mb-4"><h3 class="font-heading text-xl font-bold text-slate-900" id="modal-title">Titre</h3><button id="close-modal" class="text-slate-400 hover:text-slate-600"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg></button></div><div id="modal-body" class="text-slate-700"></div><div class="mt-6 flex justify-end"><button id="modal-close-btn" class="rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white">Fermer</button></div></div></div>

  <div id="toast" class="toast"></div>

  <script>
    (function() {
      // ==================== DONNÉES ENRICHIES ====================
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
          { id: 1, nom: "KOUADIO", prenom: "Marie", classe: "3ème", matricule: "CSM-001", fraisTotal: 250000 },
          { id: 2, nom: "TRAORÉ", prenom: "Ibrahim", classe: "Seconde", matricule: "LB-045", fraisTotal: 280000 },
          { id: 3, nom: "DIALLO", prenom: "Aminata", classe: "Terminale", matricule: "UPA-234", fraisTotal: 300000 },
          { id: 4, nom: "N'GUESSAN", prenom: "Koffi", classe: "4ème", matricule: "CST-089", fraisTotal: 220000 },
          { id: 5, nom: "HOUNDONOU", prenom: "Jules", classe: "5ème", matricule: "ELS-067", fraisTotal: 200000 }
        ],
        paiements: [
          { id: 101, studentId: 1, montant: 85000, date: "2026-02-10", statut: "payé", reference: "PAY-001", echeance: "2026-02-15" },
          { id: 102, studentId: 2, montant: 120000, date: "2026-01-20", statut: "payé", reference: "PAY-002", echeance: "2026-02-01" },
          { id: 103, studentId: 3, montant: 75000, date: "", statut: "retard", reference: "", echeance: "2026-02-28" },
          { id: 104, studentId: 4, montant: 95000, date: "2026-02-05", statut: "payé", reference: "PAY-004", echeance: "2026-02-10" },
          { id: 105, studentId: 5, montant: 60000, date: "", statut: "retard", reference: "", echeance: "2026-02-20" },
          { id: 106, studentId: 1, montant: 80000, date: "2025-12-12", statut: "payé", reference: "PAY-006", echeance: "2025-12-20" },
          { id: 107, studentId: 3, montant: 100000, date: "2025-11-05", statut: "payé", reference: "PAY-007", echeance: "2025-11-15" },
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
          { id: 1, nom: "KOUASSI", prenom: "Jean", classe: "Licence 1 Info", matricule: "UAC-001", fraisTotal: 450000 },
          { id: 2, nom: "YAO", prenom: "Awa", classe: "Master 1 Droit", matricule: "UAC-002", fraisTotal: 500000 },
          { id: 3, nom: "GNAMIEN", prenom: "Bénédicte", classe: "Licence 2 Maths", matricule: "UAC-003", fraisTotal: 420000 },
          { id: 4, nom: "HOUNKPATIN", prenom: "Cédric", classe: "Doctorat Physique", matricule: "UAC-004", fraisTotal: 600000 }
        ],
        paiements: [
          { id: 201, studentId: 1, montant: 150000, date: "2026-02-12", statut: "payé", reference: "UPAY-101", echeance: "2026-02-20" },
          { id: 202, studentId: 2, montant: 200000, date: "", statut: "retard", reference: "", echeance: "2026-02-05" },
          { id: 203, studentId: 3, montant: 175000, date: "2026-01-28", statut: "payé", reference: "UPAY-103", echeance: "2026-02-10" },
          { id: 204, studentId: 4, montant: 300000, date: "2026-02-01", statut: "payé", reference: "UPAY-104", echeance: "2026-02-15" },
          { id: 205, studentId: 1, montant: 150000, date: "2025-12-18", statut: "payé", reference: "UPAY-105", echeance: "2025-12-31" },
        ]
      };

      let typeEtablissement = localStorage.getItem("typeEtablissement") || "college";
      let currentData = typeEtablissement === "college" ? JSON.parse(JSON.stringify(collegeData)) : JSON.parse(JSON.stringify(universityData));
      let nextPaiementId = Math.max(...currentData.paiements.map(p => p.id), 0) + 1;

      function setType(type) {
        typeEtablissement = type;
        localStorage.setItem("typeEtablissement", type);
        currentData = type === "college" ? JSON.parse(JSON.stringify(collegeData)) : JSON.parse(JSON.stringify(universityData));
        nextPaiementId = Math.max(...currentData.paiements.map(p => p.id), 0) + 1;
        renderPage();
        updateSwitchButtons();
        updateHeaderFooter();
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
      }

      function showToast(msg, isError = false) {
        const toast = document.getElementById("toast");
        toast.innerText = msg;
        toast.style.backgroundColor = isError ? "#ef4444" : "#10b981";
        toast.classList.add("show");
        setTimeout(() => toast.classList.remove("show"), 3000);
      }

      // Modale
      const modal = document.getElementById("modal-generic");
      const modalTitle = document.getElementById("modal-title");
      const modalBody = document.getElementById("modal-body");
      function openModal(title, bodyHtml) { modalTitle.innerText = title; modalBody.innerHTML = bodyHtml; modal.classList.add("is-open"); document.body.style.overflow = "hidden"; }
      function closeModal() { modal.classList.remove("is-open"); document.body.style.overflow = ""; }
      document.getElementById("close-modal")?.addEventListener("click", closeModal);
      document.getElementById("modal-close-btn")?.addEventListener("click", closeModal);
      modal?.addEventListener("click", (e) => { if (e.target === modal) closeModal(); });

      function getStudentName(id) {
        const s = currentData.students.find(st => st.id === id);
        return s ? `${s.prenom} ${s.nom}` : "Inconnu";
      }

      function getStudentClasse(id) {
        const s = currentData.students.find(st => st.id === id);
        return s ? s.classe : "";
      }

      function getStudentFraisTotal(id) {
        const s = currentData.students.find(st => st.id === id);
        return s ? s.fraisTotal : 0;
      }

      function renderPage() {
        const container = document.getElementById("dynamic-content");
        const isUniv = typeEtablissement === "universite";
        const studentLabel = isUniv ? "étudiant" : "élève";

        const paiements = currentData.paiements;
        const totalEncaisse = paiements.filter(p => p.statut === "payé").reduce((sum, p) => sum + p.montant, 0);
        const nbRetards = paiements.filter(p => p.statut === "retard").length;
        const totalRetardMontant = paiements.filter(p => p.statut === "retard").reduce((sum, p) => sum + p.montant, 0);
        
        // Total à encaisser (année) = somme des fraisTotal de tous les étudiants
        const totalAnnuelAFacturer = currentData.students.reduce((sum, s) => sum + (s.fraisTotal || 0), 0);

        container.innerHTML = `
          <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
            <div>
              <h1 class="font-heading text-2xl font-bold text-slate-900 sm:text-3xl">Scolarité & Paiements</h1>
              <p class="mt-1 text-sm text-slate-600">Gestion des frais de scolarité et suivi des paiements</p>
            </div>
            <button id="btn-add-paiement" class="action-button inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primaryDark">
              <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 4.5v15m7.5-7.5h-15"/></svg>
              Enregistrer un paiement
            </button>
          </div>

          <!-- KPIs (4 cartes) avec cercle décoratif intégré -->
          <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-8">
            <div class="kpi-card rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm" style="border-left-color: #10b981; color: #10b981;">
              <div class="flex items-start justify-between gap-2">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
                  <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 4.5h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5z"/></svg>
                </span>
              </div>
              <p class="mt-4 text-3xl font-bold tracking-tight text-slate-900">${totalEncaisse.toLocaleString()} <span class="text-lg font-normal text-slate-500">F CFA</span></p>
              <p class="text-sm font-medium text-slate-500">Total encaissé</p>
            </div>
            <div class="kpi-card rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm" style="border-left-color: #ef4444; color: #ef4444;">
              <div class="flex items-start justify-between gap-2">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-rose-100 text-rose-700">
                  <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                </span>
              </div>
              <p class="mt-4 text-3xl font-bold tracking-tight text-slate-900">${nbRetards}</p>
              <p class="text-sm font-medium text-slate-500">Paiements en retard</p>
            </div>
            <div class="kpi-card rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm" style="border-left-color: #f97316; color: #f97316;">
              <div class="flex items-start justify-between gap-2">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-100 text-amber-700">
                  <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                </span>
              </div>
              <p class="mt-4 text-3xl font-bold tracking-tight text-slate-900">${totalRetardMontant.toLocaleString()} <span class="text-lg font-normal text-slate-500">F CFA</span></p>
              <p class="text-sm font-medium text-slate-500">Montant en retard</p>
            </div>
            <div class="kpi-card rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm" style="border-left-color: #7300e9; color: #7300e9;">
              <div class="flex items-start justify-between gap-2">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary">
                  <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 6v12m-3-2.818l.879.659c1.17.879 3.018 1.758 4.242 0 .879-.879 1.758-2.635 1.758-4.242 0-1.758-1.758-3.518-3.518-3.518-.879 0-1.758.44-2.197 1.318L12 11.182"/></svg>
                </span>
              </div>
              <p class="mt-4 text-3xl font-bold tracking-tight text-slate-900">${totalAnnuelAFacturer.toLocaleString()} <span class="text-lg font-normal text-slate-500">F CFA</span></p>
              <p class="text-sm font-medium text-slate-500">Total à encaisser (année)</p>
            </div>
          </div>

          <!-- Filtres -->
          <div class="mb-5 flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[240px]">
              <input type="text" id="search-paiement" placeholder="Rechercher par nom ou référence..." class="w-full rounded-xl border border-slate-200 py-2 pl-9 pr-3 text-sm focus:border-primary focus:outline-none" />
              <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 21l-4.35-4.35M17 11a6 6 0 1 1-12 0 6 6 0 0 1 12 0z"/></svg>
            </div>
            <select id="filter-statut" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm">
              <option value="">Tous les statuts</option>
              <option value="payé">Payé</option>
              <option value="retard">En retard</option>
            </select>
          </div>

          <!-- Tableau des paiements -->
          <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-md">
            <div class="overflow-x-auto">
              <table class="min-w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                  <tr>
                    <th class="px-5 py-3">${studentLabel}</th>
                    <th class="px-3 py-3">Classe / Filière</th>
                    <th class="px-3 py-3">Montant</th>
                    <th class="px-3 py-3">Date paiement</th>
                    <th class="px-3 py-3">Échéance</th>
                    <th class="px-3 py-3">Statut</th>
                    <th class="px-3 py-3">Référence</th>
                    <th class="px-5 py-3 text-right">Actions</th>
                  </tr>
                </thead>
                <tbody id="paiements-tbody" class="divide-y divide-slate-100"></tbody>
              </table>
            </div>
          </div>
        `;

        const tbody = document.getElementById("paiements-tbody");
        const searchInput = document.getElementById("search-paiement");
        const filterStatut = document.getElementById("filter-statut");

        function renderTable() {
          const searchTerm = searchInput.value.toLowerCase();
          const statutFilter = filterStatut.value;
          const filtered = paiements.filter(p => {
            const studentName = getStudentName(p.studentId).toLowerCase();
            const ref = (p.reference || "").toLowerCase();
            const matchSearch = studentName.includes(searchTerm) || ref.includes(searchTerm);
            const matchStatut = statutFilter === "" || p.statut === statutFilter;
            return matchSearch && matchStatut;
          });

          tbody.innerHTML = filtered.map(p => {
            const studentName = getStudentName(p.studentId);
            const classe = getStudentClasse(p.studentId);
            const badgeClass = p.statut === "payé" ? "badge-paid" : "badge-late";
            const statutLabel = p.statut === "payé" ? "Payé" : "En retard";
            const datePaid = p.date ? new Date(p.date).toLocaleDateString("fr-FR") : "—";
            const echeance = new Date(p.echeance).toLocaleDateString("fr-FR");
            return `
              <tr class="hover:bg-slate-50/80">
                <td class="px-5 py-4 font-medium text-slate-900">${studentName}</td>
                <td class="px-3 py-4 text-slate-600">${classe}</td>
                <td class="px-3 py-4 font-semibold">${p.montant.toLocaleString()} F</td>
                <td class="px-3 py-4">${datePaid}</td>
                <td class="px-3 py-4">${echeance}</td>
                <td class="px-3 py-4"><span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold ${badgeClass}">${statutLabel}</span></td>
                <td class="px-3 py-4 font-mono text-xs">${p.reference || "—"}</td>
                <td class="px-5 py-4 text-right">
                  <div class="flex items-center justify-end gap-2">
                    <button data-id="${p.studentId}" class="btn-view-student text-slate-500 hover:text-primary" title="Voir détails ${studentLabel}">
                      <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                    </button>
                    <button data-id="${p.id}" class="btn-edit-paiement text-primary hover:underline text-xs font-semibold">Modifier</button>
                    <button data-id="${p.id}" class="btn-delete-paiement text-danger hover:underline text-xs font-semibold">Supprimer</button>
                  </div>
                </td>
              </tr>
            `;
          }).join("");
        }

        renderTable();
        searchInput.addEventListener("input", renderTable);
        filterStatut.addEventListener("change", renderTable);

        // Bouton Ajouter
        document.getElementById("btn-add-paiement").addEventListener("click", () => openPaiementModal());

        // Actions sur les boutons du tableau
        tbody.addEventListener("click", (e) => {
          const viewBtn = e.target.closest(".btn-view-student");
          const editBtn = e.target.closest(".btn-edit-paiement");
          const delBtn = e.target.closest(".btn-delete-paiement");

          if (viewBtn) {
            const studentId = parseInt(viewBtn.dataset.id);
            const student = currentData.students.find(s => s.id === studentId);
            if (student) openStudentDetailsModal(student);
          }
          if (editBtn) {
            const id = parseInt(editBtn.dataset.id);
            const paiement = paiements.find(p => p.id === id);
            if (paiement) openPaiementModal(paiement);
          }
          if (delBtn) {
            const id = parseInt(delBtn.dataset.id);
            if (confirm("Supprimer ce paiement ?")) {
              currentData.paiements = currentData.paiements.filter(p => p.id !== id);
              renderPage();
              showToast("Paiement supprimé");
            }
          }
        });

        // Fonction modale détails étudiant
        function openStudentDetailsModal(student) {
          const studentPaiements = paiements.filter(p => p.studentId === student.id);
          const totalPaye = studentPaiements.filter(p => p.statut === "payé").reduce((sum, p) => sum + p.montant, 0);
          const resteAPayer = student.fraisTotal - totalPaye;
          const historiqueHtml = studentPaiements.length ? studentPaiements.map(p => `
            <tr>
              <td class="py-2">${new Date(p.date || p.echeance).toLocaleDateString("fr-FR")}</td>
              <td class="py-2">${p.montant.toLocaleString()} F</td>
              <td class="py-2"><span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold ${p.statut === 'payé' ? 'badge-paid' : 'badge-late'}">${p.statut === 'payé' ? 'Payé' : 'Retard'}</span></td>
              <td class="py-2 font-mono text-xs">${p.reference || "—"}</td>
            </tr>
          `).join("") : `<tr><td colspan="4" class="py-4 text-center text-slate-500">Aucun paiement enregistré</td></tr>`;

          const bodyHtml = `
            <div class="space-y-4">
              <div class="flex items-center gap-4 border-b pb-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-primary/10 text-lg font-bold text-primary">${student.prenom[0]}${student.nom[0]}</div>
                <div>
                  <h3 class="font-heading text-lg font-bold">${student.prenom} ${student.nom}</h3>
                  <p class="text-sm text-slate-500">${student.matricule} · ${student.classe}</p>
                </div>
              </div>
              <div class="grid grid-cols-3 gap-4 text-center">
                <div class="rounded-lg bg-slate-50 p-3">
                  <p class="text-xs text-slate-500">Total dû</p>
                  <p class="text-xl font-bold">${student.fraisTotal.toLocaleString()} F</p>
                </div>
                <div class="rounded-lg bg-emerald-50 p-3">
                  <p class="text-xs text-emerald-700">Total payé</p>
                  <p class="text-xl font-bold text-emerald-800">${totalPaye.toLocaleString()} F</p>
                </div>
                <div class="rounded-lg ${resteAPayer > 0 ? 'bg-amber-50' : 'bg-emerald-50'} p-3">
                  <p class="text-xs ${resteAPayer > 0 ? 'text-amber-700' : 'text-emerald-700'}">Reste à payer</p>
                  <p class="text-xl font-bold ${resteAPayer > 0 ? 'text-amber-800' : 'text-emerald-800'}">${resteAPayer.toLocaleString()} F</p>
                </div>
              </div>
              <div>
                <h4 class="font-semibold mb-2">Historique des paiements</h4>
                <div class="max-h-64 overflow-y-auto rounded-lg border">
                  <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-xs uppercase text-slate-500 sticky top-0">
                      <tr><th class="px-3 py-2 text-left">Date</th><th class="px-3 py-2 text-left">Montant</th><th class="px-3 py-2 text-left">Statut</th><th class="px-3 py-2 text-left">Réf.</th></tr>
                    </thead>
                    <tbody class="divide-y">${historiqueHtml}</tbody>
                  </table>
                </div>
              </div>
            </div>
          `;
          openModal(`Détails ${studentLabel}`, bodyHtml);
        }

        // Fonction modale Ajout/Modification paiement
        function openPaiementModal(paiement = null) {
          const isEdit = !!paiement;
          const title = isEdit ? "Modifier le paiement" : "Nouveau paiement";
          const studentOptions = currentData.students.map(s => `<option value="${s.id}" ${paiement && paiement.studentId === s.id ? "selected" : ""}>${s.prenom} ${s.nom} (${s.matricule})</option>`).join("");
          const bodyHtml = `
            <form id="paiement-form" class="space-y-4">
              <div>
                <label class="block text-sm font-medium">${studentLabel}</label>
                <select id="paiement-student" class="w-full rounded-xl border p-2" required>${studentOptions}</select>
              </div>
              <div>
                <label class="block text-sm font-medium">Montant (F CFA)</label>
                <input type="number" id="paiement-montant" value="${paiement?.montant || ''}" class="w-full rounded-xl border p-2" required>
              </div>
              <div>
                <label class="block text-sm font-medium">Date de paiement</label>
                <input type="date" id="paiement-date" value="${paiement?.date || ''}" class="w-full rounded-xl border p-2">
              </div>
              <div>
                <label class="block text-sm font-medium">Date d'échéance</label>
                <input type="date" id="paiement-echeance" value="${paiement?.echeance || ''}" class="w-full rounded-xl border p-2" required>
              </div>
              <div>
                <label class="block text-sm font-medium">Référence</label>
                <input type="text" id="paiement-ref" value="${paiement?.reference || ''}" class="w-full rounded-xl border p-2">
              </div>
              <div>
                <label class="block text-sm font-medium">Statut</label>
                <select id="paiement-statut" class="w-full rounded-xl border p-2">
                  <option value="payé" ${paiement?.statut === "payé" ? "selected" : ""}>Payé</option>
                  <option value="retard" ${paiement?.statut === "retard" ? "selected" : ""}>En retard</option>
                </select>
              </div>
              <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white">${isEdit ? "Mettre à jour" : "Enregistrer"}</button>
                <button type="button" id="modal-cancel" class="flex-1 rounded-xl border bg-white px-4 py-2 text-sm font-semibold">Annuler</button>
              </div>
            </form>
          `;
          openModal(title, bodyHtml);
          document.getElementById("modal-cancel").addEventListener("click", closeModal);
          const form = document.getElementById("paiement-form");
          form.addEventListener("submit", (e) => {
            e.preventDefault();
            const studentId = parseInt(document.getElementById("paiement-student").value);
            const montant = parseFloat(document.getElementById("paiement-montant").value);
            const date = document.getElementById("paiement-date").value;
            const echeance = document.getElementById("paiement-echeance").value;
            const reference = document.getElementById("paiement-ref").value.trim();
            const statut = document.getElementById("paiement-statut").value;

            if (!studentId || isNaN(montant) || !echeance) {
              showToast("Veuillez remplir tous les champs obligatoires", true);
              return;
            }

            const newPaiement = {
              id: isEdit ? paiement.id : nextPaiementId++,
              studentId,
              montant,
              date,
              echeance,
              reference,
              statut
            };

            if (isEdit) {
              const index = currentData.paiements.findIndex(p => p.id === paiement.id);
              if (index !== -1) currentData.paiements[index] = newPaiement;
            } else {
              currentData.paiements.push(newPaiement);
            }

            renderPage();
            closeModal();
            showToast(isEdit ? "Paiement modifié" : "Paiement enregistré");
          });
        }
      }

      function init() {
        updateHeaderFooter();
        renderPage();
        updateSwitchButtons();
        document.getElementById("switch-college")?.addEventListener("click", () => setType("college"));
        document.getElementById("switch-universite")?.addEventListener("click", () => setType("universite"));

        // Sidebar mobile
        const sidebar = document.getElementById("sidebar");
        const overlay = document.getElementById("sidebar-overlay");
        const btnMenu = document.getElementById("btn-menu");
        btnMenu?.addEventListener("click", () => { sidebar.classList.remove("-translate-x-full"); overlay.classList.add("is-open"); document.body.style.overflow = "hidden"; });
        overlay?.addEventListener("click", () => { sidebar.classList.add("-translate-x-full"); overlay.classList.remove("is-open"); document.body.style.overflow = ""; });
        window.addEventListener("resize", () => { if (window.innerWidth >= 1024) { sidebar.classList.remove("-translate-x-full"); overlay.classList.remove("is-open"); document.body.style.overflow = ""; } });

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
