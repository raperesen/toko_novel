function toggleGenre() {
  var genreOptions = document.getElementById("genre-options");
  genreOptions.style.display = genreOptions.style.display === "none" ? "block" : "none";
}

function toggleYear() {
  var yearOptions = document.getElementById("year-options");
  yearOptions.style.display = yearOptions.style.display === "none" ? "block" : "none";
}

function toggleRecommendation() {
  var recommendationOptions = document.getElementById("recommendation-options");
  recommendationOptions.style.display = recommendationOptions.style.display === "none" ? "block" : "none";
}

function searchNovel() {
  const query = document.getElementById("search-input").value.toLowerCase();
  const products = document.querySelectorAll(".product");

  products.forEach((product) => {
    const productName = product.querySelector("h3").textContent.toLowerCase();
    const genre = product.getAttribute("data-genre").toLowerCase();
    const year = product.getAttribute("data-year");

    if (productName.includes(query) || genre.includes(query) || year.includes(query)) {
      product.style.display = "block"; 
    } else {
      product.style.display = "none"; 
    }
  });
}

