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
     * Check if $user can index Areamonografias
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Monografia $monografia
     * @return bool
     */
    public function canwIndex(?IdentityInterface $user, TccestudantesTable $tccestudantes) {
        return isset($user->categoria) && $user->categoria == '1';
    }

}
