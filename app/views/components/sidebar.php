<?php
$role = $_SESSION['user_role'];
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
body{font-family:"Outfit",sans-serif}
h1,h2,h3,h4{font-family:"Quicksand",sans-serif}

.sidebar-link{
    transition: all .2s ease;
}
.sidebar-link:hover{
    background-color: rgba(255,255,255,0.1);
    transform: translateX(4px);
}
.sidebar-link.active{
    background-color: rgba(153,251,227,0.2);
    color: #99fbe3;
    border-left: 3px solid #99fbe3;
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
</style>

</head>

<body class="bg-slate-100">
<div id="sidebar-overlay" class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden"></div>

<aside class="fixed left-0 top-0 w-[270px] h-full bg-gradient-to-b from-purple-700 to-purple-900 text-white shadow-2xl flex flex-col">

<!-- LOGO -->
<div class="flex items-center gap-3 h-16 px-4 border-b border-white/20">
    <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-white/20">
        <i class="fa-solid fa-graduation-cap"></i>
    </div>
    <h1 class="text-xl font-bold">AfricEduc</h1>
</div>

<nav class="flex-1 overflow-y-auto px-3 py-6 text-sm">

<!-- ADMIN -->
<?php if($role === 'admin'): ?>

<a href="#" class="sidebar-link active flex items-center gap-3 px-3 py-2.5 rounded-xl">
    <i class="fa-solid fa-gauge"></i> Dashboard
</a>

<h4 class="mt-5 mb-2 px-3 text-xs text-white/60 uppercase">Mon école</h4>

<a href="../admin/setup_school.php" class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-lg">
    <i class="fa-solid fa-gear"></i> Configuration
</a>

<a href="../school_identity/index.php" class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-lg">
    <i class="fa-solid fa-id-card"></i> Identité & contact
</a>

<h4 class="mt-5 mb-2 px-3 text-xs text-white/60 uppercase">Organisation</h4>

<a href="../classes/index.php" class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-lg">
    <i class="fa-solid fa-school"></i> Classes / Groupes
</a>

<a href="../matieres/index.php" class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-lg">
    <i class="fa-solid fa-book"></i> Matières
</a>

<a href="../students/index.php" class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-lg">
    <i class="fa-solid fa-user-graduate"></i> Élèves
</a>

<a href="../notes/index.php" class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-lg">
    <i class="fa-solid fa-pen"></i> Notes & Moyennes
</a>

<a href="../paiements/index.php" class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-lg">
    <i class="fa-solid fa-credit-card"></i> Paiements
</a>

<a href="../agents/index.php" class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-lg">
    <i class="fa-solid fa-users"></i> Agents
</a>

<a href="../agents/index.php" class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-lg">
    <i class="fa-solid fa-users"></i> Professeurs
</a>

<a href="../bulletins/index.php" class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-lg">
    <i class="fa-solid fa-file-pdf"></i> Bulletins
</a>

<a href="../stats_admin/index.php" class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-lg">
    <i class="fa-solid fa-chart-line"></i> Statistiques
</a>

<?php endif; ?>



<!-- AGENT -->
<?php if($role === 'agent'): ?>

<a href="#" class="sidebar-link active flex items-center gap-3 px-3 py-2.5 rounded-xl">
    <i class="fa-solid fa-gauge"></i> Tableau de bord
</a>

<a href="../students/index.php" class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-lg">
    <i class="fa-solid fa-user-graduate"></i> Élèves
</a>

<a href="../notes/index.php" class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-lg">
    <i class="fa-solid fa-pen"></i> Notes & Moyennes
</a>

<a href="../paiements/index.php" class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-lg">
    <i class="fa-solid fa-credit-card"></i> Paiements
</a>

<a href="../bulletins/index.php" class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-lg">
    <i class="fa-solid fa-file-pdf"></i> Professeurs
</a>

<a href="../stats_agents/index.php" class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-lg">
    <i class="fa-solid fa-file-pdf"></i> Bulletins
</a>

<?php endif; ?>

<!-- LOGOUT -->
<div class="mt-8 border-t border-white/20 pt-4">

<a href="../auth/logout.php" class="sidebar-link flex items-center gap-3 px-3 py-2.5 text-red-300 hover:bg-red-500/20 rounded-xl">
    <i class="fa-solid fa-right-from-bracket"></i> Déconnexion
</a>

</div>

</nav>
</aside>

</body>
</html>
