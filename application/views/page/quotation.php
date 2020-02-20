<style type="text/css">
	
	.dropdown > .dropdown-menu:after, .dropdown-toggle > .dropdown-menu:after, .btn-group > .dropdown-menu:after{
		left:120px !important;
	}
	.dropdown > .dropdown-menu:before, .dropdown-toggle > .dropdown-menu:before, .btn-group > .dropdown-menu:before{
		left:119px;
	}

</style>

<div class="page-content">

				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
					Quotation <small></small>
				</h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-cubes"></i>
							<a href="javascript:;">Quotation</a>
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
									<i class="fa fa-database"></i> Data Quotation
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
												<button class="btn green" data-toggle="modal" data-target="#md-add2">
													<i class="fa fa-plus fa-lg"></i> Tambah Dari Inquiry
												</button>
											</div>
										</div>
									</div>
									<table class="table table-striped table-bordered table-hover" id="datatable_ajax">
										<thead>
											<tr>
												<th width="5%"><center>#</center></th>
												<th width="10%">No. Quot</th>
												<th>Tanggal</th>
												<th>User</th>
												<th>Total</th>
												<th width="15%">Terms</th>
												<th>Bank</th>
												<th>Purchasing</th>
												<!--<th>Status</th>-->
												<th width="5%"><center>Action</center></th>
											</tr>
										</thead>
										<thead>
											<tr>
												<th></th>
												<th><input class="form-control" id="src_po" placeholder="Cari No. Quotation..."></th>
												<th></th>
												<th><input class="form-control" id="src_supplier" placeholder="Cari User..."></th>
												<th></th>
												<th>
													<select class="form-control select2me" id="src_bayar">
														<option value="">Pilih</option>
													</select>
												</th>
												<th></th>
												<th><input class="form-control" id="src_user" placeholder="Cari Purchasing..."></th>
												<th></th>
											</tr>
										</thead>
									<tbody>
										
									</tbody>
									<tbody>
										<tr>
											<td colspan="4" align="center"><strong>TOTAL KESELURUHAN</strong></td>
											<td id="total_all" align="right" style="font-weight: bold;"></td>
											<td></td>
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

<div class="modal fade" id="md-det" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-big">
		<div class="modal-content modal-content-big">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Detail Item</h4>
			</div>
			<form method="POST" id="edit-form">
				<div class="modal-body">
					<div class="row">
						 <div class="col-md-12 col-sm-12">
						 	<div class="form-group">
						 		Quotation For : <span id="duntuk"></span>
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
										<th><center>Lead Time</center></th>
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

<div class="modal fade" id="md-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-big">
		<div class="modal-content modal-content-big">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Tambah Quotation</h4>
			</div>
			
				<div class="modal-body">
					<div class="row">
						<div class="col-md-8">
							<h4>No. Quotation : <label id="no_po" style="font-weight: bold"></label></h4>
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<th><center>No</center></th>
										<th><center>Item</center></th>
										<th><center>Deskripsi</center></th>
										<th><center>Qty</center></th>
										<th><center>Harga Beli</center></th>
										<th><center>Harga Jual</center></th>
										<th><center>Disc %</center></th>
										<th><center>Lead Time</center></th>
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
										<label>User <span class="require"></span></label>
										<input class="form-control" type="hidden" id="supplier">
									</div>
									<div class="form-group">
										<label>Quotation Untuk <span class="require"></span></label>
										<input class="form-control" type="text" id="untuk">
									</div>
									<div class="form-group">
										<label>Terms <span class="require"></span></label>
										<select class="form-control select2me" id="bayar">
											<option value="">Pilih</option>
											
										</select>
									</div>
									<div class="form-group">
										<label>Bank <span class="require"></span></label>
										<input class="form-control" type="hidden" id="bank">
									</div>
								</div>
								<div class="col-md-6">
									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover">
											<tbody>
												<tr>
													<td width="50%">Total</td>
													<td id="total" align="right"></td>
												</tr>
												<tr>
													<td width="50%">PPN 10% <input type="checkbox" id="ppn_cek" checked=""></td>
													<td align="right"><span id="ppn"></span> <span style="display: none" id="ppn_no">0</span></td>
												</tr>
												<tr>
													<td>Subtotal</td>
													<td id="gtotal" align="right"></td>
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
								<label>Harga Beli</label>
								<input type="text" class="form-control rupiah" placeholder="Harga Beli" style="text-align: right;" id="modal" autocomplete="off">
							</div>
							<div class="form-group">
								<label>Harga Jual</label>
								<input type="text" class="form-control rupiah" placeholder="Harga Jual" style="text-align: right;" id="harga" autocomplete="off">
							</div>
							<div class="form-group">
								<label>Fee</label>
								<input type="text" class="form-control rupiah" placeholder="Fee" style="text-align: right;" id="fee" autocomplete="off">
							</div>
							<div class="form-group">
								<label>Discount %</label>
								<input type="text" class="form-control" style="text-align: right;" id="disc" autocomplete="off" maxlength="2">
							</div>
							<div class="form-group">
								<label>Lead Time</label>
								<input type="text" class="form-control" placeholder="Lead Time" id="lead_time" autocomplete="off" style="text-transform: uppercase;">
							</div>
							<div class="form-group">
								<label>Keterangan Produk</label>
								<textarea class="form-control" style="height: 200px;resize: none" placeholder="Keterangan" id="ket"></textarea>
							</div>
							<div class="form-group">
								<button class="btn blue" id="btn-add" onclick="add()"> <i class="fa fa-plus"></i> Tambah</button>
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

<div class="modal fade" id="md-add2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-big">
		<div class="modal-content modal-content-big">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Tambah Quotation Dari Inquiry</h4>
			</div>
			
				<div class="modal-body">
					<div class="row">
						<div class="col-md-8">
							<h4>No. Quotation : <label id="no_po2" style="font-weight: bold"></label></h4>
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<th><center>No</center></th>
										<th><center>Item</center></th>
										<th><center>Deskripsi</center></th>
										<th><center>Qty</center></th>
										<th><center>Harga Beli</center></th>
										<th><center>Harga Jual</center></th>
										<th><center>Disc %</center></th>
										<th><center>Lead Time</center></th>
										<th><center>Total</center></th>
										<th><center>Action</center></th>
									</thead>
									<tbody id="dt2">
										
									</tbody>
								</table>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="col-md-6">
										<div class="form-group">
											<label>User <span class="require"></span></label>
											<input class="form-control" type="hidden" id="supplier2">
										</div>
										<div class="form-group">
											<label>Quotation Untuk <span class="require"></span></label>
											<input class="form-control" type="text" id="untuk2">
										</div>
										<div class="form-group">
											<label>Terms <span class="require"></span></label>
											<select class="form-control select2me" id="bayar2">
												<option value="">Pilih</option>
												
											</select>
										</div>
										<div class="form-group">
											<label>Bank <span class="require"></span></label>
											<input class="form-control" type="hidden" id="bank2">
										</div>
									</div>
									<div class="col-md-6">
										<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover">
												<tbody>
													<tr>
														<td width="50%">Total</td>
														<td id="total2" align="right"></td>
													</tr>
													<tr>
													<td width="50%">PPN 10% <input type="checkbox" id="ppn_cek2" checked=""></td>
													<td align="right"><span id="ppn2"></span> <span style="display: none" id="ppn_no2">0</span></td>
													</tr>
													<tr>
														<td>Subtotal</td>
														<td id="gtotal2" align="right"></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>

								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>No. Inquiry</label>
								<input type="hidden" class="form-control" id="inq" onchange="get_item()">
							</div>
							<div class="form-group">
								<label>Pilih Item</label>
								<select class="form-control select2me" id="inq_item" onchange="get_inq_item()">
									
								</select>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-8">
										<label>Qty</label>
										<input type="text" class="rupiah form-control" id="inq_qty" style="text-align: right;" placeholder="Qty" autocomplete="off">
									</div>
									<div class="col-md-4">	
										<h4><span id="satuan2"></span></h4>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Harga Beli</label>
								<input type="text" class="form-control rupiah" placeholder="Harga Beli" style="text-align: right;" id="inq_hbeli" autocomplete="off">
							</div>
							<div class="form-group">
								<label>Harga Jual</label>
								<input type="text" class="form-control rupiah" placeholder="Harga Jual" style="text-align: right;" id="inq_hjual" autocomplete="off">
							</div>
							<div class="form-group">
								<label>Fee</label>
								<input type="text" class="form-control rupiah" placeholder="Fee" style="text-align: right;" id="fee2" autocomplete="off">
							</div>
							<div class="form-group">
								<label>Discount (%)</label>
								<input type="text" class="form-control" style="text-align: right;" id="inq_disc" autocomplete="off" maxlength="2">
							</div>
							<div class="form-group">
								<label>Lead Time</label>
								<input type="text" class="form-control" placeholder="Lead Time" id="inq_lead_time" autocomplete="off" style="text-transform: uppercase;">
							</div>
							<div class="form-group">
								<label>Keterangan Produk</label>
								<textarea class="form-control" id="ket2" placeholder="Keterangan" style="resize: none;height: 200px;"></textarea>
							</div>
							<div class="form-group">
								<button class="btn blue" id="btn-add2" onclick="add2()"> <i class="fa fa-plus"></i> Tambah</button>
							</div>
						</div>
					</div>
					
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn green" id="btn-gg2" disabled="" data-toggle="modal" data-target="#md-save2">Simpan Transaksi</button>
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

<div class="modal" id="md-save2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
				<button type="submit" class="btn red" id="btn-save2"  onclick="save2()">Proses</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<div class="modal fade" id="md-rev" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-big">
		<div class="modal-content modal-content-big">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Revisi Item</h4>
			</div>
			<form method="POST" id="edit-form">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-2 col-sm-12">
							<div class="form-group">
						 		<label>Kode Revisi</label>
						 		<input id="kdrev" class="form-control" style="text-transform: uppercase;" maxlength="2">
						 	</div>
						</div>
						<div class="col-md-12 col-sm-12">

						 	<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<th><center>No</center></th>
										<th><center>Deskripsi</center></th>
										<th><center>Qty</center></th>
										<th><center>Harga Beli</center></th>
										<th><center>Harga Jual</center></th>
										<th><center>Disc%</center></th>
										<th><center>Lead Time</center></th>
										<th><center>Total</center></th>
										<th><center>Action</center></th>
									</thead>
									<tbody id="dt-rev">
										
									</tbody>
									<tfoot>
										<tr>
											<th colspan="7"><center>SUBTOTAL</center></th>
											<th id="rsub" style="text-align: right;"></th>
											<th></th>
										</tr>
										<tr>
											<th colspan="7"><center>PPN 10%</center></th>
											<th id="rppn" style="text-align: right;"></th>
											<th></th>
										</tr>
										<tr>
											<th colspan="7"><center>GRAND TOTAL</center></th>
											<th id="rgtotal" style="text-align: right;"></th>
											<th></th>
										</tr>
									</tfoot>
								</table>
						 	</div>
						</div>
						
					</div>
				</div>
			</form>
			<div class="modal-footer">
				<button class="btn green" id="btn-srev" onclick="save_rev()" >Simpan Revisi</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<div class="modal" id="md-ed" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Revisi Item <strong id="ritem"></strong></h4>
			</div>
			<div class="modal-body">
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Qty <span class="require"></span></label>
							<input id="rqty" class="form-control">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Harga Beli <span class="require"></span></label>
							<input id="rbeli" class="form-control rupiah">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Harga Jual <span class="require"></span></label>
							<input id="rjual" class="form-control rupiah">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Disc % <span class="require"></span></label>
							<input id="rdisc" class="form-control" maxlength="2">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Lead Time <span class="require"></span></label>
							<input id="rlead" class="form-control ">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label>Keterangan Revisi</label>
							<textarea class="form-control" id="rket" style="resize: none;height: 200px;"></textarea>
						</div>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn default" data-dismiss="modal">Batal</button>
				<button type="submit" class="btn red" id="btn-rev"  onclick="rev()">Proses</button>
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

<script>
	var table;
		
	$(document).ready(function() {
		$('.tooltips').tooltip();
		get_trans();
		dt();
		dt2();
		select("pembayaran/select", "bayar");
		select("pembayaran/select", "bayar2");
		select("pembayaran/select", "src_bayar");
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

		var sel_inq = {
	        placeholder: "Pilih",
	        minimumInputLength: 2,
	        ajax: {
	            url: '<?php echo base_url() ?>inquiry/select2',
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
	            return "<div>" + option.id + "</div>";
	        },
	        formatSelection: function (option) {
	            return option.id;
	        }
	    };
	    $("#inq").select2(sel_inq);

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
	    $("#supplier2").select2(sel_supplier);
	    var sel_bank = {
	        placeholder: "Pilih",
	        minimumInputLength: 2,
	        ajax: {
	            url: '<?php echo base_url() ?>bank/select2',
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
	            return "<div>" + option.nama_bank + "</div>";
	        },
	        formatSelection: function (option) {
	            return option.nama_bank;
	        }
	    };
	    $("#bank").select2(sel_bank);
	    $("#bank2").select2(sel_bank);


		//Modal Setting
		$('#md-add').on('shown.bs.modal', function() {
		    $("#item").select2("focus");
		});

		$('#md-add2').on('shown.bs.modal', function() {
		    $("#inq").select2("focus");
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
	        "order": [[ 2, "desc" ]], //Initial no order.
	        "loadingMessage": 'Loading...',
	        "searching":false,
	        "aoColumnDefs": [
				{ "bSortable": false, "aTargets": [ 0,4,6,8 ] }
			],
			"oLanguage": {sProcessing: "<i class='fa fa-spinner fa-pulse fa-lg'></i> Loading..."},
	 		
	        // Load data for the table's content from an Ajax source
	        "ajax": {
	            "url": "<?php echo site_url('quotation/data')?>",
	            "type": "POST",
	            "dataType":"json",
	            "data":function ( d ) {
	                  return $.extend( {}, d, {
	                  		"src_po": $('#src_po').val(),
	                  		"src_from" : toTglSys($("#src_from").val()),
	                  		"src_to" : toTglSys($("#src_to").val()),
	                  		"src_supplier" : $("#src_supplier").val(),
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
					    	var left = $btnDropDown.offset().left - 310;
					    	var top = $btnDropDown.offset().top - 160;
					    }
					    else if(parseInt($btnDropDown.offset().left) >= 620 && parseInt($btnDropDown.offset().left)<870){
					    	var left = $btnDropDown.offset().left-310;
					    	var top = $btnDropDown.offset().top - 160;
					    }
					    else{
					    	var left = $btnDropDown.offset().left-110;
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
						$("#total_all").html(parseInt(data[len-1][9]).toLocaleString("de-DE"));
					}
					else{
						$("#total_all").html("0");
						//$(tfoot).find('th').eq(1).html("0");
					}

				}
	 
	    });

	});

	function unduh(){
		//<?php echo base_url() ?>quotation/excel?src_supplier=kerta
		var src_po 			= $("#src_po").val();
		var src_from 		= toTglSys($("#src_from").val());
		var src_to 			= toTglSys($("#src_to").val());
		var src_supplier 	= $("#src_supplier").val();
		var src_user 		= $("#src_user").val();
		var src_status 		= "";
		var src_bayar 		= $("#src_bayar").val();

		window.open('<?php echo base_url() ?>quotation/excel?src_po='+src_po+'&src_from='+src_from+'&src_to='+src_to+'&src_supplier='+src_supplier+'&src_user='+src_user+'&src_status='+src_status+'&src_bayar='+src_bayar, '_blank');

	}

	function add2(){

		var harga 		= $("#inq_hjual").val();
		var modal 		= $("#inq_hbeli").val();
		var satuan 		= $("#satuan2").val();
		var id 			= $("#inq_item").val();
		var qty 		= $("#inq_qty").val();
		var lead_time 	= $("#inq_lead_time").val();
		var inq 		= $("#inq_item option:selected").attr("dt");
		var ket 		= $("#ket2").val();
		var disc 		= $("#inq_disc").val();
		var fee 		= $("#fee2").val();


		if (id && qty && harga && modal && disc&& fee !=="") {
			$.ajax({

				type:"POST",
				url:"<?php echo base_url();?>quotation/add2",
				dataType:"json",
				data:{id, qty, harga, satuan, lead_time, modal, inq, ket, disc, fee},
				beforeSend:function(){
					$("#btn-add2").html(loading_event());
					$("#btn-add2").attr("disabled", "disabled");
				},
				success:function(data){

					switch(parseFloat(data)){

						case 0:
							notif("Error", "Item gagal ditambahkan.", "error");
						break;

						case 1:
							dt2();
							get_trans();
							//notif("Success", "Produk berhasil ditambahkan.", "success");
							$("#inq_qty").val("");
							$("#inq_hjual").val("");
							$("#inq_hbeli").val("");
							$("#inq_item").val("");
							$("#inq_disc").val("");
							$("#fee2").val("");
							$("#inq_item").trigger("change");
							$("#inq_lead_time").val("");
							$("#ket2").val("");
							
						break;

					}

				},
				complete:function(){
					$('#inq_item').select2('focus');
					$("#btn-add2").html("<i class='fa fa-plus'></i> Tambahkan");
					$("#btn-add2").removeAttr("disabled");
				}

			});
		}
		else{
			notif("Error", "Isi Produk terlebih dahulu.", "error");
		}

	}

	function get_inq_item(){

		var id = $("#inq_item").val();
		var qty = $("#inq_item option:selected").attr("qty");
		var harga = $("#inq_item option:selected").attr("hrg");
		var modal = $("#inq_item option:selected").attr("mdl");

		if (id!=="") {
			$("#inq_qty").val(qty);
			$("#inq_hjual").val(parseInt(harga).toLocaleString("de-DE"));
			$("#inq_hbeli").val(parseInt(modal).toLocaleString("de-DE"));
		}

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
			url:"<?php echo base_url() ?>quotation/detail",
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
						l+="<td align='right'><span class='tooltips' data-placement='top' data-original-title='Fee : "+data[i].fee+"'>"+data[i].hf+"</span></td>";
						l+="<td align='right'>"+data[i].disc+"%</td>";
						l+="<td align='center'>"+data[i].lead_time+"</td>";
						l+="<td align='right'>"+data[i].total+"</td>";
					l+="</tr>";
				}

				$("#duntuk").html(data[0].untuk);

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

	function get_rev(id, qty, modal, harga, lead_time, nm, no_trans, disc, idproduk, ket){
		$("#get_id").val(id);
		$("#rqty").val(qty);
		$("#rbeli").val(modal);
		$("#rjual").val(harga);
		$("#rlead").val(lead_time);
		$("#ritem").html(nm);
		$("#trans").val(no_trans);
		$("#rdisc").val(disc);
		$("#idproduk").val(idproduk);
		$("#rket").val(ket);
	}

	function rev(){
		var harga 		= $("#rjual").val();
		var modal 		= $("#rbeli").val();
		var id 			= $("#get_id").val();
		var qty 		= $("#rqty").val();
		var lead_time 	= $("#rlead").val();
		var no_trans    = $("#trans").val();
		var disc 		= $("#rdisc").val();
		var idproduk    = $("#idproduk").val();
		var ket_rev     = $("#rket").val();


		if (id && qty && harga && modal && lead_time && disc && ket_rev !=="") {
			$.ajax({

				type:"POST",
				url:"<?php echo base_url();?>quotation/rev_item",
				dataType:"json",
				data:{id, qty, harga, lead_time, modal, disc, idproduk, ket_rev},
				beforeSend:function(){
					$("#btn-rev").html(loading_event());
					$("#btn-rev").attr("disabled", "disabled");
				},
				success:function(data){

					switch(parseFloat(data)){

						case 0:
							notif("Error", "Item gagal direvisi.", "error");
						break;

						case 1:
							notif("Success", "Item berhasil direvisi.", "success");
							revisi(no_trans);
							$("#md-ed").modal("toggle");
						break;

					}

				},
				complete:function(){
					$("#btn-rev").html("Proses");
					$("#btn-rev").removeAttr("disabled");
				}

			});
		}
		else{
			notif("Error", "Error Revisi.", "error");
		}	
	}

	function save_rev(){
		var kode 		= $("#kdrev").val();
		var no_trans    = $("#trans").val();
		//var ket_rev		= $("#ket_rev").val();


		if (kode && no_trans !=="") {
			$.ajax({

				type:"POST",
				url:"<?php echo base_url();?>quotation/save_rev",
				dataType:"json",
				data:{no_trans, kode},
				beforeSend:function(){
					$("#btn-srev").html(loading_event());
					$("#btn-srev").attr("disabled", "disabled");
				},
				success:function(data){

					switch(parseFloat(data)){

						case 0:
							notif("Error", "Quotation gagal direvisi.", "error");
						break;

						case 0.1:
							notif("Error", "Kode Revisi sudah digunakan.", "error");
						break;

						case 1:
							notif("Success", "Quotation berhasil direvisi.", "success");
							table.ajax.reload(false,null);
							$("#md-rev").modal("toggle");
						break;

					}

				},
				complete:function(){
					$("#btn-srev").html("Simpan Revisi");
					$("#btn-srev").removeAttr("disabled");
				}

			});
		}
		else{
			notif("Error", "Error Revisi.", "error");
		}	
	}

	function revisi(id){

		$.ajax({
			type:"POST",
			url:"<?php echo base_url() ?>quotation/detail",
			dataType:"json",
			data:{id},
			beforeSend:function(){
				$("#dt-rev").html("<tr><td colspan='8' align='center'><i class='fa fa-spinner fa-pulse'></i> Loading...</td></tr>");
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
						l+="<td align='right'><span class='tooltips' data-placement='top' data-original-title='Fee : "+data[i].fee+"'>"+data[i].hf+"</span></td>";
						l+="<td align='right'>"+data[i].disc+"%</td>";
						l+="<td align='center'>"+data[i].lead_time+"</td>";
						l+="<td align='right'>"+data[i].total+"</td>";
						l+="<td align='center'>";
								l+="<a href='javascript:;' data-toggle='modal' data-target='#md-ed' onclick='get_rev("+data[i].id+", "+data[i].qty+", \""+data[i].modal+"\", \""+data[i].harga+"\", \""+data[i].lead_time+"\", \""+data[i].deskripsi+"\", \""+id+"\", "+data[i].disc+", "+data[i].idproduk+", \""+data[i].ket_revisi+"\"  )'>";
									l+="<i class='fa fa-pencil'></i>";
								l+="</a>";
							l+="</td>";
					l+="</tr>";
				}

				$("#rsub").html(data[len-1].subtotal);
				$("#rppn").html(data[len-1].ppn);
				$("#rgtotal").html(data[len-1].gtotal);
				$("#kdrev").val(data[0].revisi);
				$("#dt-rev").html(l);
				$("#trans").val(id);
				$("#ket_rev").val(data[0].ket_revisi);

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
		var no_trans = $("#no_po").text();
		var item = $("#total_item").val();
		var supplier = $("#supplier").val();
		var bayar = $("#bayar").val();
		var bank = $("#bank").val();
		var cek_ppn = $("#val_ppn").val();
		var untuk = $("#untuk").val();
		if (supplier && bank && bayar && untuk !== "") {

			$.ajax({

				type:"POST",
				url:"<?php echo base_url() ?>quotation/save",
				dataType:"json",
				data:{no_trans, item, supplier, bank, bayar, untuk, cek_ppn},
				beforeSend:function(){
					$("#btn-save").html(loading_event());
					$("#btn-save").attr("disabled", "disabled");
				},
				success:function(data){

					switch(parseFloat(data)){

						case 1:
							notif("Success","Quotation disimpan.", "success");
							get_trans();
							table.draw();
							dt();

							$("#supplier").select2("val", "");
							$("#bank").select2("val", "");
							$("#bayar").val("");
							$("#bayar").trigger("change");

							$("#ppn").html("0");
							$("#untuk").html("");
							$("#val_ppn").val("Y");
							$('#ppn_cek').attr('checked', "checked");


							$("#md-save").modal("toggle");
							$("#md-add").modal("toggle");
						break;

						case 0:
							get_trans();
							notif("Error","Quotation gagal disimpan.", "error");
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
			notif("Error", "Pilih Supplier terlebih dahulu.", "error");
		}

	}
	function save2(){
		get_trans();
		var no_trans = $("#no_po2").text();
		var item = $("#total_item2").val();
		var supplier = $("#supplier2").val();
		var bayar = $("#bayar2").val();
		var bank = $("#bank2").val();
		var untuk = $("#untuk2").val();

		if (supplier && bank && bayar && untuk !== "") {

			$.ajax({

				type:"POST",
				url:"<?php echo base_url() ?>quotation/save2",
				dataType:"json",
				data:{no_trans, item, supplier, bank, bayar, untuk},
				beforeSend:function(){
					$("#btn-save2").html(loading_event());
					$("#btn-save2").attr("disabled", "disabled");
				},
				success:function(data){

					switch(parseFloat(data)){

						case 1:
							notif("Success","Purchase Order Out berhasil disimpan.", "success");
							get_trans();
							table.draw();
							dt2();

							$("#supplier2").select2("val", "");
							$("#bank2").select2("val", "");
							$("#bayar2").val("");
							$("#bayar2").trigger("change");

							$("#ppn2").html("0");

							$("#md-save2").modal("toggle");
							$("#md-add2").modal("toggle");
						break;

						case 0:
							get_trans();
							notif("Error","Purchase Order Out gagal disimpan.", "error");
						break;

					}

				},
				complete:function(){
					$("#btn-save2").html("Proses");
					$("#btn-save2").removeAttr("disabled");
				}

			});

		}
		else{
			notif("Error", "Pilih Supplier terlebih dahulu.", "error");
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
	function cek_total2(v){

		if (parseInt(v)!=0 || parseInt(v)!="") {
			$("#btn-gg2").removeAttr("disabled");
		}
		else{
			$("#btn-gg2").attr("disabled", "disabled");
		}

	}
	function dt(){
		$.ajax({

			type:"POST",
			url:"<?php echo base_url();?>quotation/data_item",
			dataType:"json",
			beforeSend:function(){
				$("#dt").html("<tr><td colspan='10' align='center'><i class='fa fa-spinner fa-pulse'></i> Loading...</td></tr>");
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
						total+= parseInt(data[i].netto);
						pt+=parseInt(data[i].pot);
						l+="<tr>";
							l+="<td align='center'>"+(i+1)+"</td>";
							l+="<td>"+data[i].nama_item+"</td>";
							l+="<td align='left'><span class='tooltips' data-placement='top' data-original-title='"+data[i].ket+"'>"+data[i].desc+"</span></td>";
							l+="<td align='center'>"+parseInt(data[i].qty).toLocaleString('de-DE')+" "+data[i].satuan+"</td>";
							l+="<td align='right'>"+parseInt(data[i].modal).toLocaleString('de-DE')+"</td>";
							l+="<td align='right'><span class='tooltips' data-placement='top' data-original-title='Fee : "+data[i].fee+"'>"+parseInt(data[i].hf).toLocaleString('de-DE')+"</span></td>";
							l+="<td align='right'>"+parseInt(data[i].disc).toLocaleString('de-DE')+"</td>";
							l+="<td align='center'>"+data[i].lead_time+"</td>";
							l+="<td align='right'>"+parseInt(data[i].netto).toLocaleString('de-DE')+"</td>";
							l+="<td align='center'><a href='javascript:;' id='btn-del-"+i+"' onclick='del("+data[i].id+", "+i+")'><i class='fa fa-trash fa-lg'></i></a></td>";
						l+="</tr>";

					}
					var cek_ppn = $("#val_ppn").val();
					var tax = ((total - pt) * 10 / 100);
					//var gtotal  = ((total - pt)+tax).toLocaleString("de-DE");
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
					//$("#tdisc").html(min+pt.toLocaleString("de-DE"));
					$("#gtotal").html(gtotal);
					$("#total_item").val(data.length);
					$("#ppn").html(tax.toLocaleString("de-DE"));

				}
				else{
					cek_total(0);
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
	function dt2(){
		$.ajax({

			type:"POST",
			url:"<?php echo base_url();?>quotation/data_item2",
			dataType:"json",
			beforeSend:function(){
				$("#dt2").html("<tr><td colspan='10' align='center'><i class='fa fa-spinner fa-pulse'></i> Loading...</td></tr>");
			},
			success:function(data){

				var l = "";
				//cek_total();
				get_trans();
				if (data.length!=0) {
					cek_total2(data[0].total_item);
					var total = 0;
					var pt = 0;
					for(var i = 0 ; i<data.length ; i++){
						total+= parseInt(data[i].netto);
						pt+=parseInt(data[i].pot);
						l+="<tr>";
							l+="<td align='center'>"+(i+1)+"</td>";
							l+="<td>"+data[i].nama_item+"</td>";
							l+="<td align='left'><span class='tooltips' data-placement='top' data-original-title='"+data[i].ket+"'>"+data[i].desc+"</span></td>";
							l+="<td align='center'>"+parseInt(data[i].qty).toLocaleString('de-DE')+" "+data[i].satuan+"</td>";
							l+="<td align='right'>"+parseInt(data[i].modal).toLocaleString('de-DE')+"</td>";
							l+="<td align='right'><span class='tooltips' data-placement='top' data-original-title='Fee : "+data[i].fee+"'>"+parseInt(data[i].hf).toLocaleString('de-DE')+"</span></td>";
							l+="<td align='right'>"+parseInt(data[i].disc).toLocaleString('de-DE')+" %</td>";
							l+="<td align='center'>"+data[i].lead_time+"</td>";
							l+="<td align='right'>"+parseInt(data[i].netto).toLocaleString('de-DE')+"</td>";
							l+="<td align='center'><a href='javascript:;' id='btn-del2-"+i+"' onclick='del2("+data[i].id+", "+i+")'><i class='fa fa-trash fa-lg'></i></a></td>";
						l+="</tr>";

					}
					var tax = (total * 10 / 100);
					var gtotal  = (total+tax).toLocaleString("de-DE");
					if (pt <= 0) {
						var min = "";
					}
					else{
						var min = "-";
					}
					
					$("#total2").html(total.toLocaleString("de-DE"));
					//$("#tdisc").html(min+pt.toLocaleString("de-DE"));
					$("#gtotal2").html(gtotal);
					$("#total_item2").val(data.length);
					$("#ppn2").html(tax.toLocaleString("de-DE"));

				}
				else{
					cek_total2(0);
					l+="<tr><td colspan='10' align='center'>Tidak ada data.</td></tr>";
					
					$("#total2").html("0");
					//$("#tdisc").html("0");
					$("#gtotal2").html("0");
					$("#total_item2").val("0");
					$("#ppn2").html("0");

				}

				$("#dt2").html(l);

			},
			complete:function(){
				$('.tooltips').tooltip();
			}

			});
	}
	function del(id, i){

		$.ajax({

			type:"POST",
			url:"<?php echo base_url();?>quotation/del",
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
	function del2(id, i){

		$.ajax({

			type:"POST",
			url:"<?php echo base_url();?>quotation/del2",
			dataType:"json",
			data:{id},
			beforeSend:function(){
				$("#btn-del2-"+i).html("<i class='fa fa-spinner fa-pulse fa-lg'></i>");
				$("#btn-del2-"+i).bind('click', false);
			},
			success:function(data){

				dt2();
				get_trans();
				$('#inq_item').select2('focus');

			},
			complete:function(){
				$("#btn-del2-"+i).html("<i class='fa fa-trash fa-lg'></i>");
				$("#btn-del2-"+i).unbind('click', false);
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
		var lead_time 	= $("#lead_time").val();
		var modal 		= $("#modal").val();
		var ket 		= $("#ket").val();
		var disc   	 	= $("#disc").val();
		var fee 		= $("#fee").val();


		if (id && qty !=="") {
			$.ajax({

				type:"POST",
				url:"<?php echo base_url();?>quotation/add",
				dataType:"json",
				data:{id, qty, harga, satuan, lead_time, modal, ket, disc, fee},
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
							$("#lead_time").val("");
							$("#ket").val("");
							$("#disc").val("");
							$("#fee").val();

							
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
			url:"<?php echo base_url() ?>quotation/get_trans",
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

		
		if (id!="") {
			$("#satuan").html(satuan);
			$("#harga").val(parseInt(harga).toLocaleString("de-DE"));
			$("#modal").val(parseInt(modal).toLocaleString("de-DE"));
			$("#qty").focus();
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