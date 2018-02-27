<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Model\CategoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

class CategoryEntityRepository extends EntityRepository
{
    /**
     * @param   UserInterface       $user
     * @return  array
     */
    public function findOneByName($name)
    {
        $category= $this->findOneBy(array('name'=> $name));

        return $category;
    }
}