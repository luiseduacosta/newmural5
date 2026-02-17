<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\AvaliacoesTable;
use Authorization\IdentityInterface;

/**
 * Avaliacoes policy
 */
class AvaliacoesTablePolicy {
    
    /**
     * Check if $user can index Avaliacoes
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Table\AvaliacoesTable $avaliacoes
     * @return bool
     */
    public function canIndex(IdentityInterface $user, AvaliacoesTable $avaliacoes) {
        return true;
    }
}
