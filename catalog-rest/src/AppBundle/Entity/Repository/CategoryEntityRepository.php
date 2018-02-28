<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class CategoryEntityRepository extends EntityRepository
{
    /**
     * Duplicate functionality from parent class to remove dependency from doctrine
     * 
     * @param type $id
     * @return object|null The entity instance or NULL if the entity can not be found.
     */
    public function find($id)
    {
        return parent::find($id);
    }
    
    /**
     * Duplicate functionality to remove dependency from doctrine
     * 
     * @return array The entities.
     */
    public function findAll()
    {
        return parent::findAll();
    }
}