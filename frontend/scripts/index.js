"use strict";

const COUNT_SHOW_CARDS_CLICK = 30;
const NO_IMAGE_PATH = "./images/no-image.jpg";

let salesList = [];

const mainContent = document.querySelector("#main");
let salesContainer = document.querySelector(".card-list");

const saleTemplate = document.querySelector("#card-template").content;
const mobileSaleTemplate = document.querySelector(
  "#mobile-card-template"
).content;
const mobileProductCardTemplate = document.querySelector(
  "#mobile-product-card"
).content;
const tabletProductCardTemplate = document.querySelector(
  "#tablet-product-card"
).content;
const productCardTemplate = document.querySelector("#product-card").content;

function showErrorMessage(message) {
  alert(message);
}

getSales().then(() =>
  window.history.replaceState({ content: main.innerHTML }, "", "")
);

async function getSales() {
  try {
    if (!salesList.length) {
      const res = await fetch("./api/items/salesList.json");

      if (!res.ok) {
        throw new Error(res.statusText);
      }

      salesList = await res.json();
    }

    renderSalesPage(salesList);
  } catch (err) {
    showErrorMessage("Ошибка сервера!");
    console.log(err);
  }
}

function renderSalesPage(sales) {
  if (!sales || !sales.length) {
    showErrorMessage("Нет скидок!");
    return;
  }

  const arrSales = sales.slice(0, COUNT_SHOW_CARDS_CLICK);
  arrSales.forEach((sale) => {
    salesContainer.append(createSaleCard(sale));
  });
}

function createSaleCard(sale) {
  const {
    id,
    image,
    shortName,
    description,
    salePrice,
    price,
    priceOffPercent,
    shopImg,
    shopName,
    url,
  } = sale;

  let cardElement;

  if (window.innerWidth <= 580) {
    cardElement = mobileSaleTemplate
      .querySelector(".card-list__item")
      .cloneNode(true);
  } else {
    cardElement = saleTemplate
      .querySelector(".card-list__item")
      .cloneNode(true);
  }

  const card = cardElement.querySelector(".card");
  card.dataset.id = id;

  const cardImage = cardElement.querySelector(".card__image");
  cardImage.src = image;
  cardImage.addEventListener("error", () => onErrorImageLoading(cardImage));

  const cardTitle = cardElement.querySelector(".card__title");
  cardTitle.insertAdjacentText("beforeend", shortName);

  const cardDescription = cardElement.querySelector(".card__text");
  if (cardDescription) {
    cardDescription.insertAdjacentHTML("beforeend", description);
  }

  const cardButton = cardElement.querySelector(".card__product-btn");
  cardButton.href = url;

  const cardShopName = cardElement.querySelector(".card__shop-name");
  cardShopName.insertAdjacentText("beforeend", shopName);

  const cardShopImage = cardElement.querySelector(".card__shop-image");
  cardShopImage.src = shopImg;
  cardShopImage.addEventListener("error", () =>
    onErrorImageLoading(cardShopImage)
  );

  const cardSalePrice = cardElement.querySelector(".card__sale-price");
  cardSalePrice.insertAdjacentText("beforeend", `${price} ₽`);

  const cardPrice = cardElement.querySelector(".card__price");
  cardPrice.insertAdjacentText("beforeend", `${salePrice} ₽`);

  const cardSale = cardElement.querySelector(".card__sale");
  cardSale.insertAdjacentText("beforeend", `${priceOffPercent}%`);

  return cardElement;
}

function onCardClick(card) {
  getProductCard(card.dataset.id);
}

function onErrorImageLoading(image) {
  image.src = NO_IMAGE_PATH;
}

async function getProductCard(saleId) {
  try {
    const res = await fetch(`./api/item/${saleId}.json`);
    if (!res.ok) {
      throw new Error(res.statusText);
    }

    const sale = await res.json();
    renderProductCard(sale);
  } catch (err) {
    showErrorMessage("Ошибка сервера!");
    console.log(err);
  }
}

function renderProductCard(clickedSale) {
  if (!clickedSale) {
    showErrorMessage("Такая скидка не найдена!");
    return;
  }

  mainContent.innerHTML = "";

  if (window.innerWidth <= 580) {
    mainContent.append(
      createProductCard(clickedSale),
      createSimilarProducts(),
      createMobileProductButton(clickedSale.url)
    );
  } else if (window.innerWidth <= 1100) {
    mainContent.append(createProductCard(clickedSale), createSimilarProducts());
  } else {
    mainContent.append(
      createProductCard(clickedSale),
      createSimilarProducts(),
      createAsideElement(clickedSale)
    );
  }
  showMoreDescription();
  mainContent.classList.remove("main");
  mainContent.classList.add("main__product-card");

  window.history.pushState({ content: main.innerHTML }, "", "");
}

function createProductCard(sale) {
  const {
    id,
    image,
    shortName,
    description,
    feature,
    salePrice,
    price,
    priceOffPercent,
    shopImg,
    shopName,
    url,
  } = sale;

  let productCardElement;

  if (window.innerWidth <= 580) {
    productCardElement = mobileProductCardTemplate
      .querySelector(".product-card__layout")
      .cloneNode(true);
  } else if (window.innerWidth <= 1100) {
    productCardElement = tabletProductCardTemplate
      .querySelector(".product-card__layout")
      .cloneNode(true);
  } else {
    productCardElement = productCardTemplate
      .querySelector(".product-card__layout")
      .cloneNode(true);
  }

  const productCard = productCardElement.querySelector(".product-card");
  productCard.dataset.id = id;

  const productCardImage = productCardElement.querySelector(
    ".product-card__image"
  );
  productCardImage.src = image;

  const productCardTitle = productCardElement.querySelector(
    ".product-card__title"
  );
  productCardTitle.insertAdjacentText("beforeend", shortName);

  const productCardSalePrice = productCardElement.querySelector(
    ".product-card__sale-price"
  );
  if (productCardSalePrice) {
    productCardSalePrice.insertAdjacentText("beforeend", `${price} ₽`);
  }

  const productCardPrice = productCardElement.querySelector(
    ".product-card__price"
  );
  if (productCardPrice) {
    productCardPrice.insertAdjacentText("beforeend", `${salePrice} ₽`);
  }

  const productCardSale = productCardElement.querySelector(
    ".product-card__sale"
  );
  if (productCardSale) {
    productCardSale.insertAdjacentText("beforeend", `${priceOffPercent}%`);
  }

  const productCardDescription = productCardElement.querySelector(
    ".product-card_description"
  );
  productCardDescription.insertAdjacentHTML("beforeend", `${description}`);

  const productCardFeatures = productCardElement.querySelector(
    ".product-card__features-text"
  );
  if (productCardFeatures) {
    productCardFeatures.insertAdjacentHTML("beforeend", feature);
  }

  const productCardShopImage = productCardElement.querySelector(
    ".product-card__shop-image"
  );
  if (productCardShopImage) {
    productCardShopImage.src = shopImg;
  }

  const productCardShopName = productCardElement.querySelector(
    ".product-card__shop-name"
  );
  if (productCardShopName) {
    productCardShopName.insertAdjacentText("beforeend", shopName);
  }

  const productButton = productCardElement.querySelector(
    ".product-card__product-btn"
  );
  if (productButton) {
    productButton.href = url;
  }

  return productCardElement;
}

function createSimilarProducts() {
  const similarProductsElement = mobileProductCardTemplate
    .querySelector(".similar-products")
    .cloneNode(true);

  return similarProductsElement;
}

function createMobileProductButton(url) {
  const mobileProductButtonContainer = mobileProductCardTemplate
    .querySelector(".product-card__product-info")
    .cloneNode(true);
  const mobileProductButton = mobileProductButtonContainer.querySelector(
    ".product-card__product-btn"
  );
  mobileProductButton.href = url;
  return mobileProductButtonContainer;
}

function createAsideElement(sale) {
  const { price, priceOffPercent, salePrice, url, shopImg } = sale;
  const productCardAsideElement = productCardTemplate
    .querySelector(".product-card__aside-info")
    .cloneNode(true);

  const productCardSalePrice = productCardAsideElement.querySelector(
    ".product-card__sale-price"
  );
  productCardSalePrice.insertAdjacentText("beforeend", `${price} ₽`);

  const productCardPrice = productCardAsideElement.querySelector(
    ".product-card__price"
  );
  productCardPrice.insertAdjacentText("beforeend", `${salePrice} ₽`);

  const productCardSale = productCardAsideElement.querySelector(
    ".product-card__sale"
  );
  productCardSale.insertAdjacentText("beforeend", `${priceOffPercent}%`);

  const productButton = productCardAsideElement.querySelector(
    ".product-card__product-btn"
  );
  productButton.href = url;

  const productCardShopImage = productCardAsideElement.querySelector(
    ".product-card__shop-image"
  );
  productCardShopImage.src = shopImg;

  return productCardAsideElement;
}

function showMoreDescription() {
  const productCardText = document.querySelector(".product-card_description");

  if (!productCardText || window.innerWidth > 580) {
    return;
  }
  const productCardShowButtonContainer = document.querySelector(
    ".product-card__show-btn_container"
  );
  const productCardShowButtonText =
    productCardShowButtonContainer.querySelector(
      ".product-card__show-btn span"
    );
  const productCardShowButtonImage =
    productCardShowButtonContainer.querySelector(".product-card__show-btn img");

  if (productCardText.scrollHeight > productCardText.offsetHeight) {
    productCardShowButtonContainer.style.display = "block";
    productCardText.style.setProperty("--after-state", "block");
  }

  productCardShowButtonContainer.addEventListener("click", () => {
    if (productCardText.scrollHeight > productCardText.offsetHeight) {
      productCardText.style.maxBlockSize =
        productCardText.scrollHeight.toString() + "px";
      productCardShowButtonText.textContent = "Свернуть";
      productCardShowButtonImage.style.rotate = "180deg";
      productCardText.style.setProperty("--after-state", "none");
    } else {
      productCardText.style.maxBlockSize = "200px";
      productCardShowButtonText.textContent = "Развернуть";
      productCardShowButtonImage.style.rotate = "none";
      productCardText.style.setProperty("--after-state", "block");
    }
  });
}
