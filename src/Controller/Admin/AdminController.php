<?php

namespace App\Controller\Admin;

use App\Entity\Items;
use App\Entity\Shop;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractDashboardController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig', [
        ]);
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::section('Statistic'),
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
            MenuItem::section('Work'),
            MenuItem::linkToCrud('User', 'fa fa-tags', User::class),
            MenuItem::linkToCrud('Items', 'fa fa-tags', Items::class),
            MenuItem::linkToCrud('Shop', 'fa fa-tags', Shop::class),
            MenuItem::linkToLogout('Logout', 'fa fa-exit'),
        ];
    }
}
