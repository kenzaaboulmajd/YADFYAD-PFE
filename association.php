<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explorer - Tadamouni</title>
    <link rel="stylesheet" href="assocition.css">
    <link rel="stylesheet" href="ass">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="header-section">
            <h1 class="main-title">Explorer</h1>
            <p class="subtitle">Découvrez les associations et leurs publications</p>
        </div>

        <div class="search-filter-section">
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input 
                    type="search" 
                    id="searchInput"
                    placeholder="Rechercher des associations ou des publications..."
                    class="search-input"
                />
            </div>
          
        </div>

        <div class="tabs-container">
            <div class="tabs-list">
                <button class="tab-trigger active" data-tab="publications">Publications</button>
                <button class="tab-trigger" data-tab="associations">Associations</button>
            </div>
            
            <div class="tab-content active" id="publications-tab">
                <div class="publications-grid" id="publicationsGrid">
                    <!-- Les publications seront générées par JavaScript -->
                </div>
                <div class="load-more-container">
                    <button class="load-more-btn">Charger plus</button>
                </div>
            </div>
            
            <div class="tab-content" id="associations-tab">
                <div class="associations-grid" id="associationsGrid">
                    <!-- Les associations seront générées par JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <script src="association-script.js"></script>
</body>
</html>
