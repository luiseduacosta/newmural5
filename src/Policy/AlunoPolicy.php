<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Aluno;
use App\Model\Entity\Monografia;
use Authorization\IdentityInterface;

/**
 * Aluno policy
 */
use Cake\ORM\TableRegistry;

class AlunoPolicy
{

    /**
     * Check if $user can add Aluno
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Aluno $aluno
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Aluno $aluno)
    {
        if (!isset($user)) {
            return false;
        } elseif ($user->categoria == '1') {
            return true;
        } elseif ($user->categoria == '2') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if $user can edit Aluno
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Aluno $aluno
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Aluno $aluno)
    {
        if (!isset($user)) {
            return false;
        } elseif ($user->categoria == '1') {
            return true;
        } elseif ($user->categoria == '2') {
            return $this->isAuthor($user, $aluno);
        } else {
            return false;
        }
    }

    /**
     * Check if $user can view Aluno
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Aluno $aluno
     * @return bool
     */
    public function canView(IdentityInterface $user, Aluno $aluno)
    {
        if (!isset($user)) {
            return false;
        } elseif ($user->categoria == '1') {
            return true;
        } elseif ($user->categoria == '2') {
            return $this->isAuthor($user, $aluno);
        } else {
            return false;
        }
    }

    /**
     * Check if $user can delete Aluno
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Aluno $aluno
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Aluno $aluno)
    {
        return isset($user->categoria) && $user->categoria == '1';
    }

    protected function isAuthor(IdentityInterface $user, Aluno $aluno)
    {
        return $aluno->id === $user->estudante_id;
    }

}
