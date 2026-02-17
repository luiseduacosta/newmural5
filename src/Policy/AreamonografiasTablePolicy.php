<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\AreamonografiasTable;
use Authorization\IdentityInterface;

/**
 * Areamonografia policy
 */
class AreamonografiasTablePolicy {

    /**
     * Check if $user can index Areamonografias
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Areamonografia $areamonografias
     * @return bool
     */
    public function canIndex(IdentityInterface $user, AreamonografiasTable $areamonografias) {
        return isset($user->categoria) && $user->categoria == '1';
    }
    
}
