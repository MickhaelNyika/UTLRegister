<?php

namespace App\Controller\Admin;

use App\Entity\DbFaculties;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DbFacultiesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DbFaculties::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'NOM')->setColumns(12),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return Crud::new()
            ->setPageTitle('index', 'Facultés')
            ->setPageTitle('edit', 'Faculté')
            ->setPageTitle('new', 'Faculté')
            ->setPageTitle('detail', 'Faculté')
            ->setEntityLabelInSingular('faculté')
            ->setEntityLabelInPlural('facultés')
            ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::NEW, 'ROLE_ROOT')
            ->setPermission(Action::DELETE, 'ROLE_ROOT')
            ->setPermission(Action::DETAIL, 'ROLE_ADMIN')
            ->setPermission(Action::EDIT, 'ROLE_OPS')
            ->setPermission(Action::INDEX, 'ROLE_ADMIN')
            ->setPermission(Action::BATCH_DELETE, 'ROLE_ROOT')
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
}
