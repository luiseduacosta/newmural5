<?php
declare(strict_types=1);

namespace App\Policy;

use \Authorization\IdentityInterface;
use \App\Model\Entity\Professor;

/**
 * Professor policy
 */
class ProfessorPolicy
{
    /**
     * Check if $user can create Professor
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Professor $professsor
     * @return bool
     */
    public function canAdd(?IdentityInterface $user, Professor $professor)
    {
        return isset($user->categoria) && ($user->categoria == '1' && $user->categoria == '3');
    }

    /**
     * Check if $user can update Professor
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Professor $professor'
     * @return bool
     */
    public function canEdit(?IdentityInterface $user, Professor $professor)
    {
        if ($user->categoria == '3') {
            return $professor->id === $user->professor_id;
        }
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can delete Docente
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Professor $professor
     * @return bool
     */
    public function canDelete(?IdentityInterface $user, Professor $professor)
    {
        return isset($user->categoria) && $user->categoria == '1';
    }

    /**
     * Check if $user can view Docente
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Professor $professor
     * @return bool
     */
    public function canView(?IdentityInterface $user, Professor $professor)
    {
        if (isset($user->categoria) && $user->categoria == '1') {
            return true;
        } else if (isset($user->categoria) && $user->categoria == '3') {
            return $professor->id === $user->professor_id;
        }        
        return true;
    }
    
    protected function isAuthor(?IdentityInterface $user, Professor $professor)
    {
        return $professor->id === $user->professor_id;
    }



}
