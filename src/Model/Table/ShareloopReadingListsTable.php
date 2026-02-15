<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShareloopReadingLists Table
 *
 * @method \App\Model\Entity\ShareloopReadingList newEmptyEntity()
 * @method \App\Model\Entity\ShareloopReadingList newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ShareloopReadingList[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ShareloopReadingList get(mixed $primaryKey, array $options = [])
 * @method \App\Model\Entity\ShareloopReadingList patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ShareloopReadingList[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ShareloopReadingList|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 */
class ShareloopReadingListsTable extends Table
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

        $this->setTable('shareloop_reading_lists');
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
            ->integer('priority')
            ->notEmptyString('priority');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->notEmptyString('status');

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

        return $rules;
    }
}

