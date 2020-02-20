<?php  


	if ($so == "Y") {
		$btn_st = "hide";
		$btn_fn = "";
		$inp_ds = "";
	}
	else{
		$btn_st = "";
		$btn_fn = "hide";
		$inp_ds = "disabled";
	}

?>


<div class="page-content">

				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
					Stok Opname <small></small>
				</h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-pelanggans"></i>
							<a href="javascript:;">Stok Opname</a>
						</li>
					</ul>
					
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row">
					<div class="col-md-12">
						<div class="portlet box blue" >
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-calculator"></i> Stok Opname
								</div>
								<div class="tools">
									<a href="javascript:;" class="collapse">
									</a>
								</div>
							</div>
							<div class="portlet-body" style="min-height: 500px;">
								<div class="row">
									<div class="col-md-4 col-sm-12">
										<button id="btn-st" class="btn bg-green <?php echo $btn_st; ?>" data-toggle="modal" data-target="#md-st">
											Start Opname
										</button>
										<button id="btn-fn" class="btn bg-yellow <?php echo $btn_fn; ?>" data-toggle="modal" data-target="#md-fn">
											Finish Opname
										</button>
										<h4><strong>No. Stok Opname : <span id="no_so"><?php echo $noso; ?></span></strong></h4>
									</div>
									<div class="col-md-8 col-sm-12"></div>
								</div>
								<hr>
								<div class="row">
									<div class="col-md-4 col-sm-12">
										<h4><strong>Form Penginputan Stok Opname</strong></h4>
										<div class="form-group">
											<label>Produk : </label>
											<input type="hidden" id="produk" class="form-control" <?php echo $inp_ds ?>>
										</div>
										<div class="form-group">
											<label>Qty : </label>
											<div class="input-group">
												<input type="text" class="form-control rupiah" style="text-align: right;" id="qty" <?php echo $inp_ds ?>>
												<span class="input-group-btn">
													<button class="btn blue" type="button" id="satuan" style="cursor: text;" <?php echo $inp_ds ?>>
														-
													</button>
												</span>
											</div>
										</div>
										<div class="form-group">
											<button class="btn bg-blue col-md-12" <?php echo $inp_ds ?>>Simpan</button>
										</div>
										

									</div>
									<div class="col-md-8 col-sm-12">
										<h4><strong>Daftar Produk Selisih</strong></h4>
										<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover">
												<thead>
													<th><center>No</center></th>
													<th><center>Nama Produk</center></th>
													<th><center>Stok</center></th>
													<th><center>Stok Awal</center></th>
													<th><center>Selisih</center></th>
												</thead>
												<tbody id="dt-selisih">
													
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
				<!-- END PAGE CONTENT-->
</div>

<div class="modal fade" id="md-st" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Start Opname</h4>
			</div>
			<div class="modal-body">
				
				<p style="text-align: center">
					<i class="fa fa-exclamation-triangle font-green" style="font-size: 35px;" ></i><br>
					<label style="font-size: 25px;"> Apa anda yakin akan memulai stok opname ? </label>
				</p>

			</div>
			<div class="modal-footer">
				<button type="submit" class="btn green" id="btn-del"  onclick="del()">Iyah</button>
				<button type="button" class="btn default" data-dismiss="modal">Batal</button>
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
			
			var nama = $("#nama").val();
			var hp = $("#hp").val();
			var alamat = $("#alamat").val();
			var fax = $("#fax").val();

			if (nama && hp && alamat !=="") {
				$.ajax({
					url:"<?php echo base_url()?>pelanggan/tambah",
					type:"POST",
					data: {nama, hp, alamat, fax},
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
								$("#hp").val("");
								$("#alamat").val("");
								$("#fax").val("");
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
			
			var nama 	= $("#enama").val();
			var hp 		= $("#ehp").val();
			var alamat 	= $("#ealamat").val();
			var id   	= $("#get_id").val();
			var fax   = $("#efax").val();
			if (nama && hp && alamat !=="") {
				$.ajax({
					url:"<?php echo base_url()?>pelanggan/update",
					type:"POST",
					data: {nama, alamat, hp, id, fax},
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
				notif("Error", "Tidak boleh kosong.", "error");
			}

			
		}));
	    var sel_item = {
	        placeholder: "Pilih Produk",
	        minimumInputLength: 2,
	        ajax: {
	            url: '<?php echo base_url() ?>produk/select2',
	            dataType: 'json',
	            type:"POST",	
	            data: function (term, page) {
	                // Nothing sent to server side. Mock example setup.
	                return {
	                	term: term
	            	}
	            },
	            results: function (data, page) {
	                // Normally server side logic would parse your JSON string from your data returned above then return results here that match your search term. In this case just returning 2 mock options.
	                return {
	                    results: data 
	                };
	            }
	        },
	        formatResult: function (option) {

	            return "<div>" + option.nama_produk+ "</div>";
	        },
	        formatSelection: function (option) {
	            return option.nama_produk;
	        }
	    };
	    $("#produk").select2(sel_item);

		$("#src_nama").keypress(function(e) {
	      if(e.which == 13) {
	        table.draw();
	      }
	    });
	    $("#src_hp").keypress(function(e) {
	      if(e.which == 13) {
	        table.draw();
	      }
	    });
	    //datatables
	    /*
	    table = $('#datatable_ajax').DataTable({ 
	        "processing": true, //Feature control the processing indicator.
	        "serverSide": true, //Feature control DataTables' server-side processing mode.
	        "order": [[ 1, "asc" ]], //Initial no order.
	        "loadingMessage": 'Loading...',
	        "searching":false,
	        "aoColumnDefs": [
				{ "bSortable": false, "aTargets": [ 0,2,4 ] }
			],
			"oLanguage": {sProcessing: "<i class='fa fa-spinner fa-pulse fa-lg'></i> Loading..."},
	 		
	        // Load data for the table's content from an Ajax source
	        "ajax": {
	            "url": "<?php echo site_url('pelanggan/data')?>",
	            "type": "POST",
	            "data":function ( d ) {
	                  return $.extend( {}, d, {
	                  		"src_nama": $('#src_nama').val(),
	                  		"src_hp":""
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

	function cetak(){

		window.open('<?php echo base_url() ?>pelanggan/cetak', '_blank');

	}
		
	function reload(){
		$("#src_nama").val("");
		$("#src_hp").val("");
		table.draw();
	}

	function edit(id){
		getId(id);
		$.ajax({
			url:"<?php echo base_url()?>pelanggan/edit",
			type:"POST",
			data: {id},
			daraType:"json",
			cache:false,
			beforeSend:function(){
				$(".inp").attr("disabled", "disabled");
			},
			success:function(data){
				$("#enama").val(data[0].nama_pelanggan);
				$("#ehp").val(data[0].no_hp);
				$("#ealamat").val(data[0].alamat);
				$("#eemail").val(data[0].email);
				$("#efax").val(data[0].fax);

			},
			complete:function(){
				$(".inp").removeAttr("disabled");
			}
		 });
	}

	function del(){
		var id = $("#get_id").val();
		$.ajax({
			url:"<?php echo base_url()?>pelanggan/hapus",
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