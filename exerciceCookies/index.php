<?php

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action'];
    $nom = trim($_POST['name']);

    if ($action === 'create' && $nom !== '') {
        setcookie("name_cookie", $nom, time() + 3600);
        $_COOKIE["name_cookie"] = $nom;
        $message = "Cookie créé : " . htmlspecialchars($nom);
    }
    elseif ($action === 'see') {
        if (isset($_COOKIE["name_cookie"])) {
            $message = "Valeur du cookie : " . htmlspecialchars($_COOKIE["name_cookie"]);
        } else {
            $message = "Aucun cookie trouvé";
        }
    }
    elseif ($action === 'delete') {
        setcookie("name_cookie", "", time() - 3600);
        $message = "Cookie supprimé";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Exercice Cookies</title>
</head>
<body>

    <main>

        <h1>Exercice Cookies PHP et Javascript</h1>

        <div class="main-container">
            <p class="title"></p>
            <p>Cette section utilise PHP pour créer, lire et supprimer un cookie nommé nomUtilisateur</p>
            <p>Nom pour le cookie</p>

            <form method="POST">
                <input type="text" name="name" placeholder="Nom du cookie" required>
                <div class="buttons">
                    <button id="create" type="submit" name="action" value="create">
                        Créer le cookie
                    </button>
                    <button id="see" type="submit" name="action" value="see">
                        Afficher le cookie
                    </button>
                    <button id="delete" type="submit" name="action" value="delete">
                        Supprimer le cookie
                    </button>
                </div>
            </form>

    <?php

        if ($message !== '') {
            echo "<p>$message</p>";
        }

    ?>

        </div>

        <button id="switch">
            Basculer thème (Dark/Light)
        </button>


    </main>

    <script src="main.js"></script>

</body>
</html>