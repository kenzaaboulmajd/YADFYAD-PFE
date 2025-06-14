<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
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
    <div class="container">
      <div class="titre">
        <h2>Message</h2>
        <p>Communiquez avec d'autres associations</p>
      </div>
    </div>
  </section>
  <section>
    <div class="parent-container">
      <div class="sidebar">
        <div class="cherche"> <input type="text" placeholder="rechercher..."></div>
        <div class="chat-teams">
          <ul>
            <li>
              <div class="contenu-message">

                <div class="profile">
                  <div class="avatare"></div>
                </div>

                <div class="resume">
                  <div class="nom-user">Association 1</div>
                  <div class="result-message"> merci pour votre aide!</div>
                </div>

                <div class="time">10:30</div>
              </div>
            </li>
          </ul>
        </div>
      </div>

      <div class="chat-container"></div>
    </div>
  </section>

</body>

</html>