<?php

session_start();

$errors = $_SESSION['errors'] ?? [];

$old = $_SESSION['old'] ?? [];

// IMPORTANT
unset($_SESSION['errors']);
unset($_SESSION['old']);

?>

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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

        <form id="register-form" method="POST" action="/AfricEduc/public/index.php?url=register">
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
                  <input type="text"
                        id="school_name"
                        name="school_name"
                        autocomplete="organization"
                        placeholder="Ex: Collège Saint-Michel de Cotonou"  
                        class="mt-1 w-full rounded-xl border <?= isset($errors['school_name']) ? 'border-red-500' : 'border-slate-200' ?> bg-slate-50/50 px-4 py-3 outline-none transition-all focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20"
                        value="<?= htmlspecialchars($old['school_name'] ?? '') ?>"
                         >
                    
                </div>
                <?php if (isset($errors['school_name'])): ?>
                  <p class="text-xs text-red-500 mt-1">
                    <?= htmlspecialchars($errors['school_name']) ?>
                  </p>
                <?php endif; ?>

                
                <div>
                  <span class="block text-sm font-semibold text-slate-700 mb-1">Type d'établissement</span>
                  <div class="flex items-center gap-2 mt-1 rounded-xl bg-slate-50/80 px-5 py-3 border border-slate-200">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#7300e9" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                    <span id="type-display" class="font-medium">Collège/Lycée</span>
                  </div>
                </div>
                <fieldset
                  name="school_subtype"
                  class="rounded-xl bg-slate-50/30 p-5 border
                    <?= isset($errors['school_subtype'])
                      ? 'border-red-500'
                      : 'border-slate-200'
                    ?>"
                >
                  <legend class="text-sm font-semibold text-slate-700 px-1">Sous-type <span class="text-red-500">*</span></legend>
                  <div class="mt-3 flex flex-wrap gap-6">
                    <label class="flex cursor-pointer items-center gap-2.5 py-1.5 px-3 rounded-lg hover:bg-slate-100 transition">
                      <input type="radio"
                              name="school_subtype"
                              value="public"
                              class="h-4 w-4 border-slate-300 text-primary focus:ring-primary"
                              <?= (($_SESSION['old']['school_subtype'] ?? '') === 'public') ? 'checked' : '' ?>
                        >
                      <span> Public</span>
                    </label>
                    <label class="flex cursor-pointer items-center gap-2.5 py-1.5 px-3 rounded-lg hover:bg-slate-100 transition">
                      <input type="radio"
                              name="school_subtype"
                              value="public"
                              class="h-4 w-4 border-slate-300 text-primary focus:ring-primary"
                              <?= (($_SESSION['old']['school_subtype'] ?? '') === 'prive') ? 'checked' : '' ?>
                      >
                      <span> Privé</span>
                      
                    </label>
                    
                  </div>
                </fieldset>
                <?php if (isset($errors['school_subtype'])): ?>
                  <p class="text-xs text-red-500 mt-1">
                    <?= htmlspecialchars($errors['school_subtype']) ?>
                  </p>
                <?php endif; ?>


                <div class="grid gap-5 sm:grid-cols-2">

                  <!-- EMAIL -->
                  <div>
                    <label for="school_email" class="block text-sm font-semibold text-slate-700 mb-1">
                      Email de l'établissement <span class="text-red-500">*</span>
                    </label>

                    <input type="email"
                      id="school_email"
                      name="school_email"
                      autocomplete="email"
                      placeholder="contact@gmail.com"
                      class="mt-1 w-full rounded-xl border <?= isset($errors['school_email']) ? 'border-red-500' : 'border-slate-200' ?> bg-slate-50/50 px-4 py-3 outline-none transition-all focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20"
                      value="<?= htmlspecialchars($old['school_email'] ?? '') ?>">

                    <?php if (isset($errors['school_email'])): ?>
                      <p class="text-xs text-red-500 mt-1">
                        <?= htmlspecialchars($errors['school_email']) ?>
                      </p>
                    <?php endif; ?>
                  </div>

                  <!-- PHONE -->
                  <div>
                    <label for="school_phone" class="block text-sm font-semibold text-slate-700 mb-1">
                      Téléphone
                    </label>

                    <input type="tel"
                      id="school_phone"
                      name="school_phone"
                      autocomplete="tel"
                      placeholder="+229 01 XX XX XX XX"
                      class="mt-1 w-full rounded-xl border <?= isset($errors['school_phone']) ? 'border-red-500' : 'border-slate-200' ?> bg-slate-50/50 px-4 py-3 outline-none transition-all focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20"
                      value="<?= htmlspecialchars($old['school_phone'] ?? '') ?>">

                    <?php if (isset($errors['school_phone'])): ?>
                      <p class="text-xs text-red-500 mt-1">
                        <?= htmlspecialchars($errors['school_phone']) ?>
                      </p>
                    <?php endif; ?>
                  </div>

                </div>
                <div>
                  <label for="school_address" class="block text-sm font-semibold text-slate-700 mb-1">Adresse</label>
                  <input type="text" id="school_address" name="school_address" autocomplete="street-address" placeholder="Cotonou, Bénin"
                    class="mt-1 w-full rounded-xl border <?= isset($errors['school_address']) ? 'border-red-500' : 'border-slate-200' ?> bg-slate-50/50 px-4 py-3 outline-none transition-all focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20"
                      value="<?= htmlspecialchars($old['school_address'] ?? '') ?>">
                </div>

                 <?php if (isset($errors['school_address'])): ?>
                    <p class="text-xs text-red-500 mt-1">
                      <?= htmlspecialchars($errors['school_address']) ?>
                    </p>
                  <?php endif; ?>
                  
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
                    class="mt-1 w-full rounded-xl border <?= isset($errors['admin_full_name']) ? 'border-red-500' : 'border-slate-200' ?> bg-slate-50/50 px-4 py-3 outline-none transition-all focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20"
                        value="<?= htmlspecialchars($old['admin_full_name'] ?? '') ?>">
                    
                </div>

                <?php if (isset($errors['admin_full_name'])): ?>
                  <p class="text-xs text-red-500 mt-1">
                    <?= htmlspecialchars($errors['admin_full_name']) ?>
                  </p>
                <?php endif; ?>

                <div>
                  <label for="admin_email" class="block text-sm font-semibold text-slate-700 mb-1">Email de connexion <span class="text-red-500">*</span></label>
                  <input type="email" id="admin_email" name="admin_email" autocomplete="username" placeholder="admin@ecole.edu"
                        class="mt-1 w-full rounded-xl border <?= isset($errors['admin_email']) ? 'border-red-500' : 'border-slate-200' ?> bg-slate-50/50 px-4 py-3 outline-none transition-all focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20"
                        value="<?= htmlspecialchars($old['admin_email'] ?? '') ?>">
                  </div>

                  <?php if (isset($errors['admin_email'])): ?>
                  <p class="text-xs text-red-500 mt-1">
                    <?= htmlspecialchars($errors['admin_email']) ?>
                  </p>
                <?php endif; ?>

                <div class="grid gap-5 sm:grid-cols-2">
                  <div>
                      <label for="password" class="block text-sm font-semibold text-slate-700 mb-1">
                        Mot de passe <span class="text-red-500">*</span>
                      </label>

                      <div class="password-wrapper">
                        <input type="password"
                          id="password"
                          name="password"
                          autocomplete="new-password"
                          placeholder="••••••••"
                          class="mt-1 w-full rounded-xl border 
                            <?= isset($errors['password']) ? 'border-red-500' : 'border-slate-200' ?>
                            bg-slate-50/50 px-4 py-3 outline-none transition-all
                            focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20"
                        >

                        <button type="button" class="password-toggle" data-target="password">
                          <svg class="eye-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                          </svg>
                        </button>
                      </div>

                      <?php if (isset($errors['password'])): ?>
                        <p class="text-xs text-red-500 mt-1">
                          <?= htmlspecialchars($errors['password']) ?>
                        </p>
                      <?php endif; ?>

                      <p class="text-xs text-slate-400 mt-1.5">Minimum 8 caractères</p>
                    </div>

                  
                  <div>
                    <label for="password_confirm" class="block text-sm font-semibold text-slate-700 mb-1">
                      Confirmer <span class="text-red-500">*</span>
                    </label>

                    <div class="password-wrapper">
                      <input type="password"
                        id="password_confirm"
                        name="password_confirm"
                        autocomplete="new-password"
                        placeholder="••••••••"
                        class="mt-1 w-full rounded-xl border 
                          <?= isset($errors['password_confirm']) ? 'border-red-500' : 'border-slate-200' ?>
                          bg-slate-50/50 px-4 py-3 outline-none transition-all
                          focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20"
                      >

                      <button type="button" class="password-toggle" data-target="password_confirm">
                        <svg class="eye-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                          <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                      </button>
                    </div>

                    <?php if (isset($errors['password_confirm'])): ?>
                      <p class="text-xs text-red-500 mt-1">
                        <?= htmlspecialchars($errors['password_confirm']) ?>
                      </p>
                    <?php endif; ?>
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
        </form>

        <div class="mt-3 text-center">
          <p class="text-sm text-slate-500">
            Déjà inscrit ?
            <a href="login.php" class="font-semibold text-primary hover:text-violet-800 hover:underline transition">Se connecter</a>
          </p>
        </div>

      </main>
    </div>

<aside class="relative hidden min-h-[280px] flex-col justify-between overflow-hidden p-8 lg:flex lg:min-h-screen lg:p-12 xl:p-16" style="background-image: linear-gradient(135deg, rgba(248,244,255,0.85) 0%, rgba(237,230,255,0.85) 30%, rgba(224,212,255,0.85) 60%, rgba(208,191,255,0.85) 100%), url('https://imgs.search.brave.com/Nqg2-9urYxRDc5JOSMXFuRcr93j90CeXTQC48vlUYCw/rs:fit:500:0:1:0/g:ce/aHR0cHM6Ly9tZWRp/YS5pc3RvY2twaG90/by5jb20vaWQvOTQ3/Mjk1MDM0L2ZyL3Bo/b3RvL3VuLWdyb3Vw/ZS1kZS1kaXBsJUMz/JUI0bSVDMyVBOXMt/amV0YW50LWRlcy1j/YXNxdWV0dGVzLWRl/LWdyYWR1YXRpb24t/ZGFucy1sYWlyLmpw/Zz9zPTYxMng2MTIm/dz0wJms9MjAmYz13/ODJYbjZnNG1Rd05f/RG5GYzcxMFAtUHpR/WGMyLTRiZndwQVoy/aUtUbzZVPQ'); background-size: cover; background-position: center; background-blend-mode: overlay;">  
  <!-- Overlay noir -->
  <div class="absolute inset-0 bg-black/70"></div>
  
  

  <!-- Contenu principal -->
  <div class="relative z-10 flex flex-col justify-center min-h-full text-white">
    <!-- Badge -->
    <div class="mb-6 inline-flex items-center gap-2 self-start px-4 py-1.5 text-4xl font-semibold">
      Bienvenue sur <span class="text-primary">AfricEduc</span>
    </div>

    <!-- Titre principal -->
    <h2 class="text-3xl font-bold leading-tight sm:text-4xl lg:text-5xl text-white">
      La plateforme éducative<br>
      <span class="text-primary">qui connecte</span> votre école
    </h2>

    <!-- Description -->
    <p class="mt-4 max-w-sm text-base text-white/80 leading-relaxed">
      Gérez vos collèges et lycées en toute simplicité. Une solution tout-en-un pensée pour l'éducation au Bénin.
    </p>

    <!-- Avantages avec icônes Font Awesome -->
    <div class="mt-8 space-y-4">
      <div class="flex items-start gap-4 p-3 rounded-xl transition-all hover:bg-white/5">
        <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary/20 text-primary backdrop-blur-md border border-white/10">
          <i class="fas fa-building text-lg"></i>
        </span>
        <div>
          <p class="font-semibold text-white">Établissements vérifiés</p>
          <p class="text-sm text-white/70">Profils authentifiés et sécurisés</p>
        </div>
      </div>

      <div class="flex items-start gap-4 p-3 rounded-xl transition-all hover:bg-white/5">
        <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary/20 text-primary backdrop-blur-md border border-white/10">
          <i class="fas fa-chart-line text-lg"></i>
        </span>
        <div>
          <p class="font-semibold text-white">Gestion simplifiée</p>
          <p class="text-sm text-white/70">Élèves, notes, bulletins en quelques clics</p>
        </div>
      </div>

      <div class="flex items-start gap-4 p-3 rounded-xl transition-all hover:bg-white/5">
        <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary/20 text-primary backdrop-blur-md border border-white/10">
          <i class="fas fa-lock text-lg"></i>
        </span>
        <div>
          <p class="font-semibold text-white">Paiements sécurisés</p>
          <p class="text-sm text-white/70">Transactions garanties et suivi intégré</p>
        </div>
      </div>
    </div>

  </div>
</aside>
  </div>

  <script>
  'use strict';

  // ─────────────────────────────────────────────
  // CONFIG
  // ─────────────────────────────────────────────

  const TOTAL_STEPS = 3;

  // ─────────────────────────────────────────────
  // HELPERS
  // ─────────────────────────────────────────────

  const $ = (id) => document.getElementById(id);

  // ─────────────────────────────────────────────
  // STATE
  // ─────────────────────────────────────────────

  const state = {
    currentStep: 1,
    isSubmitting: false,
  };

  // ─────────────────────────────────────────────
  // ELEMENTS
  // ─────────────────────────────────────────────

  const els = {
    form: $('register-form'),

    prevBtn: $('prev-btn'),
    nextBtn: $('next-btn'),
    submitBtn: $('submit-btn'),

    btnLabel: $('btn-label'),
    btnSpinner: $('btn-spinner'),

    recapContainer: $('recap-container'),

    schoolName: $('school_name'),
    schoolEmail: $('school_email'),
   

    adminName: $('admin_full_name'),
    adminEmail: $('admin_email'),
  };

  // ─────────────────────────────────────────────
  // INIT
  // ─────────────────────────────────────────────

  document.addEventListener('DOMContentLoaded', () => {

    if (!els.form) return;

    initNavigation();

    initPasswordToggles();

    initSubmit();

    render();
  });

  // ─────────────────────────────────────────────
  // NAVIGATION
  // ─────────────────────────────────────────────

  function initNavigation() {

    els.nextBtn?.addEventListener('click', () => {

      if (state.currentStep >= TOTAL_STEPS) {
        return;
      }

      state.currentStep++;

      render();
    });

    els.prevBtn?.addEventListener('click', () => {

      if (state.currentStep <= 1) {
        return;
      }

      state.currentStep--;

      render();
    });
  }

  function render() {

    renderPanels();

    renderButtons();

    renderIndicators();

    renderRecap();
  }

  // ─────────────────────────────────────────────
  // STEP PANELS
  // ─────────────────────────────────────────────

  function renderPanels() {

    for (let i = 1; i <= TOTAL_STEPS; i++) {

      const panel = $('step' + i);

      if (!panel) continue;

      panel.classList.toggle(
        'hidden',
        i !== state.currentStep
      );
    }
  }

  // ─────────────────────────────────────────────
  // NAV BUTTONS
  // ─────────────────────────────────────────────

  function renderButtons() {

    const isFirst =
      state.currentStep === 1;

    const isLast =
      state.currentStep === TOTAL_STEPS;

    els.prevBtn?.classList.toggle(
      'hidden',
      isFirst
    );

    els.nextBtn?.classList.toggle(
      'hidden',
      isLast
    );

    els.submitBtn?.classList.toggle(
      'hidden',
      !isLast
    );
  }

  // ─────────────────────────────────────────────
  // STEP INDICATORS
  // ─────────────────────────────────────────────

  function renderIndicators() {

    for (let i = 1; i <= TOTAL_STEPS; i++) {

      const indicator =
        $('step' + i + '-indicator');

      const label =
        $('step' + i + '-label');

      if (!indicator || !label) continue;

      indicator.classList.remove(
        'step-active',
        'step-completed',
        'step-default'
      );

      label.classList.remove(
        'step-label-active',
        'step-label-completed',
        'step-label-default'
      );

      if (i < state.currentStep) {

        indicator.classList.add(
          'step-completed'
        );

        label.classList.add(
          'step-label-completed'
        );

        indicator.textContent = '✓';

      } else if (i === state.currentStep) {

        indicator.classList.add(
          'step-active'
        );

        label.classList.add(
          'step-label-active'
        );

        indicator.textContent = i;

      } else {

        indicator.classList.add(
          'step-default'
        );

        label.classList.add(
          'step-label-default'
        );

        indicator.textContent = i;
      }
    }

    renderLines();
  }

  // ─────────────────────────────────────────────
  // STEP LINES
  // ─────────────────────────────────────────────

  function renderLines() {

    const line1 = $('line1');

    const line2 = $('line2');

    if (line1) {

      line1.className =
        state.currentStep > 1
          ? 'flex-1 h-0.5 mx-2 step-line step-line-completed'
          : 'flex-1 h-0.5 mx-2 step-line step-line-default';
    }

    if (line2) {

      line2.className =
        state.currentStep > 2
          ? 'flex-1 h-0.5 mx-2 step-line step-line-completed'
          : 'flex-1 h-0.5 mx-2 step-line step-line-default';
    }
  }

  // ─────────────────────────────────────────────
  // RECAP
  // ─────────────────────────────────────────────

  function renderRecap() {

    if (!els.recapContainer) return;

    const rows = [
      ['Établissement', els.schoolName?.value],
      ['Email école', els.schoolEmail?.value],
      ['Administrateur', els.adminName?.value],
      ['Email admin', els.adminEmail?.value],
    ];

    els.recapContainer.innerHTML =
      rows.map(([label, value]) => {

        return `
          <div class="flex justify-between py-2 border-b border-slate-100">

            <span class="text-slate-500">
              ${escapeHtml(label)}
            </span>

            <span class="font-medium text-slate-700">
              ${escapeHtml(value || '-')}
            </span>

          </div>
        `;
      }).join('');
  }

  // ─────────────────────────────────────────────
  // SUBMIT
  // ─────────────────────────────────────────────

  function initSubmit() {

    els.form.addEventListener(
      'submit',
      handleSubmit
    );
  }

  function handleSubmit() {

    if (state.isSubmitting) {
      return;
    }

    disableSubmitButton();

    
  }

  function disableSubmitButton() {

    state.isSubmitting = true;

    els.submitBtn.disabled = true;

    els.submitBtn.classList.add(
      'opacity-70',
      'cursor-not-allowed'
    );

    els.btnLabel?.classList.add(
      'hidden'
    );

    els.btnSpinner?.classList.remove(
      'hidden'
    );
  }

  // ─────────────────────────────────────────────
  // PASSWORD TOGGLE
  // ─────────────────────────────────────────────

  function initPasswordToggles() {

    document.querySelectorAll(
      '.password-toggle'
    ).forEach((button) => {

      button.addEventListener(
        'click',
        () => {

          const targetId =
            button.dataset.target;

          if (!targetId) return;

          const input = $(targetId);

          if (!input) return;

          input.type =
            input.type === 'password'
              ? 'text'
              : 'password';
        }
      );
    });
  }

  // ─────────────────────────────────────────────
  // UTILS
  // ─────────────────────────────────────────────

  function escapeHtml(str) {

    return String(str).replace(
      /[&<>"]/g,
      (char) => {

        const map = {
          '&': '&amp;',
          '<': '&lt;',
          '>': '&gt;',
          '"': '&quot;',
        };

        return map[char];
      }
    );
  }
  </script>
</body>
</html>