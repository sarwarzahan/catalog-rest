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
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Patch;
use FOS\RestBundle\Controller\Annotations\Delete;


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
        $product = $this->handler->get($id);
        $view = $this->view($product);

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
     * @Post("/product/create")
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
        $this->denyAccessUnlessGranted('create', $this);
        
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
    
    /**
     * Update existing Product from the submitted data
     * 
     * @Patch("/product/update/{id}")
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\ProductType",
     *   output = "AppBundle\Entity\Product",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when errors",
     *     404 = "Returned when not found"
     *   }
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the product id
     *
     * @return FormTypeInterface|RouteRedirectView
     *
     * @throws NotFoundHttpException when does not exist
     */
    public function patchAction(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('update', $this);
        
        $requestedProduct = $this->handler->getRepository()->findOneById($id);
        try {
            $product = $this->handler->patch(
                $requestedProduct,
                $request->request->all()
            );
            $routeOptions = [
                'id'  => $product->getId(),
                '_format'    => $request->get('_format'),
            ];

            return $this->routeRedirectView('get_products', $routeOptions, Response::HTTP_NO_CONTENT);

        } catch (InvalidFormException $e) {
            return $e->getForm();
        } catch (\InvalidArgumentException $e) {
            return new View('Invalid product id: ' . $id, Response::HTTP_BAD_REQUEST);
        }
    }
    
    /**
     * Deletes a specific Product by ID
     * 
     * @Delete("/product/delete/{id}")
     *
     * @ApiDoc(
     *  description="Deletes an existing Product",
     *  statusCodes={
     *         204="Returned when an existing Product has been successfully deleted",
     *         403="Returned when trying to delete a non existent Product"
     *     }
     * )
     *
     * @param int         $id       the product id
     * @return View
     */
    public function deleteAction($id) 
    {
        $this->denyAccessUnlessGranted('delete', $this);
        
        $requestedProduct = $this->handler->getRepository()->findOneById($id);
        try {
            $this->handler->delete($requestedProduct);
            return new View(null, Response::HTTP_NO_CONTENT);
        } catch (\InvalidArgumentException $e) {
            return new View('Invalid product id: ' . $id, Response::HTTP_BAD_REQUEST);
        }
    }

}