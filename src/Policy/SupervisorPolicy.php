<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Supervisor;
use Authorization\IdentityInterface;

/**
 * Supervisor policy
 */
class SupervisorPolicy
{

    /**
     * Check if $user can add Supervisor
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Supervisor $supervisor
     * @return bool
     */
    public function canAdd(?IdentityInterface $user, Supervisor $supervisor)
    {
        if (!$user) {
            return false;
        }
        return isset($user) && ($user->categoria == '1' || $user->categoria == '4');
    }

    /**
     * Check if $user can edit Supervisor
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Supervisor $supervisor
     * @return bool
     */
    public function canEdit(?IdentityInterface $user, Supervisor $supervisor)
    {
        if (!isset($user)) {
            return false;
        } elseif ($user->categoria == '1') {
            return true;
        } elseif ($user->categoria == '4') {
            return $this->isAuthor($user, $supervisor);
        } else {
            return false;
        }
    }

    /**
     * Check if $user can delete Supervisor
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Supervisor $supervisor
     * @return bool
     */
    public function canDelete(?IdentityInterface $user, Supervisor $supervisor)
    {
        if (!$user) {
            return false;
        }
        return isset($user) && $user->categoria == '1';
    }

    /**
     * Check if $user can view Supervisor
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Supervisor $supervisor
     * @return bool
     */
    public function canView(?IdentityInterface $user, Supervisor $supervisor)
    {
        if (!isset($user)) {
            return false;
        } elseif ($user->categoria == '1') {
            return true;
        } elseif ($user->categoria == '4') {
            return $this->isAuthor($user, $supervisor);
        } else {
            return false;
        }
    }

    /**
     * Check if $user is the author of $supervisor
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Supervisor $supervisor
     * @return bool
     */
    protected function isAuthor(?IdentityInterface $user, Supervisor $supervisor)
    {
        if (!$user) {
            return false;
        }
        return $supervisor->id === $user->supervisor_id;
    }
}
