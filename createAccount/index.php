
<?php 
    session_start();
    $pdo = new PDO('mysql:host=localhost;dbname=ranzig', 'root', 'Ndsjasmcdj');

    if(isset($_GET['r'])) {

        $username = $_POST['username'];
        $email = $_POST['email'];
        $pwd = $_POST['pwd'];

        $pwd_hash = password_hash($pwd, PASSWORD_DEFAULT);

        $statement = $pdo->prepare("INSERT INTO users (`username`, `email`, `password`) VALUES (:username, :email, :passwort)");
        $result = $statement->execute(array('username' => $username, 'email' => $email, 'passwort' => $pwd_hash));

        if($result) {    
            $statement = $pdo->prepare("SELECT * FROM users WHERE username = :username");
            $result = $statement->execute(array('username' => $username));
            $user = $statement->fetch();

            if ($user !== false) {
                $_SESSION['userid'] = $user['id'];
                header("Location: ../list/index.html");
            }
        } else {
            $databaseInsertError = true;
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
                        </div>
                    </div>
                    <div class="white_container">
                        <form action="?r=1" method="post">
                            <?php
                                //
                                //
                                // Wenn bei dem Insert der Userdaten etwas nicht passt, wird dieser Alert angezeigt.
                                //
                                // 
                                if($databaseInsertError == true){
                                    ?>
                                        <div class="alert alert-danger alert-dismissible">
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                            Etwas ist schiefgelaufen. Bitte versuche es später erneut.
                                        </div>
                                    <?php
                                }
                            ?>
                            <p id="usernameError" style="color: red;"></p>
                            <div class="input-group createAccountInputMobile">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" placeholder="Benutzername" name="username" id="username" onkeyup="UsernameValidate()">
                            </div>
                            <p id="emailError" style="color: red;"></p>
                            <div class="input-group createAccountInputMobile">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" placeholder="E-Mail" name="email" id="email" onkeyup="EmailValidate()">
                            </div>
                            <p id="pwdError" style="color: red;"></p>
                            <div class="input-group createAccountInputMobile">
                                <span class="input-group-text"><i class="bi bi-key"></i></span>
                                <input type="password" class="form-control" placeholder="Passwort" name="pwd" id="pwd" onkeyup="PwdValidate()">
                            </div>
                            <p id="pwdRepeatError" style="color: red;"></p>
                            <div class="input-group createAccountInputMobile">
                                <span class="input-group-text"><i class="bi bi-key"></i></span>
                                <input type="password" class="form-control" placeholder="Passwort wiederholen" name="pwdRepeat" id="pwdRepeat" onkeyup="PwdRepeatValidate()">
                            </div>

                            <div class="form-check" style="margin-top: 2vh; margin-bottom: 2vh;">
                                <input class="form-check-input" type="checkbox" id="check1" name="option1" onclick="checkValidate()">
                                <label class="form-check-label">Ich habe die <a href="#">Datenschutzerklärung</a> gelesen und akzeptiere diese.</label>
                            </div>

                            <input type="submit" class="btn btn-success" style="width: 100%;" id="create" value="Account erstellen">
                        </form>
                    </div>
                    <div class="white_container">
                        <button type="submit" class="btn btn-primary" style="width: 100%;" onclick="window.location.href='../index.html'">Ich habe einen Account</button>
                    </div>
                </div>
                <div class="col-sm-4"></div>
            </div>
        </div>
        <script>

            if(document.getElementById("username").value === "" || document.getElementById("email").value === "" || document.getElementById("pwd").value === "" || document.getElementById("pwdRepeat").value === "" || document.getElementById("check1").checked == false){
                document.getElementById("create").disabled = true;
            }

            // Globale Variablen um den "Account erstellen"-Button zu disablen wenn es einen Fehler gibt.
            var errorUsername, errorEmail, errorPwd, errorPwdRepeat;

            function UsernameValidate(){
                var lengthError, blankError, alreadyExistError, message;
                var username = document.getElementById("username").value;

                // Überprüfen, ob die Länge des Benutzernamen stimmt
                if(username.length <= 3) {
                    lengthError = true;
                    message = "Der Benutzername muss mindestens 4 Zeichen lang sein."
                } else if(username.length > 30) {
                    lengthError = true;
                    message = "Der Benutzername darf maximal 30 Zeichen lang sein."
                } else {
                    lengthError = false;
                }

                // Überprüfen, ob der Benutzername leer ist
                if(username === ""){
                    blankError = true;
                    message = "Dieses Feld darf nicht leer sein.";
                } else {
                    blankError = false;
                }

                // Überprüfen, ob der Benutzername schon vergeben ist
                const xmlhttp = new XMLHttpRequest();
                xmlhttp.onload = function() {
                    if(this.responseText === ""){
                        alreadyExistError = false;
                    } else {
                        alreadyExistError = true;
                        message = "Dieser Benutzername existiert bereits.";
                    }

                    // Ist in der onload-Funktion weil diese als letztes aufgerufen wird
                    if(lengthError || blankError || alreadyExistError){
                        document.getElementById("username").style.borderColor = "red";
                        errorUsername = true;
                        document.getElementById("usernameError").innerHTML = message;
                    } else {
                        document.getElementById("username").style.borderColor = "";
                        message = "";
                        errorUsername = false;
                        document.getElementById("usernameError").innerHTML = message;
                    }

                    if(errorUsername || errorEmail || errorPwd || errorPwdRepeat){
                        document.getElementById("create").disabled = true;
                    } else {
                        document.getElementById("create").disabled = false;
                    }

                    if(document.getElementById("username").value === "" || document.getElementById("email").value === "" || document.getElementById("pwd").value === "" || document.getElementById("pwdRepeat").value === "" || document.getElementById("check1").checked == false){
                        document.getElementById("create").disabled = true;
                    }
                }

                xmlhttp.open("GET", "getUsernames.php?username=" + username);
                xmlhttp.send();
            }

            function EmailValidate(){
                var formatError, blankError, alreadyExistError, message;
                var email = document.getElementById("email").value;

                if(email === ""){
                    blankError = true;
                    message = "Dieses Feld darf nicht leer sein.";
                } else {
                    blankError = false;
                }

                if(email.includes("@") && email.includes(".")){
                    formatError = false;
                } else {
                    formatError = true;
                    message = "Bitte gib eine gültige E-Mail ein.";
                }

                const xmlhttp = new XMLHttpRequest();
                xmlhttp.onload = function() {
                    if(this.responseText === ""){
                        alreadyExistError = false;
                    } else {
                        alreadyExistError = true;
                        message = "Diese E-Mail wird bereits verwendet.";
                    }

                    // Ist in der onload-Funktion weil diese als letztes aufgerufen wird
                    if(formatError || blankError || alreadyExistError){
                        document.getElementById("email").style.borderColor = "red";
                        errorEmail = true;
                        document.getElementById("emailError").innerHTML = message;
                    } else {
                        document.getElementById("email").style.borderColor = "";
                        message = "";
                        errorEmail = false;
                        document.getElementById("emailError").innerHTML = message;
                    }

                    if(errorUsername || errorEmail || errorPwd || errorPwdRepeat){
                        document.getElementById("create").disabled = true;
                    } else {
                        document.getElementById("create").disabled = false;
                    }

                    if(document.getElementById("username").value === "" || document.getElementById("email").value === "" || document.getElementById("pwd").value === "" || document.getElementById("pwdRepeat").value === "" || document.getElementById("check1").checked == false){
                        document.getElementById("create").disabled = true;
                    }
                }

                xmlhttp.open("GET", "getEmails.php?email=" + email);
                xmlhttp.send();
            }

            function PwdValidate(){
                var lengthError, blankError, message;
                var pwd = document.getElementById("pwd").value;

                if(pwd === ""){
                    blankError = true;
                    message = "Dieses Feld darf nicht leer sein."
                } else {
                    blankError = false;
                }

                if(pwd.length < 8){
                    lengthError = true;
                    message = "Das Passwort muss mindestens 8 Zeichen lang sein."
                } else {
                    lengthError = false;
                }

                if(lengthError || blankError){
                    document.getElementById("pwd").style.borderColor = "red";
                    errorPwd = true;
                    document.getElementById("pwdError").innerHTML = message;
                } else {
                    document.getElementById("pwd").style.borderColor = "";
                    message = ""
                    errorPwd = false;
                    document.getElementById("pwdError").innerHTML = message;
                }

                if(errorUsername || errorEmail || errorPwd || errorPwdRepeat){
                    document.getElementById("create").disabled = true;
                } else {
                    document.getElementById("create").disabled = false;
                }

                if(document.getElementById("username").value === "" || document.getElementById("email").value === "" || document.getElementById("pwd").value === "" || document.getElementById("pwdRepeat").value === "" || document.getElementById("check1").checked == false){
                    document.getElementById("create").disabled = true;
                }
            }

            function PwdRepeatValidate(){
                var repeatError, blankError, message;
                var pwd = document.getElementById("pwd").value;
                var pwdRepeat = document.getElementById("pwdRepeat").value;

                if(pwdRepeat === ""){
                    blankError = true;
                    message = "Dieses Feld darf nicht leer sein.";
                } else {
                    blankError = false;
                }

                if(pwd != pwdRepeat){
                    repeatError = true;
                    message = "Das Passwort muss identisch sein.";
                } else {
                    repeatError = false;
                }

                if(repeatError || blankError){
                    document.getElementById("pwdRepeat").style.borderColor = "red";
                    errorPwdRepeat = true;
                    document.getElementById("pwdRepeatError").innerHTML = message;
                } else {
                    document.getElementById("pwdRepeat").style.borderColor = "";
                    message = "";
                    errorPwdRepeat = false;
                    document.getElementById("pwdRepeatError").innerHTML = message;
                }

                if(errorUsername || errorEmail || errorPwd || errorPwdRepeat){
                    document.getElementById("create").disabled = true;
                } else {
                    document.getElementById("create").disabled = false;
                }

                if(document.getElementById("username").value === "" || document.getElementById("email").value === "" || document.getElementById("pwd").value === "" || document.getElementById("pwdRepeat").value === "" || document.getElementById("check1").checked == false){
                    document.getElementById("create").disabled = true;
                }
            }

            // Für die Datenschutz-Checkbox
            function checkValidate(){
                if(document.getElementById("check1").checked == true && errorUsername == false && errorEmail == false && errorPwd == false && errorPwdRepeat == false){
                    document.getElementById("create").disabled = false;
                } else {
                    document.getElementById("create").disabled = true;
                }
            }
        </script>
    </body>
</html>