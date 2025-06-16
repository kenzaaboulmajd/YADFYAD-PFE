<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_email = $_SESSION["email"];
    $publication_id = $_POST["publication_id"];

    require_once "../config.php";

    $sql = $pdo->prepare("SELECT * FROM utilisateur WHERE EMAIL = :email");
    $sql->execute([
        ":email" => $user_email,
    ]);
    $utilisateur = $sql->fetch();
    $user_id = $utilisateur["ID_UTILISATEUR"];

    $sql = $pdo->prepare("SELECT * FROM liker WHERE ID_UTILISATEUR = :id_utilisateur AND ID_PUB = :id_publication");
    $sql->execute([
        ":id_utilisateur" => $user_id,
        ":id_publication" => $publication_id
    ]);
    $likes = $sql->fetch();
    $is_liking = (bool) $sql->rowCount();

    if (!$is_liking) {
        $sql = $pdo->prepare("INSERT INTO liker (ID_UTILISATEUR, ID_PUB, DATE) VALUES (:id_utilisateur, :id_publication, now())");
        $sql->execute([
            ":id_utilisateur" => $user_id,
            ":id_publication" => $publication_id
        ]);
        $is_liking = true;
    } else {
        $sql = $pdo->prepare("DELETE FROM liker WHERE ID_UTILISATEUR = :id_utilisateur AND ID_PUB = :id_publication");
        $sql->execute([
            ":id_utilisateur" => $user_id,
            ":id_publication" => $publication_id
        ]);
        $is_liking = false;
    }

    $sql = $pdo->prepare("SELECT * FROM liker WHERE ID_UTILISATEUR = :id_utilisateur AND ID_PUB = :id_publication");
    $sql->execute([
        ":id_utilisateur" => $user_id,
        ":id_publication" => $publication_id
    ]);
    $likes = $sql->fetch();
    $likesCount = $sql->rowCount();

    echo json_encode(["is_liking" => $is_liking, "count" => $likesCount]);
}