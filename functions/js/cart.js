// Usuwanie produktu z koszyka
$(".delete").click(function () {
  var productId = $(this).data("product-id");

  $.ajax({
    type: "POST",
    url: "../functions/php/remove_from_cart.php",
    data: { productID: productId },
    success: function (response) {
      if (response.success) {
        location.reload(); // Odśwież stronę
      } else {
        location.reload();
        // alert("Błąd podczas usuwania produktu z koszyka.");
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
  
  updateProduct(productId, newAmount);

  totalPrice();
});

// Funkcja do aktualizacji produktu
function updateProduct(productId, newAmount) {
  $.ajax({
    type: "POST",
    url: "../functions/php/update_product.php",
    data: { productID: productId, newAmount: newAmount },
    success: function (response) {
      if (response.success) {
        location.reload();
        console.log(response);
      } else {
        location.reload();
        // alert("Błąd podczas aktualizacji produktu.");
      }
    },
    error: function (xhr, status, error) {
      console.error(error);
      alert("Wystąpił błąd podczas komunikacji z serwerem. Error: " + error);
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
