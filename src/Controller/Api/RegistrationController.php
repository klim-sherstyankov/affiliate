<?php

namespace App\Controller\Api;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/api/register', name: 'app_api_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $user = new User();
        $user->setEmail($request->request->get('email'));
        $user->setRoles(['ROLE_ADMIN']);
        // encode the plain password
        $user->setPassword(
            $userPasswordHasher->hashPassword(
                $user,
                $request->request->get('plainPassword')
            )
        );

        $entityManager->persist($user);
        $entityManager->flush();

        // do anything else you need here, like send an email
        return new JsonResponse(['success' => true]);
    }
}
