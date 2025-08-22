<?php

namespace App\Controller\Admin;

use App\Entity\DbUsers;
use App\Entity\UserLogs;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserLogsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserLogs::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('user.email', 'MAIL')->hideOnForm(),
            TextField::new('ip', 'IP'),
            TextField::new('msg', 'MESSAGE'),
            AssociationField::new('user', 'UTILSATEUR')->hideOnIndex()->hideOnDetail()->setFormTypeOptions([
                'class' => DbUsers::class,
                'choice_label' => 'email'
            ])->setRequired(true)->setColumns(3),
            DateTimeField::new('createdAt', 'DATE'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return Crud::new()
            ->setPageTitle('index', 'Journaux utilisateurs')
            ->setPageTitle('edit', 'Journal utilisateurs')
            ->setPageTitle('new', 'Journal utilisateur')
            ->setPageTitle('detail', 'Journal utilisateur')
            ->setEntityLabelInSingular('journal utilisateur')
            ->setEntityLabelInPlural('journaux utilisateurs')
            ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::NEW, 'ROLE_ROOT')
            ->setPermission(Action::DELETE, 'ROLE_ROOT')
            ->setPermission(Action::DETAIL, 'ROLE_ADMIN')
            ->setPermission(Action::EDIT, 'ROLE_ROOT')
            ->setPermission(Action::INDEX, 'ROLE_ADMIN')
            ->setPermission(Action::BATCH_DELETE, 'ROLE_ROOT')
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
}
