<?php

namespace App\Form;

use App\Entity\Article;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', CKEditorType::class, [
                'label' => 'Intitulé',
                'help' => 'indiquez par exemple un poste de travail ou une formation suivie.',
                'config' => [
                    'height' => 50,
                ],
            ])
            ->add('content', CKEditorType::class, [
                'label' => 'Contenu',
                'help' => 'Mettez en forme les informations : vignette ou image, période, détails, ...'
            ])
            ->add('submit', SubmitType::class, ['label' => 'Valider'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}