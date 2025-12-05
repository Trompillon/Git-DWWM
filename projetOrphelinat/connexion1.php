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

<form class="formConnexion" action="connexion" method="post">
    <h1>Connexion</h1>

    <label for="email">Email</label>
    <input class="formInput" type="email" name="email" id="email" required>
    <br>
    <br>

    <label for="password">Mot de passe</label>
    <input class="formInput" type="password" name="password" id="password" required>
    <br>
    <br>

    <br>
    <button type="submit" id="btn">Connexion</button>

    <p>
        <a href="XXX">Vous n'êtes pas inscrit?</a>
    </p>
</form>

</body>
</html>