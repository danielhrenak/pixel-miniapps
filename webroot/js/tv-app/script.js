/****************
 * DEMO DATA
 ****************/
const links = window.tvAppData?.links || [];
const announcements = window.tvAppData?.announcements || [];
const wallPosts = window.tvAppData?.wallPosts || [];

/****************
 * PRIORITY WEIGHTING SYSTEM
 ****************/
// Calculate weights for posts based on creation date
function calculatePostWeights(posts) {
    if (posts.length === 0) return [];

    // Find newest and oldest post dates
    let newestTime = 0;
    let oldestTime = Infinity;

    posts.forEach(post => {
        const postTime = new Date(post.created).getTime();
        newestTime = Math.max(newestTime, postTime);
        oldestTime = Math.min(oldestTime, postTime);
    });

    const timeRange = newestTime - oldestTime;

    // Calculate weights using exponential function
    return posts.map(post => {
        const postTime = new Date(post.created).getTime();

        // Normalize age to 0-1 (0 = newest, 1 = oldest)
        const normalizedAge = timeRange === 0 ? 0 : (newestTime - postTime) / timeRange;

        // Exponential weight: newer posts get much higher weight
        // Formula: e^(-2 * age) gives newer posts ~7x weight compared to oldest
        const weight = Math.exp(-2 * normalizedAge);

        return weight;
    });
}

// Select a random post with weighted probability
function selectWeightedRandomPost(posts) {
    console.log(posts);


    if (posts.length === 0) return null;
    if (posts.length === 1) return posts[0];

    const weights = calculatePostWeights(posts);
    const totalWeight = weights.reduce((sum, w) => sum + w, 0);

    let random = Math.random() * totalWeight;

    for (let i = 0; i < posts.length; i++) {
        random -= weights[i];
        if (random <= 0) {
            return posts[i];
        }
    }

    return posts[posts.length - 1];
}

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
let lastRotatedPosition = 0; // Track which position was last rotated

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

// Format relative time (e.g., "5 days ago")
function formatTimeAgo(createdAt) {
    if (!createdAt) return "";

    const now = new Date();
    const created = new Date(createdAt);
    const diffMs = now - created;
    const diffSecs = Math.floor(diffMs / 1000);
    const diffMins = Math.floor(diffSecs / 60);
    const diffHours = Math.floor(diffMins / 60);
    const diffDays = Math.floor(diffHours / 24);

    if (diffSecs < 60) return "práve teraz";
    if (diffMins < 60) return `${diffMins} min${diffMins === 1 ? '' : ''}`;
    if (diffHours < 24) return `${diffHours}hours ago`;
    if (diffDays < 7) return `${diffDays} day${diffDays === 1 ? '' : 's'} ago`;
    if (diffDays < 30) return `${Math.floor(diffDays / 7)}weeks ago`;
    return `${Math.floor(diffDays / 30)}months ago`;
}

// Render exactly 2 posts (first is manual, second is weighted random)
function renderTwoPosts(startIdx) {
    wallContainer.innerHTML = "";

    // Check if we have posts
    if (!wallPosts || wallPosts.length === 0) {
        console.warn("No wall posts available");
        return;
    }

    for (let i = 0; i < 2; i++) {
        let p;

        if (wallPosts.length === 1) {
            // Only 1 post available - show the same post twice
            p = wallPosts[0];
        } else if (i === 0) {
            // First post: sequential
            const idx = (startIdx + i) % wallPosts.length;
            p = wallPosts[idx];
        } else {
            // Second post: weighted random (prioritize newer posts)
            p = selectWeightedRandomPost(wallPosts);

            // Fallback: if weighted selection fails, use random
            if (!p) {
                p = wallPosts[Math.floor(Math.random() * wallPosts.length)];
            }
        }

        if (!p) continue; // Skip if post is invalid

        const post = document.createElement("div");
        post.className = "wall-post";

        // Add timestamp
        if (p.created) {
            const timestamp = document.createElement("div");
            timestamp.className = "post-timestamp";
            timestamp.textContent = formatTimeAgo(p.created);
            post.appendChild(timestamp);
        }

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
            post.innerHTML = `<strong>${p.author || "Bez autora"}</strong>`;
            const textDiv = document.createElement("div");
            textDiv.textContent = p.text || "";
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

// Rotate both posts alternately (use weighted selection)
function rotatePosts() {
    const posts = wallContainer.querySelectorAll(".wall-post");

    if (posts.length < 2 || wallPosts.length === 0) return;

    // Alternate between rotating first and second post
    const positionToRotate = lastRotatedPosition === 0 ? 1 : 0;
    const postToReplace = posts[positionToRotate];

    lastRotatedPosition = positionToRotate;

    postToReplace.style.animation = "none";

    setTimeout(() => {
        postToReplace.style.animation = "fadeOutUp 0.5s ease-out forwards";
    }, 10);

    setTimeout(() => {
        // Use weighted random selection
        let p = selectWeightedRandomPost(wallPosts);

        // Fallback if selection fails
        if (!p) {
            p = wallPosts[Math.floor(Math.random() * wallPosts.length)];
        }

        const newPost = document.createElement("div");
        newPost.className = "wall-post";

        // Add timestamp
        if (p.created) {
            const timestamp = document.createElement("div");
            timestamp.className = "post-timestamp";
            timestamp.textContent = formatTimeAgo(p.created);
            newPost.appendChild(timestamp);
        }

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
            newPost.innerHTML = `<strong>${p.author || "Bez autora"}</strong>`;
            const textDiv = document.createElement("div");
            textDiv.textContent = p.text || "";
            newPost.appendChild(textDiv);
        }
        newPost.style.animation = "slideIn 0.5s ease-out";

        wallContainer.replaceChild(newPost, postToReplace);
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
if (wallPosts.length > 0) {
    renderTwoPosts(0);

    // Start rotation every 5 seconds, alternating between both posts
    rotationInterval = setInterval(rotatePosts, 20000);
} else {
    console.warn("No wall posts to display");
}


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
