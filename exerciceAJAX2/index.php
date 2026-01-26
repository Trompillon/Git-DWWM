<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
    <title>Requête AJAX</title>
</head>
<body>

    <button id="btn">Charger les utilisateurs</button>
    <table id="table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Numéro de téléphone</th>
                <th>Email</th>
                <th>Adresse</th>
                <th>Photo de profil</th>
            </tr>
        </thead>

        <tbody></tbody>
            
    </table>

    <form action="getData.php" method="post">
        <label for="number">Nombre d'éléments à ajouter</label>
        <input type="number" name="number" id="number">

        <button type="submit" id="submit">Ajouter</button>
    </form>
    
</body>
</html>