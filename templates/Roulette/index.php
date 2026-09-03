<section class="roulette-page">
    <div class="roulette-shell">
        <header class="roulette-header">
            <a href="/kasino" class="back-home-link">← Domov</a>
            <p class="roulette-kicker">Party hra</p>
            <h1>🎰 RULETA</h1>
            <p class="roulette-subtitle">Dvojkolová hra: najprv pridaj hráčov, potom im pretiahni meno na políčko rulety spolu so stávkou a roztoč koleso šťastia. Každý hráč môže staviť aj na viacero políčok naraz.</p>
        </header>

        <!-- Screen 1: players -->
        <div id="screen-players" class="roulette-screen">
            <div class="panel-card">
                <h2>Kolo 1 · Pridaj hráčov</h2>
                <div class="players-input-row">
                    <input id="player-name-input" type="text" maxlength="24" placeholder="Meno hráča" autocomplete="off">
                    <button id="add-player-btn" type="button" class="roulette-button button-primary">Pridať</button>
                </div>
                <p id="players-count" class="players-count">0 / 15 hráčov</p>
                <p id="players-error" class="form-error hidden"></p>
                <div id="players-list" class="players-list"></div>
            </div>
            <div class="screen-actions">
                <button id="continue-btn" type="button" class="roulette-button button-primary" disabled>Pokračovať na stávkovanie →</button>
            </div>
        </div>

        <!-- Screen 2: betting -->
        <div id="screen-betting" class="roulette-screen hidden">
            <div class="panel-card pool-card">
                <h2>Kolo 2 · Stávkovanie</h2>
                <p class="pool-hint">Každý hráč môže staviť aj na viacero políčok. Pretiahni (drag&amp;drop) meno hráča na políčko rulety, alebo naň klikni a potom klikni na políčko — pokojne opakovane. Na dotykovom zariadení funguje klikanie rovnako.</p>
                <div id="player-pool" class="player-pool"></div>
                <div id="betting-status" class="betting-status"></div>
            </div>

            <div class="board-wrap">
                <div id="roulette-board" class="roulette-board"></div>
            </div>

            <div class="screen-actions">
                <button id="back-players-btn" type="button" class="roulette-button button-secondary">← Späť na hráčov</button>
                <button id="spin-btn" type="button" class="roulette-button button-primary" disabled>🎡 ROZTOČIŤ RULETU</button>
            </div>
        </div>
    </div>

    <!-- Stake popup -->
    <div id="stake-popup" class="modal-overlay hidden">
        <div class="modal-card">
            <h3 id="stake-popup-title">Stávka</h3>
            <label class="stake-label" for="stake-input">Výška stávky</label>
            <input id="stake-input" type="number" min="1" max="1000000" step="1" value="10">
            <p id="stake-error" class="form-error hidden"></p>
            <div class="modal-actions">
                <button id="stake-cancel-btn" type="button" class="roulette-button button-secondary">Zrušiť</button>
                <button id="stake-confirm-btn" type="button" class="roulette-button button-primary">Potvrdiť stávku</button>
            </div>
        </div>
    </div>

    <!-- Results modal -->
    <div id="results-modal" class="modal-overlay hidden">
        <div class="modal-card results-card">
            <h3>🏁 Výsledky kola</h3>
            <p id="results-winning-line" class="results-winning-line"></p>
            <div id="results-list" class="results-list"></div>
            <div class="modal-actions">
                <button id="new-round-btn" type="button" class="roulette-button button-secondary">🔁 Nové kolo</button>
                <button id="new-game-btn" type="button" class="roulette-button button-primary">🆕 Nová hra</button>
            </div>
        </div>
    </div>

    <!-- Fullscreen spin overlay -->
    <div id="spin-overlay" class="spin-overlay hidden">
        <div class="spin-inner">
            <p id="spin-title" class="spin-title">Ruleta sa točí...</p>
            <div id="wheel-frame" class="wheel-frame">
                <div class="wheel-pointer"></div>
                <div id="ball-orbit" class="ball-orbit"><div class="ball"></div></div>
                <div id="wheel-disc" class="wheel-disc"></div>
                <div class="wheel-hub"></div>
            </div>
            <p id="spin-result-text" class="spin-result-text hidden"></p>
            <button id="show-results-btn" type="button" class="roulette-button button-primary hidden">Zobraziť výsledky →</button>
        </div>
    </div>
</section>

<style>
    .roulette-page {
        min-height: 100vh;
        padding: 0.75rem 0.5rem 2rem;
        background:
            radial-gradient(circle at top, rgba(255, 215, 0, 0.14), transparent 38%),
            radial-gradient(circle at bottom, rgba(15, 122, 61, 0.12), transparent 45%),
            linear-gradient(180deg, #0d1610 0%, #16241a 50%, #1c2b20 100%);
        color: #f8fafc;
        font-family: Arial, sans-serif;
    }

    .roulette-shell {
        width: min(1180px, 100%);
        margin: 0 auto;
        border-radius: 22px;
        border: 1px solid rgba(255, 215, 0, 0.18);
        background: rgba(8, 10, 8, 0.84);
        box-shadow: 0 24px 60px rgba(0, 0, 0, 0.55), inset 0 1px 0 rgba(255, 255, 255, 0.04);
        backdrop-filter: blur(18px);
        padding: 1rem;
    }

    .roulette-header {
        position: relative;
        text-align: center;
        margin-bottom: 0.9rem;
    }

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

    .back-home-link:hover {
        color: #ffd700;
        border-color: rgba(255, 215, 0, 0.4);
    }

    .roulette-kicker {
        margin: 0 0 0.3rem;
        color: #ffd700;
        letter-spacing: 0.36em;
        text-transform: uppercase;
        font-size: 0.75rem;
    }

    .roulette-header h1 {
        margin: 0;
        font-size: clamp(1.8rem, 5vw, 3.1rem);
        color: #ffd700;
        text-shadow: 0 0 22px rgba(255, 215, 0, 0.25);
        letter-spacing: 0.03em;
    }

    .roulette-subtitle {
        margin: 0.45rem auto 0;
        max-width: 780px;
        line-height: 1.55;
        color: #d1d5db;
        font-size: 0.88rem;
    }

    .hidden { display: none !important; }

    .roulette-screen { display: flex; flex-direction: column; gap: 0.75rem; animation: screenFadeIn 0.25s ease; }

    .panel-card,
    .board-wrap {
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        background: linear-gradient(180deg, rgba(26, 32, 26, 0.94) 0%, rgba(18, 22, 18, 0.94) 100%);
        padding: 0.95rem 1.05rem;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.04), 0 10px 24px rgba(0, 0, 0, 0.25);
    }

    .panel-card h2 {
        margin: 0 0 0.5rem;
        color: #ffd700;
        font-size: 1.08rem;
        letter-spacing: 0.02em;
    }

    .players-input-row {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .players-input-row input {
        flex: 1 1 220px;
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.14);
        background: rgba(255, 255, 255, 0.05);
        color: #f8fafc;
        padding: 0.6rem 0.8rem;
        font-size: 0.95rem;
    }

    .players-input-row input:focus,
    #stake-input:focus {
        outline: none;
        border-color: rgba(255, 215, 0, 0.6);
        box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.14);
    }

    .players-count {
        margin: 0.6rem 0 0;
        color: #86efac;
        font-weight: 700;
        font-size: 0.85rem;
    }

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

    .players-list {
        margin-top: 0.7rem;
        display: flex;
        flex-wrap: wrap;
        gap: 0.55rem;
    }

    .player-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border-radius: 999px;
        padding: 0.32rem 0.55rem 0.32rem 0.32rem;
        background: linear-gradient(135deg, #212d22 0%, #171f18 100%);
        border: 1px solid rgba(255, 215, 0, 0.28);
        color: #f8fafc;
        font-weight: 700;
        font-size: 0.88rem;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.25);
        transition: border-color 0.15s ease, box-shadow 0.15s ease, transform 0.12s ease;
    }

    .chip-avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 26px;
        height: 26px;
        min-width: 26px;
        border-radius: 50%;
        background: linear-gradient(135deg, #ffd700 0%, #d99a00 100%);
        color: #14201a;
        font-weight: 900;
        font-size: 0.8rem;
    }

    .chip-name-wrap {
        display: flex;
        flex-direction: column;
        line-height: 1.15;
    }

    .chip-badge {
        font-size: 0.66rem;
        font-weight: 700;
        color: #86efac;
        letter-spacing: 0.02em;
    }

    .player-chip.draggable-chip {
        cursor: grab;
        user-select: none;
        touch-action: none;
    }

    .player-chip.draggable-chip.has-bets {
        border-color: rgba(74, 222, 128, 0.55);
        box-shadow: 0 0 0 2px rgba(74, 222, 128, 0.14), 0 3px 8px rgba(0, 0, 0, 0.25);
    }

    .player-chip.draggable-chip.selected {
        border-color: #ffd700;
        box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.26);
        transform: translateY(-1px);
    }

    .player-chip.dragging { opacity: 0.4; }

    .chip-remove {
        appearance: none;
        border: none;
        background: rgba(255, 255, 255, 0.08);
        color: #fecaca;
        border-radius: 999px;
        width: 20px;
        height: 20px;
        line-height: 1;
        font-size: 0.85rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .chip-remove:hover { background: rgba(255, 0, 0, 0.22); }

    .screen-actions {
        display: flex;
        gap: 0.65rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .roulette-button {
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

    .roulette-button:hover { transform: translateY(-1px); filter: brightness(1.05); }

    .roulette-button:disabled {
        cursor: not-allowed;
        opacity: 0.4;
        transform: none;
        filter: none;
    }

    .button-primary {
        background: linear-gradient(135deg, #ffd700 0%, #ffb800 100%);
        color: #111827;
        box-shadow: 0 6px 16px rgba(255, 184, 0, 0.22);
    }

    .button-secondary {
        background: rgba(255, 255, 255, 0.08);
        color: #f8fafc;
        border: 1px solid rgba(255, 255, 255, 0.14);
    }

    .pool-hint {
        margin: 0 0 0.7rem;
        color: #d1d5db;
        font-size: 0.82rem;
        line-height: 1.5;
    }

    .player-pool {
        display: flex;
        flex-wrap: wrap;
        gap: 0.55rem;
        min-height: 2.4rem;
    }

    .betting-status {
        margin-top: 0.75rem;
        padding-top: 0.6rem;
        border-top: 1px dashed rgba(255, 255, 255, 0.1);
        display: flex;
        flex-direction: column;
        gap: 0.2rem;
    }

    .betting-stats-line {
        color: #cbd5e1;
        font-weight: 700;
        font-size: 0.8rem;
    }

    .betting-ready-line {
        color: #4ade80;
        font-weight: 800;
        font-size: 0.85rem;
    }

    .betting-waiting-line {
        color: #ffd700;
        font-weight: 800;
        font-size: 0.85rem;
    }

    .board-wrap { overflow-x: auto; padding: 1.1rem 0.8rem; }

    .roulette-board {
        display: grid;
        grid-template-columns: 46px repeat(12, minmax(42px, 1fr)) 64px;
        grid-template-rows: repeat(3, 54px) 42px 42px;
        gap: 3px;
        width: max(760px, 100%);
        margin: 0 auto;
        background:
            repeating-linear-gradient(135deg, rgba(255, 255, 255, 0.02) 0px, rgba(255, 255, 255, 0.02) 2px, transparent 2px, transparent 12px),
            radial-gradient(circle at 50% 0%, #135a36 0%, #0b3d24 70%);
        border: 4px solid #7a5c1e;
        border-radius: 14px;
        padding: 7px;
        box-shadow: inset 0 2px 10px rgba(0, 0, 0, 0.45), 0 12px 30px rgba(0, 0, 0, 0.35);
    }

    .roulette-cell {
        position: relative;
        border-radius: 6px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #f8fafc;
        font-weight: 800;
        font-size: 0.85rem;
        border: 1px solid rgba(0, 0, 0, 0.4);
        cursor: pointer;
        transition: box-shadow 0.15s ease, transform 0.1s ease, filter 0.15s ease;
        text-align: center;
        padding: 2px;
    }

    .roulette-cell:hover { filter: brightness(1.14); }

    .roulette-cell.cell-red { background: linear-gradient(155deg, #d81b3f 0%, #8a0f28 100%); }
    .roulette-cell.cell-black { background: linear-gradient(155deg, #34343a 0%, #0b0b0d 100%); }
    .roulette-cell.cell-green { background: linear-gradient(155deg, #17a862 0%, #0a5b34 100%); }
    .roulette-cell.cell-outside { background: linear-gradient(155deg, #12603a 0%, #0a3d24 100%); font-size: 0.68rem; letter-spacing: 0.04em; }
    .roulette-cell.cell-color-red { background: linear-gradient(155deg, #d81b3f 0%, #8a0f28 100%); }
    .roulette-cell.cell-color-black { background: linear-gradient(155deg, #34343a 0%, #0b0b0d 100%); }

    .roulette-cell.drag-over {
        box-shadow: 0 0 0 3px #ffd700 inset;
        transform: scale(1.04);
        z-index: 2;
    }

    .roulette-cell.cell-winning {
        box-shadow: 0 0 0 3px #ffd700, 0 0 18px 4px rgba(255, 215, 0, 0.65);
        z-index: 3;
        animation: cellPulse 1s ease-in-out infinite;
    }

    .cell-number-label { pointer-events: none; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5); }

    .cell-bets {
        display: flex;
        flex-wrap: wrap;
        gap: 2px;
        justify-content: center;
        margin-top: 2px;
        pointer-events: none;
    }

    .placed-bet-chip {
        pointer-events: auto;
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: radial-gradient(circle at 32% 28%, #2c2c2c 0%, #0a0a0a 75%);
        border: 2px solid #ffd700;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
        color: #ffd700;
        font-size: 0.5rem;
        font-weight: 900;
        animation: chipPop 0.18s ease-out;
    }

    .placed-bet-chip .bet-remove {
        appearance: none;
        position: absolute;
        top: -6px;
        right: -6px;
        width: 13px;
        height: 13px;
        border-radius: 50%;
        border: none;
        background: #7f1d1d;
        color: #fecaca;
        cursor: pointer;
        font-size: 0.55rem;
        line-height: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }

    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.72);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 60;
        padding: 1rem;
    }

    .modal-card {
        width: min(420px, 100%);
        border-radius: 18px;
        border: 1px solid rgba(255, 215, 0, 0.24);
        background: #141814;
        padding: 1.1rem;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6);
    }

    .modal-card h3 {
        margin: 0 0 0.65rem;
        color: #ffd700;
        font-size: 1.1rem;
    }

    .stake-label {
        display: block;
        margin-bottom: 0.35rem;
        color: #d1d5db;
        font-size: 0.82rem;
        font-weight: 700;
    }

    #stake-input {
        width: 100%;
        box-sizing: border-box;
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.14);
        background: rgba(255, 255, 255, 0.04);
        color: #f8fafc;
        padding: 0.6rem 0.75rem;
        font-size: 1rem;
    }

    .modal-actions {
        display: flex;
        gap: 0.6rem;
        justify-content: center;
        margin-top: 1rem;
        flex-wrap: wrap;
    }

    .results-card { width: min(580px, 100%); }

    .results-winning-line {
        text-align: center;
        font-weight: 900;
        font-size: 1.15rem;
        color: #ffd700;
        margin: 0 0 0.75rem;
    }

    .results-list {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        max-height: 50vh;
        overflow-y: auto;
        padding-right: 0.2rem;
    }

    .result-card-row {
        border-radius: 12px;
        padding: 0.6rem 0.7rem;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .result-card-row.result-win { border-color: rgba(34, 197, 94, 0.4); background: rgba(34, 197, 94, 0.08); }
    .result-card-row.result-lose { border-color: rgba(239, 68, 68, 0.32); background: rgba(239, 68, 68, 0.06); }

    .result-card-header {
        display: flex;
        align-items: center;
        gap: 0.55rem;
    }

    .result-avatar { flex-shrink: 0; }

    .result-name-total {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex: 1;
        gap: 0.5rem;
    }

    .result-name { font-weight: 800; font-size: 0.92rem; }

    .result-amount { font-weight: 900; font-size: 1rem; white-space: nowrap; }
    .result-amount.positive { color: #4ade80; }
    .result-amount.negative { color: #f87171; }

    .result-breakdown {
        margin-top: 0.45rem;
        padding-top: 0.4rem;
        border-top: 1px dashed rgba(255, 255, 255, 0.1);
        display: flex;
        flex-direction: column;
        gap: 0.2rem;
    }

    .result-breakdown-line {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.5rem;
        font-size: 0.76rem;
        color: #cbd5e1;
    }

    .result-breakdown-line.positive .result-bet-amount { color: #4ade80; }
    .result-breakdown-line.negative .result-bet-amount { color: #f87171; }
    .result-bet-amount { font-weight: 800; white-space: nowrap; }

    .spin-overlay {
        position: fixed;
        inset: 0;
        background: radial-gradient(circle at center, #14231a 0%, #060a07 100%);
        z-index: 100;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .spin-inner {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.6rem;
        padding: 0.75rem;
        width: 100%;
    }

    .spin-title {
        margin: 0;
        color: #ffd700;
        font-size: clamp(1.2rem, 3.5vw, 1.8rem);
        font-weight: 900;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        min-height: 1.4em;
        text-align: center;
    }

    .wheel-frame {
        position: relative;
        width: min(84vmin, 92vw, 900px);
        aspect-ratio: 1 / 1;
    }

    .wheel-frame.reveal-flash { animation: revealFlash 0.6s ease-out; }

    .wheel-pointer {
        position: absolute;
        top: -6px;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 0;
        border-left: 16px solid transparent;
        border-right: 16px solid transparent;
        border-top: 27px solid #ffd700;
        z-index: 7;
        filter: drop-shadow(0 2px 3px rgba(0, 0, 0, 0.5));
    }

    .wheel-disc {
        position: absolute;
        inset: 0;
        border-radius: 50%;
        border: 6px solid #7a5c1e;
        box-shadow: 0 0 0 4px #1a1a1a, 0 0 0 7px #7a5c1e, 0 25px 60px rgba(0, 0, 0, 0.65);
        will-change: transform;
    }

    .wheel-number {
        position: absolute;
        inset: 0;
        pointer-events: none;
    }

    .wheel-number .num {
        position: absolute;
        top: 5.5%;
        left: 50%;
        transform: translateX(-50%);
        font-size: clamp(0.65rem, 2.1vmin, 1.15rem);
        font-weight: 800;
        color: #f8fafc;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.85);
    }

    .wheel-hub {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 15%;
        height: 15%;
        transform: translate(-50%, -50%);
        border-radius: 50%;
        background: radial-gradient(circle at 35% 30%, #fff8dc 0%, #ffd700 42%, #8a6d1a 90%);
        box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.55), 0 4px 10px rgba(0, 0, 0, 0.6);
        z-index: 6;
    }

    .ball-orbit {
        position: absolute;
        inset: 0;
        will-change: transform;
        z-index: 4;
    }

    .ball {
        position: absolute;
        top: 4%;
        left: 50%;
        width: 12px;
        height: 12px;
        margin-left: -6px;
        border-radius: 50%;
        background: radial-gradient(circle at 30% 30%, #fff, #cbd5e1 60%, #94a3b8);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.6);
    }

    .spin-result-text {
        margin: 0;
        text-align: center;
        font-size: clamp(1.3rem, 4vw, 2rem);
        font-weight: 900;
        color: #ffd700;
        text-shadow: 0 0 18px rgba(255, 215, 0, 0.35);
    }

    @keyframes cellPulse {
        0%, 100% { box-shadow: 0 0 0 3px #ffd700, 0 0 10px 2px rgba(255, 215, 0, 0.5); }
        50% { box-shadow: 0 0 0 4px #ffd700, 0 0 22px 6px rgba(255, 215, 0, 0.85); }
    }

    @keyframes chipPop {
        0% { transform: scale(0.4); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
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
        .roulette-page { padding: 0.5rem 0.35rem 1.5rem; }
        .roulette-shell { padding: 0.65rem; border-radius: 16px; }
        .panel-card, .board-wrap { padding: 0.7rem 0.6rem; }
        .screen-actions { flex-direction: column; }
        .roulette-button { width: 100%; text-align: center; }
        .modal-actions { flex-direction: column; }
    }
</style>

<script>
(function () {
    var redSet = new Set([1, 3, 5, 7, 9, 12, 14, 16, 18, 19, 21, 23, 25, 27, 30, 32, 34, 36]);
    var wheelSequence = [0, 32, 15, 19, 4, 21, 2, 25, 17, 34, 6, 27, 13, 36, 11, 30, 8, 23, 10, 5, 24, 16, 33, 1, 20, 14, 31, 9, 22, 18, 29, 7, 28, 12, 35, 3, 26];
    var segAngle = 360 / wheelSequence.length;
    var MAX_PLAYERS = 15;
    var WHEEL_SPIN_MS = 8600;
    var BALL_SPIN_MS = 6600;

    var numbersMeta = {};
    var cellDefs = [];
    var cellElements = {};

    var state = {
        phase: 'players',
        players: [],
        bets: [],
        selectedPlayerId: null,
        winningNumber: null,
        pendingPlacement: null,
        boardBuilt: false,
    };

    var el = {
        playerNameInput: document.getElementById('player-name-input'),
        addPlayerBtn: document.getElementById('add-player-btn'),
        playersCount: document.getElementById('players-count'),
        playersError: document.getElementById('players-error'),
        playersList: document.getElementById('players-list'),
        continueBtn: document.getElementById('continue-btn'),

        screenPlayers: document.getElementById('screen-players'),
        screenBetting: document.getElementById('screen-betting'),

        playerPool: document.getElementById('player-pool'),
        bettingStatus: document.getElementById('betting-status'),
        board: document.getElementById('roulette-board'),
        backPlayersBtn: document.getElementById('back-players-btn'),
        spinBtn: document.getElementById('spin-btn'),

        stakePopup: document.getElementById('stake-popup'),
        stakePopupTitle: document.getElementById('stake-popup-title'),
        stakeInput: document.getElementById('stake-input'),
        stakeError: document.getElementById('stake-error'),
        stakeCancelBtn: document.getElementById('stake-cancel-btn'),
        stakeConfirmBtn: document.getElementById('stake-confirm-btn'),

        resultsModal: document.getElementById('results-modal'),
        resultsWinningLine: document.getElementById('results-winning-line'),
        resultsList: document.getElementById('results-list'),
        newRoundBtn: document.getElementById('new-round-btn'),
        newGameBtn: document.getElementById('new-game-btn'),

        spinOverlay: document.getElementById('spin-overlay'),
        spinTitle: document.getElementById('spin-title'),
        wheelFrame: document.getElementById('wheel-frame'),
        wheelDisc: document.getElementById('wheel-disc'),
        ballOrbit: document.getElementById('ball-orbit'),
        spinResultText: document.getElementById('spin-result-text'),
        showResultsBtn: document.getElementById('show-results-btn'),
    };

    function randomInt(max) {
        return Math.floor(Math.random() * max);
    }

    function makePlayerId() {
        return 'p_' + Date.now().toString(36) + '_' + Math.random().toString(36).slice(2, 8);
    }

    function createEl(tag, className, text) {
        var node = document.createElement(tag);
        if (className) node.className = className;
        if (text !== undefined && text !== null) node.textContent = text;
        return node;
    }

    function pluralStavka(n) {
        if (n === 1) return 'stávka';
        if (n >= 2 && n <= 4) return 'stávky';
        return 'stávok';
    }

    // ---------- Players screen ----------

    function renderPlayers() {
        el.playersCount.textContent = state.players.length + ' / ' + MAX_PLAYERS + ' hráčov';
        el.playersList.innerHTML = '';

        state.players.forEach(function (player) {
            var chip = createEl('div', 'player-chip');
            chip.appendChild(createEl('span', 'chip-avatar', player.name.charAt(0).toUpperCase()));
            chip.appendChild(createEl('span', null, player.name));
            var removeBtn = createEl('button', 'chip-remove', '×');
            removeBtn.type = 'button';
            removeBtn.setAttribute('aria-label', 'Odobrať hráča ' + player.name);
            removeBtn.addEventListener('click', function () {
                state.players = state.players.filter(function (p) { return p.id !== player.id; });
                renderPlayers();
            });
            chip.appendChild(removeBtn);
            el.playersList.appendChild(chip);
        });

        el.continueBtn.disabled = state.players.length < 1;
        el.addPlayerBtn.disabled = state.players.length >= MAX_PLAYERS;
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

    function addPlayer() {
        var name = el.playerNameInput.value.trim();

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
            showPlayersError('Hráč s týmto menom už existuje.');
            return;
        }

        state.players.push({ id: makePlayerId(), name: name });
        el.playerNameInput.value = '';
        showPlayersError(null);
        renderPlayers();
        el.playerNameInput.focus();
    }

    el.addPlayerBtn.addEventListener('click', addPlayer);
    el.playerNameInput.addEventListener('keydown', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            addPlayer();
        }
    });

    el.continueBtn.addEventListener('click', function () {
        if (state.players.length < 1) return;
        if (!state.boardBuilt) {
            buildBoard();
            state.boardBuilt = true;
        }
        state.phase = 'betting';
        el.screenPlayers.classList.add('hidden');
        el.screenBetting.classList.remove('hidden');
        renderPool();
        renderBettingStatus();
    });

    // ---------- Board building ----------

    function labelForField(type, value) {
        switch (type) {
            case 'number': return value === 0 ? '0 (ZERO)' : String(value);
            case 'color': return value === 'red' ? 'ČERVENÁ' : 'ČIERNA';
            case 'parity': return value === 'even' ? 'PÁRNE' : 'NEPÁRNE';
            case 'half': return value === 'low' ? '1–18' : '19–36';
            case 'dozen': return value === 1 ? '1. dvanástka (1–12)' : (value === 2 ? '2. dvanástka (13–24)' : '3. dvanástka (25–36)');
            case 'column': return 'Stĺpec (2 na 1) — riadok ' + value;
            default: return '';
        }
    }

    function oddsForType(type) {
        return { number: 35, dozen: 2, column: 2, half: 1, parity: 1, color: 1 }[type];
    }

    function buildBoardDefinitions() {
        var defs = [];

        defs.push({
            type: 'number', value: 0, label: '0', colorClass: 'cell-green',
            col: '1 / 2', row: '1 / 4',
        });

        for (var c = 1; c <= 12; c++) {
            var top = 3 * c;
            var mid = 3 * c - 1;
            var bottom = 3 * c - 2;

            [[top, 1], [mid, 2], [bottom, 3]].forEach(function (pair) {
                var num = pair[0];
                var rowIdx = pair[1];
                var isRed = redSet.has(num);
                numbersMeta[num] = {
                    color: isRed ? 'red' : 'black',
                    half: num <= 18 ? 'low' : 'high',
                    parity: num % 2 === 0 ? 'even' : 'odd',
                    dozen: Math.ceil(num / 12),
                    column: rowIdx,
                };
                defs.push({
                    type: 'number', value: num, label: String(num),
                    colorClass: isRed ? 'cell-red' : 'cell-black',
                    col: (c + 1) + ' / ' + (c + 2), row: rowIdx + ' / ' + (rowIdx + 1),
                });
            });
        }

        for (var rowIdx2 = 1; rowIdx2 <= 3; rowIdx2++) {
            defs.push({
                type: 'column', value: rowIdx2, label: '2 na 1', colorClass: 'cell-outside',
                col: '14 / 15', row: rowIdx2 + ' / ' + (rowIdx2 + 1),
            });
        }

        defs.push({ type: 'dozen', value: 1, label: '1. dvanástka', colorClass: 'cell-outside', col: '2 / 6', row: '4 / 5' });
        defs.push({ type: 'dozen', value: 2, label: '2. dvanástka', colorClass: 'cell-outside', col: '6 / 10', row: '4 / 5' });
        defs.push({ type: 'dozen', value: 3, label: '3. dvanástka', colorClass: 'cell-outside', col: '10 / 14', row: '4 / 5' });

        defs.push({ type: 'half', value: 'low', label: '1–18', colorClass: 'cell-outside', col: '2 / 4', row: '5 / 6' });
        defs.push({ type: 'parity', value: 'even', label: 'PÁRNE', colorClass: 'cell-outside', col: '4 / 6', row: '5 / 6' });
        defs.push({ type: 'color', value: 'red', label: '', colorClass: 'cell-outside cell-color-red', col: '6 / 8', row: '5 / 6' });
        defs.push({ type: 'color', value: 'black', label: '', colorClass: 'cell-outside cell-color-black', col: '8 / 10', row: '5 / 6' });
        defs.push({ type: 'parity', value: 'odd', label: 'NEPÁRNE', colorClass: 'cell-outside', col: '10 / 12', row: '5 / 6' });
        defs.push({ type: 'half', value: 'high', label: '19–36', colorClass: 'cell-outside', col: '12 / 14', row: '5 / 6' });

        return defs;
    }

    function cellKey(type, value) {
        return type + ':' + value;
    }

    function buildBoard() {
        cellDefs = buildBoardDefinitions();
        el.board.innerHTML = '';

        cellDefs.forEach(function (def) {
            var cell = createEl('div', 'roulette-cell');
            (def.colorClass || '').split(' ').forEach(function (cls) {
                if (cls) cell.classList.add(cls);
            });
            cell.style.gridColumn = def.col;
            cell.style.gridRow = def.row;
            cell.dataset.type = def.type;
            cell.dataset.value = String(def.value);

            if (def.label) {
                cell.appendChild(createEl('span', 'cell-number-label', def.label));
            }
            var betsHolder = createEl('div', 'cell-bets');
            cell.appendChild(betsHolder);

            cell.addEventListener('dragover', function (event) {
                if (state.phase !== 'betting') return;
                event.preventDefault();
                cell.classList.add('drag-over');
            });
            cell.addEventListener('dragleave', function () {
                cell.classList.remove('drag-over');
            });
            cell.addEventListener('drop', function (event) {
                event.preventDefault();
                cell.classList.remove('drag-over');
                if (state.phase !== 'betting') return;
                var playerId = event.dataTransfer.getData('text/plain');
                if (playerId) {
                    openStakePopup(playerId, def);
                }
            });
            cell.addEventListener('click', function () {
                if (state.phase !== 'betting' || !state.selectedPlayerId) return;
                var playerId = state.selectedPlayerId;
                state.selectedPlayerId = null;
                renderPool();
                openStakePopup(playerId, def);
            });

            cellElements[cellKey(def.type, def.value)] = { el: cell, betsHolder: betsHolder };
            el.board.appendChild(cell);
        });
    }

    // ---------- Player pool / drag & drop ----------

    function betsForPlayer(playerId) {
        return state.bets.filter(function (b) { return b.playerId === playerId; });
    }

    function totalStakeForPlayer(playerId) {
        return betsForPlayer(playerId).reduce(function (sum, b) { return sum + b.stake; }, 0);
    }

    function playersWithZeroBets() {
        return state.players.filter(function (p) { return betsForPlayer(p.id).length === 0; });
    }

    function renderPool() {
        el.playerPool.innerHTML = '';
        state.players.forEach(function (player) {
            var bets = betsForPlayer(player.id);
            var chip = createEl('div', 'player-chip draggable-chip' + (bets.length > 0 ? ' has-bets' : ''));
            chip.draggable = true;
            chip.dataset.playerId = player.id;
            chip.appendChild(createEl('span', 'chip-avatar', player.name.charAt(0).toUpperCase()));

            var nameWrap = createEl('span', 'chip-name-wrap');
            nameWrap.appendChild(createEl('span', 'chip-name', player.name));
            if (bets.length > 0) {
                nameWrap.appendChild(createEl('span', 'chip-badge', '✓ ' + bets.length + '× · ' + totalStakeForPlayer(player.id)));
            }
            chip.appendChild(nameWrap);

            if (state.selectedPlayerId === player.id) {
                chip.classList.add('selected');
            }

            chip.addEventListener('dragstart', function (event) {
                event.dataTransfer.setData('text/plain', player.id);
                event.dataTransfer.effectAllowed = 'move';
                chip.classList.add('dragging');
            });
            chip.addEventListener('dragend', function () {
                chip.classList.remove('dragging');
            });
            chip.addEventListener('click', function () {
                state.selectedPlayerId = state.selectedPlayerId === player.id ? null : player.id;
                renderPool();
            });

            el.playerPool.appendChild(chip);
        });
    }

    function renderBettingStatus() {
        var totalBets = state.bets.length;
        var totalStake = state.bets.reduce(function (sum, b) { return sum + b.stake; }, 0);
        var remaining = playersWithZeroBets().length;
        var readyCount = state.players.length - remaining;

        el.bettingStatus.innerHTML = '';
        el.bettingStatus.appendChild(createEl('div', 'betting-stats-line',
            totalBets + ' ' + pluralStavka(totalBets) + ' spolu · vklad ' + totalStake));

        if (remaining === 0) {
            el.bettingStatus.appendChild(createEl('div', 'betting-ready-line', '✅ Všetci hráči majú aspoň jednu stávku. Môžeš roztočiť ruletu!'));
        } else {
            el.bettingStatus.appendChild(createEl('div', 'betting-waiting-line',
                '⏳ ' + readyCount + '/' + state.players.length + ' pripravených · čaká sa na ' + remaining + ' hráč' + (remaining === 1 ? 'a' : 'ov')));
        }

        el.spinBtn.disabled = state.players.length < 1 || remaining > 0;
    }

    function renderPlacedBets() {
        Object.keys(cellElements).forEach(function (key) {
            cellElements[key].betsHolder.innerHTML = '';
        });

        state.bets.forEach(function (bet) {
            var target = cellElements[cellKey(bet.type, bet.value)];
            if (!target) return;

            var player = state.players.find(function (p) { return p.id === bet.playerId; });
            if (!player) return;

            var chip = createEl('div', 'placed-bet-chip', String(bet.stake));
            chip.title = player.name + ': ' + bet.stake;

            var removeBtn = createEl('button', 'bet-remove', '×');
            removeBtn.type = 'button';
            removeBtn.setAttribute('aria-label', 'Zrušiť stávku hráča ' + player.name);
            removeBtn.addEventListener('click', function (event) {
                event.stopPropagation();
                if (state.phase !== 'betting') return;
                state.bets = state.bets.filter(function (b) { return b !== bet; });
                renderPool();
                renderPlacedBets();
                renderBettingStatus();
            });
            chip.appendChild(removeBtn);

            target.betsHolder.appendChild(chip);
        });
    }

    el.backPlayersBtn.addEventListener('click', function () {
        if (state.bets.length > 0) {
            var ok = window.confirm('Vrátiť sa na pridávanie hráčov? Všetky aktuálne stávky sa vymažú.');
            if (!ok) return;
        }
        state.bets = [];
        state.selectedPlayerId = null;
        clearWinningHighlight();
        renderPlacedBets();
        state.phase = 'players';
        el.screenBetting.classList.add('hidden');
        el.screenPlayers.classList.remove('hidden');
    });

    // ---------- Stake popup ----------

    function openStakePopup(playerId, cellDef) {
        var player = state.players.find(function (p) { return p.id === playerId; });
        if (!player) return;

        state.pendingPlacement = { playerId: playerId, type: cellDef.type, value: cellDef.value };
        var label = labelForField(cellDef.type, cellDef.value);
        var existing = state.bets.find(function (b) {
            return b.playerId === playerId && b.type === cellDef.type && b.value === cellDef.value;
        });

        el.stakePopupTitle.textContent = existing
            ? 'Hráč „' + player.name + '“ už má na „' + label + '“ vsadené ' + existing.stake + '. Pridaj sumu:'
            : 'Stávka hráča „' + player.name + '“ na „' + label + '“';

        el.stakeInput.value = '10';
        el.stakeError.classList.add('hidden');
        el.stakePopup.classList.remove('hidden');
        window.setTimeout(function () { el.stakeInput.focus(); el.stakeInput.select(); }, 0);
    }

    function closeStakePopup() {
        state.pendingPlacement = null;
        el.stakePopup.classList.add('hidden');
    }

    function confirmStake() {
        if (!state.pendingPlacement) return;
        var stake = parseInt(el.stakeInput.value, 10);

        if (!Number.isFinite(stake) || stake < 1) {
            el.stakeError.textContent = 'Zadaj platnú stávku (celé číslo väčšie ako 0).';
            el.stakeError.classList.remove('hidden');
            return;
        }

        var placement = state.pendingPlacement;
        var existing = state.bets.find(function (b) {
            return b.playerId === placement.playerId && b.type === placement.type && b.value === placement.value;
        });

        if (existing) {
            existing.stake += stake;
        } else {
            state.bets.push({ playerId: placement.playerId, type: placement.type, value: placement.value, stake: stake });
        }

        closeStakePopup();
        renderPool();
        renderPlacedBets();
        renderBettingStatus();
    }

    el.stakeCancelBtn.addEventListener('click', closeStakePopup);
    el.stakeConfirmBtn.addEventListener('click', confirmStake);
    el.stakeInput.addEventListener('keydown', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            confirmStake();
        } else if (event.key === 'Escape') {
            closeStakePopup();
        }
    });

    // ---------- Spin ----------

    function colorNameSk(color) {
        return color === 'red' ? 'ČERVENÁ' : (color === 'black' ? 'ČIERNA' : 'ZELENÁ');
    }

    function colorHex(num) {
        if (num === 0) return '#0f7a3d';
        return redSet.has(num) ? '#b0122a' : '#1c1c1c';
    }

    function buildWheelVisualsOnce() {
        if (el.wheelDisc.dataset.built === '1') return;

        var start = -segAngle / 2;
        var wedgeStops = [];
        wheelSequence.forEach(function (num, idx) {
            var from = idx * segAngle + start;
            var to = (idx + 1) * segAngle + start;
            wedgeStops.push(colorHex(num) + ' ' + from + 'deg ' + to + 'deg');
        });
        var wedgesLayer = 'conic-gradient(from 0deg, ' + wedgeStops.join(',') + ')';
        var separatorLayer = 'repeating-conic-gradient(from ' + start + 'deg, rgba(0,0,0,0.55) 0deg 0.6deg, transparent 0.6deg ' + segAngle + 'deg)';
        el.wheelDisc.style.background = separatorLayer + ', ' + wedgesLayer;

        wheelSequence.forEach(function (num, idx) {
            var wrapper = createEl('div', 'wheel-number');
            wrapper.style.transform = 'rotate(' + (idx * segAngle) + 'deg)';
            wrapper.appendChild(createEl('span', 'num', String(num)));
            el.wheelDisc.appendChild(wrapper);
        });

        el.wheelDisc.dataset.built = '1';
    }

    function checkWin(bet, winningNumber) {
        if (winningNumber === 0) {
            return bet.type === 'number' && bet.value === 0;
        }
        var meta = numbersMeta[winningNumber];
        switch (bet.type) {
            case 'number': return bet.value === winningNumber;
            case 'color': return bet.value === meta.color;
            case 'parity': return bet.value === meta.parity;
            case 'half': return bet.value === meta.half;
            case 'dozen': return bet.value === meta.dozen;
            case 'column': return bet.value === meta.column;
            default: return false;
        }
    }

    function clearWinningHighlight() {
        Object.keys(cellElements).forEach(function (key) {
            cellElements[key].el.classList.remove('cell-winning');
        });
    }

    function highlightWinningCell(winningNumber) {
        clearWinningHighlight();
        var target = cellElements[cellKey('number', winningNumber)];
        if (target) target.el.classList.add('cell-winning');
    }

    var spinResults = [];
    var spinTimeouts = [];

    function scheduleSpinStep(fn, delay) {
        spinTimeouts.push(window.setTimeout(fn, delay));
    }

    function setSpinTitle(text) {
        el.spinTitle.textContent = text;
    }

    function startSpin() {
        if (state.phase !== 'betting' || playersWithZeroBets().length > 0) return;

        spinTimeouts.forEach(function (id) { window.clearTimeout(id); });
        spinTimeouts = [];

        buildWheelVisualsOnce();
        state.phase = 'spinning';
        el.spinOverlay.classList.remove('hidden');
        el.spinResultText.classList.add('hidden');
        el.showResultsBtn.classList.add('hidden');
        el.wheelFrame.classList.remove('reveal-flash');
        setSpinTitle('Ruleta sa točí...');

        if (el.spinOverlay.requestFullscreen) {
            el.spinOverlay.requestFullscreen().catch(function () {});
        }

        var idx = randomInt(wheelSequence.length);
        var winningNumber = wheelSequence[idx];
        state.winningNumber = winningNumber;

        var wheelSpins = 10 + randomInt(4);
        var ballSpins = wheelSpins + 6;
        var wheelTarget = 360 * wheelSpins - idx * segAngle;
        var ballTarget = -360 * ballSpins;

        el.wheelDisc.style.transition = 'none';
        el.ballOrbit.style.transition = 'none';
        el.wheelDisc.style.transform = 'rotate(0deg)';
        el.ballOrbit.style.transform = 'rotate(0deg)';
        void el.wheelDisc.offsetWidth;

        requestAnimationFrame(function () {
            el.wheelDisc.style.transition = 'transform ' + (WHEEL_SPIN_MS / 1000) + 's cubic-bezier(0.1, 0.62, 0.12, 1)';
            el.ballOrbit.style.transition = 'transform ' + (BALL_SPIN_MS / 1000) + 's cubic-bezier(0.16, 0.7, 0.18, 1)';
            el.wheelDisc.style.transform = 'rotate(' + wheelTarget + 'deg)';
            el.ballOrbit.style.transform = 'rotate(' + ballTarget + 'deg)';
        });

        // staged suspense messages
        scheduleSpinStep(function () { setSpinTitle('Gulička naberá rýchlosť...'); }, 1800);
        scheduleSpinStep(function () { setSpinTitle('Ruleta sa krúti...'); }, Math.round(WHEEL_SPIN_MS * 0.35));
        scheduleSpinStep(function () { setSpinTitle('Gulička sa spomaľuje...'); }, Math.round(WHEEL_SPIN_MS * 0.6));
        scheduleSpinStep(function () { setSpinTitle('Už to bude... 🤞'); }, Math.round(WHEEL_SPIN_MS * 0.85));

        scheduleSpinStep(function () {
            var meta = winningNumber === 0 ? { color: 'green' } : numbersMeta[winningNumber];
            setSpinTitle('Ruleta sa zastavila!');
            el.wheelFrame.classList.add('reveal-flash');
            el.spinResultText.textContent = 'Padlo číslo ' + winningNumber + ' — ' + colorNameSk(meta.color);
            el.spinResultText.classList.remove('hidden');
            el.showResultsBtn.classList.remove('hidden');

            var perPlayer = {};
            state.bets.forEach(function (bet) {
                var player = state.players.find(function (p) { return p.id === bet.playerId; });
                if (!player) return;
                var won = checkWin(bet, winningNumber);
                var net = won ? bet.stake * oddsForType(bet.type) : -bet.stake;

                if (!perPlayer[bet.playerId]) {
                    perPlayer[bet.playerId] = { player: player, items: [], totalNet: 0 };
                }
                perPlayer[bet.playerId].items.push({
                    label: labelForField(bet.type, bet.value),
                    stake: bet.stake,
                    won: won,
                    net: net,
                });
                perPlayer[bet.playerId].totalNet += net;
            });

            spinResults = Object.keys(perPlayer)
                .map(function (id) { return perPlayer[id]; })
                .sort(function (a, b) { return b.totalNet - a.totalNet; });
        }, WHEEL_SPIN_MS + 150);
    }

    el.spinBtn.addEventListener('click', startSpin);

    el.showResultsBtn.addEventListener('click', function () {
        if (document.fullscreenElement) {
            document.exitFullscreen().catch(function () {});
        }
        el.spinOverlay.classList.add('hidden');

        state.phase = 'results';
        highlightWinningCell(state.winningNumber);
        renderResultsModal();
        el.resultsModal.classList.remove('hidden');
    });

    function renderResultsModal() {
        var meta = state.winningNumber === 0 ? { color: 'green' } : numbersMeta[state.winningNumber];
        el.resultsWinningLine.textContent = '🎯 Padlo číslo ' + state.winningNumber + ' — ' + colorNameSk(meta.color);

        el.resultsList.innerHTML = '';
        spinResults.forEach(function (group) {
            var row = createEl('div', 'result-card-row ' + (group.totalNet >= 0 ? 'result-win' : 'result-lose'));

            var header = createEl('div', 'result-card-header');
            header.appendChild(createEl('span', 'chip-avatar result-avatar', group.player.name.charAt(0).toUpperCase()));

            var nameAndTotal = createEl('div', 'result-name-total');
            nameAndTotal.appendChild(createEl('div', 'result-name', (group.totalNet >= 0 ? '🏆 ' : '💸 ') + group.player.name));
            nameAndTotal.appendChild(createEl('div', 'result-amount ' + (group.totalNet >= 0 ? 'positive' : 'negative'),
                (group.totalNet >= 0 ? '+' : '') + group.totalNet));
            header.appendChild(nameAndTotal);
            row.appendChild(header);

            var breakdown = createEl('div', 'result-breakdown');
            group.items.forEach(function (item) {
                var line = createEl('div', 'result-breakdown-line ' + (item.won ? 'positive' : 'negative'));
                line.appendChild(createEl('span', 'result-bet-label', item.label + ' · stávka ' + item.stake));
                line.appendChild(createEl('span', 'result-bet-amount', (item.net >= 0 ? '+' : '') + item.net));
                breakdown.appendChild(line);
            });
            row.appendChild(breakdown);

            el.resultsList.appendChild(row);
        });
    }

    el.newRoundBtn.addEventListener('click', function () {
        state.bets = [];
        state.selectedPlayerId = null;
        state.phase = 'betting';
        clearWinningHighlight();
        renderPlacedBets();
        renderPool();
        renderBettingStatus();
        el.resultsModal.classList.add('hidden');
    });

    el.newGameBtn.addEventListener('click', function () {
        state.bets = [];
        state.selectedPlayerId = null;
        state.phase = 'players';
        clearWinningHighlight();
        renderPlacedBets();
        el.resultsModal.classList.add('hidden');
        el.screenBetting.classList.add('hidden');
        el.screenPlayers.classList.remove('hidden');
        showPlayersError(null);
        renderPlayers();
    });

    renderPlayers();
})();
</script>
