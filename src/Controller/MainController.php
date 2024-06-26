<?php

/**
 * This file is part of Berlioz framework.
 *
 * @license   https://opensource.org/licenses/MIT MIT License
 * @copyright 2020 Ronan GIRON
 * @author    Ronan GIRON <https://github.com/ElGigi>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code, to the root.
 */

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Recipe;
use App\Service\Utils;
use Berlioz\Core\Exception\BerliozException;
use Berlioz\Http\Core\Attribute as Berlioz;
use Berlioz\Http\Core\Controller\AbstractController;
use Psr\Http\Message\ResponseInterface;
use Twig\Error\Error;

class MainController extends AbstractController
{
    /**
     * Home route.
     *
     * @return ResponseInterface
     * @throws BerliozException
     * @throws Error
     */
    #[Berlioz\Route('/', name: 'home')]
    public function home(): ResponseInterface
    {
        $isUser = Utils::userInSession();
        $recipes = Recipe::getRandomRecipes(5);
        return $this->response($this->render('home.html.twig', [
            'recipes' => $recipes,
            'isUser' => $isUser,
        ]));
    }
}
