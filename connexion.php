<?php
session_start();
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
    if ($users = $sql->fetch(PDO::FETCH_ASSOC)) {
        if (password_verify($mdps, $users["MOT_DE_PASSE"])) {
            $_SESSION["email"] = $users["EMAIL"];

            header("location:actualite.php");
        }
    } else {
        echo "email ou mot de passe incorrect";
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