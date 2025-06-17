<?php
session_start();
require_once "config.php";

$dest_id = $_GET['id_dest'] ?? null;
$dest_type = $_GET['type_dest'] ?? null;
$id = $_SESSION["type"] == 'UTILISATEUR' ? $_SESSION['id_utilisateur'] : $_SESSION['id_association'];

$messages = [];
$dest_info = [];

if ($dest_id && $dest_type) {
  if ($dest_type === 'ASSOCIATION') {
    $stmt = $pdo->prepare("SELECT * FROM association WHERE ID_ASSOCIATION = :id");
    $stmt->execute([':id' => $dest_id]);
    $dest_info = $stmt->fetch();
  } elseif ($dest_type === 'UTILISATEUR') {
    $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE ID_UTILISATEUR = :id");
    $stmt->execute([':id' => $dest_id]);
    $dest_info = $stmt->fetch();
  }

  $sql = $pdo->prepare(("SELECT * FROM message WHERE EXPEDITEUR_ID = :id1 AND DESTINATAIRE_ID = :id2 OR EXPEDITEUR_ID = :id2 AND DESTINATAIRE_ID = :id1 ORDER BY DATE_CREATION ASC"));
  $sql->execute([':id1' => $_SESSION["type"] == 'UTILISATEUR' ? $_SESSION['id_utilisateur'] : $_SESSION['id_association'], ':id2' => $dest_id]);
  $messages = $sql->fetchAll(PDO::FETCH_ASSOC);
}

$sql = $pdo->prepare("SELECT * FROM association WHERE VERIFIE = true");
$sql->execute();
$associations = $sql->fetchAll(PDO::FETCH_ASSOC);

foreach ($associations as $key => $association) {
  $stmt = $pdo->prepare("SELECT * FROM message WHERE (EXPEDITEUR_ID = :exp AND DESTINATAIRE_ID = :dest) OR (EXPEDITEUR_ID = :dest AND DESTINATAIRE_ID = :exp) ORDER BY DATE_CREATION DESC LIMIT 1");
  $stmt->execute([':exp' => $_SESSION["type"] == 'UTILISATEUR' ? $_SESSION['id_utilisateur'] : $_SESSION['id_association'], ':dest' => $association['ID_ASSOCIATION']]);
  $last_message = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($last_message) {
    $associations[$key]['last_message'] = $last_message['MESSAGE'];
    $associations[$key]['time'] = date('H:i', strtotime($last_message['DATE_CREATION']));
  } else {
    $associations[$key]['last_message'] = '';
    $associations[$key]['time'] = '';
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chat</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap">
  <link rel="stylesheet" href="assets/styles/style.css">
  <link rel="stylesheet" href="profile-association.css">
  <link rel="stylesheet" href="chat.css">
</head>

<body>
  <!-- NAVBARE -->
  <?php require_once "sections/navbar.php"; ?>

  <section>
    <div class="container-full">
      <div class="titre">
        <h2>Message</h2>
        <p>Communiquez avec d'autres associations</p>
      </div>
    </div>
    <div class="parent-container">
      <div class="sidebar"> <!-- Colonne de gauche -->
        <div class="cherche"><input type="text" placeholder="Rechercher..."></div>
        <div class="chat-teams">
          <ul>
            <?php foreach ($associations as $association): ?>
              <a href="chat.php?id_dest=<?php echo $association['ID_ASSOCIATION']; ?>&type_dest=ASSOCIATION">
                <div class="contenu-message">
                  <div class="profile">
                    <div class="avatare"></div>
                  </div>
                  <div class="resume">
                    <div class="nom-user"><?php echo htmlspecialchars($association['NOM_ASSOCIATION']); ?></div>
                    <div class="result-message"><?php echo htmlspecialchars($association['last_message']); ?></div>
                  </div>
                  <div class="time"><?php echo htmlspecialchars($association['time']); ?></div>
                </div>
              </a>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>

      <div class="chat-container"> <!-- Zone droite -->
        <div class="chat-header">
          <div class="profile">
            <div class="avatare"></div>
          </div>
          <div class="nom-user">
            <?php echo count($dest_info) > 0 ? htmlspecialchars($dest_info['NOM_ASSOCIATION'] ?? $dest_info['PRENOM'] . ' ' . $dest_info['NOM']) : "YADFYAD Chat!" ?>
          </div>
        </div>
        <div class="chat-messages">
          <ul>
            <?php foreach ($messages as $message): ?>
              <li class="message <?= $message['EXPEDITEUR_ID'] == $id ? 'sent' : 'received'; ?>">
                <p><?php echo htmlspecialchars($message['MESSAGE']); ?></p>
                <div class="time"><?php echo date('H:i', strtotime($message['DATE_CREATION'])); ?></div>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <div class="chat-input">
          <input placeholder="Écrivez votre message..." type="text" id="message-input">
          <button class="send-message" data-destinataire="<?php echo $dest_id; ?>"
            data-typeDestinataire="<?php echo $dest_type; ?>">Envoyer</button>
        </div>
      </div>
    </div>
  </section>
  <script src="script.js"></script>
  <script src="requets.js"></script>
</body>

</html>