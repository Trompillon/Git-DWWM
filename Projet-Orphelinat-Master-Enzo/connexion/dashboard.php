<?php 
require_once __DIR__ . '/../config.php';
require_once base_path('components/header.php');
require_once base_path('db.php');

if(!isset($_SESSION['user_id'])) {
    header('location: ' . base_url('connexion/connexion.php'));
    exit;
}
?>

<div class="container-fluid">
    <div class="row justify-content-center align-items-center form-container">
        <div class="col-11 col-sm-8 col-md-6 col-lg-4">
            <div class="bg-white p-4 p-md-5 shadow-sm">
                <h1 class="text-center mb-4 fw-normal fs-2">Dashboard</h1>
                <?php 
                    $sql = "SELECT * FROM owned_pokemon WHERE ownedby = " . $_SESSION['user_id'];
                    $stmt = $pdo->query($sql);
                    $ownedPokemon = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    echo "<p><strong>Nombre de Pokemon:</strong> " . htmlspecialchars(count($ownedPokemon)) . "</p>";
                ?>
                <select name="ownedPokemon" id="ownedPokemon" class="form-select input-custom" required>
                    <option value="" disabled selected>Selectionner un Pokémon</option>
                    <?php
                    foreach ($ownedPokemon as $poke) {
                        echo '<option value="' . htmlspecialchars($poke['pokedex_id']) . '" data-is-shiny="' . htmlspecialchars($poke['is_shiny']) . '">'
                            . htmlspecialchars($poke['nom']) .
                        '</option>';
                    }
                    ?>
                </select>
                <div id="pokemon-details" class="mt-4">
                    <img id="pokemon-image" src="" alt="" style="max-width: 200px; display:block; margin:auto;">
                </div>

                <form action="<?= base_url('connexion/deconnexion.php') ?>" method="post">
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn text-white py-3 fs-5 btn-custom">Deconnexion</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
const pokemonInfo = document.getElementById('pokemon-details');
const selectPokemon = document.getElementById('ownedPokemon');

selectPokemon.addEventListener('change', () => {
    let pokemonId = selectPokemon.value;

    const selectedOption = selectPokemon.options[selectPokemon.selectedIndex];
    const isShiny = selectedOption.getAttribute('data-is-shiny') === '1';

    getApiImage(pokemonId, isShiny);
});

function getApiImage(pokemonId, isShiny) {
    fetch(`https://tyradex.vercel.app/api/v1/pokemon/${pokemonId}`)
        .then(response => response.json())
        .then(data => {
            const spriteUrl = isShiny ? data.sprites.shiny : data.sprites.regular;

            pokemonInfo.innerHTML = `
                <img src="${spriteUrl}" alt="${data.name.fr}" style="max-width:200px;display:block;margin:auto;">
                <h3>${data.name.fr}</h3>
                <p>Type : ${data.types.map(t => t.name).join(', ')}</p>
            `;
        })
        .catch(error => console.error("Erreur lors du chargement du Pokémon :", error));
}

</script>

<?php require_once base_path('components/footer.php'); ?>