<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ShareloopUser $user
 * @var string $verifyUrl
 */
?>

<h1><?= __('Verifikácia emailu - ShareLoop') ?></h1>

<p><?= sprintf(__('Ahoj %s,'), h($user->first_name ?: $user->email)) ?></p>

<p><?= __('Ďakujeme za registráciu na ShareLoop! Kvôli potvrdeniu vašej emailovej adresy klikните na odkaz nižšie:') ?></p>

<p>
    <a href="<?= $verifyUrl ?>" style="background: #007bff; color: white; padding: 12px 24px; text-decoration: none; border-radius: 4px; display: inline-block;">
        <?= __('Overiť email') ?>
    </a>
</p>

<p><?= __('Alebo použite tento verifikačný kód: ') . h($token) ?></p>

<p><?= __('Verifikačný link platí 7 dní.') ?></p>

<p><?= __('Ak ste sa neregistrovali, môžete túto správu ignorovať.') ?></p>

<p><?= __('S pozdravom,') ?><br>
<?= __('ShareLoop tím') ?></p>

