<?php
require_once '../static/header.php';
?>
<style>
    /* Gaya untuk gambar yang diperbesar */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .modal-content img {
        max-width: 90%;
        max-height: 90%;
    }

    /* Gaya tambahan untuk membuat tampilan lebih menarik */
    .list-group-item {
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .list-group-item:hover {
        transform: scale(1.1);
    }

    .list-group-item img {
        border-radius: 5px;
    }
</style>

<body>
    <div class="container">
        <h1>Daftar Gambar</h1>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
            Tambah Gambar
        </button>

        <div id="galleryList">
            <!-- Data gambar akan dimuat di sini -->
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data gambar akan dimuat di sini -->
                </tbody>
            </table>
        </div>

        <!-- Modal Tambah Data -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Tambah Gambar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="addForm" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="title">Judul Gambar</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="form-group">
                                <label for="imageFile">File Gambar</label>
                                <input type="file" class="form-control-file" id="imageFile" name="imageFile" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                // Mengirim data ke server menggunakan AJAX
                $('#addForm').submit(function (e) {
                    e.preventDefault(); // Menghentikan aksi submit form

                    var formData = new FormData(this); // Mengambil data form

                    $.ajax({
                        type: 'POST',
                        url: '../backend/addGallery.php',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            alert('Data berhasil ditambahkan');
                            $('#addModal').modal('hide'); // Menutup modal
                        },
                        error: function (xhr, status, error) {
                            alert('Terjadi kesalahan: ' + error);
                        }
                    });
                });
            });

            $(document).ready(function () {
                // Fungsi untuk memuat data gambar
                function loadGallery() {
                    $.ajax({
                        url: '../backend/getGallery.php',
                        type: 'GET',
                        dataType: 'json',
                        success: function (response) {
                            if (response.status === 'success') {
                                var galleryTable = '<table class="table">';
                                galleryTable += '<thead>';
                                galleryTable += '<tr>';
                                galleryTable += '<th>Image</th>';
                                galleryTable += '<th>Title</th>';
                                galleryTable += '<th>Action</th>';
                                galleryTable += '</tr>';
                                galleryTable += '</thead>';
                                galleryTable += '<tbody>';

                                var galleryData = response.data;
                                galleryData.forEach(function (item) {
                                    galleryTable += '<tr>';
                                    galleryTable += '<td><img src="../img/src/' + item.image_url + '" alt="' + item.title + '" class="img-fluid" style="width: 250px; height: 250px;"></td>';
                                    galleryTable += '<td>' + item.title + '</td>';
                                    galleryTable += '<td><button class="btn btn-danger btn-delete" data-id="' + item.id + '">Hapus</button></td>';
                                    galleryTable += '</tr>';
                                });

                                galleryTable += '</tbody>';
                                galleryTable += '</table>';

                                // Menambahkan tabel ke dalam elemen dengan id "galleryList"
                                $('#galleryList').html(galleryTable);

                                // Menambahkan event click pada tombol hapus
                                $('.btn-delete').on('click', function () {
                                    var imageId = $(this).data('id');
                                    deleteImage(imageId);
                                });
                            } else {
                                console.log('Terjadi kesalahan: ' + response.message);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log('Terjadi kesalahan saat memuat data: ' + error);
                        }
                    });
                }

                // Panggil fungsi untuk memuat data gambar
                loadGallery();

                // Fungsi untuk menghapus data gambar
                function deleteImage(imageId) {
                    $.ajax({
                        url: '../backend/deleteGallery.php',
                        type: 'POST',
                        dataType: 'json',
                        data: { id: imageId },
                        success: function (response) {
                            if (response.status === 'success') {
                                // Memuat ulang data gambar setelah berhasil menghapus
                                loadGallery();

                                // Menampilkan SweetAlert berhasil
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sukses',
                                    text: response.message
                                });
                            } else {
                                // Menampilkan SweetAlert error
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log('Terjadi kesalahan saat menghapus data: ' + error);
                        }
                    });
                }
            });

            $(document).ready(function () {
                // Fungsi untuk membuka gambar secara lebar
                function openImage(imageUrl) {
                    // Buat elemen <img> baru
                    var img = $('<img>').attr('src', imageUrl).addClass('img-fluid');

                    // Buat elemen <div> sebagai kontainer gambar
                    var modalContent = $('<div>').addClass('modal-content').append(img);

                    // Buat elemen <div> sebagai modal
                    var modalDialog = $('<div>').addClass('modal-dialog modal-dialog-centered').append(modalContent);

                    // Buat elemen <div> sebagai overlay
                    var modalOverlay = $('<div>').addClass('modal-overlay').append(modalDialog);

                    // Tambahkan elemen overlay ke dalam body
                    $('body').append(modalOverlay);

                    // Tampilkan overlay dengan animasi fade in
                    modalOverlay.fadeIn();

                    // Klik overlay untuk menutup gambar
                    modalOverlay.on('click', function () {
                        modalOverlay.fadeOut(function () {
                            // Hapus elemen overlay setelah gambar ditutup
                            modalOverlay.remove();
                        });
                    });
                }

                // Event click pada gambar
                $(document).on('click', '#galleryList img', function () {
                    var imageUrl = $(this).attr('src');
                    openImage(imageUrl);
                });
            });

        </script>
</body>