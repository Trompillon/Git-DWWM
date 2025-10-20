<?php

require 'db.php';

// On vérifie que le formulaire a été soumis
if (isset($_GET['valider']) && isset($_GET['recherche'])) {
    
    $recherche = $_GET['recherche'];
    
    // IMPORTANT : On ne lance la requête que si le champ n'est pas vide (pour la performance)
    if (trim($recherche) !== '') {
        
        // Étape 1 : Préparation de la recherche avec jokers %
        $searchTerm = "%" . $recherche . "%";
        
        // Étape 2 : Définition de la Requête SQL
        $sql = "SELECT ville_nom, ville_code_postal FROM villes_france_free 
                WHERE ville_nom LIKE :motcle OR ville_code_postal LIKE :motcle";
        
        // Étape 3 : Préparation, Exécution et Récupération (La communication sécurisée)
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':motcle' => $searchTerm]);
        $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Moteur de recherche Villes de france</title>
</head>
<body>

<h1>Faites votre recherche</h1>

<form name="form" method="GET">
    <input type="text" name="recherche" placeholder="recherche" value="<?= htmlspecialchars($recherche) ?>">
    <input type="submit" name="valider" value="rechercher">
</form>

<hr>

<?php 
// On affiche seulement si l'utilisateur a cliqué sur le bouton 'valider'
if (isset($_GET['valider'])) { 
    
    // Si le tableau $resultats contient des lignes
    if (count($resultats) > 0) {
        
        echo "<h2>Résultats trouvés (" . count($resultats) . ") :</h2>";
        echo "<ul>";
        
        // LA BOUCLE : Pour chaque ligne...
        foreach ($resultats as $ville) {
            
            // ATTENTION : REMPLACEZ CES CLÉS ENCORE UNE FOIS
            echo "<li><strong>" . htmlspecialchars($ville['ville_nom']) . "</strong> - Code Postal : " . htmlspecialchars($ville['ville_code_postal']) . "</li>";
            
        } 
        echo "</ul>";
        
    } else {
        // Cas : 0 résultat trouvé.
        echo "<p> Aucun résultat trouvé pour : <strong>" . htmlspecialchars($recherche) . "</strong>.</p>";
    }
}
?>

</body>
</html>