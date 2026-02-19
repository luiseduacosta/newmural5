<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Turmaestagio;
use Authorization\IdentityInterface;

/**
 * Areaestagio policy
 */
class TurmaestagioPolicy {

    /**
     * Check if $user can add Turmaestagio
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Turmaestagio $turmaestagio
     * @return bool
     */
    public function canAdd(?IdentityInterface $user, Turmaestagio $areaestagio) {       
        return isset($user) && $user->categoria == '1';
    }

    /**
     * Check if $user can edit Turmaestagio
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Turmaestagio $turmaestagio
     * @return bool
     */
    public function canEdit(?IdentityInterface $user, Turmaestagio $turmaestagio) {
        return isset($user) && $user->categoria == '1';
    }

    /**
     * Check if $user can delete Turmaestagio
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Turmaestagio $turmaestagio
     * @return bool
     */
    public function canDelete(?IdentityInterface $user, Turmaestagio $areaestagio) {
        return isset($user) && $user->categoria == '1';
    }

    /**
     * Check if $user can view Turmaestagio
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Turmaestagio $turmaestagio
     * @return bool
     */
    public function canView(?IdentityInterface $user, Turmaestagio $areaestagio) {
        return isset($user);
    }

}
