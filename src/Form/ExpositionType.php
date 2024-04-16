<?php

namespace App\Form;

use App\Entity\Exposition;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;



class ExpositionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('image_affiche', FileType::class, [
                'label' => 'Image de l\'affiche',
                'mapped' => false, // Indique que ce champ n'est pas mappé à une propriété de l'entité
                'required' => false, // Le champ n'est pas obligatoire
            ])
            ->add('titre')
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false, // Le champ n'est pas obligatoire
                'attr' => ['class' => 'form-control', 'rows' => 4], // rows contrôle la hauteur du textarea
            ])
            ->add('date_debut', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'attr' => ['class' => 'form-control'],
                'required' => false, // Le champ n'est pas obligatoire
            ])
            ->add('date_fin', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'attr' => ['class' => 'form-control'],
                'required' => false, // Le champ n'est pas obligatoire
            ])
            ->add('type_expo',ChoiceType::class, [
                'label' => 'Type d\'exposition',
                'choices' => [
                    'En ligne' => 'en ligne',
                    'Présentiel' => 'présentiel',
                ],
                'placeholder' => 'Choisir le type d\'exposition',
                'required' => true,
                'attr' => ['class' => 'form-control'], // Ajoutez des attributs HTML personnalisés si nécessaire
            ])
            ->add('localisation');
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Exposition::class,
        ]);
    }
}
