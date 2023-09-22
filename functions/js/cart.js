// Usuwanie produktu z koszyka
$(".delete").click(function () {
  var productId = $(this).data("product-id");

  $.ajax({
    type: "POST",
    url: "../php/remove_from_cart.php",
    data: { productID: productId },
    success: function (response) {
      if (response.success) {
        location.reload(); // Odśwież stronę
      } else {
        alert("Błąd podczas usuwania produktu z koszyka.");
      }
    },
    error: function (xhr, status, error) {
      console.error(error);
      alert("Wystąpił błąd podczas komunikacji z serwerem. Error: " + error);
    },
  });
});

// Obsługa zmiany ilości produktu
$(".amount").change(function () {
  var productId = $(this).data("product-id");
  var newAmount = $(this).val();

  $.ajax({
    type: "POST",
    url: "../php/update_quantity.php",
    data: { productID: productId, newAmount: newAmount },
    success: function (response) {
      if (response.success) {
        // Zaktualizowano ilość produktu, możesz zaktualizować cenę na stronie
        updatePrice(productId, newAmount);
      } else {
        alert("Błąd podczas aktualizacji ilości produktu.");
      }
    },
    error: function (xhr, status, error) {
      console.error(error);
      alert("Wystąpił błąd podczas komunikacji z serwerem. Error: " + error);
    },
  });
});

// Nasłuchiwanie zmiany ilości produktu
const amountInputs = document.querySelectorAll(".amount");

amountInputs.forEach((input) => {
  input.addEventListener("change", (event) => {
    const productDiv = event.target.closest(".product");
    const productID = productDiv.getAttribute("data-product-id");
    const newAmount = parseFloat(event.target.value);

    // Aktualizacja ceny
    updatePrice(productID, newAmount);
  });
});

// Funkcja do aktualizacji ceny na stronie po zmianie ilości
function updatePrice(productID, newAmount) {
  $.ajax({
    method: "POST",
    url: "../php/updatePrice.php",
    data: {
      productID: productID,
      newAmount: newAmount,
    },
    success: function (response) {
      console.log(response);
    },
    error: function (xhr, status, error) {
      console.error(error);
      alert("Wystąpił błąd przy aktualizacji ceny. Error: " + error);
    },
  });
}

// Count all prices in cart
function totalPrice() {
  const input = document.querySelector(".buy");
  const priceElements = document.querySelectorAll(".price");

  let total_cost = 0;

  priceElements.forEach((element) => {
    const price = parseFloat(element.textContent);
    total_cost += price;
  });

  input.value = "Kup teraz: " + total_cost + " PLN";
}

// Obsługa przycisku "Kup"
function checkout() {
  // Przekierowanie na stronę zakupów
  window.location.href = "purchase.php";
}

totalPrice();
