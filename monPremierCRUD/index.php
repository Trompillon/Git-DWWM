<?php

require 'db.php';

    $sql = "SELECT * FROM User";
    $stmt = $pdo->query($sql);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Mon premier CRUD</title>
</head>
<body>
    
<?php


if (isset($_GET['action']) && $_GET['action'] === 'added') {
    
    $message = "Ajout réussi ! Vous êtes incroyablement fort ! La taille de votre pénis doit être gigantesque !";
    
    echo "<div style='background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 10px; margin-bottom: 15px; border-radius: 5px;'>";
    echo $message;
    echo "</div>";
}

?>

<h1>Formulaire d'inscription</h1>

<!-- Formulaire d'ajout -->
 
<form action="insert.php" method="POST">
    <input type="text" name="nom" placeholder="Nom" required>
    <input type="text" name="prenom" placeholder="Prénom" required>
    <input type="number" name="age" placeholder="Àge" required>
    <select name="sexe" required>
        <option value="">Sexe</option>
        <option value="Homme">Homme</option>
        <option value="Femme">Femme</option>
        <option value="Autre">Autre</option>
    </select>
    <input type="submit" value="Ajouter">
</form>
 
<!-- Tableau d'affichage -->

<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Àge</th>
            <th>Sexe</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>

<?php

    if (!empty($users)) {
        foreach($users as $user){
            ?>

            <tr>
                <td><?= htmlspecialchars($user['id']) ?></td>
                <td><?= htmlspecialchars($user['lastname']) ?></td> 
                <td><?= htmlspecialchars($user['firstname']) ?></td>
                <td><?= ($user['age']) ?></td>
                <td><?= ($user['sex']) ?></td>      
                
                <td>
                    <button class="boutonSupprimer"
                            onclick="if(confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) { window.location.href='delete.php?id=<?= htmlspecialchars($user['id']) ?>'; }">
                       Supprimer
                    </button>
                    <button class="boutonModifier" 
                            onclick="window.location.href='update.php?id=<?= htmlspecialchars($user['id']) ?>'">
                       Modifier
                    </button>
                </td>   
            </tr>

            <?php
        }
    } else {
        // Affichage d'un message si aucun utilisateur n'est trouvé
        ?>

        <tr>
            <td colspan="6">Aucun utilisateur trouvé.</td>
        </tr>

        <?php
    }
        ?>

    </tbody>

</table>

</body>
</html>