<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShareloopBookBorrowings Table
 *
 * @method \App\Model\Entity\ShareloopBookBorrowing newEmptyEntity()
 * @method \App\Model\Entity\ShareloopBookBorrowing newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ShareloopBookBorrowing[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ShareloopBookBorrowing get(mixed $primaryKey, array $options = [])
 * @method \App\Model\Entity\ShareloopBookBorrowing patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ShareloopBookBorrowing[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ShareloopBookBorrowing|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 */
class ShareloopBookBorrowingsTable extends Table
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

        $this->setTable('shareloop_book_borrowings');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ShareloopUserBooks', [
            'foreignKey' => 'user_book_id',
            'className' => 'ShareloopUserBooks',
        ]);
        $this->belongsTo('ShareloopUsers', [
            'foreignKey' => 'borrower_id',
            'className' => 'ShareloopUsers',
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
            ->integer('user_book_id')
            ->notEmptyString('user_book_id');

        $validator
            ->integer('borrower_id')
            ->notEmptyString('borrower_id');

        $validator
            ->dateTime('borrowed_at')
            ->notEmptyDateTime('borrowed_at');

        $validator
            ->dateTime('due_date')
            ->allowEmptyDateTime('due_date');

        $validator
            ->dateTime('returned_at')
            ->allowEmptyDateTime('returned_at');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->notEmptyString('status');

        $validator
            ->scalar('notes')
            ->allowEmptyString('notes');

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
        $rules->add($rules->existsIn(['user_book_id'], 'ShareloopUserBooks'), ['errorField' => 'user_book_id']);
        $rules->add($rules->existsIn(['borrower_id'], 'ShareloopUsers'), ['errorField' => 'borrower_id']);

        return $rules;
    }
}

