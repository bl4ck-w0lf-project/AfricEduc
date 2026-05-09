<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EduManager · Bulletins & Documents</title>
  <meta name="description" content="Gestion des bulletins scolaires et relevés de notes.">

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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>

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
      max-width: 95%; width: 64rem; background: white; border-radius: 1rem;
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
        <span class="text-[10px] font-medium uppercase tracking-wider text-white/70">Espace agent · Bulletins</span>
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
      <a href="notes.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0 opacity-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6.5h16M6.5 4v5M17.5 4v5M5.75 20h12.5A1.75 1.75 0 0 0 20 18.25V7.75A1.75 1.75 0 0 0 18.25 6H5.75A1.75 1.75 0 0 0 4 7.75v10.5C4 19.22 4.78 20 5.75 20Z" /></svg>
        Notes & Moyennes
      </a>
      <a href="paiements.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0 opacity-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.5 8.5h17M6 5h12a2.5 2.5 0 0 1 2.5 2.5v9A2.5 2.5 0 0 1 18 19H6a2.5 2.5 0 0 1-2.5-2.5v-9A2.5 2.5 0 0 1 6 5Z" /><path stroke-linecap="round" d="M7.5 14h4M7.5 11h9" /></svg>
        Paiements
      </a>
      <a href="bulletins.html" class="sidebar-link sidebar-link--active flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0 opacity-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3.75h10.5l3 4.5v9.75a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25l3-4.5Z" /><path stroke-linecap="round" d="M9 12h6M9 15.75h3" /></svg>
        Bulletins
      </a>
      <a href="statistiques.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0 opacity-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18M7 16v-5m5 5v-8m5 8v-3"/></svg>
        Statistiques
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
          <p class="text-xs text-slate-500">Cotonou · Gestion des bulletins</p>
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
      <!-- En-tête -->
      <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
          <h1 class="font-heading text-2xl font-bold text-slate-900 sm:text-3xl">Bulletins & Documents</h1>
          <p class="mt-1 text-sm text-slate-600">Générez et consultez les bulletins scolaires et relevés de notes.</p>
        </div>
        <button id="btn-open-add-modal" class="action-button inline-flex items-center gap-2 rounded-xl bg-primary px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-primary/25 transition hover:bg-primary-dark">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 4.5v15m7.5-7.5h-15"/></svg>
          Nouveau bulletin
        </button>
      </div>

      <!-- Filtres -->
      <div class="mb-5 flex flex-wrap items-center gap-3">
        <div class="relative flex-1 min-w-[240px]">
          <input type="text" id="search-input" placeholder="Rechercher par élève..." class="w-full rounded-xl border border-slate-200 py-2 pl-9 pr-3 text-sm focus:border-primary focus:outline-none" />
          <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 21l-4.35-4.35M17 11a6 6 0 1 1-12 0 6 6 0 0 1 12 0z"/></svg>
        </div>
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
                <th class="px-3 py-3">Période</th>
                <th class="px-3 py-3">Moyenne</th>
                <th class="px-3 py-3">Conduite</th>
                <th class="px-3 py-3">Mention</th>
                <th class="px-5 py-3 text-right">Actions</th>
              </tr>
            </thead>
            <tbody id="bulletins-tbody" class="divide-y divide-slate-100"></tbody>
          </table>
        </div>
      </div>

      <footer class="mt-12 pb-8 text-center text-xs text-slate-400">
        EduManager — Collège Saint-Michel · Bulletins & Documents
      </footer>
    </main>
  </div>

  <!-- Modale Ajout/Modification -->
  <div id="modal-form" class="modal-overlay">
    <div class="modal-content bg-white rounded-2xl shadow-2xl p-6">
      <div class="flex justify-between items-center mb-4">
        <h3 class="font-heading text-xl font-bold text-slate-900" id="modal-title">Nouveau bulletin</h3>
        <button id="close-modal-form" class="text-slate-400 hover:text-slate-600">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>
      <form id="bulletin-form" class="space-y-4">
        <input type="hidden" id="bulletin-id" value="">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium">Élève</label>
            <select id="bulletin-eleve" class="w-full rounded-xl border p-2" required>
              <option value="">-- Sélectionner --</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium">Période</label>
            <select id="bulletin-periode" class="w-full rounded-xl border p-2" required>
              <option value="Trimestre 1">Trimestre 1</option>
              <option value="Trimestre 2">Trimestre 2</option>
              <option value="Trimestre 3">Trimestre 3</option>
              <option value="Semestre 1">Semestre 1</option>
              <option value="Semestre 2">Semestre 2</option>
            </select>
          </div>
        </div>

        <!-- Matières dynamiques -->
        <div>
          <div class="flex items-center justify-between mb-2">
            <label class="text-sm font-medium">Matières et notes</label>
            <button type="button" id="add-matiere" class="text-xs text-primary hover:underline">+ Ajouter une matière</button>
          </div>
          <div id="matieres-container" class="space-y-3 max-h-96 overflow-y-auto border rounded-xl p-3 bg-slate-50"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium">Conduite (/20)</label>
            <input type="number" id="bulletin-conduite" step="0.5" min="0" max="20" value="16" class="w-full rounded-xl border p-2">
          </div>
          <div>
            <label class="block text-sm font-medium">Appréciation</label>
            <input type="text" id="bulletin-appreciation" class="w-full rounded-xl border p-2" placeholder="Ex: Bon trimestre...">
          </div>
        </div>

        <div class="bg-slate-100 p-3 rounded-xl text-sm">
          <span class="font-semibold">Moyenne générale :</span> <span id="preview-moyenne">—</span>/20
        </div>

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
        <h3 class="font-heading text-xl font-bold text-slate-900">Détail du bulletin</h3>
        <button id="close-modal-view" class="text-slate-400 hover:text-slate-600">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>
      <div id="view-content" class="space-y-4"></div>
      <div class="mt-6 flex justify-end gap-2">
        <button id="btn-download-from-view" class="rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white">Télécharger PDF</button>
        <button id="close-view-btn" class="rounded-xl border px-4 py-2 text-sm font-semibold">Fermer</button>
      </div>
    </div>
  </div>

  <!-- Modale Historique -->
  <div id="modal-history" class="modal-overlay">
    <div class="modal-content bg-white rounded-2xl shadow-2xl p-6">
      <div class="flex justify-between items-center mb-4">
        <h3 class="font-heading text-xl font-bold text-slate-900" id="history-title">Historique des bulletins</h3>
        <button id="close-modal-history" class="text-slate-400 hover:text-slate-600">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>
      <div id="history-content" class="space-y-4"></div>
      <div class="mt-6 flex justify-end">
        <button id="close-history-btn" class="rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white">Fermer</button>
      </div>
    </div>
  </div>

  <div id="toast" class="toast"></div>

  <script>
    (function(){
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

      let bulletins = [
        { id: 101, eleveId: 1, periode: "Trimestre 2", date: "2026-02-10",
          matieres: [
            { nom: "Mathématiques", coeff: 3, moyenne_interro: 14.0, moyenne_devoirs: 13.5, moyenne_matiere: 13.8 },
            { nom: "Français", coeff: 2, moyenne_interro: 12.0, moyenne_devoirs: 15.0, moyenne_matiere: 13.5 }
          ],
          conduite: 18, appreciation: "Très bon trimestre, élève sérieuse." },
        { id: 102, eleveId: 1, periode: "Trimestre 1", date: "2025-12-05",
          matieres: [
            { nom: "Mathématiques", coeff: 3, moyenne_interro: 13.0, moyenne_devoirs: 14.0, moyenne_matiere: 13.5 },
            { nom: "Français", coeff: 2, moyenne_interro: 11.0, moyenne_devoirs: 13.0, moyenne_matiere: 12.0 }
          ],
          conduite: 17, appreciation: "Bon début d'année." },
        { id: 103, eleveId: 2, periode: "Trimestre 1", date: "2026-01-20",
          matieres: [
            { nom: "Mathématiques", coeff: 3, moyenne_interro: 10.5, moyenne_devoirs: 11.0, moyenne_matiere: 10.8 },
            { nom: "Physique-Chimie", coeff: 2, moyenne_interro: 8.0, moyenne_devoirs: 8.5, moyenne_matiere: 8.3 }
          ],
          conduite: 14, appreciation: "Des efforts à fournir." }
      ];
      let nextId = 104;

      const tbody = document.getElementById('bulletins-tbody');
      const searchInput = document.getElementById('search-input');
      const filterClasse = document.getElementById('filter-classe');
      const filterPeriode = document.getElementById('filter-periode');
      const modalForm = document.getElementById('modal-form');
      const modalView = document.getElementById('modal-view');
      const modalHistory = document.getElementById('modal-history');
      const form = document.getElementById('bulletin-form');
      const matieresContainer = document.getElementById('matieres-container');
      const previewMoyenne = document.getElementById('preview-moyenne');
      const toast = document.getElementById('toast');

      function moyenneMatiereCalc(mat) {
        if (mat.moyenne_interro > 0 && mat.moyenne_devoirs > 0) return (mat.moyenne_interro + mat.moyenne_devoirs) / 2;
        return mat.moyenne_interro || mat.moyenne_devoirs || 0;
      }
      function moyenneGenerale(bulletin) {
        let total = 0, coeffSum = 0;
        bulletin.matieres.forEach(m => {
          const moy = moyenneMatiereCalc(m);
          total += moy * m.coeff;
          coeffSum += m.coeff;
        });
        return coeffSum ? total / coeffSum : 0;
      }
      function getMention(moy) {
        if (moy >= 16) return "Très bien";
        if (moy >= 14) return "Bien";
        if (moy >= 12) return "Assez bien";
        if (moy >= 10) return "Passable";
        return "Insuffisant";
      }

      function showToast(msg, isError = false) {
        toast.innerText = msg;
        toast.style.backgroundColor = isError ? '#ef4444' : '#10b981';
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3000);
      }

      function renderMatiereFields(mat, idx) {
        return `
          <div class="border rounded-lg p-3 bg-white" data-matidx="${idx}">
            <div class="flex flex-wrap items-center gap-2 mb-2">
              <input type="text" value="${mat.nom || ''}" placeholder="Matière" class="flex-1 min-w-[150px] border rounded px-2 py-1 text-sm" data-field="nom">
              <label class="text-xs">Coeff.</label>
              <input type="number" value="${mat.coeff || 1}" step="0.5" min="0.5" class="w-16 border rounded px-1 py-1 text-sm" data-field="coeff">
              <span class="text-xs font-semibold bg-primary/10 px-2 py-1 rounded">Moy: ${(mat.moyenne_matiere || moyenneMatiereCalc(mat)).toFixed(2)}</span>
              <button type="button" class="remove-matiere text-urgent text-xs">Suppr.</button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-2">
              <div>
                <label class="text-xs">Interros (moyenne)</label>
                <input type="number" value="${mat.moyenne_interro || ''}" step="0.1" min="0" max="20" class="w-full border rounded px-2 py-1 text-sm" data-field="interro">
              </div>
              <div>
                <label class="text-xs">Devoir 1</label>
                <input type="number" value="${mat.devoirs?.[0] || ''}" step="0.1" min="0" max="20" class="w-full border rounded px-2 py-1 text-sm" data-field="dev1">
              </div>
              <div>
                <label class="text-xs">Devoir 2</label>
                <input type="number" value="${mat.devoirs?.[1] || ''}" step="0.1" min="0" max="20" class="w-full border rounded px-2 py-1 text-sm" data-field="dev2">
              </div>
              <div>
                <label class="text-xs">Devoir Hebdo</label>
                <input type="number" value="${mat.devoirs?.[2] || ''}" step="0.1" min="0" max="20" class="w-full border rounded px-2 py-1 text-sm" data-field="devHebdo">
              </div>
            </div>
          </div>
        `;
      }

      function renderMatieresFields(matieres) {
        if (!matieres.length) matieres.push({ nom: '', coeff: 1, moyenne_interro: 0, moyenne_devoirs: 0 });
        matieresContainer.innerHTML = matieres.map((m, idx) => renderMatiereFields(m, idx)).join('');
        updatePreviewMoyenne();
      }

      function updatePreviewMoyenne() {
        const matieres = [];
        document.querySelectorAll('[data-matidx]').forEach(div => {
          const nom = div.querySelector('[data-field="nom"]')?.value;
          const coeff = parseFloat(div.querySelector('[data-field="coeff"]')?.value);
          const interro = parseFloat(div.querySelector('[data-field="interro"]')?.value) || 0;
          const dev1 = parseFloat(div.querySelector('[data-field="dev1"]')?.value) || 0;
          const dev2 = parseFloat(div.querySelector('[data-field="dev2"]')?.value) || 0;
          const devHebdo = parseFloat(div.querySelector('[data-field="devHebdo"]')?.value) || 0;
          const devoirs = [dev1, dev2, devHebdo].filter(v => v > 0);
          const moyenneDevoirs = devoirs.length ? devoirs.reduce((a,b) => a+b, 0) / devoirs.length : 0;
          const moy = interro > 0 && moyenneDevoirs > 0 ? (interro + moyenneDevoirs) / 2 : (interro || moyenneDevoirs);
          if (nom && !isNaN(coeff)) matieres.push({ nom, coeff, moyenne_interro: interro, moyenne_devoirs: moyenneDevoirs, moyenne_matiere: moy });
        });
        if (matieres.length) {
          let total = 0, coeffSum = 0;
          matieres.forEach(m => { total += m.moyenne_matiere * m.coeff; coeffSum += m.coeff; });
          previewMoyenne.textContent = (coeffSum ? total / coeffSum : 0).toFixed(2);
        } else {
          previewMoyenne.textContent = '—';
        }
      }

      matieresContainer.addEventListener('click', e => {
        if (e.target.classList.contains('remove-matiere')) {
          e.target.closest('[data-matidx]').remove();
          updatePreviewMoyenne();
        }
      });
      matieresContainer.addEventListener('input', updatePreviewMoyenne);
      matieresContainer.addEventListener('change', updatePreviewMoyenne);

      document.getElementById('add-matiere').addEventListener('click', () => {
        const idx = document.querySelectorAll('[data-matidx]').length;
        const div = document.createElement('div');
        div.dataset.matidx = idx;
        div.innerHTML = renderMatiereFields({ nom: '', coeff: 1, moyenne_interro: 0, moyenne_devoirs: 0 }, idx);
        matieresContainer.appendChild(div);
        updatePreviewMoyenne();
      });

      function populateEleveSelect(selectEl, selectedId = null) {
        selectEl.innerHTML = '<option value="">-- Sélectionner --</option>' +
          eleves.map(e => `<option value="${e.id}" ${selectedId===e.id?'selected':''}>${e.prenom} ${e.nom} (${e.classe})</option>`).join('');
      }

      function openFormModal(editMode = false, bulletin = null) {
        const selectEleve = document.getElementById('bulletin-eleve');
        populateEleveSelect(selectEleve, bulletin?.eleveId);
        if (editMode && bulletin) {
          document.getElementById('modal-title').textContent = 'Modifier le bulletin';
          document.getElementById('bulletin-id').value = bulletin.id;
          document.getElementById('bulletin-periode').value = bulletin.periode;
          document.getElementById('bulletin-conduite').value = bulletin.conduite;
          document.getElementById('bulletin-appreciation').value = bulletin.appreciation || '';
          renderMatieresFields(JSON.parse(JSON.stringify(bulletin.matieres)));
        } else {
          document.getElementById('modal-title').textContent = 'Nouveau bulletin';
          document.getElementById('bulletin-id').value = '';
          form.reset();
          renderMatieresFields([]);
        }
        modalForm.classList.add('is-open');
        document.body.style.overflow = 'hidden';
      }

      function closeFormModal() {
        modalForm.classList.remove('is-open');
        document.body.style.overflow = '';
      }

      function openViewModal(bulletin) {
        const eleve = eleves.find(e => e.id === bulletin.eleveId);
        const moyenne = moyenneGenerale(bulletin);
        const mention = getMention(moyenne);
        let html = `
          <div class="border-b pb-3">
            <p class="text-lg font-bold">${eleve.prenom} ${eleve.nom}</p>
            <p class="text-sm text-slate-500">${eleve.classe} · ${bulletin.periode}</p>
          </div>
          <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
              <thead class="bg-slate-100"><tr><th class="px-3 py-2">Matière</th><th>Coeff</th><th>Moy. Interro</th><th>Moy. Devoirs</th><th>Moyenne</th></tr></thead>
              <tbody>
                ${bulletin.matieres.map(m => {
                  const moy = moyenneMatiereCalc(m);
                  return `<tr><td class="px-3 py-2">${m.nom}</td><td class="px-3 py-2">${m.coeff}</td><td class="px-3 py-2">${m.moyenne_interro.toFixed(1)}</td><td class="px-3 py-2">${m.moyenne_devoirs.toFixed(1)}</td><td class="px-3 py-2 font-bold">${moy.toFixed(2)}</td></tr>`;
                }).join('')}
              </tbody>
            </table>
          </div>
          <div class="grid grid-cols-2 gap-2 text-sm">
            <div><span class="font-medium">Conduite:</span> ${bulletin.conduite}/20</div>
            <div><span class="font-medium">Moyenne:</span> ${moyenne.toFixed(2)}/20</div>
            <div><span class="font-medium">Mention:</span> ${mention}</div>
            <div><span class="font-medium">Appréciation:</span> ${bulletin.appreciation || '—'}</div>
          </div>
        `;
        document.getElementById('view-content').innerHTML = html;
        document.getElementById('btn-download-from-view').onclick = () => generatePDF(bulletin);
        modalView.classList.add('is-open');
        document.body.style.overflow = 'hidden';
      }

      function closeViewModal() {
        modalView.classList.remove('is-open');
        document.body.style.overflow = '';
      }

      function openHistoryModal(eleveId) {
        const eleve = eleves.find(e => e.id === eleveId);
        const eleveBulletins = bulletins.filter(b => b.eleveId === eleveId).sort((a,b) => new Date(b.date) - new Date(a.date));
        document.getElementById('history-title').textContent = `Historique · ${eleve.prenom} ${eleve.nom} (${eleve.classe})`;
        let html = eleveBulletins.length ? eleveBulletins.map(b => {
          const moy = moyenneGenerale(b);
          return `
            <div class="border rounded-lg p-4 mb-3 bg-white shadow-sm">
              <div class="flex justify-between items-center">
                <span class="font-bold">${b.periode}</span>
                <span class="text-sm text-slate-500">${new Date(b.date).toLocaleDateString()}</span>
              </div>
              <div class="grid grid-cols-3 gap-2 mt-2 text-sm">
                <div>Moy: ${moy.toFixed(2)}</div>
                <div>Conduite: ${b.conduite}</div>
                <div>Mention: ${getMention(moy)}</div>
              </div>
              <div class="mt-2 flex gap-2">
                <button data-id="${b.id}" class="btn-view-from-history text-primary text-xs hover:underline">Voir</button>
                <button data-id="${b.id}" class="btn-download-from-history text-primary text-xs hover:underline">PDF</button>
              </div>
            </div>
          `;
        }).join('') : '<p class="text-center text-slate-500">Aucun bulletin</p>';
        document.getElementById('history-content').innerHTML = html;
        modalHistory.classList.add('is-open');
        document.body.style.overflow = 'hidden';
        document.querySelectorAll('.btn-view-from-history').forEach(btn => {
          btn.addEventListener('click', () => {
            const id = parseInt(btn.dataset.id);
            const b = bulletins.find(x => x.id === id);
            if (b) { closeHistoryModal(); openViewModal(b); }
          });
        });
        document.querySelectorAll('.btn-download-from-history').forEach(btn => {
          btn.addEventListener('click', () => {
            const id = parseInt(btn.dataset.id);
            const b = bulletins.find(x => x.id === id);
            if (b) generatePDF(b);
          });
        });
      }

      function closeHistoryModal() {
        modalHistory.classList.remove('is-open');
        document.body.style.overflow = '';
      }

      function generatePDF(bulletin) {
        const eleve = eleves.find(e => e.id === bulletin.eleveId);
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        doc.setFontSize(16);
        doc.text("BULLETIN SCOLAIRE", 105, 20, { align: "center" });
        doc.setFontSize(10);
        doc.text(`${eleve.prenom} ${eleve.nom} - ${eleve.classe}`, 105, 30, { align: "center" });
        doc.text(`${bulletin.periode}`, 105, 36, { align: "center" });
        const rows = bulletin.matieres.map(m => [m.nom, m.coeff, moyenneMatiereCalc(m).toFixed(2)]);
        doc.autoTable({ startY: 45, head: [['Matière','Coeff','Moyenne']], body: rows });
        let finalY = doc.lastAutoTable.finalY + 10;
        doc.text(`Conduite: ${bulletin.conduite}/20`, 14, finalY);
        doc.text(`Moyenne générale: ${moyenneGenerale(bulletin).toFixed(2)}/20`, 14, finalY+6);
        doc.text(`Appréciation: ${bulletin.appreciation || ''}`, 14, finalY+12);
        doc.save(`bulletin_${eleve.nom}_${bulletin.periode}.pdf`);
        showToast('PDF généré');
      }

      function renderTable() {
        const search = searchInput.value.toLowerCase();
        const classeF = filterClasse.value;
        const periodeF = filterPeriode.value;
        const filtered = bulletins.filter(b => {
          const eleve = eleves.find(e => e.id === b.eleveId);
          if (!eleve) return false;
          const name = `${eleve.prenom} ${eleve.nom}`.toLowerCase();
          return (!search || name.includes(search)) && (!classeF || eleve.classe === classeF) && (!periodeF || b.periode === periodeF);
        });
        tbody.innerHTML = filtered.map(b => {
          const eleve = eleves.find(e => e.id === b.eleveId);
          const moy = moyenneGenerale(b);
          return `
            <tr>
              <td class="px-5 py-4 font-medium">${eleve.prenom} ${eleve.nom}</td>
              <td class="px-3 py-4">${eleve.classe}</td>
              <td class="px-3 py-4">${b.periode}</td>
              <td class="px-3 py-4 font-bold text-primary">${moy.toFixed(2)}</td>
              <td class="px-3 py-4">${b.conduite}/20</td>
              <td class="px-3 py-4">${getMention(moy)}</td>
              <td class="px-5 py-4 text-right">
                <div class="flex items-center justify-end gap-1">
                  <button data-id="${b.id}" class="btn-view rounded-lg p-1.5 text-slate-500 hover:bg-slate-100" title="Voir">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                  </button>
                  <button data-id="${b.id}" class="btn-edit rounded-lg border border-slate-200 bg-white px-2.5 py-1 text-xs font-medium text-slate-700 hover:bg-slate-50" title="Modifier">
                    <svg class="h-4 w-4 inline mr-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/><path d="m14.25 5.25 4.5 4.5"/></svg>Modifier
                  </button>
                  <button data-eleve="${b.eleveId}" class="btn-history rounded-lg border border-info/30 bg-info/5 px-2.5 py-1 text-xs font-medium text-info hover:bg-info/10" title="Historique">
                    <svg class="h-4 w-4 inline mr-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 8v4l3 3M12 4a8 8 0 1 0 0 16 8 8 0 0 0 0-16Z"/></svg>Historique
                  </button>
                  <button data-id="${b.id}" class="btn-delete rounded-lg border border-urgent/30 bg-white px-2.5 py-1 text-xs font-medium text-urgent hover:bg-urgent/5" title="Supprimer">
                    <svg class="h-4 w-4 inline mr-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>Supprimer
                  </button>
                  <button data-id="${b.id}" class="btn-download rounded-lg border border-primary/30 bg-primary/5 px-2.5 py-1 text-xs font-medium text-primary hover:bg-primary/10" title="Télécharger PDF">
                    <svg class="h-4 w-4 inline mr-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>PDF
                  </button>
                </div>
              </td>
            </tr>
          `;
        }).join('');
      }

      searchInput.addEventListener('input', renderTable);
      filterClasse.addEventListener('change', renderTable);
      filterPeriode.addEventListener('change', renderTable);
      tbody.addEventListener('click', e => {
        const btn = e.target.closest('button');
        if (!btn) return;
        const id = btn.dataset.id ? parseInt(btn.dataset.id) : null;
        const bulletin = id ? bulletins.find(b => b.id === id) : null;
        if (btn.classList.contains('btn-view')) { if (bulletin) openViewModal(bulletin); }
        else if (btn.classList.contains('btn-edit')) { if (bulletin) openFormModal(true, bulletin); }
        else if (btn.classList.contains('btn-download')) { if (bulletin) generatePDF(bulletin); }
        else if (btn.classList.contains('btn-history')) { openHistoryModal(parseInt(btn.dataset.eleve)); }
        else if (btn.classList.contains('btn-delete')) {
          if (confirm('Supprimer ce bulletin ?')) {
            bulletins = bulletins.filter(b => b.id !== id);
            renderTable();
            showToast('Bulletin supprimé');
          }
        }
      });

      document.getElementById('btn-open-add-modal').addEventListener('click', () => openFormModal(false));
      document.getElementById('close-modal-form').addEventListener('click', closeFormModal);
      document.getElementById('cancel-modal-form').addEventListener('click', closeFormModal);
      modalForm.addEventListener('click', e => { if (e.target === modalForm) closeFormModal(); });
      document.getElementById('close-modal-view').addEventListener('click', closeViewModal);
      document.getElementById('close-view-btn').addEventListener('click', closeViewModal);
      modalView.addEventListener('click', e => { if (e.target === modalView) closeViewModal(); });
      document.getElementById('close-modal-history').addEventListener('click', closeHistoryModal);
      document.getElementById('close-history-btn').addEventListener('click', closeHistoryModal);
      modalHistory.addEventListener('click', e => { if (e.target === modalHistory) closeHistoryModal(); });

      form.addEventListener('submit', e => {
        e.preventDefault();
        const id = document.getElementById('bulletin-id').value;
        const eleveId = parseInt(document.getElementById('bulletin-eleve').value);
        const periode = document.getElementById('bulletin-periode').value;
        const conduite = parseFloat(document.getElementById('bulletin-conduite').value);
        const appreciation = document.getElementById('bulletin-appreciation').value;
        if (!eleveId) { showToast('Sélectionnez un élève', true); return; }

        const matieres = [];
        document.querySelectorAll('[data-matidx]').forEach(div => {
          const nom = div.querySelector('[data-field="nom"]')?.value;
          const coeff = parseFloat(div.querySelector('[data-field="coeff"]')?.value);
          const interro = parseFloat(div.querySelector('[data-field="interro"]')?.value) || 0;
          const dev1 = parseFloat(div.querySelector('[data-field="dev1"]')?.value) || 0;
          const dev2 = parseFloat(div.querySelector('[data-field="dev2"]')?.value) || 0;
          const devHebdo = parseFloat(div.querySelector('[data-field="devHebdo"]')?.value) || 0;
          const devoirs = [dev1, dev2, devHebdo].filter(v => v > 0);
          const moyenneDevoirs = devoirs.length ? devoirs.reduce((a,b) => a+b, 0) / devoirs.length : 0;
          const moy = interro > 0 && moyenneDevoirs > 0 ? (interro + moyenneDevoirs) / 2 : (interro || moyenneDevoirs);
          if (nom && !isNaN(coeff)) matieres.push({ nom, coeff, moyenne_interro: interro, moyenne_devoirs: moyenneDevoirs, moyenne_matiere: moy });
        });
        if (!matieres.length) { showToast('Ajoutez au moins une matière', true); return; }

        const data = { eleveId, periode, date: new Date().toISOString().split('T')[0], matieres, conduite, appreciation };
        if (id) {
          const idx = bulletins.findIndex(b => b.id === parseInt(id));
          if (idx !== -1) bulletins[idx] = { ...bulletins[idx], ...data };
          showToast('Bulletin modifié');
        } else {
          bulletins.push({ id: nextId++, ...data });
          showToast('Bulletin créé');
        }
        renderTable();
        closeFormModal();
      });

      // Sidebar mobile
      const sidebar = document.getElementById('sidebar'), overlay = document.getElementById('sidebar-overlay'), btnMenu = document.getElementById('btn-menu');
      btnMenu.addEventListener('click', () => { sidebar.classList.remove('-translate-x-full'); overlay.classList.add('is-open'); document.body.style.overflow = 'hidden'; });
      overlay.addEventListener('click', () => { sidebar.classList.add('-translate-x-full'); overlay.classList.remove('is-open'); document.body.style.overflow = ''; });
      window.addEventListener('resize', () => { if (window.innerWidth >= 1024) { sidebar.classList.remove('-translate-x-full'); overlay.classList.remove('is-open'); document.body.style.overflow = ''; } });

      renderTable();
    })();
  </script>
</body>
</html>
