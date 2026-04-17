<section class="flex min-h-screen items-center justify-center px-4 py-10">
    <div class="w-full max-w-6xl rounded-3xl border border-slate-700 bg-slate-900/70 p-6 shadow-2xl backdrop-blur md:p-10">
        <div id="puzzle-screen" class="space-y-6">
            <div class="space-y-3 text-center text-xl leading-relaxed md:text-2xl">
                <p>☄️☄️ | 🌍🌍 | ☄️🌍🌍 | ☄️ | ☄️☄️☄️ | 🌍☄️☄️ | ☄️🌍</p>
                <p>🌍🌍🌍 | 🌍🌍🌍🌍 | ☄️☄️☄️ | 🌍☄️☄️🌍 | 🌍☄️☄️🌍 | 🌍🌍 | ☄️🌍 | ☄️☄️🌍</p>
                <p>☄️🌍☄️🌍 | 🌍 | ☄️🌍 | ☄️ | 🌍 | 🌍☄️🌍</p>
            </div>

            <form id="answer-form" class="mx-auto flex w-full max-w-2xl flex-col gap-3 sm:flex-row">
                <label for="answer-input" class="sr-only">Heslo</label>
                <input
                    id="answer-input"
                    type="text"
                    aria-label="Heslo"
                    autocomplete="off"
                    spellcheck="false"
                    class="w-full rounded-xl border border-slate-600 bg-slate-950 px-4 py-3 text-center text-base uppercase tracking-wide text-slate-100 outline-none transition focus:border-sky-400"
                    placeholder="Zadaj heslo"
                >
                <button
                    type="submit"
                    class="rounded-xl bg-sky-500 px-6 py-3 font-semibold text-slate-950 transition hover:bg-sky-400"
                >
                    Overiť
                </button>
            </form>

            <div id="error-message" class="mx-auto hidden w-full max-w-2xl rounded-xl border border-red-500/60 bg-red-500/10 px-4 py-3 text-center text-sm font-medium text-red-200 shadow-lg transition-opacity duration-300" role="alert" aria-live="polite">
                <span class="inline-flex items-center gap-2">
                    <span aria-hidden="true">⚠️</span>
                    <span>Mylis sa, skus znovu.</span>
                </span>
            </div>
        </div>

        <div id="result-screen" class="hidden space-y-5">
            <p class="text-center text-lg font-semibold text-emerald-300">Správne! Tam kde nájdeš MIDTOWN SHOPPING CENTER, nájdeš aj tieto dieliky</p>

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
                            <td class="border border-slate-700 px-4 py-3 font-semibold">4x</td>
                            <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/ItemImage/PN/1/3749.png" alt="Skupina 1 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                            <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/ItemImage/PN/1/3749.png" alt="Skupina 2 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                            <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/ItemImage/PN/1/3749.png" alt="Skupina 3 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                            <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/ItemImage/PN/1/3749.png" alt="Skupina 4 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                            <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/ItemImage/PN/1/3749.png" alt="Skupina 5 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                        </tr>
                        <tr>
                            <td class="border border-slate-700 px-4 py-3 font-semibold">4x</td>
                            <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/ItemImage/PN/5/6683pb01.png" alt="Skupina 1 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                            <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/71/6683pb01.jpg" alt="Skupina 2 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                            <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/36/6683pb01.jpg" alt="Skupina 3 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                            <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/1/6683pb01.jpg" alt="Skupina 4 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                            <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/47/6683pb01.jpg" alt="Skupina 5 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<script>
    (function () {
        const expected = 'MIDTOWN SHOPPING CENTER';
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

            const value = input.value.trim();
            const normalizedValue = value.toUpperCase();

            if (normalizedValue === expected) {
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

