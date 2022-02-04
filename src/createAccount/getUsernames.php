<?php

    $pdo = new PDO('mysql:host=localhost;dbname=ranzig', 'root', 'Ndsjasmcdj');

    $username = $_GET["username"];

    $statement = $pdo->prepare("SELECT id FROM users WHERE username = :username");
    $result = $statement->execute(array('username' => $username));
    $user = $statement->fetch();

    echo $user["id"];
?>