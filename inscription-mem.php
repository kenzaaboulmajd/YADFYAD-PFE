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
    <div class="design">
        <span class="left"></span>
        <span class="right"></span>
        <span class="center"> </span>
    </div>
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
                    <label for=" nom">Nom et prenom</label>
                    <input type="text" id="nom" name="nom" required>


                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>

                    <label for="motdepasse">Mot de passe</label>
                    <input type="password" id="motdepasse" name="motdepasse" required>

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
</body>

</html>