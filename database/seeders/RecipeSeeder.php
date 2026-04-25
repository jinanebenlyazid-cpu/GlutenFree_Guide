<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecipeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('recipes')->insert([
            [
                'name' => 'Pancakes Sans Gluten à la Banane',
                'image_url' => 'https://images.unsplash.com/photo-1598514982205-f36b96d1e8dd?auto=format&fit=crop&q=80&w=400',
                'ingredients' => json_encode(['2 bananes mûres', '2 œufs', '70g de farine de riz', '1 c.à.c de levure chimique sans gluten']),
                'steps' => json_encode(['Écraser les bananes.', 'Mélanger avec les œufs.', 'Ajouter la farine et la levure.', 'Cuire dans une poêle chaude 2 min par face.']),
                'prep_time' => 15,
                'difficulty' => 'facile',
                'likes' => 24,
                'user_id' => null,
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'name' => 'Pizza Express Sans Gluten',
                'image_url' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?auto=format&fit=crop&q=80&w=400',
                'ingredients' => json_encode(['200g de mix farine sans gluten', '120ml d\'eau tiède', '1 c.à.s d\'huile d\'olive', 'Sauce tomate', 'Fromage nature']),
                'steps' => json_encode(['Mélanger la farine, l\'eau et l\'huile pour former une pâte.', 'Étaler sur une plaque.', 'Garnir avec sauce et fromage.', 'Cuire à 220°C pendant 15 minutes.']),
                'prep_time' => 25,
                'difficulty' => 'moyen',
                'likes' => 45,
                'user_id' => null,
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'name' => 'Brownies Chocolat et Noix',
                'image_url' => 'https://images.unsplash.com/photo-1606313564200-e75d5e30476c?auto=format&fit=crop&q=80&w=400',
                'ingredients' => json_encode(['200g de chocolat noir', '100g de beurre', '150g de sucre', '3 œufs', '50g de farine d\'amande', 'Noix concassées']),
                'steps' => json_encode(['Fondre beurre et chocolat.', 'Fouetter œufs et sucre.', 'Mélanger le tout et ajouter farine + noix.', 'Cuire 20 min à 180°C.']),
                'prep_time' => 30,
                'difficulty' => 'moyen',
                'likes' => 18,
                'user_id' => null,
                'created_at' => now(), 'updated_at' => now()
            ]
        ]);
    }
}
