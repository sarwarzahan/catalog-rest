<?php

namespace AppBundle\Controller;

use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\View\RouteRedirectView;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Handler\HandlerInterface;

/**
 * Class CategoryController
 * @package AppBundle\Controller
 * @Annotations\RouteResource("category")
 */
class CategoryController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @var HandlerInterface
     */
    private $handler;

    public function __construct(HandlerInterface $handler)
    {
        $this->handler = $handler;
    }

    /**
     * Gets a collection of Categories.
     *
     * @ApiDoc(
     *   output = "AppBundle\Entity\Category",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when not found"
     *   }
     * )
     *
     * @throws NotFoundHttpException when does not exist
     *
     * @return View
     */
    public function cgetAction()
    {
        $user = $this->handler->all();

        $view = $this->view($user);

        return $view;
    }
}