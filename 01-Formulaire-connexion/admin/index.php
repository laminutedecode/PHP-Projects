<?php
session_start();

include('../cnx/cnx.php');

if(isset($_SESSION['client_log'])){
    $client_log = $_SESSION['client_log'];
 
} else {
    header('location:../index.php');
}

if(isset($_SESSION['client_pass'])){
    $client_pass = $_SESSION['client_pass'];
} 

// Ajout d'un bouton de déconnexion
if(isset($_POST['deconnexion'])) {
    session_unset();
    session_destroy();
    header('location:../index.php');
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>La Minute de code</title>
</head>
<body>




<section class="container">

    <p class="txt-bvn">Bienvenue <?= $client_log; ?> </p>
    <form action="" method="POST">
    
          <div class="box email">
              <label >Votre login:</label>
                <div class="input-area">
                <input type="text"  name="client_log" value=" <?= $client_log; ?> " disabled>
                    <ion-icon class="key" name="person-circle-outline"></ion-icon>

                </div>
            </div>
            <div class="box password">
                <label >Votre mot de passe</label>
                <div class="input-area">
                <input type="text" name="client_pass" value="<?= $client_pass; ?> " disabled>
                    <ion-icon class="key" name="key-outline"></ion-icon>
                </div>
  
            </div>
            <button type="submit" name="deconnexion">Se déconnecter</button>
    
    </form>
</section>


<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
