<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\questionario;
use Authorization\IdentityInterface;

/**
 * Questionario policy
 */
class QuestionarioPolicy
{
    /**
     * Check if $user can add questionario
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\questionario $questionario
     * @return bool
     */
    public function canAdd(?IdentityInterface $user, questionario $questionario)
    {
        if (isset($user) && $user->categoria_id === '1') {
            return true;
        }
        return false;
    }

    /**
     * Check if $user can edit questionario
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\questionario $questionario
     * @return bool
     */
    public function canEdit(?IdentityInterface $user, questionario $questionario)
    {
        if (isset($user) && $user->categoria_id === '1') {
            return true;
        }
        return false;
    }

    /**
     * Check if $user can delete questionario
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\questionario $questionario
     * @return bool
     */
    public function canDelete(?IdentityInterface $user, questionario $questionario)
    {
        if (isset($user) && $user->categoria_id === '1') {
            return true;
        }
        return false;
    }

    /**
     * Check if $user can view questionario
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\questionario $questionario
     * @return bool
     */
    public function canView(?IdentityInterface $user, questionario $questionario)
    {
        return isset($user);
    }
}
