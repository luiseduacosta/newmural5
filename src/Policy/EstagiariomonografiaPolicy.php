<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Estagiariomonografia;
use Authorization\IdentityInterface;

/**
 * Estagiario policy
 */
class EstagiariomonografiaPolicy {

    /**
     * Check if $user can create Estagiariomonografia
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Estagiariomonografia $estagiariomongrafia
     * @return bool
     */
    public function canCreate(?IdentityInterface $user, Estagiariomonografia $estagiariomonografia) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can update Estagiariomonografia
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Estagiariomonografia $estagiariomonografia
     * @return bool
     */
    public function canUpdate(?IdentityInterface $user, Estagiariomonografia $estagiariomonografia) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can delete Estagiariomonografia
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Estagiariomonografia $estagiariomonografia
     * @return bool
     */
    public function canDelete(?IdentityInterface $user, Estagiariomonografia $estagiariomonografia) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can view Estagiariomonografia
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Estagiariomonografia $estagiariomonografia
     * @return bool
     */
    public function canView(?IdentityInterface $user, Estagiariomonografia $estagiariomonografia) {
        return isset($user->categoria) && $user->categoria == '1';
    }

}
