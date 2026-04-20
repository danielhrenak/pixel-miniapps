<section class="flex min-h-screen items-center justify-center px-4 py-8">
    <div class="w-full max-w-6xl rounded-3xl border border-slate-700 bg-slate-900/70 p-5 shadow-2xl backdrop-blur md:p-8">
        <div id="quiz-screen" class="space-y-6">
            <h1 class="text-center text-3xl font-bold tracking-tight md:text-4xl">Scavenger - Stage Pocitanie</h1>

            <div class="mx-auto max-w-3xl rounded-2xl border border-slate-700 bg-slate-950/60 p-5 text-center">
                <p id="question-progress" class="mb-2 text-sm text-slate-400">Otazka 1/6</p>
                <p id="question-text" class="text-lg font-semibold text-slate-100 md:text-xl"></p>
            </div>

            <form id="answer-form" class="mx-auto flex w-full max-w-2xl flex-col gap-3 sm:flex-row">
                <label for="answer-input" class="sr-only">Odpoved</label>
                <input
                    id="answer-input"
                    type="text"
                    autocomplete="off"
                    spellcheck="false"
                    aria-label="Odpoved"
                    class="w-full rounded-xl border border-slate-600 bg-slate-950 px-4 py-3 text-center text-base text-slate-100 outline-none transition focus:border-sky-400"
                    placeholder="Zadaj odpoved"
                >
                <button
                    type="submit"
                    class="rounded-xl bg-sky-500 px-6 py-3 font-semibold text-slate-950 transition hover:bg-sky-400"
                >
                    Potvrdit
                </button>
            </form>

            <p id="success-message" class="hidden text-center text-sm font-semibold text-emerald-300">Spravne! Pokracujeme dalej.</p>

            <div id="error-message" class="mx-auto hidden w-full max-w-2xl rounded-xl border border-red-500/60 bg-red-500/10 px-4 py-3 text-center text-sm font-medium text-red-200 shadow-lg" role="alert" aria-live="polite">
                <span class="inline-flex items-center gap-2">
                    <span aria-hidden="true">⚠️</span>
                    <span>Nespravna odpoved, skus znova.</span>
                </span>
            </div>
        </div>

        <div id="result-screen" class="hidden space-y-5">
            <p class="text-center text-lg font-semibold text-emerald-300">Hľadaj tieto časti. A kde? Nech ti je nápovedou obrázok</p>
            <div class="mx-auto max-w-2xl rounded-2xl border border-slate-700 bg-slate-950/60 p-4">
                <?= $this->Html->image('nerf.png', ['alt' => 'Nápoveda - Nerf', 'class' => 'mx-auto h-auto w-full max-w-xl object-contain']) ?>
            </div>
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
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/6667.jpg" alt="Skupina 1 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/6667.jpg" alt="Skupina 2 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/6667.jpg" alt="Skupina 3 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/6667.jpg" alt="Skupina 4 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/6667.jpg" alt="Skupina 5 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                    </tr>
                    <tr>
                        <td class="border border-slate-700 px-4 py-3 font-semibold">1x</td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/5/6682.jpg" alt="Skupina 1 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/71/6682.jpg" alt="Skupina 2 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/36/6682.jpg" alt="Skupina 3 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/6682.jpg" alt="Skupina 4 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/6682.jpg" alt="Skupina 5 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<script>
    (function () {
        const SUCCESS_HIDE_MS = 1400;
        const ERROR_HIDE_MS = 2800;

        const questions = [
            {
                text: 'Kolko biomov mame na PAPO vytlacenych na plagatikoch?',
                answer: '14'
            },
            {
                text: 'Kontrolna otazka 2: Kolko skupin je v tejto hre?',
                answer: '5'
            },
            {
                text: 'Kontrolna otazka 3: Kolko domov ma Einsteinova uloha?',
                answer: '5'
            },
            {
                text: 'Kontrolna otazka 4: Kolko otazok ma tato etapa celkovo?',
                answer: '6'
            },
            {
                text: 'Kontrolna otazka 5: Kolko dielikov je v prvom riadku odmeny?',
                answer: '1'
            },
            {
                text: 'Kontrolna otazka 6: Zopakuj odpoved z prvej otazky.',
                answer: '14'
            }
        ];

        const quizScreen = document.getElementById('quiz-screen');
        const resultScreen = document.getElementById('result-screen');
        const questionProgress = document.getElementById('question-progress');
        const questionText = document.getElementById('question-text');
        const answerForm = document.getElementById('answer-form');
        const answerInput = document.getElementById('answer-input');
        const errorMessage = document.getElementById('error-message');
        const successMessage = document.getElementById('success-message');

        let currentStep = 0;
        let errorTimeout = null;
        let successTimeout = null;

        if (!quizScreen || !resultScreen || !questionProgress || !questionText || !answerForm || !answerInput || !errorMessage || !successMessage) {
            return;
        }

        function normalize(value) {
            return String(value).trim().toLowerCase();
        }

        function renderQuestion() {
            const total = questions.length;
            const item = questions[currentStep];
            questionProgress.textContent = 'Otazka ' + (currentStep + 1) + '/' + total;
            questionText.textContent = item.text;
            answerInput.value = '';
            answerInput.focus();
        }

        function showError() {
            errorMessage.classList.remove('hidden');
            if (errorTimeout) {
                clearTimeout(errorTimeout);
            }
            errorTimeout = setTimeout(function () {
                errorMessage.classList.add('hidden');
                errorTimeout = null;
            }, ERROR_HIDE_MS);
        }

        function showSuccessStep() {
            successMessage.classList.remove('hidden');
            if (successTimeout) {
                clearTimeout(successTimeout);
            }
            successTimeout = setTimeout(function () {
                successMessage.classList.add('hidden');
                successTimeout = null;
            }, SUCCESS_HIDE_MS);
        }

        answerForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const item = questions[currentStep];
            const provided = normalize(answerInput.value);
            const expected = normalize(item.answer);

            if (provided !== expected) {
                showError();
                answerInput.focus();
                answerInput.select();
                return;
            }

            errorMessage.classList.add('hidden');

            if (currentStep === questions.length - 1) {
                quizScreen.classList.add('hidden');
                resultScreen.classList.remove('hidden');
                return;
            }

            currentStep += 1;
            showSuccessStep();
            renderQuestion();
        });

        renderQuestion();
    })();
</script>

