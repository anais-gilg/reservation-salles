<?php
    session_start();

    #----------------db connect----------------#
    require("include/dbconnect.php");

    #----------------creation of a variable for error messages----------------#
    $msgError = "";
    $msgSuccess = "";

    #----------------To prevent a user from accessing this page if they are not logged in----------------#
    if (!isset($_SESSION['id'])){
        header('Location: accueil/index.php');
    }

    #----------------Recover the information of the connected user----------------#
    $id = $_SESSION['id'][0];
    $sesslog = $_SESSION['login'][1];
    $recupUser = mysqli_query($connect, "SELECT * FROM `utilisateurs` WHERE id = '$id'" );
    // the function mysqli_fetch_array() returns an array that matches the retrieved row.
    $user = mysqli_fetch_array($recupUser);
    #----------------pre-fill the fields----------------#
    $login = $user['login'];
    $password = $user['password'];

    #----------------When you press the buton----------------#
    if(isset($_POST['envoyer']))

        #----------------Check if the fields are filled in----------------#
        if(!empty($_POST['login']) && !empty($_POST['password'])){

            #----------------Security----------------#
            // htmlspecialchars is for security so that nobody can insert
            // an html or javascript code in this field and thus make an attack Cross-Site Scripting
            $login = htmlspecialchars($_POST['login']);
            $password = $_POST['password'];
            $confpassword = $_POST['confpassword'];

            #----------------check if data are present in the db----------------#
            $check_login = mysqli_query($connect, "SELECT * FROM `utilisateurs` WHERE login='$login'");
            // the function mysqli_num_rows() check if data are present in the db
            // https://www.geeksforgeeks.org/php-mysqli_num_rows-function/

            // Si le login est identique au login de la session en cours 
            if (mysqli_num_rows($check_login) === $sesslog){
                $samelogin = mysqli_query($connect, "UPDATE `utilisateurs` SET `login`='$login' WHERE id = '$id'");
                $msgSucces = 'The modification has been correctly done';
            }
            elseif (mysqli_num_rows($check_login) !== $sesslog){
                $samelogin = mysqli_query($connect, "UPDATE `utilisateurs` SET `login`='$login' WHERE id = '$id'");
                $msgSuccess = 'The modification has been correctly done';
            }
            else {
                $msgError ='This login already exists';
            }

            #----------------the same password----------------#
            if ($password === $confpassword){
                #----------------Add user in db----------------#
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  
                $new_info = mysqli_query($connect, "UPDATE `utilisateurs` SET `password`='$password' WHERE id = '$id'");
            }
            else {
                $msgError = 'Invalid password';
            }    

        }
        else {
            $msgError = 'ID incorrect, <br> please check your login and/or password';
        }
?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
        <title>Profil</title>
    </head>

    <body class="bcgmodif">
        <div class="hder1">
            
            <?php require("include/header.php"); ?>          
            
        </div>

        <main>

            <div class="otherpage">
            
                <h1 class="modifh1">Modification</h1>

                <p class="msgerror"><?php echo $msgError ?></p>
                <p class="msgsuccess"><?php echo $msgSuccess ?></p>

                <div class="blocform">
                    <form action="" method="post" id="form">
                        
                        <div class="newinfo">
                        <input type="text" name="login" id="login" placeholder="New login" value="<?php echo $login; ?>" required> <br />

                        <!--type password to hide the code-->
                        <input type="password" name="password" id="password" placeholder="New password" required> <br/>
                        <input type="password" name="confpassword" id="confpassword" placeholder="Confirmation new password" required> <br/>
                        <br /> <br />
                        <input class="submit" type="submit" name="envoyer" value="Enter" id="buton">
                        </div>
                    </form>
                </div>

            </div>
        </main>

        <?php require("include/footer.php")?>

    </body>
</html>