<?php declare(strict_types=1);

namespace Tests\Unit;

use App\Models\User;
use App\Services\UserCreators;
use Tests\BaseTestCase;

final class UsersTest extends BaseTestCase
{
    public function testGetUsers(): void
    {
        $result = $this->produceUserManager()->getUsers(10);
        $this->assertContainsOnlyInstancesOf(User::class, $result);
    }

    public function testGetUsersWithLimit(): void
    {
        $limit = 3;
        $result = $this->produceUserManager()->getUsers(10, $limit);
        $this->assertLessThanOrEqual($limit, count($result));
    }

    public function testGetUsersByNames(): void
    {
        $result = $this->produceUserManager()->getByNames(['test1']);
        $this->assertContainsOnlyInstancesOf(User::class, $result);
    }

    public function testAddUsers(): void
    {
        $seedUser = function (): User {
            $user = new User('name user' . rand(0, 100), 'last name' . rand(0, 100), rand(1, 100));
            $user->from = 'from location' . rand(0, 100);
            $user->key = '';
            return $user;
        };
        $users = [
            $seedUser(),
            $seedUser()
        ];
        $result = $this->produceUserManager()->addUsers($users);
        $this->assertEquals(count($users), count($result));
    }

    public function testUserCreator(): void
    {
        $row = [
            'id' => 10,
            'name' => 'nameValue',
            'lastName' => 'lastNameValue',
            'age' => 10,
            'from' => 'fromValue',
            'settings' => '{"key": "keyValue"}'
        ];
        $expectedModel = new User('nameValue', 'lastNameValue', 10);
        $expectedModel->id = 10;
        $expectedModel->from = 'fromValue';
        $expectedModel->key = 'keyValue';

        $user = UserCreators::createFromDatabaseRow($row);
        $this->assertEquals($expectedModel, $user);
    }
}
