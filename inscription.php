<?php
    session_start();
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $db="mysql:host=localhost;dbname=revision_system";
        $user="root";
        $pass="";
        $name=$_POST['name'];
        $email=$_POST['email'];
        $mdps=$_POST['mdps'];
        $mconfirotdepasse=$_POST['mconfirotdepasse'];
        $domaine=$_POST['domaine'];
        $description=$_POST['description'];
        try{
            $conn=new PDO ($db,$user,$pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            echo 'error de cnx'.$e->getMessage();
        }
        if(!empty($name) && !empty($email) && !empty($mdps) && !empty($mconfirotdepasse) && !empty($domain) && !empty($description)){
            $hash=password_hash($mdps,PASSWORD_DEFAULT);
        $sql=$conn->prepare("INSERT INTO utilisateurs (nom,email,mot_de_passe,con) VALUES (:nom,:email,:mdps)");
        $sql->execute([
            ':nom' => $name,
            ':email'=> $email,
            ':mdps'=> $hash
        ]);
        header('location:connexion.php');
        }else{
            echo'Veuillez entrer tt les donnÃ©es ';
        }}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="authentification.css">
</head>

<body>
   
    <!-- START HEADER -->
    <header>
        <div class=" container">
            <nav>
                <div class="logo">
                    <img src="assets/images/logo.png" alt="YADFYAD-logo">
            </nav>
        </div>
    </header>

    <!-- START SECTION -->
    <section>
    <!-- <div class="design">
        <span class="left"></span>
        <span class="right"></span>
        <span class="center"> </span> -->

        <div class="container">
            <div class="links-boutons">
                <a href="#">Association</a>
                <a href="#"> Membre</a>
            </div>
            <div class="description">
                <h2>Créer un compte</h2>
                <p>Rejoignez la communauté YADFYAD pour connecter avec
                    <br> d' autres associations solidaires
                </p>
            </div>
          
            <div class="information">
                <form method="post" class="form-group">
                    <label for=" nom">Nom de l'association</label>
                    <input type="text" id="nom" name="nom" required>

                    <label for="nom">Preuve de l’association</label>
                    <input type="text" id="nom" name="nom" required>

                    <label for="adress">Adress</label>
                    <input type="text" id="adress" name="adress" required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>

                    <label for="motdepasse">Mot de passe</label>
                    <input type="password" id="md" name="motdepasse" required>

                    <label for="confirmotdepasse">confirmer mot de passe</label>
                    <input type="password" id="confirmotdepasse" name="mconfirotdepasse" required>

                    <label for="domaine">Domaine</label>
                    <input type="text" id="domaine" name="domaine" required>

                    <label for="description">Description</label>
                    <input type="text" id="description" name="description" required>

                    <input type="submit" value="S'inscrire">

                    <div class="question">Vous avez déjà un compte? <a href=" #">Connectez-vous</a></div>

                </form>
                </div>
            </div>
        <!-- </div> -->
       
    </section>
<footer>
<div class="copyright">
    <p>&copy; 2025 YADFYAD. All rights reserved.</p>
</div>
</footer>
</body>

</html>