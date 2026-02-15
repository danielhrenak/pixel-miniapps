<?php
/**
 * @var \App\View\AppView $this
 * @var string $pageTitle
 */
?>
<div class="shareloop-container">
    <div class="auth-card">
        <h1><?= __('Registrácia') ?></h1>

        <?= $this->Form->create(null, ['url' => ['controller' => 'ShareloopAuth', 'action' => 'register']]) ?>
            <div class="form-group">
                <?= $this->Form->label('email', __('Emailová adresa')) ?>
                <?= $this->Form->email('email', ['placeholder' => 'vasa@emailova.com', 'required' => true]) ?>
            </div>

            <div class="form-group">
                <?= $this->Form->label('first_name', __('Meno')) ?>
                <?= $this->Form->text('first_name', ['placeholder' => 'Váše meno']) ?>
            </div>

            <div class="form-group">
                <?= $this->Form->label('last_name', __('Priezvisko')) ?>
                <?= $this->Form->text('last_name', ['placeholder' => 'Vaše priezvisko']) ?>
            </div>

            <div class="form-group">
                <?= $this->Form->submit(__('Zaregistrovať')) ?>
            </div>
        <?= $this->Form->end() ?>

        <p><?= __('Už máte účet?') ?> <?= $this->Html->link(__('Prihláste sa'), ['action' => 'login']) ?></p>
    </div>
</div>

