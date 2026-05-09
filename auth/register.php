<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription établissement | AfricEduc</title>
  <meta name="description" content="Créez le compte administrateur de votre établissement sur AfricEduc.">

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
          },
          boxShadow: {
            glow: "0 20px 50px -20px rgba(115, 0, 233, 0.45)"
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
    h1, h2, h3 { font-family: "Quicksand", sans-serif; }

    @keyframes spin { to { transform: rotate(360deg); } }
    .spinner { animation: spin 0.7s linear infinite; }

    .aside-gradient {
      background:
        radial-gradient(circle at 20% 30%, rgba(153, 251, 227, 0.35), transparent 50%),
        radial-gradient(circle at 80% 70%, rgba(115, 0, 233, 0.2), transparent 45%),
        linear-gradient(160deg, #faf5ff 0%, #f0fffb 50%, #ffffff 100%);
    }

    input, button { transition: all 0.2s ease; }
    input:focus { transform: translateY(-1px); }

    .step-content { animation: fadeInStep 0.4s ease-out; }
    @keyframes fadeInStep {
      from { opacity: 0; transform: translateX(10px); }
      to   { opacity: 1; transform: translateX(0); }
    }

    .step-indicator { transition: all 0.3s ease; cursor: pointer; }
    .step-active    { background-color: #7300e9; color: white; border-color: #7300e9; transform: scale(1.05); box-shadow: 0 0 0 4px rgba(115,0,233,0.2); }
    .step-completed { background-color: #10b981; border-color: #10b981; color: white; box-shadow: 0 0 0 2px rgba(16,185,129,0.2); }
    .step-default   { background-color: white; border-color: #cbd5e1; color: #64748b; }

    .step-line          { transition: background-color 0.3s ease; height: 3px; }
    .step-line-completed { background-color: #10b981; }
    .step-line-active   { background-color: #7300e9; }
    .step-line-default  { background-color: #e2e8f0; }

    .card-hover { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .card-hover:hover { transform: translateY(-2px); box-shadow: 0 8px 25px -8px rgba(115,0,233,0.15); }

    .step-label          { transition: color 0.3s ease; }
    .step-label-active   { color: #7300e9; font-weight: 600; }
    .step-label-completed{ color: #10b981; font-weight: 500; }
    .step-label-default  { color: #94a3b8; }

    .password-toggle {
      position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
      cursor: pointer; color: #94a3b8; transition: color 0.2s ease;
      background: transparent; border: none; padding: 4px;
      display: flex; align-items: center; justify-content: center;
    }
    .password-toggle:hover { color: #7300e9; }
    .password-wrapper { position: relative; }
    .password-wrapper input { padding-right: 42px; }
  </style>
</head>
<body class="min-h-screen bg-slate-50 antialiased text-slate-800">
  <div class="min-h-screen lg:grid lg:grid-cols-2">

    <!-- Colonne gauche - Formulaire -->
    <div class="flex flex-col px-4 py-6 sm:px-8 lg:px-12 xl:px-16">
      <header class="mb-4">
        <a href="index.html" class="inline-flex items-center gap-3 group">
          <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-primary/10 text-primary transition-all duration-300 group-hover:rotate-6 group-hover:bg-primary/20">
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10 text-primary transition-all duration-300 group-hover:rotate-6">
              <svg width="30px" height="30px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="none" stroke="#9600ec" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path d="m14.25 9.25v-3.25l-6.25-3.25-6.25 3.25 6.25 3.25 3.25-1.5v3.5c0 1-1.5 2-3.25 2s-3.25-1-3.25-2v-3.5"></path></svg>
            </span>
          </span>
          <span class="text-xl font-bold text-slate-900 transition-all duration-300 group-hover:text-primary">Afric<span class="text-primary">Educ</span></span>
        </a>
      </header>

      <main class="mx-auto w-full max-w-xl flex-1 pb-12">

        <div class="mb-6">
          <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl tracking-tight">Créer votre espace <span class="text-primary">AfricEduc</span></h1>
          <p class="mt-2 text-slate-500 text-sm">Remplissez le formulaire en 3 étapes. Un email de confirmation vous sera envoyé.</p>
        </div>

        <!-- STEP INDICATOR -->
        <div class="mb-8">
          <div class="flex items-center justify-between">
            <div class="flex flex-col items-center flex-1">
              <div id="step1-indicator" class="step-indicator w-10 h-10 rounded-full bg-white border-2 border-slate-300 flex items-center justify-center font-semibold text-slate-600">1</div>
              <span id="step1-label" class="text-xs mt-2 font-medium text-slate-500 step-label">Établissement</span>
            </div>
            <div class="flex-1 h-0.5 mx-2 step-line" id="line1"></div>
            <div class="flex flex-col items-center flex-1">
              <div id="step2-indicator" class="step-indicator w-10 h-10 rounded-full bg-white border-2 border-slate-300 flex items-center justify-center font-semibold text-slate-600">2</div>
              <span id="step2-label" class="text-xs mt-2 font-medium text-slate-500 step-label">Administrateur</span>
            </div>
            <div class="flex-1 h-0.5 mx-2 step-line" id="line2"></div>
            <div class="flex flex-col items-center flex-1">
              <div id="step3-indicator" class="step-indicator w-10 h-10 rounded-full bg-white border-2 border-slate-300 flex items-center justify-center font-semibold text-slate-600">3</div>
              <span id="step3-label" class="text-xs mt-2 font-medium text-slate-500 step-label">Validation</span>
            </div>
          </div>
        </div>

        <form id="register-form" method="POST" action="../app/controllers/RegisterController.php">
          <input type="hidden" name="school_type" id="school_type" value="college">

          <!-- STEP 1 -->
          <div id="step1" class="step-content">
            <section class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 card-hover">
              <h2 class="flex items-center gap-3 text-lg font-semibold text-slate-900 border-b border-slate-100 pb-4 mb-5">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-primary/10 text-primary">
                  <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5V8.25L12 4l8 4.25V19.5" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19.5V12h6v7.5" />
                  </svg>
                </span>
                Informations de l'établissement
              </h2>
              <div class="space-y-5">
                <div>
                  <label for="school_name" class="block text-sm font-semibold text-slate-700 mb-1">Nom de l'établissement <span class="text-red-500">*</span></label>
                  <input type="text" id="school_name" name="school_name" autocomplete="organization" placeholder="Ex: Collège Saint-Michel de Cotonou"
                    class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 outline-none transition-all focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20">
                    <p id="error_school_name" class="hidden text-xs text-red-500 mt-1"></p>
                </div>
                <div>
                  <span class="block text-sm font-semibold text-slate-700 mb-1">Type d'établissement</span>
                  <div class="flex items-center gap-2 mt-1 rounded-xl bg-slate-50/80 px-5 py-3 border border-slate-200">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#7300e9" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                    <span id="type-display" class="font-medium">Collège/Lycée</span>
                  </div>
                </div>
                <fieldset class="rounded-xl border border-slate-200 bg-slate-50/30 p-5">
                  <legend class="text-sm font-semibold text-slate-700 px-1">Sous-type <span class="text-red-500">*</span></legend>
                  <div class="mt-3 flex flex-wrap gap-6">
                    <label class="flex cursor-pointer items-center gap-2.5 py-1.5 px-3 rounded-lg hover:bg-slate-100 transition">
                      <input type="radio" name="school_subtype" value="public" class="h-4 w-4 border-slate-300 text-primary focus:ring-primary">
                      <span> Public</span>
                    </label>
                    <label class="flex cursor-pointer items-center gap-2.5 py-1.5 px-3 rounded-lg hover:bg-slate-100 transition">
                      <input type="radio" name="school_subtype" value="prive" class="h-4 w-4 border-slate-300 text-primary focus:ring-primary">
                      <span> Privé</span>
                    </label>
                  </div>
                </fieldset>
                <div class="grid gap-5 sm:grid-cols-2">
                  <div>
                    <label for="school_email" class="block text-sm font-semibold text-slate-700 mb-1">Email de l'établissement <span class="text-red-500">*</span></label>
                    <input type="email" id="school_email" name="school_email" autocomplete="email" placeholder="contact@gmail.com"
                      class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 outline-none transition-all focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20">
                      <p id="error_school_email" class="hidden text-xs text-red-500 mt-1"></p>
                  </div>
                  <div>
                    <label for="school_phone" class="block text-sm font-semibold text-slate-700 mb-1">Téléphone</label>
                    <input type="tel" id="school_phone" name="school_phone" autocomplete="tel" placeholder="+229 01 XX XX XX XX"
                      class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 outline-none transition-all focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20">
                      <p id="error_school_phone" class="hidden text-xs text-red-500 mt-1"></p>
                  </div>
                </div>
                <div>
                  <label for="school_address" class="block text-sm font-semibold text-slate-700 mb-1">Adresse</label>
                  <input type="text" id="school_address" name="school_address" autocomplete="street-address" placeholder="Cotonou, Bénin"
                    class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 outline-none transition-all focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20">
                    <p id="error_school_address" class="hidden text-xs text-red-500 mt-1"></p>
                </div>
              </div>
            </section>
          </div>

          <!-- STEP 2 -->
          <div id="step2" class="step-content hidden">
            <section class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 card-hover">
              <h2 class="flex items-center gap-3 text-lg font-semibold text-slate-900 border-b border-slate-100 pb-4 mb-5">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-primary/10 text-primary">
                  <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 20a8 8 0 0 1 16 0" />
                  </svg>
                </span>
                Compte administrateur
              </h2>
              <div class="space-y-5">
                <div>
                  <label for="admin_full_name" class="block text-sm font-semibold text-slate-700 mb-1">Nom complet <span class="text-red-500">*</span></label>
                  <input type="text" id="admin_full_name" name="admin_full_name" autocomplete="name" placeholder="Jean Dupont"
                    class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 outline-none transition-all focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20">
                    <p id="error_admin_full_name" class="hidden text-xs text-red-500 mt-1"></p>
                    
                </div>
                <div>
                  <label for="admin_email" class="block text-sm font-semibold text-slate-700 mb-1">Email de connexion <span class="text-red-500">*</span></label>
                  <input type="email" id="admin_email" name="admin_email" autocomplete="username" placeholder="admin@ecole.edu"
                    class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 outline-none transition-all focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20">
                  <p id="error_admin_email" class="hidden text-xs text-red-500 mt-1"></p>
                  </div>
                <div class="grid gap-5 sm:grid-cols-2">
                  <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-1">Mot de passe <span class="text-red-500">*</span></label>
                    <div class="password-wrapper">
                      <input type="password" id="password" name="password" autocomplete="new-password" placeholder="••••••••"
                        class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 outline-none transition-all focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20">
                        <p id="error_password" class="hidden text-xs text-red-500 mt-1"></p>
                      <button type="button" class="password-toggle" data-target="password">
                        <svg class="eye-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                          <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                      </button>
                    </div>
                    <p class="text-xs text-slate-400 mt-1.5">Minimum 8 caractères</p>
                  </div>
                  <div>
                    <label for="password_confirm" class="block text-sm font-semibold text-slate-700 mb-1">Confirmer <span class="text-red-500">*</span></label>
                    <div class="password-wrapper">
                      <input type="password" id="password_confirm" name="password_confirm" autocomplete="new-password" placeholder="••••••••"
                        class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 outline-none transition-all focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20">
                        <p id="error_password_confirm" class="hidden text-xs text-red-500 mt-1"></p>
                      <button type="button" class="password-toggle" data-target="password_confirm">
                        <svg class="eye-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                          <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          </div>

          <!-- STEP 3 -->
          <div id="step3" class="step-content hidden">
            <section class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
              <h2 class="flex items-center gap-3 text-lg font-semibold text-slate-900 border-b border-slate-100 pb-4 mb-5">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-primary/10 text-primary">
                  <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20 6 9 17 4 12" />
                  </svg>
                </span>
                Validation et engagement
              </h2>
              <div class="space-y-5">
                <div class="bg-slate-50 rounded-xl p-4">
                  <p class="text-sm font-semibold text-slate-700 mb-2">Récapitulatif</p>
                  <div class="space-y-1 text-sm text-slate-600" id="recap-container"></div>
                </div>
                <div class="rounded-xl border border-slate-200 bg-slate-50/30 p-5">
                  <label class="flex cursor-pointer items-start gap-3">
                    <input type="checkbox" id="accept_terms" name="accept_terms" value="1"
                      class="mt-0.5 h-4 w-4 rounded border-slate-300 text-primary focus:ring-primary">
                    <span class="text-sm text-slate-700">J'accepte les <a href="#" class="font-semibold text-primary underline">conditions d'utilisation</a></span>
                  </label>
                </div>
                <p id="form-global-error" class="hidden rounded-xl border border-red-200 bg-red-50 px-5 py-3 text-sm text-red-800 shadow-sm" role="alert"></p>
              </div>
            </section>
          </div>

          <!-- Navigation -->
          <div class="flex justify-between gap-4 mt-6">
            <button type="button" id="prev-btn" class="hidden px-6 py-3 rounded-xl border border-slate-300 text-slate-700 font-medium hover:bg-slate-50 transition-all">
              ← Précédent
            </button>
            <button type="button" id="next-btn" class="px-6 py-3 rounded-xl bg-primary text-white font-medium hover:bg-violet-800 transition-all shadow-md ml-auto">
              Suivant →
            </button>
            <button type="submit" id="submit-btn" class="hidden px-6 py-3 rounded-xl bg-primary text-white font-medium hover:bg-violet-800 transition-all shadow-md">
              <span id="btn-label">Créer mon compte</span>
              <svg id="btn-spinner" class="hidden h-5 w-5 spinner inline-block ml-2" viewBox="0 0 24 24" fill="none">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" class="opacity-25" />
                <path fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4Z" class="opacity-90" />
              </svg>
            </button>
          </div>
          <div id="globalError" class="hidden ...">
            <p id="globalErrorMsg"></p>
          </div>
        </form>

        <div class="mt-3 text-center">
          <p class="text-sm text-slate-500">
            Déjà inscrit ?
            <a href="login.php" class="font-semibold text-primary hover:text-violet-800 hover:underline transition">Se connecter</a>
          </p>
        </div>

      </main>
    </div>

    <!-- Colonne droite -->
    <aside class="aside-gradient relative hidden min-h-[280px] flex-col justify-between border-t border-violet-100 p-8 lg:flex lg:min-h-screen lg:border-l lg:border-t-0">
      <div class="absolute inset-0 overflow-hidden" aria-hidden="true">
        <svg class="absolute -right-16 top-20 h-96 w-96 text-primary/10" viewBox="0 0 200 200" fill="none">
          <circle cx="100" cy="100" r="80" stroke="currentColor" stroke-width="0.5" />
          <circle cx="100" cy="100" r="55" stroke="currentColor" stroke-width="0.5" />
          <circle cx="100" cy="100" r="30" stroke="currentColor" stroke-width="0.5" />
        </svg>
      </div>
      <div class="relative z-10 max-w-md">
        <p class="text-2xl font-bold leading-snug text-slate-900">Une inscription simple, une gestion scolaire <span class="text-primary">plus sereine</span>.</p>
        <p class="mt-4 text-slate-600 leading-relaxed">Multi-tenant, sécurisé et pensé pour les collèges du Bénin et d'Afrique de l'Ouest.</p>
        <div class="mt-8 space-y-3">
          <div class="flex items-center gap-3 text-sm text-slate-700"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#7300e9"><polyline points="20 6 9 17 4 12"/></svg><span>Gestion complète des élèves et notes</span></div>
          <div class="flex items-center gap-3 text-sm text-slate-700"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#7300e9"><polyline points="20 6 9 17 4 12"/></svg><span>Paiements et suivi financier intégré</span></div>
          <div class="flex items-center gap-3 text-sm text-slate-700"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#7300e9"><polyline points="20 6 9 17 4 12"/></svg><span>Génération automatique de bulletins PDF</span></div>
        </div>
      </div>
    </aside>
  </div>

  <script>
    /**
 * register.js — AfricEduc
 * Fusion complète : navigation par étapes + toggle mot de passe + soumission fetch.
 * IDs HTML de référence alignés avec le fichier register.html.
 */

'use strict';

// ─── Config ───────────────────────────────────────────────────────────────────

const CONFIG = {
  endpoint:    '../controllers/RegisterController.php',
  minPassword: 8,
  totalSteps:  3,
};

// ─── État centralisé ──────────────────────────────────────────────────────────

const state = {
  currentStep:   1,
  isSubmitting:  false,
};

// ─── Sélecteurs (résolus une seule fois) ─────────────────────────────────────

const $ = (id) => document.getElementById(id);

const els = {
  // Formulaire
  form:           $('register-form'),

  // Navigation
  prevBtn:        $('prev-btn'),
  nextBtn:        $('next-btn'),
  submitBtn:      $('submit-btn'),
  btnLabel:       $('btn-label'),
  btnSpinner:     $('btn-spinner'),

  // Récapitulatif (step 3)
  recapContainer: $('recap-container'),

  // Erreur globale
  globalError:    $('form-global-error'),

  // Champs utiles au récap
  schoolName:     $('school_name'),
  schoolEmail:    $('school_email'),
  adminName:      $('admin_full_name'),
  adminEmail:     $('admin_email'),
};

// ─── Init ─────────────────────────────────────────────────────────────────────

document.addEventListener('DOMContentLoaded', () => {
  if (!els.form) return;

  initStepNavigation();
  initPasswordToggles();
  initInlineClearErrors();

  els.form.addEventListener('submit', handleSubmit);
});

// ═══════════════════════════════════════════════════════════════════════════════
//  NAVIGATION PAR ÉTAPES
// ═══════════════════════════════════════════════════════════════════════════════

function initStepNavigation() {
  els.nextBtn?.addEventListener('click', () => {
    if (state.currentStep < CONFIG.totalSteps) {
      goToStep(state.currentStep + 1);
    }
  });

  els.prevBtn?.addEventListener('click', () => {
    if (state.currentStep > 1) {
      goToStep(state.currentStep - 1);
    }
  });

  // Afficher l'étape initiale
  goToStep(1);
}

function goToStep(step) {
  state.currentStep = step;
  renderStepPanels();
  renderStepIndicators();
  renderNavButtons();
  if (step === CONFIG.totalSteps) renderRecap();
}

/** Affiche le panneau de l'étape courante, masque les autres. */
function renderStepPanels() {
  for (let i = 1; i <= CONFIG.totalSteps; i++) {
    $('step' + i)?.classList.toggle('hidden', i !== state.currentStep);
  }
}

/** Met à jour les indicateurs visuels (cercles numérotés + lignes). */
function renderStepIndicators() {
  for (let i = 1; i <= CONFIG.totalSteps; i++) {
    const ind   = $('step' + i + '-indicator');
    const label = $('step' + i + '-label');
    if (!ind || !label) continue;

    ind.classList.remove('step-active', 'step-completed', 'step-default');
    label.classList.remove('step-label-active', 'step-label-completed', 'step-label-default');

    if (i === state.currentStep) {
      ind.classList.add('step-active');
      label.classList.add('step-label-active');
    } else if (i < state.currentStep) {
      ind.classList.add('step-completed');
      label.classList.add('step-label-completed');
      // Remplacer le chiffre par une coche pour les étapes complétées
      ind.textContent = '✓';
    } else {
      ind.classList.add('step-default');
      label.classList.add('step-label-default');
      ind.textContent = String(i);
    }
  }

  // Lignes entre les étapes
  const lineStates = {
    line1: state.currentStep > 1 ? 'step-line-completed' : 'step-line-default',
    line2: state.currentStep > 2 ? 'step-line-completed' : 'step-line-default',
  };
  Object.entries(lineStates).forEach(([id, cls]) => {
    const el = $(id);
    if (el) el.className = 'flex-1 mx-2 step-line ' + cls;
  });
}

/** Affiche/masque les boutons selon l'étape. */
function renderNavButtons() {
  const isFirst = state.currentStep === 1;
  const isLast  = state.currentStep === CONFIG.totalSteps;

  els.prevBtn?.classList.toggle('hidden', isFirst);
  els.nextBtn?.classList.toggle('hidden', isLast);
  els.submitBtn?.classList.toggle('hidden', !isLast);
}

// ═══════════════════════════════════════════════════════════════════════════════
//  RÉCAPITULATIF (étape 3)
// ═══════════════════════════════════════════════════════════════════════════════

function renderRecap() {
  if (!els.recapContainer) return;

  const subType  = getRadioValue('school_subtype');
  const typeText = 'Collège' + (subType ? ` (${subType === 'public' ? 'Public' : 'Privé'})` : '');

  const rows = [
    ['Établissement', els.schoolName?.value],
    ['Type',          typeText],
    ['Email école',   els.schoolEmail?.value],
    ['Admin',         els.adminName?.value],
    ['Email connexion', els.adminEmail?.value],
  ];

  els.recapContainer.innerHTML = rows
    .map(([label, value]) => `
      <div class="flex justify-between py-1">
        <span class="text-slate-500">${label} :</span>
        <span class="font-medium">${escapeHtml(value || 'Non renseigné')}</span>
      </div>`)
    .join('');
}

// ═══════════════════════════════════════════════════════════════════════════════
//  TOGGLE VISIBILITÉ MOT DE PASSE
// ═══════════════════════════════════════════════════════════════════════════════

function initPasswordToggles() {
  document.querySelectorAll('.password-toggle').forEach((button) => {
    button.addEventListener('click', () => {
      const targetId = button.getAttribute('data-target');
      const input    = $(targetId);
      if (!input) return;

      const isHidden = input.type === 'password';
      input.type = isHidden ? 'text' : 'password';

      // Mise à jour de l'icône SVG (œil ouvert / barré)
      const svg = button.querySelector('.eye-icon');
      if (svg) {
        svg.innerHTML = isHidden
          ? `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
             <path d="M3 3l18 18" stroke="currentColor" stroke-width="2"></path>
             <circle cx="12" cy="12" r="3"></circle>`
          : `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
             <circle cx="12" cy="12" r="3"></circle>`;
      }

      button.setAttribute('aria-label',
        isHidden ? 'Masquer le mot de passe' : 'Afficher le mot de passe'
      );
    });
  });
}

// ═══════════════════════════════════════════════════════════════════════════════
//  SOUMISSION FETCH
// ═══════════════════════════════════════════════════════════════════════════════

async function handleSubmit(e) {
  e.preventDefault();
  if (state.isSubmitting) return;

  clearAllErrors();

  // Validation côté client : champs obligatoires vides uniquement
  const clientErrors = validateRequiredFields(new FormData(els.form));
  if (Object.keys(clientErrors).length > 0) {
    displayFieldErrors(clientErrors);
    focusFirstError();
    return;
  }

  setSubmitting(true);

  try {
    const response = await fetch(CONFIG.endpoint, {
      method: 'POST',
      body:   new FormData(els.form),
    });

    const data = await response.json();

    if (data.success) {
      handleSuccess(data);
    } else {
      handleFailure(data);
    }

  } catch (err) {
    console.error('[Register] Fetch error:', err);
    showGlobalError('Une erreur réseau est survenue. Vérifiez votre connexion.');
  } finally {
    setSubmitting(false);
  }
}

function handleSuccess(data) {
  els.form.reset();
  if (data.redirect) {
    window.location.href = data.redirect;
  } else {
    showGlobalError(data.message ?? 'Inscription réussie !');
  }
}

function handleFailure(data) {
  if (data.errors && typeof data.errors === 'object') {
    // Remonter à la première étape contenant une erreur
    navigateToErrorStep(data.errors);
    displayFieldErrors(data.errors);
    focusFirstError();
  } else {
    showGlobalError(data.message ?? 'Une erreur est survenue.');
  }
}

// ═══════════════════════════════════════════════════════════════════════════════
//  VALIDATION CLIENT (champs vides uniquement — la logique métier reste au PHP)
// ═══════════════════════════════════════════════════════════════════════════════

const REQUIRED_FIELDS = [
  'school_name',
  'school_subtype',
  'school_email',
  'admin_full_name',
  'admin_email',
  'password',
  'password_confirm',
];

function validateRequiredFields(formData) {
  const errors = {};

  REQUIRED_FIELDS.forEach((field) => {
    if (!(formData.get(field) ?? '').trim()) {
      errors[field] = 'Ce champ est requis.';
    }
  });

  return errors;
}

// ═══════════════════════════════════════════════════════════════════════════════
//  GESTION DES ERREURS
// ═══════════════════════════════════════════════════════════════════════════════

/** Mapping champ → étape pour remonter automatiquement en cas d'erreur serveur. */
const FIELD_STEP_MAP = {
  school_name:      1,
  school_subtype:   1,
  school_sub:       1,
  school_email:     1,
  school_phone:     1,
  school_address:   1,
  admin_full_name:  2,
  admin_name:       2,
  admin_email:      2,
  password:         2,
  password_confirm: 2,
};

function navigateToErrorStep(errors) {
  const firstErrorField = Object.keys(errors)[0];
  const targetStep      = FIELD_STEP_MAP[firstErrorField] ?? 1;
  if (targetStep !== state.currentStep) {
    goToStep(targetStep);
  }
}

function displayFieldErrors(errors) {
  Object.entries(errors).forEach(([field, message]) => {
    const input   = els.form.querySelector(`[name="${field}"]`);
    const errorEl = $('error_' + field);

    input?.classList.add('border-red-500');
    input?.setAttribute('aria-invalid', 'true');

    if (errorEl) {
      errorEl.textContent = message;
      errorEl.classList.remove('hidden');
    }
  });
}

function clearFieldError(fieldName) {
  const input   = els.form.querySelector(`[name="${fieldName}"]`);
  const errorEl = $('error_' + fieldName);

  input?.classList.remove('border-red-500');
  input?.removeAttribute('aria-invalid');

  if (errorEl) {
    errorEl.textContent = '';
    errorEl.classList.add('hidden');
  }
}

function clearAllErrors() {
  els.form.querySelectorAll('[id^="error_"]').forEach((el) => {
    el.textContent = '';
    el.classList.add('hidden');
  });
  els.form.querySelectorAll('[aria-invalid]').forEach((el) => {
    el.removeAttribute('aria-invalid');
    el.classList.remove('border-red-500');
  });
  hideGlobalError();
}

/** Efface l'erreur d'un champ dès que l'utilisateur retape dedans. */
function initInlineClearErrors() {
  els.form.querySelectorAll('input, select, textarea').forEach((field) => {
    field.addEventListener('input', () => clearFieldError(field.name));
  });
}

function focusFirstError() {
  els.form.querySelector('[aria-invalid="true"]')?.focus();
}

// ─── Messages globaux ────────────────────────────────────────────────────────

function showGlobalError(message) {
  if (!els.globalError) return;
  els.globalError.textContent = message;
  els.globalError.classList.remove('hidden');
}

function hideGlobalError() {
  if (!els.globalError) return;
  els.globalError.textContent = '';
  els.globalError.classList.add('hidden');
}

// ─── État bouton submit ──────────────────────────────────────────────────────

function setSubmitting(active) {
  state.isSubmitting     = active;
  els.submitBtn.disabled = active;
  els.btnLabel?.classList.toggle('hidden', active);
  els.btnSpinner?.classList.toggle('hidden', !active);
}

// ═══════════════════════════════════════════════════════════════════════════════
//  UTILS
// ═══════════════════════════════════════════════════════════════════════════════

function getRadioValue(name) {
  return document.querySelector(`input[name="${name}"]:checked`)?.value ?? '';
}

function escapeHtml(str) {
  return String(str).replace(/[&<>]/g, (c) =>
    ({ '&': '&amp;', '<': '&lt;', '>': '&gt;' }[c])
  );
}
  </script>
</body>
</html>