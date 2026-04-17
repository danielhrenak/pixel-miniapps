<section class="pattern-page">
    <div class="pattern-shell">
        <header class="pattern-header">
            <p class="pattern-kicker">Scavenger Stage</p>
            <h1>MEMORY PATTERN</h1>
            <p class="pattern-subtitle">Zapamätaj si vzor a zopakuj ho! Potrebuješ 5 úspešných pokusov po sebe. Jedna chyba a ideš späť na pokus 1/5.</p>
        </header>

        <div id="game-screen" class="pattern-screen">
            <div class="pattern-topbar">
                <div id="attempt-indicator" class="pattern-badge">Pokus: 1/5</div>
                <div id="phase-indicator" class="pattern-phase">Priprav sa na vzor</div>
            </div>

            <div id="solve-panel" class="solve-panel hidden">
                <p><strong>?vyries=1</strong> režim je aktívny.</p>
                <button id="solve-button" type="button" class="pattern-button button-primary">Zobraziť riešenie</button>
            </div>

            <div class="pattern-card grid-card">
                <div id="pattern-grid" class="pattern-grid" aria-label="5x5 mriežka pre memory pattern"></div>
                <div class="grid-status-block">
                    <h2 id="status-title">Zapamätaj si vzor a zopakuj ho!</h2>
                    <p id="status-text">Počítač ti o chvíľu ukáže nový vzor. Sleduj poradie rozsvietených políčok.</p>
                </div>
            </div>

            <div class="pattern-card info-card">
                <div class="progress-block">
                    <div class="progress-labels">
                        <span>Postup v kole</span>
                        <span id="click-progress">Políčko 0/0</span>
                    </div>
                    <div class="progress-track" aria-hidden="true">
                        <div id="progress-bar" class="progress-bar"></div>
                    </div>
                </div>

                <div id="feedback-box" class="feedback-box hidden"></div>

                <div class="controls-row">
                    <button id="start-button" type="button" class="pattern-button button-primary">Spustiť vzor</button>
                    <button id="restart-button" type="button" class="pattern-button button-secondary">Začať odznova</button>
                </div>
            </div>
        </div>

        <div id="success-screen" class="pattern-screen hidden">
            <div class="pattern-card success-card">
                <h2>🎉 ÚSPECH! VYHRAL SI! 🎉</h2>
                <p class="success-copy">Tieto dieliky nájdeš pri osobe, ktorá ti rada predá svoje Thor Steinar mikiny.</p>

                <div class="overflow-x-auto success-table-wrap">
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
                                <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/5/3024.jpg" alt="Skupina 1 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                                <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/89/3024.jpg" alt="Skupina 2 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                                <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/36/3024.jpg" alt="Skupina 3 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                                <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/4/3024.jpg" alt="Skupina 4 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                                <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/47/3024.jpg" alt="Skupina 5 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                            </tr>
                            <tr>
                                <td class="border border-slate-700 px-4 py-3 font-semibold">1x</td>
                                <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/1/3626.jpg" alt="Skupina 1 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                                <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/1/3626.jpg" alt="Skupina 2 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                                <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/1/3626.jpg" alt="Skupina 3 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                                <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/1/3626.jpg" alt="Skupina 4 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                                <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/1/3626.jpg" alt="Skupina 5 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="controls-row success-actions">
                    <button id="success-restart-button" type="button" class="pattern-button button-primary">ĎALŠIA HRA</button>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .pattern-page {
        min-height: 100vh;
        padding: 2rem 1rem;
        background:
            radial-gradient(circle at top, rgba(255, 215, 0, 0.12), transparent 35%),
            linear-gradient(180deg, #1a1a1a 0%, #222 45%, #2d2d2d 100%);
        color: #f8fafc;
        font-family: Arial, sans-serif;
    }

    .pattern-shell {
        width: min(1080px, 100%);
        margin: 0 auto;
        padding: 1.5rem;
        border-radius: 28px;
        border: 1px solid rgba(255, 215, 0, 0.16);
        background: rgba(8, 8, 8, 0.84);
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.48);
        backdrop-filter: blur(18px);
    }

    .pattern-header {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .pattern-kicker {
        margin: 0 0 0.45rem;
        color: #ffd700;
        letter-spacing: 0.34em;
        text-transform: uppercase;
        font-size: 0.82rem;
    }

    .pattern-header h1 {
        margin: 0;
        font-size: clamp(2rem, 5vw, 3.5rem);
        color: #ffd700;
        text-shadow: 0 0 18px rgba(255, 215, 0, 0.2);
    }

    .pattern-subtitle {
        margin: 0.9rem auto 0;
        max-width: 760px;
        line-height: 1.7;
        color: #d1d5db;
    }

    .hidden {
        display: none;
    }

    .pattern-topbar,
    .pattern-card,
    .solve-panel {
        border-radius: 24px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        background: rgba(20, 20, 20, 0.92);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.03);
    }

    .pattern-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
        padding: 1rem 1.1rem;
        margin-bottom: 1rem;
    }

    .pattern-badge,
    .pattern-phase {
        border-radius: 999px;
        padding: 0.7rem 1rem;
        font-weight: 700;
    }

    .pattern-badge {
        background: rgba(255, 215, 0, 0.1);
        color: #ffd700;
        border: 1px solid rgba(255, 215, 0, 0.24);
    }

    .pattern-phase {
        background: rgba(0, 255, 0, 0.08);
        color: #86efac;
        border: 1px solid rgba(0, 255, 0, 0.18);
    }

    .solve-panel {
        display: grid;
        gap: 0.8rem;
        justify-items: center;
        text-align: center;
        padding: 1rem;
        margin-bottom: 1rem;
        border-color: rgba(255, 215, 0, 0.2);
        background: rgba(255, 215, 0, 0.06);
    }

    .solve-panel.hidden {
        display: none;
    }

    .solve-panel p {
        margin: 0;
        color: #e5e7eb;
    }

    .pattern-card {
        padding: 1.1rem;
        margin-bottom: 1rem;
    }

    .grid-card {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .pattern-grid {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 82px));
        gap: 0.6rem;
        width: 100%;
        max-width: 460px;
    }

    .pattern-cell {
        aspect-ratio: 1 / 1;
        border-radius: 16px;
        border: 2px solid rgba(255, 255, 255, 0.08);
        background: #444;
        transition: transform 0.15s ease, background-color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
        cursor: default;
    }

    .pattern-cell.is-player-turn {
        cursor: pointer;
        border-color: rgba(255, 255, 255, 0.18);
    }

    .pattern-cell.is-player-turn:hover,
    .pattern-cell.is-player-turn:focus-visible {
        transform: translateY(-1px);
        border-color: rgba(255, 215, 0, 0.45);
        outline: none;
    }

    .pattern-cell.flash-computer {
        background: #ffd700;
        border-color: rgba(255, 215, 0, 0.85);
        box-shadow: 0 0 0 5px rgba(255, 215, 0, 0.14);
    }

    .pattern-cell.flash-player {
        background: #0099ff;
        border-color: rgba(0, 153, 255, 0.85);
        box-shadow: 0 0 0 5px rgba(0, 153, 255, 0.14);
    }

    .pattern-cell.flash-error {
        background: #ff0000;
        border-color: rgba(255, 0, 0, 0.85);
        box-shadow: 0 0 0 5px rgba(255, 0, 0, 0.14);
    }

    .pattern-cell.flash-success {
        background: #00ff7f;
        border-color: rgba(0, 255, 127, 0.9);
        box-shadow: 0 0 0 5px rgba(0, 255, 127, 0.15);
    }

    .grid-status-block {
        width: 100%;
        margin-top: 1rem;
        text-align: center;
    }

    .grid-status-block h2 {
        margin: 0 0 0.35rem;
        color: #ffd700;
        font-size: clamp(1.2rem, 3vw, 1.6rem);
    }

    .grid-status-block p,
    .success-copy {
        margin: 0;
        color: #d1d5db;
        line-height: 1.6;
    }

    .progress-block {
        margin-top: 0.2rem;
    }

    .progress-labels {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 0.45rem;
        color: #d1d5db;
        font-weight: 700;
    }

    .progress-track {
        height: 12px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.08);
        overflow: hidden;
    }

    .progress-bar {
        height: 100%;
        width: 0;
        background: linear-gradient(90deg, #0099ff 0%, #ffd700 100%);
        border-radius: inherit;
        transition: width 0.2s ease;
    }

    .feedback-box {
        margin-top: 1rem;
        border-radius: 18px;
        padding: 1rem;
        font-weight: 700;
        line-height: 1.65;
        text-align: center;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .feedback-box.error {
        background: rgba(255, 0, 0, 0.08);
        border-color: rgba(255, 0, 0, 0.26);
        color: #fecaca;
    }

    .feedback-box.success {
        background: rgba(0, 255, 0, 0.08);
        border-color: rgba(0, 255, 0, 0.24);
        color: #bbf7d0;
    }

    .controls-row,
    .success-actions {
        display: flex;
        gap: 0.85rem;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 1.1rem;
    }

    .pattern-button {
        appearance: none;
        border: none;
        border-radius: 16px;
        padding: 1rem 1.35rem;
        font-weight: 900;
        letter-spacing: 0.04em;
        cursor: pointer;
        transition: transform 0.15s ease, filter 0.15s ease, opacity 0.15s ease;
    }

    .pattern-button:hover {
        transform: translateY(-1px);
        filter: brightness(1.03);
    }

    .pattern-button:disabled {
        cursor: not-allowed;
        opacity: 0.45;
        transform: none;
        filter: none;
    }

    .button-primary {
        background: linear-gradient(135deg, #ffd700 0%, #ffb800 100%);
        color: #111827;
    }

    .button-secondary {
        background: rgba(255, 255, 255, 0.08);
        color: #f8fafc;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .success-card {
        max-width: 780px;
        margin: 0 auto;
        text-align: center;
    }

    .success-card h2 {
        margin: 0 0 1rem;
        color: #00ff88;
        font-size: clamp(1.7rem, 4vw, 2.4rem);
    }

    .success-table-wrap {
        margin-top: 1rem;
    }

    .shake {
        animation: shake 0.35s ease;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        20% { transform: translateX(-6px); }
        40% { transform: translateX(6px); }
        60% { transform: translateX(-4px); }
        80% { transform: translateX(4px); }
    }

    @media (max-width: 820px) {
        .pattern-topbar {
            align-items: stretch;
        }

        .pattern-badge,
        .pattern-phase,
        .pattern-button {
            width: 100%;
            text-align: center;
        }

        .controls-row,
        .success-actions {
            flex-direction: column;
        }
    }

    @media (max-width: 640px) {
        .pattern-page {
            padding: 1rem 0.75rem;
        }

        .pattern-shell {
            padding: 1rem;
        }

        .pattern-grid {
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 0.45rem;
        }

        .pattern-cell {
            border-radius: 12px;
        }

        .pattern-subtitle {
            font-size: 0.96rem;
            line-height: 1.55;
        }

        .grid-status-block {
            margin-top: 0.85rem;
        }

        .progress-labels,
        .success-card {
            text-align: center;
        }
    }
</style>

<script>
    (function () {
        const isSolveMode = new URLSearchParams(window.location.search).get('vyries') === '1';
        const GRID_SIZE = 5;
        const TOTAL_WINS = 5;
        const MIN_PATTERN = 5;
        const MAX_PATTERN = 8;
        const COMPUTER_FLASH_MS = 520;
        const COMPUTER_GAP_MS = 230;
        const PLAYER_FLASH_MS = 220;
        const NEXT_ROUND_DELAY_MS = 1400;
        const RESET_DELAY_MS = 2200;

        const state = {
            streak: 1,
            currentPattern: [],
            playerIndex: 0,
            isPlaybackRunning: false,
            isPlayerTurn: false,
            solved: false,
        };

        const elements = {
            gameScreen: document.getElementById('game-screen'),
            successScreen: document.getElementById('success-screen'),
            grid: document.getElementById('pattern-grid'),
            attemptIndicator: document.getElementById('attempt-indicator'),
            phaseIndicator: document.getElementById('phase-indicator'),
            statusTitle: document.getElementById('status-title'),
            statusText: document.getElementById('status-text'),
            clickProgress: document.getElementById('click-progress'),
            progressBar: document.getElementById('progress-bar'),
            feedbackBox: document.getElementById('feedback-box'),
            startButton: document.getElementById('start-button'),
            restartButton: document.getElementById('restart-button'),
            solvePanel: document.getElementById('solve-panel'),
            solveButton: document.getElementById('solve-button'),
            successRestartButton: document.getElementById('success-restart-button'),
        };

        if (Object.values(elements).some((element) => !element)) {
            return;
        }

        function delay(ms) {
            return new Promise((resolve) => {
                window.setTimeout(resolve, ms);
            });
        }

        function randomInt(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }

        function indexToCellId(index) {
            const row = Math.floor(index / GRID_SIZE);
            const col = index % GRID_SIZE;
            return `${row}-${col}`;
        }

        function formatCellId(cellId) {
            const [row, col] = cellId.split('-').map(Number);
            return `${String.fromCharCode(65 + row)}${col + 1}`;
        }

        function buildGrid() {
            elements.grid.innerHTML = '';

            for (let index = 0; index < GRID_SIZE * GRID_SIZE; index += 1) {
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'pattern-cell';
                button.dataset.cellId = indexToCellId(index);
                button.setAttribute('aria-label', `Políčko ${formatCellId(button.dataset.cellId)}`);
                button.addEventListener('click', () => handleCellClick(button.dataset.cellId, button));
                elements.grid.appendChild(button);
            }
        }

        function getCell(cellId) {
            return elements.grid.querySelector(`[data-cell-id="${cellId}"]`);
        }

        function setBoardInteractive(isInteractive) {
            elements.grid.querySelectorAll('.pattern-cell').forEach((cell) => {
                cell.classList.toggle('is-player-turn', isInteractive);
                cell.disabled = !isInteractive;
            });
        }

        function clearBoardState() {
            elements.grid.querySelectorAll('.pattern-cell').forEach((cell) => {
                cell.classList.remove('flash-computer', 'flash-player', 'flash-error', 'flash-success', 'shake');
            });
        }

        function updateAttemptIndicator() {
            elements.attemptIndicator.textContent = `Pokus: ${state.streak}/${TOTAL_WINS}`;
        }

        function updateProgress() {
            elements.clickProgress.textContent = `Políčko ${state.playerIndex}/${state.currentPattern.length}`;
            const percentage = state.currentPattern.length > 0 ? (state.playerIndex / state.currentPattern.length) * 100 : 0;
            elements.progressBar.style.width = `${percentage}%`;
        }

        function setStatus(title, text, phase) {
            elements.statusTitle.textContent = title;
            elements.statusText.textContent = text;
            elements.phaseIndicator.textContent = phase;
        }

        function setFeedback(message, type) {
            if (!message) {
                elements.feedbackBox.textContent = '';
                elements.feedbackBox.className = 'feedback-box hidden';
                return;
            }

            elements.feedbackBox.textContent = message;
            elements.feedbackBox.className = `feedback-box ${type}`;
        }

        function generatePattern() {
            const pool = Array.from({ length: GRID_SIZE * GRID_SIZE }, (_, index) => indexToCellId(index));
            const patternLength = randomInt(MIN_PATTERN, MAX_PATTERN);
            const pattern = [];

            while (pattern.length < patternLength) {
                const pickedIndex = randomInt(0, pool.length - 1);
                pattern.push(pool[pickedIndex]);
                pool.splice(pickedIndex, 1);
            }

            return pattern;
        }

        async function flashCell(cellId, className, duration) {
            const cell = getCell(cellId);
            if (!cell) {
                return;
            }

            cell.classList.add(className);
            await delay(duration);
            cell.classList.remove(className);
        }

        async function playPattern() {
            state.isPlaybackRunning = true;
            state.isPlayerTurn = false;
            setBoardInteractive(false);
            setStatus('Zapamätaj si vzor a zopakuj ho!', 'Počítač hrá vzor. Sleduj poradie rozsvietených políčok.', `Pokus ${state.streak}/${TOTAL_WINS}`);
            setFeedback('', '');
            state.playerIndex = 0;
            updateProgress();
            clearBoardState();

            for (const cellId of state.currentPattern) {
                await flashCell(cellId, 'flash-computer', COMPUTER_FLASH_MS);
                await delay(COMPUTER_GAP_MS);
            }

            state.isPlaybackRunning = false;
            state.isPlayerTurn = true;
            setBoardInteractive(true);
            setStatus('TVOJ RAD! Zopakuj vzor!', 'Klikaj na políčka v presne rovnakom poradí ako počítač.', `Pokus ${state.streak}/${TOTAL_WINS}`);
        }

        function sequenceToText(pattern) {
            return pattern.map(formatCellId).join(' → ');
        }

        async function handleRoundSuccess() {
            state.isPlayerTurn = false;
            setBoardInteractive(false);
            setFeedback('✅ SPRÁVNE! Ďalší vzor sa načítava...', 'success');
            setStatus('✅ SPRÁVNE!', 'Zvládol si aktuálny vzor bez chyby.', `Pokus ${state.streak}/${TOTAL_WINS}`);
            elements.grid.querySelectorAll('.pattern-cell').forEach((cell) => cell.classList.add('flash-success'));
            await delay(NEXT_ROUND_DELAY_MS);
            clearBoardState();

            if (state.streak === TOTAL_WINS) {
                state.solved = true;
                showSuccessScreen();
                return;
            }

            state.streak += 1;
            startRound();
        }

        async function handleRoundError(clickedCellId) {
            state.isPlayerTurn = false;
            setBoardInteractive(false);
            const clickedCell = getCell(clickedCellId);
            if (clickedCell) {
                clickedCell.classList.add('flash-error', 'shake');
            }

            setFeedback(`❌ ZLE! Správne poradie bolo: ${sequenceToText(state.currentPattern)}`, 'error');
            setStatus('❌ ZLE!', 'Poradie je zložité. Pokúšaj sa znovu! Pokus sa resetuje na 1/5.', 'Reset pokusu');
            state.streak = 1;
            updateAttemptIndicator();
            state.playerIndex = 0;
            updateProgress();

            await delay(RESET_DELAY_MS);
            clearBoardState();
            startRound();
        }

        function handleCellClick(cellId, cellElement) {
            if (!state.isPlayerTurn || state.isPlaybackRunning || state.solved) {
                return;
            }

            const expectedCellId = state.currentPattern[state.playerIndex];
            cellElement.classList.add('flash-player');
            window.setTimeout(() => {
                cellElement.classList.remove('flash-player');
            }, PLAYER_FLASH_MS);

            if (cellId !== expectedCellId) {
                void handleRoundError(cellId);
                return;
            }

            state.playerIndex += 1;
            updateProgress();

            if (state.playerIndex === state.currentPattern.length) {
                void handleRoundSuccess();
            }
        }

        function showSuccessScreen() {
            elements.gameScreen.classList.add('hidden');
            elements.successScreen.classList.remove('hidden');
        }

        function showGameScreen() {
            elements.successScreen.classList.add('hidden');
            elements.gameScreen.classList.remove('hidden');
        }

        function startRound() {
            state.currentPattern = generatePattern();
            state.playerIndex = 0;
            updateAttemptIndicator();
            updateProgress();
            setFeedback('', '');
            setStatus('Zapamätaj si vzor a zopakuj ho!', 'Stlač tlačidlo a sleduj, ktoré políčka sa rozsvietia.', `Pokus ${state.streak}/${TOTAL_WINS}`);
            setBoardInteractive(false);
            elements.startButton.disabled = false;
        }

        function startGame() {
            state.solved = false;
            state.streak = 1;
            showGameScreen();
            startRound();
        }

        function playCurrentPattern() {
            if (state.isPlaybackRunning || state.solved) {
                return;
            }

            elements.startButton.disabled = true;
            void playPattern();
        }

        function solveImmediately() {
            if (!isSolveMode) {
                return;
            }
            state.solved = true;
            showSuccessScreen();
        }

        elements.startButton.addEventListener('click', playCurrentPattern);
        elements.restartButton.addEventListener('click', startGame);
        elements.successRestartButton.addEventListener('click', startGame);

        if (isSolveMode) {
            elements.solvePanel.classList.remove('hidden');
            elements.solveButton.addEventListener('click', solveImmediately);
        }

        buildGrid();
        startGame();
    })();
</script>

