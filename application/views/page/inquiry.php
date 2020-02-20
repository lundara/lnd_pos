<div class="page-content">

				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
					Inquiry <small></small>
				</h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-question"></i>
							<a href="javascript:;">Inquiry</a>
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
									<i class="fa fa-database"></i> Data Inquiry
								</div>
								<div class="tools">
									<a href="javascript:;" class="collapse">
									</a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group col-md-5 col-sm-12 col-xs-12">
												<label>Pencarian Tanggal : </label>
												<input class="form-control date-mask" id="src_from" placeholder="Dari Tgl (dd/mm/yyyy)">
												<br>
												<input class="form-control date-mask" id="src_to" placeholder="Sampai Tgl (dd/mm/yyyy)">
												<br>
												<button class="btn green col-md-12 col-xs-12" onclick="src_tgl()">
													Cari
												</button>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group" style="float:right">
											<!--
												<a class="btn green" href="<?php echo base_url() ?>inquiry/excel">
													<i class="fa fa-download fa-lg"></i> Download
												</a>-->
												<button class="btn green" onclick="reload()">
													<i class="fa fa-refresh fa-lg"></i> Refresh
												</button>
												<button class="btn green" data-toggle="modal" data-target="#md-add">
													<i class="fa fa-plus fa-lg"></i> Tambah
												</button>
											</div>
										</div>
									</div>
									<table class="table table-striped table-bordered table-hover" id="datatable_ajax">
										<thead>
											<tr>
												<th width="5%"><center>#</center></th>
												<th>No. Inq</th>
												<th width="10%">Tanggal</th>
												<th>User</th>
												<th>Purchasing</th>
												<th>Total Item</th>
												<th width="10%"><center>Action</center></th>
											</tr>
										</thead>
										<thead>
											<tr>
												<th></th>
												<th><input class="form-control" id="src_po" placeholder="Cari No. Inquiry..."></th>
												<th></th>
												<th><input class="form-control" id="src_supplier" placeholder="Cari User..."></th>
												<th><input class="form-control" id="src_user" placeholder="Cari Petugas..."></th>
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

<div class="modal fade" id="md-det" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog ">
		<div class="modal-content ">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Detail Item</h4>
			</div>
			<form method="POST" id="edit-form">
				<div class="modal-body">
					<div class="row">
						 <div class="col-md-12 col-sm-12">
						 	<div class="form-group">
						 		Inquiry From : <span id="duntuk"></span>
						 	</div>
						 	<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<th><center>No</center></th>
										<th><center>Deskripsi</center></th>
										<th><center>Qty</center></th>
									</thead>
									<tbody id="dt-det">
										
									</tbody>

								</table>
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

<div class="modal fade" id="md-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-big">
		<div class="modal-content modal-content-big">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Tambah Inquiry</h4>
			</div>
			
				<div class="modal-body">
					<div class="row">
						<div class="col-md-8">
							<h4>No. Inquiry : <label id="no_po" style="font-weight: bold"></label></h4>
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<th><center>No</center></th>
										<th><center>Item</center></th>
										<th><center>Deskripsi</center></th>
										<th><center>Qty</center></th>
										<th><center>Action</center></th>
									</thead>
									<tbody id="dt">
										
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Nama Produk</label>
								<input type="hidden" class="form-control" id="item" onchange="get_harga()">
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-8">
										<input type="text" class="rupiah form-control" id="qty" style="text-align: right;" placeholder="Qty" autocomplete="off">
									</div>
									<div class="col-md-4">	
										<h4><span id="satuan"></span></h4>
									</div>
								</div>
							</div>
							<div class="form-group">
								<button class="btn blue" id="btn-add" onclick="add()"> <i class="fa fa-plus"></i> Tambah</button>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-8">
							<div class="col-md-6">
								<div class="form-group">
									<label>User </label>
									<input class="form-control" type="hidden" id="supplier">
								</div>
								<div class="form-group">
									<label>Inquiry Dari </label>
									<input class="form-control" type="text" id="untuk">
								</div>
							</div>
							<!--
							<div class="col-md-6">
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover">
										<tbody>
											<tr>
												<td width="50%">Total</td>
												<td id="total" align="right"></td>
											</tr>
											<tr>
												<td width="50%">PPN 10%</td>
												<td id="ppn" align="right">0</td>
											</tr>
											<tr>
												<td>Subtotal</td>
												<td id="gtotal" align="right"></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							-->

						</div>
						<div class="col-md-4"></div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn green" id="btn-gg" disabled="" data-toggle="modal" data-target="#md-save">Simpan Transaksi</button>
				</div>
			
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<div class="modal" id="md-save" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Simpan Transaksi</h4>
			</div>
			<div class="modal-body">
				
				<p style="text-align: center">
					<i class="fa fa-exclamation-triangle" style="font-size: 35px;color:#C23F44" ></i>&nbsp
					<label style="font-size: 35px;"> Apa anda yakin ? </label>
				</p>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn default" data-dismiss="modal">Batal</button>
				<button type="submit" class="btn red" id="btn-save"  onclick="save()">Proses</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<div class="modal" id="md-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Update Item <strong id="up"></strong> </h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Harga Beli</label>	
							<input type="text" id="hbeli" class="form-control rupiah einp">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Harga Jual</label>
							<input type="text" id="hjual" class="form-control rupiah einp">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Lead Time</label>	
							<input style="text-transform: uppercase;" id="etime" class="form-control einp">
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn default" data-dismiss="modal">Batal</button>
				<button type="submit" class="btn red" id="btn-save"  onclick="update()">Proses</button>
			</div>
		</div>
	</div>
</div>


<input type="hidden" id="get_id">
<input type="hidden" id="total_item">

<script>
	var table;
		
	$(document).ready(function() {
		get_trans();
		dt();
		select("pembayaran/select", "bayar");
		select("pembayaran/select", "src_bayar");
		//select2
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
	        }
	    };
	    $("#item").select2(sel_item);

	    var sel_supplier = {
	        placeholder: "Pilih",
	        minimumInputLength: 2,
	        ajax: {
	            url: '<?php echo base_url() ?>pelanggan/select2',
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
	            return "<div>" + option.nama_pelanggan + "</div>";
	        },
	        formatSelection: function (option) {
	            return option.nama_pelanggan;
	        }
	    };
	    $("#supplier").select2(sel_supplier);



		//Modal Setting
		$('#md-add').on('shown.bs.modal', function() {
		    $("#item").select2("focus");
		});


		$("#src_po").keypress(function(e) {
	      if(e.which == 13) {
	        table.draw();
	      }
	    });
	    $("#src_supplier").keypress(function(e) {
	      if(e.which == 13) {
	        table.draw();
	      }
	    });
	    $("#src_user").keypress(function(e) {
	      if(e.which == 13) {
	        table.draw();
	      }
	    });

	    //datatables
	    table = $('#datatable_ajax').DataTable({ 
	        "processing": true, //Feature control the processing indicator.
	        "serverSide": true, //Feature control DataTables' server-side processing mode.
	        "order": [[ 2, "desc" ]], //Initial no order.
	        "loadingMessage": 'Loading...',
	        "searching":false,
	        "aoColumnDefs": [
				{ "bSortable": false, "aTargets": [ 0,5 ] }
			],
			"oLanguage": {sProcessing: "<i class='fa fa-spinner fa-pulse fa-lg'></i> Loading..."},
	 		
	        // Load data for the table's content from an Ajax source
	        "ajax": {
	            "url": "<?php echo site_url('inquiry/data')?>",
	            "type": "POST",
	            "dataType":"json",
	            "data":function ( d ) {
	                  return $.extend( {}, d, {
	                  		"src_po": $('#src_po').val(),
	                  		"src_from" : toTglSys($("#src_from").val()),
	                  		"src_to" : toTglSys($("#src_to").val()),
	                  		"src_supplier" : $("#src_supplier").val(),
	                  		"src_user" : $("#src_user").val(),
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
					    	var left = $btnDropDown.offset().left - 220;
					    	var top = $btnDropDown.offset().top - 160;
					    }
					    else if(parseInt($btnDropDown.offset().left) >= 620 && parseInt($btnDropDown.offset().left)<870){
					    	var left = $btnDropDown.offset().left-210;
					    	var top = $btnDropDown.offset().top - 160;
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
    		"footerCallback": function( tfoot, data, start, end, display, gg ) {


			}
	 
	    });

	});
	
	function update(){

		var hjual = $("#hjual").val();
		var hbeli = $("#hbeli").val();
		var time  = $("#etime").val();
		var id    = $("#get_id").val();


		$.ajax({
			type:"POST",
			url:"<?php echo base_url() ?>inquiry/edit",
			dataType:"json",
			data:{hjual, hbeli, time, id},
			beforeSend:function(){
				$(".einp").attr("disabled", "disabled");
				$(".einp").val("");
			},
			success:function(data){
				if (data == "1") {
					notif("Success", "Item berhasil diupdate.", "success");
					$("#md-edit").modal("toggle");
				}
				else{
					notif("Error", "Item gagal diupdate.", "error");
				}
			},
			complete:function(){
				$(".einp").removeAttr("disabled");
			}
		});		
	}

	function edit(id, nm){

		$("#up").html(nm);
		$("#get_id").val(id);
		$.ajax({
			type:"POST",
			url:"<?php echo base_url() ?>inquiry/edit",
			dataType:"json",
			data:{id},
			beforeSend:function(){
				$(".einp").attr("disabled", "disabled");
				$(".einp").val("");
			},
			success:function(data){

				$("#hjual").val(data[0].harga);
				$("#hbeli").val(data[0].modal);
				$("#lead_time").val(data[0].lead_time);

			},
			complete:function(){
				$(".einp").removeAttr("disabled");
			}
		});		
	}

	function detail(id){

		$.ajax({
			type:"POST",
			url:"<?php echo base_url() ?>inquiry/detail",
			dataType:"json",
			data:{id},
			beforeSend:function(){
				$("#dt-det").html("<tr><td colspan='6' align='center'><i class='fa fa-spinner fa-pulse'></i> Loading...</td></tr>");
			},
			success:function(data){

				var len = data.length;
				var l = "";
				for(var i =0;i<len;i++){

					if (data[i].no_quot!=="") {
						var no_quot = "(<strong>"+data[i].no_quot+"</strong>) <i class='fa fa-check fa-lg font-green'></i>";
					}
					else{
						var no_quot = "";
					}


					l+="<tr>";
						l+="<td align='center'>"+(i+1)+"</td>";
						l+="<td>"+data[i].deskripsi+" "+no_quot+"</td>";
						l+="<td align='right'>"+data[i].qty+"</td>";
						/*
						l+="<td align='center'>";
								l+="<a href='javascript:;' data-toggle='modal' data-target='#md-edit' onclick='edit("+data[i].id+", \""+data[i].deskripsi+"\")'>";
									l+="<i class='fa fa-pencil fa-lg'></i>";
								l+="</a>";
						l+="</td>";*/
					l+="</tr>";
				}

				$("#duntuk").html(data[0].untuk);

				$("#lsub").html(data[len-1].subtotal);
				$("#lppn").html(data[len-1].ppn);
				$("#lgtotal").html(data[len-1].gtotal);

				$("#dt-det").html(l);

			},
			complete:function(){
				
			}
		});

	}
	function src_tgl(){

		var fr = $("#src_from").val();
		var to = $("#src_to").val();

		if (fr && to !=="") {
			table.draw()
		}
		else{
			notif("Error", "Lengkapi form pencarian.", "error");
		}

	}
	function save(){
		get_trans();
		var no_trans = $("#no_po").text();
		var item = $("#total_item").val();
		var untuk = $("#untuk").val();
		var supplier = $("#supplier").val();

		if (no_trans !== "") {

			$.ajax({

				type:"POST",
				url:"<?php echo base_url() ?>inquiry/save",
				dataType:"json",
				data:{no_trans, item, supplier, untuk},
				beforeSend:function(){
					$("#btn-save").html(loading_event());
					$("#btn-save").attr("disabled", "disabled");
				},
				success:function(data){

					switch(parseFloat(data)){

						case 1:
							notif("Success","Inquiry berhasil disimpan.", "success");
							get_trans();
							table.draw();
							dt();

							$("#supplier").select2("val", "");

							$("#untuk").val("");

							$("#md-save").modal("toggle");
							$("#md-add").modal("toggle");
						break;

						case 0:
							get_trans();
							notif("Error","Inquiry gagal disimpan.", "error");
						break;

					}

				},
				complete:function(){
					$("#btn-save").html("Proses");
					$("#btn-save").removeAttr("disabled");
				}

			});

		}
		else{
			notif("Error", "Lengkapi semua data.", "error");
		}

	}
	function cek_total(v){

		if (parseInt(v)!=0 || parseInt(v)!="") {
			$("#btn-gg").removeAttr("disabled");
		}
		else{
			$("#btn-gg").attr("disabled", "disabled");
		}

	}
	function dt(){
		$.ajax({

			type:"POST",
			url:"<?php echo base_url();?>Inquiry/data_item",
			dataType:"json",
			beforeSend:function(){
				$("#dt").html("<tr><td colspan='5' align='center'><i class='fa fa-spinner fa-pulse'></i> Loading...</td></tr>");
			},
			success:function(data){

				var l = "";
				cek_total();
				get_trans();
				if (data.length!=0) {
					cek_total(data[0].total_item);
					var total = 0;
					var pt = 0;
					for(var i = 0 ; i<data.length ; i++){
						total+= parseInt(data[i].brutto);
						pt+=parseInt(data[i].pot);
						l+="<tr>";
							l+="<td align='center'>"+(i+1)+"</td>";
							l+="<td>"+data[i].nama_item+"</td>";
							l+="<td align='left'>"+data[i].desc+"</td>";
							l+="<td align='center'>"+parseInt(data[i].qty).toLocaleString('de-DE')+" "+data[i].satuan+"</td>";
							l+="<td align='center'><a href='javascript:;' id='btn-del-"+i+"' onclick='del("+data[i].id+", "+i+")'><i class='fa fa-trash fa-lg'></i></a></td>";
						l+="</tr>";

					}
					var tax = ((total - pt) * 10 / 100);
					var gtotal  = ((total - pt)+tax).toLocaleString("de-DE");
					if (pt <= 0) {
						var min = "";
					}
					else{
						var min = "-";
					}
					
					$("#total").html(total.toLocaleString("de-DE"));
					//$("#tdisc").html(min+pt.toLocaleString("de-DE"));
					$("#gtotal").html(gtotal);
					$("#total_item").val(data.length);
					$("#ppn").html(tax.toLocaleString("de-DE"));

				}
				else{
					cek_total(0);
					l+="<tr><td colspan='5' align='center'>Tidak ada data.</td></tr>";
					
					$("#total").html("0");
					//$("#tdisc").html("0");
					$("#gtotal").html("0");
					$("#total_item").val("0");

				}

				$("#dt").html(l);

			},
			complete:function(){
				
			}

			});
	}
	function del(id, i){

		$.ajax({

			type:"POST",
			url:"<?php echo base_url();?>inquiry/del",
			dataType:"json",
			data:{id},
			beforeSend:function(){
				$("#btn-del-"+i).html("<i class='fa fa-spinner fa-pulse fa-lg'></i>");
				$("#btn-del-"+i).bind('click', false);
			},
			success:function(data){

				dt();
				get_trans();
				$('#item').select2('focus');

			},
			complete:function(){
				$("#btn-del-"+i).html("<i class='fa fa-trash fa-lg'></i>");
				$("#btn-del-"+i).unbind('click', false);
			}

		});

	}
	function add(){
		$("#md-delete").modal("toggle");
		var g = $("#item").select2("data"); 
		delete g.element; 

		var satuan 		= g["nama_satuan"];
		var id 			= g["id"];
		var qty 		= $("#qty").val();


		if (id && qty !=="") {
			$.ajax({

				type:"POST",
				url:"<?php echo base_url();?>inquiry/add",
				dataType:"json",
				data:{id, qty, satuan},
				beforeSend:function(){
					$("#btn-add").html(loading_event());
					$("#btn-add").attr("disabled", "disabled");
				},
				success:function(data){

					switch(parseFloat(data)){

						case 0:
							notif("Error", "Item gagal ditambahkan.", "error");
						break;

						case 1:
							dt();
							get_trans();
							//notif("Success", "Produk berhasil ditambahkan.", "success");
							$("#qty").val("");
							$("#item").select2("val", "");
						break;

					}

				},
				complete:function(){
					$('#item').select2('focus');
					$("#btn-add").html("<i class='fa fa-plus'></i> Tambahkan");
					$("#btn-add").removeAttr("disabled");
				}

			});
		}
		else{
			notif("Error", "Item Produk terlebih dahulu.", "error");
		}

	}


	function get_trans(){
		$.ajax({
			type:"POST",
			url:"<?php echo base_url() ?>inquiry/get_trans",
			dataType:"json",
			success:function(data){
				$("#no_po").html(data[0].no_trans);
			}
		});

		
	}
	function get_harga(){

		var data = $("#inq").select2("data"); 
		delete data.element; 

		var harga 	= data["harga"];
		var satuan 	= data["nama_satuan"];
		var id 		= data["id"];

		
		if (id!="") {
			$("#satuan").html(satuan);
			//$("#harga").val(parseInt(harga).toLocaleString("de-DE"));
			$("#qty").focus();
		}
		
		
	}
		
	function reload(){
		$("#src_po").val("");
		$("#src_from").val("");
		$("#src_to").val("");
		$("#src_user").val("");
		$("#src_supplier").val("");

		table.draw();
	}


	function getId(id){
		$("#get_id").val(id);
	}

</script>