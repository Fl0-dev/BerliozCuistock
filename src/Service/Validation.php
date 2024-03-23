<?php

namespace App\Service;

use App\Entity\User;

class Validation
{
    public static function validate(array $data): array
    {
        $errors = [];
        if (empty($data['firstname'])) {
            $errors['firstname'] = 'Firstname is required';
        } elseif (strlen($data['firstname']) < 2) {
            $errors['firstname'] = 'Firstname must be at least 2 characters.';
        } elseif (strlen($data['firstname']) > 50) {
            $errors['firstname'] = 'Firstname must be less than 50 characters.';
        }

        if (empty($data['lastname'])) {
            $errors['lastname'] = 'Lastname is required';
        } elseif (strlen($data['lastname']) < 2) {
            $errors['lastname'] = 'Lastname must be at least 2 characters.';
        } elseif (strlen($data['lastname']) > 50) {
            $errors['lastname'] = 'Lastname must be less than 50 characters.';
        }

        if (empty($data['email'])) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email is not valid';
        } elseif (strlen($data['email']) > 255) {
            $errors['email'] = 'Email must be less than 255 characters.';
        } elseif (User::findByEmail($data['email'])) {
            $errors['email'] = 'Email already exists';
        }

        if (empty($data['password'])) {
            $errors['password'] = 'Password is required';
        } elseif (strlen($data['password']) < 8) {
            $errors['password'] = 'Password must be at least 8 characters.';
        }

        if (empty($data['address'])) {
            $errors['address'] = 'Address is required';
        } elseif (strlen($data['address']) < 2) {
            $errors['address'] = 'Address must be at least 2 characters.';
        } elseif (strlen($data['address']) > 255) {
            $errors['address'] = 'Address must be less than 255 characters.';
        }

        if (empty($data['city'])) {
            $errors['city'] = 'City is required';
        } elseif (strlen($data['city']) < 2) {
            $errors['city'] = 'City must be at least 2 characters.';
        } elseif (strlen($data['city']) > 255) {
            $errors['city'] = 'City must be less than 50 characters.';
        }

        if (empty($data['postalCode'])) {
            $errors['postalCode'] = 'Postal code is required';
        } elseif (!preg_match('/^[0-9]{5}$/', $data['postalCode'])) {
            $errors['postalCode'] = 'Postal code is not valid';
        }

        return $errors;
    }
}
