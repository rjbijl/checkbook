<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Category;
use AppBundle\Model\Mutation\Filter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MutationFilterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate', DateType::class, [
                'attr' => [
                    'class' => 'datepicker form-input',
                ],
                'widget' => 'single_text',
                'required'   => false,
                'label_attr' => [
                    'class' => 'form-label',
                ],
            ])
            ->add('endDate', DateType::class, [
                'attr' => [
                    'class' => 'datepicker form-input',
                ],
                'widget' => 'single_text',
                'required'   => false,
                'label_attr' => [
                    'class' => 'form-label',
                ],
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'required'   => false,
                'attr' => [
                    'class' => 'form-input'
                ],
                'label_attr' => [
                    'class' => 'form-label',
                ],
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Filter::class,
            'csrf_protection' => false,
        ]);
    }
}