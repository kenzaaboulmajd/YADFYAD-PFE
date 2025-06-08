<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/styles/style.css">
    <link rel="stylesheet" href="assets/styles/landingpage.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

</head>

<body>
    <?php require_once "sections/landing-navbar.php";
 ?>
    <!-- START HERO -->
    <section class="hero">
        <div class=" container">
            <div class="contenu">
                <div class="inctro">
                    <h1>Bienvenue sur YADFYAD</h1>
                    <p>YADFYAD connecte les association solidaires pour partager leurs <br>
                        besion et problemes leurs activites et s'entraider
                    </p>
                </div>
                <div class="img">
                    <img src="imge-hero-removebg-preview.png" alt="image-hero">
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </section>

    <!-- END HERO -->

    <!-- START A  PROPOS-->
    <section>
        <div class="container">
            <div class="title">
                <h2> A propos</h2>
                <p> YADFYAD simplifie la collaboration entre associations solidaires</p>

            </div>
            <div class="carres">
                <div class="column one">
                    <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="#059669" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-users-round-icon lucide-users-round">
                            <path d="M18 21a8 8 0 0 0-16 0" />
                            <circle cx="10" cy="8" r="5" />
                            <path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3" />
                        </svg></span>
                    <h3>Créez vitre profil</h3>
                    <p>Présenter votre association, sa mission et ses activités pour vous faire connaître.</p>
                </div>
                <div class="column two">
                    <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="#059669" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-users-round-icon lucide-users-round">
                            <path d="M18 21a8 8 0 0 0-16 0" />
                            <circle cx="10" cy="8" r="5" />
                            <path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3" />
                        </svg></span>
                    <h3>Créez vitre profil</h3>
                    <p>Présenter votre association, sa mission et ses activités pour vous faire connaître.</p>
                </div>
                <div class="column three">
                    <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="#059669" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-users-round-icon lucide-users-round">
                            <path d="M18 21a8 8 0 0 0-16 0" />
                            <circle cx="10" cy="8" r="5" />
                            <path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3" />
                        </svg></span>
                    <h3>Créez vitre profil</h3>
                    <p>Présenter votre association, sa mission et ses activités pour vous faire connaître.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- END A  PROPOS-->

    <!-- START EXPLORER -->
    <section class="explorer">
        <div class=" container">
            <div class="titre">
                <h2>Explorer les associations</h2>
                <p>Voici un aperçu des activités et besoins partagés par notre communauté</p>
            </div>
            <div class="landing-posts">
                <div class="post">
                    <div class="profile">
                        <div class="avatar"></div>
                        <div class="profile-content">
                            <div class="profile-name"></div>
                            <div class="profile-time"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>


    <!-- END EXPLORER -->
    <script src="script.js"></script>
</body>

</html>