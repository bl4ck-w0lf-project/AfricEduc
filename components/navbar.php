<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EduManager | Gestion scolaire moderne</title>
  <meta name="description" content="EduManager, la solution SaaS de gestion scolaire pour les collèges et universités du Bénin et d'Afrique de l'Ouest.">

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
    html {
      scroll-behavior: smooth;
    }
    body {
      font-family: "Outfit", sans-serif;
    }
    h1, h2, h3, h4 {
      font-family: "Quicksand", sans-serif;
    }
    .fade-in {
      opacity: 0;
      transform: translateY(24px);
      transition: opacity 700ms ease, transform 700ms ease;
    }
    .fade-in.is-visible {
      opacity: 1;
      transform: translateY(0);
    }
    
    .nav-link {
            position: relative;
        }
        
        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: #9600ec;
            transition: width 0.3s ease;
        }
        
        .nav-link:hover:after {
            width: 100%;
        }
  </style>
  <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.9.10/dist/dotlottie-wc.js" type="module"></script>
</head>
<body class="bg-white text-slate-800 antialiased">
  <header class="fixed left-0 right-0 top-0 z-50 border-b border-violet-100/70 bg-white/85 backdrop-blur-md">
    <nav class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
      <a href="index.html" class="group inline-flex items-center gap-3">
        <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10 text-primary transition group-hover:rotate-6">
          <svg width="30px" height="30px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="none" stroke="#9600ec" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.16"></g><g id="SVGRepo_iconCarrier"> <path d="m14.25 9.25v-3.25l-6.25-3.25-6.25 3.25 6.25 3.25 3.25-1.5v3.5c0 1-1.5 2-3.25 2s-3.25-1-3.25-2v-3.5"></path> </g></svg>
        </span>
        <span class="text-xl font-bold tracking-tight text-slate-900">Edu<span class="text-primary">Manager</span></span>
      </a>

      <!-- Menu desktop -->
      <div class="hidden md:flex items-center gap-x-8 text-sm font-medium">
        <a href="#features" class="nav-link text-gray-600 hover:text-gray-900">Fonctionnalités</a>
        <a href="#whom" class="nav-link text-gray-600 hover:text-gray-900">Pour qui ?</a>
        <a href="#testimonies" class="nav-link text-gray-600 hover:text-gray-900">Avis</a>
      </div>

      <!-- Bouton Se connecter desktop -->
      <a href="choose_type.html" class="hidden md:flex rounded-full items-center gap-1 border border-primary/20 px-5 py-2 text-sm font-semibold text-primary transition hover:border-primary hover:bg-primary hover:text-white">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mr-1">
          <path d="M15 9L20 12L15 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M20 12H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
          <path d="M12 5H8C6.89543 5 6 5.89543 6 7V17C6 18.1046 6.89543 19 8 19H12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
       S'inscrire
      </a>

      <!-- Bouton hamburger mobile -->
      <button id="menu-btn" class="md:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition">
        <svg id="menu-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="3" y1="12" x2="21" y2="12"></line>
          <line x1="3" y1="6" x2="21" y2="6"></line>
          <line x1="3" y1="18" x2="21" y2="18"></line>
        </svg>
      </button>
    </nav>

    <!-- Menu mobile (caché par défaut) -->
    <div id="mobile-menu" class="hidden md:hidden bg-white/95 backdrop-blur-md border-t border-violet-100/70 py-4 px-4 shadow-lg">
      <div class="flex flex-col space-y-4">
        <a href="#features" class="nav-link text-gray-600 hover:text-gray-900 py-2 text-sm font-medium">Fonctionnalités</a>
        <a href="#whom" class="nav-link text-gray-600 hover:text-gray-900 py-2 text-sm font-medium">Pour qui ?</a>
        <a href="#testimonies" class="nav-link text-gray-600 hover:text-gray-900 py-2 text-sm font-medium">Avis</a>
        <div class="pt-3 border-t border-gray-100">
          <a href="choose_type.html" class="inline-flex items-center justify-center w-full rounded-full border border-primary/20 px-5 py-2.5 text-sm font-semibold text-primary transition hover:border-primary hover:bg-primary hover:text-white">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mr-2">
              <path d="M15 9L20 12L15 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M20 12H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
              <path d="M12 5H8C6.89543 5 6 5.89543 6 7V17C6 18.1046 6.89543 19 8 19H12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            Se connecter
          </a>
        </div>
      </div>
    </div>
  </header>
  <script>
    // Menu hamburger mobile
    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');

    if (menuBtn && mobileMenu) {
      menuBtn.addEventListener('click', function() {
        mobileMenu.classList.toggle('hidden');
        
        // Changer l'icône (optionnel)
        if (!mobileMenu.classList.contains('hidden')) {
          menuIcon.innerHTML = '<line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line>';
        } else {
          menuIcon.innerHTML = '<line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line>';
        }
      });
    }

    (function () {
      const fadeElements = document.querySelectorAll(".fade-in");
      const revealOnScroll = new IntersectionObserver(
        (entries, observer) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              entry.target.classList.add("is-visible");
              observer.unobserve(entry.target);
            }
          });
        },
        { threshold: 0.16 }
      );
      fadeElements.forEach((el) => revealOnScroll.observe(el));

  </script>
</body>
</html>
