<section class="memory-page">
    <div class="memory-shell">
        <header class="memory-header">
            <p class="memory-kicker">Scavenger Stage</p>
            <h1>FIND IN DETAILS</h1>
            <p id="memory-subtitle" class="memory-subtitle">Pamäťová hra s 30-sekundovým limitom. Zapamätaj si scénu, potom odpovedz na otázky bez toho, aby si sa k nej vrátil.</p>
        </header>

        <div id="memorize-screen" class="memory-screen">
            <div class="memory-topbar">
                <div class="memory-phase-pill">Fáza 1: Sleduj scénu</div>
                <div id="timer-chip" class="timer-chip">30s</div>
            </div>

            <div class="progress-track" aria-hidden="true">
                <div id="progress-bar" class="progress-bar"></div>
            </div>

            <div class="scene-card">
                <div class="scene-meta">
                    <div><strong>Úloha:</strong> Pozeraj, počítaj a zapamätaj si detaily.</div>
                    <div id="scene-meta-time">Čas beží automaticky.</div>
                </div>
                <div id="scene-grid" class="scene-grid" aria-label="Pamäťová scéna plná emoji symbolov"></div>
            </div>
        </div>

        <div id="quiz-screen" class="memory-screen hidden">
            <div class="memory-topbar">
                <div class="memory-phase-pill">Fáza 2: Odpovede</div>
            </div>

            <div class="quiz-card">
                <h2>Scéna zmizla. Teraz odpovedz podľa pamäti.</h2>
                <p>Obrázok už nie je dostupný. Zadaj čísla čo najpresnejšie.</p>

                <form id="quiz-form" class="quiz-form">
                    <div id="questions-container" class="questions-grid"></div>
                    <div id="quiz-error" class="quiz-error hidden">Niektorá odpoveď nie je správna. Hra sa spustí odznova.</div>
                    <button type="submit" class="primary-button">ODOSLAŤ ODPOVEDE</button>
                </form>
            </div>
        </div>

        <div id="result-screen" class="memory-screen hidden">
            <div class="memory-topbar">
                <div class="memory-phase-pill">Fáza 3: Nápoveda</div>
            </div>

            <div class="result-card">
                <h2>Hľadaj tieto dieliky? Kde? 🌍</h2>
            </div>

            <div class="result-card">
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
                                <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/5/7071pb19.jpg" alt="Skupina 1 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                                <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/1/7071pb15.jpg" alt="Skupina 2 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                                <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/7071pb14.jpg" alt="Skupina 3 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                                <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/63/7071pb11.jpg" alt="Skupina 4 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                                <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/7/7071pb16.jpg" alt="Skupina 5 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                            </tr>
                            <tr>
                                <td class="border border-slate-700 px-4 py-3 font-semibold">1x</td>
                                <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/54200.jpg" alt="Skupina 1 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                                <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/156/54200.jpg" alt="Skupina 2 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                                <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/54200.jpg" alt="Skupina 3 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                                <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/63/54200.jpg" alt="Skupina 4 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                                <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/47/54200.jpg" alt="Skupina 5 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="result-actions">
                <button id="play-again-btn" type="button" class="primary-button">HRAŤ ZNOVA</button>
            </div>
        </div>
    </div>
</section>

<style>
    .memory-page {
        min-height: 100vh;
        padding: 2rem 1rem;
        background:
            radial-gradient(circle at top, rgba(255, 215, 0, 0.12), transparent 35%),
            linear-gradient(180deg, #1a1a1a 0%, #202020 45%, #2d2d2d 100%);
        color: #f8fafc;
        font-family: Arial, sans-serif;
    }

    .memory-shell {
        width: min(1180px, 100%);
        margin: 0 auto;
        border: 1px solid rgba(255, 215, 0, 0.15);
        border-radius: 28px;
        background: rgba(10, 10, 10, 0.78);
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.45);
        backdrop-filter: blur(18px);
        padding: 1.5rem;
    }

    .memory-header {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .memory-kicker {
        margin: 0 0 0.5rem;
        color: #ffd700;
        letter-spacing: 0.35em;
        text-transform: uppercase;
        font-size: 0.8rem;
    }

    .memory-header h1 {
        margin: 0;
        font-size: clamp(2rem, 5vw, 3.5rem);
        color: #ffd700;
        text-shadow: 0 0 18px rgba(255, 215, 0, 0.2);
    }

    .memory-subtitle {
        margin: 0.85rem auto 0;
        max-width: 760px;
        color: #d1d5db;
        line-height: 1.65;
    }

    .memory-screen {
        opacity: 1;
        transform: translateY(0);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }

    .memory-screen.hidden {
        display: none;
    }

    .memory-topbar {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        align-items: center;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }

    .memory-phase-pill,
    .timer-chip {
        border-radius: 999px;
        padding: 0.7rem 1rem;
        font-weight: 700;
    }

    .memory-phase-pill {
        background: rgba(255, 215, 0, 0.1);
        color: #ffd700;
        border: 1px solid rgba(255, 215, 0, 0.28);
    }

    .timer-chip {
        min-width: 5.5rem;
        text-align: center;
        border: 1px solid rgba(0, 255, 0, 0.25);
        background: rgba(0, 255, 0, 0.12);
        color: #86efac;
        transition: transform 0.2s ease, background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease, animation 0.2s ease;
    }

    .progress-track {
        height: 12px;
        width: 100%;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.08);
        overflow: hidden;
        margin-bottom: 1rem;
    }

    .progress-bar {
        height: 100%;
        width: 100%;
        border-radius: inherit;
        background: linear-gradient(90deg, #00ff00 0%, #ffd700 55%, #ff0000 100%);
        transform-origin: left center;
        transition: width 0.2s linear;
    }

    .scene-card,
    .quiz-card,
    .result-card {
        border-radius: 24px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        background: rgba(19, 19, 19, 0.92);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.03);
        padding: 1.25rem;
    }

    .scene-meta {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 1rem;
        color: #d1d5db;
        font-size: 0.95rem;
    }

    .scene-grid {
        --scene-cols: 12;
        display: grid;
        grid-template-columns: repeat(var(--scene-cols), minmax(0, 1fr));
        gap: 0.45rem;
        padding: 0.4rem;
    }

    .scene-grid > div {
        --float-duration: 4s;
        --float-delay: 0s;
        --float-offset: 0px;
        --rotate: 0deg;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 48px;
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.04);
        font-size: clamp(1rem, 2vw, 1.8rem);
        user-select: none;
        animation: floatItem var(--float-duration) ease-in-out infinite;
        animation-delay: var(--float-delay);
        transform: translateY(var(--float-offset)) rotate(var(--rotate));
    }

    .quiz-card h2 {
        margin: 0 0 0.45rem;
        color: #ffd700;
    }

    .quiz-card p {
        margin: 0 0 1.2rem;
        color: #d1d5db;
    }

    .quiz-form {
        display: grid;
        gap: 1.25rem;
    }

    .questions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1rem;
    }

    .questions-grid > div {
        border-radius: 18px;
        border: 1px solid rgba(255, 215, 0, 0.15);
        background: rgba(255, 215, 0, 0.04);
        padding: 1rem;
    }

    .questions-grid > div label {
        display: block;
        font-weight: 700;
        line-height: 1.55;
        margin-bottom: 0.8rem;
        color: #f8fafc;
    }

    .questions-grid > div input {
        width: 100%;
        border-radius: 14px;
        border: 1px solid rgba(255, 255, 255, 0.12);
        background: rgba(255, 255, 255, 0.04);
        padding: 0.9rem 1rem;
        color: #f8fafc;
        font-size: 1rem;
        outline: none;
    }

    .questions-grid > div input:focus {
        border-color: rgba(255, 215, 0, 0.55);
        box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.12);
    }

    .quiz-error {
        border-radius: 16px;
        border: 1px solid rgba(255, 0, 0, 0.28);
        background: rgba(255, 0, 0, 0.08);
        color: #fecaca;
        padding: 0.9rem 1rem;
        text-align: center;
        font-weight: 700;
    }

    .primary-button {
        appearance: none;
        border: none;
        border-radius: 16px;
        background: linear-gradient(135deg, #ffd700 0%, #ffb800 100%);
        color: #111827;
        font-weight: 900;
        letter-spacing: 0.04em;
        padding: 1rem 1.4rem;
        cursor: pointer;
        transition: transform 0.15s ease, filter 0.15s ease;
    }

    .primary-button:hover {
        transform: translateY(-1px);
        filter: brightness(1.03);
    }

    .result-card h2 {
        margin: 0;
        text-align: center;
        color: #ffd700;
        font-size: clamp(1.3rem, 3vw, 2rem);
    }

    .result-actions {
        display: flex;
        justify-content: center;
        margin-top: 1rem;
    }

    .hidden {
        display: none;
    }

    @keyframes floatItem {
        0%, 100% {
            transform: translateY(var(--float-offset)) rotate(var(--rotate));
        }
        50% {
            transform: translateY(calc(var(--float-offset) - 8px)) rotate(var(--rotate));
        }
    }

    @keyframes timerPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    @media (max-width: 900px) {
        .scene-grid {
            gap: 0.3rem;
        }

        .scene-grid > div {
            min-height: 42px;
            font-size: 1.15rem;
        }
    }

    @media (max-width: 640px) {
        .memory-page {
            padding: 1rem 0.75rem;
        }

        .memory-shell {
            padding: 1rem;
        }

        .scene-grid > div {
            min-height: 36px;
            border-radius: 10px;
            font-size: 1rem;
        }
    }
</style>

<script>
    (function () {
        const searchParams = new URLSearchParams(window.location.search);
        const isSolveMode = searchParams.get('vyries') === '1';

        const config = {
            memorizeSeconds: isSolveMode ? 5 : 30,
            dummyCount: 15,
            columns: [10, 11, 12, 13, 14, 15],
            specialTypes: [
                { key: 'wolves', emoji: '🐺', min: 2, max: 6, label: 'vlkov' },
                { key: 'guns', emoji: '🔫', min: 3, max: 10, label: 'zbraní' },
                { key: 'skulls', emoji: '💀', min: 2, max: 8, label: 'lebiek' },
                { key: 'zombies', emoji: '🧟', min: 1, max: 6, label: 'zombie' },
                { key: 'viruses', emoji: '🦠', min: 1, max: 5, label: 'víruses' },
                { key: 'radiation', emoji: '☢️', min: 1, max: 4, label: 'radiácie' },
                { key: 'aliens', emoji: '👽', min: 1, max: 5, label: 'mimozemšťanov' },
                { key: 'bombs', emoji: '💣', min: 1, max: 3, label: 'bômb' },
                { key: 'meteors', emoji: '☄️', min: 1, max: 4, label: 'meteoritov' },
                { key: 'scorpions', emoji: '🦂', min: 1, max: 4, label: 'škorpiónov' },
                { key: 'buildings', emoji: '🏚️', min: 1, max: 3, label: 'budov' },
                { key: 'fire', emoji: '🔥', min: 1, max: 3, label: 'ohňov' },
            ],
            dummyEmojis: ['🌍', '🌳', '🌑', '⚙️', '💡', '🔔', '📍', '⬜', '⬛'],
        };

        const state = {
            phase: 'memorize',
            sceneItems: [],
            counts: {},
            totalSpecial: 0,
            activeQuestions: [],
            sceneColumns: 12,
            remainingMs: config.memorizeSeconds * 1000,
            intervalId: null,
            startedAt: null,
            restartTimeoutId: null,
        };

        const elements = {
            memorizeScreen: document.getElementById('memorize-screen'),
            quizScreen: document.getElementById('quiz-screen'),
            resultScreen: document.getElementById('result-screen'),
            memorySubtitle: document.getElementById('memory-subtitle'),
            sceneMetaTime: document.getElementById('scene-meta-time'),
            sceneGrid: document.getElementById('scene-grid'),
            timerChip: document.getElementById('timer-chip'),
            progressBar: document.getElementById('progress-bar'),
            questionsContainer: document.getElementById('questions-container'),
            quizForm: document.getElementById('quiz-form'),
            quizError: document.getElementById('quiz-error'),
            playAgainBtn: document.getElementById('play-again-btn'),
        };

        if (Object.values(elements).some((element) => !element)) {
            console.log('stage_memory: required elements not found');
            return;
        }

        const questions = [
            { key: 'wolves', text: 'Koľko vlkov (🐺) si videl?' },
            { key: 'guns', text: 'Koľko zbraní (🔫)?' },
            { key: 'skulls', text: 'Koľko lebiek (💀)?' },
            { key: 'zombies', text: 'Koľko zombie (🧟)?' },
            { key: 'viruses', text: 'Koľko víruses (🦠)?' },
            { key: 'radiation', text: 'Koľko radiácie (☢️)?' },
            { key: 'aliens', text: 'Koľko mimozemšťanov (👽)?' },
            { key: 'totalSpecial', text: 'Aký je CELKOVÝ počet všetkých prvkov?' },
        ];

        function getActiveQuestions() {
            const totalQuestion = questions.find((question) => question.key === 'totalSpecial');
            const otherQuestions = questions.filter((question) => question.key !== 'totalSpecial');
            const selected = shuffle(otherQuestions).slice(0, 2);

            return shuffle([...(totalQuestion ? [totalQuestion] : []), ...selected]);
        }

        function randomInt(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }

        function shuffle(array) {
            const copy = array.slice();
            for (let i = copy.length - 1; i > 0; i -= 1) {
                const j = Math.floor(Math.random() * (i + 1));
                [copy[i], copy[j]] = [copy[j], copy[i]];
            }
            return copy;
        }

        function chooseColumns() {
            const width = window.innerWidth;
            if (width < 560) {
                return 10;
            }
            if (width < 860) {
                return 12;
            }
            return config.columns[randomInt(2, config.columns.length - 1)] || 14;
        }

        function generateCounts() {
            const counts = {};
            let total = 0;

            config.specialTypes.forEach((type) => {
                const count = randomInt(type.min, type.max);
                counts[type.key] = count;
                total += count;
            });

            while (total + config.dummyCount < 50) {
                const expandable = config.specialTypes.filter((type) => counts[type.key] < type.max);
                if (!expandable.length) {
                    break;
                }
                const chosen = expandable[randomInt(0, expandable.length - 1)];
                counts[chosen.key] += 1;
                total += 1;
            }

            return { counts, totalSpecial: total + config.dummyCount };
        }

        function getCorrectAnswer(questionKey) {
            if (questionKey === 'totalSpecial') {
                return state.totalSpecial;
            }
            return state.counts[questionKey] ?? 0;
        }

        function buildSceneItems() {
            const { counts, totalSpecial } = generateCounts();
            const items = [];

            config.specialTypes.forEach((type) => {
                for (let i = 0; i < counts[type.key]; i += 1) {
                    items.push({ emoji: type.emoji, label: type.label });
                }
            });

            for (let i = 0; i < config.dummyCount; i += 1) {
                items.push({
                    emoji: config.dummyEmojis[randomInt(0, config.dummyEmojis.length - 1)],
                    label: 'dummy',
                });
            }

            state.counts = counts;
            state.totalSpecial = totalSpecial;
            state.sceneItems = shuffle(items);
            state.sceneColumns = chooseColumns();
            console.log('stage_memory scene counts', { counts, totalSpecial, totalItems: items.length });
        }

        function renderScene() {
            elements.sceneGrid.innerHTML = '';
            elements.sceneGrid.style.setProperty('--scene-cols', String(state.sceneColumns));

            state.sceneItems.forEach((item, index) => {
                const cell = document.createElement('div');
                cell.textContent = item.emoji;
                cell.setAttribute('role', 'img');
                cell.setAttribute('aria-label', item.label);
                cell.style.setProperty('--float-duration', `${randomInt(3, 6)}s`);
                cell.style.setProperty('--float-delay', `${(index % 10) * 0.12}s`);
                cell.style.setProperty('--float-offset', `${randomInt(-2, 4)}px`);
                cell.style.setProperty('--rotate', `${randomInt(-12, 12)}deg`);
                elements.sceneGrid.appendChild(cell);
            });
        }

        function updateTimerUi(remainingMs) {
            const seconds = Math.ceil(remainingMs / 1000);
            const ratio = Math.max(0, remainingMs / (config.memorizeSeconds * 1000));
            elements.timerChip.textContent = `${seconds}s`;
            elements.progressBar.style.width = `${ratio * 100}%`;

            if (seconds <= 10) {
                elements.timerChip.style.background = 'rgba(255, 0, 0, 0.15)';
                elements.timerChip.style.color = '#fca5a5';
                elements.timerChip.style.borderColor = 'rgba(255, 0, 0, 0.32)';
                elements.timerChip.style.animation = 'timerPulse 0.8s ease-in-out infinite';
            } else if (seconds <= 25) {
                elements.timerChip.style.background = 'rgba(255, 165, 0, 0.14)';
                elements.timerChip.style.color = '#fdba74';
                elements.timerChip.style.borderColor = 'rgba(255, 165, 0, 0.3)';
                elements.timerChip.style.animation = 'none';
            } else {
                elements.timerChip.style.background = 'rgba(0, 255, 0, 0.12)';
                elements.timerChip.style.color = '#86efac';
                elements.timerChip.style.borderColor = 'rgba(0, 255, 0, 0.25)';
                elements.timerChip.style.animation = 'none';
            }
        }

        function setScreen(visibleScreen) {
            [elements.memorizeScreen, elements.quizScreen, elements.resultScreen].forEach((screen) => {
                if (screen === visibleScreen) {
                    screen.classList.remove('hidden');
                    requestAnimationFrame(() => {
                        screen.style.opacity = '1';
                        screen.style.transform = 'translateY(0)';
                    });
                } else {
                    screen.classList.add('hidden');
                    screen.style.opacity = '1';
                    screen.style.transform = 'translateY(0)';
                }
            });
        }

        function fadeTo(nextScreen) {
            const current = state.phase === 'memorize'
                ? elements.memorizeScreen
                : state.phase === 'quiz'
                    ? elements.quizScreen
                    : elements.resultScreen;

            current.style.opacity = '0';
            current.style.transform = 'translateY(10px)';
            window.setTimeout(() => {
                setScreen(nextScreen);
            }, 450);
        }

        function renderQuestions() {
            elements.questionsContainer.innerHTML = '';
            elements.quizError.classList.add('hidden');
            state.activeQuestions.forEach((question, index) => {
                const wrapper = document.createElement('div');
                const label = document.createElement('label');
                const input = document.createElement('input');

                label.setAttribute('for', `question-${index}`);
                label.textContent = `${index + 1}. ${question.text}`;

                input.type = 'number';
                input.id = `question-${index}`;
                input.name = question.key;
                input.inputMode = 'numeric';
                input.min = '0';
                input.required = true;
                input.placeholder = 'Tvoj odhad';

                if (isSolveMode) {
                    input.value = String(getCorrectAnswer(question.key));
                }

                wrapper.appendChild(label);
                wrapper.appendChild(input);
                elements.questionsContainer.appendChild(wrapper);
            });
        }

        function updateStaticTexts() {
            const secondsText = `${config.memorizeSeconds}-sekundovým`;
            elements.memorySubtitle.textContent = `Pamäťová hra s ${secondsText} limitom. Zapamätaj si scénu, potom odpovedz na otázky bez toho, aby si sa k nej vrátil.`;
            elements.sceneMetaTime.textContent = `Čas beží automaticky ${config.memorizeSeconds} sekúnd.`;
            elements.timerChip.textContent = `${config.memorizeSeconds}s`;
        }

        function startMemorizePhase() {
            if (state.intervalId) {
                window.clearInterval(state.intervalId);
            }
            if (state.restartTimeoutId) {
                window.clearTimeout(state.restartTimeoutId);
                state.restartTimeoutId = null;
            }

            state.phase = 'memorize';
            state.remainingMs = config.memorizeSeconds * 1000;
            state.activeQuestions = getActiveQuestions();
            buildSceneItems();
            renderScene();
            renderQuestions();
            setScreen(elements.memorizeScreen);
            updateTimerUi(state.remainingMs);
            state.startedAt = Date.now();

            state.intervalId = window.setInterval(() => {
                const elapsed = Date.now() - state.startedAt;
                state.remainingMs = Math.max(0, config.memorizeSeconds * 1000 - elapsed);
                updateTimerUi(state.remainingMs);

                if (state.remainingMs <= 0) {
                    window.clearInterval(state.intervalId);
                    state.intervalId = null;
                    state.phase = 'quiz';
                    console.log('stage_memory switching to quiz phase');
                    fadeTo(elements.quizScreen);
                }
            }, 100);
        }

        function handleSubmit(event) {
            event.preventDefault();
            const formData = new FormData(elements.quizForm);
            const hasWrongAnswer = state.activeQuestions.some((question) => {
                const providedValue = Number(formData.get(question.key));
                const expectedValue = getCorrectAnswer(question.key);

                return Number.isNaN(providedValue) || providedValue !== expectedValue;
            });

            if (hasWrongAnswer) {
                elements.quizError.classList.remove('hidden');
                console.log('stage_memory wrong answer, restarting whole game', {
                    activeQuestions: state.activeQuestions.map((question) => question.key),
                });
                if (state.restartTimeoutId) {
                    window.clearTimeout(state.restartTimeoutId);
                }
                state.restartTimeoutId = window.setTimeout(() => {
                    startMemorizePhase();
                }, 1600);
                return;
            }

            elements.quizError.classList.add('hidden');
            state.phase = 'result';
            console.log('stage_memory finished, showing final hint');
            fadeTo(elements.resultScreen);
        }

        elements.quizForm.addEventListener('submit', handleSubmit);
        elements.playAgainBtn.addEventListener('click', startMemorizePhase);
        window.addEventListener('resize', () => {
            if (state.phase === 'memorize') {
                state.sceneColumns = chooseColumns();
                renderScene();
            }
        });

        updateStaticTexts();
        startMemorizePhase();
    })();
</script>

