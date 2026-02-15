<?php
/**
 * @var \App\View\AppView $this
 * @var string $pageTitle
 */
?>
<div class="shareloop-container">
    <h1><?= __('Pridať nové umiestnenie') ?></h1>

    <div class="form-section">
        <?= $this->Form->create(null, ['url' => ['controller' => 'ShareloopLocations', 'action' => 'add']]) ?>

            <div class="form-group">
                <?= $this->Form->label('name', __('Názov umiestnenia')) ?>
                <?= $this->Form->text('name', ['required' => true, 'placeholder' => 'napr. Domáca knižnica']) ?>
                <small><?= __('Napr: Domáca knižnica, Kancelária, IT oddělení...') ?></small>
            </div>

            <div class="form-group">
                <?= $this->Form->label('description', __('Popis')) ?>
                <?= $this->Form->textarea('description', ['placeholder' => 'Kratký popis umiestnenia...']) ?>
            </div>

            <div class="form-group">
                <?= $this->Form->label('address', __('Adresa')) ?>
                <?= $this->Form->text('address', ['placeholder' => 'Улica, mesto']) ?>
            </div>

            <div class="form-group">
                <?= $this->Form->label('is_default', __('Nastaviť ako predvolené umiestnenie')) ?>
                <?= $this->Form->checkbox('is_default') ?>
            </div>

            <div class="form-actions">
                <?= $this->Form->submit(__('Vytvoriť umiestnenie'), ['class' => 'btn btn-success']) ?>
                <?= $this->Html->link(__('Zrušiť'), ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
            </div>

        <?= $this->Form->end() ?>
    </div>
</div>

