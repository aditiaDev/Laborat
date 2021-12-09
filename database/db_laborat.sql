-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Des 2021 pada 15.26
-- Versi server: 10.4.10-MariaDB
-- Versi PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_laborat`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_barang`
--

CREATE TABLE `tb_barang` (
  `id_barang` varchar(20) NOT NULL,
  `nama_barang` text DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `stock_tersedia` int(11) NOT NULL,
  `harga_beli` float DEFAULT NULL,
  `min_stock` int(11) DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `id_kategori` varchar(10) DEFAULT NULL,
  `id_laborat` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_bukti_pembelanjaan`
--

CREATE TABLE `tb_bukti_pembelanjaan` (
  `id_nota` int(11) NOT NULL,
  `id_pengadaan` varchar(20) DEFAULT NULL,
  `foto_nota` text DEFAULT NULL,
  `tgl_upload` datetime DEFAULT NULL,
  `no_induk` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_dtl_monitoring`
--

CREATE TABLE `tb_dtl_monitoring` (
  `id_dtl_monitoring` int(11) NOT NULL,
  `id_barang` varchar(20) DEFAULT NULL,
  `stock_sistem` int(11) DEFAULT NULL,
  `stock_actual` int(11) DEFAULT NULL,
  `qty_bagus` int(11) DEFAULT NULL,
  `qty_rusak` int(11) DEFAULT NULL,
  `id_monitoring` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_dtl_peminjaman`
--

CREATE TABLE `tb_dtl_peminjaman` (
  `id_dtl_peminjaman` int(11) NOT NULL,
  `id_barang` varchar(20) DEFAULT NULL,
  `qty_pinjam` int(11) DEFAULT NULL,
  `qty_approved` int(11) DEFAULT NULL,
  `status` enum('approved','not approved') DEFAULT NULL,
  `id_peminjaman` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_dtl_pengadaan`
--

CREATE TABLE `tb_dtl_pengadaan` (
  `id_dtl_pengadaan` int(11) NOT NULL,
  `id_barang` varchar(20) DEFAULT NULL,
  `qty_pengajuan` int(11) DEFAULT NULL,
  `qty_approved` int(11) DEFAULT NULL,
  `harga` float DEFAULT NULL,
  `status` enum('approved','not approved','proses') DEFAULT NULL,
  `total_belanja` float NOT NULL,
  `id_pengadaan` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_dtl_pengaduan`
--

CREATE TABLE `tb_dtl_pengaduan` (
  `id_dtl_pengaduan` int(11) NOT NULL,
  `id_barang` varchar(20) DEFAULT NULL,
  `qty_rusak` int(11) DEFAULT NULL,
  `ket_rusak` text DEFAULT NULL,
  `id_pengaduan` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kategori`
--

CREATE TABLE `tb_kategori` (
  `id_kategori` varchar(10) NOT NULL,
  `deskripsi` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_kategori`
--

INSERT INTO `tb_kategori` (`id_kategori`, `deskripsi`) VALUES
('KM', 'BAHAN KIMIA');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_laborat`
--

CREATE TABLE `tb_laborat` (
  `id_laborat` varchar(25) NOT NULL,
  `deskripsi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_laborat`
--

INSERT INTO `tb_laborat` (`id_laborat`, `deskripsi`) VALUES
('LFS01', 'Lab Fisika 01'),
('LKM01', 'Lab Kimia 01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_monitoring`
--

CREATE TABLE `tb_monitoring` (
  `id_monitoring` varchar(20) NOT NULL,
  `tgl_monitoring` datetime DEFAULT NULL,
  `status` enum('process','approved','not_approved') DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `no_induk` varchar(30) DEFAULT NULL,
  `id_periode` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_peminjaman`
--

CREATE TABLE `tb_peminjaman` (
  `id_peminjaman` varchar(20) NOT NULL,
  `tgl_pengajuan` date DEFAULT NULL,
  `pinjam_mulai` date DEFAULT NULL,
  `pinjam_sampai` date DEFAULT NULL,
  `tgl_kembali` date NOT NULL,
  `ket_kembali` text NOT NULL,
  `keterangan` text DEFAULT NULL,
  `status` enum('proses','approved','not approved','selesai') DEFAULT NULL,
  `no_induk` varchar(30) DEFAULT NULL,
  `id_periode` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pendaftaran`
--

CREATE TABLE `tb_pendaftaran` (
  `id_daftar` int(11) NOT NULL,
  `tgl_daftar` date DEFAULT NULL,
  `no_induk` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pengadaan`
--

CREATE TABLE `tb_pengadaan` (
  `id_pengadaan` varchar(20) NOT NULL,
  `tgl_pengajuan` datetime DEFAULT NULL,
  `status` enum('process','approved sarpras','not approved sarpras','approved kepsek','not approved kepsek','selesai') DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `no_induk` varchar(30) DEFAULT NULL,
  `id_periode` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pengaduan`
--

CREATE TABLE `tb_pengaduan` (
  `id_pengaduan` varchar(20) NOT NULL,
  `tgl_pengaduan` date DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` enum('proses','approved','not approved') DEFAULT NULL,
  `no_induk` varchar(30) DEFAULT NULL,
  `id_periode` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_periode`
--

CREATE TABLE `tb_periode` (
  `id_periode` int(11) NOT NULL,
  `periode` varchar(100) DEFAULT '',
  `status` enum('Aktif','Tidak Aktif') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_periode`
--

INSERT INTO `tb_periode` (`id_periode`, `periode`, `status`) VALUES
(1, '2020-2021', 'Tidak Aktif'),
(2, '2021-2022', 'Aktif'),
(3, '2022-2023', 'Tidak Aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `no_induk` varchar(30) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_telp` varchar(14) DEFAULT NULL,
  `no_wa` varchar(14) DEFAULT NULL,
  `jekel` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `hak_akses` enum('kepsek','bendahara','sarpras','siswa','guru','laboran') DEFAULT NULL,
  `status` enum('Aktif','Tidak Aktif') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`no_induk`, `nama`, `alamat`, `no_telp`, `no_wa`, `jekel`, `username`, `password`, `hak_akses`, `status`) VALUES
('0012345678', 'Rifky Febian', 'Jln. Kartini no 2, Jepara', '085643520576', '085643520576', 'Laki-laki', 'siswa', 'siswa', 'siswa', 'Aktif'),
('1234353', 'TEST edit', 'Alamat edit', '085446546542', '085446546543', 'Perempuan', 'TESTedit', '123456edit', 'siswa', 'Aktif'),
('2100123456', 'Chandra Asih', 'Jln. Pemuda no 23, Semarang', '08512376871', '08512376871', 'Perempuan', 'sarpras', 'sarpras', 'sarpras', 'Tidak Aktif'),
('2111123456', 'Subejo, M.H', 'Jln. Merpati no 12, Pati', '0813247688112', '0813247688112', 'Laki-laki', 'kepsek', 'kepsek', 'kepsek', 'Aktif');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_barang`
--
ALTER TABLE `tb_barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `barang_fk1` (`id_kategori`),
  ADD KEY `barang_fk2` (`id_laborat`);

--
-- Indeks untuk tabel `tb_bukti_pembelanjaan`
--
ALTER TABLE `tb_bukti_pembelanjaan`
  ADD PRIMARY KEY (`id_nota`),
  ADD KEY `bukti_belanja_fk1` (`id_pengadaan`);

--
-- Indeks untuk tabel `tb_dtl_monitoring`
--
ALTER TABLE `tb_dtl_monitoring`
  ADD PRIMARY KEY (`id_dtl_monitoring`),
  ADD KEY `dtl_monitoring_fk1` (`id_monitoring`),
  ADD KEY `dtl_monitoring_fk2` (`id_barang`);

--
-- Indeks untuk tabel `tb_dtl_peminjaman`
--
ALTER TABLE `tb_dtl_peminjaman`
  ADD PRIMARY KEY (`id_dtl_peminjaman`),
  ADD KEY `dtl_peminjaman_fk1` (`id_barang`),
  ADD KEY `dtl_peminjaman_fk2` (`id_peminjaman`);

--
-- Indeks untuk tabel `tb_dtl_pengadaan`
--
ALTER TABLE `tb_dtl_pengadaan`
  ADD PRIMARY KEY (`id_dtl_pengadaan`),
  ADD KEY `dtl_pengadaan_fk1` (`id_pengadaan`),
  ADD KEY `dtl_pengadaan_fk2` (`id_barang`);

--
-- Indeks untuk tabel `tb_dtl_pengaduan`
--
ALTER TABLE `tb_dtl_pengaduan`
  ADD PRIMARY KEY (`id_dtl_pengaduan`),
  ADD KEY `dtl_pengaduan_fk1` (`id_pengaduan`),
  ADD KEY `dtl_pengaduan_fk2` (`id_barang`);

--
-- Indeks untuk tabel `tb_kategori`
--
ALTER TABLE `tb_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `tb_laborat`
--
ALTER TABLE `tb_laborat`
  ADD PRIMARY KEY (`id_laborat`);

--
-- Indeks untuk tabel `tb_monitoring`
--
ALTER TABLE `tb_monitoring`
  ADD PRIMARY KEY (`id_monitoring`),
  ADD KEY `monitoring_fk1` (`no_induk`),
  ADD KEY `monitoring_fk2` (`id_periode`);

--
-- Indeks untuk tabel `tb_peminjaman`
--
ALTER TABLE `tb_peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `peminjaman_fk1` (`no_induk`),
  ADD KEY `peminjaman_fk2` (`id_periode`);

--
-- Indeks untuk tabel `tb_pendaftaran`
--
ALTER TABLE `tb_pendaftaran`
  ADD PRIMARY KEY (`id_daftar`),
  ADD KEY `pendaftaran_fk1` (`no_induk`);

--
-- Indeks untuk tabel `tb_pengadaan`
--
ALTER TABLE `tb_pengadaan`
  ADD PRIMARY KEY (`id_pengadaan`),
  ADD KEY `pengadaan_fk1` (`no_induk`),
  ADD KEY `pengadaan_fk2` (`id_periode`);

--
-- Indeks untuk tabel `tb_pengaduan`
--
ALTER TABLE `tb_pengaduan`
  ADD PRIMARY KEY (`id_pengaduan`),
  ADD KEY `pengaduan_fk1` (`no_induk`),
  ADD KEY `pengaduan_fk2` (`id_periode`);

--
-- Indeks untuk tabel `tb_periode`
--
ALTER TABLE `tb_periode`
  ADD PRIMARY KEY (`id_periode`);

--
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`no_induk`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_bukti_pembelanjaan`
--
ALTER TABLE `tb_bukti_pembelanjaan`
  MODIFY `id_nota` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_dtl_monitoring`
--
ALTER TABLE `tb_dtl_monitoring`
  MODIFY `id_dtl_monitoring` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_dtl_peminjaman`
--
ALTER TABLE `tb_dtl_peminjaman`
  MODIFY `id_dtl_peminjaman` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_dtl_pengadaan`
--
ALTER TABLE `tb_dtl_pengadaan`
  MODIFY `id_dtl_pengadaan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_dtl_pengaduan`
--
ALTER TABLE `tb_dtl_pengaduan`
  MODIFY `id_dtl_pengaduan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_pendaftaran`
--
ALTER TABLE `tb_pendaftaran`
  MODIFY `id_daftar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_periode`
--
ALTER TABLE `tb_periode`
  MODIFY `id_periode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_barang`
--
ALTER TABLE `tb_barang`
  ADD CONSTRAINT `barang_fk1` FOREIGN KEY (`id_kategori`) REFERENCES `tb_kategori` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_fk2` FOREIGN KEY (`id_laborat`) REFERENCES `tb_laborat` (`id_laborat`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_bukti_pembelanjaan`
--
ALTER TABLE `tb_bukti_pembelanjaan`
  ADD CONSTRAINT `bukti_belanja_fk1` FOREIGN KEY (`id_pengadaan`) REFERENCES `tb_pengadaan` (`id_pengadaan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_dtl_monitoring`
--
ALTER TABLE `tb_dtl_monitoring`
  ADD CONSTRAINT `dtl_monitoring_fk1` FOREIGN KEY (`id_monitoring`) REFERENCES `tb_monitoring` (`id_monitoring`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dtl_monitoring_fk2` FOREIGN KEY (`id_barang`) REFERENCES `tb_barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_dtl_peminjaman`
--
ALTER TABLE `tb_dtl_peminjaman`
  ADD CONSTRAINT `dtl_peminjaman_fk1` FOREIGN KEY (`id_barang`) REFERENCES `tb_barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dtl_peminjaman_fk2` FOREIGN KEY (`id_peminjaman`) REFERENCES `tb_peminjaman` (`id_peminjaman`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_dtl_pengadaan`
--
ALTER TABLE `tb_dtl_pengadaan`
  ADD CONSTRAINT `dtl_pengadaan_fk1` FOREIGN KEY (`id_pengadaan`) REFERENCES `tb_pengadaan` (`id_pengadaan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dtl_pengadaan_fk2` FOREIGN KEY (`id_barang`) REFERENCES `tb_barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_dtl_pengaduan`
--
ALTER TABLE `tb_dtl_pengaduan`
  ADD CONSTRAINT `dtl_pengaduan_fk1` FOREIGN KEY (`id_pengaduan`) REFERENCES `tb_pengaduan` (`id_pengaduan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dtl_pengaduan_fk2` FOREIGN KEY (`id_barang`) REFERENCES `tb_barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_monitoring`
--
ALTER TABLE `tb_monitoring`
  ADD CONSTRAINT `monitoring_fk1` FOREIGN KEY (`no_induk`) REFERENCES `tb_user` (`no_induk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `monitoring_fk2` FOREIGN KEY (`id_periode`) REFERENCES `tb_periode` (`id_periode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_peminjaman`
--
ALTER TABLE `tb_peminjaman`
  ADD CONSTRAINT `peminjaman_fk1` FOREIGN KEY (`no_induk`) REFERENCES `tb_user` (`no_induk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `peminjaman_fk2` FOREIGN KEY (`id_periode`) REFERENCES `tb_periode` (`id_periode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_pendaftaran`
--
ALTER TABLE `tb_pendaftaran`
  ADD CONSTRAINT `pendaftaran_fk1` FOREIGN KEY (`no_induk`) REFERENCES `tb_user` (`no_induk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_pengadaan`
--
ALTER TABLE `tb_pengadaan`
  ADD CONSTRAINT `pengadaan_fk1` FOREIGN KEY (`no_induk`) REFERENCES `tb_user` (`no_induk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pengadaan_fk2` FOREIGN KEY (`id_periode`) REFERENCES `tb_periode` (`id_periode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_pengaduan`
--
ALTER TABLE `tb_pengaduan`
  ADD CONSTRAINT `pengaduan_fk1` FOREIGN KEY (`no_induk`) REFERENCES `tb_user` (`no_induk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pengaduan_fk2` FOREIGN KEY (`id_periode`) REFERENCES `tb_periode` (`id_periode`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
