<?php
require_once __DIR__ . '/../config.php';
require_once base_path('db.php');

if(!isset($_SESSION['user_id'])) {
    header('location: ' . base_url('connexion/connexion.php'));
    exit;
}

$sql = "SELECT op.*, pg.nom as nom_complet FROM owned_pokemon op 
        LEFT JOIN pokemon_gen1 pg ON op.pokedex_id = pg.id 
        WHERE op.ownedby = :user_id 
        ORDER BY op.niveau DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $_SESSION['user_id']]);
$ownedPokemons = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once base_path('components/header.php');
?>

<div class="container my-5">
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success text-center mx-auto w-75 mb-4">
            <?php 
            echo htmlspecialchars($_SESSION['success_message']); 
            unset($_SESSION['success_message']);
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger text-center mx-auto w-75 mb-4">
            <?php 
            echo htmlspecialchars($_SESSION['error_message']); 
            unset($_SESSION['error_message']);
            ?>
        </div>
    <?php endif; ?>
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold titre mb-3">Centre de Recyclage</h1>
        <div class="mx-auto maxW">
            <div class="carte-base rounded-4 p-4">
                <p class="text-white fs-5 mb-0">
                    Recyclez vos Pokemon pour liberer de l'espace dans votre collection.
                </p>
            </div>
        </div>
    </div>
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="carte-base rounded-4 p-4 text-center">
                <div class="text-white">
                    <h3 class="display-4 fw-bold"><?= count($ownedPokemons) ?></h3>
                    <p class="fs-5 mb-0">Pokemon possedes</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="carte-base rounded-4 p-4 text-center">
                <div class="text-white">
                    <h3 class="display-4 fw-bold">
                        <?php 
                        $niveauMin = count($ownedPokemons) > 0 
                            ? min(array_column($ownedPokemons, 'niveau')) 
                            : 0;
                        echo $niveauMin;
                        ?>
                    </h3>
                    <p class="fs-5 mb-0">Niveau le plus bas</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="carte-base rounded-4 p-4 text-center">
                <div class="text-white">
                    <h3 class="display-4 fw-bold">
                        <?php 
                        $niveauMax = count($ownedPokemons) > 0 
                            ? max(array_column($ownedPokemons, 'niveau')) 
                            : 0;
                        echo $niveauMax;
                        ?>
                    </h3>
                    <p class="fs-5 mb-0">Plus haut niveau</p>
                </div>
            </div>
        </div>
    </div>
    <?php if (!empty($ownedPokemons)): ?>
    <div class="row g-4">
        <?php foreach($ownedPokemons as $pokemon): ?>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="carte-base rounded-4 p-4 h-100">
                <div class="text-center mb-3">
                <img src="" 
                    alt="<?= htmlspecialchars($pokemon['nom']) ?>" 
                    class="pokemon-sprite imgPoke" 
                    data-pokemon-id="<?= htmlspecialchars($pokemon['pokedex_id']) ?>"
                    data-is-shiny="<?= htmlspecialchars($pokemon['is_shiny']) ?>">
                </div>
                
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h3 class="text-white fs-4 fw-bold mb-1"><?= htmlspecialchars($pokemon['nom']) ?></h3>
                        <?php if(!empty($pokemon['surnom'])): ?>
                        <p class="text-white-50 mb-0 fst-italic"><?= htmlspecialchars($pokemon['surnom']) ?></p>
                        <?php endif; ?>
                    </div>
                    <span class="badge bg-light text-dark fs-6">Niv. <?= htmlspecialchars($pokemon['niveau']) ?></span>
                </div>

                <div class="carte-content-area rounded-4 p-3 mb-3">
                    <div class="row g-2 text-white">
                        <div class="col-6">
                            <small class="text-white-50 d-block">Type 1</small>
                            <span class="badge bg-secondary"><?= htmlspecialchars($pokemon['type1']) ?></span>
                        </div>
                        <?php if(!empty($pokemon['type2'])): ?>
                        <div class="col-6">
                            <small class="text-white-50 d-block">Type 2</small>
                            <span class="badge bg-secondary"><?= htmlspecialchars($pokemon['type2']) ?></span>
                        </div>
                        <?php endif; ?>
                        <div class="col-6">
                            <small class="text-white-50 d-block">Taille</small>
                            <strong><?= htmlspecialchars($pokemon['taille']) ?> m</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-white-50 d-block">Poids</small>
                            <strong><?= htmlspecialchars($pokemon['poids']) ?> kg</strong>
                        </div>
                        <?php if(!empty($pokemon['objet_equiper'])): ?>
                        <div class="col-12">
                            <small class="text-white-50 d-block">Objet equipe</small>
                            <strong><?= htmlspecialchars($pokemon['objet_equiper']) ?></strong>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <a href="<?= base_url('pages/recyclerDelete.php?id=' . htmlspecialchars($pokemon['id'])) ?>" 
                   class="btn btn-danger w-100 py-2 fw-bold recycle-btn">
                    Recycler ce Pokemon
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="text-center py-5">
        <div class="carte-base rounded-4 p-5 mx-auto maxWCatch">
            <h3 class="text-white fs-3 fw-bold mb-3">Aucun Pokemon a recycler</h3>
            <p class="text-white-50 fs-5 mb-4">Vous n'avez actuellement aucun Pokemon dans votre collection.</p>
            <a href="<?= base_url('pages/zoneDeCapture.php') ?>" class="btn submit-btn btn-lg px-4">
                Capturer des Pokemon
            </a>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php require_once base_path('components/footer.php'); ?>