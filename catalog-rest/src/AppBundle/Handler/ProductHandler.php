<?php

namespace AppBundle\Handler;

use AppBundle\Repository\ProductRepositoryInterface;
use AppBundle\Form\Handler\FormHandlerInterface;
use Symfony\Component\HttpFoundation\Request;

class ProductHandler implements HandlerInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private $repository;
    
    /**
     * @var FormHandlerInterface
     */
    private $formHandler;

    public function __construct(ProductRepositoryInterface $productRepository,
            FormHandlerInterface $formHandler
    )
    {
        $this->repository = $productRepository;
        $this->formHandler = $formHandler;
    }

    public function get($id)
    {
        return $this->repository->findOneById($id);
    }

    public function all($limit = 10, $offset = 0)
    {
        return $this->repository->findAll();
    }

    /**
     * @param array                 $parameters
     * @param array                 $options
     * @return ProductInterface
     */
    public function post(array $parameters, array $options = [])
    {
        $productEntityClass = $this->repository->getEntityClassName();
        $product = $this->formHandler->handle(
            new $productEntityClass(),
            $parameters,
            Request::METHOD_POST,
            $options
        );

        $this->repository->save($product);

        return $product;
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