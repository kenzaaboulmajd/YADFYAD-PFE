<?php
session_start();
require_once "config.php";

$sql = $pdo->prepare("SELECT * FROM association LIMIT 12");
$sql->execute();
$associations = $sql->fetchAll()
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/style.css">
    <link rel="stylesheet" href="association.css">
    <title>Associations</title>
</head>

<body>
    <?php require_once "sections/navbar.php"; ?>

    <!-- Main Content -->
    <section class="main">
        <div class="container">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">Associations</h1>
                <p class="page-description">Découvrez les associations et leurs publications</p>
            </div>

            <!-- Search Section -->
            <!-- <div class="search-section">
                <div class="search-container">
                    <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="search" class="search-input"
                        placeholder="Rechercher des associations ou des publications..." id="searchInput">
                </div>
            </div> -->

            <!-- Associations Tab -->
            <div class="tab-content active" id="associations">
                <div class="cards-grid cards-grid-associations" id="associationsGrid">
                    <?php foreach ($associations as $association): ?>
                        <div class="card association-card">
                            <div class="card-content">
                                <div class="avatar avatar-large">
                                    <img src="<?= $association["PHOTO"] ? "http://localhost/YADFYAD-PFE" . $association["PHOTO"] : "https://assets.procurement.opengov.com/assets/unknown-business-logo.png" ?>"
                                        alt="">
                                </div>
                                <h3 class="card-title"><?= $association["NOM_ASSOCIATION"] ?></h3>
                                <p class="card-description"><?= $association["INFO"] ?></p>
                                <a href="profile.php?id=<?= $association["ID_ASSOCIATION"] ?>"><button
                                        class="btn btn-outline">
                                        <svg class="action-icon" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Voir le profile
                                    </button></a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Load More Button -->
        <div class="load-more">
            <!-- <button class="btn btn-outline" onclick="loadMoreAssociations()">Charger plus</button> -->
        </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="copyright">

            &copy; 2025 YADFYAD.Tous droits reveser.

        </div>
    </footer>

</body>

</html>