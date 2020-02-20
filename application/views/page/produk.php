

<script src="<?php echo base_url() ?>assets/global/plugins/dropzone/dropzone.js"></script>
<style type="text/css">
	.dropzone{
		min-height: 200px;
		text-align: center;
	}
	.produk-img{
		width: 50px;
	    height: 50px;
	    overflow: hidden;
	    border-radius: 2px;
	    /*background-color: #f2f2f2;*/
	    display: inline-block;
	    margin: 0 10px;
	    vertical-align: middle;
	}
	.label-info{
		background-color:#D61C62 !important; 
	}
</style>

<?php  
	
	$sel_outlet = "";
	foreach ($outlet as $voutlet) {
		$sel_outlet .= "<option value='".$voutlet->id."'>".$voutlet->nama_outlet."</option>";
	}

?>

<div class="page-content">

				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
					Produk<small></small>
				</h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-cubes"></i>
							<a href="javascript:;">Produk</a>
						</li>
					</ul>
					
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row">
					<div class="col-md-12">
						<div class="portlet box main">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-database f-white"></i> Data Produk
								</div>
								<div class="tools">
									<a href="javascript:;" class="collapse">
									</a>
								</div>
							</div>
							<div class="portlet-body">

								<div class="row">
									<div class="col-md-12">
										<div class="form-group" style="float:right">
											
											<button class="btn main" onclick="reload()">
												<i class="fa fa-refresh fa-lg"></i> Refresh
											</button>
											<!--
											<button class="btn main" data-toggle="modal" data-target="#md-variant">
												<i class="fa fa-yelp fa-lg"></i> Tambah Varian
											</button>-->
											<button class="btn main" data-toggle="modal" data-target="#md-add">
												<i class="fa fa-plus fa-lg"></i> Tambah
											</button>
										</div>
									</div>
									<div class="col-md-12">
										<table class="table table-bordered" id="datatable_ajax">
											<thead>
												<tr>
													<th width="5%"><center>#</center></th>
													<th width="">Nama Produk</th>
													<th width="10%">Harga Jual</th>
													<th width="10%">Harga Beli</th>
													<th width="5%">Satuan</th>
													<th width="5%">Status</th>
													<th width="20%"><center>Action</center></th>
												</tr>
											</thead>
											<thead>
												<tr>
													<th></th>
													<th><input class="form-control" id="src_nama" placeholder="Cari Produk/Barcode..."></th>
													<th></th>
													<th></th>
													<th>
														<select class="form-control select2me" id="src_satuan">
															<option value="">- Cari Satuan - </option>
														</select>
													</th>
													<th>
														<select class="form-control select2me" id="src_status">
															<option value="">- Pilih Status - </option>
															<option value="1">Aktif</option>
															<option value="0">Nonaktif</option>
														</select>
													</th>
													<th></th>
												</tr>
											</thead>
										<tbody>
											
										</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
				<!-- END PAGE CONTENT-->
</div>

<div class="modal fade" id="md-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-big">
		<div class="modal-content modal-content-big">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Edit Produk</h4>
			</div>
			<form method="POST" id="edit-form">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Nama Produk <span class="require"></span></label>
								<input type="text" class="form-control inp" id="enama" autocomplete="off">
							</div>
							<div class="form-group" style="display: none;">
								<label>Harga <span class="require"></span></label>
								<input type="hidden" class="form-control rupiah inp" id="ejual" autocomplete="off">
							</div>
							<div class="form-group" style="display: none;">
								<label>Modal <span class="require"></span></label>
								<input type="hidden" class="form-control rupiah inp" id="ebeli" autocomplete="off">
							</div>
							<div class="form-group">
								<label>Satuan <span class="require"></span></label>
								<select class="form-control select2me inp" id="esatuan">
									<option value=""> - Pilih Satuan -</option>
								</select>
							</div>
							<div class="form-group">
								<label>Barcode</label>
								<input type="text" class="form-control inp" id="ebarcode" autocomplete="off">
							</div>
						</div>

						<div class='col-md-6'>
						 	
							<style type="text/css">
								.w-jenis{
								    border-radius: 5px !important;
									min-height: 150px;
									display: block;
									padding: 10px;
									box-shadow: 0 2px 11px 0 rgba(0,0,0,.06) !important;
									cursor: pointer;
								}
							</style>
							<div class="form-group">
								<label>Jenis Produk</label>
								<div class="row">
									<div class="col-md-6">
										<div class="w-jenis" style="background: #D61C62;" id="etunggal" val="tunggal">
											<center style="color:white" id="etunggal-text">
												<i class="fa fa-gift" style="font-size: 4em;margin-top:30px"></i><br>
												TUNGGAL<br>
												Produk tidak memiliki bahan baku.<br>
												Contoh : Buah Jeruk
											</center>
										</div>
									</div>
									<div class="col-md-6">
										<div class="w-jenis" id="ekomposit" val="komposit">
											<center id="ekomposit-text">
												<i class="fa fa-cutlery" style="font-size: 4em;margin-top:30px"></i><br>
												KOMPOSIT<br>
												Produk memiliki bahan baku.<br>
												Contoh : Donat, bahan baku : Tepung 100g dan Telur 2 butir
											</center>
										</div>
									</div>
								</div>
								<br>
								<input type="hidden" id="evjenis" value="Tunggal">
							   	<div class="form-group">
									<label>Deskripsi Produk</label>
									<textarea class="form-control" id="edeskripsi" style="height: 200px;resize: none;"></textarea>
								</div>
								
							</div>
						</div>

						 <div class="col-md-12">
						 	<div class="form-group">
						 		<div class="alert alert-info"><span class="require"></span> = Wajib diisi</div>
						 	</div>
						 </div>
					</div>
					
				</div>
				<div class="modal-footer">
					<button type="submit" id="btn-edit" class="btn main">Simpan Perubahan</button>
					<button type="button" class="btn default" data-dismiss="modal">Batal</button>
					
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<div class="modal fade" id="md-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-big">
		<div class="modal-content modal-content-big">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Tambah Produk</h4>
			</div>
			<form id="add-form">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Gambar Produk</label>
								<div class="dropzone" id="lnd_dropzone">
								</div>
							</div>
							<div class="form-group">
								<label>Nama Produk <span class="require"></span></label>
								<input type="text" class="form-control" id="nama" autocomplete="off">
							</div>
							<div class="form-group">
								<label>Harga <span class="require"></span></label>
								<input type="text" class="form-control rupiah" id="jual" autocomplete="off">
							</div>
							<div class="form-group">
								<label>Modal <span class="require"></span></label>
								<input type="text" class="form-control rupiah" id="beli" autocomplete="off">
							</div>
							
						</div>

						<div class='col-md-6'>
						 	<div class="form-group">
								<label>Satuan <span class="require"></span></label>
								<select class="form-control select2me" id="satuan">
									<option value=""> - Pilih Satuan -</option>
								</select>
							</div>
							<div class="form-group">
								<label>Barcode</label>
								<input type="text" class="form-control" id="barcode" autocomplete="off">
							</div>
							<style type="text/css">
								.w-jenis{
								    border-radius: 5px !important;
									min-height: 150px;
									display: block;
									padding: 10px;
									box-shadow: 0 2px 11px 0 rgba(0,0,0,.06) !important;
									cursor: pointer;
								}
							</style>
							<div class="form-group">
								<label>Jenis Produk</label>
								<div class="row">
									<div class="col-md-6">
										<div class="w-jenis" style="background: #D61C62;" id="tunggal" val="tunggal">
											<center style="color:white" id="tunggal-text">
												<i class="fa fa-gift" style="font-size: 4em;margin-top:30px"></i><br>
												TUNGGAL<br>
												Produk tidak memiliki bahan baku.<br>
												Contoh : Buah Jeruk
											</center>
										</div>
									</div>
									<div class="col-md-6">
										<div class="w-jenis" id="komposit" val="komposit">
											<center id="komposit-text">
												<i class="fa fa-cutlery" style="font-size: 4em;margin-top:30px"></i><br>
												KOMPOSIT<br>
												Produk memiliki bahan baku.<br>
												Contoh : Donat, bahan baku : Tepung 100g dan Telur 2 butir
											</center>
										</div>
									</div>
								</div>
								<input type="hidden" id="vjenis" value="Tunggal">
							</div>
						   	<div class="form-group">
								<label>Deskripsi Produk</label>
								<textarea class="form-control" id="deskripsi" style="height: 200px;resize: none;"></textarea>
							</div>
						</div>

						 <div class="col-md-12">
						 	<div class="form-group">
						 		<div class="alert alert-info"><span class="require"></span> = Wajib diisi</div>
						 	</div>
						 </div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn main" id="btn-save">Simpan</button>
					<button type="button" class="btn default" data-dismiss="modal">Batal</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<div class="modal fade" id="md-img" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Edit Gambar Produk</h4>
			</div>
			<form id="img-form">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Gambar Produk</label>
								<div class="dropzone" id="elnd_dropzone">
								</div>
							</div>
							
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn main" id="btn-eimg">Simpan</button>
					<button type="button" class="btn default" data-dismiss="modal">Batal</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<div class="modal fade" id="md-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Hapus Produk</h4>
			</div>
			<div class="modal-body">
				
				<p style="text-align: center">
					<i class="fa fa-exclamation-triangle" style="font-size: 35px;color:#C23F44" ></i>&nbsp
					<label style="font-size: 35px;"> Apa anda yakin ? </label>
				</p>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn default" data-dismiss="modal">Batal</button>
				<button type="submit" class="btn main" id="btn-del"  onclick="del()">Proses</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<div class="modal fade" id="md-aktif" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title" id="aktif-title"></h4>
			</div>
			<div class="modal-body">
				
				<p style="text-align: center">
					<i class="fa fa-exclamation-triangle" style="font-size: 35px;color:#C23F44" ></i>&nbsp
					<label style="font-size: 35px;"> Apa anda yakin ? </label>
				</p>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn default" data-dismiss="modal">Batal</button>
				<button type="submit" class="btn main" id="btn-aktif" onclick="aktif()">Proses</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<div class="modal fade" id="md-produk-varian" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Kelola Produk Varian <strong id="varian_nm"></strong></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="alert alert-info">
							<strong>Info !</strong><br>
							Stok yang dimasukan akan menjadi Stok Awal dan tidak bisa di Edit kembali.
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 col-sm-12">
						<div class="form-group">
							<label>Varian<span class="require"></span></label>
							<input class="form-control" id="varian" style="text-transform: uppercase;">
						</div>
						<input type="hidden" id="var_id">
					</div>
					<div class="col-md-6 col-sm-12">
						<div class="form-group">
							<label>Stok<span class="require"></span></label>
							<input class="form-control rupiah" id="varian_qty" value="0">
						</div>
					</div>
					<div class="col-md-6 col-sm-12">
						<div class="form-group">
							<label></label>
							<input class="form-control rupiah" id="varian_modal" type="hidden">
						</div>
					</div>
					<div class="col-md-6 col-sm-12">
						<div class="form-group">
							<label></label>
							<input class="form-control rupiah" id="varian_harga" type="hidden">
						</div>
					</div>
					<div class="col-md-12 col-sm-12">
						<div class="form-group">
							<button type="submit" class="btn main" id="btn-variant2" onclick="vproduk_add()" style="width: 100%">Simpan</button>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-default" id="btn-btl-varian" onclick="vproduk_cnc()" style="width: 100%;display: none">Batal</button>
						</div>
					</div>

				</div>
				<hr>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<th><center>Varian</center></th>
									<th><center>Qty</center></th>
									<th><center>Action</center></th>
								</thead>
								<tbody id="dt-produk-varian">
									
								</tbody>
							</table>
						</div>
					</div>
				</div>

			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<div class="modal fade" id="md-variant" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Kelola Varian </h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-5">
						<div class="form-group">
							<label>Varian Group <span class="require"></span></label>
							<input type="text" class="form-control" id="varian_title" placeholder="Contoh : Ukuran">
						</div>
					</div>
					<div class="col-md-7">
						<div class="form-group">
							<label>Varian Detail <span class="require"></span></label>
							<input type="text" value="" data-role="tagsinput" class="form-control" placeholder="Contoh : M, L, XL" id="varian_detail">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<button type="submit" class="btn main" id="btn-variant" onclick="varian_add()" style="width: 100%">Simpan</button>
						</div>
						<div class="form-group" id="btn-varian-batal" style="display: none">
							<button type="submit" class="btn btn-default" onclick="cancel_edit_varian()" style="width: 100%">Batal</button>
						</div>
					</div>
					<input type="hidden" id="varian_id">
				</div>
				<hr>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th width="30%"><center>Varian Group</center></th>
										<th><center>Varian Detail</center></th>
										<th width="20%"><center>Action</center></th>
									</tr>
								</thead>
								<tbody id="dt-varian"></tbody>
							</table>
						</div>
					</div>
				</div>

			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<div class="modal fade" id="md-log" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Kartu Stok <strong id="lp"></strong></h4>
			</div>
			<div class="modal-body">
				
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover" id="datatable_ajax">
								<thead>
									<th width="15%"><center>Tanggal</center></th>
									<th width="5%"><center>Beli</center></th>
									<th width="5%"><center>Jual</center></th>
									<th width="5%"><center>Sisa</center></th>
								</thead>
								<tbody id="dt-log"></tbody>
							</table>
						</div>
					</div>
				</div>

			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<div class="modal fade" id="md-sh" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Stok & Harga <strong id="sh_nm"></strong></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-4 col-sm-12">
								<select class="select2me form-control" id="src_sh_outlet" onchange="load_sh()">
									<option value="">Semua Outlet</option>
									<?php echo $sel_outlet; ?>
								</select>
							</div>
						</div>
						<br>
						<ul class="nav nav-tabs">
						  <li class="active"><a data-toggle="tab" href="#li_stk">Stok</a></li>
						  <li><a data-toggle="tab" href="#li_hrg">Harga</a></li>
						</ul>
						<input type="hidden" id="sh_id">
						<input type="hidden" id="sh_nm2">
						<div class="tab-content">
						  <div id="li_stk" class="tab-pane fade in active">
						    <div class="table-responsive">
						    	<table class="table table-bordered">
						    		<thead>
						    			<th><center>Produk</center></th>
						    			<th><center>Outlet</center></th>
						    			<th width="30%"><center>Potong Stok</center></th>
						    			<th width="20%"><center>Minimal Stok</center></th>
						    		</thead>
						    		<tbody id="dt-stk">
						    			
						    		</tbody>
						    	</table>
						    </div>
						  </div>
						  <div id="li_hrg" class="tab-pane fade">
						    <div class="table-responsive">
						    	<table class="table table-bordered">
						    		<thead>
						    			<th><center>Produk</center></th>
						    			<th><center>Outlet</center></th>
						    			<th width="20%"><center>Modal</center></th>
						    			<th width="20%"><center>Harga</center></th>
						    		</thead>
						    		<tbody id="dt-hrg">
						    			
						    		</tbody>
						    	</table>
						    </div>
						  </div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<input type="hidden" id="get_id">

<script>





	var table;
	
	$(document).ready(function() {
	    Dropzone.autoDiscover = false;

	    var foto_upload= new Dropzone("#lnd_dropzone",{
	        url: "<?php echo base_url('produk/tambah') ?>",
	        maxFilesize: 1,
	        maxfilesexceeded:1,
	        method:"post",
	        acceptedFiles:"image/*",
	        autoProcessQueue: false,
	        paramName:"userfile",
	        dictInvalidFileType:"Type file ini tidak dizinkan",
	        addRemoveLinks:true,
	    });
	    foto_upload.on("addedfile",function(file){
	    	var len = foto_upload.files.length;
	    	if (len > 1) {
	            notif("Error", "Maksimal Hanya 1 Gambar !", "error");
	            this.removeFile(file);
	        }
	    });
	    foto_upload.on("sending",function(a,b,c){
	    	$("#btn-save").attr("disabled", "disabled");
			$("#btn-save").html(loading_event());

	        a.nama 			= $("#nama").val();
	        a.jual 			= $("#jual").val().split('.').join('');
	        a.beli 			= $("#beli").val().split('.').join('');
	        a.satuan 		= $("#satuan").val();
	        a.barcode 		= $("#barcode").val();
	        a.jenis 		= $("#vjenis").val();
	        a.deskripsi 	= $("#deskripsi").val();

	        c.append("nama",a.nama);
	        c.append("jual",a.jual);
	        c.append("beli",a.beli);
	        c.append("satuan",a.satuan);
	        c.append("barcode",a.barcode);
	        c.append("jenis",a.jenis);
	        c.append("deskripsi",a.deskripsi);
	        c.append("img","1");
	    });
	    foto_upload.on("success", function(file, response) {
	      	
	    	switch(response){
	    		case "1":
			      	foto_upload.removeFile(file);
	  	

			        $('#md-add').modal('toggle');
			        $("#tunggal").click();
					

			        $("#nama").val("");
			        //$("#barcode").val("");
			        get_barcode();
			        $("#satuan").val("");
			        $("#satuan").trigger("change");
			        $("#beli").val("");
			        $("#jual").val("");
			        $("#vjenis").val("Tunggal");
			        $("#deskripsi").val("");


			        notif("Success", "Data berhasil disimpan.", "success");

			        table.ajax.reload(false, null);
	    		break;
	    		
	    		case "0":
	    			notif("Error", "Data gagal disimpan !", "error");
	    		break;

	    		case "0.1":
	    			notif("Error", "Kode Barcode sudah ada !", "error");
	    		break;
	    	}
	    	
			$("#btn-save").removeAttr("disabled");
			$("#btn-save").html("Simpan");


	    });
	    foto_upload.on("error", function(file, error, xhr) {
	    	foto_upload.removeFile(file);
	        notif("Error", error, "error");
	    });

	    var foto_upload2= new Dropzone("#elnd_dropzone",{
	        url: "<?php echo base_url('produk/img_update') ?>",
	        maxFilesize: 1,
	        maxfilesexceeded:1,
	        method:"post",
	        acceptedFiles:"image/*",
	        autoProcessQueue: false,
	        paramName:"userfile",
	        dictInvalidFileType:"Type file ini tidak dizinkan",
	        addRemoveLinks:true,
	    });
	    foto_upload2.on("addedfile",function(file){
	    	var len = foto_upload2.files.length;
	    	if (len > 1) {
	            notif("Error", "Maksimal Hanya 1 Gambar !", "error");
	            this.removeFile(file);
	        }
	    });
	    foto_upload2.on("sending",function(a,b,c){
	    	$("#btn-eimg").attr("disabled", "disabled");
			$("#btn-eimg").html(loading_event());

	        a.id 	= $("#get_id").val();

	        c.append("id",a.id);
	    });
	    foto_upload2.on("success", function(file, response) {
	      	
	    	switch(response){
	    		case "1":
			      	foto_upload2.removeFile(file);
	  	

			        $('#md-img').modal('toggle');


			        notif("Success", "Data berhasil disimpan.", "success");

			        table.ajax.reload(false, null);
	    		break;
	    		
	    		case "0":
	    			notif("Error", "Data gagal disimpan !", "error");
	    		break;

	    	}
	    	
			$("#btn-eimg").removeAttr("disabled");
			$("#btn-eimg").html("Simpan");


	    });
	    foto_upload2.on("error", function(file, error, xhr) {
	    	foto_upload2.removeFile(file);
	        notif("Error", error, "error");
	    });


		//Select Setting
		select("satuan/select", "satuan");
		select("satuan/select", "src_satuan");
		select("satuan/select", "esatuan");

		get_barcode();


		//Modal Setting
		$('#md-add').on('shown.bs.modal', function() {
		    $("#nama").focus();
		});

		$('#md-produk-varian').on('shown.bs.modal', function() {
		    $("#varian").focus();
		    get_produk_varian();
		    $("#dt-produk-varian").html("");
		    vproduk_cnc();

		});

		$('#md-variant').on('shown.bs.modal', function() {
			data_varian();
		    $("#varian_title").focus();
		    $("#btn-varian-batal button").click();
		});

		$("#img-form").on("submit",(function(e){
			e.preventDefault();

			var l = parseInt(foto_upload2.files.length);
			if (l > 0) {
				foto_upload2.processQueue();
			}
			else{
				notif("Error", "Masukan file gambar terlebih dahulu !", "error");
			}
			
		}));
		$("#add-form").on("submit",(function(e){
			e.preventDefault();

			var l = parseInt(foto_upload.files.length);
			if (l > 0) {
				foto_upload.processQueue();
			}
			else{
				tambah();
			}
			
		}));
		$("#komposit").click(function(){
			$("#komposit").css("background", "#D61C62");
			$("#komposit-text").css("color", "white");
			$("#komposit").attr("cek", "cek");

			$("#vjenis").val("Komposit");

			$("#tunggal").css("background", "transparent");
			$("#tunggal-text").css("color", "#6c7987");
			$("#tunggal").removeAttr("cek");										
		});
		$("#tunggal").click(function(){
			$("#tunggal").css("background", "#D61C62");
			$("#tunggal-text").css("color", "white");
			$("#tunggal").attr("cek", "cek");

			$("#vjenis").val("Tunggal");


			$("#komposit").css("background", "transparent");
			$("#komposit-text").css("color", "#6c7987");
			$("#komposit").removeAttr("cek");										
		});

		$("#ekomposit").click(function(){
			$("#ekomposit").css("background", "#D61C62");
			$("#ekomposit-text").css("color", "white");
			$("#ekomposit").attr("cek", "cek");

			$("#evjenis").val("Komposit");

			$("#etunggal").css("background", "transparent");
			$("#etunggal-text").css("color", "#6c7987");
			$("#etunggal").removeAttr("cek");										
		});
		$("#etunggal").click(function(){
			$("#etunggal").css("background", "#D61C62");
			$("#etunggal-text").css("color", "white");
			$("#etunggal").attr("cek", "cek");

			$("#evjenis").val("Tunggal");


			$("#ekomposit").css("background", "transparent");
			$("#ekomposit-text").css("color", "#6c7987");
			$("#ekomposit").removeAttr("cek");										
		});
		/*
		$("#add-form").on("submit",(function(e){
			e.preventDefault();
			
			var nama 	= $("#nama").val();
			var jual 	= $("#jual").val().split('.').join('');
			var beli 	= $("#beli").val().split('.').join('');
			var satuan 	= $("#satuan").val();



			if (satuan !=="") {
				
				if (parseInt(jual) >= parseInt(beli)) {
					$.ajax({
						url:"<?php echo base_url()?>produk/tambah",
						type:"POST",
						data: {nama, jual, beli, satuan},
						daraType:"json",
						cache:false,
						beforeSend:function(){
							$("#btn-save").attr("disabled", "disabled");
							$("#btn-save").html(loading_event());
						},
						success:function(data){
							switch(parseFloat(data)){
								case 1:
									$("#nama").val("");
									$("#jual").val("");
									$("#beli").val("");
									$("#satuan").val("");
									$("#satuan").trigger("change");

									table.ajax.reload(false, null);
									notif("Success", "Data berhasil disimpan.", "success");
									$('#md-add').modal('toggle');
								break;
								case 0:
									notif("Error", "Data gagal disimpan.", "error");
								break;
							}
						},
						complete:function(){
							$("#btn-save").removeAttr("disabled");
							$("#btn-save").html("Simpan");
						}
				});
				}
				else{
					notif("Error", "Harga Jual tidak boleh kurang dari Harga Beli.", "error");
				}
				

					

				
			}
			else{
				notif("Error", "Lengkapi data yang wajib diisi.", "error");
			}

			
		}));*/

		$("#edit-form").on("submit",(function(e){
			e.preventDefault();
			
			var nama 		= $("#enama").val();
			var jual 		= $("#ejual").val().split('.').join('');
			var beli 		= $("#ebeli").val().split('.').join('');
			var satuan 		= $("#esatuan").val();
			var barcode 	= $("#ebarcode").val();
			var jenis 		= $("#evjenis").val();
			var deskripsi 	= $("#edeskripsi").val();

			var id 			= $("#get_id").val();


			if (nama !=="" && jual !=="" && beli !=="" && satuan !=="") {
				$.ajax({
						url:"<?php echo base_url()?>produk/update",
						type:"POST",
						data: {nama, jual, beli, satuan, barcode, jenis, deskripsi, id},
						daraType:"json",
						cache:false,
						beforeSend:function(){
							$("#btn-edit").attr("disabled", "disabled");
							$("#btn-edit").html(loading_event());
						},
						success:function(data){
							switch(parseFloat(data)){
								case 1:
									table.ajax.reload(null,false);
									notif("Success", "Data berhasil disimpan.", "success");
									$('#md-edit').modal('toggle');
								break;
								case 0:
									notif("Error", "Data gagal disimpan.", "error");
								break;
								case 0.1:
									notif("Error", "Kode Barcode sudah ada !", "error");
								break;
							}
						},
						complete:function(){
							$("#btn-edit").removeAttr("disabled");
							$("#btn-edit").html("Simpan");
						}
				});
				/*
				if (parseInt(jual) >= parseInt(beli)) {
					
				}
				else{
					notif("Error", "Harga Jual tidak boleh kurang dari Harga Beli.", "error");
				}*/

				
			}
			else{
				notif("Error", "Lengkapi data yang wajib diisi.", "error");
			}

			
		}));

		$("#src_nama").keypress(function(e) {
	      if(e.which == 13) {
	        table.draw();
	      }
	    });
		$("#src_desc").keypress(function(e) {
	      if(e.which == 13) {
	        table.draw();
	      }
	    });
	    $("#src_satuan").change(function(){
	     	table.draw();
	    });
	    $("#src_status").change(function(){
	     	table.draw();
	    });
	    //datatables
	    table = $('#datatable_ajax').DataTable({ 
	        "processing": true, //Feature control the processing indicator.
	        "serverSide": true, //Feature control DataTables' server-side processing mode.
	        "order": [[ 1, "asc" ]], //Initial no order.
	        "loadingMessage": 'Loading...',
	        "searching":false,
	        "aoColumnDefs": [
				{ "bSortable": false, "aTargets": [ 0,4 ] }
			],
			"oLanguage": {sProcessing: "<i class='fa fa-spinner fa-pulse fa-lg'></i> Loading..."},
	 		
	        // Load data for the table's content from an Ajax source
	        "ajax": {
	            "url": "<?php echo site_url('produk/data')?>",
	            "type": "POST",
	            "data":function ( d ) {
	                  return $.extend( {}, d, {
	                  		"src_nama": $('#src_nama').val(),
	                  		"src_satuan": $('#src_satuan').val(),
	                  		"src_desc":$("#src_desc").val(),
	                  		"src_status":$("#src_status").val()
	                  	})
	            },
	            "complete":function(){
	            	$('.lnd-tooltip').tooltip();
	            	$('.img-popup').magnificPopup({type:'image'});
	            	$(".act").on("show.bs.dropdown", function(event){
				        
				        var $btnDropDown = $(this).find(".dropdown-toggle");
					    var $listHolder = $(this).find(".dropdown-menu");
					    //reset position property for DD container
					    $(this).css("position", "static");

					    var n = $btnDropDown.outerHeight(true) *5;
					    if ($btnDropDown.offset().left >= 870) {//1024
					    	var left = $btnDropDown.offset().left - 300;
					    	var top = $btnDropDown.offset().top - 265;
					    }
					    else if(parseInt($btnDropDown.offset().left) >= 620 && parseInt($btnDropDown.offset().left)<870){
					    	var left = $btnDropDown.offset().left-110;
					    	var top = $btnDropDown.offset().top - 210;
					    }
					    else{
					    	var left = $btnDropDown.offset().left-100;
					    	var top = $btnDropDown.offset().top - 265;
					    }
					    $listHolder.css({
					      "top": top + "px",
					      "left": left + "px"
					    });
					   
					    $listHolder.data("open", true);
				    });
	            }
	        },
	        "serverSide":true,

	        //Set column definition initialisation properties.
	        "columnDefs": [
	        { 
	            "targets": [ -1 ], //last column
	            "orderable": false, //set not orderable
	        },
	        ],
	 
	    });

	});

	function edit_img(id){
		getId(id);
	}

	function get_barcode(){
		var n = "LND-"+Math.floor((Math.random() * 9999999999) + 1);
		$("#barcode").val(n);
	}


	function hapus_varian(id){
		var konfirmasi = confirm("Apakah anda yakin ?");

		if (konfirmasi === true) {
			$.ajax({
				url:"<?php echo base_url()?>produk/hapus_varian",
				type:"POST",
				dataType:"json",
				data:{id},
				cache:false,
				beforeSend:function(){
					
				},
				success:function(data){
					switch(parseFloat(data)){
						case 1:
							//table.ajax.reload(null,false);
							notif("Success", "Data berhasil dihapus.", "success");
							//$('#md-variant').modal('toggle');
							data_varian();
						break;
						case 0:
							notif("Error", "Data gagal dihapus.", "error");
						break;
					}
				},
				complete:function(){
					//$("#evarian").tagsinput();
				}
			});
		}
		else{
			return false;
		}
	}

	function vproduk_cnc() {
		$("#var_id").val("");
		$("#varian").val("");
		$("#varian_qty").val("0");
		$("#varian_qty").removeAttr("disabled");
		$("#btn-btl-varian").hide();

	}

	function vproduk_add(){
		var varian_detail 	= $("#varian").val();
		var idproduk 		= $("#get_id").val();
		var qty 			= $("#varian_qty").val();
		var modal 			= $("#varian_modal").val().split('.').join('');
		var harga 			= $("#varian_harga").val().split('.').join('');
		var arr_id 			= $("#var_id").val();

		if (varian_detail !="") {
			$.ajax({
				url:"<?php echo base_url()?>produk/vproduk_add",
				type:"POST",
				dataType:"json",
				data:{varian_detail, idproduk, qty, modal, harga, arr_id},
				cache:false,
				beforeSend:function(){
					$("#btn-variant2").attr("disabled", "disabled");
					$("#btn-variant2").html(loading_event());
				},
				success:function(data){
					switch(parseFloat(data)){
						case 1:
							notif("Success", "Data berhasil disimpan.", "success");

							$("#varian").val("");
							$("#varian_qty").val("0");
							$("#varian").focus();

							vproduk_cnc();
							get_produk_varian();
						break;
						case 0:
							notif("Error", "Data gagal disimpan.", "error");
						break;
						case 0.1:
							notif("Error", "Varian sudah ada.", "error");
						break;
					}
				},
				complete:function(){
					$("#btn-variant2").removeAttr("disabled");
					$("#btn-variant2").html("Tambahkan");
				}
			});
		}
		else{
			notif("Error", "Lengkapi semua data.", "error");
		}
	}


	function vproduk_del(id, o){
		if (id!="") {
			$.ajax({
				url:"<?php echo base_url()?>produk/vproduk_del",
				type:"POST",
				dataType:"json",
				data:{id},
				cache:false,
				beforeSend:function(){
					$("#btnv-"+o).html("<i class='fa fa-spinner fa-pulse'></i>");
					$("#btnv-"+o).attr("disabled", "disabled");
				},
				success:function(data){
					switch(parseFloat(data)){
						case 1:
							//table.ajax.reload(null,false);
							notif("Success", "Data berhasil dihapus.", "success");
							//$('#md-variant').modal('toggle');
							get_produk_varian();
						break;
						case 0:
							notif("Error", "Data gagal dihapus.", "error");
						break;
					}
				},
				complete:function(){
					$("#btnv-"+o).html("<i class='fa fa-trash'></i>");
					$("#btnv-"+o).removeAttr("disabled");
				}
			});
		}
		else{


		}
	}

	function vproduk_get(id, varian, qty){
		$("#var_id").val(id);
		$("#varian").val(varian);
		$("#varian_qty").val(qty);
		$("#varian_qty").attr("disabled", "disabled");
		$("#btn-btl-varian").show();
	}

	function get_produk_varian(){
		var id = $("#get_id").val();
		if (id!="") {
			$.ajax({
				url:"<?php echo base_url()?>produk/get_produk_varian",
				type:"POST",
				dataType:"json",
				data:{id},
				cache:false,
				beforeSend:function(){
					$("#dt-produk-varian").html("<tr><td colspan='3' align='center'>"+loading_event()+"</td></tr>");
				},
				success:function(data){
					var len = data.length;
					var dt = "";
					if (len > 0) {
						for(var i=0;i < len;i++){
							dt+="<tr>";
								dt+="<td> "+data[i].nama_produk+" - "+data[i].varian+"</td>";
								dt+="<td align='right'>"+data[i].qty+"</td>";
								dt+="<td align='center'>";
									dt+="<button class='btn main btn-sm' onclick='vproduk_get(`"+data[i].arr_id+"`, `"+data[i].varian+"`, `"+data[i].qty+"`)'><i class='fa fa-pencil'></i></button>";
									dt+="<button class='btn main btn-sm' id='btnv-"+i+"' onclick='vproduk_del(`"+data[i].arr_id+"`, `"+i+"`)'><i class='fa fa-trash'></i></button>";
								dt+="</td>";
							dt+="</tr>";
						}
					}
					else{
						dt+="<tr><td colspan='3' align='center'>Tidak ada data.</td></tr>";
					}

					$("#dt-produk-varian").html(dt);
				},
				complete:function(){
					
				}
			});
		}
		else{

		}
	}

	function sel_varian(){
		$.ajax({
			url:"<?php echo base_url()?>produk/sel_varian",
			type:"POST",
			dataType:"json",
			cache:false,
			beforeSend:function(){
				$("#varian_title2").attr("disabled", "disabled");

			},
			success:function(data){
				var len = data.length;
				var sel = "<option value=''>- Pilih Varian -</option>";

				if (len > 0) {
					for(var i=0;i < len;i++){
						sel+="<option value='"+data[i].id+"'>"+data[i].nama_varian+"</option>";
					}
				}


				$("#varian_title2").html(sel);
			},
			complete:function(){
				$("#varian_title2").removeAttr("disabled");
			}
		});
	}

	function data_varian(){
		$.ajax({
			url:"<?php echo base_url()?>produk/data_varian",
			type:"POST",
			dataType:"json",
			cache:false,
			beforeSend:function(){
				$("#dt-varian").html("<tr><td colspan='3' align='center'>"+loading_event()+"</td></tr>");
			},
			success:function(data){
				var l = data.length;


				var r = "";

				if (l > 0) {

					for(var i = 0;i < l;i++){

						r+="<tr>";
							r+="<td align='center'>"+data[i].nama_varian+"</td>";
							r+="<td align='left' style='line-height: 27px;'>";
								var g = "";
								for(var m = 0;m < data[i]['varian_detail'].length;m++){
									r+="<span class='tag label label-info' style='font-weight:600'>"+data[i]['varian_detail'][m].nama_varian_detail+"</span> ";
									g+= data[i]['varian_detail'][m].nama_varian_detail+",";
								}
							r+="</td>";
							r+="<td align='center'>";
								r+="<button class='btn btn-sm main' onclick='edit_varian(`"+data[i].id+"`, `"+g+"`, `"+data[i].nama_varian+"`)'><i class='fa fa-pencil'></i></button>";
								r+="<button class='btn btn-sm main' onclick='hapus_varian(`"+data[i].id+"`)'><i class='fa fa-trash'></i></button>";
							r+="</td>";	
						r+="</tr>";
					}

				}
				else{
					r+="<tr>";
						r+="<td colspan='3' align='center'>Tidak ada data.</td>";	
					r+="</tr>";
				}

				$("#dt-varian").html(r);
			},
			complete:function(){
				//$("#evarian").tagsinput();
			}
		});
	}

	function get_varian(id, nm, harga, modal){
		$("#get_id").val(id);
		$("#varian_nm").html(nm);
		$("#varian_harga").val(parseInt(harga).toLocaleString("de-DE"));
		$("#varian_modal").val(parseInt(modal).toLocaleString("de-DE"));
	}

	function load_sh(){
		get_sh($("#sh_id").val(), $("#sh_nm2").val());
	}

	function get_sh(id, nm){
		$("#sh_id").val(id);
		$("#sh_nm").html(nm);
		$("#sh_nm2").val(nm);

		get_stk(id);
		get_hrg(id);
	}

	function upd_hrg(id, field){
		var v = $("#"+field+"-"+id).val().split('.').join('');
		
		$.ajax({
			url:"<?php echo base_url()?>produk/upd_hrg",
			type:"POST",
			data:{id, field, v},
			dataType:"json",
			cache:false,
			beforeSend:function(){
			},
			success:function(data){

			},
			complete:function(){
			}
		});
		
	}

	function get_hrg(id){

		var src_sh_outlet = $("#src_sh_outlet").val();

		$.ajax({
			url:"<?php echo base_url()?>produk/get_stk",
			type:"POST",
			data: {id, src_sh_outlet},
			dataType:"json",
			cache:false,
			beforeSend:function(){
				$("#dt-hrg").html("<tr><td colspan='4' align='center'><i class='fa fa-spinner fa-lg fa-pulse'></i> Loading...</td></tr>");

			},
			success:function(data){

				//alert(data);
				var len = data.length;

				if (len!==0) {
					var l = "";
					
					for(var i = 0;i < len;i++){
						if (data[i].varian!==null) {
							var varian = " - "+data[i].varian;
						}
						else{
							var varian = "";
						}

						l+="<tr>";
							l+="<td align='center'>"+data[i].nama_produk+varian+"</td>";
							l+="<td align='center'>"+data[i].nama_outlet+"</td>";
							l+="<td align='center'>";
								l+="<input type='text' onchange='upd_hrg(`"+data[i].id+"`, `mdl`)' class='form-control rupiah' id='mdl-"+data[i].id+"' value='"+parseInt(data[i].modal).toLocaleString('de-DE')+"' style='text-align:right'>";
							l+="</td>";
							l+="<td align='right'>";
								l+="<input type='text' onchange='upd_hrg(`"+data[i].id+"`, `hrg`)' class='form-control rupiah' id='hrg-"+data[i].id+"' value='"+parseInt(data[i].harga).toLocaleString('de-DE')+"' style='text-align:right'>";
							l+="</td>";
						l+="</tr>";
					}
					$("#dt-hrg").html(l);

				}
				else{
					$("#dt-hrg").html("<tr><td colspan='4' align='center'>Tidak ada data.</td></tr>");
				}
			},
			complete:function(){

			}
		});
	}

	function upd_ps(id){
		var ps = $("input[name=op-ps-"+id+"]:checked").val();
		$.ajax({
			url:"<?php echo base_url()?>produk/upd_ps",
			type:"POST",
			data:{id, ps},
			dataType:"json",
			cache:false,
			beforeSend:function(){
			},
			success:function(data){

			},
			complete:function(){
			}
		});
	}

	function upd_ms(id){
		var ms = $("#ms-"+id).val();
		
		$.ajax({
			url:"<?php echo base_url()?>produk/upd_ms",
			type:"POST",
			data:{id, ms},
			dataType:"json",
			cache:false,
			beforeSend:function(){
			},
			success:function(data){

			},
			complete:function(){
			}
		});
	}

	function get_stk(id){

		var src_sh_outlet = $("#src_sh_outlet").val();

		$.ajax({
			url:"<?php echo base_url()?>produk/get_stk",
			type:"POST",
			data: {id, src_sh_outlet},
			dataType:"json",
			cache:false,
			beforeSend:function(){
				$("#dt-stk").html("<tr><td colspan='4' align='center'><i class='fa fa-spinner fa-lg fa-pulse'></i> Loading...</td></tr>");

			},
			success:function(data){

				//alert(data);
				var len = data.length;

				if (len!==0) {
					var l = "";
					
					for(var i = 0;i < len;i++){

						if (data[i].potong_stok == "1") {
							var act_1_ps = "active";
							var cek_1_ps = "checked";

							var act_0_ps = "";
							var cek_0_ps = "";
						}
						else{
							var act_1_ps = "";
							var $cek_1_ps = "";

							var act_0_ps = "active";
							var cek_0_ps = "checked";

						}
						if (data[i].varian!==null) {
							var varian = " - "+data[i].varian;
						}
						else{
							var varian = "";
						}
						l+="<tr>";
							l+="<td align='center'>"+data[i].nama_produk+varian+"</td>";
							l+="<td align='center'>"+data[i].nama_outlet+"</td>";
							l+="<td align='center'>";
					            l+="<div class='btn-group' id='status' data-toggle='buttons' >";
					              l+="<label class='btn btn-default btn-on-2 btn-sm "+act_1_ps+"' style='margin-right: 0px;'>";
					              l+="<input type='radio' value='1' name='op-ps-"+data[i].id+"' "+cek_1_ps+" onchange='upd_ps(`"+data[i].id+"`)'>ON</label>";
					              l+="<label class='btn btn-default btn-off-2 btn-sm "+act_0_ps+" '>";
					              l+="<input type='radio' value='0' name='op-ps-"+data[i].id+"' "+cek_0_ps+" onchange='upd_ps(`"+data[i].id+"`)'>OFF</label>";
					            l+="</div>";
							l+="</td>";
							l+="<td align='right'><input type='number' onchange='upd_ms(`"+data[i].id+"`)' class='form-control' id='ms-"+data[i].id+"' value='"+data[i].min_stok+"' style='text-align:right'></td>";
						l+="</tr>";
					}
					$("#dt-stk").html(l);

				}
				else{
					$("#dt-stk").html("<tr><td colspan='4' align='center'>Tidak ada data.</td></tr>");
				}
			},
			complete:function(){

			}
		});
	}

	function tambah(){
		var nama 		= $("#nama").val();
		var jual 		= $("#jual").val().split('.').join('');
		var beli 		= $("#beli").val().split('.').join('');
		var satuan 		= $("#satuan").val();
		var barcode 	= $("#barcode").val();
		var jenis 		= $("#vjenis").val();
		var deskripsi 	= $("#deskripsi").val();
		var img 		= "";

		if (nama !=="" && jual !=="" && beli !=="" && satuan !=="") {
			
			if (parseInt(jual) >= parseInt(beli)) {
				$.ajax({
					url:"<?php echo base_url()?>produk/tambah",
					type:"POST",
					data: {nama, jual, beli, satuan, barcode, jenis, deskripsi, img},
					daraType:"json",
					cache:false,
					beforeSend:function(){
						$("#btn-save").attr("disabled", "disabled");
						$("#btn-save").html(loading_event());
					},
					success:function(data){
						switch(parseFloat(data)){
							case 1:
						        $("#nama").val("");
						        //$("#barcode").val("");
						        get_barcode();
						        $("#satuan").val("");
						        $("#satuan").trigger("change");
						        $("#beli").val("");
						        $("#jual").val("");
						        $("#vjenis").val("Tunggal");
						        $("#deskripsi").val("");

								table.ajax.reload(false, null);
								notif("Success", "Data berhasil disimpan.", "success");
								$('#md-add').modal('toggle');
							break;
							case 0:
								notif("Error", "Data gagal disimpan.", "error");
							break;
							case 0.1:
								notif("Error", "Kode Barcode sudah ada !", "error");
							break;
						}
					},
					complete:function(){
						$("#btn-save").removeAttr("disabled");
						$("#btn-save").html("Simpan");
					}
			});
			}
			else{
				notif("Error", "Harga Jual tidak boleh kurang dari Harga Beli.", "error");
			}
			

				

			
		}
		else{
			notif("Error", "Lengkapi data yang wajib diisi.", "error");
		}
	}

	function get_aktif(id, title){
		$("#aktif-title").html(title);
		$("#get_id").val(id);
	}

	function varian_add(){
		var id 		= $("#varian_id").val();
		var title 	= $("#varian_title").val();
		var detail 	= $("#varian_detail").val();

		if (id == "") {
			var link_act = "tambah_varian";
		}
		else{
			var link_act = "update_varian";
		}

		if (title !="" && detail !="") {
			$.ajax({
				url:"<?php echo base_url()?>produk/"+link_act,
				type:"POST",
				data: {id, title, detail},
				dataType:"json",
				cache:false,
				beforeSend:function(){
					$("#btn-variant").attr("disabled", "disabled");
					$("#btn-variant").html(loading_event());
				},
				success:function(data){

					switch(parseFloat(data)){
						case 1:
							//table.ajax.reload(null,false);
							notif("Success", "Data berhasil disimpan.", "success");
							//$('#md-variant').modal('toggle');
							
							$('#varian_detail').tagsinput('removeAll');
							$("#varian_title").val("");
							$("#varian_id").val("");

							$("#btn-varian-batal button").click();

							data_varian();
						break;
						case 0:
							notif("Error", "Data gagal disimpan.", "error");
						break;
					}
				},
				complete:function(){
					$("#btn-variant").removeAttr("disabled");
					$("#btn-variant").html("Simpan");
				}
			});
		}
		else{
			notif("Error", "Lengkapi semua data.", "error");
		}
	}

	function aktif(){
		var id = $("#get_id").val();
		$.ajax({
			url:"<?php echo base_url()?>produk/aktif",
			type:"POST",
			data: {id},
			dataType:"json",
			cache:false,
			beforeSend:function(){
				$("#btn-aktif").attr("disabled", "disabled");
				$("#btn-aktif").html(loading_event());
			},
			success:function(data){
				switch(parseFloat(data)){
					case 1:
						table.ajax.reload(null,false);
						notif("Success", "Data berhasil diubah.", "success");
						$('#md-aktif').modal('toggle');
					break;
					case 0:
						notif("Error", "Data gagal diubah.", "error");
					break;
				}
			},
			complete:function(){
				$("#btn-aktif").removeAttr("disabled");
				$("#btn-aktif").html("Proses");
			}
		});
	}

	function reload(){
		$("#src_nama").val("");
		$("#src_desc").val("");
		$("#src_satuan").val("");
		$("#src_satuan").trigger("change");
		$("#src_status").val("");
		$("#src_status").trigger("change");

		table.draw();
	}
	function kartu_stok(id, nm){
		$("#lp").html(nm);
		$.ajax({
			url:"<?php echo base_url()?>produk/kartu_stok",
			type:"POST",
			data: {id},
			dataType:"json",
			cache:false,
			beforeSend:function(){
				$("#dt-log").html("<tr><td colspan='4x' align='center'><i class='fa fa-spinner fa-lg fa-pulse'></i> Loading...</td></tr>");
			},
			success:function(data){
				//alert(data);
				var len = data.length;

				if (len!==0) {
					var l = "";
					for(var i = 0;i < len;i++){
						l+="<tr>";
							l+="<td align='center'>"+toTgl(data[i].created_on)+"</td>";
							l+="<td align='right' class='font-red-thunderbird'>"+data[i].beli+"</td>";
							l+="<td align='right' class='font-blue'>"+data[i].jual+"</td>";
							l+="<td align='right'><strong>"+data[i].stok+"</strong></td>";
						l+="</tr>";
					}
					$("#dt-log").html(l);

				}
				else{
					$("#dt-log").html("<tr><td colspan='4' align='center'>Belum ada riwayat stok.</td></tr>");
				}
			},
			complete:function(){
			}
		 });
	}


	function edit(id){
		getId(id);
		$.ajax({
			url:"<?php echo base_url()?>produk/edit",
			type:"POST",
			data: {id},
			dataType:"json",
			cache:false,
			beforeSend:function(){
				$(".inp").attr("disabled", "disabled");
			},
			success:function(data){
				$("#enama").val(data[0].nama_produk);
				$("#ejual").val(parseInt(data[0].harga).toLocaleString("de-DE"));
				$("#ebeli").val(parseInt(data[0].modal).toLocaleString("de-DE"));
				$("#esatuan").val(data[0].idsatuan);
				$("#esatuan").trigger("change");
				$("#ebarcode").val(data[0].barcode);
				$("#edeskripsi").val(data[0].deskripsi);
				$("#evjenis").val(data[0].produk_type);

				switch(data[0].produk_type){
					case "Komposit":
						$("#ekomposit").click();
					break;
					case "Tunggal":
						$("#etunggal").click();
					break;
					default:
						$("#etunggal").click();
					break;
				}
			},
			complete:function(){
				$(".inp").removeAttr("disabled");
			}
		 });
	}


	function del(){
		var id = $("#get_id").val();
		$.ajax({
			url:"<?php echo base_url()?>produk/hapus",
			type:"POST",
			data: {id},
			daraType:"json",
			cache:false,
			beforeSend:function(){
				$("#btn-del").attr("disabled", "disabled");
				$("#btn-del").html(loading_event());
			},
			success:function(data){
				switch(parseFloat(data)){
					case 1:
						table.ajax.reload(null,false);
						notif("Success", "Data berhasil dihapus.", "success");
						$('#md-delete').modal('toggle');
					break;
					case 0:
						notif("Error", "Data gagal dihapus.", "error");
					break;
				}
			},
			complete:function(){
				$("#btn-del").removeAttr("disabled");
				$("#btn-del").html("Proses");
			}
		 });
	}

	function getId(id){
		$("#get_id").val(id);
	}

</script>