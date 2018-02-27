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

/**
 * Class ProductsController
 * @package AppBundle\Controller
 * @Annotations\RouteResource("products")
 */
class ProductsController extends FOSRestController implements ClassResourceInterface
{
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
     * @param int   $id     the user id
     *
     * @throws NotFoundHttpException when does not exist
     *
     * @return View
     */
    public function getAction($id)
    {
        $user = $this->getProductHandler()->get($id);

        $view = $this->view($user);

        return $view;
    }

    /**
     * Gets a collection of Products.
     *
     * @ApiDoc(
     *   output = "AppBundle\Entity\Product",
     *   statusCodes = {
     *     405 = "Method not allowed"
     *   }
     * )
     *
     * @throws MethodNotAllowedHttpException
     *
     * @return View
     */
    public function cgetAction()
    {
        throw new MethodNotAllowedHttpException([], "Method not allowed");
    }

    /**
     * Update existing User from the submitted data
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\UserType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when errors",
     *     401 = "Returned when provided password is incorrect",
     *     404 = "Returned when not found"
     *   }
     * )
     *
     * @param Request   $request    the request object
     * @param int       $id         the user id
     *
     * @return FormTypeInterface|RouteRedirectView
     *
     * @throws NotFoundHttpException when does not exist
     */
    public function patchAction(Request $request, $id)
    {
        $requestedUser = $this->get('repository.restricted_user_repository')->findOneById($id);

        try {

            $statusCode = Response::HTTP_NO_CONTENT;

            /** @var $user \AppBundle\Entity\User */
            $user = $this->getUserHandler()->patch(
                $requestedUser,
                $request->request->all()
            );

            $routeOptions = array(
                'id'        => $user->getId(),
                '_format'   => $request->get('_format')
            );

            return $this->routeRedirectView('get_users', $routeOptions, $statusCode);

        } catch (InvalidFormException $e) {

            return $e->getForm();
        }
    }

    /**
     * @return ProductHandler
     */
    private function getProductHandler()
    {
        return $this->container->get('handler.restricted_product_handler');
    }
}