<?php declare(strict_types=1);

namespace App\Services;

class UserManager
{
    private const defaultLimit = 10;

    public function __construct(private readonly UserGatewayInterface $userGateway)
    {
    }

    /**
     * Возвращает пользователей старше заданного возраста.
     * @param int $ageFrom
     * @param int|null $limit
     * @return array
     * @throws \Exception
     */
    public function getUsers(int $ageFrom, ?int $limit = UserManager::defaultLimit): array
    {
        return $this->userGateway->getUsers($ageFrom, $limit);
    }

    /**
     * Возвращает пользователей по списку имен.
     * @param array $names
     * @return array
     */
    public function getByNames(array $names): array
    {
        $users = [];
        foreach ($names as $name) {
            try {
                $users[] = $this->userGateway->getUser($name);
            } catch (\Exception) {
            }
        }

        return $users;
    }

    /**
     * Добавляет пользователей в базу данных.
     * @param array $users
     * @return array
     * @throws \Exception
     */
    public function addUsers(array $users): array
    {
        $ids = [];

        foreach ($users as $user) {
            $this->userGateway->addUser($user, function (string $id) use (&$ids) {
                $ids[] = $id;
            });
        }

        return $ids;
    }
}