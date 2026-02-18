<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\MuralestagiosTable;
use Authorization\IdentityInterface;

/**
 * Muralestagios policy
 */
class MuralestagiosTablePolicy {

    /**
     * Check if $user can index Muralestagios
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Table\MuralestagiosTable $muralestagios
     * @return bool
     */
    public function canIndex(?IdentityInterface $user, MuralestagiosTable $muralestagios) {
        return true;
    }

}
