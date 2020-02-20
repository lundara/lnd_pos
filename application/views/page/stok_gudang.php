<div class="page-content">

				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
					Stok <small></small>
				</h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-cube"></i>
							<a href="javascript:;">Stok</a>
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
									<i class="fa fa-database"></i> Data Stok
								</div>
								<div class="tools">
									<a href="javascript:;" class="collapse">
									</a>
								</div>
							</div>
							<div class="portlet-body" style="min-height: 500px;">
								<div class="row">
									<div class="col-md-3 col-sm-12">
										<div class="form-group">
											<form class="search-form search-form-expanded" action="extra_search.html" method="POST" id="fsrc">
												<div class="input-group">
													<input type="text" class="form-control" placeholder="Cari Gudang..." id="src_gudang" autocomplete="off">
													<span class="input-group-btn">
														<a href="javascript:;" class="btn submit green"><i class="icon-magnifier"></i></a>
														<a href="javascript:;" class="btn submit red" id="btn-res" style="display: none" onclick="res();">
															<i class="fa fa-times"></i>
														</a>
													</span>
												</div>
											</form>
										</div>
									</div>
								</div>
								<div class="row" id="dt">
									

									
								</div>
							</div>
						</div>

					</div>
				</div>
				<!-- END PAGE CONTENT-->
</div>


<input type="hidden" id="get_id">

<script>
	
$(document).ready(function(){
	dt();

	$("#fsrc").submit(function(e){
		e.preventDefault();
		dt();
	});

});
	
	function res(){
		$("#src_gudang").val("");
		dt();
	}

	function dt(){

		var src_gudang = $("#src_gudang").val();

		if (src_gudang!=="") {
			$("#btn-res").fadeIn();
		}
		else{
			$("#btn-res").hide();
		}

		$.ajax({
			url:"<?php echo base_url() ?>stok/dt_gudang",
			type:"POST",
			dataType:"json",
			data:{src_gudang},
			beforeSend:function(){

			},
			success:function(data){
				var len = data.length;

				if (len!==0) {
					var d = "";
					for(var i = 0; i < len; i++){

						d+="<div class='col-lg-3 col-md-3 col-sm-6 col-xs-12'>";
							d+="<a class='dashboard-stat dashboard-stat-light purple' href='<?php echo base_url() ?>stok/detail/"+data[i].id+"'>";
							d+="<div class='visual'>";
								d+="<i class='fa fa-home'></i>";
							d+="</div>";	
							d+="<div class='details'>";
								d+="<div class='number'>";
									 d+= data[i].nama_gudang;
								d+="</div>";
								d+="<div class='desc'>";
									
								d+="</div>";
							d+="</div>";
							d+="</a>";
						d+="</div>";
					}
					$("#dt").html(d);
				}
				else{
					$("#dt").html("<div class='col-md-3'><label>Tidak ada data.</label></div>");
				}
			},
			complete:function(){

			}
		});
	}	 


		
	function reload(){
		$("#src_nama").val("");

		table.draw();
	}

	function edit(id){
		getId(id);
		$.ajax({
			url:"<?php echo base_url()?>satuan/edit",
			type:"POST",
			data: {id},
			daraType:"json",
			cache:false,
			beforeSend:function(){
				$(".inp").attr("disabled", "disabled");
			},
			success:function(data){
				$("#enama").val(data[0].nama_satuan);
			},
			complete:function(){
				$(".inp").removeAttr("disabled");
			}
		 });
	}
	function getId(id){
		$("#get_id").val(id);
	}

</script>