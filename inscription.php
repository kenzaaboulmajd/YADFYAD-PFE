<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = "mysql:host=localhost;dbname=yadfyad";
    $user = "root";
    $pass = "";
    $name = $_POST['nom'];
    $email = $_POST['email'];
    $mdps = $_POST['motdepasse'];
    $adresse = $_POST['adresse'];
    $numero = $_POST['numero'];
    $confirmotdepasse = $_POST['confirmotdepasse'];
    $info = $_POST['info'];
    $domaine = $_POST['domaine'];



    try {
        $conn = new PDO($db, $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'error de cnx' . $e->getMessage();
    }


    if (!empty($name) && !empty($email) && !empty($mdps) && !empty($confirmotdepasse) && !empty($info) && !empty($adresse) && !empty($numero) && !empty($domaine)) {
        $hash = password_hash($mdps, PASSWORD_DEFAULT);
        $sql = $conn->prepare("INSERT INTO association (NOM_ASSOCIATION,EMAIL, MOT_DE_PASSE, INFO,ADRESSE, NUMERO_TELEPHONE, DOMAINE) VALUES (:nom, :email, :mdps,:info,:adresse,:numero,:domaine)");
        $sql->execute([
            ':nom' => $name,
            ':email' => $email,
            ':mdps' => $hash,
            ':info' => $info,
            ':adresse' => $adresse,
            ':numero' => $numero,
            ':domaine' => $domaine,
        ]);
        header('location:connexion.php');
    } else {
        echo 'Veuillez entrer tout les donnees ';
    }
}
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
                    <!-- Nom de l'association -->
                    <label for="nom">Nom de l'association</label>
                    <input type="text" id="nom" name="nom" required>

                    <!-- Preuve (facultatif ici car pas utilisé en PHP) -->
                    <label for="preuve">Preuve de l’association</label>
                    <input type="text" id="preuve" name="preuve">

                    <!-- Adresse -->
                    <label for="adresse">Adresse</label>
                    <input type="text" id="adresse" name="adresse" required>

                    <!-- Email -->
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>

                    <!-- Numéro -->
                    <label for="numero">Numero de téléphone</label>
                    <input type="text" id="numero" name="numero" required>

                    <!-- Mot de passe -->
                    <label for="motdepasse">Mot de passe</label>
                    <input type="password" id="motdepasse" name="motdepasse" required>

                    <!-- Confirmation -->
                    <label for="confirmotdepasse">Confirmer mot de passe</label>
                    <input type="password" id="confirmotdepasse" name="confirmotdepasse" required>

                    <!-- Domaine -->
                    <label for="domaine">Domaine</label>
                    <input type="text" id="domaine" name="domaine" required>

                    <!-- Description -->
                    <label for="description">Description</label>
                    <textarea id="info" name="info" required></textarea>



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