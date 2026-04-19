<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pismenkova zahrada</title>
    <style>
        :root {
            --sky-top: #78c8ff;
            --sky-bottom: #c9f3ff;
            --grass-top: #68ca4f;
            --grass-bottom: #3d9f32;
            --sun: #ffd74d;
            --letter-color: #ff4f7b;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            overflow: hidden;
            background: #c9f3ff;
        }

        .scene {
            position: relative;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, var(--sky-top), var(--sky-bottom));
            transition: background 1s ease;
        }

        .sun {
            position: absolute;
            top: 30px;
            right: 40px;
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: var(--sun);
            box-shadow: 0 0 25px rgba(255, 220, 90, 0.8);
            animation: floatSlow 6s ease-in-out infinite;
        }

        .cloud {
            position: absolute;
            width: 140px;
            height: 46px;
            border-radius: 40px;
            background: rgba(255, 255, 255, 0.9);
            filter: blur(0.2px);
            animation: cloudMove 28s linear infinite;
        }

        .cloud::before,
        .cloud::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.9);
        }

        .cloud::before {
            width: 54px;
            height: 54px;
            left: 18px;
            top: -20px;
        }

        .cloud::after {
            width: 58px;
            height: 58px;
            right: 24px;
            top: -24px;
        }

        .cloud.one {
            top: 56px;
            left: -180px;
        }

        .cloud.two {
            top: 120px;
            left: -320px;
            animation-duration: 35s;
            animation-delay: -8s;
            transform: scale(0.85);
        }

        .ground {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 36%;
            background: linear-gradient(to bottom, var(--grass-top), var(--grass-bottom));
            border-top: 4px solid rgba(255, 255, 255, 0.2);
        }

        .hud {
            position: absolute;
            left: 14px;
            right: 14px;
            top: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 8px;
            z-index: 5;
        }

        .pill {
            padding: 9px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid rgba(10, 70, 120, 0.2);
            font-weight: 700;
            color: #17436f;
            font-size: 14px;
        }

        .center {
            position: absolute;
            inset: 0;
            display: grid;
            place-items: center;
            pointer-events: none;
        }

        .letter-wrap {
            text-align: center;
            margin-top: -40px;
        }

        .letter {
            margin: 0;
            line-height: 1;
            font-size: min(32vw, 250px);
            font-weight: 900;
            color: var(--letter-color);
            text-shadow: 0 8px 0 rgba(255, 255, 255, 0.55), 0 14px 30px rgba(0, 0, 0, 0.2);
            transform: scale(1);
        }

        .letter.pop {
            animation: letterPop 0.36s ease;
        }

        .word {
            margin-top: 8px;
            font-size: min(5vw, 34px);
            font-weight: 800;
            color: #ffffff;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.35);
        }

        .object-zone {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 17%;
            display: flex;
            justify-content: center;
            pointer-events: none;
        }

        .object {
            min-width: 180px;
            max-width: 280px;
            min-height: 130px;
            border-radius: 24px;
            border: 3px solid rgba(255, 255, 255, 0.65);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.2);
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 10px;
            text-align: center;
            transform: translateY(70px) scale(0.65);
            opacity: 0;
        }

        .object.show {
            animation: objectGrow 0.45s ease forwards, objectBob 2.2s ease-in-out 0.45s infinite;
        }

        .object-shape {
            width: 74px;
            height: 74px;
            border-radius: 50%;
            border: 4px solid rgba(255, 255, 255, 0.75);
            background: rgba(255, 255, 255, 0.22);
        }

        .object-name {
            margin-top: 10px;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .message {
            position: absolute;
            left: 50%;
            top: 22%;
            transform: translateX(-50%);
            padding: 9px 16px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.9);
            color: #0b4f7a;
            font-weight: 800;
            font-size: 20px;
            min-width: 220px;
            text-align: center;
            z-index: 6;
        }

        .message.flash {
            animation: messageFlash 0.4s ease;
        }

        .confetti {
            position: absolute;
            width: 12px;
            height: 18px;
            top: -30px;
            opacity: 0;
            border-radius: 2px;
            z-index: 7;
        }

        .confetti.drop {
            animation: confettiDrop 1.8s ease-in forwards;
        }

        .help {
            position: absolute;
            left: 50%;
            bottom: 10px;
            transform: translateX(-50%);
            width: min(700px, calc(100% - 24px));
            text-align: center;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.95);
            background: rgba(16, 72, 32, 0.28);
            border: 2px solid rgba(255, 255, 255, 0.35);
            border-radius: 14px;
            padding: 8px 10px;
            z-index: 5;
        }

        @keyframes letterPop {
            0% { transform: scale(0.7); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }

        @keyframes objectGrow {
            0% { transform: translateY(70px) scale(0.65); opacity: 0; }
            100% { transform: translateY(0) scale(1); opacity: 1; }
        }

        @keyframes objectBob {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-8px) scale(1.02); }
        }

        @keyframes floatSlow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(7px); }
        }

        @keyframes cloudMove {
            0% { transform: translateX(0); }
            100% { transform: translateX(calc(100vw + 450px)); }
        }

        @keyframes messageFlash {
            0% { transform: translateX(-50%) scale(0.9); }
            100% { transform: translateX(-50%) scale(1); }
        }

        @keyframes confettiDrop {
            0% { transform: translateY(0) rotate(0deg); opacity: 1; }
            100% { transform: translateY(110vh) rotate(540deg); opacity: 0; }
        }
    </style>
</head>
<body>
<div id="scene" class="scene">
    <div class="sun"></div>
    <div class="cloud one"></div>
    <div class="cloud two"></div>

    <div class="hud">
        <div id="star-pill" class="pill">Hviezdicky: 0 / 5</div>
        <div id="theme-pill" class="pill">Tema: Den</div>
    </div>

    <div id="message" class="message">Stlac lubovolne pismeno</div>

    <div class="center">
        <div class="letter-wrap">
            <p id="letter" class="letter">A</p>
            <div id="word" class="word">A ako auto</div>
        </div>
    </div>

    <div class="object-zone">
        <div id="object" class="object">
            <div id="object-shape" class="object-shape"></div>
            <div id="object-name" class="object-name">AUTO</div>
        </div>
    </div>

    <div class="ground"></div>

    <div class="help">Iba klavesnica: pismena A-Z. Ostatne klavesy sa ignoruju.</div>
</div>

<script>
    const associations = {
        A: { word: 'auto', color: '#ff6b6b' },
        B: { word: 'balon', color: '#ff9f43' },
        C: { word: 'citrus', color: '#feca57' },
        D: { word: 'dom', color: '#48dbfb' },
        E: { word: 'elf', color: '#1dd1a1' },
        F: { word: 'fialka', color: '#5f27cd' },
        G: { word: 'gitara', color: '#54a0ff' },
        H: { word: 'hviezda', color: '#ff9ff3' },
        I: { word: 'ihla', color: '#00d2d3' },
        J: { word: 'jablko', color: '#ee5253' },
        K: { word: 'kocka', color: '#10ac84' },
        L: { word: 'lod', color: '#2e86de' },
        M: { word: 'macka', color: '#ff6b81' },
        N: { word: 'noc', color: '#576574' },
        O: { word: 'okno', color: '#f368e0' },
        P: { word: 'pes', color: '#ff9f43' },
        Q: { word: 'quinoa', color: '#1dd1a1' },
        R: { word: 'ruza', color: '#ee5253' },
        S: { word: 'strom', color: '#2ecc71' },
        T: { word: 'trava', color: '#27ae60' },
        U: { word: 'ulik', color: '#feca57' },
        V: { word: 'vlak', color: '#54a0ff' },
        W: { word: 'wifi', color: '#8395a7' },
        X: { word: 'xylafon', color: '#5f27cd' },
        Y: { word: 'yeti', color: '#48dbfb' },
        Z: { word: 'zaba', color: '#10ac84' }
    };

    const praises = ['Vyborne!', 'Super!', 'Skus dalsie pismeno!', 'Parada!', 'Skvela praca!'];
    const themes = [
        {
            name: 'Den',
            skyTop: '#78c8ff',
            skyBottom: '#c9f3ff',
            grassTop: '#68ca4f',
            grassBottom: '#3d9f32',
            sun: '#ffd74d'
        },
        {
            name: 'Vecer',
            skyTop: '#ff9d6c',
            skyBottom: '#ffe0b0',
            grassTop: '#57b95a',
            grassBottom: '#2f8a45',
            sun: '#ffb14a'
        },
        {
            name: 'Noc',
            skyTop: '#273c75',
            skyBottom: '#3c6382',
            grassTop: '#3a8b52',
            grassBottom: '#245a35',
            sun: '#d7d7ff'
        }
    ];

    const scene = document.getElementById('scene');
    const letterEl = document.getElementById('letter');
    const wordEl = document.getElementById('word');
    const objectEl = document.getElementById('object');
    const objectShapeEl = document.getElementById('object-shape');
    const objectNameEl = document.getElementById('object-name');
    const messageEl = document.getElementById('message');
    const starPillEl = document.getElementById('star-pill');
    const themePillEl = document.getElementById('theme-pill');

    let starCount = 0;
    let pressCount = 0;
    let audioContext = null;

    function getAudioContext() {
        if (!audioContext) {
            const Context = window.AudioContext || window.webkitAudioContext;
            if (Context) {
                audioContext = new Context();
            }
        }
        return audioContext;
    }

    function playTone(freq, duration, type, gainValue) {
        const ctx = getAudioContext();
        if (!ctx) {
            return;
        }

        const osc = ctx.createOscillator();
        const gain = ctx.createGain();

        osc.type = type;
        osc.frequency.value = freq;
        gain.gain.value = gainValue;

        osc.connect(gain);
        gain.connect(ctx.destination);

        const now = ctx.currentTime;
        gain.gain.setValueAtTime(gainValue, now);
        gain.gain.exponentialRampToValueAtTime(0.0001, now + duration);

        osc.start(now);
        osc.stop(now + duration);
    }

    function playPopSound() {
        playTone(620, 0.12, 'triangle', 0.14);
        window.setTimeout(() => playTone(910, 0.08, 'triangle', 0.1), 70);
    }

    function playCelebrateSound() {
        playTone(700, 0.13, 'sine', 0.14);
        window.setTimeout(() => playTone(920, 0.13, 'sine', 0.13), 120);
        window.setTimeout(() => playTone(1150, 0.2, 'sine', 0.14), 240);
    }

    function speakLetterAndWord(letter, word) {
        if (!('speechSynthesis' in window)) {
            return;
        }

        window.speechSynthesis.cancel();

        const first = new SpeechSynthesisUtterance(letter);
        first.lang = 'sk-SK';
        first.rate = 0.78;

        const second = new SpeechSynthesisUtterance(letter + ' ako ' + word);
        second.lang = 'sk-SK';
        second.rate = 0.82;

        first.onend = () => window.speechSynthesis.speak(second);
        window.speechSynthesis.speak(first);
    }

    function updateTheme() {
        const themeIndex = pressCount >= 16 ? 2 : pressCount >= 8 ? 1 : 0;
        const theme = themes[themeIndex];

        scene.style.setProperty('--sky-top', theme.skyTop);
        scene.style.setProperty('--sky-bottom', theme.skyBottom);
        scene.style.setProperty('--grass-top', theme.grassTop);
        scene.style.setProperty('--grass-bottom', theme.grassBottom);
        scene.style.setProperty('--sun', theme.sun);
        themePillEl.textContent = 'Tema: ' + theme.name;
    }

    function setMessage(text) {
        messageEl.textContent = text;
        messageEl.classList.remove('flash');
        void messageEl.offsetWidth;
        messageEl.classList.add('flash');
    }

    function updateStars() {
        starPillEl.textContent = 'Hviezdicky: ' + starCount + ' / 5';
    }

    function showLetterAndObject(letter) {
        const association = associations[letter];
        if (!association) {
            return;
        }

        letterEl.textContent = letter;
        letterEl.style.color = association.color;
        wordEl.textContent = letter + ' ako ' + association.word;

        letterEl.classList.remove('pop');
        void letterEl.offsetWidth;
        letterEl.classList.add('pop');

        objectShapeEl.style.background = association.color;
        objectNameEl.textContent = association.word.toUpperCase();
        objectEl.classList.remove('show');
        void objectEl.offsetWidth;
        objectEl.classList.add('show');

        playPopSound();
        speakLetterAndWord(letter, association.word);
    }

    function launchConfetti() {
        const colors = ['#ff6b6b', '#feca57', '#1dd1a1', '#54a0ff', '#ff9ff3'];
        for (let i = 0; i < 36; i += 1) {
            const confetti = document.createElement('div');
            confetti.className = 'confetti';
            confetti.style.left = Math.floor(Math.random() * 100) + 'vw';
            confetti.style.background = colors[i % colors.length];
            confetti.style.animationDelay = (Math.random() * 0.3).toFixed(2) + 's';
            confetti.style.transform = 'rotate(' + Math.floor(Math.random() * 360) + 'deg)';
            scene.appendChild(confetti);
            confetti.classList.add('drop');
            window.setTimeout(() => confetti.remove(), 2200);
        }
    }

    function onLetterPressed(letter) {
        pressCount += 1;
        starCount += 1;

        showLetterAndObject(letter);
        updateTheme();
        updateStars();
        setMessage(praises[Math.floor(Math.random() * praises.length)]);

        if (starCount >= 5) {
            starCount = 0;
            updateStars();
            launchConfetti();
            playCelebrateSound();
            setMessage('Mala oslava! Pokracuj dalej!');
        }
    }

    document.addEventListener('keydown', (event) => {
        const key = event.key.toUpperCase();
        if (!associations[key]) {
            return;
        }

        onLetterPressed(key);
    });

    updateTheme();
    updateStars();
    showLetterAndObject('A');
</script>
</body>
</html>

