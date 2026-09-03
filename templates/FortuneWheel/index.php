<section class="fw-page">
    <div class="fw-shell">
        <header class="fw-header">
            <a href="/kasino" class="back-home-link">← Domov</a>
            <p class="fw-kicker">Party hra</p>
            <h1>🎡 KOLESO ŠŤASTIA</h1>
            <p class="fw-subtitle">Zadaj meno a stávku hráča a hneď sa preňho roztočí koleso šťastia. Po výsledku pridaj ďalšieho hráča rovnakým spôsobom. Koleso môže stávku znásobiť, dať pevnú výhru (max 10), alebo zobrať všetko.</p>
        </header>

        <div class="fw-screen">
            <div class="panel-card">
                <h2>Pridaj hráča a roztoč koleso</h2>
                <div class="players-input-row">
                    <input id="player-name-input" type="text" maxlength="24" placeholder="Meno hráča" autocomplete="off">
                    <input id="player-stake-input" type="number" min="1" max="1000000" step="1" value="10" placeholder="Stávka">
                    <button id="add-player-btn" type="button" class="fw-button button-primary">🎡 Pridať a točiť</button>
                </div>
                <p id="players-count" class="players-count">0 / 15 hráčov</p>
                <p id="players-error" class="form-error hidden"></p>
            </div>

            <div id="history-card" class="panel-card hidden">
                <h3 class="history-title">Priebeh hry</h3>
                <div id="history-list" class="turn-queue"></div>
                <div class="screen-actions">
                    <button id="show-summary-btn" type="button" class="fw-button button-secondary">🏁 Zobraziť celkové výsledky</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary results modal -->
    <div id="results-modal" class="modal-overlay hidden">
        <div class="modal-card results-card">
            <h3>🏁 Celkové výsledky</h3>
            <div id="results-list" class="results-list"></div>
            <div class="modal-actions">
                <button id="add-more-btn" type="button" class="fw-button button-secondary">➕ Pridať ďalšieho hráča</button>
                <button id="new-game-btn" type="button" class="fw-button button-primary">🆕 Nová hra</button>
            </div>
        </div>
    </div>

    <!-- Fullscreen spin overlay -->
    <div id="spin-overlay" class="spin-overlay hidden">
        <div class="spin-inner">
            <p id="spin-title" class="spin-title">Koleso sa točí...</p>
            <p id="spin-player-line" class="spin-player-line"></p>
            <div id="wheel-frame" class="wheel-frame">
                <div class="wheel-pointer"></div>
                <div id="wheel-disc" class="wheel-disc"></div>
                <div class="wheel-hub">🍀</div>
            </div>
            <p id="spin-result-text" class="spin-result-text hidden"></p>
            <button id="next-turn-btn" type="button" class="fw-button button-primary hidden">Pokračovať →</button>
        </div>
    </div>
</section>

<style>
    .fw-page {
        min-height: 100vh;
        padding: 0.75rem 0.5rem 2rem;
        background:
            radial-gradient(circle at top, rgba(250, 204, 21, 0.14), transparent 38%),
            radial-gradient(circle at bottom, rgba(147, 51, 234, 0.16), transparent 48%),
            linear-gradient(180deg, #150d1e 0%, #1c1330 50%, #0f0a18 100%);
        color: #f8fafc;
        font-family: Arial, sans-serif;
    }

    .fw-shell {
        width: min(1100px, 100%);
        margin: 0 auto;
        border-radius: 22px;
        border: 1px solid rgba(250, 204, 21, 0.2);
        background: rgba(12, 8, 18, 0.86);
        box-shadow: 0 24px 60px rgba(0, 0, 0, 0.55), inset 0 1px 0 rgba(255, 255, 255, 0.04);
        backdrop-filter: blur(18px);
        padding: 1rem;
    }

    .fw-header { position: relative; text-align: center; margin-bottom: 0.9rem; }

    .back-home-link {
        position: absolute;
        top: 0;
        left: 0;
        color: #d8d3e6;
        text-decoration: none;
        font-size: 0.8rem;
        font-weight: 700;
        padding: 0.35rem 0.6rem;
        border-radius: 8px;
        border: 1px solid rgba(255, 255, 255, 0.14);
        background: rgba(255, 255, 255, 0.05);
        transition: color 0.15s ease, border-color 0.15s ease;
    }

    .back-home-link:hover {
        color: #facc15;
        border-color: rgba(250, 204, 21, 0.4);
    }

    .fw-kicker {
        margin: 0 0 0.3rem;
        color: #facc15;
        letter-spacing: 0.36em;
        text-transform: uppercase;
        font-size: 0.75rem;
    }

    .fw-header h1 {
        margin: 0;
        font-size: clamp(1.8rem, 5vw, 3.1rem);
        color: #facc15;
        text-shadow: 0 0 22px rgba(250, 204, 21, 0.25);
        letter-spacing: 0.03em;
    }

    .fw-subtitle {
        margin: 0.45rem auto 0;
        max-width: 780px;
        line-height: 1.55;
        color: #d8d3e6;
        font-size: 0.88rem;
    }

    .hidden { display: none !important; }

    .fw-screen { display: flex; flex-direction: column; gap: 0.75rem; animation: screenFadeIn 0.25s ease; }

    .panel-card {
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        background: linear-gradient(180deg, rgba(35, 24, 51, 0.9) 0%, rgba(22, 15, 33, 0.92) 100%);
        padding: 0.95rem 1.05rem;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.04), 0 10px 24px rgba(0, 0, 0, 0.25);
    }

    .panel-card h2 { margin: 0 0 0.5rem; color: #facc15; font-size: 1.08rem; letter-spacing: 0.02em; }

    .history-title { margin: 0 0 0.55rem; color: #e9d5ff; font-size: 0.95rem; }

    .players-input-row { display: flex; gap: 0.5rem; flex-wrap: wrap; }

    .players-input-row input {
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.14);
        background: rgba(255, 255, 255, 0.05);
        color: #f8fafc;
        padding: 0.6rem 0.8rem;
        font-size: 0.95rem;
    }

    #player-name-input { flex: 2 1 220px; }
    #player-stake-input { flex: 1 1 110px; width: 110px; }

    .players-input-row input:focus,
    #stake-input:focus {
        outline: none;
        border-color: rgba(250, 204, 21, 0.6);
        box-shadow: 0 0 0 3px rgba(250, 204, 21, 0.14);
    }

    .players-count { margin: 0.6rem 0 0; color: #86efac; font-weight: 700; font-size: 0.85rem; }

    .form-error {
        margin: 0.4rem 0 0;
        color: #fecaca;
        background: rgba(255, 0, 0, 0.08);
        border: 1px solid rgba(255, 0, 0, 0.24);
        border-radius: 10px;
        padding: 0.45rem 0.65rem;
        font-size: 0.82rem;
        font-weight: 700;
    }

    .chip-avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 26px;
        height: 26px;
        min-width: 26px;
        border-radius: 50%;
        background: linear-gradient(135deg, #facc15 0%, #d97706 100%);
        color: #241536;
        font-weight: 900;
        font-size: 0.8rem;
    }

    .screen-actions { display: flex; gap: 0.65rem; justify-content: center; flex-wrap: wrap; margin-top: 0.75rem; }

    .fw-button {
        appearance: none;
        border: none;
        border-radius: 12px;
        padding: 0.75rem 1.15rem;
        font-weight: 900;
        font-size: 0.9rem;
        letter-spacing: 0.03em;
        cursor: pointer;
        transition: transform 0.15s ease, filter 0.15s ease, opacity 0.15s ease, box-shadow 0.15s ease;
    }

    .fw-button:hover { transform: translateY(-1px); filter: brightness(1.05); }

    .fw-button:disabled { cursor: not-allowed; opacity: 0.4; transform: none; filter: none; }

    .button-primary {
        background: linear-gradient(135deg, #facc15 0%, #f59e0b 100%);
        color: #241536;
        box-shadow: 0 6px 16px rgba(245, 158, 11, 0.25);
    }

    .button-secondary {
        background: rgba(255, 255, 255, 0.08);
        color: #f8fafc;
        border: 1px solid rgba(255, 255, 255, 0.14);
    }

    .turn-queue { display: flex; flex-direction: column; gap: 0.45rem; }

    .queue-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.6rem;
        border-radius: 12px;
        padding: 0.5rem 0.7rem;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        font-size: 0.85rem;
    }

    .queue-row.state-win { border-color: rgba(34, 197, 94, 0.4); background: rgba(34, 197, 94, 0.08); }
    .queue-row.state-lose { border-color: rgba(239, 68, 68, 0.32); background: rgba(239, 68, 68, 0.06); }

    .queue-left { display: flex; align-items: center; gap: 0.5rem; }
    .queue-name { font-weight: 800; }
    .queue-stake { color: #c4b5fd; font-size: 0.76rem; }
    .queue-outcome { font-weight: 900; white-space: nowrap; }
    .queue-outcome.positive { color: #4ade80; }
    .queue-outcome.negative { color: #f87171; }

    .modal-overlay {
        position: fixed; inset: 0;
        background: rgba(0, 0, 0, 0.72);
        display: flex; align-items: center; justify-content: center;
        z-index: 60; padding: 1rem;
    }

    .modal-card {
        width: min(480px, 100%);
        border-radius: 18px;
        border: 1px solid rgba(250, 204, 21, 0.24);
        background: #170f24;
        padding: 1.1rem;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6);
    }

    .modal-card h3 { margin: 0 0 0.65rem; color: #facc15; font-size: 1.1rem; }

    .modal-actions { display: flex; gap: 0.6rem; justify-content: center; margin-top: 1rem; flex-wrap: wrap; }

    .results-card { width: min(560px, 100%); }

    .results-list {
        display: flex; flex-direction: column; gap: 0.45rem;
        max-height: 55vh; overflow-y: auto; padding-right: 0.2rem;
    }

    .results-list:empty::before {
        content: 'Zatiaľ žiadne výsledky.';
        color: #9ca3af;
        font-size: 0.85rem;
    }

    .result-row {
        display: flex; align-items: center; justify-content: space-between; gap: 0.6rem;
        border-radius: 12px; padding: 0.55rem 0.7rem;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        font-size: 0.85rem;
    }

    .result-row.result-win { border-color: rgba(34, 197, 94, 0.4); background: rgba(34, 197, 94, 0.08); }
    .result-row.result-lose { border-color: rgba(239, 68, 68, 0.32); background: rgba(239, 68, 68, 0.06); }

    .result-left { display: flex; align-items: center; gap: 0.55rem; }
    .result-name { font-weight: 800; font-size: 0.92rem; }
    .result-bet { color: #c4b5fd; font-size: 0.76rem; }
    .result-amount { font-weight: 900; font-size: 1rem; white-space: nowrap; }
    .result-amount.positive { color: #4ade80; }
    .result-amount.negative { color: #f87171; }

    .spin-overlay {
        position: fixed; inset: 0;
        background: radial-gradient(circle at center, #241536 0%, #0a0612 100%);
        z-index: 100;
        display: flex; align-items: center; justify-content: center;
        overflow-y: auto;
    }

    .spin-inner {
        display: flex; flex-direction: column; align-items: center;
        gap: 0.5rem; padding: 0.75rem; width: 100%;
    }

    .spin-title {
        margin: 0; color: #facc15;
        font-size: clamp(1.2rem, 3.5vw, 1.8rem);
        font-weight: 900; letter-spacing: 0.08em; text-transform: uppercase;
        min-height: 1.4em; text-align: center;
    }

    .spin-player-line {
        margin: 0 0 0.2rem;
        color: #e9d5ff;
        font-weight: 700;
        font-size: clamp(0.85rem, 2vw, 1rem);
        text-align: center;
    }

    .wheel-frame { position: relative; width: min(78vmin, 88vw, 860px); aspect-ratio: 1 / 1; }

    .wheel-frame.reveal-flash { animation: revealFlash 0.6s ease-out; }

    .wheel-pointer {
        position: absolute; top: -6px; left: 50%; transform: translateX(-50%);
        width: 0; height: 0;
        border-left: 16px solid transparent;
        border-right: 16px solid transparent;
        border-top: 27px solid #facc15;
        z-index: 7;
        filter: drop-shadow(0 2px 3px rgba(0, 0, 0, 0.5));
    }

    .wheel-disc {
        position: absolute; inset: 0;
        border-radius: 50%;
        border: 6px solid #d97706;
        box-shadow: 0 0 0 4px #1a1a1a, 0 0 0 7px #d97706, 0 25px 60px rgba(0, 0, 0, 0.65);
        will-change: transform;
    }

    .wheel-number { position: absolute; inset: 0; pointer-events: none; }

    .wheel-number .num {
        position: absolute; top: 8%; left: 50%; transform: translateX(-50%);
        font-size: clamp(0.7rem, 2.3vmin, 1.25rem);
        font-weight: 900;
        color: #f8fafc;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.85);
        white-space: nowrap;
    }

    .wheel-hub {
        position: absolute; top: 50%; left: 50%;
        width: 15%; height: 15%;
        transform: translate(-50%, -50%);
        border-radius: 50%;
        background: radial-gradient(circle at 35% 30%, #fff8dc 0%, #facc15 42%, #8a6d1a 90%);
        box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.55), 0 4px 10px rgba(0, 0, 0, 0.6);
        z-index: 6;
        display: flex; align-items: center; justify-content: center;
        font-size: clamp(1rem, 3.5vmin, 1.8rem);
    }

    .spin-result-text {
        margin: 0; text-align: center;
        font-size: clamp(1.15rem, 3.6vw, 1.8rem);
        font-weight: 900; color: #facc15;
        text-shadow: 0 0 18px rgba(250, 204, 21, 0.35);
    }

    @keyframes revealFlash {
        0% { filter: brightness(1); }
        30% { filter: brightness(1.7); }
        100% { filter: brightness(1); }
    }

    @keyframes screenFadeIn {
        0% { opacity: 0; transform: translateY(4px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 640px) {
        .fw-page { padding: 0.5rem 0.35rem 1.5rem; }
        .fw-shell { padding: 0.65rem; border-radius: 16px; }
        .panel-card { padding: 0.7rem 0.6rem; }
        .screen-actions { flex-direction: column; }
        .fw-button { width: 100%; text-align: center; }
        .modal-actions { flex-direction: column; }
        #player-stake-input { width: auto; }
    }
</style>

<script>
(function () {
    var MAX_PLAYERS = 15;
    var WHEEL_SPIN_MS = 6400;

    var SEGMENTS = [
        { type: 'multiplier', value: 2, label: 'x2', color: '#7c3aed' },
        { type: 'lose', value: 0, label: '💀 PREHRA', color: '#7f1d1d' },
        { type: 'fixed', value: 2, label: '2', color: '#f59e0b' },
        { type: 'lose', value: 0, label: '💀 PREHRA', color: '#7f1d1d' },
        { type: 'multiplier', value: 3, label: 'x3', color: '#9333ea' },
        { type: 'lose', value: 0, label: '💀 PREHRA', color: '#7f1d1d' },
        { type: 'fixed', value: 5, label: '5', color: '#f59e0b' },
        { type: 'lose', value: 0, label: '💀 PREHRA', color: '#7f1d1d' },
        { type: 'multiplier', value: 2, label: 'x2', color: '#7c3aed' },
        { type: 'lose', value: 0, label: '💀 PREHRA', color: '#7f1d1d' },
        { type: 'multiplier', value: 5, label: 'x5', color: '#a855f7' },
        { type: 'fixed', value: 3, label: '3', color: '#f59e0b' },
        { type: 'lose', value: 0, label: '💀 PREHRA', color: '#7f1d1d' },
        { type: 'multiplier', value: 3, label: 'x3', color: '#9333ea' },
        { type: 'fixed', value: 10, label: '10', color: '#fbbf24' },
        { type: 'lose', value: 0, label: '💀 PREHRA', color: '#7f1d1d' },
        { type: 'multiplier', value: 2, label: 'x2', color: '#7c3aed' },
        { type: 'multiplier', value: 10, label: 'x10', color: '#c026d3' },
        { type: 'fixed', value: 1, label: '1', color: '#f59e0b' },
        { type: 'lose', value: 0, label: '💀 PREHRA', color: '#7f1d1d' },
    ];
    var segAngle = 360 / SEGMENTS.length;

    var state = {
        players: [],
        results: [],
        spinning: false,
    };

    var el = {
        playerNameInput: document.getElementById('player-name-input'),
        playerStakeInput: document.getElementById('player-stake-input'),
        addPlayerBtn: document.getElementById('add-player-btn'),
        playersCount: document.getElementById('players-count'),
        playersError: document.getElementById('players-error'),

        historyCard: document.getElementById('history-card'),
        historyList: document.getElementById('history-list'),
        showSummaryBtn: document.getElementById('show-summary-btn'),

        resultsModal: document.getElementById('results-modal'),
        resultsList: document.getElementById('results-list'),
        addMoreBtn: document.getElementById('add-more-btn'),
        newGameBtn: document.getElementById('new-game-btn'),

        spinOverlay: document.getElementById('spin-overlay'),
        spinTitle: document.getElementById('spin-title'),
        spinPlayerLine: document.getElementById('spin-player-line'),
        wheelFrame: document.getElementById('wheel-frame'),
        wheelDisc: document.getElementById('wheel-disc'),
        spinResultText: document.getElementById('spin-result-text'),
        nextTurnBtn: document.getElementById('next-turn-btn'),
    };

    function randomInt(max) { return Math.floor(Math.random() * max); }

    function makePlayerId() {
        return 'p_' + Date.now().toString(36) + '_' + Math.random().toString(36).slice(2, 8);
    }

    function createEl(tag, className, text) {
        var node = document.createElement(tag);
        if (className) node.className = className;
        if (text !== undefined && text !== null) node.textContent = text;
        return node;
    }

    // ---------- Add player form ----------

    function renderForm() {
        el.playersCount.textContent = state.players.length + ' / ' + MAX_PLAYERS + ' hráčov';
        var atLimit = state.players.length >= MAX_PLAYERS;
        el.addPlayerBtn.disabled = state.spinning || atLimit;
        el.playerNameInput.disabled = state.spinning || atLimit;
        el.playerStakeInput.disabled = state.spinning || atLimit;
    }

    function showPlayersError(message) {
        if (!message) {
            el.playersError.classList.add('hidden');
            el.playersError.textContent = '';
            return;
        }
        el.playersError.textContent = message;
        el.playersError.classList.remove('hidden');
    }

    function addPlayerAndSpin() {
        if (state.spinning) return;

        var name = el.playerNameInput.value.trim();
        var stake = parseInt(el.playerStakeInput.value, 10);

        if (!name) {
            showPlayersError('Zadaj meno hráča.');
            return;
        }
        if (state.players.length >= MAX_PLAYERS) {
            showPlayersError('Maximálny počet hráčov je ' + MAX_PLAYERS + '.');
            return;
        }
        var exists = state.players.some(function (p) { return p.name.toLowerCase() === name.toLowerCase(); });
        if (exists) {
            showPlayersError('Hráč s týmto menom už hral. Zvoľ iné meno.');
            return;
        }
        if (!Number.isFinite(stake) || stake < 1) {
            showPlayersError('Zadaj platnú stávku (celé číslo väčšie ako 0).');
            return;
        }

        var player = { id: makePlayerId(), name: name, stake: stake };
        state.players.push(player);

        el.playerNameInput.value = '';
        el.playerStakeInput.value = '10';
        showPlayersError(null);
        renderForm();

        startSpin(player);
    }

    el.addPlayerBtn.addEventListener('click', addPlayerAndSpin);
    [el.playerNameInput, el.playerStakeInput].forEach(function (input) {
        input.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                addPlayerAndSpin();
            }
        });
    });

    // ---------- History ----------

    function renderHistory() {
        el.historyCard.classList.toggle('hidden', state.results.length === 0);
        el.historyList.innerHTML = '';

        state.results.forEach(function (result) {
            var row = createEl('div', 'queue-row ' + (result.net >= 0 ? 'state-win' : 'state-lose'));
            var left = createEl('div', 'queue-left');
            left.appendChild(createEl('span', 'chip-avatar', result.name.charAt(0).toUpperCase()));
            var nameWrap = createEl('div');
            nameWrap.appendChild(createEl('div', 'queue-name', result.name));
            nameWrap.appendChild(createEl('div', 'queue-stake', 'stávka ' + result.stake));
            left.appendChild(nameWrap);
            row.appendChild(left);

            row.appendChild(createEl('div', 'queue-outcome ' + (result.net >= 0 ? 'positive' : 'negative'),
                result.segmentLabel + ' · ' + (result.net >= 0 ? '+' : '') + result.net));

            el.historyList.appendChild(row);
        });
    }

    // ---------- Wheel ----------

    function computeOutcome(segment, stake) {
        if (segment.type === 'lose') {
            return { totalReturn: 0, net: -stake };
        }
        if (segment.type === 'multiplier') {
            var totalReturn = stake * segment.value;
            return { totalReturn: totalReturn, net: totalReturn - stake };
        }
        // fixed win: independent of stake size
        return { totalReturn: stake + segment.value, net: segment.value };
    }

    function colorHex(idx) { return SEGMENTS[idx].color; }

    function buildWheelVisualsOnce() {
        if (el.wheelDisc.dataset.built === '1') return;

        var start = -segAngle / 2;
        var wedgeStops = [];
        SEGMENTS.forEach(function (seg, idx) {
            var from = idx * segAngle + start;
            var to = (idx + 1) * segAngle + start;
            wedgeStops.push(colorHex(idx) + ' ' + from + 'deg ' + to + 'deg');
        });
        var wedgesLayer = 'conic-gradient(from 0deg, ' + wedgeStops.join(',') + ')';
        var separatorLayer = 'repeating-conic-gradient(from ' + start + 'deg, rgba(0,0,0,0.5) 0deg 0.6deg, transparent 0.6deg ' + segAngle + 'deg)';
        el.wheelDisc.style.background = separatorLayer + ', ' + wedgesLayer;

        SEGMENTS.forEach(function (seg, idx) {
            var wrapper = createEl('div', 'wheel-number');
            wrapper.style.transform = 'rotate(' + (idx * segAngle) + 'deg)';
            wrapper.appendChild(createEl('span', 'num', seg.label));
            el.wheelDisc.appendChild(wrapper);
        });

        el.wheelDisc.dataset.built = '1';
    }

    var spinTimeouts = [];

    function scheduleSpinStep(fn, delay) {
        spinTimeouts.push(window.setTimeout(fn, delay));
    }

    function setSpinTitle(text) {
        el.spinTitle.textContent = text;
    }

    function startSpin(player) {
        if (state.spinning) return;

        spinTimeouts.forEach(function (id) { window.clearTimeout(id); });
        spinTimeouts = [];

        state.spinning = true;
        renderForm();

        buildWheelVisualsOnce();
        el.spinOverlay.classList.remove('hidden');
        el.spinResultText.classList.add('hidden');
        el.nextTurnBtn.classList.add('hidden');
        el.wheelFrame.classList.remove('reveal-flash');
        el.spinPlayerLine.textContent = player.name + ' · stávka ' + player.stake;
        setSpinTitle('Koleso sa točí...');

        if (el.spinOverlay.requestFullscreen) {
            el.spinOverlay.requestFullscreen().catch(function () {});
        }

        var idx = randomInt(SEGMENTS.length);
        var spins = 9 + randomInt(4);
        var target = 360 * spins - idx * segAngle;

        el.wheelDisc.style.transition = 'none';
        el.wheelDisc.style.transform = 'rotate(0deg)';
        void el.wheelDisc.offsetWidth;

        requestAnimationFrame(function () {
            el.wheelDisc.style.transition = 'transform ' + (WHEEL_SPIN_MS / 1000) + 's cubic-bezier(0.1, 0.62, 0.12, 1)';
            el.wheelDisc.style.transform = 'rotate(' + target + 'deg)';
        });

        scheduleSpinStep(function () { setSpinTitle('Koleso sa krúti...'); }, Math.round(WHEEL_SPIN_MS * 0.3));
        scheduleSpinStep(function () { setSpinTitle('Spomaľuje...'); }, Math.round(WHEEL_SPIN_MS * 0.6));
        scheduleSpinStep(function () { setSpinTitle('Už to bude... 🤞'); }, Math.round(WHEEL_SPIN_MS * 0.85));

        scheduleSpinStep(function () {
            var segment = SEGMENTS[idx];
            var outcome = computeOutcome(segment, player.stake);

            setSpinTitle('Koleso sa zastavilo!');
            el.wheelFrame.classList.add('reveal-flash');

            var resultLine;
            if (segment.type === 'lose') {
                resultLine = player.name + ' prehráva všetko! −' + player.stake;
            } else if (segment.type === 'multiplier') {
                resultLine = player.name + ' vyhráva ' + segment.label + '! ' + player.stake + ' → ' + outcome.totalReturn + ' (+' + outcome.net + ')';
            } else {
                resultLine = player.name + ' vyhráva pevnú výhru ' + segment.label + '!';
            }

            el.spinResultText.textContent = resultLine;
            el.spinResultText.classList.remove('hidden');

            state.results.push({
                playerId: player.id,
                name: player.name,
                stake: player.stake,
                segmentLabel: segment.label,
                segmentType: segment.type,
                totalReturn: outcome.totalReturn,
                net: outcome.net,
            });

            el.nextTurnBtn.classList.remove('hidden');
        }, WHEEL_SPIN_MS + 150);
    }

    el.nextTurnBtn.addEventListener('click', function () {
        if (document.fullscreenElement) {
            document.exitFullscreen().catch(function () {});
        }
        el.spinOverlay.classList.add('hidden');
        state.spinning = false;
        renderForm();
        renderHistory();
        window.setTimeout(function () { el.playerNameInput.focus(); }, 0);
    });

    // ---------- Summary modal ----------

    function openSummaryModal() {
        el.resultsList.innerHTML = '';

        var rows = state.results.slice().sort(function (a, b) { return b.net - a.net; });
        rows.forEach(function (result) {
            var isWin = result.net >= 0;
            var rowEl = createEl('div', 'result-row ' + (isWin ? 'result-win' : 'result-lose'));

            var left = createEl('div', 'result-left');
            left.appendChild(createEl('span', 'chip-avatar', result.name.charAt(0).toUpperCase()));
            var nameWrap = createEl('div');
            nameWrap.appendChild(createEl('div', 'result-name', (isWin ? '🏆 ' : '💥 ') + result.name));
            nameWrap.appendChild(createEl('div', 'result-bet', result.segmentLabel + ' · stávka ' + result.stake));
            left.appendChild(nameWrap);
            rowEl.appendChild(left);

            rowEl.appendChild(createEl('div', 'result-amount ' + (isWin ? 'positive' : 'negative'),
                (isWin ? '+' : '') + result.net));

            el.resultsList.appendChild(rowEl);
        });

        el.resultsModal.classList.remove('hidden');
    }

    el.showSummaryBtn.addEventListener('click', openSummaryModal);

    el.addMoreBtn.addEventListener('click', function () {
        el.resultsModal.classList.add('hidden');
        el.playerNameInput.focus();
    });

    el.newGameBtn.addEventListener('click', function () {
        state.players = [];
        state.results = [];
        state.spinning = false;
        el.resultsModal.classList.add('hidden');
        showPlayersError(null);
        renderForm();
        renderHistory();
        el.playerNameInput.value = '';
        el.playerStakeInput.value = '10';
    });

    renderForm();
    renderHistory();
})();
</script>
