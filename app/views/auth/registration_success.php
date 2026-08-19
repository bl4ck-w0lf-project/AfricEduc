<?php 
session_start();

$success = $_SESSION['success'] ?? null;
$mailError = $_SESSION['mail_error'] ?? null;
$registeredEmail = $_SESSION['registered_email'] ?? null;
$adminNotified = $_SESSION['admin_notified'] ?? false;

unset($_SESSION['success'], $_SESSION['mail_error'], $_SESSION['registered_email'], $_SESSION['admin_notified']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription réussie | AfricEduc</title>
  <meta name="description" content="Votre inscription sur AfricEduc a été prise en compte.">

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

    .status-icon {
      animation: pulse 2s ease-in-out infinite;
    }
    @keyframes pulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.05); }
    }
  </style>
</head>
<body class="page-bg min-h-screen antialiased text-slate-800">
  <div class="relative z-10 min-h-screen lg:grid lg:grid-cols-2">

    <!-- Colonne gauche - SVG + cercles verts -->
    <aside class="relative hidden min-h-[280px] flex-col justify-between overflow-hidden p-8 lg:flex lg:min-h-screen lg:p-12 xl:p-16" style="background-image: linear-gradient(135deg, rgba(15,157,114,0.9) 0%, rgba(11,122,88,0.9) 50%, rgba(10,46,31,0.95) 100%), url('/AfricEduc/public/college-admission-rafiki.svg'); background-size: cover; background-position: center; background-blend-mode: overlay;">  
      <!-- Cercles décoratifs verts -->
      <div class="absolute top-20 right-20 w-64 h-64 bg-[#00ffb3]/20 rounded-full blur-3xl"></div>
      <div class="absolute bottom-20 left-20 w-48 h-48 bg-[#00ffb3]/10 rounded-full blur-2xl"></div>
      <div class="absolute top-40 left-10 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>
    </aside>

    <!-- Colonne droite - Contenu -->
    <div class="flex min-h-screen flex-col justify-center px-6 py-8 sm:px-10 md:px-14 lg:px-20 xl:px-24">

      <!-- Logo -->
      <a href="#" class="">
        <img src="/AfricEduc/public/logo.png" alt="AfricEduc" class="h-[100px] w-auto mx-auto">
      </a>

      <!-- Status icon -->
      <div class="status-icon mx-auto mt-6 flex h-16 w-16 items-center justify-center rounded-full <?php echo $mailError ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600'; ?> text-3xl">
        <?php echo $mailError ? '<i class="fa-solid fa-xmark"></i>' : '<i class="fa-solid fa-check"></i>'; ?>
      </div>

      <h1 class="mt-4 text-3xl font-bold text-slate-900 mx-auto text-center">
        <?php echo $mailError ? "Compte créé mais email non envoyé !" : "Inscription en attente de validation !!"; ?>
      </h1>

      <p class="mt-4 max-w-sm text-sm text-slate-600 sm:text-base mx-auto text-center leading-relaxed">
        <?php 
          if ($mailError) {
            echo "Nous n'avons pas pu envoyer l'email de confirmation à <strong class='text-primary'>{$registeredEmail}</strong>.<br>";
            echo "Erreur: {$mailError}";
          } else {
            echo "Un email de confirmation a été envoyé à <strong class='text-primary'>{$registeredEmail}</strong>.<br><br>";
            echo "<strong>Étapes à suivre :</strong><br>";
            echo "1. Vérifiez votre boîte email et cliquez sur le lien de confirmation.<br>";
            echo "2. Votre compte sera ensuite examiné par l'administrateur.<br>";
            echo "3. Vous recevrez une notification dès que votre compte sera activé.";
          }
        ?>
      </p>

      <?php if ($adminNotified && !$mailError): ?>
        <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg mx-auto max-w-sm">
          <p class="text-xs text-blue-700 flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-blue-500"></i>
            L'administrateur a été notifié de votre inscription.
          </p>
        </div>
      <?php endif; ?>

      <div class="mt-8 space-y-3 mx-auto w-full max-w-md">
        <a href="/AfricEduc/public/index.php?url=login"
           class="block w-full rounded-xl bg-primary px-6 py-3.5 text-white font-semibold text-center shadow-lg shadow-primary/25 hover:bg-primary/90 hover:shadow-primary/35 transition">
          <i class="fa-solid fa-arrow-right-to-bracket mr-2"></i>
          Aller à la connexion
        </a>
        <?php if($mailError): ?>
          <p class="text-xs text-red-500 text-center">
            Vous pouvez réessayer plus tard ou contacter l'assistance.
          </p>
        <?php else: ?>
          <p class="text-xs text-slate-500 text-center">
            Vous ne trouvez pas l'email ? Vérifiez vos spams.
          </p>
        <?php endif; ?>
      </div>

    </div>
  </div>
</body>
</html>