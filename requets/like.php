<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_email = $_SESSION["email"];
    $publication_id = $_POST["publication_id"];

    require_once "../config.php";

    if ($_SESSION["type"] == "association") {
        $sql = $pdo->prepare("SELECT * FROM association WHERE EMAIL = :email");
        $sql->execute([":email" => $user_email]);
        $association = $sql->fetch();
        $association_id = $association["ID_ASSOCIATION"];
    } else {
        $sql = $pdo->prepare("SELECT * FROM utilisateur WHERE EMAIL = :email");
        $sql->execute([":email" => $user_email]);
        $utilisateur = $sql->fetch();
        $user_id = $utilisateur["ID_UTILISATEUR"];
    }


    if ($_SESSION["type"] == "association") {
        $sql = $pdo->prepare("SELECT * FROM liker WHERE ID_ASSOCIATION = :id_association AND ID_PUB = :id_publication");
        $sql->execute([
            ":id_association" => isset($association_id) ? $association_id : null,
            ":id_publication" => $publication_id
        ]);
    } else {
        $sql = $pdo->prepare("SELECT * FROM liker WHERE ID_UTILISATEUR = :id_utilisateur AND ID_PUB = :id_publication");
        $sql->execute([
            ":id_utilisateur" => isset($user_id) ? $user_id : null,
            ":id_publication" => $publication_id
        ]);
    }
    $likes = $sql->fetch();
    $is_liking = (bool) $sql->rowCount();

    if (!$is_liking) {
        $sql = $pdo->prepare("INSERT INTO liker (ID_UTILISATEUR, ID_PUB, ID_ASSOCIATION, DATE) VALUES (:id_utilisateur, :id_publication, :id_association, now())");
        $sql->execute([
            ":id_utilisateur" => isset($user_id) ? $user_id : null,
            ":id_publication" => $publication_id,
            ":id_association" => isset($association_id) ? $association_id : null
        ]);
        $is_liking = true;
    } else {
        $sql = $pdo->prepare("DELETE FROM liker WHERE (ID_UTILISATEUR = :id_utilisateur OR ID_ASSOCIATION = :id_association) AND ID_PUB = :id_publication");
        $sql->execute([
            ":id_utilisateur" => isset($user_id) ? $user_id : null,
            ":id_publication" => $publication_id,
            ":id_association" => isset($association_id) ? $association_id : null
        ]);
        $is_liking = false;
    }

    $sql = $pdo->prepare("SELECT * FROM liker WHERE ID_PUB = :id_publication");
    $sql->execute([
        ":id_publication" => $publication_id
    ]);
    $likes = $sql->fetch();
    $likesCount = $sql->rowCount();

    require_once "../includes/notifications-helper.php";
    if ($is_liking)
        creer_notification(($_SESSION["type"] == "utilisateur" ? $utilisateur["PRENOM"] . " " . $utilisateur["NOM"] : $association["NOM_ASSOCIATION"]) . " a aimé votre publication.", "LIKE", "", "ASSOCIATION", $likes["ID_ASSOCIATION"]);

    echo json_encode(["is_liking" => $is_liking, "count" => $likesCount]);
}