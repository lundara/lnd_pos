<div class="page-content">

				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
					Invoice Out LAMA<small></small>
				</h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-cubes"></i>
							<a href="javascript:;">Invoice Out LAMA</a>
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
									<i class="fa fa-database"></i> Data Invoice Out LAMA
								</div>
								<div class="tools">
									<a href="javascript:;" class="collapse">
									</a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="">
									<?php //$this->load->view("port/alert_perbaikan"); ?>
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
												<a class="btn green" href="javascript:;" onclick='unduh()'>
													<i class="fa fa-download fa-lg"></i> Download
												</a>
												<button class="btn green" onclick="reload()">
													<i class="fa fa-refresh fa-lg"></i> Refresh
												</button>
												<button class="btn green" data-toggle="modal" data-target="#md-add">
													<i class="fa fa-plus fa-lg"></i> Tambah
												</button>
												<!--
												<button class="btn green" data-toggle="modal" data-target="#md-add2">
													<i class="fa fa-plus fa-lg"></i> Tambah Dari Inquiry
												</button>-->
											</div>
										</div>
									</div>
									<table class="table table-striped table-bordered table-hover" id="datatable_ajax">
										<thead>
											<tr>
												<th width="5%"><center>#</center></th>
												<th>No. Invoice</th>
												<th>No. PO</th>
												<th>No. DO</th>
												<th width="10%">Tanggal</th>
												<th>User</th>
												<th>Bayar</th>
												<th width="15%">Terms</th>
												<th>Admin</th>
												<th width="15%"><center>Action</center></th>
											</tr>
										</thead>
										<thead>
											<tr>
												<th></th>
												<th><input class="form-control" id="src_inv" placeholder="Cari No. Inv..."></th>
												<th><input class="form-control" id="src_po" placeholder="Cari No. PO..."></th>
												<th></th>
												<th></th>
												<th><input class="form-control" id="src_supplier" placeholder="Cari User..."></th>
												<th></th>
												<th>
													<select class="form-control select2me" id="src_bayar">
														<option value="">Pilih</option>
													</select>
												</th>
												<th><input class="form-control" id="src_user" placeholder="Cari Admin..."></th>
												<th></th>
											</tr>
										</thead>
									<tbody>
										
									</tbody>
									<tbody>
										<tr>
											<td colspan="6" align="center"><strong>TOTAL KESELURUHAN</strong></td>
											<td id="total_all" align="right" style="font-weight: bold;"></td>
											<td></td>
											<th></th>
											<th></th>
										</tr>
									</tbody>
									</table>
									
								</div>
							</div>
						</div>

					</div>
				</div>
				<!-- END PAGE CONTENT-->
</div>


<div class="modal fade" id="md-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-big">
		<div class="modal-content modal-content-big">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Tambah Invoice Out LAMA</h4>
			</div>
			
				<div class="modal-body">
					<div class="row">
						<div class="col-md-8">
							<div class="form-group">
								<label style="font-weight: bold">No. Invoice Out :</label>
								<input type="text" class="form-control inp-sm" id="no_inv" style="width: 200px;">
							</div>
							<div class="form-group">
								<label style="font-weight: bold">Tgl. Invoice Out :</label>
								<input type="text" class="form-control inp-sm date-mask" id="tgl_inv" style="width: 200px;">
							</div>
						 	<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<th><center>No</center></th>
										<th><center>Deskripsi</center></th>
										<th><center>Qty</center></th>
										<th><center>Harga Beli</center></th>
										<th><center>Harga Jual</center></th>
										<th><center>Disc%</center></th>
										<th><center>Delivery Date</center></th>
										<th><center>Total</center></th>
									</thead>
									<tbody id="dt-det">
										
									</tbody>
									<tfoot>
										<tr>
											<th colspan="7"><center>SUBTOTAL</center></th>
											<th id="lsub" style="text-align: right;"></th>
										</tr>
										<tr>
											<th colspan="7"><center>PPN 10%</center></th>
											<th id="lppn" style="text-align: right;"></th>
										</tr>
										<tr>
											<th colspan="7"><center>GRAND TOTAL</center></th>
											<th id="lgtotal" style="text-align: right;"></th>
										</tr>
										<tr>
											<th colspan="7"><center>PEMBAYARAN</center></th>
											<th id="lbayar" style="text-align: right;"></th>
										</tr>
										<tr>
											<th colspan="7"><center>SISA</center></th>
											<th id="lsisa" style="text-align: right;"></th>
										</tr>
									</tfoot>
								</table>
						 	</div>
						 	<div class="row">
						 		<div class="col-md-6">
						 			<div class="form-group">
								 		<label>Jatuh Tempo <span class="require"></span></label>
								 		<input class="form-control date-mask" id="tempo" placeholder="dd/mm/yyyy">
								 	</div>
								 	<div class="form-group">
								 		<label>Bayar <span class="require"></span></label>
								 		<input class="form-control rupiah" id="bayar" style="text-align: right;">
								 	</div>

						 		</div>
						 		<div class="col-md-6">
								 	<div class="form-group">
								 		<label>Type <span class="require"></span></label>
								 		<select class="form-control select2me" id="type">
								 			<option value="">- Pilih -</option>
								 			<option value="biasa">Biasa</option>
								 			<option value="performa">Performa</option>
								 		</select>
								 	</div>
								 	<div class="form-group">
								 		<label>DO <span class="require"></span></label>
								 		<select class="form-control select2me" id="do" onchange="get_do()">
								 			<option value="">- Pilih -</option>
								 			<option value="yes">YES</option>
								 			<option value="no">NO</option>
								 		</select>
								 		<label id="no_do" style="font-weight: bold"></label>
								 	</div>
						 		</div>
						 	</div>

						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>No. PO In</label>
								<input type="hidden" class="form-control" id="po" onchange="get_po()">
							</div>
							<div class="form-group">
								<label>Tanggal PO</label><br>
								<span id="tgl_po" style="font-weight: bold"></span>
							</div>
							<div class="form-group">
								<label>User</label><br>
								<span id="pelanggan" style="font-weight: bold"></span>
							</div>
							<div class="form-group">
								<label>Term</label><br>
								<span id="term" style="font-weight: bold"></span>
							</div>

						</div>
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


<input type="hidden" id="get_id">
<input type="hidden" id="total_item">
<input type="hidden" id="total_item2">
<input type="hidden" id="trans">
<input type="hidden" id="idproduk">
<input id="val_ppn" type="hidden" value="Y">
<input id="vinv" type="hidden">
<input id="poin" type="hidden">
<script>
	var table;
		
	$(document).ready(function() {

		$("#ppn_cek").change(function() {  
		     if($(this).is(":checked")) {
		        $("#val_ppn").val("Y");
		        $("#ppn").show();
		        $("#ppn_no").hide();
		        dt();
		     }
		      else {
		        $("#val_ppn").val("N");
		        $("#ppn").hide();
		        $("#ppn_no").show();
		        dt();
		     }
	    });


		$('.tooltips').tooltip();
		get_trans();
		dt();
		//select2
	    var sel_po = {
	        placeholder: "Pilih",
	        minimumInputLength: 2,
	        ajax: {
	            url: '<?php echo base_url() ?>po_in/select2',
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
	            return "<div>" + option.no_po + "</div>";
	        },
	        formatSelection: function (option) {
	            return option.no_po;
	        }
	    };
	    $("#po").select2(sel_po);


		//Modal Setting
		$('#md-add').on('shown.bs.modal', function() {
		    $("#po").select2("focus");
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
	    $("#src_bayar").change(function(e) {
	      table.draw();
	    });
	    //datatables
	    table = $('#datatable_ajax').DataTable({ 
	        "processing": true, //Feature control the processing indicator.
	        "serverSide": true, //Feature control DataTables' server-side processing mode.
	        "order": [[ 4, "desc" ]], //Initial no order.
	        "loadingMessage": 'Loading...',
	        "searching":false,
	        "aoColumnDefs": [
				{ "bSortable": false, "aTargets": [ 0,6,8 ] }
			],
			"oLanguage": {sProcessing: "<i class='fa fa-spinner fa-pulse fa-lg'></i> Loading..."},
	 		
	        // Load data for the table's content from an Ajax source
	        "ajax": {
	            "url": "<?php echo site_url('invoice_out/data')?>",
	            "type": "POST",
	            "dataType":"json",
	            "data":function ( d ) {
	                  return $.extend( {}, d, {
	                  		"src_po": $('#src_po').val(),
	                  		"src_from" : toTglSys($("#src_from").val()),
	                  		"src_to" : toTglSys($("#src_to").val()),
	                  		"src_supplier" : $("#src_supplier").val(),
	                  		"src_inv" : $("#src_inv").val(),
	                  		"src_user" : $("#src_user").val(),
	                  		"src_bayar" : $("#src_bayar").val(),
	                  		//"src_status" : $("#src_status").val()
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

					var len = data.length;

				    if (len !==0) {
						//$(tfoot).find('th').eq(1).html(data[0][7]);
						$("#total_all").html(parseInt(data[len-1][10]).toLocaleString("de-DE"));
					}
					else{
						$("#total_all").html("0");
						//$(tfoot).find('th').eq(1).html("0");
					}

				}
	 
	    });

	});
	


	function unduh(){
		//<?php echo base_url() ?>invoice_out/excel?src_supplier=kerta
		var src_po 			= $("#src_po").val();
		var src_from 		= toTglSys($("#src_from").val());
		var src_to 			= toTglSys($("#src_to").val());
		var src_supplier 	= $("#src_supplier").val();
		var src_user 		= $("#src_user").val();
		var src_status 		= "";
		var src_bayar 		= $("#src_bayar").val();
		var src_inv 		= $("#src_inv").val();

		window.open('<?php echo base_url() ?>invoice_out/excel?src_po='+src_po+'&src_from='+src_from+'&src_to='+src_to+'&src_supplier='+src_supplier+'&src_user='+src_user+'&src_status='+src_status+'&src_bayar='+src_bayar+'&src_inv='+src_inv, '_blank');

	}


	function detail(id){

		$.ajax({
			type:"POST",
			url:"<?php echo base_url() ?>po_in/detail",
			dataType:"json",
			data:{id},
			beforeSend:function(){
				$("#dt-det").html("<tr><td colspan='8' align='center'><i class='fa fa-spinner fa-pulse'></i> Loading...</td></tr>");
			},
			success:function(data){

				var len = data.length;
				var l = "";
				for(var i =0;i<len;i++){
					l+="<tr>";
						l+="<td align='center'>"+(i+1)+"</td>";
						l+="<td><span class='tooltips' data-placement='top' data-original-title='"+data[i].ket+"'>"+data[i].deskripsi+"</Simpan></td>";
						l+="<td align='right'>"+data[i].qty+"</td>";
						l+="<td align='right'>"+data[i].modal+"</td>";
						l+="<td align='right'>"+data[i].harga+"</td>";
						l+="<td align='right'>"+data[i].disc+"%</td>";
						l+="<td align='center'>"+data[i].delivery_date+"</td>";
						l+="<td align='right'>"+data[i].total+"</td>";
					l+="</tr>";
				}

				$("#lsub").html(data[len-1].subtotal);
				$("#lppn").html(data[len-1].ppn);
				$("#lgtotal").html(data[len-1].gtotal);

				$("#dt-det").html(l);

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
	function save(){
		get_trans();
		var no_trans = $("#no_inv").val();
		var bayar = $("#bayar").val();
		var tempo = toTglSys($("#tempo").val());
		var po = $("#poin").val();
		var sisa = $("#lsisa").text();
		var type = $("#type").val();
		var no_do = $("#no_do").text();
		var tgl_inv = toTglSys($("#tgl_inv").val());

		if (no_trans && bayar && tempo && po && type && no_do && tgl_inv !== "") {

			$.ajax({

				type:"POST",
				url:"<?php echo base_url() ?>invoice_out_lama/save",
				dataType:"json",
				data:{no_trans, bayar, tempo, po, sisa, type, no_do, tgl_inv},
				beforeSend:function(){
					$("#btn-save").html(loading_event());
					$("#btn-save").attr("disabled", "disabled");
				},
				success:function(data){

					switch(parseFloat(data)){

						case 1:
							notif("Success","Invoice Out berhasil disimpan.", "success");
							get_trans();
							table.draw();
							dt();

							$("#po").select2("val", "");
							$("#bayar").val("");
							$("#tempo").val("");
							$("#poin").val("");
							$("#no_inv").val("");
							$("#tgl_inv").val("");
							$("#md-save").modal("toggle");
							$("#md-add").modal("toggle");

							$("#type").val("");
							$("#type").trigger("change");
							$("#do").val("");
							$("#do").trigger("change");

							$("#tgl_po").html("");
							$("#term").html("");
							$("#pelanggan").html("");

							$("#dt-det").html("");

							$("#lbayar").html("0");
							$("#lsisa").html("0");
							$("#lgtotal").html("0");
							$("#lppn").html("0");
							$("#lsub").html("0");

							$("#")
						break;

						case 0:
							get_trans();
							notif("Error","Invoice Out gagal disimpan.", "error");
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
			notif("Error", "Lengkapi Semua Data yang wajib diisi.", "error");
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
			url:"<?php echo base_url();?>invoice_out/data_item",
			dataType:"json",
			beforeSend:function(){
				$("#dt").html("<tr><td colspan='10' align='center'><i class='fa fa-spinner fa-pulse'></i> Loading...</td></tr>");
			},
			success:function(data){

				var l = "";
				//cek_total();
				get_trans();
				if (data.length!=0) {
					//cek_total(data[0].total_item);
					var total = 0;
					var pt = 0;
					for(var i = 0 ; i<data.length ; i++){
						total+= parseInt(data[i].netto);
						pt+=parseInt(data[i].pot);
						l+="<tr>";
							l+="<td align='center'>"+(i+1)+"</td>";
							l+="<td>"+data[i].nama_item+"</td>";
							l+="<td align='left'><span class='tooltips' data-placement='top' data-original-title='"+data[i].ket+"'>"+data[i].desc+"</span></td>";
							l+="<td align='center'>"+data[i].dd+"</td>";
							l+="<td align='center'>"+parseInt(data[i].qty).toLocaleString('de-DE')+" "+data[i].satuan+"</td>";
							l+="<td align='right'>"+parseInt(data[i].modal).toLocaleString('de-DE')+"</td>";
							l+="<td align='right'>"+parseInt(data[i].harga).toLocaleString('de-DE')+"</td>";
							l+="<td align='right'>"+parseInt(data[i].disc).toLocaleString('de-DE')+"</td>";
							l+="<td align='right'>"+parseInt(data[i].netto).toLocaleString('de-DE')+"</td>";
							l+="<td align='center'><a href='javascript:;' id='btn-del-"+i+"' onclick='del("+data[i].id+", "+i+")'><i class='fa fa-trash fa-lg'></i></a></td>";
						l+="</tr>";

					}

					var cek_ppn = $("#val_ppn").val();

					var tax = ((total - pt) * 10 / 100);

					if (cek_ppn=="Y") {
						var gtotal  = ((total - pt)+tax).toLocaleString("de-DE");
					}
					else{
						var gtotal  = (total - pt).toLocaleString("de-DE");
					}
					
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
					//cek_total(0);
					l+="<tr><td colspan='10' align='center'>Tidak ada data.</td></tr>";
					
					$("#total").html("0");
					//$("#tdisc").html("0");
					$("#gtotal").html("0");
					$("#total_item").val("0");
					$("#ppn").html("0");

				}

				$("#dt").html(l);

			},
			complete:function(){
				$('.tooltips').tooltip();
			}

			});
	}

	function del(id, i){

		$.ajax({

			type:"POST",
			url:"<?php echo base_url();?>invoice_out/del",
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

		var harga 		= $("#harga").val();
		var satuan 		= g["nama_satuan"];
		var id 			= g["id"];
		var qty 		= $("#qty").val();
		var ket 		= $("#ket").val();
		var disc   	 	= $("#disc").val();
		var dd 			= $("#dd").val();
		var modal 		= $("#modal").val();


		if (id && qty !=="") {
			$.ajax({

				type:"POST",
				url:"<?php echo base_url();?>invoice_out/add",
				dataType:"json",
				data:{id, qty, harga, satuan, ket, disc, dd, modal},
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
							$("#harga").val("");
							$("#ket").val("");
							$("#disc").val("");
							$("#dd").val("");

							
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
			url:"<?php echo base_url() ?>invoice_out/get_trans",
			dataType:"json",
			success:function(data){
				$("#no_inv").html("INV/"+data[0].no_trans+"/CBT");
				$("#vinv").val(data[0].no_trans);
				//$("#no_po2").html(data[0].no_trans);
			}
		});

		
	}
	function get_do(){
		var d = $("#do").val();

		if (d == "yes") {
			$.ajax({
				type:"POST",
				url:"<?php echo base_url() ?>invoice_out/get_do",
				dataType:"json",
				success:function(data){
					$("#no_do").html(data[0].no_trans);
				}
			});
		}
		else{
			$("#no_do").html("");
		}


		
	}
	function get_po(){

		var data = $("#po").select2("data"); 
		delete data.element; 

		var id 		= data["id"];
		var tgl 	= data["tgl_po"];
		var pelanggan = data["pelanggan"];
		var term = data["idpembayaran"];
		
		if (id!="") {
			$("#tgl_po").html(tgl);
			$("#pelanggan").html(pelanggan);
			$("#term").html(term);
			$("#tempo").val(data["jatuh_tempo"]);
			$("#lbayar").html(data["bayar"]);
			$("#lsisa").html(data["sisa"]);
			$("#poin").val(data["no_po"]);
			detail(id);
			$("#btn-gg").removeAttr("disabled");
		}
		else{
			$("#btn-gg").attr("disabled", "disabled");
		}
		
		
	}
		
	function reload(){
		$("#src_po").val("");
		$("#src_from").val("");
		$("#src_to").val("");
		$("#src_user").val("");
		$("#src_supplier").val("");
		$("#src_status").val("");
		$("#src_status").trigger("change");
		$("#src_bayar").val("");
		$("#src_bayar").trigger("change");

		table.draw();
	}


	function getId(id){
		$("#get_id").val(id);
	}

</script>