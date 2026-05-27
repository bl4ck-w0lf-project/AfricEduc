<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Paramètres système | EduManager</title>
  <meta name="description" content="Configuration globale de la plateforme EduManager">

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
    /* Style pour les cards de configuration */
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

  <!-- SIDEBAR – IDENTIQUE AU DESIGN EXISTANT -->
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
        <label for="global-search" class="sr-only">Rechercher une configuration</label>
        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" /></svg>
        </span>
        <input id="global-search" type="search" placeholder="Rechercher un paramètre..." class="w-full max-w-xl rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-4 text-sm text-slate-900 outline-none transition focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20">
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
          <h1 class="font-heading text-2xl font-bold text-slate-900 sm:text-3xl">Paramètres système</h1>
          <p class="mt-1 text-sm text-slate-600">Configuration globale de la plateforme EduManager</p>
        </div>
        <div class="mt-2 flex items-center gap-2">
          <div class="flex h-10 items-center gap-2 rounded-xl bg-white px-3 shadow-sm">
            <svg class="h-4 w-4 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
            <span class="text-xs text-slate-500">Dernière sauvegarde :</span>
            <span id="last-save" class="text-xs font-medium text-slate-700">--/--/----</span>
          </div>
        </div>
      </div>

      <!-- Configuration générale -->
      <section class="mt-8 space-y-6">
        <!-- Carte Configuration générale -->
        <div class="settings-card rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm sm:p-6">
          <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10 text-primary">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
              </svg>
            </div>
            <h2 class="font-heading text-lg font-bold text-slate-900">Configuration générale</h2>
          </div>
          <form id="general-config-form" class="mt-4 space-y-4">
            <div>
              <label class="mb-1 block text-sm font-medium text-slate-700">Nom de l'application</label>
              <div class="flex items-center gap-2">
                <input type="text" id="app-name" value="EduManager" class="flex-1 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
                <button type="button" class="save-general rounded-lg bg-primary/10 px-3 py-2 text-sm font-semibold text-primary transition hover:bg-primary/20">Enregistrer</button>
              </div>
            </div>
            <div>
              <label class="mb-1 block text-sm font-medium text-slate-700">Email de contact (support)</label>
              <div class="flex items-center gap-2">
                <input type="email" id="contact-email" value="support@edumanager.com" class="flex-1 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
                <button type="button" class="save-general rounded-lg bg-primary/10 px-3 py-2 text-sm font-semibold text-primary transition hover:bg-primary/20">Enregistrer</button>
              </div>
            </div>
            <div>
              <label class="mb-1 block text-sm font-medium text-slate-700">Devise utilisée</label>
              <div class="flex items-center gap-2">
                <select id="currency" class="flex-1 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
                  <option value="FCFA">FCFA (XOF)</option>
                  <option value="EUR">Euro (EUR)</option>
                  <option value="USD">Dollar US (USD)</option>
                </select>
                <button type="button" class="save-general rounded-lg bg-primary/10 px-3 py-2 text-sm font-semibold text-primary transition hover:bg-primary/20">Enregistrer</button>
              </div>
            </div>
          </form>
        </div>

        <!-- Gestion des rôles -->
        <div class="settings-card rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm sm:p-6">
          <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10 text-primary">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 20a8 8 0 0 1 15.659-2.165" />
              </svg>
            </div>
            <h2 class="font-heading text-lg font-bold text-slate-900">Gestion des rôles & permissions</h2>
          </div>
          <div class="mt-4 space-y-4">
            <div class="rounded-xl border border-slate-100 bg-slate-50 p-4">
              <div class="flex items-center justify-between">
                <div>
                  <p class="font-semibold text-slate-900">Administrateur</p>
                  <p class="text-xs text-slate-500">Accès total à tous les modules</p>
                </div>
                <span class="rounded-full bg-primary/10 px-2 py-0.5 text-xs font-medium text-primary">Par défaut</span>
              </div>
            </div>
            <div class="rounded-xl border border-slate-100 bg-slate-50 p-4">
              <div class="flex items-center justify-between">
                <div>
                  <p class="font-semibold text-slate-900">Agent</p>
                  <p class="text-xs text-slate-500">Gestion limitée (élèves, notes, paiements)</p>
                </div>
                <div class="flex items-center gap-2">
                  <label class="relative inline-flex cursor-pointer items-center">
                    <input type="checkbox" class="role-permission peer sr-only" data-role="agent" data-perm="edit-students" checked>
                    <div class="h-5 w-9 rounded-full bg-slate-300 after:absolute after:left-[2px] after:top-[2px] after:h-4 after:w-4 after:rounded-full after:bg-white after:transition-all peer-checked:bg-primary peer-checked:after:translate-x-full"></div>
                    <span class="ml-2 text-xs text-slate-600">Modifier élèves</span>
                  </label>
                  <label class="relative inline-flex cursor-pointer items-center">
                    <input type="checkbox" class="role-permission peer sr-only" data-role="agent" data-perm="edit-notes" checked>
                    <div class="h-5 w-9 rounded-full bg-slate-300 after:absolute after:left-[2px] after:top-[2px] after:h-4 after:w-4 after:rounded-full after:bg-white after:transition-all peer-checked:bg-primary peer-checked:after:translate-x-full"></div>
                    <span class="ml-2 text-xs text-slate-600">Saisie notes</span>
                  </label>
                </div>
              </div>
            </div>
            <button id="save-roles" type="button" class="rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90">Enregistrer les permissions</button>
          </div>
        </div>

        <!-- Préférences générales -->
        <div class="settings-card rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm sm:p-6">
          <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10 text-primary">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 0 1 0 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 0 1-.22.128c-.331.183-.581.495-.644.87l-.213 1.28c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 0 1 0-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.355.133.75.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.87l.214-1.281Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
              </svg>
            </div>
            <h2 class="font-heading text-lg font-bold text-slate-900">Préférences générales</h2>
          </div>
          <div class="mt-4 space-y-4">
            <div class="flex items-center justify-between">
              <div>
                <p class="font-medium text-slate-900">Notifications par email</p>
                <p class="text-xs text-slate-500">Recevoir les alertes système et rapports</p>
              </div>
              <label class="relative inline-flex cursor-pointer items-center">
                <input type="checkbox" id="notif-email" class="peer sr-only" checked>
                <div class="h-6 w-11 rounded-full bg-slate-300 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all peer-checked:bg-primary peer-checked:after:translate-x-full"></div>
              </label>
            </div>
            <div class="flex items-center justify-between">
              <div>
                <p class="font-medium text-slate-900">Mode sombre</p>
                <p class="text-xs text-slate-500">Adapter l'interface au thème sombre</p>
              </div>
              <label class="relative inline-flex cursor-pointer items-center">
                <input type="checkbox" id="dark-mode" class="peer sr-only">
                <div class="h-6 w-11 rounded-full bg-slate-300 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all peer-checked:bg-primary peer-checked:after:translate-x-full"></div>
              </label>
            </div>
            <div>
              <label class="mb-1 block text-sm font-medium text-slate-700">Langue par défaut</label>
              <select id="default-lang" class="w-full max-w-xs rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
                <option value="fr">Français</option>
                <option value="en">English</option>
              </select>
            </div>
            <button id="save-preferences" type="button" class="rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90">Enregistrer les préférences</button>
          </div>
        </div>

        <!-- Sauvegarde / Export -->
        <div class="settings-card rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm sm:p-6">
          <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10 text-primary">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375 7.444 2.25 12 2.25s8.25 1.847 8.25 4.125Zm0 0v5.25m0-5.25v5.25m0 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125m0 0v-5.25" />
              </svg>
            </div>
            <h2 class="font-heading text-lg font-bold text-slate-900">Sauvegarde & maintenance</h2>
          </div>
          <div class="mt-4 flex flex-wrap gap-4">
            <button id="export-config" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:border-primary/30 hover:bg-slate-50">📥 Exporter la configuration</button>
            <button id="reset-defaults" class="rounded-xl border border-red-200 bg-red-50 px-4 py-2 text-sm font-medium text-red-700 transition hover:bg-red-100">↻ Rétablir les paramètres par défaut</button>
          </div>
        </div>
      </section>

      <footer class="mt-12 pb-8 text-center text-xs text-slate-400">
        EduManager Super Admin · Configuration système
      </footer>
    </main>
  </div>

  <script>
    (function() {
      // Éléments du DOM
      const appNameInput = document.getElementById('app-name');
      const contactEmailInput = document.getElementById('contact-email');
      const currencySelect = document.getElementById('currency');
      const saveGeneralBtns = document.querySelectorAll('.save-general');
      const saveRolesBtn = document.getElementById('save-roles');
      const savePrefsBtn = document.getElementById('save-preferences');
      const exportBtn = document.getElementById('export-config');
      const resetBtn = document.getElementById('reset-defaults');
      const notifEmailCheck = document.getElementById('notif-email');
      const darkModeCheck = document.getElementById('dark-mode');
      const defaultLangSelect = document.getElementById('default-lang');
      const lastSaveSpan = document.getElementById('last-save');

      // Fonction pour mettre à jour la date de dernière sauvegarde
      function updateLastSave() {
        const now = new Date();
        lastSaveSpan.textContent = now.toLocaleDateString('fr-FR') + ' ' + now.toLocaleTimeString('fr-FR', {hour:'2-digit', minute:'2-digit'});
      }

      // Sauvegarde configuration générale
      function saveGeneralConfig() {
        const appName = appNameInput.value.trim();
        const contactEmail = contactEmailInput.value.trim();
        const currency = currencySelect.value;
        if (!appName || !contactEmail) {
          alert('Veuillez remplir tous les champs.');
          return;
        }
        localStorage.setItem('appName', appName);
        localStorage.setItem('contactEmail', contactEmail);
        localStorage.setItem('currency', currency);
        updateLastSave();
        alert('Configuration générale enregistrée !');
      }

      // Sauvegarde permissions des rôles
      function saveRolesPermissions() {
        const permissions = {};
        document.querySelectorAll('.role-permission').forEach(cb => {
          const role = cb.dataset.role;
          const perm = cb.dataset.perm;
          if (!permissions[role]) permissions[role] = {};
          permissions[role][perm] = cb.checked;
        });
        localStorage.setItem('rolePermissions', JSON.stringify(permissions));
        updateLastSave();
        alert('Permissions des rôles enregistrées !');
      }

      // Sauvegarde préférences
      function savePreferences() {
        const notifEmail = notifEmailCheck.checked;
        const darkMode = darkModeCheck.checked;
        const lang = defaultLangSelect.value;
        localStorage.setItem('notificationsEmail', notifEmail);
        localStorage.setItem('darkMode', darkMode);
        localStorage.setItem('defaultLanguage', lang);
        updateLastSave();
        alert('Préférences générales enregistrées !');
      }

      // Exporter la configuration (simulation)
      function exportConfig() {
        const config = {
          appName: localStorage.getItem('appName') || 'EduManager',
          contactEmail: localStorage.getItem('contactEmail') || 'support@edumanager.com',
          currency: localStorage.getItem('currency') || 'FCFA',
          rolePermissions: JSON.parse(localStorage.getItem('rolePermissions') || '{}'),
          notificationsEmail: localStorage.getItem('notificationsEmail') === 'true',
          darkMode: localStorage.getItem('darkMode') === 'true',
          defaultLanguage: localStorage.getItem('defaultLanguage') || 'fr'
        };
        const dataStr = JSON.stringify(config, null, 2);
        const blob = new Blob([dataStr], {type: 'application/json'});
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'edumanager_config.json';
        a.click();
        URL.revokeObjectURL(url);
        alert('Configuration exportée avec succès !');
      }

      // Réinitialiser les paramètres par défaut
      function resetToDefaults() {
        if (!confirm('Voulez-vous vraiment rétablir tous les paramètres par défaut ? Cette action est irréversible.')) return;
        // Valeurs par défaut
        const defaultAppName = 'EduManager';
        const defaultContactEmail = 'support@edumanager.com';
        const defaultCurrency = 'FCFA';
        const defaultNotif = true;
        const defaultDark = false;
        const defaultLang = 'fr';
        // Appliquer dans les champs
        appNameInput.value = defaultAppName;
        contactEmailInput.value = defaultContactEmail;
        currencySelect.value = defaultCurrency;
        notifEmailCheck.checked = defaultNotif;
        darkModeCheck.checked = defaultDark;
        defaultLangSelect.value = defaultLang;
        // Permissions par défaut : agent peut modifier élèves et notes
        document.querySelectorAll('.role-permission').forEach(cb => {
          if (cb.dataset.role === 'agent') {
            if (cb.dataset.perm === 'edit-students' || cb.dataset.perm === 'edit-notes') cb.checked = true;
          }
        });
        // Sauvegarder en localStorage
        localStorage.setItem('appName', defaultAppName);
        localStorage.setItem('contactEmail', defaultContactEmail);
        localStorage.setItem('currency', defaultCurrency);
        localStorage.setItem('notificationsEmail', defaultNotif);
        localStorage.setItem('darkMode', defaultDark);
        localStorage.setItem('defaultLanguage', defaultLang);
        const defaultPerms = { agent: { 'edit-students': true, 'edit-notes': true } };
        localStorage.setItem('rolePermissions', JSON.stringify(defaultPerms));
        updateLastSave();
        alert('Tous les paramètres ont été réinitialisés aux valeurs par défaut.');
      }

      // Chargement des valeurs sauvegardées
      function loadSavedConfig() {
        const savedAppName = localStorage.getItem('appName');
        const savedContactEmail = localStorage.getItem('contactEmail');
        const savedCurrency = localStorage.getItem('currency');
        const savedNotif = localStorage.getItem('notificationsEmail');
        const savedDark = localStorage.getItem('darkMode');
        const savedLang = localStorage.getItem('defaultLanguage');
        const savedPerms = localStorage.getItem('rolePermissions');
        if (savedAppName) appNameInput.value = savedAppName;
        if (savedContactEmail) contactEmailInput.value = savedContactEmail;
        if (savedCurrency) currencySelect.value = savedCurrency;
        if (savedNotif !== null) notifEmailCheck.checked = savedNotif === 'true';
        if (savedDark !== null) darkModeCheck.checked = savedDark === 'true';
        if (savedLang) defaultLangSelect.value = savedLang;
        if (savedPerms) {
          const perms = JSON.parse(savedPerms);
          document.querySelectorAll('.role-permission').forEach(cb => {
            const role = cb.dataset.role;
            const perm = cb.dataset.perm;
            if (perms[role] && perms[role][perm] !== undefined) cb.checked = perms[role][perm];
          });
        }
        updateLastSave();
      }

      // Attacher les écouteurs
      saveGeneralBtns.forEach(btn => btn.addEventListener('click', saveGeneralConfig));
      if (saveRolesBtn) saveRolesBtn.addEventListener('click', saveRolesPermissions);
      if (savePrefsBtn) savePrefsBtn.addEventListener('click', savePreferences);
      if (exportBtn) exportBtn.addEventListener('click', exportConfig);
      if (resetBtn) resetBtn.addEventListener('click', resetToDefaults);

      // Menu sidebar (identique)
      const sidebar = document.getElementById("sidebar");
      const overlay = document.getElementById("sidebar-overlay");
      const btnMenu = document.getElementById("btn-menu");
      function openMenu() { sidebar.classList.remove("-translate-x-full"); overlay.classList.add("is-open"); document.body.style.overflow = "hidden"; }
      function closeMenu() { sidebar.classList.add("-translate-x-full"); overlay.classList.remove("is-open"); document.body.style.overflow = ""; }
      if (btnMenu) btnMenu.addEventListener("click", openMenu);
      if (overlay) overlay.addEventListener("click", closeMenu);
      window.addEventListener("resize", function () { if (window.innerWidth >= 1024) closeMenu(); });

      // Recherche simple sur les cartes
      const searchInput = document.getElementById('global-search');
      if (searchInput) {
        searchInput.addEventListener('input', function(e) {
          const term = e.target.value.toLowerCase();
          const cards = document.querySelectorAll('.settings-card');
          cards.forEach(card => {
            const text = card.innerText.toLowerCase();
            if (text.includes(term)) card.style.display = ''; else card.style.display = 'none';
          });
        });
      }

      loadSavedConfig();
    })();
  </script>
</body>
</html>
