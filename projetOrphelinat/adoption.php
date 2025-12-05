<?php 
include 'header.php';
include 'db.php';

$sql = "SELECT * FROM pokemon_gen1 ORDER BY nom ASC";
$stmt = $pdo->query($sql);
$pokemonsList = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<body>
    <form method="POST" action="insertPokemon.php" id="adoption-form">
        <div class="carte-base rounded-4 p-4 d-flex flex-column align-items-center text-white w-75 mx-auto my-4">
            <div class="form-group w-75 mb-4 mt">
                <label for="nom" class="form-label text-center d-block">Nom du Pokémon</label>
                <select name="nom" id="nomP" class="form-select input-custom" required>
                    <option value="" disabled selected>Sélectionner un Pokémon</option>
                    <?php
                    // Todo: JS Recup la value du selecteur "nom", ajouté un EventListener à vérifier (OnChange)
                    // AJAX (FETCH) Recupéré l'info dans ma BDD format (JSON 'json_decode') avec ces infos, update le OnChange automatiquement avec les infos du input
                    foreach ($pokemonsList as $poke) {
                        echo '<option value="' . htmlspecialchars($poke['id']) . '">' 
                        . htmlspecialchars($poke['nom']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group w-75 mb-4">
                <label for="surnom" class="form-label text-center d-block">Surnom</label>
                <input type="text" name="surnom" id="surnom" class="form-control input-custom" minlength="3" maxlength="20" required>
            </div>
            <div class="form-group w-75 mb-4">
                <label for="taille" class="form-label text-center d-block">Taille</label>
                <input type="number" name="taille" id="taille" class="form-control input-custom" min="1" required>
            </div>
            <div class="form-group w-75 mb-4">
                <label for="poids" class="form-label text-center d-block">Poids</label>
                <input type="number" name="poids" id="poids" class="form-control input-custom" min="1" required>
            </div>
            <!--  TODO: EventListener du Selecteur,Listener = OnChange -->
            <div class="form-group w-75 mb-4 mt">
                <label for="type" class="form-label text-center d-block">Type 1</label>
                <input type="text" name="type1" id="type1" class="form-control input-custom" readonly="readonly">
                <label for="type" class="form-label text-center d-block">Type 2</label>
                <input type="text" name="type2" id="type2" class="form-control input-custom" readonly="readonly">
                <!-- <select name="type" id="type" class="form-select input-custom" required>
                    <option value="" disabled selected>Selectionner un type</option>
                    <option value="feu">Feu</option>
                    <option value="eau">Eau</option>
                    <option value="plante">Plante</option>
                    <option value="electrik">Electrik</option>
                    <option value="combat">Combat</option>
                    <option value="psy">Psy</option>
                    <option value="tenebres">Ténèbres</option>
                </select> -->
            </div>
            <div class="form-group w-75 mb-4">
                <label for="niveau" class="form-label text-center d-block">Niveau</label>
                <input type="number" name="niveau" id="niveau" class="form-control input-custom" min="1" max="100" required>
            </div>
            <div>
                <button type="submit" class="submit-btn btn w-100" id="adopt-btn">Adopter</button>
            </div>
        </div>
    </form>
    <div>
        <div class="carte-base rounded-4 p-4 text-white w-75 mx-auto my-4">
            <table class="table table-borderless text-white">
                <thead>
                    <tr>
                        <th scope="col" class="text-start">Nom</th>
                        <th scope="col" class="text-start">Surnom</th>
                        <th scope="col" class="text-start">Type</th>
                        <th scope="col" class="text-start">Niveau</th>
                    </tr>
                </thead>
                    <tbody id="adoption-table-body">
                    <?php
                    try {
                        $sql = "SELECT * FROM pokemons ORDER BY id DESC";
                        $stmt = $pdo->query($sql);
                        $pokemons = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if (count($pokemons) > 0) {
                            foreach ($pokemons as $pokemon) {
                                echo "<tr class='input-custom border-bottom mb-2 pb-2'>";
                                echo "<td class='text-start'>" . htmlspecialchars($pokemon['nom']) . "</td>";
                                echo "<td class='text-start'>" . htmlspecialchars($pokemon['surnom']) . "</td>";
                                echo "<td class='text-start'>" . htmlspecialchars($pokemon['type1']) . "</td>";
                                echo "<td class='text-start'>" . htmlspecialchars($pokemon['type2']) . "</td>";
                                echo "<td class='text-start'>" . htmlspecialchars($pokemon['niveau']) . "</td>";
                                echo '<td class="d-flex justify-content-around">' . 
                                    '<form method="POST" action="edit.php" style="display:inline; margin:0;">
                                        <input type="hidden" name="id" value="' . $pokemon['id'] . '">
                                        <button type="submit" class="btn bg-success text-white">Modifié</button>
                                    </form>' . ' ' . 
                                    '<a class="btn btn-danger" href="delete.php?id=' . $pokemon['id'] . '">Delete</a>' . 
                                    '</td>';

                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' class='text-center'>Aucun Pokémon disponible à l'adoption</td></tr>";
                        }
                    } catch (PDOException $e) {
                        echo "<tr><td colspan='4' class='text-center'>Erreur : " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
<?php include 'footer.php'; ?>

<script src="script.js"></script>

</body>