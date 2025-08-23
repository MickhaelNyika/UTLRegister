<?php

namespace App\Controller\Admin;

use App\Entity\DbFaculties;
use App\Entity\DbMaritalStatus;
use App\Entity\DbSectors;
use App\Entity\DbSexes;
use App\Entity\DbCandidates;
use App\Entity\DbResidences;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DbCandidatesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DbCandidates::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('Etape 1'),
            IdField::new('id')->onlyOnIndex(),
            BooleanField::new('isVerified', 'Vérifier'),
            IntegerField::new('Code', 'Code')->setColumns(3),
            TextField::new('name', 'Nom')->setColumns(3),
            TextField::new('fistName', 'Post-nom')->setColumns(3),
            TextField::new('lastName', 'Prénom')->setColumns(3),
            AssociationField::new('facOne', 'FACULTE 1')->hideOnIndex()->hideOnDetail()->hideWhenCreating()->setFormTypeOptions([
                'class' => DbFaculties::class,
                'choice_label' => 'name'
            ])->setRequired(true)->setColumns(6),
            AssociationField::new('fistChoice', 'Filière 1')->hideOnIndex()->hideOnDetail()->hideWhenCreating()->setFormTypeOptions([
                'class' => DbSectors::class,
                'choice_label' => 'name'
            ])->setRequired(true)->setColumns(6),
            AssociationField::new('factTwo', 'FACULTE 2')->hideOnIndex()->hideOnDetail()->hideWhenCreating()->setFormTypeOptions([
                'class' => DbFaculties::class,
                'choice_label' => 'name'
            ])->setRequired(true)->setColumns(6),
            AssociationField::new('secondChoice', 'Filière 1')->hideOnIndex()->hideOnDetail()->hideWhenCreating()->setFormTypeOptions([
                'class' => DbSectors::class,
                'choice_label' => 'name'
            ])->setRequired(true)->setColumns(6),
            TextField::new('facOne.name', 'FACULTE 1')->hideOnForm(),
            TextField::new('fistChoice.name', 'FILIERE 1')->hideOnForm(),
            TextField::new('factTwo.name', 'FACULTE 2')->hideOnForm(),
            TextField::new('secondChoice.name', 'FILIERE 2')->hideOnForm(),
            TextField::new('placeBirth', 'Lieu de naissance')->hideOnIndex()->setColumns(3),
            DateField::new('dateBirth', 'Date de naissance')->hideOnIndex()->setColumns(3),
            AssociationField::new('sexe', 'Sexe')->hideOnIndex()->hideOnDetail()->hideWhenCreating()->setFormTypeOptions([
                'class' => DbSexes::class,
                'choice_label' => 'name'
            ])->setRequired(true)->setColumns(3),
            TextField::new('sexe.name', 'Sexe')->onlyOnDetail(),
            TextField::new('nationality', 'Nationalité')->hideOnIndex()->setColumns(3),
            AssociationField::new('maritalStatus', 'Etat civil')->hideOnIndex()->hideOnDetail()->hideWhenCreating()->setFormTypeOptions([
                'class' => DbMaritalStatus::class,
                'choice_label' => 'name'
            ])->setRequired(true)->setColumns(3),
            TextField::new('maritalStatus.name', 'Etat civil')->onlyOnDetail()->setColumns(3),
            EmailField::new('email', 'E-mail')->hideOnIndex()->setColumns(3),
            TextField::new('phone', 'Téléphone')->hideOnIndex()->setColumns(3),
            AssociationField::new('residence', 'Résidence')->hideOnIndex()->hideOnDetail()->hideWhenCreating()->setFormTypeOptions([
                'class' => DbResidences::class,
                'choice_label' => 'name'
            ])->setRequired(true)->setColumns(3),
            TextField::new('residence.name', 'Résidence')->onlyOnDetail()->setColumns(3),
            NumberField::new('addNumber', 'Numéro')->hideOnIndex()->setColumns(1),
            TextField::new('addAvenue', 'Avenue')->hideOnIndex()->setColumns(2),
            TextField::new('addQuarter', 'Quartier')->hideOnIndex()->setColumns(3),
            TextField::new('addMunicipality', 'Commune')->hideOnIndex()->setColumns(3),
            TextField::new('addCity', 'Ville')->hideOnIndex()->setColumns(3),

            FormField::addTab('Etape 2'),

            FormField::addFieldset('Etudes faites'),
            TextField::new('scName', 'Nom de l\'établissment')->hideOnIndex()->setColumns(4),
            TextField::new('scSection', 'Section')->hideOnIndex()->setColumns(3),
            TextField::new('scOption', 'Option')->hideOnIndex()->setColumns(3),
            NumberField::new('scPercentage', '%')->hideOnIndex()->setColumns(1),
            NumberField::new('scYear', 'Année')->hideOnIndex()->setColumns(1),
            TextField::new('scDiplomaType', 'Type de diplôme')->hideOnIndex()->setColumns(3),
            TextField::new('scDiplomaNumber', 'Numéro de diplôme')->hideOnIndex()->setColumns(3),
            TextField::new('scDiplomaPlace', 'Diplôme délivré à')->hideOnIndex()->setColumns(3),
            DateField::new('scDiplomaDate', 'Date de délivrance')->hideOnIndex()->setColumns(3),
            TextField::new('scCode', 'Code')->hideOnIndex()->setColumns(4),
            TextField::new('scProvince', 'Province')->hideOnIndex()->setColumns(4),
            CountryField::new('scCountry', 'Pays')->hideOnIndex()->setColumns(4),

            FormField::addFieldset('Personne à contacter'),
            TextField::new('urgName', 'Personne à contacter en cas d\'urgence')->hideOnIndex()->setColumns(3),
            TextField::new('urgRelation', 'Rélation d\'urgence')->hideOnIndex()->setColumns(3),
            TextField::new('urgPhone', 'N° d\'urgence')->hideOnIndex()->setColumns(3),
            EmailField::new('urgMail', 'E-mail d\'urgence')->hideOnIndex()->setColumns(3),

            FormField::addTab('Etape 3'),

            FormField::addFieldset('Père ou tuteur'),
            TextField::new('fatherName', 'Tuteur')->hideOnIndex()->setColumns(3),
            TextField::new('fatherOccupation', 'Profession')->hideOnIndex()->setColumns(3),
            TextField::new('fatherPhone', 'N°')->hideOnIndex()->setColumns(3),
            EmailField::new('fatherMail', 'E-mail')->hideOnIndex()->setColumns(3),
            FormField::addFieldset('Mère ou tutrice'),
            TextField::new('motherName', 'Tutrice')->hideOnIndex()->setColumns(3),
            TextField::new('motherOccupation', 'Profession')->hideOnIndex()->setColumns(3),
            TextField::new('motherPhone', 'N°')->hideOnIndex()->setColumns(3),
            EmailField::new('motherMail', 'E-mail')->hideOnIndex()->setColumns(3),
            FormField::addFieldset('Origine'),
            TextField::new('provinceOrigin', 'Province d\'origine')->hideOnIndex()->setColumns(6),
            TextField::new('territoryOrigin', 'Territoire d\'origine')->hideOnIndex()->setColumns(6),

            FormField::addTab('Etape 4'),

            DateField::new('slipAt', 'Date paiement')->hideOnIndex()->setColumns(6),
            TextField::new('slipRef', 'Réf Bordereau')->hideOnIndex()->setColumns(6),
            BooleanField::new('isSpecial', 'Spécial')->hideOnIndex(),
            TextField::new('instOrigin', 'Provenance')->hideOnIndex()->setColumns(3),
            TextField::new('facultyOrigin', 'Faculté/Filière de provenance')->hideOnIndex()->setColumns(3),
            TextField::new('promRequest', 'Promotion demandée')->hideOnIndex()->setColumns(3),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return Crud::new()
            ->setPageTitle('index', 'Applications')
            ->setPageTitle('edit', 'Application')
            ->setPageTitle('new', 'Application')
            ->setPageTitle('detail', 'Application')
            ->setEntityLabelInSingular('application')
            ->setEntityLabelInPlural('applications')
            ;
    }

    public function configureActions(Actions $actions): Actions
    {
        $fiche = Action::new('Fiche de scolarité', 'Fiche de scolarité', '')
            ->linkToCrudAction('fiche');
        return $actions
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->setPermission(Action::DELETE, 'ROLE_ROOT')
            ->setPermission(Action::DETAIL, 'ROLE_PRIME')
            ->setPermission(Action::EDIT, 'ROLE_ROOT')
            ->setPermission(Action::INDEX, 'ROLE_PRIME')
            ->setPermission(Action::BATCH_DELETE, 'ROLE_ROOT')
            ->add(Crud::PAGE_INDEX, $fiche);
    }

    public function fiche(AdminContext $context)
    {
        $entity = $context->getEntity()->getInstance();
        //$url = $this->gene
        $url = $this->generateUrl('app_pdf_down_fiche_solarize', ['code' => $entity->getCode()]);
        return $this->redirect($url);
    }
}
