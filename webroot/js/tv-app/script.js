/****************
 * DEMO DATA
 ****************/
const links = window.tvAppData?.links || [];
const announcements = window.tvAppData?.announcements || [];
const wallPosts = window.tvAppData?.wallPosts || [];

/****************
 * LAYOUT LOGIC
 ****************/
const layout = document.querySelector(".layout");
const wall = document.getElementById("wall");
const wallContainer = document.getElementById("wall-posts");
const wallLoader = document.getElementById("wall-loader");
const announcementsEl = document.getElementById("announcements");
const announcementList = document.getElementById("announcement-list");
const infoPanel = document.getElementById("info");
const dataIframe = document.getElementById("data-iframe");
const dataTitle = document.getElementById("data-title");
const loadCountdown = document.getElementById("load-countdown");

let currentPostIndex = 0;
let currentLinkIndex = 0;
let rotationInterval;
let linkRotationInterval;
let countdownInterval;

// Announcements
if (!announcementsEl) {
    // ...existing code...
} else {
    if (announcements.length === 0) {
        announcementsEl.style.display = "none";
    } else {
        // populate popup list
        announcementList.innerHTML = "";
        announcements.forEach(a => {
            const div = document.createElement("div");
            div.className = "announcement";
            div.innerHTML = `${a.text}${a.author ? `<br/><small>— ${a.author}</small>` : ""}`;
            announcementList.appendChild(div);
        });
    }
}

// Extract YouTube video ID and return embed URL with autoplay
function getYouTubeEmbedUrl(url) {
    const patterns = [
        /(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/,
        /youtube\.com\/embed\/([a-zA-Z0-9_-]{11})/
    ];

    for (const pattern of patterns) {
        const match = url.match(pattern);
        if (match) {
            return `https://www.youtube.com/embed/${match[1]}?autoplay=1&mute=1`;
        }
    }
    return url.includes('embed') ? url : null;
}

// Render exactly 2 posts
function renderTwoPosts(startIdx) {
    wallContainer.innerHTML = "";

    for (let i = 0; i < 2; i++) {
        const idx = (startIdx + i) % wallPosts.length;
        const p = wallPosts[idx];
        const post = document.createElement("div");
        post.className = "wall-post";

        if (p.image) {
            const imgWrapper = document.createElement("div");
            imgWrapper.className = "image-wrapper";
            const img = document.createElement("img");
            img.src = p.image;
            img.onload = () => resizeImageToFit(img, post);
            imgWrapper.appendChild(img);

            // only add overlay when author or text exists
            const hasOverlayContent = (p.author && p.author.trim()) || (p.text && p.text.trim());
            if (hasOverlayContent) {
                const overlay = document.createElement("div");
                overlay.className = "image-overlay";
                overlay.innerHTML = `<strong>${p.author}</strong><div>${p.text}</div>`;
                imgWrapper.appendChild(overlay);
            }

            post.appendChild(imgWrapper);
        } else if (p.video) {
            const videoWrapper = document.createElement("div");
            videoWrapper.className = "video-wrapper";
            const iframe = document.createElement("iframe");
            iframe.src = getYouTubeEmbedUrl(p.video);
            iframe.allow = "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture";
            iframe.allowFullscreen = true;
            iframe.setAttribute("allow", "autoplay");
            videoWrapper.appendChild(iframe);

            // only add overlay when author or text exists
            const hasOverlayContent = (p.author && p.author.trim()) || (p.text && p.text.trim());
            if (hasOverlayContent) {
                const overlay = document.createElement("div");
                overlay.className = "image-overlay";
                overlay.innerHTML = `<strong>${p.author}</strong><div>${p.text}</div>`;
                videoWrapper.appendChild(overlay);
            }

            post.appendChild(videoWrapper);
        } else {
            post.innerHTML = `<strong>${p.author}</strong>`;
            const textDiv = document.createElement("div");
            textDiv.textContent = p.text;
            post.appendChild(textDiv);
        }
        wallContainer.appendChild(post);
    }
}

// Resize image to fit post without overflow
function resizeImageToFit(img, post) {
    const wrapper = img.parentElement;
    const maxHeight = 450;
    const maxWidth = wrapper.clientWidth - 4;

    const imgRatio = img.naturalWidth / img.naturalHeight;
    const containerRatio = maxWidth / maxHeight;

    if (imgRatio > containerRatio) {
        img.style.maxWidth = `${maxWidth}px`;
        img.style.maxHeight = "auto";
    } else {
        img.style.maxHeight = `${maxHeight}px`;
        img.style.maxWidth = "auto";
    }
}

// Rotate only second post every 15 seconds
function rotatePosts() {
    const posts = wallContainer.querySelectorAll(".wall-post");

    if (posts.length < 2) return;

    const randomIdx = Math.floor(Math.random() * wallPosts.length);
    const secondPost = posts[randomIdx];
    secondPost.style.animation = "none";

    setTimeout(() => {
        secondPost.style.animation = "fadeOutUp 0.5s ease-out forwards";
    }, 10);

    setTimeout(() => {
        const newRandomIdx = Math.floor(Math.random() * wallPosts.length);
        const p = wallPosts[newRandomIdx];

        const newPost = document.createElement("div");
        newPost.className = "wall-post";

        if (p.image) {
            const imgWrapper = document.createElement("div");
            imgWrapper.className = "image-wrapper";
            const img = document.createElement("img");
            img.src = p.image;
            img.onload = () => resizeImageToFit(img, newPost);
            imgWrapper.appendChild(img);

            // only add overlay when author or text exists
            const hasOverlayContent = (p.author && p.author.trim()) || (p.text && p.text.trim());
            if (hasOverlayContent) {
                const overlay = document.createElement("div");
                overlay.className = "image-overlay";
                overlay.innerHTML = `<strong>${p.author}</strong><div>${p.text}</div>`;
                imgWrapper.appendChild(overlay);
            }

            newPost.appendChild(imgWrapper);
        } else if (p.video) {
            const videoWrapper = document.createElement("div");
            videoWrapper.className = "video-wrapper";
            const iframe = document.createElement("iframe");
            iframe.src = getYouTubeEmbedUrl(p.video);
            iframe.allow = "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture";
            iframe.allowFullscreen = true;
            videoWrapper.appendChild(iframe);

            // only add overlay when author or text exists
            const hasOverlayContent = (p.author && p.author.trim()) || (p.text && p.text.trim());
            if (hasOverlayContent) {
                const overlay = document.createElement("div");
                overlay.className = "image-overlay";
                overlay.innerHTML = `<strong>${p.author}</strong><div>${p.text}</div>`;
                videoWrapper.appendChild(overlay);
            }

            newPost.appendChild(videoWrapper);
        } else {
            newPost.innerHTML = `<strong>${p.author}</strong>`;
            const textDiv = document.createElement("div");
            textDiv.textContent = p.text;
            newPost.appendChild(textDiv);
        }
        newPost.style.animation = "slideIn 0.5s ease-out";

        wallContainer.replaceChild(newPost, secondPost);
    }, 500);
}

// Start countdown timer for link rotation
function startCountdown() {
    const duration = 30000; // 30 seconds in milliseconds
    let startTime = Date.now();

    if (countdownInterval) cancelAnimationFrame(countdownInterval);

    // Reset bar to 100%
    loadCountdown.style.width = "100%";

    function animate() {
        const elapsed = Date.now() - startTime;
        const percentage = Math.max(0, ((duration - elapsed) / duration) * 100);
        loadCountdown.style.width = percentage + "%";

        if (elapsed < duration) {
            countdownInterval = requestAnimationFrame(animate);
        } else {
            loadCountdown.style.width = "0%";
        }
    }

    countdownInterval = requestAnimationFrame(animate);
}

// Load first link
function loadLink(index) {
    if (links.length === 0) return;

    const link = links[index % links.length];
    dataIframe.src = link.url;
    dataTitle.textContent = link.title;
    currentLinkIndex = index;
    startCountdown(); // Start countdown when link loads
}

// Rotate links every 30 seconds
function rotateLinks() {
    loadLink(currentLinkIndex + 1);
}

// Load initial link
loadLink(0);

// Start link rotation if multiple links
if (links.length > 1) {
    linkRotationInterval = setInterval(rotateLinks, 30000);
}

// Initial render
renderTwoPosts(0);

// Start rotation every 15 seconds
rotationInterval = setInterval(rotatePosts, 5000);


// Only data fullscreen
if (announcements.length === 0 && wallPosts.length === 0) {
    layout.classList.add("only-data");
    infoPanel.style.display = "none";
}

/****************
 * WEATHER – Bratislava (Open-Meteo, no API key)
 ****************/
async function loadWeather() {
    try {
        const res = await fetch("https://api.open-meteo.com/v1/forecast?latitude=48.1486&longitude=17.1077&current_weather=true");
        const data = await res.json();
        const w = data.current_weather;

        const icons = {
            0: "☀️", 1: "🌤", 2: "⛅", 3: "☁️",
            45: "🌫", 48: "🌫",
            51: "🌦", 61: "🌧", 71: "❄️", 95: "⛈"
        };

        document.getElementById("weather").textContent = `${icons[w.weathercode] || "🌡"} ${Math.round(w.temperature)} °C`;
        document.getElementById("weather-desc").textContent = `Vietor ${Math.round(w.windspeed)} km/h`;
    } catch (e) {
        document.getElementById("weather").textContent = "N/A";
    }
}

/****************
 * NAMEDAY – Slovakia
 ****************/
async function loadNamedaySK() {
    try {
        const now = new Date();
        const day = String(now.getDate()).padStart(2, '0');
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const dateStr = `${day}${month}`;

        const url = `https://svatky.adresa.info/json?lang=sk&date=${dateStr}`;
        const res = await fetch(url);
        const json = await res.json();

        const names = json.map(item => item.name);
        const todayNames = names.join(', ');

        document.getElementById("nameday").textContent = todayNames || "—";
    } catch (e) {
        document.getElementById("nameday").textContent = "—";
    }
}


loadWeather();
loadNamedaySK();
