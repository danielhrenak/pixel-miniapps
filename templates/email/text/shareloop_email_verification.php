<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ShareloopUser $user
 * @var string $verifyUrl
 * @var string $token
 */
?>

<?= sprintf(__('Ahoj %s,'), h($user->first_name ?: $user->email)) ?>

<?= __('Ďakujeme za registráciu na ShareLoop! Kvôli potvrdeniu vašej emailovej adresy klikněte na odkaz nižšie:') ?>

<?= $verifyUrl ?>

<?= __('Alebo použite tento verifikačný kód: ') . h($token) ?>

<?= __('Verifikačný link platí 7 dní.') ?>

<?= __('Ak ste sa neregistrovali, môžete túto správu ignorovať.') ?>

<?= __('S pozdravom,') ?>
<?= __('ShareLoop tím') ?>

