-- Create comments table for YADFYAD application
-- This table stores comments made by users and associations on publications

CREATE TABLE IF NOT EXISTS commenter (
    ID_COMMENTER INT AUTO_INCREMENT PRIMARY KEY,
    TYPE_UTILISATEUR ENUM('ASSOCIATION', 'UTILISATEUR') NOT NULL,
    ID_UTILISATEUR INT NULL,
    ID_ASSOCIATION INT NULL,
    ID_PUB INT NOT NULL,
    DATE TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONTENU TEXT NOT NULL,
    
    -- Foreign key constraints
    FOREIGN KEY (ID_PUB) REFERENCES publication(ID_PUB) ON DELETE CASCADE,
    FOREIGN KEY (ID_UTILISATEUR) REFERENCES utilisateur(ID_UTILISATEUR) ON DELETE CASCADE,
    FOREIGN KEY (ID_ASSOCIATION) REFERENCES association(ID_ASSOCIATION) ON DELETE CASCADE,
    
    -- Ensure that either ID_UTILISATEUR or ID_ASSOCIATION is set, but not both
    CONSTRAINT chk_user_type CHECK (
        (TYPE_UTILISATEUR = 'UTILISATEUR' AND ID_UTILISATEUR IS NOT NULL AND ID_ASSOCIATION IS NULL) OR
        (TYPE_UTILISATEUR = 'ASSOCIATION' AND ID_ASSOCIATION IS NOT NULL AND ID_UTILISATEUR IS NULL)
    ),
    
    -- Index for better performance
    INDEX idx_publication_comments (ID_PUB),
    INDEX idx_user_comments (ID_UTILISATEUR),
    INDEX idx_association_comments (ID_ASSOCIATION),
    INDEX idx_comment_date (DATE)
);

-- Add some sample data for testing (optional)
-- INSERT INTO commenter (TYPE_UTILISATEUR, ID_UTILISATEUR, ID_ASSOCIATION, ID_PUB, CONTENU) VALUES
-- ('UTILISATEUR', 1, NULL, 1, 'Excellent initiative! Merci pour votre travail.'),
-- ('ASSOCIATION', NULL, 1, 1, 'Nous sommes ravis de voir votre engagement.');
