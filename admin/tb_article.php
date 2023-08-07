<?php
require_once '../static/header.php';
?>
<div class="container">
    <a class="btn btn-danger" href="./home.php">Back</a>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addArticleModal">Tambah
        Artikel</button>
    <h1>Tabel Data Artikel</h1>
    <div class="input-group mb-3">
        <input type="text" id="searchInput" class="form-control " placeholder="Cari ID BOOK atau TITLE">
        <div class="input-group-append">
            <button class="btn btn-primary" onclick="search()">Cari</button>
        </div>
    </div>
    <div id="searchResults"></div>
</div>

<!-- Modal add-->
<div id="addArticleModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addArticleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addArticleModalLabel">Tambah Berita Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addArticleForm" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="author">Penulis</label>
                        <input type="text" class="form-control" id="author" name="author"
                            value="<?php echo $_SESSION['admin_name']; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="image">Gambar</label>
                        <input type="file" class="form-control-file" id="image" name="image" required>
                    </div>
                    <div class="form-group">
                        <label for="title">Judul</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="content">Konten</label>
                        <textarea class="form-control" id="content" name="content" rows="6"
                            style="height: 400px;"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="addArticleBtn">Simpan</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Edit-->
<div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Berita</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editDataForm" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="editArticleId">
                    <div class="form-group">
                        <label for="editAuthor">Penulis</label>
                        <input type="text" class="form-control" id="editAuthor" name="author" readonly>
                    </div>
                    <div class="form-group">
                        <label for="editImage">Gambar</label>
                        <input type="file" class="form-control-file" id="editImage" name="image">
                    </div>
                    <div class="form-group">
                        <label for="editTitle">Judul</label>
                        <input type="text" class="form-control" id="editTitle" name="title">
                    </div>
                    <div class="form-group">
                        <label for="editContent">Konten</label>
                        <textarea class="form-control" id="editContent" name="content" rows="6"
                            style="height: 400px;"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" id="saveButton">Simpan</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Modal View Article -->
<div class="modal fade" id="viewArticleModal" tabindex="-1" role="dialog" aria-labelledby="viewArticleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewArticleModalLabel">View Article</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="viewImage">Gambar</label>
                    <img id="viewImage" class="img-fluid" src="../img/src/" alt="Article Image"
                        style="max-width: 200px; max-height: 200px;">
                </div>
                <div class="form-group">
                    <label for="contentTitle">Judul</label>
                    <div id="contentTitle"></div>
                </div>
                <div class="form-group">
                    <label for="contentPublicationDate">Tanggal Publikasi</label>
                    <div id="contentPublicationDate"></div>
                </div>
                <div class="form-group">
                    <label for="contentContent">Konten</label>
                    <div id="contentContent"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
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

        xmlhttp.open("GET", "../backend/searchArticle.php?q=" + searchQuery, true);
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
        var headerRow = $("<tr>").html("<th>ID</th><th>Gambar</th><th>Title</th><th>Author</th><th>Content</th><th>Tgl. Publish</th><th>Tgl. Edit</th><th>Action</th>");
        tableHeader.append(headerRow);
        table.append(tableHeader);

        var tableBody = $("<tbody>");
        for (var i = 0; i < results.length; i++) {
            var result = results[i];
            var imagePath = "../img/src/" + result.image;

            var row = $("<tr>").html(
                "<td>" + result.id + "</td>" +
                "<td><img src='" + imagePath + "' alt='Article Image' width='100' height='100'></td>" +
                "<td>" + result.title + "</td>" +
                "<td>" + result.author + "</td>" +
                "<td>" +
                "<button class='btn btn-primary btn-content' data-id='" + result.id + "'><i class='bi bi-eye-fill'></i></button> " +
                "</td>" +
                "<td>" + result.publication_date + "</td>" +
                "<td>" + result.edited_date + "</td>" +
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

    $(document).ready(function () {
        // Menangani klik tombol "Simpan" pada modal
        $("#addArticleBtn").click(function () {
            var formData = new FormData($("#addArticleForm")[0]);
            $.ajax({
                url: "../backend/addArticle.php",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    alert(response);
                    $("#addArticleModal").modal("hide");
                    // Tambahkan kode untuk melakukan tindakan setelah berhasil menambahkan data
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                    alert("Terjadi kesalahan: " + xhr.responseText);
                }
            });
        });
    });


    // Fungsi Editnya
    $(document).ready(function () {
        // Fungsi untuk mengisi form edit dengan data admin yang dipilih
        function fillEditForm(articleId) {
            // Mengirim permintaan AJAX untuk mendapatkan data buku berdasarkan ID
            $.ajax({
                url: '../backend/getArticleID.php',
                type: 'POST',
                data: {
                    id: articleId
                },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        // Mengisi form edit dengan data buku yang diterima dari server
                        $('#editArticleId').val(response.article.id);
                        $('#editAuthor').val(response.article.author);
                        $('#editTitle').val(response.article.title);
                        $('#editContent').val(response.article.content);

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
        // Fungsi untuk mengisi modal view dengan data artikel yang dipilih
        function fillViewForm(articleId) {
            // Mengirim permintaan AJAX untuk mendapatkan data artikel berdasarkan ID
            $.ajax({
                url: '../backend/getArticleID.php',
                type: 'POST',
                data: {
                    id: articleId
                },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        // Mengisi modal view dengan data artikel yang diterima dari server
                        $('#viewImage').attr('src', '../img/src/' + response.article.image);
                        $('#contentTitle').text(response.article.title);
                        $('#contentContent').text(response.article.content);
                        $('#contentPublicationDate').text(response.article.publication_date);

                    } else {
                        // Menampilkan pesan error jika terjadi kesalahan dalam mengambil data artikel
                        alert('Terjadi kesalahan saat mengambil data artikel');
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
            var articleId = $(this).data('id');
            fillEditForm(articleId);
            $('#editModal').modal('show');
        });

        $(document).on('click', '.btn-content', function () {
            var articleId = $(this).data('id');
            fillViewForm(articleId);
            $('#viewArticleModal').modal('show');
        });

        // Submit form edit menggunakan AJAX
        $('#editDataForm').submit(function (event) {
            event.preventDefault(); // Mencegah form dikirim secara default

            // Mengumpulkan data dari form edit
            var formData = new FormData(this);

            // Mengirim data ke server menggunakan AJAX
            $.ajax({
                url: '../backend/editArticle.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.status === 'success') {
                        // Menampilkan pesan sukses menggunakan Sweet Alert
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: 'Data buku berhasil diubah',
                        }).then(function () {
                            // Menutup modal edit
                            $('#editModal').modal('hide');
                            // Refresh halaman atau lakukan tindakan lain yang diperlukan
                            location.reload();
                        });
                    } else {
                        // Menampilkan pesan error jika terjadi kesalahan dalam mengubah data buku
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat mengubah data buku',
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Menampilkan pesan error jika terjadi kesalahan dalam permintaan AJAX
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error: ' + textStatus + ' - ' + errorThrown,
                    });
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
                url: '../backend/deleteArticle.php',
                type: 'POST',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        // Jika penghapusan berhasil, tampilkan pesan sukses dan lakukan tindakan tambahan
                        Swal.fire({
                            title: 'Sukses',
                            text: response.message,
                            icon: 'success',
                        }).then(function () {
                            // Misalnya, reload halaman atau perbarui tampilan data admin
                            location.reload();
                        });
                    } else {
                        // Jika penghapusan gagal, tampilkan pesan error
                        Swal.fire({
                            title: 'Error',
                            text: response.message,
                            icon: 'error',
                        });
                    }
                },
                error: function () {
                    // Jika terjadi kesalahan pada permintaan Ajax, tampilkan pesan error
                    Swal.fire('Error', 'Terjadi kesalahan pada permintaan Ajax', 'error');
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

<!--Dalam kode di atas, telah ditambahkan modal untuk fitur edit data dan juga modal untuk fitur delete data. Terdapat juga form edit dengan input fields yang sesuai untuk mengedit data admin. Fungsi `editData` telah diperbarui untuk mengambil data admin dengan ID tertentu melalui Ajax, kemudian memanggil fungsi `fillEditForm` untuk mengisi form edit dengan data admin yang diperoleh. Fungsi `fillEditForm` akan menampilkan modal edit setelah mengisi form. Fungsi `deleteData` masih menggunakan implementasi yang sama, yaitu menampilkan modal delete saat dipanggil.

Pastikan Anda juga memiliki backend yang sesuai untuk