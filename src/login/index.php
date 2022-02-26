<?php 
    session_start();
    $pdo = new PDO('mysql:host=localhost;dbname=ranzig', 'root', 'Ndsjasmcdj');
    
    if(isset($_GET['login'])) {

        $ip = $_SERVER["REMOTE_ADDR"];

        $statement = $pdo->prepare("SELECT COUNT(*) AS 'Count' FROM loginAttempts WHERE ip LIKE :ip AND `timestamp` > (now() - interval 5 minute)");
        $result = $statement->execute(array('ip' => $ip));
        $loginAttempts = $statement->fetch();

        if($loginAttempts['Count'] < 5){
            $statement = $pdo->prepare("INSERT INTO loginAttempts(ip) VALUES (:ip)");
            $result = $statement->execute(array('ip' => $ip));

            $username = $_POST['username'];
            $passwort = $_POST['pwd'];
        
            $statement = $pdo->prepare("SELECT * FROM users WHERE username = :username");
            $result = $statement->execute(array('username' => $username));
            $user = $statement->fetch();
            
            //Überprüfung des Passworts
            if ($user !== false && password_verify($passwort, $user['password'])) {
                $_SESSION['userid'] = $user['id'];
                header("Location: ../list/index.php");
            } else {
                $error = true;
            }
        }
        else{
            $statement = $pdo->prepare("SELECT `timestamp`FROM loginAttempts WHERE ip LIKE :ip AND `timestamp` > (now() - interval 5 minute) LIMIT 1");
            $result = $statement->execute(array('ip' => $ip));
            $timestampFirstAttempt = $statement->fetch();

            $firstAttemptTime = strtotime($timestampFirstAttempt[0]);

            $firstAttemptTime = date('H:i', strtotime('+1 hour +5 minutes', $firstAttemptTime));

            $attemptError = true;
        }
        
    }
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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    </head>
    <body style="background-color: rgb(237, 237, 237);">
        <div class="container-fluid">
            <div class="row" style="margin-top: 3vh;">
                <div class="col-sm-4"></div>
                <div class="col-sm-4">
                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" style="margin: 1vh;">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="../test.png" class="d-block w-100" style="max-height: 20vh; border-radius: 5px;">
                            </div>
                            <div class="carousel-item">
                                <img src="../test2.png" class="d-block w-100" style="max-height: 20vh; border-radius: 5px;">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <div class="white_container">
                        <form action="?login=1" method="post" style="margin-top: -2vh;">
                            <?php
                                //
                                //
                                // Wenn keine übereinstimmung gefunden werden kann
                                //
                                // 
                                if($attemptError == true){
                                    ?>
                                        <div class="alert alert-danger alert-dismissible" style="margin-top: 1vh;">
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                            Limit der Versuche überschritten! Versuche es um <?php echo $firstAttemptTime; ?> nocheinmal.
                                        </div>
                                    <?php
                                } else if($error == true){
                                    ?>
                                        <div class="alert alert-danger alert-dismissible" style="margin-top: 1vh;">
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                            Benutzername oder Passwort ist falsch.
                                        </div>
                                    <?php
                                }
                            ?>
                            <div class="mb-3 mt-3">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" id="username" placeholder="Benutzername" name="username">
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-key"></i></span>
                                    <input type="password" class="form-control" id="pwd" placeholder="Passwort" name="pwd">
                                </div>
                            </div>
                            <input type="submit" class="btn btn-primary" style="width: 100%;" value="Anmelden">
                        </form>
                    </div>
                </div>
                <div class="col-sm-4"></div>
            </div>
        </div>
    </body>
</html>