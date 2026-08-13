<?php
/**
 * @var \App\View\AppView $this
 * @var string $content
 * @var string|null $error
 * @var bool $saved
 * @var string $csrfToken
 */
$linkCount = count(array_filter(preg_split('/[\s,]+/', (string)$content) ?: []));
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>PAPO TV – správa linkov</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: #14161a;
            color: #e6e8eb;
            min-height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 32px 16px;
        }
        .card {
            width: 100%;
            max-width: 720px;
            background: #1d2026;
            border: 1px solid #2b2f37;
            border-radius: 12px;
            padding: 24px;
        }
        h1 { margin: 0 0 4px; font-size: 20px; }
        p.hint { margin: 0 0 20px; color: #9aa0aa; font-size: 13px; line-height: 1.5; }
        label { display: block; margin-bottom: 6px; font-size: 13px; color: #c3c8d0; }
        textarea, input[type="password"] {
            width: 100%;
            background: #14161a;
            border: 1px solid #333844;
            border-radius: 8px;
            color: #e6e8eb;
            padding: 10px 12px;
            font-size: 14px;
            font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
        }
        textarea { min-height: 320px; resize: vertical; line-height: 1.5; }
        input[type="password"] { font-family: inherit; }
        .row { margin-bottom: 18px; }
        .actions { display: flex; align-items: center; gap: 16px; }
        button {
            background: #3b82f6;
            border: none;
            border-radius: 8px;
            color: #fff;
            padding: 11px 22px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }
        button:hover { background: #2f6fe0; }
        .count { color: #9aa0aa; font-size: 13px; }
        .alert { padding: 11px 14px; border-radius: 8px; margin-bottom: 18px; font-size: 14px; }
        .alert-error { background: #3a1d20; border: 1px solid #6b2b31; color: #f2b8bd; }
        .alert-ok { background: #16311f; border: 1px solid #2c6b41; color: #a7e0bd; }
    </style>
</head>
<body>
    <div class="card">
        <h1>PAPO TV – správa linkov</h1>
        <p class="hint">
            Vlož zoznam odkazov na obrázky/videá – jeden link na riadok alebo oddelené čiarkami.
            Po uložení sa slideshow načíta z tohto zoznamu.
        </p>

        <?php if ($saved) : ?>
            <div class="alert alert-ok">✓ Uložené. Zoznam bol aktualizovaný.</div>
        <?php endif; ?>
        <?php if (!empty($error)) : ?>
            <div class="alert alert-error"><?= h($error) ?></div>
        <?php endif; ?>

        <form method="post" action="">
            <input type="hidden" name="_csrfToken" value="<?= h($csrfToken) ?>">
            <div class="row">
                <label for="links">Linky (<?= (int)$linkCount ?>)</label>
                <textarea id="links" name="links" placeholder="https://priklad.sk/obrazok1.jpg&#10;https://priklad.sk/video.mp4"><?= h($content) ?></textarea>
            </div>
            <div class="row">
                <label for="password">Heslo</label>
                <input type="password" id="password" name="password" autocomplete="current-password" required>
            </div>
            <div class="actions">
                <button type="submit">Uložiť</button>
                <span class="count">Zmeny sa prejavia okamžite.</span>
            </div>
        </form>
    </div>
</body>
</html>
