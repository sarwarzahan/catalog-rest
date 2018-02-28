<?php

namespace AppBundle\Handler;

use AppBundle\Repository\CategoryRepositoryInterface;

class CategoryHandler implements HandlerInterface
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $repository;

    public function __construct(CategoryRepositoryInterface $productRepository)
    {
        $this->repository = $productRepository;
    }

    public function get($id)
    {
        throw new \DomainException('CategoryHandler::get is currently not implemented.');
    }

    public function all($limit = 10, $offset = 0)
    {
        return $this->repository->findAll();
    }

    public function post(array $parameters, array $options = [])
    {
        throw new \DomainException('CategoryHandler::post is currently not implemented.');
    }

    public function put($resource, array $parameters, array $options = [])
    {
        throw new \DomainException('CategoryHandler::put is currently not implemented.');
    }

    /**
     * @param UserInterface     $user
     * @param array             $parameters
     * @param array             $options
     * @return UserInterface
     */
    public function patch($user, array $parameters, array $options = [])
    {
        $this->repository->save($user);

        return $user;
    }

    public function delete($resource)
    {
        throw new \DomainException('CategoryHandler::delete is currently not implemented.');
    }

}