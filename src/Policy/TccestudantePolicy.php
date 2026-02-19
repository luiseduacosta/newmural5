<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Tccestudante;
use Authorization\IdentityInterface;

/**
 * Tccestudante policy
 */
class TccestudantePolicy {

    /**
     * Check if $user can create Tccestudante
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Tccestudante $tccestudante
     * @return bool
     */
    public function canAdd(?IdentityInterface $user, Tccestudante $tccestudante) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can update Tccestudante
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Tccestudante $tccestudante
     * @return bool
     */
    public function canEdit(?IdentityInterface $user, Tccestudante $tccestudante) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can delete Tccestudante
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Tccestudante $tccestudante
     * @return bool
     */
    public function canDelete(?IdentityInterface $user, Tccestudante $tccestudante) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can view Tccestudante
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Tccestudante $tccestudante
     * @return bool
     */
    public function canView(?IdentityInterface $user, Tccestudante $tccestudante) {
        return isset($user->categoria) && $user->categoria == '1';
    }

}
