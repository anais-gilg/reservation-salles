<?php
    session_start();

    #----------------Create a connection----------------#
    require("include/dbconnect.php");

    #----------------Deconnection----------------#
    if(isset ($_GET['deco'])){
    }

    #----------------Creation of a variable for error messages----------------#
    $msgError = "";

    #----------------When you press the buton----------------#
    if(isset($_POST['envoyer'])){

        #----------------Check if the fields are filled in----------------#
        if(!empty($_POST['login']) && !empty($_POST['password'])){

            #----------------Security----------------#
            // htmlspecialchars is for security so that nobody can insert
            // an html or javascript code in this field and thus make an attack Cross-Site Scripting
            $login = htmlspecialchars($_POST['login']);
            $password = $_POST['password'];
             
            #----------------Check the login exist----------------#
            $check_login = mysqli_query($connect, "SELECT * FROM `utilisateurs` WHERE login='$login'");
            
            if (mysqli_num_rows($check_login) == 1){
                
                #----------------Check the password correspond----------------#
                $check_password = mysqli_query($connect, "SELECT * FROM `utilisateurs` WHERE login='$login'");
                $resq = $check_password -> fetch_all();

                if ($resq) {

                    $id = $resq['0'];

                    if(password_verify($password, $resq[0][2]) == true){

                        $_SESSION['id'] = $id;
                        $_SESSION['login'] = $login;

                        header('location: index.php');
 
                    }
                    else {
                        $msgError = 'ID incorrect, <br> please check your login and/or password';
                    }

                }
                else {
                    $msgError = 'ID incorrect, <br> please check your login and/or password';
                }

            }
            else {
                $msgError = 'ID incorrect, <br> please check your login and/or password';
            }

        }
        else {
            $msgError = 'Please fill in all fields';
        }
    
    }
?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
        <title>Connection</title>
    </head>

    <body class="bcgconn">
        <!--Header-->
        <?php require("include/header.php"); ?>
        
        <main>
            <div class="otherpage">
                <h1 class="connecth1">Log in</h1>
                <p class="msgerror"><?php echo $msgError ?></p>

                <form action="" method="post" id="from" class="bref" >
                    <div class="newinfo">
                        <input type="text" name="login" id="login" placeholder="Login" required> <br>
                        <input type="password" name="password" id="password" placeholder="Password" required> <br>
                        <input class="submit" type="submit" name="envoyer" value="Enter" id="buton">
                    </div>
                </form>
            </div>

            <?php require("include/footer.php")?>
        </main>
    </body>

</html>