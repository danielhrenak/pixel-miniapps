<?php
/** @var array<int, array{url:string,qrUrl:string}> $items */
?>
<section class="qr-sheet-page">
    <div class="qr-sheet-grid">
        <?php foreach ($items as $item): ?>
            <a href="<?= h($item['url']) ?>" class="qr-tile" target="_blank" rel="noopener noreferrer">
                <img src="<?= h($item['qrUrl']) ?>" alt="QR" class="qr-image">
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
        grid-template-columns: repeat(4, 1fr);
        gap: 8mm;
    }

    .qr-tile {
        display: block;
        border: 1px dashed #d1d5db;
        padding: 4mm;
        break-inside: avoid;
        page-break-inside: avoid;
        background: #fff;
    }

    .qr-image {
        display: block;
        width: 100%;
        height: auto;
    }

    @media (max-width: 980px) {
        .qr-sheet-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 680px) {
        .qr-sheet-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media print {
        .qr-sheet-page {
            padding: 0;
        }

        .qr-sheet-grid {
            gap: 6mm;
        }

        .qr-tile {
            border-color: #e5e7eb;
        }
    }
</style>

