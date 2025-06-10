<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  require_once "../../database/connexion.php";

  $association_id = $_POST["association_id"];

  $associationStmt = $pdo->prepare("UPDATE association SET VERIFIE = 1, STATUT = 'VERIFIE' WHERE ID_ASSOCIATION = $association_id");
  $associationStmt->execute();

  $association = $associationStmt->fetch();
  $est_verifie = (bool) $associationStmt->rowCount();

  if (!$est_verifie)
    http_response_code(400);
  echo json_encode(["est_verifie" => $est_verifie]);
}