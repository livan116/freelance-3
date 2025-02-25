
// Navigation active state
const navLinks = document.querySelectorAll(".nav-line");
const currentPage = window.location.pathname;

navLinks.forEach((link) => {
  if (link.getAttribute("href") === currentPage) {
    link.classList.add("active");
    link.classList.add("text-green-500");
  }
});

// Mobile menu functionality
const mobileMenuButton = document.getElementById("mobile-menu-button");
const mobileMenu = document.querySelector(".mobile-menu");
const mobileCloseButton = document.querySelector(".mobile-close-button");

function toggleMenu() {
  mobileMenu.classList.toggle("active");
}

if (mobileMenuButton) {
  mobileMenuButton.addEventListener("click", toggleMenu);
}

if (mobileCloseButton) {
  mobileCloseButton.addEventListener("click", toggleMenu);
}

const mobileMenuLinks = mobileMenu.querySelectorAll("a");
mobileMenuLinks.forEach((link) => {
  link.addEventListener("click", toggleMenu);
});