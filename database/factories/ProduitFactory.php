<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProduitFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nom' => fake()->words(3, true),
            'sku' => strtoupper(fake()->unique()->bothify('???-###')),
            'description' => fake()->sentence(),
            'prix_unitaire' => fake()->randomFloat(2, 5, 900),
            'quantite_stock' => fake()->numberBetween(0, 50),
            'seuil_alerte' => fake()->numberBetween(2, 10),
        ];
    }

    /** Génère volontairement un produit en alerte de stock, pratique pour tester le badge visuel */
    public function enAlerte(): static
    {
        return $this->state(fn () => [
            'quantite_stock' => 1,
            'seuil_alerte' => 5,
        ]);
    }
}
