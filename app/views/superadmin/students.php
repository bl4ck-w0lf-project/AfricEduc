<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion des élèves | EduManager</title>
  <meta name="description" content="Suivi des élèves inscrits sur EduManager — Afrique de l'Ouest">

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

  <!-- SIDEBAR - IDENTIQUE -->
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
        <label for="search-student" class="sr-only">Rechercher un élève</label>
        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" /></svg>
        </span>
        <input id="search-student" type="search" placeholder="Rechercher un élève (nom, prénom, matricule…)"
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
          <h1 class="font-heading text-2xl font-bold text-slate-900 sm:text-3xl">Gestion des élèves</h1>
          <p class="mt-1 text-sm text-slate-600">Suivi centralisé de tous les élèves inscrits</p>
        </div>
        <button id="btn-add-student" type="button" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90">
          <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
          </svg>
          Nouvel élève
        </button>
      </div>

      <!-- Filtres -->
      <section class="mt-6 flex flex-wrap gap-3">
        <div class="relative">
          <select id="filter-class" class="appearance-none rounded-xl border border-slate-200 bg-white px-4 py-2 pr-8 text-sm text-slate-700 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
            <option value="">Toutes les classes</option>
            <option value="6ème">6ème</option>
            <option value="5ème">5ème</option>
            <option value="4ème">4ème</option>
            <option value="3ème">3ème</option>
            <option value="Seconde">Seconde</option>
            <option value="Première">Première</option>
            <option value="Terminale">Terminale</option>
          </select>
          <svg class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
          </svg>
        </div>

        <div class="relative">
          <select id="filter-school" class="appearance-none rounded-xl border border-slate-200 bg-white px-4 py-2 pr-8 text-sm text-slate-700 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
            <option value="">Tous les établissements</option>
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
          <svg class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
          </svg>
        </div>

        <button id="reset-filters" type="button" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
          Réinitialiser
        </button>
      </section>

      <!-- Tableau des élèves (6 colonnes + actions) -->
      <section class="mt-6 overflow-hidden rounded-2xl border border-slate-200/90 bg-white shadow-sm">
        <div class="overflow-x-auto">
          <table class="min-w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
              <tr>
                <th class="whitespace-nowrap px-5 py-4 sm:px-6">Élève</th>
                <th class="whitespace-nowrap px-3 py-4">Matricule</th>
                <th class="whitespace-nowrap px-3 py-4">Classe</th>
                <th class="whitespace-nowrap px-3 py-4">Établissement</th>
                <th class="whitespace-nowrap px-3 py-4">Moyenne /20</th>
                <th class="whitespace-nowrap px-3 py-4">Statut</th>
                <th class="whitespace-nowrap px-5 py-4 text-right sm:px-6">Actions</th>
              </tr>
            </thead>
            <tbody id="student-table-body" class="divide-y divide-slate-100 text-slate-700"></tbody>
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
        EduManager Super Admin · Gestion des élèves
      </footer>
    </main>
  </div>

  <!-- MODALE AJOUT / MODIFICATION ÉLÈVE (avec champ Moyenne) -->
  <div id="student-modal" class="modal-overlay fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4" style="pointer-events: none; opacity: 0;">
    <div class="modal-content w-full max-w-md rounded-2xl bg-white shadow-2xl">
      <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
        <h2 id="modal-title" class="font-heading text-xl font-bold text-slate-900">Ajouter un élève</h2>
        <button id="close-modal" type="button" class="rounded-lg p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-600">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <form id="student-form" class="p-6">
        <input type="hidden" id="student-id" value="">
        <div class="mb-4">
          <label class="mb-1 block text-sm font-medium text-slate-700">Nom *</label>
          <input type="text" id="student-lastname" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
        </div>
        <div class="mb-4">
          <label class="mb-1 block text-sm font-medium text-slate-700">Prénom *</label>
          <input type="text" id="student-firstname" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
        </div>
        <div class="mb-4">
          <label class="mb-1 block text-sm font-medium text-slate-700">Classe *</label>
          <select id="student-class" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
            <option value="">Sélectionner une classe</option>
            <option value="6ème">6ème</option>
            <option value="5ème">5ème</option>
            <option value="4ème">4ème</option>
            <option value="3ème">3ème</option>
            <option value="Seconde">Seconde</option>
            <option value="Première">Première</option>
            <option value="Terminale">Terminale</option>
          </select>
        </div>
        <div class="mb-4">
          <label class="mb-1 block text-sm font-medium text-slate-700">Établissement *</label>
          <select id="student-school" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
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
          <label class="mb-1 block text-sm font-medium text-slate-700">Matricule *</label>
          <input type="text" id="student-matricule" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
        </div>
        <div class="mb-6">
          <label class="mb-1 block text-sm font-medium text-slate-700">Moyenne générale (0-20) *</label>
          <input type="number" id="student-average" step="0.1" min="0" max="20" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
        </div>
        <div class="flex gap-3">
          <button type="submit" class="flex-1 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90">Enregistrer</button>
          <button type="button" id="cancel-modal" class="flex-1 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Annuler</button>
        </div>
      </form>
    </div>
  </div>

  <!-- MODALE VISUALISATION PROFIL (améliorée) -->
  <div id="view-modal" class="modal-overlay fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4" style="pointer-events: none; opacity: 0;">
    <div class="modal-content w-full max-w-md rounded-2xl bg-white shadow-2xl">
      <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
        <h2 class="font-heading text-xl font-bold text-slate-900">Profil de l'élève</h2>
        <button id="close-view-modal" type="button" class="rounded-lg p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-600">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <div class="p-6">
        <div class="mb-4 flex justify-center">
          <div class="flex h-20 w-20 items-center justify-center rounded-full bg-primary/10">
            <svg class="h-10 w-10 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
          </div>
        </div>
        <div class="mb-4">
          <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Nom complet</label>
          <p id="view-fullname" class="text-slate-900 font-medium">-</p>
        </div>
        <div class="mb-4">
          <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Matricule</label>
          <p id="view-matricule" class="text-slate-900">-</p>
        </div>
        <div class="mb-4">
          <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Classe</label>
          <p id="view-class" class="text-slate-900">-</p>
        </div>
        <div class="mb-4">
          <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Établissement</label>
          <p id="view-school" class="text-slate-900">-</p>
        </div>
        <div class="mb-4">
          <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Moyenne générale</label>
          <p id="view-average" class="text-slate-900">-</p>
        </div>
        <div class="mb-6">
          <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Statut</label>
          <p id="view-status" class="text-slate-900">-</p>
        </div>
        <button id="close-view-btn" type="button" class="w-full rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90">Fermer</button>
      </div>
    </div>
  </div>

  <script>
    (function () {
      // Données élèves enrichies (moyenne + statut)
      let studentsData = [
        { id: 1, nom: "KOUADIO", prenom: "Marie", classe: "3ème", etablissement: "Collège Saint-Michel", matricule: "CSM-001", moyenne: 14.5 },
        { id: 2, nom: "TRAORÉ", prenom: "Ibrahim", classe: "Seconde", etablissement: "Lycée Béhanzin", matricule: "LB-045", moyenne: 11.2 },
        { id: 3, nom: "DIALLO", prenom: "Aminata", classe: "CM2", etablissement: "Complexe Les Lauriers", matricule: "CLL-112", moyenne: 9.8 },
        { id: 4, nom: "N'GUESSAN", prenom: "Koffi", classe: "Terminale", etablissement: "Université Partenaire Atlantique", matricule: "UPA-234", moyenne: 16.0 },
        { id: 5, nom: "HOUNDONOU", prenom: "Jules", classe: "4ème", etablissement: "Cours Secondaire Ste Thérèse", matricule: "CST-089", moyenne: 12.3 },
        { id: 6, nom: "AGOSSOU", prenom: "Bénédicte", classe: "Première", etablissement: "Institut Technique de Porto-Novo", matricule: "ITPN-456", moyenne: 13.7 },
        { id: 7, nom: "DOSSOU", prenom: "Gabin", classe: "6ème", etablissement: "École Le Savoir", matricule: "ELS-067", moyenne: 8.5 },
        { id: 8, nom: "BIO", prenom: "Karim", classe: "5ème", etablissement: "Groupe scolaire Les Phénix", matricule: "GSLP-123", moyenne: 7.2 },
        { id: 9, nom: "ZINSOU", prenom: "Espoir", classe: "Terminale", etablissement: "Faculté des Sciences Lokossa", matricule: "FSL-789", moyenne: 15.8 },
        { id: 10, nom: "AÏSSI", prenom: "Pélagie", classe: "3ème", etablissement: "Centre Maria-Goretti", matricule: "CMG-234", moyenne: 10.5 },
        { id: 11, nom: "OROU", prenom: "Blaise", classe: "Seconde", etablissement: "Lycée Moderne de Parakou", matricule: "LMP-567", moyenne: 9.0 },
        { id: 12, nom: "ADJOVI", prenom: "Pascal", classe: "Première", etablissement: "Institut Cardinal Gantin", matricule: "ICG-890", moyenne: 12.9 }
      ];

      let nextId = 13;
      let filteredStudents = [...studentsData];
      let perPage = 8;
      let currentPage = 1;
      let totalPages = 1;

      // Références filtres
      const searchInput = document.getElementById("search-student");
      const classFilter = document.getElementById("filter-class");
      const schoolFilter = document.getElementById("filter-school");

      // Références modales
      const modal = document.getElementById("student-modal");
      const viewModal = document.getElementById("view-modal");
      const modalTitle = document.getElementById("modal-title");
      const studentIdField = document.getElementById("student-id");
      const studentLastname = document.getElementById("student-lastname");
      const studentFirstname = document.getElementById("student-firstname");
      const studentClass = document.getElementById("student-class");
      const studentSchool = document.getElementById("student-school");
      const studentMatricule = document.getElementById("student-matricule");
      const studentAverage = document.getElementById("student-average");
      const studentForm = document.getElementById("student-form");

      // Helper : obtenir statut à partir de la moyenne
      function getStatutFromMoyenne(moyenne) {
        return moyenne >= 10 ? "Admis" : "Redoublant";
      }

      // Badge statut HTML
      function getStatutBadge(statut) {
        if (statut === "Admis") {
          return '<span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-800">Admis</span>';
        } else {
          return '<span class="inline-flex items-center gap-1.5 rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">Redoublant</span>';
        }
      }

      function applyFilters() {
        let searchTerm = searchInput.value.toLowerCase();
        let selectedClass = classFilter.value;
        let selectedSchool = schoolFilter.value;

        filteredStudents = studentsData.filter(s => {
          let fullName = (s.nom + " " + s.prenom).toLowerCase();
          let matchSearch = fullName.includes(searchTerm) || s.matricule.toLowerCase().includes(searchTerm);
          let matchClass = selectedClass === "" || s.classe === selectedClass;
          let matchSchool = selectedSchool === "" || s.etablissement === selectedSchool;
          return matchSearch && matchClass && matchSchool;
        });
        totalPages = Math.max(1, Math.ceil(filteredStudents.length / perPage));
        if (currentPage > totalPages) currentPage = totalPages;
        renderTable();
        renderPagination();
      }

      function renderTable() {
        let tbody = document.getElementById("student-table-body");
        let start = (currentPage - 1) * perPage;
        let slice = filteredStudents.slice(start, start + perPage);
        if (slice.length === 0) {
          tbody.innerHTML = '<tr><td colspan="7" class="px-5 py-8 text-center text-slate-500">Aucun élève trouvé</td></tr>';
          return;
        }
        tbody.innerHTML = slice.map(s => {
          const statut = getStatutFromMoyenne(s.moyenne);
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
                    <p class="font-medium">${escapeHtml(s.nom)} ${escapeHtml(s.prenom)}</p>
                    <p class="text-xs text-slate-500">${escapeHtml(s.matricule)}</p>
                  </div>
                </div>
               </td>
               <td class="px-3 py-4">${escapeHtml(s.matricule)}</td>
               <td class="px-3 py-4">
                <div class="flex items-center gap-1.5">
                  <svg class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16v-5M12 16V8m5 8V11" />
                  </svg>
                  ${escapeHtml(s.classe)}
                </div>
               </td>
               <td class="px-3 py-4">
                <div class="flex items-center gap-1.5">
                  <svg class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5V8.25L12 4l8 4.25V19.5" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19.5V12h6v7.5" />
                  </svg>
                  ${escapeHtml(s.etablissement)}
                </div>
               </td>
               <td class="px-3 py-4 font-semibold">${s.moyenne.toFixed(1)} / 20</td>
               <td class="px-3 py-4">${getStatutBadge(statut)}</td>
               <td class="px-5 py-4 text-right sm:px-6">
                <div class="flex flex-wrap justify-end gap-2">
                  <button type="button" class="view-student-btn rounded-lg p-1.5 text-slate-500 hover:bg-slate-100 hover:text-primary transition" data-id="${s.id}" title="Voir profil">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                  </button>
                  <button type="button" class="edit-student-btn rounded-lg bg-primary/10 px-2.5 py-1 text-xs font-semibold text-primary hover:bg-primary/20 transition" data-id="${s.id}">Modifier</button>
                  <button type="button" class="delete-student-btn rounded-lg border border-red-200 bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700 hover:bg-red-100 transition" data-id="${s.id}">Supprimer</button>
                </div>
               </td>
             `
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

      // Modale ajout/modification
      function openModal(editMode = false, student = null) {
        if (editMode && student) {
          modalTitle.textContent = "Modifier l'élève";
          studentIdField.value = student.id;
          studentLastname.value = student.nom;
          studentFirstname.value = student.prenom;
          studentClass.value = student.classe;
          studentSchool.value = student.etablissement;
          studentMatricule.value = student.matricule;
          studentAverage.value = student.moyenne;
        } else {
          modalTitle.textContent = "Ajouter un élève";
          studentIdField.value = "";
          studentLastname.value = "";
          studentFirstname.value = "";
          studentClass.value = "";
          studentSchool.value = "";
          studentMatricule.value = "";
          studentAverage.value = "";
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

      function saveStudent(event) {
        event.preventDefault();
        const id = parseInt(studentIdField.value);
        const nom = studentLastname.value.trim();
        const prenom = studentFirstname.value.trim();
        const classe = studentClass.value;
        const etablissement = studentSchool.value;
        const matricule = studentMatricule.value.trim();
        const moyenne = parseFloat(studentAverage.value);

        if (!nom || !prenom || !classe || !etablissement || !matricule || isNaN(moyenne) || moyenne < 0 || moyenne > 20) {
          alert("Veuillez remplir tous les champs correctement (moyenne entre 0 et 20).");
          return;
        }

        if (id) {
          // Modification
          const index = studentsData.findIndex(s => s.id === id);
          if (index !== -1) {
            studentsData[index] = { ...studentsData[index], nom, prenom, classe, etablissement, matricule, moyenne };
          }
        } else {
          // Ajout
          const newStudent = { id: nextId++, nom, prenom, classe, etablissement, matricule, moyenne };
          studentsData.push(newStudent);
        }
        closeModal();
        applyFilters();
      }

      // Suppression
      function deleteStudentById(id) {
        if (confirm("Êtes-vous sûr de vouloir supprimer cet élève ?")) {
          studentsData = studentsData.filter(s => s.id !== id);
          applyFilters();
        }
      }

      // Modale visualisation (profil complet)
      function openViewModal(student) {
        document.getElementById("view-fullname").textContent = `${student.nom} ${student.prenom}`;
        document.getElementById("view-matricule").textContent = student.matricule;
        document.getElementById("view-class").textContent = student.classe;
        document.getElementById("view-school").textContent = student.etablissement;
        document.getElementById("view-average").textContent = student.moyenne.toFixed(1) + " / 20";
        const statut = getStatutFromMoyenne(student.moyenne);
        document.getElementById("view-status").innerHTML = getStatutBadge(statut);
        viewModal.style.pointerEvents = "auto";
        viewModal.style.opacity = "1";
        document.body.style.overflow = "hidden";
      }

      function closeViewModal() {
        viewModal.style.pointerEvents = "none";
        viewModal.style.opacity = "0";
        document.body.style.overflow = "";
      }

      // Événements filtres
      searchInput.addEventListener("input", () => { currentPage = 1; applyFilters(); });
      classFilter.addEventListener("change", () => { currentPage = 1; applyFilters(); });
      schoolFilter.addEventListener("change", () => { currentPage = 1; applyFilters(); });
      document.getElementById("reset-filters").addEventListener("click", () => {
        searchInput.value = "";
        classFilter.value = "";
        schoolFilter.value = "";
        applyFilters();
      });

      // Bouton ajout
      document.getElementById("btn-add-student").addEventListener("click", () => openModal(false));

      // Délégation des actions du tableau
      document.getElementById("student-table-body").addEventListener("click", (e) => {
        let target = e.target.closest(".view-student-btn");
        if (target) {
          let id = parseInt(target.getAttribute("data-id"));
          let student = studentsData.find(s => s.id === id);
          if (student) openViewModal(student);
          return;
        }
        target = e.target.closest(".edit-student-btn");
        if (target) {
          let id = parseInt(target.getAttribute("data-id"));
          let student = studentsData.find(s => s.id === id);
          if (student) openModal(true, student);
          return;
        }
        target = e.target.closest(".delete-student-btn");
        if (target) {
          let id = parseInt(target.getAttribute("data-id"));
          deleteStudentById(id);
          return;
        }
      });

      // Fermeture modales
      document.getElementById("close-modal").addEventListener("click", closeModal);
      document.getElementById("cancel-modal").addEventListener("click", closeModal);
      modal.addEventListener("click", (e) => { if (e.target === modal) closeModal(); });
      studentForm.addEventListener("submit", saveStudent);

      document.getElementById("close-view-modal").addEventListener("click", closeViewModal);
      document.getElementById("close-view-btn").addEventListener("click", closeViewModal);
      viewModal.addEventListener("click", (e) => { if (e.target === viewModal) closeViewModal(); });

      // Pagination
      document.getElementById("pager-prev").addEventListener("click", () => {
        if (currentPage > 1) { currentPage--; renderTable(); renderPagination(); }
      });
      document.getElementById("pager-next").addEventListener("click", () => {
        if (currentPage < totalPages) { currentPage++; renderTable(); renderPagination(); }
      });

      // Menu sidebar
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
