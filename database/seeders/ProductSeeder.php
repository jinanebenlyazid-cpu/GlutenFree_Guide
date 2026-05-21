<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = 'C:/Users/DELL 7400/Documents/projet/projet_sansgluten/Produit.json';
        
        if (File::exists($jsonPath)) {
            // Empty the table first to insert the fresh batch from JSON
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('products')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            $json = File::get($jsonPath);
            $productsRaw = json_decode($json, true);
            
            $products = [];
            foreach ($productsRaw as $item) {
                $imageUrl = isset($item['image']) && !empty($item['image']) ? $item['image'] : 'images/default-product.jpg';
                
                $products[] = [
                    'name' => $item['nom'] ?? 'Produit Inconnu',
                    'description' => (isset($item['marque']) ? $item['marque'] . ' - ' : '') . ($item['description'] ?? ''),
                    'price' => isset($item['prix']) && is_numeric($item['prix']) ? (float) $item['prix'] : null,
                    'city' => 'Maroc', // Required by migration
                    'ingredients' => isset($item['ingredients']) && $item['ingredients'] !== "" ? $item['ingredients'] : null,
                    'category' => $item['categorie'] ?? 'Divers',
                    'image_url' => $imageUrl,
                    'is_certified' => true,
                    'user_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            
            // Insert in chunks of 100 to avoid query limits on massive arrays
            $chunks = array_chunk($products, 100);
            foreach ($chunks as $chunk) {
                DB::table('products')->insert($chunk);
            }
        }
    }
}
