<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Avaliacao;
use Authorization\IdentityInterface;

/**
 * Avaliacao policy
 */
class AvaliacaoPolicy {

    /**
     * Check if $user can add Avaliacao
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Avaliacao $avaliacao
     * @return bool
     */
    public function canAdd(?IdentityInterface $user, Avaliacao $avaliacao) {
        return isset($user->categoria) && ($user->categoria == '1' || $user->categoria == '4');
    }

    /**
     * Check if $user can edit Avaliacao
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Avaliacao $avaliacao
     * @return bool
     */
    public function canEdit(?IdentityInterface $user, Avaliacao $avaliacao) {
        return isset($user->categoria) && ($user->categoria == '1' || $user->categoria == '4');
    }

    /**
     * Check if $user can delete Avaliacao
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Avaliacao $avaliacao
     * @return bool
     */
    public function canDelete(?IdentityInterface $user, Avaliacao $avaliacao) {
        return isset($user->categoria) && ($user->categoria == '1' || $user->categoria == '4');
    }

    /**
     * Check if $user can view Avaliacao
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Avaliacao $avaliacao
     * @return bool
     */
    public function canView(?IdentityInterface $user, Avaliacao $avaliacao) {
        return true;
    }

}
