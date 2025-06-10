const url_de_base = "http://localhost/kenza_pfe/admin";

// verifier les associations
const verifierAssociation = async (association_id) => {
  const urlencoded = new URLSearchParams();
  urlencoded.append("association_id", association_id);

  const result = await fetch(
    url_de_base + "/requets/verifications/verifications.php",
    {
      method: "POST",
      body: urlencoded,
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
    }
  );

  if (!result.ok) return;
  const data = await result.json();

  if (data.est_verifie == true) window.location.href = url_de_base;
};
