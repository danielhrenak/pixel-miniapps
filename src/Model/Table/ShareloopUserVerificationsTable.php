<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShareloopUserVerifications Table
 *
 * @method \App\Model\Entity\ShareloopUserVerification newEmptyEntity()
 * @method \App\Model\Entity\ShareloopUserVerification newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ShareloopUserVerification[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ShareloopUserVerification get(mixed $primaryKey, array $options = [])
 * @method \App\Model\Entity\ShareloopUserVerification patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ShareloopUserVerification[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ShareloopUserVerification|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 */
class ShareloopUserVerificationsTable extends Table
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

        $this->setTable('shareloop_user_verifications');
        $this->setDisplayField('token');
        $this->setPrimaryKey('id');

        $this->belongsTo('ShareloopUsers', [
            'foreignKey' => 'user_id',
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
            ->integer('user_id')
            ->notEmptyString('user_id');

        $validator
            ->scalar('token')
            ->maxLength('token', 255)
            ->requirePresence('token', 'create')
            ->notEmptyString('token')
            ->add('token', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('token_type')
            ->maxLength('token_type', 50)
            ->notEmptyString('token_type');

        $validator
            ->dateTime('expires_at')
            ->allowEmptyDateTime('expires_at');

        $validator
            ->boolean('used')
            ->notEmptyString('used');

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
        $rules->add($rules->isUnique(['token']), ['errorField' => 'token']);

        return $rules;
    }
}

