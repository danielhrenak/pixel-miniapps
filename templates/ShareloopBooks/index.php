<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ShareloopBook[] $books
 * @var string $pageTitle
 */
?>
<div class="shareloop-container">
    <div class="header-section">
        <h1><?= __('Katalóg kníh - ShareLoop') ?></h1>
        <p><?= __('Objavte a zdieľajte knihy s komunitou') ?></p>
    </div>

    <?php if ($this->Authentication->getIdentity()): ?>
        <div class="user-actions">
            <?= $this->Html->link(__('Moja knižnica'), ['action' => 'myBooks'], ['class' => 'btn btn-primary']) ?>
            <?= $this->Html->link(__('Pridať novú knihu'), ['action' => 'add'], ['class' => 'btn btn-success']) ?>
            <?= $this->Html->link(__('Môj zoznam na čítanie'), ['action' => 'myReadingList'], ['class' => 'btn btn-info']) ?>
        </div>
    <?php endif; ?>

    <div class="search-section">
        <?= $this->Html->link(__('Hľadať knihu'), ['action' => 'search'], ['class' => 'btn btn-outline']) ?>
    </div>

    <div class="books-grid">
        <?php foreach ($books as $book): ?>
            <div class="book-card">
                <?php if ($book->cover_image_url): ?>
                    <img src="<?= h($book->cover_image_url) ?>" alt="<?= h($book->title) ?>" class="book-cover">
                <?php else: ?>
                    <div class="book-cover-placeholder">
                        <i class="fa fa-book"></i>
                    </div>
                <?php endif; ?>

                <div class="book-info">
                    <h3><?= $this->Html->link(h($book->title), ['action' => 'view', $book->id]) ?></h3>
                    <?php if ($book->author): ?>
                        <p class="author"><?= h($book->author) ?></p>
                    <?php endif; ?>
                    <?php if ($book->isbn): ?>
                        <p class="isbn">ISBN: <?= h($book->isbn) ?></p>
                    <?php endif; ?>

                    <div class="book-actions">
                        <?= $this->Html->link(__('Detaily'), ['action' => 'view', $book->id], ['class' => 'btn btn-sm']) ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<<') ?>
            <?= $this->Paginator->prev('<') ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next('>') ?>
            <?= $this->Paginator->last('>>') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>

