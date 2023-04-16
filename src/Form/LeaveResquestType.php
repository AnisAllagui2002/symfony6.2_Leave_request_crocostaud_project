<?php

namespace App\Form;

use App\Entity\LeaveResquest;
use App\Entity\TypesConges;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LeaveResquestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('StartDate', DateType::class, [
                // renders it as a single text box
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',

            ])
            ->add('EndDate', DateType::class, [
                // renders it as a single text box
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('Reason')
            ->add('type', EntityType::class, [
                'class' => TypesConges::class,
                'choice_label' => 'label',
                'by_reference' => true

                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ])
//            ->add('FirstName')
//            ->add('LastName')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LeaveResquest::class,
        ]);
    }
}
