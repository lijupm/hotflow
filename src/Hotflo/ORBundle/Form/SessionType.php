<?php

namespace Hotflo\ORBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SessionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('startTime', DateTimeType::class, [
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'data'        => new \DateTime()
            ])
            ->add('endTime', DateTimeType::class, [
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'data'        => new \DateTime()
            ])
            ->add('operatingRoom', EntityType::class, [
                'class'        => 'Hotflo\ORBundle\Entity\OperatingRoom',
                'choice_label' => 'name'
            ])
            ->add('patient', EntityType::class, [
                'class'        => 'Hotflo\ORBundle\Entity\Patient',
                'choice_label' => 'firstName'
            ])
            ->add('specialist', EntityType::class, [
                'class'        => 'Hotflo\ORBundle\Entity\Specialist',
                'choice_label' => 'firstName'
            ])
            ->add('anesthetists', EntityType::class, [
                'class'        => 'Hotflo\ORBundle\Entity\Anesthetist',
                'choice_label' => 'firstName',
                'multiple'     => true
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Hotflo\ORBundle\Entity\Session'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'hotflo_orbundle_session';
    }


}
