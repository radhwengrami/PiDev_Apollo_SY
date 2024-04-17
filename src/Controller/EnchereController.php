<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EnchereRepository;
use App\Entity\Enchere;
use App\Form\EnchereType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException; // Import FileException class
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints as Assert;
class EnchereController extends AbstractController
{
    /**
     * @Route("/", name="app_enchere",methods="GET")
     */
    public function index(EnchereRepository $EnchereRepository):Response
    {
        // dump($EnchereRepository->findAll());
        // Your controller logic goes here
        $enchere = $EnchereRepository->findAll();

        return $this->render('enchere/index.html.twig', compact('enchere'));
    }


    
      /**
     * @Route("accueil", name="app_enchere_accueil",methods="GET")
     */
    public function accueil(EnchereRepository $EnchereRepository):Response
    {
        // dump($EnchereRepository->findAll());
        // Your controller logic goes here
        $enchere = $EnchereRepository->findAll();

        return $this->render('enchere/accueil.html.twig', compact('enchere'));
    }
  /**
     * @Route("/home", name="app_encheres",methods="GET")
     */
    public function view(EnchereRepository $EnchereRepository):Response
    {
        // dump($EnchereRepository->findAll());
        // Your controller logic goes here
        $enchere = $EnchereRepository->findAll();

        return $this->render('enchere/enchere.html.twig', compact('enchere'));
    }

/**
     * @Route("/back", name="app_back",methods="GET")
     */
    public function back(EnchereRepository $EnchereRepository):Response
    {
        // dump($EnchereRepository->findAll());
        // Your controller logic goes here
        $enchere = $EnchereRepository->findAll();

        return $this->render('enchere/back.html.twig', compact('enchere'));
    }

    /**
     * @Route("/backk", name="app_backk",methods="GET")
     */
    public function backk(EnchereRepository $EnchereRepository):Response
    {
        // dump($EnchereRepository->findAll());
        // Your controller logic goes here
        $enchere = $EnchereRepository->findAll();

        return $this->render('enchere/template.html.twig', compact('enchere'));
    }
    /**
     * @Route("/encheres/{id<[0-9]+>}", name="app_encheres_show",methods="GET")
     */
    public function show(int $id, EnchereRepository $enchereRepository): Response
    {
        $enchere = $enchereRepository->find($id);
        // dd($enchere);
        return $this->render('enchere/show.html.twig', compact('enchere'));

    }

       /* /**
         * @Route("/encheres/create", name="app_encheres_create", methods={"GET","POST"})
         */
      /* public function create(Request $request, EntityManagerInterface $em): Response
       {
           $form = $this->createFormBuilder()
               ->add('type_oeuvre', TextType::class)
               ->add('min_montant', TextType::class)
               ->add('date_debut', DateType::class)
               ->add('date_fin', DateType::class)
               ->add('imageFile', FileType::class)
               ->getForm();

           $form->handleRequest($request);

           if ($form->isSubmitted() && $form->isValid()) {
               $data = $form->getData();

               // Instantiate a new Enchere object
               $enchere = new Enchere();
               $enchere->setTypeOeuvre($data['type_oeuvre']); // Set 'type_oeuvre' from the form data
               $enchere->setMinMontant($data['min_montant']); // Set 'min_montant' from the form data
               $enchere->setDateDebut($data['date_debut']);
               $enchere->setDateFin($data['date_fin']);
               $enchere->setIdUtilisateur(2);
               // Handle file upload for the image field
               $imageFile = $form->get('imageFile')->getData();
               if ($imageFile) {
                   $newFilename = uniqid().'.'.$imageFile->guessExtension();
                   try {
                       $imageFile->move(
                          // $this->getParameter('images_directory'),
                           $newFilename
                       );
                       $enchere->setImage($newFilename); // Set 'image' from the uploaded file
                   } catch (FileException $e) {
                       // Handle file upload error
                   }
               }

               // Persist the Enchere entity
               $em->persist($enchere);
               $em->flush();

               return $this->redirectToRoute('app_enchere');
           }

           return $this->render('enchere/create.html.twig', [
               'monFormulaire' => $form->createView()
           ]);
       }*/

    /**
     * @Route("/encheres/create", name="app_encheres_create", methods={"GET","POST"})
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createFormBuilder()
            ->add('type_oeuvre', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Ce champ ne peut pas être vide.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-Z\s]*$/',
                        'message' => 'Le type d\'oeuvre ne doit contenir que des lettres de l\'alphabet.',
                    ]),
                ],
            ])
            ->add('min_montant', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Ce champ ne peut pas être vide.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^\d+(\.\d+)?$/',
                        'message' => 'Le montant minimum doit être un entier ou un nombre à virgule flottante.',
                    ]),
                ],
            ])
            ->add('date_debut', DateType::class, [
                'widget' => 'single_text',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Ce champ ne peut pas être vide.',
                    ]),
                    new Assert\GreaterThanOrEqual([
                        'value' => 'today',
                        'message' => 'La date de début doit être aujourd\'hui ou plus tard.',
                    ]),
                ],
            ])
            ->add('date_fin', DateType::class, [
                'widget' => 'single_text',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Ce champ ne peut pas être vide.',
                    ]),
                    new Assert\GreaterThan([
                        'propertyPath' => '[date_debut]',
                        'message' => 'La date de fin doit être supérieure à la date de début.',
                    ]),
                ],
            ])
            ->add('imageFile', FileType::class, [
                'constraints' => [
                    new Assert\NotBlank([
                            'message' => 'Ce champ ne peut pas être vide.',
                        ])

                ],
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // Instantiate a new Enchere object
            $enchere = new Enchere();
            $enchere->setTypeOeuvre($data['type_oeuvre']); // Set 'type_oeuvre' from the form data
            $enchere->setMinMontant($data['min_montant']); // Set 'min_montant' from the form data
            $enchere->setDateDebut($data['date_debut']);
            $enchere->setDateFin($data['date_fin']);
            $enchere->setIdUtilisateur(2);

            // Handle file upload for the image field
            $imageFile = $form->get('imageFile')->getData();
            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();
                $uploadDirectory = $this->getParameter('kernel.project_dir') . '/public/uploads/enchere'; // Répertoire de téléversement des images
                try {
                    $imageFile->move(
                        $uploadDirectory,
                        $newFilename
                    );
                    $enchere->setImage($newFilename); // Définir le nom du fichier dans l'entité Enchere
                } catch (FileException $e) {
                    // Gérer l'erreur de téléversement du fichier
                }
            }

            // Persist the Enchere entity
            $em->persist($enchere);
            $em->flush();

            return $this->redirectToRoute('app_encheres');
        }

        return $this->render('enchere/create.html.twig', [
            'monFormulaire' => $form->createView()
        ]);
    }

   /* public function create(Request $request, EntityManagerInterface $em): Response
    {
        // Créer un formulaire en utilisant EnchereType
        $form = $this->createForm(EnchereType::class);

        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les données soumises dans le formulaire
            $enchere = $form->getData();
            $enchere->setIdUtilisateur(2); // Si cela doit être défini à 2 à chaque fois

            // Gérer le téléversement du fichier pour le champ image
            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {

                $newFilename = uniqid().'.'.$imageFile->guessExtension();
                $uploadDirectory = $this->getParameter('kernel.project_dir') . '/public/uploads/enchere';
                try {
                    $imageFile->move($uploadDirectory, $newFilename);
                    $enchere->setImage($newFilename);
                } catch (FileException $e) {
                    // Gérer l'erreur de téléversement du fichier
                    // Gérer l'erreur de téléversement du fichier
                    $this->addFlash('error', 'Une erreur est survenue lors du téléversement de l\'image.');
                }
            }

            // Persister l'entité Enchere
            $em->persist($enchere);
            $em->flush();

            // Rediriger vers la page d'accueil des enchères après l'ajout réussi
            return $this->redirectToRoute('app_encheres');
        }

        // Afficher le formulaire s'il n'est pas encore soumis ou s'il contient des erreurs
        return $this->render('enchere/create.html.twig', [
            'monFormulaire' => $form->createView()
        ]);
    }*/

    /**
     * @Route("/encheres/{id}/edit", name="app_encheres_edit", methods={"GET","POST"})
     */
  /* public function edit(Request $request, EntityManagerInterface $em, EnchereRepository $enchereRepository, $id): Response
    {
        // Récupérer l'enchère à éditer à partir de son identifiant
        $enchere = $enchereRepository->find($id);

        if (!$enchere) {
            throw $this->createNotFoundException('Enchère non trouvée');
        }

        $form = $this->createFormBuilder()
            ->add('type_oeuvre', TextType::class, ['data' => $enchere->getTypeOeuvre()])
            ->add('min_montant', TextType::class, ['data' => $enchere->getMinMontant()])
            ->add('date_debut', DateType::class, ['data' => $enchere->getDateDebut()])
            ->add('date_fin', DateType::class, ['data' => $enchere->getDateFin()])
            ->add('image', FileType::class, ['required' => false]) // Permet de ne pas rendre le champ d'image obligatoire pour l'édition
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // Mettre à jour les propriétés de l'enchère avec les données du formulaire
            $enchere->setTypeOeuvre($data['type_oeuvre']);
            $enchere->setMinMontant($data['min_montant']);
            $enchere->setDateDebut($data['date_debut']);
            $enchere->setDateFin($data['date_fin']);

            // Gérer la mise à jour de l'image si un nouveau fichier est soumis
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                    // $this->getParameter('images_directory'),
                        $newFilename
                    );
                    $enchere->setImage($newFilename);
                } catch (FileException $e) {
                    // Gérer les erreurs de téléchargement du fichier
                }
            }

            // Persister les changements dans la base de données
            $em->flush();

            return $this->redirectToRoute('app_enchere');
        }

        return $this->render('enchere/edit.html.twig', [
            'monFormulaire' => $form->createView(),
            'enchere' => $enchere, // Passer l'enchère à la vue pour afficher les détails si nécessaire
        ]);
    }*/
    public function edit(Request $request, EntityManagerInterface $em, EnchereRepository $enchereRepository, $id): Response
    {
        // Récupérer l'enchère à éditer à partir de son identifiant
        $enchere = $enchereRepository->find($id);

        if (!$enchere) {
            throw $this->createNotFoundException('Enchère non trouvée');
        }

        $form = $this->createFormBuilder()
            // Ajoutez vos champs de formulaire ici avec les données de l'enchère
            ->add('type_oeuvre', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Ce champ ne peut pas être vide.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-Z\s]*$/',
                        'message' => 'Le type d\'oeuvre ne doit contenir que des lettres de l\'alphabet.',
                    ]),
                ],
                'data' => $enchere->getTypeOeuvre()
            ])
            ->add('min_montant', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Ce champ ne peut pas être vide.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^\d+(\.\d+)?$/',
                        'message' => 'Le montant minimum doit être un entier ou un nombre à virgule flottante.',
                    ]),
                ],
                'data' => $enchere->getMinMontant()
            ])
            ->add('date_debut', DateType::class, [
                'widget' => 'single_text',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Ce champ ne peut pas être vide.',
                    ]),
                    new Assert\GreaterThanOrEqual([
                        'value' => 'today',
                        'message' => 'La date de début doit être aujourd\'hui ou plus tard.',
                    ]),
                ],
                'data' => $enchere->getDateDebut()
            ])
            ->add('date_fin', DateType::class, [
                'widget' => 'single_text',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Ce champ ne peut pas être vide.',
                    ]),
                    new Assert\GreaterThan([
                        'propertyPath' => '[date_debut]',
                        'message' => 'La date de fin doit être supérieure à la date de début.',
                    ]),
                ],
                'data' => $enchere->getDateFin()
            ])
            ->add('image', FileType::class, ['required' => false]) // Permet de ne pas rendre le champ d'image obligatoire pour l'édition
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // Mettre à jour les propriétés de l'enchère avec les données du formulaire
            $enchere->setTypeOeuvre($data['type_oeuvre']);
            $enchere->setMinMontant($data['min_montant']);
            $enchere->setDateDebut($data['date_debut']);
            $enchere->setDateFin($data['date_fin']);

            // Gérer la mise à jour de l'image si un nouveau fichier est soumis
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                // Supprimer l'ancienne image si elle existe
                $oldImage = $enchere->getImage();
                if ($oldImage) {
                    $oldImagePath = $this->getParameter('kernel.project_dir') . '/public/uploads/enchere/' . $oldImage;
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                // Téléverser la nouvelle image
                $newFilename = uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads/enchere',
                        $newFilename
                    );
                    $enchere->setImage($newFilename);
                } catch (FileException $e) {
                    // Gérer les erreurs de téléversement du fichier
                }
            }

            // Persister les changements dans la base de données
            $em->flush();

            return $this->redirectToRoute('app_encheres');
        }

        return $this->render('enchere/edit.html.twig', [
            'monFormulaire' => $form->createView(),
            'enchere' => $enchere, // Passer l'enchère à la vue pour afficher les détails si nécessaire
        ]);
    }





    /**
     * @Route("/encheres/{id}", name="app_encheres_delete", methods={ "POST"})
     */
   public function delete(Request $request, EntityManagerInterface $em, EnchereRepository $enchereRepository, $id): Response
    {
        $enchere = $enchereRepository->find($id);

        if (!$enchere) {
            throw $this->createNotFoundException('Enchère non trouvée');
        }

        // Vérifier si le jeton CSRF est valide
        if ($this->isCsrfTokenValid('delete' . $enchere->getId(), $request->request->get('_token'))) {
            // Supprimer l'enchère de la base de données
            $em->remove($enchere);
            $em->flush();
        }

        // Rediriger vers la page d'index des enchères après la suppression
        return $this->redirectToRoute('app_encheres');
    }

 

}