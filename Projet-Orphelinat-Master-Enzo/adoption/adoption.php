<?php 
include '../config.php';
require_once base_path('components/header.php');
require_once base_path('db.php');

if(!isset($_SESSION['user_id'])) {
    header('location: ' . base_url('connexion/connexion.php'));
    exit;
}

$sql = "SELECT * FROM pokemon_gen1 ORDER BY nom ASC";
$stmt = $pdo->query($sql);
$pokemonsList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="carte-base rounded-4 p-4 text-white w-75 mx-auto my-4">
    <div class="w-50 mx-auto mb-3">
        <label for="typeSelect" class="form-label text-center d-block">Type</label>
        <select class="form-select input-custom" name="typeSelector" id="typeSelector">
            <option value="" disabled selected>Selectionner un Type</option>
            <option value="tous">Tous</option>
            <option value="feu">Feu</option>
            <option value="eau">Eau</option>
            <option value="normal">Normal</option>
            <option value="vol">Vol</option>
            <option value="spectre">Spectre</option>
            <option value="poison">Poison</option>
            <option value="plante">Plante</option>
            <option value="glace">Glace</option>
            <option value="electrik">Electrik</option>
            <option value="insecte">Insecte</option>
            <option value="fée">Fée</option>
            <option value="psy">Psy</option>
            <option value="combat">Combat</option>
            <option value="acier">Acier</option>
            <option value="roche">Roche</option>
            <option value="dragon">Dragon</option>
        </select>
        <label for="graphSelect" class="form-label text-center d-block">Graphique</label>
        <select class="form-select input-custom" name="graphSelector" id="graphSelector">
            <option value="" disabled selected>Selectionner un Graphique</option>
            <option value="bar">Bar</option>
            <option value="doughnut">Donut</option>
            <option value="pie">Tarte</option>
            <option value="line">Ligne</option>
            <option value="polarArea">Zone Polaire</option>
            <option value="radar">Radar</option>
        </select>
    </div>
    <div class="bg-white rounded p-3 mx-auto d-flex justify-content-center align-items-center canva-propotion">
        <canvas id="adoptionChart"></canvas>
    </div>
</div>
<?php
if (!empty($_SESSION['role']) && $_SESSION['role'] === "admin") {
    echo '
    <form method="POST" action="' . base_url('adoption/insertPokemon.php') . '" id="adoption-form">
        <div class="carte-base rounded-4 p-4 d-flex flex-column align-items-center text-white w-75 mx-auto my-4">
            
            <div class="form-group w-75 mb-4 mt">
                <label for="nom" class="form-label text-center d-block">Nom du Pokémon</label>
                <select name="id" id="nomP" class="form-select input-custom" required>
                    <option value="" disabled selected>Sélectionner un Pokémon</option>';
                    
                    foreach ($pokemonsList as $poke) {
                        echo '<option value="' . htmlspecialchars($poke['id']) . '">' 
                            . htmlspecialchars($poke['nom']) . '</option>';
                    }
    echo '      </select>
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

            <div class="form-group w-75 mb-4 mt">
                <label for="type1" class="form-label text-center d-block">Type 1</label>
                <input type="text" name="type1" id="type1" class="form-control input-custom" readonly="readonly">
                <label for="type2" class="form-label text-center d-block">Type 2</label>
                <input type="text" name="type2" id="type2" class="form-control input-custom" readonly="readonly">
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
    ';
}
?>
    <div>
        <div class="carte-base rounded-4 p-4 text-white w-75 mx-auto my-4">
            <table class="table table-borderless text-white">
                <thead>
                    <tr>
                        <th scope="col" class="text-start">ID</th>
                        <th scope="col" class="text-start">Nom</th>
                        <th scope="col" class="text-start">Surnom</th>
                        <th scope="col" class="text-start">Type 1</th>
                        <th scope="col" class="text-start">Type 2</th>
                        <th scope="col" class="text-start">Taille</th>
                        <th scope="col" class="text-start">Poids</th>
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
                                echo "<td class='text-start'>" . htmlspecialchars($pokemon['id']) . "</td>";
                                echo "<td class='text-start'>" . htmlspecialchars($pokemon['nom']) . "</td>";
                                echo "<td class='text-start'>" . $pokemon['surnom'] . "</td>";
                                echo "<td class='text-start'>" . htmlspecialchars($pokemon['type1']) . "</td>";
                                echo "<td class='text-start'>" . htmlspecialchars($pokemon['type2'] ?? '') . "</td>";
                                echo "<td class='text-start'>" . htmlspecialchars($pokemon['taille']) . "cm" . "</td>";
                                echo "<td class='text-start'>" . htmlspecialchars($pokemon['poids']) . "kg" . "</td>";
                                echo "<td class='text-start'>" . htmlspecialchars($pokemon['niveau']) . "</td>";

                                if (!empty($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                                    echo '<td class="d-flex justify-content-around">' . 
                                        '<form method="POST" action="' . base_url('adoption/edit.php') . '" style="display:inline; margin:0;">
                                            <input type="hidden" name="id" value="' . $pokemon['id'] . '">
                                            <button type="submit" class="btn bg-success text-white">Modifier</button>
                                        </form>' . ' ' . 
                                        '<a class="btn btn-danger" href="' . base_url('adoption/delete.php?id=' . $pokemon['id']) . '">Supprimer</a>' . 
                                        '</td>';
                                } else {
                                    echo '<td></td>';   
                                }
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const graphSelector = document.getElementById('graphSelector');
const typeSelector = document.getElementById('typeSelector');
const ctx = document.getElementById('adoptionChart');


let myChart = null;
let chartType = 'bar';
let selectedType = 'tous';
let allPokemons = [];

const couleurs = [
      'rgba(255,99,132,0.5)','rgba(54,162,235,0.5)','rgba(255,206,86,0.5)',
      'rgba(75,192,192,0.5)','rgba(153,102,255,0.5)','rgba(255,159,64,0.5)',
      'rgba(255,140,0,0.5)','rgba(0,200,83,0.5)','rgba(220,20,60,0.5)','rgba(0,191,255,0.5)'
    ];

window.onload = function() {
  chartType = 'bar';
  fetch('statsGet.php')
    .then(response => response.json())
    .then(pokemons => {
     allPokemons = pokemons;
    chargerGraphique();
  });
};

graphSelector.addEventListener('change', () => {
  chartType = graphSelector.value;
  chargerGraphique();
});

typeSelector.addEventListener('change', () => {
    selectedType = typeSelector.value;
    chargerGraphique();

    fetch('filtrer.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'type=' + encodeURIComponent(selectedType)
    })
    .then(res => res.json())
    .then(data => {
        const tbody = document.getElementById('adoption-table-body');
        tbody.innerHTML = '';
        if (data.length > 0) {
            data.forEach(p => {
                const tr = document.createElement('tr');
                tr.classList.add('input-custom', 'border-bottom', 'mb-2', 'pb-2');
                tr.innerHTML = `
                    <td class="text-start">${p.id}</td>
                    <td class="text-start">${p.nom}</td>
                    <td class="text-start">${p.surnom || ''}</td>
                    <td class="text-start">${p.type1}</td>
                    <td class="text-start">${p.type2 || ''}</td>
                    <td class="text-start">${p.taille || ''}cm</td>
                    <td class="text-start">${p.poids || ''}kg</td>
                    <td class="text-start">${p.niveau || ''}</td>
                `;
                tbody.appendChild(tr);
            });
        } else {
            tbody.innerHTML = '<tr><td colspan="8" class="text-center">Aucun Pokémon disponible pour ce type</td></tr>';
        }
    })
    .catch(err => console.error(err));
});


function chargerGraphique() {
    if (myChart) myChart.destroy();

    let pokemonsFiltres = allPokemons;
    if (selectedType !== 'tous') {
        const typeLower = selectedType.toLowerCase();
        pokemonsFiltres = allPokemons.filter(p =>
            (p.type1 && p.type1.toLowerCase() === typeLower) ||
            (p.type2 && p.type2.toLowerCase() === typeLower)
        );
    }

    const typeCounts = {};

    pokemonsFiltres.forEach(pokemon => {
        if (pokemon.type1) {
            typeCounts[pokemon.type1] = (typeCounts[pokemon.type1] || 0) + 1;
        }
        if (pokemon.type2) {
            typeCounts[pokemon.type2] = (typeCounts[pokemon.type2] || 0) + 1;
        }
    });

    const typesOrdonnes = Object.keys(typeCounts).sort();
    const number = typesOrdonnes.map(type => typeCounts[type]);
    const title = selectedType === 'tous'
    ? 'Nombre de Pokémon par Type'
    : `Nombre de Pokémon par Type (filtrés par ${selectedType})`;

    myChart = new Chart(ctx, {
        type: chartType,
        data: {
            labels: typesOrdonnes,
            datasets: [{
                label: title,
                data: number,
                borderWidth: 1,
                backgroundColor: couleurs,
            }]
        },
    });
}
</script>

<?php require_once base_path('components/footer.php'); ?>