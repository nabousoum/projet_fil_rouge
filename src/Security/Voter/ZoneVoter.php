<?php
// api/src/Security/Voter/ZoneVoter.php

namespace App\Security\Voter;

use App\Entity\Zone;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class ZoneVoter extends Voter
{
    private $security = null;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject): bool
    {
        if ($attribute == "ZONE_ALL") {
            $subject = new $subject();
        }
        $supportsAttribute = in_array($attribute, ['ZONE_CREATE', 'ZONE_READ', 'ZONE_EDIT', 'ZONE_DELETE','ZONE_ALL']);
        $supportsSubject = $subject instanceof Zone;
        return $supportsAttribute && $supportsSubject;
   
    }

    /**
     * @param string $attribute
     * @param Zone $subject
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
            case 'ZONE_CREATE':
                if ( $this->security->isGranted("ROLE_GESTIONNAIRE") ) 
                { 
                    return true;
                }  // only admins can create Zones
                break;
            case 'ZONE_ALL':
                if ( $this->security->isGranted("ROLE_GESTIONNAIRE") ) 
                { 
                    return true;
                }  // only admins can create Zones
                break;
            case 'ZONE_READ':
                if ( $this->security->isGranted("ROLE_GESTIONNAIRE") ) 
                { 
                    return true;
                } 
                break;
            case 'ZONE_EDIT':
                if ( $this->security->isGranted("ROLE_GESTIONNAIRE") ) 
                { 
                    return true;
                } 
                break;
        }

        return false;
    }
}