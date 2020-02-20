

<style type="text/css">
	table.dataTable tbody td {
  		vertical-align: middle;
	}
</style>

<div class="page-content">

				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
					User <small></small>
				</h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-user"></i>
							<a href="javascript:;">User</a>
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
									<i class="fa fa-database"></i> Data User
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
												<th>Foto</th>
												<th>Username</th>
												<th>Nama Lengkap</th>
												<th>Jabatan</th>
												<th width="20%"><center>Action</center></th>
											</tr>
										</thead>
										<thead>
											<tr>
												<th></th>
												<th></th>
												<th></th>
												<th><input class="form-control" id="src_nama" placeholder="Cari Nama..."></th>
												<th>
													<select class="form-control select2me" id="src_jabatan">
														<option value="">- Cari Jabatan - </option>
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
				<!-- END PAGE CONTENT-->
</div>

<div class="modal fade" id="md-detail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Detail Member</h4>
			</div>
			<form method="POST" id="d-form">
				<div class="modal-body">
					<div class="row">
						
						<div class="col-md-12 col-sm-12 col-xs-12">
							<center style="display: none"><i class="fa fa-spinner fa-lg fa=pulse"  id="loading_detail"></i> Loading ...</center>
						</div>
						 <div class="col-md-12">
							<div class="form-group">
								<center>
									<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="fileinput-new thumbnail" style="width: 120px;height: 120px;overflow: hidden;border-radius: 50% !important;border:none;padding: 0;">
												<img src="" id="dimg" style="width: 100%;min-height: 120px;max-height: none !important;" />
											</div>
											<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
											</div>

									</div>
								</center>
							</div>
						</div>


						<div class='col-md-6'>
						 	<div class="form-group">
								<label>Nama Lengkap</label><br>
								<label id="dnama"  style="font-weight: bold"></label>
							</div>
						</div>

						<div class='col-md-6'>
						 	<div class="form-group">
								<label>Jenis Kelamin</label><br>
								<label id="djk" style="font-weight: bold"></label>
							</div>
						</div>

						<div class='col-md-6'>
						 	<div class="form-group">
								<label>Tempat Lahir</label><br>
								<label id="dtmp" style="font-weight: bold"></label>
							</div>
						</div>

						<div class='col-md-6'>
						 	<div class="form-group">
								<label>Tanggal Lahir</label><br>
								<label id="dtgl" style="font-weight: bold"></label>
							</div>
						</div>

						
						<div class='col-md-6'>
						 	<div class="form-group">
								<label>No. HP</label><br>
								<label id="dhp" style="font-weight: bold"></label>
							</div>
						</div>

						<div class='col-md-6'>
						 	<div class="form-group">
								<label>Jabatan</label><br>
								<label id="djabatan" style="font-weight: bold"></label>
							</div>
						</div>

						<div class='col-md-12'>
						 	<div class="form-group">
								<label>Alamat</label><br>
								<label id="dalamat" style="font-weight: bold"></label>
							</div>
						</div>
					</div>
					
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<div class="modal fade" id="md-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Edit Member</h4>
			</div>
			<form method="POST" id="edit-form">
				<div class="modal-body">
					<div class="row">
						 <div class="col-md-12">
							<div class="form-group">
								<center>
									<div class="fileinput fileinput-new" data-provides="fileinput">
										
											<div class="clearfix margin-top-10" style="padding-bottom: 20px">
												<span class="label label-danger">
													NOTE : File format harus .jpg, .png, .jpeg
												</span>
											
											</div>
											<div class="fileinput-new thumbnail" style="width: 120px;height: 120px;overflow: hidden;border-radius: 50% !important;border:none;padding: 0;">
												<img src="" id="eimg" style="width: 100%;min-height: 120px;max-height: none !important;" />
											</div>
											<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
											</div>
											<div>
												<span class="btn default btn-file">
													<span class="fileinput-new">
														Pilih Foto (Opsional)
													</span>
													<span class="fileinput-exists">
														Pilih Lagi
													</span>
													<input type="file" name="..." id="efoto">
												</span>
												<a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput" id="ehapus-foto">
													Hapus 
												</a>
											</div>

									</div>
								</center>
							</div>
						</div>

						<div class='col-md-6'>
						 	<div class="form-group">
								<label>Nama Lengkap <span class="require"></span></label>
								<input type="text" class="form-control inp" id="enama" autocomplete="off">
							</div>
						</div>

						<div class='col-md-6'>
						 	<div class="form-group">
								<label>Jenis Kelamin <span class="require"></span></label>
								<select class="form-control select2me" id="ejk">
									<option value="Laki - laki">Laki - laki</option>
									<option value="Perempuan">Perempuan</option>
								</select>
							</div>
						</div>

						<div class='col-md-6'>
						 	<div class="form-group">
								<label>Tempat Lahir <span class="require"></span></label>
								<input type="text" class="form-control inp" id="etmp" autocomplete="off">
							</div>
						</div>

						<div class='col-md-6'>
						 	<div class="form-group">
								<label>Tanggal Lahir <span class="require"></span></label>
								<input type="text" class="form-control date-mask inp" id="etgl" autocomplete="off">
							</div>
						</div>

						
						<div class='col-md-6'>
						 	<div class="form-group">
								<label>No. HP <span class="require"></span></label>
								<input type="text" class="form-control inp" maxlength="12" id="ehp" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
							</div>
						</div>

						<div class='col-md-6'>
						 	<div class="form-group">
								<label>Jabatan <span class="require"></span></label>
								<select class="form-control select2me inp" id="ejabatan">
									<option value=""> - Pilih Jabatan -</option>
								</select>
							</div>
						</div>

						<div class='col-md-12'>
						 	<div class="form-group">
								<label>Alamat (Opsional)</label>
								<textarea class="form-control inp" id="ealamat" style="resize: none;height: 200px;"></textarea>
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
				<h4 class="modal-title">Tambah Member</h4>
			</div>
			<form id="add-form">
				<div class="modal-body">
					<div class="row">

						<div class="col-md-12">
							<div class="form-group">
								<center>
									<div class="fileinput fileinput-new" data-provides="fileinput">
										
											<div class="clearfix margin-top-10" style="padding-bottom: 20px">
												<span class="label label-danger">
													NOTE : File format harus .jpg, .png, .jpeg
												</span>
											
											</div>
											<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
												<img src="<?php echo base_url() ?>upload/user/no_img.png"/>
											</div>
											<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
											</div>
											<div>
												<span class="btn default btn-file">
													<span class="fileinput-new">
														Pilih Foto (Opsional)
													</span>
													<span class="fileinput-exists">
														Pilih Lagi
													</span>
													<input type="file" name="..." id="foto">
												</span>
												<a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput" id="hapus-foto">
													Hapus 
												</a>
											</div>

									</div>
								</center>
							</div>
						</div>

						<div class='col-md-6'>
						 	<div class="form-group">
								<label>Nama Lengkap <span class="require"></span></label>
								<input type="text" class="form-control" id="nama" autocomplete="off">
							</div>
						</div>

						<div class='col-md-6'>
						 	<div class="form-group">
								<label>Username <span class="require"></span></label>
								<input type="text" class="form-control" id="username" autocomplete="off" maxlength="12">
							</div>
						</div>

						<div class='col-md-6'>
						 	<div class="form-group">
								<label>Password <span class="require"></span></label>
								<input type="password" class="form-control" id="pass1" autocomplete="off">
							</div>
						</div>

						<div class='col-md-6'>
						 	<div class="form-group">
								<label>Ketik Ulang Password <span class="require"></span></label>
								<input type="password" class="form-control" id="pass2" autocomplete="off">
							</div>
						</div>

						<div class='col-md-6'>
						 	<div class="form-group">
								<label>Jenis Kelamin <span class="require"></span></label>
								<div class="input-group">
									<div class="icheck-inline">
										<label>
											<input type="radio" name="jk" class="icheck" data-radio="iradio_square-blue" value="Laki - laki"> Laki - laki
										</label>
										<label>
											<input type="radio" name="jk" class="icheck" data-radio="iradio_square-blue" value="Perempuan"> Perempuan
										</label>
									</div>
								</div>
							</div>
						</div>

						<div class='col-md-6'>
						 	<div class="form-group">
								<label>Tempat Lahir <span class="require"></span></label>
								<input type="text" class="form-control" id="tmp" autocomplete="off">
							</div>
						</div>

						<div class='col-md-6'>
						 	<div class="form-group">
								<label>Tanggal Lahir <span class="require"></span></label>
								<input type="text" class="form-control date-mask" id="tgl" autocomplete="off">
							</div>
						</div>

						
						<div class='col-md-6'>
						 	<div class="form-group">
								<label>No. HP <span class="require"></span></label>
								<input type="text" class="form-control" maxlength="12" id="hp" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
							</div>
						</div>

						<div class='col-md-6'>
						 	<div class="form-group">
								<label>Jabatan <span class="require"></span></label>
								<select class="form-control select2me" id="jabatan">
									<option value=""> - Pilih Jabatan -</option>
								</select>
							</div>
						</div>

						<div class='col-md-12'>
						 	<div class="form-group">
								<label>Alamat </label>
								<textarea class="form-control" id="alamat" style="resize: none;height: 200px;"></textarea>
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
				<h4 class="modal-title">Hapus User</h4>
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

<div class="modal fade" id="md-akses" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Hak Akses <strong id="akses-title"></strong></h4>
			</div>
			<div class="modal-body">
				
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover" id="dt-akses">
								<thead>
									<th>Menu</th>
									<th>Modul</th>
									<th>Akses</th>
									<th width="10%">Action</th>
								</thead>
								<tbody>
									
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

<input type="hidden" id="get_id">

<script>

	var table;
	var akses;
	
	$(document).ready(function() {

		//Select Setting
		select("jabatan/select", "jabatan");
		select("jabatan/select", "src_jabatan");
		select("jabatan/select", "ejabatan");

		//Modal Setting
		$('#md-add').on('shown.bs.modal', function() {
		    $("#nama").focus();
		});

		$("#add-form").on("submit",(function(e){
			e.preventDefault();
			
			var nama 		= $("#nama").val();
			var tmp 		= $("#tmp").val();
			var tgl 		= toTglSys($("#tgl").val());
			var alamat 		= $("#alamat").val();
			var username 	= $("#username").val();
			var pass1 		= $("#pass1").val();
			var pass2 		= $("#pass2").val();
			var jabatan 	= $("#jabatan").val();
			var foto 		= $("#foto").prop('files')[0];
			var jk			= $("input[name=jk]:checked").val();
			var hp 			= $("#hp").val();
			var divisi 		= $("#divisi").val();

			var form_data = new FormData();
        	form_data.append('foto', foto);
        	form_data.append('nama', nama);
        	form_data.append('username', username);
        	form_data.append('tmp', tmp);
        	form_data.append('alamat', alamat);
        	form_data.append('tgl', tgl);
        	form_data.append('pass1', pass1);
        	form_data.append('jabatan', jabatan);
        	form_data.append('jk', jk);
        	form_data.append('hp', hp);
        	form_data.append('divisi', divisi);


			if (nama && username && pass1 && pass2 && jabatan && jk && divisi !=="") {

				if (pass1 == pass2) {
					if (pass1.length >=6) {
						var val_password = "1";
					}
					else{
						var val_password = "0";
						notif("Error", "Password minimal 6 karakter.", "error");
					}
				}
				else{
					var val_password = "0";
					notif("Error", "Password tidak sama.", "error");
				}

				if (username.length >=4) {
						var val_username = "1";
				}
				else{
					var val_username = "0";
					notif("Error", "Username minimal 4 karakter.", "error");
				}


				if (val_password && val_username == "1") {
					$.ajax({
						url:"<?php echo base_url()?>user/tambah",
						type:"POST",
						data: form_data,
						daraType:"json",
						contentType: false,
                		processData: false,
						cache:false,
						beforeSend:function(){
							$("#btn-save").attr("disabled", "disabled");
							$("#btn-save").html(loading_event());
						},
						success:function(data){
							switch(parseFloat(data)){
								case 1:
									$("#nama").val("");
									$("#tmp").val("");
									$("#tgl").val("");
									$("#username").val("");
									$("#pass1").val("");
									$("#pass2").val("");
									$("#alamat").val("");
									$("#hp").val("");
									$("#jabatan").val("");
									$("#jabatan").trigger("change");
									$("#divisi").val("");
									$("#divisi").trigger("change");
									$("#hapus-foto").click();

									table.draw();
									notif("Success", "Data berhasil disimpan.", "success");
									$('#md-add').modal('toggle');
								break;
								case 0:
									notif("Error", "Data gagal disimpan.", "error");
								break;
								case 0.1:
									notif("Error", "Username tidak bisa digunakan.", "error");
								break;
							}
						},
						complete:function(){
							$("#btn-save").removeAttr("disabled");
							$("#btn-save").html("Simpan");
						}
					 });	
				}

				
			}
			else{
				notif("Error", "Lengkapi data yang wajib diisi.", "error");
			}

			
		}));

		$("#edit-form").on("submit",(function(e){
			e.preventDefault();
			
			var nama 		= $("#enama").val();
			var tmp 		= $("#etmp").val();
			var tgl 		= toTglSys($("#etgl").val());
			var alamat 		= $("#ealamat").val();
			var username 	= $("#get_id").val();
			var jabatan 	= $("#ejabatan").val();
			var foto 		= $("#efoto").prop('files')[0];
			var jk			= $("#ejk").val();
			var hp 			= $("#ehp").val();
			var cabang 		= $("#ecabang").val();
			var divisi 		= $("#edivisi").val();

			var form_data = new FormData();
        	form_data.append('foto', foto);
        	form_data.append('nama', nama);
        	form_data.append('username', username);
        	form_data.append('tmp', tmp);
        	form_data.append('alamat', alamat);
        	form_data.append('tgl', tgl);
        	form_data.append('jabatan', jabatan);
        	form_data.append('jk', jk);
        	form_data.append('hp', hp);
        	form_data.append('cabang', cabang);
        	form_data.append('divisi', divisi);


			if (nama && username && jabatan && jk && divisi !=="") {


				if (username.length >=4) {
						var val_username = "1";
				}
				else{
					var val_username = "0";
					notif("Error", "Username minimal 4 karakter.", "error");
				}


				if (val_username == "1") {
					$.ajax({
						url:"<?php echo base_url()?>user/update",
						type:"POST",
						data: form_data,
						daraType:"json",
						contentType: false,
                		processData: false,
						cache:false,
						beforeSend:function(){
							$("#btn-edit").attr("disabled", "disabled");
							$("#btn-edit").html(loading_event());
						},
						success:function(data){
							switch(parseFloat(data)){
								case 1:
									$("#enama").val("");
									$("#etmp").val("");
									$("#etgl").val("");
									$("#ealamat").val("");
									$("#ehp").val("");
									$("#ejabatan").val("");
									$("#ejabatan").trigger("change");
									$("#ecabang").val("");
									$("#ecabang").trigger("change");
									$("#edivisi").val("");
									$("#edivisi").trigger("change");

									$("#ehapus-foto").click();

									table.draw();
									notif("Success", "Data berhasil disimpan.", "success");
									$('#md-edit').modal('toggle');
								break;
								case 0:
									notif("Error", "Data gagal disimpan.", "error");
								break;
								case 0.1:
									notif("Error", "Username tidak bisa digunakan.", "error");
								break;
							}
						},
						complete:function(){
							$("#btn-edit").removeAttr("disabled");
							$("#btn-edit").html("Simpan");
						}
					 });	
				}

				
			}
			else{
				notif("Error", "Lengkapi data yang wajib diisi .", "error");
			}

			
		}));

		$("#src_nama").keypress(function(e) {
	      if(e.which == 13) {
	        table.draw();
	      }
	    });
	    $("#src_jabatan").change(function(){
	     	table.draw();
	    });
	    //datatables
	    table = $('#datatable_ajax').DataTable({ 
	        "processing": true, //Feature control the processing indicator.
	        "serverSide": true, //Feature control DataTables' server-side processing mode.
	        "order": [[ 3, "asc" ]], //Initial no order.
	        "loadingMessage": 'Loading...',
	        "searching":false,
	        "aoColumnDefs": [
				{ "bSortable": false, "aTargets": [ 0, 1, 5 ] }
			],
			"oLanguage": {sProcessing: "<i class='fa fa-spinner fa-pulse fa-lg'></i> Loading..."},
	 		
	        // Load data for the table's content from an Ajax source
	        "ajax": {
	            "url": "<?php echo site_url('user/data')?>",
	            "type": "POST",
	            "data":function ( d ) {
	                  return $.extend( {}, d, {
	                  		"src_nama": $('#src_nama').val(),
	                  		"src_jabatan": $('#src_jabatan').val(),
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
	    akses = $('#dt-akses').DataTable({ 
	        "processing": true, //Feature control the processing indicator.
	        "serverSide": true, //Feature control DataTables' server-side processing mode.
	        "order": [[ 0, "asc" ]], //Initial no order.
	        "loadingMessage": 'Loading...',
	        "searching":false,
	        "bInfo" : false,
	        "bLengthChange": false,
	        "aoColumnDefs": [
				{ "bSortable": false, "aTargets": [ 3 ] }
			],
			"oLanguage": {sProcessing: "<i class='fa fa-spinner fa-pulse fa-lg'></i> Loading..."},
	 		
	        // Load data for the table's content from an Ajax source
	        "ajax": {
	            "url": "<?php echo site_url('user/dt_akses')?>",
	            "type": "POST",
	            "data":function ( d ) {
	                  return $.extend( {}, d, {
	                  		"id": $("#get_id").val()
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

	function get_akses(id){
		getId(id)
		akses.draw();

	}

	function akses_proses(id, status, no){

		$.ajax({
			url:"<?php echo base_url() ?>user/akses",
			type:"POST",
			dataType:"json",
			data:{id, status},
			beforeSend:function(){
				$("#aks"+no).html("<i class='fa fa-spinner fa-pulse'></i>");
				$("#aks"+no).attr("disabled");
			},
			success:function(data){
				akses.ajax.reload(null,false);
			},
			complete:function(){
				$("#aks"+no).removeAttr("disabled");
			}
		});

	}
		
	function reload(){
		$("#src_nama").val("");
		$("#src_jabatan").val("");
		$("#src_jabatan").trigger("change");

		table.draw();
	}

	function edit(id){
		getId(id);
		$.ajax({
			url:"<?php echo base_url()?>user/edit",
			type:"POST",
			data: {id},
			daraType:"json",
			cache:false,
			beforeSend:function(){
				$(".inp2").attr("disabled", "disabled");
				$(".inp2").val("");
				$("#eimg").attr("src","");
			},
			success:function(data){
				$("#enama").val(data[0].nama);
				$("#etmp").val(data[0].tmp_lahir);
				$("#etgl").val(toTgl(data[0].tgl_lahir));
				$("#ehp").val(data[0].no_hp);
				$("#ealamat").val(data[0].alamat);
				$("#ejabatan").val(data[0].idjabatan);
				$("#ejabatan").trigger("change");
				$("#ejk").val(data[0].jk);
				$("#ejk").trigger("change");
				$("#edivisi").val(data[0].divisi);
				$("#edivisi").trigger("change");

				//alert(toTgl(data[0].tgl_lahir));


				if (data[0].foto!=="") {
					var img = "upload/user/"+data[0].foto;
				}
				else{
					if (data[0].jk == "Laki - laki") {
						var img = "assets/layout2/img/user-m.png";
					}
					else{
						var img = "assets/layout2/img/user-f.png";
					}
				}
				$("#eimg").attr("src", "<?php echo base_url()?>"+img);

					
				
				
			},
			complete:function(){
				$(".inp2").removeAttr("disabled");
			}
		 });
	}

	function detail(id){
		getId(id);
		$.ajax({
			url:"<?php echo base_url()?>user/edit",
			type:"POST",
			data: {id},
			daraType:"json",
			cache:false,
			beforeSend:function(){
				$("#loading_detail").fadeIn();
			},
			success:function(data){
				$("#dnama").html(data[0].nama);
				$("#dtmp").html(data[0].tmp_lahir);
				$("#dtgl").html(toTgl(data[0].tgl_lahir));
				$("#dhp").html(data[0].no_hp);
				$("#dalamat").html(data[0].alamat);
				$("#djabatan").html(data[0].nama_jabatan);
				$("#djk").html(data[0].jk);

				//alert(toTgl(data[0].tgl_lahir));


				if (data[0].foto!=="") {
					var img = "upload/user/"+data[0].foto;
				}
				else{
					if (data[0].jk == "Laki - laki") {
						var img = "assets/layout2/img/user-m.png";
					}
					else{
						var img = "assets/layout2/img/user-f.png";
					}
				}

				$("#dimg").attr("src", "<?php echo base_url()?>"+img);

					
				
				
			},
			complete:function(){
				$("#loading_detail").fadeOut();
			}
		 });
	}

	function del(){
		var id = $("#get_id").val();
		$.ajax({
			url:"<?php echo base_url()?>user/hapus",
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
				$("#btn-del").html("Simpan");
			}
		 });
	}

	function getId(id){
		$("#get_id").val(id);
	}

</script>