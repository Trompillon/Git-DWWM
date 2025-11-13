<?php
// Connexion à la base avec PDO
$pdo = new PDO("mysql:host=localhost;dbname=topfilms", "root", "root");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>