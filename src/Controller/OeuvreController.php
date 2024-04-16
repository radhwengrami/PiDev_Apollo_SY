<?php
namespace App\Controller;
use App\Entity\OeuvreArt;
use App\Entity\User;
use App\Form\OeuvreArt1Type;
use App\Repository\OeuvreArtRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\PortfolioRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


/** 
 * @Route("/oeuvre")
 */
class OeuvreController extends AbstractController
{
    /**
     * @Route("/",name="liste_Oeuvre")
     */
    public function index(OeuvreArtRepository $oeuvreArtRepository): Response
    {
        return $this->render('oeuvre/index.html.twig', [
            'oeuvre_arts' => $oeuvreArtRepository->findAll(),
        ]);
    }
    /**
     * @Route("/img",name="liste_Oeuvre1")
     */
    public function index1(OeuvreArtRepository $oeuvreArtRepository): Response
    {
        return $this->render('front/oeuvre.html.twig', [
            'oeuvre_arts' => $oeuvreArtRepository->findAll(),
        ]);
    }


    /**
     * @Route("/ajouter/{userId}",name="ajouter_Oeuvre")
     */
    public function new(Request $request,int $userId ,Security $security, EntityManagerInterface $entityManager, PortfolioRepository $portfolioRepository): Response
    {

    // Obtenez l'utilisateur connecté
      $user = $security->getUser();
    // Vérifiez si l'utilisateur est connecté
    if ($user) {
        // Récupérez l'ID du portfolio de l'utilisateur connecté en utilisant le repository du portfolio
        $portfolioId = $portfolioRepository->findByUserId($userId);
        $oeuvreArt = new OeuvreArt();
        // Créez le formulaire pour l'entité OeuvreArt
        $form = $this->createForm(OeuvreArt1Type::class, $oeuvreArt);
        // Traitez la soumission du formulaire
        $form->handleRequest($request);
        // Vérifiez si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérez le fichier téléchargé
            $imageFile = $form->get('image_oeuvre')->getData();
            // Vérifiez si un fichier a été téléchargé
            if ($imageFile) {
                // Déplacez le fichier vers le répertoire où vous souhaitez stocker les images
                $newFilename = uniqid().'.'.$imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('images_directory'), 
                    $newFilename
                );
                // Mettez à jour l'entité avec le nom du fichier
                $oeuvreArt->setImageOeuvre($newFilename);
            }

            // Définissez l'ID du portfolio pour l'œuvre d'art
            $oeuvreArt->setPortfolios($portfolioId);

            // Persistez l'œuvre d'art
            $entityManager->persist($oeuvreArt);
            $entityManager->flush();

            return new Response('ajout');
        }

        // Affichez le formulaire de création d'œuvre d'art
        return $this->renderForm('oeuvre/ajouter_Oeuvre.html.twig', [
            'oeuvre_art' => $oeuvreArt,
            'form' => $form,
        ]);
    } else {
        // L'utilisateur n'est pas connecté, vous pouvez gérer cela comme vous le souhaitez
        return new Response('Vous devez être connecté pour accéder à cette fonctionnalité.');
    }
    }

    /** 
     * @Route("/{id}",name="detail_Oeuvre", methods={"GET"})
     */
    public function detail(OeuvreArt $oeuvreArt): Response
    {
        return $this->render('oeuvre/detail_Oeuvre.html.twig', [
            'oeuvre_art' => $oeuvreArt,
        ]);
    }
     /** 
     * @Route("/front/{id}",name="detail_OeuvreF", methods={"GET"})
     */
    public function detailfront(OeuvreArt $oeuvreArt): Response
    {
        return $this->render('front/detailOeuvrefront.html.twig', [
            'oeuvre_art' => $oeuvreArt,
        ]);
    }

  /**
 * @Route("/{id}/edit", name="modifier_Oeuvre")
 */
public function modifier(Request $request, OeuvreArt $oeuvreArt, EntityManagerInterface $entityManager): Response
{
    $form = $this->createForm(OeuvreArt1Type::class, $oeuvreArt);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Récupérez le fichier téléchargé
        $imageFile = $form->get('image_oeuvre')->getData();

        // Vérifiez si un nouveau fichier a été téléchargé
        if ($imageFile) {
            // Déplacez le fichier vers le répertoire où vous souhaitez stocker les images
            $newFilename = uniqid().'.'.$imageFile->guessExtension();
            $imageFile->move(
                $this->getParameter('images_directory'), 
                $newFilename
            );

            // Mettez à jour l'entité avec le nouveau nom de fichier
            $oeuvreArt->setImageOeuvre($newFilename);
        }

        // Enregistrez les modifications de l'œuvre d'art
        $entityManager->flush();

        return $this->redirectToRoute('liste_Oeuvre', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('oeuvre/modifier_Oeuvre.html.twig', [
        'oeuvre_art' => $oeuvreArt,
        'form' => $form,
    ]);
}

    /**
     * @Route("/{id}",name="supprimer_Oeuvre",methods={"POST"})
     */
    public function delete(Request $request, OeuvreArt $oeuvreArt, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$oeuvreArt->getId(), $request->request->get('_token'))) {
            $entityManager->remove($oeuvreArt);
            $entityManager->flush();
        }
        return $this->redirectToRoute('liste_Oeuvre', [], Response::HTTP_SEE_OTHER);
    }
    
   
}
