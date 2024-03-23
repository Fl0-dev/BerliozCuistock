<?php


declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Service\Validation;
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
        $data = $request->getParsedBody();
        if ($data && is_array($data)) {
            $errors = Validation::validate($data);
            if (!empty($errors)) {
                unset($data['password']);
                return $this->response($this->render('user.html.twig', [
                    'errors' => $errors,
                    'data' => $data,
                ]));
            }

            $user = new User();
            $user->setFirstname($data['firstname']);
            $user->setLastname($data['lastname']);
            $user->setEmail($data['email']);
            $user->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));
            $user->setAddress($data['address']);
            $user->setCity($data['city']);
            $user->setPostalCode($data['postalCode']);

            $user->$user->save();
            unset($data['password']);
        }
        return $this->response($this->render('user.html.twig', [
            'data' => $data,
            'success' => 'User created successfully.',
        ]));
    }
}
