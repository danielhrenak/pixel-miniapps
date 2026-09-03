<section class="slot-page">
    <div class="slot-shell">
        <header class="slot-header">
            <a href="/kasino" class="back-home-link">← Domov</a>
            <p class="slot-kicker">Herný automat</p>
            <h1>🎰 JEDNORUKÝ BANDITA</h1>
            <p class="slot-subtitle">Vsaď kredit, potiahni páku a skús šťastie na troch valcoch. Tri rovnaké symboly na strednej linke vyhrávajú!</p>
        </header>

        <div class="slot-layout">
            <div class="machine-col">
                <div class="credit-bar">
                    <div class="credit-box">
                        <span class="credit-label">Kredit</span>
                        <span id="credit-value" class="credit-value">100</span>
                    </div>
                    <div class="credit-box">
                        <span class="credit-label">Stávka</span>
                        <span id="bet-value" class="credit-value">10</span>
                    </div>
                    <div class="credit-box win-box">
                        <span class="credit-label">Posledná výhra</span>
                        <span id="win-value" class="credit-value">0</span>
                    </div>
                </div>

                <div class="machine-cabinet">
                    <div class="cabinet-lights"></div>
                    <div class="reels-window">
                        <div class="payline-marker payline-left">▶</div>
                        <div class="payline-marker payline-right">◀</div>
                        <div id="reel-0" class="reel"><div class="reel-strip"></div></div>
                        <div id="reel-1" class="reel"><div class="reel-strip"></div></div>
                        <div id="reel-2" class="reel"><div class="reel-strip"></div></div>
                    </div>
                    <div id="message-line" class="message-line">Nastav stávku a potiahni páku!</div>
                </div>

                <div class="controls-row">
                    <div class="bet-controls">
                        <button id="bet-minus-btn" type="button" class="slot-button button-secondary bet-step">−</button>
                        <div class="bet-buttons">
                            <button type="button" class="slot-button button-secondary bet-quick" data-bet="10">10</button>
                            <button type="button" class="slot-button button-secondary bet-quick" data-bet="25">25</button>
                            <button type="button" class="slot-button button-secondary bet-quick" data-bet="50">50</button>
                            <button id="bet-max-btn" type="button" class="slot-button button-secondary bet-quick">MAX</button>
                        </div>
                        <button id="bet-plus-btn" type="button" class="slot-button button-secondary bet-step">+</button>
                    </div>

                    <div class="spin-controls">
                        <button id="lever-btn" type="button" class="lever-button" aria-label="Potiahni páku">
                            <span class="lever-knob"></span>
                        </button>
                        <button id="spin-btn" type="button" class="slot-button button-primary spin-main-btn">🎰 TOČIŤ</button>
                    </div>
                </div>

                <div id="topup-row" class="topup-row hidden">
                    <p>Došiel ti kredit!</p>
                    <button id="topup-btn" type="button" class="slot-button button-primary">💰 Dobiť kredit (100)</button>
                </div>
            </div>

            <aside class="paytable-col">
                <div class="panel-card">
                    <h2>Výherná tabuľka</h2>
                    <p class="paytable-hint">3 rovnaké symboly na strednej linke = stávka × násobok</p>
                    <div id="paytable-list" class="paytable-list"></div>
                </div>

                <div class="panel-card">
                    <h2>História točení</h2>
                    <div id="history-list" class="history-list"></div>
                </div>
            </aside>
        </div>
    </div>
</section>

<style>
    .slot-page {
        min-height: 100vh;
        padding: 0.75rem 0.5rem 2rem;
        background:
            radial-gradient(circle at top, rgba(255, 60, 60, 0.14), transparent 40%),
            radial-gradient(circle at bottom, rgba(255, 215, 0, 0.12), transparent 45%),
            linear-gradient(180deg, #180b0b 0%, #241010 50%, #170a0a 100%);
        color: #f8fafc;
        font-family: Arial, sans-serif;
    }

    .slot-shell {
        width: min(1180px, 100%);
        margin: 0 auto;
        border-radius: 22px;
        border: 1px solid rgba(255, 215, 0, 0.18);
        background: rgba(10, 6, 6, 0.84);
        box-shadow: 0 24px 60px rgba(0, 0, 0, 0.55), inset 0 1px 0 rgba(255, 255, 255, 0.04);
        backdrop-filter: blur(18px);
        padding: 1rem;
    }

    .slot-header { position: relative; text-align: center; margin-bottom: 0.9rem; }

    .back-home-link {
        position: absolute;
        top: 0;
        left: 0;
        color: #d1d5db;
        text-decoration: none;
        font-size: 0.8rem;
        font-weight: 700;
        padding: 0.35rem 0.6rem;
        border-radius: 8px;
        border: 1px solid rgba(255, 255, 255, 0.14);
        background: rgba(255, 255, 255, 0.05);
        transition: color 0.15s ease, border-color 0.15s ease;
    }

    .back-home-link:hover { color: #ffd700; border-color: rgba(255, 215, 0, 0.4); }

    .slot-kicker {
        margin: 0 0 0.3rem;
        color: #ffd700;
        letter-spacing: 0.36em;
        text-transform: uppercase;
        font-size: 0.75rem;
    }

    .slot-header h1 {
        margin: 0;
        font-size: clamp(1.7rem, 5vw, 2.9rem);
        color: #ffd700;
        text-shadow: 0 0 22px rgba(255, 215, 0, 0.25);
        letter-spacing: 0.03em;
    }

    .slot-subtitle {
        margin: 0.45rem auto 0;
        max-width: 720px;
        line-height: 1.55;
        color: #d1d5db;
        font-size: 0.88rem;
    }

    .hidden { display: none !important; }

    .slot-layout {
        display: grid;
        grid-template-columns: minmax(0, 1.5fr) minmax(240px, 1fr);
        gap: 1rem;
        align-items: start;
    }

    .machine-col { display: flex; flex-direction: column; gap: 0.75rem; }

    .credit-bar {
        display: flex;
        gap: 0.6rem;
        flex-wrap: wrap;
    }

    .credit-box {
        flex: 1 1 140px;
        border-radius: 14px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        background: linear-gradient(180deg, rgba(30, 18, 18, 0.9) 0%, rgba(18, 10, 10, 0.92) 100%);
        padding: 0.55rem 0.8rem;
        text-align: center;
    }

    .credit-label {
        display: block;
        font-size: 0.68rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #d1d5db;
        margin-bottom: 0.2rem;
    }

    .credit-value { font-size: 1.35rem; font-weight: 900; color: #ffd700; }

    .win-box .credit-value { color: #4ade80; }
    .win-box.flash-win .credit-value { animation: winPulse 0.6s ease-in-out 2; }

    .machine-cabinet {
        border-radius: 22px;
        border: 6px solid #7a1f1f;
        background:
            repeating-linear-gradient(135deg, rgba(255, 255, 255, 0.02) 0px, rgba(255, 255, 255, 0.02) 2px, transparent 2px, transparent 12px),
            linear-gradient(180deg, #3d1414 0%, #240a0a 100%);
        box-shadow: inset 0 2px 10px rgba(0, 0, 0, 0.5), 0 14px 30px rgba(0, 0, 0, 0.4);
        padding: 1rem;
        position: relative;
        overflow: hidden;
    }

    .cabinet-lights {
        position: absolute;
        inset: 0;
        pointer-events: none;
        background-image: radial-gradient(circle, rgba(255, 215, 0, 0.55) 0 3px, transparent 4px);
        background-size: 34px 34px;
        background-position: center top;
        opacity: 0.5;
        mask-image: linear-gradient(180deg, black, transparent 24px, transparent calc(100% - 24px), black);
    }

    .reels-window {
        position: relative;
        display: flex;
        justify-content: center;
        gap: 0.6rem;
        border-radius: 14px;
        background: #0a0505;
        border: 4px solid #3d1414;
        padding: 0.6rem;
        box-shadow: inset 0 4px 14px rgba(0, 0, 0, 0.7);
        z-index: 1;
    }

    .reel {
        position: relative;
        width: 92px;
        height: 276px;
        overflow: hidden;
        border-radius: 8px;
        background: linear-gradient(180deg, #151515 0%, #0a0a0a 100%);
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.06);
    }

    .reel::before,
    .reel::after {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        height: 92px;
        z-index: 2;
        pointer-events: none;
    }

    .reel::before {
        top: 0;
        background: linear-gradient(180deg, rgba(0, 0, 0, 0.75), transparent);
    }

    .reel::after {
        bottom: 0;
        background: linear-gradient(0deg, rgba(0, 0, 0, 0.75), transparent);
    }

    .reel-strip {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        will-change: transform;
    }

    .symbol-cell {
        height: 92px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        line-height: 1;
    }

    .payline-marker {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        color: #ffd700;
        font-size: 1.1rem;
        z-index: 3;
        text-shadow: 0 0 8px rgba(255, 215, 0, 0.7);
    }

    .payline-left { left: -2px; }
    .payline-right { right: -2px; }

    .reels-window.win-flash .reel {
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.06), 0 0 0 2px #ffd700, 0 0 18px 4px rgba(255, 215, 0, 0.6);
        animation: reelPulse 0.9s ease-in-out infinite;
    }

    .message-line {
        margin-top: 0.75rem;
        text-align: center;
        min-height: 1.6em;
        font-weight: 800;
        font-size: 1rem;
        color: #f8fafc;
        z-index: 1;
        position: relative;
    }

    .message-line.is-win { color: #4ade80; }
    .message-line.is-lose { color: #f87171; }

    .controls-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .bet-controls {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        flex-wrap: wrap;
    }

    .bet-buttons { display: flex; gap: 0.4rem; flex-wrap: wrap; }

    .slot-button {
        appearance: none;
        border: none;
        border-radius: 12px;
        padding: 0.65rem 1rem;
        font-weight: 900;
        font-size: 0.85rem;
        letter-spacing: 0.02em;
        cursor: pointer;
        transition: transform 0.15s ease, filter 0.15s ease, opacity 0.15s ease, box-shadow 0.15s ease;
    }

    .slot-button:hover { transform: translateY(-1px); filter: brightness(1.06); }

    .slot-button:disabled { cursor: not-allowed; opacity: 0.4; transform: none; filter: none; }

    .bet-step { width: 40px; padding: 0.65rem 0; }

    .button-primary {
        background: linear-gradient(135deg, #ffd700 0%, #ffb800 100%);
        color: #241010;
        box-shadow: 0 6px 16px rgba(255, 184, 0, 0.22);
    }

    .button-secondary {
        background: rgba(255, 255, 255, 0.08);
        color: #f8fafc;
        border: 1px solid rgba(255, 255, 255, 0.14);
    }

    .bet-quick.active-bet {
        background: rgba(255, 215, 0, 0.2);
        border-color: rgba(255, 215, 0, 0.6);
        color: #ffd700;
    }

    .spin-controls {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .spin-main-btn { padding: 0.85rem 1.5rem; font-size: 1rem; }

    .lever-button {
        appearance: none;
        border: none;
        width: 26px;
        height: 78px;
        border-radius: 999px;
        background: linear-gradient(180deg, #4b5563 0%, #1f2937 100%);
        box-shadow: inset 0 0 0 2px rgba(255, 255, 255, 0.08);
        position: relative;
        cursor: pointer;
        padding: 0;
    }

    .lever-knob {
        position: absolute;
        left: 50%;
        top: 4px;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        transform: translateX(-50%);
        background: radial-gradient(circle at 32% 28%, #ff6b6b 0%, #b91c1c 75%);
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.5);
        transition: top 0.18s ease;
    }

    .lever-button.pulled .lever-knob { top: 44px; }
    .lever-button:disabled { cursor: not-allowed; opacity: 0.5; }

    .topup-row {
        text-align: center;
        border-radius: 14px;
        border: 1px solid rgba(255, 215, 0, 0.3);
        background: rgba(255, 215, 0, 0.08);
        padding: 0.75rem;
    }

    .topup-row p { margin: 0 0 0.5rem; font-weight: 800; color: #ffd700; }

    .paytable-col { display: flex; flex-direction: column; gap: 0.75rem; }

    .panel-card {
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        background: linear-gradient(180deg, rgba(32, 20, 20, 0.94) 0%, rgba(20, 12, 12, 0.94) 100%);
        padding: 0.95rem 1.05rem;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.04), 0 10px 24px rgba(0, 0, 0, 0.25);
    }

    .panel-card h2 { margin: 0 0 0.4rem; color: #ffd700; font-size: 1.02rem; }

    .paytable-hint { margin: 0 0 0.65rem; color: #d1d5db; font-size: 0.76rem; line-height: 1.4; }

    .paytable-list { display: flex; flex-direction: column; gap: 0.4rem; }

    .paytable-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.5rem;
        border-radius: 10px;
        padding: 0.4rem 0.55rem;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.06);
        font-size: 0.85rem;
    }

    .paytable-symbols { font-size: 1.15rem; letter-spacing: 0.05em; }
    .paytable-mult { font-weight: 900; color: #ffd700; }

    .history-list {
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
        max-height: 220px;
        overflow-y: auto;
        padding-right: 0.15rem;
    }

    .history-empty { color: #9ca3af; font-size: 0.8rem; }

    .history-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.5rem;
        border-radius: 10px;
        padding: 0.4rem 0.55rem;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.06);
        font-size: 0.78rem;
    }

    .history-row.history-win { border-color: rgba(74, 222, 128, 0.35); background: rgba(74, 222, 128, 0.07); }
    .history-symbols { letter-spacing: 0.04em; }
    .history-net { font-weight: 800; white-space: nowrap; }
    .history-net.positive { color: #4ade80; }
    .history-net.negative { color: #f87171; }

    @keyframes reelPulse {
        0%, 100% { filter: brightness(1); }
        50% { filter: brightness(1.35); }
    }

    @keyframes winPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.18); }
    }

    @media (max-width: 900px) {
        .slot-layout { grid-template-columns: 1fr; }
    }

    @media (max-width: 640px) {
        .slot-page { padding: 0.5rem 0.35rem 1.5rem; }
        .slot-shell { padding: 0.65rem; border-radius: 16px; }
        .reel { width: 74px; height: 222px; }
        .symbol-cell { height: 74px; font-size: 2.3rem; }
        .reels-window { gap: 0.4rem; }
        .controls-row { flex-direction: column; align-items: stretch; }
        .bet-controls { justify-content: center; }
        .spin-controls { justify-content: center; }
    }
</style>

<script>
(function () {
    var CELL_HEIGHT = 92;
    var MOBILE_CELL_HEIGHT = 74;
    var MOBILE_BREAKPOINT = 640;
    var STRIP_LENGTH = 34;
    var SPIN_MS = [1800, 2200, 2600];
    var START_CREDIT = 100;
    var TOPUP_AMOUNT = 100;
    var MIN_BET = 1;
    var MAX_BET = 200;
    var BET_STEP = 5;

    var SYMBOLS = [
        { key: 'cherry', emoji: '🍒', weight: 9, mult: 3 },
        { key: 'lemon', emoji: '🍋', weight: 8, mult: 4 },
        { key: 'grape', emoji: '🍇', weight: 7, mult: 6 },
        { key: 'bell', emoji: '🔔', weight: 5, mult: 10 },
        { key: 'star', emoji: '⭐', weight: 3, mult: 20 },
        { key: 'diamond', emoji: '💎', weight: 2, mult: 40 },
        { key: 'seven', emoji: '7️⃣', weight: 1, mult: 100 },
    ];
    var TOTAL_WEIGHT = SYMBOLS.reduce(function (sum, s) { return sum + s.weight; }, 0);

    var state = {
        credit: START_CREDIT,
        bet: 10,
        spinning: false,
        history: [],
    };

    var el = {
        creditValue: document.getElementById('credit-value'),
        betValue: document.getElementById('bet-value'),
        winValue: document.getElementById('win-value'),
        winBox: document.querySelector('.win-box'),
        reelsWindow: document.querySelector('.reels-window'),
        reels: [0, 1, 2].map(function (i) { return document.getElementById('reel-' + i); }),
        messageLine: document.getElementById('message-line'),
        betMinusBtn: document.getElementById('bet-minus-btn'),
        betPlusBtn: document.getElementById('bet-plus-btn'),
        betMaxBtn: document.getElementById('bet-max-btn'),
        betQuickBtns: Array.prototype.slice.call(document.querySelectorAll('.bet-quick[data-bet]')),
        spinBtn: document.getElementById('spin-btn'),
        leverBtn: document.getElementById('lever-btn'),
        topupRow: document.getElementById('topup-row'),
        topupBtn: document.getElementById('topup-btn'),
        paytableList: document.getElementById('paytable-list'),
        historyList: document.getElementById('history-list'),
    };

    function createEl(tag, className, text) {
        var node = document.createElement(tag);
        if (className) node.className = className;
        if (text !== undefined && text !== null) node.textContent = text;
        return node;
    }

    function cellHeight() {
        return window.innerWidth <= MOBILE_BREAKPOINT ? MOBILE_CELL_HEIGHT : CELL_HEIGHT;
    }

    function pickWeightedSymbol() {
        var roll = Math.random() * TOTAL_WEIGHT;
        var acc = 0;
        for (var i = 0; i < SYMBOLS.length; i++) {
            acc += SYMBOLS[i].weight;
            if (roll < acc) return SYMBOLS[i];
        }
        return SYMBOLS[SYMBOLS.length - 1];
    }

    // ---------- Paytable ----------

    function renderPaytable() {
        el.paytableList.innerHTML = '';
        SYMBOLS.slice().reverse().forEach(function (sym) {
            var row = createEl('div', 'paytable-row');
            row.appendChild(createEl('span', 'paytable-symbols', sym.emoji + sym.emoji + sym.emoji));
            row.appendChild(createEl('span', 'paytable-mult', '× ' + sym.mult));
            el.paytableList.appendChild(row);
        });
    }

    // ---------- Credit / bet display ----------

    function renderCredit() {
        el.creditValue.textContent = String(state.credit);
        el.betValue.textContent = String(state.bet);
        el.topupRow.classList.toggle('hidden', state.credit >= MIN_BET);
        updateSpinAvailability();
    }

    function updateSpinAvailability() {
        var canSpin = !state.spinning && state.credit >= state.bet && state.bet >= MIN_BET;
        el.spinBtn.disabled = !canSpin;
        el.leverBtn.disabled = !canSpin;
        el.betMinusBtn.disabled = state.spinning || state.bet <= MIN_BET;
        el.betPlusBtn.disabled = state.spinning || state.bet >= MAX_BET || state.bet + BET_STEP > state.credit;
        el.betMaxBtn.disabled = state.spinning || state.credit < MIN_BET;
        el.betQuickBtns.forEach(function (btn) {
            var val = parseInt(btn.dataset.bet, 10);
            btn.disabled = state.spinning || val > state.credit;
            btn.classList.toggle('active-bet', val === state.bet);
        });
    }

    function setBet(value) {
        var clamped = Math.max(MIN_BET, Math.min(MAX_BET, value));
        if (state.credit < clamped) {
            clamped = Math.max(state.credit, 0);
        }
        state.bet = clamped;
        renderCredit();
    }

    el.betMinusBtn.addEventListener('click', function () { setBet(state.bet - BET_STEP); });
    el.betPlusBtn.addEventListener('click', function () { setBet(state.bet + BET_STEP); });
    el.betMaxBtn.addEventListener('click', function () { setBet(MAX_BET); });
    el.betQuickBtns.forEach(function (btn) {
        btn.addEventListener('click', function () { setBet(parseInt(btn.dataset.bet, 10)); });
    });

    el.topupBtn.addEventListener('click', function () {
        state.credit += TOPUP_AMOUNT;
        setMessage('Kredit dobitý! Veľa šťastia. 🍀', null);
        renderCredit();
    });

    // ---------- Message ----------

    function setMessage(text, kind) {
        el.messageLine.textContent = text;
        el.messageLine.classList.remove('is-win', 'is-lose');
        if (kind === 'win') el.messageLine.classList.add('is-win');
        if (kind === 'lose') el.messageLine.classList.add('is-lose');
    }

    // ---------- History ----------

    function renderHistory() {
        el.historyList.innerHTML = '';
        if (state.history.length === 0) {
            el.historyList.appendChild(createEl('p', 'history-empty', 'Zatiaľ žiadne točenia.'));
            return;
        }
        state.history.slice(0, 12).forEach(function (entry) {
            var row = createEl('div', 'history-row' + (entry.net >= 0 ? ' history-win' : ''));
            row.appendChild(createEl('span', 'history-symbols', entry.symbolsLabel));
            row.appendChild(createEl('span', 'history-net ' + (entry.net >= 0 ? 'positive' : 'negative'),
                (entry.net >= 0 ? '+' : '') + entry.net));
            el.historyList.appendChild(row);
        });
    }

    // ---------- Reel build ----------

    function buildReelStrip(reelEl, targetSymbol) {
        var strip = reelEl.querySelector('.reel-strip');
        strip.innerHTML = '';
        strip.style.transition = 'none';
        strip.style.transform = 'translateY(0px)';

        var sequence = [];
        for (var i = 0; i < STRIP_LENGTH; i++) {
            sequence.push(pickWeightedSymbol());
        }
        var landIndex = STRIP_LENGTH - 2;
        sequence[landIndex] = targetSymbol;

        sequence.forEach(function (sym) {
            strip.appendChild(createEl('div', 'symbol-cell', sym.emoji));
        });

        return { sequence: sequence, landIndex: landIndex };
    }

    function initReels() {
        var height = cellHeight();
        el.reels.forEach(function (reelEl) {
            var target = pickWeightedSymbol();
            var built = buildReelStrip(reelEl, target);
            var strip = reelEl.querySelector('.reel-strip');
            strip.style.transition = 'none';
            strip.style.transform = 'translateY(' + (-((built.landIndex - 1) * height)) + 'px)';
        });
    }

    // ---------- Spin ----------

    function spin() {
        if (state.spinning) return;
        if (state.credit < state.bet || state.bet < MIN_BET) return;

        state.spinning = true;
        state.credit -= state.bet;
        el.winBox.classList.remove('flash-win');
        el.winValue.textContent = '0';
        el.reelsWindow.classList.remove('win-flash');
        el.leverBtn.classList.add('pulled');
        setMessage('Valce sa točia...', null);
        renderCredit();

        var results = [];
        var height = cellHeight();

        el.reels.forEach(function (reelEl, idx) {
            var target = pickWeightedSymbol();
            var built = buildReelStrip(reelEl, target);
            results[idx] = target;

            var strip = reelEl.querySelector('.reel-strip');
            void strip.offsetHeight;

            var duration = SPIN_MS[idx];
            var translateY = -((built.landIndex - 1) * height);

            requestAnimationFrame(function () {
                strip.style.transition = 'transform ' + (duration / 1000) + 's cubic-bezier(0.12, 0.68, 0.18, 1)';
                strip.style.transform = 'translateY(' + translateY + 'px)';
            });
        });

        window.setTimeout(function () {
            el.leverBtn.classList.remove('pulled');
            finishSpin(results);
        }, Math.max.apply(null, SPIN_MS) + 150);
    }

    function finishSpin(results) {
        state.spinning = false;

        var allMatch = results[0].key === results[1].key && results[1].key === results[2].key;
        var net;
        var symbolsLabel = results.map(function (r) { return r.emoji; }).join(' ');

        if (allMatch) {
            var winAmount = state.bet * results[0].mult;
            state.credit += winAmount;
            net = winAmount - state.bet;
            el.winValue.textContent = String(winAmount);
            el.winBox.classList.add('flash-win');
            el.reelsWindow.classList.add('win-flash');
            setMessage('🎉 VÝHRA! ' + symbolsLabel + '  ×' + results[0].mult + ' = +' + winAmount, 'win');
        } else {
            net = -state.bet;
            setMessage('Skús to znova! ' + symbolsLabel, 'lose');
        }

        state.history.unshift({ symbolsLabel: symbolsLabel, net: net });
        renderHistory();
        renderCredit();

        if (state.credit < MIN_BET) {
            setMessage('Došiel ti kredit. Dobi si ho a hraj ďalej!', 'lose');
        } else if (state.bet > state.credit) {
            setBet(state.credit);
        }
    }

    el.spinBtn.addEventListener('click', spin);
    el.leverBtn.addEventListener('click', spin);

    renderPaytable();
    renderHistory();
    renderCredit();
    initReels();
})();
</script>
