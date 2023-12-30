<?php

namespace App\Controller\Admin;

use App\Entity\Shop;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ShopCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Shop::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
