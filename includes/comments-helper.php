<?php
/**
 * Comments Helper Functions
 * Provides utility functions for handling comments display and management
 */

/**
 * Get comments count for a publication
 * @param PDO $pdo Database connection
 * @param int $publication_id Publication ID
 * @return int Number of comments
 */
function getCommentsCount($pdo, $publication_id)
{
    try {
        $sql = $pdo->prepare("SELECT COUNT(*) as total FROM commenter WHERE ID_PUB = :id_pub");
        $sql->execute([":id_pub" => $publication_id]);
        $result = $sql->fetch();
        return (int) $result["total"];
    } catch (PDOException $e) {
        error_log("Error getting comments count: " . $e->getMessage());
        return 0;
    }
}

/**
 * Get comments for a publication with user information
 * @param PDO $pdo Database connection
 * @param int $publication_id Publication ID
 * @param int $limit Number of comments to fetch (default: 5)
 * @param int $offset Offset for pagination (default: 0)
 * @return array Array of comments with user information
 */
function getCommentsForPublication($pdo, $publication_id, $limit = 20, $offset = 0)
{
    try {
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
            LIMIT 20
        ");

        $sql->bindParam(":id_pub", $publication_id, PDO::PARAM_INT);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error getting comments: " . $e->getMessage());
        return [];
    }
}

/**
 * Format comment date for display
 * @param string $date Date string from database
 * @return string Formatted date
 */
function formatCommentDate($date)
{
    $comment_time = strtotime($date);
    $current_time = time();
    $time_diff = $current_time - $comment_time;

    if ($time_diff < 60) {
        return "À l'instant";
    } elseif ($time_diff < 3600) {
        $minutes = floor($time_diff / 60);
        return $minutes . " min";
    } elseif ($time_diff < 86400) {
        $hours = floor($time_diff / 3600);
        return $hours . " h";
    } elseif ($time_diff < 604800) {
        $days = floor($time_diff / 86400);
        return $days . " j";
    } else {
        return date("d M Y", $comment_time);
    }
}

/**
 * Sanitize comment content for display
 * @param string $content Comment content
 * @return string Sanitized content
 */
function sanitizeCommentContent($content)
{
    // Remove HTML tags and convert special characters
    $content = htmlspecialchars(strip_tags($content), ENT_QUOTES, 'UTF-8');

    // Convert URLs to clickable links
    $content = preg_replace(
        '/(https?:\/\/[^\s]+)/',
        '<a href="$1" target="_blank" rel="noopener noreferrer">$1</a>',
        $content
    );

    // Convert line breaks to <br> tags
    $content = nl2br($content);

    return $content;
}

/**
 * Get user profile link based on user type
 * @param string $user_type User type (ASSOCIATION or UTILISATEUR)
 * @param int $user_id User ID
 * @return string Profile link
 */
function getUserProfileLink($user_type, $user_id)
{
    if ($user_type === 'ASSOCIATION') {
        return "profile.php?id=" . $user_id;
    } else {
        return "profile-membre.php?id=" . $user_id;
    }
}

/**
 * Check if current user can delete a comment
 * @param array $comment Comment data
 * @param array $session_data Current session data
 * @return bool True if user can delete comment
 */
function canDeleteComment($comment, $session_data)
{
    if (!isset($session_data['type']) || !isset($session_data['email'])) {
        return false;
    }

    // Users can delete their own comments
    if ($comment['TYPE_UTILISATEUR'] === 'ASSOCIATION' && $session_data['type'] === 'association') {
        return isset($session_data['id_association']) &&
            $comment['user_id'] == $session_data['id_association'];
    } elseif ($comment['TYPE_UTILISATEUR'] === 'UTILISATEUR' && $session_data['type'] === 'utilisateur') {
        return isset($session_data['id_utilisateur']) &&
            $comment['user_id'] == $session_data['id_utilisateur'];
    }

    return false;
}

/**
 * Render comments HTML for a publication
 * @param PDO $pdo Database connection
 * @param int $publication_id Publication ID
 * @param array $session_data Current session data
 * @param int $limit Number of comments to show initially
 * @return string HTML for comments section
 */
function renderCommentsSection($pdo, $publication_id, $session_data, $limit = 20)
{
    $comments = getCommentsForPublication($pdo, $publication_id, $limit);
    $total_comments = getCommentsCount($pdo, $publication_id);

    ob_start();
    ?>
    <div class="comments-section" data-publication-id="<?= $publication_id ?>">
        <div class="comments-header">
            <h4>Commentaires (<?= $total_comments ?>)</h4>
        </div>

        <?php if (isset($session_data['email'])): ?>
            <div class="comment-form">
                <div class="comment-input-container">
                    <textarea class="comment-input" placeholder="Écrivez votre commentaire..." maxlength="1000"
                        data-publication-id="<?= $publication_id ?>"></textarea>
                    <button class="comment-submit-btn" data-publication-id="<?= $publication_id ?>">
                        Publier
                    </button>
                </div>
            </div>
        <?php endif; ?>

        <div class="comments-list">
            <?php foreach ($comments as $comment): ?>
                <div class="comment-item" data-comment-id="<?= $comment['ID_COMMENTER'] ?>">
                    <div class="comment-avatar">
                        <?php if ($comment['photo']): ?>
                            <img src="<?= htmlspecialchars($comment['photo']) ?>" alt="Avatar">
                        <?php else: ?>
                            <div class="default-avatar"><?= strtoupper(substr($comment['nom'], 0, 1)) ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="comment-content">
                        <div class="comment-header">
                            <a href="<?= getUserProfileLink($comment['TYPE_UTILISATEUR'], $comment['user_id']) ?>"
                                class="comment-author">
                                <?= htmlspecialchars($comment['nom']) ?>
                            </a>
                            <span class="comment-date"><?= formatCommentDate($comment['DATE']) ?></span>
                            <?php if (canDeleteComment($comment, $session_data)): ?>
                                <button class="comment-delete-btn" data-comment-id="<?= $comment['ID_COMMENTER'] ?>">
                                    ×
                                </button>
                            <?php endif; ?>
                        </div>
                        <div class="comment-text">
                            <?= sanitizeCommentContent($comment['CONTENU']) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- <?php if ($total_comments > $limit): ?>
            <div class="comments-load-more">
                <button class="load-more-comments-btn" data-publication-id="<?= $publication_id ?>" data-page="2">
                    Voir plus de commentaires (<?= $total_comments - $limit ?> restants)
                </button>
            </div>
        <?php endif; ?> -->
    </div>
    <?php
    return ob_get_clean();
}
?>