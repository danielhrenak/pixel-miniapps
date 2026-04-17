<?php
/** @var array<int, array{title:string,description:string,url:string,qrUrl:string}> $items */
?>
<section class="flex min-h-screen items-center justify-center px-4 py-8">
    <div class="w-full max-w-6xl rounded-3xl border border-slate-700 bg-slate-900/70 p-5 shadow-2xl backdrop-blur md:p-8">
        <h1 class="mb-2 text-center text-3xl font-bold tracking-tight md:text-4xl">Scavenger Stages</h1>
        <p class="mb-8 text-center text-slate-300">Vyber stage cez link alebo naskenuj QR kod.</p>

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($items as $item): ?>
                <article class="rounded-2xl border border-slate-700 bg-slate-950/60 p-4">
                    <h2 class="mb-3 text-lg font-semibold text-slate-100"><?= h($item['title']) ?></h2>
                    <p class="mb-4 text-sm text-slate-300"><?= h($item['description']) ?></p>
                    <a
                        href="<?= h($item['url']) ?>"
                        class="mb-4 inline-block rounded-lg bg-sky-500 px-4 py-2 font-semibold text-slate-950 transition hover:bg-sky-400"
                    >
                        Otvorit stage
                    </a>
                    <div class="rounded-xl border border-slate-700 bg-slate-900/60 p-3">
                        <img
                            src="<?= h($item['qrUrl']) ?>"
                            alt="QR kod pre <?= h($item['title']) ?>"
                            class="mx-auto h-52 w-52 object-contain"
                        >
                    </div>
                    <p class="mt-3 break-all text-xs text-slate-400"><?= h($item['url']) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

