<?php
/**
 * @var \App\View\AppView $this
 * @var string $pageTitle
 */
?>
<div class="shareloop-container">
    <div class="auth-card">
        <h1><?= __('Prihlásenie') ?></h1>

        <?= $this->Form->create(null, ['url' => ['controller' => 'ShareloopAuth', 'action' => 'login']]) ?>
            <div class="form-group">
                <?= $this->Form->label('email', __('Emailová adresa')) ?>
                <?= $this->Form->email('email', ['placeholder' => 'vasa@emailova.com', 'required' => true]) ?>
            </div>

            <div class="form-group">
                <?= $this->Form->label('password', __('Heslo')) ?>
                <?= $this->Form->password('password', ['placeholder' => 'Vaše heslo', 'required' => true]) ?>
            </div>

            <div class="form-group">
                <?= $this->Form->submit(__('Prihlásiť sa')) ?>
            </div>
        <?= $this->Form->end() ?>

        <p><?= __('Nemáte ešte účet?') ?> <?= $this->Html->link(__('Zaregistrujte sa'), ['action' => 'register']) ?></p>
    </div>
</div>

