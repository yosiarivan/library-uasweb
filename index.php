<?php
require_once './static/index_header.php';
?>

<!-- Hero Section -->
<section class="jumbotron text-center">
  <div class="container">
    <h1 class="display-4">Selamat datang di UKRIDA LIBRARY!</h1>
    <p class="lead">Temukan koleksi buku terbaru dan bacaan favorit Anda.</p>
    <a href="book.php" class="btn btn-primary">Lihat Koleksi Buku</a>
  </div>
</section>
<hr class="my-7">
<!-- Data Gallery akan dimuat di sini -->
<section class="container">
  <div class="row">
    <div class="col-md-6">
      <div id="galleryCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators"></ol>
        <div class="carousel-inner"></div>
        <a class="carousel-control-prev" href="#galleryCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#galleryCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>

    <!-- Data artikel akan dimuat di sini -->
    <div class="col-md-6">

      <ul class="list-group" id="newsList">
        <!-- Data artikel akan dimuat di sini -->
      </ul>

    </div>
  </div>
</section>

<hr class="my-7">
<section class="container">
  <h2 class="text-center mb-4">Buku Terbaru</h2>
  <div class="row">
    <div id="book-list"></div>
  </div>
</section>
<!-- Modal Book Info-->
<div class="modal fade" id="bookModal" tabindex="-1" role="dialog" aria-labelledby="bookModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bookModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="bookModalBody">
        <div class="row">
          <div class="col-md-6">
            <img class="img-fluid" id="bookModalImage" alt="">
          </div>
          <div class="col-md-6">
            <h5 id="bookModalTitle"></h5>
            <p id="bookModalAuthor"></p>
            <p id="bookModalGenre"></p>
            <p id="bookModalYear"></p>
            <p id="bookModalStatus"></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
    loadGallery();

    function loadGallery() {
      $.ajax({
        url: './backend/getGallery.php', // Ganti dengan URL endpoint Anda
        method: 'GET',
        dataType: 'json',
        success: function (response) {
          if (response.status === 'success') {
            var galleryItems = response.data;
            var carouselIndicators = $('#galleryCarousel .carousel-indicators');
            var carouselInner = $('#galleryCarousel .carousel-inner');

            // Reset carousel indicators and inner content
            carouselIndicators.empty();
            carouselInner.empty();

            // Loop through gallery items and create carousel items
            for (var i = 0; i < galleryItems.length; i++) {
              var item = galleryItems[i];
              var activeClass = i === 0 ? 'active' : '';

              // Create carousel indicators
              var indicator = $('<li></li>').attr('data-target', '#galleryCarousel').attr('data-slide-to', i).addClass(activeClass);
              carouselIndicators.append(indicator);

              // Create carousel item
              var carouselItem = $('<div></div>').addClass('carousel-item').addClass(activeClass);
              var image = $('<img>').attr('src', './img/src/' + item.image_url).attr('alt', item.title).addClass('carousel-image');

              carouselItem.append(image);
              carouselInner.append(carouselItem);
            }
          } else {
            console.log('Terjadi kesalahan saat memuat data galeri: ' + response.message);
          }
        },
        error: function (xhr, status, error) {
          console.log('Terjadi kesalahan saat memuat data galeri: ' + error);
        }
      });
    }
  });


  $(document).ready(function () {
    // Fungsi untuk membuat card artikel
    function createArticleCard(article) {
      var card = '<li class="list-group-item" data-id="' + article.id + '">';
      card += '<div class="media">';
      card += '<img src="./img/src/' + article.image + '" class="mr-3 img-thumbnail" width="50" height="50" alt="' + article.title + '">';
      card += '<div class="media-body">';
      card += '<h5 class="mt-0">' + article.title + '</h5>';
      card += '<p class="mt-2">' + article.content.slice(0, 70) + (article.content.length > 70 ? '...' : '') + '</p>';
      card += '</div>';
      card += '</div>';
      card += '</li>';

      return card;
    }

    // Fungsi untuk memuat data artikel
    function loadArticles() {
      $.ajax({
        url: './config/latest_article.php',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
          if (response.status === 'success') {
            var articleItems = '';

            // Membuat markup untuk setiap data artikel
            response.data.forEach(function (article) {
              articleItems += createArticleCard(article);
            });

            // Menambahkan markup ke dalam list
            $('#newsList').html(articleItems);

            // Menambahkan event listener untuk setiap card
            $('.list-group-item').click(function () {
              var articleId = $(this).data('id');
              // Navigasi ke halaman berita terkait dengan ID artikel
              window.location.href = './article_content.php?id=' + articleId;
            });
          } else {
            console.log('Terjadi kesalahan: ' + response.message);
          }
        },
        error: function (xhr, status, error) {
          console.log('Terjadi kesalahan saat memuat data artikel: ' + error);
        }
      });
    }

    // Memuat data artikel saat halaman siap
    loadArticles();
  });




  $(document).ready(function () {
    var bookList = $('#book-list');

    // Fungsi untuk menampilkan modal dengan data buku
    function showBookModal(book) {
      var modalTitle = $('#bookModalLabel');
      var modalImage = $('#bookModalImage');
      var modalTitleText = $('#bookModalTitle');
      var modalAuthor = $('#bookModalAuthor');
      var modalGenre = $('#bookModalGenre');
      var modalYear = $('#bookModalYear');
      var modalStatus = $('#bookModalStatus');

      modalTitle.text(book.title);
      modalImage.attr('src', './img/src/' + book.img);
      modalTitleText.text(book.title);
      modalAuthor.text('Penulis: ' + book.author);
      modalGenre.text('Genre: ' + book.genre);
      modalYear.text('Tahun: ' + book.year);
      modalStatus.text('Status: ' + book.status);

      $('#bookModal').modal('show');
    }

    // Fungsi untuk mengambil data buku terbaru menggunakan AJAX
    function fetchLatestBooks() {
      $.ajax({
        url: './config/latest_book.php', // Ganti dengan URL atau path ke file PHP yang akan mengambil data buku terbaru dari database
        type: 'GET',
        dataType: 'json',
        success: function (response) {
          // Memperbarui elemen "book-list" dengan data buku terbaru
          bookList.empty();

          if (response.length > 0) {
            $.each(response, function (index, book) {
              // Membuat elemen card untuk setiap buku
              var card = $('<div class="col-lg-4 col-md-6 mb-4">');
              var cardContent = $('<div class="card w-100 d-flex flex-column">');
              var img = $('<img class="card-img-top object-fit img-fluid">');
              img.attr('src', './img/src/' + book.img);
              img.attr('alt', book.title);
              var cardBody = $('<div class="card-body">');
              var title = $('<h5 class="card-title">').text(book.title);
              var readMoreLink = $('<a href="#" class="btn btn-primary">').text('Baca Selengkapnya');

              // Menambahkan event listener untuk menampilkan modal saat tombol "Baca Selengkapnya" diklik
              readMoreLink.on('click', function () {
                showBookModal(book);
              });

              // Menambahkan elemen-elemen ke dalam card
              cardContent.append(img, cardBody);
              cardBody.append(title, readMoreLink);
              card.append(cardContent);
              bookList.append(card);

              // Menambahkan gaya CSS untuk mengatur tampilan kartu secara horizontal (ke samping)
              bookList.css('display', 'flex');
              bookList.css('flex-wrap', 'wrap');
            });
          } else {
            bookList.text('Tidak ada data buku yang tersedia.');
          }
        },
        error: function (xhr, status, error) {
          console.log('Error: ' + error);
        }
      });
    }

    // Memanggil fungsi untuk mengambil data buku terbaru saat halaman dimuat
    fetchLatestBooks();
  });


</script>
<!-- Footer -->
<footer class="bg-dark text-white text-center py-4">
  <p>&copy; 2023 UKRIDA LIBRARY. All rights reserved.</p>
</footer>
</body>

</html>