// On encapsule toute la logique de recherche dans une fonction
function initializeSearch() {
  // Récupération des éléments dont nous avons besoin
  const searchInput = document.querySelector("#searchInput");
  const productBlocks = document.querySelectorAll(".produits_blocks");
  let noResultsMessage;

  // Si l'input de recherche existe sur la page
  if (searchInput) {
    // On vérifie si le message existe déjà
    noResultsMessage = searchInput.parentNode.querySelector(".alert");

    // Si le message n'existe pas, on le crée
    if (!noResultsMessage) {
      noResultsMessage = document.createElement("div");
      noResultsMessage.className = "alert alert-info text-center mt-3";
      noResultsMessage.style.display = "none";
      searchInput.parentNode.appendChild(noResultsMessage);
    }

    // On s'assure de nettoyer l'ancien event listener s'il existe
    const newSearchInput = searchInput.cloneNode(true);
    searchInput.parentNode.replaceChild(newSearchInput, searchInput);

    // On ajoute le nouveau event listener
    newSearchInput.addEventListener("input", function () {
      const searchTerm = this.value.toLowerCase().trim();
      let foundResults = false;

      productBlocks.forEach(function (block) {
        const productTitle = block
          .querySelector(".produit-nom")
          .textContent.toLowerCase();

        if (productTitle.includes(searchTerm)) {
          block.style.display = "";
          foundResults = true;
        } else {
          block.style.display = "none";
        }
      });

      if (!foundResults && searchTerm !== "") {
        noResultsMessage.textContent = `Désolé! Aucun produit ne correspond à "${searchTerm}"`;
        noResultsMessage.style.display = "block";
      } else {
        noResultsMessage.style.display = "none";
      }
    });
  }
}

// Initialisation au chargement initial de la page
document.addEventListener("DOMContentLoaded", initializeSearch);

// Réinitialisation après les clics sur les liens
document.addEventListener("click", function (e) {
  // Si c'est un lien qui a été cliqué
  if (e.target.closest("a")) {
    // On réinitialise après un court délai pour laisser le temps à la page de se mettre à jour
    setTimeout(initializeSearch, 100);
  }
});

// Réinitialisation lors de l'utilisation du bouton retour/avant du navigateur
window.addEventListener("popstate", function () {
  setTimeout(initializeSearch, 100);
});
