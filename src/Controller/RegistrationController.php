<?php
namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\RegistrationFormType;
use App\Security\AppAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher,UserAuthenticatorInterface $userAuthenticator, AppAuthenticator $authenticator,EntityManagerInterface $entityManager): Response
    {
        $user = new Utilisateur();
        $f = $this->createForm(RegistrationFormType::class, $user);
        $f->handleRequest($request);

        if ($f->isSubmitted() && $f->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $f->get('plainPassword')->getData()
                )
            );
// Assigner le rôle sélectionné dans le formulaire
            // Assign the selected role from the form
            $role = $f->get('role')->getData(); // Get the role selected from the form
            $user->setRoles([$role]); // Pass the role as an array
            $entityManager->persist($user);
            $entityManager->flush();

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );

        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $f->createView(),
        ]);
    }
}
