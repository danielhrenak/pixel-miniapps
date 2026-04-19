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

            <p id="selected-banner" class="hidden rounded-xl border border-yellow-400/60 bg-yellow-400/10 px-4 py-2 text-center text-sm font-semibold text-yellow-200">
                Vybrané: <span id="selected-banner-value"></span> — teraz klikni na cieľové políčko v rovnakom riadku
            </p>

            <div class="overflow-x-auto rounded-xl">
                <table class="w-full min-w-[540px] border-collapse text-center text-sm md:text-base" id="einstein-table">
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
        const selectedBanner = document.getElementById('selected-banner');
        const selectedBannerValue = document.getElementById('selected-banner-value');

        let draggedCard = null;
        let selectedCard = null;
        let hideErrorTimeout = null;

        // Touch drag state
        let touchDragCard = null;
        let touchClone = null;
        let touchOffsetX = 0;
        let touchOffsetY = 0;
        let touchLastTarget = null;

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

        function setSelectedCard(card) {
            if (selectedCard) {
                selectedCard.classList.remove('ring-2', 'ring-yellow-300', 'scale-105');
            }
            selectedCard = card;
            if (selectedBanner && selectedBannerValue) {
                if (card) {
                    selectedBannerValue.textContent = card.dataset.value;
                    selectedBanner.classList.remove('hidden');
                } else {
                    selectedBanner.classList.add('hidden');
                }
            }
            if (card) {
                card.classList.add('ring-2', 'ring-yellow-300', 'scale-105');
            }
        }

        function createCard(categoryKey, value, cardClass) {
            const card = document.createElement('div');
            card.className = 'cursor-pointer select-none rounded-lg border px-2 py-2 text-slate-100 shadow transition-transform ' + cardClass;
            card.draggable = true;
            card.dataset.category = categoryKey;
            card.dataset.value = value;
            card.textContent = value;

            // ── Mouse drag-and-drop (desktop) ──────────────────────────────
            card.addEventListener('dragstart', function (event) {
                draggedCard = card;
                event.dataTransfer.effectAllowed = 'move';
            });

            card.addEventListener('dragend', function () {
                draggedCard = null;
            });

            // ── Tap-to-select (desktop & mobile fallback) ──────────────────
            card.addEventListener('click', function (event) {
                event.stopPropagation();

                if (selectedCard === card) {
                    setSelectedCard(null);
                    return;
                }

                if (selectedCard && selectedCard.dataset.category === card.dataset.category) {
                    const sourceCell = selectedCard.parentElement;
                    const targetCell = card.parentElement;
                    if (sourceCell !== targetCell) {
                        sourceCell.appendChild(card);
                        targetCell.appendChild(selectedCard);
                    }
                    setSelectedCard(null);
                    return;
                }

                setSelectedCard(card);
            });

            // ── Touch drag-and-drop (mobile) ───────────────────────────────
            card.addEventListener('touchstart', function (event) {
                if (event.touches.length !== 1) {
                    return;
                }
                event.preventDefault(); // prevents scroll while dragging a card

                const touch = event.touches[0];
                const rect = card.getBoundingClientRect();
                touchOffsetX = touch.clientX - rect.left;
                touchOffsetY = touch.clientY - rect.top;
                touchDragCard = card;

                // Create a floating visual clone
                touchClone = card.cloneNode(true);
                touchClone.style.cssText = [
                    'position:fixed',
                    'pointer-events:none',
                    'z-index:9999',
                    'width:' + rect.width + 'px',
                    'opacity:0.85',
                    'left:' + (touch.clientX - touchOffsetX) + 'px',
                    'top:' + (touch.clientY - touchOffsetY) + 'px',
                    'box-shadow:0 8px 24px rgba(0,0,0,0.45)',
                    'transform:scale(1.08)',
                    'transition:none',
                ].join(';');
                document.body.appendChild(touchClone);
                card.style.opacity = '0.3';
            }, { passive: false });

            card.addEventListener('touchmove', function (event) {
                if (!touchClone || !touchDragCard) {
                    return;
                }
                event.preventDefault();

                const touch = event.touches[0];
                touchClone.style.left = (touch.clientX - touchOffsetX) + 'px';
                touchClone.style.top = (touch.clientY - touchOffsetY) + 'px';

                // Highlight the cell under the finger
                touchClone.style.display = 'none';
                const elementUnder = document.elementFromPoint(touch.clientX, touch.clientY);
                touchClone.style.display = '';

                const cell = elementUnder ? elementUnder.closest('td[data-category]') : null;

                if (touchLastTarget && touchLastTarget !== cell) {
                    touchLastTarget.classList.remove('ring-2', 'ring-sky-400');
                }
                touchLastTarget = cell;
                if (cell && cell.dataset.category === touchDragCard.dataset.category) {
                    cell.classList.add('ring-2', 'ring-sky-400');
                }
            }, { passive: false });

            card.addEventListener('touchend', function (event) {
                if (!touchClone || !touchDragCard) {
                    return;
                }
                event.preventDefault();

                // Clean up clone and highlight
                touchClone.remove();
                touchClone = null;
                touchDragCard.style.opacity = '';

                if (touchLastTarget) {
                    touchLastTarget.classList.remove('ring-2', 'ring-sky-400');
                }

                const touch = event.changedTouches[0];
                const elementUnder = document.elementFromPoint(touch.clientX, touch.clientY);
                const targetCell = elementUnder ? elementUnder.closest('td[data-category]') : null;

                if (
                    targetCell &&
                    targetCell.dataset.category === touchDragCard.dataset.category &&
                    targetCell !== touchDragCard.parentElement
                ) {
                    const sourceCell = touchDragCard.parentElement;
                    const existingCard = targetCell.querySelector('[draggable="true"]');
                    if (existingCard) {
                        sourceCell.appendChild(existingCard);
                    }
                    targetCell.appendChild(touchDragCard);
                }

                touchDragCard = null;
                touchLastTarget = null;
            }, { passive: false });

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

            cell.addEventListener('click', function () {
                if (!selectedCard) {
                    return;
                }

                if (selectedCard.dataset.category !== cell.dataset.category) {
                    showError('Presúvať môžeš iba v rámci toho istého riadku.');
                    setSelectedCard(null);
                    return;
                }

                const sourceCell = selectedCard.parentElement;
                if (sourceCell === cell) {
                    setSelectedCard(null);
                    return;
                }

                const existingCard = cell.querySelector('[draggable="true"]');
                if (existingCard) {
                    sourceCell.appendChild(existingCard);
                }
                cell.appendChild(selectedCard);
                setSelectedCard(null);
            });
        }

        function buildBoard() {
            categories.forEach(function (category) {
                const row = document.createElement('tr');
                row.className = category.rowClass;
                const labelCell = document.createElement('td');
                labelCell.className = 'border border-slate-700 px-2 py-2 font-semibold text-xs whitespace-nowrap sticky left-0 z-10 ' + category.labelClass;
                labelCell.textContent = category.label;
                row.appendChild(labelCell);

                const values = isSolveMode ? category.solution.slice() : shuffle(category.solution);

                for (let i = 0; i < 5; i++) {
                    const cell = document.createElement('td');
                    cell.className = 'border border-slate-700 px-1 py-1 align-top min-w-[90px] ' + category.rowClass;
                    cell.dataset.category = category.key;
                    cell.dataset.house = String(i);
                    makeDropCell(cell);
                    const card = createCard(category.key, values[i], category.cardClass);
                    card.className = 'cursor-pointer select-none rounded-lg border px-2 py-3 text-slate-100 shadow transition-transform text-xs leading-tight w-full text-center min-h-[44px] flex items-center justify-center ' + category.cardClass;
                    cell.appendChild(card);
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

