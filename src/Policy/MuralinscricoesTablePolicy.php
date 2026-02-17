<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\MuralinscricoesTable;
use Authorization\IdentityInterface;

/**
 * Muralinscricoes policy
 */
class MuralinscricoesTablePolicy {

    /**
     * Check if $user can index Areamonografias
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Table\MuralinscricoesTable $muralinscricoes
     * @return bool
     */
    public function canIndex(IdentityInterface $user, MuralinscricoesTable $muralinscricoes) {
        return isset($user->categoria) && $user->categoria == '1';
    }

}
