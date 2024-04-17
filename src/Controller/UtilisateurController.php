<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UtilisateurRepository;

class UtilisateurController extends AbstractController
{
    #[Route('/utilisateur', name: 'liste_utilisateur')]
    public function listeUtilisateur(UtilisateurRepository $utilisateurRepository): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        // Récupérer tous les utilisateurs sauf l'utilisateur connecté
        $users = $utilisateurRepository->createQueryBuilder('u')
            ->andWhere('u != :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();

        return $this->render('utilisateur/liste_utilisateur.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/getUserName/{userId}', name: 'get_user_name', methods: ['GET'])]
    public function getUserName($userId, UtilisateurRepository $userRepository): JsonResponse
    {
        $user = $userRepository->find($userId);

        if (!$user) {
            return new JsonResponse(['error' => 'Utilisateur non trouvé'], Response::HTTP_NOT_FOUND);
        }

        // Renvoyer le nom de l'utilisateur au format JSON
        return new JsonResponse(['nom' => $user->getNom()]);
    }
}
