<style type="text/css">
	
	.dropdown > .dropdown-menu:after, .dropdown-toggle > .dropdown-menu:after, .btn-group > .dropdown-menu:after{
		left:90px !important;
	}
	.dropdown > .dropdown-menu:before, .dropdown-toggle > .dropdown-menu:before, .btn-group > .dropdown-menu:before{
		left:89px;
	}

</style>

<div class="page-content">

				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
					Penjualan Pitstop <small></small>
				</h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-cubes"></i>
							<a href="javascript:;">Penjualan Pitstop</a>
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
									<i class="fa fa-database"></i> Data Penjualan Pitstop
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
											</div>
										</div>
									</div>
									<table class="table table-striped table-bordered table-hover" id="datatable_ajax">
										<thead>
											<tr>
												<th width="5%"><center>#</center></th>
												<th >No. Transaksi</th>
												<th width="10%">Tanggal</th>
												<th>Pelanggan</th>
												<th>Kendaraan</th>
												<th width="10%">Total</th>
												<th>Pembayaran</th>
												<th>Lunas</th>
												<th width="15%">Kasir</th>
												<th width="10%">Status</th>
												<th width="5%"><center>Action</center></th>
											</tr>
										</thead>
										<thead>
											<tr>
												<th></th>
												<th><input class="form-control" id="src_trans" placeholder="Cari No. Transaksi..."></th>
												<th></th>
												<th><input class="form-control" id="src_pelanggan" placeholder="Cari Pelanggan..."></th>
												<th><input class="form-control" id="src_plat" placeholder="Cari Plat Nomor..."></th>
												<th></th>
												<th>
													<select class="form-control" id="src_pembayaran">
														<option value="">- Pilih -</option>
														<option value="Cash">CASH</option>
														<option value="Debit">DEBIT</option>
														<option value="Kredit">KREDIT</option>
													</select>
												</th>
												<th>
													<select class="form-control" id="src_lunas">
														<option value="">- Pilih -</option>
														<option value="Y">Lunas</option>
														<option value="N">Belum Lunas</option>
													</select>
												</th>

												<th><input class="form-control" id="src_user" placeholder="Cari Kasir..."></th>
												<th>
													<select class="form-control" id="src_status">
														<option value="">- Pilih -</option>
														<option value="POSTED">POSTED</option>
														<option value="DRAFT">DRAFT</option>
													</select>
												</th>
												<th></th>
											</tr>
										</thead>
									<tbody>
										
									</tbody>
									<tbody>
										<tr>
											<td colspan="5" align="center"><strong>TOTAL KESELURUHAN</strong></td>
											<td id="total_all" align="right" style="font-weight: bold;"></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
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

<div class="modal fade" id="md-det" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-big">
		<div class="modal-content modal-content-big">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Detail Item <strong id="det_inv"></strong></h4>
			</div>
			<form method="POST" id="edit-form">
				<div class="modal-body">
					<div class="row">
						 <div class="col-md-12 col-sm-12">
						 	<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<th><center>No</center></th>
										<th><center>Nama Produk</center></th>
										<th><center>Merk</center></th>
										<th><center>Qty</center></th>
										<th><center>Harga Beli</center></th>
										<th><center>Disc%</center></th>
										<th><center>Total</center></th>
									</thead>
									<tbody id="dt-det">
										
									</tbody>
									<tfoot>
										<tr>
											<th colspan="6"><center>SUBTOTAL</center></th>
											<th id="lsub" style="text-align: right;"></th>
										</tr>
										<tr>
											<th colspan="6"><center>BIAYA JASA</center></th>
											<th id="ljasa" style="text-align: right;"></th>
										</tr>
										<tr>
											<th colspan="6"><center>GRAND TOTAL</center></th>
											<th id="lgtotal" style="text-align: right;"></th>
										</tr>
									</tfoot>
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
<div class="modal fade" id="md-pembayaran" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Riwayat Pembayaran <strong id="pemb_inv"></strong></h4>
			</div>
			
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="form-group">
								<button class="btn btn-primary" id="btn-add-pmb" data-toggle="modal" data-target="#md-tpmb" style="display: none;"><i class="fa fa-plus"></i> Tambah Pembayaran</button>
							</div>
						</div>
						 <div class="col-md-12 col-sm-12">
						 	<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<th width="10%"><center>No</center></th>
										<th width="20%"><center>Tanggal</center></th>
										<th width="30%"><center>Nominal</center></th>
										<th><center>Kasir</center></th>
									</thead>
									<tbody id="dt-pmb">
										
									</tbody>
									<tfoot>
										<tr>
											<th colspan="3"><center>PIUTANG</center></th>
											<th id="piutang" style="text-align: right;"></th>
										</tr>
										<tr>
											<th colspan="3"><center>TOTAL BAYAR</center></th>
											<th id="tbayar" style="text-align: right;"></th>
										</tr>
										<tr>
											<th colspan="3"><center>SISA PIUTANG</center></th>
											<th id="sisa" style="text-align: right;color:red"></th>
										</tr>
									</tfoot>
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
<div class="modal fade" id="md-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-big">
		<div class="modal-content modal-content-big">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Tambah Penjualan </h4>
			</div>
			
				<div class="modal-body">
					<div class="row">
						<div class="col-md-8">
							<h4>No. Penjualan : <label id="no_po" style="font-weight: bold"></label></h4>
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<th><center>No</center></th>
										<th><center>Nama Produk</center></th>
										<th><center>Merk</center></th>
										<th><center>Qty</center></th>
										<th><center>Harga Jual</center></th>
										<th><center>Disc %</center></th>
										<th><center>Total</center></th>
										<th><center>Action</center></th>
									</thead>
									<tbody id="dt">
										
									</tbody>
								</table>
							</div>
							<div class="col-md-12">
								<div class="col-md-6">
									<div class="form-group">
										<label>Pelanggan <a target="_blank" href="<?php echo base_url() ?>pitstop/pelanggan"><i class="fa fa-plus"></i></a> <span class="require"></span></label>
										<input class="form-control" type="hidden" id="pelanggan">
									</div>
									<div class="form-group">
										<label>Plat Nomor <span class="require"></span></label>
										<input class="form-control" type="text" id="plat" style="text-transform: uppercase;">
									</div>
									<div class="form-group">
										<label>Kendaraan <span class="require"></span></label>
										<input class="form-control" type="text" id="kendaraan">
									</div>
									<div class="form-group">
										<label>Pembayaran <span class="require"></span></label>
										<select class="form-control select2me" id="pembayaran">
											<option value="">- Pilih -</option>
											<option value="Cash">Cash</option>
											<option value="Debit">Debit</option>
											<option value="Kredit">Kredit</option>
										</select>
									</div>
		

								</div>
								<div class="col-md-6">
									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover">
											<tbody>
												<tr>
													<td width="50%">Sub Total</td>
													<td id="total" align="right"></td>
												</tr>
												<tr>
													<td width="50%">Discount </td>
													<td id="tdisc" align="right" style="color:red">0</td>
												</tr>
												<tr>
													<td width="50%" style="line-height: 30px;">Biaya Pemasangan <span class="require"></span> </td>
													<td>
														<input class="form-control rupiah" id="jasa" style="height: 30px;text-align: right;" onkeyup="cek_gtotal()">
													</td>
												</tr>
												<tr style="font-weight: bold">
													<td>Grand Total</td>
													<td id="gtotal" align="right"></td>
												</tr>
												<tr>
													<td width="50%" style="line-height: 30px;">Bayar <span class="require"></span></td>
													<td>
														<input class="form-control rupiah" id="bayar" style="height: 30px;text-align: right;" onkeyup="cek_kembalian()">
													</td>
												</tr>
												<tr>
													<td width="50%" >Kembalian</td>
													<td id="kembalian" align="right"></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>

							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Nama Produk</label>
								<input type="hidden" class="form-control" id="item" onchange="get_harga()">
							</div>
							<div class="form-group">
								<label>Merk</label>
								<input type="text" class="form-control" id="merk" disabled="">
							</div>
							<div class="form-group">
								<label>Harga Satuan</label>
								<input type="text" class="form-control" style="text-align: right;" id="harga" autocomplete="off" >
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-8">
										<label>Qty</label>
										<input type="text" class="rupiah form-control" id="qty" style="text-align: right;" placeholder="Qty" autocomplete="off">
									</div>
									<div class="col-md-4">	
										<h4><span id="satuan"></span></h4>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label>Discount %</label>
								<input type="text" class="form-control" style="text-align: right;" id="disc" autocomplete="off" maxlength="2">
							</div>
							<div class="form-group">
								<button class="btn blue" id="btn-add" onclick="add()"> <i class="fa fa-plus"></i> Tambah</button>
							</div>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<button type="submit" class="btn yellow" id="btn-draft" data-toggle="modal" data-target="#md-draft">DRAFT</button>
					<button type="submit" class="btn green" id="btn-gg" disabled="" data-toggle="modal" data-target="#md-save">POSTING</button>
				</div>
			
		</div>
	</div>
</div>

<div class="modal fade" id="md-edraft" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-big">
		<div class="modal-content modal-content-big">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Edit Penjualan </h4>
			</div>
			
				<div class="modal-body">
					<div class="row">
						<div class="col-md-8">
							<h4>No. Penjualan : <label id="eno_po" style="font-weight: bold"></label></h4>
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<th><center>No</center></th>
										<th><center>Nama Produk</center></th>
										<th><center>Merk</center></th>
										<th><center>Qty</center></th>
										<th><center>Harga Jual</center></th>
										<th><center>Disc %</center></th>
										<th><center>Total</center></th>
										<th><center>Action</center></th>
									</thead>
									<tbody id="edt">
										
									</tbody>
								</table>
							</div>
							<div class="col-md-12">
								<div class="col-md-6">
									<div class="form-group">
										<label>Pelanggan <a target="_blank" href="<?php echo base_url() ?>pitstop/pelanggan"><i class="fa fa-plus"></i></a> <span class="require"></span></label>
										<input class="form-control" type="hidden" id="epelanggan">
									</div>
									<div class="form-group">
										<label>Plat Nomor <span class="require"></span></label>
										<input class="form-control" type="text" id="eplat" style="text-transform: uppercase;">
									</div>
									<div class="form-group">
										<label>Kendaraan <span class="require"></span></label>
										<input class="form-control" type="text" id="ekendaraan">
									</div>
									<div class="form-group">
										<label>Pembayaran <span class="require"></span></label>
										<select class="form-control select2me" id="epembayaran">
											<option value="">- Pilih -</option>
											<option value="Cash">Cash</option>
											<option value="Debit">Debit</option>
											<option value="Kredit">Kredit</option>
										</select>
									</div>
		

								</div>
								<div class="col-md-6">
									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover">
											<tbody>
												<tr>
													<td width="50%">Sub Total</td>
													<td id="etotal" align="right"></td>
												</tr>
												<tr>
													<td width="50%" style="line-height: 30px;">Biaya Pemasangan <span class="require"></span> </td>
													<td>
														<input class="form-control rupiah" id="ejasa" style="height: 30px;text-align: right;" onkeyup="ecek_gtotal()">
													</td>
												</tr>
												<tr style="font-weight: bold">
													<td>Grand Total</td>
													<td id="egtotal" align="right"></td>
												</tr>
												<tr>
													<td width="50%" style="line-height: 30px;">Bayar <span class="require"></span></td>
													<td>
														<input class="form-control rupiah" id="ebayar" style="height: 30px;text-align: right;" onkeyup="ecek_kembalian()">
													</td>
												</tr>
												<tr>
													<td width="50%" >Kembalian</td>
													<td id="ekembalian" align="right"></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>

							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Nama Produk</label>
								<input type="hidden" class="form-control" id="eitem" onchange="eget_harga()">
							</div>
							<div class="form-group">
								<label>Merk</label>
								<input type="text" class="form-control" id="emerk" disabled="">
							</div>
							<div class="form-group">
								<label>Harga Satuan</label>
								<input type="text" class="form-control" style="text-align: right;" id="eharga" autocomplete="off" disabled="">
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-8">
										<label>Qty</label>
										<input type="text" class="rupiah form-control" id="eqty" style="text-align: right;" placeholder="Qty" autocomplete="off">
									</div>
									<div class="col-md-4">	
										<h4><span id="esatuan"></span></h4>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label>Discount %</label>
								<input type="text" class="form-control" style="text-align: right;" id="edisc" autocomplete="off" maxlength="2">
							</div>
							<div class="form-group">
								<button class="btn blue" id="btn-add-draft" onclick="add_draft()"> <i class="fa fa-plus"></i> Tambah</button>
							</div>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<button type="submit" class="btn green" id="btn-gg2"  data-toggle="modal" data-target="#md-save-draft">POSTING</button>
				</div>
			
		</div>
	</div>
</div>

<div class="modal" id="md-draft" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">SIMPAN KE DRAFT</h4>
			</div>
			<div class="modal-body">
				
				<p style="text-align: center">
					<i class="fa fa-exclamation-triangle font-yellow" style="font-size: 35px;" ></i>&nbsp
					<label style="font-size: 35px;"> Apa anda yakin ? </label>
				</p>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn default" data-dismiss="modal">Batal</button>
				<button type="submit" class="btn yellow" id="btn-sdraft"  onclick="draft()">Proses</button>
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
				<h4 class="modal-title">POSTING TRANSAKSI</h4>
			</div>
			<div class="modal-body">
				
				<p style="text-align: center">
					<i class="fa fa-exclamation-triangle font-green" style="font-size: 35px;" ></i>&nbsp
					<label style="font-size: 35px;"> Apa anda yakin ? </label>
				</p>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn default" data-dismiss="modal">Batal</button>
				<button type="submit" class="btn green" id="btn-save"  onclick="save()">Proses</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<div class="modal" id="md-save-draft" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">POSTING TRANSAKSI2</h4>
			</div>
			<div class="modal-body">
				
				<p style="text-align: center">
					<i class="fa fa-exclamation-triangle font-green" style="font-size: 35px;" ></i>&nbsp
					<label style="font-size: 35px;"> Apa anda yakin ? </label>
				</p>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn default" data-dismiss="modal">Batal</button>
				<button type="submit" class="btn green" id="btn-save-draft"  onclick="save_draft()">Proses</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<div class="modal" id="md-tpmb" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">TAMBAH PEMBAYARAN</h4>
			</div>
			<div class="modal-body">
				
				<form id="ftpmb" method="post">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="form-group">
								<label>Nominal <span class="require"></span> </label>
								<input id="pmb_nominal" class="form-control rupiah">
							</div>
						</div>
					</div>
				</form>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn default" data-dismiss="modal">Batal</button>
				<button type="submit" class="btn green" id="btn-tpmb" >Proses</button>
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
<input id="vt" type="hidden">
<input id="evt" type="hidden">
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

		$("#ftpmb").submit(function(e){
			e.preventDefault();

			var nominal = parseInt($("#pmb_nominal").val().split(".").join(""));
			var no_trans = $("#pemb_inv").text();
			var sisa     = parseInt($("#sisa").text().split(".").join(""));

			if (nominal !=="" || nominal !==0) {
				$.ajax({
					type:"POST",
					url:"<?php echo base_url() ?>pitstop/penjualan/add_pembayaran",
					dataType:"json",
					data:{no_trans, nominal, sisa},
					beforeSend:function(){
						$("#btn-tpmb").html(loading_event());
						$("#btn-tpmb").attr("disabled", "disabled");
					},
					success:function(data){

						switch(parseFloat(data)){

							case 1:
								notif("Success","Pembayaran berhasil disimpan.", "success");
								table.ajax.reload(null, false);

								$("#pmb_nominal").val("");
								pembayaran(no_trans);

								$("#md-tpmb").modal("toggle");
							break;

							case 0:
								notif("Error","Pembayaran gagal disimpan.", "error");
							break;

						}

					},
					complete:function(){
						$("#btn-tpmb").html("Proses");
						$("#btn-tpmb").removeAttr("disabled");
					}

				});
			}
			else{
				notif("Error", "Isi nominal terlebih dahulu.", "error");
			}
		});

		$('.tooltips').tooltip();
		get_trans();
		dt();
		//select2
	    var sel_item = {
	        placeholder: "Pilih",
	        minimumInputLength: 2,
	        ajax: {
	            url: '<?php echo base_url() ?>produk_pitstop/select2',
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
	        	if (option.tipe_mobil!=="") {
	        		var tipe = " ("+option.tipe_mobil+")";
	        	}
	        	else{
	        		var tipe = "";
	        	}	

	            return "<div>" + option.nama_produk+tipe+ "</div>";
	        },
	        formatSelection: function (option) {
	        	if (option.tipe_mobil!=="") {
	        		var tipe = " ("+option.tipe_mobil+")";
	        	}
	        	else{
	        		var tipe = "";
	        	}	
	            return option.nama_produk+tipe;
	        }
	    };
	    $("#item").select2(sel_item);
	    $("#eitem").select2(sel_item);

	    var sel_pelanggan = {
	        placeholder: "Pilih",
	        minimumInputLength: 2,
	        ajax: {
	            url: '<?php echo base_url() ?>pitstop/pelanggan/select2',
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
	        },
          	escapeMarkup: function(m) {
	          	return m;
	      	}
	    };
	    $("#pelanggan").select2(sel_pelanggan);
	    $("#epelanggan").select2(sel_pelanggan);

		//Modal Setting
		$('#md-add').on('shown.bs.modal', function() {
		    $("#item").select2("focus");
		});
		$('#md-edraft').on('shown.bs.modal', function() {
		    $("#item2").select2("focus");
		});
		$('#md-tpmb').on('shown.bs.modal', function() {
		    $("#pmb_nominal").focus();
		});



		$("#src_trans").keypress(function(e) {
	      if(e.which == 13) {
	        table.draw();
	      }
	    });
	    $("#src_plat").keypress(function(e) {
	      if(e.which == 13) {
	        table.draw();
	      }
	    });
	    $("#src_pelanggan").keypress(function(e) {
	      if(e.which == 13) {
	        table.draw();
	      }
	    });
	    $("#src_user").keypress(function(e) {
	      if(e.which == 13) {
	        table.draw();
	      }
	    });
	    $("#src_pembayaran").change(function(e) {
	      table.draw();
	    });
	    $("#src_lunas").change(function(e) {
	      table.draw();
	    });
	    $("#src_status").change(function(e) {
	      table.draw();
	    });
	    //datatables
	    table = $('#datatable_ajax').DataTable({ 
	        "processing": true, //Feature control the processing indicator.
	        "serverSide": true, //Feature control DataTables' server-side processing mode.
	        "order": [[ 2, "desc" ]], //Initial no order.
	        "loadingMessage": 'Loading...',
	        "searching":false,
	        "aoColumnDefs": [
				{ "bSortable": false, "aTargets": [ 0,5,10 ] }
			],
			"oLanguage": {sProcessing: "<i class='fa fa-spinner fa-pulse fa-lg'></i> Loading..."},
	 		
	        // Load data for the table's content from an Ajax source
	        "ajax": {
	            "url": "<?php echo site_url('pitstop/penjualan/data')?>",
	            "type": "POST",
	            "dataType":"json",
	            "data":function ( d ) {
	                  return $.extend( {}, d, {
	                  		"src_trans": $('#src_trans').val(),
	                  		"src_from" : toTglSys($("#src_from").val()),
	                  		"src_to" : toTglSys($("#src_to").val()),
	                  		"src_pelanggan" : $("#src_pelanggan").val(),
	                  		"src_user" : $("#src_user").val(),
	                  		"src_pembayaran" : $("#src_pembayaran").val(),
	                  		"src_lunas" : $("#src_lunas").val(),
	                  		"src_status" : $("#src_status").val(),
	                  		"src_plat" : $("#src_plat").val()
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
					    	var left = $btnDropDown.offset().left - 280;
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
						$("#total_all").html(parseInt(data[len-1][11]).toLocaleString("de-DE"));
					}
					else{
						$("#total_all").html("0");
						//$(tfoot).find('th').eq(1).html("0");
					}

				}
	 
	    });

	});

	function cek_kembalian(){
		var gtotal 		= parseInt($("#gtotal").html().split(".").join(""));
		if ($("#bayar").val()== "") {
			var bayar = 0;
			var kembalian 	= 0;
		}	
		else{
			var bayar = parseInt($("#bayar").val().split(".").join(""));
			var kembalian 	= bayar-gtotal;
		}
		
		


		$("#kembalian").html(kembalian.toLocaleString("de-DE"));
	}
	function cek_gtotal(){
		
		var subtotal = parseInt($("#vt").val().split(".").join(""));
		
		if ($("#jasa").val()== "") {
			var jasa = 0;
		}	
		else{
			var jasa = parseInt($("#jasa").val().split(".").join(""));
		}
		var gt = jasa + subtotal;


		$("#gtotal").html(gt.toLocaleString("de-DE"));
		cek_kembalian();
	}
	function ecek_kembalian(){
		var gtotal 		= parseInt($("#egtotal").html().split(".").join(""));
		if ($("#ebayar").val()== "") {
			var bayar = 0;
			var kembalian 	= 0;
		}	
		else{
			var bayar = parseInt($("#ebayar").val().split(".").join(""));
			var kembalian 	= bayar-gtotal;
		}
		
		


		$("#ekembalian").html(kembalian.toLocaleString("de-DE"));
	}
	function ecek_gtotal(){
		
		var subtotal = parseInt($("#evt").val().split(".").join(""));
		
		if ($("#ejasa").val()== "") {
			var jasa = 0;
		}	
		else{
			var jasa = parseInt($("#ejasa").val().split(".").join(""));
		}
		var gt = jasa + subtotal;


		$("#egtotal").html(gt.toLocaleString("de-DE"));
		ecek_kembalian();
	}
	function unduh(){
		//<?php echo base_url() ?>quotation/excel?src_supplier=kerta
		var src_trans 		= $("#src_trans").val();
		var src_from 		= toTglSys($("#src_from").val());
		var src_to 			= toTglSys($("#src_to").val());
		var src_pelanggan 	= $("#src_pelanggan").val();
		var src_user 		= $("#src_user").val();
		var src_status 		= $("#src_status").val();
		var src_pembayaran 	= $("#src_pembayaran").val();
		var src_plat		= $("#src_plat").val();
		var src_lunas		= $("#src_lunas").val();

		window.open('<?php echo base_url() ?>pitstop/penjualan/excel?src_trans='+src_trans+'&src_from='+src_from+'&src_to='+src_to+'&src_pelanggan='+src_pelanggan+'&src_user='+src_user+'&src_status='+src_status+'&src_pembayaran='+src_pembayaran+'&src_plat='+src_plat+'&src_lunas='+src_lunas, '_blank');

	}


	function get_item(){
		var data = $("#inq").select2("data"); 
		delete data.element; 

		var item 	= data["op"];
		var id 		= data["id"];

		
		if (id!="") {
			$("#inq_item").html(item);
			//$("#harga").val(parseInt(harga).toLocaleString("de-DE"));
			//$("#qty").focus();
		}
	}

	function detail(id){

		$.ajax({
			type:"POST",
			url:"<?php echo base_url() ?>pitstop/penjualan/detail",
			dataType:"json",
			data:{id},
			beforeSend:function(){
				$("#dt-det").html("<tr><td colspan='7' align='center'><i class='fa fa-spinner fa-pulse'></i> Loading...</td></tr>");
				$("#det_inv").html("");
			},
			success:function(data){

				var len = data.length;
				var l = "";
				for(var i =0;i<len;i++){
					l+="<tr>";
						l+="<td align='center'>"+(i+1)+"</td>";
						l+="<td>"+data[i].nama+"</td>";
						l+="<td align='center'>"+data[i].merk+"</td>";
						l+="<td align='right'>"+data[i].qty+"</td>";
						l+="<td align='right'>"+data[i].harga+"</td>";
						l+="<td align='right'>"+data[i].disc+"%</td>";
						l+="<td align='right'>"+data[i].total+"</td>";
					l+="</tr>";
				}
				$("#det_inv").html(data[0].inv);
				$("#duntuk").html(data[0].untuk);

				$("#lsub").html(data[len-1].subtotal);
				$("#lppn").html(data[len-1].ppn);
				$("#lgtotal").html(data[len-1].gtotal);
				$("#ljasa").html(data[len-1].jasa);

				$("#dt-det").html(l);

			},
			complete:function(){
				$('.tooltips').tooltip();
			}
		});

	}
	function edit_draft(id){

		$.ajax({
			type:"POST",
			url:"<?php echo base_url() ?>pitstop/penjualan/edit_draft",
			dataType:"json",
			data:{id},
			beforeSend:function(){
				$("#edt").html("<tr><td colspan='8' align='center'><i class='fa fa-spinner fa-pulse'></i> Loading...</td></tr>");
				$("#eno_po").html("");
			},
			success:function(data){

				var len = data.length;
				var l = "";
				for(var i =0;i<len;i++){
					l+="<tr>";
						l+="<td align='center'>"+(i+1)+"</td>";
						l+="<td>"+data[i].nama+"</td>";
						l+="<td align='center'>"+data[i].merk+"</td>";
						l+="<td align='right'>"+data[i].qty+"</td>";
						l+="<td align='right'>"+data[i].harga+"</td>";
						l+="<td align='right'>"+data[i].disc+"%</td>";
						l+="<td align='right'>"+data[i].total+"</td>";
						l+="<td align='center'><a href='javascript:;' id='btn-edel-"+i+"' onclick='edel("+data[i].id+", "+i+")'><i class='fa fa-trash fa-lg'></i></a></td>";
					l+="</tr>";
				}
				$("#eno_po").html(id);
				
						
				$("#etotal").html(data[len-1].subtotal);
				$("#egtotal").html(data[len-1].gtotal);
				$("#evt").val(data[len-1].gtotal);
				$("#epelanggan").select2('data', { id: data[0].idpelanggan, nama_pelanggan: data[0].nama_pelanggan });
				$("#eplat").val(data[0].plat);
				$("#ekendaraan").val(data[0].kendaraan);
				$("#epembayaran").val(data[0].pembayaran);
				$("#epembayaran").trigger("change");



				$("#edt").html(l);

			},
			complete:function(){
				$('.tooltips').tooltip();
			}
		});

	}
	function pembayaran(id){

		$.ajax({
			type:"POST",
			url:"<?php echo base_url() ?>pitstop/penjualan/pembayaran",
			dataType:"json",
			data:{id},
			beforeSend:function(){
				$("#dt-pmb").html("<tr><td colspan='4' align='center'><i class='fa fa-spinner fa-pulse'></i> Loading...</td></tr>");
				$("#det_inv").html("");
				$("#btn-add-pmb").hide();
			},
			success:function(data){

				var len = data.length;
				var l = "";
				for(var i =0;i<len;i++){
					l+="<tr>";
						l+="<td align='center'>"+(i+1)+"</td>";
						l+="<td align='center'>"+data[i].tgl+"</td>";
						l+="<td align='right'>"+data[i].nominal+"</td>";
						l+="<td align='left'>"+data[i].kasir+"</td>";
					l+="</tr>";
				}
				$("#pemb_inv").html(id);
				$("#tbayar").html(data[0].bayar);
				$("#piutang").html(data[0].piutang);
				$("#sisa").html(data[0].sisa);

				if (data[0].sisa == "0") {
					$("#btn-add-pmb").hide();
				}
				else{
					$("#btn-add-pmb").show();
				}



				$("#dt-pmb").html(l);

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
	function draft(){
		get_trans();
		var no_trans = $("#no_po").text();
		var item = $("#total_item").val();
		var pelanggan = $("#pelanggan").val();
		var plat 	= $("#plat").val();
		var kendaraan = $("#kendaraan").val();
		var pembayaran = $("#pembayaran").val();
		if (pelanggan && plat && kendaraan && pembayaran !== "") {
			$.ajax({

				type:"POST",
				url:"<?php echo base_url() ?>pitstop/penjualan/draft",
				dataType:"json",
				data:{no_trans, item, pelanggan, kendaraan, pembayaran, plat},
				beforeSend:function(){
					$("#btn-sdraft").html(loading_event());
					$("#btn-sdraft").attr("disabled", "disabled");
				},
				success:function(data){

					switch(parseFloat(data)){

						case 1:
							notif("Success","Penjualan disimpan ke DRAFT.", "success");
							get_trans();
							table.draw();
							dt();

							$("#pelanggan").select2("val", "");

							
							$("#plat").val("");
							$("#kendaraan").val("");
							$("#val_ppn").val("N");
							
							$("#pembayaran").val("");
							$("#pembayaran").trigger("change");


							$("#md-draft").modal("toggle");
							$("#md-add").modal("toggle");
						break;

						case 0:
							get_trans();
							notif("Error","Penjualan gagal disimpan ke DRAFT.", "error");
						break;

					}

				},
				complete:function(){
					$("#btn-sdraft").html("Proses");
					$("#btn-sdraft").removeAttr("disabled");
				}

			});




		}
		else{
			notif("Error", "Lengkapi Data yang wajib diisi.", "error");
		}

	}
	function save_draft(){
		var no_trans = $("#eno_po").text();
		var pelanggan = $("#epelanggan").val();
		var plat 	= $("#eplat").val();
		var kendaraan = $("#ekendaraan").val();
		var pembayaran = $("#epembayaran").val();
		var jasa = $("#ejasa").val();
		var bayar = parseInt($("#ebayar").val().split(".").join(""));
		var kembalian = parseInt($("#ekembalian").html().split(".").join(""));
		var gtotal = parseInt($("#egtotal").html().split(".").join(""));
		if (pelanggan && plat && kendaraan && pembayaran && jasa && bayar !== "") {

			if (pembayaran == "Kredit") {
					$.ajax({

						type:"POST",
						url:"<?php echo base_url() ?>pitstop/penjualan/save_draft",
						dataType:"json",
						data:{no_trans, pelanggan, kendaraan, jasa, bayar, kembalian, pembayaran, plat, gtotal, bayar},
						beforeSend:function(){
							$("#btn-save-draft").html(loading_event());
							$("#btn-save-draft").attr("disabled", "disabled");
						},
						success:function(data){

							switch(parseFloat(data)){

								case 1:
									notif("Success","Penjualan berhasil diposting.", "success");
									get_trans();
									table.ajax.reload(null, false);
									dt();

									$("#epelanggan").select2("val", "");

									
									$("#eplat").val("");
									$("#ekendaraan").val("");
									$("#val_ppn").val("N");

									$("#ebayar").val("");
									$("#ejasa").val("");
									
									$("#epembayaran").val("");
									$("#epembayaran").trigger("change");


									$("#md-save-draft").modal("toggle");
									$("#md-edraft").modal("toggle");
								break;

								case 0:
									get_trans();
									notif("Error","Penjualan gagal diposting.", "error");
								break;

							}

						},
						complete:function(){
							$("#btn-save-draft").html("Proses");
							$("#btn-save-draft").removeAttr("disabled");
						}

					});
			}
			else{

				if (bayar >= gtotal) {
					$.ajax({

						type:"POST",
						url:"<?php echo base_url() ?>pitstop/penjualan/save_draft",
						dataType:"json",
						data:{no_trans, pelanggan, kendaraan, jasa, bayar, kembalian, pembayaran, plat, gtotal, bayar},
						beforeSend:function(){
							$("#btn-save-draft").html(loading_event());
							$("#btn-save-draft").attr("disabled", "disabled");
						},
						success:function(data){

							switch(parseFloat(data)){

								case 1:
									notif("Success","Penjualan berhasil diposting.", "success");
									get_trans();
									table.ajax.reload(null, false);
									dt();

									$("#epelanggan").select2("val", "");

									
									$("#eplat").val("");
									$("#ekendaraan").val("");
									$("#val_ppn").val("N");

									$("#ebayar").val("");
									$("#ejasa").val("");
									
									$("#epembayaran").val("");
									$("#epembayaran").trigger("change");


									$("#md-save-draft").modal("toggle");
									$("#md-edraft").modal("toggle");
								break;

								case 0:
									get_trans();
									notif("Error","Penjualan gagal diposting.", "error");
								break;

							}

						},
						complete:function(){
							$("#btn-save-draft").html("Proses");
							$("#btn-save-draft").removeAttr("disabled");
						}

					});
				}
				else{
					notif("Error", "Bayar tidak boleh kurang.", "error");
				}
		
			}



		}
		else{
			notif("Error", "Lengkapi Data yang wajib diisi.", "error");
		}

	}
	function save(){
		get_trans();
		var no_trans = $("#no_po").text();
		var item = $("#total_item").val();
		var pelanggan = $("#pelanggan").val();
		var plat 	= $("#plat").val();
		var kendaraan = $("#kendaraan").val();
		var pembayaran = $("#pembayaran").val();
		var jasa = $("#jasa").val();
		var bayar = parseInt($("#bayar").val().split(".").join(""));
		var kembalian = parseInt($("#kembalian").html().split(".").join(""));
		var gtotal = parseInt($("#gtotal").html().split(".").join(""));
		if (pelanggan && plat && kendaraan && pembayaran && jasa && bayar !== "") {

			if (pembayaran == "Kredit") {
					$.ajax({

						type:"POST",
						url:"<?php echo base_url() ?>pitstop/penjualan/save",
						dataType:"json",
						data:{no_trans, item, pelanggan, kendaraan, jasa, bayar, kembalian, pembayaran, plat, gtotal, bayar},
						beforeSend:function(){
							$("#btn-save").html(loading_event());
							$("#btn-save").attr("disabled", "disabled");
						},
						success:function(data){

							switch(parseFloat(data)){

								case 1:
									notif("Success","Penjualan berhasil diposting.", "success");
									get_trans();
									table.draw();
									dt();

									$("#pelanggan").select2("val", "");

									
									$("#plat").val("");
									$("#kendaraan").val("");
									$("#val_ppn").val("N");
									
									$("#pembayaran").val("");
									$("#pembayaran").trigger("change");


									$("#md-save").modal("toggle");
									$("#md-add").modal("toggle");
								break;

								case 0:
									get_trans();
									notif("Error","Penjualan gagal diposting.", "error");
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

				if (bayar >= gtotal) {
					$.ajax({

						type:"POST",
						url:"<?php echo base_url() ?>pitstop/penjualan/save",
						dataType:"json",
						data:{no_trans, item, pelanggan, kendaraan, jasa, bayar, kembalian, pembayaran, plat, gtotal, bayar},
						beforeSend:function(){
							$("#btn-save").html(loading_event());
							$("#btn-save").attr("disabled", "disabled");
						},
						success:function(data){

							switch(parseFloat(data)){

								case 1:
									notif("Success","Penjualan berhasil diposting.", "success");
									get_trans();
									table.draw();
									dt();

									$("#pelanggan").select2("val", "");

									
									$("#plat").val("");
									$("#kendaraan").val("");
									$("#val_ppn").val("N");
									
									$("#pembayaran").val("");
									$("#pembayaran").trigger("change");


									$("#md-save").modal("toggle");
									$("#md-add").modal("toggle");
								break;

								case 0:
									get_trans();
									notif("Error","Penjualan gagal diposting.", "error");
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
					notif("Error", "Bayar tidak boleh kurang.", "error");
				}
		
			}



		}
		else{
			notif("Error", "Lengkapi Data yang wajib diisi.", "error");
		}

	}
	function cek_total(v){

		if (parseInt(v)!=0 || parseInt(v)!="") {
			$("#btn-gg").removeAttr("disabled");
			$("#btn-draft").removeAttr("disabled");
		}
		else{
			$("#btn-gg").attr("disabled", "disabled");
			$("#btn-draft").attr("disabled", "disabled");
		}

	}

	function dt(){
		$.ajax({

			type:"POST",
			url:"<?php echo base_url();?>pitstop/penjualan/data_item",
			dataType:"json",
			beforeSend:function(){
				$("#dt").html("<tr><td colspan='8' align='center'><i class='fa fa-spinner fa-pulse'></i> Loading...</td></tr>");
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
							l+="<td align='left'><span class='tooltips' data-placement='top' data-original-title=''>"+data[i].merk+"</span></td>";
							l+="<td align='center'>"+parseInt(data[i].qty).toLocaleString('de-DE')+" "+data[i].satuan+"</td>";
							l+="<td align='right'>"+parseInt(data[i].harga).toLocaleString('de-DE')+"</td>";
							l+="<td align='right'>"+parseInt(data[i].disc).toLocaleString('de-DE')+"</td>";
							l+="<td align='right'>"+parseInt(data[i].netto).toLocaleString('de-DE')+"</td>";
							l+="<td align='center'><a href='javascript:;' id='btn-del-"+i+"' onclick='del("+data[i].id+", "+i+")'><i class='fa fa-trash fa-lg'></i></a></td>";
						l+="</tr>";

					}
					var cek_ppn = "N";
					var tax = ((total - pt) * 10 / 100);
					var gtotal  = ((total - pt)+tax).toLocaleString("de-DE");
					if (pt <= 0) {
						var min = "";
					}
					else{
						var min = "-";
					}
					if (cek_ppn=="Y") {
						var gtotal  = ((total - pt)+tax).toLocaleString("de-DE");
					}
					else{
						var gtotal  = (total - pt).toLocaleString("de-DE");
					}
					$("#total").html(total.toLocaleString("de-DE"));
					$("#tdisc").html(min+pt.toLocaleString("de-DE"));
					$("#gtotal").html(gtotal);
					$("#vt").val(gtotal);
					$("#total_item").val(data.length);
					$("#ppn").html(tax.toLocaleString("de-DE"));

				}
				else{
					cek_total(0);
					l+="<tr><td colspan='8' align='center'>Tidak ada data.</td></tr>";
					
					$("#total").html("0");
					$("#tdisc").html("0");
					$("#gtotal").html("0");
					$("#total_item").val("0");
					$("#ppn").html("0");
					$("#vt").val("0");
					$("#kembalian").html("0");
					$("#bayar").val("0");
					$("#jasa").val("0");

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
			url:"<?php echo base_url();?>pitstop/penjualan/del",
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
	function edel(id, i){

		$.ajax({

			type:"POST",
			url:"<?php echo base_url();?>pitstop/penjualan/del_draft",
			dataType:"json",
			data:{id},
			beforeSend:function(){
				$("#btn-edel-"+i).html("<i class='fa fa-spinner fa-pulse fa-lg'></i>");
				$("#btn-edel-"+i).bind('click', false);
			},
			success:function(data){

				dt();
				edit_draft($("#eno_po").text());
				$('#eitem').select2('focus');

			},
			complete:function(){
				$("#btn-edel-"+i).html("<i class='fa fa-trash fa-lg'></i>");
				$("#btn-edel-"+i).unbind('click', false);
			}

		});

	}
	function add(){
		var g = $("#item").select2("data"); 
		delete g.element; 

		var harga 		= $("#harga").val();
		var satuan 		= g["nama_satuan"];
		var id 			= g["id"];
		var qty 		= $("#qty").val();
		var modal 		= g["modal"];
		var disc   	 	= $("#disc").val();


		if (id && qty !=="") {
			$.ajax({

				type:"POST",
				url:"<?php echo base_url();?>pitstop/penjualan/add",
				dataType:"json",
				data:{id, qty, harga, satuan, modal, disc},
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
							$("#modal").val("");
							$("#disc").val("");
							$("#merk").val("");

							
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
	function add_draft(){
		var g = $("#eitem").select2("data"); 
		delete g.element; 

		var harga 		= $("#eharga").val();
		var satuan 		= g["nama_satuan"];
		var id 			= g["id"];
		var qty 		= $("#eqty").val();
		var modal 		= g["modal"];
		var disc   	 	= $("#edisc").val();
		var no_trans 	= $("#eno_po").text();


		if (id && qty !=="") {
			$.ajax({

				type:"POST",
				url:"<?php echo base_url();?>pitstop/penjualan/add_draft",
				dataType:"json",
				data:{id, qty, harga, satuan, modal, disc, no_trans},
				beforeSend:function(){
					$("#btn-add-draft").html(loading_event());
					$("#btn-add-draft").attr("disabled", "disabled");
				},
				success:function(data){

					switch(parseFloat(data)){

						case 0:
							notif("Error", "Item gagal ditambahkan.", "error");
						break;

						case 1:
							dt();
							edit_draft(no_trans);
							//notif("Success", "Produk berhasil ditambahkan.", "success");
							$("#eqty").val("");
							$("#eitem").select2("val", "");
							$("#eharga").val("");
							$("#emodal").val("");
							$("#edisc").val("");
							$("#emerk").val("");

							
						break;

					}

				},
				complete:function(){
					$('#item2').select2('focus');
					$("#btn-add-draft").html("<i class='fa fa-plus'></i> Tambahkan");
					$("#btn-add-draft").removeAttr("disabled");
				}

			});
		}
		else{
			notif("Error", "Pilih Produk terlebih dahulu.", "error");
		}

	}

	function get_trans(){
		$.ajax({
			type:"POST",
			url:"<?php echo base_url() ?>pitstop/penjualan/get_trans",
			dataType:"json",
			success:function(data){
				$("#no_po").html(data[0].no_trans);
				$("#no_po2").html(data[0].no_trans);
			}
		});

		
	}
	function get_harga(){

		var data = $("#item").select2("data"); 
		delete data.element; 

		var harga 	= data["harga"];
		var satuan 	= data["nama_satuan"];
		var id 		= data["id"];
		var modal   = data["modal"];
		var merk 	= data["merk"];

		
		if (id!="") {
			$("#satuan").html(satuan);
			$("#harga").val(parseInt(harga).toLocaleString("de-DE"));
			$("#modal").val(parseInt(modal).toLocaleString("de-DE"));
			$("#qty").focus();
			$("#merk").val(merk);
		}
		
		
	}
	function eget_harga(){

		var data = $("#eitem").select2("data"); 
		delete data.element; 

		var harga 	= data["harga"];
		var satuan 	= data["nama_satuan"];
		var id 		= data["id"];
		var modal   = data["modal"];
		var merk 	= data["merk"];

		
		if (id!="") {
			$("#esatuan").html(satuan);
			$("#eharga").val(parseInt(harga).toLocaleString("de-DE"));
			$("#emodal").val(parseInt(modal).toLocaleString("de-DE"));
			$("#eqty").focus();
			$("#emerk").val(merk);
		}
		
		
	}	
	function reload(){
		$("#src_trans").val("");
		$("#src_plat").val("");
		$("#src_from").val("");
		$("#src_to").val("");
		$("#src_user").val("");
		$("#src_pelanggan").val("");
		$("#src_status").val("");
		$("#src_status").trigger("change");
		$("#src_pembayaran").val("");
		$("#src_pembayaran").trigger("change");
		$("#src_lunas").val("");
		$("#src_lunas").trigger("change");

		table.draw();
	}


	function getId(id){
		$("#get_id").val(id);
	}

</script>