<?php

$en_auth = [
    "Bon retour !" => "Welcome back!",
    "Connectez-vous pour gérer vos favoris et partager des recettes." => "Log in to manage your favorites and share recipes.",
    "Se souvenir de moi" => "Remember me",
    "Oublié ?" => "Forgot?",
    "Pas encore de compte ?" => "Don't have an account?",
    "Rejoignez-nous" => "Join us",
    "Créez votre compte pour sauvegarder vos lieux et recettes favoris." => "Create your account to save your favorite locations and recipes.",
    "Confirmation" => "Confirm Password",
    "Créer mon compte" => "Create my account",
    "Déjà inscrit ?" => "Already registered?",
    "Sélectionnez votre ville" => "Select your city",
    "votre@email.com" => "your@email.com",
    "Fès" => "Fes"
];

$ar_auth = [
    "Bon retour !" => "مرحباً بعودتك!",
    "Connectez-vous pour gérer vos favoris et partager des recettes." => "سجل الدخول لإدارة مفضلاتك ومشاركة الوصفات.",
    "Se souvenir de moi" => "تذكرني",
    "Oublié ?" => "نسيت كلمة المرور؟",
    "Pas encore de compte ?" => "ليس لديك حساب؟",
    "Rejoignez-nous" => "انضم إلينا",
    "Créez votre compte pour sauvegarder vos lieux et recettes favoris." => "أنشئ حسابك لحفظ الأماكن والوصفات المفضلة لديك.",
    "Confirmation" => "تأكيد كلمة المرور",
    "Créer mon compte" => "إنشاء حسابي",
    "Déjà inscrit ?" => "مسجل بالفعل؟",
    "Sélectionnez votre ville" => "اختر مدينتك",
    "votre@email.com" => "your@email.com",
    "Fès" => "فاس"
];

$es_auth = [
    "Bon retour !" => "¡Bienvenido de nuevo!",
    "Connectez-vous pour gérer vos favoris et partager des recettes." => "Inicia sesión para gestionar tus favoritos y compartir recetas.",
    "Se souvenir de moi" => "Recordarme",
    "Oublié ?" => "¿Olvidaste tu contraseña?",
    "Pas encore de compte ?" => "¿No tienes cuenta?",
    "Rejoignez-nous" => "Únete a nosotros",
    "Créez votre compte pour sauvegarder vos lieux et recettes favoris." => "Crea tu cuenta para guardar tus lugares y recetas favoritos.",
    "Confirmation" => "Confirmar contraseña",
    "Créer mon compte" => "Crear mi cuenta",
    "Déjà inscrit ?" => "¿Ya estás registrado?",
    "Sélectionnez votre ville" => "Selecciona tu ciudad",
    "votre@email.com" => "tu@email.com",
    "Fès" => "Fez"
];

function updateLang($lang, $add) {
    $file = "lang/{$lang}.json";
    if (!file_exists($file)) return;
    $json = json_decode(file_get_contents($file), true);
    $merged = array_merge($json, $add);
    file_put_contents($file, json_encode($merged, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

updateLang('en', $en_auth);
updateLang('ar', $ar_auth);
updateLang('es', $es_auth);
