<?php

// src/Security/ApiKeyAuthenticator.php
namespace App\Security;

use App\Entity\DbApiKeys;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class ApiKeyAuthenticator extends AbstractAuthenticator
{
    public function __construct(private EntityManagerInterface $em) {}

    public function supports(Request $request): ?bool
    {
        return $request->headers->has('X-UTL-API');
    }
/*
    public function authenticate(Request $request): SelfValidatingPassport
    {
        $apiKey = $request->headers->get('X-UTL-API');

        if (!$apiKey) {
            throw new AuthenticationException('Missing API Key');
        }

        $apiKeyEntity = $this->em->getRepository(DbApiKeys::class)->findOneBy(['name' => $apiKey, 'isEnabled' => true]);

        if (!$apiKeyEntity) {
            throw new AuthenticationException('Invalid API Key');
        }

        return new SelfValidatingPassport(
            new UserBadge('api_key_user')
        );
    }
*/
    public function authenticate(Request $request): SelfValidatingPassport
    {
        $apiKey = $request->headers->get('X-UTL-API');

        if (!$apiKey) {
            throw new AuthenticationException('Missing API Key');
        }

        $apiKeyEntity = $this->em->getRepository(DbApiKeys::class)->findOneBy(['name' => $apiKey, 'isEnabled' => true]);

        if (!$apiKeyEntity) {
            throw new AuthenticationException('Invalid API Key');
        }

        $user = $apiKeyEntity->getUser();

        if (!$user) {
            throw new AuthenticationException('No user linked to this API Key');
        }

        return new SelfValidatingPassport(
            new UserBadge($user->getUserIdentifier())
        );
    }
    public function onAuthenticationSuccess(Request $request, $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new Response('401 Unauthorized', Response::HTTP_UNAUTHORIZED);
    }
}
