<?php
// api/src/Security/Voter/QuartierVoter.php

namespace App\Security\Voter;

use App\Entity\Quartier;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class QuartierVoter extends Voter
{
    private $security = null;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject): bool
    {
        if ($attribute == "QUARTIER_ALL") {
            $subject = new $subject();
        }
        $supportsAttribute = in_array($attribute, ['QUARTIER_CREATE', 'QUARTIER_READ', 'QUARTIER_EDIT', 'QUARTIER_DELETE','QUARTIER_ALL']);
        $supportsSubject = $subject instanceof Quartier;
        return $supportsAttribute && $supportsSubject;
   
    }

    /**
     * @param string $attribute
     * @param Quartier $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        switch ($attribute) {
            case 'QUARTIER_CREATE':
                if ( $this->security->isGranted("ROLE_GESTIONNAIRE") ) 
                { 
                    return true;
                }  // only admins can create Quartiers
                break;
            case 'QUARTIER_ALL':
                if ( $this->security->isGranted("ROLE_GESTIONNAIRE") ) 
                { 
                    return true;
                }  // only admins can create Quartiers
                break;
            case 'QUARTIER_READ':
                if ( $this->security->isGranted("ROLE_GESTIONNAIRE") ) 
                { 
                    return true;
                } 
                break;
            case 'QUARTIER_EDIT':
                if ( $this->security->isGranted("ROLE_GESTIONNAIRE") ) 
                { 
                    return true;
                } 
                break;
        }

        return false;
    }
}