<?php

use FOS\RestBundle\View\View;


describe('CategoryController', function () {
    beforeAll(function () {
        $controller = $this->get('AppBundle\Controller\CategoryController');
        $this->controller = $controller;
    });
    // Unit test
    describe('cgetAction', function () {
        it('returns a FOS Rest View', function () {
            $result     = $this->controller->cgetAction();
            expect($result)->toBeAnInstanceOf(View::class);
        });
    });  
});