<?php

//action.php

include('database_connection.php');

if(isset($_POST["action"]))
{
	if($_POST["action"] == "insert")
	{
		$query = "
		INSERT INTO barang (kode_barang, nama_barang, harga_beli, harga_jual) 
		VALUES ('".$_POST["kode_barang"]."','". $_POST["nama_barang"]."','". $_POST["harga_beli"]."','". $_POST["harga_jual"]."')
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		echo '<p>Barang berhasil ditamabahkan...</p>';
	}
	if($_POST["action"] == "fetch_single")
	{
		$query = "
		SELECT * FROM barang WHERE kode_barang = '".$_POST["kode_barang"]."'
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['kode_barang'] = $row['kode_barang'];
			$output['nama_barang'] = $row['nama_barang'];
			$output['harga_beli'] = $row['harga_beli'];
			$output['harga_jual'] = $row['harga_jual'];
		}
		echo json_encode($output);
	}
	if($_POST["action"] == "update")
	{
		$query = "
		UPDATE barang 
		SET kode_barang = '".$_POST["kode_barang"]."', 
		nama_barang = '".$_POST["nama_barang"]."', 
		harga_beli = '".$_POST["harga_beli"]."', 
		harga_jual = '".$_POST["harga_jual"]."' 
		WHERE kode_barang = '".$_POST["kode_barang"]."'
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		echo '<p>Barang berhasil diubah...</p>';
	}
	if($_POST["action"] == "delete")
	{
		$query = "DELETE FROM barang WHERE kode_barang = '".$_POST["kode_barang"]."'";
		$statement = $connect->prepare($query);
		$statement->execute();
		echo '<p>Barang dihapus...</p>';
	}
}

?>