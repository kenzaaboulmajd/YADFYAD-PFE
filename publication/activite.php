<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style1.css">
    <title>Document</title>
</head>

<body>


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
                <div class="icone"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="#ae00ff" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-lightbulb-icon lucide-lightbulb">
                        <path
                            d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.7 1.3 1.5 1.5 2.5" />
                        <path d="M9 18h6" />
                        <path d="M10 22h4" />
                    </svg></div>
                <h2>Partager une activité</h2>
                <p>Montrez à la communauté les belles actions que vous réalisez ! 🌟</p>
                <div class="box">
                    <div class="title">
                        <h3>Détails de l'activité</h3>
                        <p>Partagez les informations sur une activité que votre association a réalisée</p>
                    </div>

                    <form action="experience.php" method="post">
                        <div class="form-group">
                            <label for="titre">Titre de l'activité </label><br>
                            <input type="text" id="titre" name="titre" placeholder="Entrez le titre de votre experience"
                                required> <br>

                            <label for="date">date</label><br>
                            <input type="text" id="date" name="date" placeholder="Entrez la date d activite" required>

                            <label for="lieu">lieu</label><br>
                            <input type="text" id="lieu" name="lieu" placeholder="Entrez le resume du experience"
                                required><br>

                            <label for="content">Description de l'activite</label><br>
                            <textarea id="content" name="content" rows="5" cols="40" required></textarea><br>



                            <label for="image">Image 'illustration (optionnelle)</label><br>
                            <input type="submit" id="image" name="img"
                                value="Entrez des tags pour votre experience"><br>

                            <input type="submit" value="Publier l'activité">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

</html>