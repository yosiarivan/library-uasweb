<?php
require_once '../static/header.php';
?>

<div class="container">
    <h2 class="my-4">Contact Us Message</h2>
    <table id="contactTable" class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data kontak akan ditambahkan secara dinamis melalui JavaScript -->
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function () {
        // Fungsi untuk memuat data kontak
        function loadContactData() {
            $.ajax({
                url: '../backend/getContact.php', // Ganti dengan URL skrip PHP yang mengambil data
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    // Memanggil fungsi untuk membangun tabel
                    buildContactTable(response);
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        }

        // Fungsi untuk membangun tabel kontak
        function buildContactTable(data) {
            var tableBody = $('#contactTable tbody');
            tableBody.empty();

            if (data.length === 0) {
                tableBody.append('<tr><td colspan="4" class="text-center">No contact data found</td></tr>');
            } else {
                $.each(data, function (index, contact) {
                    var row = $('<tr></tr>');
                    row.append('<td>' + contact.name + '</td>');
                    row.append('<td>' + contact.email + '</td>');
                    row.append('<td>' + contact.message + '</td>');

                    var actionColumn = $('<td></td>');
                    var deleteButton = $('<button class="btn btn-danger btn-sm">Delete</button>');
                    deleteButton.click(function () {
                        deleteContact(contact.id); // Ganti dengan fungsi untuk menghapus kontak
                    });
                    actionColumn.append(deleteButton);

                    row.append(actionColumn);
                    tableBody.append(row);
                });
            }
        }

        // Fungsi untuk menghapus kontak
        function deleteContact(id) {
            $.ajax({
                url: '../backend/deleteContact.php', // Ganti dengan URL skrip PHP yang menghapus kontak
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function (response) {
                    // Menampilkan pesan respons menggunakan SweetAlert
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message
                    });

                    // Memuat kembali data kontak setelah berhasil menghapus
                    loadContactData();
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        }


        // Memuat data kontak saat halaman dimuat
        loadContactData();
    });
</script>