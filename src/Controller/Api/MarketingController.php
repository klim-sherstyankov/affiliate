<?php

namespace App\Controller\Api;

use App\Service\ClickService;
use App\Service\MarketingService;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MarketingController extends AbstractController
{
    public function __construct(private MarketingService $marketingService, private ClickService $clickService)
    {
    }

    /**
     * @throws Exception
     */
    #[Route('/api/marketing/redirect/{sourceUrl}', name: 'redirecting', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Get url'
    )]
    #[OA\Parameter(
        name: 'source_url',
        description: 'source url',
        in: 'query',
        schema: new OA\Schema(type: 'string')
    )]
    public function redirecting(Request $request, string $sourceUrl): JsonResponse
    {
        $status = Response::HTTP_NOT_FOUND;
        $destUrl = $this->marketingService->getDestUrl($sourceUrl);

        if (null !== $destUrl) {
            $status = Response::HTTP_OK;
            $this->marketingService->click($request, $sourceUrl);
        }

        return new JsonResponse(['url' => $destUrl], $status);
    }

    #[Route('/api/marketing/analytic/{sourceUrl}', name: 'app_analytic', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Get url'
    )]
    #[OA\Parameter(
        name: 'source_url',
        description: 'source url',
        in: 'query',
        schema: new OA\Schema(type: 'string')
    )]
    public function clickInfo(Connection $clickhouseConnection, string $sourceUrl): Response
    {
        $results = $this->clickService->getData($sourceUrl);

        return $this->json($results);
    }
}
