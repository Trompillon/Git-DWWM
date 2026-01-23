<?php
// 1. Inclure le fichier de connexion à la base de données
include 'db.php'; 

// Démarrer une session (crucial pour garder l'utilisateur connecté)
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (!empty($_POST['login']) && !empty($_POST['password'])) {
        
        $login = trim($_POST['login']);
        $password = $_POST['password'];

        // 2. Préparer la requête pour récupérer l'utilisateur 
        // On sélectionne toutes les colonnes, mais on va surtout utiliser 'password_hash'
        $stmt = $pdo->prepare("SELECT * FROM users WHERE login = :login");
        $stmt->execute(['login' => $login]);
        $user = $stmt->fetch();

        // 3. Vérifier si l'utilisateur existe
        if ($user) {
            // 4. Vérifier si le mot de passe correspond au hash stocké 
            if (password_verify($password, $user['password'])) { // Changement ici
        
                // Connexion réussie !
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_login'] = $user['login'];
               
                // Rediriger vers une page sécurisée (ex: profil.php)
                header('Location: index.php');
                exit;

            } else {
                $erreur = "Login ou mot de passe incorrect.";
            }
        } else {
            $erreur = "Login ou mot de passe incorrect.";
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
    <title>Connexion</title>
</head>
<body>

    <?php
    if (!empty($_GET['action']) && $_GET['action'] === 'added') {
        $message_succes = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
    }
    ?>

    <?php if (!empty($erreur)) : ?>
    <p class="error"><?= $erreur ?></p>
    <?php endif; ?>

    <?php if (!empty($message_succes)) : ?>
    <p class="success"><?= $message_succes ?></p>
    <?php endif; ?>


    <div class="form-wrapper">
        <form class="formConnexion" action="connexion.php" method="post">
            <h1>Connexion</h1>

            <label for="pseudo">Pseudo</label>
            <input class="formInput" type="text" name="login" id="login" required>
            <br>

            <label for="password">Mot de passe</label>
            <input class="formInput" type="password" name="password" id="password" required>
            <br>

            <br>
            <button type="submit" id="btn">Connexion</button>

            <p>
                <a href="inscription.php">Vous n'êtes pas inscrit?</a>
            </p>
        </form>
    </div>
    
</body>
</html>