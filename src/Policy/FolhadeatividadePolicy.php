<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Folhadeatividade;
use Authorization\IdentityInterface;

/**
 * Folhadeatividade policy
 */
class FolhadeatividadePolicy {

    /**
     * Check if $user can add Folhadeatividade
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Folhadeatividade $folhadeatividade
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Folhadeatividade $folhadeatividade) {
        return isset($user->categoria) && $user->categoria == '1' || $user->categoria == '2';
    }

    /**
     * Check if $user can edit Folhadeatividade
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Folhadeatividade $folhadeatividade
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Folhadeatividade $folhadeatividade) {
        return isset($user->categoria) && $user->categoria == '1' || $user->categoria == '2';
    }

    /**
     * Check if $user can delete Folhadeatividade
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Folhadeatividade $folhadeatividade
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Folhadeatividade $folhadeatividade) {
        return isset($user->categoria) && $user->categoria == '1' || $user->categoria == '2';
    }

    /**
     * Check if $user can view Folhadeatividade
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Folhadeatividade $folhadeatividade
     * @return bool
     */
    public function canView(IdentityInterface $user, Folhadeatividade $folhadeatividade) {
        return true;
    }

    /**
     * Check if $user can atividade Folhadeatividade
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Folhadeatividade $folhadeatividade
     * @return bool
     */
    public function canAtividade(IdentityInterface $user, Folhadeatividade $folhadeatividade) {
        return isset($user->categoria) && $user->categoria == '1' || $user->categoria == '2';
    }

    /**
     * Check if $user can folhadeatividades pdf
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Folhadeatividade $folhadeatividade
     * @return bool
     */
    public function canFolhadeatividadespdf(IdentityInterface $user, Folhadeatividade $folhadeatividade) {
        return isset($user->categoria) && $user->categoria == '1' || $user->categoria == '2';
    }
}
