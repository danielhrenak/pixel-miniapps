<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Písmenkový Dážď</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Fredoka', sans-serif;
            overflow: hidden;
            background-color: #f0f9ff;
        }
        .letter {
            position: absolute;
            font-weight: bold;
            user-select: none;
            transition: transform 0.1s linear;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        .shake {
            animation: shake 0.2s ease-in-out 2;
        }
        @keyframes pop {
            0% { transform: scale(1); opacity: 1; }
            100% { transform: scale(2); opacity: 0; }
        }
        .pop-effect {
            position: absolute;
            pointer-events: none;
            animation: pop 0.5s ease-out forwards;
        }
    </style>
</head>
<body class="h-screen w-full flex items-center justify-center">
<!-- Start Screen -->
<div id="start-screen" class="z-50 text-center bg-white p-12 rounded-3xl shadow-2xl border-4 border-blue-400 max-w-md mx-4">
    <h1 class="text-5xl font-bold text-blue-600 mb-4">Písmenkový Dážď</h1>
    <p class="text-xl text-gray-600 mb-8">Chytaj padajúce písmenká na klávesnici!</p>
    <button onclick="startGame()" class="px-12 py-6 bg-blue-500 text-white rounded-full text-3xl font-bold shadow-xl hover:bg-blue-600 hover:scale-105 active:scale-95 transition-all">
        HRAŤ
    </button>
</div>

<!-- Game HUD -->
<div id="hud" class="hidden absolute top-4 left-0 right-0 px-8 flex justify-between items-center z-40 pointer-events-none">
    <div class="bg-white/90 backdrop-blur px-6 py-2 rounded-full shadow-lg flex items-center gap-6 border-2 border-blue-200">
        <div class="text-blue-600 font-bold text-2xl">⭐ <span id="score">0</span></div>
        <div class="text-red-500 font-bold text-2xl">❌ <span id="misses">0</span></div>
    </div>
    <div class="bg-white/90 backdrop-blur px-6 py-2 rounded-full shadow-lg border-2 border-blue-200 text-blue-600 font-bold text-2xl">
        ⏱️ <span id="timer">0.0</span>s
    </div>
</div>

<!-- Game Container -->
<div id="game-container" class="absolute inset-0 hidden"></div>

<!-- End Screen -->
<div id="end-screen" class="hidden z-50 text-center bg-white p-12 rounded-3xl shadow-2xl border-4 border-green-400 max-w-md mx-4">
    <div class="text-7xl mb-4">🏆</div>
    <h2 class="text-4xl font-bold text-gray-800 mb-2">Skvelá práca!</h2>
    <div class="space-y-4 my-8 text-2xl">
        <div class="flex justify-between border-b pb-2">
            <span class="text-gray-500">Písmenká:</span>
            <span id="final-score" class="font-bold text-blue-600">0 / 15</span>
        </div>
        <div class="flex justify-between border-b pb-2">
            <span class="text-gray-500">Chyby:</span>
            <span id="final-misses" class="font-bold text-red-500">0</span>
        </div>
    </div>
    <button onclick="startGame()" class="w-full py-4 bg-green-500 text-white rounded-full text-2xl font-bold shadow-lg hover:bg-green-600 hover:scale-105 active:scale-95 transition-all">
        ZNOVA
    </button>
</div>

<script>
    const ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const ROUND_COUNT = 15;
    const FALL_DURATION = 4000; // ms

    let gameState = 'start';
    let score = 0;
    let misses = 0;
    let spawnedCount = 0;
    let startTime = 0;
    let letters = [];
    let gameLoop;
    let lastSpawn = 0;

    const startScreen = document.getElementById('start-screen');
    const endScreen = document.getElementById('end-screen');
    const hud = document.getElementById('hud');
    const gameContainer = document.getElementById('game-container');
    const scoreEl = document.getElementById('score');
    const missesEl = document.getElementById('misses');
    const timerEl = document.getElementById('timer');

    function startGame() {
        gameState = 'playing';
        score = 0;
        misses = 0;
        spawnedCount = 0;
        letters = [];
        startTime = Date.now();
        lastSpawn = 0;

        startScreen.classList.add('hidden');
        endScreen.classList.add('hidden');
        hud.classList.remove('hidden');
        gameContainer.classList.remove('hidden');
        gameContainer.innerHTML = '';

        updateHUD();
        requestAnimationFrame(loop);
    }

    function updateHUD() {
        scoreEl.textContent = score;
        missesEl.textContent = misses;
    }

    function spawnLetter() {
        if (spawnedCount >= ROUND_COUNT) return;

        const char = ALPHABET[Math.floor(Math.random() * ALPHABET.length)];
        const x = Math.random() * 80 + 10;
        const id = Math.random().toString(36).substr(2, 9);

        const el = document.createElement('div');
        el.className = 'letter text-7xl';
        el.textContent = char;
        el.style.left = x + '%';
        el.style.top = '-100px';
        el.style.color = `hsl(${Math.random() * 360}, 70%, 50%)`;
        el.style.textShadow = '3px 3px 0px white';

        gameContainer.appendChild(el);

        letters.push({
            id,
            char,
            x,
            startTime: Date.now(),
            el
        });

        spawnedCount++;
    }

    function loop() {
        if (gameState !== 'playing') return;

        const now = Date.now();
        const elapsedTotal = (now - startTime) / 1000;
        timerEl.textContent = elapsedTotal.toFixed(1);

        // Spawning
        if (now - lastSpawn > 1500 && spawnedCount < ROUND_COUNT) {
            spawnLetter();
            lastSpawn = now;
        }

        // Updating positions
        for (let i = letters.length - 1; i >= 0; i--) {
            const l = letters[i];
            const elapsed = now - l.startTime;
            const progress = elapsed / FALL_DURATION;

            if (progress >= 1) {
                // Missed!
                misses++;
                updateHUD();
                l.el.remove();
                letters.splice(i, 1);
                document.body.classList.add('shake');
                setTimeout(() => document.body.classList.remove('shake'), 200);
            } else {
                l.el.style.top = (progress * 100) + 'vh';
            }
        }

        // End Check
        if (spawnedCount >= ROUND_COUNT && letters.length === 0) {
            endGame();
        } else {
            requestAnimationFrame(loop);
        }
    }

    function endGame() {
        gameState = 'end';
        hud.classList.add('hidden');
        gameContainer.classList.add('hidden');
        endScreen.classList.remove('hidden');
        document.getElementById('final-score').textContent = `${score} / ${ROUND_COUNT}`;
        document.getElementById('final-misses').textContent = misses;
    }

    window.addEventListener('keydown', (e) => {
        if (gameState !== 'playing') return;

        const key = e.key.toUpperCase();
        // Find the lowest letter matching the key
        let targetIndex = -1;
        let maxStartTime = -1;

        for (let i = 0; i < letters.length; i++) {
            if (letters[i].char === key && letters[i].startTime > maxStartTime) {
                maxStartTime = letters[i].startTime;
                targetIndex = i;
            }
        }

        if (targetIndex !== -1) {
            const l = letters[targetIndex];
            score++;
            updateHUD();

            // Pop effect
            const pop = document.createElement('div');
            pop.className = 'pop-effect text-6xl';
            pop.textContent = '⭐';
            pop.style.left = l.x + '%';
            pop.style.top = l.el.style.top;
            document.body.appendChild(pop);
            setTimeout(() => pop.remove(), 500);

            l.el.remove();
            letters.splice(targetIndex, 1);
        } else if (ALPHABET.includes(key)) {
            misses++;
            updateHUD();
            document.body.classList.add('shake');
            setTimeout(() => document.body.classList.remove('shake'), 200);
        }
    });
</script>
</body>
</html>

