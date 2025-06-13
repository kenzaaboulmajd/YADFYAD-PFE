<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YADFYAD</title>
    <link rel="icon" href="assets/images/logo.png">
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
                    <div class="rejoindre-button"> <a href="inscription.php">Rejoindre la communauté</a></div>
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
    <section id="propos">
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
                    <h3>Créez votre profil</h3>
                    <p>Présentez votre association, sa
                        mission et ses activités pour vous
                        faire connaître.</p>
                </div>
                <div class="column two">
                    <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="#059669" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-users-round-icon lucide-users-round">
                            <path d="M18 21a8 8 0 0 0-16 0" />
                            <circle cx="10" cy="8" r="5" />
                            <path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3" />
                        </svg></span>
                    <h3>Partagez vos besoins</h3>
                    <p>Publiez vos problèmes, besoins
                        ou réussites pour informer la
                        communauté.</p>
                </div>
                <div class="column three">
                    <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="#059669" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-users-round-icon lucide-users-round">
                            <path d="M18 21a8 8 0 0 0-16 0" />
                            <circle cx="10" cy="8" r="5" />
                            <path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3" />
                        </svg></span>
                    <h3>Entraidez-vous</h3>
                    <p>Commentez, aimez et partagez
                        pour soutenir d'autres
                        associations et créer des liens.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- END A  PROPOS-->

    <!-- START EXPLORER -->
    <section id="explorer" class="explorer">
        <div class=" container">
            <div class="titre">
                <h2>Explorer les associations</h2>
                <p>Voici un aperçu des activités et besoins partagés par notre communauté</p>
            </div>
            <div class="landing-posts">
                <div class="post">
                    <div class="post-header">
                        <div class="avatar"></div>
                        <div class="post-header-content">
                            <div class="post-header-name">kolna me3a ismail baalouk</div>
                            <div class="post-header-time">il y a 2 jours</div>

                        </div>
                    </div>
                    <div class="description">
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolore
                            odit eius nam eligendi.
                        </p>
                    </div>
                    <div class="icone">
                        <div class="like"> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" sp stroke="currentColor" stroke-width="1"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-heart-icon lucide-heart">
                                <path
                                    d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                            </svg> <span>2</span>
                        </div>
                        <div class="commenter">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-message-circle-icon lucide-message-circle">
                                <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z" />
                            </svg>
                            <span>2</span>
                        </div>
                    </div>

                </div>
                <div class="post">
                    <div class="post-header">
                        <div class="avatar"></div>
                        <div class="post-header-content">
                            <div class="post-header-name">kolna me3a ismail baalouk</div>
                            <div class="post-header-time">il y a 2 jours</div>

                        </div>
                    </div>
                    <div class="description">
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolore
                            odit eius nam eligendi.
                        </p>
                    </div>
                    <div class="icone">
                        <div class="like"> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" sp stroke="currentColor" stroke-width="1"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-heart-icon lucide-heart">
                                <path
                                    d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                            </svg> <span>2</span>
                        </div>
                        <div class="commenter">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-message-circle-icon lucide-message-circle">
                                <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z" />
                            </svg>
                            <span>2</span>
                        </div>
                    </div>

                </div>
                <div class="post">
                    <div class="post-header">
                        <div class="avatar"></div>
                        <div class="post-header-content">
                            <div class="post-header-name">kolna me3a ismail baalouk</div>
                            <div class="post-header-time">il y a 2 jours</div>

                        </div>
                    </div>
                    <div class="description">
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolore
                            odit eius nam eligendi.
                        </p>
                    </div>
                    <div class="icone">
                        <div class="like"> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" sp stroke="currentColor" stroke-width="1"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-heart-icon lucide-heart">
                                <path
                                    d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                            </svg> <span>2</span>
                        </div>
                        <div class="commenter">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-message-circle-icon lucide-message-circle">
                                <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z" />
                            </svg>
                            <span>2</span>
                        </div>
                    </div>

                </div>
                <div class="post">
                    <div class="post-header">
                        <div class="avatar"></div>
                        <div class="post-header-content">
                            <div class="post-header-name">kolna me3a ismail baalouk</div>
                            <div class="post-header-time">il y a 2 jours</div>

                        </div>
                    </div>
                    <div class="description">
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolore
                            odit eius nam eligendi.
                        </p>
                    </div>
                    <div class="icone">
                        <div class="like"> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" sp stroke="currentColor" stroke-width="1"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-heart-icon lucide-heart">
                                <path
                                    d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                            </svg> <span>2</span>
                        </div>
                        <div class="commenter">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-message-circle-icon lucide-message-circle">
                                <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z" />
                            </svg>
                            <span>2</span>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
    <!-- END EXPLORER -->

    <!-- START ASSOCIATION -->
    <section class="association" id="associations">
        <div class="container">
            <div class="titre">
                <h2>Associations</h2>
                <p>Rejoignez ces Associations qui collaborent déjà sur YADFYAD</p>
            </div>
            <div class="slides">
                <div class="photo-profil">
                    <div class="avatar"><img src="https://placehold.co/100" alt="profile"></div>
                    <span>association</span>
                </div>
                <div class="photo-profil">
                    <div class="avatar"></div>
                    <span>association</span>
                </div>
                <div class="photo-profil">
                    <div class="avatar"></div>
                    <span>association</span>
                </div>
                <div class="photo-profil">
                    <div class="avatar"></div>
                    <span>association</span>
                </div>
                <div class="photo-profil">
                    <div class="avatar"></div>
                    <span>association</span>
                </div>
                <div class="photo-profil">
                    <div class="avatar"></div>
                    <span>association</span>
                </div>
            </div>
        </div>
    </section>
    <!-- END ASSOCIATION -->

    <!-- START REJOINDRE -->
    <section class="rejoindre">
        <div class="container">
            <div class="info">
                <h2>Prêt à rejoindre la communauté?</h2>
                <p>Inscrivez votre association dès aujourd'hui et commencez à collaborer avec d'autres organisations
                    partageant les mêmes valeurs.</p>
            </div>
            <div class="boutton">
                <a href="inscription.php">S'inscrire gratuitement </a>
            </div>
        </div>
    </section>
    <!-- END REJOINDRE -->

    <!-- START FOOTER -->
    <footer>
        <div class="container">

            <div class="footer-link">
                <div class="logo">
                    <img src="assets/images/logo.png" alt="LOGO yadfyad">
                    <p>Plateforme collaborative pour les associations au Maroc.</p>
                </div>
                <div class="column">
                    <h3>PLATEFORME</h3>
                    <ul>
                        <li><a href="#">Problèmes</a></li>
                        <li><a href="#">Activités </a></li>
                        <li><a href="#"> Expériences</a></li>
                        <li><a href="#">Associations </a></li>

                    </ul>
                </div>

                <div class="column">
                    <h3>Ressources</h3>
                    <ul>
                        <li><a href="#">Guide d'utilisation</a></li>
                        <li><a href="#">FAQ </a></li>
                        <li><a href="#"> Blog</a></li>
                        <li><a href="#"> Événements</a></li>

                    </ul>
                </div>

                <div class="column">
                    <h3>A PROPOS</h3>
                    <ul>
                        <li><a href="#">Notre mission </a></li>
                        <li><a href="#"> Equipe</a></li>
                        <li><a href="#"> Contact</a></li>
                        <li><a href="#"> Confidentialité</a></li>

                    </ul>

                </div>
            </div>
        </div>
        <div class="copyright">

            &copy; 2025 YADFYAD.Tous droits reveser.

        </div>
    </footer>
    <!-- END FOOTER -->
    <script src="script.js"></script>
</body>

</html>