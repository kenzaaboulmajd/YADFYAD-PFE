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

// Comments functionality
const addComment = async (publication_id, contenu) => {
  const urlencoded = new URLSearchParams();
  urlencoded.append("publication_id", publication_id);
  urlencoded.append("contenu", contenu);

  const response = await fetch(BASE_URL + "/requets/add-comment.php", {
    method: "POST",
    body: urlencoded,
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
  });

  if (!response.ok) {
    const errorData = await response.json();
    throw new Error(
      errorData.message || "Erreur lors de l'ajout du commentaire"
    );
  }

  const data = await response.json();
  return data;
};

const getComments = async (publication_id, page = 1, limit = 10) => {
  const params = new URLSearchParams({
    publication_id: publication_id,
    page: page,
    limit: limit,
  });

  const response = await fetch(
    BASE_URL + "/requets/get-comments.php?" + params,
    {
      method: "GET",
    }
  );

  if (!response.ok) {
    const errorData = await response.json();
    throw new Error(
      errorData.message || "Erreur lors du chargement des commentaires"
    );
  }

  const data = await response.json();
  return data;
};

const deleteComment = async (comment_id) => {
  const urlencoded = new URLSearchParams();
  urlencoded.append("comment_id", comment_id);

  const response = await fetch(BASE_URL + "/requets/delete-comment.php", {
    method: "POST",
    body: urlencoded,
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
  });

  if (!response.ok) {
    const errorData = await response.json();
    throw new Error(
      errorData.message || "Erreur lors de la suppression du commentaire"
    );
  }

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

// Helper functions for comments
const loadComments = async (publicationId) => {
  try {
    const response = await getComments(publicationId, 1, 3);
    if (response.success) {
      // Comments are already rendered server-side, just mark as loaded
      return response;
    }
  } catch (error) {
    console.error("Error loading comments:", error);
    showCommentMessage(
      publicationId,
      "Erreur lors du chargement des commentaires",
      "error"
    );
  }
};

const addCommentToList = (publicationId, comment, prepend = true) => {
  const commentsList = document.querySelector(
    `#comments-${publicationId} .comments-list`
  );
  if (!commentsList) return;

  const commentElement = createCommentElement(comment);

  if (prepend) {
    commentsList.insertBefore(commentElement, commentsList.firstChild);
  } else {
    commentsList.appendChild(commentElement);
  }
};

const createCommentElement = (comment) => {
  const commentDiv = document.createElement("div");
  commentDiv.className = "comment-item new-comment";
  commentDiv.dataset.commentId = comment.id;

  const avatarHtml = comment.photo
    ? `<img src="${comment.photo}" alt="Avatar">`
    : `<div class="default-avatar">${comment.nom
        .charAt(0)
        .toUpperCase()}</div>`;

  commentDiv.innerHTML = `
    <div class="comment-avatar">
      ${avatarHtml}
    </div>
    <div class="comment-content">
      <div class="comment-header">
        <a href="#" class="comment-author">${comment.nom}</a>
        <span class="comment-date">À l'instant</span>
      </div>
      <div class="comment-text">${comment.contenu}</div>
    </div>
  `;

  return commentDiv;
};

const updateCommentCount = (publicationId, newCount) => {
  const countElements = document.querySelectorAll(
    `[data-publication="${publicationId}"] + .valeur`
  );
  countElements.forEach((element) => {
    element.textContent = newCount;
  });
};

const showCommentMessage = (publicationId, message, type) => {
  const commentsSection = document.getElementById(`comments-${publicationId}`);
  if (!commentsSection) return;

  // Remove existing messages
  const existingMessage = commentsSection.querySelector(".comment-message");
  if (existingMessage) {
    existingMessage.remove();
  }

  const messageDiv = document.createElement("div");
  messageDiv.className = `comment-message comment-${type}`;
  messageDiv.textContent = message;

  commentsSection.insertBefore(messageDiv, commentsSection.firstChild);

  // Auto-remove success messages after 3 seconds
  if (type === "success") {
    setTimeout(() => {
      messageDiv.remove();
    }, 3000);
  }
};

// Comments Event Listeners
document.addEventListener("DOMContentLoaded", function () {
  // Toggle comments visibility
  const commentToggleButtons = document.querySelectorAll(".comment-toggle");
  commentToggleButtons.forEach((button) => {
    button.addEventListener("click", async () => {
      const publicationId = button.dataset.publication;
      const commentsSection = document.getElementById(
        `comments-${publicationId}`
      );

      if (
        commentsSection.style.display === "none" ||
        !commentsSection.style.display
      ) {
        commentsSection.style.display = "block";
        // Load comments if not already loaded
        if (!commentsSection.dataset.loaded) {
          await loadComments(publicationId);
          commentsSection.dataset.loaded = "true";
        }
      } else {
        commentsSection.style.display = "none";
      }
    });
  });

  // Submit comment
  const commentSubmitButtons = document.querySelectorAll(".comment-submit-btn");
  commentSubmitButtons.forEach((button) => {
    button.addEventListener("click", async (e) => {
      e.preventDefault();
      const publicationId = button.dataset.publicationId;
      const commentInput = document.querySelector(
        `.comment-input[data-publication-id="${publicationId}"]`
      );
      const contenu = commentInput.value.trim();

      if (!contenu) {
        alert("Veuillez saisir un commentaire");
        return;
      }

      try {
        button.disabled = true;
        button.textContent = "Publication...";

        const response = await addComment(publicationId, contenu);

        if (response.success) {
          // Add new comment to the list
          addCommentToList(publicationId, response.comment);

          // Update comment count
          updateCommentCount(publicationId, response.total_comments);

          // Clear input
          commentInput.value = "";

          // Show success message
          showCommentMessage(
            publicationId,
            "Commentaire ajouté avec succès",
            "success"
          );
        }
      } catch (error) {
        showCommentMessage(publicationId, error.message, "error");
      } finally {
        button.disabled = false;
        button.textContent = "Publier";
      }
    });
  });

  // Load more comments
  const loadMoreButtons = document.querySelectorAll(".load-more-comments-btn");
  loadMoreButtons.forEach((button) => {
    button.addEventListener("click", async (e) => {
      e.preventDefault();
      const publicationId = button.dataset.publicationId;
      const page = parseInt(button.dataset.page);

      try {
        button.disabled = true;
        button.textContent = "Chargement...";

        const response = await getComments(publicationId, page);

        if (response.success && response.comments.length > 0) {
          // Add comments to the list
          response.comments.forEach((comment) => {
            addCommentToList(publicationId, comment, false);
          });

          // Update button
          if (response.pagination.has_more) {
            button.dataset.page = page + 1;
            button.textContent = `Voir plus de commentaires (${
              response.pagination.total_comments - page * 10
            } restants)`;
          } else {
            button.style.display = "none";
          }
        }
      } catch (error) {
        showCommentMessage(publicationId, error.message, "error");
      } finally {
        button.disabled = false;
        if (button.textContent === "Chargement...") {
          button.textContent = "Voir plus de commentaires";
        }
      }
    });
  });

  // Delete comment functionality
  document.addEventListener("click", async (e) => {
    if (e.target.classList.contains("comment-delete-btn")) {
      e.preventDefault();

      if (!confirm("Êtes-vous sûr de vouloir supprimer ce commentaire ?")) {
        return;
      }

      const commentId = e.target.dataset.commentId;
      const commentElement = e.target.closest(".comment-item");

      try {
        const response = await deleteComment(commentId);

        if (response.success) {
          // Remove comment from DOM
          commentElement.remove();

          // Update comment count
          updateCommentCount(response.publication_id, response.total_comments);

          // Show success message
          showCommentMessage(
            response.publication_id,
            "Commentaire supprimé avec succès",
            "success"
          );
        }
      } catch (error) {
        showCommentMessage(
          response.publication_id || "unknown",
          error.message,
          "error"
        );
      }
    }
  });
});
