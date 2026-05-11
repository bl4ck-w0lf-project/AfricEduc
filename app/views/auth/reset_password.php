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
          colors: { primary: "#7300e9", accent: "#99fbe3" },
          fontFamily: {
            heading: ["Quicksand", "sans-serif"],
            body:    ["Outfit",    "sans-serif"]
          },
          boxShadow: { glow: "0 20px 50px -20px rgba(115,0,233,.45)" }
        }
      }
    };
  </script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">

  <style>
    body { font-family: "Outfit", sans-serif; }
    h1, h2, h3 { font-family: "Quicksand", sans-serif; }
    .page-bg {
      background-color: #f4f4f7;
      background-image:
        radial-gradient(circle at 15% 20%, rgba(153,251,227,.45), transparent 42%),
        radial-gradient(circle at 85% 10%, rgba(115,0,233,.12),   transparent 40%),
        radial-gradient(circle at 50% 100%, rgba(115,0,233,.06),  transparent 50%);
    }
    .page-bg::before {
      content: "";
      position: fixed;
      inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%237300e9' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
      opacity: .9;
      pointer-events: none;
      z-index: 0;
    }
    .glass-card {
      background: rgba(255,255,255,.72);
      border: 1px solid rgba(255,255,255,.85);
      box-shadow:
        0 4px 6px -1px rgba(115,0,233,.06),
        0 20px 40px -12px rgba(115,0,233,.15);
      backdrop-filter: blur(14px);
      -webkit-backdrop-filter: blur(14px);
    }
    @keyframes card-in {
      from { opacity: 0; transform: translateY(20px) scale(.98); }
      to   { opacity: 1; transform: translateY(0)    scale(1);   }
    }
    .card-enter { animation: card-in .65s ease-out forwards; }

    /* Indicateur force du mot de passe */
    .strength-bar { height: 4px; border-radius: 2px; transition: all .3s; }
  </style>
</head>
<body class="page-bg min-h-screen antialiased text-slate-800">
<div class="relative z-10 flex min-h-screen flex-col items-center justify-center px-4 py-10 sm:px-6">
  <div class="card-enter glass-card w-full max-w-md rounded-3xl p-8 sm:p-10">

    <!-- Logo -->
    <div class="flex flex-col items-center text-center">
      <a href="/index.php" class="inline-flex items-center gap-3">
        <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-primary/10">
          <svg width="30" height="30" viewBox="0 0 16 16" fill="none"
               stroke="#9600ec" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
            <path d="m14.25 9.25v-3.25l-6.25-3.25-6.25 3.25 6.25 3.25 3.25-1.5v3.5c0 1-1.5 2-3.25 2s-3.25-1-3.25-2v-3.5"/>
          </svg>
        </span>
        <span class="text-2xl font-bold tracking-tight text-slate-900">
          Afric<span class="text-primary">Educ</span>
        </span>
      </a>
      <h1 class="mt-6 text-2xl font-bold text-slate-900 sm:text-3xl">Nouveau mot de passe</h1>
      <p class="mt-3 text-sm text-slate-600">
        Choisissez un mot de passe sécurisé (8 caractères minimum).
      </p>
    </div>

    <?php if ($success): ?>

      <!-- ── Succès ──────────────────────────────────────────────────── -->
      <div class="mt-8 text-center" role="status" aria-live="polite">
        <div class="rounded-2xl border border-accent/50 bg-accent/25 px-4 py-5 text-slate-800">
          <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center
                      rounded-full bg-primary/15 text-primary">
            <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none"
                 stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75 9 17.25 20.25 6"/>
            </svg>
          </div>
          <p class="text-base font-semibold text-slate-900">Mot de passe mis à jour !</p>
          <p class="mt-2 text-sm text-slate-600">
            Vous pouvez maintenant vous connecter avec votre nouveau mot de passe.
          </p>
          <a href="/app/views/auth/login.php"
             class="mt-4 inline-flex items-center justify-center gap-2
                    rounded-xl bg-primary px-5 py-2.5 text-sm font-semibold
                    text-white transition hover:bg-violet-800">
            Aller à la connexion
          </a>
        </div>
      </div>

    <?php else: ?>

      <!-- ── Formulaire ──────────────────────────────────────────────── -->
      <form method="POST"
            action="/app/controllers/PasswordController.php?action=reset"
            class="mt-8 space-y-5"
            novalidate>

        <!-- Token caché -->
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

        <!-- Erreur globale (token expiré, etc.) -->
        <?php if (!empty($errors['global'])): ?>
          <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3
                      text-sm text-red-800" role="alert">
            <?= htmlspecialchars($errors['global']) ?>
            <a href="/app/views/auth/forgot_password.php"
               class="ml-1 font-semibold underline hover:text-red-900">
              Faire une nouvelle demande
            </a>
          </div>
        <?php endif; ?>

        <!-- Nouveau mot de passe -->
        <div>
          <label for="password" class="block text-sm font-medium text-slate-700">
            Nouveau mot de passe
          </label>
          <div class="relative">
            <input
              type="password"
              id="password"
              name="password"
              required
              autocomplete="new-password"
              class="mt-1 w-full rounded-xl border
                     <?= isset($errors['password']) ? 'border-red-500' : 'border-slate-200' ?>
                     bg-slate-50/50 px-4 py-3 pr-12 outline-none transition-all
                     focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20">
            <!-- Toggle visibilité -->
            <button type="button" onclick="toggleVisi('password', this)"
              class="absolute right-3 top-1/2 -translate-y-1/2 mt-0.5
                     text-slate-400 hover:text-primary transition"
              aria-label="Afficher/masquer le mot de passe">
              <svg class="h-5 w-5 eye-icon" fill="none" viewBox="0 0 24 24"
                   stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7
                         -1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z"/>
                <circle cx="12" cy="12" r="3" stroke-linecap="round"/>
              </svg>
            </button>
          </div>
          <?php if (isset($errors['password'])): ?>
            <p class="mt-1 text-xs text-red-500">
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
          <label for="password_confirm" class="block text-sm font-medium text-slate-700">
            Confirmer le mot de passe
          </label>
          <div class="relative">
            <input
              type="password"
              id="password_confirm"
              name="password_confirm"
              required
              autocomplete="new-password"
              class="mt-1 w-full rounded-xl border
                     <?= isset($errors['password_confirm']) ? 'border-red-500' : 'border-slate-200' ?>
                     bg-slate-50/50 px-4 py-3 pr-12 outline-none transition-all
                     focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20">
            <button type="button" onclick="toggleVisi('password_confirm', this)"
              class="absolute right-3 top-1/2 -translate-y-1/2 mt-0.5
                     text-slate-400 hover:text-primary transition"
              aria-label="Afficher/masquer la confirmation">
              <svg class="h-5 w-5 eye-icon" fill="none" viewBox="0 0 24 24"
                   stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7
                         -1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z"/>
                <circle cx="12" cy="12" r="3" stroke-linecap="round"/>
              </svg>
            </button>
          </div>
          <?php if (isset($errors['password_confirm'])): ?>
            <p class="mt-1 text-xs text-red-500">
              <?= htmlspecialchars($errors['password_confirm']) ?>
            </p>
          <?php endif; ?>
        </div>

        <!-- Bouton submit -->
        <button type="submit"
          class="inline-flex w-full min-h-[48px] items-center justify-center
                 rounded-xl bg-primary px-6 py-3 text-sm font-semibold text-white
                 shadow-glow transition hover:bg-violet-800
                 disabled:cursor-not-allowed disabled:opacity-60">
          Mettre à jour le mot de passe
        </button>
      </form>

    <?php endif; ?>

    <p class="mt-8 text-center">
      <a href="/app/views/auth/login.php"
         class="inline-flex items-center gap-2 text-sm font-semibold
                text-primary transition hover:text-violet-800">
        <span aria-hidden="true">←</span> Retour à la connexion
      </a>
    </p>

  </div>
</div>

<script>
  // ── Toggle visibilité mot de passe ──────────────────────────────────────
  function toggleVisi(id, btn) {
    var inp = document.getElementById(id);
    var isHidden = inp.type === 'password';
    inp.type = isHidden ? 'text' : 'password';

    // Icône œil barré quand visible
    var svg = btn.querySelector('svg');
    if (isHidden) {
      svg.innerHTML = `
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M3.98 8.223A10.477 10.477 0 0 0 2.458 12
                 c1.274 4.057 5.065 7 9.542 7
                 1.906 0 3.686-.54 5.19-1.473M6.228 6.228
                 A10.451 10.451 0 0 1 12 5c4.477 0 8.268 2.943 9.542 7
                 a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228
                 3 3m0 0 3 3m3.5-1.5a3 3 0 1 1-4.243 4.243"/>`;
    } else {
      svg.innerHTML = `
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7
                 -1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z"/>
        <circle cx="12" cy="12" r="3" stroke-linecap="round"/>`;
    }
  }

  // ── Indicateur de force du mot de passe ────────────────────────────────
  var pwdInput = document.getElementById('password');
  if (pwdInput) {
    pwdInput.addEventListener('input', function () {
      var val    = this.value;
      var score  = 0;
      var colors = ['bg-red-400', 'bg-orange-400', 'bg-yellow-400', 'bg-green-500'];
      var labels = ['Très faible', 'Faible', 'Moyen', 'Fort'];

      if (val.length >= 8)               score++;
      if (/[A-Z]/.test(val))            score++;
      if (/[0-9]/.test(val))            score++;
      if (/[^A-Za-z0-9]/.test(val))    score++;

      for (var i = 1; i <= 4; i++) {
        var bar = document.getElementById('bar-' + i);
        bar.className = 'strength-bar flex-1 ' +
                        (i <= score ? colors[score - 1] : 'bg-slate-200');
      }

      var lbl = document.getElementById('strength-label');
      lbl.textContent = val.length > 0 ? labels[score - 1] || '' : '';
    });
  }
</script>
</body>
</html>