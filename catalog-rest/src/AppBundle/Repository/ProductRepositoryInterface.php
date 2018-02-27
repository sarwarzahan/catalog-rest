<?php

namespace AppBundle\Repository;

use AppBundle\Model\ProductInterface;

/**
 * Interface ProductRepositoryInterface
 * @package AppBundle\Repository
 */
interface ProductRepositoryInterface
{
    /**
     * @param ProductInterface $Product
     * @return mixed
     */
    public function refresh(ProductInterface $Product);

    /**
     * @param ProductInterface      $Product
     * @param array                 $arguments
     */
    public function save(ProductInterface $Product, array $arguments = []);

    /**
     * @param ProductInterface      $Product
     * @param array                 $arguments
     */
    public function delete(ProductInterface $Product, array $arguments = []);

    /**
     * @param                       $id
     * @return                      mixed|null
     */
    public function findOneById($id);
}