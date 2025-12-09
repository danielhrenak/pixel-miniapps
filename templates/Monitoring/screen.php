<?php
/**
 * @var array $comments
 * @var array $urls
 * @var bool $comment_section_enabled
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Cycle</title>
    <link rel="stylesheet" href="/css/monitoring.css?v=4.0">
</head>
<body>
    <iframe id="monitorFrame"></iframe>

    <?php if ($comment_section_enabled) {?>
        <div id="jokePopup"></div>
    <?php } ?>

    <div id="timer">
        <div id="progressBar">
            <div id="progress"></div>
        </div>
    </div>

    <script>
        const comments = <?= json_encode($comments); ?>;
        const urls = <?= json_encode($urls); ?>;
    </script>
    <script src="/js/monitoring.js"></script>
</body>
</html>
