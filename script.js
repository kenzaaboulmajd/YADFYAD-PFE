//==Responsive nav-bar====
let navMenu = document.getElementById("side-bar");
let navToggle = document.getElementById("buttonClick");

// Toggle menu (ouvre et ferme avec un seul bouton)
if(navToggle){
    navToggle.addEventListener('click', () => {
        navMenu.classList.toggle('show-menu');
    });
}

//==Scroll to top button====window.onload = () => {
  const msgBox = document.querySelector('.chat-messages');
  msgBox.scrollTop = msgBox.scrollHeight;
};
