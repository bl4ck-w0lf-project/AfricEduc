<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$errors  = $_SESSION['forgot_errors'] ?? [];
$old     = $_SESSION['forgot_old']    ?? [];
$success = $_SESSION['forgot_success'] ?? false;

unset(
    $_SESSION['forgot_errors'],
    $_SESSION['forgot_old'],
    $_SESSION['forgot_success']
);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mot de passe oublié | AfricEduc</title>
  <meta name="description" content="Réinitialisez votre mot de passe AfricEduc.">

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
  </style>
</head>
<body class="page-bg min-h-screen antialiased text-slate-800">
<div class="relative z-10 flex min-h-screen flex-col items-center justify-center px-4 py-10 sm:px-6">
  <div class="card-enter glass-card w-full max-w-md rounded-3xl p-8 sm:p-10">

    <!-- Logo -->
    <div class="flex flex-col items-center text-center">
      <a href="/index.php" class="inline-flex items-center gap-3">
        <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-primary/10 text-primary">
          <svg width="30" height="30" viewBox="0 0 16 16" fill="none"
               stroke="#9600ec" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
            <path d="m14.25 9.25v-3.25l-6.25-3.25-6.25 3.25 6.25 3.25 3.25-1.5v3.5c0 1-1.5 2-3.25 2s-3.25-1-3.25-2v-3.5"/>
          </svg>
        </span>
        <span class="text-2xl font-bold tracking-tight text-slate-900">
          Afric<span class="text-primary">Educ</span>
        </span>
      </a>

      <h1 class="mt-6 text-2xl font-bold text-slate-900 sm:text-3xl">Mot de passe oublié ?</h1>
      <p class="mt-3 max-w-sm text-sm leading-relaxed text-slate-600 sm:text-base">
        Saisissez l'adresse email de votre compte administrateur. Vous recevrez un lien valable
        <strong class="font-semibold text-slate-800">1 heure</strong> pour choisir un nouveau mot de passe.
      </p>
    </div>

    <?php if ($success): ?>

      <!-- ── Bloc succès ─────────────────────────────────────────────── -->
      <div class="mt-8 text-center" role="status" aria-live="polite">
        <div class="rounded-2xl border border-accent/50 bg-accent/25 px-4 py-5 text-slate-800">
          <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center
                      rounded-full bg-primary/15 text-primary">
            <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none"
                 stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75 9 17.25 20.25 6"/>
            </svg>
          </div>
          <p class="text-base font-semibold text-slate-900">Email envoyé !</p>
          <p class="mt-2 text-sm text-slate-600">
            Consultez votre boîte de réception (et les courriers indésirables).<br>
            Le lien expire dans <strong>une heure</strong>.
          </p>
        </div>
      </div>

    <?php else: ?>

      <!-- ── Formulaire ──────────────────────────────────────────────── -->
      <form method="POST"
            action="/AfricEduc/public/index.php?url=password&action=forgot"
            class="mt-8 space-y-5"
            novalidate>

        <!-- Erreur globale -->
        <?php if (!empty($errors['global'])): ?>
          <p class="rounded-xl border border-red-200 bg-red-50 px-4 py-3
                    text-sm text-red-800" role="alert">
            <?= htmlspecialchars($errors['global']) ?>
          </p>
        <?php endif; ?>

        <!-- Champ email -->
        <div>
          <label for="email" class="block text-sm font-medium text-slate-700">
            Email
          </label>
          <input
            type="email"
            id="email"
            name="email"
            required
            autocomplete="email"
            value="<?= htmlspecialchars($old['email'] ?? '') ?>"
            class="mt-1 w-full rounded-xl border
                   <?= isset($errors['email']) ? 'border-red-500' : 'border-slate-200' ?>
                   bg-slate-50/50 px-4 py-3 outline-none transition-all
                   focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20">
          <?php if (isset($errors['email'])): ?>
            <p class="mt-1 text-xs text-red-500">
              <?= htmlspecialchars($errors['email']) ?>
            </p>
          <?php endif; ?>
        </div>

        <!-- Bouton -->
        <button type="submit"
          class="inline-flex w-full min-h-[48px] items-center justify-center
                 rounded-xl bg-primary px-6 py-3 text-sm font-semibold text-white
                 shadow-glow transition hover:bg-violet-800
                 disabled:cursor-not-allowed disabled:opacity-60">
          Envoyer le lien
        </button>
      </form>

    <?php endif; ?>

    <!-- Retour connexion -->
    <p class="mt-8 text-center">
      <a href="login.php"
         class="inline-flex items-center gap-2 text-sm font-semibold
                text-primary transition hover:text-violet-800">
        <span aria-hidden="true">←</span> Retour à la connexion
      </a>
    </p>

  </div>
</div>
</body>
</html>