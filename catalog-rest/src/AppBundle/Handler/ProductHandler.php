<?php

namespace AppBundle\Handler;

use AppBundle\Repository\ProductRepositoryInterface;
use AppBundle\Form\Handler\FormHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Model\ProductInterface;

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
    
    public function getRepository()
    {
        return $this->repository;
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
     * @param  ProductInterface     $requestedProduct
     * @param  array                $parameters
     * @param  array                $options
     * @return mixed
     */
    public function patch($requestedProduct, array $parameters, array $options = [])
    {
        $this->checkAccountImplementsInterface($requestedProduct);

        $productEntityClass = $this->repository->getEntityClassName();
        
        $product = $this->formHandler->handle(
            new $productEntityClass(),
            $parameters,
            Request::METHOD_PATCH,
            $options
        );

        $this->repository->refresh($requestedProduct);
        $requestedProduct->replaceValueFromEntity($product);
        $this->repository->save($requestedProduct);

        return $requestedProduct;
    }

    /**
     * @param mixed $resource
     * @return bool
     */
    public function delete($resource)
    {
        $this->checkAccountImplementsInterface($resource);

        $this->repository->delete($resource);

        return true;
    }
    
    /**
     * @param $product
     */
    private function checkAccountImplementsInterface($product)
    {
        if (!$product instanceof ProductInterface) {
            throw new \InvalidArgumentException('Product must implement ProductInterface');
        }
    }

}