<?php declare(strict_types=1);

namespace App\Models;

class User
{
    public ?int $id;
    public ?string $key;
    public ?string $from;

    public function __construct(
        public string  $name,
        public string  $lastName,
        public int     $age)
    {
    }
}