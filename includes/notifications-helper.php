<?php

function creer_notification($message, $type, $lien, $type_utilisateur, $id_utilisateur)
{
  global $pdo;

  $sql = $pdo->prepare("INSERT INTO notification (MESSAGE, TYPE_NOTIFICATION, LIEN, TYPE_UTILISATEUR, ID_UTILISATEUR, EST_LU, DATE_CREATION) VALUES (:message, :type_notification, :lien, :type_utilisateur, :id_utilisateur, FALSE, NOW())");
  $sql->execute([
    ":message" => $message,
    ":type_notification" => $type,
    ":id_utilisateur" => $id_utilisateur,
    ":lien" => $lien,
    ":type_utilisateur" => $type_utilisateur,
  ]);
}