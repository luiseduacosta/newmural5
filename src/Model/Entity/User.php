<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Authentication\PasswordHasher\DefaultPasswordHasher; // Add this line
use Cake\ORM\Entity;

/**
 * Userestagio Entity
 *
 * @property int $id
 * @property string|null $email
 * @property string|null $password
 * @property numeric|null $categoria
 * @property numeric|null $numero
 * @property int|null $aluno_id
 * @property int|null $supervisor_id
 * @property int|null $professor_id
 * @property \Cake\I18n\DateTime $timestamp
 *
 * @property \App\Model\Entity\Aluno[] $alunos
 * @property \App\Model\Entity\Supervisor[] $supervisores
 * @property \App\Model\Entity\Professor[] $professores
 *
 */
class User extends Entity {

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected array $_accessible = [
        'email' => true,
        'password' => true,
        'categoria' => true,
        'numero' => true,
        'aluno_id' => true,
        'supervisor_id' => true,
        'professor_id' => true,
        'timestamp' => true,
        'alunos' => true,
        'supervisores' => true,
        'professores' => true,
    ];

    // Add this method
    protected function _setPassword(string $password): ?string {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
        return null; // Should return null if no password
    }

    public function isAdmin(): bool
    {
        return $this->categoria == 1;
    }

    public function isAluno(): bool
    {
        return $this->categoria == 2;
    }

    public function isProfessor(): bool
    {
        return $this->categoria == 3;
    }

    public function isSupervisor(): bool
    {
        return $this->categoria == 4;
    }

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected array $_hidden = [
        'password',
    ];

}
