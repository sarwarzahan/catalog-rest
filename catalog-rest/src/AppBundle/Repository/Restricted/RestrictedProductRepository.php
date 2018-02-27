<?php

namespace AppBundle\Repository\Restricted;

use AppBundle\Model\ProductInterface;
use AppBundle\Repository\ProductRepositoryInterface;
use AppBundle\Repository\RepositoryInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class RestrictedProductRepository
 * @package AppBundle\Repository\Restricted
 */
class RestrictedProductRepository extends RestrictedRepository implements ProductRepositoryInterface, RepositoryInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private $repository;

    /**
     * RestrictedProductRepository constructor.
     * @param ProductRepositoryInterface $repository
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(
        ProductRepositoryInterface $repository,
        AuthorizationCheckerInterface $authorizationChecker
    )
    {
        $this->repository = $repository;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @param ProductInterface $product
     * @return mixed
     */
    public function refresh(ProductInterface $product)
    {
        $this->authorizationChecker->isGranted('view', $product);

        $this->repository->refresh($product);
    }

    /**
     * @param ProductInterface $product
     * @param array $arguments
     */
    public function save(ProductInterface $product, array $arguments = [])
    {
        $this->authorizationChecker->isGranted('view', $product);

        $this->repository->save($product);
    }

    /**
     * @param ProductInterface $product
     * @param array $arguments
     */
    public function delete(ProductInterface $product, array $arguments = [])
    {
        $this->authorizationChecker->isGranted('view', $product);

        $this->repository->delete($product);
    }

    /**
     * @param $id
     * @return mixed|null
     */
    public function findOneById($id)
    {
        $product = $this->repository->findOneById($id);

        $this->denyAccessUnlessGranted('view', $product);

        return $product;
    }
}
