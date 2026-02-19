<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\questiones;
use Authorization\IdentityInterface;

/**
 * questiones policy
 */
class questionesPolicy
{
    /**
     * Check if $user can add questiones
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\questiones $questiones
     * @return bool
     */
    public function canAdd(?IdentityInterface $user, questiones $questiones)
    {
        if (isset($user) && $user->categoria_id === '1') {
            return true;
        }
        return false;
    }

    /**
     * Check if $user can edit questiones
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\questiones $questiones
     * @return bool
     */
    public function canEdit(?IdentityInterface $user, questiones $questiones)
    {
        if (isset($user) && $user->categoria_id === '1') {
            return true;
        }
        return false;
    }

    /**
     * Check if $user can delete questiones
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\questiones $questiones
     * @return bool
     */
    public function canDelete(?IdentityInterface $user, questiones $questiones)
    {
        if (isset($user) && $user->categoria_id === '1') {
            return true;
        }
        return false;
    }

    /**
     * Check if $user can view questiones
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\questiones $questiones
     * @return bool
     */
    public function canView(?IdentityInterface $user, questiones $questiones)
    {
        return isset($user);
    }
}
