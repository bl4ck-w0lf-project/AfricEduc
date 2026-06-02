<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <title>Configuration | AfricEduc Collège</title>
  <meta name="description" content="Assistant de configuration initiale de votre collège sur AfricEduc.">

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: "#7300e9",
            primaryDark: "#5c00bd",
            accent: "#99fbe3",
            danger: "#ef4444",
            warning: "#f59e0b",
            success: "#10b981"
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
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: "Outfit", sans-serif;
      overflow-x: hidden;
    }
    
    h1, h2, h3, .font-heading {
      font-family: "Quicksand", sans-serif;
    }
    /* Sous-menus */
    .submenu {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.35s ease;
    }
    .submenu.open {
      max-height: 320px;
    }
    
    /* Step panels */
    .step-panel {
      display: none;
      opacity: 0;
      transform: translateY(12px);
      transition: opacity 0.35s ease, transform 0.35s ease;
    }
    .step-panel.is-active {
      display: block;
      opacity: 1;
      transform: translateY(0);
    }
    
    /* Progress bar */
    .progress-fill {
      transition: width 0.45s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Toast notification */
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
    .toast.show {
      opacity: 1;
    }
    
    /* Scrollbar personnalisée */
    ::-webkit-scrollbar {
      width: 6px;
    }
    ::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
    }
    ::-webkit-scrollbar-thumb {
      background: #7300e9;
      border-radius: 10px;
    }
    
    /* Layout principal - CORRIGÉ */
    .app-container {
      display: flex;
      min-height: 100vh;
      width: 100%;
    }
    
    
    /* Contenu principal - poussé à droite */
    .main-content {
      flex: 1;
      min-height: 100vh;
      width: 100%;
      margin-left: 0;
      transition: margin-left 0.3s ease;
      display: flex;
      flex-direction: column;
    }
    
    /* Sur desktop, la sidebar est visible */
    @media (min-width: 1024px) {
      
      .main-content {
        margin-left: 260px;
        width: calc(100% - 280px);
      }
    }
    
    
    /* Header fixe */
    .app-header {
      position: sticky;
      top: 0;
      z-index: 30;
      background-color: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(12px);
      border-bottom: 1px solid #e2e8f0;
    }
  </style>
</head>
<body>

<div class="app-container">
  <!-- Overlay sidebar mobile -->

  <!-- Sidebar -->
   <?php include __DIR__ . '/../components/sidebar.php'; ?>

  <!-- Main content -->
  <div class="main-content">
    <!-- Header -->
    <header class="app-header">
      <div class="flex h-16 items-center justify-between gap-4 px-4 sm:px-6">
        <div class="flex items-center gap-3 ml-14 lg:ml-0">
          
          <div>
            <p class="font-heading text-sm font-semibold text-primary sm:text-base" id="school-name-header"><?= htmlspecialchars($_SESSION['school_name'] ?? 'École inconnue') ?> </p>
            <p class="text-xs text-slate-500" id="school-location"><?= htmlspecialchars($_SESSION['school_address'] ?? 'École inconnue') ?> </p>
          </div>
        </div>
        <div class="flex items-center gap-3">
          <?php
        $currentYear = date("Y");
        $nextYear = $currentYear + 1;
        $schoolYear = $currentYear . "–" . $nextYear;
        ?>
          <span class="hidden rounded-full border border-accent/50 bg-accent/20 px-3 py-1 text-xs font-medium text-slate-800 sm:inline-flex" id="school-year">Année scolaire  <?= $schoolYear ?></span>
          <button class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-2 py-1.5 pr-3 shadow-sm hover:shadow-md transition">
            <?php
                $userName = $_SESSION['user_name'] ?? 'User';

                // on récupère les initiales
                $words = explode(' ', trim($userName));
                $initials = '';

                foreach ($words as $w) {
                    $initials .= strtoupper($w[0] ?? '');
                }

                // limite à 2 caractères max
                $initials = substr($initials, 0, 2);
            ?>
            <span id="header-avatar" class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-primary to-primaryDark text-sm font-bold text-white shadow-md"><?= $initials ?></span>
            <span class="hidden text-left text-sm sm:block">
              <span class="block font-medium text-slate-900"><?= htmlspecialchars($_SESSION['user_name']) ?></span>
              <span class="text-xs text-slate-500"><?= htmlspecialchars($_SESSION['user_role']) ?></span>
            </span>
          </button>
        </div>
      </div>
    </header>

    <!-- Main content area -->
    <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
      <!-- Assistant de configuration -->
      <div class="max-w-5xl mx-auto">
        <div class="mb-6">
          <h1 class="font-heading text-2xl font-bold text-slate-900 sm:text-3xl">Configuration initiale</h1>
          <p class="mt-1 text-sm text-slate-600">Paramétrez le système pédagogique de votre collège en quelques étapes.</p>
        </div>

        <!-- Progress bar -->
        <div class="mt-6">
          <div class="flex items-center justify-between gap-2 text-xs font-semibold text-slate-500 sm:text-sm" id="step-labels">
            <span class="step-label w-1/4 text-center text-primary cursor-pointer" data-step="1">1. Pédagogie</span>
            <span class="step-label w-1/4 text-center cursor-pointer" data-step="2">2. Devoirs</span>
            <span class="step-label w-1/4 text-center cursor-pointer" data-step="3">3. Conduite</span>
            <span class="step-label w-1/4 text-center cursor-pointer" data-step="4">4. Scolarité</span>
          </div>
          <div class="mt-3 h-2 overflow-hidden rounded-full bg-slate-200/80">
            <div id="progress-bar" class="progress-fill h-full rounded-full bg-primary" style="width: 25%;" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="4"></div>
          </div>
        </div>

        <!-- Formulaire -->
        <div class="mt-8 rounded-3xl border border-slate-200/80 bg-white p-6 shadow-xl shadow-violet-100/50 sm:p-10">
          <p id="step-banner" class="mb-6 text-center text-sm font-semibold text-primary">Étape 1/4 — Système pédagogique</p>

          <form method="POST" id="setup-form" novalidate action="../../controllers/SetupSchoolController.php">
            <!-- Étape 1 : Pédagogie -->
            <div class="step-panel is-active" data-step="1">
              <h2 class="font-heading text-xl font-bold text-slate-900 sm:text-2xl">Comment fonctionne votre établissement ?</h2>
              <p class="mt-2 text-sm text-slate-600">Choisissez comment les périodes scolaires sont découpées.</p>
              
              <div class="mt-8 grid gap-4 sm:grid-cols-2">
                <label class="group relative cursor-pointer">
                  <input type="radio" name="period_system" value="semestre" class="peer sr-only" checked>
                  <div class="rounded-2xl border-2 border-slate-200 bg-slate-50/50 p-5 transition peer-checked:border-primary peer-checked:bg-primary/[0.06] peer-checked:shadow-md hover:border-primary/40">
                    <div class="flex items-start gap-3">
                      <span class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                          <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h12v10H6a2 2 0 0 1-2-2V7Z" />
                        </svg>
                      </span>
                      <div>
                        <span class="font-heading font-bold text-slate-900">Semestre</span>
                        <p class="mt-1 text-sm text-slate-600">2 périodes par an (S1, S2)</p>
                      </div>
                    </div>
                  </div>
                </label>
                
                <label class="group relative cursor-pointer">
                  <input type="radio" name="period_system" value="trimestre" class="peer sr-only">
                  <div class="rounded-2xl border-2 border-slate-200 bg-slate-50/50 p-5 transition peer-checked:border-primary peer-checked:bg-primary/[0.06] peer-checked:shadow-md hover:border-primary/40">
                    <div class="flex items-start gap-3">
                      <span class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-accent/50 text-slate-800">
                        <svg class="h-5 w-5 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h10" />
                        </svg>
                      </span>
                      <div>
                        <span class="font-heading font-bold text-slate-900">Trimestre</span>
                        <p class="mt-1 text-sm text-slate-600">3 périodes par an (T1, T2, T3)</p>
                      </div>
                    </div>
                  </div>
                </label>
              </div>
              
              <div class="formula-box mt-8 rounded-2xl border border-violet-100 bg-violet-50/60 px-4 py-4 sm:px-5">
                <p class="text-xs font-semibold uppercase tracking-wide text-primary">Formule annuelle (aperçu)</p>
                <p id="formula-period" class="mt-2 font-mono text-sm text-slate-800 sm:text-base"></p>
              </div>
              <p class="field-error mt-2 hidden text-sm text-red-600" id="err-step1"></p>
            </div>

            <!-- Étape 2 : Devoirs -->
            <div class="step-panel" data-step="2">
              <h2 class="font-heading text-xl font-bold text-slate-900 sm:text-2xl">Quels types de devoirs utilisez-vous ?</h2>
              <p class="mt-2 text-sm text-slate-600">Cochez les types de devoirs que vous souhaitez suivre.</p>
              
              <div class="mt-8 space-y-4">
                <label class="flex cursor-pointer items-center justify-between gap-4 rounded-2xl border border-slate-200 px-4 py-3 transition hover:border-primary/30">
                  <span class="font-medium text-slate-900">Interrogations <span class="text-slate-500">(MI)</span></span>
                  <input type="checkbox" name="hw_mi" value="1" checked class="peer sr-only hom-toggle">
                  <span class="relative h-7 w-12 shrink-0 rounded-full bg-slate-200 transition peer-checked:bg-primary after:absolute after:left-1 after:top-1 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition peer-checked:after:translate-x-5"></span>
                </label>
                
                <label class="flex cursor-pointer items-center justify-between gap-4 rounded-2xl border border-slate-200 px-4 py-3 transition hover:border-primary/30">
                  <span class="font-medium text-slate-900">Devoir 1 <span class="text-slate-500">(D1)</span></span>
                  <input type="checkbox" name="hw_d1" value="1" checked class="peer sr-only hom-toggle">
                  <span class="relative h-7 w-12 shrink-0 rounded-full bg-slate-200 transition peer-checked:bg-primary after:absolute after:left-1 after:top-1 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition peer-checked:after:translate-x-5"></span>
                </label>
                
                <label class="flex cursor-pointer items-center justify-between gap-4 rounded-2xl border border-slate-200 px-4 py-3 transition hover:border-primary/30">
                  <span class="font-medium text-slate-900">Devoir 2 <span class="text-slate-500">(D2)</span></span>
                  <input type="checkbox" name="hw_d2" value="1" checked class="peer sr-only hom-toggle">
                  <span class="relative h-7 w-12 shrink-0 rounded-full bg-slate-200 transition peer-checked:bg-primary after:absolute after:left-1 after:top-1 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition peer-checked:after:translate-x-5"></span>
                </label>

                
                
                <label class="flex cursor-pointer items-center justify-between gap-4 rounded-2xl border border-slate-200 px-4 py-3 transition hover:border-primary/30">
                  <span class="font-medium text-slate-900">Devoir hebdomadaire <span class="text-slate-500">(DH)</span></span>
                  <input type="checkbox" name="hw_dh" value="1" class="peer sr-only hom-toggle">
                  <span class="relative h-7 w-12 shrink-0 rounded-full bg-slate-200 transition peer-checked:bg-primary after:absolute after:left-1 after:top-1 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition peer-checked:after:translate-x-5"></span>
                </label>
              </div>
              <p class="field-error mt-6 hidden text-sm text-red-600" id="err-step2"></p>
            </div>

            <!-- Étape 3 : Conduite -->
            <div class="step-panel" data-step="3">
              <h2 class="font-heading text-xl font-bold text-slate-900 sm:text-2xl">Conduite &amp; paramètres</h2>
              <p class="mt-2 text-sm text-slate-600">Définissez si vous souhaitez inclure une note de conduite.</p>
              
              <div class="mt-6 rounded-2xl border border-slate-200 p-4 sm:p-5">
                <label class="flex cursor-pointer items-center justify-between gap-4">
                  <span class="font-medium text-slate-900">Activer la note de conduite</span>
                  <input type="checkbox" name="conduct_enabled" value="1" id="conduct_enabled" class="peer sr-only">
                  <span class="relative h-7 w-12 shrink-0 cursor-pointer rounded-full bg-slate-200 transition peer-checked:bg-primary after:pointer-events-none after:absolute after:left-1 after:top-1 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition peer-checked:after:translate-x-5"></span>
                </label>
                
                <div id="conduct-fields" class="mt-4 hidden space-y-4 border-t border-slate-100 pt-4">
                  <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                      <label for="conduct_coeff" class="block text-sm font-medium text-slate-700">Coefficient conduite</label>
                      <input type="number" name="conduct_coefficient" id="conduct_coeff" step="0.1" min="0.1" value="1" class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
                    </div>
                    <div>
                      <label for="conduct_max" class="block text-sm font-medium text-slate-700">Note max. conduite</label>
                      <input type="number" name="conduct_max" id="conduct_max" min="1" max="20" value="20" class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="formula-box mt-6 rounded-2xl border border-violet-100 bg-violet-50/60 px-4 py-4">
                <p class="text-xs font-semibold uppercase text-primary">Formule annuelle (rappel)</p>
                <p id="formula-period-full" class="mt-2 font-mono text-sm text-slate-800"></p>
              </div>
              <p class="field-error mt-2 hidden text-sm text-red-600" id="err-step3"></p>
            </div>

            <!-- Étape 4 : Scolarité et confirmation -->
            <div class="step-panel" data-step="4">
              <h2 class="font-heading text-xl font-bold text-slate-900 sm:text-2xl">Scolarité &amp; confirmation</h2>
              <p class="mt-2 text-sm text-slate-600">Vérifiez le récapitulatif puis validez.</p>
              
              <div class="mt-6">
                <label class="block text-sm font-medium text-slate-700">Devise</label>
                <input type="text" name="currency" value="FCFA" readonly class="mt-1 w-full max-w-md cursor-not-allowed rounded-xl border border-slate-200 bg-slate-100 px-4 py-2.5 text-slate-600">
                <p class="mt-1 text-xs text-slate-500">Paramètre fixe pour l'instant.</p>
              </div>
              
              <div class="mt-8 rounded-2xl border border-slate-200 bg-slate-50/80 p-5 sm:p-6">
                <h3 class="font-heading text-sm font-bold uppercase tracking-wide text-slate-500">Récapitulatif</h3>
                <dl id="summary-dl" class="mt-4 space-y-3 text-sm"></dl>
              </div>
              <p id="submit-error" class="mt-4 hidden rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert"></p>
            </div>

            <!-- Boutons navigation -->
            <div class="mt-10 flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">
              <button type="button" id="btn-prev" class="rounded-xl border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40">Précédent</button>
              <div class="flex flex-col gap-3 sm:flex-row sm:gap-3">
                <button type="button" id="btn-next" class="rounded-xl bg-primary px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-primary/25 transition hover:bg-violet-800">Suivant</button>
                <button type="submit" id="btn-submit" class="hidden items-center justify-center gap-2 rounded-xl bg-primary px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-primary/25 transition hover:bg-violet-800 disabled:opacity-60">
                  <span id="btn-submit-label">Confirmer</span>
                  <svg id="btn-submit-spinner" class="hidden h-5 w-5 animate-spin text-white" viewBox="0 0 24 24" fill="none">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" class="opacity-25" />
                    <path fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4Z" class="opacity-90" />
                  </svg>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
      
      <footer class="mt-12 pb-8 text-center text-xs text-slate-400">
        AfricEduc — <?= htmlspecialchars($_SESSION['school_name'] ?? 'École inconnue') ?>  · <span id="last-update"></span>
      </footer>
    </main>
  </div>
</div>

<div id="toast" class="toast"></div>
<script>
(function () {

  let currentStep = 1;
  const totalSteps = 4;

  const prevBtn = document.getElementById('btn-prev');
  const nextBtn = document.getElementById('btn-next');
  const submitBtn = document.getElementById('btn-submit');
  const form = document.getElementById('setup-form');

  const conductEnabled = document.getElementById('conduct_enabled');
  const conductFields = document.getElementById('conduct-fields');

  // =========================
  // STEP CONTROL
  // =========================
  function showStep(step) {
    currentStep = step;

    document.querySelectorAll('.step-panel').forEach(p => {
      p.classList.toggle('is-active', parseInt(p.dataset.step) === step);
    });

    // boutons
    prevBtn.disabled = step === 1;

    nextBtn.classList.toggle('hidden', step === totalSteps);
    submitBtn.classList.toggle('hidden', step !== totalSteps);
    submitBtn.classList.toggle('flex', step === totalSteps);

    updateProgress();
    if (step === totalSteps) buildSummary();
  }

  function updateProgress() {
    const bar = document.getElementById('progress-bar');
    bar.style.width = (currentStep / totalSteps) * 100 + '%';
  }

  function updateFormulaPreview() {
  const period = document.querySelector('input[name="period_system"]:checked')?.value;

  const formula1 = document.getElementById('formula-period');
  const formula2 = document.getElementById('formula-period-full');

  if (!formula1 && !formula2) return;

  if (period === 'semestre') {
    const text = "MA = (MGS1 × 1 + MGS2 × 2) / 3";
    if (formula1) formula1.textContent = text;
    if (formula2) formula2.textContent = text;
  }

  if (period === 'trimestre') {
    const text = "MA = (T1 + T2 + T3) / 3";
    if (formula1) formula1.textContent = text;
    if (formula2) formula2.textContent = text;
  }
}

  // =========================
  // CONDUITE (FIX IMPORTANT)
  // =========================
  function toggleConduct() {
    if (!conductEnabled || !conductFields) return;

    const active = conductEnabled.checked;

    conductFields.classList.toggle('hidden', !active);

    // important: enable/disable inputs proprement
    conductFields.querySelectorAll('input').forEach(input => {
      input.disabled = !active;
    });

    buildSummary();
  }

  // =========================
  // RÉCAP (FIX COMPLET)
  // =========================
  function buildSummary() {

    const period = document.querySelector('input[name="period_system"]:checked')?.value || 'semestre';

    const hw = [];
    if (document.querySelector('[name="hw_mi"]').checked) hw.push('MI');
    if (document.querySelector('[name="hw_d1"]').checked) hw.push('D1');
    if (document.querySelector('[name="hw_d2"]').checked) hw.push('D2');
    if (document.querySelector('[name="hw_dh"]').checked) hw.push('DH');

    const conductOn = conductEnabled?.checked;

    const coeff = document.getElementById('conduct_coeff')?.value || 1;
    const max = document.getElementById('conduct_max')?.value || 20;

    const dl = document.getElementById('summary-dl');
    if (!dl) return;

    dl.innerHTML = `
      <div class="flex justify-between border-b pb-2">
        <dt>Système</dt><dd>${period}</dd>
      </div>

      <div class="flex justify-between border-b pb-2">
        <dt>Devoirs</dt><dd>${hw.length ? hw.join(', ') : 'Aucun'}</dd>
      </div>

      <div class="flex justify-between border-b pb-2">
        <dt>Conduite</dt>
        <dd>${conductOn ? `Oui (coef ${coeff}, max ${max})` : 'Non'}</dd>
      </div>

      <div class="flex justify-between">
        <dt>Devise</dt><dd>FCFA</dd>
      </div>
    `;
  }

  // =========================
  // VALIDATION SIMPLE (IMPORTANT POUR BTN SUIVANT)
  // =========================
  function validate(step) {

    if (step === 1) {
      return document.querySelector('input[name="period_system"]:checked') !== null;
    }

    if (step === 2) {
      return document.querySelectorAll('input[name^="hw_"]:checked').length > 0;
    }

    if (step === 3) {
      if (!conductEnabled.checked) return true;

      const c = parseFloat(document.getElementById('conduct_coeff').value);
      const m = parseFloat(document.getElementById('conduct_max').value);

      return c > 0 && m > 0;
    }

    return true;
  }

  // =========================
  // EVENTS (FIX DU BOUTON SUIVANT)
  // =========================
  nextBtn.addEventListener('click', () => {
    if (!validate(currentStep)) {
      alert("Complète l'étape avant de continuer");
      return;
    }

    if (currentStep < totalSteps) {
      showStep(currentStep + 1);
    }
  });

  prevBtn.addEventListener('click', () => {
    if (currentStep > 1) showStep(currentStep - 1);
  });

  // labels clickable
  document.querySelectorAll('.step-label').forEach(l => {
    l.addEventListener('click', () => {
      const step = parseInt(l.dataset.step);
      if (step < currentStep || validate(currentStep)) {
        showStep(step);
      }
    });
  });

  // conduite toggle
  conductEnabled?.addEventListener('change', toggleConduct);

  // live update
  document.querySelectorAll('input').forEach(i => {
    i.addEventListener('change', () => {
      if (currentStep === totalSteps) buildSummary();
    });
  });

  // init
  function init() {
    toggleConduct();
    showStep(1);
  }

  init();
  updateFormulaPreview();
  document.querySelectorAll('input[name="period_system"]').forEach(radio => {
  radio.addEventListener('change', updateFormulaPreview);
});

})();
</script>
</body>
</html>