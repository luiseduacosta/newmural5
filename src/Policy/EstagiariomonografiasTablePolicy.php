<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\EstagiariomonografiasTable;
use Authorization\IdentityInterface;

/**
 * Estagiarios policy
 */
class EstagiariomonografiasTablePolicy {

    /**
     * Check if $user can index Estagiarios
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Table\EstagiariomonografiasTable $estagiariomonografias
     * @return bool
     */
    public function canIndex(?IdentityInterface $user, EstagiariomonografiasTable $estagiariomonografias) {
        return isset($user->categoria) && $user->categoria == '1';
    }

}
