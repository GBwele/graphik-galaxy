const shopCarouselContainer = document.querySelector(".shop-carousel-list");
const shopCarouselItems = document.querySelectorAll(".shop-carousel-item");
let shopCarouselItemWidth =
  document.querySelector(".shop-carousel-item").offsetWidth + 1;

const itemsClone = Array.from(shopCarouselItems).map((item) =>
  item.cloneNode(true)
);
itemsClone.forEach((item) => shopCarouselContainer.append(item));

window.addEventListener("resize", function () {
  shopCarouselItemWidth =
    document.querySelector(".shop-carousel-item").offsetWidth + 1;
});

setInterval(() => {
  shopCarouselContainer.scrollBy({
    left: shopCarouselItemWidth,
    behavior: "smooth",
  });

  if (
    shopCarouselContainer.scrollLeft >=
    shopCarouselContainer.scrollWidth / 2
  ) {
    shopCarouselContainer.scrollLeft = 0;
  }
}, 2000);
