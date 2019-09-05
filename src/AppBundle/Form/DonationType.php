<?php

namespace AppBundle\Form;

use AppBundle\Entity\Category;
use AppBundle\Entity\Institution;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DonationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'required' => true,
                'expanded' => true,
                'multiple' => true,
                'attr' => [
                    'name' => 'categories',
                    'class' => 'checkbox',
                ],
            ])
            ->add('institution', EntityType::class, [
                'class' => Institution::class,
                'choice_label' => 'name',
                'required' => true,
                'expanded' => true,
                'attr' => [
                    'name' => 'organization'
                ]
            ])
            ->add('quantity', NumberType::class, [
                'required' => true,
                'attr' => [
                    'step' => 1,
                    'min' => 1,
                ],
                'label' => false,
            ])
            ->add('street', TextType::class, [
                'required' => true,
            ])
            ->add('city', TextType::class, [
                'required' => true,
            ])
            ->add('zipCode', TextType::class, [
                'required' => true,
            ])
            ->add('pickUpDate', DateType::class, [
                'widget' => 'single_text',
                'required' => true,
            ])
            ->add('pickUpTime', TimeType::class, [
                'widget' => 'single_text',
                'required' => true,
            ])
            ->add('pickUpComment', TextareaType::class, [
                'required' => true,
            ])
            ->add('phone', TextType::class, [
                'required' => true,
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Donation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return '';
    }


}
