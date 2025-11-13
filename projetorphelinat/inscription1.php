<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Header</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li>Accueil</li>
                <div class = "centre">
                <li>Adopter</li>
                <li>Combattre</li>
                <li>Recycler</li>
                </div>
                <li class = "deco">Déconnexion</li>
            </ul>
        </nav>
    </header>

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