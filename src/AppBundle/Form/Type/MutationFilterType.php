<?php

namespace AppBundle\Form\Type;

use AppBundle\Model\MutationFilter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
                    'class' => 'datepicker',
                ],
                'widget' => 'single_text',
            ])
            ->add('endDate', DateType::class, [
                'attr' => [
                    'class' => 'datepicker',
                ],
                'widget' => 'single_text',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Filter',
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MutationFilter::class,
            'csrf_protection' => false,
        ]);
    }
}