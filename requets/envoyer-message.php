<?php
session_start();
require_once "../config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $contenu = $_POST["contenu"];
  $type_destinataire = $_POST["type_destinataire"];
  $id_destinataire = $_POST["id_destinataire"];

  $sql = $pdo->prepare("INSERT INTO message (MESSAGE, EXPEDITEUR_ID, DESTINATAIRE_ID, DESTINATAIRE_TYPE, EXPEDITEUR_TYPE, DATE_CREATION) VALUES (:message, :expediteur_id, :destinataire_id, :destinataire_type, :expediteur_type, NOW())");
  $sql->execute([
    ":message" => $contenu,
    ":expediteur_id" => $_SESSION["type"] === "UTILISATEUR" ? $_SESSION["id_utilisateur"] : $_SESSION["id_association"],
    ":destinataire_id" => $id_destinataire,
    ":destinataire_type" => $type_destinataire,
    ":expediteur_type" => ctype_upper($_SESSION["type"])
  ]);

  $stmt = $pdo->prepare("SELECT * FROM message WHERE (EXPEDITEUR_ID = :exp AND DESTINATAIRE_ID = :dest) OR (EXPEDITEUR_ID = :dest AND DESTINATAIRE_ID = :exp) ORDER BY DATE_CREATION DESC LIMIT 1");
  $stmt->execute([':exp' => $_SESSION["type"] == 'UTILISATEUR' ? $_SESSION['id_utilisateur'] : $_SESSION['id_association'], ':dest' => $id_destinataire]);
  $message = $stmt->fetch(PDO::FETCH_ASSOC);

  echo json_encode(["success" => true, "message" => $message["MESSAGE"], "time" => $message["DATE_CREATION"]]);
}