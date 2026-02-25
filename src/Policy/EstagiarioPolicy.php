<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Estagiario;
use Authorization\IdentityInterface;

/**
 * Estagiario policy
 */
class EstagiarioPolicy
{
        /**
         * Check if $user can create Estagiario
         *
         * @param \Authorization\IdentityInterface|null $user The user.
         * @param \App\Model\Entity\Estagiario $estagiario
         * @return bool
         */
        public function canAdd(?IdentityInterface $user, Estagiario $estagiario)
        {
                return isset($user->categoria) && ($user->categoria == '1' || $user->categoria == '2');
        }

        /**
         * Check if $user can update Estagiario
         *
         * @param \Authorization\IdentityInterface|null $user The user.
         * @param \App\Model\Entity\Estagiario $estagiario
         * @return bool
         */
        public function canEdit(?IdentityInterface $user, Estagiario $estagiario)
        {
                return isset($user->categoria) && ($user->categoria == '1' || $user->categoria == '2' || $user->categoria == '3');
        }

        /**
         * Check if $user can delete Estagiario
         *
         * @param \Authorization\IdentityInterface|null $user The user.
         * @param \App\Model\Entity\Estagiario $estagiario
         * @return bool
         */
        public function canDelete(?IdentityInterface $user, Estagiario $estagiario)
        {
                return isset($user->categoria) && $user->categoria == '1';
        }

        /**
         * Check if $user can view Estagiario
         *
         * @param \Authorization\IdentityInterface|null $user The user.
         * @param \App\Model\Entity\Estagiario $estagiario
         * @return bool
         */
        public function canView(?IdentityInterface $user, Estagiario $estagiario)
        {
                return true;
        }

        /**
         * Check if $user can create Novo Termo de Compromisso
         *
         * @param \Authorization\IdentityInterface|null $user The user.
         * @param \App\Model\Entity\Estagiario $estagiario
         * @return bool
         */
        public function canNovotermocompromisso(?IdentityInterface $user, Estagiario $estagiario)
        {
                return isset($user->categoria) && ($user->categoria == '1' || $user->categoria == '2');
        }

}
