<?php

namespace App\Controller\Admin;

use App\Entity\DbConditions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class DbConditionsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DbConditions::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnDetail(),
            TextField::new('imgFile', 'Image')->setFormType(VichImageType::class)->onlyOnForms()->setColumns(2),
            TextField::new('title', 'Titre')->setColumns(10),
            TextEditorField::new('content', 'Lien')->setColumns(8),
            ImageField::new('img')->setBasePath('/media/cache/resolve/carousel/assets/img/carousel/')->hideOnForm(),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return Crud::new()
            ->setPageTitle('index', 'Pages conditions')
            ->setPageTitle('edit', 'Page condition')
            ->setPageTitle('new', 'Page condition')
            ->setPageTitle('detail', 'Page condition')
            ->setEntityLabelInSingular('page condition')
            ->setEntityLabelInPlural('Pages conditions')
            ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::NEW, 'ROLE_ROOT')
            ->setPermission(Action::DELETE, 'ROLE_ROOT')
            ->setPermission(Action::DETAIL, 'ROLE_PRIME')
            ->setPermission(Action::EDIT, 'ROLE_ADMIN')
            ->setPermission(Action::INDEX, 'ROLE_PRIME')
            ->setPermission(Action::BATCH_DELETE, 'ROLE_ADMIN');
    }
}
