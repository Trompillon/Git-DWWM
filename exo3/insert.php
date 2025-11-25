<?php
require 'db.php';

//Vérifie que le formulaire a bien été soumis via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

// On vérifie que tous les champs attendus existent ET ne sont pas vides
if (isset($_POST['number']) && isset($_POST['firstname']) && isset($_POST['lastname'])) {
    //On sécurise les données reçues
    $number = ($_POST['number']);
    $firstname = ($_POST['firstname']);
    $lastname = ($_POST['lastname']);


    $syllablesP = ["ba", "te", "ku", "rin", "lo", "sha", "mi", "dre", "po", "san", "vu", "ne", "kra", "to", "li", "pen", "sho", "gru", "fa", "zi", "mer", "ta", "plo", "ki", "ran", "chu", "se", "bri", "mo", "ga", "tri", "ven", "yo", "pra", "lu", "chan", "dif", "so", "vip", "re", "blu", "tet", "gar", "si", "ko", "flan", "dru", "pe", "jol"];
    $syllablesN = ["ra", "lin", "dor", "ven", "mar", "til", "sha", "kor", "bel", "ris", "tan", "mor", "yel", "dra", "fen", "sol", "gar", "nim", "vor", "kal", "ser", "thul", "bar", "in", "os", "mir", "kan", "del", "ros", "var", "tol", "sha", "quin", "dur", "pel", "yon", "sur", "ehl", "ran", "gal", "fir", "lom", "sar", "thek", "vol", "min", "ruk", "dar", "wen"];


    for ($i = 0; $i < $number; $i++) {

        $prenom = "";
        for ($a=0; $a < $firstname; $a++) {
            $index = array_rand($syllablesP);
            $syllableP = $syllablesP[$index];
            $prenom .= $syllableP;
        }

        $nom = "";
        for ($b=0; $b < $lastname; $b++) {
            $index = array_rand($syllablesN);
            $syllableN = $syllablesN[$index];
            $nom .= $syllableN;
        }
        // echo "$prenom $nom <br> ";

        

        try {
            $stmt = $pdo->prepare("INSERT INTO listnames (firstname, lastname) VALUES (?, ?)");
            $stmt->execute([$prenom, $nom]);

        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }

    }

    } else {
    // Si des champs sont manquants ou vides, on redirige avec un paramètre d'erreur
    header("Location: index.php?action=missing_fields"); // On ajoute le mot-clé "missing_fields"
    exit;
    }

} else {
// Si quelqu'un tente d'accéder au script sans POST
echo "<p style='color:red;'>Méthode non autorisée. </p>" ;
}

header("Location: index.php?action=added");
exit;


?>