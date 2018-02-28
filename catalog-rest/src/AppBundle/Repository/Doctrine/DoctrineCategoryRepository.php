<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Repository\CategoryEntityRepository;
use AppBundle\Model\CategoryInterface;
use AppBundle\Repository\CategoryRepositoryInterface;

/**
 * Class DoctrineCategoryRepository
 * @package AppBundle\Repository\Doctrine
 */
class DoctrineCategoryRepository implements CategoryRepositoryInterface
{
    /**
     * @var CommonDoctrineRepository
     */
    private $commonRepository;
    /**
     * @var CategoryEntityRepository
     */
    private $categoryEntityRepository;

    /**
     * DoctrineCategoryRepository constructor.
     * @param CommonDoctrineRepository $commonRepository
     * @param CategoryEntityRepository $categoryEntityRepository
     */
    public function __construct(CommonDoctrineRepository $commonRepository, CategoryEntityRepository $categoryEntityRepository)
    {
        $this->commonRepository = $commonRepository;
        $this->categoryEntityRepository = $categoryEntityRepository;
    }

    /**
     * @param CategoryInterface         $category
     */
    public function refresh(CategoryInterface $category)
    {
        $this->commonRepository->refresh($category);
    }

    /**
     * @param   CategoryInterface       $category
     * @param   array               $arguments
     */
    public function save(CategoryInterface $category, array $arguments = ['flush'=>true])
    {
        $this->commonRepository->save($category, $arguments);
    }

    /**
     * @param   CategoryInterface       $category
     * @param   array               $arguments
     */
    public function delete(CategoryInterface $category, array $arguments = ['flush'=>true])
    {
        $this->commonRepository->delete($category, $arguments);
    }

    /**
     * @param   $id
     * @return  mixed
     */
    public function findOneById($id)
    {
        return $this->categoryEntityRepository->find($id);
    }
    
    /**
     * @param   $id
     * @return  collection
     */
    public function findAll()
    {
        return $this->categoryEntityRepository->findAll();
    }
}