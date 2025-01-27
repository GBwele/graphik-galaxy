<?php

namespace App\Controller\Admin;

use App\Entity\Products;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Faker\Core\Number;

class ProductsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Products::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
        
            TextField::new('nom'),
            NumberField::new('taille'),
            NumberField::new('prix'),
            TextField::new('public_cible'),
            TextField::new('categorie'),
            TextField::new('genre'),
            ImageField::new('images')
            ->setBasePath('public/assets/img')
            ->setUploadDir('public/assets/img')
            ->setRequired(true),
            TextareaField::new('description'),
            IntegerField::new('stocks', 'Stocks disponibles'),
        
        ];
    }
}
