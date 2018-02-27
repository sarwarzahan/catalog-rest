<?php

namespace AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Product;
use AppBundle\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture implements FixtureInterface, ContainerAwareInterface
{
    private $manager;
    private $container;
    private $em;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    public function load(ObjectManager $manager)
    {
        $this->em = $this->container->get('doctrine')->getEntityManager('default');


        $this->manager = $manager;
        
        // Create Category
        $this->categoryFactory('Games');
        $this->categoryFactory('Computers');
        $this->categoryFactory('TVs and Accessories');
        
        $this->manager->flush();
        
        // Create product
        $this->productFactory('Pong', 'Games', 'A0001', '69.99', '20');
        $this->productFactory('GameStation 5', 'Games', 'A0002', '269.99', '15');
        $this->productFactory('AP Oman PC - Aluminum', 'Computers', 'A0003', '1399.99', '10');
        $this->productFactory('Fony UHD HDR 55\" 4k TV', 'TVs and Accessories', 'A0004', '1399.99', '5');
        
        // Create user
        $this->userFactory('bobby', 'bobby@foo.com', 'Bobby', 'Fischer', 'bobby123');
        $this->userFactory('betty', 'betty@foo.com', 'Betty', 'Rubble', 'betty123');
        
        $this->manager->flush();
    }
    
    private function categoryFactory($categoryName) 
    {
        $category = new Category();
        $category->setName($categoryName);
        $this->manager->persist($category);
    }
    
    private function productFactory($name, $categoryName, $sku, $price, $quantity) 
    {
        $product = new Product();
        $product->setName($name);
        $repository = $this->em->getRepository('AppBundle:Category');
        $category = $repository->findOneByName(array('name' => $categoryName));
        $product->setCategory($category);
        $product->setSku($sku);
        $product->setPrice($price);
        $product->setQuantity($quantity);
        
        $this->manager->persist($product);
    }
    
    private function userFactory($username, $email, $first_name, $last_name, $password) 
    {
        // Create user
        $userManager = $this->container->get('fos_user.user_manager');
        // Create our user and set details
        $user = $userManager->createUser();
        $user->setUsername($username);
        $user->setFirstName($first_name);
        $user->setLastName($last_name);
        $user->setEmail($email);
        $user->setPlainPassword($password);
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_USER'));
        // Update the user
        $userManager->updateUser($user, true);
    }
}