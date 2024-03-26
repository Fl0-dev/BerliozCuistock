<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Recipe;
use App\Service\RecipeMapper;
use Berlioz\Http\Core\Controller\AbstractController;
use Psr\Http\Message\ResponseInterface;
use Berlioz\Core\Exception\BerliozException;
use Berlioz\Http\Core\Attribute as Berlioz;
use Berlioz\Http\Message\Request;

class RecipeController extends AbstractController
{
    /**
     * Fetch route.
     *
     * @return ResponseInterface
     * @throws BerliozException
     * @throws Error
     */
    #[Berlioz\Route('/fetchRecipes', name: 'fetchRecipes', method: ['POST'])]
    public function fetchRecipesAndSave(Request $request): ResponseInterface
    {
        $postData = $request->getParsedBody();
        $ingredient = $postData['ingredient'];
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.spoonacular.com/recipes/complexSearch?number=100&instructionsRequired=true&addRecipeInformation=true&query=$ingredient&apiKey=[YOUR_API_KEY]",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $responseToArray = json_decode($response, true);
        $recipes = $responseToArray['results'];

        if (empty($recipes)) {
            return $this->response($this->render('home.html.twig', ['data' => ['No recipes found with the ingredient ' . $ingredient . '. Please try another ingredient.']]));
        }

        foreach ($recipes as $recipe) {

            $recipeMapped = RecipeMapper::map($recipe);
            if (empty($recipeMapped)) {
                continue;
            }
            $recipeToSave = new Recipe();
            $recipeToSave->setTitle($recipeMapped['title']);
            $recipeToSave->setDescription($recipeMapped['description']);
            $recipeToSave->setIngredients($recipeMapped['ingredients']);
            $recipeToSave->setInstructions($recipeMapped['instructions']);
            $recipeToSave->setImage($recipeMapped['image']);

            $recipeToSave->save();

            $data[] = $recipeMapped['title'];
        }


        return $this->response($this->render('home.html.twig', ['data' => $data]));
    }
}
