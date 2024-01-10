window.addEventListener("popstate", (event) => {
  mainContent.innerHTML = event.state.content;

  if (event.state.content.includes("card-list")) {
    mainContent.classList.remove("main__product-card");
    mainContent.classList.add("main");

    salesContainer = document.querySelector(".card-list");
  }
  if (event.state.content.includes("product-card")) {
    mainContent.classList.remove("main");
    mainContent.classList.add("main__product-card");

    if (window.innerWidth <= 580) {
      showMoreDescription();
    }
  }

  document
    .querySelectorAll("img")
    .forEach((image) =>
      image.addEventListener("error", () => onErrorImageLoading(image))
    );
});

document.body.addEventListener("click", (evt) => {
  const clickTarget = evt.target;

  if (clickTarget.closest(".card__text")) {
    clickTarget.closest(".card__text").classList.toggle("minimize");
  }

  if (
    clickTarget.closest(".card") &&
    !clickTarget.closest(".card__text") &&
    !clickTarget.closest(".card__shop-image") &&
    !clickTarget.closest(".card__product-btn")
  ) {
    const card = clickTarget.closest(".card");
    onCardClick(card);
  }
});
