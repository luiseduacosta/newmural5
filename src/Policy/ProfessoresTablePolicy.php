<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\ProfessoresTable;
use Authorization\IdentityInterface;

/**
 * Professor policy
 */
class ProfessoresTablePolicy
{
    /**
     * Check if $user can index Professor
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Table\ProfessoresTable $professores
     * @return bool
     */
    public function canIndex(?IdentityInterface $user, ProfessoresTable $professores)
    {
        return isset($user->categoria) && ($user->categoria == '1' || $user->categoria == '3');
    }    
}
