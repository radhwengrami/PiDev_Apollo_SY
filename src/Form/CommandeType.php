<?php

namespace App\Form;

use App\Entity\Commande;
use App\Entity\Panier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_commande')
            ->add('idUser')
            ->add('etat', ChoiceType::class, [
                'choices' => [
                    'En cours' => 'en_cours',
                    'Traitée' => 'traitee',
                    'Annulée par le client' => 'annulee_par_client',
                    'Annulée par l\'administrateur' => 'annulee_par_admin',
                ],
                'placeholder' => 'Choose an option',
            ])
            ->add('panier', EntityType::class, [
                'class' => Panier::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.id', 'ASC');
                },
                'choice_label' => 'id',
                'placeholder' => 'Choose an ID',
                
            ])
            ->add('oeuvres', EntityType::class, [
                'class' => 'App\Entity\Oeuvre',
                'choice_label' => 'titre', // Change 'name' to the property you want to display in the dropdown
                'multiple' => true, // Allow multiple selection
                'expanded' => false, // Render as a dropdown (set to true for checkboxes)
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
