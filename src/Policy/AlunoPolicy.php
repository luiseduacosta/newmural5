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
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Aluno $aluno
     * @return bool
     */
    public function canAdd(?IdentityInterface $user, Aluno $aluno)
    {
        if (!isset($user)) {
            return false;
        } elseif ($user->getOriginalData()->isAdmin()) {
            return true;
        } elseif ($user->getOriginalData()->isAluno()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if $user can edit Aluno
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Aluno $aluno
     * @return bool
     */
    public function canEdit(?IdentityInterface $user, Aluno $aluno)
    {
        if (!isset($user)) {
            return false;
        } elseif ($user->getOriginalData()->isAdmin()) {
            return true;
        } elseif ($user->getOriginalData()->isAluno()) {
            return $this->isAuthor($user, $aluno);
        } else {
            return false;
        }
    }

    /**
     * Check if $user can view Aluno
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Aluno $aluno
     * @return bool
     */
    public function canView(?IdentityInterface $user, Aluno $aluno)
    {
        if (!isset($user)) {
            return false;
        } elseif ($user->getOriginalData()->isAdmin()) {
            return true;
        } elseif ($user->getOriginalData()->isAluno()) {
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
    public function canDelete(?IdentityInterface $user, Aluno $aluno)
    {
        return isset($user) && $user->getOriginalData()->isAdmin();
    }

    public function canCargaHoraria(?IdentityInterface $user, Aluno $aluno)
    {
        if (!isset($user)) {
            return false;
        } elseif ($user->getOriginalData()->isAdmin()) {
            return true;
        }
    }

    public function canDeclaracaoperiodo(?IdentityInterface $user, Aluno $aluno)
    {
        if (!isset($user)) {
            return false;
        } elseif ($user->getOriginalData()->isAdmin()) {
            return true;
        } elseif ($user->getOriginalData()->isAluno()) {
            return $this->isAuthor($user, $aluno);
        } else {
            return false;
        }
    }

    public function canCertificadoperiodo(?IdentityInterface $user, Aluno $aluno)
    {
        if (!isset($user)) {
            return false;
        } elseif ($user->getOriginalData()->isAdmin()) {
            return true;
        } elseif ($user->getOriginalData()->isAluno()) {
            return $this->isAuthor($user, $aluno);
        } else {
            return false;
        }
    }

    public function canCertificadoperiodopdf(?IdentityInterface $user, Aluno $aluno)
    {
        if (!isset($user)) {
            return false;
        } elseif ($user->getOriginalData()->isAdmin()) {
            return true;
        } elseif ($user->getOriginalData()->isAluno()) {
            return $this->isAuthor($user, $aluno);
        } else {
            return false;
        }
    }

    public function canPlanilhaCress(?IdentityInterface $user, Aluno $aluno)
    {
        if (!isset($user)) {
            return false;
        } elseif ($user->getOriginalData()->isAdmin()) {
            return true;
        } 
    }

    protected function isAuthor(?IdentityInterface $user, Aluno $aluno)
    {
        return $aluno->id === $user->estudante_id;
    }

    public function isAuthorMonografia(?IdentityInterface $user, Monografia $monografia)
    {
        $aluno = TableRegistry::getTableLocator()->get('Aluno')->get($monografia->aluno_id);
        return $this->isAuthor($user, $aluno);
    }
}
