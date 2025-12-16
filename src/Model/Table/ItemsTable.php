<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ItemsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('items');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp'); // spravuje created a modified

        // Vzťah na Screens
        $this->belongsTo('Screens', [
            'foreignKey' => 'screen_id',
            'joinType' => 'LEFT'
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('text')
            ->allowEmptyString('name');

        $validator
            ->integer('screen_id')
            ->allowEmptyString('screen_id');

        $validator
            ->scalar('image')
            ->allowEmptyString('image');

        $validator
            ->scalar('video')
            ->allowEmptyString('video');

        $validator
            ->scalar('author')
            ->allowEmptyString('author');

        $validator
            ->scalar('category')
            ->maxLength('category', 100)
            ->allowEmptyString('category');

        $validator
            ->integer('priority')
            ->allowEmptyString('priority');

        return $validator;
    }
}
