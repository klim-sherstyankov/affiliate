<?php

namespace App\Controller\Api;

use App\Service\ClickService;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MarketingController extends AbstractController
{
    public function __construct(private ClickService $clickService)
    {
    }

    /**
     * @throws Exception
     */
    #[Route('/api/marketing/click', name: 'click', methods: ['GET'])]
    public function click(Request $request): Response
    {
        $data = [
            'user_id' => $request->get('user_id'),
            'session_id' => $request->get('session_id'),
            'url' => $request->get('url'),
            'referer' => $request->get('referer'),
            'user_agent' => $request->get('user_agent'),
            'ip' => $request->get('ip'),
            'method' => $request->getMethod(),
            'status_code' => $request->get('status_code'),
            'response_time' => $request->get('response_time'),
            'created_at' => (new \DateTime())->format('Y-m-d H:i:s'),
        ];

        $this->clickService->insertClickData($data);

        return new Response('Click data inserted successfully', Response::HTTP_OK);
    }

    #[Route('/api/marketing/all', name: 'app_marketing2', methods: ['GET'])]
    public function clickInfo(Connection $clickhouseConnection): Response
    {
        $sql = 'SELECT * FROM click LIMIT 10';
        $statement = $clickhouseConnection->executeQuery($sql);
        $results = $statement->fetchAllAssociative();

        return $this->json($results);
    }
}
