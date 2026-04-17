<section class="mastermind-page">
    <div class="mastermind-shell">
        <header class="mastermind-header">
            <p class="mastermind-kicker">Scavenger Stage</p>
            <h1>MASTERMIND</h1>
            <p class="mastermind-subtitle">Uhádni do 8 pokusov, inak prehráš! Po každom pokuse dostaneš spätnú väzbu, ktoré farby a pozície sedia.</p>
        </header>

        <div id="game-screen" class="mastermind-screen">
            <div class="game-topbar">
                <div class="game-badge">MAXIMÁLNE 8 POKUSOV!</div>
                <div id="attempt-indicator" class="attempt-indicator">Pokus 1/8</div>
            </div>

            <div id="solve-panel" class="solve-panel hidden">
                <strong>?vyries=1:</strong>
                <span>Správne riešenie</span>
                <div id="solve-code" class="code-display"></div>
            </div>

            <div class="legend-card">
                <span><span class="peg peg-black"></span> správna farba na správnom mieste</span>
                <span><span class="peg peg-white"></span> správna farba na zlom mieste</span>
                <span><span class="peg peg-empty"></span> farba nie je v kóde</span>
            </div>

            <div class="board-card">
                <div id="board" class="board"></div>
            </div>

            <div id="controls-card" class="controls-card">
                <div class="controls-head">
                    <h2>Paleta farieb</h2>
                    <p>Klikni na pozíciu v aktívnom riadku a vyber farbu.</p>
                </div>

                <div id="palette" class="palette"></div>

                <div class="active-row-panel">
                    <div class="active-row-label">Aktívny pokus</div>
                    <div id="active-preview" class="active-preview"></div>
                </div>

                <div id="game-message" class="game-message hidden"></div>

                <div class="controls-actions">
                    <button id="submit-guess" type="button" class="mastermind-button button-primary" disabled>ODOSLAŤ POKUS</button>
                    <button id="new-game" type="button" class="mastermind-button button-secondary">NOVÁ HRA</button>
                </div>
            </div>
        </div>

        <div id="success-screen" class="mastermind-screen hidden">
            <div class="result-card result-success">
                <h2>✅ ÚSPECH! VYHRAL SI! ✅</h2>
                <p class="result-copy">Tieto dieliky nájdeš v chille pri TS3 ARTe. Toto je pre väčšinu hádanka sama o sebe :D</p>
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
                                <td class="border border-slate-700 px-4 py-3 font-semibold">2x</td>
                                <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/5/11477pb204.jpg" alt="Skupina 1 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                                <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/89/11477pb209.jpg" alt="Skupina 2 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                                <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/11477pb206.jpg" alt="Skupina 3 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                                <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/63/11477pb213.jpg" alt="Skupina 4 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                                <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/11477pb211.jpg" alt="Skupina 5 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                            </tr>
                            <tr>
                                <td class="border border-slate-700 px-4 py-3 font-semibold">2x</td>
                                <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/5/25269.jpg" alt="Skupina 1 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                                <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/89/25269.jpg" alt="Skupina 2 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                                <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/25269.jpg" alt="Skupina 3 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                                <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/63/25269.jpg" alt="Skupina 4 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                                <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/25269.jpg" alt="Skupina 5 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="result-actions">
                    <button id="success-new-game" type="button" class="mastermind-button button-primary">NOVÁ HRA</button>
                </div>
            </div>
        </div>

        <div id="failure-screen" class="mastermind-screen hidden">
            <div class="result-card result-failure">
                <h2>❌ NEÚSPECH! PREHRAL SI ❌</h2>
                <div class="result-code-row">
                    <span>Tajný kód bol:</span>
                    <div id="failure-secret" class="code-display"></div>
                </div>
                <p class="result-copy">Vyčerpal si všetkých 8 pokusov bez uhádnutia.</p>
                <p class="result-copy">Pokúsaj sa znovu!</p>
                <button id="failure-new-game" type="button" class="mastermind-button button-primary">NOVÁ HRA</button>
            </div>
        </div>

    </div>
</section>

<style>
    .mastermind-page {
        min-height: 100vh;
        padding: 2rem 1rem;
        background:
            radial-gradient(circle at top, rgba(255, 215, 0, 0.15), transparent 35%),
            linear-gradient(180deg, #1a1a1a 0%, #232323 50%, #2d2d2d 100%);
        color: #f8fafc;
        font-family: Arial, sans-serif;
    }

    .mastermind-shell {
        width: min(1120px, 100%);
        margin: 0 auto;
        border-radius: 28px;
        border: 1px solid rgba(255, 215, 0, 0.16);
        background: rgba(8, 8, 8, 0.82);
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(18px);
        padding: 1.5rem;
    }

    .mastermind-header {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .mastermind-kicker {
        margin: 0 0 0.5rem;
        color: #ffd700;
        letter-spacing: 0.34em;
        text-transform: uppercase;
        font-size: 0.82rem;
    }

    .mastermind-header h1 {
        margin: 0;
        font-size: clamp(2.1rem, 5vw, 3.7rem);
        color: #ffd700;
        text-shadow: 0 0 18px rgba(255, 215, 0, 0.18);
    }

    .mastermind-subtitle {
        margin: 0.85rem auto 0;
        max-width: 760px;
        line-height: 1.7;
        color: #d1d5db;
    }

    .mastermind-screen.hidden {
        display: none;
    }

    .hidden {
        display: none;
    }

    .game-topbar,
    .legend-card,
    .board-card,
    .controls-card,
    .result-card {
        border-radius: 24px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        background: rgba(20, 20, 20, 0.92);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.03);
    }

    .game-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
        padding: 1rem 1.1rem;
        margin-bottom: 1rem;
    }

    .game-badge,
    .attempt-indicator {
        border-radius: 999px;
        padding: 0.7rem 1rem;
        font-weight: 700;
    }

    .game-badge {
        background: rgba(255, 215, 0, 0.1);
        color: #ffd700;
        border: 1px solid rgba(255, 215, 0, 0.24);
    }

    .attempt-indicator {
        background: rgba(0, 255, 0, 0.08);
        color: #86efac;
        border: 1px solid rgba(0, 255, 0, 0.18);
    }

    .legend-card {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        justify-content: center;
        padding: 0.95rem 1rem;
        margin-bottom: 1rem;
        color: #d1d5db;
    }

    .legend-card span {
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
    }

    .solve-panel {
        display: grid;
        justify-items: center;
        gap: 0.55rem;
        padding: 1rem;
        margin-bottom: 1rem;
        border-radius: 20px;
        border: 1px solid rgba(255, 215, 0, 0.2);
        background: rgba(255, 215, 0, 0.06);
        text-align: center;
    }

    .solve-panel strong {
        color: #ffd700;
    }

    .board-card {
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .board {
        display: flex;
        flex-direction: column-reverse;
        gap: 0.75rem;
    }

    .board.board-shake {
        animation: boardShake 0.35s ease;
    }

    .guess-row {
        display: grid;
        grid-template-columns: minmax(88px, 110px) 1fr minmax(88px, 110px);
        align-items: center;
        gap: 0.75rem;
        padding: 0.85rem;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.06);
        transition: border-color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
    }

    .guess-row.active {
        border-color: rgba(255, 215, 0, 0.55);
        box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.08);
        animation: rowPulse 1.4s ease-in-out infinite;
    }

    .guess-row.locked {
        opacity: 0.95;
    }

    .guess-row.future {
        opacity: 0.35;
    }

    .row-label {
        font-weight: 700;
        color: #d1d5db;
    }

    .guess-cells {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 0.75rem;
    }

    .guess-slot,
    .preview-slot,
    .code-peg,
    .palette-button {
        border-radius: 999px;
        aspect-ratio: 1 / 1;
        min-height: 52px;
    }

    .guess-slot,
    .preview-slot,
    .code-peg {
        border: 2px solid rgba(255, 255, 255, 0.12);
        background: rgba(255, 255, 255, 0.04);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        font-weight: 700;
        color: rgba(255, 255, 255, 0.25);
    }

    .guess-slot.clickable {
        cursor: pointer;
    }

    .guess-slot.selected {
        border-color: #ffd700;
        box-shadow: 0 0 0 4px rgba(255, 215, 0, 0.12);
        transform: translateY(-1px);
    }

    .feedback-grid {
        display: grid;
        grid-template-columns: repeat(2, 16px);
        grid-auto-rows: 16px;
        gap: 0.4rem;
        justify-content: end;
    }

    .peg {
        width: 16px;
        height: 16px;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, 0.16);
        background: rgba(255, 255, 255, 0.06);
    }

    .peg-black {
        background: #22c55e;
        border-color: rgba(34, 197, 94, 0.5);
    }

    .peg-white {
        background: #f97316;
        border-color: rgba(249, 115, 22, 0.5);
    }

    .peg-empty {
        background: #ef4444;
        border-color: rgba(239, 68, 68, 0.5);
    }

    .controls-card,
    .result-card {
        padding: 1.25rem;
    }

    .controls-head h2 {
        margin: 0 0 0.35rem;
        color: #ffd700;
    }

    .controls-head p,
    .result-copy {
        margin: 0;
        color: #d1d5db;
        line-height: 1.65;
    }

    .palette {
        margin-top: 1rem;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(76px, 1fr));
        gap: 0.8rem;
    }

    .palette-button {
        border: 2px solid rgba(255, 255, 255, 0.12);
        cursor: pointer;
        transition: transform 0.15s ease, box-shadow 0.15s ease, border-color 0.15s ease;
        position: relative;
    }

    .palette-button:hover,
    .palette-button:focus-visible {
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.25);
        border-color: rgba(255, 215, 0, 0.55);
        outline: none;
    }

    .palette-button::after {
        content: attr(data-emoji);
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
    }

    .active-row-panel {
        margin-top: 1.2rem;
        border-radius: 18px;
        border: 1px solid rgba(255, 215, 0, 0.16);
        background: rgba(255, 215, 0, 0.04);
        padding: 1rem;
    }

    .active-row-label {
        font-weight: 700;
        margin-bottom: 0.65rem;
        color: #f8fafc;
    }

    .active-preview,
    .code-display {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 64px));
        gap: 0.75rem;
        justify-content: center;
    }

    .game-message {
        margin-top: 1rem;
        border-radius: 16px;
        padding: 0.95rem 1rem;
        border: 1px solid rgba(255, 255, 255, 0.12);
        text-align: center;
        font-weight: 700;
    }

    .game-message.error {
        background: rgba(255, 0, 0, 0.08);
        border-color: rgba(255, 0, 0, 0.26);
        color: #fecaca;
    }

    .controls-actions,
    .reward-actions,
    .result-actions {
        display: flex;
        gap: 0.85rem;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 1.2rem;
    }

    .mastermind-button,
    .reward-link {
        appearance: none;
        border: none;
        border-radius: 16px;
        padding: 1rem 1.35rem;
        font-weight: 900;
        letter-spacing: 0.04em;
        cursor: pointer;
        text-decoration: none;
        transition: transform 0.15s ease, filter 0.15s ease, opacity 0.15s ease;
    }

    .mastermind-button:hover,
    .reward-link:hover {
        transform: translateY(-1px);
        filter: brightness(1.03);
    }

    .mastermind-button:disabled {
        cursor: not-allowed;
        opacity: 0.45;
        transform: none;
        filter: none;
    }

    .button-primary,
    .reward-link {
        background: linear-gradient(135deg, #ffd700 0%, #ffb800 100%);
        color: #111827;
    }

    .button-secondary {
        background: rgba(255, 255, 255, 0.08);
        color: #f8fafc;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .result-card {
        max-width: 760px;
        margin: 0 auto;
        text-align: center;
    }

    .result-success {
        border-color: rgba(0, 255, 0, 0.22);
    }

    .result-failure {
        border-color: rgba(255, 0, 0, 0.22);
    }

    .result-card h2 {
        margin: 0 0 1rem;
        color: #ffd700;
        font-size: clamp(1.6rem, 4vw, 2.4rem);
    }

    .success-table-wrap {
        margin-top: 1rem;
    }

    .result-code-row {
        display: grid;
        gap: 0.6rem;
        margin-bottom: 1rem;
        justify-items: center;
    }

    .result-code-row span {
        color: #d1d5db;
        font-weight: 700;
    }

    @keyframes rowPulse {
        0%, 100% { box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.08); }
        50% { box-shadow: 0 0 0 6px rgba(255, 215, 0, 0.14); }
    }

    @keyframes boardShake {
        0%, 100% { transform: translateX(0); }
        20% { transform: translateX(-6px); }
        40% { transform: translateX(6px); }
        60% { transform: translateX(-4px); }
        80% { transform: translateX(4px); }
    }

    @media (max-width: 820px) {
        .game-topbar {
            align-items: stretch;
        }

        .game-badge,
        .attempt-indicator {
            width: 100%;
            text-align: center;
        }

        .guess-row {
            grid-template-columns: 1fr;
            justify-items: center;
            text-align: center;
            gap: 0.6rem;
            padding: 0.75rem;
        }

        .feedback-grid {
            justify-content: center;
            grid-template-columns: repeat(4, 16px);
            grid-auto-rows: 16px;
        }

        .board-card,
        .controls-card {
            padding: 0.95rem;
        }

        .controls-actions,
        .reward-actions,
        .result-actions {
            flex-direction: column;
        }

        .mastermind-button,
        .reward-link {
            width: 100%;
            text-align: center;
        }
    }

    @media (max-width: 640px) {
        .mastermind-page {
            padding: 1rem 0.75rem;
        }

        .mastermind-shell {
            padding: 1rem;
        }

        .mastermind-subtitle {
            font-size: 0.96rem;
            line-height: 1.55;
        }

        .legend-card {
            justify-content: flex-start;
            gap: 0.75rem;
            padding: 0.9rem;
            font-size: 0.92rem;
        }

        .guess-cells,
        .active-preview,
        .code-display {
            gap: 0.55rem;
        }

        .guess-row {
            width: 100%;
        }

        .guess-cells {
            width: 100%;
        }

        .guess-slot,
        .preview-slot,
        .code-peg,
        .palette-button {
            min-height: 56px;
        }

        .palette {
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0.65rem;
        }

        .palette-button::after {
            font-size: 1.5rem;
        }

        .active-row-label,
        .controls-head,
        .result-card,
        .result-code-row {
            text-align: center;
        }

        .result-card {
            padding: 1rem;
        }
    }
</style>

<script>
    (function () {
        // All logic stays client-side for an instant, dependency-free Mastermind game.
        const isSolveMode = new URLSearchParams(window.location.search).get('vyries') === '1';

        const colors = [
            { key: 'red', label: 'Červená', emoji: '🔴', hex: '#ef4444' },
            { key: 'yellow', label: 'Žltá', emoji: '🟡', hex: '#facc15' },
            { key: 'green', label: 'Zelená', emoji: '🟢', hex: '#22c55e' },
            { key: 'blue', label: 'Modrá', emoji: '🔵', hex: '#3b82f6' },
            { key: 'purple', label: 'Fialová', emoji: '🟣', hex: '#a855f7' },
            { key: 'orange', label: 'Oranžová', emoji: '🟠', hex: '#f97316' },
        ];

        const state = {
            secret: [],
            rows: [],
            currentAttempt: 0,
            currentGuess: [null, null, null, null],
            selectedSlot: 0,
            status: 'playing',
        };

        const elements = {
            gameScreen: document.getElementById('game-screen'),
            board: document.getElementById('board'),
            controlsCard: document.getElementById('controls-card'),
            solvePanel: document.getElementById('solve-panel'),
            solveCode: document.getElementById('solve-code'),
            palette: document.getElementById('palette'),
            activePreview: document.getElementById('active-preview'),
            gameMessage: document.getElementById('game-message'),
            submitGuess: document.getElementById('submit-guess'),
            newGame: document.getElementById('new-game'),
            attemptIndicator: document.getElementById('attempt-indicator'),
            successScreen: document.getElementById('success-screen'),
            successNewGame: document.getElementById('success-new-game'),
            failureScreen: document.getElementById('failure-screen'),
            failureSecret: document.getElementById('failure-secret'),
            failureNewGame: document.getElementById('failure-new-game'),
        };

        if (Object.values(elements).some((element) => !element)) {
            return;
        }

        function randomInt(max) {
            return Math.floor(Math.random() * max);
        }

        function getColor(key) {
            return colors.find((color) => color.key === key) || null;
        }

        function createSecretCode() {
            return Array.from({ length: 4 }, () => colors[randomInt(colors.length)].key);
        }

        // Duplicate-safe Mastermind feedback algorithm.
        function calculateFeedback(guess, secret) {
            let black = 0;
            let white = 0;
            const guessCopy = guess.slice();
            const secretCopy = secret.slice();

            for (let i = 0; i < 4; i += 1) {
                if (guessCopy[i] === secretCopy[i]) {
                    black += 1;
                    guessCopy[i] = null;
                    secretCopy[i] = null;
                }
            }

            for (let i = 0; i < 4; i += 1) {
                if (guessCopy[i] === null) {
                    continue;
                }
                const foundIndex = secretCopy.indexOf(guessCopy[i]);
                if (foundIndex !== -1) {
                    white += 1;
                    secretCopy[foundIndex] = null;
                }
            }

            return { black, white };
        }

        function paintPeg(element, colorKey) {
            const color = colorKey ? getColor(colorKey) : null;
            element.textContent = color ? color.emoji : '';
            element.style.background = color ? color.hex : 'rgba(255,255,255,0.04)';
            element.style.borderColor = color ? 'rgba(255,255,255,0.2)' : 'rgba(255,255,255,0.12)';
            element.style.color = color ? '#111827' : 'rgba(255,255,255,0.25)';
        }

        function createPeg(colorKey, className) {
            const peg = document.createElement('div');
            peg.className = className;
            paintPeg(peg, colorKey);
            return peg;
        }

        function renderPalette() {
            elements.palette.innerHTML = '';
            colors.forEach((color, index) => {
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'palette-button';
                button.dataset.color = color.key;
                button.dataset.emoji = color.emoji;
                button.setAttribute('aria-label', `${index + 1} - ${color.label}`);
                button.style.background = color.hex;
                button.addEventListener('click', () => fillSelectedSlot(color.key));
                elements.palette.appendChild(button);
            });
        }

        function renderPreview() {
            elements.activePreview.innerHTML = '';
            state.currentGuess.forEach((colorKey) => {
                elements.activePreview.appendChild(createPeg(colorKey, 'preview-slot'));
            });
        }

        function renderFeedback(feedback) {
            const wrapper = document.createElement('div');
            wrapper.className = 'feedback-grid';
            const totalPegs = [];

            for (let i = 0; i < feedback.black; i += 1) {
                totalPegs.push('black');
            }
            for (let i = 0; i < feedback.white; i += 1) {
                totalPegs.push('white');
            }
            while (totalPegs.length < 4) {
                totalPegs.push('empty');
            }

            totalPegs.forEach((pegType) => {
                const peg = document.createElement('span');
                peg.className = `peg peg-${pegType}`;
                wrapper.appendChild(peg);
            });

            return wrapper;
        }

        function renderBoard() {
            elements.board.innerHTML = '';

            for (let attempt = 0; attempt < 8; attempt += 1) {
                const row = document.createElement('div');
                const rowState = state.rows[attempt] || null;
                const isPast = attempt < state.currentAttempt;
                const isActive = attempt === state.currentAttempt && state.status === 'playing';
                const isFuture = attempt > state.currentAttempt;

                row.className = 'guess-row';
                if (isActive) row.classList.add('active');
                if (isPast) row.classList.add('locked');
                if (isFuture) row.classList.add('future');

                const label = document.createElement('div');
                label.className = 'row-label';
                label.textContent = `Pokus ${attempt + 1}`;

                const cells = document.createElement('div');
                cells.className = 'guess-cells';
                const guessValues = isPast && rowState ? rowState.guess : isActive ? state.currentGuess : [null, null, null, null];

                guessValues.forEach((colorKey, slotIndex) => {
                    const slot = createPeg(colorKey, 'guess-slot');
                    if (isActive) {
                        slot.classList.add('clickable');
                        if (state.selectedSlot === slotIndex) {
                            slot.classList.add('selected');
                        }
                        slot.addEventListener('click', () => {
                            state.selectedSlot = slotIndex;
                            renderBoard();
                            renderPreview();
                            scrollControlsIntoView();
                        });
                    }
                    cells.appendChild(slot);
                });

                const feedbackHolder = isPast && rowState
                    ? renderFeedback(rowState.feedback)
                    : renderFeedback({ black: 0, white: 0 });

                row.appendChild(label);
                row.appendChild(cells);
                row.appendChild(feedbackHolder);
                elements.board.appendChild(row);
            }
        }

        function updateStatusMessage(message, isError) {
            if (!message) {
                elements.gameMessage.textContent = '';
                elements.gameMessage.classList.add('hidden');
                elements.gameMessage.classList.remove('error');
                return;
            }

            elements.gameMessage.textContent = message;
            elements.gameMessage.classList.remove('hidden');
            elements.gameMessage.classList.toggle('error', Boolean(isError));
        }

        function updateAttemptIndicator() {
            const shownAttempt = Math.min(state.currentAttempt + 1, 8);
            elements.attemptIndicator.textContent = `Pokus ${shownAttempt}/8`;
        }

        function updateSubmitState() {
            const isComplete = state.currentGuess.every((colorKey) => colorKey !== null);
            elements.submitGuess.disabled = !isComplete || state.status !== 'playing';
        }

        function renderCode(container, values) {
            container.innerHTML = '';
            values.forEach((value) => container.appendChild(createPeg(value, 'code-peg')));
        }

        function scrollControlsIntoView() {
            if (window.innerWidth > 820 || !elements.controlsCard) {
                return;
            }

            elements.controlsCard.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest',
            });
        }

        function fillSelectedSlot(colorKey) {
            if (state.status !== 'playing') {
                return;
            }
            state.currentGuess[state.selectedSlot] = colorKey;
            if (state.selectedSlot < 3) {
                state.selectedSlot += 1;
            }
            renderBoard();
            renderPreview();
            updateSubmitState();
            updateStatusMessage('', false);
        }

        function clearSelectedSlot() {
            if (state.status !== 'playing') {
                return;
            }

            if (state.currentGuess[state.selectedSlot] !== null) {
                state.currentGuess[state.selectedSlot] = null;
            } else {
                const lastFilledIndex = [...state.currentGuess].map((value, index) => ({ value, index })).reverse().find((item) => item.value !== null);
                if (lastFilledIndex) {
                    state.selectedSlot = lastFilledIndex.index;
                    state.currentGuess[state.selectedSlot] = null;
                }
            }

            renderBoard();
            renderPreview();
            updateSubmitState();
        }

        function openScreen(name) {
            elements.gameScreen.classList.add('hidden');
            elements.successScreen.classList.add('hidden');
            elements.failureScreen.classList.add('hidden');
            elements[name].classList.remove('hidden');
        }

        function showSuccessScreen() {
            state.status = 'won';
            openScreen('successScreen');
        }

        function showFailureScreen() {
            state.status = 'lost';
            renderCode(elements.failureSecret, state.secret);
            openScreen('failureScreen');
        }

        function updateSolvePanel() {
            if (!isSolveMode) {
                elements.solvePanel.classList.add('hidden');
                return;
            }

            renderCode(elements.solveCode, state.secret);
            elements.solvePanel.classList.remove('hidden');
        }

        function submitGuess() {
            if (state.status !== 'playing' || state.currentGuess.some((value) => value === null)) {
                return;
            }

            const feedback = calculateFeedback(state.currentGuess, state.secret);
            state.rows[state.currentAttempt] = {
                guess: state.currentGuess.slice(),
                feedback,
            };

            elements.board.classList.remove('board-shake');
            void elements.board.offsetWidth;
            elements.board.classList.add('board-shake');
            window.setTimeout(() => elements.board.classList.remove('board-shake'), 350);

            if (feedback.black === 4) {
                renderBoard();
                renderPreview();
                updateSubmitState();
                showSuccessScreen();
                return;
            }

            if (state.currentAttempt === 7) {
                renderBoard();
                renderPreview();
                updateSubmitState();
                showFailureScreen();
                return;
            }

            state.currentAttempt += 1;
            state.currentGuess = [null, null, null, null];
            state.selectedSlot = 0;
            renderBoard();
            renderPreview();
            updateSubmitState();
            updateAttemptIndicator();
            updateStatusMessage('', false);
        }

        function startNewGame() {
            state.secret = createSecretCode();
            state.rows = Array.from({ length: 8 }, () => null);
            state.currentAttempt = 0;
            state.currentGuess = [null, null, null, null];
            state.selectedSlot = 0;
            state.status = 'playing';

            openScreen('gameScreen');
            renderPalette();
            renderBoard();
            renderPreview();
            updateSolvePanel();
            updateAttemptIndicator();
            updateSubmitState();
            updateStatusMessage('Vyber 4 farby a odošli svoj prvý pokus.', false);
        }

        document.addEventListener('keydown', (event) => {
            if (state.status !== 'playing') {
                return;
            }

            if (event.code === 'Enter') {
                if (!elements.submitGuess.disabled) {
                    event.preventDefault();
                    submitGuess();
                }
                return;
            }

            if (event.code === 'Backspace') {
                event.preventDefault();
                clearSelectedSlot();
                return;
            }

            const number = Number(event.key);
            if (number >= 1 && number <= 6) {
                event.preventDefault();
                fillSelectedSlot(colors[number - 1].key);
            }
        });

        elements.submitGuess.addEventListener('click', submitGuess);
        elements.newGame.addEventListener('click', startNewGame);
        elements.successNewGame.addEventListener('click', startNewGame);
        elements.failureNewGame.addEventListener('click', startNewGame);

        startNewGame();
    })();
</script>

        // All logic stays client-side for an instant, dependency-free Mastermind game.
