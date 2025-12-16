<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Správa položiek</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }

        h1 {
            color: white;
            font-size: 32px;
        }

        .btn-add-new {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-add-new:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(40, 167, 69, 0.4);
        }

        .filters {
            display: flex;
            gap: 10px;
            background: rgba(255, 255, 255, 0.1);
            padding: 10px;
            border-radius: 8px;
            backdrop-filter: blur(10px);
            flex-wrap: wrap;
        }

        .filter-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .filter-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
        }

        .filter-btn.active {
            background: white;
            color: #667eea;
            border-color: white;
        }

        .items-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
        }

        .item-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s, box-shadow 0.2s, opacity 0.3s;
            display: flex;
            flex-direction: column;
        }

        .item-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }

        .item-card.hidden {
            opacity: 0.6;
            border: 2px solid #dc3545;
        }

        .item-card.hidden-filter {
            display: none;
        }

        .item-preview {
            width: 100%;
            height: 200px;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        .item-preview img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }

        .item-preview.no-image {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-size: 14px;
            text-align: center;
        }

        .item-preview iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .item-type-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            background: rgba(2, 6, 23, 0.8);
            color: white;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            backdrop-filter: blur(4px);
        }

        .item-content {
            padding: 16px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .item-author {
            font-size: 12px;
            color: #667eea;
            font-weight: 600;
            margin-bottom: 4px;
            text-transform: uppercase;
        }

        .item-text {
            font-size: 14px;
            color: #333;
            margin-bottom: 12px;
            line-height: 1.5;
            flex: 1;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .item-url {
            font-size: 12px;
            color: #667eea;
            margin-bottom: 12px;
            word-break: break-all;
        }

        .item-url a {
            color: #667eea;
            text-decoration: none;
            transition: color 0.2s;
        }

        .item-url a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .item-meta {
            font-size: 11px;
            color: #999;
            margin-bottom: 12px;
        }

        .item-actions {
            display: flex;
            gap: 8px;
            border-top: 1px solid #eee;
            padding-top: 12px;
        }

        .btn {
            flex: 1;
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
        }

        .btn-hide {
            background: #dc3545;
            color: white;
        }

        .btn-hide:hover {
            background: #c82333;
        }

        .btn-show {
            background: #28a745;
            color: white;
        }

        .btn-show:hover {
            background: #218838;
        }

        .btn-edit {
            background: #007bff;
            color: white;
            flex: 0.5;
        }

        .btn-edit:hover {
            background: #0056b3;
        }

        .btn.loading {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .empty-state {
            background: white;
            border-radius: 12px;
            padding: 60px 20px;
            text-align: center;
            color: #999;
        }

        .empty-state h2 {
            color: #333;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📋 Správa položiek</h1>
            <a href="/tv-app-admin/add/1" class="btn-add-new">+ Pridať nový item</a>
        </div>

        <!-- Hidden CSRF Token for JavaScript -->
        <input type="hidden" id="csrf-token" value="<?= $this->request->getAttribute('csrfToken') ?>">

        <!-- Filters -->
        <div class="filters">
            <button class="filter-btn active" data-filter="all">Všetky (<?= count($items->toArray()) ?>)</button>
            <button class="filter-btn" data-filter="visible">Viditeľné (<?= count(array_filter($items->toArray(), fn($i) => !$i->hidden)) ?>)</button>
            <button class="filter-btn" data-filter="hidden">Skryté (<?= count(array_filter($items->toArray(), fn($i) => $i->hidden)) ?>)</button>
        </div>

        <?php if (empty($items->toArray())): ?>
            <div class="empty-state" style="margin-top: 40px;">
                <h2>Zatiaľ žiadne položky</h2>
                <p>Začnite pridávaním nových položiek do svojej TV aplikácie.</p>
            </div>
        <?php else: ?>
            <div class="items-grid" style="margin-top: 30px;">
                <?php foreach ($items as $item): ?>
                    <div class="item-card <?= $item->hidden ? 'hidden' : '' ?>" data-item-id="<?= $item->id ?>" data-status="<?= $item->hidden ? 'hidden' : 'visible' ?>">
                        <!-- Preview -->
                        <div class="item-preview <?= (!$item->image && !$item->video) ? 'no-image' : '' ?>">
                            <?php if ($item->image): ?>
                                <img src="<?= h($item->image) ?>" alt="Preview">
                                <div class="item-type-badge">🖼️ Obrázok</div>
                            <?php elseif ($item->video): ?>
                                <?php
                                    // Extract YouTube video ID
                                    $videoRegex = '/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([^&\n?#]+)/';
                                    $match = [];
                                    if (preg_match($videoRegex, $item->video, $match) && isset($match[1])) {
                                        $videoId = $match[1];
                                        $embedUrl = "https://www.youtube.com/embed/{$videoId}";
                                    } else {
                                        $embedUrl = null;
                                    }
                                ?>
                                <?php if ($embedUrl): ?>
                                    <iframe src="<?= $embedUrl ?>" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                <?php endif; ?>
                                <div class="item-type-badge">📺 Video</div>
                            <?php else: ?>
                                📝 Text
                                <div class="item-type-badge">📝 Text</div>
                            <?php endif; ?>
                        </div>

                        <!-- Content -->
                        <div class="item-content">
                            <?php if ($item->author): ?>
                                <div class="item-author"><?= h($item->author) ?></div>
                            <?php endif; ?>

                            <?php if ($item->text): ?>
                                <div class="item-text"><?= h($item->text) ?></div>
                            <?php endif; ?>

                            <?php if ($item->video): ?>
                                <div class="item-url">
                                    <strong>Video:</strong>
                                    <a href="<?= h($item->video) ?>" target="_blank" rel="noopener">Otvoriť na YouTube →</a>
                                </div>
                            <?php elseif ($item->image): ?>
                                <div class="item-url">
                                    <strong>URL:</strong>
                                    <a href="<?= h($item->image) ?>" target="_blank" rel="noopener">Otvoriť obrázok →</a>
                                </div>
                            <?php endif; ?>

                            <div class="item-meta">
                                📅 <?= $item->created ? $item->created->format('d.m.Y H:i') : 'Neuvedené' ?>
                                <?php if ($item->hidden): ?>
                                    <br>🔒 Skryté
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="item-actions">
                            <button class="btn <?= $item->hidden ? 'btn-show' : 'btn-hide' ?> toggle-btn" data-item-id="<?= $item->id ?>" data-hidden="<?= $item->hidden ? '1' : '0' ?>">
                                <?= $item->hidden ? '👁️ Zobraziť' : '👁️ Skryť' ?>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Toggle button functionality
        document.querySelectorAll('.toggle-btn').forEach(btn => {
            btn.addEventListener('click', async (e) => {
                const btn = e.target;
                const itemId = btn.dataset.itemId;
                const itemCard = document.querySelector(`[data-item-id="${itemId}"]`);

                btn.classList.add('loading');
                btn.disabled = true;

                try {
                    const csrfToken = document.getElementById('csrf-token').value;

                    const response = await fetch(`/tv-app-admin/toggle/${itemId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-Token': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        // Update card status
                        const newStatus = data.hidden ? 'hidden' : 'visible';
                        itemCard.dataset.status = newStatus;

                        if (data.hidden) {
                            itemCard.classList.add('hidden');
                            btn.textContent = '👁️ Zobraziť';
                            btn.classList.remove('btn-hide');
                            btn.classList.add('btn-show');
                        } else {
                            itemCard.classList.remove('hidden');
                            btn.textContent = '👁️ Skryť';
                            btn.classList.remove('btn-show');
                            btn.classList.add('btn-hide');
                        }

                        // Reapply current filter
                        applyFilter(document.querySelector('.filter-btn.active').dataset.filter);
                    } else {
                        alert('Chyba pri zmene položky.');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Chyba pri komunikácii so serverom.');
                } finally {
                    btn.classList.remove('loading');
                    btn.disabled = false;
                }
            });
        });

        // Filter functionality
        function applyFilter(filterType) {
            const itemCards = document.querySelectorAll('.item-card');

            itemCards.forEach(card => {
                const status = card.dataset.status;

                if (filterType === 'all') {
                    card.classList.remove('hidden-filter');
                } else if (filterType === 'visible' && status === 'visible') {
                    card.classList.remove('hidden-filter');
                } else if (filterType === 'hidden' && status === 'hidden') {
                    card.classList.remove('hidden-filter');
                } else {
                    card.classList.add('hidden-filter');
                }
            });
        }

        // Filter button click handlers
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                e.target.classList.add('active');
                applyFilter(e.target.dataset.filter);
            });
        });
    </script>
</body>
</html>
