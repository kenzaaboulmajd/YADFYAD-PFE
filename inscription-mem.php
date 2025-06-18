<?php
session_start();
require_once "config.php";

$sql = $pdo->prepare("SELECT ID_ASSOCIATION, NOM_ASSOCIATION FROM association");
$sql->execute();
$associations = $sql->fetchAll();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = "mysql:host=localhost;dbname=yadfyad";
    $user = "root";
    $pass = "";
    $fullname = $_POST["nom"];
    $nom = explode(" ", $fullname)[0];
    $prenom = explode(" ", $fullname)[1] ?? "";
    $email = $_POST['email'];
    $mdps = $_POST['mdps'];
    $confirmotdepasse = $_POST['confirmotdepasse'];
    $description = $_POST['description'];
    $role = $_POST['role'];
    $association_id = $_POST["association"];

    if ($role == "membre") {
        $type = 1;
    } else {
        $type = 0;
    }
    try {
        $conn = new PDO($db, $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'error de cnx' . $e->getMessage();
    }
    if (!empty($nom) && !empty($email) && !empty($mdps) && !empty($confirmotdepasse) && !empty($description)) {
        $hash = password_hash($mdps, PASSWORD_DEFAULT);
        $sql = $conn->prepare("INSERT INTO utilisateur (NOM,PRENOM,EMAIL, MOT_DE_PASSE, DESCRIPTION,TYPE_UTILISATEUR,ID_ASSOCIATION) VALUES (:nom,:prenom, :email, :mdps,:description,:type_utilisateur,:id_association)");
        $sql->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':mdps' => $hash,
            ':description' => $description,
            ':type_utilisateur' => $type,
            ':id_association' => $association_id
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
    <!-- <div class="design">
        <span class="left"></span>
        <span class="right"></span>
        <span class="center"> </span>
    </div> -->
    <!-- START HEADER -->
    <header>
        <div class=" container">
            <nav>
                <div class="logo">
                    <a href="/YADFYAD-PFE"><img src="assets/images/logo.png" alt="YADFYAD-logo"></a>
            </nav>
        </div>
    </header>

    <!-- START SECTION -->
    <section>
        <div class="container">
            <div class="links-boutons">
                <a href="inscription.php" class="button-active">Association</a>
                <a href="inscription-mem.php"> Membre solidaire</a>
            </div>
            <div class="description">
                <h2>Créer un compte</h2>
                <p>Rejoignez la communauté YADFYAD pour connecter avec
                    <br> d' autres associations solidaires
                </p>
            </div>
            <div class="information">
                <form method="post" class="form-group">

                    <label for="role">Je suis :</label>
                    <select name="role" id="role" class="role" onchange="toggleFields(this)" required>
                        <option value="" disabled hidden selected>Choisissez...</option>
                        <option value="membre">Membre d'association</option>
                        <option value="visiteur">visiteur</option>
                    </select>

                    <label class="association-membre-champs" for="association" style="display: none;">Membre de
                        :</label>
                    <select class="role association-membre-champs" name="association" id="association"
                        style="display: none">
                        <option value="" disabled hidden selected>Choisissez...</option>
                        <?php foreach ($associations as $association): ?>
                            <option value="<?= $association["ID_ASSOCIATION"] ?>"><?= $association["NOM_ASSOCIATION"] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <label for=" nom">Nom et prenom</label>
                    <input type="text" id="nom" name="nom" required>


                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>

                    <label for="motdepasse">Mot de passe</label>
                    <input type="password" id="mdps" name="mdps" required>

                    <label for="confirmotdepasse">confirmer mot de passe</label>
                    <input type="password" id="confirmotdepasse" name="confirmotdepasse" required>

                    <label for="description">description</label>
                    <input type="text" id="description" name="description" required>

                    <input type="submit" value="S'inscrire">

                    <div class="question"> Vous avez déjà un compte? <a href=" #">Connectez-vous</a></div>
            </div>
            </form>

        </div>
    </section>
    <footer>
        <div class="copyright">

            &copy; 2025 YADFYAD.Tous droits reveser.

        </div>
    </footer>
    <script src="script.js"></script>
</body>

</html>