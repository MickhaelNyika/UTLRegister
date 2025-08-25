<?php

namespace App\Controller\Admin;

use App\Entity\DbApiKeys;
use App\Entity\DbUsers;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\HiddenField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Random\RandomException;

class DbApiKeysCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DbApiKeys::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            BooleanField::new('isEnabled', 'Activer')->setColumns(2),
            TextField::new('user.email', 'Utilisateur')->hideOnForm(),
            AssociationField::new('user', 'Utilisateur')->hideOnIndex()->hideOnDetail()->setFormTypeOptions([
                'class' => DbUsers::class,
                'choice_label' => function($s) {
                    return $s->getEmail() ;
                },
            ])->setRequired(true)->setColumns(6),
            HiddenField::new('name', 'Clef')->setColumns(4),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Clé API')
            ->setEntityLabelInPlural('Clés API')
            ->setDefaultSort(['createdAt' => 'DESC']);
    }

    /**
     * @throws RandomException
     */
    public function persistEntity($entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof DbApiKeys && !$entityInstance->getName()) {
            $entityInstance->setName(bin2hex(random_bytes(32)));
        }

        parent::persistEntity($entityManager, $entityInstance);
    }
}