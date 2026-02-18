<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\respostas;
use Authorization\IdentityInterface;

/**
 * respostas policy
 */
class respostasPolicy
{
    /**
     * Check if $user can add respostas
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\respostas $respostas
     * @return bool
     */
    public function canAdd(?IdentityInterface $user, respostas $respostas)
    {
        if (isset($user->categoria) && $user->categoria === '1') {
            return true;
        } elseif (isset($user->categoria) && $user->categoria === '4') {
            return true;
        }
    }

    /**
     * Check if $user can edit respostas
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\respostas $respostas
     * @return bool
     */
    public function canEdit(?IdentityInterface $user, respostas $respostas)
    {
        if (isset($user->categoria) && $user->categoria === '1') {
            return true;
        } elseif (isset($user->categoria) && $user->categoria === '4')
            return true;
    }

    /**
     * Check if $user can delete respostas
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\respostas $respostas
     * @return bool
     */
    public function canDelete(?IdentityInterface $user, respostas $respostas)
    {
        if (isset($user->categoria) && $user->categoria === '1') {
            return true;
        } elseif (isset($user->categoria) && $user->categoria === '4')
            return true;
    }

    /**
     * Check if $user can view respostas
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\respostas $respostas
     * @return bool
     */
    public function canView(?IdentityInterface $user, respostas $respostas)
    {   
        return isset($user);
    }
}
