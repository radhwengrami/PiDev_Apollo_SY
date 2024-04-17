<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Mise;
use App\Form\MiseType;
use App\Entity\Enchere;
use App\Repository\MiseRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Twilio\Rest\Client;
class MiseController extends AbstractController

{
    #[Route('/mise', name: 'app_mise')]
    public function index(): Response
    {
        return $this->render('mise/index.html.twig', [
            'controller_name' => 'MiseController',
        ]);
    }

    /**
     * @Route("/mise/create", name="app_mise_create", methods={"GET","POST"})
     */
    /**
     * @Route("/mise/create", name="app_mise_create")
     */


   /* public function create(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createFormBuilder()
            ->add('max_montant', TextType::class)
            ->getForm();
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
    
            // Récupérer l'ID de l'enchère sélectionnée depuis la requête
            $enchereId = $request->query->get('enchere_id');
    
            // Charger l'objet Enchere correspondant depuis la base de données
            $enchere = $em->getRepository(Enchere::class)->find($enchereId);
    
            // Vérifier si l'enchère existe
            if (!$enchere) {
                throw $this->createNotFoundException('Enchère non trouvée');
            }  
    
            $mise = new Mise();
            $mise->setMaxMontant($data['max_montant']); // Set 'max_montant' from the form data
            $mise->setEnchers($enchere);

    
            // Mettre à jour le min_montant de l'enchère si nécessaire
            if ($enchere->getMinMontant() === null || $data['max_montant'] > $enchere->getMinMontant()) {
                $enchere->setMinMontant($data['max_montant']);
                $em->persist($enchere); // Enregistrez les modifications de l'enchère
            }
    
            $em->persist($mise);
            $em->flush();
    
            return $this->redirectToRoute('app_enchere_accueil');
        }
    
        return $this->render('mise/ajouter_mise.html.twig', [
            'monFormulaire' => $form->createView()
        ]);
    }*/

    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(MiseType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mise = $form->getData();

            // Récupérer l'ID de l'enchère sélectionnée depuis la requête
            $enchereId = $request->query->get('enchere_id');

            // Charger l'objet Enchere correspondant depuis la base de données
            $enchere = $em->getRepository(Enchere::class)->find($enchereId);

            // Vérifier si l'enchère existe
            if (!$enchere) {
                throw $this->createNotFoundException('Enchère non trouvée');
            }

            // Assigner l'enchère à la mise
            $mise->setEnchers($enchere);



            // Mettre à jour le min_montant de l'enchère si nécessaire
            $maxMontant = $mise->getMaxMontant();
            if ($enchere->getMinMontant() === null || $maxMontant > $enchere->getMinMontant()) {
                $enchere->setMinMontant($maxMontant);
                $em->persist($enchere); // Enregistrez les modifications de l'enchère
            }

            // Enregistrer la mise
            $em->persist($mise);
            $em->flush();

            return $this->redirectToRoute('app_enchere_accueil');
        }

        return $this->render('mise/ajouter_mise.html.twig', [
            'monFormulaire' => $form->createView()
        ]);
    }

    /**
 * @Route("/enchere/{enchere_id}/mises", name="app_mise_list")
 */
public function listMises(int $enchere_id): Response
{
    $enchere = $this->getDoctrine()->getRepository(Enchere::class)->find($enchere_id);

    if (!$enchere) {
        throw $this->createNotFoundException('Enchère non trouvée');
    }

    $mises = $enchere->getMises();

    return $this->render('mise/list_mises.html.twig', [
        'enchere' => $enchere,
        'mises' => $mises,
    ]);
}
}
