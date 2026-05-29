<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WAT sound</title>
    <style>
        :root {
            color-scheme: dark;
            --bg-1: #0f172a;
            --bg-2: #111827;
            --panel: rgba(15, 23, 42, 0.82);
            --text: #f8fafc;
            --muted: #cbd5e1;
            --accent: #38bdf8;
            --accent-strong: #0ea5e9;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            font-family: Arial, sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top, rgba(56, 189, 248, 0.28), transparent 35%),
                linear-gradient(160deg, var(--bg-1), var(--bg-2));
        }

        .card {
            width: min(92vw, 560px);
            padding: 32px;
            border: 1px solid rgba(148, 163, 184, 0.2);
            border-radius: 24px;
            background: var(--panel);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.35);
            text-align: center;
        }

        h1 {
            margin: 0 0 12px;
            font-size: clamp(2.5rem, 10vw, 5rem);
            letter-spacing: 0.08em;
        }

        p {
            margin: 0 0 24px;
            color: var(--muted);
            line-height: 1.5;
        }

        button {
            appearance: none;
            border: 0;
            border-radius: 999px;
            padding: 14px 22px;
            font-size: 1rem;
            font-weight: 700;
            color: white;
            background: linear-gradient(135deg, var(--accent), var(--accent-strong));
            cursor: pointer;
        }

        button:focus-visible {
            outline: 3px solid rgba(56, 189, 248, 0.5);
            outline-offset: 4px;
        }

        .status {
            margin-top: 18px;
            min-height: 1.4em;
            color: var(--muted);
            font-size: 0.95rem;
        }

        audio {
            display: none;
        }
    </style>
</head>

<body>
    <main class="card">
        <h1>WAT</h1>
        <p>Stránka sa po otvorení pokúsi prehrať zvuk <strong>wat_refren.mp3</strong>.</p>
        <button id="playButton" type="button">Play</button>
        <div class="status" id="status">Načítavam zvuk...</div>
        <audio id="watAudio" preload="auto" src="/sound/wat_refren.mp3"></audio>
    </main>

    <script>
        const audio = document.getElementById('watAudio');
        const playButton = document.getElementById('playButton');
        const status = document.getElementById('status');

        function syncButtonState() {
            playButton.textContent = audio.paused ? 'Play' : 'Stop';
        }

        async function playSound() {
            try {
                if (audio.ended || audio.currentTime >= audio.duration) {
                    audio.currentTime = 0;
                }

                await audio.play();
                status.textContent = 'Zvuk beží.';
                syncButtonState();
            } catch (error) {
                status.textContent = 'Prehliadač blokuje autoplay. Klikni na tlačidlo.';
                syncButtonState();
            }
        }

        function stopSound() {
            audio.pause();
            audio.currentTime = 0;
            status.textContent = 'Zvuk zastavený.';
            syncButtonState();
        }

        playButton.addEventListener('click', () => {
            if (audio.paused) {
                playSound();
                return;
            }

            stopSound();
        });

        audio.addEventListener('play', () => {
            status.textContent = 'Zvuk beží.';
            syncButtonState();
        });

        audio.addEventListener('pause', () => {
            syncButtonState();
        });

        audio.addEventListener('ended', () => {
            status.textContent = 'Zvuk skončil.';
            syncButtonState();
        });

        window.addEventListener('load', () => {
            syncButtonState();
            playSound();
        });
    </script>
</body>

</html>
