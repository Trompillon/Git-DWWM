<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>ECF CRUD</title>
</head>
<body>

    <main>

        <h2>Formulaire d'inscription</h2>

        <form action="../Controllers/create_ctrl.php" id="form" method="post">
            <input type="text" name="pseudo" placeholder="Pseudonyme" required>
            <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
            <input type="text" name="description" placeholder="Description" required>
            <input type="submit" value="Ajouter">
        </form>

    </main>
    
</body>
</html>