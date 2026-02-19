<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\VisitasTable;
use Authorization\IdentityInterface;

/**
 * Visitas policy
 */
class VisitasTablePolicy {

    /**
     * Check if $user can index Visitas
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Table\VisitasTable $visitas
     * @return bool
     */
    public function canIndex(?IdentityInterface $user, VisitasTable $visitas) {
        return isset($user->categoria) && $user->categoria == '1';
    }

}
