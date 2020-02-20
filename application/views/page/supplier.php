<div class="page-content">

				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
					Supplier <small></small>
				</h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-truck"></i>
							<a href="javascript:;">Supplier</a>
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
									<i class="fa fa-database"></i> Data Supplier
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
											<a class="btn green" href="javascirp:;" onclick="cetak()">
												<i class="fa fa-print fa-lg"></i> Print
											</a>
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
												<th>Nama Supplier</th>
												<th>Telp</th>
												<th>Email</th>
												<th>Alamat</th>
												<th width="20%"><center>Action</center></th>
											</tr>
										</thead>
										<thead>
											<tr>
												<th></th>
												<th><input class="form-control" id="src_nama" placeholder="Cari Supplier..."></th>
												<th></th>
												<th></th>
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
				<h4 class="modal-title">Edit Supplier</h4>
			</div>
			<form method="POST" id="edit-form">
				<div class="modal-body">
					
						 <div col-md-12>
						 	<div class="form-group">
								<label>Nama Supplier</label>
								<input type="text" class="form-control inp" id="enama" autocomplete="off">
							</div>
						 </div>

						 <div col-md-12>
						 	<div class="form-group">
								<label>Telp <small>(Opsional)</small></label>
								<input type="text" class="form-control inp" id="etelp" autocomplete="off">
							</div>
						 </div>

						 <div col-md-12>
						 	<div class="form-group">
								<label>Email <small>(Opsional)</small></label>
								<input type="text" class="form-control inp" id="eemail" autocomplete="off">
							</div>
						 </div>

						  <div col-md-12>
						 	<div class="form-group">
								<label>Alamat Supplier</label>
								<textarea class="form-control inp" id="ealamat" style="resize: none;height: 200px;"></textarea>
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
				<h4 class="modal-title">Tambah Supplier</h4>
			</div>
			<form id="add-form">
				<div class="modal-body">
						 <div col-md-12>
						 	<div class="form-group">
								<label>Nama Supplier</label>
								<input type="text" class="form-control inp" id="nama" autocomplete="off">
							</div>
						 </div>

						 <div col-md-12>
						 	<div class="form-group">
								<label>Telp <small>(Opsional)</small></label>
								<input type="text" class="form-control inp" id="telp" autocomplete="off">
							</div>
						 </div>

						 <div col-md-12>
						 	<div class="form-group">
								<label>Email <small>(Opsional)</small></label>
								<input type="text" class="form-control inp" id="email" autocomplete="off">
							</div>
						 </div>

						  <div col-md-12>
						 	<div class="form-group">
								<label>Alamat Supplier</label>
								<textarea class="form-control inp" id="alamat" style="resize: none;height: 200px;"></textarea>
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
				<h4 class="modal-title">Hapus Supplier</h4>
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

		//Modal Setting
		$('#md-add').on('shown.bs.modal', function() {
		    $("#nama").focus();
		});

		$("#add-form").on("submit",(function(e){
			e.preventDefault();
			
			var nama 	= $("#nama").val();
			var telp 	= $("#telp").val();
			var email 	= $("#email").val();
			var alamat 	= $("#alamat").val();
			if (nama && alamat !=="") {
				$.ajax({
					url:"<?php echo base_url()?>supplier/tambah",
					type:"POST",
					data: {nama, telp, email, alamat},
					daraType:"json",
					cache:false,
					beforeSend:function(){
						$("#btn-save").attr("disabled", "disabled");
						$("#btn-save").html(loading_event());
					},
					success:function(data){

						if (parseInt(data)==1) {
							notif("Success", "Data berhasil disimpan.", "success");
							$('#md-add').modal("toggle");
							table.draw();
								$("#nama").val("");
								$("#alamat").val("");
								$("#email").val("");
								$("#telp").val("");

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
			
			var nama 	= $("#enama").val();
			var telp 	= $("#etelp").val();
			var email 	= $("#eemail").val();
			var alamat 	= $("#ealamat").val();

			var id   = $("#get_id").val();
			if (nama && alamat !=="") {
				$.ajax({
					url:"<?php echo base_url()?>supplier/update",
					type:"POST",
					data: {nama, telp, email, alamat, id},
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
								$("#ealamat").val("");
								$("#eemail").val("");
								$("#etelp").val("");
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

		$("#src_nama").keypress(function(e) {
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
	            "url": "<?php echo site_url('supplier/data')?>",
	            "type": "POST",
	            "data":function ( d ) {
	                  return $.extend( {}, d, {
	                  		"src_nama": $('#src_nama').val()
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

	function cetak(){

		window.open('<?php echo base_url() ?>supplier/cetak', '_blank');

	}
		
	function reload(){
		$("#src_nama").val("");
		table.draw();
	}


	function edit(id){
		getId(id);
		$.ajax({
			url:"<?php echo base_url()?>supplier/edit",
			type:"POST",
			data: {id},
			daraType:"json",
			cache:false,
			beforeSend:function(){
				$(".inp").attr("disabled", "disabled");
			},
			success:function(data){
				$("#enama").val(data[0].nama_supplier);
				$("#eemail").val(data[0].email);
				$("#etelp").val(data[0].telp);
				$("#ealamat").val(data[0].alamat);
			},
			complete:function(){
				$(".inp").removeAttr("disabled");
			}
		 });
	}

	function del(){
		var id = $("#get_id").val();
		$.ajax({
			url:"<?php echo base_url()?>supplier/hapus",
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