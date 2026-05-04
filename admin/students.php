<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion des élèves | EduManager</title>
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
    .modal-content { transform: scale(0.95); transition: transform 0.2s ease; max-width: 90%; width: 32rem; background: white; border-radius: 1rem; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); }
    .modal-overlay.is-open .modal-content { transform: scale(1); }
    .toast { position: fixed; bottom: 20px; right: 20px; background: #1e293b; color: white; padding: 12px 20px; border-radius: 12px; font-size: 0.875rem; z-index: 10000; opacity: 0; transition: opacity 0.3s; pointer-events: none; }
    .toast.show { opacity: 1; }
    .student-photo { width: 40px; height: 40px; object-fit: cover; border-radius: 9999px; }
    .mention-badge { display: inline-flex; align-items: center; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.7rem; font-weight: 500; margin-left: 0.5rem; }
    .mention-excellent { background-color: #dcfce7; color: #166534; }
    .mention-good { background-color: #dbeafe; color: #1e40af; }
    .mention-average { background-color: #fef9c3; color: #854d0e; }
    .mention-passable { background-color: #fed7aa; color: #9a3412; }
    .mention-insufficient { background-color: #fee2e2; color: #991b1b; }
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
      <a href="eleves.html" class="sidebar-link active flex items-center gap-3 rounded-xl px-3 py-2.5 mt-1">
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
        { id: 1, nom: "KOUADIO", prenom: "Marie", classe: "3ème", etablissement: "Collège Saint-Michel", matricule: "CSM-001", notes: [{ matiere: "Mathématiques", note: 15, coeff:3 }, { matiere: "Français", note: 14, coeff:2 }, { matiere: "Anglais", note: 16, coeff:2 }], photo: null },
        { id: 2, nom: "TRAORÉ", prenom: "Ibrahim", classe: "Seconde", etablissement: "Lycée Béhanzin", matricule: "LB-045", notes: [{ matiere: "Mathématiques", note: 12, coeff:3 }, { matiere: "Français", note: 10, coeff:2 }, { matiere: "Anglais", note: 11, coeff:2 }], photo: null },
        { id: 3, nom: "DIALLO", prenom: "Aminata", classe: "Terminale", etablissement: "Université Partenaire Atlantique", matricule: "UPA-234", notes: [{ matiere: "Mathématiques", note: 18, coeff:3 }, { matiere: "Français", note: 17, coeff:2 }, { matiere: "Anglais", note: 19, coeff:2 }], photo: null },
        { id: 4, nom: "N'GUESSAN", prenom: "Koffi", classe: "4ème", etablissement: "Cours Secondaire Ste Thérèse", matricule: "CST-089", notes: [{ matiere: "Mathématiques", note: 11, coeff:3 }, { matiere: "Français", note: 12, coeff:2 }, { matiere: "Anglais", note: 10, coeff:2 }], photo: null },
        { id: 5, nom: "HOUNDONOU", prenom: "Jules", classe: "5ème", etablissement: "École Le Savoir", matricule: "ELS-067", notes: [{ matiere: "Mathématiques", note: 8, coeff:3 }, { matiere: "Français", note: 9, coeff:2 }, { matiere: "Anglais", note: 7, coeff:2 }], photo: null }
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
        { id: 1, nom: "KOUASSI", prenom: "Jean", classe: "Licence 1 Info", etablissement: "Université d'Abomey-Calavi", matricule: "UAC-001", notes: [{ matiere: "Algorithmique", note: 14, coeff:3 }, { matiere: "Maths Discrètes", note: 12, coeff:2 }, { matiere: "Anglais", note: 13, coeff:2 }], photo: null },
        { id: 2, nom: "YAO", prenom: "Awa", classe: "Master 1 Droit", etablissement: "Université d'Abomey-Calavi", matricule: "UAC-002", notes: [{ matiere: "Droit des contrats", note: 16, coeff:3 }, { matiere: "Droit pénal", note: 15, coeff:2 }, { matiere: "Anglais juridique", note: 14, coeff:2 }], photo: null },
        { id: 3, nom: "GNAMIEN", prenom: "Bénédicte", classe: "Licence 2 Maths", etablissement: "Université d'Abomey-Calavi", matricule: "UAC-003", notes: [{ matiere: "Algèbre", note: 11, coeff:3 }, { matiere: "Analyse", note: 10, coeff:2 }, { matiere: "Probabilités", note: 12, coeff:2 }], photo: null },
        { id: 4, nom: "HOUNKPATIN", prenom: "Cédric", classe: "Doctorat Physique", etablissement: "Université d'Abomey-Calavi", matricule: "UAC-004", notes: [{ matiere: "Mécanique quantique", note: 17, coeff:3 }, { matiere: "Physique statistique", note: 16, coeff:2 }, { matiere: "Anglais scientifique", note: 15, coeff:2 }], photo: null }
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

    function restorePhotos() {
      const savedPhotos = localStorage.getItem("studentPhotos");
      if (savedPhotos) {
        const photos = JSON.parse(savedPhotos);
        currentData.students.forEach(s => { if (photos[s.id]) s.photo = photos[s.id]; });
      }
    }
    function savePhotos() {
      const photos = {};
      currentData.students.forEach(s => { if (s.photo) photos[s.id] = s.photo; });
      localStorage.setItem("studentPhotos", JSON.stringify(photos));
    }
    restorePhotos();

    function getStudentAverage(student) {
      let total = 0, coeffSum = 0;
      if (student.notes && student.notes.length) {
        student.notes.forEach(n => { total += n.note * n.coeff; coeffSum += n.coeff; });
        return coeffSum ? total / coeffSum : 0;
      }
      return 0;
    }

    function getMention(moyenne) {
      if (moyenne >= 16) return { text: "Très bien", class: "mention-excellent" };
      if (moyenne >= 14) return { text: "Bien", class: "mention-good" };
      if (moyenne >= 12) return { text: "Assez bien", class: "mention-average" };
      if (moyenne >= 10) return { text: "Passable", class: "mention-passable" };
      return { text: "Insuffisant", class: "mention-insufficient" };
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
      restorePhotos();
      updateHeaderFooter();
      renderStudentsPage();
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

    function getPhotoPreview(file, callback) {
      const reader = new FileReader();
      reader.onload = (e) => callback(e.target.result);
      reader.readAsDataURL(file);
    }

    function openAddModal() {
      const isUniv = typeEtablissement === "universite";
      const classLabel = isUniv ? "Filière / Niveau" : "Classe";
      const classOptions = currentData.classes.map(c => `<option value="${escapeHtml(c.name)}">${escapeHtml(c.name)}</option>`).join("");
      const bodyHtml = `
        <form id="add-student-form" class="space-y-4">
          <div class="flex justify-center">
            <div class="relative">
              <div id="photo-preview" class="w-24 h-24 rounded-full bg-slate-100 border-2 border-slate-200 flex items-center justify-center overflow-hidden">
                <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0ZM12 14a7 7 0 0 0-7 7h14a7 7 0 0 0-7-7Z"/></svg>
              </div>
              <input type="file" id="photo-upload" accept="image/*" class="hidden">
              <button type="button" id="choose-photo" class="mt-2 text-xs text-primary hover:underline">Ajouter une photo</button>
            </div>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700">Nom</label>
            <input type="text" id="new-nom" class="w-full rounded-xl border border-slate-200 px-3 py-2" required>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700">Prénom</label>
            <input type="text" id="new-prenom" class="w-full rounded-xl border border-slate-200 px-3 py-2" required>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700">${classLabel}</label>
            <select id="new-classe" class="w-full rounded-xl border border-slate-200 px-3 py-2" required>
              <option value="">-- Sélectionner --</option>
              ${classOptions}
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700">Matricule</label>
            <input type="text" id="new-matricule" class="w-full rounded-xl border border-slate-200 px-3 py-2" required>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700">Établissement</label>
            <input type="text" id="new-etab" value="${escapeHtml(currentData.schoolName)}" class="w-full rounded-xl border border-slate-200 px-3 py-2" required>
          </div>
          <div class="flex gap-3 pt-2">
            <button type="submit" class="flex-1 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white">Enregistrer</button>
            <button type="button" id="form-cancel" class="flex-1 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700">Annuler</button>
          </div>
        </form>
      `;
      openModal(isUniv ? "Ajouter un étudiant" : "Ajouter un élève", bodyHtml);
      let selectedPhoto = null;
      const chooseBtn = document.getElementById("choose-photo");
      const photoUpload = document.getElementById("photo-upload");
      const previewDiv = document.getElementById("photo-preview");
      if (chooseBtn && photoUpload) {
        chooseBtn.addEventListener("click", () => photoUpload.click());
        photoUpload.addEventListener("change", (e) => {
          const file = e.target.files[0];
          if (file && file.type.startsWith("image/")) {
            getPhotoPreview(file, (dataUrl) => {
              selectedPhoto = dataUrl;
              previewDiv.innerHTML = `<img src="${dataUrl}" class="w-full h-full object-cover">`;
            });
          } else {
            showToast("Veuillez sélectionner une image valide", "error");
          }
        });
      }
      const form = document.getElementById("add-student-form");
      const cancelBtn = document.getElementById("form-cancel");
      if (cancelBtn) cancelBtn.addEventListener("click", closeModal);
      if (form) {
        form.addEventListener("submit", (e) => {
          e.preventDefault();
          const nom = document.getElementById("new-nom").value.trim();
          const prenom = document.getElementById("new-prenom").value.trim();
          const classe = document.getElementById("new-classe").value;
          const matricule = document.getElementById("new-matricule").value.trim();
          const etablissement = document.getElementById("new-etab").value.trim();
          if (!nom || !prenom || !classe || !matricule || !etablissement) {
            showToast("Veuillez remplir tous les champs", "error");
            return;
          }
          const newId = Math.max(...currentData.students.map(s => s.id), 0) + 1;
          const newStudent = {
            id: newId,
            nom,
            prenom,
            classe,
            matricule,
            etablissement,
            notes: [],
            photo: selectedPhoto || null
          };
          currentData.students.push(newStudent);
          savePhotos();
          renderStudentsPage();
          closeModal();
          showToast(isUniv ? "Étudiant ajouté" : "Élève ajouté");
        });
      }
    }

    function openEditModal(student) {
      const isUniv = typeEtablissement === "universite";
      const classLabel = isUniv ? "Filière / Niveau" : "Classe";
      const classOptions = currentData.classes.map(c => `<option value="${escapeHtml(c.name)}" ${c.name === student.classe ? "selected" : ""}>${escapeHtml(c.name)}</option>`).join("");
      const photoHtml = student.photo ? `<img src="${student.photo}" class="w-full h-full object-cover">` : `<svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0ZM12 14a7 7 0 0 0-7 7h14a7 7 0 0 0-7-7Z"/></svg>`;
      const bodyHtml = `
        <form id="edit-student-form" class="space-y-4">
          <div class="flex justify-center">
            <div class="relative">
              <div id="photo-preview-edit" class="w-24 h-24 rounded-full bg-slate-100 border-2 border-slate-200 flex items-center justify-center overflow-hidden">
                ${photoHtml}
              </div>
              <input type="file" id="photo-upload-edit" accept="image/*" class="hidden">
              <button type="button" id="choose-photo-edit" class="mt-2 text-xs text-primary hover:underline">Changer la photo</button>
            </div>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700">Nom</label>
            <input type="text" id="edit-nom" value="${escapeHtml(student.nom)}" class="w-full rounded-xl border border-slate-200 px-3 py-2" required>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700">Prénom</label>
            <input type="text" id="edit-prenom" value="${escapeHtml(student.prenom)}" class="w-full rounded-xl border border-slate-200 px-3 py-2" required>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700">${classLabel}</label>
            <select id="edit-classe" class="w-full rounded-xl border border-slate-200 px-3 py-2" required>
              <option value="">-- Sélectionner --</option>
              ${classOptions}
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700">Matricule</label>
            <input type="text" id="edit-matricule" value="${escapeHtml(student.matricule)}" class="w-full rounded-xl border border-slate-200 px-3 py-2" required>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700">Établissement</label>
            <input type="text" id="edit-etab" value="${escapeHtml(student.etablissement)}" class="w-full rounded-xl border border-slate-200 px-3 py-2" required>
          </div>
          <div class="flex gap-3 pt-2">
            <button type="submit" class="flex-1 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white">Mettre à jour</button>
            <button type="button" id="form-cancel-edit" class="flex-1 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700">Annuler</button>
          </div>
        </form>
      `;
      openModal(isUniv ? "Modifier un étudiant" : "Modifier un élève", bodyHtml);
      let selectedPhoto = student.photo || null;
      const chooseBtn = document.getElementById("choose-photo-edit");
      const photoUpload = document.getElementById("photo-upload-edit");
      const previewDiv = document.getElementById("photo-preview-edit");
      if (chooseBtn && photoUpload) {
        chooseBtn.addEventListener("click", () => photoUpload.click());
        photoUpload.addEventListener("change", (e) => {
          const file = e.target.files[0];
          if (file && file.type.startsWith("image/")) {
            getPhotoPreview(file, (dataUrl) => {
              selectedPhoto = dataUrl;
              previewDiv.innerHTML = `<img src="${dataUrl}" class="w-full h-full object-cover">`;
            });
          } else {
            showToast("Veuillez sélectionner une image valide", "error");
          }
        });
      }
      const form = document.getElementById("edit-student-form");
      const cancelBtn = document.getElementById("form-cancel-edit");
      if (cancelBtn) cancelBtn.addEventListener("click", closeModal);
      if (form) {
        form.addEventListener("submit", (e) => {
          e.preventDefault();
          const nom = document.getElementById("edit-nom").value.trim();
          const prenom = document.getElementById("edit-prenom").value.trim();
          const classe = document.getElementById("edit-classe").value;
          const matricule = document.getElementById("edit-matricule").value.trim();
          const etablissement = document.getElementById("edit-etab").value.trim();
          if (!nom || !prenom || !classe || !matricule || !etablissement) {
            showToast("Veuillez remplir tous les champs", "error");
            return;
          }
          student.nom = nom;
          student.prenom = prenom;
          student.classe = classe;
          student.matricule = matricule;
          student.etablissement = etablissement;
          if (selectedPhoto) student.photo = selectedPhoto;
          savePhotos();
          renderStudentsPage();
          closeModal();
          showToast(isUniv ? "Étudiant modifié" : "Élève modifié");
        });
      }
    }

    function openViewModal(student) {
      const isUniv = typeEtablissement === "universite";
      const classLabel = isUniv ? "Filière / Niveau" : "Classe";
      const moyenne = getStudentAverage(student).toFixed(1);
      const mention = getMention(parseFloat(moyenne));
      const photoHtml = student.photo ? `<img src="${student.photo}" class="w-20 h-20 rounded-full object-cover mx-auto">` : `<div class="w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center mx-auto"><svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0ZM12 14a7 7 0 0 0-7 7h14a7 7 0 0 0-7-7Z"/></svg></div>`;
      const bodyHtml = `
        <div class="space-y-4">
          <div class="flex justify-center">${photoHtml}</div>
          <div class="border-b border-slate-100 pb-2">
            <p class="text-xs font-semibold uppercase text-slate-500">Nom complet</p>
            <p class="text-slate-800 font-medium">${escapeHtml(student.nom)} ${escapeHtml(student.prenom)}</p>
          </div>
          <div class="border-b border-slate-100 pb-2">
            <p class="text-xs font-semibold uppercase text-slate-500">${classLabel}</p>
            <p class="text-slate-800">${escapeHtml(student.classe)}</p>
          </div>
          <div class="border-b border-slate-100 pb-2">
            <p class="text-xs font-semibold uppercase text-slate-500">Matricule</p>
            <p class="text-slate-800">${escapeHtml(student.matricule || "-")}</p>
          </div>
          <div class="border-b border-slate-100 pb-2">
            <p class="text-xs font-semibold uppercase text-slate-500">Établissement</p>
            <p class="text-slate-800">${escapeHtml(student.etablissement || currentData.schoolName)}</p>
          </div>
          <div>
            <p class="text-xs font-semibold uppercase text-slate-500">Moyenne générale</p>
            <p class="text-slate-800 font-medium">${moyenne} /20 <span class="mention-badge ${mention.class}">${mention.text}</span></p>
          </div>
        </div>
      `;
      openModal("Détails de l'étudiant", bodyHtml);
    }

    function deleteStudent(id) {
      const student = currentData.students.find(s => s.id === id);
      if (!student) return;
      const isUniv = typeEtablissement === "universite";
      const confirmBody = `
        <div class="space-y-4">
          <p class="text-slate-700">Supprimer définitivement <strong>${escapeHtml(student.nom)} ${escapeHtml(student.prenom)}</strong> ?</p>
          <div class="flex gap-3 justify-end">
            <button id="confirm-cancel" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700">Annuler</button>
            <button id="confirm-ok" class="rounded-xl bg-red-600 px-4 py-2 text-sm font-semibold text-white">Supprimer</button>
          </div>
        </div>
      `;
      openModal("Confirmation", confirmBody);
      const confirmOk = document.getElementById("confirm-ok");
      const confirmCancel = document.getElementById("confirm-cancel");
      const modalClose = () => closeModal();
      if (confirmCancel) confirmCancel.addEventListener("click", modalClose);
      if (confirmOk) {
        confirmOk.addEventListener("click", () => {
          const index = currentData.students.findIndex(s => s.id === id);
          if (index !== -1) currentData.students.splice(index, 1);
          savePhotos();
          renderStudentsPage();
          closeModal();
          showToast(isUniv ? "Étudiant supprimé" : "Élève supprimé");
        });
      }
    }

    function renderStudentsPage() {
      const container = document.getElementById("dynamic-content");
      if (!container) return;

      const isUniv = typeEtablissement === "universite";
      const studentLabel = isUniv ? "étudiants" : "élèves";
      const classLabel = isUniv ? "filière" : "classe";
      const classLabelCapitalized = isUniv ? "Filière / Niveau" : "Classe";
      const classLabelPlural = isUniv ? "filières" : "classes";

      const totalStudents = currentData.students.length;
      let sumGrades = 0, difficultyCount = 0;
      currentData.students.forEach(s => {
        const avg = getStudentAverage(s);
        sumGrades += avg;
        if (avg < 10) difficultyCount++;
      });
      const globalAverage = totalStudents ? (sumGrades / totalStudents).toFixed(1) : "0.0";

      const classOptions = currentData.classes.map(c => `<option value="${escapeHtml(c.name)}">${escapeHtml(c.name)}</option>`).join("");

      container.innerHTML = `
        <div class="mb-6">
          <h1 class="font-heading text-2xl font-bold text-slate-900 sm:text-3xl">Gestion des ${studentLabel}</h1>
          <p class="mt-1 text-sm text-slate-600">Liste complète et suivi des performances</p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 mb-8">
          <div class="kpi-card rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm" style="border-left-color: #7300e9;">
            <p class="text-xs font-semibold uppercase text-slate-500">Total ${studentLabel}</p>
            <p class="text-3xl font-bold text-slate-900">${totalStudents}</p>
          </div>
          <div class="kpi-card rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm" style="border-left-color: #22c55e;">
            <p class="text-xs font-semibold uppercase text-slate-500">Moyenne générale</p>
            <p class="text-3xl font-bold text-slate-900">${globalAverage}<span class="text-lg font-normal text-slate-500"> /20</span></p>
          </div>
          <div class="kpi-card rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm" style="border-left-color: #ef4444;">
            <p class="text-xs font-semibold uppercase text-slate-500">En difficulté (&lt;10)</p>
            <p class="text-3xl font-bold text-slate-900">${difficultyCount}</p>
          </div>
        </div>

        <div class="flex flex-wrap justify-between gap-4 mb-6">
          <div class="flex flex-wrap gap-3">
            <div class="relative">
              <input type="text" id="search-students" placeholder="Rechercher (nom, prénom, matricule)" class="w-64 rounded-xl border border-slate-200 bg-white px-4 py-2 pl-10 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
              <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z"/></svg>
              </span>
            </div>
            <div class="relative">
              <select id="filter-class-select" class="appearance-none rounded-xl border border-slate-200 bg-white px-4 py-2 pr-8 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
                <option value="">Tous les ${classLabelPlural}</option>
                ${classOptions}
              </select>
              <svg class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m19 9-7 7-7-7"/></svg>
            </div>
            <button id="reset-filters" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Réinitialiser</button>
          </div>
          <button id="btn-add-student-page" class="action-button inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primaryDark">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 4.5v15m7.5-7.5h-15"/></svg>
            ${isUniv ? "Ajouter un étudiant" : "Ajouter un élève"}
          </button>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-md">
          <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
              <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr>
                  <th class="px-5 py-4 sm:px-6">Photo</th>
                  <th class="px-3 py-4">Nom complet</th>
                  <th class="px-3 py-4">${classLabelCapitalized}</th>
                  <th class="px-3 py-4">Moyenne & mention</th>
                  <th class="px-5 py-4 text-right">Actions</th>
                </tr>
              </thead>
              <tbody id="students-table-body" class="divide-y divide-slate-100"></tbody>
            </table>
          </div>
        </div>
      `;

      let filterClass = "";
      let searchTerm = "";

      function renderTable() {
        const tbody = document.getElementById("students-table-body");
        if (!tbody) return;

        let filtered = [...currentData.students];
        if (filterClass) filtered = filtered.filter(s => s.classe === filterClass);
        if (searchTerm) {
          filtered = filtered.filter(s => 
            s.nom.toLowerCase().includes(searchTerm) || 
            s.prenom.toLowerCase().includes(searchTerm) ||
            (s.matricule && s.matricule.toLowerCase().includes(searchTerm))
          );
        }

        if (filtered.length === 0) {
          tbody.innerHTML = `<tr><td colspan="5" class="px-5 py-8 text-center text-slate-500">Aucun ${studentLabel} trouvé</td></tr>`;
          return;
        }

        tbody.innerHTML = filtered.map(s => {
          const moyenne = getStudentAverage(s).toFixed(1);
          const mention = getMention(parseFloat(moyenne));
          const difficultyClass = moyenne < 10 ? "text-red-600 font-semibold" : "text-slate-700";
          const photoHtml = s.photo ? `<img src="${s.photo}" class="student-photo">` : `<div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center"><svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0ZM12 14a7 7 0 0 0-7 7h14a7 7 0 0 0-7-7Z"/></svg></div>`;
          return `
            <tr class="hover:bg-slate-50/80 transition-all">
              <td class="px-5 py-4">${photoHtml}</td>
              <td class="px-3 py-4 font-medium text-slate-900">${escapeHtml(s.nom)} ${escapeHtml(s.prenom)}</td>
              <td class="px-3 py-4">${escapeHtml(s.classe)}</td>
              <td class="px-3 py-4 ${difficultyClass}">
                ${moyenne} /20
                <span class="mention-badge ${mention.class}">${mention.text}</span>
              </td>
              <td class="px-5 py-4 text-right">
                <div class="flex justify-end gap-2">
                  <button class="view-student-btn text-slate-500 hover:text-primary transition" data-id="${s.id}" title="Voir détails">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                  </button>
                  <button class="edit-student-btn text-primary hover:underline" data-id="${s.id}">Modifier</button>
                  <button class="delete-student-btn text-red-600 hover:underline" data-id="${s.id}">Supprimer</button>
                </div>
               </td>
             </tr>
          `;
        }).join("");
      }

      const searchInput = document.getElementById("search-students");
      const filterSelect = document.getElementById("filter-class-select");
      const resetBtn = document.getElementById("reset-filters");
      if (searchInput) {
        searchInput.addEventListener("input", (e) => {
          searchTerm = e.target.value.toLowerCase();
          renderTable();
        });
      }
      if (filterSelect) {
        filterSelect.addEventListener("change", (e) => {
          filterClass = e.target.value;
          renderTable();
        });
      }
      if (resetBtn) {
        resetBtn.addEventListener("click", () => {
          if (searchInput) searchInput.value = "";
          if (filterSelect) filterSelect.value = "";
          searchTerm = "";
          filterClass = "";
          renderTable();
        });
      }

      const addBtn = document.getElementById("btn-add-student-page");
      if (addBtn) addBtn.addEventListener("click", () => openAddModal());

      const tbody = document.getElementById("students-table-body");
      if (tbody) {
        tbody.addEventListener("click", (e) => {
          const viewBtn = e.target.closest(".view-student-btn");
          if (viewBtn) {
            const id = parseInt(viewBtn.getAttribute("data-id"));
            const student = currentData.students.find(s => s.id === id);
            if (student) openViewModal(student);
            return;
          }
          const editBtn = e.target.closest(".edit-student-btn");
          if (editBtn) {
            const id = parseInt(editBtn.getAttribute("data-id"));
            const student = currentData.students.find(s => s.id === id);
            if (student) openEditModal(student);
            return;
          }
          const deleteBtn = e.target.closest(".delete-student-btn");
          if (deleteBtn) {
            const id = parseInt(deleteBtn.getAttribute("data-id"));
            deleteStudent(id);
            return;
          }
        });
      }

      renderTable();
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
      renderStudentsPage();
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
