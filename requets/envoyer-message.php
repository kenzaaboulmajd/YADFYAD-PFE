<?php
session_start();
require_once "../config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $contenu = $_POST["contenu"];
  $type_expediteur = $_POST["type_expediteur"];
  $type_destinataire = $_POST["type_destinataire"];
  $id_destinataire = $_POST["id_destinataire"];

  if ($type_expediteur === "UTILISATEUR") {
    $email = $_SESSION["email"];
    $stmt = $pdo->prepare("SELECT ID_UTILISATEUR FROM utilisateur WHERE EMAIL = :email");
    $stmt->execute([":email" => $email]);
    $exp = $stmt->fetch();
    $id_expediteur = $exp["ID_UTILISATEUR"];

    $query = $pdo->prepare("
            INSERT INTO message (CONTENU, ID_EXPEDITEUR_UTILISATEUR, ID_DESTINATAIRE_UTILISATEUR, ID_DESTINATAIRE_ASSOCIATION, DATE_ENVOI)
            VALUES (:contenu, :id_exp, :id_dest_user, :id_dest_asso, now())
        ");
    $query->execute([
      ":contenu" => $contenu,
      ":id_exp" => $id_expediteur,
      ":id_dest_user" => $type_destinataire === "UTILISATEUR" ? $id_destinataire : null,
      ":id_dest_asso" => $type_destinataire === "ASSOCIATION" ? $id_destinataire : null
    ]);
  }

  // même logique si c’est une association qui envoie le message...
  // (tu peux ajouter ça selon ton système de session)

  echo json_encode(["success" => true]);
}