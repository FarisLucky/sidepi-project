<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends CI_Controller 
{
	public function __construct(){
		parent::__construct();	
		$this->rolemenu->init();
		$this->load->library('form_validation');
	}
	public function index()
	{
		$data['title'] = "Kategori";
		$data['kategori_item'] = $this->modelapp->getData("*",'tbl_item')->result();
		$data['menus'] = $this->rolemenu->getMenus();
		$data['img'] = getCompanyLogo();
		$this->pages('item/view_item',$data);
	}
	public function tambah(){
		$data['title'] = "Tambah Kategori";
		$data['img'] = getCompanyLogo();
		$data['menus'] = $this->rolemenu->getMenus();
		$data['kategori'] = $this->modelapp->getData("*",'kategori_kelompok')->result();
		$this->pages('item/v_tambah_item',$data);
	}
	public function coreTambah(){
		$config = $this->validate();
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == true) {
			$nama_kelompok = $this->input->post('nama_kelompok');
			$data = array(
				'nama_kelompok' => $nama_kelompok,
				'id_user' => $this->session->userdata('id_user'),
				'id_kategori' => $this->input->post('select_kategori'),
				'status' => 'a'
				);
			$query = $this->modelapp->insertData($data,'kelompok_item');
			if ($query) {
				$this->session->set_flashdata('success','Data berhasil ditambahkan');
				redirect('item');
			}
		} else {
			$this->tambah();
		}
	}
	public function ubah($id_kelompok)
	{
		$data["title"] = "Edit Item";
		$data['menus'] = $this->rolemenu->getMenus();
		$data['img'] = getCompanyLogo();
		$where = array('id_kelompok' => $id_kelompok);
		$data['kategori_item'] = $this->modelapp->getData('*','kelompok_item',$where)->row();
		$data['kategori'] = $this->modelapp->getData("*",'kategori_kelompok')->result();
		$this->pages('item/v_edit_item',$data);
	}
	public function coreUbah(){
		$id_kelompok = $this->input->post('id_kelompok',true);
		$config = $this->validate();
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == false) {
			$this->ubah($id_kelompok);
		} else {
			$input = [
				'nama_kelompok' => $this->input->post('nama_kelompok',true),
				'id_user' => $this->session->userdata('id_user'),
				'id_kategori' => $this->input->post('select_kategori',true),
				'status' => 'a'
			];
			$query = $this->modelapp->updateData($input,'kelompok_item',['id_kelompok'=>$id_kelompok]);
			if ($query) {
				$this->session->set_flashdata('success','Data berhasil diubah');
				redirect('item/ubah/'.$id_kelompok);
			}
		}
	}
	public function status($id)
	{
		$input = $id;
		$get_data = $this->modelapp->getData('*','kelompok_item',['id_kelompok'=>$input]);
		if ($get_data->num_rows() > 0) {
			$rs_status = $get_data->row();
			$set_st;
			if ($rs_status->status == 'a') {
				$set_st = 't';
			} else {
				$set_st = 'a';
			}
			$query = $this->modelapp->updateData(["status"=>$set_st],'kelompok_item',['id_kelompok'=>$id]);
			if ($query) {
				$this->session->set_flashdata('success','Data berhasil diubah');
				redirect('item');
			}
		}else{
			$this->session->set_flashdata('failed','Data tidak ditemukan');
			redirect('item');
		}
	}
	private function pages($path,$data)
	{
		$this->load->view('partials/part_navbar',$data);
		$this->load->view('partials/part_sidebar',$data);
		$this->load->view($path,$data);
		$this->load->view('partials/part_footer',$data);
	}
	private function validate()
	{
		return array (
			array(
				'field' => 'nama_kelompok',
				'label' => 'Nama Kelompok',
				'rules' => 'trim|required|max_length[50]'
			),array(
				'field' => 'select_kategori',
				'label' => 'Kategori Kelompok',
				'rules' => 'trim|required'
			));
	}
}