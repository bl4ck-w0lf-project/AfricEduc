<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EduManager · Notes & Moyennes</title>
  <meta name="description" content="Consultation des notes - données calculées automatiquement.">

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: "#7300e9",
            "primary-dark": "#5c00ba",
            accent: "#99fbe3",
            "accent-dark": "#6ee7d6",
            urgent: "#ef4444",
            warning: "#f59e0b",
            success: "#10b981",
            info: "#3b82f6"
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
    body { font-family: "Outfit", sans-serif; }
    h1, h2, h3, .font-heading { font-family: "Quicksand", sans-serif; }
    .sidebar-link { transition: all 0.2s ease; }
    .sidebar-link--active { background-color: rgba(153, 251, 227, 0.2); color: #99fbe3; }
    .sidebar-link:hover:not(.sidebar-link--locked) { background-color: rgba(255, 255, 255, 0.1); transform: translateX(4px); }
    #sidebar-overlay { pointer-events: none; opacity: 0; transition: opacity 0.2s ease; }
    #sidebar-overlay.is-open { pointer-events: auto; opacity: 1; }
    .kpi-card { transition: all 0.2s ease; }
    .kpi-card:hover { transform: translateY(-2px); box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.02); }
    .action-button { transition: all 0.2s ease; }
    .action-button:hover { transform: scale(1.05); }
    .modal-overlay {
      pointer-events: none; opacity: 0; transition: opacity 0.2s ease;
      position: fixed; inset: 0; z-index: 9999; background: rgba(0,0,0,0.5);
      display: flex; align-items: center; justify-content: center;
    }
    .modal-overlay.is-open { pointer-events: auto; opacity: 1; }
    .modal-content {
      transform: scale(0.95); transition: transform 0.2s ease;
      max-width: 90%; width: 42rem; background: white; border-radius: 1rem;
      box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); max-height: 85vh; overflow-y: auto;
    }
    .modal-overlay.is-open .modal-content { transform: scale(1); }
    .toast {
      position: fixed; bottom: 20px; right: 20px; background: #1e293b; color: white;
      padding: 12px 20px; border-radius: 12px; font-size: 0.875rem; z-index: 10000;
      opacity: 0; transition: opacity 0.3s; pointer-events: none;
    }
    .toast.show { opacity: 1; }
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-slate-50 to-slate-100 text-slate-800 antialiased">
  <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden"></div>

  <!-- Sidebar -->
  <aside id="sidebar" class="fixed left-0 top-0 z-50 flex h-full w-[280px] -translate-x-full flex-col border-r border-white/10 bg-gradient-to-b from-primary to-primary-dark text-white shadow-2xl transition-transform duration-300 lg:translate-x-0">
    <div class="flex h-16 items-center gap-3 border-b border-white/15 px-5">
      <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/20 backdrop-blur-sm">
        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6.75C4 5.78 4.78 5 5.75 5h4.5c.46 0 .9.18 1.22.51l.56.56c.33.33.77.51 1.24.51h5.98c.97 0 1.75.78 1.75 1.75v8.92c0 .97-.78 1.75-1.75 1.75H5.75A1.75 1.75 0 0 1 4 17.25V6.75Z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M8 11.5h8M8 14.5h5" />
        </svg>
      </span>
      <div>
        <span class="font-heading block text-sm font-bold tracking-tight">EduManager</span>
        <span class="text-[10px] font-medium uppercase tracking-wider text-white/70">Espace agent · Notes</span>
      </div>
    </div>

    <nav class="flex-1 space-y-0.5 overflow-y-auto px-3 py-6 text-sm" aria-label="Navigation agent">
      <a href="dashboard_agent.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0 opacity-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h3A2.25 2.25 0 0 1 11.25 6v3A2.25 2.25 0 0 1 9 11.25H6A2.25 2.25 0 0 1 3.75 9V6ZM13.5 6A2.25 2.25 0 0 1 15.75 3.75h3A2.25 2.25 0 0 1 21 6v3A2.25 2.25 0 0 1 18.75 11.25h-3A2.25 2.25 0 0 1 13.5 9V6ZM3.75 15A2.25 2.25 0 0 1 6 12.75h3A2.25 2.25 0 0 1 11.25 15v3A2.25 2.25 0 0 1 9 20.25H6A2.25 2.25 0 0 1 3.75 18v-3ZM13.5 15A2.25 2.25 0 0 1 15.75 12.75h3A2.25 2.25 0 0 1 21 15v3A2.25 2.25 0 0 1 18.75 20.25h-3A2.25 2.25 0 0 1 13.5 18v-3Z" /></svg>
        Tableau de bord
      </a>
      <a href="eleves.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0 opacity-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 0 0-4-4H8m0 0a4 4 0 0 1 8 0m-9 0a4 4 0 1 1 8 0M12 3a4 4 0 1 0 0 8 4 4 0 0 0 0-8Z" /></svg>
        Élèves
      </a>
      <a href="notes.html" class="sidebar-link sidebar-link--active flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0 opacity-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6.5h16M6.5 4v5M17.5 4v5M5.75 20h12.5A1.75 1.75 0 0 0 20 18.25V7.75A1.75 1.75 0 0 0 18.25 6H5.75A1.75 1.75 0 0 0 4 7.75v10.5C4 19.22 4.78 20 5.75 20Z" /></svg>
        Notes & Moyennes
      </a>
      <a href="paiements.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0 opacity-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.5 8.5h17M6 5h12a2.5 2.5 0 0 1 2.5 2.5v9A2.5 2.5 0 0 1 18 19H6a2.5 2.5 0 0 1-2.5-2.5v-9A2.5 2.5 0 0 1 6 5Z" /><path stroke-linecap="round" d="M7.5 14h4M7.5 11h9" /></svg>
        Paiements
      </a>
      <a href="bulletins.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0 opacity-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3.75h10.5l3 4.5v9.75a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25l3-4.5Z" /><path stroke-linecap="round" d="M9 12h6M9 15.75h3" /></svg>
        Bulletins
      </a>
      <div class="mt-8 border-t border-white/15 pt-4">
        <a href="login.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 text-red-200 transition-all hover:bg-red-500/20 hover:text-white">
          <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" /></svg>
          Déconnexion
        </a>
      </div>
    </nav>
  </aside>

  <!-- Main content -->
  <div class="min-h-screen lg:pl-[280px]">
    <header class="sticky top-0 z-30 flex h-16 items-center justify-between gap-4 border-b border-slate-200/80 bg-white/95 px-4 backdrop-blur-md sm:px-6 shadow-sm">
      <div class="flex items-center gap-3">
        <button type="button" id="btn-menu" class="inline-flex rounded-xl border border-slate-200 p-2 text-slate-700 hover:bg-slate-50 lg:hidden transition-all" aria-label="Ouvrir le menu">
          <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
        </button>
        <div>
          <p class="font-heading text-sm font-semibold text-primary sm:text-base">Collège Saint-Michel</p>
          <p class="text-xs text-slate-500">Cotonou · Gestion des notes</p>
        </div>
      </div>
      <div class="flex items-center gap-3">
        <button type="button" class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-2 py-1.5 pr-3 shadow-sm transition-all hover:border-primary/30 hover:shadow-md">
          <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-accent to-accent-dark text-sm font-bold text-primary">JM</span>
          <span class="hidden text-left text-sm sm:block">
            <span class="block font-medium text-slate-900">José Mensah</span>
            <span class="text-xs text-slate-500">Agent · Secrétariat</span>
          </span>
        </button>
      </div>
    </header>

    <main class="px-4 py-6 sm:px-6 lg:px-8">
      <!-- En-tête avec bouton Ajouter -->
      <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
          <h1 class="font-heading text-2xl font-bold text-slate-900 sm:text-3xl">Notes & Moyennes</h1>
          <p class="mt-1 text-sm text-slate-600">Consultation des performances. Toutes les moyennes sont calculées automatiquement.</p>
        </div>
        <button id="btn-open-add-modal" class="action-button inline-flex items-center gap-2 rounded-xl bg-primary px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-primary/25 transition hover:bg-primary-dark">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 4.5v15m7.5-7.5h-15"/></svg>
          Ajouter une note
        </button>
      </div>

      <!-- KPIs -->
      <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <div class="kpi-card rounded-2xl border-l-4 border-l-primary bg-white p-5 shadow-sm">
          <p class="text-xs font-semibold uppercase text-slate-500">Total notes</p>
          <p class="text-3xl font-bold text-slate-900" id="kpi-total-notes">0</p>
        </div>
        <div class="kpi-card rounded-2xl border-l-4 border-l-info bg-white p-5 shadow-sm">
          <p class="text-xs font-semibold uppercase text-slate-500">Élèves évalués</p>
          <p class="text-3xl font-bold text-slate-900" id="kpi-eleves-evalues">0</p>
        </div>
        <div class="kpi-card rounded-2xl border-l-4 border-l-warning bg-white p-5 shadow-sm">
          <p class="text-xs font-semibold uppercase text-slate-500">Moyenne générale</p>
          <p class="text-3xl font-bold text-slate-900" id="kpi-moyenne-generale">—</p>
        </div>
        <div class="kpi-card rounded-2xl border-l-4 border-l-success bg-white p-5 shadow-sm">
          <p class="text-xs font-semibold uppercase text-slate-500">Moyenne période</p>
          <p class="text-3xl font-bold text-slate-900" id="kpi-moyenne-periode">—</p>
        </div>
      </div>

      <!-- Recherche et filtres -->
      <div class="mb-5 flex flex-wrap items-center gap-3">
        <div class="relative flex-1 min-w-[240px]">
          <input type="text" id="search-input" placeholder="Rechercher par élève ou matière..." class="w-full rounded-xl border border-slate-200 py-2 pl-9 pr-3 text-sm focus:border-primary focus:outline-none" />
          <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 21l-4.35-4.35M17 11a6 6 0 1 1-12 0 6 6 0 0 1 12 0z"/></svg>
        </div>
        <select id="filter-matiere" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm">
          <option value="">Toutes les matières</option>
          <option value="Mathématiques">Mathématiques</option>
          <option value="Français">Français</option>
          <option value="Anglais">Anglais</option>
          <option value="Physique-Chimie">Physique-Chimie</option>
          <option value="SVT">SVT</option>
          <option value="Histoire-Géo">Histoire-Géo</option>
        </select>
        <select id="filter-classe" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm">
          <option value="">Toutes les classes</option>
          <option value="6ème">6ème</option>
          <option value="5ème">5ème</option>
          <option value="4ème">4ème</option>
          <option value="3ème">3ème</option>
          <option value="Seconde">Seconde</option>
          <option value="Première">Première</option>
          <option value="Terminale">Terminale</option>
        </select>
        <select id="filter-periode" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm">
          <option value="">Toutes les périodes</option>
          <option value="Trimestre 1">Trimestre 1</option>
          <option value="Trimestre 2">Trimestre 2</option>
          <option value="Trimestre 3">Trimestre 3</option>
          <option value="Semestre 1">Semestre 1</option>
          <option value="Semestre 2">Semestre 2</option>
        </select>
      </div>

      <!-- Tableau -->
      <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-md">
        <div class="overflow-x-auto">
          <table class="min-w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
              <tr>
                <th class="px-5 py-3">Élève</th>
                <th class="px-3 py-3">Classe</th>
                <th class="px-3 py-3">Matière</th>
                <th class="px-3 py-3">Moy. Interro</th>
                <th class="px-3 py-3">Moy. Devoirs</th>
                <th class="px-3 py-3">Moy. Matière</th>
                <th class="px-5 py-3 text-right">Actions</th>
              </tr>
            </thead>
            <tbody id="notes-tbody" class="divide-y divide-slate-100"></tbody>
          </table>
        </div>
      </div>

      <footer class="mt-12 pb-8 text-center text-xs text-slate-400">
        EduManager — Collège Saint-Michel · Données calculées automatiquement
      </footer>
    </main>
  </div>

  <!-- Modale Ajout/Modification (sans coefficient, avec trois devoirs) -->
  <div id="modal-form" class="modal-overlay">
    <div class="modal-content bg-white rounded-2xl shadow-2xl p-6">
      <div class="flex justify-between items-center mb-4">
        <h3 class="font-heading text-xl font-bold text-slate-900" id="modal-title">Ajouter une note</h3>
        <button id="close-modal-form" class="text-slate-400 hover:text-slate-600">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>
      <form id="note-form" class="space-y-4">
        <input type="hidden" id="note-id" value="">
        <div>
          <label class="block text-sm font-medium">Élève</label>
          <select id="note-eleve" class="w-full rounded-xl border p-2" required>
            <option value="">-- Sélectionner --</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium">Matière</label>
          <select id="note-matiere" class="w-full rounded-xl border p-2" required>
            <option value="">-- Sélectionner --</option>
            <option value="Mathématiques">Mathématiques</option>
            <option value="Français">Français</option>
            <option value="Anglais">Anglais</option>
            <option value="Physique-Chimie">Physique-Chimie</option>
            <option value="SVT">SVT</option>
            <option value="Histoire-Géo">Histoire-Géo</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium">Période</label>
          <select id="note-periode" class="w-full rounded-xl border p-2" required>
            <option value="Trimestre 1">Trimestre 1</option>
            <option value="Trimestre 2">Trimestre 2</option>
            <option value="Trimestre 3">Trimestre 3</option>
            <option value="Semestre 1">Semestre 1</option>
            <option value="Semestre 2">Semestre 2</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium">Nombre d'interrogations</label>
          <input type="number" id="nb-interros" min="0" value="1" class="w-full rounded-xl border p-2">
        </div>
        <div id="interro-notes-container" class="space-y-2 border rounded-xl p-3 bg-slate-50">
          <!-- Généré dynamiquement -->
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
          <div>
            <label class="block text-sm font-medium">Devoir 1</label>
            <input type="number" id="note-devoir1" step="0.1" min="0" max="20" class="w-full rounded-xl border p-2" placeholder="/20">
          </div>
          <div>
            <label class="block text-sm font-medium">Devoir 2</label>
            <input type="number" id="note-devoir2" step="0.1" min="0" max="20" class="w-full rounded-xl border p-2" placeholder="/20">
          </div>
          <div>
            <label class="block text-sm font-medium">Devoir Hebdo</label>
            <input type="number" id="note-devoir-hebdo" step="0.1" min="0" max="20" class="w-full rounded-xl border p-2" placeholder="/20">
          </div>
        </div>
        <p class="text-xs text-slate-500">* Les moyennes seront calculées automatiquement par le système (interros et devoirs).</p>
        <div class="flex gap-3 pt-2">
          <button type="submit" class="flex-1 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white">Enregistrer</button>
          <button type="button" id="cancel-modal-form" class="flex-1 rounded-xl border bg-white px-4 py-2 text-sm font-semibold">Annuler</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modale Voir détails -->
  <div id="modal-view" class="modal-overlay">
    <div class="modal-content bg-white rounded-2xl shadow-2xl p-6">
      <div class="flex justify-between items-center mb-4">
        <h3 class="font-heading text-xl font-bold text-slate-900">Détail de l'évaluation</h3>
        <button id="close-modal-view" class="text-slate-400 hover:text-slate-600">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>
      <div id="view-content" class="space-y-4"></div>
      <div class="mt-6 flex justify-end">
        <button id="close-view-btn" class="rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white">Fermer</button>
      </div>
    </div>
  </div>

  <div id="toast" class="toast"></div>

  <script>
    (function(){
      // Données mockées (élèves)
      const eleves = [
        { id: 1, nom: "KOUADIO", prenom: "Marie", classe: "3ème" },
        { id: 2, nom: "TRAORÉ", prenom: "Ibrahim", classe: "Seconde" },
        { id: 3, nom: "DIALLO", prenom: "Aminata", classe: "Terminale" },
        { id: 4, nom: "N'GUESSAN", prenom: "Koffi", classe: "4ème" },
        { id: 5, nom: "HOUNDONOU", prenom: "Jules", classe: "5ème" },
        { id: 6, nom: "AGOSSOU", prenom: "Pélagie", classe: "6ème" },
        { id: 7, nom: "SOSSOU", prenom: "Marc", classe: "Première" },
        { id: 8, nom: "ADJOVI", prenom: "Laure", classe: "3ème" }
      ];

      // Notes avec moyennes déjà calculées (simulées) – ajout de moyenne_devoirs
      let notesData = [
        { id: 101, eleveId: 1, eleve: "KOUADIO Marie", classe: "3ème", matiere: "Mathématiques", moyenne_interro: 14.0, moyenne_devoirs: 13.5, moyenne_matiere: 13.8, periode: "Trimestre 1", moyenne_periode: 12.9 },
        { id: 102, eleveId: 1, eleve: "KOUADIO Marie", classe: "3ème", matiere: "Français", moyenne_interro: 12.0, moyenne_devoirs: 15.0, moyenne_matiere: 13.5, periode: "Trimestre 1", moyenne_periode: 12.9 },
        { id: 103, eleveId: 2, eleve: "TRAORÉ Ibrahim", classe: "Seconde", matiere: "Mathématiques", moyenne_interro: 10.5, moyenne_devoirs: 11.0, moyenne_matiere: 10.8, periode: "Trimestre 1", moyenne_periode: 10.2 },
        { id: 104, eleveId: 2, eleve: "TRAORÉ Ibrahim", classe: "Seconde", matiere: "Anglais", moyenne_interro: 16.0, moyenne_devoirs: 14.0, moyenne_matiere: 15.0, periode: "Trimestre 1", moyenne_periode: 10.2 },
        { id: 105, eleveId: 3, eleve: "DIALLO Aminata", classe: "Terminale", matiere: "Physique-Chimie", moyenne_interro: 13.0, moyenne_devoirs: 12.0, moyenne_matiere: 12.5, periode: "Semestre 1", moyenne_periode: 13.1 },
        { id: 106, eleveId: 3, eleve: "DIALLO Aminata", classe: "Terminale", matiere: "SVT", moyenne_interro: 15.0, moyenne_devoirs: 14.5, moyenne_matiere: 14.8, periode: "Semestre 1", moyenne_periode: 13.1 },
        { id: 107, eleveId: 4, eleve: "N'GUESSAN Koffi", classe: "4ème", matiere: "Histoire-Géo", moyenne_interro: 9.0, moyenne_devoirs: 10.0, moyenne_matiere: 9.5, periode: "Trimestre 2", moyenne_periode: 11.0 },
        { id: 108, eleveId: 6, eleve: "AGOSSOU Pélagie", classe: "6ème", matiere: "Mathématiques", moyenne_interro: 17.0, moyenne_devoirs: 16.0, moyenne_matiere: 16.5, periode: "Trimestre 2", moyenne_periode: 12.8 },
        { id: 109, eleveId: 7, eleve: "SOSSOU Marc", classe: "Première", matiere: "Français", moyenne_interro: 11.0, moyenne_devoirs: 13.0, moyenne_matiere: 12.0, periode: "Semestre 2", moyenne_periode: 11.5 },
        { id: 110, eleveId: 8, eleve: "ADJOVI Laure", classe: "3ème", matiere: "Anglais", moyenne_interro: 18.0, moyenne_devoirs: 17.0, moyenne_matiere: 17.5, periode: "Trimestre 3", moyenne_periode: 14.2 }
      ];
      let nextId = 111;

      // Éléments DOM
      const tbody = document.getElementById('notes-tbody');
      const searchInput = document.getElementById('search-input');
      const filterMatiere = document.getElementById('filter-matiere');
      const filterClasse = document.getElementById('filter-classe');
      const filterPeriode = document.getElementById('filter-periode');
      
      const kpiTotalNotes = document.getElementById('kpi-total-notes');
      const kpiElevesEvalues = document.getElementById('kpi-eleves-evalues');
      const kpiMoyenneGenerale = document.getElementById('kpi-moyenne-generale');
      const kpiMoyennePeriode = document.getElementById('kpi-moyenne-periode');

      // Modales
      const modalForm = document.getElementById('modal-form');
      const modalView = document.getElementById('modal-view');
      const closeModalFormBtn = document.getElementById('close-modal-form');
      const cancelModalFormBtn = document.getElementById('cancel-modal-form');
      const closeModalViewBtn = document.getElementById('close-modal-view');
      const closeViewBtn = document.getElementById('close-view-btn');
      const form = document.getElementById('note-form');
      const modalTitle = document.getElementById('modal-title');
      const noteIdInput = document.getElementById('note-id');
      const eleveSelect = document.getElementById('note-eleve');
      const nbInterrosInput = document.getElementById('nb-interros');
      const interroContainer = document.getElementById('interro-notes-container');
      const toast = document.getElementById('toast');

      function showToast(msg, isError = false) {
        toast.innerText = msg;
        toast.style.backgroundColor = isError ? '#ef4444' : '#10b981';
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3000);
      }

      function populateEleveSelect() {
        eleveSelect.innerHTML = '<option value="">-- Sélectionner --</option>' +
          eleves.map(e => `<option value="${e.id}">${e.prenom} ${e.nom} (${e.classe})</option>`).join('');
      }

      function renderInterroFields(count, existingNotes = []) {
        if (count <= 0) {
          interroContainer.innerHTML = '<p class="text-sm text-slate-500 text-center py-2">Aucune interrogation</p>';
          return;
        }
        let html = '';
        for (let i = 0; i < count; i++) {
          const val = existingNotes[i] !== undefined ? existingNotes[i] : '';
          html += `<div class="flex items-center gap-2">
            <span class="text-xs w-12">Interro ${i+1}</span>
            <input type="number" step="0.1" min="0" max="20" value="${val}" class="interro-note flex-1 rounded border px-2 py-1 text-sm" placeholder="/20">
          </div>`;
        }
        interroContainer.innerHTML = html;
      }

      function openFormModal(editMode = false, note = null) {
        populateEleveSelect();
        if (editMode && note) {
          modalTitle.textContent = 'Modifier la note';
          noteIdInput.value = note.id;
          eleveSelect.value = note.eleveId;
          document.getElementById('note-matiere').value = note.matiere;
          document.getElementById('note-periode').value = note.periode;
          // Pour la démo, on ne peut pas retrouver le détail des interros et devoirs, on laisse vide
          nbInterrosInput.value = 1;
          renderInterroFields(1, [note.moyenne_interro]);
          document.getElementById('note-devoir1').value = '';
          document.getElementById('note-devoir2').value = '';
          document.getElementById('note-devoir-hebdo').value = '';
        } else {
          modalTitle.textContent = 'Ajouter une note';
          noteIdInput.value = '';
          form.reset();
          nbInterrosInput.value = 1;
          renderInterroFields(1);
        }
        modalForm.classList.add('is-open');
        document.body.style.overflow = 'hidden';
      }

      function closeFormModal() {
        modalForm.classList.remove('is-open');
        document.body.style.overflow = '';
        form.reset();
      }

      function openViewModal(note) {
        const content = document.getElementById('view-content');
        content.innerHTML = `
          <div class="border-b pb-3">
            <p class="text-lg font-bold">${note.eleve}</p>
            <p class="text-sm text-slate-500">${note.classe} · ${note.matiere} · ${note.periode}</p>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div><span class="text-xs uppercase text-slate-500">Moy. Interro</span><p class="font-medium">${note.moyenne_interro.toFixed(1)}</p></div>
            <div><span class="text-xs uppercase text-slate-500">Moy. Devoirs</span><p class="font-medium">${note.moyenne_devoirs.toFixed(1)}</p></div>
            <div><span class="text-xs uppercase text-slate-500">Moy. Matière</span><p class="font-medium text-primary font-bold">${note.moyenne_matiere.toFixed(1)}</p></div>
          </div>
        `;
        modalView.classList.add('is-open');
        document.body.style.overflow = 'hidden';
      }

      function closeViewModal() {
        modalView.classList.remove('is-open');
        document.body.style.overflow = '';
      }

      function computeMoyenneInterro(notesArray) {
        if (!notesArray.length) return 0;
        const sum = notesArray.reduce((a, b) => a + b, 0);
        return sum / notesArray.length;
      }

      function computeMoyenneDevoirs(d1, d2, dHebdo) {
        const vals = [d1, d2, dHebdo].filter(v => !isNaN(v) && v > 0);
        if (vals.length === 0) return 0;
        const sum = vals.reduce((a, b) => a + b, 0);
        return sum / vals.length;
      }

      function updateKPIs(filteredData) {
        kpiTotalNotes.textContent = filteredData.length;
        const elevesUniques = new Set(filteredData.map(d => `${d.eleve}|${d.classe}`));
        kpiElevesEvalues.textContent = elevesUniques.size;

        if (filteredData.length > 0) {
          const sum = filteredData.reduce((acc, d) => acc + d.moyenne_matiere, 0);
          const avg = (sum / filteredData.length).toFixed(1);
          kpiMoyenneGenerale.innerHTML = `${avg}<span class="text-lg font-normal text-slate-500">/20</span>`;
        } else {
          kpiMoyenneGenerale.innerHTML = '—';
        }

        const periodeFilter = filterPeriode.value;
        if (periodeFilter) {
          const periodeData = filteredData.filter(d => d.periode === periodeFilter);
          if (periodeData.length > 0) {
            const sumPeriode = periodeData.reduce((acc, d) => acc + d.moyenne_periode, 0);
            const avgPeriode = (sumPeriode / periodeData.length).toFixed(1);
            kpiMoyennePeriode.innerHTML = `${avgPeriode}<span class="text-lg font-normal text-slate-500">/20</span>`;
          } else {
            kpiMoyennePeriode.innerHTML = '—';
          }
        } else {
          if (filteredData.length > 0) {
            const sum = filteredData.reduce((acc, d) => acc + d.moyenne_matiere, 0);
            const avg = (sum / filteredData.length).toFixed(1);
            kpiMoyennePeriode.innerHTML = `${avg}<span class="text-lg font-normal text-slate-500">/20</span>`;
          } else {
            kpiMoyennePeriode.innerHTML = '—';
          }
        }
      }

      function renderTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const matiereFilter = filterMatiere.value;
        const classeFilter = filterClasse.value;
        const periodeFilter = filterPeriode.value;

        let filtered = notesData.filter(d => {
          if (matiereFilter && d.matiere !== matiereFilter) return false;
          if (classeFilter && d.classe !== classeFilter) return false;
          if (periodeFilter && d.periode !== periodeFilter) return false;
          if (searchTerm) {
            const eleveMatch = d.eleve.toLowerCase().includes(searchTerm);
            const matiereMatch = d.matiere.toLowerCase().includes(searchTerm);
            if (!eleveMatch && !matiereMatch) return false;
          }
          return true;
        });

        tbody.innerHTML = filtered.map(d => `
          <tr class="hover:bg-slate-50/80">
            <td class="px-5 py-4 font-medium text-slate-900">${d.eleve}</td>
            <td class="px-3 py-4">${d.classe}</td>
            <td class="px-3 py-4">${d.matiere}</td>
            <td class="px-3 py-4 font-semibold">${d.moyenne_interro.toFixed(1)}</td>
            <td class="px-3 py-4 font-semibold">${d.moyenne_devoirs.toFixed(1)}</td>
            <td class="px-3 py-4 font-bold text-primary">${d.moyenne_matiere.toFixed(1)}</td>
            <td class="px-5 py-4 text-right">
              <div class="flex items-center justify-end gap-1">
                <button data-id="${d.id}" class="btn-view rounded-lg p-1.5 text-slate-500 hover:bg-slate-100" title="Voir détails">
                  <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                </button>
                <button data-id="${d.id}" class="btn-edit rounded-lg border border-slate-200 bg-white px-2.5 py-1 text-xs font-medium text-slate-700 hover:bg-slate-50">Modifier</button>
                <button data-id="${d.id}" class="btn-delete rounded-lg border border-urgent/30 bg-white px-2.5 py-1 text-xs font-medium text-urgent hover:bg-urgent/5">Supprimer</button>
              </div>
            </td>
          </tr>
        `).join('');

        updateKPIs(filtered);
      }

      // Événements filtres
      searchInput.addEventListener('input', renderTable);
      filterMatiere.addEventListener('change', renderTable);
      filterClasse.addEventListener('change', renderTable);
      filterPeriode.addEventListener('change', renderTable);

      nbInterrosInput.addEventListener('input', () => {
        const count = parseInt(nbInterrosInput.value) || 0;
        renderInterroFields(count);
      });

      // Actions tableau
      tbody.addEventListener('click', (e) => {
        const viewBtn = e.target.closest('.btn-view');
        const editBtn = e.target.closest('.btn-edit');
        const delBtn = e.target.closest('.btn-delete');
        const id = parseInt(viewBtn?.dataset.id || editBtn?.dataset.id || delBtn?.dataset.id);
        const note = notesData.find(n => n.id === id);

        if (viewBtn) { if (note) openViewModal(note); }
        if (editBtn) { if (note) openFormModal(true, note); }
        if (delBtn) {
          if (confirm('Supprimer cette note ?')) {
            notesData = notesData.filter(n => n.id !== id);
            renderTable();
            showToast('Note supprimée');
          }
        }
      });

      document.getElementById('btn-open-add-modal').addEventListener('click', () => openFormModal(false));

      closeModalFormBtn.addEventListener('click', closeFormModal);
      cancelModalFormBtn.addEventListener('click', closeFormModal);
      modalForm.addEventListener('click', (e) => { if (e.target === modalForm) closeFormModal(); });

      closeModalViewBtn.addEventListener('click', closeViewModal);
      closeViewBtn.addEventListener('click', closeViewModal);
      modalView.addEventListener('click', (e) => { if (e.target === modalView) closeViewModal(); });

      form.addEventListener('submit', (e) => {
        e.preventDefault();
        const eleveId = parseInt(eleveSelect.value);
        const matiere = document.getElementById('note-matiere').value;
        const periode = document.getElementById('note-periode').value;
        const editId = noteIdInput.value;

        if (!eleveId || !matiere || !periode) {
          showToast('Veuillez remplir les champs obligatoires', true);
          return;
        }

        const interroInputs = document.querySelectorAll('.interro-note');
        const interroNotes = Array.from(interroInputs).map(inp => parseFloat(inp.value) || 0).filter(v => v > 0);
        const moyenneInterro = interroNotes.length ? computeMoyenneInterro(interroNotes) : 0;

        const dev1 = parseFloat(document.getElementById('note-devoir1').value) || 0;
        const dev2 = parseFloat(document.getElementById('note-devoir2').value) || 0;
        const devHebdo = parseFloat(document.getElementById('note-devoir-hebdo').value) || 0;
        const moyenneDevoirs = computeMoyenneDevoirs(dev1, dev2, devHebdo);

        // Moyenne matière = (moyInterro + moyDevoirs) / 2 si les deux > 0, sinon la valeur non nulle
        let moyenneMatiere = 0;
        if (moyenneInterro > 0 && moyenneDevoirs > 0) {
          moyenneMatiere = (moyenneInterro + moyenneDevoirs) / 2;
        } else if (moyenneInterro > 0) {
          moyenneMatiere = moyenneInterro;
        } else if (moyenneDevoirs > 0) {
          moyenneMatiere = moyenneDevoirs;
        }

        const eleve = eleves.find(el => el.id === eleveId);
        if (!eleve) return;

        const noteData = {
          eleveId,
          eleve: `${eleve.prenom} ${eleve.nom}`,
          classe: eleve.classe,
          matiere,
          moyenne_interro: moyenneInterro,
          moyenne_devoirs: moyenneDevoirs,
          moyenne_matiere: moyenneMatiere,
          periode,
          moyenne_periode: (notesData.find(n => n.eleveId === eleveId && n.periode === periode)?.moyenne_periode || moyenneMatiere)
        };

        if (editId) {
          const idx = notesData.findIndex(n => n.id === parseInt(editId));
          if (idx !== -1) {
            notesData[idx] = { ...notesData[idx], ...noteData, id: parseInt(editId) };
          }
          showToast('Note modifiée');
        } else {
          notesData.push({ id: nextId++, ...noteData });
          showToast('Note ajoutée');
        }
        renderTable();
        closeFormModal();
      });

      // Sidebar mobile
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('sidebar-overlay');
      const btnMenu = document.getElementById('btn-menu');
      btnMenu.addEventListener('click', () => { sidebar.classList.remove('-translate-x-full'); overlay.classList.add('is-open'); document.body.style.overflow = 'hidden'; });
      overlay.addEventListener('click', () => { sidebar.classList.add('-translate-x-full'); overlay.classList.remove('is-open'); document.body.style.overflow = ''; });
      window.addEventListener('resize', () => { if (window.innerWidth >= 1024) { sidebar.classList.remove('-translate-x-full'); overlay.classList.remove('is-open'); document.body.style.overflow = ''; } });

      renderTable();
    })();
  </script>
</body>
</html>
