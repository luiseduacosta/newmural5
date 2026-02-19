<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Areainstituicao;
use Authorization\IdentityInterface;

/**
 * Areainstituicao policy
 */
class AreainstituicaoPolicy {

    /**
     * Check if $user can add Areainstituicao
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Areainstituicao $areainstituicao
     * @return bool
     */
    public function canAdd(?IdentityInterface $user, Areainstituicao $areainstituicao) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can edit Areainstituicao
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Areainstituicao $areainstituicao
     * @return bool
     */
    public function canEdit(?IdentityInterface $user, Areainstituicao $areainstituicao) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can delete Areainstituicao
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Areainstituicao $areainstituicao
     * @return bool
     */
    public function canDelete(?IdentityInterface $user, Areainstituicao $areainstituicao) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can view Areainstituicao
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Areainstituicao $areainstituicao
     * @return bool
     */
    public function canView(?IdentityInterface $user, Areainstituicao $areainstituicao) {
        return isset($user->categoria) && $user->categoria == '1';
    }

}
