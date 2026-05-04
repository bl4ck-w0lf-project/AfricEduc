<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EduManager · Paiements</title>
  <meta name="description" content="Gestion des paiements et scolarité.">

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
      max-width: 90%; width: 48rem; background: white; border-radius: 1rem;
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

  <!-- Sidebar (identique) -->
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
        <span class="text-[10px] font-medium uppercase tracking-wider text-white/70">Espace agent · Paiements</span>
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
      <a href="paiements.html" class="sidebar-link sidebar-link--active flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0 opacity-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.5 8.5h17M6 5h12a2.5 2.5 0 0 1 2.5 2.5v9A2.5 2.5 0 0 1 18 19H6a2.5 2.5 0 0 1-2.5-2.5v-9A2.5 2.5 0 0 1 6 5Z" /><path stroke-linecap="round" d="M7.5 14h4M7.5 11h9" /></svg>
        Paiements
      </a>
      <a href="bulletins.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
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
          <p class="text-xs text-slate-500">Cotonou · Gestion des paiements</p>
        </div>
      </div>
      <div class="flex items-center gap-3">
        <div class="hidden md:flex items-center gap-2 bg-amber-50 border border-amber-200 rounded-full px-3 py-1.5">
          <div class="h-2 w-2 rounded-full bg-urgent animate-pulse"></div>
          <span class="text-xs font-medium text-amber-800">3 paiements en retard</span>
        </div>
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
          <h1 class="font-heading text-2xl font-bold text-slate-900 sm:text-3xl">Scolarité & Paiements</h1>
          <p class="mt-1 text-sm text-slate-600">Suivi des frais de scolarité et gestion des encaissements.</p>
        </div>
        <button id="btn-open-add-modal" class="action-button inline-flex items-center gap-2 rounded-xl bg-primary px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-primary/25 transition hover:bg-primary-dark">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 4.5v15m7.5-7.5h-15"/></svg>
          Enregistrer un paiement
        </button>
      </div>

      <!-- KPIs -->
      <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <div class="kpi-card rounded-2xl border-l-4 border-l-primary bg-white p-5 shadow-sm">
          <p class="text-xs font-semibold uppercase text-slate-500">Total à encaisser (année)</p>
          <p class="text-3xl font-bold text-slate-900" id="kpi-total-du">0 F</p>
        </div>
        <div class="kpi-card rounded-2xl border-l-4 border-l-success bg-white p-5 shadow-sm">
          <p class="text-xs font-semibold uppercase text-slate-500">Total encaissé</p>
          <p class="text-3xl font-bold text-slate-900" id="kpi-total-encaisse">0 F</p>
        </div>
        <div class="kpi-card rounded-2xl border-l-4 border-l-warning bg-white p-5 shadow-sm">
          <p class="text-xs font-semibold uppercase text-slate-500">Reste à encaisser</p>
          <p class="text-3xl font-bold text-slate-900" id="kpi-reste">0 F</p>
        </div>
        <div class="kpi-card rounded-2xl border-l-4 border-l-info bg-white p-5 shadow-sm">
          <p class="text-xs font-semibold uppercase text-slate-500">Taux de recouvrement</p>
          <p class="text-3xl font-bold text-slate-900" id="kpi-taux">0%</p>
        </div>
      </div>

      <!-- Filtres et recherche -->
      <div class="mb-5 flex flex-wrap items-center gap-3">
        <div class="relative flex-1 min-w-[240px]">
          <input type="text" id="search-input" placeholder="Rechercher par élève ou référence..." class="w-full rounded-xl border border-slate-200 py-2 pl-9 pr-3 text-sm focus:border-primary focus:outline-none" />
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
        <select id="filter-statut" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm">
          <option value="">Tous les statuts</option>
          <option value="Payé">Payé</option>
          <option value="En retard">En retard</option>
          <option value="Partiel">Partiel</option>
        </select>
      </div>

      <!-- Tableau des paiements -->
      <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-md">
        <div class="overflow-x-auto">
          <table class="min-w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
              <tr>
                <th class="px-5 py-3">Élève</th>
                <th class="px-3 py-3">Classe</th>
                <th class="px-3 py-3">Montant dû</th>
                <th class="px-3 py-3">Montant payé</th>
                <th class="px-3 py-3">Reste à payer</th>
                <th class="px-3 py-3">Statut</th>
                <th class="px-3 py-3">Référence</th>
                <th class="px-5 py-3 text-right">Actions</th>
              </tr>
            </thead>
            <tbody id="paiements-tbody" class="divide-y divide-slate-100"></tbody>
          </table>
        </div>
      </div>

      <footer class="mt-12 pb-8 text-center text-xs text-slate-400">
        EduManager — Collège Saint-Michel · Gestion des paiements
      </footer>
    </main>
  </div>

  <!-- Modale Ajout/Modification -->
  <div id="modal-form" class="modal-overlay">
    <div class="modal-content bg-white rounded-2xl shadow-2xl p-6">
      <div class="flex justify-between items-center mb-4">
        <h3 class="font-heading text-xl font-bold text-slate-900" id="modal-title">Enregistrer un paiement</h3>
        <button id="close-modal-form" class="text-slate-400 hover:text-slate-600">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>
      <form id="paiement-form" class="space-y-4">
        <input type="hidden" id="paiement-id" value="">
        <div>
          <label class="block text-sm font-medium">Élève</label>
          <select id="paiement-eleve" class="w-full rounded-xl border p-2" required>
            <option value="">-- Sélectionner --</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium">Montant total dû</label>
          <input type="number" id="paiement-montant-du" step="1000" min="0" class="w-full rounded-xl border p-2" placeholder="Ex: 250000" required>
        </div>
        <div>
          <label class="block text-sm font-medium">Montant payé</label>
          <input type="number" id="paiement-montant-paye" step="1000" min="0" class="w-full rounded-xl border p-2" placeholder="Ex: 150000" required>
        </div>
        <div>
          <label class="block text-sm font-medium">Date de paiement</label>
          <input type="date" id="paiement-date" class="w-full rounded-xl border p-2" required>
        </div>
        <div>
          <label class="block text-sm font-medium">Référence (optionnel)</label>
          <input type="text" id="paiement-ref" class="w-full rounded-xl border p-2" placeholder="Ex: RECU-001">
        </div>
        <div>
          <label class="block text-sm font-medium">Statut</label>
          <select id="paiement-statut" class="w-full rounded-xl border p-2" required>
            <option value="Payé">Payé</option>
            <option value="Partiel">Partiel</option>
            <option value="En retard">En retard</option>
          </select>
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
        <h3 class="font-heading text-xl font-bold text-slate-900">Détail du paiement</h3>
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

  <!-- Modale Historique des paiements d'un élève -->
  <div id="modal-history" class="modal-overlay">
    <div class="modal-content bg-white rounded-2xl shadow-2xl p-6">
      <div class="flex justify-between items-center mb-4">
        <h3 class="font-heading text-xl font-bold text-slate-900" id="history-title">Historique des paiements</h3>
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
      // Données mockées
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

      let paiements = [
        { id: 101, eleveId: 1, montantDu: 250000, montantPaye: 250000, date: "2026-02-10", reference: "PAY-001", statut: "Payé" },
        { id: 102, eleveId: 2, montantDu: 280000, montantPaye: 150000, date: "2026-01-20", reference: "PAY-002", statut: "Partiel" },
        { id: 103, eleveId: 3, montantDu: 300000, montantPaye: 0, date: "", reference: "", statut: "En retard" },
        { id: 104, eleveId: 4, montantDu: 220000, montantPaye: 220000, date: "2026-02-05", reference: "PAY-004", statut: "Payé" },
        { id: 105, eleveId: 5, montantDu: 200000, montantPaye: 100000, date: "2026-01-15", reference: "PAY-005", statut: "Partiel" },
        { id: 106, eleveId: 6, montantDu: 180000, montantPaye: 180000, date: "2026-02-01", reference: "PAY-006", statut: "Payé" },
        { id: 107, eleveId: 7, montantDu: 260000, montantPaye: 0, date: "", reference: "", statut: "En retard" },
        { id: 108, eleveId: 8, montantDu: 250000, montantPaye: 200000, date: "2026-02-12", reference: "PAY-008", statut: "Partiel" },
        // Ajoutons quelques transactions supplémentaires pour l'historique de Marie (id 1)
        { id: 109, eleveId: 1, montantDu: 250000, montantPaye: 50000, date: "2025-10-15", reference: "PAY-009", statut: "Partiel" },
        { id: 110, eleveId: 1, montantDu: 250000, montantPaye: 100000, date: "2025-11-20", reference: "PAY-010", statut: "Partiel" },
        { id: 111, eleveId: 1, montantDu: 250000, montantPaye: 100000, date: "2025-12-10", reference: "PAY-011", statut: "Partiel" },
        // Pour Ibrahim
        { id: 112, eleveId: 2, montantDu: 280000, montantPaye: 50000, date: "2025-09-12", reference: "PAY-012", statut: "Partiel" },
        { id: 113, eleveId: 2, montantDu: 280000, montantPaye: 50000, date: "2025-10-18", reference: "PAY-013", statut: "Partiel" },
        { id: 114, eleveId: 2, montantDu: 280000, montantPaye: 50000, date: "2025-11-22", reference: "PAY-014", statut: "Partiel" }
      ];
      let nextId = 115;

      const tbody = document.getElementById('paiements-tbody');
      const searchInput = document.getElementById('search-input');
      const filterClasse = document.getElementById('filter-classe');
      const filterStatut = document.getElementById('filter-statut');
      const kpiTotalDu = document.getElementById('kpi-total-du');
      const kpiTotalEncaisse = document.getElementById('kpi-total-encaisse');
      const kpiReste = document.getElementById('kpi-reste');
      const kpiTaux = document.getElementById('kpi-taux');

      const modalForm = document.getElementById('modal-form');
      const modalView = document.getElementById('modal-view');
      const modalHistory = document.getElementById('modal-history');
      const closeModalFormBtn = document.getElementById('close-modal-form');
      const cancelModalFormBtn = document.getElementById('cancel-modal-form');
      const closeModalViewBtn = document.getElementById('close-modal-view');
      const closeViewBtn = document.getElementById('close-view-btn');
      const closeModalHistoryBtn = document.getElementById('close-modal-history');
      const closeHistoryBtn = document.getElementById('close-history-btn');
      const form = document.getElementById('paiement-form');
      const modalTitle = document.getElementById('modal-title');
      const paiementIdInput = document.getElementById('paiement-id');
      const eleveSelect = document.getElementById('paiement-eleve');
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

      function openFormModal(editMode = false, paiement = null) {
        populateEleveSelect();
        if (editMode && paiement) {
          modalTitle.textContent = 'Modifier le paiement';
          paiementIdInput.value = paiement.id;
          eleveSelect.value = paiement.eleveId;
          document.getElementById('paiement-montant-du').value = paiement.montantDu;
          document.getElementById('paiement-montant-paye').value = paiement.montantPaye;
          document.getElementById('paiement-date').value = paiement.date;
          document.getElementById('paiement-ref').value = paiement.reference;
          document.getElementById('paiement-statut').value = paiement.statut;
        } else {
          modalTitle.textContent = 'Enregistrer un paiement';
          paiementIdInput.value = '';
          form.reset();
        }
        modalForm.classList.add('is-open');
        document.body.style.overflow = 'hidden';
      }

      function closeFormModal() {
        modalForm.classList.remove('is-open');
        document.body.style.overflow = '';
        form.reset();
      }

      function openViewModal(paiement) {
        const eleve = eleves.find(e => e.id === paiement.eleveId);
        const reste = paiement.montantDu - paiement.montantPaye;
        const content = document.getElementById('view-content');
        content.innerHTML = `
          <div class="border-b pb-3">
            <p class="text-lg font-bold">${eleve.prenom} ${eleve.nom}</p>
            <p class="text-sm text-slate-500">${eleve.classe} · Réf: ${paiement.reference || '—'}</p>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div><span class="text-xs uppercase text-slate-500">Montant dû</span><p class="font-medium">${paiement.montantDu.toLocaleString()} F</p></div>
            <div><span class="text-xs uppercase text-slate-500">Montant payé</span><p class="font-medium text-success">${paiement.montantPaye.toLocaleString()} F</p></div>
            <div><span class="text-xs uppercase text-slate-500">Reste à payer</span><p class="font-medium ${reste > 0 ? 'text-urgent' : 'text-success'}">${reste.toLocaleString()} F</p></div>
            <div><span class="text-xs uppercase text-slate-500">Date</span><p class="font-medium">${paiement.date || '—'}</p></div>
            <div><span class="text-xs uppercase text-slate-500">Statut</span><p class="font-medium">${paiement.statut}</p></div>
          </div>
        `;
        modalView.classList.add('is-open');
        document.body.style.overflow = 'hidden';
      }

      function closeViewModal() {
        modalView.classList.remove('is-open');
        document.body.style.overflow = '';
      }

      function openHistoryModal(eleveId) {
        const eleve = eleves.find(e => e.id === eleveId);
        if (!eleve) return;

        const elevePaiements = paiements.filter(p => p.eleveId === eleveId).sort((a,b) => new Date(b.date) - new Date(a.date));
        const totalDu = elevePaiements.length > 0 ? elevePaiements[0].montantDu : 0;
        const totalPaye = elevePaiements.reduce((sum, p) => sum + p.montantPaye, 0);
        const reste = totalDu - totalPaye;

        const historyTitle = document.getElementById('history-title');
        historyTitle.textContent = `Historique · ${eleve.prenom} ${eleve.nom} (${eleve.classe})`;

        let html = `
          <div class="bg-slate-50 p-4 rounded-xl mb-4 grid grid-cols-3 gap-4 text-center">
            <div>
              <p class="text-xs text-slate-500">Total dû</p>
              <p class="text-xl font-bold">${totalDu.toLocaleString()} F</p>
            </div>
            <div>
              <p class="text-xs text-slate-500">Total payé</p>
              <p class="text-xl font-bold text-success">${totalPaye.toLocaleString()} F</p>
            </div>
            <div>
              <p class="text-xs text-slate-500">Reste à payer</p>
              <p class="text-xl font-bold ${reste > 0 ? 'text-urgent' : 'text-success'}">${reste.toLocaleString()} F</p>
            </div>
          </div>
          <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
              <thead class="bg-slate-100 text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr>
                  <th class="px-3 py-2">Date</th>
                  <th class="px-3 py-2">Montant payé</th>
                  <th class="px-3 py-2">Référence</th>
                  <th class="px-3 py-2">Statut</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100">
                ${elevePaiements.map(p => {
                  const badgeColor = p.statut === 'Payé' ? 'bg-emerald-100 text-emerald-800' : (p.statut === 'Partiel' ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-800');
                  return `
                  <tr>
                    <td class="px-3 py-3">${p.date || '—'}</td>
                    <td class="px-3 py-3 font-medium">${p.montantPaye.toLocaleString()} F</td>
                    <td class="px-3 py-3 font-mono text-xs">${p.reference || '—'}</td>
                    <td class="px-3 py-3"><span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold ${badgeColor}">${p.statut}</span></td>
                  </tr>
                `}).join('')}
              </tbody>
            </table>
          </div>
        `;

        document.getElementById('history-content').innerHTML = html;
        modalHistory.classList.add('is-open');
        document.body.style.overflow = 'hidden';
      }

      function closeHistoryModal() {
        modalHistory.classList.remove('is-open');
        document.body.style.overflow = '';
      }

      function updateKPIs(filteredData) {
        // Pour les KPIs on garde la logique de somme sur les paiements (peut-être en doublon si plusieurs lignes par élève, mais c'est acceptable pour la démo)
        const totalDu = filteredData.reduce((sum, p) => sum + p.montantDu, 0);
        const totalEncaisse = filteredData.reduce((sum, p) => sum + p.montantPaye, 0);
        const reste = totalDu - totalEncaisse;
        const taux = totalDu ? Math.round((totalEncaisse / totalDu) * 100) : 0;

        kpiTotalDu.textContent = totalDu.toLocaleString() + ' F';
        kpiTotalEncaisse.textContent = totalEncaisse.toLocaleString() + ' F';
        kpiReste.textContent = reste.toLocaleString() + ' F';
        kpiTaux.textContent = taux + '%';
      }

      function renderTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const classeFilter = filterClasse.value;
        const statutFilter = filterStatut.value;

        let filtered = paiements.filter(p => {
          const eleve = eleves.find(e => e.id === p.eleveId);
          if (!eleve) return false;
          const eleveName = `${eleve.prenom} ${eleve.nom}`.toLowerCase();
          const matchSearch = eleveName.includes(searchTerm) || (p.reference || '').toLowerCase().includes(searchTerm);
          const matchClasse = !classeFilter || eleve.classe === classeFilter;
          const matchStatut = !statutFilter || p.statut === statutFilter;
          return matchSearch && matchClasse && matchStatut;
        });

        tbody.innerHTML = filtered.map(p => {
          const eleve = eleves.find(e => e.id === p.eleveId);
          const reste = p.montantDu - p.montantPaye;
          const badgeColor = p.statut === 'Payé' ? 'bg-emerald-100 text-emerald-800' : (p.statut === 'Partiel' ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-800');
          return `
            <tr class="hover:bg-slate-50/80">
              <td class="px-5 py-4 font-medium text-slate-900">${eleve.prenom} ${eleve.nom}</td>
              <td class="px-3 py-4">${eleve.classe}</td>
              <td class="px-3 py-4">${p.montantDu.toLocaleString()} F</td>
              <td class="px-3 py-4 text-success font-medium">${p.montantPaye.toLocaleString()} F</td>
              <td class="px-3 py-4 ${reste > 0 ? 'text-urgent font-medium' : 'text-slate-600'}">${reste.toLocaleString()} F</td>
              <td class="px-3 py-4"><span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold ${badgeColor}">${p.statut}</span></td>
              <td class="px-3 py-4 font-mono text-xs">${p.reference || '—'}</td>
              <td class="px-5 py-4 text-right">
                <div class="flex items-center justify-end gap-1">
                  <button data-id="${p.id}" data-eleve="${p.eleveId}" class="btn-view rounded-lg p-1.5 text-slate-500 hover:bg-slate-100" title="Voir détails">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                  </button>
                  <button data-id="${p.id}" class="btn-edit rounded-lg border border-slate-200 bg-white px-2.5 py-1 text-xs font-medium text-slate-700 hover:bg-slate-50">Modifier</button>
                  <button data-id="${p.id}" data-eleve="${p.eleveId}" class="btn-history rounded-lg border border-info/30 bg-info/5 px-2.5 py-1 text-xs font-medium text-info hover:bg-info/10">Historique</button>
                  <button data-id="${p.id}" class="btn-delete rounded-lg border border-urgent/30 bg-white px-2.5 py-1 text-xs font-medium text-urgent hover:bg-urgent/5">Supprimer</button>
                </div>
              </td>
            </tr>
          `;
        }).join('');

        updateKPIs(filtered);
      }

      searchInput.addEventListener('input', renderTable);
      filterClasse.addEventListener('change', renderTable);
      filterStatut.addEventListener('change', renderTable);

      tbody.addEventListener('click', (e) => {
        const viewBtn = e.target.closest('.btn-view');
        const editBtn = e.target.closest('.btn-edit');
        const historyBtn = e.target.closest('.btn-history');
        const delBtn = e.target.closest('.btn-delete');
        const id = parseInt(viewBtn?.dataset.id || editBtn?.dataset.id || historyBtn?.dataset.id || delBtn?.dataset.id);
        const paiement = paiements.find(p => p.id === id);

        if (viewBtn) { if (paiement) openViewModal(paiement); }
        if (editBtn) { if (paiement) openFormModal(true, paiement); }
        if (historyBtn) { 
          const eleveId = parseInt(historyBtn.dataset.eleve);
          openHistoryModal(eleveId);
        }
        if (delBtn) {
          if (confirm('Supprimer ce paiement ?')) {
            paiements = paiements.filter(p => p.id !== id);
            renderTable();
            showToast('Paiement supprimé');
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

      closeModalHistoryBtn.addEventListener('click', closeHistoryModal);
      closeHistoryBtn.addEventListener('click', closeHistoryModal);
      modalHistory.addEventListener('click', (e) => { if (e.target === modalHistory) closeHistoryModal(); });

      form.addEventListener('submit', (e) => {
        e.preventDefault();
        const eleveId = parseInt(eleveSelect.value);
        const montantDu = parseFloat(document.getElementById('paiement-montant-du').value);
        const montantPaye = parseFloat(document.getElementById('paiement-montant-paye').value);
        const date = document.getElementById('paiement-date').value;
        const reference = document.getElementById('paiement-ref').value.trim();
        const statut = document.getElementById('paiement-statut').value;
        const editId = paiementIdInput.value;

        if (!eleveId || isNaN(montantDu) || isNaN(montantPaye) || !date) {
          showToast('Veuillez remplir tous les champs obligatoires', true);
          return;
        }

        const paiementData = { eleveId, montantDu, montantPaye, date, reference, statut };

        if (editId) {
          const idx = paiements.findIndex(p => p.id === parseInt(editId));
          if (idx !== -1) {
            paiements[idx] = { ...paiements[idx], ...paiementData };
          }
          showToast('Paiement modifié');
        } else {
          paiements.push({ id: nextId++, ...paiementData });
          showToast('Paiement enregistré');
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
