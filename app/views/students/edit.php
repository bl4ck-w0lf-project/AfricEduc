<?php
/**
 * Vue modification d'un élève
 * @var array $student Données de l'élève
 * @var string $title Titre de la page
 */
 session_start();
$title = $title ?? 'Modifier l\'élève';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($title) ?> | EduManager</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: { primary: "#7300e9", primaryDark: "#5c00bd", accent: "#99fbe3", danger: "#ef4444", warning: "#f59e0b", success: "#10b981" },
          fontFamily: { heading: ["Quicksand", "sans-serif"], body: ["Outfit", "sans-serif"] }
        }
      }
    };
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: "Outfit", sans-serif; }
    h1, h2, h3, .font-heading { font-family: "Quicksand", sans-serif; }
    .sidebar-link { transition: all 0.2s ease; }
    .sidebar-link:hover { background-color: rgba(255,255,255,0.1); transform: translateX(4px); }
    .sidebar-link.active { background-color: rgba(153,251,227,0.2); color: #99fbe3; border-left: 3px solid #99fbe3; }
    .submenu { max-height: 0; overflow: hidden; transition: max-height 0.35s ease; }
    .submenu.open { max-height: 320px; }
    #sidebar-overlay { pointer-events: none; opacity: 0; transition: opacity 0.2s ease; }
    #sidebar-overlay.is-open { pointer-events: auto; opacity: 1; }
    .toast { position: fixed; bottom: 20px; right: 20px; background: #1e293b; color: white; padding: 12px 20px; border-radius: 12px; font-size: 0.875rem; z-index: 10000; opacity: 0; transition: opacity 0.3s; pointer-events: none; }
    .toast.show { opacity: 1; }
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 text-slate-800 antialiased">
  <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden"></div>

  <!-- Sidebar (identique) -->
  <?php include __DIR__ . '/../components/sidebar.php'; ?>

  <!-- Main content -->
  <div class="min-h-screen lg:pl-[260px]">
    <header class="sticky top-0 z-30 flex h-16 items-center justify-between gap-4 border-b border-slate-200 bg-white/95 px-4 backdrop-blur-md shadow-sm sm:px-6">
      <div class="flex items-center gap-3"><button id="btn-menu" class="inline-flex rounded-xl border border-slate-200 p-2 text-slate-700 hover:bg-slate-50 lg:hidden"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7h16M4 12h16M4 17h16"/></svg></button><div><p class="font-heading text-sm font-semibold text-primary sm:text-base">Collège Saint-Michel</p><p class="text-xs text-slate-500">Cotonou, Bénin</p></div></div>
      <div class="flex items-center gap-3"><span class="hidden rounded-full border border-accent/50 bg-accent/20 px-3 py-1 text-xs font-medium text-slate-800 sm:inline-flex">Année 2025–2026</span><button class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-2 py-1.5 pr-3 shadow-sm"><span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-primary to-primaryDark text-sm font-bold text-white shadow-md">AK</span><span class="hidden text-left text-sm sm:block"><span class="block font-medium text-slate-900">Aminata Kossi</span><span class="text-xs text-slate-500">Administratrice</span></span></button></div>
    </header>

    <main class="px-4 py-6 sm:px-6 lg:px-8">
      <div class="max-w-4xl mx-auto">
        <div class="mb-6">
          <h1 class="font-heading text-2xl font-bold text-slate-900 sm:text-3xl"><?= htmlspecialchars($title) ?></h1>
          <p class="mt-1 text-sm text-slate-600">Modifiez les informations de l'élève</p>
        </div>

        <form action="/students/update?id=<?= $student['id'] ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
          <input type="hidden" name="_method" value="PUT">
          
          <!-- Informations personnelles -->
          <div class="rounded-2xl border border-slate-200/80 bg-white shadow-md overflow-hidden">
            <div class="border-b border-slate-200 bg-slate-50 px-6 py-4"><h2 class="font-heading text-lg font-semibold text-slate-900">Informations personnelles</h2></div>
            <div class="p-6 space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Matricule <span class="text-red-500">*</span></label><input type="text" name="matricule" required value="<?= htmlspecialchars($student['matricule']) ?>" class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"></div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Genre <span class="text-red-500">*</span></label><select name="gender" required class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"><option value="M" <?= $student['gender'] === 'M' ? 'selected' : '' ?>>Masculin</option><option value="F" <?= $student['gender'] === 'F' ? 'selected' : '' ?>>Féminin</option></select></div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Prénom <span class="text-red-500">*</span></label><input type="text" name="firstname" required value="<?= htmlspecialchars($student['firstname']) ?>" class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"></div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Nom <span class="text-red-500">*</span></label><input type="text" name="lastname" required value="<?= htmlspecialchars($student['lastname']) ?>" class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"></div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Date de naissance</label><input type="date" name="birthdate" value="<?= htmlspecialchars($student['birthdate']) ?>" class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"></div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Lieu de naissance</label><input type="text" name="birthplace" value="<?= htmlspecialchars($student['birthplace'] ?? '') ?>" class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"></div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Nationalité</label><input type="text" name="nationality" value="<?= htmlspecialchars($student['nationality'] ?? 'Béninoise') ?>" class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"></div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Situation matrimoniale</label><select name="marital_status" class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"><option value="celibataire" <?= ($student['marital_status'] ?? '') === 'celibataire' ? 'selected' : '' ?>>Célibataire</option><option value="marie" <?= ($student['marital_status'] ?? '') === 'marie' ? 'selected' : '' ?>>Marié(e)</option><option value="divorce" <?= ($student['marital_status'] ?? '') === 'divorce' ? 'selected' : '' ?>>Divorcé(e)</option><option value="veuf" <?= ($student['marital_status'] ?? '') === 'veuf' ? 'selected' : '' ?>>Veuf/Veuve</option></select></div>
              </div>
            </div>
          </div>

          <!-- Coordonnées -->
          <div class="rounded-2xl border border-slate-200/80 bg-white shadow-md overflow-hidden">
            <div class="border-b border-slate-200 bg-slate-50 px-6 py-4"><h2 class="font-heading text-lg font-semibold text-slate-900">Coordonnées</h2></div>
            <div class="p-6 space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Email</label><input type="email" name="email" value="<?= htmlspecialchars($student['email'] ?? '') ?>" class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"></div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Téléphone</label><input type="tel" name="phone" value="<?= htmlspecialchars($student['phone'] ?? '') ?>" class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"></div>
              </div>
              <div><label class="block text-sm font-medium text-slate-700 mb-1">Adresse</label><textarea name="address" rows="2" class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"><?= htmlspecialchars($student['address'] ?? '') ?></textarea></div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Nom du parent/tuteur</label><input type="text" name="parent_name" value="<?= htmlspecialchars($student['parent_name'] ?? '') ?>" class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"></div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Téléphone du parent</label><input type="tel" name="parent_phone" value="<?= htmlspecialchars($student['parent_phone'] ?? '') ?>" class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"></div>
              </div>
            </div>
          </div>

          <!-- Informations scolaires -->
          <div class="rounded-2xl border border-slate-200/80 bg-white shadow-md overflow-hidden">
            <div class="border-b border-slate-200 bg-slate-50 px-6 py-4"><h2 class="font-heading text-lg font-semibold text-slate-900">Informations scolaires</h2></div>
            <div class="p-6 space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-slate-700 mb-1">ID École <span class="text-red-500">*</span></label><input type="number" name="school_id" required value="<?= htmlspecialchars($student['school_id']) ?>" class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"></div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1">ID Classe</label><input type="number" name="class_id" value="<?= htmlspecialchars($student['class_id'] ?? '') ?>" class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"></div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Statut <span class="text-red-500">*</span></label><select name="status" required class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"><option value="actif" <?= $student['status'] === 'actif' ? 'selected' : '' ?>>Actif</option><option value="inactif" <?= $student['status'] === 'inactif' ? 'selected' : '' ?>>Inactif</option><option value="exclu" <?= $student['status'] === 'exclu' ? 'selected' : '' ?>>Exclu</option><option value="diplome" <?= $student['status'] === 'diplome' ? 'selected' : '' ?>>Diplômé</option></select></div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Date d'inscription</label><input type="date" name="enrolled_at" value="<?= htmlspecialchars($student['enrolled_at'] ?? '') ?>" class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"></div>
              </div>
              <div><label class="block text-sm font-medium text-slate-700 mb-1">Notes</label><textarea name="notes" rows="3" class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary" placeholder="Informations complémentaires..."><?= htmlspecialchars($student['notes'] ?? '') ?></textarea></div>
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Photo</label>
                <?php if (!empty($student['photo'])): ?><div class="mb-2"><img src="/uploads/<?= htmlspecialchars($student['photo']) ?>" class="h-20 w-20 rounded-xl object-cover border border-slate-200"></div><?php endif; ?>
                <input type="file" name="photo" accept="image/*" class="w-full rounded-xl border border-slate-200 px-4 py-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary file:mr-4 file:rounded-xl file:border-0 file:bg-primary/10 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-primary hover:file:bg-primary/20">
              </div>
            </div>
          </div>

          <div class="flex justify-end gap-3">
            <a href="/students" class="rounded-xl border border-slate-200 bg-white px-6 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Annuler</a>
            <button type="submit" class="rounded-xl bg-primary px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primaryDark">Mettre à jour</button>
          </div>
        </form>
      </div>
      <footer class="mt-12 pb-8 text-center text-xs text-slate-400">EduManager — Collège Saint-Michel · Modification élève</footer>
    </main>
  </div>

  <div id="toast" class="toast"></div>

  <script>
    function showToast(msg, type) { const toast = document.getElementById("toast"); toast.innerText = msg; toast.style.backgroundColor = type === "error" ? "#ef4444" : "#10b981"; toast.classList.add("show"); setTimeout(() => toast.classList.remove("show"), 3000); }
    function init() {
      document.querySelectorAll(".sidebar-toggle").forEach(btn => { const id = btn.getAttribute("data-submenu"); const panel = document.getElementById(id); const chev = btn.querySelector(".chevron"); if (panel) btn.addEventListener("click", () => { const open = panel.classList.toggle("open"); if (chev) chev.style.transform = open ? "rotate(180deg)" : ""; }); });
      const sidebar = document.getElementById("sidebar"), overlay = document.getElementById("sidebar-overlay"), btnMenu = document.getElementById("btn-menu");
      function openMenu() { sidebar.classList.remove("-translate-x-full"); overlay.classList.add("is-open"); document.body.style.overflow = "hidden"; }
      function closeMenu() { sidebar.classList.add("-translate-x-full"); overlay.classList.remove("is-open"); document.body.style.overflow = ""; }
      btnMenu?.addEventListener("click", openMenu); overlay?.addEventListener("click", closeMenu); window.addEventListener("resize", () => { if (window.innerWidth >= 1024) closeMenu(); });
    }
    init();
  </script>
</body>
</html>
