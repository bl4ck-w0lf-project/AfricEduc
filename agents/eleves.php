<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EduManager · Élèves</title>
  <meta name="description" content="Gestion des élèves - Liste, recherche et ajout.">

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
          },
          animation: {
            "pulse-slow": "pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite"
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
    .sidebar-link--active {
      background-color: rgba(153, 251, 227, 0.2);
      color: #99fbe3;
    }
    .sidebar-link:hover:not(.sidebar-link--locked) {
      background-color: rgba(255, 255, 255, 0.1);
      transform: translateX(4px);
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
    .kpi-card {
      transition: all 0.2s ease;
    }
    .kpi-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
    }
    .action-button {
      transition: all 0.2s ease;
    }
    .action-button:hover {
      transform: scale(1.05);
    }
    .modal-overlay {
      pointer-events: none;
      opacity: 0;
      transition: opacity 0.2s ease;
      position: fixed;
      inset: 0;
      z-index: 9999;
      background: rgba(0,0,0,0.5);
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .modal-overlay.is-open {
      pointer-events: auto;
      opacity: 1;
    }
    .modal-content {
      transform: scale(0.95);
      transition: transform 0.2s ease;
      max-width: 90%;
      width: 32rem;
      background: white;
      border-radius: 1rem;
      box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
      max-height: 85vh;
      overflow-y: auto;
    }
    .modal-overlay.is-open .modal-content {
      transform: scale(1);
    }
    .toast {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background: #1e293b;
      color: white;
      padding: 12px 20px;
      border-radius: 12px;
      font-size: 0.875rem;
      z-index: 10000;
      opacity: 0;
      transition: opacity 0.3s;
      pointer-events: none;
    }
    .toast.show { opacity: 1; }
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-slate-50 to-slate-100 text-slate-800 antialiased">
  <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden"></div>

  <!-- Sidebar (tous les modules autorisés) -->
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
        <span class="text-[10px] font-medium uppercase tracking-wider text-white/70">Espace agent · Élèves</span>
      </div>
    </div>

    <nav class="flex-1 space-y-0.5 overflow-y-auto px-3 py-6 text-sm" aria-label="Navigation agent">
      <a href="dashboard_agent.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0 opacity-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h3A2.25 2.25 0 0 1 11.25 6v3A2.25 2.25 0 0 1 9 11.25H6A2.25 2.25 0 0 1 3.75 9V6ZM13.5 6A2.25 2.25 0 0 1 15.75 3.75h3A2.25 2.25 0 0 1 21 6v3A2.25 2.25 0 0 1 18.75 11.25h-3A2.25 2.25 0 0 1 13.5 9V6ZM3.75 15A2.25 2.25 0 0 1 6 12.75h3A2.25 2.25 0 0 1 11.25 15v3A2.25 2.25 0 0 1 9 20.25H6A2.25 2.25 0 0 1 3.75 18v-3ZM13.5 15A2.25 2.25 0 0 1 15.75 12.75h3A2.25 2.25 0 0 1 21 15v3A2.25 2.25 0 0 1 18.75 20.25h-3A2.25 2.25 0 0 1 13.5 18v-3Z" /></svg>
        Tableau de bord
      </a>

      <!-- Élèves (actif) -->
      <a href="eleves.html" class="sidebar-link sidebar-link--active flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0 opacity-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 0 0-4-4H8m0 0a4 4 0 0 1 8 0m-9 0a4 4 0 1 1 8 0M12 3a4 4 0 1 0 0 8 4 4 0 0 0 0-8Z" /></svg>
        Élèves
      </a>

      <!-- Notes (autorisé) -->
      <a href="notes.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0 opacity-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6.5h16M6.5 4v5M17.5 4v5M5.75 20h12.5A1.75 1.75 0 0 0 20 18.25V7.75A1.75 1.75 0 0 0 18.25 6H5.75A1.75 1.75 0 0 0 4 7.75v10.5C4 19.22 4.78 20 5.75 20Z" /></svg>
        Notes
      </a>

      <!-- Paiements (autorisé) -->
      <a href="paiements.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0 opacity-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.5 8.5h17M6 5h12a2.5 2.5 0 0 1 2.5 2.5v9A2.5 2.5 0 0 1 18 19H6a2.5 2.5 0 0 1-2.5-2.5v-9A2.5 2.5 0 0 1 6 5Z" /><path stroke-linecap="round" d="M7.5 14h4M7.5 11h9" /></svg>
        Paiements
      </a>

      <!-- Bulletins (autorisé) -->
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
          <p class="text-xs text-slate-500">Cotonou · Gestion des élèves</p>
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
      <!-- En-tête de page -->
      <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
          <h1 class="font-heading text-2xl font-bold text-slate-900 sm:text-3xl">Gestion des élèves</h1>
          <p class="mt-1 text-sm text-slate-600">Liste complète, recherche et ajout d'élèves.</p>
        </div>
        <button id="btn-open-add-modal" class="action-button inline-flex items-center gap-2 rounded-xl bg-primary px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-primary/25 transition hover:bg-primary-dark">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 4.5v15m7.5-7.5h-15"/></svg>
          Ajouter un élève
        </button>
      </div>

      <!-- KPIs -->
      <div class="grid gap-4 sm:grid-cols-3 mb-8">
        <div class="kpi-card rounded-2xl border-l-4 border-l-primary bg-white p-5 shadow-sm">
          <p class="text-xs font-semibold uppercase text-slate-500">Total élèves</p>
          <p class="text-3xl font-bold text-slate-900" id="total-eleves">14</p>
        </div>
        <div class="kpi-card rounded-2xl border-l-4 border-l-success bg-white p-5 shadow-sm">
          <p class="text-xs font-semibold uppercase text-slate-500">Nouveaux ce mois</p>
          <p class="text-3xl font-bold text-slate-900" id="new-eleves">3</p>
        </div>
        <div class="kpi-card rounded-2xl border-l-4 border-l-warning bg-white p-5 shadow-sm">
          <p class="text-xs font-semibold uppercase text-slate-500">Classes actives</p>
          <p class="text-3xl font-bold text-slate-900" id="classes-actives">4</p>
        </div>
      </div>

      <!-- Recherche & filtres -->
      <div class="mb-5 flex flex-wrap items-center gap-3">
        <div class="relative flex-1 min-w-[240px]">
          <input type="text" id="search-input" placeholder="Rechercher par nom..." class="w-full rounded-xl border border-slate-200 py-2 pl-9 pr-3 text-sm focus:border-primary focus:outline-none" />
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
          <option value="Actif">Actif</option>
          <option value="Inactif">Inactif</option>
        </select>
      </div>

      <!-- Tableau des élèves -->
      <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-md">
        <div class="overflow-x-auto">
          <table class="min-w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
              <tr>
                <th class="px-5 py-3">Nom</th>
                <th class="px-3 py-3">Classe</th>
                <th class="px-3 py-3">Âge</th>
                <th class="px-3 py-3">Contact</th>
                <th class="px-3 py-3">Statut</th>
                <th class="px-5 py-3 text-right">Actions</th>
              </tr>
            </thead>
            <tbody id="eleves-tbody" class="divide-y divide-slate-100"></tbody>
          </table>
        </div>
      </div>

      <footer class="mt-12 pb-8 text-center text-xs text-slate-400">
        EduManager — Collège Saint-Michel · Gestion des élèves
      </footer>
    </main>
  </div>

  <!-- Modale Ajout/Modification élève (avec photo) -->
  <div id="modal-add" class="modal-overlay">
    <div class="modal-content bg-white rounded-2xl shadow-2xl p-6">
      <div class="flex justify-between items-center mb-4">
        <h3 class="font-heading text-xl font-bold text-slate-900" id="modal-title">Nouvel élève</h3>
        <button id="close-modal" class="text-slate-400 hover:text-slate-600">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>
      <form id="add-eleve-form" class="space-y-4">
        <input type="hidden" id="edit-id" value="">
        <!-- Photo -->
        <div class="flex flex-col items-center gap-3 border-b border-slate-100 pb-4">
          <div id="photo-preview" class="flex h-16 w-16 items-center justify-center rounded-full bg-primary/10 text-xl font-bold text-primary">
            <span id="photo-initials">?</span>
            <img id="photo-img" src="" alt="" class="hidden h-full w-full rounded-full object-cover">
          </div>
          <div class="w-full space-y-2">
            <div>
              <label class="block text-sm font-medium">Photo (fichier)</label>
              <input type="file" id="photo-file" accept="image/*" class="w-full text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-primary/10 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-primary">
            </div>
            <div>
              <label class="block text-sm font-medium">ou URL</label>
              <input type="url" id="photo-url" placeholder="https://..." class="w-full rounded-xl border p-2">
            </div>
            <div class="flex gap-2">
              <button type="button" id="btn-apply-photo" class="flex-1 rounded-lg bg-primary/10 px-3 py-1.5 text-xs font-medium text-primary hover:bg-primary/20">Appliquer</button>
              <button type="button" id="btn-delete-photo" class="rounded-lg border border-urgent px-3 py-1.5 text-xs font-medium text-urgent hover:bg-urgent/5 hidden">Supprimer photo</button>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-2 gap-3">
          <div><label class="block text-sm font-medium">Nom</label><input type="text" id="nom" class="w-full rounded-xl border p-2" required></div>
          <div><label class="block text-sm font-medium">Prénom</label><input type="text" id="prenom" class="w-full rounded-xl border p-2" required></div>
        </div>
        <div><label class="block text-sm font-medium">Classe</label><select id="classe" class="w-full rounded-xl border p-2"><option value="6ème">6ème</option><option value="5ème">5ème</option><option value="4ème">4ème</option><option value="3ème">3ème</option><option value="Seconde">Seconde</option><option value="Première">Première</option><option value="Terminale">Terminale</option></select></div>
        <div><label class="block text-sm font-medium">Âge</label><input type="number" id="age" min="5" max="25" class="w-full rounded-xl border p-2"></div>
        <div><label class="block text-sm font-medium">Contact (téléphone parent)</label><input type="text" id="contact" class="w-full rounded-xl border p-2"></div>
        <div><label class="block text-sm font-medium">Statut</label><select id="statut" class="w-full rounded-xl border p-2"><option value="Actif">Actif</option><option value="Inactif">Inactif</option></select></div>
        <div class="flex gap-3 pt-2">
          <button type="submit" class="flex-1 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white">Enregistrer</button>
          <button type="button" id="cancel-modal" class="flex-1 rounded-xl border bg-white px-4 py-2 text-sm font-semibold">Annuler</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modale Voir détails élève -->
  <div id="modal-view" class="modal-overlay">
    <div class="modal-content bg-white rounded-2xl shadow-2xl p-6">
      <div class="flex justify-between items-center mb-4">
        <h3 class="font-heading text-xl font-bold text-slate-900">Détails de l'élève</h3>
        <button id="close-view-modal" class="text-slate-400 hover:text-slate-600">
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
      // Données mockées avec photo optionnelle
      let eleves = [
        { id: 1, nom: "KOUADIO", prenom: "Marie", classe: "3ème", age: 14, contact: "+229 97 12 34 56", statut: "Actif", photo: null },
        { id: 2, nom: "TRAORÉ", prenom: "Ibrahim", classe: "Seconde", age: 16, contact: "+229 98 76 54 32", statut: "Actif", photo: "https://randomuser.me/api/portraits/men/32.jpg" },
        { id: 3, nom: "DIALLO", prenom: "Aminata", classe: "Terminale", age: 17, contact: "+229 96 33 22 11", statut: "Actif", photo: null },
        { id: 4, nom: "N'GUESSAN", prenom: "Koffi", classe: "4ème", age: 13, contact: "+229 95 44 33 22", statut: "Inactif", photo: null },
        { id: 5, nom: "HOUNDONOU", prenom: "Jules", classe: "5ème", age: 12, contact: "+229 94 55 66 77", statut: "Actif", photo: null },
        { id: 6, nom: "AGOSSOU", prenom: "Pélagie", classe: "6ème", age: 11, contact: "+229 93 22 11 00", statut: "Actif", photo: null },
        { id: 7, nom: "SOSSOU", prenom: "Marc", classe: "Première", age: 16, contact: "+229 92 11 22 33", statut: "Actif", photo: null }
      ];
      let nextId = 8;
      let currentPhotoData = null; // base64 ou URL

      const tbody = document.getElementById('eleves-tbody');
      const searchInput = document.getElementById('search-input');
      const filterClasse = document.getElementById('filter-classe');
      const filterStatut = document.getElementById('filter-statut');
      const totalSpan = document.getElementById('total-eleves');
      const newSpan = document.getElementById('new-eleves');
      const classesSpan = document.getElementById('classes-actives');

      const modalAdd = document.getElementById('modal-add');
      const modalView = document.getElementById('modal-view');
      const closeModalBtn = document.getElementById('close-modal');
      const cancelModalBtn = document.getElementById('cancel-modal');
      const closeViewBtn = document.getElementById('close-view-modal');
      const closeViewBtn2 = document.getElementById('close-view-btn');
      const form = document.getElementById('add-eleve-form');
      const modalTitle = document.getElementById('modal-title');
      const editIdInput = document.getElementById('edit-id');
      const toast = document.getElementById('toast');

      // Gestion photo
      const photoFile = document.getElementById('photo-file');
      const photoUrl = document.getElementById('photo-url');
      const photoPreview = document.getElementById('photo-preview');
      const photoImg = document.getElementById('photo-img');
      const photoInitials = document.getElementById('photo-initials');
      const btnApplyPhoto = document.getElementById('btn-apply-photo');
      const btnDeletePhoto = document.getElementById('btn-delete-photo');

      function showToast(msg, isError = false) {
        toast.innerText = msg;
        toast.style.backgroundColor = isError ? '#ef4444' : '#10b981';
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3000);
      }

      function updatePhotoPreview(photoData) {
        if (photoData) {
          photoImg.src = photoData;
          photoImg.classList.remove('hidden');
          photoInitials.classList.add('hidden');
          btnDeletePhoto.classList.remove('hidden');
        } else {
          photoImg.classList.add('hidden');
          photoInitials.classList.remove('hidden');
          const nom = document.getElementById('nom').value.trim();
          const prenom = document.getElementById('prenom').value.trim();
          photoInitials.textContent = (prenom[0] || '') + (nom[0] || '?');
          btnDeletePhoto.classList.add('hidden');
        }
      }

      function resetPhotoFields() {
        photoFile.value = '';
        photoUrl.value = '';
        currentPhotoData = null;
        updatePhotoPreview(null);
      }

      btnApplyPhoto.addEventListener('click', () => {
        if (photoFile.files && photoFile.files[0]) {
          const reader = new FileReader();
          reader.onload = e => { currentPhotoData = e.target.result; updatePhotoPreview(currentPhotoData); };
          reader.readAsDataURL(photoFile.files[0]);
        } else if (photoUrl.value.trim()) {
          currentPhotoData = photoUrl.value.trim();
          updatePhotoPreview(currentPhotoData);
        }
      });

      btnDeletePhoto.addEventListener('click', () => {
        currentPhotoData = null;
        photoFile.value = '';
        photoUrl.value = '';
        updatePhotoPreview(null);
      });

      function openModal(editMode = false, eleve = null) {
        if (editMode && eleve) {
          modalTitle.textContent = 'Modifier l\'élève';
          editIdInput.value = eleve.id;
          document.getElementById('nom').value = eleve.nom;
          document.getElementById('prenom').value = eleve.prenom;
          document.getElementById('classe').value = eleve.classe;
          document.getElementById('age').value = eleve.age || '';
          document.getElementById('contact').value = eleve.contact || '';
          document.getElementById('statut').value = eleve.statut;
          currentPhotoData = eleve.photo || null;
          updatePhotoPreview(currentPhotoData);
        } else {
          modalTitle.textContent = 'Nouvel élève';
          editIdInput.value = '';
          form.reset();
          resetPhotoFields();
        }
        modalAdd.classList.add('is-open');
        document.body.style.overflow = 'hidden';
      }

      function closeModal() {
        modalAdd.classList.remove('is-open');
        document.body.style.overflow = '';
        form.reset();
        resetPhotoFields();
      }

      function openViewModal(eleve) {
        const content = document.getElementById('view-content');
        content.innerHTML = `
          <div class="flex items-center gap-4 border-b pb-4">
            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-primary/10 text-2xl font-bold text-primary">
              ${eleve.photo ? `<img src="${eleve.photo}" alt="Photo" class="h-full w-full rounded-full object-cover">` : `${eleve.prenom[0]}${eleve.nom[0]}`}
            </div>
            <div>
              <h4 class="text-xl font-bold">${eleve.prenom} ${eleve.nom}</h4>
              <p class="text-sm text-slate-500">${eleve.classe} · ${eleve.statut}</p>
            </div>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div><span class="text-xs uppercase text-slate-500">Âge</span><p class="font-medium">${eleve.age || '—'}</p></div>
            <div><span class="text-xs uppercase text-slate-500">Contact</span><p class="font-medium">${eleve.contact || '—'}</p></div>
          </div>
        `;
        modalView.classList.add('is-open');
        document.body.style.overflow = 'hidden';
      }

      function closeViewModal() {
        modalView.classList.remove('is-open');
        document.body.style.overflow = '';
      }

      function updateKPIs() {
        totalSpan.textContent = eleves.length;
        newSpan.textContent = eleves.filter(e => e.statut === 'Actif').slice(0,3).length;
        const classesUniques = new Set(eleves.map(e => e.classe));
        classesSpan.textContent = classesUniques.size;
      }

      function renderTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const classeFilter = filterClasse.value;
        const statutFilter = filterStatut.value;

        const filtered = eleves.filter(e => {
          const fullName = `${e.prenom} ${e.nom}`.toLowerCase();
          const matchSearch = fullName.includes(searchTerm) || e.nom.toLowerCase().includes(searchTerm);
          const matchClasse = !classeFilter || e.classe === classeFilter;
          const matchStatut = !statutFilter || e.statut === statutFilter;
          return matchSearch && matchClasse && matchStatut;
        });

        tbody.innerHTML = filtered.map(e => `
          <tr class="hover:bg-slate-50/80">
            <td class="px-5 py-4 font-medium text-slate-900">${e.prenom} ${e.nom}</td>
            <td class="px-3 py-4">${e.classe}</td>
            <td class="px-3 py-4">${e.age || '—'}</td>
            <td class="px-3 py-4">${e.contact || '—'}</td>
            <td class="px-3 py-4"><span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold ${e.statut === 'Actif' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700'}">${e.statut}</span></td>
            <td class="px-5 py-4 text-right">
              <div class="flex items-center justify-end gap-1">
                <button data-id="${e.id}" class="btn-view rounded-lg p-1.5 text-slate-500 hover:bg-slate-100" title="Voir détails">
                  <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                </button>
                <button data-id="${e.id}" class="btn-edit rounded-lg border border-slate-200 bg-white px-2.5 py-1 text-xs font-medium text-slate-700 hover:bg-slate-50">Modifier</button>
                <button data-id="${e.id}" class="btn-delete rounded-lg border border-urgent/30 bg-white px-2.5 py-1 text-xs font-medium text-urgent hover:bg-urgent/5">Supprimer</button>
              </div>
            </td>
          </tr>
        `).join('');
        updateKPIs();
      }

      searchInput.addEventListener('input', renderTable);
      filterClasse.addEventListener('change', renderTable);
      filterStatut.addEventListener('change', renderTable);

      tbody.addEventListener('click', (e) => {
        const viewBtn = e.target.closest('.btn-view');
        const editBtn = e.target.closest('.btn-edit');
        const delBtn = e.target.closest('.btn-delete');
        const id = parseInt(viewBtn?.dataset.id || editBtn?.dataset.id || delBtn?.dataset.id);
        const eleve = eleves.find(el => el.id === id);

        if (viewBtn) {
          if (eleve) openViewModal(eleve);
        }
        if (editBtn) {
          if (eleve) openModal(true, eleve);
        }
        if (delBtn) {
          if (confirm('Supprimer cet élève ?')) {
            eleves = eleves.filter(el => el.id !== id);
            renderTable();
            showToast('Élève supprimé');
          }
        }
      });

      document.getElementById('btn-open-add-modal').addEventListener('click', () => openModal(false));

      closeModalBtn.addEventListener('click', closeModal);
      cancelModalBtn.addEventListener('click', closeModal);
      modalAdd.addEventListener('click', (e) => { if (e.target === modalAdd) closeModal(); });

      closeViewBtn.addEventListener('click', closeViewModal);
      closeViewBtn2.addEventListener('click', closeViewModal);
      modalView.addEventListener('click', (e) => { if (e.target === modalView) closeViewModal(); });

      form.addEventListener('submit', (e) => {
        e.preventDefault();
        const nom = document.getElementById('nom').value.trim();
        const prenom = document.getElementById('prenom').value.trim();
        const classe = document.getElementById('classe').value;
        const age = document.getElementById('age').value;
        const contact = document.getElementById('contact').value.trim();
        const statut = document.getElementById('statut').value;
        const editId = editIdInput.value;

        if (!nom || !prenom || !classe) {
          showToast('Veuillez remplir les champs obligatoires', true);
          return;
        }

        const eleveData = {
          nom, prenom, classe,
          age: parseInt(age) || null,
          contact, statut,
          photo: currentPhotoData || null
        };

        if (editId) {
          const idx = eleves.findIndex(el => el.id === parseInt(editId));
          if (idx !== -1) {
            eleves[idx] = { ...eleves[idx], ...eleveData };
          }
          showToast('Élève modifié');
        } else {
          eleves.push({ id: nextId++, ...eleveData });
          showToast('Élève ajouté');
        }
        renderTable();
        closeModal();
      });

      // Sidebar mobile
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('sidebar-overlay');
      const btnMenu = document.getElementById('btn-menu');
      btnMenu.addEventListener('click', () => { sidebar.classList.remove('-translate-x-full'); overlay.classList.add('is-open'); document.body.style.overflow = 'hidden'; });
      overlay.addEventListener('click', () => { sidebar.classList.add('-translate-x-full'); overlay.classList.remove('is-open'); document.body.style.overflow = ''; });
      window.addEventListener('resize', () => { if (window.innerWidth >= 1024) { sidebar.classList.remove('-translate-x-full'); overlay.classList.remove('is-open'); document.body.style.overflow = ''; } });

      // Initialisation
      renderTable();
    })();
  </script>
</body>
</html>
