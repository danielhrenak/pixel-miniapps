<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ShareloopUserLocation $location
 * @var string $pageTitle
 */
?>
<div class="shareloop-container">
    <h1><?= sprintf(__('Upraviť umiestnenie: %s'), h($location->name)) ?></h1>

    <div class="form-section">
        <?= $this->Form->create($location, ['url' => ['controller' => 'ShareloopLocations', 'action' => 'edit', $location->id]]) ?>

            <div class="form-group">
                <?= $this->Form->label('name', __('Názov umiestnenia')) ?>
                <?= $this->Form->text('name', ['required' => true]) ?>
            </div>

            <div class="form-group">
                <?= $this->Form->label('description', __('Popis')) ?>
                <?= $this->Form->textarea('description') ?>
            </div>

            <div class="form-group">
                <?= $this->Form->label('address', __('Adresa')) ?>
                <?= $this->Form->text('address') ?>
            </div>

            <div class="form-group">
                <?= $this->Form->label('is_default', __('Nastaviť ako predvolené umiestnenie')) ?>
                <?= $this->Form->checkbox('is_default') ?>
            </div>

            <div class="form-actions">
                <?= $this->Form->submit(__('Uložiť zmeny'), ['class' => 'btn btn-primary']) ?>
                <?= $this->Html->link(__('Zrušiť'), ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
            </div>

        <?= $this->Form->end() ?>
    </div>
</div>

