// Refresh the page every hour (3600000 milliseconds)
setTimeout(() => location.reload(), 3600000);

const jokeInterval = 30000;
let currentIndex = 0; // Initialize currentIndex globally

function getTotalPriority(comments) {
    return comments.reduce((sum, joke) => sum + joke.priority, 0);
}

function selectRandomJoke(comments, totalPriority) {
    let randomValue = Math.random() * totalPriority;
    for (const joke of comments) {
        randomValue -= joke.priority;
        if (randomValue <= 0) {
            return joke;
        }
    }
    return null;
}

function hideJokePopup(jokePopup) {
    jokePopup.style.display = 'none';
}

function showJokePopup(jokePopup) {
    jokePopup.style.display = 'block';
}

function displayTextJoke(jokePopup, content) {
    const div = document.createElement('div');
    div.className = 'jokeText';
    div.textContent = content;
    jokePopup.appendChild(div);
    jokePopup.style.padding = '35px';
}

function displayImageJoke(jokePopup, content) {
    const img = document.createElement('img');
    img.src = content;
    img.style.maxWidth = '100%';
    img.style.borderRadius = '8px';
    jokePopup.appendChild(img);
    jokePopup.style.padding = '10px';
}

function displayYoutubeJoke(jokePopup, content) {
    const iframe = document.createElement('iframe');
    iframe.src = `https://www.youtube.com/embed/${content}?autoplay=1`;
    iframe.width = '560';
    iframe.height = '200';
    iframe.frameBorder = '0';
    iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
    iframe.allowFullscreen = true;
    jokePopup.appendChild(iframe);
    jokePopup.style.padding = '0';
}

function addProgressBar(jokePopup) {
    const progressBar = document.createElement('div');
    progressBar.id = 'jokeProgressBar';
    progressBar.style.width = '100%';
    progressBar.style.height = '3px';
    progressBar.style.backgroundColor = '#4caf50';
    progressBar.style.transition = `width ${jokeInterval}ms linear`;
    jokePopup.appendChild(progressBar);
}

function resetJokeProgressBar() {
    const progressBar = document.getElementById('jokeProgressBar');
    progressBar.style.transition = 'none';
    progressBar.style.width = '100%';
    setTimeout(() => {
        progressBar.style.transition = `width ${jokeInterval}ms linear`;
        progressBar.style.width = '0%';
    }, 50);
}

function displayRandomJoke() {
    const jokePopup = document.getElementById('jokePopup');
    jokePopup.innerHTML = ''; // Clear previous content

    const totalPriority = getTotalPriority(comments);
    const selectedJoke = selectRandomJoke(comments, totalPriority);

    if (selectedJoke.category === 'empty') {
        hideJokePopup(jokePopup);
        return;
    }

    showJokePopup(jokePopup);

    switch (selectedJoke.category) {
        case 'text':
            displayTextJoke(jokePopup, selectedJoke.content);
            break;
        case 'image':
            displayImageJoke(jokePopup, selectedJoke.content);
            break;
        case 'youtube':
            displayYoutubeJoke(jokePopup, selectedJoke.content);
            break;
    }

    addProgressBar(jokePopup);
    resetJokeProgressBar();
}

function cyclePages() {
    const iframe = document.getElementById('monitorFrame');
    const currentUrl = urls[currentIndex];
    const duration = currentUrl.duration * 1000;

    iframe.src = currentUrl.url;
    resetProgressBar(duration);

    currentIndex = (currentIndex + 1) % urls.length;
    setTimeout(cyclePages, duration);
}

function resetProgressBar(duration) {
    const progress = document.getElementById('progress');
    progress.style.transition = 'none';
    progress.style.width = '100%';
    setTimeout(() => {
        progress.style.transition = `width ${duration}ms linear`;
        progress.style.width = '0%';
    }, 50);
}

// Initialize jokes and page cycling
if (typeof comments !== 'undefined' && comments.length > 0) {
    displayRandomJoke();
    setInterval(displayRandomJoke, jokeInterval);
}

if (typeof urls !== 'undefined' && urls.length > 0) {
    cyclePages();
}
