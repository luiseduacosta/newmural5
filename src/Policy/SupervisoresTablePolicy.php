<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\SupervisoresTable;
use Authorization\IdentityInterface;

/**
 * Supervisores policy
 */
class SupervisoresTablePolicy {

    /**
     * Check if $user can index Supervisores
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Table\SupervisoresTable $supervisores
     * @return bool
     */
    public function canIndex(?IdentityInterface $user, SupervisoresTable $supervisores) {
        return isset($user->categoria) && $user->categoria == '1' || $user->categoria == '4';
    }

}
