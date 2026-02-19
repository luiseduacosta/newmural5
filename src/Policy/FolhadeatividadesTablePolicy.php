<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\FolhadeatividadesTable;
use Authorization\IdentityInterface;

/**
 * Folhadeatividades policy
 */
class FolhadeatividadesTablePolicy {

    /**
     * Check if $user can index Folhadeatividades
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Folhadeatividade $folhadeatividade
     * @return bool
     */
    public function canIndex(?IdentityInterface $user, FolhadeatividadesTable $folhadeatividades) {
        return true;
    }

}
