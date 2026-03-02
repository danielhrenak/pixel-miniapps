<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Abeceda – písmeno a zvuk</title>
    <style>
        body {
            background: #f2f2f2;
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 20px;
        }

        h1 {
            font-size: 32px;
            margin-bottom: 10px;
        }

        button {
            font-size: 20px;
            padding: 10px 20px;
            margin-bottom: 20px;
            cursor: pointer;
        }

        #grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
            max-width: 600px;
            margin: 0 auto;
        }

        .cell {
            background: white;
            border: 3px solid #333;
            height: 80px;
            font-size: 48px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            user-select: none;
            transition: transform 0.2s ease;
        }

        .active {
            transform: scale(1.4);
        }
    </style>
</head>
<body>

<h1>Stlač písmeno</h1>

<button id="resetBtn">Reset</button>

<div id="grid"></div>

<script>
    const letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ".split("");
    const grid = document.getElementById("grid");
    const resetBtn = document.getElementById("resetBtn");

    const colors = [
        "#ff6b6b", "#4dabf7", "#ffd43b",
        "#69db7c", "#da77f2", "#ffa94d",
        "#63e6be"
    ];

    const cells = {};

    letters.forEach((letter, index) => {
        const cell = document.createElement("div");
        cell.className = "cell";
        cell.textContent = letter;
        grid.appendChild(cell);

        cells[letter] = {
            element: cell,
            color: colors[index % colors.length],
            filled: false
        };
    });

    function speakLetter(letter) {
        const utterance = new SpeechSynthesisUtterance(letter.toLowerCase());
        utterance.lang = "sk-SK";
        utterance.rate = 0.8;

        speechSynthesis.cancel();
        speechSynthesis.speak(utterance);
    }

    function activateCell(letter) {
        const cell = cells[letter].element;

        cell.classList.add("active");

        setTimeout(() => {
            cell.classList.remove("active");
        }, 300);
    }

    document.addEventListener("keydown", (event) => {
        const key = event.key.toUpperCase();

        if (cells[key]) {
            const data = cells[key];

            data.element.style.background = data.color;
            data.filled = true;

            activateCell(key);
            speakLetter(key);
        }
    });

    resetBtn.addEventListener("click", () => {
        Object.values(cells).forEach(data => {
            data.filled = false;
            data.element.style.background = "white";
        });
    });
</script>

</body>
</html>
