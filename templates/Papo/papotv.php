<?php
?>
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

<!-- Autoplay Unlock Overlay (shown only when browser blocks autoplay) -->
<div id="unlock-overlay" class="fixed inset-0 z-[200] bg-black flex flex-col items-center justify-center cursor-pointer transition-opacity duration-500 hidden">
    <div class="p-8 bg-white/10 backdrop-blur-xl rounded-3xl border border-white/20 flex flex-col items-center space-y-6 hover:bg-white/20 transition-all">
        <div class="w-20 h-20 bg-white text-black rounded-full flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="currentColor"><path d="m7 4 12 8-12 8V4z"/></svg>
        </div>
        <div class="text-center">
            <h1 class="text-2xl font-bold mb-2">Spustiť Slideshow</h1>
            <p class="text-zinc-400">Kliknite pre spustenie automatického prehrávania</p>
        </div>
    </div>
</div>

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

    <input id="file-input" type="file" accept="image/*,video/mp4,video/webm,video/ogg,video/quicktime" multiple class="hidden" />
</div>

<script>
    const INITIAL_ITEM = <?= $initialItemJson ?? 'null' ?>;
    const INITIAL_INDEX = <?= (int)($initialIndex ?? 0) ?>;
    const TOTAL_ITEMS = <?= (int)($totalItems ?? 0) ?>;
    const SLIDE_ENDPOINT = <?= json_encode($slideEndpoint ?? '', JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
    const PAGE_REFRESH_MS = 60 * 60 * 1000;
    const ROTATION_TIME = 3000;

    let currentItem = normalizeSlideItem(INITIAL_ITEM);
    let currentIndex = INITIAL_INDEX;
    let totalItems = TOTAL_ITEMS > 0 ? TOTAL_ITEMS : 1;
    let bufferedSlide = null;
    let bufferedIndex = null;
    let rotationInterval = null;
    let errorTimeout = null;
    let isAutoplayUnlocked = true;
    let isAdvancing = false;
    let preloadPromise = null;
    const preloadedElements = new Map();

    const bgBlur = document.getElementById('bg-blur');
    const bgVideo = document.getElementById('bg-video');
    const mainImage = document.getElementById('main-image');
    const mainVideo = document.getElementById('main-video');
    const progressBar = document.getElementById('progress-bar');
    const errorMsg = document.getElementById('error-msg');
    const loadingIndicator = document.getElementById('loading-indicator');
    const unlockOverlay = document.getElementById('unlock-overlay');

    function normalizeSlideItem(item) {
        if (!item || typeof item !== 'object') {
            return null;
        }

        const url = typeof item.url === 'string' ? item.url.trim() : '';
        const renderUrl = typeof item.renderUrl === 'string' && item.renderUrl.trim() !== ''
            ? item.renderUrl.trim()
            : url;

        if (!url && !renderUrl) {
            return null;
        }

        return {
            url,
            renderUrl,
            type: item.type === 'video' ? 'video' : 'image',
            mimeType: typeof item.mimeType === 'string' ? item.mimeType : null,
        };
    }

    async function fetchSlide(index) {
        if (!SLIDE_ENDPOINT) {
            throw new Error('Missing slide endpoint.');
        }

        const response = await fetch(`${SLIDE_ENDPOINT}?index=${encodeURIComponent(index)}`, {
            headers: { 'Accept': 'application/json' },
        });

        if (!response.ok) {
            throw new Error(`Failed to fetch slide ${index}: ${response.status}`);
        }

        const payload = await response.json();
        const item = normalizeSlideItem(payload.item);
        if (!item) {
            throw new Error(`Invalid slide payload for index ${index}`);
        }

        totalItems = Math.max(Number(payload.total || totalItems || 1), 1);

        return {
            index: Number(payload.index ?? index),
            item,
        };
    }

    function preloadItem(item) {
        if (!item) return;

        const url = item.renderUrl || item.url;
        if (!url || preloadedElements.has(url)) return;

        if (item.type === 'video') {
            const video = document.createElement('video');
            video.preload = 'auto';
            video.muted = true;
            video.src = url;
            preloadedElements.set(url, video);
            return;
        }

        const img = new Image();
        img.src = url;
        preloadedElements.set(url, img);
    }

    async function queueNextSlide() {
        if (!currentItem) {
            bufferedSlide = null;
            bufferedIndex = null;
            return;
        }

        const nextIndex = (currentIndex + 1) % Math.max(totalItems, 1);
        if (bufferedSlide && bufferedIndex === nextIndex) {
            return;
        }
        if (preloadPromise) {
            return preloadPromise;
        }

        preloadPromise = fetchSlide(nextIndex)
            .then((slide) => {
                bufferedSlide = slide.item;
                bufferedIndex = slide.index;
                preloadItem(bufferedSlide);
            })
            .catch((error) => {
                console.error('Preloading next slide failed:', error);
                bufferedSlide = null;
                bufferedIndex = null;
            })
            .finally(() => {
                preloadPromise = null;
            });

        return preloadPromise;
    }

    function showError() {
        errorMsg.style.opacity = '1';
        loadingIndicator.style.opacity = '0';
        clearTimeout(errorTimeout);
        errorTimeout = setTimeout(() => {
            errorMsg.style.opacity = '0';
            void nextImage();
        }, 3000);
    }

    function renderCurrentItem() {
        if (!currentItem) {
            mainImage.style.opacity = '0';
            mainVideo.style.opacity = '0';
            bgVideo.style.opacity = '0';
            mainVideo.classList.add('hidden');
            bgBlur.style.backgroundImage = 'none';
            loadingIndicator.style.opacity = '0';
            return;
        }

        const url = currentItem.renderUrl || currentItem.url;
        const isVideo = currentItem.type === 'video';

        mainImage.style.opacity = '0';
        mainVideo.style.opacity = '0';
        bgVideo.style.opacity = '0';
        loadingIndicator.style.opacity = preloadedElements.has(url) ? '0' : '1';

        progressBar.style.transition = 'none';
        progressBar.style.width = '0%';
        progressBar.offsetHeight;
        progressBar.style.transition = `width ${ROTATION_TIME}ms linear`;
        progressBar.style.width = '100%';

        setTimeout(() => {
            if (isVideo) {
                mainImage.classList.add('hidden');
                mainVideo.classList.remove('hidden');

                mainVideo.pause();
                bgVideo.pause();
                mainVideo.muted = true;
                bgVideo.muted = true;
                mainVideo.src = url;
                bgVideo.src = url;
                mainVideo.load();
                bgVideo.load();

                const playPromise = mainVideo.play();
                if (playPromise !== undefined) {
                    playPromise.then(() => {
                        bgVideo.play().catch(() => {});
                    }).catch((err) => {
                        console.error('Video play failed:', err);
                        tryAsImage(url);
                    });
                }

                mainVideo.onloadeddata = () => {
                    mainVideo.style.opacity = '1';
                    bgVideo.style.opacity = '0.5';
                    loadingIndicator.style.opacity = '0';
                    void queueNextSlide();
                };
                mainVideo.onerror = (e) => {
                    console.error('Video error:', e);
                    tryAsImage(url);
                };
                bgBlur.style.backgroundImage = 'none';
                return;
            }

            tryAsImage(url);
        }, 500);
    }

    function tryAsImage(url) {
        mainVideo.classList.add('hidden');
        mainVideo.pause();
        bgVideo.pause();
        mainImage.classList.remove('hidden');
        mainImage.src = url;
        bgBlur.style.backgroundImage = `url(${url})`;

        mainImage.onload = () => {
            mainImage.style.opacity = '1';
            loadingIndicator.style.opacity = '0';
            void queueNextSlide();
        };
        mainImage.onerror = (e) => {
            console.error('Image load failed for URL:', url, e);
            showError();
        };
    }

    async function nextImage() {
        if (!currentItem || isAdvancing || totalItems <= 0) {
            return;
        }

        isAdvancing = true;

        try {
            const expectedNextIndex = (currentIndex + 1) % totalItems;
            let nextSlide;

            if (bufferedSlide && bufferedIndex === expectedNextIndex) {
                nextSlide = {
                    index: bufferedIndex,
                    item: bufferedSlide,
                };
            } else {
                nextSlide = await fetchSlide(expectedNextIndex);
            }

            bufferedSlide = null;
            bufferedIndex = null;

            currentIndex = nextSlide.index;
            currentItem = nextSlide.item;
            renderCurrentItem();
        } catch (error) {
            console.error('Loading next slide failed:', error);
            showError();
        } finally {
            isAdvancing = false;
        }
    }

    function startSlideshow() {
        if (!isAutoplayUnlocked || !currentItem) return;
        if (rotationInterval) clearInterval(rotationInterval);

        renderCurrentItem();

        rotationInterval = setInterval(() => {
            void nextImage();
        }, ROTATION_TIME);
    }

    async function unlockMediaPlayback() {
        // Muted + playsinline is sufficient for autoplay in all modern browsers.
        // No fake video priming needed — just ensure the attributes are set.
        for (const videoEl of [mainVideo, bgVideo]) {
            videoEl.muted = true;
            videoEl.playsInline = true;
            videoEl.setAttribute('muted', '');
            videoEl.setAttribute('playsinline', '');
        }
    }

    function startHourlyPageRefresh() {
        setInterval(() => {
            window.location.reload();
        }, PAGE_REFRESH_MS);
    }

    async function initializeSlideshow() {
        startHourlyPageRefresh();

        if (!currentItem) {
            showError();
            return;
        }

        preloadItem(currentItem);
        void queueNextSlide();

        try {
            await unlockMediaPlayback();
            startSlideshow();
        } catch {
            if (unlockOverlay) {
                unlockOverlay.classList.remove('hidden');
            }
        }
    }

    if (unlockOverlay) {
        unlockOverlay.addEventListener('click', async () => {
            isAutoplayUnlocked = true;
            await unlockMediaPlayback();
            startSlideshow();

            unlockOverlay.style.opacity = '0';
            setTimeout(() => {
                unlockOverlay.classList.add('hidden');
            }, 500);
        });
    }


    initializeSlideshow();
</script>
</body>
</html>
