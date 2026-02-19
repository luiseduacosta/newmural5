<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\AgendamentotccsTable;
use Authorization\IdentityInterface;

/**
 * Agendamentotccs policy
 */
class AgendamentotccsTablePolicy {
    
    /**
     * Check if $user can index Agendamentotccs
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Table\AgendamentotccsTable $agendamentotccss
     * @return bool
     */
    public function canIndex(?IdentityInterface $user, AgendamentotccsTable $agendamentotccs) {
        return true;
    }
}
