<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion des utilisateurs | EduManager</title>
  <meta name="description" content="Gestion des utilisateurs (admins, agents) sur EduManager — Afrique de l'Ouest">

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
    tbody tr:nth-child(even) {
      background-color: rgba(248, 250, 252, 0.85);
    }
    tbody tr:hover {
      background-color: rgba(115, 0, 233, 0.04) !important;
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
  </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">
  <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden" aria-hidden="true"></div>

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
    <header class="sticky top-0 z-30 flex h-16 items-center gap-4 border-b border-slate-200/90 bg-white px-4 shadow-sm backdrop-blur-sm sm:px-6">
      <button type="button" id="btn-menu" class="inline-flex rounded-xl border border-slate-200 p-2 text-slate-700 hover:bg-slate-50 lg:hidden" aria-label="Ouvrir le menu">
        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
      </button>

      <div class="relative min-w-0 flex-1">
        <label for="user-search" class="sr-only">Rechercher un utilisateur</label>
        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" /></svg>
        </span>
        <input id="user-search" type="search" placeholder="Rechercher un utilisateur (nom, rôle, établissement…)"
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
      <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h1 class="font-heading text-2xl font-bold text-slate-900 sm:text-3xl">Gestion des utilisateurs</h1>
          <p class="mt-1 text-sm text-slate-600">Administrez les comptes admins et agents des établissements</p>
        </div>
        <button id="btn-new-user" type="button" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90">
          <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
          </svg>
          Nouvel utilisateur
        </button>
      </div>

      <!-- Tableau des utilisateurs -->
      <section class="mt-6 overflow-hidden rounded-2xl border border-slate-200/90 bg-white shadow-sm">
        <div class="overflow-x-auto">
          <table class="min-w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
              <tr>
                <th class="whitespace-nowrap px-5 py-4 sm:px-6">Utilisateur</th>
                <th class="whitespace-nowrap px-3 py-4">Rôle</th>
                <th class="whitespace-nowrap px-3 py-4">Établissement</th>
                <th class="whitespace-nowrap px-3 py-4">Statut</th>
                <th class="whitespace-nowrap px-5 py-4 text-right sm:px-6">Actions</th>
              </tr>
            </thead>
            <tbody id="user-table-body" class="divide-y divide-slate-100 text-slate-700"></tbody>
          </table>
        </div>
        <div class="flex flex-col items-center justify-between gap-3 border-t border-slate-100 px-5 py-4 sm:flex-row sm:px-6">
          <p class="text-xs text-slate-500" id="page-info">Page 1 sur <span id="total-pages"></span></p>
          <div class="flex items-center gap-2">
            <button type="button" id="pager-prev" class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40">Précédent</button>
            <div id="pager-numbers" class="flex gap-1"></div>
            <button type="button" id="pager-next" class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40">Suivant</button>
          </div>
        </div>
      </section>

      <footer class="mt-12 pb-8 text-center text-xs text-slate-400">
        EduManager Super Admin · Gestion des utilisateurs
      </footer>
    </main>
  </div>

  <!-- MODALE AJOUT / MODIFICATION UTILISATEUR (avec champ mot de passe) -->
  <div id="user-modal" class="modal-overlay fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4" style="pointer-events: none; opacity: 0;">
    <div class="modal-content w-full max-w-md rounded-2xl bg-white shadow-2xl">
      <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
        <h2 id="modal-title" class="font-heading text-xl font-bold text-slate-900">Ajouter un utilisateur</h2>
        <button id="close-modal" type="button" class="rounded-lg p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-600">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <form id="user-form" class="p-6">
        <input type="hidden" id="user-id" value="">
        <div class="mb-4">
          <label class="mb-1 block text-sm font-medium text-slate-700">Nom complet *</label>
          <input type="text" id="user-name" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
        </div>
        <div class="mb-4">
          <label class="mb-1 block text-sm font-medium text-slate-700">Email *</label>
          <input type="email" id="user-email" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
        </div>
        <div class="mb-4">
          <label class="mb-1 block text-sm font-medium text-slate-700">Rôle *</label>
          <select id="user-role" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
            <option value="admin">Administrateur</option>
            <option value="agent">Agent</option>
          </select>
        </div>
        <div class="mb-4">
          <label class="mb-1 block text-sm font-medium text-slate-700">Établissement *</label>
          <select id="user-school" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
            <option value="">Sélectionner un établissement</option>
            <option value="Collège Saint-Michel">Collège Saint-Michel</option>
            <option value="Lycée Béhanzin">Lycée Béhanzin</option>
            <option value="Complexe Les Lauriers">Complexe Les Lauriers</option>
            <option value="Université Partenaire Atlantique">Université Partenaire Atlantique</option>
            <option value="Cours Secondaire Ste Thérèse">Cours Secondaire Ste Thérèse</option>
            <option value="Institut Technique de Porto-Novo">Institut Technique de Porto-Novo</option>
            <option value="École Le Savoir">École Le Savoir</option>
            <option value="Groupe scolaire Les Phénix">Groupe scolaire Les Phénix</option>
            <option value="Faculté des Sciences Lokossa">Faculté des Sciences Lokossa</option>
            <option value="Centre Maria-Goretti">Centre Maria-Goretti</option>
            <option value="Lycée Moderne de Parakou">Lycée Moderne de Parakou</option>
            <option value="Institut Cardinal Gantin">Institut Cardinal Gantin</option>
          </select>
        </div>
        <div class="mb-4">
          <label class="mb-1 block text-sm font-medium text-slate-700">Mot de passe</label>
          <input type="password" id="user-password" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
          <p class="mt-1 text-xs text-slate-400" id="password-hint">(Laissez vide pour ne pas modifier)</p>
        </div>
        <div class="mb-6">
          <label class="mb-1 block text-sm font-medium text-slate-700">Statut</label>
          <select id="user-status" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
            <option value="actif">Actif</option>
            <option value="inactif">Inactif</option>
          </select>
        </div>
        <div class="flex gap-3">
          <button type="submit" class="flex-1 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90">Enregistrer</button>
          <button type="button" id="cancel-modal" class="flex-1 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Annuler</button>
        </div>
      </form>
    </div>
  </div>

  <!-- MODALE RÉINITIALISATION MOT DE PASSE -->
  <div id="password-reset-modal" class="modal-overlay fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4" style="pointer-events: none; opacity: 0;">
    <div class="modal-content w-full max-w-md rounded-2xl bg-white shadow-2xl">
      <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
        <h2 class="font-heading text-xl font-bold text-slate-900">Réinitialiser le mot de passe</h2>
        <button id="close-reset-modal" type="button" class="rounded-lg p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-600">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <form id="reset-form" class="p-6">
        <input type="hidden" id="reset-user-id">
        <div class="mb-4">
          <label class="mb-1 block text-sm font-medium text-slate-700">Nouveau mot de passe</label>
          <input type="password" id="reset-password" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
        </div>
        <div class="mb-6">
          <label class="mb-1 block text-sm font-medium text-slate-700">Confirmer le mot de passe</label>
          <input type="password" id="reset-password-confirm" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
        </div>
        <div class="flex gap-3">
          <button type="submit" class="flex-1 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90">Modifier</button>
          <button type="button" id="cancel-reset" class="flex-1 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Annuler</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    (function () {
      // Données utilisateurs (nom, rôle, établissement, statut, mot de passe simulé)
      let usersData = [
        { id: 1, nom: "Dr. Arnaud Kossi", email: "a.kossi@csm.edu", role: "admin", etablissement: "Collège Saint-Michel", statut: "actif", password: "pass123" },
        { id: 2, nom: "M. Hounkpe Marc", email: "m.hounkpe@lb.edu", role: "admin", etablissement: "Lycée Béhanzin", statut: "actif", password: "pass123" },
        { id: 3, nom: "S. Ahouanvo", email: "s.ahouanvo@ll.edu", role: "agent", etablissement: "Complexe Les Lauriers", statut: "actif", password: "pass123" },
        { id: 4, nom: "Dr. T. Mensah", email: "t.mensah@upa.edu", role: "admin", etablissement: "Université Partenaire Atlantique", statut: "actif", password: "pass123" },
        { id: 5, nom: "Sr. B. Lawson", email: "b.lawson@cst.edu", role: "agent", etablissement: "Cours Secondaire Ste Thérèse", statut: "inactif", password: "pass123" },
        { id: 6, nom: "I. Sossou", email: "i.sossou@itpn.edu", role: "admin", etablissement: "Institut Technique de Porto-Novo", statut: "actif", password: "pass123" },
        { id: 7, nom: "G. Dossou", email: "g.dossou@els.edu", role: "agent", etablissement: "École Le Savoir", statut: "actif", password: "pass123" },
        { id: 8, nom: "K. Bio", email: "k.bio@gslp.edu", role: "admin", etablissement: "Groupe scolaire Les Phénix", statut: "inactif", password: "pass123" },
        { id: 9, nom: "Prof. Zinsou", email: "zinsou@fsl.edu", role: "admin", etablissement: "Faculté des Sciences Lokossa", statut: "actif", password: "pass123" },
        { id: 10, nom: "P. Aïssi", email: "p.aissi@cmg.edu", role: "agent", etablissement: "Centre Maria-Goretti", statut: "actif", password: "pass123" },
        { id: 11, nom: "B. Orou", email: "b.orou@lmp.edu", role: "admin", etablissement: "Lycée Moderne de Parakou", statut: "actif", password: "pass123" },
        { id: 12, nom: "P. Adjovi", email: "p.adjovi@icg.edu", role: "agent", etablissement: "Institut Cardinal Gantin", statut: "actif", password: "pass123" }
      ];

      let nextId = 13;
      let filteredUsers = [...usersData];
      let perPage = 8;
      let currentPage = 1;
      let totalPages = 1;

      // Références modale principale
      const modal = document.getElementById("user-modal");
      const modalTitle = document.getElementById("modal-title");
      const userIdField = document.getElementById("user-id");
      const userName = document.getElementById("user-name");
      const userEmail = document.getElementById("user-email");
      const userRole = document.getElementById("user-role");
      const userSchool = document.getElementById("user-school");
      const userPassword = document.getElementById("user-password");
      const passwordHint = document.getElementById("password-hint");
      const userStatus = document.getElementById("user-status");
      const userForm = document.getElementById("user-form");

      // Références modale reset password
      const resetModal = document.getElementById("password-reset-modal");
      const resetUserId = document.getElementById("reset-user-id");
      const resetPassword = document.getElementById("reset-password");
      const resetPasswordConfirm = document.getElementById("reset-password-confirm");
      const resetForm = document.getElementById("reset-form");

      // Filtre recherche
      const searchInput = document.getElementById("user-search");

      function applyFilters() {
        let searchTerm = searchInput ? searchInput.value.toLowerCase() : "";
        filteredUsers = usersData.filter(user => {
          return user.nom.toLowerCase().includes(searchTerm) ||
                 user.role.toLowerCase().includes(searchTerm) ||
                 user.etablissement.toLowerCase().includes(searchTerm);
        });
        totalPages = Math.max(1, Math.ceil(filteredUsers.length / perPage));
        if (currentPage > totalPages) currentPage = totalPages;
        renderTable();
        renderPagination();
      }

      function getRoleBadge(role) {
        if (role === "admin") {
          return '<span class="inline-flex items-center gap-1.5 rounded-full bg-primary/10 px-2.5 py-0.5 text-xs font-semibold text-primary"><svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>Admin</span>';
        } else {
          return '<span class="inline-flex items-center gap-1.5 rounded-full bg-accent/30 px-2.5 py-0.5 text-xs font-semibold text-slate-800"><svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M4 20a8 8 0 0 1 15.659-2.165"/></svg>Agent</span>';
        }
      }

      function getStatusBadge(statut) {
        if (statut === "actif") {
          return '<span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-800"><span class="relative flex h-2 w-2"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span></span>Actif</span>';
        } else {
          return '<span class="rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">Inactif</span>';
        }
      }

      function actionButtonsHtml(userId, currentStatus) {
        let statusBtn = currentStatus === "actif" 
          ? '<button type="button" class="desactivate-user-btn rounded-lg border border-red-200 bg-red-50 px-2 py-1 text-xs font-semibold text-red-700 hover:bg-red-100 transition" data-id="' + userId + '">Désactiver</button>'
          : '<button type="button" class="activate-user-btn rounded-lg bg-emerald-600 px-2 py-1 text-xs font-semibold text-white hover:bg-emerald-700 transition" data-id="' + userId + '">Activer</button>';
        
        return (
          '<div class="flex flex-wrap justify-end gap-2">' +
          '<button type="button" class="edit-user-btn rounded-lg bg-primary/10 px-2.5 py-1 text-xs font-semibold text-primary hover:bg-primary/20 transition" data-id="' + userId + '">Modifier</button>' +
          '<button type="button" class="reset-pwd-btn rounded-lg border border-primary/20 bg-white px-2.5 py-1 text-xs font-semibold text-primary hover:bg-primary/5 transition" data-id="' + userId + '">Réinitialiser mot de passe</button>' +
          statusBtn +
          '</div>'
        );
      }

      function renderTable() {
        let body = document.getElementById("user-table-body");
        let start = (currentPage - 1) * perPage;
        let slice = filteredUsers.slice(start, start + perPage);
        
        if (slice.length === 0) {
          body.innerHTML = '<tr><td colspan="5" class="px-5 py-8 text-center text-slate-500">Aucun utilisateur trouvé</td></tr>';
          return;
        }
        
        body.innerHTML = slice.map(user => {
          return `
            <tr>
              <td class="px-5 py-4 font-medium text-slate-900 sm:px-6">
                <div class="flex items-center gap-3">
                  <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary/10">
                    <svg class="h-5 w-5 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                  </div>
                  <div>
                    <p class="font-medium">${escapeHtml(user.nom)}</p>
                    <p class="text-xs text-slate-500">${escapeHtml(user.email)}</p>
                  </div>
                </div>
               </td>
              <td class="px-3 py-4">${getRoleBadge(user.role)}</td>
              <td class="px-3 py-4">
                <div class="flex items-center gap-1.5">
                  <svg class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5V8.25L12 4l8 4.25V19.5" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19.5V12h6v7.5" />
                  </svg>
                  ${escapeHtml(user.etablissement)}
                </div>
              </td>
              <td class="px-3 py-4">${getStatusBadge(user.statut)}</td>
              <td class="px-5 py-4 text-right sm:px-6">${actionButtonsHtml(user.id, user.statut)}</td>
            </tr>
          `;
        }).join("");
        
        document.getElementById("total-pages").textContent = totalPages;
        document.getElementById("page-info").innerHTML = "Page " + currentPage + " sur " + totalPages;
        document.getElementById("pager-prev").disabled = currentPage <= 1;
        document.getElementById("pager-next").disabled = currentPage >= totalPages;
      }

      function renderPagination() {
        let nums = document.getElementById("pager-numbers");
        nums.innerHTML = "";
        for (let p = 1; p <= totalPages; p++) {
          let b = document.createElement("button");
          b.type = "button";
          b.textContent = String(p);
          b.className = "h-8 min-w-[2rem] rounded-lg text-xs font-semibold transition " +
            (p === currentPage ? "bg-primary text-white" : "border border-slate-200 text-slate-700 hover:bg-slate-50");
          b.addEventListener("click", (function(page) {
            return function() {
              currentPage = page;
              renderTable();
              renderPagination();
            };
          })(p));
          nums.appendChild(b);
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

      // Modale principale (ajout / modification)
      function openModal(editMode = false, user = null) {
        if (editMode && user) {
          modalTitle.textContent = "Modifier l'utilisateur";
          userIdField.value = user.id;
          userName.value = user.nom;
          userEmail.value = user.email;
          userRole.value = user.role;
          userSchool.value = user.etablissement;
          userStatus.value = user.statut;
          userPassword.value = "";
          passwordHint.textContent = "(Laissez vide pour ne pas modifier le mot de passe)";
        } else {
          modalTitle.textContent = "Ajouter un utilisateur";
          userIdField.value = "";
          userName.value = "";
          userEmail.value = "";
          userRole.value = "admin";
          userSchool.value = "";
          userStatus.value = "actif";
          userPassword.value = "";
          passwordHint.textContent = "(Définissez un mot de passe pour le nouvel utilisateur)";
        }
        modal.style.pointerEvents = "auto";
        modal.style.opacity = "1";
        document.body.style.overflow = "hidden";
      }

      function closeModal() {
        modal.style.pointerEvents = "none";
        modal.style.opacity = "0";
        document.body.style.overflow = "";
      }

      function saveUser(event) {
        event.preventDefault();
        const id = parseInt(userIdField.value);
        const nom = userName.value.trim();
        const email = userEmail.value.trim();
        const role = userRole.value;
        const etablissement = userSchool.value;
        const statut = userStatus.value;
        const password = userPassword.value;

        if (!nom || !email || !etablissement) {
          alert("Veuillez remplir tous les champs obligatoires.");
          return;
        }

        if (id) {
          // Modification
          const index = usersData.findIndex(u => u.id === id);
          if (index !== -1) {
            const updatedUser = { ...usersData[index], nom, email, role, etablissement, statut };
            if (password) updatedUser.password = password;
            usersData[index] = updatedUser;
          }
        } else {
          // Ajout
          if (!password) {
            alert("Veuillez définir un mot de passe pour le nouvel utilisateur.");
            return;
          }
          const newUser = {
            id: nextId++,
            nom,
            email,
            role,
            etablissement,
            statut,
            password
          };
          usersData.push(newUser);
        }
        closeModal();
        applyFilters();
      }

      // Modale de réinitialisation mot de passe
      let currentResetUserId = null;

      function openResetModal(userId) {
        currentResetUserId = userId;
        resetUserId.value = userId;
        resetPassword.value = "";
        resetPasswordConfirm.value = "";
        resetModal.style.pointerEvents = "auto";
        resetModal.style.opacity = "1";
        document.body.style.overflow = "hidden";
      }

      function closeResetModal() {
        resetModal.style.pointerEvents = "none";
        resetModal.style.opacity = "0";
        document.body.style.overflow = "";
        currentResetUserId = null;
      }

      function resetPasswordHandler(event) {
        event.preventDefault();
        const userId = parseInt(resetUserId.value);
        const newPwd = resetPassword.value;
        const confirmPwd = resetPasswordConfirm.value;
        if (!newPwd || !confirmPwd) {
          alert("Veuillez remplir les deux champs.");
          return;
        }
        if (newPwd !== confirmPwd) {
          alert("Les mots de passe ne correspondent pas.");
          return;
        }
        const user = usersData.find(u => u.id === userId);
        if (user) {
          user.password = newPwd;
          alert(`Mot de passe modifié pour ${user.nom}`);
          closeResetModal();
        } else {
          alert("Utilisateur non trouvé.");
        }
      }

      // Événements
      document.getElementById("btn-new-user").addEventListener("click", () => openModal(false));
      document.getElementById("close-modal").addEventListener("click", closeModal);
      document.getElementById("cancel-modal").addEventListener("click", closeModal);
      modal.addEventListener("click", (e) => { if (e.target === modal) closeModal(); });
      userForm.addEventListener("submit", saveUser);

      // Fermeture modale reset
      document.getElementById("close-reset-modal").addEventListener("click", closeResetModal);
      document.getElementById("cancel-reset").addEventListener("click", closeResetModal);
      resetModal.addEventListener("click", (e) => { if (e.target === resetModal) closeResetModal(); });
      resetForm.addEventListener("submit", resetPasswordHandler);

      // Recherche
      searchInput.addEventListener("input", () => {
        currentPage = 1;
        applyFilters();
      });

      // Délégation pour les actions du tableau
      document.getElementById("user-table-body").addEventListener("click", (e) => {
        let target = e.target.closest(".edit-user-btn");
        if (target) {
          let id = parseInt(target.getAttribute("data-id"));
          let user = usersData.find(u => u.id === id);
          if (user) openModal(true, user);
          return;
        }
        target = e.target.closest(".reset-pwd-btn");
        if (target) {
          let id = parseInt(target.getAttribute("data-id"));
          openResetModal(id);
          return;
        }
        target = e.target.closest(".activate-user-btn");
        if (target) {
          let id = parseInt(target.getAttribute("data-id"));
          let user = usersData.find(u => u.id === id);
          if (user && user.statut === "inactif") {
            user.statut = "actif";
            applyFilters();
          }
          return;
        }
        target = e.target.closest(".desactivate-user-btn");
        if (target) {
          let id = parseInt(target.getAttribute("data-id"));
          let user = usersData.find(u => u.id === id);
          if (user && user.statut === "actif") {
            user.statut = "inactif";
            applyFilters();
          }
          return;
        }
      });

      // Pagination
      document.getElementById("pager-prev").addEventListener("click", () => {
        if (currentPage > 1) {
          currentPage--;
          renderTable();
          renderPagination();
        }
      });
      document.getElementById("pager-next").addEventListener("click", () => {
        if (currentPage < totalPages) {
          currentPage++;
          renderTable();
          renderPagination();
        }
      });

      // Sidebar / menu
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
      btnMenu.addEventListener("click", openMenu);
      overlay.addEventListener("click", closeMenu);
      window.addEventListener("resize", () => { if (window.innerWidth >= 1024) closeMenu(); });

      // Initialisation
      applyFilters();
    })();
  </script>
</body>
</html>
