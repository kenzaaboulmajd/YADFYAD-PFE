<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" />
  <link rel="stylesheet" href="assets/styles/style.css" />
  <link rel="stylesheet" href="profile-association.css" />
  <link rel="stylesheet" href="modifier-profile.css" />
</head>

<body>
  <!-- NAVBARE -->
  <?php require_once "sections/navbar.php"; ?>

  <section>
    <div class="container">
      <div class="titre">Modifier le profil</div>
      <div class="information">
        <form method="post" class="form-group">

          <!-- Nom de l'association -->
          <label for="nom">Nom de l'association</label>
          <input type="text" id="nom" name="nom" required>

          <!-- Email -->
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required>

          <!-- Numéro -->
          <label for="numero">Numero de téléphone</label>
          <input type="text" id="numero" name="numero" required>

          <!-- Adresse -->
          <label for="adresse">Adresse</label>
          <input type="text" id="adresse" name="adresse" required>

          <!-- description -->
          <label for="info">Description</label>
          <textarea id="info" name="info" required></textarea>

          <!-- Notre mission -->
          <label for="mission">Notre mission</label>
          <input type="text" id="mission" name="mission" required>

          <!-- domaine -->
          <label for="domaine"> Domaine</label>
          <input type="text" id="domaine" name="domaine" required>

          <!-- site web -->
          <label for="url">Site web</label>
          <input type="url" id="url" name="url" required>

          <input type="submit" value="Modifier" name="modifier">
        </form>
      </div>
    </div>
    </div>
  </section>
</body>

</html>