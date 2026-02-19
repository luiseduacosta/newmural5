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
    public function canIndex(?IdentityInterface $user, MuralinscricoesTable $muralinscricoes) {

        if (isset($user) && $user->categoria_id === '1') {
            return true;
        } elseif (isset($user) && $user->categoria_id === '2') {
            return $aluno->id === $user->aluno_id;
        } 
        return false;
    }

}
