// Fonction de notification unifiée
function message(type, content) {
  document
    .querySelectorAll(".message-notification")
    .forEach((el) => el.remove());

  const divMessage = document.createElement("div");
  divMessage.classList.add("message-notification");
  divMessage.textContent = content;
  divMessage.style.position = "fixed";
  divMessage.style.top = "20px";
  divMessage.style.right = "20px";
  divMessage.style.width = "auto";
  divMessage.style.maxWidth = "300px";
  divMessage.style.maxHeight = "60px";
  divMessage.style.overflow = "hidden";
  divMessage.style.padding = "10px 16px";
  divMessage.style.lineHeight = "1.4";
  divMessage.style.borderRadius = "8px";
  divMessage.style.zIndex = "1000";
  divMessage.style.boxShadow = "0 0 10px rgba(0, 0, 0, 0.3)";
  divMessage.style.opacity = "0.95";

  const styles = getComputedStyle(document.documentElement);
  const colorSuccess = styles.getPropertyValue("--validation").trim();
  const colorError = styles.getPropertyValue("--rougeAkira").trim();
  const colorWarning = styles.getPropertyValue("--bleuNeonBtn").trim();
  const textColor = styles.getPropertyValue("--textes").trim();

  switch (type) {
    case "success":
      divMessage.style.backgroundColor = colorSuccess;
      divMessage.style.color = textColor;
      break;
    case "warning":
      divMessage.style.backgroundColor = colorWarning;
      divMessage.style.color = "#000";
      break;
    case "error":
    default:
      divMessage.style.backgroundColor = colorError;
      divMessage.style.color = textColor;
      break;
  }

  document.body.appendChild(divMessage);
  setTimeout(() => {
    divMessage.remove();
  }, 2000);
}

// Ajout panier
function ajoutPanier(event, id) {
  event.preventDefault();

  fetch("/panier/ajout", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id: id }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        // ✅ Produit bien ajouté
        message("success", "Produit ajouté au panier ❤");
        const NBARTICLES = document.querySelector("#nb_article");
        NBARTICLES.textContent = data.nb;
      } else {
        // ⚠️ Affiche le message d’erreur renvoyé par Symfony
        const errorMessage = data.error || "Une erreur est survenue ❌";
        message("error", errorMessage);
      }
    })
    .catch((error) => {
      console.error("Erreur réseau :", error);
      message("error", "Erreur de connexion au serveur");
    });
}

// Mise à jour de la quantité
async function updateQuantity(event, productId) {
  const quantity = parseInt(event.target.value);
  const messageStock = document.getElementById(`panier_stock-${productId}`);

  if (quantity < 1) {
    event.target.value = 1;
    return;
  }

  try {
    const response = await fetch("/panier/update-quantite", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id: productId, quantity: quantity }),
    });

    const data = await response.json();

    if (response.status === 400 && data.error === "Stock insuffisant") {
      messageStock.textContent = `Stock disponible: ${data.stockDisponible} unités`;
      messageStock.style.display = "block";
      event.target.value = data.stockDisponible;
      message("warning", "Stock insuffisant 🛑");
    } else if (data.success) {
      messageStock.style.display = "none";

      const row = event.target.closest("tr");
      const totalCell = row.querySelector(".total");
      totalCell.textContent = data.productTotal.toFixed(2) + "€";

      const absolutTotal = document.getElementById("absolut-total");
      if (absolutTotal) {
        animateValue(absolutTotal, data.newTotal.toFixed(2) + "€");
      }

      message("success", "Quantité mise à jour");
    } else {
      message("error", data.error);
    }
  } catch (error) {
    console.error("Erreur:", error);
    message("error", "Erreur lors de la mise à jour");
  }
}

// Animation des valeurs
function animateValue(element, newValue) {
  element.style.transition = "color 0.3s";
  element.style.color = "#4CAF50";
  element.textContent = newValue;

  setTimeout(() => {
    element.style.color = "";
  }, 300);
}

// Suppression d'un produit du panier
document.addEventListener("DOMContentLoaded", function () {
  const delButtons = document.querySelectorAll(".btn-delete");

  delButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const productId = this.getAttribute("data-product-id");

      fetch("/panier/supprimer", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id: productId }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            const row = this.closest("tr");
            row.remove();
            const NBARTICLES = document.querySelector("#nb_article");
            if (NBARTICLES) {
              NBARTICLES.textContent = data.nb;
            }

            if (Object.keys(data.cart).length === 0) {
              window.location.reload();
            } else {
              let newTotal = 0;
              Object.values(data.cart).forEach((item) => {
                newTotal += item.price * item.quantity;
              });
              document.getElementById("absolut-total").textContent =
                newTotal + "€";
            }

            message("success", "Produit supprimé du panier");
          }
        })
        .catch((error) => {
          console.error("Erreur:", error);
          message("error", "Erreur lors de la suppression");
        });
    });
  });
});
