<?php
require_once './static/index_header.php';
?>
<!-- Hero Section -->
<section class="jumbotron text-center">
  <div class="container">
    <h1 class="display-4">Artikel</h1>
  </div>
</section>
<section class="container">
  <div id="latestNewsContainer"></div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
  $(document).ready(function () {
    // Mengambil data artikel dari server menggunakan AJAX
    $.ajax({
      url: './config/load_article.php',
      type: 'GET',
      dataType: 'json',
      success: function (response) {
        var articles = response;

        // Menampilkan data artikel ke dalam elemen HTML
        articles.forEach(function (article) {
          var card = $('<a>', { class: 'card mb-3 list-group-item', href: 'article_content.php?id=' + article.id }); // Menambahkan class "list-group-item" pada card
          var cardBody = $('<div>', { class: 'card-body d-flex' });
          var imageContainer = $('<div>', { class: 'image-container' });
          var image = $('<img>', { class: 'card-img-top', src: './img/src/' + article.image, alt: 'Article Image' });
          image.css({ 'width': '75px', 'height': '75px', 'margin-right': '10px', 'border-radius': '5px' }); // Mengatur lebar, tinggi, margin, dan border radius gambar
          var contentContainer = $('<div>', { class: 'content-container' });
          var title = $('<h5>', { class: 'card-title', text: article.title });
          var content = $('<p>', { class: 'card-text', text: article.content });

          // Mengatur batas panjang teks konten
          var maxLength = 200;
          if (article.content.length > maxLength) {
            var trimmedContent = article.content.substr(0, maxLength) + '...';
            content.text(trimmedContent);
          }

          // Membuat link dengan id artikel sebagai tujuan
          var link = $('<a>', {
            href: 'article_content.php?id=' + article.id,
            text: 'Read More'
          });

          // Menambahkan elemen-elemen ke dalam card
          imageContainer.append(image);
          contentContainer.append(title, content);
          cardBody.append(imageContainer, contentContainer);
          card.append(cardBody);
          $('#latestNewsContainer').append(card);
        });

      },
      error: function (jqXHR, textStatus, errorThrown) {
        // Menampilkan pesan error jika terjadi kesalahan dalam permintaan AJAX
        console.log('Error: ' + textStatus + ' - ' + errorThrown);
      }
    });
  });

</script>




<!-- Footer -->
<footer class="bg-dark text-white text-center py-4">
  <p>&copy; 2023 UKRIDA LIBRARY. All rights reserved.</p>
</footer>
</body>

</html>