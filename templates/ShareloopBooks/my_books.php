<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ShareloopUserBook[] $userBooks
 * @var string $pageTitle
 */
?>
<div class="shareloop-container">
    <h1><?= __('Moja knižnica') ?></h1>

    <div class="my-books-actions">
        <?= $this->Html->link(__('+ Pridať novú knihu'), ['action' => 'add'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php if (empty($userBooks)): ?>
        <div class="empty-state">
            <p><?= __('Nemáte ešte žiadne knihy.') ?></p>
            <p><?= $this->Html->link(__('Pridajte svoju prvú knihu'), ['action' => 'add']) ?></p>
        </div>
    <?php else: ?>
        <div class="user-books-grid">
            <?php foreach ($userBooks as $userBook): ?>
                <div class="user-book-card">
                    <?php if ($userBook->shareloop_book->cover_image_url): ?>
                        <img src="<?= h($userBook->shareloop_book->cover_image_url) ?>"
                             alt="<?= h($userBook->shareloop_book->title) ?>"
                             class="book-cover">
                    <?php else: ?>
                        <div class="book-cover-placeholder">
                            <i class="fa fa-book"></i>
                        </div>
                    <?php endif; ?>

                    <div class="user-book-info">
                        <h3><?= h($userBook->shareloop_book->title) ?></h3>
                        <p class="author"><?= h($userBook->shareloop_book->author) ?></p>

                        <?php if ($userBook->shareloop_user_location): ?>
                            <p class="location">
                                <strong><?= __('Miesto:') ?></strong>
                                <?= h($userBook->shareloop_user_location->name) ?>
                            </p>
                        <?php endif; ?>

                        <p class="condition">
                            <strong><?= __('Stav:') ?></strong>
                            <?= h($userBook->condition) ?>
                        </p>

                        <?php if ($userBook->sharing_type): ?>
                            <p class="sharing">
                                <strong><?= __('Typ zdieľania:') ?></strong>
                                <?= h($userBook->sharing_type) ?>
                            </p>
                        <?php endif; ?>

                        <div class="book-actions">
                            <?= $this->Html->link(__('Upraviť'),
                                ['action' => 'edit', $userBook->id],
                                ['class' => 'btn btn-sm']) ?>
                            <?= $this->Html->link(__('Odstrániť'),
                                ['action' => 'delete', $userBook->id],
                                ['class' => 'btn btn-sm btn-danger', 'confirm' => __('Ste si istí?')]) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

