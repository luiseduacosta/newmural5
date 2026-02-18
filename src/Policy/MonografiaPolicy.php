<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Monografia;
use Authorization\IdentityInterface;

/**
 * Monografia policy
 */
class MonografiaPolicy
{
    /**
     * Check if $user can create Monografia
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Monografia $monografia
     * @return bool
     */
    public function canAdd(?IdentityInterface $user, Monografia $monografia)
    {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can update Monografia
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Monografia $monografia
     * @return bool
     */
    public function canEdit(?IdentityInterface $user, Monografia $monografia)
    {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can delete Monografia
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Monografia $monografia
     * @return bool
     */
    public function canDelete(?IdentityInterface $user, Monografia $monografia)
    {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can view Monografia
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Monografia $monografia
     * @return bool
     */
    public function canView(?IdentityInterface $user, Monografia $monografia)
    {
        return true;
    }
}
