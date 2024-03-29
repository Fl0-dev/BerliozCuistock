<?php

namespace App\Entity;

use DateTime;
use Hector\Orm\Entity\Entity;

// use Hector\Orm\Entity\MagicEntity;

class User extends Entity
{
    private int $id;
    private ?string $firstname;
    private ?string $lastname;
    private string $email;
    private string $password;
    private ?string $address;
    private ?string $city;
    private ?string $postalCode;
    private DateTime $created_at;
    private ?DateTime $updated_at;

    public function __construct()
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function getCreateAt(): DateTime
    {
        return $this->created_at;
    }

    public function getUpdateAt(): ?DateTime
    {
        return $this->updated_at;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function setPostalCode(string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    public function setCreateAt(DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function setUpdateAt(DateTime $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    public static function isExistByEmail(string $email): bool
    {
        $user = User::query()
            ->where('email', '=', $email)
            ->fetchOne();

        return $user !== null;
    }

    public static function findByEmail(string $email): ?array
    {
        return User::query()
            ->where('email', '=', $email)
            ->fetchOne();
    }
}
