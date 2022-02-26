<?php
    header('Content-Type: application/json');

    $pdo = new PDO('mysql:host=localhost;dbname=ranzig', 'root', 'Ndsjasmcdj');

    $aResult = array();

    if( !isset($_POST['functionname']) ) { $aResult['error'] = 'No function name!'; }

    if( !isset($_POST['arguments']) ) { $aResult['error'] = 'No function arguments!'; }

    if( !isset($aResult['error']) ) {

        switch($_POST['functionname']) {
            case 'getNameById':
               if( !is_array($_POST['arguments']) || (count($_POST['arguments']) < 1) || (count($_POST['arguments']) > 1)) {
                   $aResult['error'] = 'Error in arguments!';
               }
               else {
                    $statement = $pdo->prepare("SELECT `name` FROM list WHERE id = :id");
                    $statement->execute(array('id' => $_POST['arguments'][0]));
                    while($row = $statement->fetch()) {
                        $aResult['result'] = $row["name"]; 
                    }
                   
               }
               break;

            default:
               $aResult['error'] = 'Not found function '.$_POST['functionname'].'!';
               break;
        }

    }

    echo json_encode($aResult);

?>