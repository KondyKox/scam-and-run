// Toggle nav menu on mobile
function toggleMenu() {
  const toggleButton = document.getElementsByClassName("toggle-button")[0];
  const navbarLinks = document.getElementsByClassName("nav-container")[0];

  toggleButton.addEventListener("click", () => {
    navbarLinks.classList.toggle("active");
  });
}

toggleMenu();
