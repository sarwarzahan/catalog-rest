<?php

namespace AppBundle\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use AppBundle\Entity\User;

class ProductVoter implements VoterInterface
{
    const CREATE = 'create';
    const UPDATE = 'update';
    const DELETE = 'delete';

    public function supportsAttribute($attribute)
    {
        return in_array($attribute, array(
            self::CREATE,
            self::UPDATE,
            self::DELETE,
        ));
    }
    
    public function supportsClass($class)
    {
        $supportedClass = 'AppBundle\Controller\ProductController';
        return $supportedClass === $class || is_subclass_of($class, $supportedClass);
    }

    public function vote(TokenInterface $token, $requestedController, array $attributes)
    {
        // check if class of this object is supported by this voter
        if (!$this->supportsClass(get_class($requestedController))) {
            return VoterInterface::ACCESS_ABSTAIN;
        }
        
        // set the attribute to check against
        $attribute = $attributes[0];

        // check if the given attribute is covered by this voter
        if (!$this->supportsAttribute($attribute)) {
            return VoterInterface::ACCESS_ABSTAIN;
        }
        
        $user = $token->getUser();
        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return VoterInterface::ACCESS_DENIED;
        }
        
        // make sure there is a user object (i.e. that the user is logged in)
        if ($user->hasRole('ROLE_USER')) {
            $decision = VoterInterface::ACCESS_DENIED;
            switch ($attribute) {
                case 'create':
                    $decision = VoterInterface::ACCESS_GRANTED;
                    break;
                case 'update':
                    $decision = VoterInterface::ACCESS_GRANTED;
                    break;
                case 'delete':
                    $decision = VoterInterface::ACCESS_GRANTED;
                    break;
                default:
                    $decision = VoterInterface::ACCESS_DENIED;
                    break;
            }
            
            return $decision;
        }

        return VoterInterface::ACCESS_DENIED;
    }
}
