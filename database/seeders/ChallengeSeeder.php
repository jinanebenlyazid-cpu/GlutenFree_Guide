<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChallengeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $challenges = [
            [
                'title' => 'Découverte à la Maison',
                'description' => 'Trouvez un produit naturellement sans gluten dans votre cuisine que vous n\'avez pas encore utilisé aujourd\'hui.',
                'icon' => 'fa-home',
                'points' => 15,
            ],
            [
                'title' => 'Lecture d\'Étiquette',
                'description' => 'Vérifiez les ingrédients d\'un produit transformé pour vous assurer qu\'il ne contient aucune trace de gluten cachée.',
                'icon' => 'fa-search',
                'points' => 10,
            ],
            [
                'title' => 'Chef Sans Gluten',
                'description' => 'Essayez une nouvelle recette simple sans gluten parmi notre collection aujourd\'hui.',
                'icon' => 'fa-utensils',
                'points' => 20,
            ],
            [
                'title' => 'Anti-Contamination',
                'description' => 'Nettoyez une surface de préparation pour garantir l\'absence de contamination croisée.',
                'icon' => 'fa-broom',
                'points' => 10,
            ],
            [
                'title' => 'Savoir Gluten-Free',
                'description' => 'Apprenez un nouveau fait sur la maladie cœliaque ou l\'intolérance au gluten sur notre page À propos.',
                'icon' => 'fa-book-open',
                'points' => 5,
            ],
            [
                'title' => 'Exploration Locale',
                'description' => 'Repérez un restaurant ou une boulangerie sans gluten sur notre carte interactive.',
                'icon' => 'fa-map-marker-alt',
                'points' => 15,
            ],
        ];

        foreach ($challenges as $challenge) {
            \App\Models\Challenge::create($challenge);
        }
    }
}
