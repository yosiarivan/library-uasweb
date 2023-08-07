<?php
// Pemeriksaan session di halaman admin
session_start();
// Jika session login tidak ada atau belum diset, redirect ke halaman login
if (!isset($_SESSION['admin_id'])) {
    $_SESSION['login_error'] = "Anda harus login terlebih dahulu.";
    header('Location: ../admin/login.php');
    exit();
}
// Memanggil nama admin dari session
$adminId = $_SESSION['admin_id'];
$adminName = $_SESSION['admin_name'];
$role_id = $_SESSION['admin_role_id'];
$imageUser = $_SESSION['admin_image'];

// Pemeriksaan session di halaman admin
if (is_admin_page()) {
    // Cek role_id
    if ($role_id === '2') {
        $_SESSION['access_error'] = "Anda tidak memiliki akses ke halaman ini.";
        header('Location: ../admin/home.php');
        exit();
    }
}
function is_admin_page()
{
    // Daftar halaman admin yang membutuhkan pemeriksaan role_id
    $admin_pages = array('tb_admin.php', 'gallery.php', 'contact_us.php');

    // Mendapatkan nama halaman yang sedang dibuka
    $current_page = basename($_SERVER['PHP_SELF']);

    // Mengecek apakah halaman yang dibuka termasuk dalam halaman admin
    if (in_array($current_page, $admin_pages)) {
        return true;
    } else {
        return false;
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>ADMIN - PORTAL LIBRARY UKRIDA</title>
    <!-- Masukkan skrip JavaScript dan jQuery Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!-- Tambahkan library Select2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js"></script>
    <!-- Memasukkan file CSS SweetAlert dari server CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
    <!-- Memasukkan file JavaScript SweetAlert dari server CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.all.min.js"></script>
    <style>
        .container {
            width: 100%;
            max-width: 1250px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="home.php">PORTAL UKRIDA LIBRARY</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Halaman Utama</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../admin/gallery.php">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact_us.php">Kontak</a>
                    </li>
                </ul>
            </div>
            <div class="dropdown">
                <a class="navbar-brand dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php
                    // Mendapatkan gambar profil dari sesi
                    $profileImage = $_SESSION['admin_image'];

                    // Menampilkan gambar profil jika tersedia, jika tidak, tampilkan gambar profil default
                    if ($profileImage) {
                        echo '<img src="../img/src/' . $profileImage . '" alt="Profile Image" style="width: 25px; height: 25px; border-radius: 50%;"> ';
                    } else {
                        echo '<img src="../img/default_user.png" alt="Default Profile Image" style="width: 25px; height: 25px; border-radius: 50%;"> ';
                    }

                    echo $adminName;
                    ?>
                </a>

                <!-- Dropdown Menu -->
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                    <button class="dropdown-item" onclick="getProfileData()">Profil</button>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="../backend/logout.php">Keluar</a>
                </div>
            </div>
            <!-- Modal View Profile -->
            <div class="modal fade" id="viewProfileModal" tabindex="-1" role="dialog"
                aria-labelledby="viewProfileModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewProfileModalLabel">Profile</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <img id="profileImage" src="" alt="Profile Picture"
                                                    class="img-fluid rounded-circle"
                                                    style="width: 150px; height: 150px;">
                                            </td>
                                            <td>
                                                <div class="profile-details mt-4">
                                                    <p><strong>Name:</strong> <span id="name"></span></p>
                                                    <p><strong>Email:</strong> <span id="email"></span></p>
                                                    <p><strong>Employee Number:</strong> <span id="no_karyawan"></span>
                                                    </p>
                                                    <p><strong>Role ID:</strong> <span id="role_id"></span></p>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" onclick="openEditProfileModal()">Edit</button>
                            <button type="button" class="btn btn-warning" data-toggle="modal"
                                data-target="#changePasswordModal">Change Password</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Edit Profile -->
            <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog"
                aria-labelledby="editProfileModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="editProfileForm">
                                <div class="form-group">
                                    <label for="editProfileImage">Profile Picture</label>
                                    <input type="file" class="form-control-file" id="editProfileImage" name="image">
                                </div>
                                <div class="form-group">
                                    <label for="editProfileName">Name</label>
                                    <input type="text" class="form-control" id="editProfileName" name="name"
                                        placeholder="Enter your name">
                                </div>
                                <div class="form-group">
                                    <label for="editProfileEmail">Email</label>
                                    <input type="email" class="form-control" id="editProfileEmail" name="email"
                                        placeholder="Enter your email">
                                </div>
                                <!-- Tambahkan input field tersembunyi untuk menyimpan ID -->
                                <input type="hidden" id="editProfileId" name="id">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal ganti password -->
            <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog"
                aria-labelledby="changePasswordModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="passwordForm">
                                <div class="form-group">
                                    <label for="userId">User ID</label>
                                    <input type="text" class="form-control" id="userId" name="userId" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="currentPassword">Current Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="currentPassword"
                                            name="currentPassword" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button"
                                                id="showCurrentPasswordBtn"
                                                onclick="togglePasswordVisibility('currentPassword')">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="newPassword">New Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="newPassword" name="newPassword"
                                            required>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button"
                                                id="showNewPasswordBtn"
                                                onclick="togglePasswordVisibility('newPassword')">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="confirmPassword">Confirm Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="confirmPassword"
                                            name="confirmPassword" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button"
                                                id="showConfirmPasswordBtn"
                                                onclick="togglePasswordVisibility('confirmPassword')">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                    </div>
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

        </nav>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>
                <?php echo "Halo, " . $adminName; ?>
            </strong> Selamat Bekerja :)
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </header>
    <script>
        function openEditProfileModal() {
            // Tutup modal profile
            $("#viewProfileModal").modal("hide");
            // Buka modal edit
            $("#editProfileModal").modal("show");
        }

        $(document).ready(function () {
            // Menggunakan event submit pada form
            $('#editProfileForm').submit(function (event) {
                // Menghentikan perilaku default submit form
                event.preventDefault();

                // Membuat objek FormData untuk mengirim data formulir
                var formData = new FormData(this);

                // Mendapatkan file gambar yang dipilih
                var imageFile = $('#editProfileImage')[0].files[0];

                // Menambahkan file gambar ke objek FormData
                formData.append('image', imageFile);

                // Mengirim data melalui AJAX
                $.ajax({
                    url: '../backend/editProfile.php', // Ganti dengan URL yang sesuai
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Profil admin berhasil diperbarui',
                            }).then((result) => {
                                // Memuat ulang halaman untuk memperbarui data admin
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal memperbarui data admin',
                                text: response.message
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'AJAX Error',
                            text: status + ' - ' + error
                        });
                    }
                });
            });
        });



        // Fungsi untuk mengambil data profil menggunakan Ajax
        function getProfileData() {
            // Mendapatkan ID sesi admin_id dari variabel admin_id
            var adminId = '<?php echo $_SESSION['admin_id']; ?>';
            // Mengirim permintaan Ajax
            $.ajax({
                url: '../backend/getAdmin.php',
                method: 'POST',
                data: {
                    id: adminId
                },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        // Data berhasil ditemukan
                        var data = response.admin;

                        // Mengisi elemen modal dengan data yang diterima
                        $('#profileImage').attr('src', '../img/src/' + data.image);
                        $('#name').text(data.name);
                        $('#email').text(data.email);
                        $('#no_karyawan').text(data.no_karyawan);
                        $('#role_id').text(data.role_id === '1' ? 'Admin' : (data.role_id === '2' ? 'Author' : 'Unrole'));

                        // Mengisi form edit dengan data yang diterima
                        $('#editProfileId').val(data.id);
                        $('#editProfileName').val(data.name);
                        $('#editProfileEmail').val(data.email);

                        $('#userId').val(data.id);


                        // Menampilkan modal profil
                        $('#viewProfileModal').modal('show');
                    } else {
                        // Tidak ada admin dengan ID yang diberikan
                        var message = response.message;
                        console.log('Error:', message);
                    }
                },
                error: function (xhr, status, error) {
                    console.log('Request failed. Status:', xhr.status);
                }
            });
        }

        $(document).ready(function () {
            $('#passwordForm').submit(function (event) {
                event.preventDefault(); // Mencegah form submit secara default

                // Mengambil nilai input dari form
                var userId = $('#userId').val();
                var currentPassword = $('#currentPassword').val();
                var newPassword = $('#newPassword').val();
                var confirmPassword = $('#confirmPassword').val();

                // Validasi password baru dan konfirmasi password
                if (newPassword !== confirmPassword) {
                    Swal.fire({
                        title: 'Error',
                        text: 'New password and confirm password do not match',
                        icon: 'error'
                    });
                    return;
                }

                // Data yang akan dikirim melalui AJAX
                var formData = {
                    userId: userId, // Menambahkan ID terkait ke data
                    currentPassword: currentPassword,
                    newPassword: newPassword,
                    confirmPassword: confirmPassword
                };

                // Mengirim permintaan AJAX
                $.ajax({
                    type: 'POST',
                    url: '../backend/changePassword.php', // Ganti dengan URL yang sesuai
                    data: formData,
                    success: function (response) {
                        // Menangani respons dari server setelah permintaan berhasil
                        if (response.success) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Password changed successfully',
                                icon: 'success'
                            }).then(function () {
                                $('#changePasswordModal').modal('hide');
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: response.message,
                                icon: 'error'
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        // Menangani kesalahan saat permintaan AJAX
                        console.error(xhr.responseText);
                        Swal.fire({
                            title: 'Error',
                            text: 'An error occurred',
                            icon: 'error'
                        });
                    }
                });
            });
        });

        function togglePasswordVisibility(inputId) {
            var input = document.getElementById(inputId);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }




    </script>