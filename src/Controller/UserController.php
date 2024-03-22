<?php


declare(strict_types=1);

namespace App\Controller;

use Berlioz\Core\Exception\BerliozException;
use Berlioz\Http\Core\Attribute as Berlioz;
use Berlioz\Http\Core\Controller\AbstractController;
use Psr\Http\Message\ResponseInterface;
use Twig\Error\Error;

class UserController extends AbstractController
{
    /**
     * user route.
     *
     * @return ResponseInterface
     * @throws BerliozException
     * @throws Error
     */
    #[Berlioz\Route('/user')]
    public function create(): ResponseInterface
    {
        return $this->response($this->render('user.html.twig'));
    }
}
