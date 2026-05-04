<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Paramètres | EduManager</title>
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
    .toast { position: fixed; bottom: 20px; right: 20px; background: #1e293b; color: white; padding: 12px 20px; border-radius: 12px; font-size: 0.875rem; z-index: 10000; opacity: 0; transition: opacity 0.3s; pointer-events: none; }
    .toast.show { opacity: 1; }
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 text-slate-800 antialiased">
  <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden"></div>

  <!-- Sidebar (identique, avec "Paramètres" avant Déconnexion) -->
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
      <!-- Nouveau lien Paramètres (actif sur cette page) -->
      <a href="parametres.html" class="sidebar-link active flex items-center gap-3 rounded-xl px-3 py-2.5 mt-2">
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
      // ==================== DONNÉES ====================
      const collegeData = {
        schoolName: "Collège Saint-Michel",
        schoolLocation: "Cotonou, Bénin",
        type: "college",
        schoolYear: "2025–2026",
        admin: { nom: "Kossi", prenom: "Aminata", email: "admin@saintmichel.bj", photo: null },
        schoolPhoto: null
      };
      const universityData = {
        schoolName: "Université d'Abomey-Calavi",
        schoolLocation: "Abomey-Calavi, Bénin",
        type: "universite",
        schoolYear: "2025–2026",
        admin: { nom: "Kossi", prenom: "Aminata", email: "admin@uac.bj", photo: null },
        schoolPhoto: null
      };

      let typeEtablissement = localStorage.getItem("typeEtablissement") || "college";
      let currentData = typeEtablissement === "college" ? JSON.parse(JSON.stringify(collegeData)) : JSON.parse(JSON.stringify(universityData));

      // Charger les données personnalisées depuis localStorage
      if (localStorage.getItem("customSchoolName")) {
        currentData.schoolName = localStorage.getItem("customSchoolName");
        currentData.schoolLocation = localStorage.getItem("customSchoolLocation") || currentData.schoolLocation;
        currentData.schoolYear = localStorage.getItem("customSchoolYear") || currentData.schoolYear;
      }
      if (localStorage.getItem("adminPhoto")) {
        currentData.admin.photo = localStorage.getItem("adminPhoto");
      }
      if (localStorage.getItem("schoolPhoto")) {
        currentData.schoolPhoto = localStorage.getItem("schoolPhoto");
      }

      function setType(type) {
        typeEtablissement = type;
        localStorage.setItem("typeEtablissement", type);
        currentData = type === "college" ? JSON.parse(JSON.stringify(collegeData)) : JSON.parse(JSON.stringify(universityData));
        // Recharger les customs
        if (localStorage.getItem("customSchoolName")) {
          currentData.schoolName = localStorage.getItem("customSchoolName");
          currentData.schoolLocation = localStorage.getItem("customSchoolLocation") || currentData.schoolLocation;
          currentData.schoolYear = localStorage.getItem("customSchoolYear") || currentData.schoolYear;
        }
        if (localStorage.getItem("adminPhoto")) {
          currentData.admin.photo = localStorage.getItem("adminPhoto");
        }
        if (localStorage.getItem("schoolPhoto")) {
          currentData.schoolPhoto = localStorage.getItem("schoolPhoto");
        }
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
        document.getElementById("school-year").innerText = `Année ${currentData.schoolYear}`;
        // Avatar header
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

      function escapeHtml(str) {
        if (!str) return "";
        return str.replace(/[&<>]/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;' })[c]);
      }

      // Prévisualisation photo (générique)
      function updatePhotoPreview(prefix, currentPhoto) {
        const fileInput = document.getElementById(`${prefix}-photo-file`);
        const urlInput = document.getElementById(`${prefix}-photo-url`);
        const preview = document.getElementById(`${prefix}-preview`);
        const deleteBtn = document.getElementById(`${prefix}-btn-delete`);
        
        if (fileInput.files && fileInput.files[0]) {
          const reader = new FileReader();
          reader.onload = e => {
            preview.innerHTML = `<img src="${e.target.result}" alt="Photo" class="h-20 w-20 rounded-full object-cover border-2 border-white shadow">`;
            deleteBtn.classList.remove("hidden");
          };
          reader.readAsDataURL(fileInput.files[0]);
        } else if (urlInput.value.trim()) {
          preview.innerHTML = `<img src="${urlInput.value.trim()}" alt="Photo" class="h-20 w-20 rounded-full object-cover border-2 border-white shadow">`;
          deleteBtn.classList.remove("hidden");
        } else if (currentPhoto) {
          preview.innerHTML = `<img src="${currentPhoto}" alt="Photo" class="h-20 w-20 rounded-full object-cover border-2 border-white shadow">`;
          deleteBtn.classList.remove("hidden");
        } else {
          preview.innerHTML = `<span class="text-3xl font-bold text-primary">${prefix === 'admin' ? currentData.admin.prenom[0]+currentData.admin.nom[0] : '🏫'}</span>`;
          deleteBtn.classList.add("hidden");
        }
      }

      function renderPage() {
        const container = document.getElementById("dynamic-content");
        const isUniv = typeEtablissement === "universite";
        const admin = currentData.admin;

        container.innerHTML = `
          <div class="mb-6">
            <h1 class="font-heading text-2xl font-bold text-slate-900 sm:text-3xl">Paramètres</h1>
            <p class="mt-1 text-sm text-slate-600">Gérez votre profil et les informations de l'établissement.</p>
          </div>

          <div class="grid gap-6 lg:grid-cols-2">
            <!-- Carte Photo Admin -->
            <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm">
              <h2 class="font-heading text-lg font-bold text-slate-900 mb-4">Photo de profil (Admin)</h2>
              <div class="flex flex-col items-center gap-4">
                <div id="admin-preview" class="flex h-20 w-20 items-center justify-center rounded-full bg-primary/10">
                  ${admin.photo ? `<img src="${admin.photo}" alt="Photo" class="h-20 w-20 rounded-full object-cover border-2 border-white shadow">` : `<span class="text-3xl font-bold text-primary">${admin.prenom[0]}${admin.nom[0]}</span>`}
                </div>
                <div class="w-full space-y-3">
                  <div>
                    <label class="block text-sm font-medium text-slate-700">Importer une photo</label>
                    <input type="file" id="admin-photo-file" accept="image/*" class="w-full text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-primary/10 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-primary">
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-slate-700">ou URL</label>
                    <input type="url" id="admin-photo-url" placeholder="https://..." class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm">
                  </div>
                  <div class="flex gap-2">
                    <button type="button" id="admin-btn-update" class="action-button flex-1 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primaryDark">Appliquer</button>
                    <button type="button" id="admin-btn-delete" class="action-button rounded-xl border border-danger bg-white px-4 py-2 text-sm font-semibold text-danger hover:bg-danger/5 ${admin.photo ? '' : 'hidden'}">Supprimer</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Carte Photo École -->
            <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm">
              <h2 class="font-heading text-lg font-bold text-slate-900 mb-4">Logo / Photo de l'établissement</h2>
              <div class="flex flex-col items-center gap-4">
                <div id="school-preview" class="flex h-20 w-20 items-center justify-center rounded-full bg-primary/10">
                  ${currentData.schoolPhoto ? `<img src="${currentData.schoolPhoto}" alt="Logo" class="h-20 w-20 rounded-full object-cover border-2 border-white shadow">` : `<span class="text-3xl font-bold text-primary">🏫</span>`}
                </div>
                <div class="w-full space-y-3">
                  <div>
                    <label class="block text-sm font-medium text-slate-700">Importer une photo</label>
                    <input type="file" id="school-photo-file" accept="image/*" class="w-full text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-primary/10 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-primary">
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-slate-700">ou URL</label>
                    <input type="url" id="school-photo-url" placeholder="https://..." class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm">
                  </div>
                  <div class="flex gap-2">
                    <button type="button" id="school-btn-update" class="action-button flex-1 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primaryDark">Appliquer</button>
                    <button type="button" id="school-btn-delete" class="action-button rounded-xl border border-danger bg-white px-4 py-2 text-sm font-semibold text-danger hover:bg-danger/5 ${currentData.schoolPhoto ? '' : 'hidden'}">Supprimer</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Carte Informations Admin -->
            <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm">
              <h2 class="font-heading text-lg font-bold text-slate-900 mb-4">Administrateur</h2>
              <div class="space-y-3">
                <div>
                  <label class="text-xs font-semibold uppercase text-slate-500">Nom complet</label>
                  <p class="text-base font-medium">${admin.prenom} ${admin.nom}</p>
                </div>
                <div>
                  <label class="text-xs font-semibold uppercase text-slate-500">Email</label>
                  <p class="text-base font-medium">${admin.email}</p>
                </div>
                <div>
                  <label class="text-xs font-semibold uppercase text-slate-500">Rôle</label>
                  <p class="text-base font-medium">Administrateur principal</p>
                </div>
                <div class="pt-3 border-t border-slate-100 text-xs text-slate-500">
                  <svg class="inline-block h-4 w-4 mr-1 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                  Le mot de passe ne peut pas être modifié ici.
                </div>
              </div>
            </div>

            <!-- Carte Informations Établissement -->
            <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm">
              <h2 class="font-heading text-lg font-bold text-slate-900 mb-4">${isUniv ? "Université" : "Établissement"}</h2>
              <form id="config-ecole-form" class="space-y-4">
                <div>
                  <label class="block text-sm font-medium text-slate-700">Nom</label>
                  <input type="text" id="config-school-name" value="${escapeHtml(currentData.schoolName)}" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
                </div>
                <div>
                  <label class="block text-sm font-medium text-slate-700">Type</label>
                  <select id="config-school-type" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
                    <option value="college" ${typeEtablissement === "college" ? "selected" : ""}>Collège</option>
                    <option value="universite" ${typeEtablissement === "universite" ? "selected" : ""}>Université</option>
                  </select>
                </div>
                <div>
                  <label class="block text-sm font-medium text-slate-700">Localisation</label>
                  <input type="text" id="config-school-location" value="${escapeHtml(currentData.schoolLocation)}" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
                </div>
                <div>
                  <label class="block text-sm font-medium text-slate-700">Année scolaire</label>
                  <input type="text" id="config-school-year" value="${escapeHtml(currentData.schoolYear)}" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
                </div>
                <button type="submit" class="action-button w-full rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primaryDark">Enregistrer les modifications</button>
              </form>
            </div>
          </div>
        `;

        // Gestion des photos Admin
        const adminFile = document.getElementById("admin-photo-file");
        const adminUrl = document.getElementById("admin-photo-url");
        const adminUpdate = document.getElementById("admin-btn-update");
        const adminDelete = document.getElementById("admin-btn-delete");

        adminFile.addEventListener("change", () => { adminUrl.value = ""; updatePhotoPreview('admin', currentData.admin.photo); });
        adminUrl.addEventListener("input", () => { adminFile.value = ""; updatePhotoPreview('admin', currentData.admin.photo); });
        adminUpdate.addEventListener("click", () => {
          let newPhoto = null;
          if (adminFile.files && adminFile.files[0]) {
            const reader = new FileReader();
            reader.onload = e => { saveAdminPhoto(e.target.result); };
            reader.readAsDataURL(adminFile.files[0]);
          } else if (adminUrl.value.trim()) {
            saveAdminPhoto(adminUrl.value.trim());
          }
        });
        adminDelete.addEventListener("click", () => {
          currentData.admin.photo = null;
          localStorage.removeItem("adminPhoto");
          updateHeaderFooter();
          renderPage();
          showToast("Photo admin supprimée");
        });
        function saveAdminPhoto(photoData) {
          currentData.admin.photo = photoData;
          localStorage.setItem("adminPhoto", photoData);
          updateHeaderFooter();
          renderPage();
          showToast("Photo admin mise à jour");
        }

        // Gestion des photos École
        const schoolFile = document.getElementById("school-photo-file");
        const schoolUrl = document.getElementById("school-photo-url");
        const schoolUpdate = document.getElementById("school-btn-update");
        const schoolDelete = document.getElementById("school-btn-delete");

        schoolFile.addEventListener("change", () => { schoolUrl.value = ""; updatePhotoPreview('school', currentData.schoolPhoto); });
        schoolUrl.addEventListener("input", () => { schoolFile.value = ""; updatePhotoPreview('school', currentData.schoolPhoto); });
        schoolUpdate.addEventListener("click", () => {
          let newPhoto = null;
          if (schoolFile.files && schoolFile.files[0]) {
            const reader = new FileReader();
            reader.onload = e => { saveSchoolPhoto(e.target.result); };
            reader.readAsDataURL(schoolFile.files[0]);
          } else if (schoolUrl.value.trim()) {
            saveSchoolPhoto(schoolUrl.value.trim());
          }
        });
        schoolDelete.addEventListener("click", () => {
          currentData.schoolPhoto = null;
          localStorage.removeItem("schoolPhoto");
          renderPage();
          showToast("Photo école supprimée");
        });
        function saveSchoolPhoto(photoData) {
          currentData.schoolPhoto = photoData;
          localStorage.setItem("schoolPhoto", photoData);
          renderPage();
          showToast("Photo école mise à jour");
        }

        // Initialiser les aperçus
        updatePhotoPreview('admin', currentData.admin.photo);
        updatePhotoPreview('school', currentData.schoolPhoto);

        // Formulaire infos école
        const form = document.getElementById("config-ecole-form");
        form.addEventListener("submit", (e) => {
          e.preventDefault();
          const newSchoolName = document.getElementById("config-school-name").value.trim();
          const newType = document.getElementById("config-school-type").value;
          const newLocation = document.getElementById("config-school-location").value.trim();
          const newYear = document.getElementById("config-school-year").value.trim();

          if (!newSchoolName || !newLocation || !newYear) {
            showToast("Veuillez remplir tous les champs", true);
            return;
          }

          currentData.schoolName = newSchoolName;
          currentData.schoolLocation = newLocation;
          currentData.schoolYear = newYear;

          localStorage.setItem("customSchoolName", newSchoolName);
          localStorage.setItem("customSchoolLocation", newLocation);
          localStorage.setItem("customSchoolYear", newYear);
          localStorage.setItem("lastConfigUpdate", new Date().toLocaleDateString("fr-FR"));

          if (newType !== typeEtablissement) {
            setType(newType);
          } else {
            updateHeaderFooter();
            renderPage();
          }
          showToast("Configuration enregistrée");
        });
      }

      function init() {
        updateHeaderFooter();
        renderPage();
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
