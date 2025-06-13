<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="profile-association.css">
  <link rel="stylesheet" href="assets/styles/style.css">
</head>

<body>
  <!-- NAVBARE -->
  <?php require_once "sections/navbar.php"; ?>
  <section>
    <div class="container">
      <div class="head-profil">
        <div class="photo-profil">
          <div class="avatar"></div>
        </div>
        <div class="script-profil">
          <h2>Nom de l'association</h2>
          <p>Description de l'association</p>
          <div class="lieu"></div>
        </div>
        <div class="bouttons">
          <label for="publication">Nouvelle publication :</label>
          <select id="association" name="association">
            <option value=""><a href="prbleme.php">Probleme</a></option>
            <option value=""><a href="activite">Activite</a></option>
            <option value="">Experience</option>
          </select>
        </div>
      </div>
    </div>
  </section>
</body>

</html>