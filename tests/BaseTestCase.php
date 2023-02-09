<?php declare(strict_types=1);

namespace Tests;

use App\Services\Database\PDODriver;
use App\Services\UserGateway;
use App\Services\UserManager;
use PHPUnit\Framework\TestCase;

require __DIR__ .'/../vendor/autoload.php';

abstract class BaseTestCase extends TestCase
{
    protected function produceUserManager(): UserManager
    {
        $configFilename = $_ENV['database'] ?? 'database-sqlite.ini';
        $databaseInstance = (new PDODriver())->create($configFilename);
        $userGateway = new UserGateway($databaseInstance);
        return new UserManager($userGateway);
    }
}