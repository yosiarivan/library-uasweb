<?php require_once './static/index_header.php'; ?>

<style>
  .clickable-card {
    cursor: pointer;
  }
</style>

<!-- Hero Section -->
<section class="jumbotron text-center">
  <div class="container">
    <h1 class="display-4">Book Collection</h1>
  </div>
</section>

<div class="container mt-4">
  <div class="form-group">
    <input type="text" class="form-control" id="searchInput" placeholder="Search">
  </div>
  <div id="bookList" class="row"></div>
</div>

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
    var searchInput = $("#searchInput");

    searchInput.on("input", function () {
      search();
    });

    search(); // Memanggil fungsi pencarian saat halaman dibuka

    function search() {
      var searchQuery = searchInput.val();
      var xmlhttp = new XMLHttpRequest();

      xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          var searchResults = JSON.parse(this.responseText);
          displayResults(searchResults);
        }
      };

      xmlhttp.open("GET", "./backend/searchBook.php?q=" + searchQuery, true);
      xmlhttp.send();
    }

    function displayResults(results) {
      var bookList = $("#bookList");
      bookList.empty();

      if (results.length === 0) {
        bookList.html("<p>No books found.</p>");
        return;
      }

      for (var i = 0; i < results.length; i++) {
        var result = results[i];
        var imagePath = "./img/src/" + result.img;

        var card = $("<div>")
          .addClass("col-lg-2 col-md-6 mb-4 clickable-card")
          .attr("data-book-id", result.id)
          .click(function () {
            var bookId = $(this).data("book-id");
            showBookModal(bookId);
          });

        var cardContent = $("<div>").addClass("card w-100 h-90 d-flex flex-column");
        var img = $("<img>")
          .addClass("card-img-top object-fit img-fluid")
          .attr("src", imagePath)
          .attr("alt", "Book Image")
          .css("width", "100%")
          .css("height", "auto");
        var cardBody = $("<div>").addClass("card-body");
        var title = $("<h5>").addClass("card-title").text(result.title);

        cardBody.append(title);
        cardContent.append(img, cardBody);
        card.append(cardContent);
        bookList.append(card);
      }
    }
  });

  function showBookModal(bookId) {
    $.ajax({
      url: './backend/getBookID.php',
      method: 'POST',
      data: {
        id: bookId
      },
      dataType: 'json', // Menentukan tipe data yang diharapkan dari respons server
      success: function (response) {
        if (response.status === 'success') {
          var book = response.book; // Inisialisasi variabel book dengan nilai dari response.book

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
        } else {
          console.log('Error: ' + response.message);
        }
      },
      error: function (xhr, status, error) {
        console.log('AJAX Error: ' + error);
      }
    });
  }



</script>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-4">
  <p>&copy; 2023 UKRIDA LIBRARY. All rights reserved.</p>
</footer>
</body>

</html>