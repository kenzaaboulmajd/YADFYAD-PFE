<?php
session_start();
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $association_id = $_SESSION["type"] == "association" ? $_SESSION["id_association"] : null;
  echo $association_id;

  if (!$association_id) {
    $sql = $pdo->prepare("SELECT utilisateur.*, association.* FROM utilisateur INNER JOIN association ON utilisateur.ID_ASSOCIATION = association.ID_ASSOCIATION WHERE ID_UTILISATEUR = :id_utilisateur");
    $sql->execute([":id_utilisateur" => $_SESSION["id_utilisateur"]]);
    $utilisateur = $sql->fetch();
    $association_id = $utilisateur["ID_ASSOCIATION"];
  }

  if (isset($_FILES['profile']) && $_FILES['profile']['error'] == UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['profile']['tmp_name'];
    $fileName = $_FILES['profile']['name'];
    $fileSize = $_FILES['profile']['size'];
    $fileType = $_FILES['profile']['type'];

    // Define the upload directory
    $uploadDir = 'uploads/';
    $dest_path = $uploadDir . basename($fileName);
    // Check if the file is an image or a video
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'video/mp4'];
    if (in_array($fileType, $allowedTypes)) {
      // Move the file to the upload directory
      if (move_uploaded_file($fileTmpPath, $dest_path)) {
        // File successfully uploaded
        $sql = $pdo->prepare("UPDATE association SET PHOTO = :profile WHERE ID_ASSOCIATION = :id_association");
        $sql->execute([':profile' => "/uploads/" . basename($fileName), ":id_association" => $association_id]);

        $_SESSION["type"] == "association" ? header("location:profile-association.php") : header("location:profile-membre.php");
        exit;
      } else {
        echo "Error moving the uploaded file.";
        exit();
      }
    } else {
      echo "Invalid file type. Only images and videos are allowed.";
      exit();
    }
  }
}