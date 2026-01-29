<?php

    require 'db.php';

    $searchWord = $_GET["searchWord"];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE first_name OR last_name LIKE ?");
    $stmt->execute(["%$searchWord%"]);
    $result=[];

    while ($user = $stmt->fetch(PDO::FETCH_ASSOC)){
        $result[]=$user;
    }

    header("Content-Type: application/json");

    echo json_encode($result);

?>