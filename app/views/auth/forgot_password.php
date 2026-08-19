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
    @keyframes spin {
      to { transform: rotate(360deg); }
    }
    .spinner { animation: spin 0.7s linear infinite; }
  </style>
</head>
<body class="page-bg min-h-screen antialiased text-slate-800">
  <div class="relative z-10 min-h-screen lg:grid lg:grid-cols-2">

    <!-- Colonne gauche - SVG + texte en bas + cercles verts -->
    <aside class="relative hidden min-h-[280px] flex-col justify-between overflow-hidden p-8 lg:flex lg:min-h-screen lg:p-12 xl:p-16" style="background-image: linear-gradient(135deg, rgba(15,157,114,0.9) 0%, rgba(11,122,88,0.9) 50%, rgba(10,46,31,0.95) 100%), url('/AfricEduc/public/Forgot-password-pana.svg'); background-size: cover; background-position: center; background-blend-mode: overlay;">  
      <!-- Cercles décoratifs verts -->
      <div class="absolute top-20 right-20 w-64 h-64 bg-[#00ffb3]/20 rounded-full blur-3xl"></div>
      <div class="absolute bottom-20 left-20 w-48 h-48 bg-[#00ffb3]/10 rounded-full blur-2xl"></div>
      <div class="absolute top-40 left-10 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>
      
      <!-- Contenu principal -->
      
    </aside>

    <!-- Colonne droite - Formulaire -->
    <div class="flex min-h-screen flex-col justify-center px-6 py-8 sm:px-10 md:px-14 lg:px-20 xl:px-24">

      <!-- Logo -->
      <a href="#" class="">
        <img src="/AfricEduc/public/logo.png" alt="AfricEduc" class="h-[100px] w-auto mx-auto">
      </a>

       <div class="mt-4 w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mx-auto">
        <i class="fa-solid fa-key text-2xl text-primary"></i>
      </div>

      <h1 class="mt-3 text-3xl font-bold text-slate-900 mx-auto">Mot de passe oublié ?</h1>
      <p class="mt-2 max-w-sm text-sm text-slate-600 sm:text-base mx-auto">
        Saisissez l'adresse email de votre compte. Vous recevrez un lien valable
        <strong class="text-primary">1 heure</strong> pour réinitialiser votre mot de passe.
      </p>

      <?php if ($success): ?>

        <!-- ── Bloc succès ─────────────────────────────────────────────── -->
        <div class="mt-8 text-center mx-auto w-full max-w-md" role="status" aria-live="polite">
          <div class="rounded-2xl border border-accent/50 bg-accent/25 px-4 py-5 text-slate-800">
            <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-primary/15 text-primary">
              <i class="fa-solid fa-check text-xl"></i>
            </div>
            <p class="text-base font-semibold text-slate-900">Email envoyé !</p>
            <p class="mt-2 text-sm text-slate-600">
              Consultez votre boîte de réception (et les courriers indésirables).<br>
              Le lien expire dans <strong class="text-primary">une heure</strong>.
            </p>
          </div>
        </div>

      <?php else: ?>

        <!-- ── Formulaire ──────────────────────────────────────────────── -->
        <form method="POST"
              action="/AfricEduc/public/index.php?url=password&action=forgot"
              class="mx-auto mt-8 space-y-6 w-full max-w-md"
              novalidate>

          <!-- Erreur globale -->
          <?php if (!empty($errors['global'])): ?>
            <p class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
              <i class="fa-solid fa-circle-exclamation mr-2"></i>
              <?= htmlspecialchars($errors['global']) ?>
            </p>
          <?php endif; ?>

          <!-- Email -->
          <div>
            <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Email</label>
            <input
              type="email"
              id="email"
              name="email"
              required
              autocomplete="email"
              placeholder="exemple@email.com"
              value="<?= htmlspecialchars($old['email'] ?? '') ?>"
              class="mt-2 w-full rounded-xl border <?= isset($errors['email']) ? 'border-red-500' : 'border-slate-200' ?> bg-white/90 px-5 py-3.5 text-slate-800 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
            <?php if (isset($errors['email'])): ?>
              <p class="text-xs text-red-500 mt-1.5">
                <i class="fa-regular fa-circle-exclamation mr-1"></i>
                <?= htmlspecialchars($errors['email']) ?>
              </p>
            <?php endif; ?>
          </div>

          <!-- Bouton -->
          <button type="submit"
            class="inline-flex w-full max-w-md min-h-[52px] items-center justify-center gap-2 rounded-xl bg-primary px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-primary/25 transition hover:bg-primary/90 hover:shadow-primary/35 disabled:cursor-not-allowed disabled:opacity-60">
            <i class="fa-solid fa-paper-plane"></i>
            Envoyer le lien
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
</body>
</html>