<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Peminjaman</title>
</head>
<body>
 
<div id="container">
	<h3>Permohonan Peminjaman Alat</h3>
	<hr>
    <table  style="font-size:14px;border: 1px solid #ddd;border-collapse: collapse;">
	  	<tbody>
		  	<tr>
				<td style="width:110px">Document No.</td>
				<td style="width:15px">:</td>
				<td><?php echo $hdr[0]['id_peminjaman']; ?></td>
				<td style="width:200px"></td>
				<td>No Identitas</td>
				<td style="width:15px">:</td>
				<td><?php echo $hdr[0]['no_induk']; ?></td>
			</tr>
			<tr>
				<td>Created Date</td>
				<td>:</td>
				<td><?php echo $hdr[0]['tgl_pengajuan']; ?></td>
				<td></td>
				<td>Nama Peminjam</td>
				<td>:</td>
				<td><?php echo $hdr[0]['nama']; ?></td>
			</tr>
			<tr>
				<td>Pinjam</td>
				<td>:</td>
				<td><?php echo $hdr[0]['pinjam_mulai']; ?></td>
			</tr>
			<tr>
				<td>Sampai</td>
				<td>:</td>
				<td><?php echo $hdr[0]['pinjam_sampai']; ?></td>
			</tr>
			<tr>
				<td>Keterangan</td>
				<td>:</td>
				<td colspan="5"><?php echo $hdr[0]['keterangan']; ?></td>
			</tr>
	  	</tbody>
	</table>
	<table border=1 style='font-size:12px; border-collapse:collapse;margin-left:5px;margin-top:15px; align:center;' width='100%'>
		<tr bgcolor='#9d9f9c'>
			<td style='color:white;font-family:calibri;font-size:12px;width:40px;height:15px;' align='center'>NO</td>
			<td style='color:white;font-family:calibri;font-size:12px;width:300px;' align='center'>ITEM CODE / DESCRIPTION</td>
			<td style='color:white;font-family:calibri;font-size:12px;width:80px;' align='center'>JML <br>PINJAM</td>
			<td style='color:white;font-family:calibri;font-size:12px;width:40px;' align='center'>JML <br>APPROVED</td>
		</tr>
		<?php 
			$no=1;
			foreach($items as $row): 
		?>
		<tr>
			<td align='right'><?php echo $no; ?></td>
			<td><b><?php echo $row['id_barang']; ?></b><br><?php echo $row['nama_barang']; ?></td>
			<td align='right'><?php echo $row['qty_pinjam']; ?></td>
			<td align='right'></td>
		</tr>
		<?php 
			$no++;
			endforeach; 
		?>
	</table>
	<table border="1" style='font-size:12px; border-collapse:collapse;margin-left:400px;margin-top:50px; align:center;'>
		<tr>
			<td style='font-size:12px;border-collapse:collapse;width:180px;height:0px;' align='center'><b>Requested By</b></td>
			<td rowspan=3 style='width:10px;border-top:none;border-bottom:none'></td>
			<td style='font-size:12px;border-collapse:collapse;width:180px;' align='center'><b>Yang Meminjamkan</b></td>
		</tr>
		<tr>
			<td style='height:80px;'></td>
			<td></td>
		</tr>
		<tr>
			<td style='font-size:12px;border-collapse:collapse;' align='center' valign='bottom'><b>Peminjam</b></td>
			<td style='font-size:12px;border-collapse:collapse;' align='center' valign='bottom'><b>Laboran</b></td>
		</tr>
	</table>
</div>
 
</body>
</html>
