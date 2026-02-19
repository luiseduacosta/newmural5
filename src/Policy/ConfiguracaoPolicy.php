<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Configuracao;
use Authorization\IdentityInterface;

/**
 * Configuracao policy
 */
class ConfiguracaoPolicy {

    /**
     * Check if $user can add Configuracao
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Configuracao $configuracao
     * @return bool
     */
    public function canAdd(?IdentityInterface $user, Configuracao $configuracao) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can edit Configuracao
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Configuracao $configuracao
     * @return bool
     */
    public function canEdit(?IdentityInterface $user, Configuracao $configuracao) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can delete Configuracao
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Configuracao $configuracao
     * @return bool
     */
    public function canDelete(?IdentityInterface $user, Configuracao $configuracao) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can view Configuracao
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Configuracao $configuracao
     * @return bool
     */
    public function canView(?IdentityInterface $user, Configuracao $configuracao) {
        return isset($user->categoria) && $user->categoria == '1';
    }

}
