<?php

    $pdo = new PDO('mysql:host=localhost;dbname=ranzig', 'root', 'Ndsjasmcdj');

    $email = $_GET["email"];

    $statement = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $result = $statement->execute(array('email' => $email));
    $user = $statement->fetch();

    echo $user["id"];
?>