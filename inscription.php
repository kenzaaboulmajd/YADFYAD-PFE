<?php
ini_set('display_errors', 'on');
session_start();

$errors = array(
    "name" => "",
    "email" => "",
    "mdps" => "",
    "confirmotdepasse" => "",
    "info" => "",
    "adresse" => "",
    "numero" => "",
    "domaine" => "",
    "siteweb" => "",
);

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
    $siteweb = $_POST['siteweb'];



    try {
        $conn = new PDO($db, $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'error de cnx' . $e->getMessage();
    }


    if (empty($name)) {
        $errors["name"] = "nom de l'association est requis!";
    }
    if (empty($email)) {
        $error["email"] = "Email est requis!";
    }
    if (empty($mdps)) {
        $error["mdps"] = "Mot de passe est requis!";
    }
    if (empty($confirmotdepasse)) {
        $error["confirmotdepasse"] = "Veuillez confirmer le mot de passe!";
    }
    if (empty($info)) {
        $error["info"] = "Description est requis!";
    }
    if (empty($adresse)) {
        $error["adresse"] = "Adresse est requis!";
    }
    if (empty($numero)) {
        $error["numero"] = "Numero de telephone est requis!";
    }
    if (empty($domaine)) {
        $error["domaine"] = "Domaine de l'association est requis!";
    }
    if (empty($siteweb)) {
        $error["siteweb"] = "Siteweb de l'association est requis!";
    }

    if (empty(array_filter($errors))) {
        $hash = password_hash($mdps, PASSWORD_DEFAULT);
        $sql = $conn->prepare("INSERT INTO association (NOM_ASSOCIATION,EMAIL, MOT_DE_PASSE, INFO,ADRESSE, NUMERO_TELEPHONE, DOMAINE, VERIFIE, SITEWEB) VALUES (:nom, :email, :mdps,:info,:adresse,:numero,:domaine, FALSE, :siteweb)");
        $sql->execute([
            ':nom' => $name,
            ':email' => $email,
            ':mdps' => $hash,
            ':info' => $info,
            ':adresse' => $adresse,
            ':numero' => $numero,
            ':domaine' => $domaine,
            ':siteweb' => $siteweb,
        ]);

        // Handle file upload
        if (isset($_FILES['preuve']) && $_FILES['preuve']['error'] == UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['preuve']['tmp_name'];
            $fileName = $_FILES['preuve']['name'];
            $fileSize = $_FILES['preuve']['size'];
            $fileType = $_FILES['preuve']['type'];

            // Define the upload directory
            $uploadDir = 'uploads/';
            $dest_path = $uploadDir . basename($fileName);
            // Check if the file is an image or a video
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'video/mp4'];
            if (in_array($fileType, $allowedTypes)) {
                // Move the file to the upload directory
                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    // File successfully uploaded
                    $sql = $conn->prepare("INSERT INTO document_justificatif (NOM_IMAGE, DATE_CREATION, ID_ASSOCIATION) VALUES (:media_url, NOW(), LAST_INSERT_ID())");
                    $sql->execute([':media_url' => "/uploads/" . basename($fileName)]);
                } else {
                    echo "Error moving the uploaded file.";
                    exit();
                }
            } else {
                echo "Invalid file type. Only images and videos are allowed.";
                exit();
            }
        }

        header('location:connexion.php');
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

    <!-- START SECTION -->
    <section>
        <!-- <div class="design">
        <span class="left"></span>
        <span class="right"></span>
        <span class="center"> </span> -->

        <div class="container">
            <div class="links-boutons">
                <a href="inscription.php">Association</a>
                <a href="inscription-mem.php" class="button-active"> Membre solidaire</a>
            </div>
            <div class="description">
                <h2>Créer un compte</h2>
                <p>Rejoignez la communauté YADFYAD pour connecter avec
                    <br> d' autres associations solidaires
                </p>
            </div>

            <div class="information">
                <form method="post" class="form-group" enctype="multipart/form-data">
                    <!-- Nom de l'association -->
                    <label for="nom">Nom de l'association</label>
                    <div class="form-error"><?= $errors["name"] ?></div>
                    <input type="text" id="nom" name="nom" required>

                    <!-- Preuve (facultatif ici car pas utilisé en PHP) -->
                    <label>Preuve de l’association</label>
                    <label for="preuve" class="custom-file-upload">Télécharger les preuves de l'association
                        <div class="custom-button-upload">file du fichier</div>
                    </label>
                    <input type="file" id="preuve" name="preuve" hidden>

                    <!-- Adresse -->
                    <label for="adresse">Adresse</label>
                    <div class="form-error"><?= $errors["adresse"] ?></div>
                    <input type="text" id="adresse" name="adresse" required>

                    <!-- Email -->
                    <label for="email">Email</label>
                    <div class="form-error"><?= $errors["email"] ?></div>
                    <input type="email" id="email" name="email" required>

                    <!-- Numéro -->
                    <label for="numero">Numero de téléphone</label>
                    <div class="form-error"><?= $errors["numero"] ?></div>
                    <input type="text" id="numero" name="numero" required>

                    <!-- Siteweb -->
                    <label for="siteweb">Siteweb</label>
                    <div class="form-error"><?= $errors["siteweb"] ?></div>
                    <input type="url" id="siteweb" name="siteweb" required>

                    <!-- Mot de passe -->
                    <label for="motdepasse">Mot de passe</label>
                    <div class="form-error"><?= $errors["mdps"] ?></div>
                    <input type="password" id="motdepasse" name="motdepasse" required>

                    <!-- Confirmation -->
                    <label for="confirmotdepasse">Confirmer mot de passe</label>
                    <div class="form-error"><?= $errors["confirmotdepasse"] ?></div>
                    <input type="password" id="confirmotdepasse" name="confirmotdepasse" required>

                    <!-- Domaine -->
                    <label for="domaine">Domaine</label>
                    <div class="form-error"><?= $errors["domaine"] ?></div>
                    <input type="text" id="domaine" name="domaine" required>

                    <!-- Description -->
                    <label for="description">Description</label>
                    <div class="form-error"><?= $errors["info"] ?></div>
                    <textarea id="info" name="info" required></textarea>



                    <input type="submit" value="S'inscrire">

                    <div class="question">Vous avez déjà un compte? <a href="connexion.php"
                            class="white-button">Connectez-vous</a></div>

                </form>
            </div>
        </div>
        <!-- </div> -->

    </section>
    <footer>
        <div class=" copyright">
            <p>&copy; 2025 YADFYAD. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>