<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\TurmaestagiosTable;
use Authorization\IdentityInterface;

/**
 * Areaestagios policy
 */
class TurmaestagiosTablePolicy {
    
    /**
     * Check if $user can index Areaestagios
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Table\TurmaestagiosTable $turmaestagios
     * @return bool
     */
    public function canIndex(?IdentityInterface $user, TurmaestagiosTable $areaestagios) {
        return isset ($user);
    }
    
}
