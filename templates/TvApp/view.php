<!-- templates/TvApp/view.php -->
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Team TV Dashboard</title>
    <link rel="stylesheet" href="/css/tv-app/style.css?v=4.0">
    <link rel="stylesheet" href="/css/tv-app/snow.css?v=4.0">
</head>
<body>
<div id="app" class="layout">

    <!-- DATA / IFRAME -->
    <section id="data-section" class="panel data">
        <div class="floating-title" id="data-title">Live systémové dáta</div>
        <div id="load-countdown" class="load-countdown"></div>
        <iframe id="data-iframe" src="" title="Live data"></iframe>
    </section>

    <!-- TEAM WALL -->
    <section id="wall" class="panel wall">
        <div id="wall-posts"></div>
        <div id="wall-loader" class="wall-loader" style="display:none;">
            <div class="spinner"></div>
        </div>
    </section>

    <!-- INFO WIDGET (weather + nameday, auto when space free) -->
    <section id="info" class="panel info">
        <div class="info-item">
            <div class="info-label">Bratislava</div>
            <div class="info-value" id="weather">—</div>
            <div class="info-sub" id="weather-desc">—</div>
        </div>
        <div class="divider"></div>
        <div class="info-item">
            <div class="info-label">Meniny</div>
            <div class="info-value" id="nameday">—</div>
        </div>
    </section>

</div>

<!-- ANNOUNCEMENTS popup (moved outside layout so it does not affect grid) -->
<section id="announcements" class="panel announcements" aria-live="polite">
    <div id="announcement-list"></div>
</section>

<script>
    // Data from controller
    window.tvAppData = <?= json_encode(['links' => $links, 'announcements' => $announcements, 'wallPosts' => $wallPosts]) ?>;
</script>
<script src="/js/tv-app/script.js"></script>
<script src="/js/tv-app/snow.js"></script>

</body>
</html>
