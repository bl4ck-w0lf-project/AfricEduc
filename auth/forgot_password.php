<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mot de passe oublié | AfricEduc</title>
  <meta name="description" content="Recevez un lien sécurisé pour réinitialiser votre mot de passe AfricEduc.">

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
        <a href="index.html" class="inline-flex items-center gap-3">
          <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-primary/10 text-primary transition-all duration-300 group-hover:rotate-6 group-hover:bg-primary/20">
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10 text-primary transition-all duration-300 group-hover:rotate-6">
              <svg width="30px" height="30px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="none" stroke="#9600ec" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.16"></g><g id="SVGRepo_iconCarrier"> <path d="m14.25 9.25v-3.25l-6.25-3.25-6.25 3.25 6.25 3.25 3.25-1.5v3.5c0 1-1.5 2-3.25 2s-3.25-1-3.25-2v-3.5"></path> </g></svg>
            </span>
          </span>
          <span class="text-2xl font-bold tracking-tight text-slate-900">Afric<span class="text-primary">Educ</span></span>
        </a>

        

        <h1 class="mt-6 text-2xl font-bold text-slate-900 sm:text-3xl">Mot de passe oublié ?</h1>
        <p class="mt-3 max-w-sm text-sm leading-relaxed text-slate-600 sm:text-base">
          Saisissez l’adresse email associée à votre compte. Nous vous enverrons un lien pour choisir un nouveau mot de passe. Ce lien est valable <strong class="font-semibold text-slate-800">1 heure</strong> et mène vers une page sécurisée.
        </p>
      </div>

      <div id="form-block" class="mt-8">
        <form id="forgot-form" class="space-y-5" novalidate>
          <div>
            <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
            <input type="email" id="email" name="email" required autocomplete="email"
              class="mt-1.5 w-full rounded-xl border border-slate-200/90 bg-white/80 px-4 py-3 text-slate-900 shadow-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/30">
            <p class="field-error mt-1.5 text-sm text-red-600" id="err-email" role="alert"></p>
          </div>

          <p id="form-global-error" class="hidden rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert"></p>

          <button type="submit" id="submit-btn"
            class="inline-flex w-full min-h-[48px] items-center justify-center gap-2 rounded-xl bg-primary px-6 py-3 text-sm font-semibold text-white shadow-glow transition hover:bg-violet-800 disabled:cursor-not-allowed disabled:opacity-60">
            <span id="btn-label">Envoyer le lien</span>
            <svg id="btn-spinner" class="hidden h-5 w-5 spinner text-white" viewBox="0 0 24 24" fill="none" aria-hidden="true">
              <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" class="opacity-25" />
              <path fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4Z" class="opacity-90" />
            </svg>
          </button>
        </form>
      </div>

      <div id="success-block" class="mt-8 hidden text-center" role="status" aria-live="polite">
        <div class="rounded-2xl border border-accent/50 bg-accent/25 px-4 py-5 text-slate-800">
          <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-primary/15 text-primary">
            <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75 9 17.25 20.25 6" />
            </svg>
          </div>
          <p class="text-base font-semibold text-slate-900">Un email a été envoyé à votre adresse.</p>
          <p class="mt-2 text-sm text-slate-600">
            Consultez votre boîte de réception (et les courriers indésirables). Le lien expire dans une heure.
          </p>
        </div>
      </div>

      <p class="mt-8 text-center">
        <a href="login.php" class="inline-flex items-center gap-2 text-sm font-semibold text-primary transition hover:text-violet-800">
          <span aria-hidden="true">←</span>
          Retour à la connexion
        </a>
      </p>
    </div>
  </div>

  <script>
    (function () {
      var API_URL = "app/controllers/AuthController.php?action=forgot";

      var form = document.getElementById("forgot-form");
      var formBlock = document.getElementById("form-block");
      var successBlock = document.getElementById("success-block");
      var submitBtn = document.getElementById("submit-btn");
      var btnLabel = document.getElementById("btn-label");
      var btnSpinner = document.getElementById("btn-spinner");
      var globalErr = document.getElementById("form-global-error");

      function setFieldError(message) {
        var err = document.getElementById("err-email");
        var input = document.getElementById("email");
        if (!err) return;
        if (message) {
          err.textContent = message;
          err.classList.add("is-visible");
          if (input) input.classList.add("input-invalid");
        } else {
          err.textContent = "";
          err.classList.remove("is-visible");
          if (input) input.classList.remove("input-invalid");
        }
      }

      function isValidEmail(value) {
        return value && /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(String(value).trim());
      }

      form.addEventListener("submit", function (ev) {
        ev.preventDefault();
        globalErr.classList.add("hidden");
        globalErr.textContent = "";

        var email = (document.getElementById("email").value || "").trim();
        if (!email) {
          setFieldError("L'email est obligatoire.");
          return;
        }
        if (!isValidEmail(email)) {
          setFieldError("Adresse email invalide.");
          return;
        }
        setFieldError("");

        submitBtn.disabled = true;
        btnLabel.textContent = "Envoi en cours…";
        btnSpinner.classList.remove("hidden");

        var fd = new FormData();
        fd.append("email", email);

        fetch(API_URL, {
          method: "POST",
          body: fd,
          headers: { Accept: "application/json" },
          credentials: "same-origin"
        })
          .then(function (res) {
            var ct = res.headers.get("content-type") || "";
            if (ct.indexOf("application/json") !== -1) {
              return res.json().then(function (data) {
                return { ok: res.ok, data: data };
              });
            }
            return res.text().then(function (text) {
              return { ok: res.ok, data: { message: text } };
            });
          })
          .then(function (result) {
            btnSpinner.classList.add("hidden");
            btnLabel.textContent = "Envoyer le lien";
            submitBtn.disabled = false;

            var data = result.data || {};
            if (result.ok && (data.success === true || data.success === "true")) {
              formBlock.classList.add("hidden");
              successBlock.classList.remove("hidden");
              return;
            }

            var msg = data.message || data.error || "Impossible d'envoyer l'email. Réessayez plus tard.";
            globalErr.textContent = msg;
            globalErr.classList.remove("hidden");
          })
          .catch(function () {
            btnSpinner.classList.add("hidden");
            btnLabel.textContent = "Envoyer le lien";
            submitBtn.disabled = false;
            globalErr.textContent = "Impossible de joindre le serveur. Vérifiez votre connexion.";
            globalErr.classList.remove("hidden");
          });
      });
    })();
  </script>
</body>
</html>
