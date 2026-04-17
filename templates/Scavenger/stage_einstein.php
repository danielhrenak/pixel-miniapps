<section class="flex min-h-screen items-center justify-center px-4 py-8">
    <div class="w-full max-w-7xl rounded-3xl border border-slate-700 bg-slate-900/70 p-5 shadow-2xl backdrop-blur md:p-8">
        <div id="puzzle-screen" class="space-y-6">
            <h1 class="text-center text-3xl font-bold tracking-tight md:text-4xl">Scavenger - Stage Einstein</h1>

            <div class="rounded-2xl border border-slate-700 bg-slate-950/60 p-4 text-sm text-slate-200 md:text-base">
                <p class="mb-3 font-semibold">Na ulici je 5 domov, každý inej farby. V každom dome žije osoba inej národnosti. Každý obyvateľ pije iný nápoj, fajčí inú značku cigariet a chová iné zviera.</p>
                <ol class="list-decimal space-y-1 pl-5">
                    <li>Angličan žije v červenom dome.</li>
                    <li>Švéd chová psy.</li>
                    <li>Dán pije čaj.</li>
                    <li>Zelený dom je hneď naľavo od bieleho.</li>
                    <li>Obyvateľ zeleného domu pije kávu.</li>
                    <li>Ten, kto fajčí cigarety Pall Mall, chová vtáky.</li>
                    <li>Obyvateľ žltého domu fajčí cigarety Dunhill.</li>
                    <li>Ten, kto žije v prostrednom dome, pije mlieko.</li>
                    <li>Nór žije v prvom dome.</li>
                    <li>Ten, kto fajčí cigarety Blends, žije vedľa chovateľa mačiek.</li>
                    <li>Chovateľ koní žije vedľa toho, kto fajčí cigarety Dunhill.</li>
                    <li>Ten, kto fajčí cigarety Blue Master, pije pivo.</li>
                    <li>Nemec fajčí cigarety Prince.</li>
                    <li>Nór žije vedľa modrého domu.</li>
                    <li>Sused toho, kto fajčí cigarety Blends, pije vodu.</li>
                </ol>
                <p class="mt-3 text-slate-300">Úloha: pretiahni karty v každom riadku do správnych domov (1-5), potom klikni na "Skontrolovať".</p>
            </div>

            <p id="solve-hint" class="hidden rounded-xl border border-emerald-500/40 bg-emerald-500/10 px-4 py-3 text-center text-sm text-emerald-200">
                Režim <code>?vyries=1</code> je aktívny - tabuľka je predvyplnená správnym riešením.
            </p>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[920px] border-collapse text-center text-sm md:text-base" id="einstein-table">
                    <thead>
                    <tr class="bg-slate-800/70 text-slate-100">
                        <th class="border border-slate-700 px-3 py-2">Dom</th>
                        <th class="border border-slate-700 px-3 py-2">1</th>
                        <th class="border border-slate-700 px-3 py-2">2</th>
                        <th class="border border-slate-700 px-3 py-2">3</th>
                        <th class="border border-slate-700 px-3 py-2">4</th>
                        <th class="border border-slate-700 px-3 py-2">5</th>
                    </tr>
                    </thead>
                    <tbody id="einstein-body"></tbody>
                </table>
            </div>

            <div class="flex flex-col items-center gap-3">
                <button id="check-solution" type="button" class="rounded-xl bg-sky-500 px-6 py-3 font-semibold text-slate-950 transition hover:bg-sky-400">Skontrolovať riešenie</button>
                <div id="error-message" class="hidden w-full max-w-2xl rounded-xl border border-red-500/60 bg-red-500/10 px-4 py-3 text-center text-sm font-medium text-red-200 shadow-lg" role="alert" aria-live="polite">
                    <span class="inline-flex items-center gap-2">
                        <span aria-hidden="true">⚠️</span>
                        <span>Tabuľka ešte nie je správne. Skús to znovu.</span>
                    </span>
                </div>
            </div>
        </div>

        <div id="result-screen" class="hidden space-y-5">
            <p class="text-center text-lg font-semibold text-emerald-300">Správne! Hľadaj tieto časti. A kde? Nech ti je nápovedou obrázok</p>
            <div class="mx-auto max-w-2xl rounded-2xl border border-slate-700 bg-slate-950/60 p-4">
                <?= $this->Html->image('diggy_kniha.png', ['alt' => 'Nápoveda - Diggy kniha', 'class' => 'mx-auto h-auto w-full max-w-xl object-contain']) ?>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[980px] border-collapse text-center">
                    <thead>
                    <tr class="bg-slate-800/70 text-slate-100">
                        <th class="border border-slate-700 px-4 py-3">Počet</th>
                        <th class="border border-slate-700 px-4 py-3">Skupina 1</th>
                        <th class="border border-slate-700 px-4 py-3">Skupina 2</th>
                        <th class="border border-slate-700 px-4 py-3">Skupina 3</th>
                        <th class="border border-slate-700 px-4 py-3">Skupina 4</th>
                        <th class="border border-slate-700 px-4 py-3">Skupina 5</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="border border-slate-700 px-4 py-3 font-semibold">1x</td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/24445.jpg" alt="Skupina 1 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/24445.jpg" alt="Skupina 2 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/24445.jpg" alt="Skupina 3 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/24445.jpg" alt="Skupina 4 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/24445.jpg" alt="Skupina 5 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                    </tr>
                    <tr>
                        <td class="border border-slate-700 px-4 py-3 font-semibold">4x</td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/50945.jpg" alt="Skupina 1 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/50945.jpg" alt="Skupina 2 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/50945.jpg" alt="Skupina 3 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/50945.jpg" alt="Skupina 4 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/50945.jpg" alt="Skupina 5 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<script>
    (function () {
        const HIDE_ERROR_DELAY_MS = 2800;
        const searchParams = new URLSearchParams(window.location.search);
        const isSolveMode = searchParams.get('vyries') === '1';
        const categories = [
            {
                key: 'farba',
                label: 'Farba',
                solution: ['žltý', 'modrý', 'červený', 'zelený', 'biely'],
                rowClass: 'bg-amber-500/10',
                labelClass: 'bg-amber-500/20',
                cardClass: 'border-amber-400/60 bg-amber-500/20',
            },
            {
                key: 'narodnost',
                label: 'Národnosť',
                solution: ['Nór', 'Dán', 'Angličan', 'Nemec', 'Švéd'],
                rowClass: 'bg-sky-500/10',
                labelClass: 'bg-sky-500/20',
                cardClass: 'border-sky-400/60 bg-sky-500/20',
            },
            {
                key: 'napoj',
                label: 'Nápoj',
                solution: ['voda', 'čaj', 'mlieko', 'káva', 'pivo'],
                rowClass: 'bg-emerald-500/10',
                labelClass: 'bg-emerald-500/20',
                cardClass: 'border-emerald-400/60 bg-emerald-500/20',
            },
            {
                key: 'cigarety',
                label: 'Cigarety',
                solution: ['Dunhill', 'Blend', 'Pall mall', 'Prince', 'Bluemaster'],
                rowClass: 'bg-violet-500/10',
                labelClass: 'bg-violet-500/20',
                cardClass: 'border-violet-400/60 bg-violet-500/20',
            },
            {
                key: 'zviera',
                label: 'Zviera',
                solution: ['mačky', 'kone', 'vtáky', 'ryby', 'psy'],
                rowClass: 'bg-rose-500/10',
                labelClass: 'bg-rose-500/20',
                cardClass: 'border-rose-400/60 bg-rose-500/20',
            }
        ];

        const puzzleScreen = document.getElementById('puzzle-screen');
        const resultScreen = document.getElementById('result-screen');
        const tbody = document.getElementById('einstein-body');
        const checkButton = document.getElementById('check-solution');
        const errorMessage = document.getElementById('error-message');
        const solveHint = document.getElementById('solve-hint');

        let draggedCard = null;
        let hideErrorTimeout = null;

        if (!puzzleScreen || !resultScreen || !tbody || !checkButton || !errorMessage) {
            return;
        }

        function shuffle(values) {
            const copy = values.slice();
            for (let i = copy.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                const temp = copy[i];
                copy[i] = copy[j];
                copy[j] = temp;
            }
            return copy;
        }

        function createCard(categoryKey, value, cardClass) {
            const card = document.createElement('div');
            card.className = 'cursor-move rounded-lg border px-2 py-2 text-slate-100 shadow ' + cardClass;
            card.draggable = true;
            card.dataset.category = categoryKey;
            card.dataset.value = value;
            card.textContent = value;

            card.addEventListener('dragstart', function (event) {
                draggedCard = card;
                event.dataTransfer.effectAllowed = 'move';
            });

            card.addEventListener('dragend', function () {
                draggedCard = null;
            });

            return card;
        }

        function makeDropCell(cell) {
            cell.addEventListener('dragover', function (event) {
                event.preventDefault();
                cell.classList.add('ring-2', 'ring-sky-400');
            });

            cell.addEventListener('dragleave', function () {
                cell.classList.remove('ring-2', 'ring-sky-400');
            });

            cell.addEventListener('drop', function (event) {
                event.preventDefault();
                cell.classList.remove('ring-2', 'ring-sky-400');

                if (!draggedCard) {
                    return;
                }

                const sourceCell = draggedCard.parentElement;
                const targetCell = cell;
                const sourceCategory = sourceCell.dataset.category;
                const targetCategory = targetCell.dataset.category;

                if (sourceCategory !== targetCategory) {
                    showError('Presúvať môžeš iba v rámci toho istého riadku.');
                    return;
                }

                if (sourceCell === targetCell) {
                    return;
                }

                const targetCard = targetCell.querySelector('[draggable="true"]');
                if (targetCard) {
                    sourceCell.appendChild(targetCard);
                }
                targetCell.appendChild(draggedCard);
            });
        }

        function buildBoard() {
            categories.forEach(function (category) {
                const row = document.createElement('tr');
                row.className = category.rowClass;
                const labelCell = document.createElement('td');
                labelCell.className = 'border border-slate-700 px-3 py-2 font-semibold ' + category.labelClass;
                labelCell.textContent = category.label;
                row.appendChild(labelCell);

                const values = isSolveMode ? category.solution.slice() : shuffle(category.solution);

                for (let i = 0; i < 5; i++) {
                    const cell = document.createElement('td');
                    cell.className = 'border border-slate-700 px-2 py-2 align-top ' + category.rowClass;
                    cell.dataset.category = category.key;
                    cell.dataset.house = String(i);
                    makeDropCell(cell);
                    cell.appendChild(createCard(category.key, values[i], category.cardClass));
                    row.appendChild(cell);
                }

                tbody.appendChild(row);
            });
        }

        function showError(message) {
            const span = errorMessage.querySelector('span span');
            if (span) {
                span.textContent = message;
            }
            errorMessage.classList.remove('hidden');

            if (hideErrorTimeout) {
                clearTimeout(hideErrorTimeout);
            }

            hideErrorTimeout = setTimeout(function () {
                errorMessage.classList.add('hidden');
                hideErrorTimeout = null;
            }, HIDE_ERROR_DELAY_MS);
        }

        function isSolved() {
            return categories.every(function (category) {
                const rowCells = tbody.querySelectorAll('td[data-category="' + category.key + '"]');
                return category.solution.every(function (expectedValue, houseIndex) {
                    const cell = rowCells[houseIndex];
                    if (!cell) {
                        return false;
                    }
                    const card = cell.querySelector('[draggable="true"]');
                    if (!card) {
                        return false;
                    }
                    return card.dataset.value === expectedValue;
                });
            });
        }

        checkButton.addEventListener('click', function () {
            if (isSolved()) {
                if (hideErrorTimeout) {
                    clearTimeout(hideErrorTimeout);
                    hideErrorTimeout = null;
                }
                errorMessage.classList.add('hidden');
                puzzleScreen.classList.add('hidden');
                resultScreen.classList.remove('hidden');
                return;
            }

            showError('');
        });

        buildBoard();

        if (isSolveMode && solveHint) {
            solveHint.classList.remove('hidden');
        }
    })();
</script>

