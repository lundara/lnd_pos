

<div class="page-content">

				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
				Profile <small></small>
				</h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-user"></i>
							<a href="<?php echo base_url() ?>profile">Profile</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="javascript:;">Edit</a>
						</li>
					</ul>
					
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row">
					<div class="col-md-12">
						<!-- BEGIN PROFILE SIDEBAR -->
						<?php
							$path = APPPATH."views/port/profile-sidebar.php";
							include($path);
						?>  
						<!-- END BEGIN PROFILE SIDEBAR -->
						<!-- BEGIN PROFILE CONTENT -->
						<div class="profile-content">
							<div class="row">
								<div class="col-md-12">
									<div class="portlet light">
										<div class="portlet-title tabbable-line">
											<ul class="nav nav-tabs">
												<li class="active">
													<a href="#tab_1_1" data-toggle="tab">Data Pribadi</a>
												</li>
												<li>
													<a href="#tab_1_2" data-toggle="tab">Foto Profile</a>
												</li>
												<li>
													<a href="#tab_1_3" data-toggle="tab">Ubah Password</a>
												</li>
											</ul>
										</div>
										<div class="portlet-body">
											<div class="tab-content">
												<!-- PERSONAL INFO TAB -->
												<div class="tab-pane active" id="tab_1_1">
													<form role="form" action="#">
														<div class="form-group">
															<label class="control-label">Nama Lengkap</label>
															<input type="text" placeholder="Nama Lengkap" class="form-control inp1" id="nama" />
														</div>
														<div class="form-group">
															<label class="control-label">Jenis Kelamin</label><br>
															<select class="form-control inp1" id="jk">
																<option value="Laki - laki">Laki - laki</option>
																<option value="Perempuan">Perempuan</option>
															</select>
														</div>
														<div class="form-group">
															<label class="control-label">Tempat Lahir</label>
															<input type="text" placeholder="Tempat Lahir" class="form-control inp1" id="tmp" />
														</div>
														<div class="form-group">
															<label class="control-label">Tanggal Lahir</label>
															<input type="text" placeholder="dd/mm/yyyy" class="form-control date-mask inp1" id="tgl" />
														</div>
														<div class="form-group">
															<label class="control-label">No. HP</label>
															<input type="text" placeholder="08XXXXXXXXXX" id="hp" class="form-control inp1" maxlength="12" />
														</div>
														<div class="form-group">
															<label class="control-label">Alamat</label>
															<textarea class="form-control inp1" rows="3" id="alamat" placeholder="Alamat Lengkap (Sesuai KTP)"></textarea>
														</div>
														<div class="margiv-top-10">
															<a href="javascript:;" class="btn green-haze" onclick="update_profile()" id="btn-up">
																Simpan Perubahan 
															</a>
														</div>
													</form>
												</div>
												<!-- END PERSONAL INFO TAB -->
												<!-- CHANGE AVATAR TAB -->
												<div class="tab-pane" id="tab_1_2">
													<form action="#" role="form">
														<div class="form-group">
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
																			Pilih Foto 
																		</span>
																		<span class="fileinput-exists">
																			Pilih Lagi
																		</span>
																		<input type="file" name="..." id="foto">
																	</span>
																	<a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput">
																		Hapus 
																	</a>
																</div>
															</div>

														</div>
														<div class="margin-top-10">
															<a href="javascript:;" class="btn green-haze " id="btn-upload" onclick="upload_foto()">
																Upload Foto 
															</a>
														</div>
													</form>
												</div>
												<!-- END CHANGE AVATAR TAB -->
												<!-- CHANGE PASSWORD TAB -->
												<div class="tab-pane" id="tab_1_3">
													<form action="#">
														<div class="form-group">
															<label class="control-label">Password Lama</label>
															<input type="password" class="form-control inp2" id="old" />
														</div>
														<div class="form-group">
															<label class="control-label">Password Baru</label>
															<input type="password" class="form-control inp2" id="new_pass" />
														</div>
														<div class="form-group">
															<label class="control-label">Ketik Ulang Password Baru</label>
															<input type="password" class="form-control inp2" id="conf" />
														</div>
														<div class="margin-top-10">
															<a href="javascript:;" class="btn green-haze" id="btn-pass" onclick="ubah_password()">
																Ubah Password 
															</a>
														</div>
													</form>
												</div>
												<!-- END CHANGE PASSWORD TAB -->
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- END PROFILE CONTENT -->
					</div>
				</div>
				<!-- END PAGE CONTENT-->
			</div>

<script type="text/javascript">

	//load data
	dt_pribadi();


	$("#old").keypress(function(e) {
          if(e.which == 13) {
               ubah_password();
          }
  	});
  	$("#new_pass").keypress(function(e) {
          if(e.which == 13) {
               ubah_password();
          }
  	});
  	$("#conf").keypress(function(e) {
          if(e.which == 13) {
               ubah_password();
          }
  	});


	function ubah_password(){

		var old 		= $("#old").val();
		var new_pass 	= $("#new_pass").val();
		var conf 		= $("#conf").val();
		

		if (old && new_pass && conf !=="") {
			var len 		= new_pass.length;

			if (len >5) {
				if (new_pass == conf) {
					$.ajax({
						url:"<?php echo base_url(); ?>profile/ubah_password",
						method:"POST",
						dataType:"json",
						data:{old, new_pass},
						beforeSend:function(){
							$("#inp2").attr("disabled", "disabled");
							$("#btn-pass").attr("disabled", "disabled");
							$("#btn-pass").html("<i class='fa fa-spinner fa-pulse fa-lg'></i> Loading...");
						},
						success:function(data){
							switch(parseFloat(data)){
								case 1:
									notif("Success", "Password berhasil diubah.", "success");
									setTimeout(function(){location.assign("<?php echo base_url()?>profile")}, 2000);
								break;
								case 0:
									notif("Error", "Password gagal diubah.", "error");
								break;
								case 0.1:
									notif("Error", "Password lama salah.", "error");
								break;
							}
						},
						complete:function(){
							$(".inp2").removeAttr("disabled");
							$("#btn-pass").removeAttr("disabled");
							$("#btn-pass").html("Simpan Perubahan");
						}
					});
				}
				else{
					notif("Error", "Password tidak sama.", "error");
				}
			}
			else{
				notif("Error", "Password Minimal 6 karakter.", "error");
			}

			
		}
		else{
			notif("Error", "Lengkapi data.", "error");
		}
	}

	function upload_foto(){
		var foto = $("#foto").prop('files')[0];
        var form_data = new FormData();
        form_data.append('foto', foto);

		if ($("#foto").val() !== "") {
			$.ajax({
				url:"<?php echo base_url(); ?>profile/upload_foto",
				method:"POST",
				dataType:"json",
				contentType: false,
                processData: false,
    			data: form_data,
				beforeSend:function(){
					$("#btn-upload").attr("disabled", "disabled");
					$("#btn-upload").html("<i class='fa fa-spinner fa-pulse fa-lg'></i> Loading...");
				},
				success:function(data){
					switch(parseFloat(data)){
						case 1:
							notif("Success", "Foto berhasil diupload.", "success");
							setTimeout(function(){location.assign("<?php echo base_url()?>profile")}, 2000);
						break;
						case 0:
							notif("Error", "Foto gagal diupload.", "error");
						break;
						case 0.1:
							notif("Error", "Format file tidak sesuai.", "error");
						break;
					}
				},
				complete:function(){
					$("#btn-upload").removeAttr("disabled");
					$("#btn-upload").html("Upload Foto");
				}
			});
		}
		else{
			notif("Error", "Pilih File terlebih dahulu.", "error");
		}
	}

	function update_profile(){

		var nama 	= $("#nama").val();
		var alamat 	= $("#alamat").val();
		var jk 		= $("#jk").val();
		var tmp 	= $("#tmp").val();
		var tgl 	= $("#tgl").val();
		var hp 		= $("#hp").val();

		if (nama && alamat && jk && tmp && tgl && hp !=="") {

			$.ajax({
				url:"<?php echo base_url(); ?>profile/update_profile",
				method:"POST",
				dataType:"json",
				data:{nama, alamat, jk, tmp, tgl, hp},
				beforeSend:function(){
					$("#inp1").attr("disabled", "disabled");
					$("#btn-up").attr("disabled", "disabled");
					$("#btn-up").html("<i class='fa fa-spinner fa-pulse fa-lg'></i> Loading...");
				},
				success:function(data){
					switch(parseFloat(data)){
						case 1:
							notif("Success", "Data berhasil disimpan.", "success");
							setTimeout(function(){location.assign("<?php echo base_url()?>profile")}, 2000);
						break;
						case 0:
							notif("Error", "Data gagal disimpan.", "error");
						break;
					}
				},
				complete:function(){
					$(".inp1").removeAttr("disabled");
					$("#btn-up").removeAttr("disabled");
					$("#btn-up").html("Simpan Perubahan");
				}
			});
		}
		else{
			notif("Error", "Lengkapi data.", "error");
		}
	}

	function dt_pribadi(){
		$.ajax({
			url:"<?php echo base_url(); ?>profile/dt_pribadi",
			method:"POST",
			dataType:"json",
			beforeSend:function(){
				$(".inp1").attr("disabled", "disabled");
			},
			success:function(data){
				$("#nama").val(data[0].nama);
				$("#tmp").val(data[0].tmp_lahir);
				$("#tgl").val(toTgl(data[0].tgl_lahir));
				$("#hp").val(data[0].no_hp);
				$("#alamat").val(data[0].alamat);
				$("#jk").val(data[0].jk);
				$("#jk").trigger("change");
			},
			complete:function(){
				$(".inp1").removeAttr("disabled");
			}
		});
	}
</script>