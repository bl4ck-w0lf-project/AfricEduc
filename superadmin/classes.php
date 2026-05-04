<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion des classes | EduManager</title>
  <meta name="description" content="Gestion des classes sur EduManager — Afrique de l'Ouest">

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

  <!-- SIDEBAR – IDENTIQUE (avec lien Classes actif) -->
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
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h3A2.25 2.25 0 0 1 11.25 6v3A2.25 2.25 0 0 1 9 11.25H6A2.25 2.25 0 0 1 3.75 9V6Z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6A2.25 2.25 0 0 1 15.75 3.75h3A2.25 2.25 0 0 1 21 6v3A2.25 2.25 0 0 1 18.75 11.25h-3A2.25 2.25 0 0 1 13.5 9V6Z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 15A2.25 2.25 0 0 1 6 12.75h3A2.25 2.25 0 0 1 11.25 15v3A2.25 2.25 0 0 1 9 20.25H6A2.25 2.25 0 0 1 3.75 18v-3Z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 15A2.25 2.25 0 0 1 15.75 12.75h3A2.25 2.25 0 0 1 21 15v3A2.25 2.25 0 0 1 18.75 20.25h-3A2.25 2.25 0 0 1 13.5 18v-3Z" />
        </svg>
        Dashboard
      </a>
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5V8.25L12 4l8 4.25V19.5" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 19.5V12h6v7.5" />
        </svg>
        Établissements
      </a>
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 20a8 8 0 0 1 15.659-2.165" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Z" />
        </svg>
        Utilisateurs
      </a>
      <a href="#" class="sidebar-link active flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M7 16v-5M12 16V8m5 8V11" />
        </svg>
        Classes
      </a>
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 3.084-1.756 3.51 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 3.084 0 3.51a1.724 1.724 0 0 0-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0-2.572 1.065c-.426 1.756-3.084 1.756-3.51 0a1.724 1.724 0 0 0-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0-1.065-2.572c-1.756-.426-1.756-3.084 0-3.51a1.724 1.724 0 0 0 1.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065Z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
        </svg>
        Notes
      </a>
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 3.084-1.756 3.51 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 3.084 0 3.51a1.724 1.724 0 0 0-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0-2.572 1.065c-.426 1.756-3.084 1.756-3.51 0a1.724 1.724 0 0 0-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0-1.065-2.572c-1.756-.426-1.756-3.084 0-3.51a1.724 1.724 0 0 0 1.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065Z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Zm0 6a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Zm0 6a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
        </svg>
        Paramètres système
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
        <label for="class-search" class="sr-only">Rechercher une classe</label>
        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" /></svg>
        </span>
        <input id="class-search" type="search" placeholder="Rechercher une classe, un niveau, un établissement…"
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
          <h1 class="font-heading text-2xl font-bold text-slate-900 sm:text-3xl">Gestion des classes</h1>
          <p class="mt-1 text-sm text-slate-600">Liste des classes par établissement</p>
        </div>
        <button id="btn-add-class" type="button" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90">
          <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
          </svg>
          Ajouter une classe
        </button>
      </div>

      <!-- Filtres rapides -->
      <section class="mt-6 flex flex-wrap gap-3">
        <div class="relative">
          <select id="filter-level" class="appearance-none rounded-xl border border-slate-200 bg-white px-4 py-2 pr-8 text-sm text-slate-700 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
            <option value="">Tous les niveaux</option>
            <option value="6ème">6ème</option>
            <option value="5ème">5ème</option>
            <option value="4ème">4ème</option>
            <option value="3ème">3ème</option>
            <option value="Seconde">Seconde</option>
            <option value="Première">Première</option>
            <option value="Terminale">Terminale</option>
            <option value="L1">L1 (Licence 1)</option>
            <option value="L2">L2 (Licence 2)</option>
            <option value="L3">L3 (Licence 3)</option>
          </select>
          <svg class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
          </svg>
        </div>
        <div class="relative">
          <select id="filter-school-class" class="appearance-none rounded-xl border border-slate-200 bg-white px-4 py-2 pr-8 text-sm text-slate-700 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
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
        <button id="reset-filters" type="button" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-50">Réinitialiser</button>
      </section>

      <!-- Tableau des classes -->
      <section class="mt-6 overflow-hidden rounded-2xl border border-slate-200/90 bg-white shadow-sm">
        <div class="overflow-x-auto">
          <table class="min-w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
              <tr>
                <th class="whitespace-nowrap px-5 py-4 sm:px-6">Classe</th>
                <th class="whitespace-nowrap px-3 py-4">Niveau</th>
                <th class="whitespace-nowrap px-3 py-4">Établissement</th>
                <th class="whitespace-nowrap px-3 py-4">Élèves</th>
                <th class="whitespace-nowrap px-5 py-4 text-right sm:px-6">Actions</th>
              </tr>
            </thead>
            <tbody id="class-table-body" class="divide-y divide-slate-100 text-slate-700"></tbody>
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
        EduManager Super Admin · Gestion des classes
      </footer>
    </main>
  </div>

  <!-- MODALE AJOUT / MODIFICATION CLASSE -->
  <div id="class-modal" class="modal-overlay fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4" style="pointer-events: none; opacity: 0;">
    <div class="modal-content w-full max-w-md rounded-2xl bg-white shadow-2xl">
      <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
        <h2 id="modal-title" class="font-heading text-xl font-bold text-slate-900">Ajouter une classe</h2>
        <button id="close-modal" type="button" class="rounded-lg p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-600">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <form id="class-form" class="p-6">
        <input type="hidden" id="class-id" value="">
        <div class="mb-4">
          <label class="mb-1 block text-sm font-medium text-slate-700">Nom de la classe *</label>
          <input type="text" id="class-name" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
        </div>
        <div class="mb-4">
          <label class="mb-1 block text-sm font-medium text-slate-700">Niveau *</label>
          <select id="class-level" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
            <option value="">Sélectionner un niveau</option>
            <option value="6ème">6ème</option>
            <option value="5ème">5ème</option>
            <option value="4ème">4ème</option>
            <option value="3ème">3ème</option>
            <option value="Seconde">Seconde</option>
            <option value="Première">Première</option>
            <option value="Terminale">Terminale</option>
            <option value="L1">L1 (Licence 1)</option>
            <option value="L2">L2 (Licence 2)</option>
            <option value="L3">L3 (Licence 3)</option>
          </select>
        </div>
        <div class="mb-4">
          <label class="mb-1 block text-sm font-medium text-slate-700">Établissement *</label>
          <select id="class-school" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
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
        <div class="mb-6">
          <label class="mb-1 block text-sm font-medium text-slate-700">Nombre d'élèves *</label>
          <input type="number" id="class-students" required min="0" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
        </div>
        <div class="flex gap-3">
          <button type="submit" class="flex-1 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90">Enregistrer</button>
          <button type="button" id="cancel-modal" class="flex-1 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Annuler</button>
        </div>
      </form>
    </div>
  </div>

  <!-- MODALE VISUALISATION DÉTAILS -->
  <div id="view-modal" class="modal-overlay fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4" style="pointer-events: none; opacity: 0;">
    <div class="modal-content w-full max-w-md rounded-2xl bg-white shadow-2xl">
      <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
        <h2 class="font-heading text-xl font-bold text-slate-900">Détails de la classe</h2>
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
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M7 16v-5M12 16V8m5 8V11" />
            </svg>
          </div>
        </div>
        <div class="mb-4">
          <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Classe</label>
          <p id="view-class-name" class="text-slate-900 font-medium">-</p>
        </div>
        <div class="mb-4">
          <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Niveau</label>
          <p id="view-class-level" class="text-slate-900">-</p>
        </div>
        <div class="mb-4">
          <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Établissement</label>
          <p id="view-class-school" class="text-slate-900">-</p>
        </div>
        <div class="mb-6">
          <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Nombre d'élèves</label>
          <p id="view-class-students" class="text-slate-900">-</p>
        </div>
        <button id="close-view-btn" type="button" class="w-full rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90">Fermer</button>
      </div>
    </div>
  </div>

  <script>
    (function () {
      // Données fictives des classes
      let classesData = [
        { id: 1, nom: "3ème A", niveau: "3ème", etablissement: "Collège Saint-Michel", eleves: 32 },
        { id: 2, nom: "Seconde C", niveau: "Seconde", etablissement: "Lycée Béhanzin", eleves: 45 },
        { id: 3, nom: "Terminale D", niveau: "Terminale", etablissement: "Université Partenaire Atlantique", eleves: 38 },
        { id: 4, nom: "CM2", niveau: "6ème", etablissement: "Complexe Les Lauriers", eleves: 28 },
        { id: 5, nom: "4ème B", niveau: "4ème", etablissement: "Cours Secondaire Ste Thérèse", eleves: 30 },
        { id: 6, nom: "Première A", niveau: "Première", etablissement: "Institut Technique de Porto-Novo", eleves: 36 },
        { id: 7, nom: "6ème A", niveau: "6ème", etablissement: "École Le Savoir", eleves: 25 },
        { id: 8, nom: "5ème C", niveau: "5ème", etablissement: "Groupe scolaire Les Phénix", eleves: 29 },
        { id: 9, nom: "L1 Maths", niveau: "L1", etablissement: "Faculté des Sciences Lokossa", eleves: 120 },
        { id: 10, nom: "3ème C", niveau: "3ème", etablissement: "Centre Maria-Goretti", eleves: 27 },
        { id: 11, nom: "Seconde A", niveau: "Seconde", etablissement: "Lycée Moderne de Parakou", eleves: 42 },
        { id: 12, nom: "Première B", niveau: "Première", etablissement: "Institut Cardinal Gantin", eleves: 33 }
      ];

      let nextId = 13;
      let filteredClasses = [...classesData];
      let perPage = 8;
      let currentPage = 1;
      let totalPages = 1;

      // Éléments DOM
      const searchInput = document.getElementById("class-search");
      const levelFilter = document.getElementById("filter-level");
      const schoolFilter = document.getElementById("filter-school-class");
      const resetBtn = document.getElementById("reset-filters");
      const tbody = document.getElementById("class-table-body");

      // Références modales
      const modal = document.getElementById("class-modal");
      const viewModal = document.getElementById("view-modal");
      const modalTitle = document.getElementById("modal-title");
      const classIdField = document.getElementById("class-id");
      const className = document.getElementById("class-name");
      const classLevel = document.getElementById("class-level");
      const classSchool = document.getElementById("class-school");
      const classStudents = document.getElementById("class-students");
      const classForm = document.getElementById("class-form");

      function applyFilters() {
        let searchTerm = searchInput.value.toLowerCase();
        let selectedLevel = levelFilter.value;
        let selectedSchool = schoolFilter.value;

        filteredClasses = classesData.filter(c => {
          let matchSearch = c.nom.toLowerCase().includes(searchTerm) ||
                            c.niveau.toLowerCase().includes(searchTerm) ||
                            c.etablissement.toLowerCase().includes(searchTerm);
          let matchLevel = selectedLevel === "" || c.niveau === selectedLevel;
          let matchSchool = selectedSchool === "" || c.etablissement === selectedSchool;
          return matchSearch && matchLevel && matchSchool;
        });
        totalPages = Math.max(1, Math.ceil(filteredClasses.length / perPage));
        if (currentPage > totalPages) currentPage = totalPages;
        renderTable();
        renderPagination();
      }

      function renderTable() {
        let start = (currentPage - 1) * perPage;
        let slice = filteredClasses.slice(start, start + perPage);
        if (slice.length === 0) {
          tbody.innerHTML = '<tr><td colspan="5" class="px-5 py-8 text-center text-slate-500">Aucune classe trouvée</td></tr>';
          return;
        }
        tbody.innerHTML = slice.map(c => `
          <tr>
            <td class="px-5 py-4 font-medium text-slate-900 sm:px-6">
              <div class="flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary/10">
                  <svg class="h-5 w-5 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16v-5M12 16V8m5 8V11" />
                  </svg>
                </div>
                <div>
                  <p class="font-medium">${escapeHtml(c.nom)}</p>
                </div>
              </div>
            </td>
            <td class="px-3 py-4">${escapeHtml(c.niveau)}</td>
            <td class="px-3 py-4">
              <div class="flex items-center gap-1.5">
                <svg class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5V8.25L12 4l8 4.25V19.5" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 19.5V12h6v7.5" />
                </svg>
                ${escapeHtml(c.etablissement)}
              </div>
            </td>
            <td class="px-3 py-4">
              <div class="flex items-center gap-1.5">
                <svg class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33" />
                </svg>
                ${c.eleves}
              </div>
            </td>
            <td class="px-5 py-4 text-right sm:px-6">
              <div class="flex flex-wrap justify-end gap-2">
                <button type="button" class="view-class-btn rounded-lg p-1.5 text-slate-500 hover:bg-slate-100 hover:text-primary transition" data-id="${c.id}" title="Voir détails">
                  <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                  </svg>
                </button>
                <button type="button" class="edit-class-btn rounded-lg bg-primary/10 px-2.5 py-1 text-xs font-semibold text-primary hover:bg-primary/20 transition" data-id="${c.id}">Modifier</button>
              </div>
            </td>
          </tr>
        `).join("");
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

      // Modale ajout / modification
      function openModal(editMode = false, classItem = null) {
        if (editMode && classItem) {
          modalTitle.textContent = "Modifier la classe";
          classIdField.value = classItem.id;
          className.value = classItem.nom;
          classLevel.value = classItem.niveau;
          classSchool.value = classItem.etablissement;
          classStudents.value = classItem.eleves;
        } else {
          modalTitle.textContent = "Ajouter une classe";
          classIdField.value = "";
          className.value = "";
          classLevel.value = "";
          classSchool.value = "";
          classStudents.value = "";
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

      function saveClass(event) {
        event.preventDefault();
        const id = parseInt(classIdField.value);
        const nom = className.value.trim();
        const niveau = classLevel.value;
        const etablissement = classSchool.value;
        const eleves = parseInt(classStudents.value);

        if (!nom || !niveau || !etablissement || isNaN(eleves)) {
          alert("Veuillez remplir tous les champs correctement.");
          return;
        }

        if (id) {
          const index = classesData.findIndex(c => c.id === id);
          if (index !== -1) {
            classesData[index] = { ...classesData[index], nom, niveau, etablissement, eleves };
          }
        } else {
          const newClass = { id: nextId++, nom, niveau, etablissement, eleves };
          classesData.push(newClass);
        }
        closeModal();
        applyFilters();
      }

      // Modale visualisation
      function openViewModal(classItem) {
        document.getElementById("view-class-name").textContent = classItem.nom;
        document.getElementById("view-class-level").textContent = classItem.niveau;
        document.getElementById("view-class-school").textContent = classItem.etablissement;
        document.getElementById("view-class-students").textContent = classItem.eleves;
        viewModal.style.pointerEvents = "auto";
        viewModal.style.opacity = "1";
        document.body.style.overflow = "hidden";
      }

      function closeViewModal() {
        viewModal.style.pointerEvents = "none";
        viewModal.style.opacity = "0";
        document.body.style.overflow = "";
      }

      // Événements
      document.getElementById("btn-add-class").addEventListener("click", () => openModal(false));
      document.getElementById("close-modal").addEventListener("click", closeModal);
      document.getElementById("cancel-modal").addEventListener("click", closeModal);
      modal.addEventListener("click", (e) => { if (e.target === modal) closeModal(); });
      classForm.addEventListener("submit", saveClass);

      document.getElementById("close-view-modal").addEventListener("click", closeViewModal);
      document.getElementById("close-view-btn").addEventListener("click", closeViewModal);
      viewModal.addEventListener("click", (e) => { if (e.target === viewModal) closeViewModal(); });

      // Filtres
      searchInput.addEventListener("input", () => { currentPage = 1; applyFilters(); });
      levelFilter.addEventListener("change", () => { currentPage = 1; applyFilters(); });
      schoolFilter.addEventListener("change", () => { currentPage = 1; applyFilters(); });
      resetBtn.addEventListener("click", () => {
        searchInput.value = "";
        levelFilter.value = "";
        schoolFilter.value = "";
        applyFilters();
      });

      // Délégation actions tableau
      document.getElementById("class-table-body").addEventListener("click", (e) => {
        let target = e.target.closest(".view-class-btn");
        if (target) {
          let id = parseInt(target.getAttribute("data-id"));
          let classItem = classesData.find(c => c.id === id);
          if (classItem) openViewModal(classItem);
          return;
        }
        target = e.target.closest(".edit-class-btn");
        if (target) {
          let id = parseInt(target.getAttribute("data-id"));
          let classItem = classesData.find(c => c.id === id);
          if (classItem) openModal(true, classItem);
          return;
        }
      });

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

      applyFilters();
    })();
  </script>
</body>
</html>
