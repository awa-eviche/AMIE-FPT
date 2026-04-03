<div id="modalDevoirsPPO" class="fixed inset-0 bg-black bg-opacity-70 hidden">  
        <div class="text-white text-sm rounded-md shadow-md px-2 py-2 hover:bg-blue-800  onclick="fermerModalDevoirsPPO()"></div>
            <i class="fa fa-book mr-2"></i> Bilan de vos évaluations

        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative bg-white rounded-lg shadow-xl w-full max-w-5xl">

                <!-- HEADER -->
                <div class="flex items-center justify-between p-4 border-b bg-blue-600 rounded-t-lg">
                    <h3 class="text-lg font-semibold text-black-50">
                        <i class="fa fa-book mr-2"></i> Bilan de vos évaluations  
                    </h3>
                    <button onclick="fermerModalDevoirsPPO()" class="text-white hover:text-gray-200">
                        <i class="fa fa-times text-xl"></i>
                    </button>
                </div>

                <!-- FILTRE -->
                <div class="px-4 pt-4 flex gap-2">
                    <button onclick="filtrerSemestrePPO('tous')" id="btnTousPPO"
                        class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-600 text-white">
                        Tous
                    </button>
                    <button onclick="filtrerSemestrePPO('1')" id="btnSem1PPO"
                        class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-200 text-gray-700">
                        Semestre 1
                    </button>
                    <button onclick="filtrerSemestrePPO('2')" id="btnSem2PPO"
                        class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-200 text-gray-700">
                        Semestre 2
                    </button>
                </div>

                <!-- BODY -->
                <div class="p-4">

                    <!-- LOADING -->
                    <div id="modalDevoirsPPOLoading" class="text-center py-8 hidden">
                        <i class="fa fa-spinner fa-spin text-blue-600 text-2xl"></i>
                        <p class="text-gray-500 mt-2">Chargement...</p>
                    </div>

                    <!-- TABLE -->
                    <div id="modalDevoirsPPOContent">
                        <table class="w-full text-sm table-fixed border border-gray-200">
                            <thead class="bg-gray-100">
                                <tr id="modalDevoirsPPOThead"></tr>
                            </thead>
                            <tbody id="modalDevoirsPPOTableBody" class="divide-y text-center align-middle"></tbody>
                        </table>

                        <!-- EMPTY -->
                        <div id="modalDevoirsPPOEmpty" class="text-center py-8 hidden">
                            <i class="fa fa-inbox text-gray-300 text-4xl"></i>
                            <p class="text-gray-500 mt-2">Aucun devoir trouvé.</p>
                        </div>
                    </div>
                </div>

                <!-- FOOTER -->
                <div class="flex justify-end p-4 border-t">
                    <button onclick="fermerModalDevoirsPPO()"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 text-sm">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT -->
    <script>
    let devoirsPPOData = [];

    function ouvrirModalDevoirsPPO(inscriptionId) {
        document.getElementById('modalDevoirsPPO').classList.remove('hidden');
        document.getElementById('modalDevoirsPPOLoading').classList.remove('hidden');
        document.getElementById('modalDevoirsPPOEmpty').classList.add('hidden');
        document.getElementById('modalDevoirsPPOTableBody').innerHTML = '';

        filtrerSemestrePPO('tous', false);

        fetch(`/devoirs/ppo/${inscriptionId}`)
            .then(res => res.json())
            .then(data => {
                devoirsPPOData = data;
                document.getElementById('modalDevoirsPPOLoading').classList.add('hidden');
                afficherDevoirsPPO(data);
            })
            .catch(() => {
                document.getElementById('modalDevoirsPPOLoading').classList.add('hidden');
                document.getElementById('modalDevoirsPPOTableBody').innerHTML =
                    `<tr><td class="text-center py-4 text-red-500">Erreur de chargement</td></tr>`;
            });fetch(`/devoirs/ppo/${inscriptionId}`)
    .then(async res => {
        if (!res.ok) {
            const text = await res.text();
            throw new Error(text); // 🔥 affiche erreur Laravel
        }
        return res.json();
    })
    .then(data => {
        devoirsPPOData = data;
        document.getElementById('modalDevoirsPPOLoading').classList.add('hidden');
        afficherDevoirsPPO(data);
    })
    .catch(err => {
        console.error("Erreur :", err); // 🔥 IMPORTANT
        document.getElementById('modalDevoirsPPOLoading').classList.add('hidden');
        document.getElementById('modalDevoirsPPOTableBody').innerHTML =
            `<tr><td class="text-center py-4 text-red-500">Erreur serveur</td></tr>`;
    });
    }

    function fermerModalDevoirsPPO() {
        document.getElementById('modalDevoirsPPO').classList.add('hidden');
    }

    function filtrerSemestrePPO(semestre, reafficher = true) {
        ['tous', '1', '2'].forEach(s => {
            const btn = document.getElementById(s === 'tous' ? 'btnTousPPO' : `btnSem${s}PPO`);
            btn.className = s === semestre
                ? 'px-3 py-1 rounded-full text-xs font-semibold bg-blue-600 text-white'
                : 'px-3 py-1 rounded-full text-xs font-semibold bg-gray-200 text-gray-700';
        });

        if (!reafficher) return;

        const filtered = semestre === 'tous'
            ? devoirsPPOData
            : devoirsPPOData.filter(d => String(d.semestre) === String(semestre));

        afficherDevoirsPPO(filtered, semestre);
    }

    function afficherDevoirsPPO(data, semestre = 'tous') {
        const tbody = document.getElementById('modalDevoirsPPOTableBody');
        const empty = document.getElementById('modalDevoirsPPOEmpty');
        const thead = document.getElementById('modalDevoirsPPOThead');

        const grouped = {};
        data.forEach(d => {
            if (!grouped[d.matiere]) grouped[d.matiere] = [];
            grouped[d.matiere].push(d);
        });

        // HEADER FIXE
        thead.innerHTML = `
            <th class="px-3 py-2 text-left border-b w-1/4">Matière</th>
            <th class="px-3 py-2 text-center border-b w-24">Devoir 1</th>
            <th class="px-3 py-2 text-center border-b w-24">Devoir 2</th>
            <th class="px-3 py-2 text-center border-b w-24">Devoir 3</th>
            <th class="px-3 py-2 text-center border-b bg-blue-50 w-28">Note MCC</th>
        `;

        if (!Object.keys(grouped).length) {
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
            const mcc = devoirs.length ? devoirs[0].mcc : null;
            if (mcc === null) return `<span class="text-gray-400 text-xs">Non définie</span>`;
            return `
                <span class="font-bold ${mcc >= 10 ? 'text-blue-600' : 'text-red-500'}">
                    ${mcc}/20
                </span>`;
        };

        let rows = '';

        Object.keys(grouped).forEach(matiere => {
            const devoirs = grouped[matiere];

            const d1 = devoirs[0] ?? null;
            const d2 = devoirs[1] ?? null;
            const d3 = devoirs[2] ?? null;

            let row = `
                <td class="px-3 py-3 text-left font-medium border-b">${matiere}</td>
                <td class="px-3 py-3 border-b">${renderNote(d1)}</td>
                <td class="px-3 py-3 border-b">${renderNote(d2)}</td>
                <td class="px-3 py-3 border-b">${renderNote(d3)}</td>
                <td class="px-3 py-3 border-b bg-blue-50">${renderMCC(devoirs)}</td>
            `;

            rows += `<tr class="hover:bg-gray-50">${row}</tr>`;
        });

        tbody.innerHTML = rows;
    }
    </script>
