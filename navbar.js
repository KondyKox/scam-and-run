// Toggle nav menu on mobile
function toggleMenu() {
    let navList = document.querySelector(".nav-links");
    let menuBtn = document.querySelector(".burger");
  
    menuBtn.addEventListener("click", () => {
      navList.classList.toggle("nav-active");
    });
  }
  
  toggleMenu();