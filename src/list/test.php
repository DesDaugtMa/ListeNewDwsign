<?php

    class Entry
    {
        public $id;
        public $name;
        public $activity;
        public $rating;
        public $location;
        public $note;
    }

    session_start();

    if(!isset($_SESSION["userid"])){
        header("Location: ../login/index.php");
    }

    $pdo = new PDO('mysql:host=localhost;dbname=ranzig', 'root', 'Ndsjasmcdj');

    $statement = $pdo->prepare("SELECT `list`.`id`, `list`.`name`, `mappingActivity`.`activity`, `mappingRating`.`rating`,`list`.`location`,`list`.`note`FROM `list` INNER JOIN mappingActivity ON `list`.`activityId`=mappingActivity.id INNER JOIN mappingRating ON `list`.`ratingId`=mappingRating.id WHERE userId = :userId");
    $statement->execute(array('userId' => $_SESSION["userid"])); 

    $listOfEntries = array();

    while($row = $statement->fetch()) {
        $entry = new Entry();
        $entry->id = $row["id"];
        $entry->name = $row["name"];
        $entry->activity = $row["activity"];
        $entry->rating = $row["rating"];
        $entry->location = $row["location"];
        $entry->note = $row["note"];

        array_push($listOfEntries, $entry);
    }

    $myJSON = json_encode($listOfEntries);

    echo $myJSON;

?>