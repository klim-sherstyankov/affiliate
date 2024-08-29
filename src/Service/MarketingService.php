<?php

namespace App\Service;

use App\Entity\Redirects;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class MarketingService
{
    public function __construct(private ClickService $clickService, private EntityManagerInterface $em)
    {
    }

    /**
     * @throws Exception
     */
    public function click(Request $request, string $sourceUrl): void
    {
        $data = [
            'source_url' => $sourceUrl,
            'user_id' => $request->get('user_id'),
            'session_id' => $request->get('session_id'),
            'url' => $request->get('url'),
            'referer' => $request->headers->get('referer'),
            'user_agent' => $request->get('user_agent'),
            'ip' => $request->get('ip'),
            'method' => $request->getMethod(),
            'status_code' => $request->get('status_code'),
            'response_time' => $request->get('response_time'),
            'created_at' => (new \DateTime())->format('Y-m-d H:i:s'),
        ];

        $this->clickService->insertClickData($data);
    }

    public function getDestUrl(string $sourceUrl): ?string
    {
        /** @var Redirects $redirects */
        $redirects = $this->em->getRepository(Redirects::class)->findOneBy(['sourceUrl' => $sourceUrl]);

        return $redirects?->getDestinationUrl();
    }
}
