<?php

namespace App\Controller\Admin;

use App\Entity\DbResidences;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DbResidencesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DbResidences::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name')
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return Crud::new()
            ->setPageTitle('index', 'Résidences')
            ->setPageTitle('edit', 'Résidence')
            ->setPageTitle('new', 'Résidence')
            ->setPageTitle('detail', 'Résidence')
            ->setEntityLabelInSingular('résidence')
            ->setEntityLabelInPlural('résidences')
            ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::NEW, 'ROLE_ROOT')
            ->setPermission(Action::DELETE, 'ROLE_ROOT')
            ->setPermission(Action::DETAIL, 'ROLE_PRIME')
            ->setPermission(Action::EDIT, 'ROLE_ROOT')
            ->setPermission(Action::INDEX, 'ROLE_PRIME')
            ->setPermission(Action::BATCH_DELETE, 'ROLE_ROOT')
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
}
