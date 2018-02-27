<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Model\ProductInterface;
use AppBundle\Repository\ProductRepositoryInterface;
use AppBundle\Entity\Repository\ProductEntityRepository;
use AppBundle\Repository\RepositoryInterface;

/**
 * Class DoctrineProductRepository
 * @package AppBundle\Repository\Doctrine
 */
class DoctrineProductRepository implements ProductRepositoryInterface, RepositoryInterface
{
    /**
     * @var CommonDoctrineRepository
     */
    private $commonRepository;
    /**
     * @var ProductEntityRepository
     */
    private $productEntityRepository;

    /**
     * DoctrineUserRepository constructor.
     * @param   CommonDoctrineRepository    $commonRepository
     * @param   ProductEntityRepository     $productEntityRepository
     */
    public function __construct(CommonDoctrineRepository $commonRepository, ProductEntityRepository $productEntityRepository)
    {
        $this->commonRepository = $commonRepository;
        $this->productEntityRepository = $productEntityRepository;
    }

    /**
     * @param ProductInterface $product
     */
    public function refresh(ProductInterface $product)
    {
        $this->commonRepository->refresh($product);
    }

    /**
     * @param   ProductInterface    $product
     * @param   array               $arguments
     */
    public function save(ProductInterface $product, array $arguments = ['flush'=>true])
    {
        $this->commonRepository->save($product, $arguments);
    }

    /**
     * @param   ProductInterface    $product
     * @param   array               $arguments
     */
    public function delete(ProductInterface $product, array $arguments = ['flush'=>true])
    {
        $this->commonRepository->delete($product, $arguments);
    }

    /**
     * @param   $id
     * @return  mixed
     */
    public function findOneById($id)
    {
        return $this->productEntityRepository->find($id);
    }
}
