<?php

namespace App\Controller;

use App\Entity\Exposition;
use App\Form\ExpositionType;
use App\Repository\ExpositionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PortfolioRepository;

/**
 * @Route("/exposition")
 */
class ExpositionController extends AbstractController
{
    /**
     * @Route("/", name="liste_Exposition")
     */
    public function index(ExpositionRepository $expositionRepository): Response
    {
        return $this->render('exposition/index.html.twig', [
            'expositions' => $expositionRepository->findAll(),
        ]);
    }

   /**
    * @Route("/ajouter/{userId}", name="ajouter_Exposition")
    */
    public function ajouter(Request $request,int $userId,Security $security,EntityManagerInterface $entityManager, PortfolioRepository $portfolioRepository): Response
    {
        $user = $security->getUser();
        if ($user) {
        $portfolioId = $portfolioRepository->findByUserId($userId);
        $exposition = new Exposition();
        $exposition->setPortfolios($portfolioId);
        $form = $this->createForm(ExpositionType::class, $exposition);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $imageAffiche = $form->get('image_affiche')->getData();
             // Vérifier si un fichier a été téléchargé
            if ($imageAffiche) {
            // Déplacer le fichier vers le répertoire où vous souhaitez stocker les images
            $newFilename = uniqid().'.'.$imageAffiche->guessExtension();
            $imageAffiche->move(
                $this->getParameter('images_directory_expo'), // Répertoire de destination configuré dans config/services.yaml
                $newFilename
            );
            $exposition->setImageAffiche($newFilename);
        }
           
            // Persistez ensuite l'entité et redirigez comme d'habitude
            $entityManager->persist($exposition);
            $entityManager->flush();
            

            return new Response('ajout');
        }

        return $this->renderForm('exposition/ajouter_expo.html.twig', [
            'exposition' => $exposition,
            'form' => $form,
        ]);
    }else {
        // L'utilisateur n'est pas connecté, vous pouvez gérer cela comme vous le souhaitez
        return new Response('Vous devez être connecté pour accéder à cette fonctionnalité.');
    }}
/**
 * @Route("/{id}", name="detail_Exposition", methods={"GET"})
 */
 
    public function detail(Exposition $exposition): Response
    {
        return $this->render('exposition/detail_expo.html.twig', [
            'exposition' => $exposition,
        ]);
    }
    
/**
 * @Route("/{id}/edit", name="modifier_Exposition")
 */
    public function modifier(Request $request, Exposition $exposition, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ExpositionType::class, $exposition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('liste_Oeuvre', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('exposition/modifier_expo.html.twig', [
            'exposition' => $exposition,
            'form' => $form,
        ]);
    }
/**
 * @Route("/{id}", name="supprimer_Exposition" ,methods={"POST"})
 */
    public function delete(Request $request, Exposition $exposition, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$exposition->getId(), $request->request->get('_token'))) {
            $entityManager->remove($exposition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('liste_Oeuvre', [], Response::HTTP_SEE_OTHER);
    }
}
