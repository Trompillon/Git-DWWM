<?php require_once __DIR__ . '/../config.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adoptez les tous</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('style.css') ?>">
</head>
<body>
<header>
<nav class="fs-4 text-white">
  <div class="d-flex justify-content-between align-items-center p-4">
    <div>
      <a href="<?= base_url('index.php') ?>" class="text-white text-decoration-none">Accueil</a>
    </div>
    <ul class="d-flex justify-content-center align-items-center list-unstyled m-0 gap-5 flex-grow-1">
      <?php include __DIR__ . '/nav.php'; ?>
    </ul>
  </div>
</nav>
</header>