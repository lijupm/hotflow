<?php

namespace Hotflo\ORBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpecialistAvailabilityType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            ->add('specialist', EntityType::class, [
                'class' => 'Hotflo\ORBundle\Entity\Specialist',
                'choice_label' => 'firstName',
                'data' => $options['specialist']
            ])
            ->add('submit', SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'specialist' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'hotflo_orbundle_specialist_availability';
    }
}
