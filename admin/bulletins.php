<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
  <title>Bulletins & Documents | EduManager</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: { primary: "#7300e9", primaryDark: "#5c00bd", accent: "#99fbe3", danger: "#ef4444", warning: "#f59e0b", success: "#10b981" },
          fontFamily: { heading: ["Quicksand", "sans-serif"], body: ["Outfit", "sans-serif"] },
          animation: { 'fade-in': 'fadeIn 0.3s ease-in-out' },
          keyframes: { fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } } }
        }
      }
    };
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
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
    .kpi-card { transition: all 0.2s ease; }
    .kpi-card:hover { transform: translateY(-2px); box-shadow: 0 12px 24px -12px rgba(0,0,0,0.15); }
    .action-button { transition: all 0.2s ease; }
    .action-button:hover { transform: scale(1.05); }
    .modal-overlay { pointer-events: none; opacity: 0; transition: opacity 0.2s ease; position: fixed; inset: 0; z-index: 9999; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; }
    .modal-overlay.is-open { pointer-events: auto; opacity: 1; }
    .modal-content { transform: scale(0.95); transition: transform 0.2s ease; max-width: 95%; width: 64rem; background: white; border-radius: 1rem; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); max-height: 85vh; overflow-y: auto; }
    @media (min-width: 640px) { .modal-content { max-width: 90%; } }
    .modal-overlay.is-open .modal-content { transform: scale(1); }
    .toast { position: fixed; bottom: 20px; right: 20px; background: #1e293b; color: white; padding: 12px 20px; border-radius: 12px; font-size: 0.875rem; z-index: 10000; opacity: 0; transition: opacity 0.3s; pointer-events: none; }
    .toast.show { opacity: 1; }
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 text-slate-800 antialiased">
  <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden"></div>

  <!-- Sidebar (identique) -->
  <aside id="sidebar" class="fixed left-0 top-0 z-50 flex h-full w-[260px] -translate-x-full flex-col bg-gradient-to-b from-primary to-primaryDark text-white shadow-2xl transition-transform duration-300 lg:translate-x-0">
    <div class="flex h-16 items-center gap-3 border-b border-white/20 px-4">
      <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/20 shadow-lg">
        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 6.75C4 5.78 4.78 5 5.75 5h4.5c.46 0 .9.18 1.22.51l.56.56c.33.33.77.51 1.24.51h5.98c.97 0 1.75.78 1.75 1.75v8.92c0 .97-.78 1.75-1.75 1.75H5.75A1.75 1.75 0 0 1 4 17.25V6.75Z"/><path d="M8 11.5h8M8 14.5h5"/></svg>
      </span>
      <span class="font-heading text-xl font-bold tracking-tight">EduManager</span>
    </div>
    <nav class="flex-1 overflow-y-auto px-3 py-6 text-sm">
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 mb-1">
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3.75 6A2.25 2.25 0 0 1 6 3.75h3A2.25 2.25 0 0 1 11.25 6v3A2.25 2.25 0 0 1 9 11.25H6A2.25 2.25 0 0 1 3.75 9V6ZM3.75 15A2.25 2.25 0 0 1 6 12.75h3A2.25 2.25 0 0 1 11.25 15v3A2.25 2.25 0 0 1 9 20.25H6A2.25 2.25 0 0 1 3.75 18v-3ZM13.5 6A2.25 2.25 0 0 1 15.75 3.75h3A2.25 2.25 0 0 1 21 6v3A2.25 2.25 0 0 1 18.75 11.25h-3A2.25 2.25 0 0 1 13.5 9V6ZM13.5 15A2.25 2.25 0 0 1 15.75 12.75h3A2.25 2.25 0 0 1 21 15v3A2.25 2.25 0 0 1 18.75 20.25h-3A2.25 2.25 0 0 1 13.5 18v-3Z"/></svg>
        Dashboard
      </a>
      <div class="mt-2">
        <button type="button" class="sidebar-toggle flex w-full items-center justify-between gap-2 rounded-xl px-3 py-2.5 text-left text-white/95 hover:bg-white/10" data-submenu="sub-ecole">
          <span class="flex items-center gap-3"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19.5V8.25L12 4l8 4.25V19.5"/><path d="M9 19.5V12h6v7.5"/></svg>Mon école</span>
          <svg class="chevron h-4 w-4 transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
        </button>
        <div id="sub-ecole" class="submenu open pl-2">
          <a href="#" class="sidebar-link mt-1 block rounded-lg py-2 pl-10 pr-3">Configuration</a>
          <a href="#" class="sidebar-link block rounded-lg py-2 pl-10 pr-3">Identité & contact</a>
        </div>
      </div>
      <div class="mt-1">
        <button type="button" class="sidebar-toggle flex w-full items-center justify-between gap-2 rounded-xl px-3 py-2.5 text-left text-white/95 hover:bg-white/10" data-submenu="sub-org">
          <span class="flex items-center gap-3"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3.75 21h16.5M4.5 3h15A1.5 1.5 0 0 1 21 4.5v13.5A1.5 1.5 0 0 1 19.5 19.5h-15A1.5 1.5 0 0 1 4.5 18v-13.5A1.5 1.5 0 0 1 4.5 3zm4.5 4.5h3M9 12h3m-3 4.5h3M15 7.5h3M15 12h3m-3 4.5h3"/></svg>Organisation</span>
          <svg class="chevron h-4 w-4 transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
        </button>
        <div id="sub-org" class="submenu open pl-2">
          <a href="#" class="sidebar-link mt-1 block rounded-lg py-2 pl-10 pr-3">Classes / Groupes</a>
          <a href="#" class="sidebar-link block rounded-lg py-2 pl-10 pr-3">Matières</a>
        </div>
      </div>
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 mt-1" id="nav-eleves">
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 17a4 4 0 1 1 8 0"/><path d="M15 11a3 3 0 1 0-6 0 3 3 0 0 0 6 0Z"/></svg>
        <span id="nav-eleves-label">Élèves</span>
      </a>
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">Notes & Moyennes</a>
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">Scolarité & Paiements</a>
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">Agents</a>
      <a href="#" class="sidebar-link active flex items-center gap-3 rounded-xl px-3 py-2.5">Bulletins & Documents</a>
      <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5">Statistiques</a>
      <div class="mt-8 border-t border-white/15 pt-4">
        <a href="#" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 text-red-200 hover:bg-red-500/20">Déconnexion</a>
      </div>
    </nav>
  </aside>

  <!-- Main content -->
  <div class="min-h-screen lg:pl-[260px]">
    <header class="sticky top-0 z-30 flex h-16 items-center justify-between gap-4 border-b border-slate-200 bg-white/95 px-4 backdrop-blur-md shadow-sm sm:px-6">
      <div class="flex items-center gap-3">
        <button id="btn-menu" class="inline-flex rounded-xl border border-slate-200 p-2 text-slate-700 hover:bg-slate-50 lg:hidden"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7h16M4 12h16M4 17h16"/></svg></button>
        <div><p class="font-heading text-sm font-semibold text-primary sm:text-base" id="school-name-header">Collège Saint-Michel</p><p class="text-xs text-slate-500" id="school-location">Cotonou, Bénin</p></div>
      </div>
      <div class="flex items-center gap-3">
        <div id="type-switch" class="hidden md:flex gap-1 bg-slate-100 p-1 rounded-lg">
          <button id="switch-college" class="px-2 py-1 text-xs font-semibold rounded bg-primary text-white">Collège</button>
          <button id="switch-universite" class="px-2 py-1 text-xs font-semibold rounded text-slate-600 hover:bg-slate-200">Université</button>
        </div>
        <span class="hidden rounded-full border border-accent/50 bg-accent/20 px-3 py-1 text-xs font-medium text-slate-800 sm:inline-flex" id="school-year">Année 2025–2026</span>
        <button class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-2 py-1.5 pr-3 shadow-sm">
          <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-primary to-primaryDark text-sm font-bold text-white shadow-md">AK</span>
          <span class="hidden text-left text-sm sm:block"><span class="block font-medium text-slate-900">Aminata Kossi</span><span class="text-xs text-slate-500">Administratrice</span></span>
        </button>
      </div>
    </header>

    <main class="px-4 py-6 sm:px-6 lg:px-8">
      <div id="dynamic-content"></div>
      <footer class="mt-12 pb-8 text-center text-xs text-slate-400">
        EduManager — <span id="footer-school">Collège Saint-Michel</span> · Dernière mise à jour : <span id="last-update"></span>
      </footer>
    </main>
  </div>

  <!-- Modale générique -->
  <div id="modal-generic" class="modal-overlay"><div class="modal-content bg-white rounded-2xl shadow-2xl p-4 sm:p-6"><div class="flex justify-between items-center mb-4"><h3 class="font-heading text-xl font-bold text-slate-900" id="modal-title">Titre</h3><button id="close-modal" class="text-slate-400 hover:text-slate-600"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg></button></div><div id="modal-body" class="text-slate-700"></div><div class="mt-6 flex justify-end"><button id="modal-close-btn" class="rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white">Fermer</button></div></div></div>

  <div id="toast" class="toast"></div>

  <script>
    (function () {
      // ==================== DONNÉES ENRICHIES ====================
      const collegeData = {
        schoolName: "Collège Saint-Michel",
        schoolLocation: "Cotonou, Bénin",
        students: [
          { id: 1, nom: "KOUADIO", prenom: "Marie", classe: "3ème", etablissement: "Collège Saint-Michel", matricule: "CSM-001" },
          { id: 2, nom: "TRAORÉ", prenom: "Ibrahim", classe: "Seconde", etablissement: "Lycée Béhanzin", matricule: "LB-045" },
          { id: 3, nom: "DIALLO", prenom: "Aminata", classe: "Terminale", etablissement: "Université Partenaire Atlantique", matricule: "UPA-234" },
          { id: 4, nom: "N'GUESSAN", prenom: "Koffi", classe: "4ème", etablissement: "Cours Secondaire Ste Thérèse", matricule: "CST-089" },
          { id: 5, nom: "HOUNDONOU", prenom: "Jules", classe: "5ème", etablissement: "École Le Savoir", matricule: "ELS-067" }
        ],
        bulletins: [
          { 
            id: 101, studentId: 1, date: "2026-02-10", trimestre: "2ème Trimestre", periode: "Trimestre 2",
            matieres: [
              { nom: "Mathématiques", coeff: 3, notes: [{ type: "Interro", note: 14, coeff: 1 }, { type: "Devoir", note: 16, coeff: 2 }] },
              { nom: "Français", coeff: 2, notes: [{ type: "Interro", note: 12, coeff: 1 }, { type: "Devoir", note: 15, coeff: 1 }] }
            ],
            conduite: 18, appreciation: "Très bon trimestre, élève sérieuse."
          },
          { 
            id: 102, studentId: 1, date: "2025-12-05", trimestre: "1er Trimestre", periode: "Trimestre 1",
            matieres: [
              { nom: "Mathématiques", coeff: 3, notes: [{ type: "Interro", note: 13, coeff: 1 }, { type: "Devoir", note: 14, coeff: 2 }] },
              { nom: "Français", coeff: 2, notes: [{ type: "Interro", note: 11, coeff: 1 }, { type: "Devoir", note: 13, coeff: 1 }] }
            ],
            conduite: 17, appreciation: "Bon début d'année."
          },
          { 
            id: 103, studentId: 2, date: "2026-01-20", trimestre: "1er Trimestre", periode: "Trimestre 1",
            matieres: [
              { nom: "Mathématiques", coeff: 3, notes: [{ type: "Interro", note: 10, coeff: 1 }, { type: "Devoir", note: 12, coeff: 2 }] },
              { nom: "Physique-Chimie", coeff: 2, notes: [{ type: "Interro", note: 8, coeff: 1 }] }
            ],
            conduite: 14, appreciation: "Des efforts à fournir en physique."
          }
        ]
      };

      const universityData = {
        schoolName: "Université d'Abomey-Calavi",
        schoolLocation: "Abomey-Calavi, Bénin",
        students: [
          { id: 1, nom: "KOUASSI", prenom: "Jean", classe: "Licence 1 Info", etablissement: "Université d'Abomey-Calavi", matricule: "UAC-001" },
          { id: 2, nom: "YAO", prenom: "Awa", classe: "Master 1 Droit", etablissement: "Université d'Abomey-Calavi", matricule: "UAC-002" },
          { id: 3, nom: "GNAMIEN", prenom: "Bénédicte", classe: "Licence 2 Maths", etablissement: "Université d'Abomey-Calavi", matricule: "UAC-003" },
          { id: 4, nom: "HOUNKPATIN", prenom: "Cédric", classe: "Doctorat Physique", etablissement: "Université d'Abomey-Calavi", matricule: "UAC-004" }
        ],
        bulletins: [
          { 
            id: 201, studentId: 1, date: "2026-02-12", trimestre: "Semestre 1", periode: "Semestre 1",
            matieres: [
              { nom: "Algorithmique", coeff: 4, notes: [{ type: "TP", note: 15, coeff: 1 }, { type: "Examen", note: 14, coeff: 3 }] },
              { nom: "Maths Discrètes", coeff: 3, notes: [{ type: "Examen", note: 12, coeff: 1 }] }
            ],
            conduite: 16, appreciation: "Bon début de semestre."
          },
          { 
            id: 202, studentId: 1, date: "2025-10-20", trimestre: "Semestre 2", periode: "Semestre 2",
            matieres: [
              { nom: "Algorithmique", coeff: 4, notes: [{ type: "TP", note: 16, coeff: 1 }, { type: "Examen", note: 15, coeff: 3 }] },
              { nom: "Maths Discrètes", coeff: 3, notes: [{ type: "Examen", note: 14, coeff: 1 }] }
            ],
            conduite: 17, appreciation: "En progression."
          }
        ]
      };

      let typeEtablissement = localStorage.getItem("typeEtablissement") || "college";
      let currentData = typeEtablissement === "college" ? JSON.parse(JSON.stringify(collegeData)) : JSON.parse(JSON.stringify(universityData));
      let nextBulletinId = Math.max(...currentData.bulletins.map(b => b.id), 0) + 1;

      function setType(type) {
        typeEtablissement = type;
        localStorage.setItem("typeEtablissement", type);
        currentData = type === "college" ? JSON.parse(JSON.stringify(collegeData)) : JSON.parse(JSON.stringify(universityData));
        nextBulletinId = Math.max(...currentData.bulletins.map(b => b.id), 0) + 1;
        renderPage();
        updateSwitchButtons();
        updateHeaderFooter();
      }

      function updateSwitchButtons() {
        const collegeBtn = document.getElementById("switch-college");
        const univBtn = document.getElementById("switch-universite");
        if (collegeBtn && univBtn) {
          const isUniv = typeEtablissement === "universite";
          collegeBtn.className = `px-2 py-1 text-xs font-semibold rounded ${!isUniv ? "bg-primary text-white" : "text-slate-600 hover:bg-slate-200"}`;
          univBtn.className = `px-2 py-1 text-xs font-semibold rounded ${isUniv ? "bg-primary text-white" : "text-slate-600 hover:bg-slate-200"}`;
        }
      }

      function updateHeaderFooter() {
        document.getElementById("school-name-header").innerText = currentData.schoolName;
        document.getElementById("school-location").innerText = currentData.schoolLocation;
        document.getElementById("footer-school").innerText = currentData.schoolName;
        document.getElementById("nav-eleves-label").innerText = typeEtablissement === "universite" ? "Étudiants" : "Élèves";
      }

      function showToast(msg, isError = false) {
        const toast = document.getElementById("toast");
        toast.innerText = msg;
        toast.style.backgroundColor = isError ? "#ef4444" : "#10b981";
        toast.classList.add("show");
        setTimeout(() => toast.classList.remove("show"), 3000);
      }

      function moyenneMatiere(mat) {
        let total = 0, coeffSum = 0;
        mat.notes.forEach(n => { total += n.note * n.coeff; coeffSum += n.coeff; });
        return coeffSum ? total / coeffSum : 0;
      }

      function moyenneGenerale(bulletin) {
        let total = 0, coeffSum = 0;
        bulletin.matieres.forEach(m => {
          const moy = moyenneMatiere(m);
          total += moy * m.coeff;
          coeffSum += m.coeff;
        });
        return coeffSum ? total / coeffSum : 0;
      }

      function getMention(moyenne) {
        if (moyenne >= 16) return "Très bien";
        if (moyenne >= 14) return "Bien";
        if (moyenne >= 12) return "Assez bien";
        if (moyenne >= 10) return "Passable";
        return "Insuffisant";
      }

      const modal = document.getElementById("modal-generic");
      const modalTitle = document.getElementById("modal-title");
      const modalBody = document.getElementById("modal-body");
      function openModal(title, bodyHtml) { modalTitle.innerText = title; modalBody.innerHTML = bodyHtml; modal.classList.add("is-open"); document.body.style.overflow = "hidden"; }
      function closeModal() { modal.classList.remove("is-open"); document.body.style.overflow = ""; }
      document.getElementById("close-modal")?.addEventListener("click", closeModal);
      document.getElementById("modal-close-btn")?.addEventListener("click", closeModal);
      modal?.addEventListener("click", (e) => { if (e.target === modal) closeModal(); });

      function generatePDF(bulletin) {
        const student = currentData.students.find(s => s.id === bulletin.studentId);
        if (!student) return;
        const isUniv = typeEtablissement === "universite";
        const docTitle = isUniv ? "RELEVÉ DE NOTES" : "BULLETIN SCOLAIRE";
        const moyenne = moyenneGenerale(bulletin);
        const mention = getMention(moyenne);

        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        doc.setFont("helvetica", "bold");
        doc.setFontSize(16);
        doc.text(docTitle, 105, 20, { align: "center" });
        doc.setFontSize(10);
        doc.setFont("helvetica", "normal");
        doc.text(`${currentData.schoolName} - ${currentData.schoolLocation}`, 105, 30, { align: "center" });
        doc.text(`Année scolaire : ${document.getElementById("school-year").innerText}`, 105, 36, { align: "center" });
        doc.text(`${bulletin.trimestre}`, 105, 42, { align: "center" });
        doc.setFont("helvetica", "bold");
        doc.text(isUniv ? "INFORMATIONS ÉTUDIANT" : "INFORMATIONS ÉLÈVE", 14, 52);
        doc.setFont("helvetica", "normal");
        doc.text(`Nom : ${student.nom} ${student.prenom}`, 14, 60);
        doc.text(`Matricule : ${student.matricule}`, 14, 68);
        doc.text(`${isUniv ? "Filière / Niveau" : "Classe"} : ${student.classe}`, 14, 76);

        const rows = bulletin.matieres.map(m => {
          const moy = moyenneMatiere(m);
          return [m.nom, m.coeff, moy.toFixed(2), (moy * m.coeff).toFixed(2)];
        });
        doc.autoTable({
          startY: 86,
          head: [["Matière / UE", "Coeff.", "Moyenne", "Pondérée"]],
          body: rows,
          theme: "striped",
          headStyles: { fillColor: [115,0,233], textColor: 255 }
        });

        let finalY = doc.lastAutoTable.finalY + 8;
        doc.text(`Conduite / Assiduité : ${bulletin.conduite}/20`, 14, finalY);
        doc.text(`Moyenne générale : ${moyenne.toFixed(2)} / 20`, 14, finalY + 8);
        doc.text(`Mention : ${mention}`, 14, finalY + 16);
        if (bulletin.appreciation) doc.text(`Appréciation : ${bulletin.appreciation}`, 14, finalY + 24);
        doc.save(`${isUniv ? "releve" : "bulletin"}_${student.matricule}_${bulletin.trimestre.replace(/\s+/g, '_')}.pdf`);
        showToast(`${isUniv ? "Relevé" : "Bulletin"} téléchargé`);
      }

      // Modale de création/édition avec saisie manuelle des notes (champs vides)
      function openBulletinModal(bulletin = null) {
        const isUniv = typeEtablissement === "universite";
        const studentLabel = isUniv ? "étudiant" : "élève";
        const isEdit = !!bulletin;
        const title = isEdit ? `Modifier le ${isUniv ? "relevé" : "bulletin"}` : `Nouveau ${isUniv ? "relevé" : "bulletin"}`;
        const studentOptions = currentData.students.map(s => `<option value="${s.id}" ${bulletin && bulletin.studentId === s.id ? "selected" : ""}>${s.nom} ${s.prenom} (${s.classe})</option>`).join("");

        let matieres = bulletin ? JSON.parse(JSON.stringify(bulletin.matieres)) : [];

        function renderMatieres() {
          if (!matieres.length) return `<div class="text-center py-4 text-slate-500">Aucune matière. Cliquez sur "Ajouter une matière".</div>`;
          return matieres.map((m, idx) => {
            const notesHtml = m.notes.map((n, nIdx) => `
              <div class="flex flex-wrap items-center gap-2 mb-1 p-1 bg-white rounded border">
                <select class="text-xs border rounded px-1 py-0.5 w-24" data-matidx="${idx}" data-noteidx="${nIdx}" data-field="type">${['Interro','Devoir','Examen','TP'].map(t => `<option ${n.type === t ? 'selected' : ''}>${t}</option>`).join('')}</select>
                <input type="number" value="${n.note}" step="0.1" min="0" max="20" placeholder="Note" class="w-16 text-xs border rounded px-1 py-0.5" data-matidx="${idx}" data-noteidx="${nIdx}" data-field="note">
                <label class="text-xs">coeff</label>
                <input type="number" value="${n.coeff}" step="0.5" min="0.5" placeholder="coeff" class="w-14 text-xs border rounded px-1 py-0.5" data-matidx="${idx}" data-noteidx="${nIdx}" data-field="coeff">
                <button type="button" class="text-danger text-xs hover:underline remove-note" data-matidx="${idx}" data-noteidx="${nIdx}">✕</button>
              </div>
            `).join('');
            const moyenne = moyenneMatiere(m);
            return `
              <div class="border rounded-xl p-4 mb-4 bg-slate-50/80 shadow-sm" data-matidx="${idx}">
                <div class="flex flex-wrap items-center gap-3 mb-3">
                  <input type="text" value="${m.nom}" placeholder="Nom de la matière" class="flex-1 min-w-[180px] border rounded-lg px-3 py-2 text-sm bg-white" data-matidx="${idx}" data-field="nom">
                  <label class="text-sm flex items-center gap-2">Coeff. matière <input type="number" value="${m.coeff}" step="0.5" min="0.5" class="w-20 border rounded-lg px-2 py-1.5 text-sm" data-matidx="${idx}" data-field="coeff"></label>
                  <span class="text-sm font-semibold bg-primary/10 px-3 py-1.5 rounded-lg">Moy: ${moyenne.toFixed(2)}/20</span>
                  <button type="button" class="text-danger text-sm hover:underline remove-matiere" data-matidx="${idx}"><svg class="h-4 w-4 inline" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M6 18L18 6M6 6l12 12"/></svg> Suppr.</button>
                </div>
                <div class="pl-2">
                  <div class="text-sm font-medium mb-2 flex items-center justify-between">
                    <span>Notes</span>
                    <button type="button" class="add-note text-xs bg-primary/10 text-primary px-3 py-1 rounded-full hover:bg-primary/20 transition" data-matidx="${idx}">+ Ajouter une note</button>
                  </div>
                  <div class="notes-container space-y-2">${notesHtml}</div>
                </div>
              </div>
            `;
          }).join('');
        }

        const bodyHtml = `
          <form id="bulletin-form" class="space-y-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium mb-1">${studentLabel}</label>
                <select id="bulletin-student" class="w-full rounded-xl border-slate-200 bg-white p-2.5 text-sm" ${isEdit ? 'disabled' : ''}>${studentOptions}</select>
                ${isEdit ? '<input type="hidden" name="studentId" value="' + bulletin.studentId + '">' : ''}
              </div>
              <div>
                <label class="block text-sm font-medium mb-1">${isUniv ? "Semestre" : "Trimestre"}</label>
                <input type="text" id="bulletin-trimestre" value="${bulletin?.trimestre || ''}" class="w-full rounded-xl border-slate-200 p-2.5 text-sm" placeholder="ex: 2ème Trimestre" required>
              </div>
            </div>

            <div>
              <div class="flex items-center justify-between mb-3">
                <label class="text-base font-semibold">Matières et notes</label>
                <button type="button" id="add-matiere" class="action-button inline-flex items-center gap-2 rounded-lg bg-primary/10 px-4 py-2 text-sm font-medium text-primary hover:bg-primary/20 transition">
                  <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 4.5v15m7.5-7.5h-15"/></svg>
                  Ajouter une matière
                </button>
              </div>
              <div id="matieres-container" class="max-h-96 overflow-y-auto pr-1">${renderMatieres()}</div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
              <div>
                <label class="block text-sm font-medium mb-1">Conduite / Assiduité (/20)</label>
                <input type="number" id="bulletin-conduite" value="${bulletin?.conduite || 16}" step="0.5" min="0" max="20" class="w-full rounded-xl border-slate-200 p-2.5 text-sm">
              </div>
              <div>
                <label class="block text-sm font-medium mb-1">Appréciation globale</label>
                <input type="text" id="bulletin-appreciation" value="${bulletin?.appreciation || ''}" class="w-full rounded-xl border-slate-200 p-2.5 text-sm" placeholder="Ex: Bon trimestre, des progrès...">
              </div>
            </div>

            <div class="bg-slate-100 p-4 rounded-xl text-base flex items-center justify-between">
              <span class="font-semibold">Moyenne générale calculée :</span>
              <span class="text-2xl font-bold text-primary"><span id="preview-moyenne">${bulletin ? moyenneGenerale(bulletin).toFixed(2) : '—'}</span><span class="text-sm font-normal text-slate-500">/20</span></span>
            </div>

            <div class="flex gap-3 pt-3">
              <button type="submit" class="flex-1 rounded-xl bg-primary px-5 py-3 text-sm font-semibold text-white shadow-md hover:bg-primaryDark transition">${isEdit ? "Mettre à jour" : "Créer le bulletin"}</button>
              <button type="button" id="modal-cancel" class="flex-1 rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">Annuler</button>
            </div>
          </form>
        `;
        openModal(title, bodyHtml);

        const container = document.getElementById("matieres-container");
        const previewSpan = document.getElementById("preview-moyenne");

        function recalcAndUpdatePreview() {
          const newMatieres = [];
          const matiereDivs = container.querySelectorAll('[data-matidx]');
          matiereDivs.forEach(div => {
            const nom = div.querySelector(`[data-field="nom"]`)?.value.trim();
            const coeff = parseFloat(div.querySelector(`[data-field="coeff"]`)?.value);
            const notes = [];
            div.querySelectorAll('.notes-container .flex').forEach(noteDiv => {
              const typeSelect = noteDiv.querySelector('select');
              const noteInput = noteDiv.querySelector('input[data-field="note"]');
              const coeffInput = noteDiv.querySelector('input[data-field="coeff"]');
              if (typeSelect && noteInput && coeffInput) {
                notes.push({ type: typeSelect.value, note: parseFloat(noteInput.value), coeff: parseFloat(coeffInput.value) });
              }
            });
            if (nom && !isNaN(coeff)) newMatieres.push({ nom, coeff, notes });
          });
          if (newMatieres.length) {
            let total = 0, coeffSum = 0;
            newMatieres.forEach(m => { const moy = moyenneMatiere(m); total += moy * m.coeff; coeffSum += m.coeff; });
            previewSpan.textContent = (coeffSum ? total / coeffSum : 0).toFixed(2);
          } else previewSpan.textContent = '—';
        }

        container.addEventListener("input", recalcAndUpdatePreview);
        container.addEventListener("change", recalcAndUpdatePreview);

        document.getElementById("add-matiere").addEventListener("click", () => {
          matieres.push({ nom: "", coeff: 1, notes: [] });
          container.innerHTML = renderMatieres();
          recalcAndUpdatePreview();
        });

        container.addEventListener("click", (e) => {
          if (e.target.classList.contains("remove-matiere") || e.target.closest(".remove-matiere")) {
            const btn = e.target.closest(".remove-matiere");
            const idx = btn.dataset.matidx;
            matieres.splice(idx, 1);
            container.innerHTML = renderMatieres();
            recalcAndUpdatePreview();
          } else if (e.target.classList.contains("remove-note") || e.target.closest(".remove-note")) {
            const btn = e.target.closest(".remove-note");
            const matIdx = btn.dataset.matidx;
            const noteIdx = btn.dataset.noteidx;
            if (matieres[matIdx]?.notes) matieres[matIdx].notes.splice(noteIdx, 1);
            container.innerHTML = renderMatieres();
            recalcAndUpdatePreview();
          } else if (e.target.classList.contains("add-note") || e.target.closest(".add-note")) {
            const btn = e.target.closest(".add-note");
            const matIdx = btn.dataset.matidx;
            if (matieres[matIdx]) {
              if (!matieres[matIdx].notes) matieres[matIdx].notes = [];
              matieres[matIdx].notes.push({ type: "Interro", note: "", coeff: "" });
              container.innerHTML = renderMatieres();
              recalcAndUpdatePreview();
            }
          }
        });

        document.getElementById("modal-cancel").addEventListener("click", closeModal);
        document.getElementById("bulletin-form").addEventListener("submit", (e) => {
          e.preventDefault();
          const studentId = isEdit ? bulletin.studentId : parseInt(document.getElementById("bulletin-student").value);
          const trimestre = document.getElementById("bulletin-trimestre").value.trim();
          const conduite = parseFloat(document.getElementById("bulletin-conduite").value);
          const appreciation = document.getElementById("bulletin-appreciation").value.trim();
          const finalMatieres = [];
          container.querySelectorAll('[data-matidx]').forEach(div => {
            const nom = div.querySelector(`[data-field="nom"]`)?.value.trim();
            const coeff = parseFloat(div.querySelector(`[data-field="coeff"]`)?.value);
            const notes = [];
            div.querySelectorAll('.notes-container .flex').forEach(noteDiv => {
              const typeSelect = noteDiv.querySelector('select');
              const noteInput = noteDiv.querySelector('input[data-field="note"]');
              const coeffInput = noteDiv.querySelector('input[data-field="coeff"]');
              if (typeSelect && noteInput && coeffInput) {
                const noteVal = parseFloat(noteInput.value);
                const coeffVal = parseFloat(coeffInput.value);
                if (!isNaN(noteVal) && !isNaN(coeffVal)) {
                  notes.push({ type: typeSelect.value, note: noteVal, coeff: coeffVal });
                }
              }
            });
            if (nom && !isNaN(coeff) && notes.length) finalMatieres.push({ nom, coeff, notes });
          });
          if (!studentId || !trimestre || finalMatieres.length === 0 || isNaN(conduite)) {
            showToast("Veuillez remplir tous les champs et ajouter au moins une matière avec notes valides.", true); return;
          }
          const newBulletin = { id: isEdit ? bulletin.id : nextBulletinId++, studentId, date: new Date().toISOString().split('T')[0], trimestre, periode: trimestre, matieres: finalMatieres, conduite, appreciation };
          if (isEdit) {
            const index = currentData.bulletins.findIndex(b => b.id === bulletin.id);
            if (index !== -1) currentData.bulletins[index] = newBulletin;
          } else currentData.bulletins.push(newBulletin);
          renderPage(); closeModal(); showToast(isEdit ? "Bulletin modifié avec succès" : "Bulletin créé avec succès");
        });
      }

      function viewStudentHistory(studentId) {
        const student = currentData.students.find(s => s.id === studentId);
        if (!student) return;
        const isUniv = typeEtablissement === "universite";
        const studentBulletins = currentData.bulletins.filter(b => b.studentId === studentId).sort((a,b) => new Date(b.date) - new Date(a.date));
        
        let historyHtml = '';
        if (studentBulletins.length === 0) {
          historyHtml = `<div class="text-center py-8 text-slate-500">Aucun bulletin enregistré pour cet ${isUniv ? "étudiant" : "élève"}.</div>`;
        } else {
          historyHtml = studentBulletins.map(b => {
            const moyenne = moyenneGenerale(b);
            const mention = getMention(moyenne);
            return `
              <div class="border rounded-xl p-5 mb-4 bg-white shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-3 mb-3">
                  <div>
                    <span class="text-lg font-bold">${b.trimestre}</span>
                    <span class="text-sm text-slate-500 ml-2">${new Date(b.date).toLocaleDateString("fr-FR")}</span>
                  </div>
                  <div class="flex gap-2">
                    <button data-id="${b.id}" class="btn-view-detail text-primary bg-primary/10 px-3 py-1.5 rounded-lg text-sm font-medium hover:bg-primary/20 transition">Voir détails</button>
                    <button data-id="${b.id}" class="btn-edit-from-history text-slate-700 border px-3 py-1.5 rounded-lg text-sm hover:bg-slate-50 transition">Modifier</button>
                    <button data-id="${b.id}" class="btn-download-from-history text-slate-700 border px-3 py-1.5 rounded-lg text-sm hover:bg-slate-50 transition"><svg class="h-4 w-4 inline mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>Télécharger</button>
                  </div>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-sm">
                  <div><span class="text-slate-500">Moyenne :</span> <span class="font-semibold">${moyenne.toFixed(2)}/20</span></div>
                  <div><span class="text-slate-500">Mention :</span> <span class="font-semibold">${mention}</span></div>
                  <div><span class="text-slate-500">Conduite :</span> <span class="font-semibold">${b.conduite}/20</span></div>
                  <div><span class="text-slate-500">Appréciation :</span> <span class="italic">${b.appreciation || '—'}</span></div>
                </div>
              </div>
            `;
          }).join('');
        }

        const bodyHtml = `
          <div class="space-y-4">
            <div class="flex items-center gap-4 border-b pb-4">
              <div class="flex h-14 w-14 items-center justify-center rounded-full bg-primary/10 text-xl font-bold text-primary">${student.prenom[0]}${student.nom[0]}</div>
              <div>
                <h3 class="text-xl font-bold">${student.prenom} ${student.nom}</h3>
                <p class="text-sm text-slate-500">${student.classe} · ${student.matricule}</p>
              </div>
              <div class="ml-auto">
                <button id="new-bulletin-for-student" class="action-button inline-flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-medium text-white" data-studentid="${student.id}">
                  <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 4.5v15m7.5-7.5h-15"/></svg>
                  Nouveau bulletin
                </button>
              </div>
            </div>
            <h4 class="font-heading text-lg font-semibold">Historique des bulletins</h4>
            <div class="max-h-96 overflow-y-auto pr-1">${historyHtml}</div>
          </div>
        `;
        openModal(`Historique de ${student.prenom} ${student.nom}`, bodyHtml);
        document.getElementById("new-bulletin-for-student").addEventListener("click", (e) => {
          closeModal();
          const newBulletin = { studentId: student.id };
          openBulletinModal(newBulletin);
        });
        document.querySelectorAll(".btn-view-detail").forEach(btn => {
          btn.addEventListener("click", () => {
            const id = parseInt(btn.dataset.id);
            const bulletin = currentData.bulletins.find(b => b.id === id);
            if (bulletin) viewBulletinModal(bulletin);
          });
        });
        document.querySelectorAll(".btn-edit-from-history").forEach(btn => {
          btn.addEventListener("click", () => {
            const id = parseInt(btn.dataset.id);
            const bulletin = currentData.bulletins.find(b => b.id === id);
            if (bulletin) { closeModal(); openBulletinModal(bulletin); }
          });
        });
        document.querySelectorAll(".btn-download-from-history").forEach(btn => {
          btn.addEventListener("click", () => {
            const id = parseInt(btn.dataset.id);
            const bulletin = currentData.bulletins.find(b => b.id === id);
            if (bulletin) generatePDF(bulletin);
          });
        });
      }

      function viewBulletinModal(bulletin) {
        const student = currentData.students.find(s => s.id === bulletin.studentId);
        if (!student) return;
        const isUniv = typeEtablissement === "universite";
        const moyenne = moyenneGenerale(bulletin);
        const mention = getMention(moyenne);
        const matieresRows = bulletin.matieres.map(m => {
          const moy = moyenneMatiere(m);
          const notesDetail = m.notes.map(n => `<span class="inline-block bg-slate-100 rounded-lg px-3 py-1 text-xs mr-1 mb-1">${n.type}: ${n.note} (coeff ${n.coeff})</span>`).join('');
          return `<tr><td class="py-3 align-top"><div class="font-medium">${m.nom}</div><div class="text-xs text-slate-500 mt-1">${notesDetail}</div></td><td class="py-3">${m.coeff}</td><td class="py-3 font-semibold">${moy.toFixed(2)}</td><td class="py-3">${(moy * m.coeff).toFixed(2)}</td></tr>`;
        }).join("");
        const bodyHtml = `
          <div class="space-y-4">
            <div class="flex flex-wrap justify-between items-center border-b pb-3 gap-2">
              <div><span class="font-bold text-lg">${student.prenom} ${student.nom}</span><span class="text-sm text-slate-500 ml-2">${student.classe}</span></div>
              <span class="text-sm bg-primary/10 px-3 py-1.5 rounded-full font-medium">${bulletin.trimestre}</span>
            </div>
            <div class="overflow-x-auto">
              <table class="w-full text-sm">
                <thead class="bg-slate-100 rounded-lg"><tr><th class="px-4 py-3 text-left">Matière (détail des notes)</th><th class="px-4 py-3">Coeff</th><th class="px-4 py-3">Moyenne</th><th class="px-4 py-3">Pondérée</th></tr></thead>
                <tbody class="divide-y">${matieresRows}</tbody>
              </table>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm bg-slate-50 p-4 rounded-xl">
              <div><span class="font-medium">Conduite :</span> ${bulletin.conduite}/20</div>
              <div><span class="font-medium">Moyenne générale :</span> <span class="text-lg font-bold text-primary">${moyenne.toFixed(2)}/20</span></div>
              <div><span class="font-medium">Mention :</span> ${mention}</div>
              <div><span class="font-medium">Appréciation :</span> ${bulletin.appreciation || '—'}</div>
            </div>
            <div class="flex justify-end gap-3 pt-3">
              <button type="button" id="modal-edit-from-view" class="rounded-xl border px-5 py-2.5 text-sm font-medium hover:bg-slate-50 transition">Modifier</button>
              <button type="button" id="modal-download-from-view" class="rounded-xl bg-primary px-5 py-2.5 text-sm font-medium text-white inline-flex items-center gap-2 shadow-sm hover:bg-primaryDark transition"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>Télécharger PDF</button>
            </div>
          </div>
        `;
        openModal(`Détail ${isUniv ? "relevé" : "bulletin"}`, bodyHtml);
        document.getElementById("modal-edit-from-view").addEventListener("click", () => { closeModal(); openBulletinModal(bulletin); });
        document.getElementById("modal-download-from-view").addEventListener("click", () => { generatePDF(bulletin); });
      }

      function renderPage() {
        const container = document.getElementById("dynamic-content");
        const isUniv = typeEtablissement === "universite";
        const studentLabel = isUniv ? "étudiant" : "élève";
        const docLabel = isUniv ? "Relevés de notes" : "Bulletins scolaires";
        const studentMap = {}; currentData.students.forEach(s => { studentMap[s.id] = s; });
        const studentOptions = currentData.students.map(s => `<option value="${s.id}">${s.nom} ${s.prenom} (${s.classe})</option>`).join("");

        container.innerHTML = `
          <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
            <div>
              <h1 class="font-heading text-2xl font-bold text-slate-900 sm:text-3xl">${docLabel}</h1>
              <p class="mt-1 text-sm text-slate-600">Consultez l'historique complet, les moyennes et les détails par ${studentLabel}.</p>
            </div>
            <button id="btn-new-bulletin" class="action-button inline-flex items-center gap-2 rounded-xl bg-primary px-5 py-3 text-sm font-semibold text-white shadow-md hover:bg-primaryDark transition">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 4.5v15m7.5-7.5h-15"/></svg>
              Nouveau ${isUniv ? "relevé" : "bulletin"}
            </button>
          </div>

          <div class="mb-6 flex flex-wrap items-center gap-4">
            <div class="relative flex-1 min-w-[240px]">
              <label class="block text-sm font-medium mb-1">Rechercher un ${studentLabel}</label>
              <input type="text" id="search-student" placeholder="Nom ou prénom..." class="w-full rounded-xl border-slate-200 bg-white p-2.5 text-sm">
            </div>
            <div class="relative flex-1 min-w-[240px]">
              <label class="block text-sm font-medium mb-1">Voir l'historique d'un ${studentLabel}</label>
              <select id="student-history-select" class="w-full rounded-xl border-slate-200 bg-white p-2.5 text-sm">
                <option value="">-- Sélectionner --</option>
                ${studentOptions}
              </select>
            </div>
            <button id="btn-view-history" class="mt-5 action-button inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 transition disabled:opacity-50" disabled>
              <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
              Voir l'historique
            </button>
          </div>

          <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-md">
            <div class="overflow-x-auto">
              <table class="min-w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                  <tr>
                    <th class="px-5 py-3">${studentLabel}</th>
                    <th class="px-3 py-3">Période</th>
                    <th class="px-3 py-3">Date</th>
                    <th class="px-3 py-3">Moyenne</th>
                    <th class="px-3 py-3">Conduite</th>
                    <th class="px-5 py-3 text-right">Actions</th>
                  </tr>
                </thead>
                <tbody id="bulletins-tbody" class="divide-y divide-slate-100"></tbody>
              </table>
            </div>
          </div>
        `;

        const tbody = document.getElementById("bulletins-tbody");
        const searchInput = document.getElementById("search-student");
        const historySelect = document.getElementById("student-history-select");
        const viewHistoryBtn = document.getElementById("btn-view-history");

        function filterBulletins() {
          const searchTerm = searchInput.value.trim().toLowerCase();
          const filtered = currentData.bulletins.filter(b => {
            if (!searchTerm) return true;
            const student = studentMap[b.studentId];
            if (!student) return false;
            return `${student.prenom} ${student.nom}`.toLowerCase().includes(searchTerm);
          });
          renderTableBody(filtered);
        }

        function renderTableBody(bulletinsArray) {
          const sorted = [...bulletinsArray].sort((a,b) => new Date(b.date) - new Date(a.date));
          tbody.innerHTML = sorted.map(b => {
            const student = studentMap[b.studentId];
            const studentName = student ? `${student.prenom} ${student.nom}` : "Inconnu";
            const moyenne = moyenneGenerale(b);
            return `
              <tr class="hover:bg-slate-50/80">
                <td class="px-5 py-4 font-medium">${studentName}</td>
                <td class="px-3 py-4">${b.trimestre}</td>
                <td class="px-3 py-4">${new Date(b.date).toLocaleDateString("fr-FR")}</td>
                <td class="px-3 py-4 font-semibold">${moyenne.toFixed(2)} /20</td>
                <td class="px-3 py-4">${b.conduite}/20</td>
                <td class="px-5 py-4 text-right">
                  <div class="flex flex-wrap items-center justify-end gap-2">
                    <button data-id="${b.id}" class="btn-view-detail text-primary bg-primary/10 px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-primary/20 transition">Détails</button>
                    <button data-id="${b.id}" class="btn-edit text-slate-700 border px-3 py-1.5 rounded-lg text-xs hover:bg-slate-50 transition">Modifier</button>
                    <button data-id="${b.id}" class="btn-download text-slate-700 border px-3 py-1.5 rounded-lg text-xs hover:bg-slate-50 transition"><svg class="h-3.5 w-3.5 inline" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg></button>
                    <button data-id="${b.id}" class="btn-delete text-danger hover:underline text-xs">Suppr.</button>
                  </div>
                </td>
              </tr>
            `;
          }).join("");
        }

        renderTableBody(currentData.bulletins);
        searchInput.addEventListener("input", filterBulletins);

        historySelect.addEventListener("change", () => {
          viewHistoryBtn.disabled = !historySelect.value;
        });

        viewHistoryBtn.addEventListener("click", () => {
          const studentId = parseInt(historySelect.value);
          if (studentId) viewStudentHistory(studentId);
        });

        document.getElementById("btn-new-bulletin").addEventListener("click", () => openBulletinModal());

        tbody.addEventListener("click", (e) => {
          const btn = e.target.closest("button");
          if (!btn) return;
          const id = parseInt(btn.dataset.id);
          const bulletin = currentData.bulletins.find(b => b.id === id);
          if (!bulletin) return;
          if (btn.classList.contains("btn-view-detail")) viewBulletinModal(bulletin);
          else if (btn.classList.contains("btn-edit")) openBulletinModal(bulletin);
          else if (btn.classList.contains("btn-download")) generatePDF(bulletin);
          else if (btn.classList.contains("btn-delete")) {
            if (confirm("Supprimer ce document ?")) {
              currentData.bulletins = currentData.bulletins.filter(b => b.id !== id);
              filterBulletins();
              showToast("Document supprimé");
            }
          }
        });
      }

      function init() {
        updateHeaderFooter(); renderPage(); updateSwitchButtons();
        document.getElementById("switch-college")?.addEventListener("click", () => setType("college"));
        document.getElementById("switch-universite")?.addEventListener("click", () => setType("universite"));
        const sidebar = document.getElementById("sidebar"), overlay = document.getElementById("sidebar-overlay"), btnMenu = document.getElementById("btn-menu");
        btnMenu?.addEventListener("click", () => { sidebar.classList.remove("-translate-x-full"); overlay.classList.add("is-open"); document.body.style.overflow = "hidden"; });
        overlay?.addEventListener("click", () => { sidebar.classList.add("-translate-x-full"); overlay.classList.remove("is-open"); document.body.style.overflow = ""; });
        window.addEventListener("resize", () => { if (window.innerWidth >= 1024) { sidebar.classList.remove("-translate-x-full"); overlay.classList.remove("is-open"); document.body.style.overflow = ""; } });
        document.querySelectorAll(".sidebar-toggle").forEach(btn => {
          const id = btn.getAttribute("data-submenu"), panel = document.getElementById(id), chev = btn.querySelector(".chevron");
          if (panel) btn.addEventListener("click", () => { const open = panel.classList.toggle("open"); if (chev) chev.style.transform = open ? "rotate(180deg)" : ""; });
        });
        document.getElementById("last-update").innerText = new Date().toLocaleTimeString("fr-FR");
      }
      init();
    })();
  </script>
</body>
</html>
