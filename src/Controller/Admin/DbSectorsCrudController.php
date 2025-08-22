<?php

namespace App\Controller\Admin;

use App\Entity\DbFaculties;
use App\Entity\DbSectors;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DbSectorsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DbSectors::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('faculty', 'Faculté')->hideOnIndex()->hideOnDetail()->setFormTypeOptions([
                'class' => DbFaculties::class,
                'choice_label' => 'name'
            ])->setRequired(true)->setColumns(6),
            TextField::new('name')->setColumns(6),
            TextField::new('faculty.name', 'FACULTE')->hideOnForm(),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return Crud::new()
            ->setPageTitle('index', 'Filières')
            ->setPageTitle('edit', 'Filière')
            ->setPageTitle('new', 'Filière')
            ->setPageTitle('detail', 'Filière')
            ->setEntityLabelInSingular('filière')
            ->setEntityLabelInPlural('filières')
            ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::NEW, 'ROLE_ROOT')
            ->setPermission(Action::DELETE, 'ROLE_ROOT')
            ->setPermission(Action::DETAIL, 'ROLE_ADMIN')
            ->setPermission(Action::EDIT, 'ROLE_ADMIN')
            ->setPermission(Action::INDEX, 'ROLE_ADMIN')
            ->setPermission(Action::BATCH_DELETE, 'ROLE_ROOT')
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
}
