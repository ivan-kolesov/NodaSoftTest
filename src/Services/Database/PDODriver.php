<?php declare(strict_types=1);

namespace App\Services\Database;

use PDO;

final class PDODriver
{
    private const CONFIG_PATH = './config/';

    /**
     * @param string $configFilename
     * @return PDO
     * @throws \PDOException
     */
    public function create(string $configFilename): PDO
    {
        $config = parse_ini_file(self::CONFIG_PATH . $configFilename);
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? null;
        $password = $config['password'] ?? null;
        $options = $config['options'] ?? null;
        return new PDO($dsn, $user, $password, $options);
    }
}