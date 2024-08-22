<?php

namespace App\Service;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class ClickService
{
    private Connection $clickhouseConnection;

    public function __construct(Connection $clickhouseConnection)
    {
        $this->clickhouseConnection = $clickhouseConnection;
    }

    /**
     * @throws Exception
     */
    public function insertClickData(array $data): void
    {
        $this->clickhouseConnection->insert('click', $data);
    }
}
