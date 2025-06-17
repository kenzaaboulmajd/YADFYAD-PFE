<?php
session_start();
require_once "../config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate required fields
    if (!isset($_POST["comment_id"])) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "ID du commentaire requis"]);
        exit;
    }

    $comment_id = (int)$_POST["comment_id"];
    $user_email = $_SESSION["email"];
    $user_type = $_SESSION["type"];

    try {
        // Get user information based on type
        if ($user_type == "association") {
            $sql = $pdo->prepare("SELECT ID_ASSOCIATION FROM association WHERE EMAIL = :email");
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
            $sql = $pdo->prepare("SELECT ID_UTILISATEUR FROM utilisateur WHERE EMAIL = :email");
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

        // Verify comment exists and belongs to current user
        $sql = $pdo->prepare("SELECT ID_PUB FROM commenter WHERE ID_COMMENTER = :comment_id AND ID_UTILISATEUR = :user_id AND TYPE_UTILISATEUR = :type_utilisateur");
        $sql->execute([
            ":comment_id" => $comment_id,
            ":user_id" => $user_id,
            ":type_utilisateur" => $type_utilisateur
        ]);
        
        $comment = $sql->fetch();
        if (!$comment) {
            http_response_code(403);
            echo json_encode(["success" => false, "message" => "Commentaire non trouvé ou non autorisé"]);
            exit;
        }

        $publication_id = $comment["ID_PUB"];

        // Delete comment
        $sql = $pdo->prepare("DELETE FROM commenter WHERE ID_COMMENTER = :comment_id");
        $sql->execute([":comment_id" => $comment_id]);

        // Get updated comments count for this publication
        $sql = $pdo->prepare("SELECT COUNT(*) as total FROM commenter WHERE ID_PUB = :id_pub");
        $sql->execute([":id_pub" => $publication_id]);
        $count_result = $sql->fetch();
        $total_comments = $count_result["total"];

        echo json_encode([
            "success" => true,
            "message" => "Commentaire supprimé avec succès",
            "total_comments" => $total_comments,
            "publication_id" => $publication_id
        ]);

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Erreur de base de données"]);
        error_log("Comment deletion error: " . $e->getMessage());
    }
} else {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Méthode non autorisée"]);
}
?>
