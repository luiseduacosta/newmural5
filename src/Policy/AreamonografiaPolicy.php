<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Areamonografia;
use Authorization\IdentityInterface;

/**
 * Areamonografia policy
 */
class AreamonografiaPolicy {

    /**
     * Check if $user can create Areamonografia
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Areamonografia $areamonografia
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Areamonografia $areamonografia) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can update Areamonografia
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Areamonografia $areamonografia
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Areamonografia $areamonografia) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can delete Areamonografia
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Areamonografia $areamonografia
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Areamonografia $areamonografia) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can view Areamonografia
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Areamonografia $areamonografia
     * @return bool
     */
    public function canView(IdentityInterface $user, Areamonografia $areamonografia) {
        return true;
    }

}
