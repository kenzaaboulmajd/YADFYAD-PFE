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
    <!-- START section -->
    <section>

        <div class="direction">
            <a href="../actualite.php"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                    viewBox="0 0 24 24" fill="none" stroke="#7d7d7d" stroke-width="1" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-arrow-left-icon lucide-arrow-left">
                    <path d="m12 19-7-7 7-7" />
                    <path d="M19 12H5" />
                </svg></a>
            <span>Retour au fil d'actualité</span>
        </div>
        <div class="container">

            <div class="titre">
                <div class="icone"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"
                        fill="none" stroke="#ff0000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-circle-alert-icon lucide-circle-alert">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" x2="12" y1="8" y2="12" />
                        <line x1="12" x2="12.01" y1="16" y2="16" />
                    </svg></div>
                <h2>Publier un problème</h2>
                <p>Partagez votre défi avec la communauté pour recevoir de l'aide </p>
            </div>
            <div class="box">
                <div class="title">
                    <h3>Détails du problème</h3>
                    <p>Remplissez les informations ci-dessous pour publier votre problème</p>
                </div>
                <form action="probleme.php" method="post">
                    <div class="form-group">
                        <label for="titre">Titre du problème</label>

                        <input type="text" id="titre" name="titre" placeholder="Entrez le titre de votre problème"
                            equired>
                        <label for="lieu">Lieu</label>
                        <input type="text" id="lieu" name="lieu" placeholder="Entrez le lieu du problème" required>
                        <label for="content"> Description :</label>
                        <textarea id="content" name="content" rows="5" cols="50" required></textarea>
                        <label for="tags">Tags (séparés par des virgules)</label>
                        <input type="text" id="tags" name="tags" placeholder="Entrez des tags pour votre problème"
                            required>

                        <input type="submit" value="Publier le problème">

                    </div>
                </form>
            </div>
    </section>
</body>

</html>