<?php 



	$act = "";
	foreach ($aktivitas as $v) {
		switch ($v->jenis_aktivitas) {
			case 'EDIT':
				$w 		= "warning";
				$icon 	= "fa-edit";
			break;
			case 'HAPUS':
				$w 		= "danger";
				$icon 	= "fa-trash";
			break;
			case 'TAMBAH':
				$w 		= "success";
				$icon 	= "fa-plus";
			break;
		}
		$act .="
			<li>
				<div class='col1'>
					<div class='cont'>
						<div class='cont-col1'>
							<div class='label label-sm label-".$w."'>
								<i class='fa ".$icon."'></i>
							</div>
						</div>
						<div class='cont-col2'>
							<div class='desc'>
								".$v->deskripsi."
							</div>
						</div>
					</div>
				</div>
				<div class='col2'>
					<div class='date'>
						 Just now
					</div>
				</div>
			</li>
		";
	}

?>


<div class="page-content">

				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
				Profile <small></small>
				</h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-user"></i>
							<a href="javascript:;">Profile</a>
						</li>
					</ul>
					
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row">
					<div class="col-md-12">
						<!-- BEGIN PROFILE SIDEBAR -->
						<?php
							$path = APPPATH."views/port/profile-sidebar.php";
							include($path);
						?>  
						<!-- END BEGIN PROFILE SIDEBAR -->
						<!-- BEGIN PROFILE CONTENT -->
						<div class="profile-content">
							<div class="row">
								<div class="col-md-12">
									<!-- BEGIN PORTLET -->
									<div class="portlet light">
										<div class="portlet-title tabbable-line">
											<div class="caption caption-md">
												<i class="icon-globe theme-font hide"></i>
												<span class="caption-subject font-blue-madison bold uppercase">Aktivitas</span>
											</div>
											<ul class="nav nav-tabs">
												
											</ul>
										</div>
										<div class="portlet-body">
											<!--BEGIN TABS-->
											<div class="tab-content">
												<div class="tab-pane active" id="tab_1_1">
													<div class="scroller" style="height: 320px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
														<ul class="feeds">
															<?php echo $act ?>															
														</ul>
													</div>
												</div>
											</div>
											<!--END TABS-->
										</div>
									</div>
									<!-- END PORTLET -->
								</div>
							</div>
						</div>
						<!-- END PROFILE CONTENT -->
					</div>
				</div>
				<!-- END PAGE CONTENT-->
</div>