<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion des agents | EduManager</title>
  <meta name="description" content="Créez et gérez les agents de votre établissement sur EduManager.">

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
      background-color: rgba(153, 251, 227, 0.2);
      color: #99fbe3;
    }
    .submenu {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.35s ease;
    }
    .submenu.open {
      max-height: 320px;
    }
    #sidebar-overlay,
    #modal-overlay,
    #delete-overlay {
      pointer-events: none;
      opacity: 0;
      transition: opacity 0.2s ease;
    }
    #sidebar-overlay.is-open,
    #modal-overlay.is-open,
    #delete-overlay.is-open {
      pointer-events: auto;
      opacity: 1;
    }
    .modal-panel {
      transform: scale(0.96) translateY(8px);
      opacity: 0;
      transition: transform 0.25s ease, opacity 0.25s ease;
    }
    .modal-panel.is-open {
      transform: scale(1) translateY(0);
      opacity: 1;
    }
    .perm-checkbox {
      accent-color: #7300e9;
    }
    .delete-dialog {
      animation: fadeSlideIn 0.2s ease-out;
    }
    @keyframes fadeSlideIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">
  <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden" aria-hidden="true"></div>

  <aside id="sidebar" class="fixed left-0 top-0 z-50 flex h-full w-[260px] -translate-x-full flex-col bg-primary text-white shadow-xl transition-transform duration-200 lg:translate-x-0">
    <div class="flex h-16 items-center gap-3 border-b border-white/15 px-4">
      <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10">
        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6.75C4 5.78 4.78 5 5.75 5h4.5c.46 0 .9.18 1.22.51l.56.56c.33.33.77.51 1.24.51h5.98c.97 0 1.75.78 1.75 1.75v8.92c0 .97-.78 1.75-1.75 1.75H5.75A1.75 1.75 0 0 1 4 17.25V6.75Z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M8 11.5h8M8 14.5h5" />
        </svg>
      </span>
      <span class="font-heading text-lg font-bold tracking-tight">EduManager</span>
    </div>

    <nav class="flex-1 overflow-y-auto px-2 py-4 text-sm" aria-label="Navigation principale">
      <a href="dashboard_admin.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0 opacity-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h3A2.25 2.25 0 0 1 11.25 6v3A2.25 2.25 0 0 1 9 11.25H6A2.25 2.25 0 0 1 3.75 9V6ZM3.75 15A2.25 2.25 0 0 1 6 12.75h3A2.25 2.25 0 0 1 11.25 15v3A2.25 2.25 0 0 1 9 20.25H6A2.25 2.25 0 0 1 3.75 18v-3ZM13.5 6A2.25 2.25 0 0 1 15.75 3.75h3A2.25 2.25 0 0 1 21 6v3A2.25 2.25 0 0 1 18.75 11.25h-3A2.25 2.25 0 0 1 13.5 9V6ZM13.5 15A2.25 2.25 0 0 1 15.75 12.75h3A2.25 2.25 0 0 1 21 15v3A2.25 2.25 0 0 1 18.75 20.25h-3A2.25 2.25 0 0 1 13.5 18v-3Z" /></svg>
        Dashboard
      </a>

      <div class="mt-1">
        <button type="button" class="sidebar-toggle flex w-full items-center justify-between gap-2 rounded-xl px-3 py-2.5 text-left text-white/95 hover:bg-white/10" data-submenu="sub-ecole" aria-expanded="true">
          <span class="flex items-center gap-3">
            <svg class="h-5 w-5 shrink-0 opacity-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5V8.25L12 4l8 4.25V19.5" /><path stroke-linecap="round" stroke-linejoin="round" d="M9 19.5V12h6v7.5" /></svg>
            Mon école
          </span>
          <svg class="chevron h-4 w-4 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
        </button>
        <div id="sub-ecole" class="submenu open pl-2">
          <a href="#" class="sidebar-link mt-1 block rounded-lg py-2 pl-10 pr-3 text-white/85">Configuration</a>
          <a href="#" class="sidebar-link block rounded-lg py-2 pl-10 pr-3 text-white/85">Identité & contact</a>
        </div>
      </div>

      <div class="mt-1">
        <button type="button" class="sidebar-toggle flex w-full items-center justify-between gap-2 rounded-xl px-3 py-2.5 text-left text-white/95 hover:bg-white/10" data-submenu="sub-org" aria-expanded="true">
          <span class="flex items-center gap-3">
            <svg class="h-5 w-5 shrink-0 opacity-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M6 6.75h12M6 12h12m-12 5.25h12M4.5 4.5h15a1.5 1.5 0 0 1 1.5 1.5v12a1.5 1.5 0 0 1-1.5 1.5h-15a1.5 1.5 0 0 1-1.5-1.5V6a1.5 1.5 0 0 1 1.5-1.5Z" /></svg>
            Organisation
          </span>
          <svg class="chevron h-4 w-4 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
        </button>
        <div id="sub-org" class="submenu open pl-2">
          <a href="#" class="sidebar-link mt-1 block rounded-lg py-2 pl-10 pr-3 text-white/85">Classes / Groupes</a>
          <a href="#" class="sidebar-link block rounded-lg py-2 pl-10 pr-3 text-white/85">Matières</a>
        </div>
      </div>

      <a href="#" class="sidebar-link mt-2 flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0 opacity-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" /><path stroke-linecap="round" stroke-linejoin="round" d="M6.5 17a4 4 0 1 1 8 0" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 1 0-6 0 3 3 0 0 0 6 0Z" /></svg>
        Élèves / Étudiants
      </a>
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0 opacity-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6.5h16M6.5 4v5M17.5 4v5M5.75 20h12.5A1.75 1.75 0 0 0 20 18.25V7.75A1.75 1.75 0 0 0 18.25 6H5.75A1.75 1.75 0 0 0 4 7.75v10.5C4 19.22 4.78 20 5.75 20Z" /><path stroke-linecap="round" stroke-linejoin="round" d="m9 15 2 2 4-4" /></svg>
        Notes &amp; Moyennes
      </a>
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0 opacity-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.5 8.5h17M6 5h12a2.5 2.5 0 0 1 2.5 2.5v9A2.5 2.5 0 0 1 18 19H6a2.5 2.5 0 0 1-2.5-2.5v-9A2.5 2.5 0 0 1 6 5Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14h4M7.5 11h9" /></svg>
        Scolarité &amp; Paiements
      </a>
      <a href="manage_agents.html" class="sidebar-link active flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0 opacity-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM4 20a8 8 0 0 1 15.659-2.165" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Z" /></svg>
        Agents
      </a>
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0 opacity-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3.75h10.5l3 4.5v9.75a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25l3-4.5Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6M9 15.75h3" /></svg>
        Bulletins &amp; Documents
      </a>
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">
        <svg class="h-5 w-5 shrink-0 opacity-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18" /><path stroke-linecap="round" stroke-linejoin="round" d="M7 16v-5M12 16V8m5 8V11" /></svg>
        Statistiques
      </a>

      <div class="mt-6 border-t border-white/15 pt-4">
        <a href="login.html" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 text-red-200 hover:bg-red-500/20 hover:text-white">
          <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" /></svg>
          Déconnexion
        </a>
      </div>
    </nav>
  </aside>

  <div class="min-h-screen lg:pl-[260px]">
    <header class="sticky top-0 z-30 flex h-16 items-center justify-between gap-4 border-b border-slate-200/80 bg-white/90 px-4 backdrop-blur-md sm:px-6">
      <div class="flex items-center gap-3">
        <button type="button" id="btn-menu" class="inline-flex rounded-xl border border-slate-200 p-2 text-slate-700 hover:bg-slate-50 lg:hidden" aria-label="Ouvrir le menu">
          <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
        </button>
        <div>
          <p class="font-heading text-sm font-semibold text-primary sm:text-base">Collège Saint-Michel</p>
          <p class="text-xs text-slate-500">Cotonou, Bénin</p>
        </div>
      </div>
      <div class="flex items-center gap-3">
        <span class="hidden rounded-full border border-accent/50 bg-accent/30 px-3 py-1 text-xs font-medium text-slate-800 sm:inline-flex">Année 2025–2026</span>
        <button type="button" class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-2 py-1.5 pr-3 shadow-sm transition hover:border-primary/30">
          <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-primary/10 text-sm font-bold text-primary">AK</span>
          <span class="hidden text-left text-sm sm:block">
            <span class="block font-medium text-slate-900">Aminata Kossi</span>
            <span class="text-xs text-slate-500">Administratrice</span>
          </span>
        </button>
      </div>
    </header>

    <main class="px-4 py-6 sm:px-6 lg:px-8">
      <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h1 class="font-heading text-2xl font-bold text-slate-900 sm:text-3xl">Gestion des agents</h1>
          <p class="mt-1 text-sm text-slate-600">Créez des comptes agents et définissez leurs droits sur votre établissement.</p>
        </div>
        <button type="button" id="btn-open-create" class="inline-flex items-center justify-center gap-2 rounded-xl bg-primary px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-primary/25 transition hover:bg-violet-800">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
          Ajouter un agent
        </button>
      </div>

      <!-- Barre de recherche -->
      <div class="mt-6">
        <div class="relative max-w-md">
          <input type="text" id="search-input" placeholder="Rechercher par nom ou email..." class="w-full rounded-xl border border-slate-200 py-2.5 pl-10 pr-4 text-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20">
          <svg class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 1 1-12 0 6 6 0 0 1 12 0z"/></svg>
        </div>
      </div>

      <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200/90 bg-white shadow-sm">
        <div class="overflow-x-auto">
          <table class="min-w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
              <tr>
                <th class="whitespace-nowrap px-4 py-3 sm:px-5">Photo</th>
                <th class="whitespace-nowrap px-3 py-3">Nom</th>
                <th class="whitespace-nowrap px-3 py-3">Email</th>
                <th class="whitespace-nowrap px-3 py-3">Rôle</th>
                <th class="whitespace-nowrap px-3 py-3">Statut</th>
                <th class="min-w-[140px] px-3 py-3">Permissions</th>
                <th class="whitespace-nowrap px-4 py-3 text-right sm:px-5">Actions</th>
              </tr>
            </thead>
            <tbody id="agents-tbody" class="divide-y divide-slate-100 text-slate-700"></tbody>
          </table>
        </div>
      </div>

      <p id="page-toast" class="fixed bottom-6 left-1/2 z-[60] hidden -translate-x-1/2 rounded-xl bg-slate-900 px-4 py-2 text-sm text-white shadow-lg" role="status"></p>
    </main>
  </div>

  <!-- Modal agent -->
  <div id="modal-overlay" class="fixed inset-0 z-[100] flex items-end justify-center bg-slate-900/55 p-4 sm:items-center" aria-hidden="true">
    <div id="modal-panel" class="modal-panel relative max-h-[92vh] w-full max-w-2xl overflow-y-auto rounded-2xl border border-slate-200 bg-white shadow-2xl" role="dialog" aria-modal="true" aria-labelledby="modal-title">
      <div class="sticky top-0 z-10 flex items-center justify-between border-b border-slate-100 bg-white px-5 py-4 sm:px-6">
        <h2 id="modal-title" class="font-heading text-lg font-bold text-slate-900">Nouvel agent</h2>
        <button type="button" id="modal-close" class="rounded-lg p-2 text-slate-500 hover:bg-slate-100" aria-label="Fermer">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M6 18 18 6M6 6l12 12"/></svg>
        </button>
      </div>

      <form id="agent-form" class="px-5 py-4 sm:px-6 sm:py-5" novalidate>
        <input type="hidden" name="agent_id" id="field_agent_id" value="">
        <input type="hidden" name="form_action" id="field_form_action" value="create_agent">
        <!-- Champ caché pour stocker la photo en base64 si upload local -->
        <input type="hidden" name="photo_data" id="photo_data" value="">

        <!-- Photo de profil -->
        <div class="mb-5 flex flex-col items-center gap-3 border-b border-slate-100 pb-5">
          <div class="flex flex-wrap items-center gap-4">
            <div id="avatar-preview" class="flex h-16 w-16 items-center justify-center rounded-full bg-primary/10 text-xl font-bold text-primary shadow-sm ring-2 ring-white">
              <span id="avatar-initials">?</span>
              <img id="avatar-img" src="" alt="" class="hidden h-full w-full rounded-full object-cover">
            </div>
            <div class="flex-1 space-y-2">
              <div>
                <label class="block text-sm font-medium text-slate-700">Photo (fichier)</label>
                <input type="file" id="photo_file" accept="image/*" class="mt-1 w-full text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-primary/10 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-primary hover:file:bg-primary/20">
              </div>
              <div>
                <label for="photo_url" class="block text-sm font-medium text-slate-700">ou URL</label>
                <input type="url" id="photo_url" name="photo_url" placeholder="https://..." class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
              </div>
              <p class="text-xs text-slate-500">Priorité au fichier uploadé.</p>
            </div>
          </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
          <div class="sm:col-span-2">
            <label for="full_name" class="block text-sm font-medium text-slate-700">Nom complet</label>
            <input type="text" id="full_name" name="full_name" required autocomplete="name" class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
            <p id="err_full_name" class="mt-1 hidden text-sm text-red-600"></p>
          </div>
          <div class="sm:col-span-2">
            <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
            <input type="email" id="email" name="email" required autocomplete="email" class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
            <p id="err_email" class="mt-1 hidden text-sm text-red-600"></p>
          </div>
          <div class="sm:col-span-2">
            <label for="password" class="block text-sm font-medium text-slate-700">Mot de passe <span id="pwd-optional-hint" class="hidden font-normal text-slate-500">(optionnel si modification)</span></label>
            <div class="mt-1 flex flex-col gap-2 sm:flex-row sm:items-center">
              <input type="text" id="password" name="password" autocomplete="new-password" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 font-mono text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 sm:flex-1">
              <div class="flex shrink-0 gap-2">
                <button type="button" id="btn-gen-pwd" class="rounded-xl border border-primary/30 bg-primary/5 px-3 py-2.5 text-xs font-semibold text-primary transition hover:bg-primary/10">Générer</button>
                <button type="button" id="btn-copy-pwd" class="rounded-xl border border-slate-200 px-3 py-2.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-50">Copier</button>
              </div>
            </div>
            <p id="err_password" class="mt-1 hidden text-sm text-red-600"></p>
          </div>
          <div class="sm:col-span-2">
            <label for="role" class="block text-sm font-medium text-slate-700">Rôle</label>
            <select id="role" name="role" class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
              <option value="Administrateur">Administrateur</option>
              <option value="Enseignant">Enseignant</option>
              <option value="Personnel">Personnel</option>
            </select>
          </div>
          <div class="sm:col-span-2">
            <span class="block text-sm font-medium text-slate-700">Statut du compte</span>
            <div class="mt-2 flex flex-wrap gap-4">
              <label class="inline-flex cursor-pointer items-center gap-2">
                <input type="radio" name="status" value="active" checked class="perm-checkbox h-4 w-4 border-slate-300 text-primary focus:ring-primary">
                <span>Actif</span>
              </label>
              <label class="inline-flex cursor-pointer items-center gap-2">
                <input type="radio" name="status" value="inactive" class="perm-checkbox h-4 w-4 border-slate-300 text-primary focus:ring-primary">
                <span>Inactif</span>
              </label>
            </div>
          </div>
        </div>

        <div id="perm-section" class="mt-8 scroll-mt-24">
          <h3 class="font-heading border-b border-slate-100 pb-2 text-base font-bold text-slate-900">Permissions</h3>

          <div class="mt-4 space-y-5 rounded-2xl border border-slate-100 bg-slate-50/50 p-4">
            <div class="perm-group" data-group="students">
              <div class="flex flex-wrap items-center justify-between gap-2">
                <span class="font-semibold text-slate-800">Élèves</span>
                <button type="button" class="select-group-btn text-xs font-semibold text-primary hover:underline">Tout sélectionner</button>
              </div>
              <ul class="mt-3 space-y-2">
                <li><label class="flex cursor-pointer items-center gap-2"><input type="checkbox" name="perm_student_add" value="1" class="perm-checkbox h-4 w-4 rounded border-slate-300"> Ajouter un élève</label></li>
                <li><label class="flex cursor-pointer items-center gap-2"><input type="checkbox" name="perm_student_edit" value="1" class="perm-checkbox h-4 w-4 rounded border-slate-300"> Modifier un élève</label></li>
                <li><label class="flex cursor-pointer items-center gap-2"><input type="checkbox" name="perm_student_delete" value="1" class="perm-checkbox h-4 w-4 rounded border-slate-300"> Supprimer un élève</label></li>
              </ul>
            </div>
            <div class="perm-group" data-group="grades">
              <div class="flex flex-wrap items-center justify-between gap-2">
                <span class="font-semibold text-slate-800">Notes</span>
                <button type="button" class="select-group-btn text-xs font-semibold text-primary hover:underline">Tout sélectionner</button>
              </div>
              <ul class="mt-3 space-y-2">
                <li><label class="flex cursor-pointer items-center gap-2"><input type="checkbox" name="perm_grade_add" value="1" class="perm-checkbox h-4 w-4 rounded border-slate-300"> Saisir des notes</label></li>
                <li><label class="flex cursor-pointer items-center gap-2"><input type="checkbox" name="perm_grade_edit" value="1" class="perm-checkbox h-4 w-4 rounded border-slate-300"> Modifier des notes</label></li>
                <li><label class="flex cursor-pointer items-center gap-2"><input type="checkbox" name="perm_grade_delete" value="1" class="perm-checkbox h-4 w-4 rounded border-slate-300"> Supprimer des notes</label></li>
              </ul>
            </div>
            <div class="perm-group" data-group="payments">
              <div class="flex flex-wrap items-center justify-between gap-2">
                <span class="font-semibold text-slate-800">Paiements</span>
                <button type="button" class="select-group-btn text-xs font-semibold text-primary hover:underline">Tout sélectionner</button>
              </div>
              <ul class="mt-3 space-y-2">
                <li><label class="flex cursor-pointer items-center gap-2"><input type="checkbox" name="perm_payment_add" value="1" class="perm-checkbox h-4 w-4 rounded border-slate-300"> Enregistrer un paiement</label></li>
                <li><label class="flex cursor-pointer items-center gap-2"><input type="checkbox" name="perm_payment_edit" value="1" class="perm-checkbox h-4 w-4 rounded border-slate-300"> Modifier un paiement</label></li>
                <li><label class="flex cursor-pointer items-center gap-2"><input type="checkbox" name="perm_payment_delete" value="1" class="perm-checkbox h-4 w-4 rounded border-slate-300"> Supprimer un paiement</label></li>
              </ul>
            </div>
            <div class="perm-group" data-group="docs">
              <div class="flex flex-wrap items-center justify-between gap-2">
                <span class="font-semibold text-slate-800">Documents</span>
                <button type="button" class="select-group-btn text-xs font-semibold text-primary hover:underline">Tout sélectionner</button>
              </div>
              <ul class="mt-3 space-y-2">
                <li><label class="flex cursor-pointer items-center gap-2"><input type="checkbox" name="perm_doc_bulletin" value="1" class="perm-checkbox h-4 w-4 rounded border-slate-300"> Générer des bulletins</label></li>
                <li><label class="flex cursor-pointer items-center gap-2"><input type="checkbox" name="perm_doc_export" value="1" class="perm-checkbox h-4 w-4 rounded border-slate-300"> Exporter des données</label></li>
                <li><label class="flex cursor-pointer items-center gap-2"><input type="checkbox" name="perm_doc_import" value="1" class="perm-checkbox h-4 w-4 rounded border-slate-300"> Importer des données</label></li>
              </ul>
            </div>
          </div>
        </div>

        <p id="form-submit-err" class="mt-4 hidden rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800"></p>

        <div class="mt-6 flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
          <button type="button" id="btn-cancel-modal" class="rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Annuler</button>
          <button type="submit" id="btn-save-agent" class="rounded-xl bg-primary px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-violet-800 disabled:opacity-60">
            Enregistrer
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Delete confirm -->
  <div id="delete-overlay" class="fixed inset-0 z-[110] flex items-center justify-center bg-slate-900/55 p-4" aria-hidden="true">
    <div id="delete-panel" class="delete-dialog modal-panel w-full max-w-md rounded-2xl border border-slate-200 bg-white p-6 shadow-2xl" role="dialog" aria-modal="true" aria-labelledby="delete-title">
      <div class="flex items-start gap-4">
        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-100 text-red-600">
          <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15h.008v.008H12v-.008z"/></svg>
        </div>
        <div class="flex-1">
          <h2 id="delete-title" class="font-heading text-lg font-bold text-slate-900">Supprimer l’agent</h2>
          <p id="delete-message" class="mt-1 text-sm text-slate-600">Cette action est irréversible.</p>
        </div>
      </div>
      <div class="mt-6 flex justify-end gap-3">
        <button type="button" id="delete-cancel" class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Annuler</button>
        <button type="button" id="delete-confirm" class="rounded-xl bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">Supprimer</button>
      </div>
    </div>
  </div>

  <script>
    (function () {
      var API_URL = "app/controllers/UserController.php";

      // Données mockées enrichies
      var agents = [
        {
          id: "1",
          name: "José Mensah",
          email: "j.mensah@saintmichel.bj",
          role: "Administrateur",
          active: true,
          photo: null,
          perms: { student_add: 1, student_edit: 1, grade_add: 1, grade_edit: 1, payment_add: 1, doc_bulletin: 0, doc_export: 1, doc_import: 0 }
        },
        {
          id: "2",
          name: "Florentine Adjobi",
          email: "f.adjobi@saintmichel.bj",
          role: "Enseignant",
          active: true,
          photo: "https://randomuser.me/api/portraits/women/44.jpg",
          perms: { student_add: 0, payment_add: 1, payment_edit: 1, doc_export: 1 }
        },
        {
          id: "3",
          name: "Brice Sèdégnon",
          email: "b.sedegnon@saintmichel.bj",
          role: "Personnel",
          active: false,
          photo: null,
          perms: {}
        }
      ];

      var permKeys = [
        "perm_student_add", "perm_student_edit", "perm_student_delete",
        "perm_grade_add", "perm_grade_edit", "perm_grade_delete",
        "perm_payment_add", "perm_payment_edit", "perm_payment_delete",
        "perm_doc_bulletin", "perm_doc_export", "perm_doc_import"
      ];

      function permSummary(p) {
        var n = 0;
        if (!p) return "—";
        Object.keys(p).forEach(function (k) { if (p[k]) n++; });
        if (n === 0) return "Aucune";
        return n + " droit" + (n > 1 ? "s" : "");
      }

      function initials(name) {
        return name.split(/\s+/).filter(Boolean).slice(0,2).map(w => w[0].toUpperCase()).join("");
      }

      function renderAvatar(agent) {
        if (agent.photo && agent.photo.trim() !== '') {
          return '<img src="' + agent.photo + '" alt="' + agent.name + '" class="h-10 w-10 rounded-full object-cover ring-2 ring-white shadow-sm">';
        } else {
          return '<span class="flex h-10 w-10 items-center justify-center rounded-full bg-primary/15 text-sm font-bold text-primary shadow-sm ring-2 ring-white">' + initials(agent.name) + '</span>';
        }
      }

      var allAgents = agents;

      function filterAgents(searchTerm) {
        var term = searchTerm.trim().toLowerCase();
        if (term === '') return allAgents;
        return allAgents.filter(a => a.name.toLowerCase().includes(term) || a.email.toLowerCase().includes(term));
      }

      function renderTable(filteredList) {
        var tb = document.getElementById("agents-tbody");
        var list = filteredList || allAgents;
        tb.innerHTML = list.map(a => {
          var statusBadge = a.active
            ? '<span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-800"><span class="h-2 w-2 rounded-full bg-emerald-500"></span>Actif</span>'
            : '<span class="inline-flex items-center gap-1 rounded-full bg-rose-100 px-2.5 py-1 text-xs font-semibold text-rose-800"><span class="h-2 w-2 rounded-full bg-rose-500"></span>Inactif</span>';

          var toggleBtn = a.active
            ? '<button type="button" class="action-toggle inline-flex items-center gap-1 rounded-lg border border-rose-200 bg-rose-50 px-2.5 py-1 text-xs font-medium text-rose-700 hover:bg-rose-100" data-id="' + a.id + '"><svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>Désactiver</button>'
            : '<button type="button" class="action-toggle inline-flex items-center gap-1 rounded-lg border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700 hover:bg-emerald-100" data-id="' + a.id + '"><svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>Activer</button>';

          return `
            <tr class="hover:bg-violet-50/40">
              <td class="px-4 py-3 sm:px-5">${renderAvatar(a)}</td>
              <td class="px-3 py-3 font-medium text-slate-900">${a.name}</td>
              <td class="px-3 py-3 text-slate-600">${a.email}</td>
              <td class="px-3 py-3"><span class="rounded-full bg-violet-100 px-2 py-0.5 text-xs font-semibold text-primary">${a.role}</span></td>
              <td class="px-3 py-3">${statusBadge}</td>
              <td class="px-3 py-3 text-xs text-slate-600">${permSummary(a.perms)}</td>
              <td class="px-4 py-3 text-right sm:px-5">
                <div class="flex flex-wrap justify-end gap-2">
                  <button type="button" class="action-edit rounded-lg bg-primary/10 px-2.5 py-1 text-xs font-medium text-primary hover:bg-primary/20" data-id="${a.id}">Modifier</button>
                  <button type="button" class="action-perm rounded-lg border border-slate-200 bg-white px-2.5 py-1 text-xs font-medium text-slate-700 hover:bg-slate-50" data-id="${a.id}">Permissions</button>
                  ${toggleBtn}
                  <button type="button" class="action-delete rounded-lg border border-rose-200 bg-white px-2.5 py-1 text-xs font-medium text-rose-600 hover:bg-rose-50" data-id="${a.id}">Supprimer</button>
                </div>
              </td>
            </tr>
          `;
        }).join("");
      }

      // Mise à jour de l'aperçu avatar
      function updateAvatarPreview() {
        var nameInput = document.getElementById('full_name');
        var fileInput = document.getElementById('photo_file');
        var urlInput = document.getElementById('photo_url');
        var previewImg = document.getElementById('avatar-img');
        var previewInitials = document.getElementById('avatar-initials');
        var photoData = document.getElementById('photo_data');

        // Priorité au fichier local
        if (fileInput.files && fileInput.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewImg.classList.remove('hidden');
            previewInitials.classList.add('hidden');
            photoData.value = e.target.result; // stocker en base64
          };
          reader.readAsDataURL(fileInput.files[0]);
        } else if (urlInput.value.trim() !== '') {
          previewImg.src = urlInput.value.trim();
          previewImg.classList.remove('hidden');
          previewInitials.classList.add('hidden');
          photoData.value = ''; // on utilisera l'URL
        } else {
          previewImg.classList.add('hidden');
          previewInitials.classList.remove('hidden');
          var name = nameInput.value.trim();
          previewInitials.textContent = name ? initials(name) : '?';
          photoData.value = '';
        }
      }

      var modalOverlay = document.getElementById("modal-overlay");
      var modalPanel = document.getElementById("modal-panel");
      var deleteOverlay = document.getElementById("delete-overlay");
      var deletePanel = document.getElementById("delete-panel");
      var form = document.getElementById("agent-form");
      var deleteTargetId = null;

      function openModal() {
        modalOverlay.classList.add("is-open");
        modalOverlay.setAttribute("aria-hidden", "false");
        document.body.style.overflow = "hidden";
        requestAnimationFrame(() => modalPanel.classList.add("is-open"));
      }
      function closeModal() {
        modalPanel.classList.remove("is-open");
        modalOverlay.classList.remove("is-open");
        modalOverlay.setAttribute("aria-hidden", "true");
        document.body.style.overflow = "";
      }
      function openDeleteModal(id, name) {
        deleteTargetId = id;
        document.getElementById("delete-message").textContent = `L’agent « ${name} » sera définitivement retiré.`;
        deleteOverlay.classList.add("is-open");
        deleteOverlay.setAttribute("aria-hidden", "false");
        requestAnimationFrame(() => deletePanel.classList.add("is-open"));
      }
      function closeDeleteModal() {
        deletePanel.classList.remove("is-open");
        deleteOverlay.classList.remove("is-open");
        deleteOverlay.setAttribute("aria-hidden", "true");
        deleteTargetId = null;
      }

      function resetForm() {
        form.reset();
        document.getElementById("field_agent_id").value = "";
        document.getElementById("field_form_action").value = "create_agent";
        document.getElementById("modal-title").textContent = "Nouvel agent";
        document.getElementById("password").required = true;
        document.getElementById("pwd-optional-hint").classList.add("hidden");
        document.getElementById("role").value = "Administrateur";
        document.getElementById("photo_file").value = "";
        document.getElementById("photo_url").value = "";
        document.getElementById("photo_data").value = "";
        permKeys.forEach(k => { var el = form.querySelector('[name="' + k + '"]'); if (el) el.checked = false; });
        clearFieldErrors();
        document.getElementById("form-submit-err").classList.add("hidden");
        document.getElementById('avatar-img').classList.add('hidden');
        document.getElementById('avatar-initials').classList.remove('hidden');
        document.getElementById('avatar-initials').textContent = '?';
      }

      function clearFieldErrors() {
        ["full_name", "email", "password"].forEach(id => {
          var e = document.getElementById("err_" + id);
          if (e) { e.textContent = ""; e.classList.add("hidden"); }
        });
      }

      function loadAgentIntoForm(a) {
        document.getElementById("field_agent_id").value = a.id;
        document.getElementById("field_form_action").value = "update_agent";
        document.getElementById("modal-title").textContent = "Modifier l’agent";
        document.getElementById("full_name").value = a.name;
        document.getElementById("email").value = a.email;
        document.getElementById("password").value = "";
        document.getElementById("password").required = false;
        document.getElementById("pwd-optional-hint").classList.remove("hidden");
        document.getElementById("role").value = a.role || "Administrateur";
        document.getElementById("photo_file").value = "";
        document.getElementById("photo_url").value = a.photo || "";
        document.getElementById("photo_data").value = "";
        form.querySelector('input[name="status"][value="' + (a.active ? "active" : "inactive") + '"]').checked = true;
        permKeys.forEach(k => {
          var el = form.querySelector('[name="' + k + '"]');
          if (!el) return;
          var pk = k.replace(/^perm_/, "");
          el.checked = !!(a.perms && a.perms[pk]);
        });
        clearFieldErrors();
        document.getElementById("form-submit-err").classList.add("hidden");
        updateAvatarPreview();
      }

      function findAgent(id) {
        return agents.find(a => a.id === id);
      }

      // Événements pour l'aperçu
      document.getElementById('full_name').addEventListener('input', updateAvatarPreview);
      document.getElementById('photo_file').addEventListener('change', function() {
        document.getElementById('photo_url').value = ''; // vider l'URL si fichier choisi
        updateAvatarPreview();
      });
      document.getElementById('photo_url').addEventListener('input', function() {
        document.getElementById('photo_file').value = ''; // vider le fichier si URL saisie
        updateAvatarPreview();
      });

      document.getElementById("btn-open-create").addEventListener("click", () => { resetForm(); openModal(); });
      document.getElementById("modal-close").addEventListener("click", closeModal);
      document.getElementById("btn-cancel-modal").addEventListener("click", closeModal);
      modalOverlay.addEventListener("click", e => { if (e.target === modalOverlay) closeModal(); });

      var searchInput = document.getElementById('search-input');
      searchInput.addEventListener('input', e => renderTable(filterAgents(e.target.value)));

      document.getElementById("agents-tbody").addEventListener("click", e => {
        var editBtn = e.target.closest(".action-edit");
        var permBtn = e.target.closest(".action-perm");
        var toggleBtn = e.target.closest(".action-toggle");
        var delBtn = e.target.closest(".action-delete");

        if (editBtn) {
          var a = findAgent(editBtn.getAttribute("data-id"));
          if (a) { loadAgentIntoForm(a); openModal(); }
        }
        if (permBtn) {
          var b = findAgent(permBtn.getAttribute("data-id"));
          if (b) { loadAgentIntoForm(b); openModal(); document.getElementById("perm-section").scrollIntoView({ behavior: "smooth", block: "start" }); }
        }
        if (toggleBtn) {
          var c = findAgent(toggleBtn.getAttribute("data-id"));
          if (!c) return;
          // Simulation toggle
          c.active = !c.active;
          allAgents = agents;
          renderTable(filterAgents(searchInput.value));
          toast(`Agent ${c.active ? 'activé' : 'désactivé'}.`);
        }
        if (delBtn) {
          var d = findAgent(delBtn.getAttribute("data-id"));
          if (d) openDeleteModal(d.id, d.name);
        }
      });

      document.querySelectorAll(".select-group-btn").forEach(btn => {
        btn.addEventListener("click", () => {
          var group = btn.closest(".perm-group");
          if (!group) return;
          var boxes = group.querySelectorAll('input[type="checkbox"]');
          var allChecked = Array.from(boxes).every(b => b.checked);
          boxes.forEach(b => b.checked = !allChecked);
        });
      });

      function genPassword() {
        var chars = "abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789";
        var out = "";
        for (var i = 0; i < 14; i++) out += chars.charAt(Math.floor(Math.random() * chars.length));
        return out + "@1a";
      }
      document.getElementById("btn-gen-pwd").addEventListener("click", () => document.getElementById("password").value = genPassword());
      document.getElementById("btn-copy-pwd").addEventListener("click", () => {
        var p = document.getElementById("password").value;
        if (!p) return;
        navigator.clipboard?.writeText(p).then(() => toast("Mot de passe copié."));
      });

      function toast(msg) {
        var t = document.getElementById("page-toast");
        t.textContent = msg;
        t.classList.remove("hidden");
        clearTimeout(t._h);
        t._h = setTimeout(() => t.classList.add("hidden"), 2400);
      }

      function validateForm() {
        clearFieldErrors();
        var ok = true;
        var name = document.getElementById("full_name").value.trim();
        var em = document.getElementById("email").value.trim();
        var pw = document.getElementById("password").value;
        var edit = document.getElementById("field_agent_id").value !== "";
        if (!name) { document.getElementById("err_full_name").textContent = "Champ obligatoire."; document.getElementById("err_full_name").classList.remove("hidden"); ok = false; }
        if (!em || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(em)) { document.getElementById("err_email").textContent = "Email invalide."; document.getElementById("err_email").classList.remove("hidden"); ok = false; }
        if (!edit && !pw) { document.getElementById("err_password").textContent = "Mot de passe obligatoire."; document.getElementById("err_password").classList.remove("hidden"); ok = false; }
        return ok;
      }

      form.addEventListener("submit", ev => {
        ev.preventDefault();
        if (!validateForm()) return;
        var btn = document.getElementById("btn-save-agent");
        btn.disabled = true;
        var fd = new FormData(form);
        permKeys.forEach(k => { if (!form.querySelector('[name="' + k + '"]').checked) fd.append(k, "0"); });

        var photoData = document.getElementById("photo_data").value;
        var photoUrl = document.getElementById("photo_url").value.trim();
        var finalPhoto = photoData || photoUrl || null;

        // Simulation d'enregistrement local
        var agentId = document.getElementById("field_agent_id").value;
        var isEdit = agentId !== "";
        var newAgent = {
          id: isEdit ? agentId : (Math.max(...agents.map(a => parseInt(a.id)), 0) + 1).toString(),
          name: document.getElementById("full_name").value.trim(),
          email: document.getElementById("email").value.trim(),
          role: document.getElementById("role").value,
          active: form.querySelector('input[name="status"]:checked').value === "active",
          photo: finalPhoto,
          perms: {}
        };
        permKeys.forEach(k => {
          var pk = k.replace(/^perm_/, "");
          newAgent.perms[pk] = form.querySelector('[name="' + k + '"]').checked ? 1 : 0;
        });

        if (isEdit) {
          var idx = agents.findIndex(a => a.id === agentId);
          if (idx !== -1) agents[idx] = newAgent;
        } else {
          agents.push(newAgent);
        }
        allAgents = agents;
        renderTable(filterAgents(searchInput.value));
        closeModal();
        toast(isEdit ? "Agent modifié." : "Agent créé.");
        btn.disabled = false;
      });

      document.getElementById("delete-cancel").addEventListener("click", closeDeleteModal);
      deleteOverlay.addEventListener("click", e => { if (e.target === deleteOverlay) closeDeleteModal(); });
      document.getElementById("delete-confirm").addEventListener("click", () => {
        if (!deleteTargetId) return;
        agents = agents.filter(a => a.id !== deleteTargetId);
        allAgents = agents;
        renderTable(filterAgents(searchInput.value));
        closeDeleteModal();
        toast("Agent supprimé.");
      });

      // Sidebar toggles & mobile
      document.querySelectorAll(".sidebar-toggle").forEach(btn => {
        var id = btn.getAttribute("data-submenu");
        var panel = document.getElementById(id);
        var chev = btn.querySelector(".chevron");
        btn.addEventListener("click", () => {
          var open = panel.classList.toggle("open");
          btn.setAttribute("aria-expanded", open);
          if (chev) chev.style.transform = open ? "rotate(180deg)" : "";
        });
      });
      var sidebar = document.getElementById("sidebar");
      var sbOverlay = document.getElementById("sidebar-overlay");
      document.getElementById("btn-menu").addEventListener("click", () => {
        sidebar.classList.remove("-translate-x-full");
        sbOverlay.classList.add("is-open");
        document.body.style.overflow = "hidden";
      });
      sbOverlay.addEventListener("click", () => {
        sidebar.classList.add("-translate-x-full");
        sbOverlay.classList.remove("is-open");
        document.body.style.overflow = "";
      });
      window.addEventListener("resize", () => {
        if (window.innerWidth >= 1024) {
          sidebar.classList.remove("-translate-x-full");
          sbOverlay.classList.remove("is-open");
          document.body.style.overflow = "";
        }
      });

      allAgents = agents;
      renderTable();
    })();
  </script>
</body>
</html>
