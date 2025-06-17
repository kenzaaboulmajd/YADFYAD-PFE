<?php
session_start();
require_once "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = $_POST['titre'];
    $date = $_POST['date'];
    $lieu = $_POST['lieu'];
    $content = $_POST['content'];

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

    // Insert activity into the database
    $stmt = $pdo->prepare("INSERT INTO publication (TITRE, DATE_EVENEMENT_ACTIVITE, LIEU_EVENEMENT_LACTIVITE, DISCRIPTION, ID_UTILISATEUR, ID_ASSOCIATION, TYPE_PUB, DATE_CREATION) VALUES (:titre, :date, :lieu, :content, :id_utilisateur, :id_association, :type_pub, NOW())");
    $stmt->execute([
        ':titre' => $titre,
        ':date' => $date,
        ':lieu' => $lieu,
        ':content' => $content,
        ':id_utilisateur' => $_SESSION["type"] == "utilisateur" ? $_SESSION["id_utilisateur"] : null, // Assuming you have user ID in session
        ':id_association' => $_SESSION["type"] == "association" ? $_SESSION["id_association"] : $user["ID_ASSOCIATION"], // Assuming you have association ID
        ':type_pub' => 'activité' // Set the publication type
    ]);

    // Handle file upload
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
    <link rel="prepdoect" href="https://fonts.googleapis.com">
    <link rel="prepdoect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../assets/styles/style.css">
</head>

<body>
    <!-- NAVBARE -->
    <?php require_once "../sections/navbar.php"; ?>

    <!-- START section -->

    <section>
        <div class="container">
            <div class="direction">
                <a href="../actualite.php"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                        viewBox="0 0 24 24" fill="none" stroke="#7d7d7d" stroke-width="1" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-arrow-left-icon lucide-arrow-left">
                        <path d="m12 19-7-7 7-7" />
                        <path d="M19 12H5" />
                    </svg></a>
                <span>Retour au fil d'actualité</span>
            </div>
            <div class="titre">
                <div class="icone activite">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="green" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-calendar-icon lucide-calendar">
                        <path d="M8 2v4" />
                        <path d="M16 2v4" />
                        <rect width="18" height="18" x="3" y="4" rx="2" />
                        <path d="M3 10h18" />
                    </svg>
                </div>
                <h2>Partager une activité</h2>
                <p>Montrez à la communauté les belles actions que vous réalisez ! </p>
                <div class="box">
                    <div class="title">
                        <h3>Détails de l'activité</h3>
                        <p>Partagez les informations sur une activité que votre association a réalisée</p>
                    </div>

                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group activite">
                            <label for="titre">Titre de l'activité </label>
                            <input type="text" id="titre" name="titre" placeholder="Entrez le titre de votre experience"
                                required>

                            <label for="date">date</label>
                            <input type="date" id="date" name="date" placeholder="Entrez la date d activite" required>

                            <label for="lieu">lieu</label>
                            <input type="text" id="lieu" name="lieu" placeholder="Entrez le resume du experience"
                                required>

                            <label for="content">Description de l'activite</label>
                            <textarea id="content" name="content" rows="5" cols="40" required></textarea>


                            <label>Photo de l'activité (optionnelle)</label>
                            <label for="media" class="custom-file-upload">
                                <div class="custom-button-upload">Choisir une image</div>
                            </label>
                            <input type="file" id="media" name="media" hidden>

                            <input type="submit" class="activite" value="Publier l'activité">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

</html>