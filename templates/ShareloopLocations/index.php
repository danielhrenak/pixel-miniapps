<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ShareloopUserLocation[] $locations
 * @var string $pageTitle
 */
?>
<div class="shareloop-container">
    <h1><?= __('Moje umiestnenia kníh') ?></h1>

    <div class="locations-actions">
        <?= $this->Html->link(__('+ Pridať nové umiestnenie'), ['action' => 'add'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php if (empty($locations)): ?>
        <div class="empty-state">
            <p><?= __('Nemáte ešte žiadne umiestnenia.') ?></p>
            <p><?= $this->Html->link(__('Vytvorte svoje prvé umiestnenie'), ['action' => 'add']) ?></p>
        </div>
    <?php else: ?>
        <div class="locations-grid">
            <?php foreach ($locations as $location): ?>
                <div class="location-card <?php if ($location->is_default): ?>default<?php endif; ?>">
                    <div class="location-header">
                        <h3><?= h($location->name) ?></h3>
                        <?php if ($location->is_default): ?>
                            <span class="badge badge-primary"><?= __('Predvolené') ?></span>
                        <?php endif; ?>
                    </div>

                    <?php if ($location->description): ?>
                        <p class="description"><?= h($location->description) ?></p>
                    <?php endif; ?>

                    <?php if ($location->address): ?>
                        <p class="address">
                            <i class="fa fa-map-marker"></i> <?= h($location->address) ?>
                        </p>
                    <?php endif; ?>

                    <div class="location-actions">
                        <?= $this->Html->link(__('Upraviť'),
                            ['action' => 'edit', $location->id],
                            ['class' => 'btn btn-sm']) ?>

                        <?php if (!$location->is_default): ?>
                            <?= $this->Html->link(__('Nastaviť ako predvolené'),
                                ['action' => 'setDefault', $location->id],
                                ['class' => 'btn btn-sm']) ?>
                        <?php endif; ?>

                        <?= $this->Html->link(__('Odstrániť'),
                            ['action' => 'delete', $location->id],
                            ['class' => 'btn btn-sm btn-danger', 'confirm' => __('Ste si istí?')]) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
    .locations-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .location-card {
        background: white;
        border: 2px solid #eee;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: all 0.3s;
    }

    .location-card.default {
        border-color: #28a745;
        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.2);
    }

    .location-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 15px;
    }

    .location-header h3 {
        margin: 0;
        color: #333;
    }

    .badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        background: #28a745;
        color: white;
    }

    .location-card p {
        margin: 10px 0;
        color: #666;
    }

    .location-card .description {
        font-style: italic;
    }

    .location-card .address {
        font-size: 0.9rem;
    }

    .location-actions {
        display: flex;
        gap: 5px;
        margin-top: 15px;
        flex-wrap: wrap;
    }

    .location-actions .btn {
        flex: 1;
        min-width: 100px;
    }
</style>

