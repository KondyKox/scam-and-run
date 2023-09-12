// Change product price based on amount
function changeProductPrice() {
  const container = document.querySelector(".container");
  const amountInputs = container.querySelectorAll(".amount");

  amountInputs.forEach((input) => {
    input.addEventListener("change", (event) => {
      const productDiv = event.target.closest(".product");
      const productID = productDiv.getAttribute("data-product-id");

      $.ajax({
        method: "POST",
        url: "functions.php",
        data: {
          action: "getPrice",
          productID: productID,
        },
        success: function (response) {
          let basicPrice = response;

          const priceElement = productDiv.querySelector(".price");
          const price = basicPrice;
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
        },
        error: function (xhr, status, error) {
          console.error(error);
        },
      });
    });
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

  document.cookie = "total_cost=" + total_cost;
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
        success: function (response) {
          console.log(response);
        },
        error: function (xhr, status, error) {
          console.error(error);
          alert("Wystąpił błąd przy usuwaniu przedmiotu.");
        },
      });
    });
  });
}

// Function to stop starting action after click on another inputs than submit
function stopInputAction() {
  document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    form.addEventListener("submit", function (event) {
      if (!event.target.matches(".buy")) {
        event.preventDefault();
      }
    });

    const amountInput = document.querySelector(".amount");
    const deleteButton = document.querySelector(".delete");

    amountInput.addEventListener("change", function (event) {
      event.preventDefault();
    });

    deleteButton.addEventListener("click", function (event) {
      event.preventDefault();
    });
  });
}

changeProductPrice();
totalPrice();
deleteItem();
stopInputAction();
