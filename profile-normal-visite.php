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
  <link rel="stylesheet" href="profile-normal.css">
</head>

<body>
  <!-- NAVBARE -->
  <?php require_once "sections/navbar.php"; ?>

  <!-- PROFILE -->
  <section>

    <div class="container">
      <div class="head-profil">
        <div class="photo-profil">
          <div class="avatar"></div>
        </div>
        <div class="script-profil">
          <h2>Mohammed Bennani</h2>
          <p>Professeur de Francais - Lycee Moullay Selimane</p>
          <div class="infos">
            <div class="lieu"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-map-pin-icon lucide-map-pin">
                <path
                  d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                <circle cx="12" cy="10" r="3" />
              </svg> <span>Fes</span> </div>

          </div>
        </div>
      </div>
      <div class="envoyer-messae"><a href="#">envoyer message</a></div>
    </div>
  </section>
  <footer>
    <div class="copyright">
      &copy; 2025 YADFYAD.Tous droits reveser.
    </div>
  </footer>
</body>

</html>