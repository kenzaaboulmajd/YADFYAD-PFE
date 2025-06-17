<?php
session_start();
require_once "config.php";
require_once "includes/comments-helper.php";

$id_association = $_GET["id"];

$publications = [];

$sql = $pdo->prepare("SELECT * FROM utilisateur WHERE EMAIL = :email");
$sql->execute([":email" => $_SESSION["email"]]);
$utilisateur = $sql->fetch();

$sql = $pdo->prepare("SELECT * FROM suivi WHERE ID_ASSOCIATION = :id_association AND ID_UTILISATEUR = :id_utilisateur");
$sql->execute([":id_association" => $id_association, ":id_utilisateur" => $utilisateur["ID_UTILISATEUR"]]);
$suivis = $sql->fetch();
$is_following = (bool) $sql->rowCount();

$sql = $pdo->prepare("SELECT association.*, utilisateur.*, association.EMAIL AS EMAIL_ASSOCIATION, association.SITEWEB AS SITEWEB_ASSOCIATION FROM association INNER JOIN utilisateur ON association.ID_ASSOCIATION = utilisateur.ID_ASSOCIATION WHERE association.ID_ASSOCIATION = :id_association");
$sql->execute([":id_association" => $id_association]);

$association = $sql->fetch();

if ($sql->rowCount()) {
    $sql = $pdo->prepare("
        SELECT
            publication.*,
            association.*,
            utilisateur.*,
            GROUP_CONCAT(DISTINCT medias_url.NOM_MEDIA SEPARATOR ',') AS media_urls,
            GROUP_CONCAT(DISTINCT liker.ID_UTILISATEUR SEPARATOR ',') AS likers,
            COUNT(DISTINCT commenter.ID_COMMENTER) AS comments_count
        FROM publication
        INNER JOIN utilisateur ON publication.ID_UTILISATEUR = utilisateur.ID_UTILISATEUR
        LEFT JOIN association ON utilisateur.ID_ASSOCIATION = association.ID_ASSOCIATION
        LEFT JOIN medias_url ON publication.ID_PUB = medias_url.ID_PUB
        LEFT JOIN liker ON publication.ID_PUB = liker.ID_PUB
        LEFT JOIN commenter ON publication.ID_PUB = commenter.ID_PUB
        WHERE association.ID_ASSOCIATION = :id_association
        GROUP BY publication.ID_PUB
        ORDER BY publication.DATE_CREATION DESC
    ");
    $sql->execute([":id_association" => $association["ID_ASSOCIATION"]]);

    $publications = $sql->fetchAll();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $association["NOM_ASSOCIATION"]; ?> | Profile</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap">
    <link rel="stylesheet" href="assets/styles/style.css">
    <link rel="stylesheet" href="profile-association.css">
    <link rel="stylesheet" href="actualite.css">
    <link rel="stylesheet" href="assets/styles/comments.css">
</head>

<body>
    <!-- NAVBARE -->
    <?php require_once "sections/navbar.php"; ?>

    <!-- posts section -->
    <section>
        <div class="container">
            <div class="head-profil">
                <div class="photo-profil">
                    <img src=<?= $association["PHOTO"] ? "http://localhost/YADFYAD-PFE" . $association["PHOTO"] : "https://assets.procurement.opengov.com/assets/unknown-business-logo.png" ?>>
                </div>
                <div class="script-profil">
                    <h2><?= $association["NOM_ASSOCIATION"] ?></h2>
                    <p><?= $association["INFO"] ?></p>
                    <div class="lieu"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-map-pin-icon lucide-map-pin">
                            <path
                                d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                            <circle cx="12" cy="10" r="3" />
                        </svg><?= $association["ADRESSE"] ?></div>
                </div>
                <div class="bouttons">
                    <!-- <label for="publication">Nouvelle publication :</label> -->

                    <a class="follow <?= $is_following ? "following" : "" ?>"
                        data-association="<?= $id_association ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-heart-icon lucide-heart">
                            <path
                                d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                        </svg><span class="follow-status"><?= $is_following ? "Suivi(e)" : "Suivre" ?></span></a>
                </div>
            </div>
            <div class="nombre">
                <div class="abonnes"><span style="color:green;">0</span> Abonnés</div>
                <div class="membres"><span style="color:blue ;">0 </span>Membres</div>
            </div>
            <div class="links-profile">
                <ul class="links association-profile-tabs-triggers">
                    <!-- javascript -->
                    <li class="tab-trigger active" data-tab="publications">Publications</li>
                    <li class="tab-trigger" data-tab="about">About</li>
                    <li class="tab-trigger" data-tab="contact">Contact</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- publication -->
    <section>
        <div class="container association-profile-tabs">
            <div class="posts tab active" data-tab="publications">
                <?php foreach ($publications as $publication): ?>
                    <div class="post">
                        <div class="post-container">

                            <div class="post-header">
                                <div class="post-icone">
                                    <img src="<?= $publication["PHOTO"] ? "http://localhost/YADFYAD-PFE" . $publication["PHOTO"] : "https://assets.procurement.opengov.com/assets/unknown-business-logo.png" ?>"
                                        alt="">
                                </div>
                                <div class="post-header-contenu">
                                    <div class="post-association"><?= $publication["NOM_ASSOCIATION"] ?></div>
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
                                <?php if ($publication["media_urls"]): ?>
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
                                        <div class="icone like <?= in_array($utilisateur["ID_UTILISATEUR"], explode(",", $publication["likers"])) ? "liking" : "" ?>"
                                            data-publication="<?= $publication["ID_PUB"] ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-heart-icon lucide-heart">
                                                <path
                                                    d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                                            </svg>
                                        </div>
                                        <div class="valeur">
                                            <?= !empty($publication["likers"]) ? count(explode(",", $publication["likers"])) : 0 ?>
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
            <div class="about tab" data-tab="about">
                <div class="about-titre">Description</div>
                <div class="about-text"><?= $publication["INFO"] ?></div>
                <div class="about-soustitre">Domaine d'activités</div>
                <div class="about-text"><?= $publication["DOMAINE"] ?></div>
            </div>
            <div class="contact tab" data-tab="contact">
                <div class="contact-titre">Informations de contact</div>
                <div class="contact-items">
                    <div class="contact-item">
                        <div class="contact-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-mail-icon lucide-mail">
                                <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7" />
                                <rect x="2" y="4" width="20" height="16" rx="2" />
                            </svg></div>
                        <div class="contact-value"><?= $association["EMAIL_ASSOCIATION"] ?></div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-phone-icon lucide-phone">
                                <path
                                    d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384" />
                            </svg></div>
                        <div class="contact-value"><?= $association["NUMERO_TELEPHONE"] ?></div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-globe-icon lucide-globe">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20" />
                                <path d="M2 12h20" />
                            </svg></div>
                        <div class="contact-value"><?= $association["SITEWEB"] ?></div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-map-pin-icon lucide-map-pin">
                                <path
                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                                <circle cx="12" cy="10" r="3" />
                            </svg></div>
                        <div class="contact-value"><?= $association["ADRESSE"] ?></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="script.js"></script>
    <script src="requets.js"></script>
</body>

</html>