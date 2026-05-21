<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            [
                "nom" => "Celiacity",
                "type" => "Magasin Sans Gluten",
                "adresse" => "4ème étage, 403 Boulevard Dammam, Casablanca 20150, Maroc",
                "ville" => "Casablanca",
                "description" => "Magasin spécialisé dans les produits sans gluten.",
                "telephone" => "",
                "latitude" => 33.5731,
                "longitude" => -7.5898
            ],
            [
                "nom" => "Diet Ibn Batouta (Gluten Free)",
                "type" => "Magasin Sans Gluten",
                "adresse" => "71 Rue Ibn Batouta, Casablanca 20250, Maroc",
                "ville" => "Casablanca",
                "description" => "Épicerie proposant des produits 100% sans gluten.",
                "telephone" => "0661905735",
                "latitude" => 33.5731,
                "longitude" => -7.5898
            ],
            [
                "nom" => "Sans Gluten Marrakech",
                "type" => "Magasin Sans Gluten",
                "adresse" => "Av. Achjar, Marrakech 40000, Maroc",
                "ville" => "Marrakech",
                "description" => "Magasin spécialisé dans les produits sans gluten .",
                "telephone" => "",
                "latitude" => 31.6295,
                "longitude" => -7.9811
            ],
            [
                "nom" => "All Gluten Free",
                "type" => "Magasin Sans Gluten",
                "adresse" => "Près de café la façade, Ain Chkef, Fès 30050, Maroc",
                "ville" => "Fès",
                "description" => "Magasin dédié aux produits sans gluten .",
                "telephone" => "",
                "latitude" => 34.0331,
                "longitude" => -5.0003
            ],
            [
                "nom" => "Chahid Sans Gluten Tanger",
                "type" => "Magasin Sans Gluten",
                "adresse" => "Tanger, Maroc",
                "ville" => "Tanger",
                "description" => "Boutique proposant des produits sans gluten .",
                "telephone" => "0667989314",
                "latitude" => 35.7595,
                "longitude" => -5.83395
            ],
            [
                "nom" => "Sans Gluten Nador",
                "type" => "Magasin Sans Gluten",
                "adresse" => "189 Rue Abdelkhalek Torres, Nador 62000, Maroc",
                "ville" => "Nador",
                "description" => "Magasin spécialisé en produits sans gluten.",
                "telephone" => "",
                "latitude" => 35.1667,
                "longitude" => -2.9333
            ],
            [
                "nom" => "Marjane Morocco Mall",
                "type" => "Hypermarché",
                "adresse" => "Morocco Mall, Boulevard de l'Océan, Casablanca",
                "ville" => "Casablanca",
                "description" => "Hypermarché avec rayon produits sans gluten.",
                "telephone" => "",
                "latitude" => 33.5800,
                "longitude" => -7.6930
            ],
            [
                "nom" => "Marjane Marrakech",
                "type" => "Hypermarché",
                "adresse" => "Marrakech, N9, Maroc",
                "ville" => "Marrakech",
                "description" => "Hypermarché proposant des produits sans gluten.",
                "telephone" => "",
                "latitude" => 31.6295,
                "longitude" => -7.9811
            ],
            [
                "nom" => "Marjane Fès I (Agdal)",
                "type" => "Hypermarché",
                "adresse" => "Fès, Maroc",
                "ville" => "Fès",
                "description" => "Grand magasin avec un rayon alimentaire incluant du sans gluten.",
                "telephone" => "",
                "latitude" => 34.0331,
                "longitude" => -5.0003
            ],
            [
                "nom" => "Marjane Fès Saiss",
                "type" => "Hypermarché",
                "adresse" => "Ouled Tayeb, Fès 30023, Maroc",
                "ville" => "Fès",
                "description" => "Hypermarché avec produits sans gluten.",
                "telephone" => "",
                "latitude" => 34.0331,
                "longitude" => -5.0003
            ],
            [
                "nom" => "Marjane Market Fès Salam",
                "type" => "Supermarché",
                "adresse" => "Ave Allal Ben Abdellah, Fès 30050, Maroc",
                "ville" => "Fès",
                "description" => "Supermarché avec section sans gluten.",
                "telephone" => "",
                "latitude" => 34.0331,
                "longitude" => -5.0003
            ],
            [
                "nom" => "Marjane Market La Fontaine",
                "type" => "Supermarché",
                "adresse" => "Rue Ahmed Chaouki, Fès 30050, Maroc",
                "ville" => "Fès",
                "description" => "Rayon alimentaire incluant produits sans gluten.",
                "telephone" => "",
                "latitude" => 34.0331,
                "longitude" => -5.0003
            ],
            [
                "nom" => "Marjane Tanger",
                "type" => "Hypermarché",
                "adresse" => "Route de Rabat, Tanger 90060, Maroc",
                "ville" => "Tanger",
                "description" => "Hypermarché avec produits sans gluten.",
                "telephone" => "",
                "latitude" => 35.7595,
                "longitude" => -5.83395
            ],
            [
                "nom" => "Marjane (Alternative Tanger)",
                "type" => "Hypermarché",
                "adresse" => "Route de Rabat, Tanger, Maroc",
                "ville" => "Tanger",
                "description" => "Deuxième implantation Marjane sur la même route.",
                "telephone" => "",
                "latitude" => 35.7595,
                "longitude" => -5.83395
            ],
            [
                "nom" => "Marjane Nador",
                "type" => "Hypermarché",
                "adresse" => "Nador 62000, Maroc",
                "ville" => "Nador",
                "description" => "Hypermarché avec options alimentaires sans gluten.",
                "telephone" => "",
                "latitude" => 35.1667,
                "longitude" => -2.9333
            ],
            [
                "nom" => "Carrefour Hypermarket Bouskoura",
                "type" => "Hypermarché",
                "adresse" => "1029 Route secondaire Bouskoura, Casablanca",
                "ville" => "Casablanca",
                "description" => "Hypermarché Carrefour avec rayon sans gluten.",
                "telephone" => "",
                "latitude" => 33.4487,
                "longitude" => -7.6486
            ],
            [
                "nom" => "Carrefour Gourmet Market",
                "type" => "Supermarché",
                "adresse" => "Boulevard Abdelatif & Av. Ahmed Charci, Casablanca",
                "ville" => "Casablanca",
                "description" => "Supermarché haut de gamme avec produits sans gluten.",
                "telephone" => "",
                "latitude" => 33.5731,
                "longitude" => -7.5898
            ],
            [
                "nom" => "Carrefour Market Aïn Sebaâ",
                "type" => "Supermarché",
                "adresse" => "Angle Route Casablanca/Rabat & Bd Mohamed Jamal Addorra, Casablanca",
                "ville" => "Casablanca",
                "description" => "Supermarché avec section sans gluten.",
                "telephone" => "",
                "latitude" => 33.6060,
                "longitude" => -7.5300
            ],
            [
                "nom" => "Carrefour Market Yacoub El Mansour",
                "type" => "Supermarché",
                "adresse" => "156 Rue Soufiane Attouri & Bd Yacoub El Mansour, Casablanca",
                "ville" => "Casablanca",
                "description" => "Carrefour Market avec produits sans gluten.",
                "telephone" => "",
                "latitude" => 33.5731,
                "longitude" => -7.5898
            ],
            [
                "nom" => "Carrefour Market Résidence Zahra",
                "type" => "Supermarché",
                "adresse" => "171 Bd de la Résistance, Casablanca",
                "ville" => "Casablanca",
                "description" => "Supermarché proposant divers produits sans gluten.",
                "telephone" => "",
                "latitude" => 33.5731,
                "longitude" => -7.5898
            ],
            [
                "nom" => "Carrefour Market Ville Verte",
                "type" => "Supermarché",
                "adresse" => "Ville Verte, Casablanca",
                "ville" => "Casablanca",
                "description" => "Carrefour Market avec rayon alimentaire sans gluten.",
                "telephone" => "",
                "latitude" => 33.5220,
                "longitude" => -7.5900
            ],
            [
                "nom" => "Carrefour Market Andalouss / Bouskoura",
                "type" => "Supermarché",
                "adresse" => "Projet Andalouss / Ville Verte — Bouskoura, Casablanca",
                "ville" => "Casablanca",
                "description" => "Supermarché avec disponibilités sans gluten.",
                "telephone" => "",
                "latitude" => 33.5220,
                "longitude" => -7.5900
            ]
        ];

        foreach($locations as $lieu) {
            DB::table('locations')->insert([
                'name' => $lieu['nom'],
                'type' => $lieu['type'],
                'address' => $lieu['adresse'],
                'city' => $lieu['ville'],
                'latitude' => $lieu['latitude'],
                'longitude' => $lieu['longitude'],
                'description' => $lieu['description'] . (!empty($lieu['telephone']) ? "\nTél: " . $lieu['telephone'] : ""),
                'user_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
