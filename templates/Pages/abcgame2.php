<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ABC Sprint 2</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-950 text-slate-100">
<div class="relative mx-auto flex min-h-screen w-full max-w-5xl items-center justify-center px-4 py-8">
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute -left-20 top-8 h-64 w-64 rounded-full bg-sky-500/20 blur-3xl"></div>
        <div class="absolute -right-20 bottom-8 h-64 w-64 rounded-full bg-violet-500/20 blur-3xl"></div>
    </div>

    <main class="relative w-full max-w-2xl rounded-3xl border border-slate-700/80 bg-slate-900/80 p-6 shadow-2xl shadow-black/40 backdrop-blur md:p-8">
        <p class="text-xs uppercase tracking-[0.22em] text-sky-300">ABC Sprint</p>
        <h1 class="mt-2 text-3xl font-bold tracking-tight text-white md:text-4xl">Abecedna hra #2</h1>
        <p class="mt-2 text-sm text-slate-300 md:text-base">Pis pismena v spravnom poradi od A po Z co najrychlejsie.</p>

        <section id="start-screen" class="mt-8 space-y-4">
            <div class="rounded-2xl border border-slate-700 bg-slate-950/70 p-4 text-sm text-slate-300">
                <p>- Start od A, ciel je Z.</p>
                <p>- Chybny klaves sa zapocita ako chyba.</p>
                <p>- Meria sa cas aj pocet chyb.</p>
            </div>
            <button id="start-btn" class="w-full rounded-xl bg-sky-500 px-5 py-3 text-base font-semibold text-slate-950 transition hover:bg-sky-400">Spustit hru</button>
        </section>

        <section id="game-screen" class="mt-8 hidden space-y-5">
            <div class="grid gap-3 sm:grid-cols-3">
                <div class="rounded-xl border border-slate-700 bg-slate-950/70 p-3 text-center">
                    <p class="text-xs uppercase tracking-wide text-slate-400">Cas</p>
                    <p id="time" class="text-2xl font-bold text-slate-100">0.00 s</p>
                </div>
                <div class="rounded-xl border border-slate-700 bg-slate-950/70 p-3 text-center">
                    <p class="text-xs uppercase tracking-wide text-slate-400">Chyby</p>
                    <p id="errors" class="text-2xl font-bold text-rose-400">0</p>
                </div>
                <div class="rounded-xl border border-slate-700 bg-slate-950/70 p-3 text-center">
                    <p class="text-xs uppercase tracking-wide text-slate-400">Postup</p>
                    <p id="progress" class="text-2xl font-bold text-emerald-400">0 / 26</p>
                </div>
            </div>

            <div class="rounded-2xl border border-sky-500/40 bg-sky-500/10 p-5 text-center">
                <p class="text-sm text-slate-300">Stlac teraz:</p>
                <p id="target-letter" class="mt-2 text-7xl font-black tracking-wider text-sky-300">A</p>
            </div>

            <div class="h-3 overflow-hidden rounded-full bg-slate-800">
                <div id="progress-bar" class="h-full w-0 bg-gradient-to-r from-emerald-400 to-sky-400 transition-all"></div>
            </div>

            <p id="hint" class="text-center text-sm text-slate-400">Pouzi klavesnicu.</p>
        </section>

        <section id="result-screen" class="mt-8 hidden space-y-4 text-center">
            <h2 class="text-3xl font-bold text-emerald-300">Hotovo!</h2>
            <p id="final-time" class="text-xl text-slate-100"></p>
            <p id="final-errors" class="text-sm text-slate-300"></p>
            <button id="restart-btn" class="w-full rounded-xl border border-slate-600 bg-slate-800 px-5 py-3 text-base font-semibold text-slate-100 transition hover:border-slate-500 hover:bg-slate-700">Hrat znova</button>
        </section>
    </main>
</div>

<script>
    const ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    let index = 0;
    let errors = 0;
    let startedAt = 0;
    let timerHandle = null;
    let playing = false;

    const startScreen = document.getElementById('start-screen');
    const gameScreen = document.getElementById('game-screen');
    const resultScreen = document.getElementById('result-screen');

    const startBtn = document.getElementById('start-btn');
    const restartBtn = document.getElementById('restart-btn');

    const timeEl = document.getElementById('time');
    const errorsEl = document.getElementById('errors');
    const progressEl = document.getElementById('progress');
    const targetLetterEl = document.getElementById('target-letter');
    const progressBarEl = document.getElementById('progress-bar');
    const hintEl = document.getElementById('hint');

    const finalTimeEl = document.getElementById('final-time');
    const finalErrorsEl = document.getElementById('final-errors');

    function elapsedSeconds() {
        return (Date.now() - startedAt) / 1000;
    }

    function updateHud() {
        progressEl.textContent = `${index} / ${ALPHABET.length}`;
        errorsEl.textContent = String(errors);
        targetLetterEl.textContent = ALPHABET[index] || '-';
        progressBarEl.style.width = `${(index / ALPHABET.length) * 100}%`;
    }

    function startGame() {
        index = 0;
        errors = 0;
        startedAt = Date.now();
        playing = true;

        startScreen.classList.add('hidden');
        resultScreen.classList.add('hidden');
        gameScreen.classList.remove('hidden');

        updateHud();
        hintEl.textContent = 'Pouzi klavesnicu.';

        if (timerHandle) {
            window.clearInterval(timerHandle);
        }

        timerHandle = window.setInterval(() => {
            timeEl.textContent = `${elapsedSeconds().toFixed(2)} s`;
        }, 30);
    }

    function finishGame() {
        playing = false;
        if (timerHandle) {
            window.clearInterval(timerHandle);
            timerHandle = null;
        }

        const total = elapsedSeconds();
        timeEl.textContent = `${total.toFixed(2)} s`;

        gameScreen.classList.add('hidden');
        resultScreen.classList.remove('hidden');

        finalTimeEl.textContent = `Cas: ${total.toFixed(2)} s`;
        finalErrorsEl.textContent = `Chyby: ${errors}`;
    }

    document.addEventListener('keydown', (event) => {
        if (!playing) {
            return;
        }

        const key = event.key.toUpperCase();
        if (!ALPHABET.includes(key)) {
            return;
        }

        const expected = ALPHABET[index];
        if (key === expected) {
            index += 1;
            updateHud();
            hintEl.textContent = 'Spravne!';

            if (index >= ALPHABET.length) {
                finishGame();
            }
            return;
        }

        errors += 1;
        errorsEl.textContent = String(errors);
        hintEl.textContent = `Ocakavane pismeno: ${expected}`;
    });

    startBtn.addEventListener('click', startGame);
    restartBtn.addEventListener('click', startGame);
</script>
</body>
</html>

