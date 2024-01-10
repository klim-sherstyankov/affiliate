const searchForm = document.querySelector(".header__search-form");
let searchedSales = [];

searchForm.addEventListener("submit", (evt) => {
  evt.preventDefault();

  mainContent.innerHTML = "";
  salesContainer = document.createElement("ul");
  salesContainer.classList.add("card-list");
  mainContent.append(salesContainer);
  mainContent.classList.add("main");
  mainContent.classList.remove("main__product-card");

  const searchInput = searchForm.querySelector(".header__search-field");

  getSearchedSales(searchInput.value).then(() => {
    renderSalesPage(searchedSales);
    window.history.pushState({ content: mainContent.innerHTML }, "", "");
  });

  searchInput.value = "";
});

async function getSearchedSales(searchText) {
  try {
    const res = await fetch(`./api/search/${searchText}.json`);

    if (!res.ok) {
      throw new Error(res.statusText);
    }

    searchedSales = await res.json();
  } catch (err) {
    showErrorMessage("Ошибка сервера!");
    console.log(err);
  }
}
