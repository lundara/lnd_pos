<div class="page-content">

				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
					Kartu Stok <small></small>
				</h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="javascript:;">Kartu Stok</a>
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
									<i class="fa fa-cubes f-white"></i> Kartu Stok
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
										</div>
									</div>
									<table class="table table-striped table-bordered table-hover" id="datatable_ajax">
										<thead>
											<tr>
												<th width="5%"><center>#</center></th>
												<th>Nama Produk</th>
												<th width="5%">Stok Awal</th>
												<th width="5%">Jual</th>
												<th width="5%">Beli</th>
												<th width="5%">Penyesuaian</th>
												<th width="5%">R. Jual</th>
												<th width="5%">R. Beli</th>
												<th width="5%">Stok Akhir</th>
											</tr>
										</thead>
										<thead>
											<tr>
												<th></th>
												<th><input class="form-control" id="src_nama" placeholder="Cari Produk..."></th>
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
	            "url": "<?php echo site_url('kartu_stok/data')?>",
	            "type": "POST",
	            "data":function ( d ) {
	                  return $.extend( {}, d, {
	                  		"src_nama": $('#src_nama').val(),
	                  		"src_kode": "",
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