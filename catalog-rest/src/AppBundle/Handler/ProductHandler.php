<?php

namespace AppBundle\Handler;

use AppBundle\Repository\ProductRepositoryInterface;

class ProductHandler implements HandlerInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private $repository;

    public function __construct(ProductRepositoryInterface $productRepositoryInterface)
    {
        $this->repository = $productRepositoryInterface;
    }

    public function get($id)
    {
        return $this->repository->findOneById($id);
    }

    public function all($limit = 10, $offset = 0)
    {
        throw new \DomainException('ProductHandler::all is currently not implemented.');
    }

    public function post(array $parameters, array $options = [])
    {
        throw new \DomainException('ProductHandler::post is currently not implemented.');
    }

    public function put($resource, array $parameters, array $options = [])
    {
        throw new \DomainException('ProductHandler::put is currently not implemented.');
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
        throw new \DomainException('ProductHandler::delete is currently not implemented.');
    }

}