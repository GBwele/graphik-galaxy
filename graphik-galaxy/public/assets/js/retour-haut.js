const retourHaut = document.querySelector("#retour_haut");
const tailleComplete = document.querySelector();

window.addEventListener("scroll", () => {
  if (window.scrollY > 300) {
    retourHaut.style.display = "block";
  } else {
    retourHaut.style.display = "none";
  }
});

retourHaut.addEventListener("click", () => {
  console.log("Bouton cliqué, retour en haut !");
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
});
