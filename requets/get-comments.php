<?php
session_start();
require_once "../config.php";

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Validate required fields
    if (!isset($_GET["publication_id"])) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Publication ID est requis"]);
        exit;
    }

    $publication_id = (int)$_GET["publication_id"];
    $page = isset($_GET["page"]) ? max(1, (int)$_GET["page"]) : 1;
    $limit = isset($_GET["limit"]) ? min(50, max(5, (int)$_GET["limit"])) : 10;
    $offset = ($page - 1) * $limit;

    try {
        // Verify publication exists
        $sql = $pdo->prepare("SELECT ID_PUB FROM publication WHERE ID_PUB = :id_pub");
        $sql->execute([":id_pub" => $publication_id]);
        if (!$sql->fetch()) {
            http_response_code(404);
            echo json_encode(["success" => false, "message" => "Publication non trouvée"]);
            exit;
        }

        // Get total comments count
        $sql = $pdo->prepare("SELECT COUNT(*) as total FROM commenter WHERE ID_PUB = :id_pub");
        $sql->execute([":id_pub" => $publication_id]);
        $count_result = $sql->fetch();
        $total_comments = $count_result["total"];

        // Get comments with user information
        $sql = $pdo->prepare("
            SELECT 
                c.ID_COMMENTER,
                c.CONTENU,
                c.DATE,
                c.TYPE_UTILISATEUR,
                CASE 
                    WHEN c.TYPE_UTILISATEUR = 'ASSOCIATION' THEN a.NOM_ASSOCIATION
                    ELSE CONCAT(u.PRENOM, ' ', u.NOM)
                END as nom,
                CASE 
                    WHEN c.TYPE_UTILISATEUR = 'ASSOCIATION' THEN a.PHOTO
                    ELSE u.PHOTO
                END as photo,
                CASE 
                    WHEN c.TYPE_UTILISATEUR = 'ASSOCIATION' THEN a.ID_ASSOCIATION
                    ELSE u.ID_UTILISATEUR
                END as user_id
            FROM commenter c
            LEFT JOIN association a ON c.TYPE_UTILISATEUR = 'ASSOCIATION' AND c.ID_UTILISATEUR = a.ID_ASSOCIATION
            LEFT JOIN utilisateur u ON c.TYPE_UTILISATEUR = 'UTILISATEUR' AND c.ID_UTILISATEUR = u.ID_UTILISATEUR
            WHERE c.ID_PUB = :id_pub
            ORDER BY c.DATE DESC
            LIMIT :limit OFFSET :offset
        ");
        
        $sql->bindParam(":id_pub", $publication_id, PDO::PARAM_INT);
        $sql->bindParam(":limit", $limit, PDO::PARAM_INT);
        $sql->bindParam(":offset", $offset, PDO::PARAM_INT);
        $sql->execute();
        
        $comments = $sql->fetchAll(PDO::FETCH_ASSOC);

        // Format comments for response
        $formatted_comments = [];
        foreach ($comments as $comment) {
            $formatted_comments[] = [
                "id" => $comment["ID_COMMENTER"],
                "contenu" => $comment["CONTENU"],
                "date" => $comment["DATE"],
                "nom" => $comment["nom"],
                "photo" => $comment["photo"],
                "type_utilisateur" => $comment["TYPE_UTILISATEUR"],
                "user_id" => $comment["user_id"],
                "formatted_date" => date("d M Y, H:i", strtotime($comment["DATE"]))
            ];
        }

        $total_pages = ceil($total_comments / $limit);

        echo json_encode([
            "success" => true,
            "comments" => $formatted_comments,
            "pagination" => [
                "current_page" => $page,
                "total_pages" => $total_pages,
                "total_comments" => $total_comments,
                "has_more" => $page < $total_pages
            ]
        ]);

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Erreur de base de données"]);
        error_log("Comments fetch error: " . $e->getMessage());
    }
} else {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Méthode non autorisée"]);
}
?>
