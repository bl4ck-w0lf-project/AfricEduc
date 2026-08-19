<?php

$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
$flash = $_GET['flash'] ?? null;

if ($flash) {
    $flash = "Déconnexion réussie ";
}
unset($_SESSION['errors'], $_SESSION['old']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion | AfricEduc</title>
  <meta name="description" content="Connectez-vous à votre espace AfricEduc — super administrateur, administrateur ou agent.">

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
           primary: "#0F9D72",
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
    body {
      font-family: "Outfit", sans-serif;
    }
    h1, h2, h3 {
      font-family: "Quicksand", sans-serif;
    }
    
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
      from {
        opacity: 0;
        transform: translateY(20px) scale(0.98);
      }
      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }
    .card-enter {
      animation: card-in 0.65s ease-out forwards;
    }
    @keyframes spin {
      to { transform: rotate(360deg); }
    }
    .spinner {
      animation: spin 0.7s linear infinite;
    }
    .field-error {
      display: none;
    }
    .field-error.is-visible {
      display: block;
    }
    .input-invalid {
      border-color: rgb(220 38 38);
    }
  </style>
</head>
<body class="page-bg min-h-screen antialiased text-slate-800">
  <div class="relative z-10 min-h-screen lg:grid lg:grid-cols-2">

    <!-- Colonne gauche - SVG + texte en bas + cercles verts -->
    <aside class="relative hidden min-h-[280px] flex-col justify-between overflow-hidden p-8 lg:flex lg:min-h-screen lg:p-12 xl:p-16" style="background-image: linear-gradient(135deg, rgba(15,157,114,0.9) 0%, rgba(11,122,88,0.9) 50%, rgba(10,46,31,0.95) 100%), url('/AfricEduc/public/Tablet-login-cuate.svg'); background-size: cover; background-position: center; background-blend-mode: overlay;">  
      <!-- Cercles décoratifs verts -->
      <div class="absolute top-20 right-20 w-64 h-64 bg-[#00ffb3]/20 rounded-full blur-3xl"></div>
      <div class="absolute bottom-20 left-20 w-48 h-48 bg-[#00ffb3]/10 rounded-full blur-2xl"></div>
      <div class="absolute top-40 left-10 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>
      
      <!-- Contenu principal -->
      
    </aside>

    <!-- Colonne droite - Formulaire -->
    <div class="flex min-h-screen flex-col justify-center px-6 py-8 sm:px-10 md:px-14 lg:px-20 xl:px-24">

      <!-- Logo avec image à côté -->
      <a href="#" class="">
        <img src="/AfricEduc/public/logo.png" alt="AfricEduc" class="h-[100px] w-auto mx-auto">
        <!-- <span class="text-2xl font-bold tracking-tight text-slate-900">Afric<span class="text-primary">Educ</span></span> -->
      </a>

      <h1 class="mt-3 text-3xl font-bold text-slate-900 mx-auto">Bienvenue</h1>
      <p class="mt-2 max-w-sm text-sm text-slate-600 sm:text-base mx-auto">
        Connectez-vous avec votre email professionnel. Un seul compte pour accéder à votre espace selon votre rôle.
      </p>

      <form id="login-form" class="mx-auto mt-8 space-y-6 w-full max-w-md" method="POST" action="/AfricEduc/public/index.php?url=login">
        <input type="hidden" name="auth_action" value="login">

        <!-- Email -->
        <div>
          <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Email</label>
          <input type="email" id="email" name="email" autocomplete="username" placeholder="exemple@email.com"
            class="mt-2 w-full max-w-md rounded-xl border <?= isset($errors['email']) ? 'border-red-500' : 'border-slate-200' ?> bg-white/90 px-5 py-3.5 text-slate-800 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
            value="<?= htmlspecialchars($old['email'] ?? '') ?>">
          <?php if (isset($errors['email'])): ?>
            <p class="text-xs text-red-500 mt-1.5"><?= htmlspecialchars($errors['email']) ?></p>
          <?php endif; ?>
        </div>

        <!-- Mot de passe -->
        <div>
          <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Mot de passe</label>
          <div class="relative mt-2">
            <input type="password" id="password" name="password" autocomplete="current-password" placeholder="••••••••"
              class="w-full max-w-md rounded-xl border <?= isset($errors['password']) ? 'border-red-500' : 'border-slate-200' ?> bg-white/90 px-5 py-3.5 pr-14 text-slate-800 placeholder:text-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
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
            <p class="text-xs text-red-500 mt-1.5"><?= htmlspecialchars($errors['password']) ?></p>
          <?php endif; ?>
        </div>

        <!-- Options -->
        <div class="flex items-center justify-between">
          <label class="flex cursor-pointer items-center gap-2.5 group">
            <input type="checkbox" id="remember_me" name="remember_me" value="1"
              class="h-4 w-4 rounded border-slate-300 text-primary focus:ring-2 focus:ring-primary/20 focus:ring-offset-0 transition">
            <span class="text-sm text-slate-600 group-hover:text-slate-800 transition">Se souvenir de moi</span>
          </label>
          <a href="/AfricEduc/public/index.php?url=password&action=forgot" class="whitespace-nowrap text-sm font-medium text-primary transition hover:text-primary/80 hover:underline underline-offset-4">
            Mot de passe oublié ?
          </a>
        </div>

        <!-- Bouton -->
        <button type="submit" id="submit-btn"
          class="inline-flex w-full max-w-md min-h-[52px] items-center justify-center gap-2 rounded-xl bg-primary px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-primary/25 transition hover:bg-primary/90 hover:shadow-primary/35 disabled:cursor-not-allowed disabled:opacity-60">
          <span id="btn-label">Se connecter</span>
          <svg id="btn-spinner" class="hidden h-5 w-5 spinner text-white" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" class="opacity-25" />
            <path fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4Z" class="opacity-90" />
          </svg>
        </button>
        
        <!-- Lien retour -->
        <p class="mt-8 text-center">
          <a href="/AfricEduc/index.php" class="inline-flex text-center items-center gap-2 text-sm font-semibold text-primary transition hover:text-emerald-800">
            <span aria-hidden="true">←</span>
            Retournez à l'accueil
          </a>
        </p>
      </form>
    </div>
  </div>

  <?php if (!empty($flash)) : ?>
  <div id="flash"
       class="fixed top-5 left-5 z-50 bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg">
      <?= $flash ?>
  </div>
  <script>
    setTimeout(() => {
      const el = document.getElementById('flash');
      if (el) {
        el.style.opacity = "0";
        setTimeout(() => el.remove(), 500);
      }
    }, 2500);
  </script>
  <?php endif; ?>

  <script>
    (function () {
      const form = document.getElementById("login-form");
      const submitBtn = document.getElementById("submit-btn");
      const btnLabel = document.getElementById("btn-label");
      const btnSpinner = document.getElementById("btn-spinner");

      const password = document.getElementById("password");
      const togglePwd = document.getElementById("toggle-password");
      const iconEye = document.getElementById("icon-eye");
      const iconEyeOff = document.getElementById("icon-eye-off");

      let isSubmitting = false;

      togglePwd.addEventListener("click", function () {
        password.type = password.type === "password" ? "text" : "password";
        const isText = password.type === "text";
        togglePwd.setAttribute("aria-pressed", isText);
        togglePwd.setAttribute("aria-label", isText ? "Masquer le mot de passe" : "Afficher le mot de passe");
        iconEye.classList.toggle("hidden", isText);
        iconEyeOff.classList.toggle("hidden", !isText);
      });

      form.addEventListener("submit", function (e) {
        const email = document.getElementById("email").value.trim();
        const pwd = password.value.trim();

        if (!email || !pwd) {
          e.preventDefault();
          return;
        }

        if (isSubmitting) return;

        isSubmitting = true;
        submitBtn.disabled = true;
        btnLabel.textContent = "Connexion en cours...";
        btnSpinner.classList.remove("hidden");

        setTimeout(() => form.submit(), 50);
        e.preventDefault();
      });
    })();
  </script>
</body>
</html>