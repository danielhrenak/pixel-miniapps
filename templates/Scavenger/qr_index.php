<?php
/** @var array<int, array{url:string,qrUrl:string}> $items */
$tiles = array_slice($items, 0, 9);
?>
<section class="qr-sheet-page">
    <div class="qr-sheet-grid">
        <?php foreach ($tiles as $index => $item): ?>
            <a href="<?= h($item['url']) ?>" class="qr-tile" target="_blank" rel="noopener noreferrer">
                <span class="qr-number"><?= $index + 1 ?></span>
                <img src="<?= h($item['qrUrl']) ?>" alt="QR <?= $index + 1 ?>" class="qr-image">
            </a>
        <?php endforeach; ?>
    </div>
</section>

<style>
    .qr-sheet-page {
        min-height: 100vh;
        padding: 10mm;
        background: #fff;
    }

    .qr-sheet-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8mm;
    }

    .qr-tile {
        position: relative;
        display: block;
        border: 2px solid #475569;
        border-radius: 8px;
        padding: 4mm;
        break-inside: avoid;
        page-break-inside: avoid;
        background: #fff;
        box-shadow: 0 0 0 1px #cbd5e1 inset;
        text-decoration: none;
    }

    .qr-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 11mm;
        height: 11mm;
        margin-bottom: 3mm;
        border-radius: 999px;
        background: #0f172a;
        color: #fff;
        font-size: 18px;
        font-weight: 700;
        line-height: 1;
    }

    .qr-image {
        display: block;
        width: 100%;
        height: auto;
    }

    @media (max-width: 980px) {
        .qr-sheet-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 6mm;
        }
    }

    @media (max-width: 680px) {
        .qr-sheet-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 4mm;
        }

        .qr-sheet-page {
            padding: 4mm;
        }

        .qr-tile {
            padding: 3mm;
        }

        .qr-number {
            min-width: 9mm;
            height: 9mm;
            font-size: 14px;
            margin-bottom: 2.5mm;
        }
    }

    @media print {
        .qr-sheet-page {
            padding: 0;
        }

        .qr-sheet-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 6mm;
        }
    }
</style>

