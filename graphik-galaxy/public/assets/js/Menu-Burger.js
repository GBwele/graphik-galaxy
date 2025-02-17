document.addEventListener("DOMContentLoaded", function () {
  // Gestion du menu hamburger
  const navbarToggler = document.querySelector(".navbar-toggler");
  const navbarContent = document.querySelector("#navbarContent");

  navbarToggler.addEventListener("click", function () {
    navbarContent.classList.toggle("show");
  });
});
