<?php
  session_start();
  require_once "config.php";

  $sql = $pdo->prepare("SELECT publication.*, association.*, utilisateur.*, GROUP_CONCAT(medias_url.NOM_MEDIA SEPARATOR ',') AS media_urls FROM publication INNER JOIN utilisateur ON publication.ID_UTILISATEUR = utilisateur.ID_UTILISATEUR LEFT JOIN association ON utilisateur.ID_ASSOCIATION = association.ID_ASSOCIATION LEFT JOIN medias_url ON publication.ID_PUB = medias_url.ID_PUB GROUP BY publication.ID_PUB");
  $sql->execute();

  $publications = $sql->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/style.css">
    <link rel="stylesheet" href="actualite.css">
    <title>Document</title>
</head>

<body>
    <header><?php require_once "sections/navbar.php"; ?></header>
    <section>
        <div class="container">
            <div class="header-actualite">
                <div class="links-tous">
                    <ul>
                        <li> <a href="#">Tous</a></li>
                        <li> <a href="#">Problèmes</a></li>
                        <li> <a href="#">Activitès</a></li>
                        <li> <a href="#">Expériences</a></li>
                    </ul>
                </div>
                <div class="recherche">
                    <input type="text" placeholder="Rechercher...">

                </div>
            </div>
            <div class="posts">
                <?php foreach ($publications as $publication): ?>
                <div class="post">
                    <div class="post-container">

                        <div class="post-header">
                            <div class="post-icone"></div>
                            <div class="post-header-contenu">
                                <div class="post-association"><?= $publication["NOM_ASSOCIATION"] ?></div>
                                <div class="post-date">
                                    <?= date("d M Y, H:i", strtotime($publication["DATE_CREATION"])); ?></div>
                            </div>
                            <div class="post-type <?= str_replace(["è", "é"], "e", $publication["TYPE_PUB"]) ?>"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="lucide lucide-calendar-days-icon lucide-calendar-days">
                                    <path d="M8 2v4" />
                                    <path d="M16 2v4" />
                                    <rect width="18" height="18" x="3" y="4" rx="2" />
                                    <path d="M3 10h18" />
                                    <path d="M8 14h.01" />
                                    <path d="M12 14h.01" />
                                    <path d="M16 14h.01" />
                                    <path d="M8 18h.01" />
                                    <path d="M12 18h.01" />
                                    <path d="M16 18h.01" />
                                </svg><span><?= $publication["TYPE_PUB"] ?></span></div>
                        </div>
                        <div class="post-contenu">
                            <div class="post-titre"><?= $publication["TITRE"] ?></div>
                            <div class="post-description"><?= $publication["DISCRIPTION"] ?></div>
                            <?php if ($publication["media_urls"]): ?>
                            <div class="post-image">
                                <img src=<?= explode(",", $publication["media_urls"])[0] ?> alt="">
                            </div>
                            <?php endif; ?>
                            <div class="post-info">
                                <?php if ($publication["LIEU_EVENEMENT_LACTIVITE"]): ?>
                                <div class="post-info-element">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-map-pin-icon lucide-map-pin">
                                        <path
                                            d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                                        <circle cx="12" cy="10" r="3" />
                                    </svg>
                                    <span><?= $publication["LIEU_EVENEMENT_LACTIVITE"] ?></span>
                                </div>
                                <?php endif; ?>
                                <?php if ($publication["DATE_EVENEMENT_ACTIVITE"]): ?>
                                <div class="post-info-element">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-clock10-icon lucide-clock-10">
                                        <circle cx="12" cy="12" r="10" />
                                        <polyline points="12 6 12 12 8 10" />
                                    </svg>
                                    <span><?= date("d M Y", strtotime($publication["DATE_EVENEMENT_ACTIVITE"])) ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="post-interactions">
                                <div class="post-interaction-element">
                                    <div class="icone"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-heart-icon lucide-heart">
                                            <path
                                                d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                                        </svg>
                                    </div>
                                    <div class="valeur">3</div>
                                    <div class="valeur">3</div>
                                </div>
                                <div class="post-interaction-element">
                                    <div class="icone"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-message-circle-icon lucide-message-circle">
                                            <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z" />
                                        </svg>
                                    </div>
                                    <div class="valeur">12</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <script src="script.js"></script>
</body>

</html>