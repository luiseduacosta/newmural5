<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\RespostasTable;
use Authorization\IdentityInterface;

/**
 * RespostasTable policy
 */
class RespostasTablePolicy
{
    /**
     * Check if $user can index Respostas
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Table\RespostasTable $respostas
     * @return bool
     */
    public function canIndex(?IdentityInterface $user, RespostasTable $respostas)
    {
        return isset($user);
    }
}
