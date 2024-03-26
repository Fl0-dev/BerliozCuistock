<?php

namespace App\Service;

use App\Entity\Recipe;

class RecipeMapper
{
    public static function map(array $data): array
    {
        // vérification si le title de $data existe en bdd
        if (Recipe::findByTitle($data['title'])) {
            return [];
        }

        $ingredients = [];
        $instructions = [];
        $analyzedInstructions = $data['analyzedInstructions'];

        if (is_array($analyzedInstructions) && count($analyzedInstructions) > 0) {
            $steps = $analyzedInstructions[0]['steps'];
            foreach ($steps as $step) {
                $instructions[] = [
                    'step' => $step['number'],
                    'description' => $step['step'],
                ];

                foreach ($step['ingredients'] as $ingredient) {
                    if (is_array($ingredient) && !empty($ingredient)) {
                        $ingredientKey = $ingredient['name'];

                        if (!array_key_exists($ingredientKey, $ingredients)) {
                            $ingredients[$ingredientKey] = [
                                'name' => $ingredient['name'],
                                'image' => $ingredient['image'],
                            ];
                        }
                    }
                }
            }
        }

        return [
            'title' => $data['title'],
            'description' => $data['summary'],
            'image' => $data['image'],
            'ingredients' => json_encode($ingredients),
            'instructions' => json_encode($instructions),
        ];
    }
}
