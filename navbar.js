// Toggle nav menu on mobile
function toggleMenu() {
  // let navList = document.querySelector(".nav-links");
  // let menuBtn = document.querySelector(".burger");

  // menuBtn.addEventListener("click", () => {
  //   navList.classList.toggle("nav-active");
  // });

  const toggleButton = document.getElementsByClassName("toggle-button")[0];
  const navbarLinks = document.getElementsByClassName("nav-container")[0];

  toggleButton.addEventListener("click", () => {
    navbarLinks.classList.toggle("active");
  });
}

// Change color of active link in navbar
document.addEventListener("DOMContentLoaded", function () {
  const links = document.querySelectorAll(".nav-link");

  // Check current URL
  setActiveLink();

  links.forEach((link) => {
    link.addEventListener("click", () => {
      // Change color after click
      setActiveLink();
    });
  });
});

// Check current URL and change color of active
function setActiveLink() {
  const links = document.querySelectorAll(".nav-link");
  const currentURL = window.location.href;

  links.forEach((link) => {
    if (link.hred === currentURL) link.classList.add("active");
    else link.classList.remove("active");
  });
}

toggleMenu();
