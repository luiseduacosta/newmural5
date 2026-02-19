<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\QuestionariosTable;
use Authorization\IdentityInterface;

/**
 * QuestionariosTable policy
 */
class QuestionariosTablePolicy
{
    /**
     * Check if $user can index Questionarios
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Table\QuestionariosTable $questionarios
     * @return bool
     */
    public function canIndex(?IdentityInterface $user, QuestionariosTable $questionarios)
    {
        return isset($user);
    }
}
