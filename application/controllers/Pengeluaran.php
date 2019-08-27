<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengeluaran extends CI_Controller 
{
	public function __construct(){
		parent::__construct();
		$this->rolemenu->init();
		$this->load->library('form_validation');
		$this->load->helper('date');
	}
	public function index()
	{
		$data["title"] = "Pengeluaran";
		$data['pengeluaran'] = $this->modelapp->getData("*","tbl_pengeluaran",["id_properti"=>$_SESSION["id_properti"]],'id_pengeluaran','DESC ')->result();
		$data['menus'] = $this->rolemenu->getMenus();
		$data['img'] = getCompanyLogo();
		$this->pages('pengeluaran/v_pengeluaran',$data);
	}
	public function tambah()
	{
		$data['title'] = "Tambah";
		$data['menus'] = $this->rolemenu->getMenus();
		$data['img'] = getCompanyLogo();
		$data['kelompok'] = $this->modelapp->getData('id_kelompok,nama_kelompok','kelompok_item',['id_kategori'=>3,"status"=>"a"])->result();
		$data['unit'] = $this->modelapp->getData('id_unit,nama_unit','unit',['id_properti'=>$_SESSION['id_properti']])->result();
		$this->pages('pengeluaran/v_tambah_pengeluaran',$data);
	}
	public function coreTambah()
	{
		$this->validate();
		if ($this->form_validation->run() == false) {
			$this->tambah();
		} else {
			$input = $this->inputData();
			if (!empty($_POST['lock'])) {
				if ($_POST['lock'] == 'l') {
					$input += ['status_owner'=>'p','status_manager'=>'p'];
				}
			}
			$input += ['tgl_buat' => date('Y-m-d'),
			'id_user'=>$this->session->userdata("id_user"),
			'id_properti'=>$this->session->userdata('id_properti')];
			$config = $this->initImage();
			$this->load->library('upload', $config);
			if ($_FILES['bukti_kwitansi']['name'] != "") {
				if ($this->upload->do_upload('bukti_kwitansi')) {
					$img = $this->upload->data();
					$gambar = $img['file_name'];
					$input += ['bukti_kwitansi'=>$gambar];
					$query = $this->modelapp->insertData($input,'pengeluaran');
					if ($query) {
						$this->session->set_flashdata('success','Data berhasil ditambahkan');
						redirect('pengeluaran');
					}
				}
				else{
					$error = $this->upload->display_errors();
					$this->session->set_flashdata('error',$error);
					$this->tambah();
				}
			}else{
				$query = $this->modelapp->insertData($input,'pengeluaran');
				if ($query) {
					$this->session->set_flashdata('success','Data berhasil ditambahkan');
					redirect('pengeluaran');
				}
			}
		}
	}
	
	public function hapus($id)
	{
		$input = $id;
		$get_data = $this->modelapp->getData('id_pengeluaran,bukti_kwitansi','pengeluaran',['id_pengeluaran'=>$input]);
		if ($get_data->num_rows() > 0) {
			$rs_pengeluaran = $get_data->row();
			$path = "./assets/uploads/images/pengeluaran/".$rs_pengeluaran->bukti_kwitansi;
			if (file_exists($path) && !is_dir($path)) {
				unlink($path);
			}
			$query = $this->modelapp->deleteData(["id_pengeluaran"=>$rs_pengeluaran->id_pengeluaran],'pengeluaran');
			if ($query) {
				$this->session->set_flashdata('success','Data berhasil dihapus');
				redirect('pengeluaran');
			}
		} else {
			$this->session->set_flashdata('failed','Data tidak ditemukan');
			redirect('pengeluaran');
		}
	}
	public function ubah($id)
	{
		$data['title'] = "Ubah";
		$data['menus'] = $this->rolemenu->getMenus();
		$where = array('id_pengeluaran' => $id);
		$data['img'] = getCompanyLogo();
		$data['kelompok'] = $this->modelapp->getData('id_kelompok,nama_kelompok','kelompok_item',['id_kategori'=>3,"status"=>"a"])->result();
		$data['unit'] = $this->modelapp->getData('id_unit,nama_unit','unit')->result();
		$data['p'] = $this->modelapp->getData('*','pengeluaran',$where)->row();
		$this->pages('pengeluaran/v_ubah_pengeluaran',$data);
	}
	public function coreUbah()
	{
		$id = $this->input->post('params',true);
		$this->validate();
		if ($this->form_validation->run() == false) {
			$this->ubah($id);
		} else {
			$input = $this->inputData();
			$config = $this->initImage();
			$this->load->library('upload', $config);
			if ($_FILES['bukti_kwitansi']['name'] != "") {
				if ($this->upload->do_upload('bukti_kwitansi')) {
					$result = $this->modelapp->getData('bukti_kwitansi','pengeluaran',['id_pengeluaran'=>$id])->row();
					$path = "./assets/uploads/images/pengeluaran/".$result->bukti_kwitansi;
					if (file_exists($path) && !is_dir($path)) {
						unlink($path);
					}
					$img = $this->upload->data();
					$input += ['bukti_kwitansi'=>$img['file_name']];
					$update = $this->modelapp->updateData($input,'pengeluaran',['id_pengeluaran'=>$id]);
					if ($update) {
						$this->session->set_flashdata('success','Data berhasil diubah');
						redirect('pemasukan/ubah/'.$id);
					} else {
						$this->session->set_flashdata('failed','Data tidak ada perubahan');
						redirect('pemasukan/ubah/'.$id);
					}
				}
				else{
					$error = $this->upload->display_errors();
					$this->session->set_flashdata('failed', $error);
					redirect('pemasukan/ubah/'.$id);
				}
			}else{
				$update = $this->modelapp->updateData($input,'pengeluaran',["id_pengeluaran"=>$id]);
				if ($update) {
					$this->session->set_flashdata('success','Data berhasil diubah');
					redirect('pemasukan/ubah/'.$id);
				} else {
					$this->session->set_flashdata('failed','tidak ada perubahan data');
					redirect('pemasukan/ubah/'.$id);
				}
			}
		}
	}

	public function lock($id)
	{
		$input = $id;
		$get_data = $this->modelapp->getData('id_pengeluaran,status_manager','pengeluaran',['id_pengeluaran'=>$input]);
		if ($get_data->num_rows() > 0) {
			$rs_pengeluaran = $get_data->row_array();
			if ($rs_pengeluaran['status_manager'] == 'sl') {
				$query_update = $this->modelapp->updateData(['status_owner'=>'p'],'pengeluaran',['id_pengeluaran'=>$rs_pengeluaran['id_pengeluaran']]);
				if ($query_update) {
					$this->session->set_flashdata('success','Berhasil disimpan');
					redirect('pengeluaran');
				}
			} else {
				$query_update = $this->modelapp->updateData(['status_owner'=>'p','status_manager'=>'p'],'pengeluaran',['id_pengeluaran'=>$rs_pengeluaran['id_pengeluaran']]);
				if ($query_update) {
					$this->session->set_flashdata('success','Berhasil disimpan');
					redirect('pengeluaran');
				}
			}
		} else {
			$this->session->set_flashdata('success','Berhasil disimpan');
			redirect('pengeluaran');
		}
	}

	private function validate()
	{
		$this->form_validation->set_rules('nama_pengeluaran', 'Nama', 'trim|required|min_length[5]|max_length[50]');
		$this->form_validation->set_rules('volume', 'Jumlah', 'trim|required|numeric');
		$this->form_validation->set_rules('satuan', 'Satuan', 'trim|required|min_length[1]|max_length[10]');
		$this->form_validation->set_rules('harga_satuan', 'Harga', 'trim|required|numeric');
		$this->form_validation->set_rules('kelompok', 'Kelompok Pengeluaran', 'trim|required');
		$this->form_validation->set_rules('kelompok', 'Kelompok Pengeluaran', 'trim');
	}
	private function pages($path,$data)
	{
		$this->load->view('partials/part_navbar',$data);
		$this->load->view('partials/part_sidebar',$data);
		$this->load->view($path,$data);
		$this->load->view('partials/part_footer',$data);
	}
	private function inputData()
	{
		$data = array(
			'nama_pengeluaran' => $this->input->post('nama_pengeluaran',true),
			'volume' => $this->input->post('volume',true),
			'satuan' => $this->input->post('satuan',true),
			'harga_satuan' => $this->input->post('harga_satuan',true),
			'total_harga' => (int) ($this->input->post('volume') * $this->input->post('harga_satuan')),
			'id_unit'=>$this->input->post('unit',true),
			'id_kelompok'=>$this->input->post('kelompok',true)
		);
		return $data;
	}
	private function initImage()
	{
		$config['upload_path'] = './assets/uploads/images/pengeluaran/';
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['encrypt_name'] = true;
		$config['max_size']  = '1024';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		return $config;
	}
}