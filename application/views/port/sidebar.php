
<?php  
	
	$lnd_id = $this->session->userdata("lnd_id");

	//$this->db->where("username", $lnd_id);
	$qmodul = $this->db->get("modul")->result();


	$modul = "";
	foreach ($qmodul as $vmd) {


		$this->db->select("
				akses.*,
				modul.id AS modulid,
				modul.nama_modul,
				modul.icon AS icon_modul,
				menu.id AS menuid,
				menu.nama_menu,
				menu.aktif,
				menu.file,
				menu.icon AS icon_menu

			");
		$this->db->from("akses");
		$this->db->join("menu", "menu.id = akses.idmenu");
		$this->db->join("modul", "modul.id = menu.idmodul");
		$this->db->where("modul.id", $vmd->id);
		$this->db->where("akses.username", $lnd_id);
		$this->db->where("akses.status", "Open");
		$this->db->order_by("menu.nama_menu", "ASC");
		$qakm = $this->db->get();

		$cakm = $qakm->num_rows();
		$dakm = $qakm->result();
		$menu2 = "";
		foreach ($dakm as $vmn) {
			if($submenu == $vmn->aktif){
				$subact= 'active';
			}
			else{
				$subact = "";
			}
			$menu2.="
				<li class='".$subact."'>
					<a href='".base_url().$vmn->file."'>
						<i class='fa ".$vmn->icon_menu."'></i>
						".$vmn->nama_menu."
					</a>
				</li>
			";
		}

		if ($cakm!=0) {

			if($menu == $vmd->aktif){
				$act= 'active';
			}
			else{
				$act = "";
			}
			$modul .="
				<li class='".$act."'>
					<a href='javascript:;'>
						<i class='fa ".$vmd->icon."'></i>
						<span class='title'>".$vmd->nama_modul."</span>
						<span class='selected '></span>
					</a>
					<ul class='sub-menu'>
						
						".$menu2."

					</ul>
				</li>

			";
		}

		
	}

?>

<div class="page-sidebar-wrapper">
			<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
			<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
			<div class="page-sidebar navbar-collapse collapse">
				<!-- BEGIN SIDEBAR MENU -->
				<!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
				<!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
				<!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
				<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
				<!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
				<!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
				<ul class="page-sidebar-menu page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
					<li class="start <?php if($menu == 'dashboard'){echo 'active';}?> ">
						<a href="<?php echo base_url() ?>dashboard">
						<i class="fa fa-bar-chart-o"></i>
						<span class="title">Dashboard</span>
						<span class="selected"></span>
						</a>
					</li>

					<?php echo $modul ?>

					<!--
					<li class="<?php if($menu == 'master_data'){echo 'active';}?>">
						<a href="javascript:;">
							<i class="fa fa-database"></i>
							<span class="title">Master Data</span>
							<span class="selected "></span>
						</a>
						<ul class="sub-menu">
							<li class="<?php if($submenu == 'satuan'){echo 'active';}?>">
								<a href="<?php echo base_url() ?>satuan">
									<i class="fa fa-cube"></i>
									Satuan
								</a>
							</li>
							<li class="<?php if($submenu == 'produk'){echo 'active';}?>">
								<a href="<?php echo base_url() ?>produk">
									<i class="fa fa-cubes"></i>
									Produk
								</a>
							</li>
							<li class="<?php if($submenu == 'jabatan'){echo 'active';}?>">
								<a href="<?php echo base_url() ?>jabatan">
									<i class="fa fa-briefcase"></i>
									Jabatan
								</a>
							</li>
							<li class="<?php if($submenu == 'user'){echo 'active';}?>">
								<a href="<?php echo base_url() ?>user">
									<i class="fa fa-user"></i>
									User
								</a>
							</li>
							<li class="<?php if($submenu == 'cabang'){echo 'active';}?>">
								<a href="<?php echo base_url() ?>cabang">
									<i class="fa fa-home"></i>
									Cabang
								</a>
							</li>
							<li class="<?php if($submenu == 'supplier'){echo 'active';}?>">
								<a href="<?php echo base_url() ?>supplier">
									<i class="fa fa-truck"></i>
									Supplier
								</a>
							</li>

						</ul>
					</li>
					<li class="<?php if($menu == 'stok'){echo 'active';}?>">
						<a href="javascript:;">
						<i class="fa fa-cubes"></i>
						<span class="title">Stok</span>
						<span class="arrow "></span>
						<span class="selected "></span>
						</a>
						<ul class="sub-menu">
							<li class="<?php if($submenu == 'data_stok'){echo 'active';}?>">
								<a href="<?php echo base_url() ?>stok">
									<i class="fa fa-cubes"></i>
									Data Stok
								</a>
							</li>
							<li class="<?php if($submenu == 'stok_opname'){echo 'active';}?>">
								<a href="<?php echo base_url() ?>stok/opname">
									<i class="fa fa-calculator"></i>
									Stok Opname
								</a>
							</li>
							<li class="<?php if($submenu == 'lap_so'){echo 'active';}?>">
								<a href="<?php echo base_url() ?>stok/so_cabang">
									<i class="fa fa-clipboard"></i>
									Laporan Stok Opname
								</a>
							</li>
						</ul>
					</li>
					<li class=" <?php if($menu == 'transaksi'){echo 'active';}?>">
						<a href="javascript:;">
						<i class="fa fa-shopping-cart"></i>
						<span class="title">Transaksi</span>
						<span class="arrow "></span>
						<span class="selected "></span>
						</a>
						<ul class="sub-menu">
							<li class="<?php if($submenu == 'penjualan'){echo 'active';}?>">
								<a href="<?php echo base_url() ?>penjualan">
									<i class="fa fa-cart-plus"></i>
									Penjualan
								</a>
							</li>
							<li class="<?php if($submenu == 'pembelian'){echo 'active';}?>">
								<a href="<?php echo base_url() ?>pembelian">
									<i class="fa fa-cart-plus"></i>
									Pembelian
								</a>
							</li>
							<li class="<?php if($submenu == 'retur_penjualan'){echo 'active';}?>">
								<a href="<?php echo base_url() ?>retur_penjualan">
									<i class="fa fa-arrow-down"></i>
									Retur Penjualan
								</a>
							</li>
							<li class="<?php if($submenu == 'retur_pembelian'){echo 'active';}?>">
								<a href="<?php echo base_url() ?>retur_pembelian">
									<i class="fa fa-arrow-up"></i>
									Retur Pembelian
								</a>
							</li>
						</ul>
					</li>

					<li class=" <?php if($menu == 'laporan'){echo 'active';}?>">
						<a href="javascript:;">
						<i class="fa fa-clipboard"></i>
						<span class="title">Laporan</span>
						<span class="arrow "></span>
						<span class="selected "></span>
						</a>
						<ul class="sub-menu">
							<li class="<?php if($submenu == 'lap_penjualan'){echo 'active';}?>">
								<a href="<?php echo base_url() ?>penjualan/laporan">
									<i class="fa fa-cart-plus"></i>
									Penjualan
								</a>
							</li>
							<li class="<?php if($submenu == 'lap_pembelian'){echo 'active';}?>">
								<a href="<?php echo base_url() ?>pembelian/laporan">
									<i class="fa fa-cart-plus"></i>
									Pembelian
								</a>
							</li>
						</ul>
					</li>

					<li class="last <?php if($menu == 'setting'){echo 'active';}?> ">
						<a href="javascript:;">
						<i class="fa fa-cogs"></i>
						<span class="title">Setting</span>
						<span class=""></span>
						<span class="selected"></span>
						</a>
						<ul class="sub-menu">
							<li class="<?php if($submenu == 'modul'){echo 'active';}?>">
								<a href="<?php echo base_url() ?>modul">
									<i class="fa fa-bars"></i>
									Modul
								</a>
							</li>
							<li class="<?php if($submenu == 'menu'){echo 'active';}?>">
								<a href="<?php echo base_url() ?>menu">
									<i class="fa fa-bars"></i>
									Menu
								</a>
							</li>
						</ul>
					</li>-->

				</ul>
				<!-- END SIDEBAR MENU -->
			</div>
		</div>