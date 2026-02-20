<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Resposta;
use Authorization\IdentityInterface;

/**
 * Resposta policy
 */
class RespostaPolicy
{
    /**
     * Check if $user can add Resposta
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Resposta $resposta
     * @return bool
     */
    public function canAdd(?IdentityInterface $user, Resposta $resposta)
    {
        if (isset($user->categoria) && $user->categoria === '1') {
            return true;
        } elseif (isset($user->categoria) && $user->categoria === '4') {
            return true;
        }
    }

    /**
     * Check if $user can edit Resposta
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Resposta $resposta
     * @return bool
     */
    public function canEdit(?IdentityInterface $user, Resposta $resposta)
    {
        if (isset($user->categoria) && $user->categoria === '1') {
            return true;
        } elseif (isset($user->categoria) && $user->categoria === '4') {
            return true;
        }
    }

    /**
     * Check if $user can delete Resposta
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Resposta $resposta
     * @return bool
     */
    public function canDelete(?IdentityInterface $user, Resposta $resposta)
    {
        if (isset($user->categoria) && $user->categoria === '1') {
            return true;
        } elseif (isset($user->categoria) && $user->categoria === '4') {
            return true;
        }
    }

    /**
     * Check if $user can view Resposta
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Resposta $resposta
     * @return bool
     */
    public function canView(?IdentityInterface $user, Resposta $resposta)
    {   
        return isset($user);
    }
}
