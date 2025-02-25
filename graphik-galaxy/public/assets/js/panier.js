function ajoutPanier(event, id) {
  event.preventDefault();
  fetch("/panier/ajout", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ id: id }),
  })
    .then((response) => {
      return response.json();
    })
    .then((data) => {
      if (data.success) {
        message("votre produit est bien envoyé dans le panier ❤", data.success); // message de confirmation
        const NBARTICLES = document.querySelector("#nb_article");
        NBARTICLES.textContent = data.nb;
      } else {
        message("le produit est deja ajouté dans le panier 👀", data.error); // message d'erreur si nécessaire
      }
    })
    .catch((error) => {
      console.error("Erreur:", error);
      message("Une erreur est survenue.");
    });
}

function message(type, message) {
  const vieuxMessage = document.querySelectorAll(".message-notification");
  vieuxMessage.forEach((msg) => msg.remove());
  const divMessage = document.createElement("div");

  
  divMessage.classList.add("message-notofication");
  divMessage.textContent = message;
  divMessage.style.position = "fixed";
  divMessage.style.bottom = "20px";
  divMessage.style.right = "20px";
  divMessage.style.padding = "10px";
  divMessage.style.color = type === "success" ? "white" : "white";
  divMessage.style.backgroundColor = type === "success" ? "green" : "red";
  divMessage.style.borderRadius = "5px";
  divMessage.style.zIndex = "1000";
  divMessage.style.boxShadow = "0 0 10px rgba(0, 0, 0, 0.2)";
  divMessage.style.opacity = "0.9";

  document.body.appendChild(divMessage);

  setTimeout(() => {
    divMessage.remove();
  }, 3000);
}


// Fonction pour mettre à jour la quantité
async function updateQuantity(event, productId) {
  const quantity = parseInt(event.target.value);
  const messageStock = document.getElementById(`panier_stock-${productId}`);

  if (quantity < 1) {
    event.target.value = 1;
    return;
  }
  console.log("Quantité demandée:", quantity);

  try {
    const response = await fetch("/panier/update-quantite", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        id: productId,
        quantity: quantity,
      }),
    });

    const data = await response.json();
    console.log("Réponse du serveur:", data);

    if (response.status === 400 && data.error === "Stock insuffisant") {
      messageStock.textContent = `Stock disponible: ${data.stockDisponible} unités`;
      messageStock.style.display = "block";
      event.target.value = data.stockDisponible;
    } else if (data.success) {
      messageStock.style.display = "none";

      // Mise à jour du total du produit
      const row = event.target.closest("tr");
      const totalCell = row.querySelector(".total");
      totalCell.textContent = data.productTotal.toFixed(2) + "€";

      // Mise à jour du total global
      const absolutTotal = document.getElementById("absolut-total");
      if (absolutTotal) {
        animateValue(absolutTotal, data.newTotal.toFixed(2) + "€");
      }

      // Message de confirmation
      message("success", "Quantité mise à jour");
    } else {
      message("error", data.error);
    }
  } catch (error) {
    console.error("Erreur:", error);
    message("error", "Erreur lors de la mise à jour");
  }
}

// Fonction d'animation (comme précédemment)
function animateValue(element, newValue) {
  element.style.transition = "color 0.3s";
  element.style.color = "#4CAF50";
  element.textContent = newValue;

  setTimeout(() => {
    element.style.color = "";
  }, 300);
}

document.addEventListener("DOMContentLoaded", function () {
  const delButtons = document.querySelectorAll(".btn-delete");

  delButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const productId = this.getAttribute("data-product-id");

      fetch("/panier/supprimer", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          id: productId,
        }),
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
              document.getElementById("absolutTotal").textContent =
                newTotal + "€";
            }
          }
        })
        .catch((error) => {
          console.error("Erreur:", error);
          console.log("erreur dans la suppression");
        });
    });
  });
});

// section stocks
