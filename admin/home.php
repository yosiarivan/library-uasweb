<?php
require_once '../static/header.php';
?>

<div class="container mt-5">
    <p class="h1 text-center">PORTAL DATA LIBRARY UKRIDA</p>
    <div class="row">
        <?php
        // Cek peran pengguna
        if ($role_id === '2') {
            // Jika peran pengguna adalah 'author', tampilkan card-book dan card-artikel
            ?>
            <div class="col-sm">
                <!-- Card Book -->
                <div class="card text-center" style="width: 15rem;">
                    <div class="text-center mt-3">
                        <img class="rounded mx-auto d-block" src="../img/book.png" alt="icon" width="80px" height="80px">
                    </div>
                    <div class="card-body">
                        <h2 class="card-title">Book</h5>
                            <a href="./tb_book.php" class="btn btn-primary btn-lg btn-block">
                                Total Data : <span class="badge badge-light" id="bookTotalData"></span>
                            </a>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <!-- Card Artikel -->
                <div class="card text-center" style="width: 15rem;">
                    <div class="text-center mt-3">
                        <img class="rounded mx-auto d-block" src="../img/article.png" alt="icon" width="80px" height="80px">
                    </div>
                    <div class="card-body">
                        <h2 class="card-title">Artikel</h5>
                            <a href="./tb_article.php" class="btn btn-primary btn-lg btn-block">
                                Total Data : <span class="badge badge-light" id="articleTotalData"></span>
                            </a>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <!-- Card Admin -->
                <div class="card text-center" style="width: 15rem;">
                    <div class="text-center mt-3">
                        <img class="rounded mx-auto d-block" src="../img/admin.png" alt="icon" width="80px" height="80px">
                    </div>
                    <div class="card-body">
                        <h2 class="card-title">Admin</h5>
                            <a href="./tb_admin.php" class="btn btn-danger btn-lg btn-block">
                                Total Data : <span class="badge badge-light" id="adminTotalData"></span>
                            </a>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <!-- Card Help -->
                <div class="card text-center" style="width: 15rem;">
                    <div class="text-center mt-3">
                        <img class="rounded mx-auto d-block" src="../img/help.png" alt="icon" width="80px" height="80px">
                    </div>
                    <div class="card-body">
                        <h2 class="card-title">Help</h5>
                            <a href="./contact_us.php" class="btn btn-danger btn-lg btn-block">
                                Total Data : <span class="badge badge-light" id="contactTotalData"></span>
                            </a>
                    </div>
                </div>
            </div>
            <?php
        } else {
            // Jika peran pengguna bukan 'author', tampilkan semua card
            ?>
            <div class="col-sm">
                <!-- Card Admin -->
                <div class="card text-center" style="width: 15rem;">
                    <div class="text-center mt-3">
                        <img class="rounded mx-auto d-block" src="../img/admin.png" alt="icon" width="80px" height="80px">
                    </div>
                    <div class="card-body">
                        <h2 class="card-title">Admin</h5>
                            <a href="./tb_admin.php" class="btn btn-primary btn-lg btn-block">
                                Total Data : <span class="badge badge-light" id="adminTotalData"></span>
                            </a>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <!-- Card Book -->
                <div class="card text-center" style="width: 15rem;">
                    <div class="text-center mt-3">
                        <img class="rounded mx-auto d-block" src="../img/book.png" alt="icon" width="80px" height="80px">
                    </div>
                    <div class="card-body">
                        <h2 class="card-title">Book</h5>
                            <a href="./tb_book.php" class="btn btn-primary btn-lg btn-block">
                                Total Data : <span class="badge badge-light" id="bookTotalData"></span>
                            </a>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <!-- Card Artikel -->
                <div class="card text-center" style="width: 15rem;">
                    <div class="text-center mt-3">
                        <img class="rounded mx-auto d-block" src="../img/article.png" alt="icon" width="80px" height="80px">
                    </div>
                    <div class="card-body">
                        <h2 class="card-title">Artikel</h5>
                            <a href="./tb_article.php" class="btn btn-primary btn-lg btn-block">
                                Total Data : <span class="badge badge-light" id="articleTotalData"></span>
                            </a>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <!-- Card Help -->
                <div class="card text-center" style="width: 15rem;">
                    <div class="text-center mt-3">
                        <img class="rounded mx-auto d-block" src="../img/help.png" alt="icon" width="80px" height="80px">
                    </div>
                    <div class="card-body">
                        <h2 class="card-title">Help</h5>
                            <a href="./contact_us.php" class="btn btn-primary btn-lg btn-block">
                                Total Data : <span class="badge badge-light" id="contactTotalData"></span>
                            </a>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<script>
    $(document).ready(function () {
        $.ajax({
            url: '../backend/getTotaldata/adminTotal.php',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                $('#adminTotalData').text(response.total);
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    });
    $(document).ready(function () {
        $.ajax({
            url: '../backend/getTotaldata/bookTotal.php',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                $('#bookTotalData').text(response.total);
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    });
    $(document).ready(function () {
        $.ajax({
            url: '../backend/getTotaldata/articleTotal.php',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                $('#articleTotalData').text(response.total);
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    });
    $(document).ready(function () {
        $.ajax({
            url: '../backend/getTotaldata/contactTotal.php',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                $('#contactTotalData').text(response.total);
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    });

    $(document).ready(function () {
        <?php
        if (isset($_SESSION['access_error'])) {
            // Menampilkan pesan error menggunakan SweetAlert
            echo "Swal.fire({
                        icon: 'error',
                        title: 'Access Error',
                        text: '" . $_SESSION['access_error'] . "'
                    });";

            // Menghapus session 'access_error' setelah menampilkannya
            unset($_SESSION['access_error']);
        }
        ?>
    });
</script>
</body>

</html>