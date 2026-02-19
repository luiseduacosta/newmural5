<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Visita;
use Authorization\IdentityInterface;

/**
 * Visita policy
 */
class VisitaPolicy {

    /**
     * Check if $user can add Visita
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Visita $visita
     * @return bool
     */
    public function canAdd(?IdentityInterface $user, Visita $visita) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can edit Visita
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Visita $visita
     * @return bool
     */
    public function canEdit(?IdentityInterface $user, Visita $visita) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can delete Visita
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Visita $visita
     * @return bool
     */
    public function canDelete(?IdentityInterface $user, Visita $visita) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can view Visita
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Visita $visita
     * @return bool
     */
    public function canView(?IdentityInterface $user, Visita $visita) {
        return isset($user->categoria) && $user->categoria == '1';
    }

}
