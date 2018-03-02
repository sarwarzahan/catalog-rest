<?php

namespace AppBundle\Entity\Repository;

use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Doctrine\ORM\EntityRepository;

class UserEntityRepository extends EntityRepository implements UserLoaderInterface
{
    /**
     * @param       $user
     * @param array $options
     */
    public function save($user, $options = ['flush'=>true])
    {
        $this->_em->persist($user);

        if ($options['flush'] === true) {
            $this->_em->flush();
        }
    }
    
    /**
     * Load a user by username or email
     * 
     * @param string $username
     * @return AppBundle\Entity\User
     */
    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }
}