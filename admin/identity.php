<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Identité & Contact | EduManager</title>
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
    /* Modale de confirmation */
    .modal-overlay { pointer-events: none; opacity: 0; transition: opacity 0.2s ease; position: fixed; inset: 0; z-index: 9999; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; }
    .modal-overlay.is-open { pointer-events: auto; opacity: 1; }
    .modal-content { transform: scale(0.95); transition: transform 0.2s ease; max-width: 90%; width: 28rem; background: white; border-radius: 1rem; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); }
    .modal-overlay.is-open .modal-content { transform: scale(1); }
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
          <a href="identite.html" class="sidebar-link active mt-1 block rounded-lg py-2 pl-10 pr-3">Identité & contact</a>
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

  <!-- Modale de confirmation pour suppression -->
  <div id="confirm-modal" class="modal-overlay">
    <div class="modal-content bg-white rounded-2xl shadow-2xl p-6">
      <div class="flex justify-between items-center mb-4">
        <h3 class="font-heading text-xl font-bold text-slate-900">Confirmation</h3>
        <button id="close-confirm-modal" class="text-slate-400 hover:text-slate-600">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>
      <div id="confirm-body" class="text-slate-700">Êtes-vous sûr de vouloir supprimer le logo ?</div>
      <div class="mt-6 flex gap-3 justify-end">
        <button id="confirm-cancel" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700">Annuler</button>
        <button id="confirm-ok" class="rounded-xl bg-red-600 px-4 py-2 text-sm font-semibold text-white">Supprimer</button>
      </div>
    </div>
  </div>

  <div id="toast" class="toast"></div>

  <script>
    // ==================== DONNÉES DE BASE ====================
    const collegeData = {
      schoolName: "Collège Saint-Michel",
      schoolLocation: "Cotonou, Bénin",
      address: "12 Avenue Jean-Paul II",
      city: "Cotonou",
      country: "Bénin",
      phone: "+229 21 30 00 00",
      email: "contact@csm.edu",
      logo: null
    };
    const universityData = {
      schoolName: "Université d'Abomey-Calavi",
      schoolLocation: "Abomey-Calavi, Bénin",
      address: "Campus Universitaire",
      city: "Abomey-Calavi",
      country: "Bénin",
      phone: "+229 21 30 20 20",
      email: "contact@uac.bj",
      logo: null
    };

    let typeEtablissement = "college";
    let currentData = JSON.parse(JSON.stringify(collegeData));

    // Charger depuis localStorage si existant
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

    // Charger les données sauvegardées de l'identité
    const savedAddress = localStorage.getItem("schoolAddress");
    const savedCity = localStorage.getItem("schoolCity");
    const savedCountry = localStorage.getItem("schoolCountry");
    const savedPhone = localStorage.getItem("schoolPhone");
    const savedEmailContact = localStorage.getItem("schoolEmailContact");
    if (savedAddress) currentData.address = savedAddress;
    if (savedCity) currentData.city = savedCity;
    if (savedCountry) currentData.country = savedCountry;
    if (savedPhone) currentData.phone = savedPhone;
    if (savedEmailContact) currentData.email = savedEmailContact;

    // Mettre à jour l'affichage du header
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
      // Recharger les valeurs sauvegardées
      const savedAddress = localStorage.getItem("schoolAddress");
      const savedCity = localStorage.getItem("schoolCity");
      const savedCountry = localStorage.getItem("schoolCountry");
      const savedPhone = localStorage.getItem("schoolPhone");
      const savedEmailContact = localStorage.getItem("schoolEmailContact");
      if (savedAddress) currentData.address = savedAddress;
      if (savedCity) currentData.city = savedCity;
      if (savedCountry) currentData.country = savedCountry;
      if (savedPhone) currentData.phone = savedPhone;
      if (savedEmailContact) currentData.email = savedEmailContact;
      updateHeaderFooter();
      renderIdentitePage();
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

    function showToast(message, type = "success") {
      const toast = document.getElementById("toast");
      toast.innerText = message;
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

    // Gestion de la modale de confirmation
    const confirmModal = document.getElementById("confirm-modal");
    const closeConfirmModalBtn = document.getElementById("close-confirm-modal");
    const confirmCancelBtn = document.getElementById("confirm-cancel");
    const confirmOkBtn = document.getElementById("confirm-ok");
    let pendingDeleteCallback = null;

    function openConfirmModal(message, onConfirm) {
      document.getElementById("confirm-body").innerHTML = message;
      confirmModal.classList.add("is-open");
      document.body.style.overflow = "hidden";
      pendingDeleteCallback = onConfirm;
    }

    function closeConfirmModal() {
      confirmModal.classList.remove("is-open");
      document.body.style.overflow = "";
      pendingDeleteCallback = null;
    }

    closeConfirmModalBtn.addEventListener("click", closeConfirmModal);
    confirmCancelBtn.addEventListener("click", closeConfirmModal);
    confirmModal.addEventListener("click", (e) => { if (e.target === confirmModal) closeConfirmModal(); });
    confirmOkBtn.addEventListener("click", () => {
      if (pendingDeleteCallback) {
        pendingDeleteCallback();
        closeConfirmModal();
      }
    });

    // Rendu de la page Identité & Contact
    function renderIdentitePage() {
      const container = document.getElementById("dynamic-content");
      if (!container) return;

      const isUniv = typeEtablissement === "universite";
      const currentSchoolName = currentData.schoolName;

      container.innerHTML = `
        <div class="mb-6">
          <h1 class="font-heading text-2xl font-bold text-slate-900 sm:text-3xl">Identité & Contact</h1>
          <p class="mt-1 text-sm text-slate-600">Informations de contact et localisation – ${isUniv ? "Université" : "Collège"}</p>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
          <!-- Formulaire principal -->
          <div class="lg:col-span-2 settings-card rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm sm:p-6">
            <h2 class="font-heading text-lg font-bold text-slate-900">Coordonnées</h2>
            <form id="identite-form" class="mt-4 space-y-4">
              <div>
                <label class="block text-sm font-medium text-slate-700">Adresse</label>
                <input type="text" id="school-address" value="${escapeHtml(currentData.address)}" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
              </div>
              <div class="grid grid-cols-2 gap-3">
                <div>
                  <label class="block text-sm font-medium text-slate-700">Ville</label>
                  <input type="text" id="school-city" value="${escapeHtml(currentData.city)}" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
                </div>
                <div>
                  <label class="block text-sm font-medium text-slate-700">Pays</label>
                  <input type="text" id="school-country" value="${escapeHtml(currentData.country)}" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
                </div>
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700">Téléphone</label>
                <input type="tel" id="school-phone" value="${escapeHtml(currentData.phone)}" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700">Email de contact</label>
                <input type="email" id="school-email-contact" value="${escapeHtml(currentData.email)}" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
              </div>
              <button type="submit" class="action-button rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primaryDark">Enregistrer les modifications</button>
            </form>
          </div>

          <!-- Carte d'information et logo -->
          <div class="settings-card rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm sm:p-6">
            <h2 class="font-heading text-lg font-bold text-slate-900">Logo & identité visuelle</h2>
            <div class="mt-4 flex flex-col items-center">
              <div id="logo-preview" class="mb-4 flex h-32 w-32 items-center justify-center rounded-xl bg-slate-100 border border-slate-200 overflow-hidden">
                <svg class="h-16 w-16 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 19.5V8.25L12 4l8 4.25V19.5"/><path d="M9 19.5V12h6v7.5"/></svg>
              </div>
              <div class="flex flex-wrap gap-3 justify-center">
                <label class="action-button cursor-pointer rounded-xl bg-white border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition-all">
                  Changer le logo
                  <input type="file" id="logo-upload" accept="image/*" class="hidden">
                </label>
                <button id="btn-delete-logo" class="action-button rounded-xl bg-red-50 border border-red-200 px-4 py-2 text-sm font-semibold text-red-700 shadow-sm hover:bg-red-100 transition-all">
                  Supprimer le logo
                </button>
              </div>
              <p class="mt-3 text-xs text-slate-500">Format PNG, JPG (max 2Mo)</p>
            </div>
            <div class="mt-6 rounded-xl bg-slate-50 p-3 text-xs text-slate-500">
              <svg class="inline-block h-4 w-4 mr-1 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
              Les informations de contact seront affichées sur les bulletins et documents officiels.
            </div>
          </div>
        </div>

        <!-- Carte récapitulative des infos -->
        <div class="mt-6 grid gap-4 sm:grid-cols-2">
          <div class="kpi-card rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm" style="border-left-color: #7300e9;">
            <p class="text-xs font-semibold uppercase text-slate-500">Adresse complète</p>
            <p class="text-sm font-medium text-slate-800 mt-1">${escapeHtml(currentData.address)}, ${escapeHtml(currentData.city)}, ${escapeHtml(currentData.country)}</p>
          </div>
          <div class="kpi-card rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm" style="border-left-color: #99fbe3;">
            <p class="text-xs font-semibold uppercase text-slate-500">Contact</p>
            <p class="text-sm font-medium text-slate-800 mt-1">📞 ${escapeHtml(currentData.phone)} &nbsp;|&nbsp; ✉️ ${escapeHtml(currentData.email)}</p>
          </div>
        </div>
      `;

      // Gestion du formulaire
      const form = document.getElementById("identite-form");
      if (form) {
        form.addEventListener("submit", (e) => {
          e.preventDefault();
          const address = document.getElementById("school-address").value.trim();
          const city = document.getElementById("school-city").value.trim();
          const country = document.getElementById("school-country").value.trim();
          const phone = document.getElementById("school-phone").value.trim();
          const emailContact = document.getElementById("school-email-contact").value.trim();

          if (!address || !city || !country || !phone || !emailContact) {
            showToast("Veuillez remplir tous les champs", "error");
            return;
          }

          // Mise à jour des données
          currentData.address = address;
          currentData.city = city;
          currentData.country = country;
          currentData.phone = phone;
          currentData.email = emailContact;
          // Sauvegarde dans localStorage
          localStorage.setItem("schoolAddress", address);
          localStorage.setItem("schoolCity", city);
          localStorage.setItem("schoolCountry", country);
          localStorage.setItem("schoolPhone", phone);
          localStorage.setItem("schoolEmailContact", emailContact);

          // Mettre à jour le header si la localisation change
          const fullLocation = `${city}, ${country}`;
          document.getElementById("school-location").innerText = fullLocation;
          currentData.schoolLocation = fullLocation;
          localStorage.setItem("customSchoolLocation", fullLocation);

          showToast("Informations enregistrées avec succès");
          renderIdentitePage();
        });
      }

      // Upload de logo
      const logoInput = document.getElementById("logo-upload");
      const logoPreview = document.getElementById("logo-preview");
      if (logoInput) {
        logoInput.addEventListener("change", (e) => {
          const file = e.target.files[0];
          if (file && file.type.startsWith("image/")) {
            const reader = new FileReader();
            reader.onload = (ev) => {
              const img = document.createElement("img");
              img.src = ev.target.result;
              img.className = "h-full w-full object-cover";
              logoPreview.innerHTML = "";
              logoPreview.appendChild(img);
              localStorage.setItem("schoolLogo", ev.target.result);
              showToast("Logo mis à jour");
            };
            reader.readAsDataURL(file);
          } else {
            showToast("Veuillez sélectionner une image valide", "error");
          }
        });
      }

      // Suppression du logo (avec modale, pas de confirm)
      const deleteBtn = document.getElementById("btn-delete-logo");
      if (deleteBtn) {
        deleteBtn.addEventListener("click", () => {
          openConfirmModal("Voulez-vous vraiment supprimer le logo ?", () => {
            logoPreview.innerHTML = `<svg class="h-16 w-16 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 19.5V8.25L12 4l8 4.25V19.5"/><path d="M9 19.5V12h6v7.5"/></svg>`;
            localStorage.removeItem("schoolLogo");
            showToast("Logo supprimé");
          });
        });
      }

      // Restaurer le logo s'il existe
      const savedLogo = localStorage.getItem("schoolLogo");
      if (savedLogo && logoPreview) {
        const img = document.createElement("img");
        img.src = savedLogo;
        img.className = "h-full w-full object-cover";
        logoPreview.innerHTML = "";
        logoPreview.appendChild(img);
      }
    }

    // ==================== INITIALISATION ====================
    function init() {
      updateHeaderFooter();
      renderIdentitePage();
      updateSwitchButtons();

      // Boutons de switch
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

      // Sous-menus
      document.querySelectorAll(".sidebar-toggle").forEach(btn => {
        const id = btn.getAttribute("data-submenu");
        const panel = document.getElementById(id);
        const chev = btn.querySelector(".chevron");
        if (panel) btn.addEventListener("click", () => { const open = panel.classList.toggle("open"); if (chev) chev.style.transform = open ? "rotate(180deg)" : ""; });
      });

      // Date de mise à jour
      document.getElementById("last-update").innerText = new Date().toLocaleTimeString("fr-FR");
    }

    init();
  </script>
</body>
</html>
