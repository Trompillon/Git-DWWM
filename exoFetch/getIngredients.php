<?php

require 'db.php';

$searchWord = $_GET["searchWord"];

$stmt = $pdo->prepare("SELECT * FROM ingredient WHERE IngredientNameFR LIKE ?");
$stmt->execute(["%$searchWord%"]);
$result=[];

while ($ingredients = $stmt->fetch(PDO::FETCH_ASSOC)){
    $result[]=$ingredients;
}

header("Content-Type: application/json");

echo json_encode($result);

?>