<section class="casino-page">
    <div class="casino-shell">
        <header class="casino-header">
            <p class="casino-kicker">Party hry</p>
            <h1>🎉 KASÍNO</h1>
            <p class="casino-subtitle">Vyber si hru a zabav sa s partiou. Každá hra funguje na jednom zariadení a je určená pre viac hráčov naraz.</p>
        </header>

        <div class="games-grid">
            <a href="/ruleta" class="game-card game-roulette">
                <div class="game-icon">🔴⚫</div>
                <h2>Ruleta</h2>
                <p>Pridaj hráčov, rozdeľ stávky po políčkach a roztoč koleso šťastia.</p>
                <span class="game-cta">Hrať →</span>
            </a>

            <a href="/koleso-stastia" class="game-card game-fortune">
                <div class="game-icon">🎡</div>
                <h2>Koleso šťastia</h2>
                <p>Každý hráč staví a postupne sa vystrieda pri točení kolesa.</p>
                <span class="game-cta">Hrať →</span>
            </a>

            <a href="/herny-automat" class="game-card game-slot">
                <div class="game-icon">🎰</div>
                <h2>Herný automat</h2>
                <p>Klasický jednoruký bandita — vsaď kredit a skús to na valcoch.</p>
                <span class="game-cta">Hrať →</span>
            </a>
        </div>
    </div>
</section>

<style>
    .casino-page {
        min-height: 100vh;
        padding: 0.75rem 0.5rem 2rem;
        background:
            radial-gradient(circle at top, rgba(255, 215, 0, 0.14), transparent 40%),
            radial-gradient(circle at bottom, rgba(147, 51, 234, 0.14), transparent 48%),
            linear-gradient(180deg, #0d0a14 0%, #17101f 50%, #0d0a14 100%);
        color: #f8fafc;
        font-family: Arial, sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .casino-shell {
        width: min(1000px, 100%);
        margin: 0 auto;
    }

    .casino-header {
        text-align: center;
        margin-bottom: 1.75rem;
    }

    .casino-kicker {
        margin: 0 0 0.3rem;
        color: #ffd700;
        letter-spacing: 0.36em;
        text-transform: uppercase;
        font-size: 0.75rem;
    }

    .casino-header h1 {
        margin: 0;
        font-size: clamp(2rem, 6vw, 3.4rem);
        color: #ffd700;
        text-shadow: 0 0 26px rgba(255, 215, 0, 0.28);
        letter-spacing: 0.03em;
    }

    .casino-subtitle {
        margin: 0.6rem auto 0;
        max-width: 640px;
        line-height: 1.55;
        color: #d1d5db;
        font-size: 0.92rem;
    }

    .games-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 1rem;
    }

    .game-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        text-decoration: none;
        border-radius: 22px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        background: linear-gradient(180deg, rgba(30, 22, 43, 0.92) 0%, rgba(18, 13, 26, 0.94) 100%);
        padding: 1.75rem 1.25rem;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.04), 0 14px 30px rgba(0, 0, 0, 0.35);
        transition: transform 0.18s ease, border-color 0.18s ease, box-shadow 0.18s ease;
    }

    .game-card:hover {
        transform: translateY(-4px);
        border-color: rgba(255, 215, 0, 0.45);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.06), 0 18px 38px rgba(0, 0, 0, 0.45);
    }

    .game-icon {
        font-size: 2.8rem;
        margin-bottom: 0.6rem;
        filter: drop-shadow(0 4px 10px rgba(0, 0, 0, 0.4));
    }

    .game-card h2 {
        margin: 0 0 0.5rem;
        color: #ffd700;
        font-size: 1.25rem;
        letter-spacing: 0.01em;
    }

    .game-card p {
        margin: 0;
        color: #d1d5db;
        font-size: 0.85rem;
        line-height: 1.5;
        flex: 1;
    }

    .game-cta {
        margin-top: 1rem;
        display: inline-block;
        font-weight: 900;
        font-size: 0.85rem;
        color: #241536;
        background: linear-gradient(135deg, #ffd700 0%, #ffb800 100%);
        border-radius: 999px;
        padding: 0.45rem 1.1rem;
        box-shadow: 0 6px 16px rgba(255, 184, 0, 0.22);
    }

    @media (max-width: 640px) {
        .casino-page { padding: 1.25rem 0.5rem; }
        .game-card { padding: 1.4rem 1rem; }
    }
</style>
