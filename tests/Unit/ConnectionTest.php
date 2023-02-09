<?php declare(strict_types=1);

namespace Tests\Unit;

use App\Services\Database\PDODriver;
use PDO;
use Tests\BaseTestCase;

final class ConnectionTest extends BaseTestCase
{
    public function testSqlite(): void
    {
        $databaseInstance = (new PDODriver())->create('database-sqlite.ini');
        $this->assertInstanceOf(PDO::class, $databaseInstance);
    }

    public function testMysql(): void
    {
        $databaseInstance = (new PDODriver())->create('database-mysql.ini');
        $this->assertInstanceOf(PDO::class, $databaseInstance);
    }
}
