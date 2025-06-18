<?php
session_start();
require_once "../config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate required fields
    if (!isset($_POST["publication_id"]) || !isset($_POST["contenu"]) || empty(trim($_POST["contenu"]))) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Publication ID et contenu sont requis"]);
        exit;
    }

    $publication_id = (int) $_POST["publication_id"];
    $contenu = trim($_POST["contenu"]);
    $user_email = $_SESSION["email"];
    $user_type = $_SESSION["type"];

    // Validate content length
    if (strlen($contenu) > 1000) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Le commentaire ne peut pas dépasser 1000 caractères"]);
        exit;
    }

    try {
        // Get user information based on type
        if ($user_type == "association") {
            $sql = $pdo->prepare("SELECT ID_ASSOCIATION, NOM_ASSOCIATION FROM association WHERE EMAIL = :email");
            $sql->execute([":email" => $user_email]);
            $user_data = $sql->fetch();

            if (!$user_data) {
                http_response_code(401);
                echo json_encode(["success" => false, "message" => "Association non trouvée"]);
                exit;
            }

            $user_id = $user_data["ID_ASSOCIATION"];
            $type_utilisateur = "ASSOCIATION";
        } else {
            $sql = $pdo->prepare("SELECT ID_UTILISATEUR, NOM FROM utilisateur WHERE EMAIL = :email");
            $sql->execute([":email" => $user_email]);
            $user_data = $sql->fetch();

            if (!$user_data) {
                http_response_code(401);
                echo json_encode(["success" => false, "message" => "Utilisateur non trouvé"]);
                exit;
            }

            $user_id = $user_data["ID_UTILISATEUR"];
            $type_utilisateur = "UTILISATEUR";
        }

        // Verify publication exists
        $sql = $pdo->prepare("SELECT ID_PUB, ID_ASSOCIATION FROM publication WHERE ID_PUB = :id_pub");
        $sql->execute([":id_pub" => $publication_id]);
        $publication = $sql->fetch();
        if (!$publication) {
            http_response_code(404);
            echo json_encode(["success" => false, "message" => "Publication non trouvée"]);
            exit;
        }

        // Insert comment
        $sql = $pdo->prepare("INSERT INTO commenter (ID_UTILISATEUR, TYPE_UTILISATEUR, ID_PUB, CONTENU, DATE) VALUES (:id_utilisateur, :type_utilisateur, :id_pub, :contenu, NOW())");
        $sql->execute([
            ":id_utilisateur" => $user_id,
            ":type_utilisateur" => $type_utilisateur,
            ":id_pub" => $publication_id,
            ":contenu" => $contenu
        ]);

        $comment_id = $pdo->lastInsertId();

        require_once("../includes/notifications-helper.php");
        creer_notification(($user_data["NOM_ASSOCIATION"] ?? ($user_data["PRENOM"] . $user_data["NOM"])) . " a ajouter un commentaire a votre publication", "COMMENTAIRE", "", "ASSOCIATION", $publication["ID_ASSOCIATION"]);

        // Get the newly created comment with user information
        if ($type_utilisateur == "ASSOCIATION") {
            $sql = $pdo->prepare("
                SELECT c.*, a.NOM_ASSOCIATION as nom, a.PHOTO as photo
                FROM commenter c 
                JOIN association a ON c.ID_UTILISATEUR = a.ID_ASSOCIATION 
                WHERE c.ID_COMMENTER = :comment_id
            ");
        } else {
            $sql = $pdo->prepare("
                SELECT c.*, CONCAT(u.PRENOM, ' ', u.NOM) as nom, u.PHOTO as photo
                FROM commenter c 
                JOIN utilisateur u ON c.ID_UTILISATEUR = u.ID_UTILISATEUR 
                WHERE c.ID_COMMENTER = :comment_id
            ");
        }

        $sql->execute([":comment_id" => $comment_id]);
        $comment = $sql->fetch();

        // Get total comments count for this publication
        $sql = $pdo->prepare("SELECT COUNT(*) as total FROM commenter WHERE ID_PUB = :id_pub");
        $sql->execute([":id_pub" => $publication_id]);
        $count_result = $sql->fetch();
        $total_comments = $count_result["total"];

        echo json_encode([
            "success" => true,
            "message" => "Commentaire ajouté avec succès",
            "comment" => [
                "id" => $comment["ID_COMMENTER"],
                "contenu" => $comment["CONTENU"],
                "date" => $comment["DATE"],
                "nom" => $comment["nom"],
                "photo" => $comment["photo"],
                "type_utilisateur" => $comment["TYPE_UTILISATEUR"]
            ],
            "total_comments" => $total_comments
        ]);

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Erreur de base de données"]);
        error_log("Comment insertion error: " . $e->getMessage());
    }
} else {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Méthode non autorisée"]);
}
?>