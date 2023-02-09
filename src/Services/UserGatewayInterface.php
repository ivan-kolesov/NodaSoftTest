<?php declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Exception;

interface UserGatewayInterface
{
    /**
     * Возвращает список пользователей старше заданного возраста.
     * @param int $ageFrom
     * @param int $limit
     * @return array
     * @throws Exception
     */
    public function getUsers(int $ageFrom, int $limit): array;

    /**
     * Возвращает пользователя по имени.
     * @param string $name
     * @return User
     * @throws Exception
     */
    public function getUser(string $name): User;

    /**
     * Добавляет пользователя в базу данных.
     * @param User $user
     * @param callable $onSuccessAdded
     * @throws Exception
     */
    public function addUser(User $user, callable $onSuccessAdded): void;
}