-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Des 2021 pada 09.33
-- Versi server: 10.4.13-MariaDB
-- Versi PHP: 7.3.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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

--
-- Dumping data untuk tabel `tb_barang`
--

INSERT INTO `tb_barang` (`id_barang`, `nama_barang`, `stock`, `stock_tersedia`, `harga_beli`, `min_stock`, `foto`, `id_kategori`, `id_laborat`) VALUES
('LFS01KM0001', 'test 1', 3, 2, 50000, 0, '1639144885427.jpg', 'KM', 'LFS01'),
('LKM01KM0001', 'test 3', 4, 2, 400000, 0, '1639144822275.png', 'KM', 'LKM01');

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
  `status` enum('Approved','Not Approved','Proses','Selesai') DEFAULT NULL,
  `id_peminjaman` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_dtl_peminjaman`
--

INSERT INTO `tb_dtl_peminjaman` (`id_dtl_peminjaman`, `id_barang`, `qty_pinjam`, `qty_approved`, `status`, `id_peminjaman`) VALUES
(1, 'LKM01KM0001', 2, 0, 'Proses', 'PJ2021120001'),
(2, 'LKM01KM0001', 2, 2, 'Proses', 'PJ2021120002'),
(3, 'LKM01KM0001', 2, 2, 'Selesai', 'PJ2021120003'),
(4, 'LKM01KM0001', 1, 1, 'Selesai', 'PJ2021120003'),
(6, 'LKM01KM0001', 2, 2, 'Proses', 'PJ2021120005');

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
  `qty_rusak_approved` int(11) DEFAULT NULL,
  `ket_rusak` text DEFAULT NULL,
  `id_pengaduan` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_dtl_pengaduan`
--

INSERT INTO `tb_dtl_pengaduan` (`id_dtl_pengaduan`, `id_barang`, `qty_rusak`, `qty_rusak_approved`, `ket_rusak`, `id_pengaduan`) VALUES
(1, 'LKM01KM0001', 1, 1, 'rusak kacanya', 'AD2021120003');

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
  `tgl_kembali` date DEFAULT NULL,
  `denda_keterlambatan` float DEFAULT NULL,
  `ket_kembali` text DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` enum('Proses','Approved','Not Approved','Selesai') DEFAULT NULL,
  `no_induk` varchar(30) DEFAULT NULL,
  `id_periode` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_peminjaman`
--

INSERT INTO `tb_peminjaman` (`id_peminjaman`, `tgl_pengajuan`, `pinjam_mulai`, `pinjam_sampai`, `tgl_kembali`, `denda_keterlambatan`, `ket_kembali`, `keterangan`, `status`, `no_induk`, `id_periode`) VALUES
('PJ2021120001', '2021-12-12', '2021-12-13', '2021-12-14', NULL, NULL, NULL, '', 'Proses', '0012345678', 2),
('PJ2021120002', '2021-12-12', '2021-12-12', '2021-12-13', NULL, NULL, NULL, 'test', 'Selesai', '0012345678', 2),
('PJ2021120003', '2021-12-12', '2021-12-12', '2021-12-14', '2021-12-14', 0, 'test1', 'dsdsf', 'Selesai', '0012345678', 2),
('PJ2021120005', '2021-12-12', '2021-12-14', '2021-12-15', NULL, NULL, NULL, 'asds', 'Proses', '0012345678', 2);

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
  `status` enum('Proses','Approved','Not Approved') DEFAULT NULL,
  `no_induk` varchar(30) DEFAULT NULL,
  `id_periode` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_pengaduan`
--

INSERT INTO `tb_pengaduan` (`id_pengaduan`, `tgl_pengaduan`, `keterangan`, `status`, `no_induk`, `id_periode`) VALUES
('AD2021120001', '2021-12-14', 'TEST KETER', 'Proses', '0012345678', 2),
('AD2021120002', '2021-12-14', NULL, 'Approved', '0012345678', 2),
('AD2021120003', '2021-12-14', 'test', 'Proses', '1234353', 2);

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
-- Struktur dari tabel `tb_transaksi`
--

CREATE TABLE `tb_transaksi` (
  `tanggal_entry` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `id_laborat` varchar(20) DEFAULT NULL,
  `id_barang` varchar(20) DEFAULT NULL,
  `prev_qty` int(11) DEFAULT NULL,
  `tran_qty` int(11) DEFAULT NULL,
  `balance_qty` int(11) DEFAULT NULL,
  `harga_satuan` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
('1234353', 'TEST edit', 'Alamat edit', '085446546542', '085446546543', 'Perempuan', 'TESTedit', '123456edit', 'guru', 'Aktif'),
('2100123456', 'Chandra Asih', 'Jln. Pemuda no 23, Semarang', '08512376871', '08512376871', 'Perempuan', 'sarpras', 'sarpras', 'sarpras', 'Tidak Aktif'),
('2111123456', 'Subejo, M.H', 'Jln. Merpati no 12, Pati', '0813247688112', '0813247688112', 'Laki-laki', 'kepsek', 'kepsek', 'kepsek', 'Aktif'),
('2111123457', 'Tresna, M.H', 'Jln. Merpati no 12, Pati', '0813247688113', '0813247688113', 'Laki-laki', 'laboran', 'laboran', 'laboran', 'Aktif');

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
  MODIFY `id_dtl_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tb_dtl_pengadaan`
--
ALTER TABLE `tb_dtl_pengadaan`
  MODIFY `id_dtl_pengadaan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_dtl_pengaduan`
--
ALTER TABLE `tb_dtl_pengaduan`
  MODIFY `id_dtl_pengaduan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
