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
<body class="bg-white text-slate-800 antialiased">
  

  <footer class="bg-white border-t border-[#7300e9]/10 pt-12 pb-6">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      
      <!-- Grille principale du footer -->
      <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-5">
        
        <!-- Colonne 1 : Logo + description -->
        <div class="lg:col-span-2">
          <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10 text-primary transition group-hover:rotate-6">
            <svg width="30px" height="30px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="none" stroke="#9600ec" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.16"></g><g id="SVGRepo_iconCarrier"> <path d="m14.25 9.25v-3.25l-6.25-3.25-6.25 3.25 6.25 3.25 3.25-1.5v3.5c0 1-1.5 2-3.25 2s-3.25-1-3.25-2v-3.5"></path> </g></svg>
          </span>
          <span class="text-xl mx-2 font-bold tracking-tight text-slate-900">Edu<span class="text-primary">Manager</span></span>
          <p class="text-gray-500 text-sm leading-relaxed mb-4 max-w-sm">
            La solution complète de gestion scolaire pour les collèges et universités d'Afrique de l'Ouest. Simple, puissante et sécurisée.
          </p>
          
        </div>
  
        <!-- Colonne 2 : Produit -->
        <div>
          <h3 class="font-title font-semibold text-gray-800 mb-4">Produit</h3>
          <ul class="space-y-2 text-sm">
            <li><a href="#features" class="text-gray-500 hover:text-[#7300e9] transition">Fonctionnalités</a></li>
            <li><a href="#whom" class="text-gray-500 hover:text-[#7300e9] transition">Par qui ?</a></li>
            <li><a href="#testimonies" class="text-gray-500 hover:text-[#7300e9] transition">Avis</a></li>
            <li><a href="choose_type.html" class="text-gray-500 hover:text-[#7300e9] transition">Démo gratuite</a></li>
            
          </ul>
        </div>
  
        <!-- Colonne 3 : Support -->
        <div>
          <h3 class="font-title font-semibold text-gray-800 mb-4">Support</h3>
          <ul class="space-y-2 text-sm">
            <li><a href="#" class="text-gray-500 hover:text-[#7300e9] transition">Centre d'aide</a></li>
            <li><a href="#" class="text-gray-500 hover:text-[#7300e9] transition">Documentation</a></li>
            <li><a href="#" class="text-gray-500 hover:text-[#7300e9] transition">API références</a></li>
            <li><a href="#" class="text-gray-500 hover:text-[#7300e9] transition">Contactez-nous</a></li>
            <li><a href="#" class="text-gray-500 hover:text-[#7300e9] transition">Statut du service</a></li>
          </ul>
        </div>
  
        <!-- Colonne 4 : Légal & Contact -->
        <div>
          <h3 class="font-title font-semibold text-gray-800 mb-4">Légal</h3>
          <ul class="space-y-2 text-sm">
            <li><a href="#" class="text-gray-500 hover:text-[#7300e9] transition">Conditions générales</a></li>
            <li><a href="#" class="text-gray-500 hover:text-[#7300e9] transition">Politique de confidentialité</a></li>
            <li><a href="#" class="text-gray-500 hover:text-[#7300e9] transition">Mentions légales</a></li>
            <li><a href="#" class="text-gray-500 hover:text-[#7300e9] transition">Cookies</a></li>
          </ul>
          
        </div>
      </div>
  
      <!-- Séparateur -->
      <div class="border-t border-gray-100 my-8"></div>
  
      <!-- Bas de footer : copyright + crédit Ricardo -->
      <div class="flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-gray-400">
        <div class="flex flex-wrap gap-4 justify-center">
          <span>&copy; 2026 EduManager. Tous droits réservés.</span>
          
        </div>
        <div class="text-center sm:text-right">
          Créé par 
          <a href="https://hounmenou-ricardo.vercel.app/" target="_blank" rel="noopener noreferrer" class="text-[#7300e9] hover:text-[#5a00b8] hover:underline font-medium transition">
            Ricardo
          </a>
        </div>
      </div>  
    </div>
  </footer>

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
