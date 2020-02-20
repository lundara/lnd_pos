<div class="page-content">

				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
					Outlet <small></small>
				</h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="javascript:;">Outlet</a>
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
									<i class="fa fa-database f-white"></i> Data Outlet
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
											<button class="btn main" onclick="reload()">
												<i class="fa fa-refresh fa-lg"></i> Refresh
											</button>
											<button class="btn main" data-toggle="modal" data-target="#md-fadd">
												<i class="fa fa-plus fa-lg"></i> Tambah
											</button>
										</div>
									</div>
									<table class="table table-striped table-bordered table-hover" id="datatable_ajax">
										<thead>
											<tr>
												<th width="5%"><center>#</center></th>
												<th>Nama Outlet</th>
												<th>Kode Outlet</th>
												<th>Telp</th>
												<th>Alamat</th>
												<th width="5%"><center>Action</center></th>
											</tr>
										</thead>
										<thead>
											<tr>
												<th></th>
												<th><input class="form-control" id="src_nama" placeholder="Cari Outlet..."></th>
												<th><input class="form-control" id="src_kode" placeholder="Cari Kode Outlet..."></th>
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

<div class="modal fade" id="md-fedit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Edit Outlet</h4>
			</div>
			<form method="POST" id="fedit" action="javascript:submitForm('fedit');" url="<?php echo base_url('outlet/update') ?>">
				<div class="modal-body">
					
					 <div class="row">
					 	<div class="col-md-6 col-sm-12">
					 		<input id="edit_id" type="hidden" name="edit_id">
						 	<div class="form-group">
								<label>Nama Outlet <span class="require"></span> </label>
								<input type="text" class="form-control inp-fedit" onkeyup="ucwords(this.value, 'enama')" id="enama" autocomplete="off" name="f[nama_outlet]" required="">
							</div>
						 </div>
						 <div class="col-md-6 col-sm-12">
						 	<div class="form-group">
								<label>Kode Outlet <span class="require"></span> </label>
								<input type="text" class="form-control inp-fedit" onkeypress="upper('ekode')" id="ekode" autocomplete="off" name="f[kode_outlet]" required="" maxlength="4">
							</div>
						 </div>
						 <div class="col-md-6 col-sm-12">
						 	<div class="form-group">
								<label>Telp <span class="require"></span></label>
								<input type="text" class="form-control inp-fedit" id="etelp" autocomplete="off" name="f[telp]" required="">
							</div>
						 </div>
						 <div class="col-md-12 col-sm-12">
						 	<div class="form-group">
								<label>Alamat </label>
								<textarea class="form-control inp-fedit" id="ealamat" style="height: 200px;" name="f[alamat]" required=""></textarea>
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
					<button type="submit" id="btn-fedit" class="btn main">Simpan</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<div class="modal fade" id="md-fadd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Tambah Outlet</h4>
			</div>
			<form id="fadd" action="javascript:submitForm('fadd')" url="<?php echo base_url('outlet/tambah') ?>">
				<div class="modal-body">
						 <div class="row">
						 	<div class="col-md-6 col-sm-12">
							 	<div class="form-group">
									<label>Nama Outlet <span class="require"></span> </label>
									<input type="text" class="form-control inp-fadd" onkeyup="ucwords(this.value, 'nama')" id="nama" autocomplete="off" name="f[nama_outlet]" required="">
								</div>
							 </div>
							 <div class="col-md-6 col-sm-12">
							 	<div class="form-group">
									<label>Kode Outlet <span class="require"></span> </label>
									<input type="text" class="form-control inp-fadd" onkeypress="upper('kode')" id="kode" autocomplete="off" name="f[kode_outlet]" required="" maxlength="4">
								</div>
							 </div>
							 <div class="col-md-6 col-sm-12">
							 	<div class="form-group">
									<label>Telp <span class="require"></span></label>
									<input type="text" class="form-control inp-fadd" id="telp" autocomplete="off" name="f[telp]" required="">
								</div>
							 </div>
							 <div class="col-md-12 col-sm-12">
							 	<div class="form-group">
									<label>Alamat </label>
									<textarea class="form-control inp-fadd" id="alamat" style="height: 200px;" name="f[alamat]" required=""></textarea>
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
					<button type="submit" class="btn main" id="btn-fadd">Simpan</button>
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
				<h4 class="modal-title">Hapus Outlet</h4>
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



<script>

	var table;
	 
	$(document).ready(function() {

		//Modal Setting
		$('#md-fadd').on('shown.bs.modal', function() {
		    $("#nama").focus();
		});

		$("#src_nama").keypress(function(e) {
	      if(e.which == 13) {
	        table.draw();
	      }
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
				{ "bSortable": false, "aTargets": [ 0,2 ] }
			],
			"oLanguage": {sProcessing: "<i class='fa fa-spinner fa-pulse fa-lg'></i> Loading..."},
	 		
	        // Load data for the table's content from an Ajax source
	        "ajax": {
	            "url": "<?php echo site_url('outlet/data')?>",
	            "type": "POST",
	            "data":function ( d ) {
	                  return $.extend( {}, d, {
	                  		"src_nama": $('#src_nama').val(),
	                  		"src_kode": $('#src_kode').val(),
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
					    	var left = $btnDropDown.offset().left - 300;
					    	var top = $btnDropDown.offset().top - 160;
					    }
					    else if(parseInt($btnDropDown.offset().left) >= 620 && parseInt($btnDropDown.offset().left)<870){
					    	var left = $btnDropDown.offset().left-110;
					    	var top = $btnDropDown.offset().top - 160;
					    }
					    else{
					    	var left = $btnDropDown.offset().left-100;
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
		$("#src_kode").val("");

		table.draw(null, false);
	}

	function edit(id){
		getId(id);
		$.ajax({
			url:"<?php echo base_url()?>outlet/edit",
			type:"POST",
			data: {id},
			daraType:"json",
			cache:false,
			beforeSend:function(){
				$(".inp-fedit").attr("disabled", "disabled");
				$(".inp-fedit").val("");
			},
			success:function(data){
				$("#enama").val(data[0].nama_outlet);
				$("#etelp").val(data[0].telp);
				$("#ealamat").val(data[0].alamat);
				$("#ekode").val(data[0].kode_outlet);
			},
			complete:function(){
				$(".inp-fedit").removeAttr("disabled");
			}
		 });
	}

	function del(){
		var id = $("#edit_id").val();
		$.ajax({
			url:"<?php echo base_url()?>outlet/hapus",
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
		$("#edit_id").val(id);
	}

</script>