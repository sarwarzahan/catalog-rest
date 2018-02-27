<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Model\ProductInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

class ProductEntityRepository extends EntityRepository
{
    /**
     * @param   UserInterface       $user
     * @return  array
     */
    public function findAllForUser(ProductInterface $product)
    {
        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('a')
            ->from('AppBundle\Entity\Account', 'a')
            ->join('a.users', 'u')
            ->where('u.id = :userId')
            ->setParameter('userId', $product->getId())
            ->getQuery();

        return $query->getResult();
    }
}