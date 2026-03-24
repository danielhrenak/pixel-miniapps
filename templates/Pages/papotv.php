<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TV Slideshow Pro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: black; color: white; overflow: hidden; font-family: sans-serif; }
        .transition-opacity { transition: opacity 1000ms; }
        .hidden { display: none; }
        #error-msg { position: absolute; top: 1rem; left: 1rem; color: #ff4444; font-size: 0.75rem; z-index: 100; pointer-events: none; }
    </style>
</head>
<body class="bg-black text-white overflow-hidden">
<div id="error-msg" class="opacity-0 transition-opacity">Chyba načítania súboru, preskakujem...</div>
<div id="slideshow-container" class="relative w-full h-screen">
    <!-- Background Blur -->
    <div id="bg-blur" class="absolute inset-0 bg-cover bg-center scale-110 blur-2xl opacity-50 transition-opacity"></div>
    <video id="bg-video" class="absolute inset-0 w-full h-full object-cover scale-110 blur-2xl opacity-50 transition-opacity opacity-0" autoplay muted playsinline loop></video>

    <!-- Main Content -->
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div id="loading-indicator" class="absolute inset-0 flex items-center justify-center z-40 opacity-0 transition-opacity pointer-events-none">
            <div class="w-12 h-12 border-4 border-white/20 border-t-white rounded-full animate-spin"></div>
        </div>
        <img id="main-image" src="" alt="" referrerPolicy="no-referrer" class="max-w-full max-h-full object-contain shadow-2xl z-10 transition-opacity opacity-0" />
        <video id="main-video" class="max-w-full max-h-full object-contain shadow-2xl z-10 transition-opacity opacity-0 hidden" autoplay muted playsinline></video>
    </div>

    <!-- Progress Bar -->
    <div id="progress-bar" class="absolute bottom-0 left-0 h-1 bg-white/30 z-50 w-0"></div>

    <!-- Settings Trigger -->
    <button id="settings-btn" class="absolute bottom-8 right-8 p-4 bg-white/10 backdrop-blur-md rounded-full hover:bg-white/20 transition-all opacity-20 hover:opacity-100 z-50">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
    </button>
</div>

<!-- Modal -->
<div id="modal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm hidden">
    <div class="bg-zinc-900 w-full max-w-2xl rounded-3xl overflow-hidden border border-white/10 shadow-2xl">
        <div class="p-8 flex justify-between items-center border-b border-white/5">
            <h2 class="text-2xl font-semibold tracking-tight">Nastavenia Slideshow</h2>
            <button id="close-modal" class="p-2 hover:bg-white/5 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>
        <div class="p-8 space-y-4">
            <div class="space-y-2">
                <label class="text-sm font-medium text-zinc-400 uppercase tracking-widest">Nahrať súbory (obrázky/videá)</label>
                <input type="file" id="file-input" multiple accept="image/*,video/mp4" class="w-full text-sm text-zinc-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-white/10 file:text-white hover:file:bg-white/20 cursor-pointer" />
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium text-zinc-400 uppercase tracking-widest">Zoznam URL adries (oddelené čiarkou)</label>
                <textarea id="url-input" class="w-full h-48 bg-black/50 border border-white/10 rounded-xl p-4 focus:outline-none focus:border-white/30 font-mono text-sm resize-none" placeholder="https://link1.jpg, https://link2.jpg..."></textarea>
            </div>
            <div class="flex justify-between items-center">
                <p class="text-xs text-zinc-500 italic">Zmeny sa uložia automaticky po zatvorení.</p>
                <button id="save-btn" class="bg-white text-black px-8 py-3 rounded-xl font-semibold hover:bg-zinc-200 transition-colors">Hotovo</button>
            </div>
        </div>
    </div>
</div>

<script>
    const DEFAULT_IMAGES = [
        'https://drive.google.com/uc?export=download&id=10dqXgAsW4-LwGsgy4xMy5OeLB07JV0uj',
        'https://drive.google.com/uc?export=download&id=1521aQlXCx0lj9IA7oQRPaQUxaWVnWpze',
        'https://drive.google.com/uc?export=download&id=1GTqyBu1AlyH6EjplZJRoxy3deN-B4Cyz',
        'https://drive.google.com/uc?export=download&id=1Lo8bFl3hGhBdrjtQXeCHwFcm0ONqQ3XM',
        'https://drive.google.com/uc?export=download&id=1j0G3uJxUq-2Y4eYTO8CX6HtAR2gPYjTD',
        'https://drive.google.com/uc?export=download&id=1lwG51G8GKhv0sSzliZUYRFfd0bJFhFPO',
        'https://drive.google.com/uc?export=download&id=1nwu0XuFrCzzz9-7x7e6CAxpKxk3A8PVC',
        'https://drive.google.com/uc?export=download&id=1poWKQSgzO1S0JqcdUE66USauAEzp0rPH',
        'https://drive.google.com/uc?export=download&id=1tp6x9SYWnbTHc2BTpvUUj12Ih0SSJ5gc'
    ];

    let images = JSON.parse(localStorage.getItem('slideshow-images') || JSON.stringify(DEFAULT_IMAGES));
    let currentIndex = 0;
    let rotationInterval = null;
    let errorTimeout = null;
    const ROTATION_TIME = 30000;
    const PRELOAD_COUNT = 3; // Number of items to preload ahead
    const preloadedElements = new Map(); // Cache for preloaded elements

    const bgBlur = document.getElementById('bg-blur');
    const bgVideo = document.getElementById('bg-video');
    const mainImage = document.getElementById('main-image');
    const mainVideo = document.getElementById('main-video');
    const progressBar = document.getElementById('progress-bar');
    const errorMsg = document.getElementById('error-msg');
    const loadingIndicator = document.getElementById('loading-indicator');
    const settingsBtn = document.getElementById('settings-btn');
    const modal = document.getElementById('modal');
    const closeModal = document.getElementById('close-modal');
    const saveBtn = document.getElementById('save-btn');
    const urlInput = document.getElementById('url-input');
    const fileInput = document.getElementById('file-input');

    function isVideo(url) {
        const videoExtensions = ['.mp4', '.webm', '.ogg', '.mov'];
        return videoExtensions.some(ext => url.toLowerCase().includes(ext)) || url.startsWith('data:video/');
    }

    function transformUrl(url) {
        // Don't transform if it's already identified as a video
        if (isVideo(url)) return url;

        // Transform Google Drive links to a more reliable embed format for images
        const driveMatch = url.match(/(?:drive\.google\.com\/(?:uc\?export=download&id=|file\/d\/)|id=)([\w-]+)/);
        if (driveMatch && driveMatch[1]) {
            // Using the thumbnail endpoint with large size is often more reliable for images
            return `https://drive.google.com/thumbnail?id=${driveMatch[1]}&sz=w1920`;
        }
        return url;
    }

    function preloadNext() {
        if (images.length <= 1) return;
        for (let i = 1; i <= PRELOAD_COUNT; i++) {
            const nextIdx = (currentIndex + i) % images.length;
            const originalUrl = images[nextIdx];
            const url = transformUrl(originalUrl);
            const isVid = isVideo(originalUrl);

            if (!preloadedElements.has(url)) {
                if (isVid) {
                    const v = document.createElement('video');
                    v.preload = 'auto';
                    v.src = url;
                    v.muted = true;
                    preloadedElements.set(url, v);
                } else {
                    const img = new Image();
                    img.src = url;
                    preloadedElements.set(url, img);
                }
            }
        }
    }

    function showError() {
        errorMsg.style.opacity = '1';
        loadingIndicator.style.opacity = '0';
        clearTimeout(errorTimeout);
        errorTimeout = setTimeout(() => {
            errorMsg.style.opacity = '0';
            nextImage();
        }, 3000);
    }

    function updateSlideshow() {
        if (images.length === 0) {
            mainImage.style.opacity = '0';
            mainVideo.style.opacity = '0';
            bgVideo.style.opacity = '0';
            mainVideo.classList.add('hidden');
            bgBlur.style.backgroundImage = 'none';
            loadingIndicator.style.opacity = '0';
            return;
        }

        let url = images[currentIndex];
        const originalUrl = url;
        url = transformUrl(url);

        const isVid = isVideo(originalUrl);

        mainImage.style.opacity = '0';
        mainVideo.style.opacity = '0';
        bgVideo.style.opacity = '0';

        // If already preloaded, we might show it faster
        const isPreloaded = preloadedElements.has(url);
        if (!isPreloaded) {
            loadingIndicator.style.opacity = '1';
        }

        setTimeout(() => {
            if (isVid) {
                mainImage.classList.add('hidden');
                mainVideo.classList.remove('hidden');

                // Reset and load
                mainVideo.pause();
                bgVideo.pause();
                mainVideo.src = url;
                bgVideo.src = url;
                mainVideo.load();
                bgVideo.load();

                const playPromise = mainVideo.play();
                if (playPromise !== undefined) {
                    playPromise.then(() => {
                        bgVideo.play().catch(() => {});
                    }).catch((err) => {
                        console.error("Video play failed:", err);
                        showError();
                    });
                }

                mainVideo.onloadeddata = () => {
                    mainVideo.style.opacity = '1';
                    bgVideo.style.opacity = '0.5';
                    loadingIndicator.style.opacity = '0';
                    preloadNext();
                };
                mainVideo.onerror = (e) => {
                    console.error("Video error:", e);
                    showError();
                };
                bgBlur.style.backgroundImage = 'none';
            } else {
                mainVideo.classList.add('hidden');
                mainVideo.pause();
                bgVideo.pause();
                mainImage.classList.remove('hidden');
                mainImage.src = url;
                bgBlur.style.backgroundImage = `url(${url})`;

                mainImage.onload = () => {
                    mainImage.style.opacity = '1';
                    loadingIndicator.style.opacity = '0';
                    preloadNext();
                };
                mainImage.onerror = (e) => {
                    console.error("Image load failed for URL:", url, e);
                    showError();
                };
            }
        }, 500);

        progressBar.style.transition = 'none';
        progressBar.style.width = '0%';
        progressBar.offsetHeight;
        progressBar.style.transition = `width ${ROTATION_TIME}ms linear`;
        progressBar.style.width = '100%';
    }

    function nextImage() {
        if (images.length === 0) return;
        currentIndex = (currentIndex + 1) % images.length;
        updateSlideshow();
    }

    function startSlideshow() {
        if (rotationInterval) clearInterval(rotationInterval);
        updateSlideshow();
        rotationInterval = setInterval(nextImage, ROTATION_TIME);
    }

    settingsBtn.addEventListener('click', () => {
        urlInput.value = images.join(', ');
        modal.classList.remove('hidden');
    });

    function handleSave() {
        const input = urlInput.value;
        images = input.split(',')
            .map(s => s.trim())
            .filter(s => s.length > 0);

        localStorage.setItem('slideshow-images', JSON.stringify(images));
        currentIndex = 0;
        modal.classList.add('hidden');
        startSlideshow();
    }

    closeModal.addEventListener('click', handleSave);
    saveBtn.addEventListener('click', handleSave);

    fileInput.addEventListener('change', (e) => {
        const files = e.target.files;
        if (!files) return;

        Array.from(files).forEach(file => {
            const reader = new FileReader();
            reader.onload = (event) => {
                const base64 = event.target.result;
                if (base64) {
                    const currentUrls = urlInput.value.split(',').map(s => s.trim()).filter(s => s.length > 0);
                    currentUrls.push(base64);
                    urlInput.value = currentUrls.join(', ');
                }
            };
            reader.readAsDataURL(file);
        });
    });

    startSlideshow();
</script>
</body>
</html>
