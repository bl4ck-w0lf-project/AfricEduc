<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AfricEduc | Gestion scolaire moderne</title>
  <meta name="description" content="AfricEduc, la solution SaaS de gestion scolaire pour les collèges et universités du Bénin et d'Afrique de l'Ouest.">

  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: "#0F9D72",
            primaryDark: "#00ffb3",
            accent: "#99fbe3"
          },
          fontFamily: {
            heading: ["Quicksand", "sans-serif"],
            body: ["Outfit", "sans-serif"]
          },
          boxShadow: {
            glow: "0 20px 50px -20px rgba(15, 157, 114, 0.45)",
            premium: "0 30px 60px -20px rgba(0,0,0,0.15)"
          }
        }
      }
    };
  </script>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">

  <style>
     html { scroll-behavior: smooth; }
    body { font-family: "Outfit", sans-serif; background: #fafafa; }
    h1, h2, h3, h4 { font-family: "Quicksand", sans-serif; }
    
    .fade-in {
      opacity: 0;
      transform: translateY(24px);
      transition: opacity 700ms ease, transform 700ms ease;
    }
    .fade-in.is-visible {
      opacity: 1;
      transform: translateY(0);
    }
    
    .feature-card {
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      background: white;
      border-radius: 2rem;
      box-shadow: 0 20px 35px -12px rgba(0,0,0,0.05);
      border: 1px solid rgba(0,0,0,0.04);
    }
    .feature-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 30px 45px -15px rgba(15, 157, 114, 0.15);
      border-color: rgba(15, 157, 114, 0.2);
    }
    .feature-card-green {
      background: linear-gradient(135deg, #0F9D72 0%, #0B7A58 100%);
      color: white;
      border: none;
    }
    .feature-card-green:hover {
      transform: translateY(-8px);
      box-shadow: 0 30px 45px -15px rgba(15, 157, 114, 0.4);
    }
    .feature-card-green .icon-bg { background: rgba(255,255,255,0.2); }
    .feature-card-green .icon-bg i { color: white; }
    .feature-card .icon-bg i { color: #0F9D72; }
    
    .nav-link { position: relative; }
    .nav-link:after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      bottom: -2px;
      left: 0;
      background-color: #0F9D72;
      transition: width 0.3s ease;
    }
    .nav-link:hover:after { width: 100%; }

    /* ===== SIDEBAR MOBILE CORRIGÉE ===== */
    #mobile-sidebar {
      position: fixed;
      top: 0;
      right: -340px;
      width: 320px;
      height: 100vh;
      background: white;
      z-index: 1000;
      transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: -20px 0 60px rgba(0,0,0,0.1);
      overflow-y: auto;
      padding: 2rem 1.5rem;
      display: flex;
      flex-direction: column;
    }
    #mobile-sidebar.is-open { right: 0; }
    
    #mobile-sidebar .sidebar-logo {
      display: flex;
      align-items: center;
      gap: 12px;
      padding-bottom: 1.5rem;
      border-bottom: 1px solid #f1f5f9;
      margin-bottom: 1.5rem;
      flex-shrink: 0;
    }
    #mobile-sidebar .sidebar-logo img {
      height: 50px;
      width: auto;
    }
    #mobile-sidebar .sidebar-logo span {
      font-size: 1.25rem;
      font-weight: 700;
      color: #0f172a;
    }
    #mobile-sidebar .sidebar-logo span .text-primary { color: #0F9D72; }

    #mobile-sidebar .sidebar-links {
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }
    #mobile-sidebar .sidebar-links a {
      padding: 12px 16px;
      border-radius: 12px;
      font-size: 0.95rem;
      font-weight: 500;
      color: #475569;
      transition: all 0.2s ease;
    }
    #mobile-sidebar .sidebar-links a:hover {
      background: #f1f5f9;
      color: #0F9D72;
    }
    #mobile-sidebar .sidebar-links .auth-links {
      margin-top: auto;
      border-top: 1px solid #f1f5f9;
      padding-top: 1rem;
    }
    #mobile-sidebar .sidebar-links .auth-links a {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 1rem;
      padding: 12px 16px;
      border-radius: 50px;
      border: 1px solid rgba(15,157,114,0.2);
      font-weight: 600;
      color: #0F9D72;
      transition: all 0.2s ease;
    }
    #mobile-sidebar .sidebar-links .auth-links a:hover {
      background: #0F9D72;
      color: #ffffff;
    }

    #mobile-overlay {
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,0.3);
      z-index: 999;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.3s ease;
      backdrop-filter: blur(4px);
    }
    #mobile-overlay.is-open {
      opacity: 1;
      pointer-events: auto;
    }

    /* Floating cards */
    .float-card {
      animation: float 6s ease-in-out infinite;
      border-radius: 1.5rem;
      box-shadow: 0 20px 60px rgba(15, 157, 114, 0.15);
    }
    .float-card:nth-child(2) { animation-delay: 2s; }
    .float-card:nth-child(3) { animation-delay: 4s; }
    .float-card:nth-child(4) { animation-delay: 1s; }
    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-15px); }
    }

    .section-title {
      font-size: 2.5rem;
      font-weight: 700;
      color: #0f172a;
    }
    .section-title span { color: #0F9D72; }
    .section-subtitle {
      color: #64748b;
      font-size: 1.1rem;
      max-width: 600px;
    }

    /* FAQ rotate */
    .faq-toggle i.fa-chevron-down {
      transition: transform 0.3s ease;
    }
    .faq-toggle i.fa-chevron-down.rotate-180 {
      transform: rotate(180deg);
    }

      /* Bouton fermeture mobile - vert */
  #close-mobile-menu {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: #e6f7f0;
    color: #0F9D72;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
  }
  #close-mobile-menu:hover {
    background: #0F9D72;
    color: white;
    transform: rotate(90deg);
  }
  #close-mobile-menu i {
    font-size: 1.5rem;
  }
  </style>
</head>
<body class="bg-[#fafafa] text-slate-800 antialiased">

  <!-- Overlay mobile -->
  <!-- Overlay mobile -->
  <div id="mobile-overlay"></div>

  <!-- Sidebar mobile CORRIGÉE -->
    <!-- Sidebar mobile CORRIGÉE -->
<div id="mobile-sidebar">
  <!-- Logo en haut avec bouton fermeture -->
  <div class="sidebar-logo" style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 1.5rem; border-bottom: 1px solid #f1f5f9; margin-bottom: 1.5rem; flex-shrink: 0;">
    <div style="display: flex; align-items: center; gap: 12px;">
      <img src="public/logo.png" alt="AfricEduc" style="height: 50px; width: auto;">
      <span style="font-size: 1.25rem; font-weight: 700; color: #0f172a;">Afric<span style="color: #0F9D72;">Educ</span></span>
    </div>
    <button id="close-mobile-menu" style="padding: 8px; border-radius: 8px; color: #0F9D72; background: #e6f7f0; border: none; cursor: pointer; transition: all 0.2s ease;">
      <i class="fa-solid fa-xmark" style="font-size: 1.5rem;"></i>
    </button>
  </div>
  
  <div class="sidebar-links">
    <a href="#features">Fonctionnalités</a>
    <a href="#whom">Pour qui ?</a>
    <a href="#testimonies">Avis</a>
    <a href="#faq">FAQ</a>
    <div class="auth-links" style="margin-top: auto; border-top: 1px solid #f1f5f9; padding-top: 1rem; display: flex; flex-direction: column; gap: 0.5rem;">
      <a href="app/views/auth/login.php" style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 12px 16px; border-radius: 50px; border: 1px solid rgba(15,157,114,0.2); font-weight: 600; color: #0F9D72; transition: all 0.2s ease; text-decoration: none;">
        <i class="fa-solid fa-arrow-right-to-bracket"></i> Se connecter
      </a>
      <a href="app/views/auth/register.php" style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 12px 16px; border-radius: 50px; border: 1px solid rgba(15,157,114,0.2); font-weight: 600; color: #0F9D72; transition: all 0.2s ease; text-decoration: none;">
        <i class="fa-solid fa-user-plus"></i> S'inscrire
      </a>
    </div>
  </div>
</div>
  </div>

  <!-- HEADER -->
   <!-- HEADER -->
  <header class="fixed left-0 right-0 top-0 z-50 border-b border-emerald-100/50 bg-white/90 backdrop-blur-md">
    <nav class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
      <a href="index.html" class="group inline-flex items-center gap-3">
        <span class="inline-flex h-[50px] w-[150px] items-center justify-center rounded-xl transition group-hover:rotate-3">
          <img src="public/logo.png" class="h-[100px] w-[150px]" alt="">
        </span>
        <span class="text-xl font-bold tracking-tight text-slate-900">Afric<span class="text-primary">Educ</span></span>
      </a>

      <div class="hidden md:flex items-center gap-x-8 text-sm font-medium">
        <a href="#features" class="nav-link text-gray-600 hover:text-gray-900">Fonctionnalités</a>
        <a href="#whom" class="nav-link text-gray-600 hover:text-gray-900">Pour qui ?</a>
        <a href="#testimonies" class="nav-link text-gray-600 hover:text-gray-900">Avis</a>
        <a href="#faq" class="nav-link text-gray-600 hover:text-gray-900">FAQ</a>
      </div>

      <div class="flex justify-center gap-2">
        <a href="app/views/auth/login.php" class="hidden md:flex rounded-full items-center gap-2 border border-primary/20 px-5 py-2 text-sm font-semibold text-primary transition hover:border-primary hover:bg-primary hover:text-white">
          <i class="fa-solid fa-arrow-right-to-bracket"></i> Se connecter
        </a>
        <a href="app/views/auth/register.php" class="hidden md:flex rounded-full items-center gap-2 border border-primary/20 px-5 py-2 text-sm font-semibold text-primary transition hover:border-primary hover:bg-primary hover:text-white">
          <i class="fa-solid fa-user-plus"></i> S'inscrire
        </a>
      </div>

      <button id="menu-btn" class="md:hidden px-4 py-3 rounded-lg bg-primary text-white hover:bg-primaryDark transition shadow-lg">
        <i class="fa-solid fa-bars text-xl "></i>
      </button>
    </nav>
  </header>

  <main>
    <!-- HERO SECTION - Dégradé corrigé -->
    <!-- HERO SECTION - Fond blanc -->
<section class="relative overflow-hidden pt-[180px] pb-[160px] px-4 sm:px-6 lg:px-8 bg-white">
  <!-- Cercles décoratifs -->
  <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-primary/5 rounded-full blur-3xl"></div>
  <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-accent/10 rounded-full blur-3xl"></div>
  
  <div class="mx-auto max-w-7xl relative z-10">
    <div class="grid lg:grid-cols-2 gap-16 items-center">
      <!-- Texte -->
      <div class="fade-in">
        <h1 class="text-4xl font-bold leading-tight text-slate-900 sm:text-5xl lg:text-6xl">
          Pilotez votre établissement <br> <span class="text-primary">sans friction.</span>
        </h1>
        <p class="mt-6 max-w-xl text-base text-slate-600 sm:text-lg">
          AfricEduc centralise les élèves, notes, moyennes, paiements de scolarité et bulletins PDF dans une interface claire, pensée pour les réalités d'Afrique de l'Ouest.
        </p>
        <div class="mt-8 flex flex-col gap-3 sm:flex-row">
          <a href="app/views/auth/register.php" class="inline-flex items-center justify-center rounded-xl bg-primary px-6 py-3 text-lg font-semibold text-white shadow-glow transition hover:-translate-y-0.5 hover:shadow-xl">
            <i class="fa-solid fa-play mr-2"></i> Commencer gratuitement
          </a>
          <a href="#features" class="inline-flex items-center justify-center rounded-xl border border-primary/30 px-6 py-3 text-lg font-semibold text-primary transition hover:bg-primary/10 hover:border-primary/50">
            <i class="fa-solid fa-circle-question mr-2"></i> Comment ça fonctionne ?
          </a>
        </div>
      </div>

      <!-- Cartes flottantes -->
      <div class="fade-in relative flex justify-center items-center min-h-[500px]">
  <!-- Carte en haut à droite - IMAGE -->
  <div class="float-card absolute -top-8 right-0 bg-white shadow-xl rounded-2xl overflow-hidden" style="width: 300px; height: 200px; animation-delay: 1s;">
    <img src="public/students.avif" alt="Étudiants" class="w-full h-full object-cover">
  </div>

  <!-- Carte en haut à gauche -->
  <div class="hidden lg:flex float-card absolute -top-8 left-0 bg-white p-5 shadow-xl rounded-2xl" style="width: 200px;">
    <div class="flex items-center gap-3">
      <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center">
        <i class="fa-solid fa-building-columns text-primary"></i>
      </div>
      <div>
        <p class="text-2xl font-bold text-slate-900">500+</p>
        <p class="text-xs text-gray-500">Écoles partenaires</p>
      </div>
    </div>
  </div>

  <!-- Carte en bas à gauche -->
  <div class="hidden lg:flex  float-card absolute -bottom-8 left-0 bg-white p-5 shadow-xl rounded-2xl" style="width: 200px; animation-delay: 2s;">
    <div class="flex items-center gap-3">
      <div class="w-10 h-10 rounded-full bg-accent/30 flex items-center justify-center">
        <i class="fa-solid fa-graduation-cap text-primary"></i>
      </div>
      <div>
        <p class="text-2xl font-bold text-slate-900">50K+</p>
        <p class="text-xs text-gray-500">Élèves suivis</p>
      </div>
    </div>
  </div>

  <!-- Carte en bas à droite - DEVENUE IMAGE -->
  <div class="float-card absolute -bottom-8 right-0 bg-white shadow-xl rounded-2xl overflow-hidden" style="width: 220px; height: 150px; animation-delay: 3s;">
    <img src="public/students2.avif" alt="Élèves" class="w-full h-full object-cover">
  </div>

  <!-- Image centrale -->
  <div class="w-full max-w-md rounded-3xl overflow-hidden shadow-2xl">
    <img src="public/school.avif" alt="Éducation" class="w-full h-[380px] object-cover">
  </div>
</div>
  </div>
</section>

    <!-- SECTION FONCTIONNALITÉS -->
    <section id="features" class="py-24 px-4 sm:px-6 lg:px-8 bg-[#fafafa]">
      <div class="max-w-7xl mx-auto">
        <div class="flex flex-col gap-3 text-left max-w-2xl fade-in">
          <span class="inline-block text-primary font-semibold tracking-wide text-md  px-4 py-1.5 mb-3">
            <i class="fa-solid fa-comment-dots mr-2"></i> FONCTIONNALITÉS
          </span>
          <h2 class="text-3xl md:text-5xl font-bold mb-4">Une solution pensée pour <span class="text-primary">l'éducation</span> ouest-africaine</h2>
          <p class="text-gray-500 text-lg mb-3">Gagnez du temps, améliorez les résultats et centralisez toutes les données.</p>
        </div>
        
        
       <div class="grid md:grid-cols-3 gap-8 lg:gap-10 mt-7">
  <!-- Carte 1 - Fond vert (pas de hover) -->
  <div class="feature-card-green p-8 border border-white/10 transition-all fade-in rounded-3xl" style="transition-delay: 0s;">
    <div class="icon-bg w-14 h-14 rounded-2xl flex items-center justify-center mb-6">
      <i class="fa-solid fa-user-graduate text-2xl"></i>
    </div>
    <h3 class="text-2xl font-bold mb-3 text-white">Gestion élèves & inscriptions</h3>
    <p class="text-white/80 leading-relaxed">Inscriptions simplifiées, dossiers numériques, classes, emplois du temps. Suivez chaque élève de la maternelle à l'université.</p>
  </div>
  
  <!-- Carte 2 - Hover sur la carte => icône change -->
  <div class="feature-card p-8 border border-gray-100 transition-all fade-in rounded-3xl group hover:border-primary/30" style="transition-delay: 0.1s;">
    <div class="icon-bg w-14 h-14 rounded-2xl flex items-center justify-center mb-6 transition-all duration-300 group-hover:bg-primary group-hover:text-white">
      <i class="fa-solid fa-pen-to-square text-2xl text-primary transition-all duration-300 group-hover:text-white"></i>
    </div>
    <h3 class="text-2xl font-bold mb-3">Notes, moyennes & examens</h3>
    <p class="text-gray-600 leading-relaxed">Saisie intuitive, calcul automatique des moyennes, appréciations, tableaux de performance, et génération de bulletins PDF.</p>
  </div>
  
  <!-- Carte 3 - Hover sur la carte => icône change -->
  <div class="feature-card p-8 border border-gray-100 transition-all fade-in rounded-3xl group hover:border-primary/30" style="transition-delay: 0.2s;">
    <div class="icon-bg w-14 h-14 rounded-2xl flex items-center justify-center mb-6 transition-all duration-300 group-hover:bg-primary group-hover:text-white">
      <i class="fa-solid fa-coins text-2xl text-primary transition-all duration-300 group-hover:text-white"></i>
    </div>
    <h3 class="text-2xl font-bold mb-3">Paiements & gestion financière</h3>
    <p class="text-gray-600 leading-relaxed">Suivi des frais de scolarité, génération de reçus, rappels automatiques et tableaux de bord financiers pour l'école.</p>
  </div>

  <!-- Carte 4 - Hover sur la carte => icône change -->
  <div class="feature-card p-8 border border-gray-100 transition-all fade-in rounded-3xl group hover:border-primary/30" style="transition-delay: 0.3s;">
    <div class="icon-bg w-14 h-14 rounded-2xl flex items-center justify-center mb-6 transition-all duration-300 group-hover:bg-primary group-hover:text-white">
      <i class="fa-solid fa-file-pdf text-2xl text-primary transition-all duration-300 group-hover:text-white"></i>
    </div>
    <h3 class="text-2xl font-bold mb-3">Bulletins & relevés PDF</h3>
    <p class="text-gray-600 leading-relaxed">Génération automatique de bulletins personnalisés, relevés de notes et certificats en PDF prêts à imprimer ou envoyer.</p>
  </div>

  <!-- Carte 5 - Hover sur la carte => icône change -->
  <div class="feature-card p-8 border border-gray-100 transition-all fade-in rounded-3xl group hover:border-primary/30" style="transition-delay: 0.4s;">
    <div class="icon-bg w-14 h-14 rounded-2xl flex items-center justify-center mb-6 transition-all duration-300 group-hover:bg-primary group-hover:text-white">
      <i class="fa-solid fa-chart-simple text-2xl text-primary transition-all duration-300 group-hover:text-white"></i>
    </div>
    <h3 class="text-2xl font-bold mb-3">Statistiques & tableaux de bord</h3>
    <p class="text-gray-600 leading-relaxed">Visualisez en temps réel les performances, les taux de réussite, les absences et la santé financière de votre établissement.</p>
  </div>

  <!-- Carte 6 - Hover sur la carte => icône change -->
  <div class="feature-card p-8 border border-gray-100 transition-all fade-in rounded-3xl group hover:border-primary/30" style="transition-delay: 0.5s;">
    <div class="icon-bg w-14 h-14 rounded-2xl flex items-center justify-center mb-6 transition-all duration-300 group-hover:bg-primary group-hover:text-white">
      <i class="fa-solid fa-building-columns text-2xl text-primary transition-all duration-300 group-hover:text-white"></i>
    </div>
    <h3 class="text-2xl font-bold mb-3">Multi-établissements</h3>
    <p class="text-gray-600 leading-relaxed">Gérez plusieurs écoles, collèges ou universités depuis une seule interface centralisée et sécurisée.</p>
  </div>
</div>
      </div>
    </section>

    <!-- SECTION : QUI PEUT UTILISER AfricEduc ? -->
    <section class="bg-white py-20 px-4 sm:px-6 lg:px-8" id="whom">
      <div class="flex flex-col gap-4 mx-auto max-w-7xl">
        <div class="flex flex-col gap-3 text-left max-w-2xl fade-in">
          <span class="inline-block text-primary font-semibold tracking-wide text-md  px-4 py-1.5 mb-3">
            <i class="fa-solid fa-comment-dots mr-2"></i> QUI PEUT UTLISER AFRICEDUC ?
          </span>
          <h2 class="section-title">Une solution adaptée à <span>tous les acteurs</span> de l'éducation</h2>
          <p class="section-subtitle">Collèges (publics/privés), lycées et écoles internationales. AfricEduc s'adapte à vos besoins.</p>
        </div>
        

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
          <!-- Carte 1 -->
          <div class="bg-white rounded-3xl p-8 shadow-lg border border-gray-100 hover:border-primary/30 hover:shadow-xl transition-all duration-300 group fade-in">
            <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-primary transition">
              <i class="fa-solid fa-school text-3xl text-primary group-hover:text-white transition"></i>
            </div>
            <h3 class="font-title text-xl font-bold mb-2">Collèges publics & privés</h3>
            <p class="text-gray-500 text-sm leading-relaxed">De la 6ème à la 3ème. Gérez les classes, les notes, les bulletins, les paiements de scolarité et la communication parents-professeurs.</p>
            <div class="mt-4 flex items-center text-primary text-sm font-medium gap-1">
              <span>6ème → Terminale</span>
            </div>
          </div>

          <!-- Carte 2 -->
          <div class="bg-white rounded-3xl p-8 shadow-lg border border-gray-100 hover:border-primary/30 hover:shadow-xl transition-all duration-300 group fade-in">
            <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-primary transition">
              <i class="fa-solid fa-graduation-cap text-3xl text-primary group-hover:text-white transition"></i>
            </div>
            <h3 class="font-title text-xl font-bold mb-2">Lycées techniques & professionnels</h3>
            <p class="text-gray-500 text-sm leading-relaxed">De la seconde à la terminale. Suivez les résultats au baccalauréat, gérez les spécialités, les bulletins et l'orientation.</p>
            <div class="mt-4 flex items-center text-primary text-sm font-medium gap-1">
              <span>Seconde → Terminale</span>
            </div>
          </div>

          <!-- Carte 3 -->
          <div class="bg-white rounded-3xl p-8 shadow-lg border border-gray-100 hover:border-primary/30 hover:shadow-xl transition-all duration-300 group fade-in">
            <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-primary transition">
              <i class="fa-solid fa-globe text-3xl text-primary group-hover:text-white transition"></i>
            </div>
            <h3 class="font-title text-xl font-bold mb-2">Écoles internationales</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Programmes bilingues, cursus internationaux (IB, Cambridge). Gestion multi-langue, rapports adaptés et suivi personnalisé.</p>
            <div class="mt-4 flex items-center text-primary text-sm font-medium gap-1">
              <span>Multi-langue · Bac international</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- SECTION CHIFFRES CLÉS -->
    <section class="py-20 lg:py-28 relative overflow-hidden bg-white">
  <!-- SVG en arrière-plan -->
  <div class="absolute inset-0 w-full h-full opacity-50" style="background-image: url('/AfricEduc/public/Contour Line.svg'); background-size: cover; background-position: center; background-repeat: no-repeat;"></div>
  
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="fade-in mb-16 max-w-xl">
      <span class="inline-block text-primary font-semibold tracking-wide text-sm px-4 py-1.5 mb-4">
        <i class="fa-solid fa-chart-simple mr-2"></i> CHIFFRES CLÉS
      </span>
      <h2 class="text-4xl text-slate-900 font-bold sm:text-5xl lg:text-6xl font-title">Ils avancent avec <span class="text-primary">AfricEduc</span></h2>
      <p class="mt-4 text-slate-600 text-lg">Des indicateurs concrets pour mesurer la confiance des établissements en Afrique de l'Ouest.</p>
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
      <div class="fade-in group rounded-2xl bg-white shadow-lg p-8 border border-gray-100 hover:border-primary/30 transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
        <div class="flex items-center justify-between mb-4">
          <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center group-hover:bg-primary transition-all duration-300">
            <i class="fa-solid fa-building-columns text-primary text-xl group-hover:text-white transition"></i>
          </div>
        </div>
        <p class="text-sm text-slate-500 uppercase tracking-wide">Écoles partenaires</p>
        <p class="mt-3 text-5xl font-bold text-primary" data-counter data-target="500" data-suffix="+">0</p>
        <div class="mt-4 h-1 w-12 bg-primary/30 rounded-full group-hover:w-full transition-all duration-500"></div>
        <p class="mt-4 text-slate-500 text-sm">Établissements scolaires et universitaires</p>
      </div>

      <div class="fade-in group rounded-2xl bg-white shadow-lg p-8 border border-gray-100 hover:border-primary/30 transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
        <div class="flex items-center justify-between mb-4">
          <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center group-hover:bg-primary transition-all duration-300">
            <i class="fa-solid fa-user-graduate text-primary text-xl group-hover:text-white transition"></i>
          </div>
        </div>
        <p class="text-sm text-slate-500 uppercase tracking-wide">Élèves suivis</p>
        <p class="mt-3 text-5xl font-bold text-primary" data-counter data-target="50000" data-suffix="+">0</p>
        <div class="mt-4 h-1 w-12 bg-primary/30 rounded-full group-hover:w-full transition-all duration-500"></div>
        <p class="mt-4 text-slate-500 text-sm">Élèves accompagnés au quotidien</p>
      </div>

      <div class="fade-in group rounded-2xl bg-white shadow-lg p-8 border border-gray-100 hover:border-primary/30 transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
        <div class="flex items-center justify-between mb-4">
          <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center group-hover:bg-primary transition-all duration-300">
            <i class="fa-solid fa-star text-primary text-xl group-hover:text-white transition"></i>
          </div>
          <div class="flex gap-0.5">
            <i class="fa-solid fa-star text-amber-400 text-sm"></i>
            <i class="fa-solid fa-star text-amber-400 text-sm"></i>
            <i class="fa-solid fa-star text-amber-400 text-sm"></i>
            <i class="fa-solid fa-star text-amber-400 text-sm"></i>
            <i class="fa-regular fa-star text-amber-400 text-sm"></i>
          </div>
        </div>
        <p class="text-sm text-slate-500 uppercase tracking-wide">Satisfaction clients</p>
        <p class="mt-3 text-5xl font-bold text-primary" data-counter data-target="99" data-suffix="%">0</p>
        <div class="mt-4 h-1 w-12 bg-primary/30 rounded-full group-hover:w-full transition-all duration-500"></div>
        <p class="mt-4 text-slate-500 text-sm">Recommandé par les équipes pédagogiques</p>
      </div>
    </div>
  </div>
</section>

    <!-- SECTION AVIS -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 relative overflow-hidden bg-white" id="testimonies">
      <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl"></div>
      <div class="absolute bottom-0 left-0 w-80 h-80 bg-accent/20 rounded-full blur-3xl"></div>
    
      <div class="mx-auto max-w-7xl relative z-10">
        <div class="fade-in mb-12">
          <span class="inline-block text-primary font-semibold tracking-wide text-md  px-4 py-1.5 mb-3">
            <i class="fa-solid fa-comment-dots mr-2"></i> ILS PARLENT DE NOUS
          </span>
          <h2 class="section-title">Ce que nos <span>clients</span> en pensent</h2>
          <p class="section-subtitle">Des établissements qui ont fait le choix d'AfricEduc</p>
        </div>
    
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
          <div class="fade-in group bg-white rounded-3xl p-6 shadow-lg border border-gray-100 hover:border-primary/30 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center gap-1 mb-4">
              <i class="fa-solid fa-star text-amber-400"></i>
              <i class="fa-solid fa-star text-amber-400"></i>
              <i class="fa-solid fa-star text-amber-400"></i>
              <i class="fa-solid fa-star text-amber-400"></i>
              <i class="fa-solid fa-star text-amber-400"></i>
            </div>
            <p class="text-gray-600 text-sm leading-relaxed italic">"AfricEduc a transformé la gestion de notre collège. Plus de perte de temps avec les notes et les bulletins, tout est automatisé. Je recommande vivement !"</p>
            <div class="mt-5 flex items-center gap-3 pt-3 border-t border-gray-100">
              <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white font-bold text-sm">MD</div>
              <div>
                <p class="font-semibold text-gray-800">Mamadou Diallo</p>
                <p class="text-xs text-gray-400">Directeur - Collège Moderne de Cotonou</p>
              </div>
            </div>
          </div>
    
          <div class="fade-in group bg-white rounded-3xl p-6 shadow-lg border border-gray-100 hover:border-primary/30 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center gap-1 mb-4">
              <i class="fa-solid fa-star text-amber-400"></i>
              <i class="fa-solid fa-star text-amber-400"></i>
              <i class="fa-solid fa-star text-amber-400"></i>
              <i class="fa-solid fa-star text-amber-400"></i>
              <i class="fa-solid fa-star text-amber-400"></i>
            </div>
            <p class="text-gray-600 text-sm leading-relaxed italic">"La plateforme est intuitive et le support client réactif. Le suivi des paiements nous a permis de réduire les impayés de 40%."</p>
            <div class="mt-5 flex items-center gap-3 pt-3 border-t border-gray-100">
              <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white font-bold text-sm">AT</div>
              <div>
                <p class="font-semibold text-gray-800">Aminata Touré</p>
                <p class="text-xs text-gray-400">Secrétaire Générale - Université Abomey-Calavi</p>
              </div>
            </div>
          </div>
    
          <div class="fade-in group bg-white rounded-3xl p-6 shadow-lg border border-gray-100 hover:border-primary/30 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center gap-1 mb-4">
              <i class="fa-solid fa-star text-amber-400"></i>
              <i class="fa-solid fa-star text-amber-400"></i>
              <i class="fa-solid fa-star text-amber-400"></i>
              <i class="fa-solid fa-star text-amber-400"></i>
              <i class="fa-regular fa-star text-amber-400"></i>
            </div>
            <p class="text-gray-600 text-sm leading-relaxed italic">"Le générateur de bulletins PDF nous fait gagner des heures chaque semaine. Et mes agents adorent la simplicité d'utilisation."</p>
            <div class="mt-5 flex items-center gap-3 pt-3 border-t border-gray-100">
              <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white font-bold text-sm">JK</div>
              <div>
                <p class="font-semibold text-gray-800">Jean Kouadio</p>
                <p class="text-xs text-gray-400">Proviseur - Lycée Moderne d'Abidjan</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- SECTION FAQ -->
    <section id="faq" class="py-20 px-4 sm:px-6 lg:px-8 bg-[#f8fafc]">
      <div class="mx-auto max-w-7xl">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
          <div class="fade-in flex justify-center">
            <img src="public/Shrug-cuate.svg" alt="FAQ" class="w-full max-w-md">
          </div>
          <div class="fade-in">
            <span class="inline-block text-primary font-semibold tracking-wide text-md px-4 py-1.5 mb-4">
              <i class="fa-solid fa-circle-question mr-2"></i> QUESTIONS FRÉQUENTES
            </span>
            <h2 class="text-3xl sm:text-4xl font-bold mb-6">Vous avez des <span class="text-primary">questions</span> ?</h2>
            <p class="text-gray-500 mb-8">Retrouvez les réponses aux questions les plus posées sur AfricEduc.</p>
            
            <div class="space-y-4">
              <div class="border border-gray-200 rounded-2xl overflow-hidden">
                <button class="faq-toggle w-full text-left px-6 py-4 flex justify-between items-center hover:bg-gray-100/50 transition">
                  <span class="font-semibold">1. Qu'est-ce que AfricEduc ?</span>
                  <i class="fa-solid fa-chevron-down text-gray-500 transition-transform duration-300"></i>
                </button>
                <div class="faq-answer px-6 pb-4 text-gray-600 text-sm hidden">AfricEduc est une plateforme SaaS de gestion scolaire qui permet aux établissements de gérer les inscriptions, notes, paiements et communications.</div>
              </div>
              <div class="border border-gray-200 rounded-2xl overflow-hidden">
                <button class="faq-toggle w-full text-left px-6 py-4 flex justify-between items-center hover:bg-gray-100/50 transition">
                  <span class="font-semibold">2. Est-ce adapté à mon école ?</span>
                  <i class="fa-solid fa-chevron-down text-gray-500 transition-transform duration-300"></i>
                </button>
                <div class="faq-answer px-6 pb-4 text-gray-600 text-sm hidden">Oui, AfricEduc s'adapte aux collèges, lycées, écoles internationales, et universités, qu'ils soient publics ou privés.</div>
              </div>
              <div class="border border-gray-200 rounded-2xl overflow-hidden">
                <button class="faq-toggle w-full text-left px-6 py-4 flex justify-between items-center hover:bg-gray-100/50 transition">
                  <span class="font-semibold">3. Combien coûte AfricEduc ?</span>
                  <i class="fa-solid fa-chevron-down text-gray-500 transition-transform duration-300"></i>
                </button>
                <div class="faq-answer px-6 pb-4 text-gray-600 text-sm hidden">Nous proposons des formules adaptées à la taille de votre établissement. Contactez-nous pour un devis personnalisé.</div>
              </div>
              <div class="border border-gray-200 rounded-2xl overflow-hidden">
                <button class="faq-toggle w-full text-left px-6 py-4 flex justify-between items-center hover:bg-gray-100/50 transition">
                  <span class="font-semibold">4. Est-ce que je peux l'essayer ?</span>
                  <i class="fa-solid fa-chevron-down text-gray-500 transition-transform duration-300"></i>
                </button>
                <div class="faq-answer px-6 pb-4 text-gray-600 text-sm hidden">Oui ! Nous proposons une démo gratuite. Inscrivez-vous et découvrez toutes les fonctionnalités sans engagement.</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA final -->
    <div class="relative overflow-hidden rounded-3xl bg-primary mt-16 mx-auto max-w-4xl">
  <!-- SVG en arrière-plan -->
  <div class="absolute inset-0 w-full h-full opacity-50" style="background-image: url('/AfricEduc/public/blob-scene-haikei (1).svg'); background-size: cover; background-position: center; background-repeat: no-repeat;"></div>
  
  <div class="relative z-10 flex flex-col items-center text-center gap-6 px-6 py-12 md:px-12 md:py-16">
    <h2 class="text-2xl font-bold text-white sm:text-3xl md:text-4xl lg:text-5xl font-title">
      Prêt à transformer votre école ?
    </h2>
    <p class="max-w-md text-sm text-slate-200 md:text-base">
      Rejoignez plus de 500 établissements qui nous font déjà confiance en Afrique de l'Ouest.
    </p>
    <div class="flex flex-col gap-3 sm:flex-row sm:gap-4 mt-2">
      <a href="app/views/auth/register.php" class="group relative inline-flex items-center justify-center gap-2 overflow-hidden rounded-full bg-white px-6 py-3 font-semibold text-primary shadow-lg transition-all hover:shadow-xl hover:scale-105 md:px-8 md:py-3.5">
        <span class="relative z-10 flex items-center gap-2">
          <i class="fa-solid fa-play"></i> Commencer gratuitement
          <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
        </span>
        <div class="absolute inset-0 -translate-x-full group-hover:translate-x-0 transition-transform duration-300 bg-gradient-to-r from-accent to-primary/20"></div>
      </a>
      <a href="#features" class="inline-flex items-center justify-center gap-2 rounded-full border border-white/30 bg-white/5 px-5 py-3 font-medium text-white backdrop-blur-sm transition-all hover:bg-white/20 hover:border-white/50 md:px-7 md:py-3.5">
        <i class="fa-solid fa-circle-question"></i> Comment ça marche ?
      </a>
    </div>
  </div>
</div>
  </main>

  <!-- FOOTER -->
  <footer class="bg-white border-t border-primary/10 pt-16 pb-6 mt-[3rem]">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-5">
        <div class="lg:col-span-2">
          <div class="flex items-center gap-3 mb-4">
            <img src="public/logo.png" class="h-[100px] w-auto" alt="AfricEduc">
            <span class="text-2xl font-bold tracking-tight text-slate-900">Afric<span class="text-primary">Educ</span></span>
          </div>
          <p class="text-gray-500 text-sm leading-relaxed mb-6 max-w-sm">
            La solution complète de gestion scolaire pour les collèges et universités d'Afrique de l'Ouest. Simple, puissante et sécurisée.
          </p>
          <div class="flex gap-3">
            <a href="#" class="w-11 h-11 rounded-full bg-gray-100 flex items-center justify-center hover:bg-primary hover:text-white transition text-gray-600 hover:text-white text-lg">
              <i class="fa-brands fa-facebook-f"></i>
            </a>
            <a href="#" class="w-11 h-11 rounded-full bg-gray-100 flex items-center justify-center hover:bg-primary hover:text-white transition text-gray-600 hover:text-white text-lg">
              <i class="fa-brands fa-twitter"></i>
            </a>
            <a href="#" class="w-11 h-11 rounded-full bg-gray-100 flex items-center justify-center hover:bg-primary hover:text-white transition text-gray-600 hover:text-white text-lg">
              <i class="fa-brands fa-linkedin-in"></i>
            </a>
            <a href="#" class="w-11 h-11 rounded-full bg-gray-100 flex items-center justify-center hover:bg-primary hover:text-white transition text-gray-600 hover:text-white text-lg">
              <i class="fa-brands fa-youtube"></i>
            </a>
          </div>
        </div>
        <div>
          <h3 class="font-title font-semibold text-gray-800 mb-4">Navigation</h3>
          <ul class="space-y-2 text-sm">
            <li><a href="#features" class="text-gray-500 hover:text-primary transition">Fonctionnalités</a></li>
            <li><a href="#whom" class="text-gray-500 hover:text-primary transition">Pour qui ?</a></li>
            <li><a href="#testimonies" class="text-gray-500 hover:text-primary transition">Avis</a></li>
            <li><a href="#faq" class="text-gray-500 hover:text-primary transition">FAQ</a></li>
          </ul>
        </div>
        <div>
          <h3 class="font-title font-semibold text-gray-800 mb-4">Contact</h3>
          <ul class="space-y-2 text-sm text-gray-500">
            <li class="flex items-center gap-2"><i class="fa-solid fa-envelope text-primary w-4"></i> <a href="mailto:contact@africeduc.com" class="hover:text-primary transition">contact@africeduc.com</a></li>
            <li class="flex items-center gap-2"><i class="fa-solid fa-phone text-primary w-4"></i> <a href="tel:+22967000000" class="hover:text-primary transition">+229 67 00 00 00</a></li>
            <li class="flex items-center gap-2"><i class="fa-solid fa-location-dot text-primary w-4"></i> Cotonou, Bénin</li>
          </ul>
        </div>
        <div>
          <h3 class="font-title font-semibold text-gray-800 mb-4">Liens utiles</h3>
          <ul class="space-y-2 text-sm">
            <li><a href="#" class="text-gray-500 hover:text-primary transition">Conditions d'utilisation</a></li>
            <li><a href="#" class="text-gray-500 hover:text-primary transition">Politique de confidentialité</a></li>
            <li><a href="#" class="text-gray-500 hover:text-primary transition">Support</a></li>
          </ul>
        </div>
      </div>
      <div class="border-t border-gray-100 my-8"></div>
      <div class="flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-gray-400">
        <span>&copy; 2026 AfricEduc. Tous droits réservés.</span>
        <span>Créé par <a href="https://hounmenou-ricardo.vercel.app/" target="_blank" rel="noopener noreferrer" class="text-primary hover:text-primaryDark hover:underline font-medium transition">Ricardo</a></span>
      </div>  
    </div>
  </footer>

  <script>
   // Menu hamburger mobile
const menuBtn = document.getElementById('menu-btn');
const mobileSidebar = document.getElementById('mobile-sidebar');
const mobileOverlay = document.getElementById('mobile-overlay');
const closeMobileMenu = document.getElementById('close-mobile-menu');

function openMobileMenu() {
  mobileSidebar.classList.add('is-open');
  mobileOverlay.classList.add('is-open');
  document.body.style.overflow = 'hidden';
}

function closeMobileMenuFn() {
  mobileSidebar.classList.remove('is-open');
  mobileOverlay.classList.remove('is-open');
  document.body.style.overflow = '';
}

if (menuBtn) menuBtn.addEventListener('click', openMobileMenu);
if (closeMobileMenu) closeMobileMenu.addEventListener('click', closeMobileMenuFn);
if (mobileOverlay) mobileOverlay.addEventListener('click', closeMobileMenuFn);
   

    // FAQ Toggle
      // FAQ Toggle - Un seul ouvert à la fois
  document.querySelectorAll('.faq-toggle').forEach(btn => {
    btn.addEventListener('click', function() {
      const answer = this.nextElementSibling;
      const icon = this.querySelector('i.fa-chevron-down');
      const isOpen = !answer.classList.contains('hidden');
      
      // Fermer toutes les réponses
      document.querySelectorAll('.faq-answer').forEach(a => {
        a.classList.add('hidden');
      });
      document.querySelectorAll('.faq-toggle i.fa-chevron-down').forEach(i => {
        i.classList.remove('rotate-180');
      });
      
      // Si elle était fermée, on l'ouvre
      if (!isOpen) {
        answer.classList.remove('hidden');
        if (icon) icon.classList.add('rotate-180');
      }
    });
  });

    // Animations fade-in
    (function () {
      const fadeElements = document.querySelectorAll(".fade-in");
      const revealOnScroll = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              entry.target.classList.add("is-visible");
              revealOnScroll.unobserve(entry.target);
            }
          });
        },
        { threshold: 0.16 }
      );
      fadeElements.forEach((el) => revealOnScroll.observe(el));

      // Counters
      const counters = document.querySelectorAll("[data-counter]");
      const counterObserver = new IntersectionObserver(
        (entries) => {
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
            counterObserver.unobserve(el);
          });
        },
        { threshold: 0.5 }
      );
      counters.forEach((counter) => counterObserver.observe(counter));
    })();
  </script>
</body>
</html>