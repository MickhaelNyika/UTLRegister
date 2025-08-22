<?php

namespace App\DataFixtures;

use AllowDynamicProperties;
use App\Entity\DbFaculties;
use App\Entity\DbMaritalStatus;
use App\Entity\DbResidences;
use App\Entity\DbSectors;
use App\Entity\DbSexes;
use App\Entity\DbUsers;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AllowDynamicProperties] class AppFixtures extends Fixture
{
    public function __construct(UserPasswordHasherInterface $passencoder)
    {
        $this->passencoder = $passencoder;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new DbUsers();
        $user->setEmail('mickhael@7futur.com')
            ->setPassword($this->passencoder->hashPassword($user, '123456'))
            ->setRoles(['ROLE_ROOT']);
        $manager->persist($user);

        $sexes = [
            'Féminin',
            'Masculin',
        ];

        $maritalStatus = [
            'Célibataire',
            'Marié(e)',
            'Divorcé(e)',
            'Veuf(ve)',
        ];

        $residences = [
            'Chez mes parents',
            'Chez moi',
            'Dans une maison d\'accueil',
        ];

        $repo = $manager->getRepository(DbSexes::class);
        foreach ($sexes as $itm) {
            $sex = new DbSexes();
            $sex->setName($itm);
            if($repo->findOneBy(['name' => $itm]) === null) {
                $manager->persist($sex);
            }
        }

        $repo = $manager->getRepository(DbMaritalStatus::class);
        foreach ($maritalStatus as $itm) {
            $status = new DbMaritalStatus();
            $status->setName($itm);
            if($repo->findOneBy(['name' => $itm]) === null) {
                $manager->persist($status);
            }
        }

        $repo = $manager->getRepository(DbMaritalStatus::class);
        foreach ($residences as $itm) {
            $residence = new DbResidences();
            $residence->setName($itm);
            if($repo->findOneBy(['name' => $itm]) === null) {
                $manager->persist($residence);
            }
        }

        $faculty = [
            'Architecture',
            'Science Juridique',
            'Sciences Agronomiques',
            'Sciences Appliquées',
            'Sciences Informatiques',
            'Sciences Economiques, Gestion et Management',
            'Arts et Métiers',
            'Sciences de Santé',
        ];

        $repo = $manager->getRepository(DbMaritalStatus::class);
        foreach ($faculty as $itm) {
            $faculty = new DbFaculties();
            $faculty->setName($itm);

            if($repo->findOneBy(['name' => $itm]) === null) {
                $manager->persist($faculty);
            }
        }
        $manager->flush();

        $sector = [
            ['name' => 'Architecture', 'faculty' => 'Architecture'],
            ['name' => 'Droit', 'faculty' => 'Science Juridique'],
            ['name' => 'Agroéconomie', 'faculty' => 'Sciences Agronomiques'],
            ['name' => 'Chimie Industrielle', 'faculty' => 'Sciences Appliquées'],
            ['name' => 'Electromécanique', 'faculty' => 'Sciences Appliquées'],
            ['name' => 'Génie Civil', 'faculty' => 'Sciences Appliquées'],
            ['name' => 'Génie Electrique', 'faculty' => 'Sciences Appliquées'],
            ['name' => 'Génie Logiciel', 'faculty' => 'Sciences Informatiques'],
            ['name' => 'Intelligence Artificielle', 'faculty' => 'Sciences Informatiques'],
            ['name' => 'Management', 'faculty' => 'Sciences Economiques, Gestion et Management'],
            ['name' => 'Métallurgie', 'faculty' => 'Sciences Appliquées'],
            ['name' => 'Modélisme', 'faculty' => 'Arts et Métiers'],
            ['name' => 'Pétrole et Gaz', 'faculty' => 'Sciences Appliquées'],
            ['name' => 'Production Animale', 'faculty' => 'Sciences Agronomiques'],
            ['name' => 'Production végétale', 'faculty' => 'Sciences Agronomiques'],
            ['name' => 'Sage-Femme', 'faculty' => 'Sciences de Santé'],
            ['name' => 'Sciences de Gestion', 'faculty' => 'Sciences Economiques, Gestion et Management'],
            ['name' => 'Sciences Economiques', 	'faculty'=> 	'Sciences Economiques, Gestion et Management'],
            ['name' => 	'Sciences Informatiques', 	'faculty'=> 'Sciences Informatiques'],
            ['name' => 	'Soins généraux', 	'faculty'=> 'Sciences de Santé'],
            ['name' => 	'Technique agricole', 	'faculty'=> 'Sciences Agronomiques'],
            ['name' => 	'Technique d\'esthétique', 'faculty'=> 	'Arts et Métiers'],
            ['name' => 	'Technique d\'habillement', 	'faculty'=> 'Arts et Métiers'],
            ['name' => 	'Technique agro-industrielle', 	'faculty'=> 'Sciences Agronomiques'],
            ['name' => 	'Géologie et Mines', 	'faculty'=> 'Sciences Appliquées'],
            ['name' => 	'Banque, Microfinance et Assurance', 	'faculty'=> 'Sciences Economiques, Gestion et Management']
        ];

        $repo = $manager->getRepository(DbFaculties::class);
        $repos = $manager->getRepository(DbSectors::class);

        foreach ($sector as $itm) {
            $sector = new DbSectors();
            $sector->setName($itm['name']);
            $faculty = $repo->findOneBy(['name' => $itm['faculty']]);
            $sector->setFaculty($faculty);
            if ($repos->findOneBy(['name' => $itm['name']]) === null) {
                $manager->persist($sector);
            }
        }
        $manager->flush();
    }
}
