<?php
// 1. Inclure le fichier de connexion à la base de données
include 'db.php'; 

// Le code de traitement doit être avant l'affichage HTML
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si tous les champs sont remplis
    if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirmPassword'])) {
        
        $email = htmlspecialchars($_POST['email']);
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
                INSERT INTO users (login, email, password_hash, role, created_at) 
                VALUES (:login, :email, :password_hash, :role, :created_at)
                ");
    
                $stmt->execute([
                    'login' => $email, // Utiliser l'email comme login par défaut
                    'email' => $email,
                    'password_hash' => $hashed_password, // Changement ici
                    'role' => $role_par_defaut,
                    'created_at' => $date_creation
                ]);

                $message_succes = "Inscription réussie ! Vous pouvez maintenant vous connecter.";

            } catch (PDOException $e) {
                // Gérer les erreurs, par exemple, si l'email existe déjà
                if ($e->getCode() == 23000) { // Code d'erreur pour les violations de contrainte (UNIQUE)
                    $erreur = "Cet email est déjà utilisé.";
                } else {
                    $erreur = "Une erreur est survenue lors de l'inscription.";
                    // Loguer $e->getMessage() pour le débogage, mais ne pas l'afficher à l'utilisateur final.
                }
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
    <title>Inscription</title>
</head>
<body>
    
    <form class="formInscription" action="inscription" method="post">
        <h1>Inscription</h1>

        <label for="email">Adresse Email</label>
        <input class="formInput" type="email" name="email" id="email" required>
        <br>
        <br>

        <label for="password">Mot de passe</label>
        <input class="formInput" type="password" name="password" id="password" required>
        <br>
        <br>

        <label for="confirmPassword">Confirmez le Mot de passe</label>
        <input class="formInput" type="password" name="confirmPassword" id="confirmPassword" required>
        <br>
        <br>

        <br>
        <button type="submit" id="btn">Inscription</button>
    </form>

</body>
</html>