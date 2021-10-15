<?php

namespace App\Form;

use App\Entity\Identity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class IdentityFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('picture', FileType::class, ['label' => 'Illustration'])
            ->add('lastname', TextType::class, ['label' => 'Nom'])
            ->add('firstname', TextType::class, ['label' => 'Prénom'])
            ->add('address', TextType::class, ['label' => 'Adresse'])
            ->add('zipcode', TextType::class, ['label' => 'Code postal'])
            ->add('city', TextType::class, ['label' => 'Ville'])
            ->add('state', TextType::class, ['label' => 'Pays'])
            ->add('telephone', TelType::class, ['label' => 'téléphone'])
            ->add('email', EmailType::class)
            ->add('submit', SubmitType::class, ['label' => 'Valider'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Identity::class,
        ]);
    }
}