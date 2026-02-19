<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\DocentesTable;
use Authorization\IdentityInterface;
use Authorization\Policy\Result;
/**
 * Docentes policy
 */
class DocentesTablePolicy
{

    /**
     * Check if $user can index
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Table\DocentesTable $docentes
     * @return bool
     */
    public function canIndex(?IdentityInterface $user, DocentesTable $Docentes)
    {
        if (isset($user->categoria) && ($user->categoria == '1' || $user->categoria == '3')) {
            return true;
        }
        return false;
    }
}
