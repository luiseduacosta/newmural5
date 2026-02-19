<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\QuestoesTable;
use Authorization\IdentityInterface;

/**
 * QuestoesTable policy
 */
class QuestoesTablePolicy
{
    /**
     * Check if $user can index Questoes
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Table\QuestoesTable $questoes
     * @return bool
     */
    public function canIndex(?IdentityInterface $user, QuestoesTable $questoes)
    {
        return isset($user);
    }
}
