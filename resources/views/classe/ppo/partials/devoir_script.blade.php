<script>
  let currentMatiereId = null;
  let currentSemestre = '';
  let currentPage = 1;
</script>
<script>
  function openDevoirPpoModal(matiereId) {
    const input = document.getElementById('devoir_matiere_id');
    const modal = document.getElementById('devoirPpoModal');

    if (input) input.value = matiereId;
    if (modal) modal.classList.remove('hidden');
  }

  function closeDevoirPpoModal() {
    const modal = document.getElementById('devoirPpoModal');
    if (modal) modal.classList.add('hidden');
  }
</script>

<script>
  function openVoirDevoirPpoModal(matiereId) {
    currentMatiereId = matiereId;
    currentPage = 1;
    currentSemestre = '';

    const modal = document.getElementById('voirDevoirPpoModal');
    if (modal) modal.classList.remove('hidden');

    chargerDevoirs(matiereId, currentSemestre, currentPage);
  }

  function closeVoirDevoirPpoModal() {
    const modal = document.getElementById('voirDevoirPpoModal');
    if (modal) modal.classList.add('hidden');
  }
</script>
<!-- <script>
  let currentMatiereId = null;
  let currentSemestre = '';
  let currentPage = 1;

  function openVoirDevoirPpoModal(matiereId) {
    currentMatiereId = matiereId;
    currentPage = 1;
    currentSemestre = '';

    document.getElementById('voirDevoirPpoModal')?.classList.remove('hidden');
    chargerDevoirs(matiereId, currentSemestre, currentPage);
  }

  function closeVoirDevoirPpoModal() {
    document.getElementById('voirDevoirPpoModal')?.classList.add('hidden');
  }

  function chargerDevoirs(matiereId, semestre = '', page = 1) {
    const container = document.getElementById('voirDevoirContent'); // ✅ IMPORTANT
    if (!container) return;

    container.innerHTML = '<div class="text-center py-6 text-gray-500">Chargement...</div>';

    let url = `/devoirPPO/matiere/${matiereId}?page=${page}`;
    if (semestre) url += `&semestre=${encodeURIComponent(semestre)}`;

    fetch(url, {
      headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' }
    })
    .then(r => r.text())
    .then(html => container.innerHTML = html)
    .catch(() => container.innerHTML = '<div class="text-center py-6 text-red-600">Erreur de chargement</div>');
  }
</script> -->
<script>
  window.PPO_CLASSE_ID = @json($classe->id);
</script>

<script>
  function chargerDevoirs(matiereId, semestre = '', page = 1) {
    const container = document.getElementById('voirDevoirContent');
    if (!container) return;

    container.innerHTML = '<div class="text-center py-6 text-gray-500">Chargement...</div>';

    const params = new URLSearchParams();
    params.set('classe_id', window.PPO_CLASSE_ID);   // ✅ obligatoire
    params.set('page', page);
    if (semestre) params.set('semestre', semestre);

    const url = `/devoirPPO/matiere/${matiereId}?${params.toString()}`;

    fetch(url, {
      headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' }
    })
    .then(r => {
      if (!r.ok) throw new Error('HTTP ' + r.status);
      return r.text();
    })
    .then(html => {
      container.innerHTML = html;
      reinitPaginationHrefEvents(); // si tu utilises la pagination
    })
    .catch(err => {
      container.innerHTML = `<div class="text-center py-6 text-red-600">Erreur de chargement</div>`;
      console.error(err);
    });
  }
</script>


<script>
  function reinitPaginationHrefEvents() {
    document.querySelectorAll('#voirDevoirContent .pagination a').forEach(a => {
      a.addEventListener('click', (e) => {
        e.preventDefault();
        const url = new URL(a.href);
        const page = parseInt(url.searchParams.get('page') || '1', 10);

        currentPage = page;
        chargerDevoirs(currentMatiereId, currentSemestre, currentPage);
      }, { once: true });
    });
  }
</script>
<script>
function editNoteInlinePPO(devoirId) {
  const noteDisplay = document.getElementById('note-display-' + devoirId);
  if (!noteDisplay) return;

  const currentNote = noteDisplay.textContent.replace('/20', '').trim();

  noteDisplay.outerHTML = `
    <div class="flex items-center justify-center gap-1">
      <input type="number"
             id="edit-input-ppo-${devoirId}"
             value="${isNaN(parseFloat(currentNote)) ? '' : currentNote}"
             step="0.01" min="0" max="20"
             class="border rounded px-2 py-1 w-20 text-center">
      <button type="button" onclick="saveNoteInlinePPO(${devoirId})"
              class="bg-green-600 text-white text-xs px-2 py-1 rounded hover:bg-green-700">
        <i class="fa fa-check"></i>
      </button>
      <button type="button" onclick="cancelEditNoteInlinePPO()"
              class="bg-gray-600 text-white text-xs px-2 py-1 rounded hover:bg-gray-700">
        <i class="fa fa-times"></i>
      </button>
    </div>
  `;
}

function saveNoteInlinePPO(devoirId) {
  const input = document.getElementById('edit-input-ppo-' + devoirId);
  if (!input) return;

  const newNote = input.value;

  if (newNote === '' || isNaN(newNote) || newNote < 0 || newNote > 20) {
    alert('Note invalide (0-20)');
    return;
  }

  fetch(`/devoirPPO/${devoirId}`, {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
      'Accept': 'application/json'
    },
    body: JSON.stringify({ note: newNote })
  })
  .then(r => r.json())
  .then(data => {
    if (!data.success) throw new Error(data.message || 'Erreur');
    
    if (currentMatiereId) chargerDevoirs(currentMatiereId, currentSemestre, currentPage);
  })
  .catch(err => {
    alert('Erreur: ' + err.message);
    cancelEditNoteInlinePPO();
  });
}

function cancelEditNoteInlinePPO() {
  if (currentMatiereId) chargerDevoirs(currentMatiereId, currentSemestre, currentPage);
}
</script>
<script>
  // Etat global déjà chez toi
  // let currentMatiereId = null;
  // let currentSemestre = '';
  // let currentPage = 1;

  function openAddDevoirPpoModal(matiereId) {
    if (matiereId) currentMatiereId = matiereId;

    // Set hidden matiere_id
    const input = document.getElementById('add_devoir_matiere_id');
    if (input && currentMatiereId) input.value = currentMatiereId;

    // Reset champs (pour pouvoir créer plusieurs devoirs)
    const modal = document.getElementById('addDevoirPpoModal');
    if (modal) {
      const libelle = modal.querySelector('input[name="libelle"]');
      if (libelle) libelle.value = '';

      // optionnel: vider notes
      modal.querySelectorAll('input[type="number"][name^="notes["]').forEach(i => i.value = '');
    }

    // Show modal
    document.getElementById('addDevoirPpoModal')?.classList.remove('hidden');
  }

  function closeAddDevoirPpoModal() {
    document.getElementById('addDevoirPpoModal')?.classList.add('hidden');

    // Réouvrir liste devoirs + refresh
    document.getElementById('voirDevoirPpoModal')?.classList.remove('hidden');
    if (currentMatiereId) chargerDevoirs(currentMatiereId, currentSemestre, currentPage);
  }

  function openAddDevoirFromVoirModal() {
    // Fermer le modal liste
    document.getElementById('voirDevoirPpoModal')?.classList.add('hidden');

    // Ouvrir modal ajout
    if (!currentMatiereId) return;
    openAddDevoirPpoModal(currentMatiereId);
  }
</script>




