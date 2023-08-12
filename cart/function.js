// Change product price based on amount
function changeProductPrice() {
  const container = document.querySelector(".container");
  const amountInputs = container.querySelectorAll(".amount");

  amountInputs.forEach((input) => {
    input.addEventListener("change", (event) => {
      const productDiv = event.target.closest(".product");
      const productID = productDiv.getAttribute("data-product-id");
      const priceElement = productDiv.querySelector(".price");
      const price = parseFloat(priceElement.textContent);
      const newAmount = parseFloat(event.target.value);
      const newPrice = price * newAmount;

      priceElement.textContent = newPrice + " PLN";

      $.ajax({
        method: "POST",
        url: "functions.php",
        data: {
          action: "changeAmount",
          newAmount: newAmount,
          productID: productID,
        },
        success: function (response) {
          console.log(response);
        },
        error: function (xhr, status, error) {
          console.error(error);
          alert("Wystąpił błąd przy zmianie ilości.");
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
  window.location.href = "purchase.php?total_cost=" + totalSum;
}

// Delete item from cart
function deleteItem() {
  const container = document.querySelector(".container");
  const deleteButtons = container.querySelectorAll(".delete");

  deleteButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      const productDiv = event.target.closest(".product");
      const productID = productDiv.getAttribute("data-product-id");

      $.ajax({
        method: "POST",
        url: "functions.php",
        data: {
          action: "deleteItem",
          productID: productID,
        },
      });
    });
  });
}

changeProductPrice();
totalPrice();
deleteItem();
