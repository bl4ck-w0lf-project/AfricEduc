<?php
/**
 * Vue création d'un élève
 * @var string $title Titre de la page
 */
$title = $title ?? 'Ajouter un élève';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($title) ?> | EduManager</title>
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
    .form-input:focus { border-color: #7300e9; ring-color: #7300e9; }
    .toast { position: fixed; bottom: 20px; right: 20px; background: #1e293b; color: white; padding: 12px 20px; border-radius: 12px; font-size: 0.875rem; z-index: 10000; opacity: 0; transition: opacity 0.3s; pointer-events: none; }
    .toast.show { opacity: 1; }
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 text-slate-800 antialiased">
  <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden"></div>

  <!-- Sidebar (identique à index.php) -->
  <aside id="sidebar" class="fixed left-0 top-0 z-50 flex h-full w-[260px] -translate-x-full flex-col bg-gradient-to-b from-primary to-primaryDark text-white shadow-2xl transition-transform duration-300 lg:translate-x-0">
    <div class="flex h-16 items-center gap-3 border-b border-white/20 px-4">
      <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/20 shadow-lg">
        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 6.75C4 5.78 4.78 5 5.75 5h4.5c.46 0 .9.18 1.22.51l.56.56c.33.33.77.51 1.24.51h5.98c.97 0 1.75.78 1.75 1.75v8.92c0 .97-.78 1.75-1.75 1.75H5.75A1.75 1.75 0 0 1 4 17.25V6.75Z"/><path d="M8 11.5h8M8 14.5h5"/></svg>
      </span>
      <span class="font-heading text-xl font-bold tracking-tight">EduManager</span>
    </div>
    <nav class="flex-1 overflow-y-auto px-3 py-6 text-sm">
      <a href="/dashboard" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 mb-1"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3.75 6A2.25 2.25 0 0 1 6 3.75h3A2.25 2.25 0 0 1 11.25 6v3A2.25 2.25 0 0 1 9 11.25H6A2.25 2.25 0 0 1 3.75 9V6ZM3.75 15A2.25 2.25 0 0 1 6 12.75h3A2.25 2.25 0 0 1 11.25 15v3A2.25 2.25 0 0 1 9 20.25H6A2.25 2.25 0 0 1 3.75 18v-3ZM13.5 6A2.25 2.25 0 0 1 15.75 3.75h3A2.25 2.25 0 0 1 21 6v3A2.25 2.25 0 0 1 18.75 11.25h-3A2.25 2.25 0 0 1 13.5 9V6ZM13.5 15A2.25 2.25 0 0 1 15.75 12.75h3A2.25 2.25 0 0 1 21 15v3A2.25 2.25 0 0 1 18.75 20.25h-3A2.25 2.25 0 0 1 13.5 18v-3Z"/></svg>Dashboard</a>
      <div class="mt-2"><button type="button" class="sidebar-toggle flex w-full items-center justify-between gap-2 rounded-xl px-3 py-2.5 text-left text-white/95 hover:bg-white/10" data-submenu="sub-ecole"><span class="flex items-center gap-3"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19.5V8.25L12 4l8 4.25V19.5"/><path d="M9 19.5V12h6v7.5"/></svg>Mon école</span><svg class="chevron h-4 w-4 transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg></button><div id="sub-ecole" class="submenu open pl-2"><a href="#" class="sidebar-link block rounded-lg py-2 pl-10 pr-3">Configuration</a><a href="#" class="sidebar-link block rounded-lg py-2 pl-10 pr-3">Identité & contact</a></div></div>
      <div class="mt-1"><button type="button" class="sidebar-toggle flex w-full items-center justify-between gap-2 rounded-xl px-3 py-2.5 text-left text-white/95 hover:bg-white/10" data-submenu="sub-org"><span class="flex items-center gap-3"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3.75 21h16.5M4.5 3h15A1.5 1.5 0 0 1 21 4.5v13.5A1.5 1.5 0 0 1 19.5 19.5h-15A1.5 1.5 0 0 1 4.5 18v-13.5A1.5 1.5 0 0 1 4.5 3zm4.5 4.5h3M9 12h3m-3 4.5h3M15 7.5h3M15 12h3m-3 4.5h3"/></svg>Organisation</span><svg class="chevron h-4 w-4 transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg></button><div id="sub-org" class="submenu open pl-2"><a href="#" class="sidebar-link block rounded-lg py-2 pl-10 pr-3">Classes / Groupes</a><a href="#" class="sidebar-link block rounded-lg py-2 pl-10 pr-3">Matières</a></div></div>
      <a href="/students" class="sidebar-link active flex items-center gap-3 rounded-xl px-3 py-2.5 mt-1"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 17a4 4 0 1 1 8 0"/><path d="M15 11a3 3 0 1 0-6 0 3 3 0 0 0 6 0Z"/></svg><span>Élèves</span></a>
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">Notes & Moyennes</a>
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">Scolarité & Paiements</a>
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">Agents</a>
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">Bulletins & Documents</a>
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">Statistiques</a>
      <div class="mt-8 border-t border-white/15 pt-4"><a href="/logout" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 text-red-200 hover:bg-red-500/20">Déconnexion</a></div>
    </nav>
  </aside>

  <!-- Main content -->
  <div class="min-h-screen lg:pl-[260px]">
    <header class="sticky top-0 z-30 flex h-16 items-center justify-between gap-4 border-b border-slate-200 bg-white/95 px-4 backdrop-blur-md shadow-sm sm:px-6">
      <div class="flex items-center gap-3">
        <button id="btn-menu" class="inline-flex rounded-xl border border-slate-200 p-2 text-slate-700 hover:bg-slate-50 lg:hidden"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7h16M4 12h16M4 17h16"/></svg></button>
        <div><p class="font-heading text-sm font-semibold text-primary sm:text-base">Collège Saint-Michel</p><p class="text-xs text-slate-500">Cotonou, Bénin</p></div>
      </div>
      <div class="flex items-center gap-3">
        <span class="hidden rounded-full border border-accent/50 bg-accent/20 px-3 py-1 text-xs font-medium text-slate-800 sm:inline-flex">Année 2025–2026</span>
        <button class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-2 py-1.5 pr-3 shadow-sm">
          <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-primary to-primaryDark text-sm font-bold text-white shadow-md">AK</span>
          <span class="hidden text-left text-sm sm:block"><span class="block font-medium text-slate-900">Aminata Kossi</span><span class="text-xs text-slate-500">Administratrice</span></span>
        </button>
      </div>
    </header>

    <main class="px-4 py-6 sm:px-6 lg:px-8">
      <div class="max-w-4xl mx-auto">
        <div class="mb-6">
          <h1 class="font-heading text-2xl font-bold text-slate-900 sm:text-3xl"><?= htmlspecialchars($title) ?></h1>
          <p class="mt-1 text-sm text-slate-600">Remplissez le formulaire pour ajouter un nouvel élève</p>
        </div>

        <form action="/students/store" method="POST" enctype="multipart/form-data" class="space-y-6">
          <!-- Informations personnelles -->
          <div class="rounded-2xl border border-slate-200/80 bg-white shadow-md overflow-hidden">
            <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
              <h2 class="font-heading text-lg font-semibold text-slate-900">Informations personnelles</h2>
            </div>
            <div class="p-6 space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Matricule <span class="text-red-500">*</span></label><input type="text" name="matricule" required class="form-input w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"></div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Genre <span class="text-red-500">*</span></label><select name="gender" required class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"><option value="">Sélectionner</option><option value="M">Masculin</option><option value="F">Féminin</option></select></div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Prénom <span class="text-red-500">*</span></label><input type="text" name="firstname" required class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"></div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Nom <span class="text-red-500">*</span></label><input type="text" name="lastname" required class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"></div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Date de naissance</label><input type="date" name="birthdate" class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"></div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Lieu de naissance</label><input type="text" name="birthplace" class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"></div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Nationalité</label><input type="text" name="nationality" value="Béninoise" class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"></div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Situation matrimoniale</label><select name="marital_status" class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"><option value="celibataire">Célibataire</option><option value="marie">Marié(e)</option><option value="divorce">Divorcé(e)</option><option value="veuf">Veuf/Veuve</option></select></div>
              </div>
            </div>
          </div>

          <!-- Coordonnées -->
          <div class="rounded-2xl border border-slate-200/80 bg-white shadow-md overflow-hidden">
            <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
              <h2 class="font-heading text-lg font-semibold text-slate-900">Coordonnées</h2>
            </div>
            <div class="p-6 space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Email</label><input type="email" name="email" class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"></div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Téléphone</label><input type="tel" name="phone" class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"></div>
              </div>
              <div><label class="block text-sm font-medium text-slate-700 mb-1">Adresse</label><textarea name="address" rows="2" class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"></textarea></div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Nom du parent/tuteur</label><input type="text" name="parent_name" class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"></div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Téléphone du parent</label><input type="tel" name="parent_phone" class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"></div>
              </div>
            </div>
          </div>

          <!-- Informations scolaires -->
          <div class="rounded-2xl border border-slate-200/80 bg-white shadow-md overflow-hidden">
            <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
              <h2 class="font-heading text-lg font-semibold text-slate-900">Informations scolaires</h2>
            </div>
            <div class="p-6 space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-slate-700 mb-1">ID École <span class="text-red-500">*</span></label><input type="number" name="school_id" required class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"></div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1">ID Classe</label><input type="number" name="class_id" class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"></div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Statut <span class="text-red-500">*</span></label><select name="status" required class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"><option value="actif">Actif</option><option value="inactif">Inactif</option><option value="exclu">Exclu</option><option value="diplome">Diplômé</option></select></div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Date d'inscription</label><input type="date" name="enrolled_at" class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"></div>
              </div>
              <div><label class="block text-sm font-medium text-slate-700 mb-1">Notes</label><textarea name="notes" rows="3" class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary" placeholder="Informations complémentaires..."></textarea></div>
              <div><label class="block text-sm font-medium text-slate-700 mb-1">Photo</label><input type="file" name="photo" accept="image/*" class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary file:mr-4 file:rounded-xl file:border-0 file:bg-primary/10 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-primary hover:file:bg-primary/20"></div>
            </div>
          </div>

          <!-- Actions -->
          <div class="flex justify-end gap-3">
            <a href="/students" class="rounded-xl border border-slate-200 bg-white px-6 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Annuler</a>
            <button type="submit" class="rounded-xl bg-primary px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primaryDark">Enregistrer l'élève</button>
          </div>
        </form>
      </div>
      <footer class="mt-12 pb-8 text-center text-xs text-slate-400">EduManager — Collège Saint-Michel · Formulaire d'ajout</footer>
    </main>
  </div>

  <div id="toast" class="toast"></div>

  <script>
    function showToast(msg, type) { const toast = document.getElementById("toast"); toast.innerText = msg; toast.style.backgroundColor = type === "error" ? "#ef4444" : "#10b981"; toast.classList.add("show"); setTimeout(() => toast.classList.remove("show"), 3000); }
    function init() {
      document.querySelectorAll(".sidebar-toggle").forEach(btn => { const id = btn.getAttribute("data-submenu"); const panel = document.getElementById(id); const chev = btn.querySelector(".chevron"); if (panel) btn.addEventListener("click", () => { const open = panel.classList.toggle("open"); if (chev) chev.style.transform = open ? "rotate(180deg)" : ""; }); });
      const sidebar = document.getElementById("sidebar"), overlay = document.getElementById("sidebar-overlay"), btnMenu = document.getElementById("btn-menu");
      function openMenu() { sidebar.classList.remove("-translate-x-full"); overlay.classList.add("is-open"); document.body.style.overflow = "hidden"; }
      function closeMenu() { sidebar.classList.add("-translate-x-full"); overlay.classList.remove("is-open"); document.body.style.overflow = ""; }
      btnMenu?.addEventListener("click", openMenu); overlay?.addEventListener("click", closeMenu); window.addEventListener("resize", () => { if (window.innerWidth >= 1024) closeMenu(); });
    }
    init();
  </script>
</body>
</html>
