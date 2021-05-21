<html>  
    <head>  
        <title>Database Gudang</title>  
		<link rel="stylesheet" href="jquery-ui.css">
        <link rel="stylesheet" href="bootstrap.min.css" />
		<script src="jquery.min.js"></script>  
		<script src="jquery-ui.js"></script>
    </head>  
    <body>  
        <div class="container">
			<br />
			
			<h3 align="center">Daftar Barang</a></h3><br />
			<br />
			<div align="right" style="margin-bottom:5px;">
			<button type="button" name="add" id="add" class="btn btn-success btn-xs">Tambah</button>
			</div>
			<div class="table-responsive" id="user_data">
				
			</div>
			<br />
		</div>
		
		<div id="user_dialog" title="Tambah Barang">
			<form method="post" id="user_form">
				<div class="form-group">
					<label>Nama Barang</label>
					<input type="text" name="nama_barang" id="nama_barang" class="form-control" />
					<span id="error_nama_barang" class="text-danger"></span>
				</div>
				<div class="form-group">
					<label>Kode Barang</label>
					<input type="text" name="kode_barang" id="kode_barang" class="form-control" />
					<span id="error_kode_barang" class="text-danger"></span>
				</div>
				<div class="form-group">
					<label>Harga Beli</label>
					<input type="text" name="harga_beli" id="harga_beli" class="form-control" />
					<span id="error_harga_beli" class="text-danger"></span>
				</div>
				<div class="form-group">
					<label>Harga Jual</label>
					<input type="text" name="harga_jual" id="harga_jual" class="form-control" />
					<span id="error_harga_jual" class="text-danger"></span>
				</div>
				<div class="form-group">
					<input type="hidden" name="action" id="action" value="insert" />
					<input type="hidden" name="ini_kode_barang" id="ini_kode_barang" />
					<input type="submit" name="form_action" id="form_action" class="btn btn-info" value="Insert" />
				</div>
			</form>
		</div>
		
		<div id="action_alert" title="Action">
			
		</div>
		
		<div id="delete_confirmation" title="Confirmation">
		<p>apakah anda ingin menghapus barang ini?</p>
		</div>
		
    </body>  
</html>  




<script>  
$(document).ready(function(){  

	load_data();
    
	function load_data()
	{
		$.ajax({
			url:"fetch.php",
			method:"POST",
			success:function(data)
			{
				$('#user_data').html(data);
			}
		});
	}
	
	$("#user_dialog").dialog({
		autoOpen:false,
		width:400
	});
	
	$('#add').click(function(){
		$('#user_dialog').attr('title', 'Tambah Barang');
		$('#action').val('insert');
		$('#form_action').val('Insert');
		$('#user_form')[0].reset();
		$('#form_action').attr('disabled', false);
		$("#user_dialog").dialog('open');
	});
	
	$('#user_form').on('submit', function(event){
		event.preventDefault();
		var error_nama_barang = '';
		var error_kode_barang = '';
		var error_harga_beli = '';
		var error_harga_jual = '';
		if($('#nama_barang').val() == ''){
			error_nama_barang = 'Nama Barang harus diisi';
			$('#error_nama_barang').text(error_nama_barang);
			$('#nama_barang').css('border-color', '#cc0000');
		}
		else{
			error_nama_barang = '';
			$('#error_nama_barang').text(error_nama_barang);
			$('#nama_barang').css('border-color', '');
		}
		if($('#kode_barang').val() == ''){
			error_kode_barang = 'Kode Barang harus diisi';
			$('#error_kode_barang').text(error_kode_barang);
			$('#kode_barang').css('border-color', '#cc0000');
		}
		else{
			error_kode_barang = '';
			$('#error_kode_barang').text(error_kode_barang);
			$('#kode_barang').css('border-color', '');
		}
		if($('#harga_beli').val() == ''){
			error_harga_beli = 'Harga Beli barang harus diisi';
			$('#error_harga_beli').text(error_harga_beli);
			$('#harga_beli').css('border-color', '#cc0000');
		}
		else{
			error_harga_beli = '';
			$('#error_harga_beli').text(error_harga_beli);
			$('#harga_beli').css('border-color', '');
		}
		if($('#harga_jual').val() == ''){
			error_harga_jual = 'Harga Jual barang harus diisi';
			$('#error_harga_jual').text(error_harga_jual);
			$('#harga_jual').css('border-color', '#cc0000');
		}
		else{
			error_harga_jual = '';
			$('#error_harga_jual').text(error_harga_jual);
			$('#harga_jual').css('border-color', '');
		}
		
		if(error_nama_barang != '' || error_kode_barang != '' || error_harga_beli !='' || error_harga_jual !=''){
			return false;
		}
		else
		{
			$('#form_action').attr('disabled', 'disabled');
			var form_data = $(this).serialize();
			$.ajax({
				url:"action.php",
				method:"POST",
				data:form_data,
				success:function(data)
				{
					$('#user_dialog').dialog('close');
					$('#action_alert').html(data);
					$('#action_alert').dialog('open');
					load_data();
					$('#form_action').attr('disabled', false);
				}
			});
		}
		
	});
	
	$('#action_alert').dialog({
		autoOpen:false
	});
	
	$(document).on('click', '.edit', function(){
		var kode_barang = $(this).attr('kode_barang');
		var action = 'fetch_single';
		$.ajax({
			url:"action.php",
			method:"POST",
			data:{kode_barang:kode_barang, action:action},
			dataType:"json",
			success:function(data)
			{
				$('#kode_barang').val(data.kode_barang);
				$('#nama_barang').val(data.nama_barang);
				$('#harga_beli').val(data.harga_beli);
				$('#harga_jual').val(data.harga_jual);
				$('#user_dialog').attr('title', 'Edit Data');
				$('#action').val('update');
				$('#ini_kode_barang').val(kode_barang);
				$('#form_action').val('Update');
				$('#user_dialog').dialog('open');
			}
		});
	});
	
	$('#delete_confirmation').dialog({
		autoOpen:false,
		modal: true,
		buttons:{
			Ok : function(){
				var kode_barang = $(this).data('kode_barang');
				var action = 'delete';
				$.ajax({
					url:"action.php",
					method:"POST",
					data:{kode_barang:kode_barang, action:action},
					success:function(data)
					{
						$('#delete_confirmation').dialog('close');
						$('#action_alert').html(data);
						$('#action_alert').dialog('open');
						load_data();
					}
				});
			},
			Cancel : function(){
				$(this).dialog('close');
			}
		}	
	});
	
	$(document).on('click', '.delete', function(){
		var kode_barang = $(this).attr("kode_barang");
		$('#delete_confirmation').data('kode_barang', kode_barang).dialog('open');
	});
	
});  
</script>