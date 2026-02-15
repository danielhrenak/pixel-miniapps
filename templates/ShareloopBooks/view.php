<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ShareloopBook $book
 * @var \App\Model\Entity\ShareloopUserBook[] $userBooks
 * @var string $pageTitle
 */
?>
<div class="shareloop-container">
    <div class="book-detail">
        <div class="book-detail-header">
            <?php if ($book->cover_image_url): ?>
                <img src="<?= h($book->cover_image_url) ?>" alt="<?= h($book->title) ?>" class="book-cover-large">
            <?php else: ?>
                <div class="book-cover-placeholder-large">
                    <i class="fa fa-book fa-5x"></i>
                </div>
            <?php endif; ?>

            <div class="book-details">
                <h1><?= h($book->title) ?></h1>

                <?php if ($book->author): ?>
                    <p class="author"><strong><?= __('Autor:') ?></strong> <?= h($book->author) ?></p>
                <?php endif; ?>

                <?php if ($book->publisher): ?>
                    <p><strong><?= __('Vydavateľ:') ?></strong> <?= h($book->publisher) ?></p>
                <?php endif; ?>

                <?php if ($book->published_year): ?>
                    <p><strong><?= __('Rok vydania:') ?></strong> <?= h($book->published_year) ?></p>
                <?php endif; ?>

                <?php if ($book->isbn): ?>
                    <p><strong><?= __('ISBN:') ?></strong> <?= h($book->isbn) ?></p>
                <?php endif; ?>

                <?php if ($book->pages): ?>
                    <p><strong><?= __('Počet strán:') ?></strong> <?= h($book->pages) ?></p>
                <?php endif; ?>

                <?php if ($book->language): ?>
                    <p><strong><?= __('Jazyk:') ?></strong> <?= h($book->language) ?></p>
                <?php endif; ?>

                <?php if ($this->Authentication->getIdentity()): ?>
                    <div class="book-actions">
                        <?= $this->Html->link(__('Pridať na čítací zoznam'),
                            ['action' => 'addToReadingList', $book->id],
                            ['class' => 'btn btn-primary']) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($book->description): ?>
            <div class="book-description">
                <h3><?= __('Popis') ?></h3>
                <p><?= nl2br(h($book->description)) ?></p>
            </div>
        <?php endif; ?>

        <div class="available-copies">
            <h3><?= __('Dostupné kópie') ?></h3>

            <?php if (empty($book->shareloop_user_books)): ?>
                <p><?= __('Žiadne dostupné kópie') ?></p>
            <?php else: ?>
                <table class="copies-table">
                    <thead>
                        <tr>
                            <th><?= __('Vlastník') ?></th>
                            <th><?= __('Umiestnenie') ?></th>
                            <th><?= __('Stav') ?></th>
                            <th><?= __('Akcia') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($book->shareloop_user_books as $userBook): ?>
                            <tr>
                                <td><?= h($userBook->shareloop_user->email) ?></td>
                                <td>
                                    <?php if ($userBook->shareloop_user_location): ?>
                                        <?= h($userBook->shareloop_user_location->name) ?>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td><?= h($userBook->condition) ?></td>
                                <td>
                                    <?php if ($this->Authentication->getIdentity()): ?>
                                        <?= $this->Html->link(__('Požičať si'),
                                            ['action' => 'borrow', $userBook->id],
                                            ['class' => 'btn btn-sm btn-primary']) ?>
                                    <?php else: ?>
                                        <?= $this->Html->link(__('Prihlásiť sa'),
                                            ['controller' => 'ShareloopAuth', 'action' => 'login'],
                                            ['class' => 'btn btn-sm btn-info']) ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <div class="back-link">
        <?= $this->Html->link(__('← Späť na katalóg'), ['action' => 'index']) ?>
    </div>
</div>

