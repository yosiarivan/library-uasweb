<?php
require_once './static/index_header.php';
?>
<style>
  .jumbotron {
    background-color: #f8f9fa;
    padding: 4rem 2rem;
    margin-bottom: 2rem;
    border-radius: 0.5rem;
  }

  .lead {
    font-size: 1.5rem;
    color: #6c757d;
  }

  .info-container {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
  }

  .info-item {
    flex: 0 0 33.33%;
    text-align: center;
    font-size: 0.8rem;
    color: #6c757d;
  }

  .info-label {
    font-weight: bold;
    margin-bottom: 0.5rem;
  }
</style>

<section class="jumbotron text-center">
  <div class="container">
    <h1 class="display-4" id="title"></h1>
    <div class="info-container">
      <div class="info-item">
        <div class="info-label">Author</div>
        <div id="author"></div>
      </div>
      <div class="info-item">
        <div class="info-label">Publication Date</div>
        <div id="publicationDate"></div>
      </div>
      <div class="info-item">
        <div class="info-label">Edited Date</div>
        <div id="editedDate"></div>
      </div>
    </div>
  </div>
</section>

<section class="news-section">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <div class="article-image">
          <img id="image" class="img-fluid" alt="Article Image" style="max-width: 80%; height: auto;">
        </div>
      </div>
      <div class="col-md-6">
        <div class="article-content">
          <div id="content"></div>
        </div>
      </div>
    </div>
  </div>
</section>


<script>
  // Fungsi untuk mendapatkan nilai parameter dari URL berdasarkan nama parameternya
  function getURLParameter(name) {
    var urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name);
  }

  // Mendapatkan ID dari URL
  var articleID = getURLParameter('id');

  // Mengambil data artikel berdasarkan ID menggunakan AJAX
  $.ajax({
    url: './config/get_article.php?id=' + articleID,
    type: 'GET',
    dataType: 'json',
    success: function (response) {
      var article = response;

      // Menampilkan data artikel ke dalam elemen HTML
      $('#image').attr('src', './img/src/' + article.image);
      $('#title').html(article.title);
      $('#content').html(article.content);
      $('#author').html(article.author);
      $('#publicationDate').html(article.publication_date);
      $('#editedDate').html(article.edited_date);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      // Menampilkan pesan error jika terjadi kesalahan dalam permintaan AJAX
      console.log('Error: ' + textStatus + ' - ' + errorThrown);
    }
  });
</script>



<!-- Footer -->
<footer class="bg-dark text-white text-center py-4">
  <p>&copy; 2023 UKRIDA LIBRARY. All rights reserved.</p>
</footer>
</body>

</html>