<?php

namespace App\Controller\Admin;

use App\Entity\Items;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ItemsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Items::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('shortName'),
            TextField::new('url'),
            TextEditorField::new('description'),
            IntegerField::new('price'),
            IntegerField::new('salePrice'),
            TextField::new('image'),
            IntegerField::new('priceOffPercent'),
            AssociationField::new('shopId'),
        ];
    }
}
