<?php

namespace AppBundle\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class ProductVoter implements VoterInterface
{
    const VIEW = 'view';

    public function supportsAttribute($attribute)
    {
        return in_array($attribute, array(
            self::VIEW,
        ));
    }

    public function supportsClass($class)
    {
        $supportedClass = 'AppBundle\Model\ProductInterface';

        return $supportedClass === $class || is_subclass_of($class, $supportedClass);
    }

    public function vote(TokenInterface $token, $requestedProducts, array $attributes)
    {
        // Check if it's list of products
        $isList = FALSE;
        if (is_array($requestedProducts)) {
            // Fetch the first product
            $product = $requestedProducts[0];
            $isList = TRUE;
        } else {
            $product = $requestedProducts;
        }
        // check if class of this object is supported by this voter
        if (!$this->supportsClass(get_class($product))) {
            return VoterInterface::ACCESS_ABSTAIN;
        }
        
        // For list of products no security
        if ($isList) {
            return VoterInterface::ACCESS_GRANTED;
        }

        // set the attribute to check against
        $attribute = $attributes[0];

        // check if the given attribute is covered by this voter
        if (!$this->supportsAttribute($attribute)) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        // get current logged in user
        $loggedInUser = $token->getUser();

        // make sure there is a user object (i.e. that the user is logged in)
        if ($loggedInUser->hasRole('ROLE_USER')) {
            return VoterInterface::ACCESS_GRANTED;
        }

        return VoterInterface::ACCESS_DENIED;
    }

}
