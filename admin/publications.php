<?php
require_once "database/connexion.php";

$page = isset($_GET["page"]) && $_GET["page"] ? (int) $_GET["page"] : 1;
$query = isset($_GET["q"]) && $_GET["q"] ? $_GET["q"] : "";

$offset = $page ? $page * 10 - 10 : 0;
$limit = 10;

$publicationsCountStmt = $pdo->prepare("SELECT COUNT(*) AS publicationsCount FROM publication INNER JOIN utilisateur ON publication.ID_UTILISATEUR = utilisateur.ID_UTILISATEUR LEFT JOIN association ON utilisateur.ID_ASSOCIATION = association.ID_ASSOCIATION WHERE TITRE LIKE \"%$query%\"");
$publicationsCountStmt->execute();
$publicationsCount = $publicationsCountStmt->fetch(PDO::FETCH_ASSOC)["publicationsCount"];

$pagesCountCalculationResult = (int) ceil($publicationsCount / $limit);
$pagesCount = $pagesCountCalculationResult > 0 ? (int) $pagesCountCalculationResult : 1;

$publicationsStmt = $pdo->prepare("SELECT publication.*, utilisateur.*, association.*, publication.DATE_CREATION AS publicationCreation FROM publication LEFT JOIN utilisateur ON publication.ID_UTILISATEUR = utilisateur.ID_UTILISATEUR LEFT JOIN association ON utilisateur.ID_ASSOCIATION = association.ID_ASSOCIATION WHERE TITRE LIKE \"%$query%\" LIMIT $limit OFFSET $offset");
$publicationsStmt->execute();
$publications = $publicationsStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lan.g="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tableau de bord</title>
  <link rel="stylesheet" href="assets/styles/style.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
    rel="stylesheet" />
</head>

<body>
  <div class="admin-container">
    <?php require_once "sections/sidebar.php" ?>
    <div class="content">
      <?php require_once "sections/header.php" ?>
      <div class="content-area">
        <div class="content-area-header">
          <div class="title">Gestion des publications</div>
        </div>
        <div class="cards">
          <div class="card card-wide">
            <div class="card-header">
              <div class="card-title">Publications</div>
              <div class="card-description">
                Liste des publication sur la plateforme
              </div>
            </div>
            <div class="card-content">
              <div class="card-filters">
                <input class="card-filter text" id="search" placeholder="Rechercher un publication..." autofocus
                  value="<?= $query ?>" onfocus="var temp_value=this.value; this.value=''; this.value=temp_value" />
                <select class="card-filter select">
                  <option value="" disabled selected hidden>Role</option>
                  <option value="">Role</option>
                  <option value="">Role</option>
                </select>
                <select class="card-filter select">
                  <option value="" disabled selected hidden>Statut</option>
                  <option value="">Statut</option>
                  <option value="">Statut</option>
                </select>
              </div>
              <table class="card-table">
                <tr class="card-table-row">
                  <th class="card-table-header">Publication</th>
                  <th class="card-table-header">Type</th>
                  <th class="card-table-header">Association</th>
                  <th class="card-table-header">Date</th>
                  <th class="card-table-header">Statut</th>
                  <!-- <th class="card-table-header">Vues</th> -->
                  <th class="card-table-header">Actions</th>
                </tr>
                <?php foreach ($publications as $publication): ?>
                  <tr class="card-table-row">
                    <td class="card-table-cell"><?= $publication["TITRE"] ?></td>
                    <td class="card-table-cell"><?= ucfirst($publication["TYPE_PUB"]) ?></td>
                    <td class="card-table-cell">
                      <div class="card-table-cell-with-avatar">
                        <div class="card-table-avatar">
                          <img src="https://assets.procurement.opengov.com/assets/unknown-business-logo.png" alt="">
                        </div>
                        <span><?= $publication["NOM_ASSOCIATION"] ?></span>
                      </div>
                    </td>
                    <td class="card-table-cell"><?= date('d/m/Y', strtotime($publication["publicationCreation"])); ?></td>
                    <td class="card-table-cell">
                      <span class="card-table-badge">Publié</span>
                    </td>
                    <!-- <td class="card-table-cell">0</td> -->
                    <td class="card-table-cell">
                      <div class="card-table-actions">
                        <div class="dropdown">
                          <button class="btn btn-icon dropdown-btn">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                              xmlns="http://www.w3.org/2000/svg">
                              <path
                                d="M7.99967 8.66659C8.36786 8.66659 8.66634 8.36811 8.66634 7.99992C8.66634 7.63173 8.36786 7.33325 7.99967 7.33325C7.63148 7.33325 7.33301 7.63173 7.33301 7.99992C7.33301 8.36811 7.63148 8.66659 7.99967 8.66659Z"
                                stroke="#020817" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                              <path
                                d="M12.6667 8.66659C13.0349 8.66659 13.3333 8.36811 13.3333 7.99992C13.3333 7.63173 13.0349 7.33325 12.6667 7.33325C12.2985 7.33325 12 7.63173 12 7.99992C12 8.36811 12.2985 8.66659 12.6667 8.66659Z"
                                stroke="#020817" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                              <path
                                d="M3.33366 8.66659C3.70185 8.66659 4.00033 8.36811 4.00033 7.99992C4.00033 7.63173 3.70185 7.33325 3.33366 7.33325C2.96547 7.33325 2.66699 7.63173 2.66699 7.99992C2.66699 8.36811 2.96547 8.66659 3.33366 8.66659Z"
                                stroke="#020817" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                          </button>
                          <div class="dropdown-content">
                            <div class="dropdown-item">Modifier le rôle</div>
                            <div class="dropdown-item">Supprimer</div>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                <?php endforeach ?>
              </table>
              <div class="card-pagination">
                <span>Affichage de 1 sur <?= $publicationsCount ?> publications</span>
                <div class="card-pagination-buttons">
                  <a <?= $page === 1 ? "" : "href=\"?page=" . ($page - 1) . "&q=$query" . "\"" ?>>
                    <button class="btn btn-outline" <?php echo $page === 1 ? "disabled" : "" ?>>Précédent</button>
                  </a>
                  <a <?= $page === $pagesCount ? "" : "href=\"?page=" . ($page + 1) . "&q=$query" . "\"" ?>>
                    <button class="btn btn-outline" <?php echo $page === $pagesCount ? "disabled" : "" ?>>Suivant</button>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/scripts/script.js"></script>
</body>

</html>