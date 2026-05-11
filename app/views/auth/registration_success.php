<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription réussie | AfricEduc</title>

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
    .glass-card {
      background: rgba(255, 255, 255, 0.75);
      border: 1px solid rgba(255, 255, 255, 0.8);
      box-shadow: 0 20px 40px -12px rgba(115, 0, 233, 0.15);
      backdrop-filter: blur(14px);
    }
  </style>
</head>

<body class="page-bg min-h-screen flex items-center justify-center px-4">

  <div class="glass-card w-full max-w-md rounded-3xl p-10 text-center">

    <!-- Logo -->
    <div class="mb-6 flex justify-center">
      <div class="h-14 w-14 rounded-2xl bg-primary/10 flex items-center justify-center">
        <span class="text-primary font-bold text-xl">AE</span>
      </div>
    </div>

    <!-- Success icon -->
    <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-green-100 text-green-600 text-3xl">
      ✓
    </div>

    <h1 class="text-2xl font-bold text-slate-900">
      Compte créé avec succès !!
    </h1>

    <p class="mt-4 text-slate-600 text-sm leading-relaxed">
      Un email de confirmation a été envoyé à votre adresse.<br>
      Vérifiez votre boîte mail pour activer votre compte avant de vous connecter.
    </p>

    <div class="mt-8 space-y-3">

      <a href="login.php"
         class="block w-full rounded-xl bg-primary px-6 py-3 text-white font-semibold shadow-glow hover:bg-violet-800 transition">
        Aller à la connexion
      </a>

      <p class="text-xs text-slate-500">
        Vous ne trouvez pas l’email ? Vérifiez vos spams.
      </p>

    </div>

  </div>

</body>
</html>

<?php unset($_SESSION['success']); ?>
