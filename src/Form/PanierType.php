<?php

namespace App\Form;

use App\Entity\Panier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PanierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idUser')
            ->add('oeuvres', EntityType::class, [
                'class' => 'App\Entity\Oeuvre',
                'choice_label' => 'titre', // Change 'name' to the property you want to display in the dropdown
                'multiple' => true, // Allow multiple selection
                'expanded' => false, // Render as a dropdown (set to true for checkboxes)
            ])
            ->add('accecible')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Panier::class,
        ]);
    }
}
