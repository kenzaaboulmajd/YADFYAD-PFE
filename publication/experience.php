<?php
session_start();
require_once "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = $_POST['titre'];
    $lieu = $_POST['lieu'];
    $content = $_POST['content'];
    $tags = $_POST['tags'];

    if ($_SESSION['type'] == 'association') {
        // Fetch association details
        $sql = $pdo->prepare("SELECT * FROM association WHERE EMAIL = :email");
        $sql->execute([':email' => $_SESSION['email']]); // Assuming you have association email in session
        $association = $sql->fetch();
    } else {
        $sql = $pdo->prepare("SELECT * FROM utilisateur INNER JOIN association ON utilisateur.ID_ASSOCIATION = association.ID_ASSOCIATION WHERE utilisateur.EMAIL = :email");
        $sql->execute([':email' => $_SESSION['email']]); // Assuming you have user email in session
        $user = $sql->fetch();
    }

    // Insert experience into the database
    $stmt = $pdo->prepare("INSERT INTO publication (TITRE, LIEU_EVENEMENT_LACTIVITE, DISCRIPTION, ID_UTILISATEUR, TYPE_PUB, DATE_CREATION, ID_ASSOCIATION) VALUES (:titre, :lieu, :content, :id_utilisateur, :type_pub, NOW(), :id_association)");
    $stmt->execute([
        ':titre' => $titre,
        ':lieu' => $lieu,
        ':content' => $content,
        ':id_utilisateur' => $_SESSION["type"] == "utilisateur" ? $_SESSION["id_utilisateur"] : null, // Assuming you have user ID in session
        ':id_association' => $_SESSION["type"] == "association" ? $_SESSION["id_association"] : $user["ID_ASSOCIATION"], // Assuming you have association ID in session
        ':type_pub' => 'expérience' // Set the publication type
    ]);

    // Handle file upload
    print_r($_FILES);
    if (isset($_FILES['media']) && $_FILES['media']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['media']['tmp_name'];
        $fileName = $_FILES['media']['name'];
        $fileSize = $_FILES['media']['size'];
        $fileType = $_FILES['media']['type'];

        // Define the upload directory
        $uploadDir = '../uploads/';
        $dest_path = $uploadDir . basename($fileName);
        // Check if the file is an image or a video
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'video/mp4'];
        if (in_array($fileType, $allowedTypes)) {
            // Move the file to the upload directory
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                // File successfully uploaded
                $sql = $pdo->prepare("INSERT INTO medias_url (NOM_MEDIA, ID_PUB) VALUES (:media_url, LAST_INSERT_ID())");
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

    $_SESSION["type"] == "utilisateur" ? header("Location:../profile-membre.php") : header("Location:../profile-association.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../assets/styles/style.css">
</head>

<body>
    <!-- NAVBARE -->
    <?php require_once "../sections/navbar.php"; ?>

    <section>
        <div class="container">
            <div class="direction">
                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="#7d7d7d" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-arrow-left-icon lucide-arrow-left">
                        <path d="m12 19-7-7 7-7" />
                        <path d="M19 12H5" />
                    </svg></a>
                <span>Retour au fil d'actualité</span>
            </div>
            <div class="titre">
                <div class="icone experience" style="background-color: #F3E8FF;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="#ae00ff" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-lightbulb-icon lucide-lightbulb">
                        <path
                            d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.7 1.3 1.5 1.5 2.5" />
                        <path d="M9 18h6" />
                        <path d="M10 22h4" />
                    </svg>
                </div>

                <h2>Partager une expérience</h2>
                <p>Vos apprentissages peuvent inspirer et aider d'autres associations ! </p>
            </div>
            <div class="box">
                <div class="title">
                    <h3>Détails de l'expérience</h3>
                    <p>Partagez une expérience significative, des leçons apprises ou des bonnes pratiques</p>
                </div>

                <form action="experience.php" method="post" enctype="multipart/form-data">
                    <div class="form-group experience">
                        <label for="titre">Titre </label>
                        <input type="text" id="titre" name="titre" placeholder="Entrez le titre de votre experience"
                            required>

                        <label for="lieu">lieu</label>
                        <input type="text" id="lieu" name="lieu" placeholder="Entrez le lieu de l'expérience" required>

                        <label for="content">contenu dettaille:</label>
                        <textarea id="content" name="content" rows="5" cols="40" required></textarea>

                        <label for="tags">Tags (séparés par des virgules)</label>
                        <input type="text" id="tags" name="tags" placeholder="Entrez des tags pour votre experience"
                            required>

                        <label>Photo de l'expérience (optionnelle)</label>
                        <label for="media" class="custom-file-upload">
                            <div class="custom-button-upload">Choisir une image</div>
                        </label>
                        <input type="file" id="media" name="media" hidden>

                        <input type="submit" class="experience" value="Publier l'experience">
                    </div>
                </form>

            </div>
        </div>
    </section>
</body>

</html>