<?php
// Pemeriksaan session di halaman admin
session_start();

// Jika session login tidak ada atau belum diset, redirect ke halaman login
if (!isset($_SESSION['admin_id'])) {
    $_SESSION['login_error'] = "Anda harus login terlebih dahulu.";
    header('Location: ../admin/login.php');
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Halaman Pencarian Produk</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Kontak</a>
                </li>
            </ul>
        </div>
        <a href="../backend/logout.php" class="btn btn-danger">Logout</a>
    </nav>

    <div class="container mt-5">
        <h1>Halaman Pencarian Produk</h1>
        <div class="input-group mb-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari...">
            <div class="input-group-append">
                <button class="btn btn-primary" onclick="search()">Cari</button>
            </div>
        </div>
        <div id="searchResults"></div>
    </div>

    <script>
        function search() {
            var searchQuery = document.getElementById("searchInput").value;
            var xmlhttp = new XMLHttpRequest();

            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var searchResults = JSON.parse(this.responseText);
                    displayResults(searchResults);
                }
            };

            xmlhttp.open("GET", "../backend/search.php?q=" + searchQuery, true);
            xmlhttp.send();
        }

        function displayResults(results) {
            var searchResultsDiv = document.getElementById("searchResults");
            searchResultsDiv.innerHTML = "";

            if (results.length === 0) {
                searchResultsDiv.innerHTML = "<p>Tidak ada hasil yang ditemukan.</p>";
                return;
            }

            var table = document.createElement("table");
            table.classList.add("table", "table-striped");

            var tableHeader = document.createElement("thead");
            var headerRow = document.createElement("tr");
            headerRow.innerHTML = "<th>ID</th><th>Nama Produk</th><th>ID Merek</th><th>Tahun Rilis</th><th>Harga</th>";
            tableHeader.appendChild(headerRow);
            table.appendChild(tableHeader);

            var tableBody = document.createElement("tbody");
            for (var i = 0; i < results.length; i++) {
                var result = results[i];
                var row = document.createElement("tr");
                row.innerHTML = "<td>" + result.id + "</td>"
                              + "<td>" + result.product_name + "</td>"
                              + "<td>" + result.brand_id + "</td>"
                              + "<td>" + result.release_year + "</td>"
                              + "<td>" + result.price + "</td>";
                tableBody.appendChild(row);
            }
            table.appendChild(tableBody);

            searchResultsDiv.appendChild(table);
        }

        // Pencarian saat halaman dimuat untuk pertama kali
        search();
    </script>
</body>
</html>
