<?php
require_once '../static/header.php';
?>
<div class="container mt-5">
    <a class="btn btn-danger" href="./home.php">Back</a>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addDataModal">
        Tambah Data
    </button>
    <h1>Tabel Data Buku</h1>
    <div class="input-group mb-3">
        <input type="text" id="searchInput" class="form-control " placeholder="Cari ID BOOK atau TITLE">
        <div class="input-group-append">
            <button class="btn btn-primary" onclick="search()">Cari</button>
        </div>
    </div>
    <div id="searchResults"></div>
</div>

<!-- Modal Add Data-->
<div id="addDataModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Data</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="addDataForm" method="POST" action="../backend/addBook.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="image">Gambar:</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="title">Judul:</label>
                        <input type="text" class="form-control" id="title" name="title">
                    </div>
                    <div class="form-group">
                        <label for="author">Penulis:</label>
                        <input type="text" class="form-control" id="author" name="author">
                    </div>
                    <div class="form-group">
                        <label for="genre">Genre:</label>
                        <select class="form-control" id="genre" name="genre">
                            <option value="">Pilih Genre</option>
                            <option value="Fiksi">Fiksi</option>
                            <option value="Non-Fiksi">Non-Fiksi</option>
                            <option value="Drama">Drama</option>
                            <option value="Romance">Romance</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="year">Tahun:</label>
                        <input type="text" class="form-control" id="year" name="year">
                    </div>
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select class="form-control" id="status" name="status">
                            <option value="Available">Tersedia</option>
                            <option value="Unavailable">Tidak Tersedia</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form Edit -->
                <form id="editDataForm" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="editBookId">
                    <div class="form-group">
                        <label for="editImage">Gambar:</label>
                        <input type="file" class="form-control" id="editImage" name="img" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="editTitle">Judul:</label>
                        <input type="text" class="form-control" id="editTitle" name="title">
                    </div>
                    <div class="form-group">
                        <label for="editAuthor">Penulis:</label>
                        <input type="text" class="form-control" id="editAuthor" name="author">
                    </div>
                    <div class="form-group">
                        <label for="editGenre">Genre:</label>
                        <input type="text" class="form-control" id="editGenre" name="genre">
                    </div>
                    <div class="form-group">
                        <label for="editYear">Tahun:</label>
                        <input type="text" class="form-control" id="editYear" name="year">
                    </div>
                    <div class="form-group">
                        <label for="editStatus">Status:</label>
                        <select class="form-control" id="editStatus" name="status">
                            <option value="Available">Available</option>
                            <option value="Unavailable">Unavailable</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>

            </div>

        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Data Buku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this data?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
    function search() {
        var searchQuery = document.getElementById("searchInput").value;
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var searchResults = JSON.parse(this.responseText);
                displayResults(searchResults);
            }
        };

        xmlhttp.open("GET", "../backend/searchBook.php?q=" + searchQuery, true);
        xmlhttp.send();
    }

    function displayResults(results) {
        var searchResultsDiv = $("#searchResults");
        searchResultsDiv.empty();

        if (results.length === 0) {
            searchResultsDiv.html("<p>Tidak ada hasil yang ditemukan.</p>");
            return;
        }

        var table = $("<table>").addClass("table table-striped");

        var tableHeader = $("<thead>");
        var headerRow = $("<tr>").html("<th>ID</th><th>Gambar</th><th>Title</th><th>Author</th><th>Genre</th><th>Year</th><th>Status</th>");
        tableHeader.append(headerRow);
        table.append(tableHeader);

        var tableBody = $("<tbody>");
        for (var i = 0; i < results.length; i++) {
            var result = results[i];
            var imagePath = "../img/src/" + result.img;

            // Membuat variabel untuk menampung kelas CSS
            var statusClass = result.status === "Available" ? "bg-success text-white" : "bg-danger text-white";
            var statusText = result.status === "Available" ? "Available" : "Unavailable";

            // Membuat elemen <span> dengan kelas CSS berdasarkan nilai status
            var statusSpan = $("<span>").addClass("p-1 rounded").addClass(statusClass).text(statusText);

            var row = $("<tr>").html(
                "<td>" + result.id + "</td>" +
                "<td><img src='" + imagePath + "' alt='Book Image' width='100' height='100'></td>" +
                "<td>" + result.title + "</td>" +
                "<td>" + result.author + "</td>" +
                "<td>" + result.genre + "</td>" +
                "<td>" + result.year + "</td>" +
                "<td>" + statusSpan.prop('outerHTML') + "</td>" + // Menambahkan statusSpan ke dalam sel
                "<td>" +
                "<button class='btn btn-primary btn-edit' data-id='" + result.id + "'><i class='bi bi-pencil'></i></button> " +
                "<button class='btn btn-danger btn-delete' data-id='" + result.id + "'><i class='bi bi-trash'></i></button>" +
                "</td>"
            );
            tableBody.append(row);
        }
        table.append(tableBody);

        searchResultsDiv.append(table);


        // Menambahkan event listener untuk tombol delete
        $(".btn-delete").click(function () {
            var id = $(this).data("id");
            deleteData(id);
        });
    }

    // Membuat kolom pencarian otomatis
    function filterGenres() {
        var input, filter, select, options, i;
        input = document.getElementById('genre');
        filter = input.value.toUpperCase();
        select = document.getElementById('genre');
        options = select.getElementsByTagName('option');

        for (i = 0; i < options.length; i++) {
            if (options[i].text.toUpperCase().indexOf(filter) > -1) {
                options[i].style.display = '';
            } else {
                options[i].style.display = 'none';
            }
        }
    }

    $(document).ready(function () {
        // Submit form using AJAX
        $('#addDataForm').submit(function (event) {
            event.preventDefault(); // Prevent default form submission

            // Mengumpulkan data dari formulir
            var formData = new FormData(this);

            // Mengirim data ke server menggunakan AJAX
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    // Menangani respons dari server
                    // Menampilkan pesan sukses menggunakan SweetAlert
                    Swal.fire({
                        icon: 'success',
                        title: 'Data buku berhasil ditambah',
                    }).then((result) => {
                        // Memuat ulang halaman untuk memperbarui data admin
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Menangani kesalahan saat pengiriman data ke server
                    alert('Error: ' + textStatus + ' - ' + errorThrown);
                }
            });
        });
    });

    // Fungsi Editnya
    $(document).ready(function () {
        // Fungsi untuk mengisi form edit dengan data admin yang dipilih
        function fillEditForm(bookId) {
            // Mengirim permintaan AJAX untuk mendapatkan data buku berdasarkan ID
            $.ajax({
                url: '../backend/getBookID.php',
                type: 'POST',
                data: {
                    id: bookId
                },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        // Mengisi form edit dengan data buku yang diterima dari server
                        $('#editBookId').val(response.book.id);
                        $('#editTitle').val(response.book.title);
                        $('#editAuthor').val(response.book.author);
                        $('#editGenre').val(response.book.genre);
                        $('#editYear').val(response.book.year);
                        $('#editStatus').val(response.book.status);
                    } else {
                        // Menampilkan pesan error jika terjadi kesalahan dalam mengambil data buku
                        alert('Terjadi kesalahan saat mengambil data buku');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Menampilkan pesan error jika terjadi kesalahan dalam permintaan AJAX
                    alert('Error: ' + textStatus + ' - ' + errorThrown);
                }
            });
        }

        // Menampilkan form edit saat tombol Edit di klik
        $(document).on('click', '.btn-edit', function () {
            var bookId = $(this).data('id');
            fillEditForm(bookId);
            $('#editModal').modal('show');
        });

        // Submit form edit menggunakan AJAX
        $('#editDataForm').submit(function (event) {
            event.preventDefault(); // Mencegah form dikirim secara default

            // Mengumpulkan data dari form edit
            var formData = new FormData(this);

            // Mengirim data ke server menggunakan AJAX
            $.ajax({
                url: '../backend/editBook.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                processData: false, // Menghindari pengolahan data FormData oleh jQuery
                contentType: false, // Menghindari pengaturan tipe konten oleh jQuery
                success: function (response) {
                    if (response.status === 'success') {
                        // Menampilkan pesan sukses menggunakan SweetAlert
                        Swal.fire({
                            icon: 'success',
                            title: 'Data buku berhasil diubah',
                        }).then((result) => {
                            // Memuat ulang halaman untuk memperbarui data admin
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    } else {
                        // Menampilkan pesan error jika terjadi kesalahan dalam mengubah data buku
                        alert('Terjadi kesalahan saat mengubah data buku');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Menampilkan pesan error jika terjadi kesalahan dalam permintaan AJAX
                    alert('Error: ' + textStatus + ' - ' + errorThrown);
                }
            });
        });
    });

    function deleteData(id) {
        // Tampilkan modal delete
        $('#deleteModal').modal('show');

        // Tambahkan event listener pada tombol delete di modal
        $('#confirmDeleteBtn').off('click').on('click', function () {
            // Lakukan permintaan delete setelah tombol delete di modal diklik
            $.ajax({
                url: '../backend/deleteBook.php',
                type: 'POST',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        // Menampilkan pesan sukses menggunakan SweetAlert
                        Swal.fire({
                            icon: 'success',
                            title: 'Data buku berhasil dihapus',
                        }).then((result) => {
                            // Memuat ulang halaman untuk memperbarui data admin
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    } else {
                        // Jika penghapusan gagal, tampilkan pesan error
                        alert(response.message);
                    }
                },
                error: function () {
                    // Jika terjadi kesalahan pada permintaan Ajax, tampilkan pesan error
                    alert('Terjadi kesalahan pada permintaan Ajax');
                }
            });

            // Sembunyikan modal delete setelah tombol delete diklik
            $('#deleteModal').modal('hide');
        });
    }



    // Pencarian saat halaman dimuat untuk pertama kali
    search();
</script>
</body>

</html>