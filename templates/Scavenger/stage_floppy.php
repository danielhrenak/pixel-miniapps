<section class="flex min-h-screen items-center justify-center px-4 py-8">
    <div class="w-full max-w-6xl rounded-3xl border border-slate-700 bg-slate-900/70 p-5 shadow-2xl backdrop-blur md:p-8">
        <div id="game-screen" class="space-y-5">
            <h1 class="text-center text-3xl font-bold tracking-tight md:text-4xl">Scavenger - Stage Floppy</h1>
            <p class="text-center text-slate-300">Tapni / klikni / stlac medzernik pre skok. Ciel: prejdi 10 prekazok.</p>

            <div class="mx-auto w-full max-w-3xl overflow-hidden rounded-2xl border border-slate-700 bg-slate-950/80 p-2">
                <canvas id="floppy-canvas" class="mx-auto block w-full touch-none" width="720" height="420" aria-label="Floppy Bird hra"></canvas>
            </div>

            <div class="flex items-center justify-center gap-4 text-sm md:text-base">
                <span class="rounded-lg border border-slate-600 bg-slate-800/80 px-3 py-1 text-slate-200">Skore: <strong id="score">0</strong> / 10</span>
                <span id="status" class="text-slate-300">Klikni alebo tapni pre start</span>
            </div>

            <div class="flex justify-center">
                <button id="restart-btn" type="button" class="hidden rounded-xl bg-sky-500 px-5 py-2 font-semibold text-slate-950 transition hover:bg-sky-400">Hrat znovu</button>
            </div>
        </div>

        <div id="result-screen" class="hidden space-y-5">
            <p class="text-center text-lg font-semibold text-emerald-300">Spravne. Hladaj toto Lego v Legu.</p>
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
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/5/61252.jpg" alt="Skupina 1 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/89/61252.jpg" alt="Skupina 2 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/36/61252.jpg" alt="Skupina 3 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/7/61252.jpg" alt="Skupina 4 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/11/61252.jpg" alt="Skupina 5 - item 1" class="mx-auto h-20 w-20 object-contain"></td>
                    </tr>
                    <tr>
                        <td class="border border-slate-700 px-4 py-3 font-semibold">1x</td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/5/11477pb203.jpg" alt="Skupina 1 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/89/11477pb210.jpg" alt="Skupina 2 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/36/11477pb205.jpg" alt="Skupina 3 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/7/11477pb214.jpg" alt="Skupina 4 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                        <td class="border border-slate-700 px-4 py-3"><img src="https://img.bricklink.com/P/7/11477pb212.jpg" alt="Skupina 5 - item 2" class="mx-auto h-20 w-20 object-contain"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<script>
    (function () {
        const GOAL = 10;
        const GRAVITY = 0.35;
        const JUMP = -6.4;
        const PIPE_SPEED = 2.4;
        const PIPE_WIDTH = 62;
        const PIPE_GAP = 140;
        const PIPE_SPAWN_MS = 1400;

        const gameScreen = document.getElementById('game-screen');
        const resultScreen = document.getElementById('result-screen');
        const canvas = document.getElementById('floppy-canvas');
        const scoreEl = document.getElementById('score');
        const statusEl = document.getElementById('status');
        const restartBtn = document.getElementById('restart-btn');

        if (!gameScreen || !resultScreen || !canvas || !scoreEl || !statusEl || !restartBtn) {
            return;
        }

        const ctx = canvas.getContext('2d');
        if (!ctx) {
            return;
        }

        let animationId = null;
        let running = false;
        let gameOver = false;
        let won = false;
        let score = 0;
        let lastSpawn = 0;

        const bird = {
            x: 120,
            y: canvas.height / 2,
            radius: 14,
            vy: 0,
        };

        const pipes = [];

        function resetGameState() {
            running = false;
            gameOver = false;
            won = false;
            score = 0;
            lastSpawn = 0;
            pipes.length = 0;
            bird.y = canvas.height / 2;
            bird.vy = 0;
            scoreEl.textContent = '0';
            statusEl.textContent = 'Klikni alebo tapni pre start';
            restartBtn.classList.add('hidden');
            draw();
        }

        function resizeCanvasForDisplay() {
            const ratio = 720 / 420;
            const displayWidth = Math.min(canvas.parentElement.clientWidth - 8, 720);
            canvas.style.height = (displayWidth / ratio) + 'px';
        }

        function spawnPipe(now) {
            const minTop = 50;
            const maxTop = canvas.height - PIPE_GAP - 50;
            const topHeight = Math.floor(Math.random() * (maxTop - minTop + 1)) + minTop;
            pipes.push({
                x: canvas.width,
                top: topHeight,
                passed: false,
            });
            lastSpawn = now;
        }

        function jump() {
            if (won) {
                return;
            }
            if (!running && !gameOver) {
                running = true;
                statusEl.textContent = 'Leť!';
            }
            if (gameOver) {
                return;
            }
            bird.vy = JUMP;
        }

        function rectCircleCollide(rx, ry, rw, rh, cx, cy, cr) {
            const testX = Math.max(rx, Math.min(cx, rx + rw));
            const testY = Math.max(ry, Math.min(cy, ry + rh));
            const dx = cx - testX;
            const dy = cy - testY;
            return (dx * dx + dy * dy) <= cr * cr;
        }

        function update(now) {
            if (!running || gameOver || won) {
                return;
            }

            bird.vy += GRAVITY;
            bird.y += bird.vy;

            if (now - lastSpawn >= PIPE_SPAWN_MS) {
                spawnPipe(now);
            }

            for (let i = pipes.length - 1; i >= 0; i--) {
                const p = pipes[i];
                p.x -= PIPE_SPEED;

                const bottomY = p.top + PIPE_GAP;
                const hitTop = rectCircleCollide(p.x, 0, PIPE_WIDTH, p.top, bird.x, bird.y, bird.radius);
                const hitBottom = rectCircleCollide(p.x, bottomY, PIPE_WIDTH, canvas.height - bottomY, bird.x, bird.y, bird.radius);

                if (hitTop || hitBottom) {
                    gameOver = true;
                }

                if (!p.passed && p.x + PIPE_WIDTH < bird.x) {
                    p.passed = true;
                    score += 1;
                    scoreEl.textContent = String(score);

                    if (score >= GOAL) {
                        won = true;
                        running = false;
                        revealResult();
                        return;
                    }
                }

                if (p.x + PIPE_WIDTH < 0) {
                    pipes.splice(i, 1);
                }
            }

            if (bird.y - bird.radius <= 0 || bird.y + bird.radius >= canvas.height) {
                gameOver = true;
            }

            if (gameOver) {
                running = false;
                statusEl.textContent = 'Koniec hry - klikni na Hrat znovu';
                restartBtn.classList.remove('hidden');
            }
        }

        function drawBackground() {
            ctx.fillStyle = '#0b1220';
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            ctx.fillStyle = '#111827';
            for (let i = 0; i < canvas.width; i += 40) {
                ctx.fillRect(i, canvas.height - 28, 20, 28);
            }
        }

        function drawPipes() {
            ctx.fillStyle = '#22c55e';
            pipes.forEach(function (p) {
                ctx.fillRect(p.x, 0, PIPE_WIDTH, p.top);
                ctx.fillRect(p.x, p.top + PIPE_GAP, PIPE_WIDTH, canvas.height - (p.top + PIPE_GAP));
            });
        }

        function drawBird() {
            ctx.beginPath();
            ctx.fillStyle = '#f59e0b';
            ctx.arc(bird.x, bird.y, bird.radius, 0, Math.PI * 2);
            ctx.fill();
            ctx.closePath();

            ctx.beginPath();
            ctx.fillStyle = '#111827';
            ctx.arc(bird.x + 4, bird.y - 4, 2, 0, Math.PI * 2);
            ctx.fill();
            ctx.closePath();
        }

        function drawOverlay() {
            if (!running && !gameOver && !won) {
                ctx.fillStyle = 'rgba(0,0,0,0.35)';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                ctx.fillStyle = '#e2e8f0';
                ctx.font = 'bold 28px sans-serif';
                ctx.textAlign = 'center';
                ctx.fillText('Tapni pre start', canvas.width / 2, canvas.height / 2);
            }

            if (gameOver) {
                ctx.fillStyle = 'rgba(0,0,0,0.45)';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                ctx.fillStyle = '#fecaca';
                ctx.font = 'bold 30px sans-serif';
                ctx.textAlign = 'center';
                ctx.fillText('Koniec hry', canvas.width / 2, canvas.height / 2 - 10);
            }
        }

        function draw() {
            drawBackground();
            drawPipes();
            drawBird();
            drawOverlay();
        }

        function loop(now) {
            update(now);
            draw();
            animationId = window.requestAnimationFrame(loop);
        }

        function revealResult() {
            if (animationId) {
                window.cancelAnimationFrame(animationId);
                animationId = null;
            }
            gameScreen.classList.add('hidden');
            resultScreen.classList.remove('hidden');
        }

        function bindControls() {
            canvas.addEventListener('pointerdown', function (event) {
                event.preventDefault();
                jump();
            });

            window.addEventListener('keydown', function (event) {
                if (event.code === 'Space') {
                    event.preventDefault();
                    jump();
                }
            });

            restartBtn.addEventListener('click', function () {
                resetGameState();
            });
        }

        window.addEventListener('resize', resizeCanvasForDisplay);
        bindControls();
        resizeCanvasForDisplay();
        resetGameState();
        animationId = window.requestAnimationFrame(loop);
    })();
</script>

