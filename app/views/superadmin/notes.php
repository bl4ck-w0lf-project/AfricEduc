<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion des notes | EduManager</title>
  <meta name="description" content="Suivi des notes et performances scolaires — EduManager">

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
    /* Badges pour notes */
    .note-badge {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-width: 48px;
      padding: 0.25rem 0.5rem;
      border-radius: 9999px;
      font-size: 0.75rem;
      font-weight: 600;
    }
    .note-good { background-color: #dcfce7; color: #166534; }   /* vert : bon */
    .note-average { background-color: #fef9c3; color: #854d0e; } /* orange : moyen */
    .note-low { background-color: #fee2e2; color: #991b1b; }    /* rouge : faible */
  </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">
  <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden" aria-hidden="true"></div>

  <!-- SIDEBAR – IDENTIQUE -->
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
        <label for="global-search" class="sr-only">Rechercher élève / matière</label>
        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" /></svg>
        </span>
        <input id="global-search" type="search" placeholder="Rechercher un élève, une matière…"
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
          <h1 class="font-heading text-2xl font-bold text-slate-900 sm:text-3xl">Notes & résultats</h1>
          <p class="mt-1 text-sm text-slate-600">Suivi des évaluations par élève et matière</p>
        </div>
        <div class="mt-2 flex items-center gap-2">
          <div class="flex h-10 items-center gap-2 rounded-xl bg-white px-3 shadow-sm">
            <svg class="h-4 w-4 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
            <span class="text-sm font-medium text-slate-700">Moyenne générale :</span>
            <span id="global-average" class="text-lg font-bold text-primary">0.00</span>
            <span class="text-xs text-slate-500">/20</span>
          </div>
        </div>
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
          <svg class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
        </div>
        <div class="relative">
          <select id="filter-subject" class="appearance-none rounded-xl border border-slate-200 bg-white px-4 py-2 pr-8 text-sm text-slate-700 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
            <option value="">Toutes les matières</option>
            <option value="Mathématiques">Mathématiques</option>
            <option value="Français">Français</option>
            <option value="Anglais">Anglais</option>
            <option value="Physique-Chimie">Physique-Chimie</option>
            <option value="Histoire-Géo">Histoire-Géo</option>
            <option value="SVT">SVT</option>
          </select>
          <svg class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
        </div>
        <button id="reset-filters" type="button" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-50">Réinitialiser</button>
      </section>

      <!-- Tableau des notes (avec coefficient et moyenne élève) -->
      <section class="mt-6 overflow-hidden rounded-2xl border border-slate-200/90 bg-white shadow-sm">
        <div class="overflow-x-auto">
          <table class="min-w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
              <tr>
                <th class="whitespace-nowrap px-5 py-4 sm:px-6">Élève</th>
                <th class="whitespace-nowrap px-3 py-4">Matière</th>
                <th class="whitespace-nowrap px-3 py-4">Note /20</th>
                <th class="whitespace-nowrap px-3 py-4">Coefficient</th>
                <th class="whitespace-nowrap px-3 py-4">Moyenne élève</th>
                <th class="whitespace-nowrap px-5 py-4 text-right sm:px-6">Appréciation</th>
              </tr>
            </thead>
            <tbody id="grades-table-body" class="divide-y divide-slate-100 text-slate-700"></tbody>
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
        EduManager Super Admin · suivi des performances académiques
      </footer>
    </main>
  </div>

  <script>
    (function () {
      // ----- DONNÉES AVEC COEFFICIENTS -----
      // Mapping matière -> coefficient
      const coeffMap = {
        "Mathématiques": 3,
        "Français": 2,
        "Anglais": 2,
        "Physique-Chimie": 2,
        "Histoire-Géo": 1,
        "SVT": 1
      };

      // Notes avec coefficient et classe
      const gradesData = [
        { id: 1, eleve: "KOUADIO Marie", classe: "3ème", matiere: "Mathématiques", note: 15.5, coeff: coeffMap["Mathématiques"] },
        { id: 2, eleve: "KOUADIO Marie", classe: "3ème", matiere: "Français", note: 14.0, coeff: coeffMap["Français"] },
        { id: 3, eleve: "KOUADIO Marie", classe: "3ème", matiere: "Anglais", note: 16.0, coeff: coeffMap["Anglais"] },
        { id: 4, eleve: "TRAORÉ Ibrahim", classe: "Seconde", matiere: "Mathématiques", note: 12.0, coeff: coeffMap["Mathématiques"] },
        { id: 5, eleve: "TRAORÉ Ibrahim", classe: "Seconde", matiere: "Physique-Chimie", note: 11.5, coeff: coeffMap["Physique-Chimie"] },
        { id: 6, eleve: "DIALLO Aminata", classe: "Terminale", matiere: "Mathématiques", note: 18.0, coeff: coeffMap["Mathématiques"] },
        { id: 7, eleve: "DIALLO Aminata", classe: "Terminale", matiere: "SVT", note: 17.5, coeff: coeffMap["SVT"] },
        { id: 8, eleve: "N'GUESSAN Koffi", classe: "4ème", matiere: "Histoire-Géo", note: 13.0, coeff: coeffMap["Histoire-Géo"] },
        { id: 9, eleve: "HOUNDONOU Jules", classe: "5ème", matiere: "Français", note: 9.5, coeff: coeffMap["Français"] },
        { id: 10, eleve: "AGOSSOU Bénédicte", classe: "Première", matiere: "Mathématiques", note: 14.5, coeff: coeffMap["Mathématiques"] },
        { id: 11, eleve: "AGOSSOU Bénédicte", classe: "Première", matiere: "Physique-Chimie", note: 13.0, coeff: coeffMap["Physique-Chimie"] },
        { id: 12, eleve: "DOSSOU Gabin", classe: "6ème", matiere: "Français", note: 11.0, coeff: coeffMap["Français"] },
        { id: 13, eleve: "BIO Karim", classe: "5ème", matiere: "Mathématiques", note: 8.5, coeff: coeffMap["Mathématiques"] },
        { id: 14, eleve: "ZINSOU Espoir", classe: "Terminale", matiere: "Anglais", note: 15.0, coeff: coeffMap["Anglais"] },
        { id: 15, eleve: "AÏSSI Pélagie", classe: "3ème", matiere: "SVT", note: 14.0, coeff: coeffMap["SVT"] }
      ];

      let filteredData = [...gradesData];
      let perPage = 8;
      let currentPage = 1;
      let totalPages = 1;

      // Éléments DOM
      const classFilter = document.getElementById("filter-class");
      const subjectFilter = document.getElementById("filter-subject");
      const searchInput = document.getElementById("global-search");
      const resetBtn = document.getElementById("reset-filters");
      const tbody = document.getElementById("grades-table-body");
      const globalAvgSpan = document.getElementById("global-average");

      // Fonction pour obtenir la classe CSS selon la note (vert/orange/rouge)
      function getNoteBadge(note) {
        if (note >= 12) return '<span class="note-badge note-good">Bon</span>';
        if (note >= 10) return '<span class="note-badge note-average">Moyen</span>';
        return '<span class="note-badge note-low">Faible</span>';
      }

      // Calcul de la moyenne générale (toutes notes affichées, non pondérée)
      function updateGlobalAverage() {
        if (filteredData.length === 0) {
          globalAvgSpan.textContent = "0.00";
          return;
        }
        const sum = filteredData.reduce((acc, g) => acc + g.note, 0);
        const avg = sum / filteredData.length;
        globalAvgSpan.textContent = avg.toFixed(2);
      }

      // Calcul de la moyenne pondérée pour un élève donné (toutes ses matières)
      function getStudentWeightedAverage(eleveName) {
        // toutes les notes de l'élève dans les données brutes (non filtrées)
        const studentNotes = gradesData.filter(g => g.eleve === eleveName);
        if (studentNotes.length === 0) return 0;
        let totalWeighted = 0;
        let totalCoeff = 0;
        studentNotes.forEach(n => {
          totalWeighted += n.note * n.coeff;
          totalCoeff += n.coeff;
        });
        return totalCoeff ? (totalWeighted / totalCoeff) : 0;
      }

      // Appliquer tous les filtres (classe, matière, recherche)
      function applyFilters() {
        const selectedClass = classFilter.value;
        const selectedSubject = subjectFilter.value;
        const searchTerm = searchInput.value.toLowerCase();

        filteredData = gradesData.filter(item => {
          let matchClass = selectedClass === "" || item.classe === selectedClass;
          let matchSubject = selectedSubject === "" || item.matiere === selectedSubject;
          let matchSearch = searchTerm === "" || item.eleve.toLowerCase().includes(searchTerm) || item.matiere.toLowerCase().includes(searchTerm);
          return matchClass && matchSubject && matchSearch;
        });

        totalPages = Math.max(1, Math.ceil(filteredData.length / perPage));
        if (currentPage > totalPages) currentPage = totalPages;
        renderTable();
        renderPagination();
        updateGlobalAverage();
      }

      // Rendu du tableau
      function renderTable() {
        if (!tbody) return;
        const start = (currentPage - 1) * perPage;
        const slice = filteredData.slice(start, start + perPage);
        if (slice.length === 0) {
          tbody.innerHTML = '<tr><td colspan="6" class="px-5 py-8 text-center text-slate-500">Aucune note correspondante</td></tr>';
          return;
        }
        tbody.innerHTML = slice.map(item => {
          const studentAvg = getStudentWeightedAverage(item.eleve);
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
                    <p class="font-medium">${escapeHtml(item.eleve)}</p>
                    <p class="text-xs text-slate-500">${escapeHtml(item.classe)}</p>
                  </div>
                </div>
               </td>
              <td class="px-3 py-4">
                <div class="flex items-center gap-1.5">
                  <svg class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16v-5M12 16V8m5 8V11" />
                  </svg>
                  ${escapeHtml(item.matiere)}
                </div>
               </td>
              <td class="px-3 py-4">
                <div class="flex items-center gap-2">
                  <span class="font-bold text-slate-900">${item.note.toFixed(1)}</span>
                  <span class="text-xs text-slate-400">/20</span>
                  ${getNoteBadge(item.note)}
                </div>
               </td>
              <td class="px-3 py-4">
                <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-700">coeff ${item.coeff}</span>
               </td>
              <td class="px-3 py-4 font-semibold text-primary">${studentAvg.toFixed(1)} / 20</td>
              <td class="px-5 py-4 text-right sm:px-6">
                <div class="flex justify-end">
                  <span class="inline-flex items-center gap-1 rounded-full bg-primary/10 px-2.5 py-1 text-xs font-medium text-primary">
                    <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    ${item.note >= 10 ? 'Au-dessus moyenne' : 'En dessous moyenne'}
                  </span>
                </div>
               </td>
             `
        }).join("");
        document.getElementById("total-pages").textContent = totalPages;
        document.getElementById("page-info").innerHTML = "Page " + currentPage + " sur " + totalPages;
        const prevBtn = document.getElementById("pager-prev");
        const nextBtn = document.getElementById("pager-next");
        if (prevBtn) prevBtn.disabled = currentPage <= 1;
        if (nextBtn) nextBtn.disabled = currentPage >= totalPages;
      }

      function renderPagination() {
        const numsContainer = document.getElementById("pager-numbers");
        if (!numsContainer) return;
        numsContainer.innerHTML = "";
        for (let p = 1; p <= totalPages; p++) {
          const btn = document.createElement("button");
          btn.type = "button";
          btn.textContent = String(p);
          btn.className = "h-8 min-w-[2rem] rounded-lg text-xs font-semibold transition " +
            (p === currentPage ? "bg-primary text-white" : "border border-slate-200 text-slate-700 hover:bg-slate-50");
          btn.addEventListener("click", (function(page) {
            return function() {
              currentPage = page;
              renderTable();
              renderPagination();
            };
          })(p));
          numsContainer.appendChild(btn);
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

      // Écouteurs d'événements
      if (classFilter) classFilter.addEventListener("change", () => { currentPage = 1; applyFilters(); });
      if (subjectFilter) subjectFilter.addEventListener("change", () => { currentPage = 1; applyFilters(); });
      if (searchInput) searchInput.addEventListener("input", () => { currentPage = 1; applyFilters(); });
      if (resetBtn) resetBtn.addEventListener("click", () => {
        if (classFilter) classFilter.value = "";
        if (subjectFilter) subjectFilter.value = "";
        if (searchInput) searchInput.value = "";
        applyFilters();
      });

      // Pagination buttons
      const prevBtn = document.getElementById("pager-prev");
      const nextBtn = document.getElementById("pager-next");
      if (prevBtn) prevBtn.addEventListener("click", () => { if (currentPage > 1) { currentPage--; renderTable(); renderPagination(); } });
      if (nextBtn) nextBtn.addEventListener("click", () => { if (currentPage < totalPages) { currentPage++; renderTable(); renderPagination(); } });

      // Sidebar / menu mobile
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

      // Initialisation
      applyFilters();
    })();
  </script>
</body>
</html>
