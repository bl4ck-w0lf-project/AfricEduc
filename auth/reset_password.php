<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nouveau mot de passe | AfricEduc</title>
  <meta name="description" content="Définissez un nouveau mot de passe sécurisé pour votre compte AfricEduc.">

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
    .rule-ok {
      color: rgb(22 101 52);
    }
    .rule-pending {
      color: rgb(100 116 139);
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

        

        <h1 class="mt-5 text-2xl font-bold text-slate-900 sm:text-3xl">Nouveau mot de passe</h1>
        <p class="mt-2 max-w-sm text-sm text-slate-600 sm:text-base">
          Choisissez un mot de passe robuste. Il sera chiffré côté serveur avant d’être enregistré.
        </p>
      </div>

      <div id="token-banner" class="mt-6 hidden rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-left text-sm text-amber-900">
        <p>Lien incomplet ou expiré : aucun jeton de réinitialisation n’a été trouvé dans l’URL.</p>
        <a href="forgot_password.html" class="mt-1 inline-block font-semibold text-primary underline">Demander un nouveau lien</a>
      </div>

      <div id="form-block" class="mt-8">
        <form id="reset-form" class="space-y-5" novalidate>
          <input type="hidden" name="auth_action" value="reset_password">
          <input type="hidden" name="token" id="token" value="">

          <div>
            <label for="password" class="block text-sm font-medium text-slate-700">Nouveau mot de passe</label>
            <div class="relative mt-1.5">
              <input type="password" id="password" name="password" required autocomplete="new-password" minlength="8"
                class="w-full rounded-xl border border-slate-200/90 bg-white/80 py-3 pl-4 pr-12 text-slate-900 shadow-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/30">
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

            <div class="mt-3 space-y-2">
              <div class="flex items-center justify-between gap-2 text-xs font-medium">
                <span class="text-slate-500">Force du mot de passe</span>
                <span id="strength-label" class="text-slate-500">—</span>
              </div>
              <div class="h-2 overflow-hidden rounded-full bg-slate-200">
                <div id="strength-bar" class="h-full w-0 rounded-full transition-all duration-300 ease-out"></div>
              </div>
            </div>

            <ul class="mt-3 space-y-2 text-sm" aria-label="Règles du mot de passe">
              <li id="rule-len" class="rule-pending flex items-start gap-2">
                <svg class="mt-0.5 h-4 w-4 shrink-0 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                  <circle cx="12" cy="12" r="9" />
                </svg>
                <span>Au moins 8 caractères</span>
              </li>
              <li id="rule-upper" class="rule-pending flex items-start gap-2">
                <svg class="mt-0.5 h-4 w-4 shrink-0 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                  <circle cx="12" cy="12" r="9" />
                </svg>
                <span>Au moins une majuscule</span>
              </li>
              <li id="rule-digit" class="rule-pending flex items-start gap-2">
                <svg class="mt-0.5 h-4 w-4 shrink-0 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                  <circle cx="12" cy="12" r="9" />
                </svg>
                <span>Au moins un chiffre</span>
              </li>
            </ul>

            <p class="field-error mt-1.5 text-sm text-red-600" id="err-password" role="alert"></p>
          </div>

          <div>
            <label for="password_confirm" class="block text-sm font-medium text-slate-700">Confirmer le mot de passe</label>
            <div class="relative mt-1.5">
              <input type="password" id="password_confirm" name="password_confirm" required autocomplete="new-password"
                class="w-full rounded-xl border border-slate-200/90 bg-white/80 py-3 pl-4 pr-12 text-slate-900 shadow-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/30">
              <button type="button" id="toggle-password-confirm" class="absolute inset-y-0 right-0 flex w-12 items-center justify-center rounded-r-xl text-slate-500 transition hover:text-primary focus:outline-none focus-visible:ring-2 focus-visible:ring-primary/40"
                aria-label="Afficher la confirmation du mot de passe" aria-pressed="false">
                <svg id="icon-eye-c" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12s-3.75 6.75-9.75 6.75S2.25 12 2.25 12Z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                </svg>
                <svg id="icon-eye-off-c" class="hidden h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M9.88 9.88A3 3 0 1 0 14.12 14.12" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6.34 6.34C4.18 7.68 2.25 12 2.25 12s3.75 6.75 9.75 6.75c1.56 0 2.97-.42 4.2-1.1M10.73 5.08A9.3 9.3 0 0 1 12 4.5c6 0 9.75 6.75 9.75 6.75s-.98 1.76-2.7 3.47" />
                </svg>
              </button>
            </div>
            <p class="field-error mt-1.5 text-sm text-red-600" id="err-password_confirm" role="alert"></p>
          </div>

          <p id="form-global-error" class="hidden rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert"></p>

          <button type="submit" id="submit-btn"
            class="inline-flex w-full min-h-[48px] items-center justify-center gap-2 rounded-xl bg-primary px-6 py-3 text-sm font-semibold text-white shadow-glow transition hover:bg-violet-800 disabled:cursor-not-allowed disabled:opacity-60">
            <span id="btn-label">Réinitialiser</span>
            <svg id="btn-spinner" class="hidden h-5 w-5 spinner text-white" viewBox="0 0 24 24" fill="none" aria-hidden="true">
              <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" class="opacity-25" />
              <path fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4Z" class="opacity-90" />
            </svg>
          </button>
        </form>
      </div>

      <div id="success-block" class="mt-8 hidden text-center" role="status" aria-live="polite">
        <div class="rounded-2xl border border-accent/50 bg-accent/25 px-4 py-6 text-slate-800">
          <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-primary/15 text-primary">
            <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75 9 17.25 20.25 6" />
            </svg>
          </div>
          <p class="text-base font-semibold text-slate-900">Mot de passe mis à jour</p>
          <p class="mt-2 text-sm text-slate-600">Vous pouvez maintenant vous connecter avec votre nouveau mot de passe.</p>
          <a href="login.html" class="mt-5 inline-flex min-h-[44px] items-center justify-center rounded-xl bg-primary px-6 py-2.5 text-sm font-semibold text-white shadow-glow transition hover:bg-violet-800">
            Aller à la connexion
          </a>
        </div>
      </div>

      <p class="mt-8 text-center">
        <a href="login.html" class="inline-flex items-center gap-2 text-sm font-semibold text-primary transition hover:text-violet-800">
          <span aria-hidden="true">←</span>
          Retour à la connexion
        </a>
      </p>
    </div>
  </div>

  <script>
    (function () {
      var API_URL = "app/controllers/AuthController.php";

      var form = document.getElementById("reset-form");
      var formBlock = document.getElementById("form-block");
      var successBlock = document.getElementById("success-block");
      var tokenInput = document.getElementById("token");
      var tokenBanner = document.getElementById("token-banner");
      var submitBtn = document.getElementById("submit-btn");
      var btnLabel = document.getElementById("btn-label");
      var btnSpinner = document.getElementById("btn-spinner");
      var globalErr = document.getElementById("form-global-error");
      var pwdInput = document.getElementById("password");
      var pwdConfirm = document.getElementById("password_confirm");
      var strengthBar = document.getElementById("strength-bar");
      var strengthLabel = document.getElementById("strength-label");

      function getTokenFromUrl() {
        var p = new URLSearchParams(window.location.search);
        var t = p.get("token");
        return t && String(t).trim() ? String(t).trim() : "";
      }

      function wireToggle(btnId, inputId, eyeId, eyeOffId) {
        var btn = document.getElementById(btnId);
        var input = document.getElementById(inputId);
        var iconEye = document.getElementById(eyeId);
        var iconEyeOff = document.getElementById(eyeOffId);
        btn.addEventListener("click", function () {
          input.type = input.type === "password" ? "text" : "password";
          var plain = input.type === "text";
          btn.setAttribute("aria-pressed", plain ? "true" : "false");
          iconEye.classList.toggle("hidden", plain);
          iconEyeOff.classList.toggle("hidden", !plain);
        });
      }

      wireToggle("toggle-password", "password", "icon-eye", "icon-eye-off");
      wireToggle("toggle-password-confirm", "password_confirm", "icon-eye-c", "icon-eye-off-c");

      function checkRules(pwd) {
        return {
          len: pwd.length >= 8,
          upper: /[A-Z]/.test(pwd),
          digit: /\d/.test(pwd)
        };
      }

      function updateRuleRow(id, ok) {
        var row = document.getElementById(id);
        if (!row) return;
        var icon = row.querySelector("svg");
        row.classList.toggle("rule-ok", ok);
        row.classList.toggle("rule-pending", !ok);
        if (icon) {
          icon.innerHTML = ok
            ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 12.75 9 17.25 20.25 6" />'
            : '<circle cx="12" cy="12" r="9" stroke-width="2" />';
          icon.setAttribute("class", "mt-0.5 h-4 w-4 shrink-0 " + (ok ? "text-green-600" : "text-slate-400"));
        }
      }

      function updateStrength() {
        var pwd = pwdInput.value || "";
        var r = checkRules(pwd);
        var met = (r.len ? 1 : 0) + (r.upper ? 1 : 0) + (r.digit ? 1 : 0);

        updateRuleRow("rule-len", r.len);
        updateRuleRow("rule-upper", r.upper);
        updateRuleRow("rule-digit", r.digit);

        var level = "weak";
        var label = "Faible";
        var pct = 33;
        var color = "rgb(239 68 68)";
        var labelClass = "text-xs font-semibold text-red-600";

        if (pwd.length === 0) {
          label = "—";
          pct = 0;
          color = "rgb(226 232 240)";
          labelClass = "text-xs font-semibold text-slate-500";
        } else if (met === 0) {
          label = "Faible";
          pct = 33;
          color = "rgb(239 68 68)";
          labelClass = "text-xs font-semibold text-red-600";
        } else if (met === 1) {
          level = "weak";
          label = "Faible";
          pct = 33;
          color = "rgb(239 68 68)";
          labelClass = "text-xs font-semibold text-red-600";
        } else if (met === 2) {
          level = "medium";
          label = "Moyen";
          pct = 66;
          color = "rgb(249 115 22)";
          labelClass = "text-xs font-semibold text-orange-600";
        } else {
          level = "strong";
          label = "Fort";
          pct = 100;
          color = "rgb(22 163 74)";
          labelClass = "text-xs font-semibold text-green-700";
        }

        strengthLabel.textContent = label;
        strengthLabel.className = labelClass;
        strengthBar.style.width = pct + "%";
        strengthBar.style.backgroundColor = color;
      }

      pwdInput.addEventListener("input", updateStrength);
      updateStrength();

      function setFieldError(id, message) {
        var err = document.getElementById("err-" + id);
        var input = document.getElementById(id);
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

      function clearErrors() {
        setFieldError("password", "");
        setFieldError("password_confirm", "");
        globalErr.classList.add("hidden");
        globalErr.textContent = "";
      }

      function validateForm() {
        var errors = {};
        var pwd = pwdInput.value || "";
        var r = checkRules(pwd);
        var pc = pwdConfirm.value || "";

        if (!r.len) errors.password = "Le mot de passe doit contenir au moins 8 caractères.";
        else if (!r.upper) errors.password = "Ajoutez au moins une majuscule.";
        else if (!r.digit) errors.password = "Ajoutez au moins un chiffre.";

        if (!pc) errors.password_confirm = "Confirmez votre mot de passe.";
        else if (pwd !== pc) errors.password_confirm = "Les mots de passe ne correspondent pas.";

        return errors;
      }

      var token = getTokenFromUrl();
      if (!token) {
        tokenBanner.classList.remove("hidden");
        submitBtn.disabled = true;
        pwdInput.disabled = true;
        pwdConfirm.disabled = true;
        document.getElementById("toggle-password").disabled = true;
        document.getElementById("toggle-password-confirm").disabled = true;
      } else {
        tokenInput.value = token;
      }

      form.addEventListener("submit", function (ev) {
        ev.preventDefault();
        clearErrors();

        if (!token) {
          globalErr.textContent = "Jeton manquant. Utilisez le lien reçu par email.";
          globalErr.classList.remove("hidden");
          return;
        }

        var errors = validateForm();
        if (Object.keys(errors).length > 0) {
          Object.keys(errors).forEach(function (k) {
            setFieldError(k, errors[k]);
          });
          return;
        }

        submitBtn.disabled = true;
        btnLabel.textContent = "Enregistrement…";
        btnSpinner.classList.remove("hidden");

        var fd = new FormData(form);
        fd.delete("password_confirm");

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
            btnLabel.textContent = "Réinitialiser";
            submitBtn.disabled = false;

            var data = result.data || {};
            if (result.ok && (data.success === true || data.success === "true")) {
              formBlock.classList.add("hidden");
              successBlock.classList.remove("hidden");
              return;
            }

            var msg = data.message || data.error || "Impossible de réinitialiser le mot de passe. Le lien est peut-être expiré.";
            globalErr.textContent = msg;
            globalErr.classList.remove("hidden");
          })
          .catch(function () {
            btnSpinner.classList.add("hidden");
            btnLabel.textContent = "Réinitialiser";
            submitBtn.disabled = false;
            globalErr.textContent = "Impossible de joindre le serveur. Vérifiez votre connexion.";
            globalErr.classList.remove("hidden");
          });
      });
    })();
  </script>
</body>
</html>
