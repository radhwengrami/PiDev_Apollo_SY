<?php

namespace App\Form;

use App\Entity\Conversation;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType; // Importez ChoiceType pour le champ de visibilité
class ConversationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Sujet')
            ->add('Titre')
            ->add('Description')

                ->add('Visibilite', ChoiceType::class, [
                    'label' => 'Visibilité',
                    'choices' => [
                        'PUBLIC' => 'PUBLIC',
                        'PRIVATE' => 'PRIVATE',
                    ],
                    'expanded' => true, // Affichage sous forme de boutons radio
                    'multiple' => false, // Sélection unique
                    'data' => 'public', // Valeur par défaut
                ])
                ->add('save', SubmitType::class, [
                    'label' => 'Enregistrer', // Libellé du bouton
                    'attr' => ['class' => 'btn btn-primary'], // Classes CSS supplémentaires
                ]);
               
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Conversation::class,
        ]);
    }
}
