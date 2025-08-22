<?php

namespace App\Controller\Admin;

use App\Entity\DbUsers;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DbUsersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DbUsers::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnDetail(),
            //BooleanField::new('isVerified'),
            EmailField::new('email')->setColumns(3),
            TextField::new('password')->hideOnIndex(),
            //DateTimeField::new('createdAt', 'Créer')->hideOnForm(),
            //DateTimeField::new('updatedAt', 'Date 2')->hideOnForm()->hideOnIndex(),
            ArrayField::new('roles')->hideOnIndex()->setColumns(3),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return Crud::new()
            ->setPageTitle('index', 'Users')
            ->setPageTitle('edit', 'User')
            ->setPageTitle('new', 'User')
            ->setPageTitle('detail', 'User')
            ->setEntityLabelInSingular('user')
            ->setEntityLabelInPlural('users')
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
