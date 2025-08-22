<?php

/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 08/05/2022
 * Time: 22:39
 */


namespace App\EventSubscriber;


use App\Entity\DbConditions;
use App\Entity\DbUsers;
use App\Entity\DbCandidates;
use App\Entity\UserLogs;
//use App\Repository\DbUserNewsLettersRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityDeletedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Service\UserLogService;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private $user;
    private $userNewsLetter;
    private $messageBus;
    private EntityManagerInterface $manager;
    private UserLogService $userLogService;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher,
                                Security $security,
                                //DbUserNewsLettersRepository $dbUserNewsLettersRepository,
                                MessageBusInterface $messageBus,
                                EntityManagerInterface $entityManager,
                                UserLogService $userLogService
    )
    {
        $this->hasher = $userPasswordHasher;
        $this->user = $security->getUser();
        //$this->userNewsLetter = $dbUserNewsLettersRepository->findBy(['isVerified' => true]);
        $this->messageBus = $messageBus;
        $this->manager = $entityManager;
        $this->userLogService = $userLogService;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => ['createEntity'],
            BeforeEntityUpdatedEvent::class => ['updateEntity'],
            AfterEntityDeletedEvent::class => ['deletedEntity']
        ];
    }

    public function createEntity(BeforeEntityPersistedEvent $event): void
    {
        $entity = $event->getEntityInstance();
        $newDate = new \DateTimeImmutable();
        $users = new DbUsers();
        if (($entity instanceof DbUsers)) {
            $this->logAction($event, 'create');
            $entity->setPassword($this->hasher->hashPassword($users, $entity->getPassword()));
        }

        if (($entity instanceof DbConditions)) {
            $this->logAction($event, 'create');
            $entity
                ->setCreatedAt(new \DateTimeImmutable('now'), 'Europe/Paris')
                ->setAuthor($this->user);
        }

    }

    public function updateEntity(BeforeEntityUpdatedEvent $event): void
    {
        $this->logAction($event, 'update');
        $entity = $event->getEntityInstance();
        $newDate = new \DateTime('now');
        $users = new DbUsers();
    }

    public function deletedEntity(AfterEntityDeletedEvent $event): void
    {
        $entity = $event->getEntityInstance();
        if($entity instanceof DbCandidates){
            $this->logAction($event, 'delete');
            $sql = 'SET @num := 0; UPDATE st_pre_registrations SET id = @num := (@num + 1); ALTER TABLE st_pre_registrations AUTO_INCREMENT = 1;';
            $con = $this->manager->getConnection();
            $con->executeQuery($sql);
        }
    }

    private function logAction($event, string $actionType): void
    {
        $entity = $event->getEntityInstance();
        $user = $this->user;
        $code = $entity->getId();

        if ($entity instanceof DbCandidates) {
            $code = $entity->getCode();
        }

        if ($user && !$entity instanceof UserLogs) {
            $message = sprintf(
                'L\'utilisateur %s a effectué une action "%s" sur l\'entité %s (ID: %d)',
                $user->getId(),
                $actionType,
                $entity,
                method_exists($entity, 'getId') ? $code : 'N/A'
            );
            $this->userLogService->info($message);
        }
    }
}