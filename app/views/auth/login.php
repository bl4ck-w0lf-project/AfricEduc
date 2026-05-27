<?php
session_start();

$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];

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
    body {
      font-family: "Outfit", sans-serif;
    }
    h1, h2, h3 {
      font-family: "Quicksand", sans-serif;
    }
    .page-bg {
      background-color: #f4f4f7;
      background-image:
        radial-gradient(circle at 15% 20%, rgba(153, 251, 227, 0.45), transparent 42%),
        radial-gradient(circle at 85% 10%, rgba(115, 0, 233, 0.12), transparent 40%),
        radial-gradient(circle at 50% 100%, rgba(115, 0, 233, 0.06), transparent 50%);
    }
    .page-bg::before {
      content: "";
      position: fixed;
      inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%237300e9' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
      opacity: 0.9;
      pointer-events: none;
      z-index: 0;
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
  <div class="relative z-10 flex min-h-screen flex-col items-center justify-center px-4 py-10 sm:px-6">
    <div class="card-enter glass-card w-full max-w-md rounded-3xl p-8 sm:p-10">
      <div class="flex flex-col items-center text-center">
        <a href="#" class="inline-flex items-center gap-3">
          <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-primary/10 text-primary transition-all duration-300 group-hover:rotate-6 group-hover:bg-primary/20">
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10 text-primary transition-all duration-300 group-hover:rotate-6">
              <svg width="30px" height="30px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="none" stroke="#9600ec" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.16"></g><g id="SVGRepo_iconCarrier"> <path d="m14.25 9.25v-3.25l-6.25-3.25-6.25 3.25 6.25 3.25 3.25-1.5v3.5c0 1-1.5 2-3.25 2s-3.25-1-3.25-2v-3.5"></path> </g></svg>
            </span>
          </span>
          <span class="text-2xl font-bold tracking-tight text-slate-900">Afric<span class="text-primary">Educ</span></span>
        </a>

        <h1 class="mt-8 text-3xl font-bold text-slate-900">Bienvenue</h1>
        <p class="mt-2 max-w-sm text-sm text-slate-600 sm:text-base">
          Connectez-vous avec votre email professionnel. Un seul compte pour accéder à votre espace selon votre rôle.
        </p>
      </div>

      <form id="login-form" class="mt-8 space-y-5" method="POST" action="../../controllers/LoginController.php"  >
        <input type="hidden" name="auth_action" value="login">

        <div>
          <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
          <input type="email" id="email" name="email"  autocomplete="username"
            class="mt-1.5 w-full rounded-xl border border-slate-200/90 bg-white/80 px-4 py-3 text-slate-900 shadow-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/30
             <?= isset($errors['email']) ? 'border-red-500' : 'border-slate-200' ?>"
          value="<?= htmlspecialchars($old['email'] ?? '') ?>">
          

           <?php if (isset($errors['email'])): ?>
            <p class="text-xs text-red-500 mt-1">
              <?= htmlspecialchars($errors['email']) ?>
            </p>
          <?php endif; ?>
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-slate-700">Mot de passe</label>
          <div class="relative mt-1.5">
            <input type="password" id="password" name="password"  autocomplete="current-password"
              class="w-full rounded-xl border border-slate-200/90 bg-white/80 py-3 pl-4 pr-12 text-slate-900 shadow-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/30
               <?= isset($errors['password']) ? 'border-red-500' : 'border-slate-200' ?>">
            <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 flex w-12 items-center justify-center rounded-r-xl text-slate-500 transition hover:text-primary focus:outline-none focus-visible:ring-2 focus-visible:ring-primary/40"
              aria-label="Afficher le mot de passe" aria-pressed="false">
              <svg id="icon-eye" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12s-3.75 6.75-9.75 6.75S2.25 12 2.25 12Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
              </svg>
              <svg id="icon-eye-off" class="hidden h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M9.88 9.88A3 3 0 1 0 14.12 14.12" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.34 6.34C4.18 7.68 2.25 12 2.25 12s3.75 6.75 9.75 6.75c1.56 0 2.97-.42 4.2-1.1M10.73 5.08A9.3 9.3 0 0 1 12 4.5c6 0 9.75 6.75 9.75 6.75s-.98 1.76-2.7 3.47" />
              </svg>
            </button>
          </div>

          <?php if (isset($errors['password'])): ?>
            <p class="text-xs text-red-500 mt-1">
              <?= htmlspecialchars($errors['password']) ?>
            </p>
          <?php endif; ?>
          
        </div>

        <div class="flex items-center justify-between gap-3">
          <label class="flex cursor-pointer items-center gap-2">
            <input type="checkbox" id="remember_me" name="remember_me" value="1"
              class="h-4 w-4 rounded border-slate-300 text-primary focus:ring-primary">
            <span class="text-sm text-slate-700">Se souvenir de moi</span>
          </label>
          <a href="forgot_password.php" class="text-sm font-semibold text-primary underline decoration-primary/30 underline-offset-4 transition hover:decoration-primary">
            Mot de passe oublié ?
          </a>
        </div>

        

        <button type="submit" id="submit-btn"
          class="inline-flex w-full min-h-[48px] items-center justify-center gap-2 rounded-xl bg-primary px-6 py-3 text-sm font-semibold text-white shadow-glow transition hover:bg-violet-800 disabled:cursor-not-allowed disabled:opacity-60">
          <span id="btn-label">Se connecter</span>
          <svg id="btn-spinner" class="hidden h-5 w-5 spinner text-white" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" class="opacity-25" />
            <path fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4Z" class="opacity-90" />
          </svg>
        </button>
      </form>

      <p class="mt-8 text-center">
        <a href="../index.php" class="inline-flex items-center gap-2 text-sm font-semibold text-primary transition hover:text-violet-800">
          <span aria-hidden="true">←</span>
          Retournez à l'accueil
        </a>
      </p>
    </div>
  </div>

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

  // ────────────────
  // PASSWORD TOGGLE 
  // ────────────────
  togglePwd.addEventListener("click", function () {
    password.type = password.type === "password" ? "text" : "password";
    const isText = password.type === "text";
    togglePwd.setAttribute("aria-pressed", isText);
    togglePwd.setAttribute("aria-label", isText ? "Masquer le mot de passe" : "Afficher le mot de passe");
    iconEye.classList.toggle("hidden", isText);
    iconEyeOff.classList.toggle("hidden", !isText);
  });

  // ────────────────
  // SPINNER DURANT SUBMIT ⏳
  // ────────────────
  fform.addEventListener("submit", function (e) {
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

  // ⚡ petite astuce pour voir le spinner avant que le submit HTML classique se fasse
  setTimeout(() => form.submit(), 50);
  e.preventDefault();
});
})();
</script>
</body>
</html>
