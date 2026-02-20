<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\ConfiguracoesTable;
use Authorization\IdentityInterface;

/**
 * Configuracoes policy
 */
class ConfiguracoesTablePolicy {   
    
    /**
     * Check if $user can index configuracoes
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Table\ConfiguracoesTable $configuracoes
     * @return bool
     */
    public function canIndex(?IdentityInterface $user, ConfiguracoesTable $configuracoes) {
        
        if (isset($user->categoria) && $user->categoria == '1') {
            return true;
        }
        return true;
    }
}
