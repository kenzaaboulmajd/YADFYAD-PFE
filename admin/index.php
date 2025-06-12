<?php
require "database/connexion.php";

$month = date('n');
$year = date('Y');

$analyticsStmt = $pdo->prepare("
    SELECT
        'utilisateur' AS source,
        COUNT(*) AS total,
        SUM(MONTH(date_creation) = :mois1 AND YEAR(date_creation) = :an1) AS total_mensuel,
        ROUND(
            SUM(MONTH(date_creation) = :mois1 AND YEAR(date_creation) = :an1) * 100.0 / COUNT(*),
            2
        ) AS pourcentage_mesuel
    FROM utilisateur

    UNION ALL

    SELECT
        'association' AS source,
        COUNT(*) AS total,
        SUM(MONTH(date_creation) = :mois2 AND YEAR(date_creation) = :an2) AS total_mensuel,
        ROUND(
            SUM(MONTH(date_creation) = :mois2 AND YEAR(date_creation) = :an2) * 100.0 / COUNT(*),
            2
        ) AS pourcentage_mesuel
    FROM association

    UNION ALL

    SELECT
        'association' AS source,
        COUNT(*) AS total,
        SUM(MONTH(date_creation) = :mois2 AND YEAR(date_creation) = :an2) AS total_mensuel,
        ROUND(
            SUM(MONTH(date_creation) = :mois2 AND YEAR(date_creation) = :an2) * 100.0 / COUNT(*),
            2
        ) AS pourcentage_mesuel
    FROM association
    WHERE VERIFIE = 0

    UNION ALL

    SELECT
        'publication' AS source,
        COUNT(*) AS total,
        SUM(MONTH(date_creation) = :mois3 AND YEAR(date_creation) = :an3) AS total_mensuel,
        ROUND(
            SUM(MONTH(date_creation) = :mois3 AND YEAR(date_creation) = :an3) * 100.0 / COUNT(*),
            2
        ) AS pourcentage_mesuel
    FROM publication
");

$analyticsStmt->execute([
  ':mois1' => $month,
  ':an1' => $year,
  ':mois2' => $month,
  ':an2' => $year,
  ':mois3' => $month,
  ':an3' => $year
]);

$analytics = $analyticsStmt->fetchAll(PDO::FETCH_ASSOC);

// Extract safely with null coalescing
$totalUtilisateurs = $analytics[0]['total'];
$utilisateursPourcentageMensuel = $analytics[0]['pourcentage_mesuel'];

$totalAssociations = $analytics[1]['total'];
$associationsPourcentageMensuel = $analytics[1]['pourcentage_mesuel'];

$totalVerifiedAssociations = $analytics[2]['total'];
$verifiedAssociationsPourcentageMensuel = $analytics[2]['pourcentage_mesuel'];

$totalPublications = $analytics[3]['total'];
$publicationsPourcentageMensuel = $analytics[3]['pourcentage_mesuel'];

// Associations à verifier
$verficationsStmt = $pdo->prepare("SELECT * FROM association WHERE VERIFIE = 0 LIMIT 3");
$verficationsStmt->execute();
$verifications = $verficationsStmt->fetchAll(PDO::FETCH_ASSOC);
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
          <div class="title">Tableau de bord</div>
          <div class="content-area-header-buttons">
            <button class="btn btn-outline">Exporter les données</button>
            <button class="btn">Rapport complet</button>
          </div>
        </div>
        <div class="widgets">
          <div class="widget">
            <div class="widget-header">
              <div>Utilisateurs</div>
              <div class="widget-icon">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M10.6668 14V12.6667C10.6668 11.9594 10.3859 11.2811 9.88578 10.781C9.38568 10.281 8.70741 10 8.00016 10H4.00016C3.29292 10 2.61464 10.281 2.11454 10.781C1.61445 11.2811 1.3335 11.9594 1.3335 12.6667V14"
                    stroke="#020817" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                  <path
                    d="M6.00016 7.33333C7.47292 7.33333 8.66683 6.13943 8.66683 4.66667C8.66683 3.19391 7.47292 2 6.00016 2C4.5274 2 3.3335 3.19391 3.3335 4.66667C3.3335 6.13943 4.5274 7.33333 6.00016 7.33333Z"
                    stroke="#020817" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                  <path
                    d="M14.6665 14V12.6667C14.6661 12.0758 14.4694 11.5019 14.1074 11.0349C13.7454 10.5679 13.2386 10.2344 12.6665 10.0867"
                    stroke="#020817" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                  <path
                    d="M10.6665 2.08667C11.2401 2.23354 11.7485 2.56714 12.1116 3.03488C12.4747 3.50262 12.6717 4.07789 12.6717 4.67C12.6717 5.26212 12.4747 5.83739 12.1116 6.30513C11.7485 6.77287 11.2401 7.10647 10.6665 7.25334"
                    stroke="#020817" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </div>
            </div>
            <div class="widget-valeur"><?= $totalUtilisateurs ?></div>
            <div class="widget-description">
              Nombre total d'utilisateurs inscrits
            </div>
            <div class="widget-footer">
              <span class="widget-badge"><svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                  <path d="M11 3.5L6.75 7.75L4.25 5.25L1 8.5" stroke="#15803D" stroke-linecap="round"
                    stroke-linejoin="round" />
                  <path d="M8 3.5H11V6.5" stroke="#15803D" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span>+<?= $utilisateursPourcentageMensuel ?>% ce mois</span></span>
            </div>
          </div>
          <div class="widget">
            <div class="widget-header">
              <div>Associations</div>
              <div class="widget-icon">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M4 14.6667V2.66667C4 2.31305 4.14048 1.97391 4.39052 1.72386C4.64057 1.47381 4.97971 1.33334 5.33333 1.33334H10.6667C11.0203 1.33334 11.3594 1.47381 11.6095 1.72386C11.8595 1.97391 12 2.31305 12 2.66667V14.6667H4Z"
                    stroke="#020817" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                  <path
                    d="M4.00016 8H2.66683C2.31321 8 1.97407 8.14048 1.72402 8.39052C1.47397 8.64057 1.3335 8.97971 1.3335 9.33333V13.3333C1.3335 13.687 1.47397 14.0261 1.72402 14.2761C1.97407 14.5262 2.31321 14.6667 2.66683 14.6667H4.00016"
                    stroke="#020817" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                  <path
                    d="M12 6H13.3333C13.687 6 14.0261 6.14048 14.2761 6.39052C14.5262 6.64057 14.6667 6.97971 14.6667 7.33333V13.3333C14.6667 13.687 14.5262 14.0261 14.2761 14.2761C14.0261 14.5262 13.687 14.6667 13.3333 14.6667H12"
                    stroke="#020817" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                  <path d="M6.6665 4H9.33317" stroke="#020817" stroke-width="1.33333" stroke-linecap="round"
                    stroke-linejoin="round" />
                  <path d="M6.6665 6.66666H9.33317" stroke="#020817" stroke-width="1.33333" stroke-linecap="round"
                    stroke-linejoin="round" />
                  <path d="M6.6665 9.33334H9.33317" stroke="#020817" stroke-width="1.33333" stroke-linecap="round"
                    stroke-linejoin="round" />
                  <path d="M6.6665 12H9.33317" stroke="#020817" stroke-width="1.33333" stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>
              </div>
            </div>
            <div class="widget-valeur"><?= $totalAssociations ?></div>
            <div class="widget-description">
              Nombre total d'associations inscrites
            </div>
            <div class="widget-footer">
              <span class="widget-badge"><svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                  <path d="M11 3.5L6.75 7.75L4.25 5.25L1 8.5" stroke="#15803D" stroke-linecap="round"
                    stroke-linejoin="round" />
                  <path d="M8 3.5H11V6.5" stroke="#15803D" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span>+<?= $associationsPourcentageMensuel ?>% ce mois</span></span>
            </div>
          </div>
          <div class="widget">
            <div class="widget-header">
              <div>Vérifications en attente</div>
              <div class="widget-icon">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M10.0003 1.33334H4.00033C3.6467 1.33334 3.30756 1.47381 3.05752 1.72386C2.80747 1.97391 2.66699 2.31305 2.66699 2.66667V13.3333C2.66699 13.687 2.80747 14.0261 3.05752 14.2761C3.30756 14.5262 3.6467 14.6667 4.00033 14.6667H12.0003C12.3539 14.6667 12.6931 14.5262 12.9431 14.2761C13.1932 14.0261 13.3337 13.687 13.3337 13.3333V4.66667L10.0003 1.33334Z"
                    stroke="#020817" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                  <path
                    d="M9.33301 1.33334V4C9.33301 4.35362 9.47348 4.69276 9.72353 4.94281C9.97358 5.19286 10.3127 5.33334 10.6663 5.33334H13.333"
                    stroke="#020817" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                  <path d="M6 10L7.33333 11.3333L10 8.66666" stroke="#020817" stroke-width="1.33333"
                    stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </div>
            </div>
            <div class="widget-valeur"><?= $totalVerifiedAssociations ?></div>
            <div class="widget-description">
              Associations en attente de vérification
            </div>
            <div class="widget-footer">
              <span class="widget-badge"><svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                  <path d="M11 3.5L6.75 7.75L4.25 5.25L1 8.5" stroke="#15803D" stroke-linecap="round"
                    stroke-linejoin="round" />
                  <path d="M8 3.5H11V6.5" stroke="#15803D" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span>+<?= $verifiedAssociationsPourcentageMensuel ?>% ce mois</span></span>
            </div>
          </div>
          <div class="widget">
            <div class="widget-header">
              <div>Publications</div>
              <div class="widget-icon">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M14 10C14 10.3536 13.8595 10.6928 13.6095 10.9428C13.3594 11.1929 13.0203 11.3333 12.6667 11.3333H4.66667L2 14V3.33333C2 2.97971 2.14048 2.64057 2.39052 2.39052C2.64057 2.14048 2.97971 2 3.33333 2H12.6667C13.0203 2 13.3594 2.14048 13.6095 2.39052C13.8595 2.64057 14 2.97971 14 3.33333V10Z"
                    stroke="#020817" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </div>
            </div>
            <div class="widget-valeur"><?= $totalPublications ?></div>
            <div class="widget-description">Nombre total de publications</div>
            <div class="widget-footer">
              <span class="widget-badge"><svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                  <path d="M11 3.5L6.75 7.75L4.25 5.25L1 8.5" stroke="#15803D" stroke-linecap="round"
                    stroke-linejoin="round" />
                  <path d="M8 3.5H11V6.5" stroke="#15803D" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span>+<?= $publicationsPourcentageMensuel ?>% ce mois</span></span>
            </div>
          </div>
        </div>
        <div class="cards">
          <div class="card">
            <div class="card-header">
              <div class="card-title">Vérifications en attente</div>
              <div class="card-description">
                Associations en attente de vérification
              </div>
            </div>
            <div class="card-content">
              <?php if (count($verifications) > 0): ?>
                <?php foreach ($verifications as $verification): ?>
                  <div class="association-item">
                    <div class="association-avatar"></div>
                    <div class="association-content">
                      <div class="association-name"><?= $verification["NOM_ASSOCIATION"] ?></div>
                      <div class="association-description">
                        Soumis le <?= date('d/m/Y', strtotime($verification["DATE_CREATION"])); ?>
                      </div>
                    </div>
                    <button class="btn btn-outline"
                      onclick="verifierAssociation(<?= $verification["ID_ASSOCIATION"]; ?>)">Verifier</button>
                  </div>
                <?php endforeach ?>
              <?php else: ?>
                <div class="card-empty">Aucune association est en attente de vérification</div>
              <?php endif ?>
            </div>
            <?php if (count($verifications) > 0): ?>
              <div class="card-more">
                <a href="verifications" class="btn btn-outline">Voir toutes les publications</a>
              </div>
            <?php endif ?>
          </div>
          <div class="card">
            <div class="card-header">
              <div class="card-title">Activités récentes</div>
              <div class="card-description">
                Dernières actions sur la plateforme
              </div>
            </div>
            <div class="card-content">
              <div class="recent-activity-item">
                <div class="recent-activity-icon"></div>
                <div class="recent-activity-content">
                  <div class="recent-activity-title">
                    Nouvelle association inscrite: Association Horizon
                  </div>
                  <div class="recent-activity-description">
                    Il y a 30 minutes
                  </div>
                </div>
                <div class="recent-activity-more">
                  <a href="#">Voir details</a>
                </div>
              </div>
            </div>
            <div class="card-more">
              <button class="btn btn-outline">Voir toutes les activités</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/scripts/script.js"></script>
  <script src="assets/scripts/requets.js"></script>
</body>

</html>