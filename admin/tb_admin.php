<?php
require_once '../static/header.php';
?>

<div class="container">
    <a class="btn btn-danger" href="./home.php">Back</a>
    <h1 class="my-4">Tabel Data Admin</h1>
    <div class="gray-box">
        <div class="input-group mb-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari NAMA atau NOMOR KARYAWAN">
            <div class="input-group-append">
                <button class="btn btn-primary" onclick="search()">Cari</button>
            </div>
        </div>
        <div id="searchResults"></div>
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
                <form id="editForm" method="POST">
                    <input type="hidden" name="id" id="editAdminId">
                    <div class="form-group">
                        <label for="editNoKaryawan">No. Karyawan</label>
                        <input type="text" class="form-control" id="editNoKaryawan" name="no_karyawan" required>
                    </div>
                    <div class="form-group">
                        <label for="editName">Nama Admin</label>
                        <input type="text" class="form-control" id="editName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="editEmail">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="editRole">Role</label>
                        <select class="form-control" id="editRole" name="role" required>
                            <option value="1">Admin</option>
                            <option value="2">Author</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
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
                <h5 class="modal-title" id="deleteModalLabel">Delete Data Admin</h5>
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
            if (this.readyState == 3 && this.status == 200) {
                var searchResults = JSON.parse(this.responseText);
                displayResults(searchResults);
            }
        };

        xmlhttp.open("GET", "../backend/searchAdmin.php?q=" + searchQuery, true);
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
        var headerRow = $("<tr>").html("<th>ID</th><th>No. Karyawan</th><th>Nama Admin</th><th>Email</th><th>Role</th><th>Last Access</th><th>Action</th>");
        tableHeader.append(headerRow);
        table.append(tableHeader);

        var tableBody = $("<tbody>");
        for (var i = 0; i < results.length; i++) {
            var result = results[i];
            var roleText = result.role_id === '1' ? 'Admin' : result.role_id === '2' ? 'Author' : 'Unrole';
            var lastAccess = result.access_at; // Ubah last_access sesuai dengan nama kolom yang menyimpan informasi waktu terakhir diakses

            // Mengubah format waktu terakhir diakses
            var lastAccessTime = new Date(lastAccess);
            var formattedLastAccess = lastAccessTime.toLocaleString(); // Menggunakan metode toLocaleString() untuk mengubah format waktu
            var row = $("<tr>").html(
                "<td>" + result.id + "</td>" +
                "<td>" + result.no_karyawan + "</td>" +
                "<td>" + result.name + "</td>" +
                "<td>" + result.email + "</td>" +
                "<td>" + roleText + "</td>" + // Gunakan teks role yang sesuai
                "<td>" + formattedLastAccess + "</td>" + // Menggunakan formattedLastAccess sebagai waktu terakhir diakses dengan format yang telah diubah
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

    // Fungsi Editnya
    $(document).ready(function () {
        // Fungsi untuk mengisi form edit dengan data admin yang dipilih
        function fillEditForm(adminId) {
            // Mengirim permintaan AJAX untuk mendapatkan data admin berdasarkan ID
            $.ajax({
                url: '../backend/getAdmin.php',
                type: 'POST',
                data: { id: adminId },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        // Mengisi form edit dengan data admin yang diterima dari server
                        $('#editAdminId').val(response.admin.id);
                        $('#editNoKaryawan').val(response.admin.no_karyawan);
                        $('#editName').val(response.admin.name);
                        $('#editEmail').val(response.admin.email);
                        $('#editRole').val(response.admin.role_id);
                    } else {
                        // Menampilkan pesan error jika terjadi kesalahan dalam mengambil data admin
                        alert('Terjadi kesalahan saat mengambil data admin');
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
            var adminId = $(this).data('id');
            fillEditForm(adminId);
            $('#editModal').modal('show');
        });

        // Submit form edit menggunakan AJAX
        $('#editForm').submit(function (event) {
            event.preventDefault(); // Mencegah form dikirim secara default

            // Mengumpulkan data dari form edit
            var formData = $(this).serialize();

            // Mengirim data ke server menggunakan AJAX
            $.ajax({
                url: '../backend/editAdmin.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        // Menampilkan pesan sukses menggunakan SweetAlert
                        Swal.fire({
                            icon: 'success',
                            title: 'Data admin berhasil diubah',
                        }).then((result) => {
                            // Memuat ulang halaman untuk memperbarui data admin
                            if (result.isConfirmed) {
                                search();
                            }
                        });
                        // Menutup modal edit menggunakan SweetAlert
                        $('#editModal').modal('hide');
                    } else {
                        // Menampilkan pesan error jika terjadi kesalahan dalam mengubah data admin
                        alert('Terjadi kesalahan saat mengubah data admin');
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
                url: '../backend/deleteAdmin.php',
                type: 'POST',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        // Menampilkan pesan sukses menggunakan SweetAlert
                        Swal.fire({
                            icon: 'success',
                            title: 'Data admin berhasil dihapus',
                        }).then((result) => {
                            // Memuat ulang halaman untuk memperbarui data admin
                            if (result.isConfirmed) {
                                search();
                            }
                        });
                        // Menutup modal edit menggunakan SweetAlert
                        $('#editModal').modal('hide');
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