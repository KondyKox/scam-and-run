// Nasłuchujemy kliknięcia na przycisk "Dodaj do koszyka"
document.getElementById("addToCartBtn").addEventListener("click", function () {
  // Pobieramy ID produktu z przycisku lub z innej zmiennej w swoim kontekście
  var productID = parseInt("<?php echo $productID; ?>");

  // Wykonujemy żądanie AJAX
  $.ajax({
    type: "POST",
    url: "./index.php",
    data: { id: productID },
    dataType: "json",
    success: function (response) {
      // Obsługa odpowiedzi z serwera
      console.log(response); // Powinien wyświetlić "Dodano do koszyka"
      alert("Produkt został dodany do koszyka.");
    },
    error: function (xhr, status, error) {
      console.error(error); // Wyświetlenie błędu w konsoli
      alert("Wystąpił błąd. Produkt nie został dodany do koszyka.");
    },
  });
});
