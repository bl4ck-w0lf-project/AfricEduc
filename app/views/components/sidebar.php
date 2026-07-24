<?php
$role = $_SESSION['user_role'];
$currentPage = $_GET['url'] ?? 'dashboard';
$baseUrl = "/AfricEduc/public/index.php?url=";

$userNom = $_SESSION['user_name'] ?? 'Administrateur';
$userPhoto = $_SESSION['user_avatar'] ?? '';
$userRole = $_SESSION['role'] ?? 'admin';
$userSchool = $_SESSION['school_name'] ?? '';

$roleLabels = [
    'super_admin' => 'Super Admin',
    'admin' => 'Administrateur',
    'agent' => 'Secrétaire'
];
$roleDisplay = $roleLabels[$userRole] ?? ucfirst($userRole);

$roleColors = [
    'super_admin' => 'text-amber-600',
    'admin' => 'text-emerald-600',
    'agent' => 'text-blue-600'
];
$roleColor = $roleColors[$userRole] ?? 'text-gray-500';

$roleIcons = [
    'super_admin' => 'fa-crown',
    'admin' => 'fa-user-tie',
    'agent' => 'fa-user-headset'
];
$roleIcon = $roleIcons[$userRole] ?? 'fa-user';

$words = explode(' ', trim($userNom));
$initials = '';
foreach ($words as $w) {
    $initials .= strtoupper($w[0] ?? '');
}
$initials = substr($initials, 0, 2);
            
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AfricEduc Sidebar</title>

<!-- TAILWIND -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- FONT AWESOME -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- GOOGLE FONTS -->
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">

<style>
body { font-family: "Outfit", sans-serif; }
h1,h2,h3,h4 { font-family: "Quicksand", sans-serif; }

.sidebar-link {
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 16px;
    border-radius: 12px;
    color: #475569;
    font-weight: 500;
    font-size: 0.875rem;
}

.sidebar-link i {
    width: 20px;
    text-align: center;
    font-size: 1rem;
    color: #94a3b8;
    transition: color 0.2s ease;
}

.sidebar-link:hover {
    background-color: #f1f5f9;
    color: #7300e9;
    transform: translateX(4px);
}

.sidebar-link:hover i {
    color: #7300e9;
}

.sidebar-link.active {
    background-color: #f3e8ff;
    color: #7300e9;
}

.sidebar-link.active i {
    color: #7300e9;
}

.sidebar-link.text-red-300:hover {
    background-color: #fef2f2;
    color: #dc2626;
}

.sidebar-link.text-red-300:hover i {
    color: #dc2626;
}

.sidebar-section-title {
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #94a3b8;
    padding: 0 16px;
    margin-top: 24px;
    margin-bottom: 8px;
}

/* ===== SIDEBAR MOBILE ===== */
#sidebar {
    transform: translateX(-100%);
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

#sidebar.is-open {
    transform: translateX(0);
}

/* ===== DESKTOP ===== */
@media (min-width: 1024px) {
    #sidebar {
        transform: translateX(0) !important;
    }
}

/* ===== OVERLAY ===== */
#sidebar-overlay {
    pointer-events: none;
    opacity: 0;
    transition: opacity 0.3s ease;
}

#sidebar-overlay.is-open {
    pointer-events: auto;
    opacity: 1;
}
</style>

</head>

<body class="bg-slate-100">

<!-- BOUTON HAMBURGER -->
<button id="sidebar-toggle" type="button"
    class="fixed top-4 left-4 z-[60] lg:hidden w-11 h-11 rounded-xl bg-primary text-white shadow-xl flex items-center justify-center hover:bg-primaryDark transition">
    <i class="fa-solid fa-bars text-lg"></i>
</button>

<div id="sidebar-overlay" class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden"></div>

<!-- SIDEBAR - FOND BLANC -->
<aside id="sidebar" class="fixed left-0 top-0 w-[270px] h-screen bg-white border-r border-gray-200 shadow-lg flex flex-col z-50">

    <!-- LOGO -->
    <div class="flex flex-col items-start gap-0 h-auto py-4 px-5 border-b border-gray-200">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-primary/10 text-primary">
                <i class="fa-solid fa-graduation-cap text-lg"></i>
            </div>
            <h1 class="text-xl font-bold text-slate-900">Afric<span class="text-primary">Educ</span></h1>
        </div>
        <p class="text-[10px] uppercase text-gray-400 font-medium mt-1 pl-1">Plateforme de gestion scolaire</p>
    </div>

    <nav class="flex-1 overflow-y-auto px-3 py-4 text-sm">

        <!-- SUPER ADMIN -->
        <?php if($role === 'super_admin'): ?>

        <a href="<?= $baseUrl ?>dashboard"
         class="sidebar-link <?= $currentPage === 'dashboard' ? 'active' : '' ?>">
            <i class="fa-solid fa-chart-area"></i> Tableau de bord
        </a>

        <div class="sidebar-section-title">Mon école</div>

        <a href="<?= $baseUrl ?>setup_school"
           class="sidebar-link <?= $currentPage === 'setup_school.php' ? 'active' : '' ?>">
            <i class="fa-solid fa-sliders"></i> Configuration de mon école
        </a>

        <a href="../school_identity/index.php" class="sidebar-link">
            <i class="fa-solid fa-building-columns"></i> Identité & contact
        </a>

        <div class="sidebar-section-title">Organisation</div>

        <a href="../classes/index.php" class="sidebar-link">
            <i class="fa-solid fa-layer-group"></i> Classes / Groupes
        </a>

        <a href="../matieres/index.php" class="sidebar-link">
            <i class="fa-solid fa-book-open"></i> Matières
        </a>

        <a href="../students/index.php" class="sidebar-link">
            <i class="fa-solid fa-user-graduate"></i> Élèves
        </a>

        <a href="../notes/index.php" class="sidebar-link">
            <i class="fa-solid fa-pen-to-square"></i> Notes & Moyennes
        </a>

        <a href="../paiements/index.php" class="sidebar-link">
            <i class="fa-solid fa-coins"></i> Paiements
        </a>

        <a href="../agents/index.php" class="sidebar-link">
            <i class="fa-solid fa-users-gear"></i> Agents
        </a>

        <a href="../agents/index.php" class="sidebar-link">
            <i class="fa-solid fa-chalkboard-user"></i> Professeurs
        </a>

        <a href="../bulletins/index.php" class="sidebar-link">
            <i class="fa-solid fa-file-pdf"></i> Bulletins
        </a>

        <a href="../stats_admin/index.php" class="sidebar-link">
            <i class="fa-solid fa-chart-pie"></i> Statistiques
        </a>

        <a href="../stats_admin/index.php" class="sidebar-link">
            <i class="fa-solid fa-user-cog"></i> Mon compte administrateur
        </a>

        <?php endif; ?>

        <!-- ADMIN -->
        <?php if($role === 'admin'): ?>

        <a href="<?= $baseUrl ?>dashboard_admin"
         class="sidebar-link <?= $currentPage === 'dashboard_admin' ? 'active' : '' ?>">
            <i class="fa-solid fa-chart-area"></i> Tableau de bord
        </a>

        <div class="sidebar-section-title">Mon école</div>

        <a href="<?= $baseUrl ?>setup_school"
           class="sidebar-link <?= $currentPage === 'setup_school' ? 'active' : '' ?>">
            <i class="fa-solid fa-sliders"></i> Configuration de mon école
        </a>

        <a href="<?= $baseUrl ?>school_identity" 
            class="sidebar-link <?= $currentPage === 'school_identity' ? 'active' : '' ?>">
            <i class="fa-solid fa-building-columns"></i> Identité & contact
        </a>

        <div class="sidebar-section-title">Organisation</div>

        <a href="<?= $baseUrl ?>classes" 
            class="sidebar-link <?= $currentPage === 'classes' ? 'active' : '' ?>">
            <i class="fa-solid fa-layer-group"></i> Classes / Groupes
        </a>

        <a href="<?= $baseUrl ?>matieres" 
            class="sidebar-link <?= $currentPage === 'matieres' ? 'active' : '' ?>">
            <i class="fa-solid fa-book-open"></i> Matières
        </a>

        <a href="../students/index.php" class="sidebar-link">
            <i class="fa-solid fa-user-graduate"></i> Élèves
        </a>

        <a href="../notes/index.php" class="sidebar-link">
            <i class="fa-solid fa-pen-to-square"></i> Notes & Moyennes
        </a>

        <a href="../paiements/index.php" class="sidebar-link">
            <i class="fa-solid fa-coins"></i> Paiements
        </a>

        <a href="../agents/index.php" class="sidebar-link">
            <i class="fa-solid fa-users-gear"></i> Agents
        </a>

        <a href="../agents/index.php" class="sidebar-link">
            <i class="fa-solid fa-chalkboard-user"></i> Professeurs
        </a>

        <a href="../bulletins/index.php" class="sidebar-link">
            <i class="fa-solid fa-file-pdf"></i> Bulletins
        </a>

        <a href="../stats_admin/index.php" class="sidebar-link">
            <i class="fa-solid fa-chart-pie"></i> Statistiques
        </a>

        <a href="<?= $baseUrl ?>admin_settings" 
            class="sidebar-link <?= $currentPage === 'admin_settings' ? 'active' : '' ?>">
            <i class="fa-solid fa-user-cog"></i> Mon compte administrateur
        </a>

        <?php endif; ?>

        <!-- AGENT -->
        <?php if($role === 'agent'): ?>

        <a href="#" class="sidebar-link active">
            <i class="fa-solid fa-gauge-high"></i> Tableau de bord
        </a>

        <a href="../students/index.php" class="sidebar-link">
            <i class="fa-solid fa-user-graduate"></i> Élèves
        </a>

        <a href="../notes/index.php" class="sidebar-link">
            <i class="fa-solid fa-pen-to-square"></i> Notes & Moyennes
        </a>

        <a href="../paiements/index.php" class="sidebar-link">
            <i class="fa-solid fa-coins"></i> Paiements
        </a>

        <a href="../bulletins/index.php" class="sidebar-link">
            <i class="fa-solid fa-chalkboard-user"></i> Professeurs
        </a>

        <a href="../stats_agents/index.php" class="sidebar-link">
            <i class="fa-solid fa-file-pdf"></i> Bulletins
        </a>

        <?php endif; ?>

        <!-- PROFIL & LOGOUT -->
        <div class="mt-8 border-t border-gray-200 pt-4">
            
            
            <!-- Infos utilisateur -->
            <div class="flex items-center gap-3 px-3 py-2.5 mb-2 bg-gray-50 rounded-xl hover:bg-gray-100 transition cursor-default">
                <!-- Avatar -->
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary to-primaryDark flex items-center justify-center text-white font-bold text-sm flex-shrink-0 overflow-hidden">
                    <?php if (!empty($userPhoto)): ?>
                        <img src="<?= htmlspecialchars($userPhoto) ?>" 
                             alt="Photo de profil" 
                             class="w-full h-full object-cover">
                    <?php else: ?>
                        <?= $initials ?>
                    <?php endif; ?>
                </div>
                
                <!-- Infos -->
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-900 truncate">
                        <?= htmlspecialchars($userNom) ?>
                    </p>
                    <p class="text-xs <?= $roleColor ?> truncate flex items-center gap-1">
                        <i class="fas <?= $roleIcon ?> text-[10px]"></i>
                        <?= $roleDisplay ?>
                    </p>
                    <?php if (!empty($userSchool)): ?>
                        <p class="text-[10px] text-gray-400 truncate flex items-center gap-1">
                            <i class="fa-solid fa-school text-[10px]"></i>
                            <?= htmlspecialchars($userSchool) ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Déconnexion -->
            <a href="<?= $baseUrl ?>logout" class="sidebar-link text-red-500 hover:bg-red-50 hover:text-red-700 group">
                <i class="fa-solid fa-right-from-bracket group-hover:scale-110 transition"></i> 
                <span>Déconnexion</span>
            </a>
        </div>

    </nav>
</aside>

<script>
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('sidebar-overlay');
const toggleBtn = document.getElementById('sidebar-toggle');

function openSidebar() {
    sidebar.classList.add('is-open');
    overlay.classList.add('is-open');
    document.body.classList.add('overflow-hidden');
    toggleBtn.style.display = 'none';
}

function closeSidebar() {
    sidebar.classList.remove('is-open');
    overlay.classList.remove('is-open');
    document.body.classList.remove('overflow-hidden');
    toggleBtn.style.display = 'flex';
}

/* Toggle hamburger */
toggleBtn.addEventListener('click', () => {
    if (sidebar.classList.contains('is-open')) {
        closeSidebar();
    } else {
        openSidebar();
    }
});

/* click overlay */
overlay.addEventListener('click', closeSidebar);

/* click link => close on mobile */
document.querySelectorAll('#sidebar a').forEach(link => {
    link.addEventListener('click', () => {
        if (window.innerWidth < 1024) {
            closeSidebar();
        }
    });
});

window.addEventListener('resize', () => {
    if (window.innerWidth >= 1024) {
        sidebar.classList.remove('is-open');
        overlay.classList.remove('is-open');
        document.body.classList.remove('overflow-hidden');
        toggleBtn.style.display = 'none';
    } else {
        toggleBtn.style.display = 'flex';
    }
});
</script>

</body>
</html>