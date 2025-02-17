document.addEventListener("DOMContentLoaded", function () {
  const paypalBtn = document.getElementById("paypalBtn");
  const cardBtn = document.getElementById("cardBtn");
  const cardForm = document.getElementById("cardForm");
  const confirmationMessage = document.getElementById("confirmationMessage");
  const paymentForm = document.getElementById("paymentForm");

  // Gestionnaire pour le bouton PayPal
  paypalBtn.addEventListener("click", function () {
    // Cache le formulaire de carte si visible
    cardForm.style.display = "none";
    // Simule un paiement PayPal
    setTimeout(() => {
      confirmationMessage.style.display = "block";
    }, 1500);
  });

  // Gestionnaire pour le bouton Carte
  cardBtn.addEventListener("click", function () {
    // Affiche/cache le formulaire de carte
    if (cardForm.style.display === "none") {
      cardForm.style.display = "block";
      confirmationMessage.style.display = "none";
    } else {
      cardForm.style.display = "none";
    }
  });

  // Gestion du formulaire de carte
  paymentForm.addEventListener("submit", function (e) {
    e.preventDefault();
    cardForm.style.display = "none";
    confirmationMessage.style.display = "block";
  });

  // Formatage automatique de la date d'expiration
  const expiryInput = document.getElementById("expiry");
  expiryInput.addEventListener("input", function (e) {
    let value = e.target.value.replace(/\D/g, "");
    if (value.length >= 2) {
      value = value.substr(0, 2) + "/" + value.substr(2);
    }
    e.target.value = value.substr(0, 5);
  });
});
