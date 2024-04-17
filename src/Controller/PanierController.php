<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\Oeuvre;
use App\Form\PanierType;
use App\Repository\OeuvreRepository;
use App\Repository\PanierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;

#[Route('/panier')]
class PanierController extends AbstractController
{
    #[Route('/', name: 'app_panier_index', methods: ['GET'])]
    public function index(PanierRepository $panierRepository): Response
    {
        return $this->render('panier/index.html.twig', [
            'paniers' => $panierRepository->findAll(),
        ]);
    }


    #[Route('/front', name: 'app_panier_index_front', methods: ['GET'])]
    public function index_front(PanierRepository $panierRepository): Response
    {
        return $this->render('panier/panier_front.html.twig', [
            'paniers' => $panierRepository->findBy(['idUser'=>1]),
        ]);
    }

    #[Route('/new', name: 'app_panier_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,PanierRepository $panierRepository,OeuvreRepository $oeuvreRepository): Response
    {
        $panier = new Panier();
        $test = false;
        $form = $this->createForm(PanierType::class, $panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($panierRepository->findBy(['idUser'=>$panier->getIdUser()])==NULL)
            {
                $panier->setAccecible("yes");
                $entityManager->persist($panier);
                $entityManager->flush();
            }
            else{
                foreach($panierRepository->findBy(['idUser'=>$panier->getIdUser()]) as $panier_test)
                {
                    if($panier_test->getAccecible()=="yes")
                    {
                        $test=true;
                    }
                }
                if( !$test ) 
                {
                    $panier->setAccecible("yes");
                    $entityManager->persist($panier);
                    $entityManager->flush();
                }
                else
                {
                    foreach ($panier->getOeuvres() as $oeuvre) 
                    {
                        $panierRepository->findOneBy(['accecible'=>"yes"])->addOeuvre($oeuvreRepository->findOneBy(["id"=>$oeuvre->getId()]));
                    }
                }
                
                
                $entityManager->flush();
            }
            
            return $this->redirectToRoute('app_panier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('panier/new.html.twig', [
            'panier' => $panier,
            'form' => $form,
        ]);
    }


    #[Route('/newFront/{id}', name: 'app_panier_new_front', methods: ['GET', 'POST'])]
    public function new_front(Request $request, EntityManagerInterface $entityManager ,OeuvreRepository $oeuvreRepository,$id,PanierRepository $panierRepository ): Response
    {
        $panier = new Panier();
        $panier->setIdUser(1);
        $id_user = 1;
        $test=false;
        if($panierRepository->findBy(['idUser'=>$id_user]) == null){
            
            
            $panier->setAccecible("yes");
            $panier->addOeuvre($oeuvreRepository->findOneBy(["id"=>$id]));   
                $entityManager->persist($panier);
                $entityManager->flush();    
        }
        else{
            foreach($panierRepository->findBy(['idUser'=>$panier->getIdUser()]) as $panier_test)
                {
                    
                    if($panier_test->getAccecible()=="yes")
                    {
                        
                        $test=true;
                    }
                }
                if( !$test ) 
                {
                    $panier->setIdUser(1);
                    $panier->setAccecible("yes");
                    $panier->addOeuvre($oeuvreRepository->findOneBy(["id"=>$id]));   
                    $entityManager->persist($panier);
                    $entityManager->flush(); 
                }
                else
                {
                    
                        $panierRepository->findOneBy(['idUser'=>$id_user,'accecible'=>"yes"])->addOeuvre($oeuvreRepository->findOneBy(["id"=>$id]));
                        $entityManager->flush();
                    
                }




            
        }

            return $this->redirectToRoute('app_oeuvre_index_front', [], Response::HTTP_SEE_OTHER);
        

        
    }

    #[Route('/{id}', name: 'app_panier_show', methods: ['GET'])]
    public function show(Panier $panier): Response
    {
        return $this->render('panier/show.html.twig', [
            'panier' => $panier,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_panier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Panier $panier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PanierType::class, $panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_panier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('panier/edit.html.twig', [
            'panier' => $panier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_panier_delete', methods: ['POST'])]
    public function delete(Request $request, Panier $panier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$panier->getId(), $request->request->get('_token'))) {
            $entityManager->remove($panier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_panier_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/front/{id}', name: 'app_panier_delete_front', methods: ['POST','GET'])]
    public function delete_front(EntityManagerInterface $entityManager,$id,PanierRepository $panierRepository,OeuvreRepository $oeuvreRepository): Response
    {
        $id_user = 1;
        $panier = new Panier();
        $panier = $panierRepository->findOneBy(['idUser'=>$id_user,'accecible'=>"yes"]);
        if (count($panier->getOeuvres()) ==1) {

            $entityManager->remove($panier);
            $entityManager->flush();
        }
        else {
            $panier->removeOeuvre($oeuvreRepository->findOneBy(['id'=>$id]));
            
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_panier_index_front', [], Response::HTTP_SEE_OTHER);
    }
}
