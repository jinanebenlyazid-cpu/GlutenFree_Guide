<?php

$ar = json_decode(file_get_contents('lang/ar.json'), true);
$keys = [
    "Bon retour !",
    "Connectez-vous pour gérer vos favoris et partager des recettes.",
    "Se souvenir de moi",
    "Oublié ?",
    "Pas encore de compte ?",
    "Rejoignez-nous",
    "Créez votre compte pour sauvegarder vos lieux et recettes favoris.",
    "Confirmation",
    "Créer mon compte",
    "Déjà inscrit ?",
    "Sélectionnez votre ville",
    "votre@email.com",
    "Fès"
];

foreach ($keys as $k) {
    if (!isset($ar[$k])) {
        echo "MISSING: $k\n";
    } else {
        echo "OK: $k -> " . $ar[$k] . "\n";
    }
}
