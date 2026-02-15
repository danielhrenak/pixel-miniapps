<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShareloopUserBooks Table
 *
 * @method \App\Model\Entity\ShareloopUserBook newEmptyEntity()
 * @method \App\Model\Entity\ShareloopUserBook newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ShareloopUserBook[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ShareloopUserBook get(mixed $primaryKey, array $options = [])
 * @method \App\Model\Entity\ShareloopUserBook patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ShareloopUserBook[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ShareloopUserBook|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 */
class ShareloopUserBooksTable extends Table
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

        $this->setTable('shareloop_user_books');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ShareloopUsers', [
            'foreignKey' => 'user_id',
            'className' => 'ShareloopUsers',
        ]);
        $this->belongsTo('ShareloopBooks', [
            'foreignKey' => 'book_id',
            'className' => 'ShareloopBooks',
        ]);
        $this->belongsTo('ShareloopUserLocations', [
            'foreignKey' => 'location_id',
            'className' => 'ShareloopUserLocations',
        ]);
        $this->belongsTo('ShareloopItemTypes', [
            'foreignKey' => 'item_type_id',
            'className' => 'ShareloopItemTypes',
        ]);
        $this->hasMany('ShareloopBookBorrowings', [
            'foreignKey' => 'user_book_id',
            'className' => 'ShareloopBookBorrowings',
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
            ->integer('user_id')
            ->notEmptyString('user_id');

        $validator
            ->integer('book_id')
            ->notEmptyString('book_id');

        $validator
            ->integer('location_id')
            ->allowEmptyString('location_id');

        $validator
            ->integer('item_type_id')
            ->notEmptyString('item_type_id');

        $validator
            ->scalar('condition')
            ->maxLength('condition', 50)
            ->notEmptyString('condition');

        $validator
            ->scalar('sharing_type')
            ->maxLength('sharing_type', 50)
            ->allowEmptyString('sharing_type');

        $validator
            ->scalar('notes')
            ->allowEmptyString('notes');

        $validator
            ->scalar('qr_code')
            ->maxLength('qr_code', 255)
            ->allowEmptyString('qr_code');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['user_id'], 'ShareloopUsers'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['book_id'], 'ShareloopBooks'), ['errorField' => 'book_id']);
        $rules->add($rules->existsIn(['location_id'], 'ShareloopUserLocations'), ['errorField' => 'location_id']);
        $rules->add($rules->existsIn(['item_type_id'], 'ShareloopItemTypes'), ['errorField' => 'item_type_id']);

        return $rules;
    }
}

