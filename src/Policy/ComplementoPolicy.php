<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Complemento;
use Authorization\IdentityInterface;

/**
 * Complemento policy
 */
class ComplementoPolicy {

    /**
     * Check if $user can add Complemento
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Complemento $complemento
     * @return bool
     */
    public function canAdd(?IdentityInterface $user, Complemento $complemento) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can edit Complemento
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Complemento $complemento
     * @return bool
     */
    public function canEdit(?IdentityInterface $user, Complemento $complemento) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can delete Complemento
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Complemento $complemento
     * @return bool
     */
    public function canDelete(?IdentityInterface $user, Complemento $complemento) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can view Complemento
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Complemento $complemento
     * @return bool
     */
    public function canView(?IdentityInterface $user, Complemento $complemento) {
        return isset($user->categoria) && $user->categoria == '1';
    }

}
