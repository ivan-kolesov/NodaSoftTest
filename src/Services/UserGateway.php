<?php declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use PDO;
use PDOException;

class UserGateway implements UserGatewayInterface
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    /**
     * Возвращает список пользователей старше заданного возраста.
     * @param int $ageFrom
     * @param int $limit
     * @return array
     * @throws PDOException
     */
    public function getUsers(int $ageFrom, int $limit): array
    {
        $stmt = $this->pdo
            ->prepare('SELECT id, name, lastName, `from`, age, settings FROM Users WHERE age > :age LIMIT :limit');
        $stmt->execute(['age' => $ageFrom, 'limit' => $limit]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $users = [];
        foreach ($rows as $row) {
            $users[] = UserCreators::createFromDatabaseRow($row);
        }

        return $users;
    }

    /**
     * Возвращает пользователя по имени.
     * @param string $name
     * @return User
     * @throws \Exception
     */
    public function getUser(string $name): User
    {
        $stmt = $this->pdo
            ->prepare('SELECT id, name, lastName, `from`, age, settings FROM Users WHERE name = :name');
        $stmt->execute(['name' => $name]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            throw new \RuntimeException("User not found");
        }

        return UserCreators::createFromDatabaseRow($row);
    }

    /**
     * Добавляет пользователя в базу данных.
     * @param User $user
     * @param callable $onSuccessAdded
     * @throws PDOException
     */
    public function addUser(User $user, callable $onSuccessAdded): void
    {
        $this->pdo->beginTransaction();

        try {
            $sth = $this->pdo
                ->prepare('INSERT INTO Users (name, lastName, age) VALUES (:name, :lastName, :age)');
            $sth->execute([':name' => $user->name, ':age' => $user->age, ':lastName' => $user->lastName]);

            $onSuccessAdded($this->pdo->lastInsertId());

            $this->pdo->commit();
        } catch (\Exception) {
            $this->pdo->rollBack();
        }
    }
}