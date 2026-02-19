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
        return $user->getOriginalData()->isAdmin() || $user->getOriginalData()->isSupervisor();
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
        } elseif ($user->getOriginalData()->isAdmin()) {
            return true;
        } elseif ($user->getOriginalData()->isSupervisor()) {
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
        return $user->getOriginalData()->isAdmin();
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
        } elseif ($user->getOriginalData()->isAdmin()) {
            return true;
        } elseif ($user->getOriginalData()->isSupervisor()) {
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
