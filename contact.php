<?php
require_once './static/index_header.php';
?>

<!-- Hero Section -->
<section class="jumbotron text-center">
  <div class="container">
    <h1 class="display-4">Contact</h1>
  </div>
</section>

<!-- Contact Section -->
<section class="container-fluid">
  <div class="row">
    <!-- Contact Information -->
    <div class="col-lg-6 mb-4">
      <div class="card">
        <div class="card-body">
          <h2 class="card-title text-center mb-4">Contact Information</h2>
          <div class="mb-3">
            <h5 class="card-subtitle">Alamat</h5>
            <p class="card-text">Jl. Tanjung Duren Raya no. 4, Jakarta Barat</p>
          </div>
          <div class="mb-3">
            <h5 class="card-subtitle">Email</h5>
            <p class="card-text">library@ukrida.ac.id</p>
          </div>
          <div class="mb-3">
            <h5 class="card-subtitle">Telepon</h5>
            <p class="card-text">+021 566 6952</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Contact Form -->
    <div class="col-lg-6 mb-4">
      <div class="card">
        <div class="card-body">
          <h2 class="card-title text-center mb-4">Contact Us</h2>
          <form>
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" id="name" placeholder="Enter your name">
            </div>
            <div class="form-group">
              <label for="email">Email address</label>
              <input type="email" class="form-control" id="email" placeholder="Enter your email">
            </div>
            <div class="form-group">
              <label for="message">Message</label>
              <textarea class="form-control" id="message" rows="5" placeholder="Enter your message"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  $(document).ready(function () {
    $('form').submit(function (event) {
      event.preventDefault();

      // Mengambil data dari formulir
      var name = $('#name').val();
      var email = $('#email').val();
      var message = $('#message').val();

      // Mengirim data melalui AJAX
      $.ajax({
        url: './backend/addContactUs.php', // Ganti dengan URL skrip PHP yang memproses data
        type: 'POST',
        dataType: 'json',
        data: {
          name: name,
          email: email,
          message: message
        },
        success: function (response) {
          // Menampilkan pesan respons menggunakan SweetAlert
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: response.message
          });

          // Menyetel ulang formulir
          $('form')[0].reset();
        },
        error: function (xhr, status, error) {
          console.log(xhr.responseText);
        }
      });
    });
  });
</script>



<!-- Footer -->
<footer class="bg-dark text-white text-center py-4">
  <p>&copy; 2023 UKRIDA LIBRARY. All rights reserved.</p>
</footer>
</body>

</html>