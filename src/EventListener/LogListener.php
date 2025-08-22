<?php

namespace App\EventListener;

use App\Entity\DbUsers;
use App\Service\UserLogService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class LogListener implements EventSubscriberInterface
{
    private UserLogService $userLogService;

    public function __construct(UserLogService $userLogService)
    {
        $this->userLogService = $userLogService;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LogoutEvent::class => 'onLogout',
            InteractiveLoginEvent::class => 'onInteractiveLogin',
        ];
    }

    public function onInteractiveLogin(InteractiveLoginEvent $event): void
    {
        $user = $event->getAuthenticationToken()->getUser();

        if ($user) {
            if ($user instanceof DbUsers){
                $message = sprintf('(ID: %s) s\'est connecté.', $user->getEmail());
                $this->userLogService->info($message);
            }
        }
    }

    public function onLogout(LogoutEvent $event): void
    {
        $token = $event->getToken();

        if ($token) {
            $user = $token->getUser();
            if ($user) {
                if ($user instanceof DbUsers){
                    $message = sprintf('(ID: %s) s\'est déconnecté.', $user->getEmail());
                    $this->userLogService->info($message);
                }
            }
        }
    }
}