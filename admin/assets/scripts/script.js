const dropdowns = document.querySelectorAll(".dropdown");

dropdowns.forEach((element) => {
  const dropdownButton = element.querySelector(".dropdown-btn");
  dropdownButton.addEventListener("click", () => {
    const dropdownContent = element.querySelector(".dropdown-content");
    dropdownContent.classList.contains("active")
      ? dropdownContent.classList.remove("active")
      : dropdownContent.classList.add("active");
  });
});

const search = document.querySelector("#search");

search.addEventListener("keyup", () => {
  clearTimeout();
  setTimeout(() => {
    console.log("ee");
    const url = new URL(window.location.href);
    url.searchParams.set("q", search.value);
    window.location.href = url;
  }, 1000);
});
