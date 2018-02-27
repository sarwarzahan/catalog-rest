<?php

namespace AppBundle\Repository\Restricted;

use AppBundle\Model\CategoryInterface;
use AppBundle\Repository\CategoryRepositoryInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class RestrictedCategoryRepository extends RestrictedRepository implements CategoryRepositoryInterface
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $repository;

    /**
     * RestrictedCategoryRepository constructor.
     * @param CategoryRepositoryInterface $repository
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(
        CategoryRepositoryInterface $repository,
        AuthorizationCheckerInterface $authorizationChecker
    )
    {
        $this->repository = $repository;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @param CategoryInterface $category
     * @return mixed
     */
    public function refresh(CategoryInterface $category)
    {
        $this->denyAccessUnlessGranted('view', $category);

        $this->repository->refresh($category);
    }

    /**
     * @param CategoryInterface $category
     * @param array $arguments
     */
    public function save(CategoryInterface $category, array $arguments = ['flush'=>true])
    {
        $this->denyAccessUnlessGranted('view', $category);

        $this->repository->save($category, $arguments);
    }

    /**
     * @param CategoryInterface $category
     * @param array $arguments
     */
    public function delete(CategoryInterface $category, array $arguments = ['flush'=>true])
    {
        $this->denyAccessUnlessGranted('view', $category);

        $this->repository->delete($category, $arguments);
    }

    /**
     * @param $id
     * @return mixed|null
     */
    public function findOneById($id)
    {
        $category = $this->repository->findOneById($id);

        $this->denyAccessUnlessGranted('view', $category);

        return $category;
    }
}