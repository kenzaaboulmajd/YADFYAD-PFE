<?php
session_start();
ini_set('display_errors', 'on');
$error = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $sdn = "mysql:host=localhost;dbname=yadfyad";
    $user = "root";
    $pass = "";
    $email = $_POST["email"];
    $mdps = $_POST['mdps'];
    try {
        $conn = new PDO($sdn, $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
        echo 'error' . $e->getMessage();
    }
    $sql = $conn->prepare("SELECT * FROM utilisateur WHERE EMAIL=:email");
    $sql->execute([
        ':email' => $email
    ]);
    $users = $sql->fetch(PDO::FETCH_ASSOC);
    $usersCount = $sql->rowCount();

    if ($usersCount) {
        if (password_verify($mdps, $users["MOT_DE_PASSE"])) {
            $_SESSION["email"] = $users["EMAIL"];
            $_SESSION["type"] = "utilisateur";
            $_SESSION["id_utilisateur"] = $users["ID_UTILISATEUR"];
            $_SESSION["est_visiteur"] = !(bool) $users["TYPE_UTILISATEUR"];
            header("location:actualite.php");
        }
    } else {
        $sql = $conn->prepare("SELECT * FROM association WHERE EMAIL=:email");
        $sql->execute([
            ':email' => $email
        ]);
        $association = $sql->fetch(PDO::FETCH_ASSOC);
        $associationCount = $sql->rowCount();

        if ($associationCount) {
            if (password_verify($mdps, $association["MOT_DE_PASSE"])) {
                $_SESSION["email"] = $association["EMAIL"];
                $_SESSION["type"] = "association";
                $_SESSION["id_association"] = $association["ID_ASSOCIATION"];

                header("location:actualite.php");
            }
        } else {
            $sql = $conn->prepare("SELECT * FROM admin WHERE EMAIL=:email");
            $sql->execute([
                ':email' => $email
            ]);
            $admin = $sql->fetch(PDO::FETCH_ASSOC);
            $adminCount = $sql->rowCount();

            if ($adminCount) {
                if (password_verify($mdps, $admin["MOT_DE_PASSE"])) {
                    $_SESSION["email"] = $admin["EMAIL"];
                    $_SESSION["type"] = "association";
                    $_SESSION["id_admin"] = $admin["ID_ADMIN"];

                    header("location:admin");
                }
            } else {
                $error = "email ou mot de passe incorrect";
            }

        }
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
                    <a href="/YADFYAD-PFE"><img src="assets/images/logo.png" alt="YADFYAD-logo"></a>
            </nav>
        </div>
    </header>

    <!-- SECTION -->
    <section class="connexion">
        <div class="container">
            <div class="info">
                <div class="picture"> <img src="imge-hero-removebg-preview.png" alt="image-hero"></div>
                <div class="connecte">
                    <div class="title">
                        <h2>Connexion</h2>
                        <p>Connectez-vous à votre compte YADFYAD</p>
                    </div>
                    <div class="form-error">
                        <?= $error; ?>
                    </div>
                    <form method="post" action="">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>

                        <label for="motdepasse">Mot de passe</label>
                        <input type="password" id="mdps" name="mdps" required>



                        <input type="submit" value="Se connecter">



                        <div class="question">Vous avez déjà un compte? <a href="inscription-mem.php">Inscrivez-vous</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <div class="copyright">

            &copy; 2025 YADFYAD.Tous droits reveser.

        </div>
    </footer>
</body>

</html>