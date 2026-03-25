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

    <!-- Settings / Upload trigger -->
    <button id="settings-btn" class="absolute bottom-8 right-8 p-4 bg-white/10 backdrop-blur-md rounded-full hover:bg-white/20 transition-all opacity-20 hover:opacity-100 z-50" title="Pridať súbory">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
    </button>
    <input id="file-input" type="file" accept="image/*,video/mp4,video/webm,video/ogg,video/quicktime" multiple class="hidden" />
</div>

<script>
    const SERVER_ITEMS = <?= $serverItemsJson ?? '[]' ?>;
    const PAGE_REFRESH_MS = 60 * 60 * 1000;
    const ROTATION_TIME = 30000;
    const PRELOAD_COUNT = 3;

    let images = normalizeSlideshowItems(JSON.parse(localStorage.getItem('slideshow-images') || JSON.stringify(SERVER_ITEMS)));
    let currentIndex = 0;
    let rotationInterval = null;
    let errorTimeout = null;
    let isAutoplayUnlocked = true;
    const preloadedElements = new Map();

    const bgBlur = document.getElementById('bg-blur');
    const bgVideo = document.getElementById('bg-video');
    const mainImage = document.getElementById('main-image');
    const mainVideo = document.getElementById('main-video');
    const progressBar = document.getElementById('progress-bar');
    const errorMsg = document.getElementById('error-msg');
    const loadingIndicator = document.getElementById('loading-indicator');
    const settingsBtn = document.getElementById('settings-btn');
    const fileInput = document.getElementById('file-input');
    const unlockOverlay = document.getElementById('unlock-overlay');

    function normalizeExplicitMediaType(value) {
        if (typeof value !== 'string') return null;

        const normalized = value.trim().toLowerCase();
        if (!normalized) return null;

        if (normalized === 'video' || normalized.startsWith('video/')) return 'video';
        if (normalized === 'image' || normalized.startsWith('image/')) return 'image';

        if (['mp4', 'webm', 'ogg', 'mov', 'movie', 'clip'].includes(normalized)) return 'video';
        if (['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif', 'photo', 'picture'].includes(normalized)) return 'image';

        return null;
    }

    function extractMediaTypeFromDataUrl(url) {
        if (typeof url !== 'string') return null;
        if (url.startsWith('data:video/')) return 'video';
        if (url.startsWith('data:image/')) return 'image';
        return null;
    }

    function inferMediaTypeFromUrl(url) {
        if (typeof url !== 'string') return null;

        const videoExtensions = ['.mp4', '.webm', '.ogg', '.mov'];
        const imageExtensions = ['.jpg', '.jpeg', '.png', '.gif', '.webp', '.avif', '.bmp', '.svg'];
        const lowerUrl = url.toLowerCase();

        if (videoExtensions.some(ext => lowerUrl.includes(ext)) || lowerUrl.includes('#video')) {
            return 'video';
        }

        if (imageExtensions.some(ext => lowerUrl.includes(ext))) {
            return 'image';
        }

        return extractMediaTypeFromDataUrl(url);
    }

    function getDriveDirectLink(shareUrl) {
        if (!isGoogleDriveUrl(shareUrl)) {
            return shareUrl;
        }

        const shareMatch = shareUrl.match(/\/d\/([a-zA-Z0-9_-]+)/);
        if (shareMatch) {
            return `https://drive.google.com/uc?export=download&id=${shareMatch[1]}`;
        }
        const idMatch = shareUrl.match(/[?&]id=([a-zA-Z0-9_-]+)/);
        if (idMatch) {
            return `https://drive.google.com/uc?export=download&id=${idMatch[1]}`;
        }
        return shareUrl;
    }

    function getGoogleDriveFileId(url) {
        const shareMatch = url.match(/\/d\/([a-zA-Z0-9_-]+)/);
        if (shareMatch) return shareMatch[1];
        const idMatch = url.match(/[?&]id=([a-zA-Z0-9_-]+)/);
        if (idMatch) return idMatch[1];
        return null;
    }

    function isGoogleDriveUrl(url) {
        return typeof url === 'string' && url.includes('drive.google.com');
    }

    function getDriveVideoUrl(fileId) {
        return `https://drive.google.com/uc?export=download&id=${fileId}`;
    }

    function getDriveImageUrls(fileId) {
        return [
            `https://drive.google.com/uc?export=view&id=${fileId}`,
            `https://drive.google.com/thumbnail?id=${fileId}&sz=w1920`,
            `https://drive.google.com/uc?export=download&id=${fileId}`,
        ];
    }

    function getDriveImageCandidateUrlsFromUrl(url) {
        const fileId = getGoogleDriveFileId(url);
        if (!fileId) return [url];
        return getDriveImageUrls(fileId);
    }

    function getItemUrl(item) {
        if (typeof item === 'string') return item.trim();
        if (!item || typeof item !== 'object') return '';

        const url = item.url ?? item.src ?? item.href ?? item.link ?? '';
        return typeof url === 'string' ? url.trim() : '';
    }

    function normalizeSlideshowItem(item) {
        if (typeof item === 'string') {
            const url = item.trim();
            if (!url) return null;

            return {
                url,
                renderUrl: url,
                type: inferMediaTypeFromUrl(url) || 'image',
                mimeType: null,
            };
        }

        if (!item || typeof item !== 'object') return null;

        const url = getItemUrl(item);
        if (!url) return null;

        const explicitType = normalizeExplicitMediaType(
            item.type ?? item.mediaType ?? item.kind ?? item.mediaKind ?? item.format
        );
        const mimeType = typeof (item.mimeType ?? item.mime) === 'string'
            ? (item.mimeType ?? item.mime).trim()
            : null;

        const renderUrl = typeof item.renderUrl === 'string' && item.renderUrl.trim() !== ''
            ? item.renderUrl.trim()
            : url;

        return {
            ...item,
            url,
            renderUrl,
            type: explicitType ?? normalizeExplicitMediaType(mimeType) ?? inferMediaTypeFromUrl(url) ?? 'image',
            mimeType,
        };
    }

    function normalizeSlideshowItems(items) {
        if (!Array.isArray(items)) return [];

        return items
            .map((item) => normalizeSlideshowItem(item))
            .filter((item) => item && item.url);
    }

    function getItemMediaType(item) {
        if (!item) return null;

        const explicitType = normalizeExplicitMediaType(item.type);
        if (explicitType) return explicitType;

        const mimeTypeType = normalizeExplicitMediaType(item.mimeType);
        if (mimeTypeType) return mimeTypeType;

        const url = getItemUrl(item);
        return extractMediaTypeFromDataUrl(url) ?? inferMediaTypeFromUrl(url);
    }

    function transformUrl(item) {
        if (item && typeof item.renderUrl === 'string' && item.renderUrl.trim() !== '') {
            return item.renderUrl.trim();
        }

        return getItemUrl(item);
    }

    function preloadNext() {
         if (images.length <= 1) return;
         for (let i = 1; i <= PRELOAD_COUNT; i++) {
             const nextIdx = (currentIndex + i) % images.length;
             const item = images[nextIdx];
             const url = item?.renderUrl || item?.url || '';
             const isVid = item?.type === 'video';

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

         const item = images[currentIndex];

         // Hide current content and start loading indicator immediately
         mainImage.style.opacity = '0';
         mainVideo.style.opacity = '0';
         bgVideo.style.opacity = '0';
         loadingIndicator.style.opacity = '1';

         // Start progress bar right away
         progressBar.style.transition = 'none';
         progressBar.style.width = '0%';
         progressBar.offsetHeight; // force reflow
         progressBar.style.transition = `width ${ROTATION_TIME}ms linear`;
         progressBar.style.width = '100%';

         // Use renderUrl from server-prepared item
         const url = item?.renderUrl || item?.url || '';
         const isVid = item?.type === 'video';

         if (preloadedElements.has(url)) {
             loadingIndicator.style.opacity = '0';
         }

         setTimeout(() => {
             if (isVid) {
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
                         console.error("Video play failed:", err);
                         // Fallback to image when a URL guessed as video is actually an image.
                         tryAsImage(url, item);
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
                     tryAsImage(url, item);
                 };
                 bgBlur.style.backgroundImage = 'none';
             } else {
                 tryAsImage(url, item);
             }
         }, 500);
     }

    function tryAsImage(url, item = null, candidateIndex = 0) {
        const candidates = item && isGoogleDriveUrl(getItemUrl(item))
            ? getDriveImageCandidateUrlsFromUrl(getItemUrl(item))
            : [url];
        const candidateUrl = candidates[candidateIndex] || url;

        mainVideo.classList.add('hidden');
        mainVideo.pause();
        bgVideo.pause();
        mainImage.classList.remove('hidden');
        mainImage.src = candidateUrl;
        bgBlur.style.backgroundImage = `url(${candidateUrl})`;

        mainImage.onload = () => {
            mainImage.style.opacity = '1';
            loadingIndicator.style.opacity = '0';
            preloadNext();
        };
        mainImage.onerror = (e) => {
            if (candidateIndex + 1 < candidates.length) {
                tryAsImage(url, item, candidateIndex + 1);
                return;
            }

            console.error("Image load failed for URL:", candidateUrl, e);
            showError();
        };
    }

    function nextImage() {
        if (images.length === 0) return;
        currentIndex = (currentIndex + 1) % images.length;
        updateSlideshow();
    }

    function startSlideshow() {
        if (!isAutoplayUnlocked) return;
        if (rotationInterval) clearInterval(rotationInterval);
        updateSlideshow();
        rotationInterval = setInterval(nextImage, ROTATION_TIME);
    }

    async function unlockMediaPlayback() {
        // Prime muted playback in a user gesture context to satisfy stricter autoplay policies.
        const primeVideo = async (videoEl) => {
            const originalSrc = videoEl.getAttribute('src') || '';

            try {
                videoEl.muted = true;
                videoEl.playsInline = true;
                videoEl.setAttribute('muted', 'muted');
                videoEl.setAttribute('playsinline', 'playsinline');

                // Tiny silent video keeps payload negligible while unlocking media pipeline.
                videoEl.src = 'data:video/mp4;base64,AAAAIGZ0eXBpc29tAAACAGlzb21pc28yYXZjMQAAAAhmcmVlAAACQG1kYXQhEAUgpAAB9AAAB9AAAB9AAAB9AAAB9AAAB9AAAB9AAAB9AAAB9AAAB9A=';
                videoEl.load();

                const playPromise = videoEl.play();
                if (playPromise !== undefined) {
                    await playPromise;
                }
                videoEl.pause();
            } catch (e) {
                console.warn('Media unlock failed for one video element:', e);
            } finally {
                if (originalSrc) {
                    videoEl.src = originalSrc;
                    videoEl.load();
                } else {
                    videoEl.removeAttribute('src');
                    videoEl.load();
                }
            }
        };

        await Promise.all([primeVideo(mainVideo), primeVideo(bgVideo)]);
    }

    function startHourlyPageRefresh() {
        setInterval(() => {
            window.location.reload();
        }, PAGE_REFRESH_MS);
    }

    async function initializeSlideshow() {
        startHourlyPageRefresh();

        images = normalizeSlideshowItems(images);
        localStorage.setItem('slideshow-images', JSON.stringify(images));

        // Try silent autoplay immediately (works for muted content).
        // If the browser blocks it, surface the click-to-start overlay.
        try {
            await unlockMediaPlayback();
            startSlideshow();
        } catch {
            unlockOverlay.classList.remove('hidden');
        }
    }

    unlockOverlay.addEventListener('click', async () => {
        isAutoplayUnlocked = true;
        await unlockMediaPlayback();
        startSlideshow();

        unlockOverlay.style.opacity = '0';
        setTimeout(() => {
            unlockOverlay.classList.add('hidden');
        }, 500);
    });

    // Removed automatic start
    // startSlideshow();

    settingsBtn.addEventListener('click', () => {
        fileInput.value = '';
        fileInput.click();
    });

    function persistImagesAndRestart(nextImages) {
        images = normalizeSlideshowItems(nextImages);
        localStorage.setItem('slideshow-images', JSON.stringify(images));
        currentIndex = 0;
        preloadedElements.clear();
        startSlideshow();
    }

    fileInput.addEventListener('change', (e) => {
        const files = e.target.files;
        if (!files) return;

        const selectedFiles = Array.from(files);
        if (selectedFiles.length === 0) return;

        const currentImages = [...images];
        let processedCount = 0;

        selectedFiles.forEach(file => {
            const reader = new FileReader();
            reader.onload = (event) => {
                const base64 = event.target.result;
                if (base64) {
                    currentImages.push({
                        url: base64,
                        type: file.type.startsWith('video/') ? 'video' : 'image',
                        mimeType: file.type || null,
                        name: file.name,
                    });
                }

                processedCount += 1;
                if (processedCount === selectedFiles.length) {
                    persistImagesAndRestart(currentImages);
                }
            };
            reader.onerror = () => {
                processedCount += 1;
                if (processedCount === selectedFiles.length) {
                    persistImagesAndRestart(currentImages);
                }
            };
            reader.readAsDataURL(file);
        });
    });

    initializeSlideshow();
</script>
</body>
</html>
