<?php

namespace AppBundle\Controller;

use AppBundle\Exception\InvalidFormException;
use AppBundle\Handler\UserHandler;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\View\RouteRedirectView;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Handler\HandlerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class ProductController
 * @package AppBundle\Controller
 * @Annotations\RouteResource("product")
 */
class ProductController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @var HandlerInterface
     */
    private $handler;
    
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(HandlerInterface $handler, LoggerInterface $logger)
    {
        $this->handler = $handler;
        $this->logger = $logger;
    }
    
    /**
     * Get a single Product.
     * 
     * 
     * @ApiDoc(
     *   output = "AppBundle\Entity\Product",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when not found"
     *   }
     * )
     *
     * @param int   $id     the product id
     *
     * @throws NotFoundHttpException when does not exist
     *
     * @return View
     */
    public function getAction($id)
    {
        $user = $this->handler->get($id);
        $view = $this->view($user);

        return $view;
    }

    /**
     * Gets a collection of Products.
     *
     * @ApiDoc(
     *   output = "AppBundle\Entity\Product",
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

    /**
     * Creates a new Product
     *
     * @ApiDoc(
     *  input = "AppBundle\Form\Type\ProductType",
     *  output = "AppBundle\Entity\Product",
     *  statusCodes={
     *         201="Returned when a new Product has been successfully created",
     *         400="Returned when the posted data is invalid"
     *     }
     * )
     *
     * @param Request $request
     * 
     * @return View
     */
    public function postAction(Request $request)
    {
        $this->denyAccessUnlessGranted('view', 'post');
        
        try {
            $product = $this->handler->post($request->request->all());

            $routeOptions = [
                'id'  => $product->getId(),
                '_format'    => $request->get('_format'),
            ];

            return $this->routeRedirectView('get_products', $routeOptions, Response::HTTP_CREATED);

        } catch (InvalidFormException $e) {

            return $e->getForm();
        }
    }
}