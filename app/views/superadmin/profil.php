<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mon profil | EduManager</title>
  <meta name="description" content="Modification de mon profil sur EduManager">

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: "#7300e9",
            accent: "#99fbe3"
          },
          fontFamily: {
            heading: ["Quicksand", "sans-serif"],
            body: ["Outfit", "sans-serif"]
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
      transition: background-color 0.15s ease, color 0.15s ease;
    }
    .sidebar-link:hover {
      background-color: rgba(255, 255, 255, 0.1);
    }
    .sidebar-link.active {
      background-color: rgba(153, 251, 227, 0.18);
      color: #99fbe3;
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
    .modal-overlay {
      pointer-events: none;
      opacity: 0;
      transition: opacity 0.2s ease;
    }
    .modal-overlay.is-open {
      pointer-events: auto;
      opacity: 1;
    }
    .modal-content {
      transform: scale(0.95);
      transition: transform 0.2s ease;
    }
    .modal-overlay.is-open .modal-content {
      transform: scale(1);
    }
    .settings-card {
      transition: all 0.2s ease;
    }
    .settings-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px -8px rgba(115, 0, 233, 0.1);
    }
  </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">
  <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden" aria-hidden="true"></div>

  <!-- SIDEBAR – IDENTIQUE (avec ajout lien "Mon profil") -->
  <aside id="sidebar" class="fixed left-0 top-0 z-50 flex h-full w-[260px] -translate-x-full flex-col bg-gradient-to-b from-primary to-[#5a00b8] text-white shadow-2xl transition-transform duration-200 lg:translate-x-0">
    <div class="flex h-16 items-center gap-3 border-b border-white/15 px-4">
      <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white/10 text-white transition group-hover:rotate-6">
        <svg width="30px" height="30px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="none" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.16"></g><g id="SVGRepo_iconCarrier"> <path d="m14.25 9.25v-3.25l-6.25-3.25-6.25 3.25 6.25 3.25 3.25-1.5v3.5c0 1-1.5 2-3.25 2s-3.25-1-3.25-2v-3.5"></path> </g></svg>
      </span>
      <div>
        <span class="font-heading block text-sm font-bold">EduManager</span>
        <span class="text-[10px] uppercase tracking-wider text-white/70">Super admin</span>
      </div>
    </div>

    <nav class="flex-1 space-y-0.5 overflow-y-auto px-2 py-4 text-sm" aria-label="Navigation">
      <a href="dashboard_superadmin.php" class="sidebar-link active flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h3A2.25 2.25 0 0 1 11.25 6v3A2.25 2.25 0 0 1 9 11.25H6A2.25 2.25 0 0 1 3.75 9V6Z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6A2.25 2.25 0 0 1 15.75 3.75h3A2.25 2.25 0 0 1 21 6v3A2.25 2.25 0 0 1 18.75 11.25h-3A2.25 2.25 0 0 1 13.5 9V6Z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 15A2.25 2.25 0 0 1 6 12.75h3A2.25 2.25 0 0 1 11.25 15v3A2.25 2.25 0 0 1 9 20.25H6A2.25 2.25 0 0 1 3.75 18v-3Z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 15A2.25 2.25 0 0 1 15.75 12.75h3A2.25 2.25 0 0 1 21 15v3A2.25 2.25 0 0 1 18.75 20.25h-3A2.25 2.25 0 0 1 13.5 18v-3Z" />
        </svg>
        Dashboard
      </a>
      <a href="etablissements.php" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5V8.25L12 4l8 4.25V19.5" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 19.5V12h6v7.5" />
        </svg>
        Établissements
      </a>
      <a href="users.php" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 20a8 8 0 0 1 15.659-2.165" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Z" />
        </svg>
        Utilisateurs
      </a>
      <a href="students.php" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 20a8 8 0 0 1 15.659-2.165" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Z" />
        </svg>
        Élèves
      </a>
      <a href="classes.php" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 20a8 8 0 0 1 15.659-2.165" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Z" />
        </svg>
        Classes
      </a>
      <a href="notes.php" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 20a8 8 0 0 1 15.659-2.165" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Z" />
        </svg>
        Notes
      </a>
      <a href="stats.php" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M7 16v-5M12 16V8m5 8V11" />
        </svg>
        Statistiques globales
      </a>
      <a href="profil.php" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M7 16v-5M12 16V8m5 8V11" />
        </svg>
        Mon compte
      </a>
      <a href="settings.php" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 3.084-1.756 3.51 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 3.084 0 3.51a1.724 1.724 0 0 0-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0-2.572 1.065c-.426 1.756-3.084 1.756-3.51 0a1.724 1.724 0 0 0-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0-1.065-2.572c-1.756-.426-1.756-3.084 0-3.51a1.724 1.724 0 0 0 1.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065Z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
        </svg>
        Paramètres systèmes
      </a>
      <div class="mt-6 border-t border-white/15 pt-4">
        <a href="login.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 text-red-200 hover:bg-red-500/20 hover:text-white">
          <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
          </svg>
          Déconnexion
        </a>
      </div>
    </nav>
  </aside>

  <div class="min-h-screen lg:pl-[260px]">
    <!-- HEADER IDENTIQUE -->
    <header class="sticky top-0 z-30 flex h-16 items-center gap-4 border-b border-slate-200/90 bg-white px-4 shadow-sm backdrop-blur-sm sm:px-6">
      <button type="button" id="btn-menu" class="inline-flex rounded-xl border border-slate-200 p-2 text-slate-700 hover:bg-slate-50 lg:hidden" aria-label="Ouvrir le menu">
        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
      </button>

      <div class="relative min-w-0 flex-1">
        <label for="global-search" class="sr-only">Rechercher...</label>
        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" /></svg>
        </span>
        <input id="global-search" type="search" placeholder="Rechercher..."
          class="w-full max-w-xl rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-4 text-sm text-slate-900 outline-none transition focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20">
      </div>

      <div class="flex shrink-0 items-center gap-3">
        <span class="hidden rounded-full border border-primary/15 bg-violet-50 px-3 py-1 text-xs font-semibold text-primary md:inline-flex">Plateforme</span>
        <button type="button" class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-2 py-1.5 pr-3 shadow-sm transition hover:border-primary/30">
          <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-primary/10 text-sm font-bold text-primary">SN</span>
          <span class="hidden text-left text-sm lg:block">
            <span class="block font-medium text-slate-900">Sèdjro Nazaire</span>
            <span class="text-xs text-slate-500">Super administrateur</span>
          </span>
        </button>
      </div>
    </header>

    <main class="px-4 py-6 sm:px-6 lg:px-8">
      <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
        <div>
          <h1 class="font-heading text-2xl font-bold text-slate-900 sm:text-3xl">Mon profil</h1>
          <p class="mt-1 text-sm text-slate-600">Consultez et modifiez vos informations personnelles</p>
        </div>
      </div>

      <!-- Carte informations générales + formulaire -->
      <div class="mt-8 grid gap-6 lg:grid-cols-2">
        <!-- Carte Informations actuelles -->
        <div class="settings-card rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm sm:p-6">
          <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10 text-primary">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
              </svg>
            </div>
            <h2 class="font-heading text-lg font-bold text-slate-900">Informations actuelles</h2>
          </div>
          <div class="mt-4 space-y-3">
            <div>
              <label class="block text-xs font-semibold uppercase text-slate-500">Nom complet</label>
              <p class="mt-1 text-slate-900 font-medium" id="display-name">Sèdjro Nazaire</p>
            </div>
            <div>
              <label class="block text-xs font-semibold uppercase text-slate-500">Email</label>
              <p class="mt-1 text-slate-900" id="display-email">sedjro.nazaire@edumanager.com</p>
            </div>
            <div>
              <label class="block text-xs font-semibold uppercase text-slate-500">Rôle</label>
              <p class="mt-1 inline-flex items-center gap-1.5 rounded-full bg-primary/10 px-2.5 py-0.5 text-xs font-semibold text-primary">Super administrateur</p>
            </div>
          </div>
        </div>

        <!-- Carte Formulaire de modification -->
        <div class="settings-card rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm sm:p-6">
          <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10 text-primary">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
              </svg>
            </div>
            <h2 class="font-heading text-lg font-bold text-slate-900">Modifier mes informations</h2>
          </div>
          <form id="profile-form" class="mt-4 space-y-4">
            <div>
              <label class="mb-1 block text-sm font-medium text-slate-700">Nom complet</label>
              <input type="text" id="edit-name" value="Sèdjro Nazaire" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
            </div>
            <div>
              <label class="mb-1 block text-sm font-medium text-slate-700">Email</label>
              <input type="email" id="edit-email" value="sedjro.nazaire@edumanager.com" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
            </div>
            <div class="pt-2">
              <button type="submit" class="rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90">Mettre à jour</button>
            </div>
          </form>
        </div>

        <!-- Carte Sécurité (mot de passe) -->
        <div class="settings-card rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm sm:p-6 lg:col-span-2">
          <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10 text-primary">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
              </svg>
            </div>
            <h2 class="font-heading text-lg font-bold text-slate-900">Sécurité</h2>
          </div>
          <div class="mt-4">
            <p class="text-sm text-slate-600">Modifiez votre mot de passe régulièrement pour protéger votre compte.</p>
            <button id="btn-change-password" type="button" class="mt-4 rounded-xl border border-primary/30 bg-white px-4 py-2 text-sm font-semibold text-primary transition hover:bg-primary/5">Changer le mot de passe</button>
          </div>
        </div>
      </div>

      <footer class="mt-12 pb-8 text-center text-xs text-slate-400">
        EduManager Super Admin · Mon profil
      </footer>
    </main>
  </div>

  <!-- MODALE CHANGEMENT MOT DE PASSE -->
  <div id="password-modal" class="modal-overlay fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4" style="pointer-events: none; opacity: 0;">
    <div class="modal-content w-full max-w-md rounded-2xl bg-white shadow-2xl">
      <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
        <h2 class="font-heading text-xl font-bold text-slate-900">Changer le mot de passe</h2>
        <button id="close-password-modal" type="button" class="rounded-lg p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-600">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <form id="password-form" class="p-6">
        <div class="mb-4">
          <label class="mb-1 block text-sm font-medium text-slate-700">Mot de passe actuel</label>
          <input type="password" id="current-password" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
        </div>
        <div class="mb-4">
          <label class="mb-1 block text-sm font-medium text-slate-700">Nouveau mot de passe</label>
          <input type="password" id="new-password" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
        </div>
        <div class="mb-6">
          <label class="mb-1 block text-sm font-medium text-slate-700">Confirmer le nouveau mot de passe</label>
          <input type="password" id="confirm-password" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
        </div>
        <div class="flex gap-3">
          <button type="submit" class="flex-1 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90">Modifier</button>
          <button type="button" id="cancel-password" class="flex-1 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Annuler</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    (function () {
      // Données utilisateur (simulées)
      let user = {
        name: "Sèdjro Nazaire",
        email: "sedjro.nazaire@edumanager.com",
        role: "Super administrateur"
      };

      // Éléments DOM
      const displayName = document.getElementById("display-name");
      const displayEmail = document.getElementById("display-email");
      const editName = document.getElementById("edit-name");
      const editEmail = document.getElementById("edit-email");
      const profileForm = document.getElementById("profile-form");
      const btnChangePassword = document.getElementById("btn-change-password");
      const passwordModal = document.getElementById("password-modal");
      const closePasswordModal = document.getElementById("close-password-modal");
      const cancelPassword = document.getElementById("cancel-password");
      const passwordForm = document.getElementById("password-form");

      // Mettre à jour l'affichage des informations
      function updateDisplay() {
        displayName.textContent = user.name;
        displayEmail.textContent = user.email;
        editName.value = user.name;
        editEmail.value = user.email;
      }

      // Sauvegarde du profil
      profileForm.addEventListener("submit", (e) => {
        e.preventDefault();
        const newName = editName.value.trim();
        const newEmail = editEmail.value.trim();
        if (!newName || !newEmail) {
          alert("Veuillez remplir tous les champs.");
          return;
        }
        user.name = newName;
        user.email = newEmail;
        updateDisplay();
        alert("Informations mises à jour avec succès.");
      });

      // Ouverture modale mot de passe
      function openPasswordModal() {
        passwordModal.style.pointerEvents = "auto";
        passwordModal.style.opacity = "1";
        document.body.style.overflow = "hidden";
      }
      function closePasswordModalFn() {
        passwordModal.style.pointerEvents = "none";
        passwordModal.style.opacity = "0";
        document.body.style.overflow = "";
        // Réinitialiser le formulaire
        document.getElementById("current-password").value = "";
        document.getElementById("new-password").value = "";
        document.getElementById("confirm-password").value = "";
      }
      btnChangePassword.addEventListener("click", openPasswordModal);
      closePasswordModal.addEventListener("click", closePasswordModalFn);
      cancelPassword.addEventListener("click", closePasswordModalFn);
      passwordModal.addEventListener("click", (e) => { if (e.target === passwordModal) closePasswordModalFn(); });

      // Soumission changement mot de passe
      passwordForm.addEventListener("submit", (e) => {
        e.preventDefault();
        const currentPwd = document.getElementById("current-password").value;
        const newPwd = document.getElementById("new-password").value;
        const confirmPwd = document.getElementById("confirm-password").value;
        if (!currentPwd || !newPwd || !confirmPwd) {
          alert("Veuillez remplir tous les champs.");
          return;
        }
        if (newPwd !== confirmPwd) {
          alert("Les nouveaux mots de passe ne correspondent pas.");
          return;
        }
        // Ici, normalement appel API pour vérifier l'ancien mot de passe et changer
        // Simulation : on considère que l'ancien mot de passe est "admin123" pour l'exemple
        if (currentPwd !== "admin123") {
          alert("Mot de passe actuel incorrect.");
          return;
        }
        alert("Mot de passe modifié avec succès (simulation).");
        closePasswordModalFn();
      });

      // Sidebar / menu mobile (identique)
      const sidebar = document.getElementById("sidebar");
      const overlay = document.getElementById("sidebar-overlay");
      const btnMenu = document.getElementById("btn-menu");
      function openMenu() {
        sidebar.classList.remove("-translate-x-full");
        overlay.classList.add("is-open");
        document.body.style.overflow = "hidden";
      }
      function closeMenu() {
        sidebar.classList.add("-translate-x-full");
        overlay.classList.remove("is-open");
        document.body.style.overflow = "";
      }
      if (btnMenu) btnMenu.addEventListener("click", openMenu);
      if (overlay) overlay.addEventListener("click", closeMenu);
      window.addEventListener("resize", function () { if (window.innerWidth >= 1024) closeMenu(); });

      // Petite recherche inutile pour la cohérence (ne fait rien)
      const searchInput = document.getElementById("global-search");
      if (searchInput) {
        searchInput.addEventListener("input", () => {
          // Aucune fonctionnalité de recherche sur cette page
        });
      }

      updateDisplay();
    })();
  </script>
</body>
</html>
