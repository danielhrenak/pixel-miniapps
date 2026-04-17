<section class="flex min-h-screen items-center justify-center px-4 py-8">
    <div class="w-full max-w-5xl rounded-3xl border border-slate-700 bg-slate-900/70 p-5 shadow-2xl backdrop-blur md:p-8">
        <div id="game-screen" class="space-y-6">
            <h1 class="text-center text-3xl font-bold tracking-tight md:text-4xl">Scavenger - Stage Timebomb</h1>
            <p class="text-center text-slate-300">Stlač <strong>Spustiť</strong>, v hlave odhadni 10 sekúnd a potom stlač <strong>Stop</strong>. Nepoužívaj hodiny.</p>
            <p id="solve-hint" class="hidden rounded-xl border border-emerald-500/40 bg-emerald-500/10 px-4 py-3 text-center text-sm text-emerald-200">
                Režim <code>?vyries=1</code> je aktívny – tolerancia je zvýšená na 5 sekund.
            </p>

            <div class="mx-auto max-w-2xl rounded-3xl border border-slate-700 bg-slate-950/70 p-6 text-center">
                <div id="pulse-indicator" class="mx-auto mb-6 flex h-28 w-28 items-center justify-center rounded-full border-4 border-sky-400/40 bg-sky-500/10 text-2xl font-bold text-sky-200 transition-all duration-300">
                    READY
                </div>

                <p id="game-status" class="mb-4 text-lg font-semibold text-slate-100">Pripravený na odhad 10 sekúnd.</p>
                <p id="game-substatus" class="mb-6 text-sm text-slate-400">Čas sa počas hry nikde nezobrazuje.</p>

                <div class="flex flex-col items-center justify-center gap-3 sm:flex-row">
                    <button id="start-btn" type="button" class="w-full rounded-2xl bg-emerald-500 px-6 py-4 text-lg font-bold text-slate-950 transition hover:bg-emerald-400 sm:w-auto">
                        Spustiť
                    </button>
                    <button id="stop-btn" type="button" class="hidden w-full rounded-2xl bg-rose-500 px-6 py-4 text-lg font-bold text-white transition hover:bg-rose-400 sm:w-auto" disabled>
                        Stop
                    </button>
                    <button id="retry-btn" type="button" class="hidden w-full rounded-2xl bg-sky-500 px-6 py-4 text-lg font-bold text-slate-950 transition hover:bg-sky-400 sm:w-auto">
                        Skúsiť znovu
                    </button>
                </div>
            </div>

            <div id="result-panel" class="hidden mx-auto max-w-2xl rounded-2xl border border-slate-700 bg-slate-950/70 p-5 text-center">
                <p class="text-sm uppercase tracking-[0.25em] text-slate-400">Tvoj čas</p>
                <p id="final-time" class="mt-2 text-5xl font-black text-slate-100">0.00 s</p>
                <p id="difference-text" class="mt-3 text-slate-300"></p>
                <p id="fail-message" class="mt-4 hidden rounded-xl border border-red-500/50 bg-red-500/10 px-4 py-3 text-red-200"></p>
            </div>
        </div>

        <div id="reward-screen" class="hidden space-y-5">
            <p class="text-center text-lg font-semibold text-emerald-300">Správne! Tieto dieliky hľadaj na mieste, ktoré je odpoveďou na otázku:</p>
            <p class="mx-auto max-w-4xl text-center text-slate-200">Ako sa nazýva pojem, ktorý sa začal používať už v 19. storočí v biológii a neskôr sa rozšíril aj do techniky, genetiky a kultúry, pričom označuje niečo, čo vzniklo spojením dvoch odlišných prvkov?</p>
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
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/5/20482.jpg" alt="Skupina 1 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/89/20482.jpg" alt="Skupina 2 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/20482.jpg" alt="Skupina 3 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/7/20482.jpg" alt="Skupina 4 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/20482.jpg" alt="Skupina 5 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                    </tr>
                    <tr>
                        <td class="border border-slate-700 px-4 py-3 font-semibold">1x</td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/5/7052.jpg" alt="Skupina 1 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/89/7052.jpg" alt="Skupina 2 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/7052.jpg" alt="Skupina 3 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/63/7052.jpg" alt="Skupina 4 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/7052.jpg" alt="Skupina 5 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<script>
    (function () {
        const TARGET_SECONDS = 10;
        const searchParams = new URLSearchParams(window.location.search);
        const isSolveMode = searchParams.get('vyries') === '1';
        const toleranceSeconds = isSolveMode ? 5 : 0.4;

        const gameScreen = document.getElementById('game-screen');
        const rewardScreen = document.getElementById('reward-screen');
        const solveHint = document.getElementById('solve-hint');
        const pulseIndicator = document.getElementById('pulse-indicator');
        const gameStatus = document.getElementById('game-status');
        const gameSubstatus = document.getElementById('game-substatus');
        const startBtn = document.getElementById('start-btn');
        const stopBtn = document.getElementById('stop-btn');
        const retryBtn = document.getElementById('retry-btn');
        const resultPanel = document.getElementById('result-panel');
        const finalTime = document.getElementById('final-time');
        const differenceText = document.getElementById('difference-text');
        const failMessage = document.getElementById('fail-message');

        let startedAt = null;
        let isRunning = false;

        if (!gameScreen || !rewardScreen || !pulseIndicator || !gameStatus || !gameSubstatus || !startBtn || !stopBtn || !retryBtn || !resultPanel || !finalTime || !differenceText || !failMessage) {
            return;
        }

        function formatSeconds(value) {
            return value.toFixed(2);
        }

        function resetGame() {
            startedAt = null;
            isRunning = false;
            startBtn.disabled = false;
            startBtn.classList.remove('hidden');
            stopBtn.disabled = true;
            stopBtn.classList.add('hidden');
            retryBtn.classList.add('hidden');
            resultPanel.classList.add('hidden');
            failMessage.classList.add('hidden');
            pulseIndicator.textContent = 'READY';
            pulseIndicator.className = 'mx-auto mb-6 flex h-28 w-28 items-center justify-center rounded-full border-4 border-sky-400/40 bg-sky-500/10 text-2xl font-bold text-sky-200 transition-all duration-300';
            gameStatus.textContent = 'Pripravený na odhad 10 sekúnd.';
            gameSubstatus.textContent = 'Čas sa počas hry nikde nezobrazuje.';
            finalTime.textContent = '0.00 s';
            differenceText.textContent = '';
        }

        function beginGame() {
            startedAt = performance.now();
            isRunning = true;
            startBtn.disabled = true;
            startBtn.classList.add('hidden');
            stopBtn.disabled = false;
            stopBtn.classList.remove('hidden');
            retryBtn.classList.add('hidden');
            resultPanel.classList.add('hidden');
            failMessage.classList.add('hidden');
            pulseIndicator.textContent = '...';
            pulseIndicator.className = 'mx-auto mb-6 flex h-28 w-28 animate-pulse items-center justify-center rounded-full border-4 border-amber-400/60 bg-amber-500/10 text-4xl font-black text-amber-200 transition-all duration-300';
            gameStatus.textContent = 'Čas beží. Zastav ho čo najbližšie k 10 sekundám.';
            gameSubstatus.textContent = 'Nepočítadlo sa nikde nezobrazuje – musíš sa spoľahnúť na odhad.';
        }

        function winGame(elapsedSeconds) {
            finalTime.textContent = formatSeconds(elapsedSeconds) + ' s';
            differenceText.textContent = 'Odchýlka od cieľa: ' + formatSeconds(Math.abs(elapsedSeconds - TARGET_SECONDS)) + ' s';
            gameScreen.classList.add('hidden');
            rewardScreen.classList.remove('hidden');
        }

        function stopGame() {
            if (!isRunning || startedAt === null) {
                return;
            }

            isRunning = false;
            stopBtn.disabled = true;
            stopBtn.classList.add('hidden');
            startBtn.disabled = false;
            startBtn.classList.remove('hidden');
            retryBtn.classList.remove('hidden');

            const elapsedSeconds = (performance.now() - startedAt) / 1000;
            const difference = Math.abs(elapsedSeconds - TARGET_SECONDS);

            resultPanel.classList.remove('hidden');
            finalTime.textContent = formatSeconds(elapsedSeconds) + ' s';
            differenceText.textContent = 'Odchýlka od cieľa: ' + formatSeconds(difference) + ' s';

            if (difference <= toleranceSeconds) {
                pulseIndicator.textContent = 'OK';
                pulseIndicator.className = 'mx-auto mb-6 flex h-28 w-28 items-center justify-center rounded-full border-4 border-emerald-400/60 bg-emerald-500/10 text-3xl font-black text-emerald-200 transition-all duration-300';
                gameStatus.textContent = 'Perfektné načasovanie!';
                gameSubstatus.textContent = 'Zvládol si to v tolerancii ' + formatSeconds(toleranceSeconds) + ' s.';
                failMessage.classList.add('hidden');
                winGame(elapsedSeconds);
                return;
            }

            pulseIndicator.textContent = 'TRY';
            pulseIndicator.className = 'mx-auto mb-6 flex h-28 w-28 items-center justify-center rounded-full border-4 border-rose-400/60 bg-rose-500/10 text-3xl font-black text-rose-200 transition-all duration-300';
            gameStatus.textContent = 'Tesne vedľa – skús to znovu.';
            gameSubstatus.textContent = 'Musíš sa zmestiť do tolerancie ' + formatSeconds(toleranceSeconds) + ' s.';
            failMessage.textContent = 'Tentoraz to nevyšlo. Potrebuješ byť bližšie k 10.00 sekundám.';
            failMessage.classList.remove('hidden');
        }

        startBtn.addEventListener('click', beginGame);
        stopBtn.addEventListener('click', stopGame);
        retryBtn.addEventListener('click', resetGame);

        if (solveHint && isSolveMode) {
            solveHint.classList.remove('hidden');
        }

        resetGame();
    })();
</script>

