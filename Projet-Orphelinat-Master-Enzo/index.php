<?php 
require_once __DIR__ . '/config.php';
require_once base_path('components/header.php');
require_once base_path('db.php');
?>
<div class="w-100 d-flex justify-content-center">
    <img src="<?= base_url('Ressources/backgroundv2.png') ?>" alt="Fond" class="w-100">
</div>
<div class="d-flex justify-content-center align-items-center titre my-4">
    <h1>Qu'est ce qu'on fait ici ?</h1>
</div>
<div class="container">
    <div class="row justify-content-center g-4 p-3">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="carte-base rounded-4 p-4 d-flex flex-column align-items-center">
                <img src="<?= base_url('Ressources/pokeball.png') ?>" alt="pokeball" class="mb-2 imgIndex">
                <h2 class="text-white fs-4 fw-bold my-2 text-center">Adoptez !</h2>
                <hr class="w-100 border-2 border-white my-3">
                <div class="carte-content-area rounded-4 p-4 text-white fs-5 lh-base text-center">
                    <p class="mb-0">Oubliez les herbes hautes et les Pokéballs ! Ici, nous vous confions un Pokémon... mais ne vous y attachez pas trop. Choisissez votre "Compagnon" d'entraînement, celui qui aura l'honneur de servir de chair à canon pour votre gloire.</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="carte-base rounded-4 p-4 d-flex flex-column align-items-center">
                <img src="<?= base_url('Ressources/swords.png') ?>" alt="combat" class="mb-2 imgIndex">
                <h2 class="text-white fs-4 fw-bold my-2 text-center">Combattez !</h2>
                <hr class="w-100 border-2 border-white my-3">
                <div class="carte-content-area rounded-4 p-4 text-white fs-5 lh-base text-center">
                    <p class="mb-0">Le temps, c'est de l'argent, et l'entraînement, c'est du rendement. Affrontez d'autres Pokémon dans des combats acharnés où seule la victoire compte. Faites-le monter en niveau, exploitez ses capacités au maximum. Chaque victoire le rapproche de la perfection... ou de la date d'expiration.</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="carte-base rounded-4 p-4 d-flex flex-column align-items-center">
                <img src="<?= base_url('Ressources/couteau-de-boucher.png') ?>" alt="recyclage" class="mb-2 imgIndex">
                <h2 class="text-white fs-4 fw-bold my-2 text-center">Recyclez !</h2>
                <hr class="w-100 border-2 border-white my-3">
                <div class="carte-content-area rounded-4 p-4 text-white fs-5 lh-base text-center">
                    <p class="mb-0">Félicitations ! Votre Pokémon a atteint son potentiel maximal, ou peut-être qu'il est juste devenu trop faible et coûteux en soins. Quoi qu'il en soit, sa mission est terminée. Notre ferme d'entraînement est équipée d'une section 'Recyclage de Carcasse et Produits Dérivés' dernier cri.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once base_path('components/footer.php'); ?>