<?php

//fetch.php

include("database_connection.php");

$query = "SELECT * FROM barang";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$total_row = $statement->rowCount();
$output = '
<table class="table table-striped table-bordered">
	<tr>
		<th>No</th>
		<th>Aksi</th>
		<th>Kode Barang</th>
		<th>Nama Barang</th>
		<th>Harga Beli</th>
		<th>Harga Jual</th>
	</tr>
';
$number = 1;

if($total_row > 0)
{
	foreach($result as $row)
	{
		$output .= '
		<tr>
			<td width="10%">'.$number.'</td>
			<td width="10%">
				<button type="button" name="edit" class="btn btn-primary btn-xs edit" kode_barang="'.$row["kode_barang"].'">Edit</button>
				<button type="button" name="delete" class="btn btn-danger btn-xs delete" kode_barang="'.$row["kode_barang"].'">Delete</button>
			</td>
			<td width="20%">'.$row["kode_barang"].'</td>
			<td width="20%">'.$row["nama_barang"].'</td>
			<td width="20%">'.$row["harga_beli"].'</td>
			<td width="20%">'.$row["harga_jual"].'</td>
		</tr>
		';
		$number = $number +1;
	}
}
else
{
	$output .= '
	<tr>
		<td colspan="4" align="center">Data tidak ada :(</td>
	</tr>
	';
}
$output .= '</table>';
echo $output;
?>