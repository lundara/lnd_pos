<div class="page-content">

				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
					Produk Pit Stop <small></small>
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
						<div class="portlet box red-thunderbird">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-database"></i> Data Produk
								</div>
								<div class="tools">
									<a href="javascript:;" class="collapse">
									</a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="">
									<div class="col-md-12">
										<div class="form-group" style="float:right">
											<button class="btn green" onclick="reload()">
												<i class="fa fa-refresh fa-lg"></i> Refresh
											</button>
											<button class="btn green" data-toggle="modal" data-target="#md-add">
												<i class="fa fa-plus fa-lg"></i> Tambah
											</button>
										</div>
									</div>
									<table class="table table-striped table-bordered table-hover" id="datatable_ajax">
										<thead>
											<tr>
												<th width="5%"><center>#</center></th>
												<th width="">Nama Produk</th>
												<th width="10%">Tipe Mobil</th>
												<th width="10%">Harga Jual</th>
												<th width="10%">Harga Beli</th>
												<th width="5%">Satuan</th>
												<th width="10%">Merk</th>
												<th width="10%">Kategori</th>
												<th width="20%"><center>Action</center></th>
											</tr>
										</thead>
										<thead>
											<tr>
												<th></th>
												<th><input class="form-control" id="src_nama" placeholder="Cari Item..."></th>
												<th></th>
												<th></th>
												<th>
													
												</th>
												<th>
													<select class="form-control select2me" id="src_satuan">
														<option value="">- Cari Satuan - </option>
													</select>
												</th>
												<th>
													<select class="form-control select2me" id="src_kategori">
														<option value="">- Cari Kategori - </option>
													</select>
												</th>
												<th>
													<input class="form-control" id="src_desc" placeholder="Cari Merk...">
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
				<!-- END PAGE CONTENT-->
</div>

<div class="modal fade" id="md-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Edit Produk</h4>
			</div>
			<form method="POST" id="edit-form">
				<div class="modal-body">
					<div class="row">
						 <div class='col-md-12'>
						 	<div class="form-group">
								<label>Nama Produk </label>
								<input type="text" class="form-control inp" id="enama" autocomplete="off">
							</div>
						 </div>
						 <div class='col-md-12'>
						 	<div class="form-group">
								<label>Tipe Mobil </label>
								<input type="text" class="form-control inp" id="emobil" autocomplete="off">
							</div>
						 </div>

						 <div class='col-md-6'>
						 	<div class="form-group">
								<label>Harga Jual <span class="require"></span></label>
								<input type="text" class="form-control rupiah inp" id="ejual" autocomplete="off" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
							</div>
						 </div>
						 <div class='col-md-6'>
						 	<div class="form-group">
								<label>Harga Beli <span class="require"></span></label>
								<input type="text" class="form-control rupiah inp" id="ebeli" autocomplete="off" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
							</div>
						 </div>

						 <div class='col-md-6'>
						 	<div class="form-group">
								<label>Kategori <span class="require"></span></label>
								<select class="form-control select2me inp" id="ekategori">
									<option value=""> - Pilih Kategori -</option>
								</select>
							</div>
						 </div>
						 <div class='col-md-6'>
						 	<div class="form-group">
								<label>Satuan <span class="require"></span></label>
								<select class="form-control select2me inp" id="esatuan">
									<option value=""> - Pilih Satuan -</option>
								</select>
							</div>
						 </div>
						 <div class='col-md-6'>
						 	<div class="form-group">
								<label>Merk</label>
								<input class="form-control" type="text" id="emerk">
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
					<button type="submit" id="btn-edit" class="btn green">Simpan Perubahan</button>
					<button type="button" class="btn default" data-dismiss="modal">Batal</button>
					
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<div class="modal fade" id="md-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Tambah Produk</h4>
			</div>
			<form id="add-form">
				<div class="modal-body">
					<div class="row">
						 <div class='col-md-12'>
						 	<div class="form-group">
								<label>Nama Produk</span></label>
								<input type="text" class="form-control" id="nama" autocomplete="off">
							</div>
						 </div>
						 <div class='col-md-12'>
						 	<div class="form-group">
								<label>Tipe Mobil</span></label>
								<input type="text" class="form-control" id="mobil" autocomplete="off">
							</div>
						 </div>

						<div class='col-md-6'>
						 	<div class="form-group">
								<label>Harga Jual <span class="require"></span></label>
								<input type="text" class="form-control rupiah" id="jual" autocomplete="off" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
							</div>
						</div>
 						<div class='col-md-6'>
						 	<div class="form-group">
								<label>Harga Beli <span class="require"></span></label>
								<input type="text" class="form-control rupiah" id="beli" autocomplete="off" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
							</div>
						</div>
						 <div class='col-md-6'>
						 	<div class="form-group">
								<label>Kategori <span class="require"></span></label>
								<select class="form-control select2me" id="kategori">
									<option value=""> - Pilih Kategori -</option>
								</select>
							</div>
						 </div>
						 <div class='col-md-6'>
						 	<div class="form-group">
								<label>Satuan <span class="require"></span></label>
								<select class="form-control select2me" id="satuan">
									<option value=""> - Pilih Satuan -</option>
								</select>
							</div>
						 </div>
 						 <div class='col-md-6'>
						 	<div class="form-group">
								<label>Merk</label>
								<input class="form-control" type="text" id="merk">
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
					<button type="submit" class="btn green" id="btn-save">Simpan</button>
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
				<button type="submit" class="btn red" id="btn-del"  onclick="del()">Proses</button>
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

<input type="hidden" id="get_id">

<script>

	var table;
	
	$(document).ready(function() {

		//Select Setting
		select("satuan/select", "satuan");
		select("satuan/select", "src_satuan");
		select("satuan/select", "esatuan");

		select("pitstop/kategori/select", "kategori");
		select("pitstop/kategori/select", "src_kategori");
		select("pitstop/kategori/select", "ekategori");


		//Modal Setting
		$('#md-add').on('shown.bs.modal', function() {
		    $("#nama").focus();
		});

		$("#add-form").on("submit",(function(e){
			e.preventDefault();
			
			var nama 	= $("#nama").val();
			var jual 	= $("#jual").val().split('.').join('');
			var beli 	= $("#beli").val().split('.').join('');
			var satuan 	= $("#satuan").val();
			var merk	= $("#merk").val();
			var mobil   = $("#mobil").val();
			var kategori = $("#kategori").val();



			if (satuan !=="") {
				/*
				if (parseInt(jual) >= parseInt(beli)) {
					
				}
				else{
					notif("Error", "Harga Jual tidak boleh kurang dari Harga Beli.", "error");
				}*/
				$.ajax({
						url:"<?php echo base_url()?>produk_pitstop/tambah",
						type:"POST",
						data: {nama, jual, beli, satuan, merk, mobil, kategori},
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
									$("#merk").val("");
									$("#mobil").val("");
									$("#satuan").val("");
									$("#satuan").trigger("change");
									$("#kategori").val("");
									$("#kategori").trigger("change");

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
				notif("Error", "Lengkapi data yang wajib diisi.", "error");
			}

			
		}));

		$("#edit-form").on("submit",(function(e){
			e.preventDefault();
			
			var nama 	= $("#enama").val();
			var jual 	= $("#ejual").val().split('.').join('');
			var beli 	= $("#ebeli").val().split('.').join('');
			var satuan 	= $("#esatuan").val();
			var id   	= $("#get_id").val();
			var merk	= $("#emerk").val();
			var mobil   = $("#emobil").val();
			var kategori = $("#ekategori").val();


			if (beli && jual && satuan && id && kategori !=="") {
				$.ajax({
						url:"<?php echo base_url()?>produk_pitstop/update",
						type:"POST",
						data: {nama, jual, beli, satuan, id, merk, mobil, kategori},
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
	    //datatables
	    table = $('#datatable_ajax').DataTable({ 
	        "processing": true, //Feature control the processing indicator.
	        "serverSide": true, //Feature control DataTables' server-side processing mode.
	        "order": [[ 1, "asc" ]], //Initial no order.
	        "loadingMessage": 'Loading...',
	        "searching":false,
	        "aoColumnDefs": [
				{ "bSortable": false, "aTargets": [ 0,5,8 ] }
			],
			"oLanguage": {sProcessing: "<i class='fa fa-spinner fa-pulse fa-lg'></i> Loading..."},
	 		
	        // Load data for the table's content from an Ajax source
	        "ajax": {
	            "url": "<?php echo site_url('produk_pitstop/data')?>",
	            "type": "POST",
	            "data":function ( d ) {
	                  return $.extend( {}, d, {
	                  		"src_nama": $('#src_nama').val(),
	                  		"src_satuan": $('#src_satuan').val(),
	                  		"src_desc":$("#src_desc").val()
	                  	})
	            },
	            "complete":function(){
	            	$(".act").on("show.bs.dropdown", function(event){
				        
				        var $btnDropDown = $(this).find(".dropdown-toggle");
					    var $listHolder = $(this).find(".dropdown-menu");
					    //reset position property for DD container
					    $(this).css("position", "static");

					    var n = $btnDropDown.outerHeight(true) *5;
					    if ($btnDropDown.offset().left >= 870) {//1024
					    	var left = $btnDropDown.offset().left - 210;
					    	var top = $btnDropDown.offset().top - 160;
					    }
					    else if(parseInt($btnDropDown.offset().left) >= 620 && parseInt($btnDropDown.offset().left)<870){
					    	var left = $btnDropDown.offset().left-210;
					    	var top = $btnDropDown.offset().top - 160;
					    }
					    else{
					    	var left = $btnDropDown.offset().left-20;
					    	var top = $btnDropDown.offset().top - 220;
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

		
	function reload(){
		$("#src_nama").val("");
		$("#src_desc").val("");
		$("#src_satuan").val("");
		$("#src_satuan").trigger("change");

		table.draw();
	}
	function kartu_stok(id, nm){
		$("#lp").html(nm);
		$.ajax({
			url:"<?php echo base_url()?>produk_pitstop/kartu_stok",
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
			url:"<?php echo base_url()?>produk_pitstop/edit",
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
				$("#emerk").val(data[0].merk);
				$("#emobil").val(data[0].type_mobil);
				$("#esatuan").val(data[0].idsatuan);
				$("#esatuan").trigger("change");
				$("#ekategori").val(data[0].idkategori);
				$("#ekategori").trigger("change");
			},
			complete:function(){
				$(".inp").removeAttr("disabled");
			}
		 });
	}


	function del(){
		var id = $("#get_id").val();
		$.ajax({
			url:"<?php echo base_url()?>produk_pitstop/hapus",
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