<?php

namespace App\Form;

use App\Entity\OeuvreArt;
use App\Entity\Portfolio;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;



class OeuvreArt1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('image_oeuvre', FileType::class, [
                'label' => 'Image de l\'oeuvre',
                'mapped' => false, // Indique que ce champ n'est pas mappé à une propriété de l'entité
                'required' => false, // Le champ n'est pas obligatoire
            ])
            ->add('description')
            ->add('date_creation', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'attr' => ['class' => 'form-control'],
                'required' => false, // Le champ n'est pas obligatoire
            ])
            ->add('dimension')
            ->add('prix')
            ->add('categorie', ChoiceType::class, [
                'choices' => [
                    'PEINTURE' => 'PEINTURE',
                    'EDITION' => 'EDITION',
                    'PHOTOGRAPHIES' => 'PHOTOGRAPHIES',
                    'SCULPTURE' => 'SCULPTURE',
                    'DESSIN' => 'DESSIN',
                    'DESIGN' => 'DESIGN',
                ],
                'placeholder' => 'Choisir une catégorie', // Optionnel : ajoutez un placeholder
                'required' => true, // Indiquez si le champ est obligatoire
                // Ajoutez d'autres options de configuration si nécessaire
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OeuvreArt::class,
        ]);
    }
}
