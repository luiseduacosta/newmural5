<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\InstituicoesTable;
use Authorization\IdentityInterface;

/**
 * Instituicoes policy
 */
class InstituicoesTablePolicy {

    /**
     * Check if $user can index Instituicoes
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Table\InstituicoesTable $instituicoes
     * @return bool
     */
    public function canIndex(?IdentityInterface $user, InstituicoesTable $instituicoes) {
        return true;
    }

}
