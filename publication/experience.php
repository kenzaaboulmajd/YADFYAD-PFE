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

                <form action="experience.php" method="post">
                    <div class="form-group experience">
                        <label for="titre">Titre </label>
                        <input type="text" id="titre" name="titre" placeholder="Entrez le titre de votre experience"
                            required>

                        <label for="lieu">lieu</label>
                        <input type="text" id="resume" name="resume" placeholder="Entrez le lieu du experience"
                            required>

                        <label for="content">contenu dettaille:</label>
                        <textarea id="content" name="content" rows="5" cols="40" required></textarea>

                        <label for="tags">Tags (séparés par des virgules)</label>
                        <input type="text" id="tags" name="tags" placeholder="Entrez des tags pour votre experience"
                            required>

                        <label>Photo de l'expérience (optionnelle)</label>
                        <label for="preuve" class="custom-file-upload">
                            <div class="custom-button-upload">Choisir une image</div>
                        </label>
                        <input type="file" id="preuve" name="preuve" hidden>

                        <input type="submit" class="experience" value="Publier l'experience">
                    </div>
                </form>

            </div>
        </div>
    </section>
</body>

</html>