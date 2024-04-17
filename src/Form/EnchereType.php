<?php

namespace App\Form;

use App\Entity\Enchere;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
class EnchereType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('type_oeuvre', TextType::class, [
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[a-zA-Z\s]*$/',
                        'message' => 'Le type d\'oeuvre ne doit contenir que des lettres de l\'alphabet.',
                    ]),
                ],
            ])
            ->add('min_montant', NumberType::class, [
                'html5' => true, // Utiliser le type HTML5 "number"
                'constraints' => [
                    new GreaterThan([
                        'value' => 0,
                        'message' => 'Le montant minimum doit être supérieur à zéro.',
                    ]),
                ],
            ])
            ->add('date_debut', DateType::class, [
                'widget' => 'single_text',
                // Définir la date minimale comme étant la date d'aujourd'hui
                'data' => new \DateTime(), // Définir la date actuelle comme valeur par défaut
                'constraints' => [
                    new GreaterThan([
                        'value' => new \DateTime(),
                        'message' => 'La date de début doit être a partir d\' aujourd\'hui.',
                    ]),
                ],
            ])
            ->add('date_fin', DateType::class, [
                'widget' => 'single_text',
                // Définir la date minimale comme étant la date d'aujourd'hui
                'data' => new \DateTime(), // Définir la date actuelle comme valeur par défaut
                'constraints' => [
                    new GreaterThan([
                        'value' => new \DateTime(),
                        'message' => 'La date de fin doit être superieur a la date de début.',
                    ]),
                    new LessThanOrEqual([
                        'value' => '+1 year',
                        'message' => 'La date de fin ne peut pas être plus d\'un an dans le futur.',
                    ]),
                ],
            ])
            ->add('imageFile', VichImageType::class, [ // Utilisation de VichImageType pour gérer les téléversements d'images
                'label' => 'Image', // Label du champ
                'required' => false, // Le champ n'est pas obligatoire
            ])

      ;
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Enchere::class,
        ]);
    }
}
