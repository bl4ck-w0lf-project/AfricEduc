
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AfricEduc | Gestion scolaire moderne</title>
  <meta name="description" content="AfricEduc, la solution SaaS de gestion scolaire pour les collèges et universités du Bénin et d'Afrique de l'Ouest.">

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
    .hero-mesh {
      background:
        
        radial-gradient(circle at 90% 15%, rgba(115, 0, 233, 0.18), transparent 45%),
        linear-gradient(135deg, #ffffff 0%, #faf5ff 52%, #f3fffc 100%);
    }
    .feature-card {
      transition: all 0.35s ease;
      background: white;
      border-radius: 2rem;
      box-shadow: 0 20px 35px -12px rgba(0,0,0,0.05);
    }
    .feature-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 30px 45px -15px rgba(115, 0, 233, 0.2);
      border-color: #7300e9;
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
        <span class="text-xl font-bold tracking-tight text-slate-900">Afric<span class="text-primary">Educ</span></span>
      </a>

      <!-- Menu desktop -->
      <div class="hidden md:flex items-center gap-x-8 text-sm font-medium">
        <a href="#features" class="nav-link text-gray-600 hover:text-gray-900">Fonctionnalités</a>
        <a href="#whom" class="nav-link text-gray-600 hover:text-gray-900">Pour qui ?</a>
        <a href="#testimonies" class="nav-link text-gray-600 hover:text-gray-900">Avis</a>
      </div>

      <!-- Bouton Se connecter desktop -->
      

      <div class="flex justify-center gap-2">
          <a href="auth/login.php" class="hidden md:flex rounded-full items-center gap-1 border border-primary/20 px-5 py-2 text-sm font-semibold text-primary transition hover:border-primary hover:bg-primary hover:text-white">
        
             Se connecter
          </a>

          <a href="auth/register.php" class="hidden md:flex rounded-full items-center gap-1 border border-primary/20 px-5 py-2 text-sm font-semibold text-primary transition hover:border-primary hover:bg-primary hover:text-white">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mr-1">
              <path d="M15 9L20 12L15 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M20 12H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
              <path d="M12 5H8C6.89543 5 6 5.89543 6 7V17C6 18.1046 6.89543 19 8 19H12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            S'inscrire
          </a>
      </div>
      

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
        <div class="pt-5 border-t border-gray-100">
          <a href="auth/login.php" class="inline-flex items-center justify-center w-full rounded-full border border-primary/20 px-5 py-2.5 my-2 text-sm font-semibold text-primary transition hover:border-primary hover:bg-primary hover:text-white">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mr-2">
              <path d="M15 9L20 12L15 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M20 12H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
              <path d="M12 5H8C6.89543 5 6 5.89543 6 7V17C6 18.1046 6.89543 19 8 19H12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            Se connecter
          </a>

          <a href="auth/register.php" class="inline-flex items-center justify-center w-full rounded-full border border-primary/20 px-5 py-2.5 my-2 text-sm font-semibold text-primary transition hover:border-primary hover:bg-primary hover:text-white">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mr-2">
              <path d="M15 9L20 12L15 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M20 12H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
              <path d="M12 5H8C6.89543 5 6 5.89543 6 7V17C6 18.1046 6.89543 19 8 19H12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            S'inscrire
          </a>
        </div>
      </div>
    </div>
  </header>

  <main class="">
    <section class="hero-mesh relative overflow-hidden pt-[150px] pb-[50px]">
      <div class="mx-auto max-w-7xl gap-10 px-4 py-15 sm:px-6 lg:px-8">
        <!-- Première div : texte -->
        <div class="fade-in mb-3 text-center">
          <div class="flex justify-center">
            <span class="text-[#7300e9] font-semibold tracking-wide uppercase text-sm bg-[#7300e9]/10 px-4 py-1.5 rounded-full inline-block">
              Une gestion administrative simplifiée !!
            </span>
          </div>
          <h1 class="mt-5 text-4xl font-bold leading-tight text-slate-900 text-center sm:text-5xl lg:text-6xl">
            Pilotez votre établissement <br> sans friction.
          </h1>
          <p class="mt-5 max-w-2xl mx-auto text-base text-slate-600 text-center sm:text-lg">
            AfricEduc centralise les élèves, notes, moyennes, paiements de scolarité et bulletins PDF dans une interface claire, pensée pour les réalités d'Afrique de l'Ouest.
          </p>
          <div class="mt-8 flex flex-col gap-3 sm:flex-row justify-center">
            <a href="auth/register.php" class="inline-flex items-center justify-center rounded-xl bg-primary px-6 py-3 text-lg font-semibold text-white shadow-glow transition hover:-translate-y-0.5 hover:bg-violet-800">
              Commencer gratuitement
            </a>
            <a href="#features" class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-6 py-3 text-lg font-semibold text-slate-700 transition hover:border-primary/30 hover:text-primary">
              Comment ça fonctionne ?
            </a>
          </div>
        </div>
    
        <!-- Deuxième div : animation -->
        <div class="fade-in p-3 sm:p-8 flex justify-center">
          <dotlottie-wc src="https://lottie.host/271ecaa2-3d0d-46c5-a2fd-24e6b3e7844b/dsOFCYq1AH.lottie" 
          style="width: 600px;height: 600px" autoplay loop></dotlottie-wc>
        </div>
      </div>
    </section>

    <!-- SECTION FEATURES -->
    <section id="features" class="py-24 px-6 bg-white">
      <div class="max-w-7xl mx-auto">
        <div class="text-center max-w-2xl mx-auto mb-16 fade-up">
          
          <span class="text-[#7300e9] font-semibold tracking-wide uppercase text-sm bg-[#7300e9]/10 px-4 py-1.5 rounded-full">Pourquoi AfricEduc ?</span>
          <h2 class="text-3xl md:text-5xl font-bold mt-5 mb-4">Une solution pensée pour l'éducation ouest-africaine</h2>
          <p class="text-gray-500 text-lg">Gagnez du temps, améliorez les résultats et centralisez toutes les données.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-8 lg:gap-12">
          <!-- Carte 1 : Gestion élèves -->
          <div class="feature-card p-8 border border-gray-100 hover:border-[#7300e9]/30 transition-all fade-up" style="transition-delay: 0s;">
            <div class="w-14 h-14 bg-[#7300e9]/10 rounded-2xl flex items-center justify-center mb-6">
              <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 12C14.2091 12 16 10.2091 16 8C16 5.79086 14.2091 4 12 4C9.79086 4 8 5.79086 8 8C8 10.2091 9.79086 12 12 12Z" stroke="#7300e9" stroke-width="1.6" stroke-linecap="round"/>
                <path d="M5 20V19C5 15.6863 7.68629 13 11 13H13C16.3137 13 19 15.6863 19 19V20" stroke="#7300e9" stroke-width="1.6" stroke-linecap="round"/>
                <circle cx="18" cy="6" r="2" stroke="#7300e9" stroke-width="1.6"/>
                <path d="M22 20V19C22 16.8 20.6 14.9 18.5 14" stroke="#7300e9" stroke-width="1.6" stroke-linecap="round"/>
              </svg>
            </div>
            <h3 class="text-2xl font-bold mb-3">Gestion élèves & inscriptions</h3>
            <p class="text-gray-600 leading-relaxed">Inscriptions simplifiées, dossiers numériques, classes, emplois du temps. Suivez chaque élève de la maternelle à l'université.</p>
            
          </div>
          <!-- Carte 2 : Notes & moyennes -->
          <div class="feature-card p-8 border border-gray-100 hover:border-[#99fbe3]/50 transition-all fade-up" style="transition-delay: 0.1s;">
            <div class="w-14 h-14 bg-[#99fbe3]/30 rounded-2xl flex items-center justify-center mb-6">
              <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 12H15" stroke="#7300e9" stroke-width="1.6" stroke-linecap="round"/>
                <path d="M12 9V15" stroke="#7300e9" stroke-width="1.6" stroke-linecap="round"/>
                <rect x="3" y="3" width="18" height="18" rx="3" stroke="#7300e9" stroke-width="1.6"/>
                <path d="M8 3V6M16 3V6" stroke="#7300e9" stroke-width="1.5" stroke-linecap="round"/>
                <path d="M3 10H21" stroke="#7300e9" stroke-width="1.4"/>
              </svg>
            </div>
            <h3 class="text-2xl font-bold mb-3">Notes, moyennes & examens</h3>
            <p class="text-gray-600 leading-relaxed">Saisie intuitive, calcul automatique des moyennes, appréciations, tableaux de performance, et génération de bulletins PDF.</p>
            
          </div>
          <!-- Carte 3 : Paiements scolarité -->
          <div class="feature-card p-8 border border-gray-100 hover:border-[#7300e9]/30 transition-all fade-up" style="transition-delay: 0.2s;">
            <div class="w-14 h-14 bg-[#7300e9]/10 rounded-2xl flex items-center justify-center mb-6">
              <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 10H21" stroke="#7300e9" stroke-width="1.6" stroke-linecap="round"/>
                <path d="M7 15H10" stroke="#7300e9" stroke-width="1.6" stroke-linecap="round"/>
                <rect x="5" y="4" width="14" height="16" rx="2" stroke="#7300e9" stroke-width="1.6"/>
                <path d="M8 7H16" stroke="#7300e9" stroke-width="1.6" stroke-linecap="round"/>
                <circle cx="17" cy="17" r="2" stroke="#7300e9" stroke-width="1.5"/>
              </svg>
            </div>
            <h3 class="text-2xl font-bold mb-3">Paiements & gestion financière</h3>
            <p class="text-gray-600 leading-relaxed">Suivi des frais de scolarité, génération de reçus, rappels automatiques et tableaux de bord financiers pour l'école.</p>
            
          </div>
        </div>
      </div>
    </section>

    <!-- SECTION : QUI PEUT UTILISER AfricEduc ? (3 catégories uniquement) -->
    <section class="bg-white py-20 px-4 sm:px-6 lg:px-8" id="whom">
      <div class="flex flex-col gap-4 mx-auto max-w-7xl">
        
        <!-- En-tête de section -->
        <div class="flex flex-col gap-3 text-center max-w-2xl mx-auto">
          <span class="text-[#7300e9] font-semibold text-sm uppercase tracking-wide bg-[#7300e9]/10 px-4 py-1.5 rounded-full w-fit mx-auto">
            Pour qui ?
          </span>
          <h2 class="font-title text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900">
            Une solution adaptée à <span class="text-[#7300e9]">tous les acteurs</span> de l'éducation
          </h2>
          <p class="text-gray-500 text-lg mt-2">
            Collèges (publics/privés), lycées et écoles internationales. AfricEduc s'adapte à vos besoins.
          </p>
        </div>

        <!-- Grille des cartes utilisateurs : 3 colonnes -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
          
          <!-- Carte 1 : Collèges publics & privés -->
          <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:border-[#7300e9]/30 hover:shadow-xl transition-all duration-300 group">
            <div class="w-14 h-14 bg-[#7300e9]/10 rounded-xl flex items-center justify-center mb-4 group-hover:bg-[#7300e9] transition">
              <svg fill="#9600ec" class="w-8 h-8 group-hover:fill-white" height="20px" width="20px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <polygon points="0,158.694 0,219.615 110.641,219.615 204.562,158.694 "></polygon> </g> </g> <g> <g> <polygon points="307.438,158.694 401.359,219.615 512,219.615 512,158.694 "></polygon> </g> </g> <g> <g> <polygon points="240.779,26.873 240.779,135.204 256,125.331 271.221,135.204 271.221,111.033 369.875,74.578 "></polygon> </g> </g> <g> <g> <path d="M367.034,364.262c-8.051,0-14.6,6.549-14.6,14.6v106.264h29.2V378.861C381.633,370.811,375.084,364.262,367.034,364.262z"></path> </g> </g> <g> <g> <path d="M144.966,364.262c-8.051,0-14.6,6.549-14.6,14.6v106.264h29.2V378.861C159.567,370.811,153.017,364.262,144.966,364.262z"></path> </g> </g> <g> <g> <path d="M256,364.262c-8.05,0-14.599,6.549-14.599,14.599v106.265h29.199V378.861C270.599,370.811,264.05,364.262,256,364.262z"></path> </g> </g> <g> <g> <path d="M256,243.015c-9.427,0-17.097,7.669-17.097,17.097s7.67,17.097,17.097,17.097c9.427,0,17.097-7.67,17.097-17.097 S265.427,243.015,256,243.015z"></path> </g> </g> <g> <g> <path d="M256,161.616l-125.633,81.49v93.155c4.582-1.575,9.49-2.443,14.599-2.443c24.837,0,45.043,20.206,45.043,45.043v106.264 h20.949V378.86c0-24.836,20.206-45.042,45.042-45.042s45.042,20.206,45.042,45.042v106.265h20.949V378.861 c0-24.837,20.206-45.043,45.042-45.043c5.109,0,10.018,0.868,14.6,2.443v-93.155L256,161.616z M256,307.651 c-26.213,0-47.539-21.326-47.539-47.539s21.326-47.539,47.539-47.539c26.213,0,47.539,21.326,47.539,47.539 C303.539,286.325,282.213,307.651,256,307.651z"></path> </g> </g> <g> <g> <path d="M0,250.058v235.068h99.924V378.861V250.058H0z M65.183,440.968H34.74v-33.69h30.443V440.968z M65.183,384.436H34.74 v-33.69h30.443V384.436z M65.183,327.905H34.74v-33.69h30.443V327.905z"></path> </g> </g> <g> <g> <path d="M412.076,250.058v128.803v106.264H512V250.058H412.076z M477.259,440.968h-30.443v-33.69h30.443V440.968z M477.259,384.436h-30.443v-33.69h30.443V384.436z M477.259,327.905h-30.443v-33.69h30.443V327.905z"></path> </g> </g> </g></svg>
            </div>
            <h3 class="font-title text-xl font-bold mb-2">Collèges publics & privés</h3>
            <p class="text-gray-500 text-sm leading-relaxed">
              De la 6ème à la 3ème. Gérez les classes, les notes, les bulletins, les paiements de scolarité et la communication parents-professeurs.
            </p>
            <div class="mt-4 flex items-center text-[#7300e9] text-sm font-medium gap-1">
              <span>6ème → Terminale</span>
              
            </div>
          </div>

          <!-- Carte 2 : Lycées -->
          <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:border-[#7300e9]/30 hover:shadow-xl transition-all duration-300 group">
            <div class="w-14 h-14 bg-[#7300e9]/10 rounded-xl flex items-center justify-center mb-4 group-hover:bg-[#7300e9] transition">
              <svg fill="#9600ec" class="w-8 h-8 group-hover:fill-white" height="200px" width="200px" version="1.2" baseProfile="tiny" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 256 256" xml:space="preserve">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path id="XMLID_24_" d="M176.2,82.2H79.8L126,44.4V31V11.4V7.4h3.9v3.9h21.7V31H130v13.4L176.2,82.2z M254,204.3v31.5h-77.8v13.8 H79.8v-13.8H2v-31.5h6.9v-94.5h70.9V86.2h96.5v23.6h70.9v94.5H254z M26.6,151.1h-9.8v45.3h9.8V151.1z M26.6,133.4h-9.8v9.8h9.8 V133.4z M44.3,151.1h-9.8v45.3h9.8V151.1z M44.3,133.4h-9.8v9.8h9.8V133.4z M62,151.1h-9.8v45.3H62V151.1z M62,133.4h-9.8v9.8H62 V133.4z M79.8,151.1h-9.8v45.3h9.8V151.1z M79.8,133.4h-9.8v9.8h9.8V133.4z M148.7,212.2h13.8V109.8h-13.8V212.2z M121.1,212.2h13.8 V109.8h-13.8V212.2z M93.5,212.2h13.8V109.8H93.5V212.2z M169.7,240.5H86.3v3.2h83.4V240.5z M169.7,232.1H86.3v3.2h83.4V232.1z M186.1,151.1h-9.8v45.3h9.8V151.1z M186.1,133.4h-9.8v9.8h9.8V133.4z M203.8,151.1H194v45.3h9.8V151.1z M203.8,133.4H194v9.8h9.8 V133.4z M221.5,151.1h-9.8v45.3h9.8V151.1z M221.5,133.4h-9.8v9.8h9.8V133.4z M239.2,151.1h-9.8v45.3h9.8V151.1z M239.2,133.4h-9.8 v9.8h9.8V133.4z"></path> </g>
              </svg>
            </div>
            <h3 class="font-title text-xl font-bold mb-2">Lycées techniques, professionnels & générales</h3>
            <p class="text-gray-500 text-sm leading-relaxed">
              De la seconde à la terminale. Suivez les résultats au baccalauréat, gérez les spécialités, les bulletins et l'orientation.
            </p>
            <div class="mt-4 flex items-center text-[#7300e9] text-sm font-medium gap-1">
              <span>Seconde → Terminale</span>
              
            </div>
          </div>

          <!-- Carte 3 : Écoles internationales -->
          <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:border-[#7300e9]/30 hover:shadow-xl transition-all duration-300 group">
            <div class="w-14 h-14 bg-[#7300e9]/10 rounded-xl flex items-center justify-center mb-4 group-hover:bg-[#7300e9] transition">
              <svg class="w-10 h-10 text-[#7300e9] group-hover:text-white transition" height="200px" width="200px" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                  <path d="M14.188 29.656H8.563c-.775 0-1.406.631-1.406 1.406v3.75c0 .775.631 1.406 1.406 1.406h5.625c.775 0 1.406-.631 1.406-1.406v-3.75c0-.775-.631-1.406-1.406-1.406m-3.282 5.625H8.563a.47.47 0 0 1-.469-.469v-3.75a.47.47 0 0 1 .469-.469h2.344v4.688zm3.75-.468a.47.47 0 0 1-.469.469h-2.344v-4.688h2.344a.47.47 0 0 1 .469.469v3.75"></path>
                  <path d="M14.188 39.5H8.563c-.775 0-1.406.631-1.406 1.406v3.75c0 .775.631 1.406 1.406 1.406h5.625c.775 0 1.406-.631 1.406-1.406v-3.75c0-.775-.631-1.406-1.406-1.406m-3.282 5.625H8.563a.47.47 0 0 1-.469-.469v-3.75a.47.47 0 0 1 .469-.469h2.344v4.688zm3.75-.469a.47.47 0 0 1-.469.469h-2.344v-4.688h2.344a.47.47 0 0 1 .469.469v3.75"></path>
                  <path d="M14.188 48.875H8.563c-.775 0-1.406.631-1.406 1.406v3.75c0 .775.631 1.406 1.406 1.406h5.625c.775 0 1.406-.631 1.406-1.406v-3.75c0-.775-.631-1.406-1.406-1.406M10.906 54.5H8.563a.47.47 0 0 1-.469-.469v-3.75a.47.47 0 0 1 .469-.469h2.344V54.5zm3.75-.469a.47.47 0 0 1-.469.469h-2.344v-4.688h2.344a.47.47 0 0 1 .469.469v3.75"></path>
                  <path d="M48.406 31.063v3.75c0 .775.631 1.406 1.406 1.406h5.625c.775 0 1.406-.631 1.406-1.406v-3.75c0-.775-.631-1.406-1.406-1.406h-5.625a1.407 1.407 0 0 0-1.406 1.406m4.688-.469h2.344a.47.47 0 0 1 .469.469v3.75a.47.47 0 0 1-.469.469h-2.344v-4.688m-.938 4.687h-2.344a.47.47 0 0 1-.469-.469v-3.75a.47.47 0 0 1 .469-.469h2.344v4.688"></path>
                  <path d="M55.438 39.5h-5.625c-.775 0-1.406.631-1.406 1.406v3.75c0 .775.631 1.406 1.406 1.406h5.625c.775 0 1.406-.631 1.406-1.406v-3.75c0-.775-.631-1.406-1.406-1.406m-3.282 5.625h-2.344a.47.47 0 0 1-.469-.469v-3.75a.47.47 0 0 1 .469-.469h2.344v4.688m3.75-.469a.47.47 0 0 1-.469.469h-2.344v-4.688h2.344a.47.47 0 0 1 .469.469v3.75"></path>
                  <path d="M55.438 48.875h-5.625c-.775 0-1.406.631-1.406 1.406v3.75c0 .775.631 1.406 1.406 1.406h5.625c.775 0 1.406-.631 1.406-1.406v-3.75c0-.775-.631-1.406-1.406-1.406M52.156 54.5h-2.344a.47.47 0 0 1-.469-.469v-3.75a.47.47 0 0 1 .469-.469h2.344V54.5m3.75-.469a.47.47 0 0 1-.469.469h-2.344v-4.688h2.344a.47.47 0 0 1 .469.469v3.75"></path>
                  <path d="M22.499 36.348c-.527-.178-.76-.28-.76-.512c0-.188.194-.35.597-.35c.399 0 .691.102.854.172l.207-.663a2.778 2.778 0 0 0-1.044-.183c-.967 0-1.549.475-1.549 1.094c0 .527.443.862 1.124 1.072c.491.155.686.286.686.512c0 .237-.225.393-.65.393c-.394 0-.776-.112-1.025-.226l-.188.679c.23.113.692.221 1.16.221c1.123 0 1.651-.517 1.651-1.126c0-.512-.34-.846-1.063-1.083"></path>
                  <path d="M26.276 35.492c.327 0 .589.063.776.134l.188-.651c-.163-.076-.527-.162-1.007-.162c-1.239 0-2.236.689-2.236 1.929c0 1.035.729 1.815 2.145 1.815c.498 0 .881-.08 1.051-.156l-.141-.641a2.59 2.59 0 0 1-.771.119c-.825 0-1.311-.459-1.311-1.186c.001-.808.572-1.201 1.306-1.201"></path>
                  <path d="M30.254 36.268h-1.525v-1.396h-.928v3.631h.928v-1.52h1.525v1.52h.923v-3.631h-.923z"></path>
                  <path d="M33.788 34.813c-1.208 0-1.991.813-1.991 1.901c0 1.035.71 1.849 1.924 1.849c1.197 0 2.01-.723 2.01-1.912c-.001-1.004-.686-1.838-1.943-1.838m-.017 3.098c-.62 0-.996-.502-.996-1.213c0-.706.364-1.234.989-1.234c.638 0 .99.561.99 1.213c0 .706-.359 1.234-.983 1.234"></path>
                  <path d="M38.144 34.813c-1.209 0-1.992.813-1.992 1.901c0 1.035.71 1.849 1.924 1.849c1.198 0 2.011-.723 2.011-1.912c-.001-1.004-.688-1.838-1.943-1.838m-.019 3.098c-.62 0-.996-.502-.996-1.213c0-.706.364-1.234.989-1.234c.639 0 .99.561.99 1.213c0 .706-.358 1.234-.983 1.234"></path>
                  <path d="M41.622 34.872h-.929v3.631h2.557v-.69h-1.628z"></path>
                  <path d="M38.563 26.375a6.563 6.563 0 1 0-13.126 0a6.563 6.563 0 1 0 13.126 0m-11.25 0a4.689 4.689 0 1 1 9.378.002a4.689 4.689 0 0 1-9.378-.002"></path>
                  <path d="M32.938 27.313v-3.75c0-.516-.422-.938-.938-.938s-.938.422-.938.938v2.813h-.938c-.516 0-.938.422-.938.938s.422.938.938.938H32a.943.943 0 0 0 .938-.939"></path>
                  <path d="M61.063 58.25h-.938v-30h.634c1.055 0 1.53-.755 1.059-1.677l-3.077-6.021c-.472-.922-1.721-1.677-2.775-1.677H40.107l-7.17-5.804v-2.29c3.75 2.992 7.5-6.446 11.25-3.453c-3.75-5.294-7.5 1.841-11.25-3.453v-.937C32.938 2.422 32.516 2 32 2s-.938.422-.938.938v10.134l-7.17 5.804H8.035c-1.055 0-2.304.755-2.775 1.677l-3.077 6.021c-.472.922.004 1.677 1.059 1.677h.634v30h-.938a.94.94 0 0 0-.938.937v1.875a.94.94 0 0 0 .938.937h58.125a.94.94 0 0 0 .937-.937v-1.875a.94.94 0 0 0-.937-.938M17 58.25H5.75v-30h8.937c.018.163.05.318.1.459c.245.685.957 1.416 2.214 1.416V58.25zm25 2.594H22v-1.5h20v1.5M26.375 58.25V47h5.156v11.25h-5.156m6.094 0V47h5.156v11.25h-5.156m12.656 0H39.5V47h1.875v-1.881s-6.443-3.893-8.487-5.348a1.586 1.586 0 0 0-1.775 0c-2.044 1.455-8.487 5.348-8.487 5.348V47H24.5v11.25h-5.625v-30H17c-.516 0-.611-.269-.214-.596l14.49-11.934c.199-.163.462-.245.724-.245s.524.082.724.245l14.49 11.934c.397.327.302.596-.214.596h-1.875v30m13.125 0H47V30.125c1.257 0 1.969-.731 2.214-1.416c.05-.141.082-.296.1-.459h8.937v30z"></path>
                  <path d="M29.246 52.156h1.348v.681h-1.348z"></path>
                  <path d="M33.406 52.156h1.348v.681h-1.348z"></path>
                </g>
              </svg>
            </div>
            <h3 class="font-title text-xl font-bold mb-2">Écoles internationales</h3>
            <p class="text-gray-500 text-sm leading-relaxed">
              Programmes bilingues, cursus internationaux (IB, Cambridge, etc.). Gestion multi-langue, rapports adaptés et suivi personnalisé.
            </p>
            <div class="mt-4 flex items-center text-[#7300e9] text-sm font-medium gap-1">
              <span>Multi-langue · Bac international</span>
              
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- SECTION CHIFFRES CLÉS (conservée) -->
    <section class="py-16 lg:py-24 relative overflow-hidden bg-[#12122b]">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="fade-in mb-12 max-w-xl text-center lg:text-left lg:max-w-2xl">
          <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm rounded-full px-4 py-1.5 mb-4">
            <span class="w-2 h-2 bg-[#99fbe3] rounded-full animate-pulse"></span>
            <span class="text-xs font-medium text-[#99fbe3] tracking-wide">CHIFFRES CLÉS</span>
          </div>
          <h2 class="text-4xl text-white font-bold sm:text-5xl lg:text-6xl font-title">Ils avancent avec <span class="text-[#99fbe3]">AfricEduc</span></h2>
          <p class="mt-4 text-slate-200 text-lg">Des indicateurs concrets pour mesurer la confiance des établissements en Afrique de l'Ouest.</p>
        </div>
    
        <div class="grid gap-6 sm:grid-cols-3">
          <!-- Carte 1 - Écoles partenaires -->
          <article class="fade-in group rounded-2xl bg-white/5 backdrop-blur-md p-8 border border-white/20 hover:border-[#99fbe3]/50 transition-all duration-300 hover:shadow-2xl hover:shadow-[#7300e9]/20 hover:-translate-y-2">
            <div class="flex items-center justify-between mb-4">
              <div class="w-12 h-12 rounded-xl bg-[#99fbe3]/20 flex items-center justify-center group-hover:bg-[#99fbe3] transition-all duration-300">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="text-white group-hover:text-[#7300e9] transition">
                  <path d="M12 3L3 8L12 13L21 8L12 3Z" />
                  <path d="M5 13L5 17.5C5 18.7 8 20 12 20C16 20 19 18.7 19 17.5L19 13" />
                </svg>
              </div>
              <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#99fbe3/30" stroke-width="1" class="opacity-50 group-hover:opacity-100 transition">
                <path d="M7 20L17 4" />
                <path d="M12 4L7 9" />
                <path d="M17 15L12 20" />
              </svg>
            </div>
            <p class="text-sm text-slate-300 uppercase tracking-wide">Écoles partenaires</p>
            <p class="mt-3 text-5xl font-bold text-[#99fbe3]" data-counter data-target="500" data-suffix="+">0</p>
            <div class="mt-4 h-1 w-12 bg-[#99fbe3]/30 rounded-full group-hover:w-full transition-all duration-500"></div>
            <p class="mt-4 text-slate-400 text-sm">Établissements scolaires et universitaires</p>
          </article>
    
          <!-- Carte 2 - Élèves suivis -->
          <article class="fade-in group rounded-2xl bg-white/5 backdrop-blur-md p-8 border border-white/20 hover:border-[#99fbe3]/50 transition-all duration-300 hover:shadow-2xl hover:shadow-[#7300e9]/20 hover:-translate-y-2">
            <div class="flex items-center justify-between mb-4">
              <div class="w-12 h-12 rounded-xl bg-[#99fbe3]/20 flex items-center justify-center group-hover:bg-[#99fbe3] transition-all duration-300">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="text-white group-hover:text-[#7300e9] transition">
                  <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z" />
                  <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                </svg>
              </div>
              <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#99fbe3/30" stroke-width="1" class="opacity-50 group-hover:opacity-100 transition">
                <circle cx="12" cy="12" r="10" />
                <path d="M12 8v4l3 3" />
              </svg>
            </div>
            <p class="text-sm text-slate-300 uppercase tracking-wide">Élèves suivis</p>
            <p class="mt-3 text-5xl font-bold text-[#99fbe3]" data-counter data-target="50000" data-suffix="+">0</p>
            <div class="mt-4 h-1 w-12 bg-[#99fbe3]/30 rounded-full group-hover:w-full transition-all duration-500"></div>
            <p class="mt-4 text-slate-400 text-sm">Élèves accompagnés au quotidien</p>
          </article>
    
          <!-- Carte 3 - Satisfaction clients -->
          <article class="fade-in group rounded-2xl bg-white/5 backdrop-blur-md p-8 border border-white/20 hover:border-[#99fbe3]/50 transition-all duration-300 hover:shadow-2xl hover:shadow-[#7300e9]/20 hover:-translate-y-2">
            <div class="flex items-center justify-between mb-4">
              <div class="w-12 h-12 rounded-xl bg-[#99fbe3]/20 flex items-center justify-center group-hover:bg-[#99fbe3] transition-all duration-300">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="text-white group-hover:text-[#7300e9] transition">
                  <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" />
                  <path d="M8 14C8.5 15.5 10 17 12 17C14 17 15.5 15.5 16 14" />
                  <circle cx="9" cy="9" r="1" fill="#99fbe3" />
                  <circle cx="15" cy="9" r="1" fill="#99fbe3" />
                </svg>
              </div>
              <div class="flex gap-0.5">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="#99fbe3" stroke="none"><polygon points="12 2 15 9 22 9 16 14 19 22 12 17 5 22 8 14 2 9 9 9 12 2" /></svg>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="#99fbe3" stroke="none"><polygon points="12 2 15 9 22 9 16 14 19 22 12 17 5 22 8 14 2 9 9 9 12 2" /></svg>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="#99fbe3" stroke="none"><polygon points="12 2 15 9 22 9 16 14 19 22 12 17 5 22 8 14 2 9 9 9 12 2" /></svg>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="#99fbe3" stroke="none"><polygon points="12 2 15 9 22 9 16 14 19 22 12 17 5 22 8 14 2 9 9 9 12 2" /></svg>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="#99fbe3/50" stroke="none"><polygon points="12 2 15 9 22 9 16 14 19 22 12 17 5 22 8 14 2 9 9 9 12 2" /></svg>
              </div>
            </div>
            <p class="text-sm text-slate-300 uppercase tracking-wide">Satisfaction clients</p>
            <p class="mt-3 text-5xl font-bold text-[#99fbe3]" data-counter data-target="99" data-suffix="%">0</p>
            <div class="mt-4 h-1 w-12 bg-[#99fbe3]/30 rounded-full group-hover:w-full transition-all duration-500"></div>
            <p class="mt-4 text-slate-400 text-sm">Recommandé par les équipes pédagogiques</p>
          </article>
        </div>
      </div>
    </section>

    <!-- SECTION AVIS (conservée) -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 relative overflow-hidden bg-white" id="testimonies">
      <div class="absolute top-0 right-0 w-96 h-96 bg-[#7300e9]/5 rounded-full blur-3xl"></div>
      <div class="absolute bottom-0 left-0 w-80 h-80 bg-[#99fbe3]/20 rounded-full blur-3xl"></div>
    
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="fade-in mb-12 text-center max-w-2xl mx-auto">
          <div class="inline-flex items-center gap-2 bg-[#7300e9]/10 backdrop-blur-sm rounded-full px-4 py-1.5 mb-4">
            <span class="w-2 h-2 bg-[#7300e9] rounded-full animate-pulse"></span>
            <span class="text-xs font-medium text-[#7300e9] tracking-wide">ILS PARLENT DE NOUS</span>
          </div>
          <h2 class="text-3xl font-bold sm:text-4xl lg:text-5xl font-title">Ce que nos <span class="text-[#7300e9]">clients</span> en pensent</h2>
          <p class="mt-4 text-gray-500 text-lg">Des établissements qui ont fait le choix d'AfricEduc</p>
        </div>
    
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
          <!-- AVIS 1 -->
          <div class="fade-in group bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:border-[#7300e9]/30 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center gap-1 mb-4">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="#7300e9" stroke="none"><polygon points="12 2 15 9 22 9 16 14 19 22 12 17 5 22 8 14 2 9 9 9 12 2" /></svg>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="#7300e9" stroke="none"><polygon points="12 2 15 9 22 9 16 14 19 22 12 17 5 22 8 14 2 9 9 9 12 2" /></svg>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="#7300e9" stroke="none"><polygon points="12 2 15 9 22 9 16 14 19 22 12 17 5 22 8 14 2 9 9 9 12 2" /></svg>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="#7300e9" stroke="none"><polygon points="12 2 15 9 22 9 16 14 19 22 12 17 5 22 8 14 2 9 9 9 12 2" /></svg>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="#7300e9" stroke="none"><polygon points="12 2 15 9 22 9 16 14 19 22 12 17 5 22 8 14 2 9 9 9 12 2" /></svg>
            </div>
            <p class="text-gray-600 text-sm leading-relaxed italic">"AfricEduc a transformé la gestion de notre collège. Plus de perte de temps avec les notes et les bulletins, tout est automatisé. Je recommande vivement !"</p>
            <div class="mt-5 flex items-center gap-3 pt-3 border-t border-gray-100">
              <div class="w-10 h-10 rounded-full bg-[#7300e9] flex items-center justify-center text-white font-bold text-sm">MD</div>
              <div>
                <p class="font-semibold text-gray-800">Mamadou Diallo</p>
                <p class="text-xs text-gray-400">Directeur - Collège Moderne de Cotonou</p>
              </div>
            </div>
          </div>
    
          <!-- AVIS 2 -->
          <div class="fade-in group bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:border-[#7300e9]/30 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center gap-1 mb-4">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="#7300e9" stroke="none"><polygon points="12 2 15 9 22 9 16 14 19 22 12 17 5 22 8 14 2 9 9 9 12 2" /></svg>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="#7300e9" stroke="none"><polygon points="12 2 15 9 22 9 16 14 19 22 12 17 5 22 8 14 2 9 9 9 12 2" /></svg>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="#7300e9" stroke="none"><polygon points="12 2 15 9 22 9 16 14 19 22 12 17 5 22 8 14 2 9 9 9 12 2" /></svg>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="#7300e9" stroke="none"><polygon points="12 2 15 9 22 9 16 14 19 22 12 17 5 22 8 14 2 9 9 9 12 2" /></svg>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="#7300e9" stroke="none"><polygon points="12 2 15 9 22 9 16 14 19 22 12 17 5 22 8 14 2 9 9 9 12 2" /></svg>
            </div>
            <p class="text-gray-600 text-sm leading-relaxed italic">"La plateforme est intuitive et le support client réactif. Le suivi des paiements nous a permis de réduire les impayés de 40%."</p>
            <div class="mt-5 flex items-center gap-3 pt-3 border-t border-gray-100">
              <div class="w-10 h-10 rounded-full bg-[#7300e9] flex items-center justify-center text-white font-bold text-sm">AT</div>
              <div>
                <p class="font-semibold text-gray-800">Aminata Touré</p>
                <p class="text-xs text-gray-400">Secrétaire Générale - Université Abomey-Calavi</p>
              </div>
            </div>
          </div>
    
          <!-- AVIS 3 -->
          <div class="fade-in group bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:border-[#7300e9]/30 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center gap-1 mb-4">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="#7300e9" stroke="none"><polygon points="12 2 15 9 22 9 16 14 19 22 12 17 5 22 8 14 2 9 9 9 12 2" /></svg>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="#7300e9" stroke="none"><polygon points="12 2 15 9 22 9 16 14 19 22 12 17 5 22 8 14 2 9 9 9 12 2" /></svg>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="#7300e9" stroke="none"><polygon points="12 2 15 9 22 9 16 14 19 22 12 17 5 22 8 14 2 9 9 9 12 2" /></svg>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="#7300e9" stroke="none"><polygon points="12 2 15 9 22 9 16 14 19 22 12 17 5 22 8 14 2 9 9 9 12 2" /></svg>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="#7300e9/40" stroke="none"><polygon points="12 2 15 9 22 9 16 14 19 22 12 17 5 22 8 14 2 9 9 9 12 2" /></svg>
            </div>
            <p class="text-gray-600 text-sm leading-relaxed italic">"Le générateur de bulletins PDF nous fait gagner des heures chaque semaine. Et mes agents adorent la simplicité d'utilisation."</p>
            <div class="mt-5 flex items-center gap-3 pt-3 border-t border-gray-100">
              <div class="w-10 h-10 rounded-full bg-[#7300e9] flex items-center justify-center text-white font-bold text-sm">JK</div>
              <div>
                <p class="font-semibold text-gray-800">Jean Kouadio</p>
                <p class="text-xs text-gray-400">Proviseur - Lycée Moderne d'Abidjan</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- CTA final -->
      <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#7300e9] via-[#5a00b8] to-[#3b006e] mt-16 mx-auto max-w-4xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-[#99fbe3]/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-[#99fbe3]/10 rounded-full blur-2xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full max-w-md bg-white/5 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 flex flex-col items-center text-center gap-6 px-6 py-12 md:px-12 md:py-16">
          <h2 class="text-2xl font-bold text-white sm:text-3xl md:text-4xl lg:text-5xl font-title">
            Prêt à transformer votre école ?
          </h2>
          <p class="max-w-md text-sm text-slate-200 md:text-base">
            Rejoignez plus de 500 établissements qui nous font déjà confiance en Afrique de l'Ouest.
          </p>
          <div class="flex flex-col gap-3 sm:flex-row sm:gap-4 mt-2">
            <a href="auth/register.php" class="group relative inline-flex items-center justify-center gap-2 overflow-hidden rounded-full bg-white px-6 py-3 font-semibold text-[#7300e9] shadow-lg transition-all hover:shadow-xl hover:scale-105 md:px-8 md:py-3.5">
              <span class="relative z-10 flex items-center gap-2">
                Commencer gratuitement
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="group-hover:translate-x-1 transition-transform">
                  <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
              </span>
              <div class="absolute inset-0 -translate-x-full group-hover:translate-x-0 transition-transform duration-300 bg-gradient-to-r from-[#99fbe3] to-[#7300e9]/20"></div>
            </a>
            <a href="#features" class="inline-flex items-center justify-center gap-2 rounded-full border border-white/30 bg-white/5 px-5 py-3 font-medium text-white backdrop-blur-sm transition-all hover:bg-white/20 hover:border-white/50 md:px-7 md:py-3.5">
              Comment ça marche ?
            </a>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer class="bg-white border-t border-[#7300e9]/10 pt-12 pb-6">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-5">
        <div class="lg:col-span-2">
          <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10 text-primary transition group-hover:rotate-6">
            <svg width="30px" height="30px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="none" stroke="#9600ec" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.16"></g><g id="SVGRepo_iconCarrier"> <path d="m14.25 9.25v-3.25l-6.25-3.25-6.25 3.25 6.25 3.25 3.25-1.5v3.5c0 1-1.5 2-3.25 2s-3.25-1-3.25-2v-3.5"></path> </g></svg>
          </span>
          <span class="text-xl mx-2 font-bold tracking-tight text-slate-900">Afric<span class="text-primary">Educ</span></span>
          <p class="text-gray-500 text-sm leading-relaxed mb-4 max-w-sm">
            La solution complète de gestion scolaire pour les collèges et universités d'Afrique de l'Ouest. Simple, puissante et sécurisée.
          </p>
        </div>
        <div>
          <h3 class="font-title font-semibold text-gray-800 mb-4">Navigation</h3>
          <ul class="space-y-2 text-sm">
            <li><a href="#features" class="text-gray-500 hover:text-[#7300e9] transition">Fonctionnalités</a></li>
            <li><a href="#whom" class="text-gray-500 hover:text-[#7300e9] transition">Par qui ?</a></li>
            <li><a href="#testimonies" class="text-gray-500 hover:text-[#7300e9] transition">Avis</a></li>
            <li><a href="auth/register.php" class="text-gray-500 hover:text-[#7300e9] transition">Démo gratuite</a></li>
          </ul>
        </div>
        
        
      </div>
      <div class="border-t border-gray-100 my-8"></div>
      <div class="flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-gray-400">
        <div class="flex flex-wrap gap-4 justify-center">
          <span>&copy; 2026 AfricEduc. Tous droits réservés.</span>
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

      const counters = document.querySelectorAll("[data-counter]");
      const counterObserver = new IntersectionObserver(
        (entries, observer) => {
          entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            const el = entry.target;
            const target = Number(el.dataset.target || 0);
            const suffix = el.dataset.suffix || "";
            const duration = 1500;
            const start = performance.now();
            const tick = (now) => {
              const progress = Math.min((now - start) / duration, 1);
              const value = Math.floor(progress * target);
              el.textContent = value.toLocaleString("fr-FR") + suffix;
              if (progress < 1) requestAnimationFrame(tick);
              else el.textContent = target.toLocaleString("fr-FR") + suffix;
            };
            requestAnimationFrame(tick);
            observer.unobserve(el);
          });
        },
        { threshold: 0.5 }
      );
      counters.forEach((counter) => counterObserver.observe(counter));
    })();
  </script>
</body>
</html>