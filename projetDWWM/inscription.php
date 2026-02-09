<?php
// 1. Inclure le fichier de connexion à la base de données
include 'db.php'; 

// Le code de traitement doit être avant l'affichage HTML
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si tous les champs sont remplis
    if (!empty($_POST['login']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirmPassword'])) {
        
        $login = trim($_POST['login']);
        $email = trim($_POST['email']);
        $password = $_POST['password']; // Mot de passe non haché
        $confirmPassword = $_POST['confirmPassword'];

        // 2. Vérifier que les mots de passe correspondent
        if ($password !== $confirmPassword) {
            $erreur = "Les mots de passe ne correspondent pas.";
        } else {
            
            // 3. Hacher le mot de passe (essentiel pour la sécurité)
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $date_creation = date('Y-m-d H:i:s'); // Date/heure actuelle

            try {
                // 4. Préparer et exécuter la requête d'insertion (CORRIGÉE)
                $stmt = $pdo->prepare("
                INSERT INTO user (login, email, password, created_at) 
                VALUES (:login, :email, :password, :created_at)
                ");
    
                $stmt->execute([
                    'login' => $login,
                    'email' => $email,
                    'password' => $hashed_password, // Changement ici
                    'created_at' => $date_creation
                ]);

                header('Location: connexion.php?action=added');
                exit;

            } catch (PDOException $e) {
                die($e->getMessage());
                // Gérer les erreurs, par exemple, si l'email existe déjà
                // if ($e->getCode() == 23000) { // Code d'erreur pour les violations de contrainte (UNIQUE)
                //     $erreur = "Cet email est déjà utilisé.";
                // } else {
                //     $erreur = "Une erreur est survenue lors de l'inscription.";
                //     // Loguer $e->getMessage() pour le débogage, mais ne pas l'afficher à l'utilisateur final.
                // }
            }
        }
    } else {
        $erreur = "Veuillez remplir tous les champs.";
    }
}
// Fin du code de traitement PHP
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Inscription</title>
</head>
<body>

    <?php if (!empty($erreur)) : ?>
    <p class="error"><?= $erreur ?></p>
    <?php endif; ?>

    
    <div class="form-wrapper">
        <form class="formInscription" action="inscription.php" method="POST">
            <h1>Inscription</h1>

            <label for="pseudo">Pseudo</label>
            <input class="formInput" type="text" name="login" id="login" required>
            <br>

            <label for="email">Adresse Email</label>
            <input class="formInput" type="email" name="email" id="email" required>
            <br>

            <label for="password">Mot de passe</label>
            <input class="formInput" type="password" name="password" id="password" required>
            <br>

            <label for="confirmPassword">Confirmez le Mot de passe</label>
            <input class="formInput" type="password" name="confirmPassword" id="confirmPassword" required>
            <br>

            <br>
            <button type="submit" id="btn">Inscription</button>
        </form>
    </div>

</body>
</html>