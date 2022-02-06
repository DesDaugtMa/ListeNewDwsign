<?php
    $isReachable = true;
    if($isReachable){
        header("Location: /login/index.php");
    } else {
        ?>
            <!DOCTYPE html>
            <html lang="de">
                <head>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>ranzig.at</title>

                    <!-- Own CSS File -->
                    <link rel="stylesheet" href="style.css">

                    <!-- Latest compiled and minified CSS -->
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

                    <!-- Latest compiled JavaScript -->
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

                    <!-- Bootstrap Icons -->
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
                </head>
                <body style="background-color: rgb(237, 237, 237);">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4">
                                <div class="alert alert-warning">
                                    Die Website ist momentan nicht erreichbar. Bitte versuche es später wieder.
                                </div>
                            </div>
                            <div class="col-sm-4"></div>
                        </div>
                    </div>
                </body>
            </html>
        <?php
    }
?>