<?php

namespace App\Controller\Admin;

use App\Entity\Magazine\InfoFlash;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class InfoFlashCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return InfoFlash::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('content', 'Contenu')->setRequired(true),
            BooleanField::new("publish", 'Publier ?'),
        ];
    }
}
