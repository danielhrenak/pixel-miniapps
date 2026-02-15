<?php
/**
 * @var \App\View\AppView $this
 * @var array $locations
 * @var array $itemTypes
 * @var string $pageTitle
 */
?>
<div class="shareloop-container">
    <h1><?= __('Pridať novú knihu') ?></h1>

    <div class="add-book-form">
        <?= $this->Form->create(null, ['url' => ['controller' => 'ShareloopBooks', 'action' => 'add']]) ?>

            <div class="form-section">
                <h3><?= __('Informácie o knihe') ?></h3>

                <div class="form-group">
                    <?= $this->Form->label('isbn', __('ISBN (ak dostupný)')) ?>
                    <?= $this->Form->text('isbn', ['placeholder' => '978-80-...']) ?>
                </div>

                <div class="form-group">
                    <?= $this->Form->label('title', __('Názov knihy')) ?>
                    <?= $this->Form->text('title', ['required' => true, 'placeholder' => 'Názov knihy']) ?>
                </div>

                <div class="form-group">
                    <?= $this->Form->label('author', __('Autor')) ?>
                    <?= $this->Form->text('author', ['placeholder' => 'Meno autora']) ?>
                </div>

                <div class="form-group">
                    <?= $this->Form->label('publisher', __('Vydavateľ')) ?>
                    <?= $this->Form->text('publisher', ['placeholder' => 'Vydavateľstvo']) ?>
                </div>

                <div class="form-group">
                    <?= $this->Form->label('published_year', __('Rok vydania')) ?>
                    <?= $this->Form->number('published_year', ['min' => 1900, 'max' => date('Y') + 1]) ?>
                </div>

                <div class="form-group">
                    <?= $this->Form->label('pages', __('Počet strán')) ?>
                    <?= $this->Form->number('pages', ['min' => 1]) ?>
                </div>

                <div class="form-group">
                    <?= $this->Form->label('description', __('Popis')) ?>
                    <?= $this->Form->textarea('description', ['placeholder' => 'Krátky popis knihy...']) ?>
                </div>

                <div class="form-group">
                    <?= $this->Form->label('cover_image_url', __('URL obálky')) ?>
                    <?= $this->Form->text('cover_image_url', ['placeholder' => 'https://...']) ?>
                </div>
            </div>

            <div class="form-section">
                <h3><?= __('Vaše detaily') ?></h3>

                <div class="form-group">
                    <?= $this->Form->label('item_type_id', __('Typ položky')) ?>
                    <?= $this->Form->select('item_type_id',
                        array_combine(
                            array_map(fn($t) => $t->id, $itemTypes),
                            array_map(fn($t) => $t->name, $itemTypes)
                        ),
                        ['default' => 1]) ?>
                </div>

                <div class="form-group">
                    <?= $this->Form->label('location_id', __('Umiestnenie')) ?>
                    <?php if (!empty($locations)): ?>
                        <?= $this->Form->select('location_id',
                            array_combine(
                                array_map(fn($l) => $l->id, $locations),
                                array_map(fn($l) => $l->name, $locations)
                            ),
                            ['empty' => __('-- Zvoľte umiestnenie --')]) ?>
                    <?php else: ?>
                        <p><?= __('Nemáte žiadne umiestnenia. ') .
                            $this->Html->link(__('Vytvorte nové'),
                            ['controller' => 'ShareloopLocations', 'action' => 'add']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <?= $this->Form->label('condition', __('Stav knihy')) ?>
                    <?= $this->Form->select('condition', [
                        'excellent' => __('Výborný'),
                        'good' => __('Dobrý'),
                        'fair' => __('Uspokojivý'),
                        'poor' => __('Zlý')
                    ], ['default' => 'good']) ?>
                </div>

                <div class="form-group">
                    <?= $this->Form->label('sharing_type', __('Typ zdieľania')) ?>
                    <?= $this->Form->select('sharing_type', [
                        'borrow' => __('Požičiavanie'),
                        'sell' => __('Predaj'),
                        'both' => __('Oboje')
                    ], ['empty' => __('-- Nezvoľte --')]) ?>
                </div>

                <div class="form-group">
                    <?= $this->Form->label('notes', __('Poznámky')) ?>
                    <?= $this->Form->textarea('notes', ['placeholder' => 'Špeciálne poznámky...']) ?>
                </div>
            </div>

            <div class="form-actions">
                <?= $this->Form->submit(__('Pridať knihu'), ['class' => 'btn btn-success']) ?>
                <?= $this->Html->link(__('Zrušiť'), ['action' => 'myBooks'], ['class' => 'btn btn-secondary']) ?>
            </div>

        <?= $this->Form->end() ?>
    </div>
</div>

