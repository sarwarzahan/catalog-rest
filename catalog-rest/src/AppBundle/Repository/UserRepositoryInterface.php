<?php

namespace AppBundle\Repository;
use AppBundle\Model\UserInterface;

/**
 * Interface UserRepositoryInterface
 * @package AppBundle\Repository
 */
interface UserRepositoryInterface
{
    /**
     * @param UserInterface $user
     * @return mixed
     */
    public function refresh(UserInterface $user);

    /**
     * @param UserInterface $user
     * @param array         $options
     * @return mixed
     */
    public function save(UserInterface $user, array $options = ['flush'=>true]);
    
    /**
     * @param UserInterface      $user
     * @param array                 $arguments
     */
    public function delete(UserInterface $user, array $arguments = []);
}