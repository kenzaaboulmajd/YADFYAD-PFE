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
