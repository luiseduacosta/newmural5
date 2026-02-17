<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Agendamentotcc;
use Authorization\IdentityInterface;

/**
 * Agendamentotcc policy
 */
class AgendamentotccPolicy
{

    /**
     * Check if $user can add Agendamentotcc
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Agendamentotcc $agendamentotcc
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Agendamentotcc $agendamentotcc)
    {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can edit Agendamentotcc
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Agendamentotcc $agendamentotcc
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Agendamentotcc $agendamentotcc)
    {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can delete Agendamentotcc
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Agendamentotcc $agendamentotcc
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Agendamentotcc $agendamentotcc)
    {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can view Agendamentotcc
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Agendamentotcc $agendamentotcc
     * @return bool
     */
    public function canView(IdentityInterface $user, Agendamentotcc $agendamentotcc)
    {
        if (isset($user->categoria) && $user->categoria == '1') {
            return true;
        }
        return true;
    }

}
