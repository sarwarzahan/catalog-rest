<?php

namespace AppBundle\Entity;

use AppBundle\Model\CategoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Product;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation as JMSSerializer;

/**
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\CategoryEntityRepository")
 * @ORM\Table(name="category", indexes={
 * @ORM\Index(name="name_idx", columns={"name"})
 * })
 * @UniqueEntity("name", message="That category name exists!")
 * @JMSSerializer\ExclusionPolicy("all")
 */
class Category implements CategoryInterface, \JsonSerializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMSSerializer\Expose
     * @JMSSerializer\Type("string")
     * @JMSSerializer\Groups({"products_all"})
     */
    protected $id;

    /**
     * @ORM\Column(type="string", name="name")
     * @JMSSerializer\Expose
     * @JMSSerializer\Groups({"category_all"})
     */
    private $name;
    
    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="category")
     */
    protected $products;
    
    /**
     * @var datetime $created_at
     *
     * @ORM\Column(type="datetime")
     */
    protected $created_at;

    /**
     * @var datetime $updated_at
     * 
     * @ORM\Column(type="datetime", nullable = true)
     */
    protected $updated_at;
    
    
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    function jsonSerialize()
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
        ];
    }
    
    /**
     * Gets triggered only on insert

     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created_at = new \DateTime("now");
        $this->updated_at = new \DateTime("now");
    }

    /**
     * Gets triggered every time on update

     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updated_at = new \DateTime("now");
    }

}
