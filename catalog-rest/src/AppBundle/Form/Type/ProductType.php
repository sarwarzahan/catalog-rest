<?php

namespace AppBundle\Form\Type;

use AppBundle\Repository\CategoryRepositoryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * ProductType constructor.
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $categoryChoice = $this->buildCategoryFieldOptions();
        $builder
            ->add('name', TextType::class)
            ->add('category', EntityType::class, [
                'class'     => 'AppBundle:Category',
                'choices' => $categoryChoice,
            ])
            /*->add('category', ChoiceType::class, [
                'choices' => $categoryChoice
            ])*/
            ->add('sku', TextType::class)
            ->add('price', TextType::class)
            ->add('quantity', TextType::class)
        ;
    }
    
    private function buildCategoryFieldOptions()
    {
        return $categoryChoiceAll = $this->categoryRepository->findAll();
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Product',
        ]);
    }

    public function getName()
    {
        return 'product';
    }
}