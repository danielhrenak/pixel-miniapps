<?php
/**
 * Custom lightweight layout with Tailwind CDN for Scavenger pages.
 *
 * @var \App\View\AppView $this
 */
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->fetch('title') ?: 'Scavenger' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body class="min-h-screen bg-slate-950 text-slate-50 antialiased">
    <?= $this->fetch('content') ?>
</body>
</html>

