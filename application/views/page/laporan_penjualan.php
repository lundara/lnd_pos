<div class="page-content">

				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
					Laporan Penjualan Bebas <small></small>
				</h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-cart-plus"></i>
							<a href="<?php echo base_url() ?>penjualan">Penjualan Bebas</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="javascript:;">Laporan</a>
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

											<div class="form-group" style="float: right;clear: both;">
												<button class="btn green" onclick="reload()" >
													<i class="fa fa-refresh fa-lg"></i> Refresh
												</button>
											</div>
										</div>
									</div>
									<table class="table table-striped table-bordered table-hover" id="datatable_ajax">
										<thead>
											<tr>
												<th width="5%"><center>#</center></th>
												<th>No Transaksi</th>
												<th>Tanggal</th>
												<th>User</th>
												<th>Total</th>
												<th>Bayar</th>
												<th width="20%"><center>Action</center></th>
											</tr>
										</thead>
										<thead>
											<tr>
												<th></th>
												<td valign="top">
													<input class="form-control" id="src_no" placeholder="Cari No Transaksi ...">
												</td>
												<th>
												</th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											
										</tbody>
										<tfoot>
								            <tr bgcolor="#ddfdff">
								                <th colspan="4"><center><strong>TOTAL PENJUALAN</strong></center></th>
								                <th style="text-align: right" id="sum"></th>
								                <th></th>
								                <th></th>

								            </tr>
								        </tfoot>
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
				<h4 class="modal-title">Detail Transaksi <strong id="lno"></strong> </h4>
			</div>
			<form id="add-form">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th>No</th>
											<th>Nama Produk</th>
											<th>Harga</th>
											<th>Qty</th>
											<th>Disc</th>
											<th>Subtotal</th>
										</tr>
									</thead>
									<tbody id="dt_detail">

									</tbody>
									<tbody>
										<tr>
											<td colspan="5" align="center"><strong>GRAND TOTAL</strong></td>
											<td id="gtotal" align="right" style="font-weight: bold;">0</td>
										</tr>
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

<div class="modal fade" id="md-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Hapus Cabang</h4>
			</div>
			<div class="modal-body">
				
				<div class="row">
					<div class="col-md-12">
						<label>Nominal</label>
						<input type="text" class="form-control" id="nominal">
					</div>
				</div>

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
		$('.tooltips').tooltip();
		//Modal Setting
		$('#md-add').on('shown.bs.modal', function() {
		    $("#nama").focus();
		});

		$('#md-detail').on('shown.bs.modal', function() {
		    $('.tooltips').tooltip();
		});



		$("#src_no").keypress(function(e) {
	      if(e.which == 13) {
	        table.draw();
	      }
	    });
	    $("#src_kode").keypress(function(e) {
	      if(e.which == 13) {
	        table.draw();
	      }
	    });
	   	$("#src_from").keypress(function(e) {
	      if(e.which == 13) {
	        table.draw();
	      }
	    });
	    $("#src_to").keypress(function(e) {
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
				{ "bSortable": false, "aTargets": [ 0,4,5,6 ] }
			],
			"oLanguage": {sProcessing: "<i class='fa fa-spinner fa-pulse fa-lg'></i> Loading..."},
	 		
	        // Load data for the table's content from an Ajax source
	        "ajax": {
	            "url": "<?php echo site_url('penjualan/data_laporan')?>",
	            "type": "POST",
	            "data":function ( d ) {
	                  return $.extend( {}, d, {
	                  		"src_no": $('#src_no').val(),
	                  		"src_from": toTglSys($('#src_from').val()),
	                  		"src_to": toTglSys($('#src_to').val())
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
			"footerCallback": function( tfoot, data, start, end, display, gg ) {

				var len = data.length;

				var t = 0;
				for (var i = 0; i < len;i++){
					t+=data[i][1];
				}
				
			    if (t !==0) {
					$(tfoot).find('th').eq(1).html(data[0][7]);
				}
				else{
					$(tfoot).find('th').eq(1).html("0");
				}

			}
	
	 
	    });


	});

	function detail(id){

		$("#lno").html(id);

		$.ajax({
			url:"<?php echo base_url() ?>penjualan/detail_transaksi",
			type:"POST",
			dataType:"json",
			data:{id},
			beforeSend:function(){
				$("#dt_detail").html("<tr><td colspan='6' align='center'><i class='fa fa-spinner fa-pulse'></i> Loading...</td></tr>");
			},
			success:function(data){
				var len = data.length;

				if (len !=0) {

					var d = "";
					var gtotal = 0;
					for(var i = 0;i<len;i++){
						var qty_jadi = parseInt(data[i].qty) - parseInt(data[i].qty_retur);
						var pot 		= (parseInt(data[i].harga) * qty_jadi ) * parseInt(data[i].disc_produk) / 100;
						var subtotal 	= (parseInt(data[i].harga) * qty_jadi ) - pot;

						if (data[i].retur == "Y") {
							var produk = "<span class='tooltips' data-placement='top' data-original-title='"+data[i].alasan_retur+"'>"+data[i].nama_produk+"</span>";
							

							if (parseInt(data[i].qty_retur) == parseInt(data[i].qty)) {
								var coret = "text-decoration:line-through;";
								gtotal+=0;
							}
							else{
								var coret = "";
								gtotal+=subtotal;
							}

							var min   = "<span style='color:red'> - "+data[i].qty_retur+"</span>";

						}
						else{
							var produk = data[i].nama_produk;
							gtotal+=subtotal;
							var min = "";
							var coret = "";
						}

						d+="<tr style='"+coret+"'>";
							d+="<td align='center'>"+(i+1)+"</td>";
							d+="<td>"+produk+"</td>";
							d+="<td align='right'>"+parseInt(data[i].harga).toLocaleString('de-DE')+"</td>";
							d+="<td align='right'>"+parseInt(data[i].qty).toLocaleString('de-DE')+min+" "+data[i].nama_satuan+"</td>";
							d+="<td align='right'>"+data[i].disc_produk+" %</td>";
							d+="<td align='right'>"+subtotal.toLocaleString("de-DE")+"</td>";
						d+="</tr>";

						
					}
					$("#dt_detail").html(d);
					$("#gtotal").html(gtotal.toLocaleString("de-DE"))

				}
				else{
					$("#dt_detail").html("<tr><td colspan='6' align='center'>Tidak ada data.</td></tr>");
				}

				$('.tooltips').tooltip();
			},
			complete:function(){
				$('.tooltips').tooltip();
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
		
	function reload(){
		$("#src_no").val("");
		$("#src_from").val("");
		$("#src_to").val("");
		table.draw();
	}

	function getId(id){
		$("#get_id").val(id);
	}

</script>