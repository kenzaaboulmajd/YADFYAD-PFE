<?php
session_start();
require_once "config.php";

$sql = $pdo->prepare("SELECT * FROM utilisateur WHERE ID_UTILISATEUR = :id_utilisateur");
$sql->execute([":id_utilisateur" => $_SESSION["id_utilisateur"]]);
$utilisateur = $sql->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $prenom = explode(" ", $_POST["nom"])[0];
  $nom = explode(" ", $_POST["nom"])[1] ?? "";

  $sql = $pdo->prepare("UPDATE utilisateur SET NOM = :nom, PRENOM = :prenom, DESCRIPTION = :description WHERE ID_UTILISATEUR = :id_utilisateur");
  $sql->execute([
    ":nom" => $nom,
    ":prenom" => $numero,
    ":description" => $_POST["description"],
    ":id_utilisateur" => $_SESSION["id_utilisateur"],
  ]);

  header("Location:profile-normal.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Modifier l'utilisateur</title>
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
      <div class="titre">Modifier votre profil visiteur</div>
      <div class="information">
        <form method="post" class="form-group">

          <!-- Nom de l'association -->
          <label for="nom">Nom de l'association</label>
          <input type="text" id="nom" name="nom" value="<?= $utilisateur["PRENOM"] . " " . $utilisateur["NOM"] ?>"
            required>

          <!-- Numéro -->
          <label for="description">Numero de téléphone</label>
          <input type="text" id="numero" name="description" value="<?= $utilisateur["DESCRIPTION"] ?>" required>

          <input type="submit" value="Modifier">
        </form>
      </div>
    </div>
    </div>
  </section>
</body>

</html>