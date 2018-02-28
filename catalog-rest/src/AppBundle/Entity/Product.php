<?php

namespace AppBundle\Entity;

use AppBundle\Model\ProductInterface;
use AppBundle\Entity\Category;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMSSerializer;

/**
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ProductEntityRepository")
 * @ORM\Table(name="product")
 * @JMSSerializer\ExclusionPolicy("all")
 */
class Product implements ProductInterface, \JsonSerializable
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
     * @JMSSerializer\Groups({"products_all"})
     */
    private $name;
    
    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products", cascade={"persist"})
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;
    
    /**
     * @ORM\Column(type="string", name="sku")
     * @JMSSerializer\Expose
     * @JMSSerializer\Groups({"products_all"})
     */
    private $sku;
    
    /**
     * @ORM\Column(type="decimal", name="price", precision=8, scale=2)
     * @JMSSerializer\Expose
     * @JMSSerializer\Groups({"products_all"})
     */
    private $price;
    
    /**
     * @ORM\Column(type="integer", name="quantity", nullable=false, options={"unsigned":true, "default":0})
     * @JMSSerializer\Expose
     * @JMSSerializer\Groups({"products_all"})
     */
    private $quantity;
    
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
    
    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }
    
    public function getSku()
    {
        return $this->sku;
    }

    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }
    
    public function getprice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }
    
    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }
    
    function getCreated_at()
    {
        return $this->created_at;
    }

    function getUpdated_at() 
    {
        return $this->updated_at;
    }
    
    function setId($id) {
        $this->id = $id;
    }

    function setCreated_at(\datetime $created_at) {
        $this->created_at = $created_at;
    }

    function setUpdated_at(\datetime $updated_at) {
        $this->updated_at = $updated_at;
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
