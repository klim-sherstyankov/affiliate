<?php

namespace App\Command;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClickHouseDeleteClickMigrateCommand extends Command
{
    protected static $defaultName = 'doctrine:migrations:clickhouse:delete:click';

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
        $sql = 'DROP TABLE click';
        $this->clickhouseConnection->executeQuery($sql);

        return 0;
    }
}
