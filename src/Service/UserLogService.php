<?php

// src/Service/UserLogService.php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\UserLogs;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class UserLogService implements LoggerInterface
{
    private EntityManagerInterface $em;
    private Security $security;

    public function __construct(EntityManagerInterface $em, Security $security)
    {
        $this->em = $em;
        $this->security = $security;
    }

    private function logToDatabase(string $level, string $message, array $context = []): void
    {
        $user = $this->security->getUser();
        $log = new UserLogs();
        $log->setUser($user);
        $log->setIp($_SERVER['REMOTE_ADDR']);
        $log->setMsg($message);
        $log->setLevel($level);
        $log->setCreatedAt(new \DateTimeImmutable());

        $this->em->persist($log);
        $this->em->flush();
    }

    public function emergency($message, array $context = []): void
    {
        $this->logToDatabase('emergency', $message, $context);
    }

    public function alert($message, array $context = []): void
    {
        $this->logToDatabase('alert', $message, $context);
    }

    public function critical($message, array $context = []): void
    {
        $this->logToDatabase('critical', $message, $context);
    }

    public function error($message, array $context = []): void
    {
        $this->logToDatabase('error', $message, $context);
    }

    public function warning($message, array $context = []): void
    {
        $this->logToDatabase('warning', $message, $context);
    }

    public function notice($message, array $context = []): void
    {
        $this->logToDatabase('notice', $message, $context);
    }

    public function info($message, array $context = []): void
    {
        $this->logToDatabase('info', $message, $context);
    }

    public function debug($message, array $context = []): void
    {
        $this->logToDatabase('debug', $message, $context);
    }

    public function log($level, $message, array $context = []): void
    {
        $this->logToDatabase($level, $message, $context);
    }
}


