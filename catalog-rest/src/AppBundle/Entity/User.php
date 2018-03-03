<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity
 * @ORM\Table(name="users", indexes={
 * @ORM\Index(name="username_idx", columns={"username"}),
 * @ORM\Index(name="email_idx", columns={"email"})
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\UserEntityRepository")
 *
 * @UniqueEntity("email", message="That email is taken!")
 */
class User extends BaseUser implements UserInterface {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @Assert\NotBlank(message="Give us at least 3 characters")
     * @Assert\Length(min=3, minMessage="Give us at least 3 characters!")
     */
    protected $username;

    /**
     * @var string The email of the user.
     * 
     * @Assert\NotBlank
     * @Assert\Email
     */
    protected $email;
    
    /**
     * @ORM\Column(name="first_name", type="string")
     */
    protected $first_name;

    /**
     * @ORM\Column(name="last_name", type="string")
     */
    protected $last_name;
    
    protected $password;
    
    protected $roles = array();
    
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

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return string
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }
    
    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return string
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
    
    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return string
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param $plainPassword
     * @return string
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }
    
    /**
     * Set first name
     *
     * @param string $first_name
     *
     * @return User
     */
    public function setFirstName($first_name) {
        $this->first_name = $first_name;
        return $this;
    }

    /**
     * Get first name
     *
     * @return string
     */
    public function getFirstName() {
        return $this->first_name;
    }
    
    /**
     * Set last name
     *
     * @param string $last_name
     *
     * @return User
     */
    public function setLastName($last_name) {
        $this->last_name = $last_name;
        return $this;
    }

    /**
     * Get last name
     *
     * @return string
     */
    public function getLastName() {
        return $this->last_name;
    }



    /**
     * @return array Role
     */
    public function getRoles()
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param array $roles
     * @return this
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Removes sensitive data from the user
     */
    public function eraseCredentials()
    {
        $this->setPlainPassword(null);
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return null;
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
