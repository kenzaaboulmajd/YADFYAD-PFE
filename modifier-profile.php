<?php
session_start();
require_once "config.php";

if ($_SESSION["type"] == "association") {
  $sql = $pdo->prepare("SELECT * FROM association WHERE ID_ASSOCIATION = :id_association");
  $sql->execute([":id_association" => $_SESSION["id_association"]]);
} else if ($_SESSION["type"] == "utilisateur") {
  $sql = $pdo->prepare("SELECT * FROM association INNER JOIN utilisateur ON association.ID_ASSOCIATION = utilisateur.ID_ASSOCIATION WHERE ID_UTILISATEUR = :id_utilisateur");
  $sql->execute([":id_utilisateur" => $_SESSION["id_utilisateur"]]);
}

$association = $sql->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $sql = $pdo->prepare("UPDATE association SET NOM_ASSOCIATION = :nom_association, NUMERO_TELEPHONE = :numero_telephone, ADRESSE = :adresse, INFO = :info, DOMAINE = :domaine, SITEWEB = :siteweb WHERE ID_ASSOCIATION = :id_association");
  $sql->execute([
    ":nom_association" => $_POST["nom"],
    ":numero_telephone" => $_POST["numero"],
    ":adresse" => $_POST["adresse"],
    ":info" => $_POST["info"],
    ":domaine" => $_POST["domaine"],
    ":siteweb" => $_POST["url"],
    ":id_association" => $association["ID_ASSOCIATION"],
  ]);

  $_SESSION["type"] == "utilisateur" ? header("Location:profile-membre.php") : header("Location:profile-association.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Modifier l'association</title>
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
          <input type="text" id="nom" name="nom" value="<?= $association["NOM_ASSOCIATION"] ?>" required>

          <!-- Numéro -->
          <label for="numero">Numero de téléphone</label>
          <input type="text" id="numero" name="numero" value="<?= $association["NUMERO_TELEPHONE"] ?>" required>

          <!-- Adresse -->
          <label for="adresse">Adresse</label>
          <input type="text" id="adresse" name="adresse" value="<?= $association["ADRESSE"] ?>" required>

          <!-- description -->
          <label for="info">Description</label>
          <textarea id="info" name="info" required><?= $association["INFO"] ?></textarea>

          <!-- domaine -->
          <label for="domaine">Domaine</label>
          <input type="text" id="domaine" name="domaine" value="<?= $association["DOMAINE"] ?>" required>

          <!-- site web -->
          <label for="url">Site web</label>
          <input type="url" id="url" name="url" value="<?= $association["SITEWEB"] ?>" required>

          <input type="submit" value="Modifier">
        </form>
      </div>
    </div>
    </div>
  </section>
</body>

</html>