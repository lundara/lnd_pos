<div class="page-content">

				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
					Stok Gudang <?php echo $g['nama_gudang'] ?> <small></small>
				</h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-cube"></i>
							<a href="javascript:;">Stok Gudang <?php echo $g['nama_gudang'] ?></a>
						</li>
					</ul>
					
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row">
					<div class="col-md-12">
						<div class="portlet box green">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-database"></i> Data Stok Gudang <?php echo $g['nama_gudang'] ?>
								</div>
								<div class="tools">
									<a href="javascript:;" class="collapse">
									</a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="row">
									<div class="col-md-12 col-sm-12">
										<div class="form-group" style="float:right">
											<button class="btn green" onclick="reload()">
												<i class="fa fa-refresh fa-lg"></i> Refresh
											</button>
										</div>
									</div>
									<div class="col-md-12 col-sm-12">
										<table class="table table-striped table-bordered table-hover" id="datatable_ajax">
											<thead>
												<tr>
													<th width="5%"><center>#</center></th>
													<th>Nama Produk</th>
													<th>Merk</th>
													<th>Stok</th>
													<th>Satuan</th>
													<th width="20%"><center>Action</center></th>
												</tr>
											</thead>
											<thead>
												<tr>
													<th></th>
													<th><input class="form-control" id="src_nama" placeholder="Cari Item..."></th>
													<th><input class="form-control" id="src_desc" placeholder="Cari Merk..."></th>
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
				</div>
				<!-- END PAGE CONTENT-->
</div>
<div class="modal fade" id="md-masuk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Masuk Barang</h4>
			</div>
			<form id="add-form">
				<div class="modal-body">
						<div class="row">
							 <div class="col-md-6 col-sm-12 col-xs-12">
							 	<div class="form-group">
									<label>Qty<small class="require"></small></label>
									<input type="text" class="form-control" id="qty" autocomplete="off" >
								</div>
							 </div>
							 <div class="col-md-6 col-sm-12 col-xs-12">
							 	<div class="form-group">
								 	<label>Satuan</label><br>
								 	<span id="satuan" style="font-size: 20px;"></span>
							 	</div>
							 </div>
						</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn default" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn green" id="btn-masuk">Simpan</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<input type="s" id="get_id">

<script>

	var table;
	 
	$(document).ready(function() {
		$('#md-masuk').on('shown.bs.modal', function() {
		    $("#qty").focus();
		});
		$("#add-form").submit(function(e){
			e.preventDefault();

			masuk();
		});

	    var sel_item = {
	        placeholder: "Pilih",
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
	            return "<div>" + option.desc + "</div>";
	        },
	        formatSelection: function (option) {
	            return option.desc;
	        },

	    };
	    $("#produk").select2(sel_item);

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
	    //datatables
	    table = $('#datatable_ajax').DataTable({ 
	        "processing": true, //Feature control the processing indicator.
	        "serverSide": true, //Feature control DataTables' server-side processing mode.
	        "order": [[ 1, "asc" ]], //Initial no order.
	        "loadingMessage": 'Loading...',
	        "searching":false,
	        "aoColumnDefs": [
				{ "bSortable": false, "aTargets": [ 0,4,5 ] }
			],
			"oLanguage": {sProcessing: "<i class='fa fa-spinner fa-pulse fa-lg'></i> Loading..."},
	 		
	        // Load data for the table's content from an Ajax source
	        "ajax": {
	            "url": "<?php echo site_url('stok_pitstop/data')?>",
	            "type": "POST",
	            "data":function ( d ) {
	                  return $.extend( {}, d, {
	                  		"src_nama": $('#src_nama').val(),
	                  		"src_desc": $('#src_desc').val(),
	                  		"src_gudang": "<?php echo $g['id'] ?>"
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
					    	var top = $btnDropDown.offset().top - 260;
					    }
					    else if(parseInt($btnDropDown.offset().left) >= 620 && parseInt($btnDropDown.offset().left)<870){
					    	var left = $btnDropDown.offset().left-210;
					    	var top = $btnDropDown.offset().top - 220;
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
	            },
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
	function masuk(){
		//var produk = $("#produk").val();
		var qty = $("#qty").val();
		var id = $("#get_id").val();

		if (qty && id !== "") {

			$.ajax({

				type:"POST",
				url:"<?php echo base_url() ?>stok_pitstop/masuk",
				dataType:"json",
				data:{qty, id},
				beforeSend:function(){
					$("#btn-masuk").html(loading_event());
					$("#btn-masuk").attr("disabled", "disabled");
				},
				success:function(data){

					switch(parseFloat(data)){

						case 1:
							notif("Success","Stok berhasil diperbaharui.", "success");
							table.ajax.reload(null, false);
								
							$("#md-masuk").modal("toggle");
							$("#qty").val("")
						break;

						case 0:
							notif("Error","Stok gagal diperbaharui.", "error");
						break;

					}

				},
				complete:function(){
					$("#btn-masuk").html("Simpan");
					$("#btn-masuk").removeAttr("disabled");
				}

			});

		}
		else{
			notif("Error", "Lengkapi Semua Data yang wajib diisi.", "error");
		}

	}
	function get_produk(){

		var data = $("#produk").select2("data"); 
		delete data.element; 

		var satuan 	= data["nama_satuan"];
		var id 		= data["id"];

		
		if (id!="") {
			$("#satuan").html(satuan);
			$("#qty").focus();
		}
		
		
	}
		
	function reload(){
		$("#src_nama").val("");
		$("#src_desc").val("");
		table.draw();
	}


	function getId(id, satuan){
		$("#get_id").val(id);
		$("#satuan").html(satuan);
	}

</script>