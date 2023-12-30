<?php

namespace App\Client;

use Doctrine\DBAL\Exception;

class ClickHouse
{
    public $clickHouseClient;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $connectionParams = [
            'host' => 'https://play.clickhouse.com/',
            'port' => 443,
            'user' => 'explorer',
            'password' => '',
            'dbname' => 'dataset',
            'driverClass' => 'FOD\DBALClickHouse\Driver',
            'wrapperClass' => 'FOD\DBALClickHouse\Connection',
            'driverOptions' => [
                'extremes' => false,
                'readonly' => true,
                'max_execution_time' => 30,
                'enable_http_compression' => 0,
                'https' => false,
            ],
        ];
        $this->clickHouseClient = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, new \Doctrine\DBAL\Configuration());
    }

    /**
     * @throws Exception
     */
    public function getData()
    {
        dd($this->clickHouseClient->isConnected());
    }
}
