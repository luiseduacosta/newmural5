<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\TccestudantesTable;
use Authorization\IdentityInterface;

/**
 * Tccestudantes policy
 */
class TccestudantesTablePolicy {

    /**
     * Check if $user can index Tccestudantes
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Table\TccestudantesTable $tccestudantes
     * @return bool
     */
    public function canIndex(?IdentityInterface $user, TccestudantesTable $tccestudantes) {
        return isset($user->categoria) && $user->categoria == '1';
    }

}
