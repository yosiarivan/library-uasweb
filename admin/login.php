<?php
session_start();

if (isset($_SESSION['admin_id'])) {
    // Pengguna sudah login, arahkan ke halaman home.php
    header("Location: home.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login & Register Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>

    <style>
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding-top: 100px;
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="../index.php">UKRIDA LIBRARY</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div id="loginForm" class="card">
                    <h2 class="card-header text-center">Login</h2>
                    <div class="card-body">
                        <form id="loginForm" onsubmit="login(event)">
                            <div class="form-group">
                                <label for="loginEmail">Email</label>
                                <input type="email" class="form-control" id="loginEmail" name="email"
                                    placeholder="Enter email" required>
                            </div>
                            <div class="form-group">
                                <label for="loginPassword">Password</label>
                                <input type="password" class="form-control" id="loginPassword" name="password"
                                    placeholder="Enter password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>
                        <p class="text-center mt-3">Don't have an account? <a href="#"
                                onclick="showRegisterForm()">Register</a></p>
                    </div>
                </div>

                <div id="registerForm" class="card" style="display: none;">
                    <h2 class="card-header text-center">Register</h2>
                    <div class="card-body">
                        <form id="registerForm">
                            <div class="form-group">
                                <label for="registerName">Name</label>
                                <input type="text" class="form-control" id="registerName" name="name"
                                    placeholder="Enter name" required>
                            </div>
                            <div class="form-group">
                                <label for="registerEmail">Email</label>
                                <input type="email" class="form-control" id="registerEmail" name="email"
                                    placeholder="Enter email" required>
                            </div>
                            <div class="form-group">
                                <label for="registerPassword">Password</label>
                                <input type="password" class="form-control" id="registerPassword" name="password"
                                    placeholder="Enter password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </form>
                        <p class="text-center mt-3">Already have an account? <a href="#"
                                onclick="showLoginForm()">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        <?php
        // Periksa apakah ada pesan error yang diset
        if (isset($_SESSION['login_error'])) {
            $error_message = $_SESSION['login_error'];
            unset($_SESSION['login_error']);

            // Tampilkan pesan error menggunakan SweetAlert
            echo "Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '$error_message',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });";
        }
        ?>
        function showRegisterForm() {
            document.getElementById("loginForm").style.display = "none";
            document.getElementById("registerForm").style.display = "block";
        }

        function showLoginForm() {
            document.getElementById("registerForm").style.display = "none";
            document.getElementById("loginForm").style.display = "block";
        }

        function login(event) {
            event.preventDefault(); // Prevent form submission

            // Mendapatkan nilai input email dan password
            var email = $("#loginEmail").val();
            var password = $("#loginPassword").val();

            // Mengirim permintaan AJAX ke server
            $.ajax({
                url: "../backend/login.php",
                type: "POST",
                data: {
                    email: email,
                    password: password
                },
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        // Login berhasil
                        // Lakukan sesuatu dengan respons dari server
                        console.log(response.message);
                        // Redirect to the desired page if necessary
                        window.location.href = "home.php";
                    } else {
                        // Login gagal
                        // Tampilkan pesan kesalahan menggunakan SweetAlert2
                        Swal.fire({
                            icon: 'error',
                            title: 'Login Error',
                            text: response.message
                        });
                    }
                },
                error: function () {
                    // Permintaan gagal
                    console.log("Terjadi kesalahan saat melakukan login.");
                }
            });
        }



        // Fungsi untuk melakukan registrasi menggunakan AJAX
        $(document).on('submit', '#registerForm', function (e) {
            e.preventDefault(); // Mencegah form melakukan submit default

            // Mengambil data dari form
            var registerForm = $(this);
            var formData = registerForm.serialize();

            // Mengirim data ke server menggunakan AJAX
            $.ajax({
                url: '../backend/register.php', // Ubah URL sesuai dengan lokasi file PHP untuk registrasi
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        // Registrasi berhasil, tampilkan pesan sukses menggunakan SweetAlert2
                        Swal.fire({
                            icon: 'success',
                            title: 'Registration Successful',
                            text: 'Congratulations! Your registration was successful.'
                        });
                        // Hide the register form and show the login form
                        $("#registerForm").hide();
                        $("#loginForm").show();
                    } else {
                        // Registrasi gagal, tampilkan pesan error menggunakan SweetAlert2
                        Swal.fire({
                            icon: 'error',
                            title: 'Registration Error',
                            text: response.message
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.log('Error: ' + error);
                }
            });
        });
    </script>
</body>

</html>