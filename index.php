<?php
    session_start();

    require("include/dbconnect.php");
?>


<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
        <title>Home</title>
    </head>

    <body class="bcgindex">
        <!--Header-->
        <?php require("include/header.php") ?>

        <main>
            

            <div class="welcome">
                <?php if ($userConnected) {?>
                    
                    <h1>Welcome to your agenda, <br>
                    <?php echo $login . 
                        "<style>
                            .welcome h1 {
                                display: flex;
                                justify-content: center;
                                text-align: center;
                                font-size: 80px;
                                margin-bottom: 40px;
                                margin-top: 20%;
                            }
                        </style>"?> ! </h1>
                    
                <?php } else {?>
                    <h1>Online agenda</h1>
                <?php } ?>
            </div>
        </main>

        <?php require("include/footer.php")?>

    </body>

</html>
