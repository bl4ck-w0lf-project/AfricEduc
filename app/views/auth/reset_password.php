<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$token   = trim($_GET['token'] ?? '');
$errors  = $_SESSION['reset_errors']  ?? [];
$success = $_SESSION['reset_success'] ?? false;

unset($_SESSION['reset_errors'], $_SESSION['reset_success']);

// Pas de token et pas en état "succès" → redirige
if (!$success && $token === '') {
    header('Location: /app/views/auth/forgot_password.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nouveau mot de passe | AfricEduc</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: "#0F9D72",
            primaryDark: "#0B7A58",
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

    .glass-card {
      background: rgba(255, 255, 255, 0.72);
      border: 1px solid rgba(255, 255, 255, 0.85);
      box-shadow:
        0 4px 6px -1px rgba(115, 0, 233, 0.06),
        0 20px 40px -12px rgba(115, 0, 233, 0.15);
      backdrop-filter: blur(14px);
      -webkit-backdrop-filter: blur(14px);
    }
    @keyframes card-in {
      from { opacity: 0; transform: translateY(20px) scale(0.98); }
      to { opacity: 1; transform: translateY(0) scale(1); }
    }
    .card-enter { animation: card-in 0.65s ease-out forwards; }

    .page-bg {
      background: linear-gradient(135deg, #f0fdf4 0%, #f8fafc 50%, #ffffff 100%);
    }

    .strength-bar { height: 4px; border-radius: 2px; transition: all .3s; }
  </style>
</head>
<body class="page-bg min-h-screen antialiased text-slate-800">
  <div class="relative z-10 min-h-screen lg:grid lg:grid-cols-2">

    <!-- Colonne gauche - SVG + cercles verts -->
    <aside class="relative hidden min-h-[280px] flex-col justify-between overflow-hidden p-8 lg:flex lg:min-h-screen lg:p-12 xl:p-16" style="background-image: linear-gradient(135deg, rgba(15,157,114,0.9) 0%, rgba(11,122,88,0.9) 50%, rgba(10,46,31,0.95) 100%), url('/AfricEduc/public/My-password-pana.svg'); background-size: cover; background-position: center; background-blend-mode: overlay;">  
      <!-- Cercles décoratifs verts -->
      <div class="absolute top-20 right-20 w-64 h-64 bg-[#00ffb3]/20 rounded-full blur-3xl"></div>
      <div class="absolute bottom-20 left-20 w-48 h-48 bg-[#00ffb3]/10 rounded-full blur-2xl"></div>
      <div class="absolute top-40 left-10 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>
    </aside>

    <!-- Colonne droite - Formulaire -->
    <div class="flex min-h-screen flex-col justify-center px-6 py-8 sm:px-10 md:px-14 lg:px-20 xl:px-24">

      <!-- Logo -->
      <a href="#" class="">
        <img src="/AfricEduc/public/logo.png" alt="AfricEduc" class="h-[100px] w-auto mx-auto">
      </a>

      <!-- Icône clé -->
      <div class="mt-4 w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mx-auto">
        <i class="fa-solid fa-key text-2xl text-primary"></i>
      </div>

      <h1 class="mt-4 text-3xl font-bold text-slate-900 mx-auto">Nouveau mot de passe</h1>
      <p class="mt-2 max-w-sm text-sm text-slate-600 sm:text-base mx-auto">
        Choisissez un mot de passe sécurisé <strong class="text-primary">(8 caractères minimum)</strong>.
      </p>

      <?php if ($success): ?>

        <!-- ── Succès ──────────────────────────────────────────────────── -->
        <div class="mt-8 text-center mx-auto w-full max-w-md" role="status" aria-live="polite">
          <div class="rounded-2xl border border-accent/50 bg-accent/25 px-4 py-5 text-slate-800">
            <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-primary/15 text-primary">
              <i class="fa-solid fa-check text-xl"></i>
            </div>
            <p class="text-base font-semibold text-slate-900">Mot de passe mis à jour !</p>
            <p class="mt-2 text-sm text-slate-600">
              Vous pouvez maintenant vous connecter avec votre nouveau mot de passe.
            </p>
            <a href="/AfricEduc/public/index.php?url=login"
               class="mt-4 inline-flex items-center justify-center gap-2 rounded-xl bg-primary px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-primary/25 transition hover:bg-primary/90 hover:shadow-primary/35">
              <i class="fa-solid fa-arrow-right-to-bracket"></i>
              Aller à la connexion
            </a>
          </div>
        </div>

      <?php else: ?>

        <!-- ── Formulaire ──────────────────────────────────────────────── -->
        <form method="POST"
              action="/AfricEduc/public/index.php?url=password&action=reset"
              class="mx-auto mt-8 space-y-6 w-full max-w-md"
              novalidate>

          <!-- Token caché -->
          <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

          <!-- Erreur globale (token expiré, etc.) -->
          <?php if (!empty($errors['global'])): ?>
            <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
              <i class="fa-solid fa-circle-exclamation mr-2"></i>
              <?= htmlspecialchars($errors['global']) ?>
              <a href="/AfricEduc/public/index.php?url=password&action=forgot"
                 class="ml-1 font-semibold underline hover:text-red-900">
                Faire une nouvelle demande
              </a>
            </div>
          <?php endif; ?>

          <!-- Nouveau mot de passe -->
          <div>
            <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Nouveau mot de passe</label>
            <div class="relative mt-2">
              <input
                type="password"
                id="password"
                name="password"
                required
                autocomplete="new-password"
                placeholder="••••••••"
                class="w-full rounded-xl border <?= isset($errors['password']) ? 'border-red-500' : 'border-slate-200' ?> bg-white/90 px-5 py-3.5 pr-14 text-slate-800 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
              <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 flex w-14 items-center justify-center rounded-r-xl text-slate-400 transition hover:text-primary focus:outline-none"
                aria-label="Afficher le mot de passe" aria-pressed="false">
                <svg id="icon-eye" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12s-3.75 6.75-9.75 6.75S2.25 12 2.25 12Z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                </svg>
                <svg id="icon-eye-off" class="hidden h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M9.88 9.88A3 3 0 1 0 14.12 14.12" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6.34 6.34C4.18 7.68 2.25 12 2.25 12s3.75 6.75 9.75 6.75c1.56 0 2.97-.42 4.2-1.1M10.73 5.08A9.3 9.3 0 0 1 12 4.5c6 0 9.75 6.75 9.75 6.75s-.98 1.76-2.7 3.47" />
                </svg>
              </button>
            </div>
            <?php if (isset($errors['password'])): ?>
              <p class="text-xs text-red-500 mt-1.5">
                <i class="fa-regular fa-circle-exclamation mr-1"></i>
                <?= htmlspecialchars($errors['password']) ?>
              </p>
            <?php endif; ?>

            <!-- Barre de force -->
            <div class="mt-2 flex gap-1" id="strength-bars" aria-hidden="true">
              <div class="strength-bar flex-1 bg-slate-200" id="bar-1"></div>
              <div class="strength-bar flex-1 bg-slate-200" id="bar-2"></div>
              <div class="strength-bar flex-1 bg-slate-200" id="bar-3"></div>
              <div class="strength-bar flex-1 bg-slate-200" id="bar-4"></div>
            </div>
            <p class="mt-1 text-xs text-slate-400" id="strength-label"></p>
          </div>

          <!-- Confirmation -->
          <div>
            <label for="password_confirm" class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Confirmer le mot de passe</label>
            <div class="relative mt-2">
              <input
                type="password"
                id="password_confirm"
                name="password_confirm"
                required
                autocomplete="new-password"
                placeholder="••••••••"
                class="w-full rounded-xl border <?= isset($errors['password_confirm']) ? 'border-red-500' : 'border-slate-200' ?> bg-white/90 px-5 py-3.5 pr-14 text-slate-800 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
              <button type="button" id="toggle-password-confirm" class="absolute inset-y-0 right-0 flex w-14 items-center justify-center rounded-r-xl text-slate-400 transition hover:text-primary focus:outline-none"
                aria-label="Afficher le mot de passe" aria-pressed="false">
                <svg id="icon-eye-confirm" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12s-3.75 6.75-9.75 6.75S2.25 12 2.25 12Z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                </svg>
                <svg id="icon-eye-off-confirm" class="hidden h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M9.88 9.88A3 3 0 1 0 14.12 14.12" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6.34 6.34C4.18 7.68 2.25 12 2.25 12s3.75 6.75 9.75 6.75c1.56 0 2.97-.42 4.2-1.1M10.73 5.08A9.3 9.3 0 0 1 12 4.5c6 0 9.75 6.75 9.75 6.75s-.98 1.76-2.7 3.47" />
                </svg>
              </button>
            </div>
            <?php if (isset($errors['password_confirm'])): ?>
              <p class="text-xs text-red-500 mt-1.5">
                <i class="fa-regular fa-circle-exclamation mr-1"></i>
                <?= htmlspecialchars($errors['password_confirm']) ?>
              </p>
            <?php endif; ?>
          </div>

          <!-- Bouton -->
          <button type="submit"
            class="inline-flex w-full max-w-md min-h-[52px] items-center justify-center gap-2 rounded-xl bg-primary px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-primary/25 transition hover:bg-primary/90 hover:shadow-primary/35 disabled:cursor-not-allowed disabled:opacity-60">
            <i class="fa-solid fa-save"></i>
            Mettre à jour le mot de passe
          </button>
        </form>

      <?php endif; ?>

      <!-- Retour connexion -->
      <p class="mt-8 text-center">
        <a href="/AfricEduc/public/index.php?url=login"
           class="inline-flex items-center gap-2 text-sm font-semibold text-primary transition hover:text-emerald-800">
          <span aria-hidden="true">←</span>
          Retour à la connexion
        </a>
      </p>

    </div>
  </div>

  <script>
    // ── Toggle visibilité mot de passe ──────────────────────────────────────
    (function() {
      const pwdInput = document.getElementById('password');
      const pwdConfirm = document.getElementById('password_confirm');
      const togglePwd = document.getElementById('toggle-password');
      const togglePwdConfirm = document.getElementById('toggle-password-confirm');
      const iconEye = document.getElementById('icon-eye');
      const iconEyeOff = document.getElementById('icon-eye-off');
      const iconEyeConfirm = document.getElementById('icon-eye-confirm');
      const iconEyeOffConfirm = document.getElementById('icon-eye-off-confirm');

      if (togglePwd && pwdInput) {
        togglePwd.addEventListener('click', function() {
          const isText = pwdInput.type === 'text';
          pwdInput.type = isText ? 'password' : 'text';
          iconEye.classList.toggle('hidden', !isText);
          iconEyeOff.classList.toggle('hidden', isText);
        });
      }

      if (togglePwdConfirm && pwdConfirm) {
        togglePwdConfirm.addEventListener('click', function() {
          const isText = pwdConfirm.type === 'text';
          pwdConfirm.type = isText ? 'password' : 'text';
          iconEyeConfirm.classList.toggle('hidden', !isText);
          iconEyeOffConfirm.classList.toggle('hidden', isText);
        });
      }

      // ── Indicateur de force du mot de passe ────────────────────────────────
      if (pwdInput) {
        pwdInput.addEventListener('input', function() {
          var val = this.value;
          var score = 0;
          var colors = ['bg-red-400', 'bg-orange-400', 'bg-yellow-400', 'bg-green-500'];
          var labels = ['Très faible', 'Faible', 'Moyen', 'Fort'];

          if (val.length >= 8) score++;
          if (/[A-Z]/.test(val)) score++;
          if (/[0-9]/.test(val)) score++;
          if (/[^A-Za-z0-9]/.test(val)) score++;

          for (var i = 1; i <= 4; i++) {
            var bar = document.getElementById('bar-' + i);
            if (bar) {
              bar.className = 'strength-bar flex-1 ' + (i <= score ? colors[score - 1] : 'bg-slate-200');
            }
          }

          var lbl = document.getElementById('strength-label');
          if (lbl) {
            lbl.textContent = val.length > 0 ? 'Force : ' + (labels[score - 1] || '') : '';
          }
        });
      }
    })();
  </script>
</body>
</html>