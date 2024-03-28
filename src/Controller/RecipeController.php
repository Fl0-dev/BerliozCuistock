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
use Berlioz\Http\Message\ServerRequest;
use Hector\Orm\Collection\Collection;

class RecipeController extends AbstractController
{

    /**
     * Recipes route.
     *
     * @return ResponseInterface
     * @throws BerliozException
     * @throws Error
     */
    #[Berlioz\Route('/recipes', name: 'recipes')]
    public function recipesView(): ResponseInterface
    {
        $recipes = Recipe::all();
        $arrayRecipes = [];
        foreach ($recipes as $recipe) {
            $arrayRecipes[] = $recipe->toArray();
        }

        return $this->response($this->render('recipes.html.twig', ['recipes' => $arrayRecipes]));
    }

    /**
     * Recipe route.
     *
     * @return ResponseInterface
     * @throws BerliozException
     * @throws Error
     */
    #[Berlioz\Route('/recipe/{id}', name: 'recipe')]
    public function recipeView(ServerRequest $request): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $recipe = Recipe::find($id);

        return $this->response($this->render('recipe.html.twig', ['recipe' => $recipe]));
    }

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

        $apikey = $_ENV['API_KEY'];

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.spoonacular.com/recipes/complexSearch?number=100&instructionsRequired=true&addRecipeInformation=true&query=$ingredient&apiKey=$apikey",
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
        $recipes = Recipe::getRandomRecipes(5);

        return $this->response($this->render('home.html.twig', [
            'data' => $data,
            'recipes' => $recipes,
        ]));
    }
}
