<div class="page-content">

				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
					Menu <small></small>
				</h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-bars"></i>
							<a href="javascript:;">Menu</a>
						</li>
					</ul>
					
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row">
					<div class="col-md-12">
						<div class="portlet box blue">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-database"></i> Data Menu
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
												<th width="10%">Icon</th>
												<th>Nama Menu</th>
												<th>File</th>
												<th>Modul</th>
												<th>Aktif</th>
												<th width="20%"><center>Action</center></th>
											</tr>
										</thead>
										<thead>
											<tr>
												<th></th>
												<th></th>
												<th><input class="form-control" id="src_nama" placeholder="Cari Menu..."></th>
												<th></th>
												<th>
													<select id="src_modul" class="form-control select2me">
														<option value="">- Cari Modul - </option>
													</select>
												</th>
												<th></th>
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
				<h4 class="modal-title">Edit Menu</h4>
			</div>
			<form method="POST" id="edit-form">
				<div class="modal-body">
					<div class="row">
						 <div class="col-md-12">
						 	<div class="form-group">
								<label>Nama Modul</label>
								<input type="text" class="form-control inp" id="enama" autocomplete="off">
							</div>
						 </div>
						 <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
						 	<div class="form-group">
								<label>File</label>
								<input type="text" class="form-control inp" id="efile" autocomplete="off">
							</div>
						 </div>
						 <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
						 	<div class="form-group">
								<label>Icon</label>
								<input type="text" class="form-control inp" id="eicon" autocomplete="off">
							</div>
						 </div>
						 <div class="col-md-6 col-sm-12 col-xs-12">
						 	<div class="form-group">
								<label>Modul</label>
								<select class="select2me form-control" id="emodul">
									<option value="" >- Pilih Modul -</option>
								</select>
							</div>
						 </div>
						 <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
						 	<div class="form-group">
								<label>Aktif</label>
								<input type="text" class="form-control inp" id="eaktif" autocomplete="off">
							</div>
						 </div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn default" data-dismiss="modal">Batal</button>
					<button type="submit" id="btn-edit" class="btn green">Simpan Perubahan</button>
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
				<h4 class="modal-title">Tambah Menu</h4>
			</div>
			<form id="add-form">
				<div class="modal-body">
					 <div class="row">
					 	<div class="col-md-12 col-sm-12 col-xs-12">
						 	<div class="form-group">
								<label>Nama Menu</label>
								<input type="text" class="form-control" id="nama" autocomplete="off">
							</div>
						 </div>

						<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
						 	<div class="form-group">
								<label>File</label>
								<input type="text" class="form-control" id="file" autocomplete="off">
							</div>
						 </div>
						 <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
						 	<div class="form-group">
								<label>Icon</label>
								<input type="text" class="form-control" id="icon" autocomplete="off">
							</div>
						 </div>

						 <div class="col-md-6 col-sm-12 col-xs-12">
						 	<div class="form-group">
								<label>Modul</label>
								<select class="select2me form-control" id="modul">
									<option value="" >- Pilih Modul -</option>
								</select>
							</div>
						 </div>
						 <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
						 	<div class="form-group">
								<label>Aktif</label>
								<input type="text" class="form-control inp" id="aktif" autocomplete="off">
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
				<h4 class="modal-title">Hapus Menu</h4>
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

<input type="hidden" id="get_id">

<script>

	


	var table;
	 
	$(document).ready(function() {
		select("modul/select", "modul");
		select("modul/select", "emodul");
		select("modul/select", "src_modul");
		//Modal Setting
		$('#md-add').on('shown.bs.modal', function() {
		    $("#nama").focus();
		});

		$("#add-form").on("submit",(function(e){
			e.preventDefault();
			
			var nama = $("#nama").val();
			var modul = $("#modul").val();
			var file = $("#file").val();
			var icon = $("#icon").val();
			var aktif = $("#aktif").val();

			if (nama!=="") {
				$.ajax({
					url:"<?php echo base_url()?>menu/tambah",
					type:"POST",
					data: {nama, modul, file, icon, aktif},
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
								$("#icon").val("");
								$("#modul").val("");
								$("#modul").trigger("change");
								$("#file").val("");
								$("#aktif").val("");
								table.draw();
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
				notif("Error", "Tidak boleh kosong.", "error");
			}

			
		}));

		$("#edit-form").on("submit",(function(e){
			e.preventDefault();
			
			var nama = $("#enama").val();
			var id   = $("#get_id").val();
			var file = $("#efile").val();
			var modul = $("#emodul").val();
			var icon = $("#eicon").val();
			var aktif = $("#eaktif").val();

			if (nama!=="") {
				$.ajax({
					url:"<?php echo base_url()?>menu/update",
					type:"POST",
					data: {nama, id, file, modul, icon, aktif},
					daraType:"json",
					cache:false,
					beforeSend:function(){
						$("#btn-edit").attr("disabled", "disabled");
						$("#btn-edit").html(loading_event());
					},
					success:function(data){
						switch(parseFloat(data)){
							case 1:
								$("#enama").val("");
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
						$("#btn-edit").html("Simpan Perubahan");
					}
				 });	
			}
			else{
				notif("Error", "Tidak boleh kosong.", "error");
			}

			
		}));

		$("#src_nama").keypress(function(e) {
	      if(e.which == 13) {
	        table.draw();
	      }
	    });

	    $("#src_modul").change(function(){
	    	table.draw();
	    });
	    //datatables
	    table = $('#datatable_ajax').DataTable({ 
	        "processing": true, //Feature control the processing indicator.
	        "serverSide": true, //Feature control DataTables' server-side processing mode.
	        "order": [[ 2, "asc" ]], //Initial no order.
	        "loadingMessage": 'Loading...',
	        "searching":false,
	        "aoColumnDefs": [
				{ "bSortable": false, "aTargets": [ 0,3,1 ] }
			],
			"oLanguage": {sProcessing: "<i class='fa fa-spinner fa-pulse fa-lg'></i> Loading..."},
	 		
	        // Load data for the table's content from an Ajax source
	        "ajax": {
	            "url": "<?php echo site_url('menu/data')?>",
	            "type": "POST",
	            "data":function ( d ) {
	                  return $.extend( {}, d, {
	                  		"src_nama": $('#src_nama').val(),
	                  		"src_modul": $("#src_modul").val()
	                  	})
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

		$("#src_modul").val("");
		$("#src_modul").trigger("change");

		table.draw();
	}

	function edit(id){
		getId(id);
		$.ajax({
			url:"<?php echo base_url()?>menu/edit",
			type:"POST",
			data: {id},
			daraType:"json",
			cache:false,
			beforeSend:function(){
				$(".inp").attr("disabled", "disabled");
			},
			success:function(data){
				$("#enama").val(data[0].nama_menu);
				$("#emodul").val(data[0].idmodul);
				$("#emodul").trigger("change");
				$("#eicon").val(data[0].icon);
				$("#efile").val(data[0].file);
				$("#eaktif").val(data[0].aktif);
			},
			complete:function(){
				$(".inp").removeAttr("disabled");
			}
		 });
	}

	function del(){
		var id = $("#get_id").val();
		$.ajax({
			url:"<?php echo base_url()?>menu/hapus",
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
				$("#btn-del").html("Simpan");
			}
		 });
	}

	function getId(id){
		$("#get_id").val(id);
	}

</script>