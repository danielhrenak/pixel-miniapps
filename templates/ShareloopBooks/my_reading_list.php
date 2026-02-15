<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ShareloopReadingList[] $readingList
 * @var string $pageTitle
 */
?>
<div class="shareloop-container">
    <h1><?= __('Môj zoznam na čítanie') ?></h1>

    <?php if (empty($readingList)): ?>
        <div class="empty-state">
            <p><?= __('Váš zoznam je prázdny.') ?></p>
            <p><?= $this->Html->link(__('Prejsť na katalóg a pridať knihy'), ['action' => 'index']) ?></p>
        </div>
    <?php else: ?>
        <table class="reading-list-table">
            <thead>
                <tr>
                    <th><?= __('Názov') ?></th>
                    <th><?= __('Autor') ?></th>
                    <th><?= __('Priorita') ?></th>
                    <th><?= __('Stav') ?></th>
                    <th><?= __('Akcia') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($readingList as $item): ?>
                    <tr>
                        <td><?= $this->Html->link(h($item->shareloop_book->title),
                            ['action' => 'view', $item->shareloop_book->id]) ?></td>
                        <td><?= h($item->shareloop_book->author) ?></td>
                        <td><?= h($item->priority) ?></td>
                        <td><?= h($item->status) ?></td>
                        <td>
                            <?= $this->Html->link(__('Odstrániť'),
                                ['action' => 'removeFromReadingList', $item->id],
                                ['class' => 'btn btn-sm btn-danger', 'confirm' => __('Ste si istí?')]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

