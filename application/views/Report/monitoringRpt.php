<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Monitoring</title>
</head>
<body>
 
<div id="container">
	<h3>Laporan Hasil Monitoring</h3>
	<hr>
    <table  style="font-size:14px;">
	  	<tbody>
		  	<tr>
				<td style="width:110px">Document No.</td>
				<td style="width:15px">:</td>
				<td><?php echo $hdr[0]['id_monitoring']; ?></td>
				<td style="width:200px"></td>
				<td>No Identitas</td>
				<td style="width:15px">:</td>
				<td><?php echo $hdr[0]['no_induk']; ?></td>
			</tr>
			<tr>
				<td>Created Date</td>
				<td>:</td>
				<td><?php echo $hdr[0]['tgl_monitoring']; ?></td>
				<td></td>
				<td>Nama</td>
				<td>:</td>
				<td><?php echo $hdr[0]['nama']; ?></td>
			</tr>
			<tr>
				<td style="vertical-align:top">Keterangan</td>
				<td style="vertical-align:top">:</td>
				<td colspan="5"><?php echo $hdr[0]['keterangan']; ?></td>
			</tr>
	  	</tbody>
	</table>
	<table border=1 style='font-size:12px; border-collapse:collapse;margin-left:5px;margin-top:15px; align:center;' width='100%'>
		<tr bgcolor='#9d9f9c'>
			<td style='color:white;font-family:calibri;font-size:12px;width:40px;height:15px;' align='center'>NO</td>
			<td style='color:white;font-family:calibri;font-size:12px;width:350px;' align='center'>Kode Barang / Deskripsi</td>
			<td style='color:white;font-family:calibri;font-size:12px;width:80px;' align='center'>Stok<br>Sistem</td>
			<td style='color:white;font-family:calibri;font-size:12px;width:80px;' align='center'>Stok<br>Aktual</td>
            <td style='color:white;font-family:calibri;font-size:12px;width:80px;' align='center'>Barang<br>Bagus</td>
            <td style='color:white;font-family:calibri;font-size:12px;width:80px;' align='center'>Barang<br>Jelek</td>
		</tr>
		<?php 
			$no=1;
			foreach($items as $row): 
		?>
		<tr>
			<td align='right'><?php echo $no; ?></td>
			<td><b><?php echo $row['id_barang']; ?></b><br><?php echo $row['nama_barang']; ?></td>
			<td align='right'><?php echo $row['stock_sistem']; ?></td>
			<td align='right'><?php echo $row['stock_actual']; ?></td>
            <td align='right'><?php echo $row['qty_bagus']; ?></td>
            <td align='right'><?php echo $row['qty_rusak']; ?></td>
		</tr>
		<?php 
			$no++;
			endforeach; 
		?>
	</table>
	<table border="1" style='font-size:12px; border-collapse:collapse;margin-left:400px;margin-top:50px; align:center;'>
		<tr>
			<td style='font-size:12px;border-collapse:collapse;width:180px;height:0px;' align='center'><b>Dibuat Oleh</b></td>
			<td rowspan=3 style='width:10px;border-top:none;border-bottom:none'></td>
			<td style='font-size:12px;border-collapse:collapse;width:180px;' align='center'><b>Disetujui Oleh</b></td>
		</tr>
		<tr>
			<td style='height:80px;'></td>
			<td></td>
		</tr>
		<tr>
			<td style='font-size:12px;border-collapse:collapse;' align='center' valign='bottom'><b>Laboran</b></td>
			<td style='font-size:12px;border-collapse:collapse;' align='center' valign='bottom'><b>Sarpras</b></td>
		</tr>
	</table>
</div>
 
</body>
</html>
