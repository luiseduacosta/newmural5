<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Estudante;
use Authorization\IdentityInterface;

/**
 * Aluno policy
 */
class EstudantePolicy {

    /**
     * Check if $user can create Aluno
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Estudante $estudante
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Estudante $estudante) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can update Aluno
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Estudante $estudante
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Estudante $estudante) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can delete Aluno
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Estudante $estudante
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Estudante $estudante) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can view Aluno
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Estudante $estudante
     * @return bool
     */
    public function canView(IdentityInterface $user, Estudante $estudante) {
        return true;
    }

}
