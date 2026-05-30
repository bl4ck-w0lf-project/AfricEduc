<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EduManager | Agent — Centre d'action</title>
  <meta name="description" content="Votre espace agent — tâches prioritaires, actions rapides et indicateurs de productivité.">

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: "#7300e9",
            "primary-dark": "#5c00ba",
            accent: "#99fbe3",
            "accent-dark": "#6ee7d6",
            urgent: "#ef4444",
            warning: "#f59e0b",
            success: "#10b981",
            info: "#3b82f6"
          },
          fontFamily: {
            heading: ["Quicksand", "sans-serif"],
            body: ["Outfit", "sans-serif"]
          },
          animation: {
            "pulse-slow": "pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite",
            "shake": "shake 0.5s ease-in-out"
          },
          keyframes: {
            shake: {
              "0%, 100%": { transform: "translateX(0)" },
              "25%": { transform: "translateX(-4px)" },
              "75%": { transform: "translateX(4px)" }
            }
          }
        }
      }
    };
  </script>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">

  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

  <style>
    body {
      font-family: "Outfit", sans-serif;
    }
    h1, h2, h3, .font-heading {
      font-family: "Quicksand", sans-serif;
    }
    .sidebar-link {
      transition: all 0.2s ease;
    }
    .sidebar-link--active {
      background-color: rgba(153, 251, 227, 0.2);
      color: #99fbe3;
    }
    .sidebar-link:hover {
      background-color: rgba(255, 255, 255, 0.1);
      transform: translateX(4px);
    }
    #sidebar-overlay {
      pointer-events: none;
      opacity: 0;
      transition: opacity 0.2s ease;
    }
    #sidebar-overlay.is-open {
      pointer-events: auto;
      opacity: 1;
    }
    .priority-item {
      transition: all 0.2s ease;
    }
    .priority-item:hover {
      transform: translateX(4px);
    }
    .kpi-card {
      transition: all 0.2s ease;
    }
    .kpi-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
    }
    .filter-btn.active {
      background-color: #7300e9;
      color: white;
      border-color: #7300e9;
    }
    .action-tile {
      transition: all 0.2s ease;
      cursor: pointer;
    }
    .action-tile:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 20px -12px rgba(115, 0, 233, 0.3);
    }
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-slate-50 to-slate-100 text-slate-800 antialiased">
  <div id="c" class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden" aria-hidden="true"></div>

   <?php include __DIR__ . '/../components/sidebar.php'; ?>


  <div class="min-h-screen lg:pl-[280px]">
    <header class="sticky top-0 z-30 flex h-16 items-center justify-between gap-4 border-b border-slate-200/80 bg-white/95 px-4 backdrop-blur-md sm:px-6 shadow-sm">
      <div class="flex items-center gap-3">
        <button type="button" id="btn-menu" class="inline-flex rounded-xl border border-slate-200 p-2 text-slate-700 hover:bg-slate-50 lg:hidden transition-all" aria-label="Ouvrir le menu">
          <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
        </button>
        <div>
          <p class="font-heading text-sm font-semibold text-primary sm:text-base"><?= htmlspecialchars($_SESSION['school_name'] ?? 'École inconnue') ?> </p>
          <p class="text-xs text-slate-500"><?= htmlspecialchars($_SESSION['school_address'] ?? 'Addresse école inconnue') ?></p>
        </div>
      </div>
      <div class="flex items-center gap-3">
        <div class="hidden md:flex items-center gap-2 bg-amber-50 border border-amber-200 rounded-full px-3 py-1.5">
          <div class="h-2 w-2 rounded-full bg-urgent animate-pulse"></div>
          <?php
        $currentYear = date("Y");
        $nextYear = $currentYear + 1;
        $schoolYear = $currentYear . "–" . $nextYear;
        ?>

          <span class="text-xs font-medium text-amber-800"> Année scolaire <?= $schoolYear ?></span>
        </div>
        <button type="button" class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-2 py-1.5 pr-3 shadow-sm transition-all hover:border-primary/30 hover:shadow-md">
           <?php
                $userName = $_SESSION['user_name'] ?? 'User';

                // on récupère les initiales
                $words = explode(' ', trim($userName));
                $initials = '';

                foreach ($words as $w) {
                    $initials .= strtoupper($w[0] ?? '');
                }

                // limite à 2 caractères max
                $initials = substr($initials, 0, 2);
            ?>
          <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-accent to-accent-dark text-sm font-bold text-primary"><?= $initials ?></span>
          <span class="hidden text-left text-sm sm:block">
            <span class="block font-medium text-slate-900"><?= htmlspecialchars($_SESSION['user_name']) ?></span>
            <span class="text-xs text-slate-500"><?= htmlspecialchars($_SESSION['user_role']) ?></span>
          </span>
        </button>
      </div>
    </header>

    <main class="px-4 py-6 sm:px-6 lg:px-8">
      <!-- Welcome Banner -->
      <section class="rounded-2xl bg-gradient-to-r from-primary/5 via-primary/10 to-accent/20 border border-primary/20 p-6 shadow-sm sm:p-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
          <div>
            <?php
                      $heure = date("H");

                      if ($heure < 12) {
                          $salutation = "Bonjour";
                      } elseif ($heure < 18) {
                          $salutation = "Bon après-midi";
                      } else {
                          $salutation = "Bonsoir";
                      }
              ?>
            <h1 class="font-heading text-2xl font-bold text-slate-900 sm:text-3xl"><?= $salutation ?> <?= htmlspecialchars($_SESSION['user_name']) ?> 👋 <p class="font-heading text-sm font-semibold text-primary sm:text-base"><?= htmlspecialchars($_SESSION['school_name'] ?? 'École inconnue') ?> </p></h1>
            <p class="mt-2 max-w-2xl text-sm text-slate-600">
              Voici votre espace de travail personnalisé. Concentrez-vous sur les tâches prioritaires et vos actions quotidiennes.
            </p>
          </div>
          <div class="flex gap-2">
            <span class="px-3 py-1.5 bg-white rounded-full text-xs font-medium text-slate-600 shadow-sm" id="date">📅</span>
            <span class="px-3 py-1.5 bg-white rounded-full text-xs font-medium text-slate-600 shadow-sm" id="clock" >⏰</span>
          </div>
        </div>
      </section>

      <!-- KPI améliorés -->
      <section class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <!-- KPI 1: Tâches urgentes -->
        <article class="kpi-card relative rounded-2xl border-l-4 border-l-urgent bg-white p-5 shadow-sm hover:shadow-md transition-all">
          <div class="flex items-center justify-between">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-100">
              <svg class="h-6 w-6 text-urgent" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3M12 4a8 8 0 1 0 0 16 8 8 0 0 0 0-16Z" />
              </svg>
            </div>
            <span class="badge-urgent text-xs font-bold px-2 py-1 bg-red-100 text-urgent rounded-full">URGENT</span>
          </div>
          <p class="mt-4 text-3xl font-bold text-slate-900">3</p>
          <p class="text-sm font-medium text-slate-500">Paiements en retard</p>
          <p class="text-xs text-slate-400 mt-1">+2 vs hier</p>
        </article>

        <!-- KPI 2: Élèves à inscrire -->
        <article class="kpi-card rounded-2xl border-l-4 border-l-warning bg-white p-5 shadow-sm hover:shadow-md transition-all">
          <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-100">
            <svg class="h-6 w-6 text-warning" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3M12 4.5v15m7.5-7.5h-15" />
            </svg>
          </div>
          <p class="mt-4 text-3xl font-bold text-slate-900">5</p>
          <p class="text-sm font-medium text-slate-500">Inscriptions à finaliser</p>
          <p class="text-xs text-slate-400 mt-1">Dossiers incomplets</p>
        </article>

        <!-- KPI 3: Bulletins non générés -->
        <article class="kpi-card rounded-2xl border-l-4 border-l-info bg-white p-5 shadow-sm hover:shadow-md transition-all">
          <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-100">
            <svg class="h-6 w-6 text-info" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3.75h10.5l3 4.5v9.75a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25l3-4.5Z" />
              <path stroke-linecap="round" d="M9 12.75h6M9 16h3" />
            </svg>
          </div>
          <p class="mt-4 text-3xl font-bold text-slate-900">12</p>
          <p class="text-sm font-medium text-slate-500">Bulletins à générer</p>
          <p class="text-xs text-slate-400 mt-1">Trimestre 2 - 4 classes</p>
        </article>

        <!-- KPI 4: Actions du jour -->
        <article class="kpi-card rounded-2xl border-l-4 border-l-success bg-white p-5 shadow-sm hover:shadow-md transition-all">
          <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-100">
            <svg class="h-6 w-6 text-success" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
          </div>
          <p class="mt-4 text-3xl font-bold text-slate-900">8/14</p>
          <p class="text-sm font-medium text-slate-500">Tâches accomplies</p>
          <p class="text-xs text-slate-400 mt-1">57% d'avancement</p>
        </article>
      </section>

      <!-- Section À faire aujourd'hui (PRIORITÉS) -->
      <section class="mt-8 rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
          <div>
            <h2 class="font-heading text-lg font-bold text-slate-900 flex items-center gap-2">
              <svg class="h-5 w-5 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
              </svg>
              À faire aujourd'hui
            </h2>
            <p class="text-xs text-slate-500 mt-1">Priorisez ces actions pour rester productif</p>
          </div>
          <div class="text-xs text-slate-400 bg-slate-50 px-3 py-1.5 rounded-full">🕐 Objectif : 100% avant 17h</div>
        </div>

        <div class="space-y-3">
          <!-- Priorité 1 - Paiements en attente -->
          <div class="priority-item flex items-center gap-3 p-3 rounded-xl bg-gradient-to-r from-red-50 to-transparent border border-red-200 cursor-pointer hover:shadow-md transition-all" data-action="paiements">
            <div class="flex-shrink-0">
              <div class="h-10 w-10 rounded-full bg-red-200 flex items-center justify-center">
                <svg class="h-5 w-5 text-urgent" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.5 8.5h17M6 5h12a2.5 2.5 0 0 1 2.5 2.5v9A2.5 2.5 0 0 1 18 19H6a2.5 2.5 0 0 1-2.5-2.5v-9A2.5 2.5 0 0 1 6 5Z" />
                </svg>
              </div>
            </div>
            <div class="flex-1">
              <p class="font-semibold text-slate-900">3 paiements en attente</p>
              <p class="text-xs text-slate-500">Familles : Koudogbo, Hountondji, Salami · Échéance dépassée</p>
            </div>
            <div class="flex-shrink-0">
              <span class="px-2 py-1 bg-red-100 text-urgent text-xs font-bold rounded-full animate-pulse">URGENT</span>
            </div>
          </div>

          <!-- Priorité 2 - Bulletins à générer -->
          <div class="priority-item flex items-center gap-3 p-3 rounded-xl bg-gradient-to-r from-amber-50 to-transparent border border-amber-200 cursor-pointer hover:shadow-md transition-all" data-action="bulletins">
            <div class="flex-shrink-0">
              <div class="h-10 w-10 rounded-full bg-amber-200 flex items-center justify-center">
                <svg class="h-5 w-5 text-warning" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3.75h10.5l3 4.5v9.75a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25l3-4.5Z" />
                </svg>
              </div>
            </div>
            <div class="flex-1">
              <p class="font-semibold text-slate-900">12 bulletins à générer</p>
              <p class="text-xs text-slate-500">Classes : 4e A, 4e B, 3e C, Tle D · Trimestre 2</p>
            </div>
            <div class="flex-shrink-0">
              <span class="px-2 py-1 bg-amber-100 text-warning text-xs font-bold rounded-full">À TRAITER</span>
            </div>
          </div>

          <!-- Priorité 3 - Inscriptions à finaliser -->
          <div class="priority-item flex items-center gap-3 p-3 rounded-xl bg-gradient-to-r from-blue-50 to-transparent border border-blue-200 cursor-pointer hover:shadow-md transition-all" data-action="inscriptions">
            <div class="flex-shrink-0">
              <div class="h-10 w-10 rounded-full bg-blue-200 flex items-center justify-center">
                <svg class="h-5 w-5 text-info" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3M12 4.5v15m7.5-7.5h-15" />
                </svg>
              </div>
            </div>
            <div class="flex-1">
              <p class="font-semibold text-slate-900">5 inscriptions à finaliser</p>
              <p class="text-xs text-slate-500">Dossiers incomplets : pièces d'identité manquantes</p>
            </div>
            <div class="flex-shrink-0">
              <span class="px-2 py-1 bg-blue-100 text-info text-xs font-bold rounded-full">EN COURS</span>
            </div>
          </div>
        </div>
      </section>

      <!-- Actions rapides entièrement fonctionnelles -->
      <section class="mt-8">
        <h2 class="font-heading text-lg font-bold text-slate-900">Actions rapides</h2>
        <p class="mt-1 text-sm text-slate-500">Un clic pour accéder aux tâches fréquentes</p>

        <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
          <!-- Action 1 - Ajouter un élève -->
          <div class="action-tile group relative flex flex-col rounded-2xl border-2 border-slate-200 bg-white p-5 shadow-sm transition-all hover:border-primary/40 hover:shadow-md hover:scale-[1.02]" data-action="add_student">
            <div class="flex items-start justify-between">
              <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary/10 text-primary transition group-hover:scale-110">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
              </span>
              <span class="bg-success/10 text-success text-xs font-bold px-2 py-1 rounded-full">ACTIF</span>
            </div>
            <span class="mt-3 font-heading font-bold text-slate-900">Ajouter un élève</span>
            <span class="mt-1 text-xs text-slate-500">Inscription rapide</span>
          </div>

          <!-- Action 2 - Saisir des notes -->
          <div class="action-tile group relative flex flex-col rounded-2xl border-2 border-slate-200 bg-white p-5 shadow-sm transition-all hover:border-primary/40 hover:shadow-md hover:scale-[1.02]" data-action="add_grade">
            <div class="flex items-start justify-between">
              <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-accent/50 text-primary transition group-hover:scale-110">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 5h10M9 12h10M9 19h6M5 5h.01M5 12h.01M5 19h.01" />
                </svg>
              </span>
              <span class="bg-success/10 text-success text-xs font-bold px-2 py-1 rounded-full">ACTIF</span>
            </div>
            <span class="mt-3 font-heading font-bold text-slate-900">Saisir des notes</span>
            <span class="mt-1 text-xs text-slate-500">Devoirs, interros</span>
          </div>

          <!-- Action 3 - Enregistrer paiement -->
          <div class="action-tile group relative flex flex-col rounded-2xl border-2 border-slate-200 bg-white p-5 shadow-sm transition-all hover:border-primary/40 hover:shadow-md hover:scale-[1.02]" data-action="add_payment">
            <div class="flex items-start justify-between">
              <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-violet-100 text-primary transition group-hover:scale-110">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M5 6h14a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2Z" />
                </svg>
              </span>
              <span class="bg-success/10 text-success text-xs font-bold px-2 py-1 rounded-full">ACTIF</span>
            </div>
            <span class="mt-3 font-heading font-bold text-slate-900">Enregistrer paiement</span>
            <span class="mt-1 text-xs text-slate-500">Scolarité, reçus</span>
          </div>

          <!-- Action 4 - Générer bulletin (déverrouillé) -->
          <div class="action-tile group relative flex flex-col rounded-2xl border-2 border-slate-200 bg-white p-5 shadow-sm transition-all hover:border-primary/40 hover:shadow-md hover:scale-[1.02]" data-action="generate_bulletin">
            <div class="flex items-start justify-between">
              <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-slate-100 text-primary transition group-hover:scale-110">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h10v18l-5-3-5 3V3Z" />
                </svg>
              </span>
              <span class="bg-success/10 text-success text-xs font-bold px-2 py-1 rounded-full">ACTIF</span>
            </div>
            <span class="mt-3 font-heading font-bold text-slate-900">Générer bulletin</span>
            <span class="mt-1 text-xs text-slate-500">PDF prêt à imprimer</span>
          </div>
        </div>
      </section>

      <!-- Graphique + Activité -->
      <div class="mt-8 grid gap-6 lg:grid-cols-2">
        <!-- Graphique -->
        <section class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm sm:p-6">
          <h2 class="font-heading text-lg font-bold text-slate-900">Activité de saisie</h2>
          <p class="mt-1 text-xs text-slate-500">Notes enregistrées par jour (lundi → dimanche)</p>
          <div class="mt-4 h-56">
            <canvas id="chart-saisies"></canvas>
          </div>
        </section>

        <!-- Activité récente -->
        <section class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm sm:p-6">
          <div class="flex items-center justify-between mb-4">
            <div>
              <h2 class="font-heading text-lg font-bold text-slate-900">Activité récente</h2>
              <p class="text-xs text-slate-500">Vos dernières actions</p>
            </div>
            <div class="flex gap-2">
              <button class="filter-btn text-xs px-3 py-1 rounded-full border border-slate-200 hover:border-primary transition-all" data-filter="all">Tous</button>
              <button class="filter-btn text-xs px-3 py-1 rounded-full border border-slate-200 hover:border-primary transition-all" data-filter="notes">Notes</button>
              <button class="filter-btn text-xs px-3 py-1 rounded-full border border-slate-200 hover:border-primary transition-all" data-filter="payments">Paiements</button>
              <button class="filter-btn text-xs px-3 py-1 rounded-full border border-slate-200 hover:border-primary transition-all" data-filter="students">Élèves</button>
            </div>
          </div>
          
          <ul class="divide-y divide-slate-100" id="activity-list">
            <li class="activity-item flex flex-wrap items-start justify-between gap-2 py-3 first:pt-0" data-type="notes">
              <div class="flex gap-3">
                <div class="flex-shrink-0 mt-1">
                  <div class="h-8 w-8 rounded-full bg-primary/10 flex items-center justify-center">
                    <svg class="h-4 w-4 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M6 4h12l2 4v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8l2-4Z" />
                    </svg>
                  </div>
                </div>
                <div>
                  <p class="font-medium text-slate-900">Saisie de notes · 4e A · Mathématiques</p>
                  <p class="text-xs text-slate-500">Aujourd'hui, 09:42</p>
                </div>
              </div>
              <span class="rounded-full bg-primary/10 px-2 py-0.5 text-xs font-semibold text-primary">Notes</span>
            </li>
            <li class="activity-item flex flex-wrap items-start justify-between gap-2 py-3" data-type="payments">
              <div class="flex gap-3">
                <div class="flex-shrink-0 mt-1">
                  <div class="h-8 w-8 rounded-full bg-emerald-100 flex items-center justify-center">
                    <svg class="h-4 w-4 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M3.5 8.5h17M6 5h12a2.5 2.5 0 0 1 2.5 2.5v9A2.5 2.5 0 0 1 18 19H6a2.5 2.5 0 0 1-2.5-2.5v-9A2.5 2.5 0 0 1 6 5Z" />
                    </svg>
                  </div>
                </div>
                <div>
                  <p class="font-medium text-slate-900">Paiement · Gnonlonfoun Raïssa · 40&nbsp;000&nbsp;F</p>
                  <p class="text-xs text-slate-500">Hier, 16:18</p>
                </div>
              </div>
              <span class="rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700">Paiement</span>
            </li>
            <li class="activity-item flex flex-wrap items-start justify-between gap-2 py-3" data-type="students">
              <div class="flex gap-3">
                <div class="flex-shrink-0 mt-1">
                  <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                    <svg class="h-4 w-4 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 0 0-4-4H8m0 0a4 4 0 0 1 8 0" />
                    </svg>
                  </div>
                </div>
                <div>
                  <p class="font-medium text-slate-900">Nouvel élève · Avocè Sèdjro · 6e B</p>
                  <p class="text-xs text-slate-500">31 mars, 11:05</p>
                </div>
              </div>
              <span class="rounded-full bg-blue-50 px-2 py-0.5 text-xs font-semibold text-blue-700">Élève</span>
            </li>
            <li class="activity-item flex flex-wrap items-start justify-between gap-2 py-3 last:pb-0" data-type="bulletins">
              <div class="flex gap-3">
                <div class="flex-shrink-0 mt-1">
                  <div class="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center">
                    <svg class="h-4 w-4 text-purple-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3.75h10.5l3 4.5v9.75a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25l3-4.5Z" />
                    </svg>
                  </div>
                </div>
                <div>
                  <p class="font-medium text-slate-900">Bulletin généré · Tle D · Trimestre 2</p>
                  <p class="text-xs text-slate-500">30 mars, 15:30</p>
                </div>
              </div>
              <span class="rounded-full bg-purple-50 px-2 py-0.5 text-xs font-semibold text-purple-700">Bulletin</span>
            </li>
          </ul>
        </section>
      </div>

      <footer class="mt-12 pb-8 text-center text-xs text-slate-400">
        EduManager — Collège Saint-Michel · Productivité & Efficacité
      </footer>
    </main>
  </div>

  <script>
    (function () {
      // Menu mobile
      var sidebar = document.getElementById("sidebar");
      var overlay = document.getElementById("sidebar-overlay");
      var btnMenu = document.getElementById("btn-menu");
      function openMenu() { sidebar.classList.remove("-translate-x-full"); overlay.classList.add("is-open"); document.body.style.overflow = "hidden"; }
      function closeMenu() { sidebar.classList.add("-translate-x-full"); overlay.classList.remove("is-open"); document.body.style.overflow = ""; }
      if (btnMenu) btnMenu.addEventListener("click", openMenu);
      if (overlay) overlay.addEventListener("click", closeMenu);
      window.addEventListener("resize", function () { if (window.innerWidth >= 1024) closeMenu(); });

      // Rendre toutes les actions rapides fonctionnelles (alertes pour démo)
      function handleAction(actionName) {
        // Ici vous pouvez remplacer par des redirections réelles ou des modales
        alert(`🔧 Action déclenchée : ${actionName}\n(Fonctionnalité à connecter à votre backend)`);
        // Exemple de redirection possible :
        // window.location.href = `/${actionName}.php`;
      }

      // Actions rapides (tuiles)
      document.querySelectorAll('.action-tile').forEach(tile => {
        tile.addEventListener('click', (e) => {
          const action = tile.getAttribute('data-action');
          if (action) handleAction(action);
        });
      });

      

      // Éléments prioritaires (tâches)
      document.querySelectorAll('.priority-item').forEach(item => {
        item.addEventListener('click', () => {
          const text = item.querySelector('.font-semibold')?.innerText || 'tâche';
          handleAction(text);
        });
      });

      // Liens du menu latéral (sauf tableau de bord et déconnexion)
      document.querySelectorAll('.sidebar-link[data-nav]').forEach(link => {
        if (link.getAttribute('data-nav') === 'dashboard') return;
        link.addEventListener('click', (e) => {
          e.preventDefault();
          const nav = link.getAttribute('data-nav');
          handleAction(`Navigation vers ${nav}`);
        });
      });

      // Filtres activité
      var filterBtns = document.querySelectorAll('.filter-btn');
      var activityItems = document.querySelectorAll('.activity-item');
      
      filterBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
          var filter = this.getAttribute('data-filter');
          filterBtns.forEach(function(b) { b.classList.remove('active', 'bg-primary', 'text-white', 'border-primary'); });
          this.classList.add('active', 'bg-primary', 'text-white', 'border-primary');
          
          activityItems.forEach(function(item) {
            if (filter === 'all' || item.getAttribute('data-type') === filter) {
              item.style.display = '';
            } else {
              item.style.display = 'none';
            }
          });
        });
      });
      // Activer filtre "Tous" par défaut
      var defaultFilter = document.querySelector('[data-filter="all"]');
      if (defaultFilter) defaultFilter.classList.add('active', 'bg-primary', 'text-white', 'border-primary');

      // Chart.js
      if (typeof Chart !== "undefined") {
        Chart.defaults.font.family = "'Outfit', sans-serif";
        Chart.defaults.color = "#64748b";
        new Chart(document.getElementById("chart-saisies"), {
          type: "bar",
          data: {
            labels: ["Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim"],
            datasets: [{
              label: "Notes saisies",
              data: [5, 8, 12, 6, 10, 2, 0],
              backgroundColor: ["#7300e9", "#7300e9", "#99fbe3", "#7300e9", "#7300e9", "rgba(115, 0, 233, 0.45)", "rgba(153, 251, 227, 0.7)"],
              borderRadius: 8,
              maxBarThickness: 32
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: true, position: "bottom" } },
            scales: {
              y: { beginAtZero: true, ticks: { stepSize: 2 }, grid: { color: "rgba(148,163,184,0.2)" } },
              x: { grid: { display: false } }
            }
          }
        });
      }
    })();
  </script>
</body>
</html>