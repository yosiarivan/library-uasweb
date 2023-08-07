<?php
session_start();
session_destroy();

// Redirect ke halaman login atau halaman lain yang sesuai setelah logout
header('Location: ../admin/login.php');
exit();
?>
