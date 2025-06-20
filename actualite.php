<?php
session_start();
require_once "config.php";
require_once "includes/comments-helper.php";

$sql = $pdo->prepare("SELECT * FROM utilisateur WHERE EMAIL = :email");
$sql->execute([":email" => $_SESSION["email"]]);
$utilisateur = $sql->fetch();

$sql = $pdo->prepare("
    SELECT
        publication.*,
        association.*,
        GROUP_CONCAT(DISTINCT medias_url.NOM_MEDIA SEPARATOR ',') AS media_urls,
        GROUP_CONCAT(DISTINCT liker.ID_UTILISATEUR SEPARATOR ',') AS utilisateur_likers,
        GROUP_CONCAT(DISTINCT liker.ID_ASSOCIATION SEPARATOR ',') AS association_likers,
        COUNT(DISTINCT commenter.ID_COMMENTER) AS comments_count
    FROM publication
    LEFT JOIN association ON publication.ID_ASSOCIATION = association.ID_ASSOCIATION
    LEFT JOIN medias_url ON publication.ID_PUB = medias_url.ID_PUB
    LEFT JOIN liker ON publication.ID_PUB = liker.ID_PUB
    LEFT JOIN commenter ON publication.ID_PUB = commenter.ID_PUB
    GROUP BY publication.ID_PUB
    ORDER BY publication.DATE_CREATION DESC
");
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
    <link rel="stylesheet" href="assets/styles/comments.css">
    <title>Document</title>
</head>

<body>
    <?php require_once "sections/navbar.php"; ?>
    <section>
        <div class="container">
            <div class="header-actualite">
                <!-- <div class="links-tous">
                    <ul>
                        <li> <a href="#">Tous</a></li>
                        <li> <a href="#">Problèmes</a></li>
                        <li> <a href="#">Activitès</a></li>
                        <li> <a href="#">Expériences</a></li>
                    </ul>
                </div>
                <div class="recherche">
                    <input type="text" placeholder="Rechercher...">

                </div> -->
            </div>
            <div class="posts">
                <?php foreach ($publications as $publication): ?>
                    <div class="post">
                        <div class="post-container">

                            <div class="post-header">
                                <div class="post-icone">
                                    <img src="<?= $publication["PHOTO"] ? "http://localhost/YADFYAD-PFE" . $publication["PHOTO"] : "https://assets.procurement.opengov.com/assets/unknown-business-logo.png" ?>"
                                        alt="">
                                </div>
                                <div class="post-header-contenu">
                                    <a href="profile.php?id=<?= $publication["ID_ASSOCIATION"] ?>"
                                        class="post-association"><?= $publication["NOM_ASSOCIATION"] ?></a>
                                    <div class="post-date">
                                        <?= date("d M Y, H:i", strtotime($publication["DATE_CREATION"])); ?>
                                    </div>
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
                                <?php if (!empty($publication["media_urls"])): ?>
                                    <div class="post-image">
                                        <img src="http://localhost/YADFYAD-PFE<?= explode(",", $publication["media_urls"])[0] ?>"
                                            alt="">
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
                                        <?php $utilisateur_likers = $_SESSION["type"] == "utilisateur" && !empty($publication["utilisateur_likers"]) ? explode(",", $publication["utilisateur_likers"]) : []; ?>
                                        <?php $association_likers = $_SESSION["type"] == "association" && !empty($publication["association_likers"]) ? explode(",", $publication["association_likers"]) : []; ?>
                                        <div class="icone like <?= in_array($_SESSION["type"] == "utilisateur" ? $_SESSION["id_utilisateur"] : $_SESSION["id_association"], $_SESSION["type"] == "utilisateur" ? $utilisateur_likers : $association_likers) ? "liking" : "" ?>"
                                            data-publication="<?= $publication["ID_PUB"] ?>"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-heart-icon lucide-heart">
                                                <path
                                                    d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                                            </svg>
                                        </div>
                                        <div class="valeur">
                                            <?= (!empty($publication["utilisateur_likers"]) ? count(explode(",", $publication["utilisateur_likers"])) : 0) + (!empty($publication["association_likers"]) ? count(explode(",", $publication["association_likers"])) : 0) ?>
                                        </div>
                                    </div>
                                    <div class="post-interaction-element">
                                        <div class="icone comment-toggle" data-publication="<?= $publication["ID_PUB"] ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-message-circle-icon lucide-message-circle">
                                                <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z" />
                                            </svg>
                                        </div>
                                        <div class="valeur"><?= $publication["comments_count"] ?></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Comments Section -->
                            <div class="post-comments" id="comments-<?= $publication["ID_PUB"] ?>" style="display: none;">
                                <?= renderCommentsSection($pdo, $publication["ID_PUB"], $_SESSION, 3) ?>
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <script src="script.js"></script>
    <script src="requets.js"></script>
</body>

</html>