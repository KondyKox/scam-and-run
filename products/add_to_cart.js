document.getElementById('addToCartBtn').addEventListener('click', function() {
    // Pobierz productID z PHP (zmienna przekazywana przez PHP) i przypisz ją do zmiennej
    const productID = '<?php echo $productID; ?>';

    // Wyślij żądanie AJAX do pliku PHP (twoj_skrypt_php.php)
    const xhr = new XMLHttpRequest();
    xhr.open('POST', './index.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send('productID=' + productID);

    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Odpowiedź serwera
                alert(xhr.responseText); // Wyświetl alert z odpowiedzią serwera
            } else {
                // Obsłuż błąd żądania
                alert('Błąd żądania AJAX');
            }
        }
    };
});
