<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UKRIDA LIBRARY</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.min.js"></script>
    <!-- Pastikan Anda telah memasang library SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .square-image {
            width: 100%;
            height: 0;
            padding-bottom: 100%;
        }

        .carousel-image {
            object-fit: cover;
            object-position: center;
            max-height: 300px;
            /* Atur tinggi maksimum sesuai kebutuhan Anda */
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
</head>

<body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="index.php">UKRIDA LIBRARY</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="book.php">Buku</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="article.php">Artikel</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
                <li class="nav-item">
                    <a href="./admin/login.php" class="btn btn-warning">Login</a>
                </li>
            </ul>
        </div>
    </nav>