<?php

namespace App\Command;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClickHouseMakeClickMigrateCommand extends Command
{
    protected static $defaultName = 'doctrine:migrations:clickhouse:make:click';

    private Connection $clickhouseConnection;

    public function __construct(Connection $clickhouseConnection)
    {
        $this->clickhouseConnection = $clickhouseConnection;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Execute a migration to a specified version or the latest version for ClickHouse');
    }

    /**
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sql = '
            CREATE TABLE click (
                user_id UInt32,
                session_id UUID,
                url String,
                referer String,
                user_agent String,
                ip String,
                method String,
                status_code UInt16,
                response_time Float32,
                created_at DateTime DEFAULT now()
            ) ENGINE = MergeTree()
            ORDER BY (created_at);
        ';
        $this->clickhouseConnection->executeQuery($sql);

        return 0;
    }
}
