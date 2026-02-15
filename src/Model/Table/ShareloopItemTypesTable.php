<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShareloopItemTypes Table
 *
 * @method \App\Model\Entity\ShareloopItemType newEmptyEntity()
 * @method \App\Model\Entity\ShareloopItemType newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ShareloopItemType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ShareloopItemType get(mixed $primaryKey, array $options = [])
 * @method \App\Model\Entity\ShareloopItemType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ShareloopItemType[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ShareloopItemType|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 */
class ShareloopItemTypesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('shareloop_item_types');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('ShareloopUserBooks', [
            'foreignKey' => 'item_type_id',
            'className' => 'ShareloopUserBooks',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 255)
            ->requirePresence('slug', 'create')
            ->notEmptyString('slug')
            ->add('slug', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('icon')
            ->maxLength('icon', 255)
            ->allowEmptyString('icon');

        return $validator;
    }
}

