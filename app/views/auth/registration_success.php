<?php 
session_start();

// Récupération des messages de session
$success = $_SESSION['success'] ?? null;
$mailError = $_SESSION['mail_error'] ?? null;
$registeredEmail = $_SESSION['registered_email'] ?? null;

// On nettoie les sessions
unset($_SESSION['success'], $_SESSION['mail_error'], $_SESSION['registered_email']);
?>
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
          colors: { primary: "#7300e9", accent: "#99fbe3" },
          fontFamily: { heading: ["Quicksand", "sans-serif"], body: ["Outfit", "sans-serif"] },
          boxShadow: { glow: "0 20px 50px -20px rgba(115, 0, 233, 0.45)" }
        }
      }
    };
  </script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: "Outfit", sans-serif; }
    h1, h2, h3 { font-family: "Quicksand", sans-serif; }
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
    <a href="#" class="inline-flex items-center gap-3 mb-6">
      <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-primary/10 text-primary">
        <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10 text-primary">
          <svg width="30" height="30" viewBox="0 0 16 16" fill="none" stroke="#9600ec" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
            <path d="m14.25 9.25v-3.25l-6.25-3.25-6.25 3.25 6.25 3.25 3.25-1.5v3.5c0 1-1.5 2-3.25 2s-3.25-1-3.25-2v-3.5"/>
          </svg>
        </span>
      </span>
      <span class="text-2xl font-bold tracking-tight text-slate-900">Afric<span class="text-primary">Educ</span></span>
    </a>

    <!-- Status icon -->
    <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full <?php echo $mailError ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600'; ?> text-3xl">
      <?php echo $mailError ? '!' : '✓'; ?>
    </div>

    <h1 class="text-2xl font-bold text-slate-900 mb-2">
      <?php echo $mailError ? "Compte créé mais email non envoyé !" : "Compte créé avec succès !!"; ?>
    </h1>

    <p class="mt-4 text-slate-600 text-sm leading-relaxed">
      <?php 
        if ($mailError) {
          echo "Nous n'avons pas pu envoyer l'email de confirmation à <strong>{$registeredEmail}</strong>.<br>";
          echo "Erreur: {$mailError}";
        } else {
          echo "Un email de confirmation a été envoyé à <strong>{$registeredEmail}</strong>.<br>";
          echo "Vérifiez votre boîte mail pour activer votre compte avant de vous connecter.";
        }
      ?>
    </p>

    <div class="mt-8 space-y-3">
      <a href="login.php"
         class="block w-full rounded-xl bg-primary px-6 py-3 text-white font-semibold shadow-glow hover:bg-violet-800 transition">
        Aller à la connexion
      </a>
      <?php if($mailError): ?>
      <p class="text-xs text-red-500">
        Vous pouvez réessayer plus tard ou contacter l'assistance.
      </p>
      <?php else: ?>
      <p class="text-xs text-slate-500">
        Vous ne trouvez pas l’email ? Vérifiez vos spams.
      </p>
      <?php endif; ?>
    </div>

  </div>

</body>
</html>

