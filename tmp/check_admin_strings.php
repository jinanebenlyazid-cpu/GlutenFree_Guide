<?php

$required = [
    'Gérer les Produits', 'Gérer les Recettes', 'Recettes en attente', 'Lieux en attente',
    'Total Produits', 'Recettes Refusées', 'Approuver', 'Refuser', 'Aucune recette en attente',
    'Aucun lieu en attente', 'Gestion des Produits', 'Ajouter un produit', 'Produit',
    'Catégorie', 'Prix', 'Ville', 'Certifié', 'Actions', 'Modifier', 'Supprimer',
    'Êtes-vous sûr de vouloir supprimer ce produit ?', 'Aucun produit trouvé.',
    'Ajouter un Produit', 'Créez un nouveau produit pour le catalogue.', 'Nom du produit',
    'Prix (DH)', 'Ville / Disponibilité', 'Ex: Casablanca, National...', 'Certifié Sans Gluten',
    'URL de l\'image', 'Enregistrer le produit', 'Modifier le Produit',
    'Mettez à jour les informations du produit.', 'Mettre à jour le produit', 'Annuler',
    'Gestion des Recettes', 'Recette', 'Auteur', 'Temps', 'Difficulté', 'Status', 'Date',
    'Approuvée', 'En attente', 'Refusée', 'Utilisateur anonyme', 'min',
    'Supprimer définitivement cette recette ?', 'Aucune recette trouvée.', 'Modifier la Recette',
    'Mise à jour d\'une recette soumise par la communauté.', 'Nom de la recette',
    'Temps (min)', 'Statut', 'Ingrédients', 'Étapes', 'Ajouter un ingrédient',
    'Ajouter une étape', 'Enregistrer les modifications', 'Retour à la liste', 'Oui', 'Non',
    'Tableau de Bord', 'Dashboard', 'Admin', 'Administration - Guide Gluten-Free', 'Panel Administrateur',
    'Gérez les recettes, produits et lieux du site.', 'Par', 'Utilisateur'
];

$langs = ['en', 'ar', 'es'];
$missing_global = [];

foreach ($langs as $lang) {
    $file = "lang/{$lang}.json";
    if (!file_exists($file)) continue;
    
    $json = json_decode(file_get_contents($file), true);
    if ($json === null) continue;
    
    foreach ($required as $r) {
        if (!isset($json[$r])) {
            $missing_global[$lang][] = $r;
        }
    }
}

echo json_encode($missing_global, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
