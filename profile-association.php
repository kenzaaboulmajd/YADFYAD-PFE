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
          <p>Description de l'association Lorem ipsum dolor, sit amet consectetur adipisicing elit. Libero repellat
            corporis ratione dolorum sed voluptatem provident!</p>
          <div class="lieu"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
              fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
              class="lucide lucide-map-pin-icon lucide-map-pin">
              <path
                d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
              <circle cx="12" cy="10" r="3" />
            </svg>Agadir</div>
        </div>
        <div class="bouttons">
          <!-- <label for="publication">Nouvelle publication :</label> -->
          <select id="association" name="association">
            <a href="prbleme.php">
              Probleme
            </a>
            <a href="activite.php">
              Activite
            </a>
            <a href="experience.php">
              Experiencn</a>
          </select>
          <a href="modifier.php">Modifier</a>
        </div>
      </div>
      <div class="nombre">
        <div class="abonnes"><span style="color:green;">0</span> Abonnés</div>
        <div class="membres"><span style="color:blue ;">0 </span>Membres</div>
      </div>
      <div class="links-profile">
        <ul class="links">
          <li><a href="">Publication</a></li>
          <li><a href="">A propos</a></li>
          <li><a href="">Contact</a></li>
        </ul>
      </div>
    </div>
  </section>
  <section>
    <div class="container">
      <di class="posts">
        <div class="post">
          <div class="post-image"></div>
          <div class="post-container">

            <div class="post-header">
              <div class="post-icone"></div>
              <div class="post-header-contenu">
                <div class="post-type">Problème</div>
                <div class="post-date">Il y'a 2 jours</div>
              </div>
            </div>
            <div class="post-contenu">
              <div class="post-titre">Manque de bénévoles pour notre événement environnemental</div>
              <div class="post-description">Nous organisons un événement de sensibilisation
                environnementale
                le mois
                prochain et nous manquons de
                bénévoles pour l'organisation et la logistique. Nous avons besoin d'au moins 10
                personnes
                pour assurer
                le
                bon déroulement de l'événement.</div>
              <div class="post-association">
                <div class="post-association-avatar"></div>
                <div class="post-association-nom">Association pour le Développement Durable</div>
              </div>
              <div class="post-interactions">
                <div class="post-interaction-element">
                  <div class="icone"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                      xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M12.6666 9.33333C13.66 8.36 14.6666 7.19333 14.6666 5.66667C14.6666 4.69421 14.2803 3.76158 13.5927 3.07394C12.9051 2.38631 11.9724 2 11 2C9.82665 2 8.99998 2.33333 7.99998 3.33333C6.99998 2.33333 6.17331 2 4.99998 2C4.02752 2 3.09489 2.38631 2.40725 3.07394C1.71962 3.76158 1.33331 4.69421 1.33331 5.66667C1.33331 7.2 2.33331 8.36667 3.33331 9.33333L7.99998 14L12.6666 9.33333Z"
                        stroke="#020817" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="valeur">3</div>
                  </div>
                </div>
                <div class="post-interaction-element">
                  <div class="icone"><svg width="17" height="16" viewBox="0 0 17 16" fill="none"
                      xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M14.67 10C14.67 10.3536 14.5295 10.6928 14.2795 10.9428C14.0294 11.1929 13.6903 11.3333 13.3366 11.3333H5.33665L2.66998 14V3.33333C2.66998 2.97971 2.81046 2.64057 3.06051 2.39052C3.31056 2.14048 3.64969 2 4.00332 2H13.3366C13.6903 2 14.0294 2.14048 14.2795 2.39052C14.5295 2.64057 14.67 2.97971 14.67 3.33333V10Z"
                        stroke="#020817" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                  </div>
                  <div class="valeur">12</div>
                </div>
              </div>
            </div>
          </div>

        </div>
        <div class="post">
          <div class="post-image">
            <img src="https://placehold.co/600x400" alt="">
          </div>
          <div class="post-container">

            <div class="post-header">
              <div class="post-icone"></div>
              <div class="post-header-contenu">
                <div class="post-type">Activité</div>
                <div class="post-date">Il y'a 2 jours</div>
              </div>
            </div>
            <div class="post-contenu">
              <div class="post-titre">Association pour le Développement Durable</div>
              <div class="post-description">Nous organisons un événement de sensibilisation
                environnementale
                le mois
                prochain et nous manquons de
                bénévoles pour l'organisation et la logistique. Nous avons besoin d'au moins 10
                personnes
                pour assurer
                le
                bon déroulement de l'événement.</div>
              <div class="post-association">
                <div class="post-association-avatar"></div>
                <div class="post-association-nom">Association pour le Développement Durable</div>
              </div>
              <div class="post-interactions">
                <div class="post-interaction-element">
                  <div class="icone"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                      xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M12.6666 9.33333C13.66 8.36 14.6666 7.19333 14.6666 5.66667C14.6666 4.69421 14.2803 3.76158 13.5927 3.07394C12.9051 2.38631 11.9724 2 11 2C9.82665 2 8.99998 2.33333 7.99998 3.33333C6.99998 2.33333 6.17331 2 4.99998 2C4.02752 2 3.09489 2.38631 2.40725 3.07394C1.71962 3.76158 1.33331 4.69421 1.33331 5.66667C1.33331 7.2 2.33331 8.36667 3.33331 9.33333L7.99998 14L12.6666 9.33333Z"
                        stroke="#020817" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="valeur">3</div>
                  </div>
                </div>
                <div class="post-interaction-element">
                  <div class="icone"><svg width="17" height="16" viewBox="0 0 17 16" fill="none"
                      xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M14.67 10C14.67 10.3536 14.5295 10.6928 14.2795 10.9428C14.0294 11.1929 13.6903 11.3333 13.3366 11.3333H5.33665L2.66998 14V3.33333C2.66998 2.97971 2.81046 2.64057 3.06051 2.39052C3.31056 2.14048 3.64969 2 4.00332 2H13.3366C13.6903 2 14.0294 2.14048 14.2795 2.39052C14.5295 2.64057 14.67 2.97971 14.67 3.33333V10Z"
                        stroke="#020817" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                  </div>
                  <div class="valeur">12</div>
                </div>
              </div>
            </div>
          </div>

        </div>
    </div>
  </section>
</body>

</html>