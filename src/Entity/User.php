<?php

namespace App\Entity;

use Hector\Orm\Entity\Entity;

// use Hector\Orm\Entity\MagicEntity;

class User extends Entity
{
    private int $id;
    private string $firstname;
    private string $lastname;
    private string $email;
    private string $password;
    private string $address;
    private string $city;
    private string $postalCode;

    public function __construct(
        int $id,
        string $firstname,
        string $lastname,
        string $email,
        string $password,
        string $address,
        string $city,
        string $postalCode
    ) {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
        $this->address = $address;
        $this->city = $city;
        $this->postalCode = $postalCode;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }
}
