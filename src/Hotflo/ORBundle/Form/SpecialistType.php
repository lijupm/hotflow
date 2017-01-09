<?php

namespace Hotflo\ORBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpecialistType extends AbstractType
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
            ->add('availabilityPerWeek')
            ->add('specialism', EntityType::class, [
                'class' => 'Hotflo\ORBundle\Entity\Specialism',
                'choice_label' => 'name'
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Hotflo\ORBundle\Entity\Specialist'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'hotflo_orbundle_specialist';
    }
}
