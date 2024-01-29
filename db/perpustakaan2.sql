-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Jan 2024 pada 18.37
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan2`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(4) NOT NULL,
  `nama_buku` varchar(50) NOT NULL,
  `kode_buku` varchar(10) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `kategori` text NOT NULL,
  `tanggal_buku` date NOT NULL DEFAULT current_timestamp(),
  `id_user` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id_buku`, `nama_buku`, `kode_buku`, `lokasi`, `kategori`, `tanggal_buku`, `id_user`) VALUES
(1, 'KBBI', 'KB', 'Rak 2 baris 3', '', '2022-11-17', 2),
(2, 'tes', 'tes', 'Rak 2 baris 3', '', '2022-11-17', 2),
(3, 'Blue', 'bl8888', 'Rak 1 baris 2', '', '2022-11-17', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `favorit`
--

CREATE TABLE `favorit` (
  `idfavorit` int(10) NOT NULL,
  `buku_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
--

CREATE TABLE `karyawan` (
  `id_kw` int(4) NOT NULL,
  `user_id` int(4) NOT NULL,
  `nama_karyawan` varchar(50) NOT NULL,
  `NIK` varchar(16) NOT NULL,
  `JK` enum('Laki-laki','Perempuan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `karyawan`
--

INSERT INTO `karyawan` (`id_kw`, `user_id`, `nama_karyawan`, `NIK`, `JK`) VALUES
(1, 2, 'Naruto', '456787654', 'Laki-laki'),
(2, 3, 'Kakashi', '576543', 'Laki-laki'),
(3, 5, 'Minato', '5676545', 'Laki-laki'),
(4, 1, 'admingas', '453', 'Laki-laki'),
(5, 8, 'tes3', '4232', 'Laki-laki');

-- --------------------------------------------------------

--
-- Struktur dari tabel `level`
--

CREATE TABLE `level` (
  `id` int(10) NOT NULL,
  `level` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `level`
--

INSERT INTO `level` (`id`, `level`) VALUES
(1, 'Admin'),
(2, 'Petugas'),
(3, 'Member');

-- --------------------------------------------------------

--
-- Struktur dari tabel `member`
--

CREATE TABLE `member` (
  `IDmember` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `nama_member` varchar(255) NOT NULL,
  `no_telp` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `member`
--

INSERT INTO `member` (`IDmember`, `user_id`, `nama_member`, `no_telp`) VALUES
(1, 4, 'Kakashi Hatake', '231321'),
(2, 7, 'tes2', '321231');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_pinjam` int(4) NOT NULL,
  `id_buku` int(4) NOT NULL,
  `status` int(1) NOT NULL,
  `peminjam_id` int(10) NOT NULL,
  `tgl_pinjam` date NOT NULL DEFAULT current_timestamp(),
  `tgl_kembali` date NOT NULL,
  `id_user` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`id_pinjam`, `id_buku`, `status`, `peminjam_id`, `tgl_pinjam`, `tgl_kembali`, `id_user`) VALUES
(3, 2, 0, 2, '2022-11-17', '0000-00-00', 2),
(4, 1, 1, 1, '2022-11-15', '2022-11-17', 2),
(5, 1, 1, 1, '2022-11-16', '2022-11-16', 3),
(6, 3, 1, 1, '2022-11-16', '2022-11-16', 2),
(7, 3, 1, 1, '2022-11-15', '2022-11-19', 2),
(8, 1, 1, 1, '2024-01-29', '2024-01-29', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ulasan`
--

CREATE TABLE `ulasan` (
  `IDulasan` int(10) NOT NULL,
  `ulasan` text NOT NULL,
  `buku_id` int(10) NOT NULL,
  `tanggal` date NOT NULL DEFAULT current_timestamp(),
  `user_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `ulasan`
--

INSERT INTO `ulasan` (`IDulasan`, `ulasan`, `buku_id`, `tanggal`, `user_id`) VALUES
(1, 'tes', 2, '2024-01-29', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(4) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `level` char(1) NOT NULL,
  `foto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `level`, `foto`) VALUES
(1, 'duar1234', '21232f297a57a5a743894a0e4a801fc3', '1', '1669642205_99d729fce45ea43459df.jpg'),
(2, 'ehe', '529ca8050a00180790cf88b63468826a', '2', '2.jpg'),
(3, 'konoha', 'bab4ff04cc14af66e4d42c85f888cfe6', '2', ''),
(4, 'tes', 'fa3fb6e0dccc657b57251c97db271b05', '3', '1706549452_488a6aaede18bede785d.jpg'),
(5, 'hokage', '83ff8d9c0eb1641f293281b3ff845ee3', '2', '.jpg'),
(7, 'tes2', '827ccb0eea8a706c4c34a16891f84e7b', '3', ''),
(8, 'tes3', '827ccb0eea8a706c4c34a16891f84e7b', '2', '');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`) USING BTREE,
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `favorit`
--
ALTER TABLE `favorit`
  ADD PRIMARY KEY (`idfavorit`);

--
-- Indeks untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_kw`),
  ADD KEY `id_user` (`user_id`);

--
-- Indeks untuk tabel `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`IDmember`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_pinjam`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `ulasan`
--
ALTER TABLE `ulasan`
  ADD PRIMARY KEY (`IDulasan`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `favorit`
--
ALTER TABLE `favorit`
  MODIFY `idfavorit` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_kw` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `level`
--
ALTER TABLE `level`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `member`
--
ALTER TABLE `member`
  MODIFY `IDmember` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_pinjam` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `IDulasan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
