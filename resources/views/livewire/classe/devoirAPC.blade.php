    <div id="modalDevoirsAPC"  class="fixed inset-0 bg-black bg-opacity-70 hidden">
        
    
        <div class="text-white text-sm rounded-md shadow-md px-2 py-2 hover:bg-blue-800 onclick="fermerModalDevoirsAPC()"></div>

        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative bg-white rounded-lg shadow-xl w-full max-w-6xl">

                <!-- HEADER -->
                <div class="flex items-center justify-between p-4 border-b bg-green-600 rounded-t-lg">
                    <h3 class="text-lg font-semibold text-white">
                        <i class="fa fa-graduation-cap mr-2"></i> Bilan de vos évaluations APC
                    </h3>
                    <button onclick="fermerModalDevoirsAPC()" class="text-white hover:text-gray-200">
                        <i class="fa fa-times text-xl"></i>
                    </button>
                </div>

                <!-- FILTRE -->
                <div class="px-4 pt-4 flex gap-2">
                    <button onclick="filtrerSemestreAPC('tous')" id="btnTousAPC"
                        class="px-3 py-1 rounded-full text-xs font-semibold bg-green-600 text-white">
                        Tous
                    </button>
                    <button onclick="filtrerSemestreAPC('1')" id="btnSem1APC"
                        class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-200 text-gray-700">
                        Semestre 1
                    </button>
                    <button onclick="filtrerSemestreAPC('2')" id="btnSem2APC"
                        class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-200 text-gray-700">
                        Semestre 2
                    </button>
                </div>

                <!-- BODY -->
                <div class="p-4">

                    <!-- LOADING -->
                    <div id="modalDevoirsAPCLoading" class="text-center py-8 hidden">
                        <i class="fa fa-spinner fa-spin text-green-600 text-2xl"></i>
                        <p class="text-gray-500 mt-2">Chargement...</p>
                    </div>

                    <!-- TABLE -->
                    <div id="modalDevoirsAPCContent">
                        <table class="w-full text-sm table-fixed border border-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-3 py-2 text-left w-1/3">Ressource</th>
                                    <th class="px-3 py-2 text-center w-24">Devoir 1</th>
                                    <th class="px-3 py-2 text-center w-24">Devoir 2</th>
                                    <th class="px-3 py-2 text-center w-24">Devoir 3</th>
                                    <th class="px-3 py-2 text-center bg-green-50 w-28">Note MCC</th>
                                </tr>
                            </thead>
                            <tbody id="modalDevoirsAPCTableBody" class="divide-y text-center align-middle"></tbody>
                        </table>

                        <!-- EMPTY -->
                        <div id="modalDevoirsAPCEmpty" class="text-center py-8 hidden">
                            <i class="fa fa-inbox text-gray-300 text-4xl"></i>
                            <p class="text-gray-500 mt-2">Aucun devoir trouvé.</p>
                        </div>
                    </div>

                </div>

                <!-- FOOTER -->
                <div class="flex justify-end p-4 border-t">
                    <button onclick="fermerModalDevoirsAPC()"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 text-sm">
                        Fermer
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- SCRIPT -->
    <script>
    let devoirsAPCData = [];

    function ouvrirModalDevoirsAPC(inscriptionId) {
        document.getElementById('modalDevoirsAPC').classList.remove('hidden');
        document.getElementById('modalDevoirsAPCLoading').classList.remove('hidden');
        document.getElementById('modalDevoirsAPCEmpty').classList.add('hidden');
        document.getElementById('modalDevoirsAPCTableBody').innerHTML = '';

        filtrerSemestreAPC('tous', false);

        fetch(`/devoirs/apc/${inscriptionId}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('modalDevoirsAPCLoading').classList.add('hidden');
                devoirsAPCData = data;
                afficherDevoirsAPC(data);
            })
            .catch(() => {
                document.getElementById('modalDevoirsAPCLoading').classList.add('hidden');
                document.getElementById('modalDevoirsAPCTableBody').innerHTML =
                    `<tr><td colspan="5" class="text-center py-4 text-red-500">Erreur de chargement</td></tr>`;
            });
    }

    function filtrerSemestreAPC(semestre, reafficher = true) {
        ['tous', '1', '2'].forEach(s => {
            const btn = document.getElementById(s === 'tous' ? 'btnTousAPC' : `btnSem${s}APC`);
            btn.className = s === semestre
                ? 'px-3 py-1 rounded-full text-xs font-semibold bg-green-600 text-white'
                : 'px-3 py-1 rounded-full text-xs font-semibold bg-gray-200 text-gray-700';
        });

        if (!reafficher) return;

        const filtered = semestre === 'tous'
            ? devoirsAPCData
            : devoirsAPCData.filter(d => String(d.semestre) === String(semestre));

        afficherDevoirsAPC(filtered, semestre);
    }

    function afficherDevoirsAPC(data) {
        const tbody = document.getElementById('modalDevoirsAPCTableBody');
        const empty = document.getElementById('modalDevoirsAPCEmpty');
        const MAX_DEVOIRS = 3;

        const grouped = {};

        data.forEach(d => {
            const key = d.ressource ?? 'Non définie';

            if (!grouped[key]) grouped[key] = [];
            if (grouped[key].length < MAX_DEVOIRS) {
                grouped[key].push(d);
            }
        });

        const ressources = Object.keys(grouped);

        if (!ressources.length) {
            tbody.innerHTML = '';
            empty.classList.remove('hidden');
            return;
        }

        empty.classList.add('hidden');

        const renderNote = (d) => {
            if (!d) return `<span class="text-gray-300">-</span>`;
            if (d.note === null) return `
                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs">
                    En attente
                </span>`;
            return `
                <span class="font-bold ${d.note >= 10 ? 'text-green-600' : 'text-red-500'}">
                    ${d.note}/20
                </span>`;
        };

        const renderMCC = (devoirs) => {
            const mcc = devoirs.find(d => d.mcc !== null)?.mcc ?? null;
            if (mcc === null) return `<span class="text-gray-400 text-xs">Non définie</span>`;
            return `
                <span class="font-bold ${mcc >= 10 ? 'text-green-600' : 'text-red-500'}">
                    ${mcc}/20
                </span>`;
        };

        let rows = '';

        ressources.forEach(res => {
            const devoirs = grouped[res];

            rows += `
                <tr class="hover:bg-gray-50">
                    <td class="px-3 py-3 text-left font-medium border-b">${res}</td>
                    <td class="px-3 py-3 border-b">${renderNote(devoirs[0])}</td>
                    <td class="px-3 py-3 border-b">${renderNote(devoirs[1])}</td>
                    <td class="px-3 py-3 border-b">${renderNote(devoirs[2])}</td>
                    <td class="px-3 py-3 border-b bg-green-50">${renderMCC(devoirs)}</td>
                </tr>
            `;
        });

        tbody.innerHTML = rows;
    }

    function fermerModalDevoirsAPC() {
        document.getElementById('modalDevoirsAPC').classList.add('hidden');
    }

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') fermerModalDevoirsAPC();
    });
    </script>