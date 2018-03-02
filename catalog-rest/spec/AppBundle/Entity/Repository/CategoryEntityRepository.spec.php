<?php

use AppBundle\Entity\Category;

describe('CategoryEntityRepository', function () {
    beforeAll(function () {
        $entityRepository = $this->get('doctrine_entity_repository.category');
        $this->entityRepository = $entityRepository;
    });
    // Unit test
    describe('findAll', function () {
        it('returns an array list', function () {
            $result     = $this->entityRepository->findAll();
            expect($result)->toBeA('array');
        });
    });
    describe('find', function () {
        it('returns a AppBundle\Entity\Category object', function () {
            $result     = $this->entityRepository->find(1);
            expect($result)->toBeAnInstanceOf(Category::class);
        });
    });
});