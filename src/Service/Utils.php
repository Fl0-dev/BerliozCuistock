<?php

namespace App\Service;

class Utils
{
    public static function userInSession(): bool
    {
        session_start();
        return isset($_SESSION['user']);
    }
}
