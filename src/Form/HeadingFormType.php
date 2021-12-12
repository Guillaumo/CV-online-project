<?php

namespace App\Form;

use App\Entity\Heading;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class HeadingFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', CKEditorType::class, [
                'label' => 'Nom de la rubrique',
                'help' => 'Indiquer par exemple : Expériences professionnelles',
                'config' => [
                    'height' => 50,
                ],
            ])
            ->add('submit', SubmitType::class, ['label' => 'Valider'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Heading::class,
        ]);
    }
}