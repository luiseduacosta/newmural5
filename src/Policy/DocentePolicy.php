<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Docente;
use Authorization\IdentityInterface;

/**
 * Docente policy
 */
class DocentePolicy {

    /**
     * Check if $user can add Docente
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Docente $docente
     * @return bool
     */
    public function canw+(?IdentityInterface $user, Docente $docente) {
        return isset($user) && $user->categoria == '1';
    }

    /**
     * Check if $user can edit Docente
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Docente $docente
     * @return bool
     */
    public function canw+(?IdentityInterface $user, Docente $docente) {
        return isset($user) && $user->categoria == '1';
    }

    /**
     * Check if $user can delete Docente
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Docente $docente
     * @return bool
     */
    public function canw+(?IdentityInterface $user, Docente $docente) {
        return isset($user) && $user->categoria == '1';
    }

    /**
     * Check if $user can view Docente
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Docente $docente
     * @return bool
     */
    public function canw+(?IdentityInterface $user, Docente $docente) {
        if (!isset($user)) {
            return false;
        }
        return isset($user) && ($user->categoria == '1' || $user->categoria == '2');
    }

}
