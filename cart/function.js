// Change product price based on amount
function changeProductPrice() {
  const container = document.querySelector(".container");

  const amountInputs = container.querySelectorAll(".amount");

  amountInputs.forEach((input) => {
    input.addEventListener("change", (event) => {
      // Pobieramy rodzica inputa, który zawiera h4 z ceną
      const productDiv = event.target.closest(".product");
      const productID = productDiv.getAttribute("data-product-id");

      // Pobieramy element h4 z ceną
      const priceElement = productDiv.querySelector(".price");

      // Pobieramy wartość ceny (musimy zamienić na liczbę)
      const price = parseFloat(priceElement.textContent);

      // Pobieramy nową wartość ilości z inputa
      const newAmount = parseFloat(event.target.value);

      // Obliczamy nową cenę
      const newPrice = price * newAmount;

      // Aktualizujemy zawartość h4 z ceną
      priceElement.textContent = newPrice + " PLN";

      $.ajax({
        method: "POST",
        url: "function.php",
        data: {
          productID: productID,
          newAmount: newAmount,
        },
      });
    });
  });
}

// Count all prices in cart
function totalPrice() {
  const input = document.querySelector(".buy");
  const priceElements = document.querySelectorAll(".price");

  let totalSum = 0;

  priceElements.forEach((element) => {
    const price = parseFloat(element.textContent);
    totalSum += price;
  });

  input.value = "Kup teraz: " + totalSum + " PLN";
}

changeProductPrice();
totalPrice();
