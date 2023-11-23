<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        //        $file = file_get_contents('http://zakupki.gov.ru/44fz/filestore/public/1.0/download/rpec/file.html?uid=05B66866E72E9409E06334548D0A3CF2', false, $context);
        $scu = 'http://zakupki.gov.ru/44fz/filestore/public/1.0/download/rpec/file.html?uid=05B66866E72E9409E06334548D0A3CF2';
        $opts = ['http' => [
                'method' => 'GET',
                'max_redirects' => '0',
                'ignore_errors' => '1',
                'user_agent' => 'EETP',
            ], 'ssl' => [
                'verify_peer' => true,
                'cafile' => '/SRV/php721/extras/ssl/cacert.pem',
                'ciphers' => 'HIGH:TLSv1.2:TLSv1.1:TLSv1.0:!SSLv3:!SSLv2',
                'disable_compression' => true,
            ],
        ];

        $context = stream_context_create($opts);
        $stream = fopen($scu, 'r', false, $context);

        // информация о заголовках, а также
        // метаданные о потоке
        dump(stream_get_meta_data($stream), 'stream_get_meta_data($stream)');

        // актуальная информация по ссылке $url
        dump($a = stream_get_contents($stream), 'stream_get_contents($stream)');

        dd(file_get_contents($a));
        fclose($stream);
        dd($stream);
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * @throws \Exception
     */
    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout(): void
    {
        throw new \RuntimeException('logout');
    }
}
