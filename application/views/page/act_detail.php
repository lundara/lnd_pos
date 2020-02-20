<?php  

	

?>


<div class="page-content">

				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
					Activity List Marketing  <small></small>
				</h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-bank"></i>
							<a href="javascript:;">Activity List Marketing</a>
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
									<i class="fa fa-database"></i> Data Activity List Marketing
								</div>
								<div class="tools">
									<a href="javascript:;" class="collapse">
									</a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="">
									<div class="col-md-12" style="<?php echo $op ?>">
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
												<th>Tanggal</th>
												<th>Hari</th>
												<th>Jam</th>
												<th>Customer</th>
												<th>PIC</th>
												<th>Phone</th>
												<th>Email</th>
												<th>Discuss</th>
												<th>Inquiry</th>
												<th>Qty</th>
												<th>Description</th>
												<th>PO Customer</th>
											</tr>
										</thead>
										<thead>
											<tr>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
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
				<h4 class="modal-title">Edit Bank</h4>
			</div>
			<form method="POST" id="edit-form">
				<div class="modal-body">
					
					 <div class="row">
					 	<div class="col-md-6 col-sm-12">
						 	<div class="form-group">
								<label>Nama Bank <span class="require"></span></label>
								<input type="text" class="form-control inp" id="enama" autocomplete="off">
							</div>
						 </div>
						 <div class="col-md-6 col-sm-12">
						 	<div class="form-group">
								<label>Cabang <span class="require"></span></label>
								<input type="text" class="form-control inp" id="ecabang" autocomplete="off">
							</div>
						 </div>
						 <div class="col-md-6 col-sm-12">
						 	<div class="form-group">
								<label>No. Rekeing <span class="require"></span></label>
								<input type="text" class="form-control inp" id="erek" autocomplete="off">
							</div>
						 </div>
						 <div class="col-md-6 col-sm-12">
						 	<div class="form-group">
								<label>Atas Nama <span class="require"></span></label>
								<input type="text" class="form-control inp" id="eatas" autocomplete="off">
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
				<h4 class="modal-title">Tambah Aktivitas</h4>
			</div>
			<form id="add-form">
				<div class="modal-body">
						 <div class="row">
						 	<div class="col-md-6 col-sm-12">
							 	<div class="form-group">
									<label>Tanggal <span class="require"></span> </label>
									<input type="text" class="form-control date-mask" id="tgl" autocomplete="off" placeholder="dd/mm/yyyy">
								</div>
							 </div>
							 <div class="col-md-6 col-sm-12">
							 	<div class="form-group">
									<label>Hari <span class="require"></span></label>
									<input type="text" class="form-control" id="hari" autocomplete="off">
								</div>
							 </div>
							 <div class="col-md-6 col-sm-12">
							 	<div class="form-group">
									<label>Jam <span class="require"></span></label>
									<input type="text" class="form-control time-mask" id="jam1" autocomplete="off" placeholder="Dari Jam (hh/mm/ss)">
									<br>
									<input type="text" class="form-control time-mask" id="jam2" autocomplete="off" placeholder="Sampai Jam (hh/mm/ss)">
								</div>
							 </div>
							 <div class="col-md-6 col-sm-12">
							 	<div class="form-group">
									<label>Customer <span class="require"></span></label>
									<input type="text" class="form-control" id="cust" autocomplete="off">
								</div>
							 </div>
							 <div class="col-md-6 col-sm-12">
							 	<div class="form-group">
									<label>PIC <span class="require"></span></label>
									<input type="text" class="form-control" id="pic" autocomplete="off">
								</div>
							 </div>
							 <div class="col-md-6 col-sm-12">
							 	<div class="form-group">
									<label>Phone <span class="require"></span></label>
									<input type="text" class="form-control" id="phone" autocomplete="off">
								</div>
							 </div>
							 <div class="col-md-6 col-sm-12">
							 	<div class="form-group">
									<label>Email</label>
									<input type="text" class="form-control" id="email" autocomplete="off">
								</div>
							 </div>
							 <div class="col-md-12 col-sm-12">
							 	<div class="form-group">
									<label>Discuss <span class="require"></span></label>
									<textarea class="form-control" id="discuss" style="resize: none;height: 200px;"></textarea>
								</div>
							 </div>
							 <div class="col-md-12 col-sm-12">
							 	<div class="form-group">
									<label>Inquiry</label>
									<textarea class="form-control" id="inquiry" style="resize: none;height: 200px;"></textarea>
								</div>
							 </div>
							 <div class="col-md-12 col-sm-12">
							 	<div class="form-group">
									<label>Description</label>
									<textarea class="form-control" id="desc" style="resize: none;height: 200px;"></textarea>
								</div>
							 </div>
							 <div class="col-md-6 col-sm-12">
							 	<div class="form-group">
									<label>PO Customer</label>
									<input type="text" class="form-control" id="po" autocomplete="off">
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
				<h4 class="modal-title">Hapus Bank</h4>
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

		//Modal Setting
		$('#md-add').on('shown.bs.modal', function() {
		    $("#nama").focus();
		});

		$("#add-form").on("submit",(function(e){
			e.preventDefault();
			
			var tgl 	= $("#tgl").val();
			var hari 	= $("#hari").val();
			var jam1 	= $("#jam1").val();
			var jam2 	= $("#jam2").val();
			var cust 	= $("#cust").val();
			var pic 	= $("#pic").val();
			var phone 	= $("#phone").val();
			var email 	= $("#email").val();
			var discuss = $("#discuss").val();
			var inquiry = $("#inquiry").val();
			var desc 	= $("#desc").val();
			var po 		= $("#po").val();


			if (tgl && hari && jam1 && jam2 && cust && pic && phone && discuss !=="") {
				$.ajax({
					url:"<?php echo base_url()?>activity_list/tambah",
					type:"POST",
					data: {nama, atas, rek, cabang},
					daraType:"json",
					cache:false,
					beforeSend:function(){
						$("#btn-save").attr("disabled", "disabled");
						$("#btn-save").html(loading_event());
					},
					success:function(data){
						switch(parseFloat(data)){
							case 1:
								$(".form-control").val("");
								table.ajax.reload(null, false);
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
			var atas 	= $("#eatas").val();
			var rek 	= $("#erek").val();
			var cabang 	= $("#ecabang").val();

			var id   = $("#get_id").val();
			if (nama && atas && rek && cabang !=="") {
				$.ajax({
					url:"<?php echo base_url()?>bank/update",
					type:"POST",
					data: {nama, atas, rek, cabang, id},
					daraType:"json",
					cache:false,
					beforeSend:function(){
						$("#btn-edit").attr("disabled", "disabled");
						$("#btn-edit").html(loading_event());
					},
					success:function(data){
						switch(parseFloat(data)){
							case 1:
								table.ajax.reload(null, false);
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
				notif("Error", "Lengkapi data yang wajib diisi.", "error");
			}

			
		}));

		$("#src_nama").keypress(function(e) {
	      if(e.which == 13) {
	        table.draw();
	      }
	    });
	    /*datatables
	    table = $('#datatable_ajax').DataTable({ 
	        "processing": true, //Feature control the processing indicator.
	        "serverSide": true, //Feature control DataTables' server-side processing mode.
	        "order": [[ 1, "asc" ]], //Initial no order.
	        "loadingMessage": 'Loading...',
	        "searching":false,
	        "aoColumnDefs": [
				{ "bSortable": false, "aTargets": [ 0,2 ] }
			],
			"oLanguage": {sProcessing: "<i class='fa fa-spinner fa-pulse fa-lg'></i> Loading..."},
	 		
	        // Load data for the table's content from an Ajax source
	        "ajax": {
	            "url": "<?php echo site_url('bank/data')?>",
	            "type": "POST",
	            "data":function ( d ) {
	                  return $.extend( {}, d, {
	                  		"src_nama": $('#src_nama').val(),
	                  		"src_rek": $('#src_rek').val(),
	                  		"src_atas": $('#src_atas').val()
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
	 
	    });*/

	});


		
	function reload(){
		$("#src_nama").val("");
		$("#src_atas").val("");
		$("#src_rek").val("");

		table.draw();
	}

	function edit(id){
		getId(id);
		$.ajax({
			url:"<?php echo base_url()?>bank/edit",
			type:"POST",
			data: {id},
			daraType:"json",
			cache:false,
			beforeSend:function(){
				$(".inp").attr("disabled", "disabled");
				$(".inp").val("");
			},
			success:function(data){
				$("#enama").val(data[0].nama_bank);
				$("#ecabang").val(data[0].cabang);
				$("#eatas").val(data[0].atas_nama);
				$("#erek").val(data[0].no_rek);
			},
			complete:function(){
				$(".inp").removeAttr("disabled");
			}
		 });
	}

	function del(){
		var id = $("#get_id").val();
		$.ajax({
			url:"<?php echo base_url()?>bank/hapus",
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
						table.ajax.reload(null, false);
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