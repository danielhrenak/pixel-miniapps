<?php
/**
 * @var \App\View\AppView $this
 * @var string $query
 * @var \App\Model\Entity\ShareloopBook[] $results
 * @var string $pageTitle
 */
?>
<div class="shareloop-container">
    <h1><?= __('Hľadať knihu') ?></h1>

    <?= $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query']]) ?>
        <div class="search-form">
            <?= $this->Form->search('q', ['placeholder' => __('Názov, autor, ISBN...'), 'value' => $query]) ?>
            <?= $this->Form->submit(__('Hľadať'), ['class' => 'btn btn-primary']) ?>
        </div>
    <?= $this->Form->end() ?>

    <?php if ($query !== null): ?>
        <?php if (empty($results)): ?>
            <div class="no-results">
                <p><?= __('Žiadne výsledky pre: "' . h($query) . '"') ?></p>
            </div>
        <?php else: ?>
            <div class="search-results">
                <h3><?= sprintf(__('Nájdených %d výsledkov'), count($results)) ?></h3>

                <div class="books-grid">
                    <?php foreach ($results as $book): ?>
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
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

