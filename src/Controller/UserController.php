<?php


declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Service\Utils;
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
        $isUser = Utils::userInSession();
        return $this->response($this->render('user.html.twig', [
            'isUser' => $isUser,
        ]));
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
        $isUser = Utils::userInSession();
        $data = $request->getParsedBody();
        if ($data && is_array($data)) {
            $errors = Validation::validate($data);
            if (!empty($errors)) {
                unset($data['password']);
                return $this->response($this->render('user.html.twig', [
                    'errors' => $errors,
                    'data' => $data,
                    'isUser' => $isUser,
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

            $user->save();
            unset($data['password']);
        }
        return $this->response($this->render('user.html.twig', [
            'data' => $data,
            'success' => 'User created successfully.',
        ]));
    }

    /**
     * login route.
     *
     * @return ResponseInterface
     * @throws BerliozException
     * @throws Error
     */
    #[Berlioz\Route('/login', name: 'login')]
    public function loginView(): ResponseInterface
    {
        $isUser = Utils::userInSession();
        return $this->response($this->render('login.html.twig', [
            'isUser' => $isUser,
        ]));
    }

    /**
     * login route.
     *
     * @return ResponseInterface
     * @throws BerliozException
     * @throws Error
     */
    #[Berlioz\Route('/signIn', name: 'signIn', method: ['POST'])]
    public function signIn(Request $request): ResponseInterface
    {
        $isUser = Utils::userInSession();
        $data = $request->getParsedBody();
        if ($data && is_array($data)) {
            $user = User::findByEmail($data['email']);
            if ($user && password_verify($data['password'], $user['password'])) {
                session_start();
                unset($user['password']);
                $_SESSION['user'] = $user;
                return $this->redirect('/');
            }
        }
        return $this->response($this->render('login.html.twig', [
            'errors' => 'Invalid email or password.',
            'isUser' => $isUser,
        ]));
    }

    /**
     * logout route.
     *
     * @return ResponseInterface
     * @throws BerliozException
     * @throws Error
     */
    #[Berlioz\Route('/logout', name: 'logout')]
    public function logout(): ResponseInterface
    {
        session_start();
        unset($_SESSION['user']);
        return $this->response($this->render('login.html.twig', [
            'success' => 'Logout successfully.',
            'isUser' => false,
        ]));
    }
}
