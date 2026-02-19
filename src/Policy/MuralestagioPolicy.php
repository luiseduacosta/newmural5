<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Muralestagio;
use Authorization\IdentityInterface;

/**
 * Muralestagio policy
 */
class MuralestagioPolicy {

    /**
     * Check if $user can add Muralestagio
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Muralestagio $muralestagio
     * @return bool
     */
    public function canAdd(?IdentityInterface $user, Muralestagio $muralestagio) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can edit Muralestagio
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Muralestagio $muralestagio
     * @return bool
     */
    public function canEdit(?IdentityInterface $user, Muralestagio $muralestagio) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can delete Muralestagio
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Muralestagio $muralestagio
     * @return bool
     */
    public function canDelete(?IdentityInterface $user, Muralestagio $muralestagio) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can view Muralestagio
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Muralestagio $muralestagio
     * @return bool
     */
    public function canView(?IdentityInterface $user, Muralestagio $muralestagio) {
        return isset($user->categoria) && ($user->categoria == '1' || $user->categoria == '2');
    }

}
