<?php
session_start();
require_once "config.php";
require_once "includes/comments-helper.php";

$email = $_SESSION["email"];

$isAssociation = false;
$isAssociationMember = false;
$publications = [];


$sql = $pdo->prepare("SELECT utilisateur.*, association.*, association.EMAIL AS EMAIL_ASSOCIATION FROM utilisateur INNER JOIN association ON utilisateur.ID_ASSOCIATION = association.ID_ASSOCIATION WHERE utilisateur.EMAIL = :email");
$sql->execute([":email" => $email]);

$association = $sql->fetch();
$isAssociationMember = (bool) $sql->rowCount();

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
    WHERE publication.ID_ASSOCIATION = :id_association
    GROUP BY publication.ID_PUB
    ORDER BY publication.DATE_CREATION DESC
");
$sql->execute([":id_association" => $association["ID_ASSOCIATION"]]);

$publications = $sql->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                <form action="modifier-photo-profile.php" enctype="multipart/form-data" method="POST">
                    <label class="photo-profil" for="profile" style="display:block;"><img src=<?= $association["PHOTO"] ? "http://localhost/YADFYAD-PFE" . $association["PHOTO"] : "https://assets.procurement.opengov.com/assets/unknown-business-logo.png" ?> alt=""></label>
                    <input type="file" id="profile" name="profile" hidden onchange="this.form.submit()">
                    <input type="text" id="association_id" hidden>
                </form>
                <div class="script-profil">
                    <h2><?= $association["NOM_ASSOCIATION"] ?></h2>
                    <div>Membre association (<?= $association["PRENOM"] . " " . $association["NOM"] ?>)</div>
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
                    <div class="new-publication-close-overlay"></div>
                    <div class="new-publication">
                        <div class="new-publication-trigger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-circle-plus-icon lucide-circle-plus">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M8 12h8" />
                                <path d="M12 8v8" />
                            </svg>
                            <span>Nouvelle Publication</span>
                        </div>
                        <div class="new-publication-types">
                            <a href="publication/activite.php" class="new-publication-type activite"><svg
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
                                </svg>Activité</a>
                            <a href="publication/probleme.php" class="new-publication-type probleme"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-info-icon lucide-info">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="M12 16v-4" />
                                    <path d="M12 8h.01" />
                                </svg>Problème</a>
                            <a href="publication/experience.php" class="new-publication-type experience"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-lightbulb-icon lucide-lightbulb">
                                    <path
                                        d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.7 1.3 1.5 1.5 2.5" />
                                    <path d="M9 18h6" />
                                    <path d="M10 22h4" />
                                </svg>Experience</a>
                        </div>
                    </div>
                    <a class="" href="modifier-profile.php"><svg xmlns="http://www.w3.org/2000/svg" width="20"
                            height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pen-icon lucide-pen">
                            <path
                                d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                        </svg></a>
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
                                        <?= date("d M Y", strtotime($publication["DATE_EVENEMENT_ACTIVITE"])) ?>
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
            <div class="about tab" data-tab="about">
                <div class="about-titre">Description</div>
                <div class="about-text"><?= $association["INFO"] ?></div>
                <div class="about-soustitre">Domaine d'activités</div>
                <div class="about-text"><?= $association["DOMAINE"] ?></div>
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