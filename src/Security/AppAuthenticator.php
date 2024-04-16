<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;


class AppAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email', '');

        $request->getSession()->set(Security::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
{
    if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
        return new RedirectResponse($targetPath);
    }
    
    $user = $token->getUser();
    
    if (in_array('ROLE_ADMIN', $user->getRoles())) {
        return new RedirectResponse($this->urlGenerator->generate('app_utilisateur_index'));
    } elseif (in_array('ROLE_ARTISTE', $user->getRoles())) {
        return new RedirectResponse($this->urlGenerator->generate('mes_oeuvres_utilisateur'));

    } elseif (in_array('ROLE_CLIENT', $user->getRoles())) {
        return new RedirectResponse($this->urlGenerator->generate('liste_Oeuvre1'));
    }
    
    return new RedirectResponse($this->urlGenerator->generate('liste_Oeuvre1'));
}

    //     if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
    //         return new RedirectResponse($targetPath);
    //     }
    //     $user = $token->getUser();
    //     if (in_array('ROLE_ADMIN', $user->getRoles(), true)){

    //     // For example:
    //     // return new RedirectResponse($this->urlGenerator->generate('some_route'));
    //     return new RedirectResponse($this->urlGenerator->generate('app_utilisateur_index'));

    // }
    //     return new RedirectResponse($this->urlGenerator->generate('display_client'));

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
