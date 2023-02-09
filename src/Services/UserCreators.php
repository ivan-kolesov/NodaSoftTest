<?php declare(strict_types=1);

namespace App\Services;

use App\Models\User;

class UserCreators
{
    /**
     * @param array $row
     * @return User
     */
    public static function createFromDatabaseRow(array $row): User
    {
        $user = new User($row['name'], $row['lastName'], $row['age']);
        $user->id = $row['id'];

        try {
            $settings = json_decode($row['settings'] ?? '', true, 512, JSON_THROW_ON_ERROR);
            if (isset($settings['key'])) {
                $user->key = (string)$settings['key'];
            }
        } catch (\JsonException) {
        }

        $user->from = $row['from'];

        return $user;
    }
}