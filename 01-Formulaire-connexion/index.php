<?php
session_start(); // Démarrage de la session PHP
include('cnx/cnx.php'); // Inclusion du fichier de configuration de la base de données

$message = ""; // Initialisation de la variable pour stocker les messages d'erreur ou de succès

if(isset($_POST['validation'])){ // Vérification si le formulaire a été soumis

    // Vérification si les champs sont remplis
    if(empty($_POST['client_log']) || empty($_POST['client_pass'])){
        $message = '<p class="access">Veuillez remplir tous les champs</p>';
    }else {
        // Requête SQL pour récupérer l'utilisateur correspondant aux identifiants fournis
        $sql = 'SELECT * FROM clients WHERE client_log = :client_log AND client_pass = :client_pass';
        $req = $cnx->prepare($sql);
        $req->execute(
            array(
                ':client_log' => $_POST['client_log'],
                ':client_pass' => $_POST['client_pass'],
            )
        );

        //  retourne moi tout les resultats de la requette. Si il ny aucune requete se sera egale à 0
        $count = $req->rowCount(); // Récupération du nombre de résultats

        // Si le nombre est positif c'est qu'il y a un résultat, donc on redirige vers la page d'administration
        $data = $req->fetch(PDO::FETCH_ASSOC);
        if($count > 0){
            header('location:admin/');

            // Gestion de la mémorisation de la checkbox
            if(isset($_POST['memorisation'])){
                // Création d'un cookie
                // setcookie prend 3 agument: un nom, la valeur, le temps de vie
                // +3600*24*365 permet de donner un an de vie au cookies 3600segondes dans une heure * 24 heure * 365 jours
                setcookie('memo', $data['client_log'], time()+3600*24*365);
            }else {
                // si le cookie depasse le nombre de segonde on le supprime pour permet le decochage de la checkbox
                setcookie('memo', $data['client_log'], time()-1);
            }

            // Récupération des données de l'utilisateur dans la session PHP
            $_SESSION['client_log'] = $data['client_log'];
            $_SESSION['client_pass'] = $data['client_pass'];
        }else {
            $message = '<p class="access">Identifiant ou mot de passe incorrecte</p>';
        }
    }
};
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="style.css">
    <title>Connexion</title>
</head>
<body>


<section class="container">
    <form action="" method="POST">
        <?php echo $message ?>
          <div class="box email">
                <div class="input-area">
                    <input type="text" name="client_log" id="login" placeholder="Login" value="<?php                     if(isset($_COOKIE['memo'])){ echo $_COOKIE['memo'] ;}?>">
                    <ion-icon class="key" name="person-circle-outline"></ion-icon>

                </div>
            </div>
            <div class="box password">
                <div class="input-area">
                    <input type="password" name="client_pass" id="password" placeholder="Mot de passe">
                    <ion-icon class="key" name="key-outline"></ion-icon>
                </div>
                <div class="info">
                    <?php
                    if(isset($_COOKIE['memo'])){
                    ?>
                 <input type="checkbox" name="memorisation" id="checkbox" class="checkbox" checked> 
                 <?php
                   } else {

                       ?>
                        <input type="checkbox" name="memorisation" id="checkbox" class="checkbox" > 
                 <?php
                }
      
                    ?>
                   Se souvenir de moi
            
            </div>
            </div>
            <button name=validation >Se connecter </button>
    
    </form>
</section>
    

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</html>