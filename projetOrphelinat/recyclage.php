<?php

require 'db.php';

//Requête préparée pour éviter les injections SQL
    $sql = "SELECT * FROM owned_pokemon";
    $stmt = $pdo->query($sql);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Recyclerie</title>
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

    <div class=entete>
        <p>Félicitations ! Votre Pokémon a atteint son potentiel maximal, ou peut-être qu'il est juste devenu trop faible et coûteux en soins. Quoi qu'il en soit, sa mission est terminée. Notre ferme d'entraînement est équipée d'une section 'Recyclage de Carcasse et Produits Dérivés' dernier cri.</p>
    </div>

    <br>
    <br>

    <div class="mx-auto">
        <table class="cdm">
            <thead>
                <tr class="head">
                  <th scope="col">#</th>
                  <th scope="col">Nom</th>
                  <th scope="col">Surnom</th>
                  <th scope="col">Type 1</th>
                  <th scope="col">Type 2</th>
                  <th scope="col">Niveau</th>
                  <th scope="col">Taille</th>
                  <th scope="col">Poids</th>
                  <th scope="col">Objet équipé</th>
                  <th scope="col">Owned By</th>
                  <th scope="col">Recyclez</th>
                </tr>
          </thead>
            <tbody>

            <?php
                if (!empty($users)) {
                foreach($users as $owned_pokemon){
            ?>

                <tr>
                    <th scope="row"><?= htmlspecialchars($owned_pokemon['id']) ?></th>
                    <td><?= htmlspecialchars($owned_pokemon['nom']) ?></td>
                    <td><?= htmlspecialchars($owned_pokemon['surnom']) ?></td>
                    <td><?= htmlspecialchars($owned_pokemon['type1']) ?></td>
                    <td><?= htmlspecialchars($owned_pokemon['type2']) ?></td>
                    <td><?= htmlspecialchars($owned_pokemon['niveau']) ?></td>
                    <td><?= htmlspecialchars($owned_pokemon['taille']) ?></td>
                    <td><?= htmlspecialchars($owned_pokemon['poids']) ?></td>
                    <td><?= htmlspecialchars($owned_pokemon['objet_equiper']) ?></td>
                    <td><?= htmlspecialchars($owned_pokemon['ownedBy']) ?></td>
                    <td><button class="btn btn-danger btn-sm"
                    onclick="if(confirm('Êtes-vous sûr de vouloir recycler ce pokemon ?')) { window.location.href='delete.php?id=<?= htmlspecialchars($owned_pokemon['id']) ?>'; }">    
                    Recycler</button></td> </tr>
                </tr>

            <?php
            }

                } else {
            // Affichage d'un message si aucun utilisateur n'est trouvé
            ?>

                <tr>
                    <td colspan="11">Aucun pokemon trouvé.</td>
                </tr>

            <?php
    }
        ?>

            </tbody>
        </table>
    </div>

</body>
</html>