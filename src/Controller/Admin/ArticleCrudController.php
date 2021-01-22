<?php

namespace App\Controller\Admin;

use App\Entity\Magazine\Article;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            ImageField::new('image', 'Image')
                ->onlyOnIndex()
                ->setBasePath(
                    $this->getParameter('app.path.article_images')
                ),
            TextField::new('imageFile', 'Image')
                ->onlyOnForms()
                ->setFormType(VichImageType::class),
            TextField::new('title', 'Titre'),
            AssociationField::new("tags", 'Mot-clés')->setRequired(false),
            TextEditorField::new('content', 'Contenu')->setRequired(true),
            BooleanField::new("publish", 'Publier ?'),
        ];
    }
}
