<?php

 
    class Main_model extends CI_Model
	{
		
		function list_data($table, $sort, $field){

		    $this->db->from($table);
		    $this->db->order_by($field, $sort);
		    $list = $this->db->get();
		    
		    return $list->result();
		}
		
		function join_data_produk(){
		    $this->db->select('
								produk.id, 
								produk.nama_produk, 
								produk.idsupplier, 
								produk.idkat_produk, 
								produk.provider, 
								produk.kode_kioser, 
								produk.harga_beli, 
								produk.harga_jual, 
								produk.status, 
								supplier.id AS id_supplier, 
								supplier.nama_supplier,
								supplier.cs_supplier,
								supplier.jabber,
								supplier.pin,
								supplier.kecepatan,
								supplier.status AS status_supplier,
								supplier.catatan,
								kategori_produk.id AS id_kategori,
								kategori_produk.nama_kategori,
								provider.id AS id_provider,
								provider.provider AS nama_provider
								');
			$this->db->from('produk');
			$this->db->join('supplier', 'supplier.id = produk.idsupplier');
			$this->db->join('kategori_produk', 'kategori_produk.id = produk.idkat_produk');
			$this->db->join('provider', 'provider.id = produk.provider');
			$produk = $this->db->get()->result();
			return $produk;
		}
		
		function join_edit_produk($id){
		    $this->db->select('
								produk.id AS id_produk, 
								produk.nama_produk, 
								produk.idsupplier, 
								produk.idkat_produk, 
								produk.provider, 
								produk.kode_kioser, 
								produk.harga_beli, 
								produk.harga_jual, 
								produk.status, 
								kategori_produk.id AS id_kategori,
								kategori_produk.nama_kategori,
								provider.id AS id_provider,
								provider.provider AS nama_provider
								');
			$this->db->from('produk');
			$this->db->join('kategori_produk', 'kategori_produk.id = produk.idkat_produk');
			$this->db->join('provider', 'provider.id = produk.provider');
			$this->db->where('produk.id', $id);
			$produk = $this->db->get()->row_array();
			return $produk;
		}
		
		function get_login($email, $pass)
		{
			$this->db->where('email', $email);
			$this->db->where('password', md5($pass));
			$login = $this->db->get('ref_user');
			return $login;
		}
		
		function edit($table, $field, $id){
		    $this->db->where($field, $id);
		    $edit = $this->db->get($table)->row_array();
		    return $edit;
		}
		
		function get_where1($table, $field, $key, $fieldsort, $sort){
		    $this->db->where($field, $key);
		    $this->db->order_by($fieldsort, $sort);
		    $dt = $this->db->get($table)->result();
		    return $dt;
		}
		

	}

    
?>