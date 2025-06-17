const BASE_URL = "http://localhost/YADFYAD-PFE";

const followAssociation = async (association_id) => {
  const urlencoded = new URLSearchParams();
  urlencoded.append("association_id", association_id);

  const response = await fetch(BASE_URL + "/requets/suivre.php", {
    method: "POST",
    body: urlencoded,
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
  });

  if (!response.ok) return;

  const data = response.json();
  return data;
};

const likePublication = async (publication_id) => {
  const urlencoded = new URLSearchParams();
  urlencoded.append("publication_id", publication_id);

  const response = await fetch(BASE_URL + "/requets/like.php", {
    method: "POST",
    body: urlencoded,
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
  });

  if (!response.ok) return;

  const data = response.json();
  return data;
};

const envoyerMessage = async (
  contenu,
  destinataireId,
  typeDestinataire = "ASSOCIATION"
) => {
  const urlencoded = new URLSearchParams();
  urlencoded.append("contenu", contenu);
  urlencoded.append("id_destinataire", destinataireId);
  urlencoded.append("type_expediteur", "UTILISATEUR"); // ou "ASSOCIATION"
  urlencoded.append("type_destinataire", typeDestinataire);

  const response = await fetch(BASE_URL + "/requets/envoyer-message.php", {
    method: "POST",
    body: urlencoded,
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
  });

  if (!response.ok) return;

  const data = await response.json();
  return data;
};

const followButtons = document.querySelectorAll(".follow");
followButtons.forEach((followButton) =>
  followButton.addEventListener("click", async () => {
    const association_id = followButton.dataset.association;
    const followStatusElement = followButton.querySelector(".follow-status");

    const follow = await followAssociation(association_id);
    if (follow.is_following) {
      followButton.classList.add("following");
      followStatusElement.innerHTML = "Suivi(e)";
    } else {
      followButton.classList.remove("following");
      followStatusElement.innerHTML = "Suivre";
    }
  })
);

const likeButtons = document.querySelectorAll(".like");
likeButtons.forEach((likeButton) =>
  likeButton.addEventListener("click", async () => {
    const publication_id = likeButton.dataset.publication;

    const follow = await likePublication(publication_id);
    if (follow.is_liking) {
      likeButton.classList.add("liking");
    } else {
      likeButton.classList.remove("liking");
    }
    if (follow.count) {
      likeButton.nextElementSibling.innerHTML = follow.count;
    } else {
      likeButton.nextElementSibling.innerHTML = 0;
    }
  })
);

const messageButton = document.querySelector(".send-message");
const messagesContainer = document.querySelector(".chat-messages>ul");
messageButton?.addEventListener("click", async () => {
  const contenu = messageButton.previousElementSibling.value;
  const destinataireId = messageButton.dataset.destinataire;
  const typeDestinataire = messageButton.dataset.typeDestinataire;

  if (!contenu || !destinataireId) return;

  const response = await envoyerMessage(
    contenu,
    destinataireId,
    typeDestinataire
  );

  if (response.success) {
    const newMessage = document.createElement("li");
    newMessage.classList.add("message");
    newMessage.classList.add("sent");

    const date = new Date(response.time);
    const hours = date.getHours().toString().padStart(2, "0");
    const minutes = date.getMinutes().toString().padStart(2, "0");
    const time = `${hours}:${minutes}`;

    newMessage.innerHTML = `<p>${response.message}</p><div class="time">${time}</div>`;
    messagesContainer.appendChild(newMessage);
    messageButton.previousElementSibling.value = "";
  } else {
    alert("Erreur lors de l'envoi du message.");
  }
});
