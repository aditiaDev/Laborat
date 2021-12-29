<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Laporan Pengadaan</title>
</head>
<body>
 
<div id="container">
	<h3>Laporan Pengadaan</h3>
    <table border="1" style="width:100%;font-size:12px;border: 1px solid #ddd;border-collapse: collapse;">
		<thead>
	  		<tr>
                <th class="normal">Periode</th>
	  			<th class="normal">No Dokumen</th>
	  			<th class="normal">Tanggal<br>Pengadaan</th>
                <th class="normal">Diajukan<br>Oleh</th>
				<th class="normal">ID Barang</th>
                <th class="normal">Deskripsi</th>
                <th class="normal">Jml</th>
                <th class="normal">Harga</th>
                <th class="normal">Keterangan</th>
	  		</tr>
	  	</thead>
	  	<tbody>
		  	<?php $no=1;$total=0; ?>
				<?php foreach($data as $row): ?>
				<tr>
                    <td><?php echo $row['periode']; ?></td>
					<td><?php echo $row['id_pengadaan']; ?></td>
					<td><?php echo $row['tgl_pengajuan']; ?></td>
					<td><?php echo $row['no_induk'].' - '.$row['nama']; ?></td>
					<td><?php echo $row['id_barang']; ?></td>
                    <td><?php echo $row['nama_barang']; ?></td>
					<td style="text-align:right;"><?php echo number_format($row['qty_approved'],0,',','.'); ?></td>
                    <td style="text-align:right;"><?php echo number_format($row['harga'],0,',','.'); ?></td>
                    <td><?php echo $row['keterangan']; ?></td>
				</tr>
	  		<?php endforeach; ?>
	  	</tbody>

	  </table>
 
</div>
 
</body>
</html>
