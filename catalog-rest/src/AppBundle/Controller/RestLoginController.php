<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;

class RestLoginController extends FOSRestController
{

    /**
     * @Annotations\Post("/login")
     */
    public function loginAction()
    {
        // The login handled by Lexik JWT Bundle
        throw new \DomainException('Invalid login action');
    }
}