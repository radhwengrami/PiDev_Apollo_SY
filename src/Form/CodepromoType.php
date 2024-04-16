<?php

namespace App\Form;

use App\Entity\Codepromo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;



class CodepromoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', null, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Code should not be blank',
                    ]),
                ],
                'attr' => [ // Supprimer les attributs HTML par défaut
                    'placeholder' => '', // Supprimer le placeholder par défaut
                ],
            ])
            ->add('dateExpiration', null, [
                'widget' => 'single_text',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Expiration date should not be blank',
                    ]),
                    new Assert\GreaterThan([
                        'value' => 'today',
                        'message' => 'Expiration date should be in the future',
                    ]),
                ],
            ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Codepromo::class,
            'attr' => ['novalidate' => 'novalidate'], // Add this line to disable browser validation for every form

        ]);
    }
}
