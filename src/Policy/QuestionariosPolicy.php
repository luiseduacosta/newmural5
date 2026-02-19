<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\questionarios;
use Authorization\IdentityInterface;

/**
 * questionarios policy
 */
class questionariosPolicy
{
    /**
     * Check if $user can add questionarios
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\questionarios $questionarios
     * @return bool
     */
    public function canAdd(?IdentityInterface $user, questionarios $questionarios)
    {
        if (isset($user) && $user->categoria_id === '1') {
            return true;
        }
        return false;
    }

    /**
     * Check if $user can edit questionarios
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\questionarios $questionarios
     * @return bool
     */
    public function canEdit(?IdentityInterface $user, questionarios $questionarios)
    {
        if (isset($user) && $user->categoria_id === '1') {
            return true;
        }
        return false;
    }

    /**
     * Check if $user can delete questionarios
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\questionarios $questionarios
     * @return bool
     */
    public function canDelete(?IdentityInterface $user, questionarios $questionarios)
    {
        if (isset($user) && $user->categoria_id === '1') {
            return true;
        }
        return false;
    }

    /**
     * Check if $user can view questionarios
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\questionarios $questionarios
     * @return bool
     */
    public function canView(?IdentityInterface $user, questionarios $questionarios)
    {
        return isset($user);
    }
}
