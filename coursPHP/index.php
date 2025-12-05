<?php

// --- 1. Déclaration des variables ---
$nom = 'Amer'; // Chaîne de caractères (string)
$prenom = "Nix";
$age = 25 ; // Entier
$is_student = true; // Booléen
$prix = 19.99; // Nombre décimal

//--- 1.1 Controle des variables ---
// La fonction var_dump() en PHP est utilisée pour afficher des informations détaillées sur une ou plusieurs variables.
//  Elle est particulièrement utile pour le débogage, car elle affiche le type et la valeur de la variable.
// var_dump($prenom);
// var_dump($prenom, $nom, $age, $is_student, $prix); 

// --- 2. Affichage de texte ---

echo '<h1>Bonjour, c\'est '.$prenom.' !</h1>'; // Utilisation de variables dans une chaîne
// (Mettre un "\" pour pouvoir taper un "'" et le différencier d'une quote, exemple "C'est" = "C\'est")

// // --- 3. Les constantes ---

define("PI", 3.14159); // Définition d'une constante
const SITE_NAME = "Mon Site "; // Définition avec const
echo "La valeur de PI est : " . PI ."</br>"; // Affiche: La valeur de PI est : 3.14159
echo "Bienvenue sur  " . SITE_NAME; // Affiche: Bienvenue sur MonSite


// --- 4. Les conditions ---
if ($age >= 18) {
    echo "Vous êtes majeur. ";
} 
else {
    echo "Vous êtes mineur. ";
}

// --- 5. Les boucles ---
// Boucle for
for ($i = 1; $i <= 5; $i++) {
    echo "Iteration: $i </br>";
}

// --- 6. Les tableaux ---

$fruits = ["Pomme", "Banane", "Orange"];

// var_dump($fruits);

echo $fruits[1]; // Affiche "Banane"

// Parcourir un tableau
foreach ($fruits as $fruit) {
    echo "<ul>$fruit </ul>";
}

// Les tableaux associatif:
$fruits = [
    "Pomme" => 1.20,   
    "Banane" => 0.80,  
    "Orange" => 1.00   
];
$user = [
    "id"=>10,
    "nom" =>"gertrude",
    "prenom"=> "plus"
];
 //var_dump($fruits);
 //var_dump($fruits["Pomme"]);

foreach ($fruits as $fruit => $prix) {
   echo "Le prix de $fruit est de $prix €<br>";
}

// // --- 7. Les fonctions ---

function sayHello($name) {
    return "Bonjour, $name!";
}
echo sayHello("alice");

// // --- 8. Les tableaux associatifs ---

$person = ["nom" => "Doe", "âge" => 30, "ville" => "Paris"];
echo $person["ville"]; // Affiche "Paris"

// --- 9. Inclusion de fichiers ---

// include("fichier.php"); // Inclure un fichier (ne plante pas en cas d'erreur)
// require("fichier.php"); // Inclure un fichier (plante en cas d'erreur) (A choisir)

// --- 10. La Concaténation en PHP ---

// En PHP, la concaténation est l’action de joindre plusieurs chaînes de caractères ensemble.
//  Pour cela, on utilise l’opérateur . (point).

echo "<br>Bonjour, je m'appelle " . $prenom . " " . $nom . " et j'ai " . ($age + 5) . " ans.";

?>
