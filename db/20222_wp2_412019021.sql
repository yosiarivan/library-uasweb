-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2023 at 05:42 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `20222_wp2_412019021`
--

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`id`, `title`, `image`, `description`, `link`) VALUES
(13, 'Pimpinan Khilafatul Muslimin Surabaya Divonis 5 Tahun Penjara', './img/b1.jpeg', 'Khilafatul Muslimin Surabaya, Aminuddin divonis 5 tahun penjara. Hakim menilai terdakwa melanggar tentang organisasi kemasyarakatan.', 'https://www.detik.com/jatim/hukum-dan-kriminal/d-6645140/pimpinan-khilafatul-muslimin-surabaya-divonis-5-tahun-penjara'),
(14, 'Kontroversi Al Zaytun', './img/b2.jpg', 'Pondok pesantren Al Zaytun tengah menjadi sorotan publik. Ponpes yang dipimpin Panji Gumilang ini diduga memiliki ajaran menyimpang.', 'https://nasional.tempo.co/read/1745404/sederet-kontroversi-al-zaytun-ponpes-panji-gumilang-yang-diduga-menyimpang'),
(16, 'Perkuat Literasi Keagamaan, Kemenag Siapkan Naskah Khotbah Jumat Berkualitas', './img/b3.jpeg', 'Kementerian Agama (Kemenag) akan menyediakan naskah khotbah Jumat yang berkualitas. Upaya ini dilakukan untuk memperkuat literasi keagamaan di Indonesia.', 'https://www.detik.com/hikmah/khazanah/d-6807353/perkuat-literasi-keagamaan-kemenag-siapkan-naskah-khotbah-jumat-berkualitas'),
(17, 'Siwak, Sunnah Rasulullah SAW yang Direkomendasikan WHO', './img/b4.jpeg', 'Di era modern seperti saat ini, kian marak produk pasta gigi dengan bahan utama siwak. Namun, tahukah kamu jika siwak telah digunakan sejak dahulu ketika zaman Rasulullah SAW.\nJauh sebelum manusia mengenal pasta dan sikat gigi, siwak sudah dipergunakan untuk membersihkan gigi dan mulut. Banyak umat Islam di seluruh dunia, terutama di negara-negara Arab, menganggap siwak sebagai pembersih gigi terbaik.', 'https://www.detik.com/hikmah/khazanah/d-6807018/siwak-sunnah-rasulullah-saw-yang-direkomendasikan-who');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(16, 'sadass666', 'saasa@gmail.comsssss', '1233412ssssssss', '2023-07-08 14:31:35'),
(17, 'sadass666', 'saasa@gmail.comsssss', '1233412ssssssss', '2023-07-08 14:33:06'),
(18, 'sadass666', 'saasa@gmail.comsssss', '1233412ssssssss', '2023-07-08 14:35:28'),
(19, 'sadass666', 'saasa@gmail.comsssss', '1233412ssssssss', '2023-07-08 14:36:19');

-- --------------------------------------------------------

--
-- Table structure for table `surahs`
--

CREATE TABLE `surahs` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surahs`
--

INSERT INTO `surahs` (`id`, `name`, `description`, `link`) VALUES
(1, 'al-fatihah', 'Surat Al-Fatihah adalah surah pembuka dalam Al-Qur', 'https://quran.kemenag.go.id/quran/per-ayat/surah/1?from=1&to=7'),
(2, 'an-nisā', 'Surah An-Nisa\' adalah surah ke-4 dalam Al-Qur\'an yang terdiri atas 176 ayat', 'https://quran.kemenag.go.id/quran/per-ayat/surah/4?from=1&to=176'),
(13, 'Al Baqarah', 'Al Baqarah merupakan surat ke-2 dalam Al Quran tepat setelah surat Al Fatihah. Surat ini terdiri dari 286 ayat dan menjadi surat dengan jumlah ayat terbanyak. Surat yang memiliki arti Sapi Betina ini diturunkan di Kota Madinah, sehingga tergolong surat Madaniyah.', 'https://quran.kemenag.go.id/quran/per-ayat/surah/2?from=1&to=286'),
(15, 'Al-Ma\'idah', 'Al-Maidah juga memiliki arti hidangan. Hal ini dikarenakan ayat-ayat tersebut menceritakan tentang peristiwa perjamuan Nabi Isa As dengan para pengikutnya dengan hidangan yang turun dari langit dan dimaknai sebagai anugerah yang datang langsung dari Allah SWT.', 'https://quran.kemenag.go.id/quran/per-ayat/surah/5?from=1&to=120'),
(55, 'asdasd', 'asdasd', 'asd'),
(56, 'asd', 'asd', 'asd');

-- --------------------------------------------------------

--
-- Table structure for table `tokoh`
--

CREATE TABLE `tokoh` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tokoh`
--

INSERT INTO `tokoh` (`id`, `name`, `image`, `description`, `link`) VALUES
(5, 'Abu Bakar ash-Shiddiq', './img/abu.jpg', 'Abu Bakar ash-Shiddiq adalah sahabat Nabi yang termasuk dalam golongan orang pertama yang masuk Islam. Ia mendapat gelar Ash-Shidiq karena perannya menjadi orang pertama yang membenarkan ajaran Nabi Muhammad SAW. Abu Bakar bukan hanya orang terdekat Rasulullah yang disebut sebagai sahabat paling utama, tetapi juga ayah mertua Nabi Muhammad SAW.', 'https://id.wikipedia.org/wiki/Abu_Bakar_ash-Shiddiq'),
(6, 'Sunan Gresik', './img/gresik.jpg', 'Sunan Gresik merupakan salah satu nama-nama Wali Songo. Nama asli Sunan Gresik adalah Maulana Malik Ibrahim. Sunan Gresik dianggap sebagai yang pertama kali menyebarkan agama Islam di tanah Jawa.\n\nSejarah Sunan Gresik menimbulkan pertanyaan, namun diperkirakan beliau adalah keturunan dari wilayah Arab Maghrib di Afrika Utara. Diperkirakan juga bahwa Sunan Maulanan Malik Ibrahim lahir di Samarkand, Asia Tengah pada awal abad 14. Namun ada juga versi yang menyebutnya berasal dari Persia.', 'https://www.zonareferensi.com/nama-nama-wali-songo/'),
(7, 'Sunan Ampel', './img/ampel.jpg', 'Sunan Ampel adalah salah satu nama Wali Songo. Nama asli Sunan Ampel adalah Raden Rahmat. Beliau adalah anak dari Sunan Gresik dan Dewi Condro Wulan. Sunan Ampel berdakwah Islam di daerah Surabaya.\n\nBeliau diperkirakan merupakan keturunan ke-19 dari Nabi Muhammad SAW. Sunan Ampel lahir di Champa pada tahun 1401. Daerah Champa diperkirakan merupakan wilayah di Kamboja, namun ada juga pendapat lain yang menyebut Champa ada di Aceh.', 'https://www.zonareferensi.com/nama-nama-wali-songo/'),
(8, 'Sunan Bonang', './img/bonang.jpg', 'Sunan Bonang adalah salah satu Wali Songo. Nama asli Sunan Bonang adalah Maulana Makhdum Ibrahim. Beliau adalah putra dari Sunan Ampel dan Nyai Ageng Manila. Sunan Bonang merupakan keturunan ke-23 Nabi Muhammad SAW.\n\nSunan Bonang sempat mempelajari agama hingga ke Malaka di daerah Pasai. Ia menimbu ilmu dari Sunan Giri dan mempelajari metode dakwah yang menarik. Beliau kemudian pulang ke Tuban dan memutuskan untuk berdakwah di sana.', 'https://www.zonareferensi.com/nama-nama-wali-songo/'),
(9, 'Sunan Drajat', './img/drajat.jpg', 'Nama Wali Songo berikutnya adalah Sunan Drajat. Nama asli Sunan Drajat adalah Raden Qasim dan sempat mendapat gelar Raden Syarifudin. Ia adalah putra dari Sunan Ampel serta saudara dari Sunan Bonang serta menjadi keturunan ke-23 Rasulullah SAW.\n\nSunan Drajat sempat mencari ilmu agama pada Sunan Muria. Setelahnya barulah beliau kembali ke daerah Gresik di desa Jelog, pesisir Banjarwati, Lamongan. Ia kemudian mendirikan pesantren di desa Drajat, kecamatan Paciran, Lamongan.', 'asdhttps://www.zonareferensi.com/nama-nama-wali-songo/'),
(10, 'Sunan Kudus', './img/kudus.jpg', 'Nama Wali Songo berikutnya adalah Sunan Kudus. Nama asli Sunan Kudus adalah Ja’far Shadiq. Beliau adalah cucu Sunan Ampel dan putra dari Sunan Ngundung bersama Syarifah Ruhil. Sunan Kudus merupakan keturunan ke-24 dari Nabi Muhammad SAW.\n\nBeliau lahir pada 9 September 1400. Sunan Kudus giat dalam mempelajari ilmu agama, bahkan pernah belajar sampai ke kota Al-Quds, Yerusalam, Palestina. Setelahnya Sunan Kudus kembali ke Indonesia dan mendirikan pesantren di desa Loram, Kudus, Jawa Tengah.', 'asdhttps://www.zonareferensi.com/nama-nama-wali-songo/'),
(11, 'Sunan Giri', './img/giri.jpg', 'Sunan Giri menjadi salah satu nama-nama Walisongo. Nama asli Sunan Giri adalah Raden Paku atau Muhammad Ainul Yaqin. Beliau adalah putra Maulana Ishaq, ulama dari Pasai, Malaka. Sunan Giri merupakan keturunan ke-23 Nabi Muhammad SAW.\n\nSunan Giri lahir pada tahun 1442. Ia merupakan murid Sunan Ampel dan saudara seperguruan Sunan Bonang. Beliau sempat berguru pada ayahnya juga di Pasai, Malaka dan setelah ayahnya wafat, Sunan Giri menggantikan ayahnya mengajar.', 'https://www.zonareferensi.com/nama-nama-wali-songo/'),
(12, 'Sunan Kalijaga', './img/kalijaga.jpg', 'Sunan Kalijaga menjadi salah satu nama Walisongo yang cukup terkenal. Nama asli Sunan Kalijaga adalah Raden Said. Beliau adalah anak Tumenggung Wilatikta atau Radeh Sahur yang merupakan adipati Tuban yang sempat memimpin pemberontakan Ronggolawe di zaman Majapahit.\n\nSunan Kalijaga lahir pada tahun 1455. Ia merupakan murid dari Sunan Bonang. Sunan Bonang mengajarkan pendidikan dan ilmu-ilmu agama pada Sunan Kalijaga.', 'https://www.zonareferensi.com/nama-nama-wali-songo/');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `role`) VALUES
(1, '', '', '', ''),
(2, '', '', '', ''),
(3, '', '', '', ''),
(4, 'billy123', 'billy123', 'billyananda220@gmail.com', ''),
(5, 'billy', 'billy1', 'b@gmail.com', ''),
(6, 'billy123', 'billy123', 'billyananda220@gmail.com', ''),
(7, 'billy1', 'billy1', 'billey@gmail.com', ''),
(8, 'billy11', 'billy11', 'billy11@gmail.com', ''),
(9, 'bb1', 'bb1', 'bb1@gmail.com', ''),
(10, 'billy', 'billy', 'billyananda220@gmail.com', 'admin'),
(11, 'aa', 'aa', 'aa@yahoo.com', ''),
(12, 'aaa', 'aaa', 'aaa@yahoo.com', ''),
(13, 'aaa', 'aaa', 'aaa@yahoo.com', ''),
(14, 'admin', 'admin', 'admin@gmail.com', 'admin'),
(16, 'sa', 'sa', 'sa@gmail.com', 'admin'),
(17, 'user', 'user', 'user@gmail.com', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surahs`
--
ALTER TABLE `surahs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tokoh`
--
ALTER TABLE `tokoh`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `surahs`
--
ALTER TABLE `surahs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `tokoh`
--
ALTER TABLE `tokoh`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
