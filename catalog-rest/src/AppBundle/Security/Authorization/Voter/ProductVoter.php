<?php

namespace AppBundle\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use AppBundle\Entity\User;

class ProductVoter implements VoterInterface
{
    const VIEW = 'view';
    
    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    public function supportsAttribute($attribute)
    {
        return in_array($attribute, array(
            self::VIEW,
        ));
    }

    public function vote(TokenInterface $token, $requestedAction, array $attributes)
    {
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
            switch ($requestedAction) {
                case 'post':
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
