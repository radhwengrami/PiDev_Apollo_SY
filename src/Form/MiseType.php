<?php

namespace App\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
class MiseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('max_montant', TextType::class, [
                'label' => 'Montant',
                'required' => true,
                'invalid_message' => 'Veuillez saisir un montant', // Message d'erreur personnalisé
                'attr' => [
                    'placeholder' => 'Saisissez le montant',
                ],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Mise', // Assurez-vous que le chemin de la classe est correct
        ]);
    }
}
