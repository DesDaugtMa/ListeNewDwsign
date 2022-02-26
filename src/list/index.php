<?php
    session_start();
    
    if(!isset($_SESSION["userid"])){
        header("Location: ../login/index.php");
    }

    $pdo = new PDO('mysql:host=localhost;dbname=ranzig', 'root', 'Ndsjasmcdj');

    $statement = $pdo->prepare("SELECT `list`.`id`, `list`.`name`, `mappingActivity`.`activity`, `mappingRating`.`rating`,`list`.`location`,`list`.`note`FROM `list` INNER JOIN mappingActivity ON `list`.`activityId`=mappingActivity.id INNER JOIN mappingRating ON `list`.`ratingId`=mappingRating.id WHERE userId = :userId");
    $statement->execute(array('userId' => $_SESSION["userid"]));   
?>
<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ranzig.at</title>

        <!-- Own CSS File -->
        <link rel="stylesheet" href="../style.css">

        <!-- Latest compiled and minified CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Latest compiled JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- Dynamic Modal JS -->
        <script src="modal-with-custom-action.js"></script>
    </head>
    <body style="background-color: rgb(237, 237, 237);">


            <nav class="navbar bg-light navbar-light fixed-top">
                <div class="container-fluid">
                    <h3 style="margin: 0;">Liste</h3>
                    <h3 class="btn_hover" style="margin: 0;" data-bs-toggle="modal" onclick="showModal('add', 0);"><i class="bi bi-plus"></i></h3>
                </div>
            </nav>

            <div class="container-fluid" style="margin-top: 7vh;">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="white_container_list" style="background-color: #cacaca;">
                            Du hast 4 Einträge<span style="float: right;"><i class="bi bi-info-circle"></i></span>
                        </div>
                    </div>
                    <?php
                        while($row = $statement->fetch()) {
                            echo '<div class="col-sm-4">';
                                echo '<div class="white_container_list">';
                                    echo '<strong>' . $row["name"] . '</strong>';
                                    echo '<span style="float: right;">';
                                        echo '<i class="bi bi-pencil btn_hover" style="margin-right: 2vh;" onclick="showModal(\'edit\', \'' . $row["id"] . '\');"></i>';
                                        echo '<i class="bi bi-trash text-danger btn_hover" onclick="showModal(\'delete\', \'' . $row["id"] . '\');"></i>';
                                    echo '</span>';
                                    echo '<hr>';
                                    echo '<p class="p_data">Bewertung: ' . $row["rating"] . '</p>';
                                    echo '<p class="p_data">Aktivität: ' . $row["activity"] . '</p>';
                                    echo '<p class="p_data">Ort: ' . $row["location"] . '</p>';
                                    echo '<p class="p_data">Notiz: ' . $row["note"] . '</p>';
                                echo '</div>';
                            echo '</div>';
                        }
                    ?>
                    <div class="col-sm-4">
                        <div class="white_container_list">
                            <strong>Leonie Forstner</strong>
                            <span style="float: right;">
                                <i class="bi bi-pencil btn_hover" style="margin-right: 2vh;" onclick="showModal('edit', 1);"></i>
                                <i class="bi bi-trash text-danger btn_hover" onclick="showModal('delete', 1);"></i>
                            </span>
                            <hr>
                            <p style="color: orange;"><i class="bi bi-star-fill"></i><i class="bi bi-star"></i><i class="bi bi-star"></i><i class="bi bi-star"></i><i class="bi bi-star"></i></p>
                            <p class="modal_label">Aktivität: Sex</p>
                            <p class="modal_label">Ort: Marias Couch</p>
                            <p class="modal_label">Notizen: Erstes Mal</p>
                        </div>
                    </div>
                </div>
            </div>
    </body>
</html>