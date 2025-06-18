//==Responsive nav-bar====
let navMenu = document.getElementById("side-bar");
let navToggle = document.getElementById("buttonClick");

// Toggle menu (ouvre et ferme avec un seul bouton)
if (navToggle) {
  navToggle.addEventListener("click", () => {
    navMenu.classList.toggle("show-menu");
  });
}

// Nouvelle publication
const newPublicationButton = document.querySelector(".new-publication-trigger");
const newPublicationDropdown = document.querySelector(".new-publication-types");
const newPublicationCloseOverlay = document.querySelector(
  ".new-publication-close-overlay"
);

newPublicationButton?.addEventListener("click", () => {
  newPublicationDropdown.classList.contains("active")
    ? newPublicationDropdown.classList.remove("active")
    : newPublicationDropdown.classList.add("active");
  newPublicationDropdown.classList.contains("active")
    ? newPublicationCloseOverlay.classList.add("active")
    : newPublicationCloseOverlay.classList.remove("active");
});

newPublicationCloseOverlay?.addEventListener("click", () => {
  newPublicationDropdown.classList.remove("active");
  newPublicationCloseOverlay.classList.rmove("active");
});

// About Association tabs
const associationTabsTriggers = document.querySelectorAll(
  ".association-profile-tabs-triggers .tab-trigger"
);
const associationTabs = document.querySelectorAll(
  ".association-profile-tabs .tab"
);

associationTabsTriggers.forEach((associationTabTrigger) => {
  const tabName = associationTabTrigger.dataset.tab;
  associationTabTrigger.addEventListener("click", () => {
    Array.from(associationTabTrigger.parentElement.children).forEach((child) =>
      child.classList.remove("active")
    );
    associationTabTrigger.classList.add("active");

    const associationTab = Array.from(associationTabs).find(
      (associationTab) => associationTab.dataset.tab == tabName
    );
    Array.from(associationTab.parentElement.children).forEach((child) =>
      child.classList.remove("active")
    );
    associationTab.classList.add("active");
  });
});
//==Scroll to top button====window.onload = () => {
const msgBox = document.querySelector(".chat-messages");
if (msgBox) msgBox.scrollTop = msgBox?.scrollHeight;

// Notifications
const notificationTriggerButtons = document.querySelectorAll(
  ".notifications-trigger"
);
notificationTriggerButtons.forEach((trigger) => {
  trigger.addEventListener("click", () => {
    trigger.nextElementSibling.classList.contains("active")
      ? trigger.nextElementSibling.classList.remove("active")
      : trigger.nextElementSibling.classList.add("active");
  });
});
