<div class="page-content">

				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
					Rumus <small></small>
				</h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="javascript:;">Rumus</a>
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
									<i class="fa fa-database"></i> Data Rumus
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
												<th>Transaksi</th>
												<th>Kel. Harga</th>
												<th>Rumus</th>
												<th width="20%"><center>Action</center></th>
											</tr>
										</thead>
										<thead>
											<tr>
												<th></th>
												<th>
													<select class="form-control select2me" id="src_nama">
														<option value="">- Cari Transaksi -</option>
														<option value="Bebas">Bebas</option>
														<option value="Dispensing Cash">Dispensing Cash</option>
														<option value="Dispensing Kredit">Dispensing Kredit</option>
														<option value="Dispensing Kirim">Dispensing Kirim</option>
														<option value="Resep">Resep</option>
													</select>
												</th>
												<th>
													<select class="form-control select2me" id="src_hrg">
														<option value="">- Cari Kel. Harga -</option>
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
				<h4 class="modal-title">Edit Cabang</h4>
			</div>
			<form method="POST" id="edit-form">
				<div class="modal-body">
					
						 <div class="row">
						 	<div class="col-md-6 col-sm-12">
						 		<div class="form-group">
							 		<label>Transaksi</label>
							 		<select class="form-control select2me inp" id="etrans">
										<option value="">- Pilih -</option>
										<option value="Bebas">Bebas</option>
										<option value="Dispensing Cash">Dispensing Cash</option>
										<option value="Dispensing Kredit">Dispensing Kredit</option>
										<option value="Dispensing Kirim">Dispensing Kirim</option>
										<option value="Resep">Resep</option>
									</select>
								</div>
						 	</div>
						 	<div class="col-md-6 col-sm-12">
							 	<div class="form-group">
									<label>Kel. Harga</label>
									<select class="form-control select2me inp" id="ekelhar">
										<option value="">- Pilih -</option>
									</select>
								</div>
							 </div>
							 <div class="col-md-12 col-sm-12">
							 	<div class="form-group">
									<label>Rumus</label>
									<input class="form-control" type="text" id="erumus" autocomplete="off">

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
				<h4 class="modal-title">Tambah Rumus</h4>
			</div>
			<form id="add-form">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<a href="javascript:;" class="tooltips" ata-placement='top' data-original-title="[modal] => Modal, [disp] => H.Disp, ">
								<i class="fa fa-info-circle" style="font-size: 20px"></i>
							</a>
						</div>
						<div class="col-md-6 col-sm-12">
						 	<div class="form-group">
								<label>Transaksi</label>
								<select class="form-control select2me" id="trans">
									<option value="">- Pilih -</option>
									<option value="Bebas">Bebas</option>
									<option value="Dispensing Cash">Dispensing Cash</option>
									<option value="Dispensing Kredit">Dispensing Kredit</option>
									<option value="Dispensing Kirim">Dispensing Kirim</option>
									<option value="Resep">Resep</option>
								</select>
							</div>
						 </div>

						  <div class="col-md-6 col-sm-12">
						 	<div class="form-group">
								<label>Kel. Harga</label>
								<select class="form-control select2me" id="kelhar">
									<option value="">- Pilih -</option>
								</select>
							</div>
						 </div>

						  <div class="col-md-12 col-sm-12">
						 	<div class="form-group">
								<label>Rumus</label>
								<input class="form-control" type="text" id="rumus" autocomplete="off">

							</div>
						 </div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn default" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn green" id="btn-save">Simpan</button>
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
				<h4 class="modal-title">Hapus Cabang</h4>
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
<input type="hidden" id="idcabang">
<script>

	var table;
	 
	$(document).ready(function() {
		select("kelompok_harga/select", "kelhar");
		select("kelompok_harga/select", "ekelhar");
		select("kelompok_harga/select", "src_hrg");

		//Modal Setting
		$('#md-add').on('shown.bs.modal', function() {
		    $("#nama").focus();
		});

		$("#add-form").on("submit",(function(e){
			e.preventDefault();
			
			var trans 	= $("#trans").val();
			var kelhar 	= $("#kelhar").val();
			var rumus 	= $("#rumus").val();
			if (trans && kelhar && rumus !=="") {
				$.ajax({
					url:"<?php echo base_url()?>rumus/tambah",
					type:"POST",
					data: {trans, kelhar, rumus},
					daraType:"json",
					cache:false,
					beforeSend:function(){
						$("#btn-save").attr("disabled", "disabled");
						$("#btn-save").html(loading_event());
					},
					success:function(data){

						if (parseInt(data) == 1) {
							$("#trans").val("");
							$("#trans").trigger("change");
							$("#kelhar").val("");
							$("#kelhar").trigger("change");
							$("#rumus").val("");
							table.draw();
							$("#md-add").modal("toggle");
							notif("Success", "Data berhasil disimpan.", "success");
						}
						else{
							notif("Error", "Data gagal disimpan.", "error");
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
			
			var trans 	= $("#etrans").val();
			var kelhar 	= $("#ekelhar").val();
			var rumus 	= $("#erumus").val();

			var id   = $("#get_id").val();
			if (trans && kelhar && rumus !=="") {
				$.ajax({
					url:"<?php echo base_url()?>rumus/update",
					type:"POST",
					data: {trans, kelhar, rumus, id},
					daraType:"json",
					cache:false,
					beforeSend:function(){
						$("#btn-edit").attr("disabled", "disabled");
						$("#btn-edit").html(loading_event());
					},
					success:function(data){
						switch(parseFloat(data)){
							case 1:
								table.draw();
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
			}
			else{
				notif("Error", "Tidak boleh kosong.", "error");
			}

			
		}));

		$("#src_nama").change(function(e) {
	      table.draw();
	    });
	    $("#src_hrg").change(function(e) {
	      table.draw();
	    });
	    $("#src_kode").keypress(function(e) {
	      if(e.which == 13) {
	        table.draw();
	      }
	    });
	    //datatables
	    table = $('#datatable_ajax').DataTable({ 
	        "processing": true, //Feature control the processing indicator.
	        "serverSide": true, //Feature control DataTables' server-side processing mode.
	        "order": [[ 1, "asc" ]], //Initial no order.
	        "loadingMessage": 'Loading...',
	        "searching":false,
	        "aoColumnDefs": [
				{ "bSortable": false, "aTargets": [ 0,3,4 ] }
			],
			"oLanguage": {sProcessing: "<i class='fa fa-spinner fa-pulse fa-lg'></i> Loading..."},
	 		
	        // Load data for the table's content from an Ajax source
	        "ajax": {
	            "url": "<?php echo site_url('rumus/data')?>",
	            "type": "POST",
	            "data":function ( d ) {
	                  return $.extend( {}, d, {
	                  		"src_nama": $('#src_nama').val(),
	                  		"src_hrg": $('#src_hrg').val()
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
		$("#src_nama").trigger("change");
		$("#src_hrg").val("");
		$("#src_hrg").trigger("change");
		table.draw();
	}

	function edit(id){
		getId(id);
		$.ajax({
			url:"<?php echo base_url()?>rumus/edit",
			type:"POST",
			data: {id},
			daraType:"json",
			cache:false,
			beforeSend:function(){
				$(".inp").attr("disabled", "disabled");
			},
			success:function(data){
				$("#etrans").val(data[0].transaksi);
				$("#etrans").trigger("change");
				$("#ekelhar").val(data[0].idkelhar);
				$("#ekelhar").trigger("change");
				$("#erumus").val(data[0].rumus);
			},
			complete:function(){
				$(".inp").removeAttr("disabled");
			}
		 });
	}

	function del(){
		var id = $("#get_id").val();
		$.ajax({
			url:"<?php echo base_url()?>rumus/hapus",
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
						table.draw();
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