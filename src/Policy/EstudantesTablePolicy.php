<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\EstudantesTable;
use Authorization\IdentityInterface;

/**
 * Estudantes policy
 */
class EstudantesTablePolicy {

    /**
     * Check if $user can index Estudantes
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Table\EstudantesTable $estudantes
     * @return bool
     */
    public function canIndex(IdentityInterface $user, EstudantesTable $estudantes) {
        return isset($user->categoria) && ($user->categoria == '1') || ($user->categoria == '2');
    }

}
