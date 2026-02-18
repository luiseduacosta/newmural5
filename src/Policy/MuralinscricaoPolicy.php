<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Muralinscricao;
use Authorization\IdentityInterface;

/**
 * Muralinscricao policy
 */
class MuralinscricaoPolicy {

    /**
     * Check if $user can add Muralinscricao
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Muralinscricao $muralinscricao
     * @return bool
     */
    public function canAdd(?IdentityInterface $user, Muralinscricao $muralinscricao) {
        return isset($user->categoria) && $user->categoria == '1' || $user->categoria == '2';
    }

    /**
     * Check if $user can edit Muralinscricao
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Muralinscricao $muralinscricao
     * @return bool
     */
    public function canEdit(?IdentityInterface $user, Muralinscricao $muralinscricao) {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can delete Muralinscricao
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Muralinscricao $muralinscricao
     * @return bool
     */
    public function canDelete(?IdentityInterface $user, Muralinscricao $muralinscricao) {

        if (isset($user->categoria) && $user->categoria == '1'){
            return true;
        } elseif (isset($user->categoria) && $user->categoria == '2') {
            return $muralinscricao->aluno_id == $user->aluno_id;
        }
        return false;
    }

    /**
     * Check if $user can view Muralinscricao
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Muralinscricao $muralinscricao
     * @return bool
     */
    public function canView(?IdentityInterface $user, Muralinscricao $muralinscricao) {
        return isset($user->categoria) && ($user->categoria == '1' || $user->categoria == '2');
    }

}
