<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\questao;
use Authorization\IdentityInterface;

/**
 * questao policy
 */
class questaoPolicy
{
    /**
     * Check if $user can add questao
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\questao $questao
     * @return bool
     */
    public function canAdd(?IdentityInterface $user, questao $questao)
    {
        if (isset($user) && $user->categoria === '1') {
            return true;
        }
        return false;
    }

    /**
     * Check if $user can edit questao
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\questao $questao
     * @return bool
     */
    public function canEdit(?IdentityInterface $user, questao $questao)
    {
        if (isset($user) && $user->categoria === '1') {
            return true;
        }
        return false;
    }

    /**
     * Check if $user can delete questao
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\questao $questao
     * @return bool
     */
    public function canDelete(?IdentityInterface $user, questao $questao)
    {
        if (isset($user) && $user->categoria === '1') {
            return true;
        }
        return false;
    }

    /**
     * Check if $user can view questao
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\questao $questao
     * @return bool
     */
    public function canView(?IdentityInterface $user, questao $questao)
    {
        if (isset($user)) {
            return true;
        }
        return false;
    }
}
