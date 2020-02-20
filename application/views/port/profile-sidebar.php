<?php

	$sl = "
      user.*,
      jabatan.id AS jabid,
      jabatan.nama_jabatan
    ";

    $this->db->select($sl);
    $this->db->from("user");
    $this->db->join("jabatan", "user.idjabatan = jabatan.id");
    $this->db->where("user.username", $sess_user);
    $user = $this->db->get()->row_array();

	if ($user["foto"]!="") {
		$img = base_url()."upload/user/".$user["foto"];
	}
	else{
		switch ($user["jk"]) {
			case 'Laki - laki':
				$img = base_url()."assets/layout2/img/user-m.png";
			break;
			case 'Perempuan':
				$img = base_url()."assets/layout2/img/user-f.png";
			break;
		}
	}

?>

<style type="text/css">
	.wprofile{
		height:200px;
		width:200px;
		margin:auto;
		overflow:hidden;
		-webkit-border-radius: 50% !important;
	    -moz-border-radius: 50% !important;
	    border-radius: 50% !important; 
	}

</style>

<div class="profile-sidebar" style="width: 250px;">
		<!-- PORTLET MAIN -->
		<div class="portlet light profile-sidebar-portlet">
			<!-- SIDEBAR USERPIC -->
			<div class="profile-userpic">
				<div class="wprofile">
					<img src="<?php echo $img ?>" class="img-responsive img-profile">
				</div>
			</div>
			<!-- END SIDEBAR USERPIC -->
			<!-- SIDEBAR USER TITLE -->
			<div class="profile-usertitle">
				<div class="profile-usertitle-name">
					 <?php echo $user["nama"] ?><br>
					 <small style="color:#b7b7b7">@<?php echo $user["username"] ?></small>
				</div>
				<div class="profile-usertitle-job">
					 <?php echo $user["nama_jabatan"] ?>
				</div>
			</div>
			<!-- END SIDEBAR USER TITLE -->
			<!-- SIDEBAR BUTTONS 
			<div class="profile-userbuttons">
				<button type="button" class="btn btn-circle green-haze btn-sm">Pesan</button>
			</div>
			END SIDEBAR BUTTONS -->
			<!-- SIDEBAR MENU -->
			<div class="profile-usermenu">
				<ul class="nav">
					<li class="<?php if($page=='profile'){echo 'active';} ?>">
						<a href="<?php echo base_url()?>profile">
							<i class="icon-home"></i>
							Kronologi
						</a>
					</li>
					<li class="<?php if($page=='profile_edit'){echo 'active';} ?>">
						<a href="<?php echo base_url()?>profile/edit">
							<i class="icon-settings"></i>
							Edit Profile
						</a>
					</li>

					<li>
						<a href="extra_profile_help.html">
						<i class="icon-info"></i>
						Help </a>
					</li>
				</ul>
			</div>
			<!-- END MENU -->
		</div>
		<!-- END PORTLET MAIN -->
		<!-- PORTLET MAIN -->
		<div class="portlet light">
			<!-- STAT -->
			<div class="row list-separated profile-stat">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="uppercase profile-stat-title">
						 0
					</div>
					<div class="uppercase profile-stat-text">
						 Transaksi
					</div>
				</div>
				
			</div>
			<!-- END STAT -->
			<div>
				<div class="margin-top-20 profile-desc-link">
					<i class="fa fa-phone"></i>
					<?php echo $user["no_hp"] ?>
				</div>
			</div>
		</div>
		<!-- END PORTLET MAIN -->
	</div>