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
            background:
                radial-gradient(circle at top, rgba(56, 189, 248, 0.28), transparent 35%),
                linear-gradient(160deg, var(--bg-1), var(--bg-2));
        }

        .controls {
            display: flex;
            gap: 12px;
            padding: 20px;
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

        audio {
            display: none;
        }
    </style>
</head>

<body>
    <main class="controls">
        <button id="toggleButton" type="button">Play</button>
    </main>
    <audio id="watAudio" preload="auto" src="/sound/wat_refren.mp3"></audio>

    <script>
        const audio = document.getElementById('watAudio');
        const toggleButton = document.getElementById('toggleButton');

        function syncButtonState() {
            toggleButton.textContent = audio.paused ? 'Play' : 'Stop';
        }

        async function playSound() {
            try {
                if (audio.ended || audio.currentTime >= audio.duration) {
                    audio.currentTime = 0;
                }

                await audio.play();
            } catch (error) {
                // Ignore autoplay errors; user can start audio manually.
            }
        }

        function stopSound() {
            audio.pause();
            audio.currentTime = 0;
        }

        toggleButton.addEventListener('click', () => {
            if (audio.paused) {
                playSound();
                return;
            }

            stopSound();
        });

        audio.addEventListener('play', syncButtonState);
        audio.addEventListener('pause', syncButtonState);
        audio.addEventListener('ended', syncButtonState);

        window.addEventListener('load', () => {
            syncButtonState();
            playSound();
        });
    </script>
</body>

</html>
