<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\MonografiasTable;
use Authorization\IdentityInterface;

/**
 * Monografias policy
 */
class MonografiasTablePolicy {

    /**
     * Check if $user can index Monografia
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Table\MonografiasTable $monografias
     * @return bool
     */
    public function canIndex(IdentityInterface $user, MonografiasTable $monografias) {
        return isset($user->categoria) && $user->categoria == '1';
    }

}
