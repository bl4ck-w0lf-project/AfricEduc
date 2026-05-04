<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion des établissements | EduManager</title>
  <meta name="description" content="Gestion des établissements scolaires sur EduManager — Afrique de l'Ouest">

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
      <a href="dashboard_superadmin.php" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h3A2.25 2.25 0 0 1 11.25 6v3A2.25 2.25 0 0 1 9 11.25H6A2.25 2.25 0 0 1 3.75 9V6Z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6A2.25 2.25 0 0 1 15.75 3.75h3A2.25 2.25 0 0 1 21 6v3A2.25 2.25 0 0 1 18.75 11.25h-3A2.25 2.25 0 0 1 13.5 9V6Z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 15A2.25 2.25 0 0 1 6 12.75h3A2.25 2.25 0 0 1 11.25 15v3A2.25 2.25 0 0 1 9 20.25H6A2.25 2.25 0 0 1 3.75 18v-3Z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 15A2.25 2.25 0 0 1 15.75 12.75h3A2.25 2.25 0 0 1 21 15v3A2.25 2.25 0 0 1 18.75 20.25h-3A2.25 2.25 0 0 1 13.5 18v-3Z" />
        </svg>
        Dashboard
      </a>
      <a href="etablissement.php" class="sidebar-link active flex items-center gap-3 rounded-xl px-3 py-2.5">
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
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M7 16v-5M12 16V8m5 8V11" />
        </svg>
        Statistiques globales
      </a>
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 3.084-1.756 3.51 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 3.084 0 3.51a1.724 1.724 0 0 0-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0-2.572 1.065c-.426 1.756-3.084 1.756-3.51 0a1.724 1.724 0 0 0-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0-1.065-2.572c-1.756-.426-1.756-3.084 0-3.51a1.724 1.724 0 0 0 1.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065Z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
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
    <header class="sticky top-0 z-30 flex h-16 items-center gap-4 border-b border-slate-200/90 bg-white px-4 shadow-sm backdrop-blur-sm sm:px-6">
      <button type="button" id="btn-menu" class="inline-flex rounded-xl border border-slate-200 p-2 text-slate-700 hover:bg-slate-50 lg:hidden" aria-label="Ouvrir le menu">
        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
      </button>

      <div class="relative min-w-0 flex-1">
        <label for="global-search" class="sr-only">Rechercher un établissement</label>
        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" /></svg>
        </span>
        <input id="global-search" type="search" placeholder="Rechercher un établissement, une ville…"
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
          <h1 class="font-heading text-2xl font-bold text-slate-900 sm:text-3xl">Gestion des établissements</h1>
          <p class="mt-1 text-sm text-slate-600">Gérez l'ensemble des écoles inscrites sur EduManager</p>
        </div>
        <button id="btn-new-school" type="button" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90">
          <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
          </svg>
          Nouvel établissement
        </button>
      </div>

      <!-- Filtres -->
      <section class="mt-6 flex flex-wrap gap-3">
        <div class="relative">
          <select id="filter-city" class="appearance-none rounded-xl border border-slate-200 bg-white px-4 py-2 pr-8 text-sm text-slate-700 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
            <option value="">Toutes les villes</option>
            <option value="Cotonou">Cotonou</option>
            <option value="Porto-Novo">Porto-Novo</option>
            <option value="Abomey-Calavi">Abomey-Calavi</option>
            <option value="Parakou">Parakou</option>
            <option value="Lokossa">Lokossa</option>
          </select>
          <svg class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
          </svg>
        </div>

        <div class="relative">
          <select id="filter-status" class="appearance-none rounded-xl border border-slate-200 bg-white px-4 py-2 pr-8 text-sm text-slate-700 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
            <option value="">Tous les statuts</option>
            <option value="actif">Actif</option>
            <option value="inactif">Inactif</option>
          </select>
          <svg class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
          </svg>
        </div>

        <button id="reset-filters" type="button" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
          Réinitialiser
        </button>
      </section>

      <!-- Tableau des établissements -->
      <section class="mt-6 overflow-hidden rounded-2xl border border-slate-200/90 bg-white shadow-sm">
        <div class="overflow-x-auto">
          <table class="min-w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
              <tr>
                <th class="whitespace-nowrap px-5 py-4 sm:px-6">Établissement</th>
                <th class="whitespace-nowrap px-3 py-4">Ville</th>
                <th class="whitespace-nowrap px-3 py-4">Élèves</th>
                <th class="whitespace-nowrap px-3 py-4">Classes</th>
                <th class="whitespace-nowrap px-3 py-4">Statut</th>
                <th class="whitespace-nowrap px-5 py-4 text-right sm:px-6">Actions</th>
              </tr>
            </thead>
            <tbody id="table-body" class="divide-y divide-slate-100 text-slate-700"></tbody>
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
        EduManager Super Admin · Gestion des établissements
      </footer>
    </main>
  </div>

  <!-- MODALE AJOUT / MODIFICATION -->
  <div id="school-modal" class="modal-overlay fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4" style="pointer-events: none; opacity: 0;">
    <div class="modal-content w-full max-w-md rounded-2xl bg-white shadow-2xl">
      <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
        <h2 id="modal-title" class="font-heading text-xl font-bold text-slate-900">Ajouter un établissement</h2>
        <button id="close-modal" type="button" class="rounded-lg p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-600">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <form id="school-form" class="p-6">
        <input type="hidden" id="school-id" value="">
        <div class="mb-4">
          <label class="mb-1 block text-sm font-medium text-slate-700">Nom de l'établissement *</label>
          <input type="text" id="school-name" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
        </div>
        <div class="mb-4">
          <label class="mb-1 block text-sm font-medium text-slate-700">Ville *</label>
          <select id="school-city" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
            <option value="">Sélectionner une ville</option>
            <option value="Cotonou">Cotonou</option>
            <option value="Porto-Novo">Porto-Novo</option>
            <option value="Abomey-Calavi">Abomey-Calavi</option>
            <option value="Parakou">Parakou</option>
            <option value="Lokossa">Lokossa</option>
          </select>
        </div>
        <div class="mb-4">
          <label class="mb-1 block text-sm font-medium text-slate-700">Nombre d'élèves *</label>
          <input type="number" id="school-eleves" required min="0" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
        </div>
        <div class="mb-4">
          <label class="mb-1 block text-sm font-medium text-slate-700">Nombre de classes *</label>
          <input type="number" id="school-classes" required min="0" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
        </div>
        <div class="mb-6">
          <label class="mb-1 block text-sm font-medium text-slate-700">Statut</label>
          <select id="school-status" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
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

  <!-- MODALE CONSULTATION (DÉTAILS) -->
  <div id="view-modal" class="modal-overlay fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4" style="pointer-events: none; opacity: 0;">
    <div class="modal-content w-full max-w-md rounded-2xl bg-white shadow-2xl">
      <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
        <h2 class="font-heading text-xl font-bold text-slate-900">Détails de l'établissement</h2>
        <button id="close-view-modal" type="button" class="rounded-lg p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-600">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <div class="p-6">
        <div class="mb-4">
          <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Nom</label>
          <p id="view-name" class="text-slate-900 font-medium">-</p>
        </div>
        <div class="mb-4">
          <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Ville</label>
          <p id="view-city" class="text-slate-900">-</p>
        </div>
        <div class="mb-4">
          <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Nombre d'élèves</label>
          <p id="view-eleves" class="text-slate-900">-</p>
        </div>
        <div class="mb-4">
          <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Nombre de classes</label>
          <p id="view-classes" class="text-slate-900">-</p>
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
      // Données des établissements (avec ID auto-incrémenté)
      let schoolsData = [
        { id: 1, nom: "Collège Saint-Michel", ville: "Cotonou", eleves: 612, classes: 24, statut: "actif" },
        { id: 2, nom: "Lycée Béhanzin", ville: "Porto-Novo", eleves: 892, classes: 32, statut: "actif" },
        { id: 3, nom: "Complexe Les Lauriers", ville: "Cotonou", eleves: 445, classes: 18, statut: "actif" },
        { id: 4, nom: "Université Partenaire Atlantique", ville: "Abomey-Calavi", eleves: 1240, classes: 45, statut: "actif" },
        { id: 5, nom: "Cours Secondaire Ste Thérèse", ville: "Parakou", eleves: 328, classes: 14, statut: "inactif" },
        { id: 6, nom: "Institut Technique de Porto-Novo", ville: "Porto-Novo", eleves: 756, classes: 28, statut: "actif" },
        { id: 7, nom: "École Le Savoir", ville: "Cotonou", eleves: 189, classes: 9, statut: "actif" },
        { id: 8, nom: "Groupe scolaire Les Phénix", ville: "Lokossa", eleves: 512, classes: 20, statut: "inactif" },
        { id: 9, nom: "Faculté des Sciences Lokossa", ville: "Lokossa", eleves: 2104, classes: 68, statut: "actif" },
        { id: 10, nom: "Centre Maria-Goretti", ville: "Cotonou", eleves: 267, classes: 12, statut: "actif" },
        { id: 11, nom: "Lycée Moderne de Parakou", ville: "Parakou", eleves: 1340, classes: 48, statut: "actif" },
        { id: 12, nom: "Institut Cardinal Gantin", ville: "Abomey-Calavi", eleves: 890, classes: 34, statut: "actif" }
      ];

      let nextId = 13;

      let filteredData = [...schoolsData];
      let perPage = 8;
      let currentPage = 1;
      let totalPages = 1;

      let cityFilter = "";
      let statusFilter = "";

      // Références modales
      const modal = document.getElementById("school-modal");
      const viewModal = document.getElementById("view-modal");
      const modalTitle = document.getElementById("modal-title");
      const schoolIdField = document.getElementById("school-id");
      const schoolName = document.getElementById("school-name");
      const schoolCity = document.getElementById("school-city");
      const schoolEleves = document.getElementById("school-eleves");
      const schoolClasses = document.getElementById("school-classes");
      const schoolStatus = document.getElementById("school-status");
      const schoolForm = document.getElementById("school-form");

      // Fonction pour appliquer filtres + recherche
      function applyFilters() {
        let filtered = schoolsData.filter(function(school) {
          let matchCity = cityFilter === "" || school.ville === cityFilter;
          let matchStatus = statusFilter === "" || school.statut === statusFilter;
          return matchCity && matchStatus;
        });
        const searchTerm = document.getElementById("global-search").value.toLowerCase();
        if (searchTerm) {
          filtered = filtered.filter(function(school) {
            return school.nom.toLowerCase().includes(searchTerm) || school.ville.toLowerCase().includes(searchTerm);
          });
        }
        filteredData = filtered;
        totalPages = Math.max(1, Math.ceil(filteredData.length / perPage));
        // Ajuster currentPage si dépasse
        if (currentPage > totalPages) currentPage = totalPages;
        renderTable();
        renderPagination();
      }

      function getStatusBadge(statut) {
        if (statut === "actif") {
          return '<span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-800"><span class="relative flex h-2 w-2"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span></span>Actif</span>';
        } else {
          return '<span class="rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">Inactif</span>';
        }
      }

      function actionButtonsHtml(schoolId, currentStatus) {
        let statusBtn = currentStatus === "actif" 
          ? '<button type="button" class="desactivate-btn rounded-lg border border-red-200 bg-red-50 px-2 py-1 text-xs font-semibold text-red-700 hover:bg-red-100 transition" data-id="' + schoolId + '">Désactiver</button>'
          : '<button type="button" class="activate-btn rounded-lg bg-emerald-600 px-2 py-1 text-xs font-semibold text-white hover:bg-emerald-700 transition" data-id="' + schoolId + '">Activer</button>';
        
        return (
          '<div class="flex flex-wrap justify-end gap-2">' +
          '<button type="button" class="view-details-btn group rounded-lg p-1.5 text-slate-500 hover:bg-slate-100 hover:text-primary transition" data-id="' + schoolId + '" title="Voir détails">' +
          '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">' +
          '<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />' +
          '<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />' +
          '</svg></button>' +
          '<button type="button" class="edit-btn rounded-lg bg-primary/10 px-2.5 py-1 text-xs font-semibold text-primary hover:bg-primary/20 transition" data-id="' + schoolId + '">Modifier</button>' +
          statusBtn +
          '</div>'
        );
      }

      function renderTable() {
        let body = document.getElementById("table-body");
        let start = (currentPage - 1) * perPage;
        let slice = filteredData.slice(start, start + perPage);
        
        if (slice.length === 0) {
          body.innerHTML = '<tr><td colspan="6" class="px-5 py-8 text-center text-slate-500">Aucun établissement trouvé</td></tr>';
          return;
        }
        
        body.innerHTML = slice
          .map(function (school) {
            return (
              "<tr>" +
              '<td class="px-5 py-4 font-medium text-slate-900 sm:px-6">' +
              '<div class="flex items-center gap-3">' +
              '<div class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary/10">' +
              '<svg class="h-5 w-5 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">' +
              '<path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5V8.25L12 4l8 4.25V19.5" />' +
              '<path stroke-linecap="round" stroke-linejoin="round" d="M9 19.5V12h6v7.5" />' +
              '</svg>' +
              '</div>' +
              '<span>' + escapeHtml(school.nom) + '</span>' +
              '</div>' +
              '</td>' +
              '<td class="px-3 py-4"><div class="flex items-center gap-1.5"><svg class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25s-7.5-4.108-7.5-11.25a7.5 7.5 0 1 1 15 0Z" /></svg>' + escapeHtml(school.ville) + '</div></td>' +
              '<td class="px-3 py-4"><div class="flex items-center gap-1.5"><svg class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>' + school.eleves.toLocaleString("fr-FR") + '</div></td>' +
              '<td class="px-3 py-4"><div class="flex items-center gap-1.5"><svg class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18" /><path stroke-linecap="round" stroke-linejoin="round" d="M7 16v-5M12 16V8m5 8V11" /></svg>' + school.classes + '</div></td>' +
              '<td class="px-3 py-4">' + getStatusBadge(school.statut) + '</td>' +
              '<td class="px-5 py-4 text-right sm:px-6">' + actionButtonsHtml(school.id, school.statut) + '</td>' +
              "</tr>"
            );
          })
          .join("");
        
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
          b.className =
            "h-8 min-w-[2rem] rounded-lg text-xs font-semibold transition " +
            (p === currentPage ? "bg-primary text-white" : "border border-slate-200 text-slate-700 hover:bg-slate-50");
          b.addEventListener("click", (function (page) {
            return function () {
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

      // Gestion de la modale d'ajout/modification
      function openModal(editMode = false, school = null) {
        if (editMode && school) {
          modalTitle.textContent = "Modifier l'établissement";
          schoolIdField.value = school.id;
          schoolName.value = school.nom;
          schoolCity.value = school.ville;
          schoolEleves.value = school.eleves;
          schoolClasses.value = school.classes;
          schoolStatus.value = school.statut;
        } else {
          modalTitle.textContent = "Ajouter un établissement";
          schoolIdField.value = "";
          schoolName.value = "";
          schoolCity.value = "";
          schoolEleves.value = "";
          schoolClasses.value = "";
          schoolStatus.value = "actif";
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

      // Gestion de la modale de visualisation
      function openViewModal(school) {
        document.getElementById("view-name").textContent = school.nom;
        document.getElementById("view-city").textContent = school.ville;
        document.getElementById("view-eleves").textContent = school.eleves.toLocaleString("fr-FR");
        document.getElementById("view-classes").textContent = school.classes;
        document.getElementById("view-status").innerHTML = getStatusBadge(school.statut);
        viewModal.style.pointerEvents = "auto";
        viewModal.style.opacity = "1";
        document.body.style.overflow = "hidden";
      }

      function closeViewModal() {
        viewModal.style.pointerEvents = "none";
        viewModal.style.opacity = "0";
        document.body.style.overflow = "";
      }

      // Sauvegarde (ajout ou modification)
      function saveSchool(event) {
        event.preventDefault();
        const id = parseInt(schoolIdField.value);
        const nom = schoolName.value.trim();
        const ville = schoolCity.value;
        const eleves = parseInt(schoolEleves.value);
        const classes = parseInt(schoolClasses.value);
        const statut = schoolStatus.value;

        if (!nom || !ville || isNaN(eleves) || isNaN(classes)) {
          alert("Veuillez remplir tous les champs correctement.");
          return;
        }

        if (id) {
          // Modification
          const index = schoolsData.findIndex(s => s.id === id);
          if (index !== -1) {
            schoolsData[index] = { ...schoolsData[index], nom, ville, eleves, classes, statut };
          }
        } else {
          // Ajout
          const newSchool = {
            id: nextId++,
            nom,
            ville,
            eleves,
            classes,
            statut
          };
          schoolsData.push(newSchool);
        }
        closeModal();
        applyFilters();
      }

      // Écouteurs des filtres
      document.getElementById("filter-city").addEventListener("change", function (e) {
        cityFilter = e.target.value;
        applyFilters();
      });

      document.getElementById("filter-status").addEventListener("change", function (e) {
        statusFilter = e.target.value;
        applyFilters();
      });

      document.getElementById("reset-filters").addEventListener("click", function () {
        cityFilter = "";
        statusFilter = "";
        document.getElementById("filter-city").value = "";
        document.getElementById("filter-status").value = "";
        document.getElementById("global-search").value = "";
        applyFilters();
      });

      // Recherche globale
      const searchInput = document.getElementById("global-search");
      if (searchInput) {
        searchInput.addEventListener("input", function () {
          applyFilters();
        });
      }

      // Délégation d'événements pour les actions du tableau
      document.getElementById("table-body").addEventListener("click", function (e) {
        let target = e.target.closest(".view-details-btn");
        if (target) {
          let id = parseInt(target.getAttribute("data-id"));
          let school = schoolsData.find(s => s.id === id);
          if (school) openViewModal(school);
          return;
        }
        
        target = e.target.closest(".edit-btn");
        if (target) {
          let id = parseInt(target.getAttribute("data-id"));
          let school = schoolsData.find(s => s.id === id);
          if (school) openModal(true, school);
          return;
        }
        
        target = e.target.closest(".activate-btn");
        if (target) {
          let id = parseInt(target.getAttribute("data-id"));
          let school = schoolsData.find(s => s.id === id);
          if (school && school.statut === "inactif") {
            school.statut = "actif";
            applyFilters();
          }
          return;
        }
        
        target = e.target.closest(".desactivate-btn");
        if (target) {
          let id = parseInt(target.getAttribute("data-id"));
          let school = schoolsData.find(s => s.id === id);
          if (school && school.statut === "actif") {
            school.statut = "inactif";
            applyFilters();
          }
          return;
        }
      });

      // Nouvel établissement
      document.getElementById("btn-new-school").addEventListener("click", function () {
        openModal(false, null);
      });

      // Fermeture modales
      document.getElementById("close-modal").addEventListener("click", closeModal);
      document.getElementById("cancel-modal").addEventListener("click", closeModal);
      modal.addEventListener("click", function(e) {
        if (e.target === modal) closeModal();
      });
      schoolForm.addEventListener("submit", saveSchool);

      // Fermeture modale de visualisation
      document.getElementById("close-view-modal").addEventListener("click", closeViewModal);
      document.getElementById("close-view-btn").addEventListener("click", closeViewModal);
      viewModal.addEventListener("click", function(e) {
        if (e.target === viewModal) closeViewModal();
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
      window.addEventListener("resize", function () {
        if (window.innerWidth >= 1024) closeMenu();
      });

      // Pagination buttons
      document.getElementById("pager-prev").addEventListener("click", function () {
        if (currentPage > 1) {
          currentPage--;
          renderTable();
          renderPagination();
        }
      });
      document.getElementById("pager-next").addEventListener("click", function () {
        if (currentPage < totalPages) {
          currentPage++;
          renderTable();
          renderPagination();
        }
      });

      // Initialisation
      applyFilters();
    })();
  </script>
</body>
</html>
