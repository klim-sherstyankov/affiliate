<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractDashboardController
{
    #[Route('/user', name: 'users')]
    public function index(): Response
    {
        return new Response('UserController');
    }
}