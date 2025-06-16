<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/style.css">
    <link rel="stylesheet" href="association.css">
    <title>Associations</title>
</head>

<body>
    <?php require_once "sections/navbar.php"; ?>

    <!-- Main Content -->
    <section class="main">
        <div class="container">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">Associations</h1>
                <p class="page-description">Découvrez les associations et leurs publications</p>
            </div>

            <!-- Search Section -->
            <div class="search-section">
                <div class="search-container">
                    <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="search" class="search-input"
                        placeholder="Rechercher des associations ou des publications..." id="searchInput">
                </div>
            </div>

            <!-- Associations Tab -->
            <div class="tab-content active" id="associations">
                <div class="cards-grid cards-grid-associations" id="associationsGrid">
                    <!-- Les cartes d'associations seront générées par JavaScript -->
                </div>
            </div>
        </div>

        <!-- Load More Button -->
        <div class="load-more">
            <button class="btn btn-outline" onclick="loadMoreAssociations()">Charger plus</button>
        </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="copyright">

            &copy; 2025 YADFYAD.Tous droits reveser.

        </div>
    </footer>


    <script>
        // Données d'exemple pour les associations
        const associationsData = [
            {
                id: 1,
                name: "Association Solidarité",
                description: "Aide alimentaire et soutien aux personnes défavorisées",
                avatar: "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Crect width='80' height='80' fill='%23f3f4f6'/%3E%3Ctext x='50%25' y='50%25' text-anchor='middle' dy='0.3em' font-family='Arial' font-size='14' fill='%236b7280'%3EAS%3C/text%3E%3C/svg%3E"
            },
            {
                id: 2,
                name: "Éducation Pour Tous",
                description: "Éducation et accompagnement des jeunes",
                avatar: "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Crect width='80' height='80' fill='%23f3f4f6'/%3E%3Ctext x='50%25' y='50%25' text-anchor='middle' dy='0.3em' font-family='Arial' font-size='14' fill='%236b7280'%3EEPT%3C/text%3E%3C/svg%3E"
            },
            {
                id: 3,
                name: "Environnement Vert",
                description: "Protection de l'environnement et sensibilisation",
                avatar: "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Crect width='80' height='80' fill='%23f3f4f6'/%3E%3Ctext x='50%25' y='50%25' text-anchor='middle' dy='0.3em' font-family='Arial' font-size='14' fill='%236b7280'%3EEV%3C/text%3E%3C/svg%3E"
            },
            {
                id: 4,
                name: "Santé Communautaire",
                description: "Soins de santé et prévention pour tous",
                avatar: "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Crect width='80' height='80' fill='%23f3f4f6'/%3E%3Ctext x='50%25' y='50%25' text-anchor='middle' dy='0.3em' font-family='Arial' font-size='14' fill='%236b7280'%3ESC%3C/text%3E%3C/svg%3E"
            },
            {
                id: 5,
                name: "Culture et Arts",
                description: "Promotion de la culture et des arts locaux",
                avatar: "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Crect width='80' height='80' fill='%23f3f4f6'/%3E%3Ctext x='50%25' y='50%25' text-anchor='middle' dy='0.3em' font-family='Arial' font-size='14' fill='%236b7280'%3ECA%3C/text%3E%3C/svg%3E"
            },
            {
                id: 6,
                name: "Sport Pour Tous",
                description: "Activités sportives et bien-être communautaire",
                avatar: "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Crect width='80' height='80' fill='%23f3f4f6'/%3E%3Ctext x='50%25' y='50%25' text-anchor='middle' dy='0.3em' font-family='Arial' font-size='14' fill='%236b7280'%3ESPT%3C/text%3E%3C/svg%3E"
            },
            {
                id: 7,
                name: "Aide aux Seniors",
                description: "Accompagnement et soutien aux personnes âgées",
                avatar: "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Crect width='80' height='80' fill='%23f3f4f6'/%3E%3Ctext x='50%25' y='50%25' text-anchor='middle' dy='0.3em' font-family='Arial' font-size='14' fill='%236b7280'%3EAS%3C/text%3E%3C/svg%3E"
            },
            {
                id: 8,
                name: "Insertion Professionnelle",
                description: "Formation et insertion dans le monde du travail",
                avatar: "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Crect width='80' height='80' fill='%23f3f4f6'/%3E%3Ctext x='50%25' y='50%25' text-anchor='middle' dy='0.3em' font-family='Arial' font-size='14' fill='%236b7280'%3EIP%3C/text%3E%3C/svg%3E"
            }
        ];

        let displayedAssociations = 0;
        const associationsPerLoad = 8;

        // Fonction pour créer une carte d'association
        function createAssociationCard(association) {
            return `
                <div class="card association-card">
                    <div class="card-content">
                        <img src="${association.avatar}" alt="Logo ${association.name}" class="avatar avatar-large">
                        <h3 class="card-title">${association.name}</h3>
                        <p class="card-description">${association.description}</p>
                        <button class="btn btn-outline">
                            <svg class="action-icon" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Voir le profil
                        </button>
                    </div>
                </div>
            `;
        }

        // Fonction pour charger les associations
        function loadAssociations() {
            const grid = document.getElementById('associationsGrid');
            const endIndex = Math.min(displayedAssociations + associationsPerLoad, associationsData.length);

            for (let i = displayedAssociations; i < endIndex; i++) {
                grid.innerHTML += createAssociationCard(associationsData[i]);
            }

            displayedAssociations = endIndex;

            // Masquer le bouton "Charger plus" si toutes les associations sont affichées
            if (displayedAssociations >= associationsData.length) {
                document.querySelector('.load-more').style.display = 'none';
            }
        }

        // Fonction pour charger plus d'associations
        function loadMoreAssociations() {
            loadAssociations();
        }

        // Fonction de recherche
        function filterAssociations() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const grid = document.getElementById('associationsGrid');

            if (searchTerm === '') {
                // Réinitialiser l'affichage
                grid.innerHTML = '';
                displayedAssociations = 0;
                loadAssociations();
                document.querySelector('.load-more').style.display = 'flex';
            } else {
                // Filtrer les associations
                const filteredAssociations = associationsData.filter(association =>
                    association.name.toLowerCase().includes(searchTerm) ||
                    association.description.toLowerCase().includes(searchTerm)
                );

                grid.innerHTML = '';
                filteredAssociations.forEach(association => {
                    grid.innerHTML += createAssociationCard(association);
                });

                // Masquer le bouton "Charger plus" lors de la recherche
                document.querySelector('.load-more').style.display = 'none';
            }
        }

        // Gestionnaire d'événements pour la recherche
        document.getElementById('searchInput').addEventListener('input', filterAssociations);

        // Gestionnaire d'événements pour les onglets
        document.querySelectorAll('.tab-trigger').forEach(trigger => {
            trigger.addEventListener('click', function () {
                // Retirer la classe active de tous les triggers et contenus
                document.querySelectorAll('.tab-trigger').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

                // Ajouter la classe active au trigger cliqué
                this.classList.add('active');

                // Afficher le contenu correspondant
                const tabId = this.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            });
        });

        // Charger les associations au chargement de la page
        document.addEventListener('DOMContentLoaded', function () {
            loadAssociations();
        });
    </script>
</body>

</html>