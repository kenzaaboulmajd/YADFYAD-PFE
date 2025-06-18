<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_email = $_SESSION["email"];
    $association_id = $_POST["association_id"];

    require_once "../config.php";

    $sql = $pdo->prepare("SELECT * FROM utilisateur WHERE EMAIL = :email");
    $sql->execute([
        ":email" => $user_email,
    ]);
    $utilisateur = $sql->fetch();
    $user_id = $utilisateur["ID_UTILISATEUR"];

    $sql = $pdo->prepare("SELECT * FROM suivi WHERE ID_UTILISATEUR = :id_utilisateur AND ID_ASSOCIATION = :id_association");
    $sql->execute([
        ":id_utilisateur" => $user_id,
        ":id_association" => $association_id
    ]);
    $suivi = $sql->fetch();
    $is_following = (bool) $sql->rowCount();

    if (!$is_following) {
        $sql = $pdo->prepare("INSERT INTO suivi (ID_UTILISATEUR, ID_ASSOCIATION, DATE_SUIVUI) VALUES (:id_utilisateur, :id_association, now())");
        $sql->execute([
            ":id_utilisateur" => $user_id,
            ":id_association" => $association_id
        ]);
        $is_following = true;
    } else {
        $sql = $pdo->prepare("DELETE FROM suivi WHERE ID_UTILISATEUR = :id_utilisateur AND ID_ASSOCIATION = :id_association");
        $sql->execute([
            ":id_utilisateur" => $user_id,
            ":id_association" => $association_id
        ]);
        $is_following = false;
    }

    $sql = $pdo->prepare("SELECT * FROM suivi WHERE ID_UTILISATEUR = :id_utilisateur AND ID_ASSOCIATION = :id_association");
    $sql->execute([
        ":id_utilisateur" => $user_id,
        ":id_association" => $association_id
    ]);
    $suivis = $sql->fetch();
    $suivisCount = $sql->rowCount();

    require_once "../includes/notifications-helper.php";
    if ($is_following)
        creer_notification(($_SESSION["type"] == "utilisateur" ? $utilisateur["PRENOM"] . " " . $utilisateur["NOM"] : $association["NOM_ASSOCIATION"]) . " vient de vous suivre.", "SUIVI", "", "ASSOCIATION", $suivis["ID_ASSOCIATION"]);

    echo json_encode(["is_following" => $is_following]);
}