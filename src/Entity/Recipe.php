<?php

namespace App\Entity;

use DateTime;
use Generator;
use Hector\Orm\Entity\Entity;

class Recipe extends Entity
{
    private int $id;
    private string $title;
    private string $description;
    private string $ingredients;
    private string $instructions;
    private ?string $image;
    private DateTime $created_at;
    private ?DateTime $updated_at;

    public function __construct()
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getIngredients(): string
    {
        return $this->ingredients;
    }

    public function getInstructions(): string
    {
        return $this->instructions;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updated_at;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setIngredients(string $ingredients): void
    {
        $this->ingredients = $ingredients;
    }

    public function setInstructions(string $instructions): void
    {
        $this->instructions = $instructions;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function setCreatedAt(DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function setUpdatedAt(?DateTime $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'ingredients' => $this->ingredients,
            'instructions' => $this->instructions,
            'image' => $this->image,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at ? $this->updated_at->format('Y-m-d H:i:s') : null,
        ];
    }

    public static function findByTitle(string $title): bool
    {
        $recipe = Recipe::query()
            ->where('title', '=', $title)
            ->fetchOne();

        return $recipe !== null;
    }

    public static function getRandomRecipes(int $number)
    {
        $count = Recipe::query()
            ->count();
        if ($count === 0) {
            return [];
        }
        $offset = rand(0, $count - $number);

        return Recipe::query()
            ->limit($number)
            ->offset($offset)
            ->fetchAll();
    }
}
