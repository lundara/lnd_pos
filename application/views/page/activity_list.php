<div class="page-content">

				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
					Activity List Marketing<small></small>
				</h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-cube"></i>
							<a href="javascript:;">Activity List Marketing</a>
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
									<i class="fa fa-database"></i> Data Activity List Marketing
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
													<input type="text" class="form-control" placeholder="Cari Marketing..." id="src_mkt" autocomplete="off">
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
		$("#src_mkt").val("");
		dt();
	}

	function dt(){

		var src_mkt = $("#src_mkt").val();

		if (src_mkt!=="") {
			$("#btn-res").fadeIn();
		}
		else{
			$("#btn-res").hide();
		}

		$.ajax({
			url:"<?php echo base_url() ?>activity_list/dt_mkt",
			type:"POST",
			dataType:"json",
			data:{src_mkt},
			beforeSend:function(){

			},
			success:function(data){
				var len = data.length;

				if (len!==0) {
					var d = "";
					for(var i = 0; i < len; i++){

						if (data[i].foto!=="") {
							var img = "upload/user/"+data[i].foto;
						}
						else{
							var img = "assets/layout2/img/user-m.png";
						}

						d+="<div class='col-lg-3 col-md-3 col-sm-6 col-xs-12' style='margin-top:10px;'>";
							d+="<a class='dashboard-stat dashboard-stat-light blue' href='<?php echo base_url() ?>activity_list/detail/"+data[i].username+"'>";
							d+="<div class='visual'>";
								d+="<div style='border-radius:50% !important;overflow:hidden;width:60px;height:60px;'><img src='<?php echo base_url() ?>"+img+"' class='img-responsive'></div>";
							d+="</div>";	
							d+="<div class='details' style='width:200px;'>";
								d+="<div class='number'>";
									
								d+="</div>";
								d+="<div class='desc'>";
									 d+= data[i].nama+"<br>";
									 d+= "<label style='font-size:10px'>Terakhir di update : <br></label>";
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