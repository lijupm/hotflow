<?php

namespace Hotflo\ORBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnesthetistType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('gender', ChoiceType::class, [
                'choices' =>['Male' => 'male', 'Female' => 'female']
            ])
            ->add('dob', DateType::class, [
                'widget' => 'single_text',
                'data' => new \DateTime()
            ])
            ->add('availabilityPerWeek');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Hotflo\ORBundle\Entity\Anesthetist'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'hotflo_orbundle_anesthetist';
    }


}
