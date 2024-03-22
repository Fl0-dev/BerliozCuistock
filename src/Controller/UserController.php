<?php


declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use Berlioz\Core\Exception\BerliozException;
use Berlioz\Http\Core\Attribute as Berlioz;
use Berlioz\Http\Core\Controller\AbstractController;
use Berlioz\Http\Message\Request;
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
    #[Berlioz\Route('/register', name: 'user')]
    public function registerView(): ResponseInterface
    {
        return $this->response($this->render('user.html.twig'));
    }

    /**
     * user route.
     *
     * @return ResponseInterface
     * @throws BerliozException
     * @throws Error
     */
    #[Berlioz\Route('/create', name: 'create', method: ['POST'])]
    public function create(Request $request): ResponseInterface
    {
        if ($request->getParsedBody() !== null) {
            $user = User::findOrFail(1);

            var_dump($user->getFirstname());

            $firstname = $request->getParsedBody()['firstname'] ?? null;
            $lastname = $request->getParsedBody()['lastname'] ?? null;
            $email = $request->getParsedBody()['email'] ?? null;
            $password = $request->getParsedBody()['password'] ?? null;
            $address = $request->getParsedBody()['address'] ?? null;
            $city = $request->getParsedBody()['city'] ?? null;
            $postalCode = $request->getParsedBody()['postalCode'] ?? null;
        }
        return $this->response($this->render('user.html.twig', [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'password' => $password,
            'address' => $address,
            'city' => $city,
            'postalCode' => $postalCode
        ]));
    }
}
