<?php

namespace App\Controller\Admin;

use App\Entity\Actualite;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;


class ActualiteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Actualite::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title')->setHelp('Title of the blogpost'),
            AssociationField::new('author', 'Author'),
            TextEditorField::new('content')->setHelp('Content'),
            TextField::new('slug')->setRequired(true),
            DateTimeField::new('date'),
            AssociationField::new('comments')->hideOnForm(),
            AssociationField::new('images')->hideOnForm()

        ];
    }
    
}
