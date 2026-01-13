<?php

session_start();
$token = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;


require 'db.php';

    $sql = "SELECT * FROM users";
    $stmt = $pdo->query($sql);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Parc Auto</title>
</head>
<body>

    <h1>Gestion parc automobile Garage Chaubert</h1>

    <main>

        <h2>Formulaire d'inscription du véhicule</h2>

        <form action="insert.php" id="form" method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
            <input type="text" name="owner_lastname" placeholder="Nom du propriétaire" required>
            <input type="text" name="owner_firstname" placeholder="Prénom du propriétaire" required>
            <input type="text" name="car_brand" placeholder="Marque du véhicule" required>
            <input type="text" name="car_model" placeholder="Modèle du véhicule" required>
            <input type="text" name="car_registration" placeholder="Immatriculation du véhicule" required>
            <input type="date" name="car_year" placeholder="Année de fabrication du véhicule" required>
            <input type="text" name="car_color" placeholder="Couleur du véhicule" required>
            <input type="submit" value="Ajouter">
        </form>

    </main>

    <section>

        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nom du propriétaire</th>
                    <th>Prénom du propriétaire</th>
                    <th>Marque du véhicule</th>
                    <th>Modèle du véhicule</th>
                    <th>Immatriculation du véhicule</th>
                    <th>Année de fabrication du véhicule</th>
                    <th>Couleur du véhicule</th>
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
                <td><?= htmlspecialchars($user['carownerlastname']) ?></td> 
                <td><?= htmlspecialchars($user['carownerfirstname']) ?></td>
                <td><?= htmlspecialchars($user['carbrand']) ?></td>
                <td><?= htmlspecialchars($user['carmodel']) ?></td>
                <td><?= htmlspecialchars($user['carregistration']) ?></td>
                <td><?= ($user['caryear']) ?></td>
                <td><?= htmlspecialchars($user['carcolor']) ?></td>    
                
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
                    <td colspan="9">Aucun utilisateur trouvé.</td>
                </tr>

                <?php
            }
                ?>

            </tbody>
            
        </table>

    </section>
    
</body>
</html>