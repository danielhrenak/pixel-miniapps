<section class="flex min-h-screen items-center justify-center px-4 py-10">
    <div class="w-full max-w-5xl rounded-3xl border border-slate-700 bg-slate-900/70 p-6 shadow-2xl backdrop-blur md:p-10">
        <div id="puzzle-screen" class="space-y-6">
            <h1 class="text-center text-3xl font-bold tracking-tight md:text-4xl">Scavenger - Stage Sudoku</h1>

            <div class="mx-auto max-w-2xl rounded-2xl border border-slate-700 bg-slate-950/70 p-4">
                <?= $this->Html->image('sudoku.png', ['alt' => 'Sudoku uloha', 'class' => 'mx-auto h-auto w-full max-w-xl object-contain']) ?>
            </div>

            <p class="text-center text-base text-slate-200 md:text-lg">Zadanie: napis cisla zo spodneho riadku (bez medzier).</p>

            <form id="answer-form" class="mx-auto flex w-full max-w-2xl flex-col gap-3 sm:flex-row">
                <label for="answer-input" class="sr-only">Odpoved</label>
                <input
                    id="answer-input"
                    type="text"
                    inputmode="numeric"
                    autocomplete="off"
                    spellcheck="false"
                    aria-label="Odpoved"
                    class="w-full rounded-xl border border-slate-600 bg-slate-950 px-4 py-3 text-center text-base tracking-[0.2em] text-slate-100 outline-none transition focus:border-sky-400"
                    placeholder="Zadaj 9 cisel"
                >
                <button
                    type="submit"
                    class="rounded-xl bg-sky-500 px-6 py-3 font-semibold text-slate-950 transition hover:bg-sky-400"
                >
                    Overit
                </button>
            </form>

            <div id="error-message" class="mx-auto hidden w-full max-w-2xl rounded-xl border border-red-500/60 bg-red-500/10 px-4 py-3 text-center text-sm font-medium text-red-200 shadow-lg" role="alert" aria-live="polite">
                <span class="inline-flex items-center gap-2">
                    <span aria-hidden="true">⚠️</span>
                    <span>Mylis sa, skus znovu.</span>
                </span>
            </div>
        </div>

        <div id="result-screen" class="hidden space-y-5">
            <p class="text-center text-lg font-semibold text-emerald-300">Správne! Tieto časti nájdeš tam, kde sa môžeš zahrať spoločenskú hru, ktorá má korene v medzivojnovom období, jej popularita sa výrazne rozšírila vďaka európskym emigrantom v Latinskej Amerike a USA, a jej skorú podobu dokumentuje patent z roku 1923 od Harold Searles Thornton.</p>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[980px] border-collapse text-center">
                    <thead>
                        <tr class="bg-slate-800/70 text-slate-100">
                            <th class="border border-slate-700 px-4 py-3">Pocet</th>
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
                            <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/79194.jpg" alt="Skupina 1 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                            <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/79194.jpg" alt="Skupina 2 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                            <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/79194.jpg" alt="Skupina 3 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                            <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/79194.jpg" alt="Skupina 4 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                            <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/79194.jpg" alt="Skupina 5 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                        </tr>
                        <tr>
                            <td class="border border-slate-700 px-4 py-3 font-semibold">1x</td>
                            <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/5/3069pb1360.jpg" alt="Skupina 1 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                            <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/71/3069pb1363.jpg" alt="Skupina 2 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                            <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/36/3069pb1361.jpg" alt="Skupina 3 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                            <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/3069pb1365.jpg" alt="Skupina 4 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                            <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/7/3069pb1364.jpg" alt="Skupina 5 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<script>
    (function () {
        const expected = '946827315';
        const HIDE_ERROR_DELAY_MS = 2800;
        const form = document.getElementById('answer-form');
        const input = document.getElementById('answer-input');
        const errorMessage = document.getElementById('error-message');
        const puzzleScreen = document.getElementById('puzzle-screen');
        const resultScreen = document.getElementById('result-screen');
        let hideErrorTimeout = null;

        if (!form || !input || !errorMessage || !puzzleScreen || !resultScreen) {
            return;
        }

        form.addEventListener('submit', function (event) {
            event.preventDefault();

            const value = input.value.replace(/\s+/g, '');

            if (value === expected) {
                if (hideErrorTimeout) {
                    clearTimeout(hideErrorTimeout);
                    hideErrorTimeout = null;
                }
                errorMessage.classList.add('hidden');
                puzzleScreen.classList.add('hidden');
                resultScreen.classList.remove('hidden');
                return;
            }

            errorMessage.classList.remove('hidden');
            if (hideErrorTimeout) {
                clearTimeout(hideErrorTimeout);
            }
            hideErrorTimeout = setTimeout(function () {
                errorMessage.classList.add('hidden');
                hideErrorTimeout = null;
            }, HIDE_ERROR_DELAY_MS);

            input.focus();
            input.select();
        });
    })();
</script>



