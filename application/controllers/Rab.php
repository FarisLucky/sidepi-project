<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rab extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->rolemenu->init();
		$this->load->library('form_validation');
	}
	public function index()
	{
		redirect('dashboard');
	}
	public function properti()
	{
		if ($_SESSION['id_user'] == 1) {
			$id = $this->uri->segment(3);
		} else {
			$id = $_SESSION['id_properti'];
		}
		$data['title']= "RAB Properti";
		$data['rab_properti'] = $this->modelapp->getData("*","rab_properti",["id_properti"=>$id,"type"=>"p"])->row_array();
		$rab = $data["rab_properti"]["id_rab"];
		$data['kelola_rab'] = $this->modelapp->getData("*","tbl_detail_rab",["id_rab"=>$rab])->result();
		$data['menus'] = $this->rolemenu->getMenus();
		$this->pages('kelola_rab/v_kelola_rab',$data);
	}
	public function unit()
	{
		if ($_SESSION['id_user'] == 1) {
			$id = $this->uri->segment(3);
		} else {
			$id = $_SESSION['id_properti'];
		}
		$data['title']= "Kelola RAB Unit";
		$data['rab_unit'] = $this->modelapp->getData("*","rab_properti",["id_properti"=>$id,"type"=>"u"])->row();
		$rab = $data["rab_unit"]->id_rab;
		$data['kelola_rab'] = $this->modelapp->getData("*","tbl_detail_rab",["id_rab"=>$rab])->result();
		$data['menus'] = $this->rolemenu->getMenus();
		$this->pages('kelola_rab/view_rab_unit',$data);
	}
	public function tambah($id)
	{
		$data['title']= "Tambah RAB";
		$data['data_id']= $id;
		$get_properti = $this->modelapp->getData("*","rab_properti",['id_rab'=>$id])->row();
		$data['kembali'] = $get_properti->id_properti;
		$data['menus'] = $this->rolemenu->getMenus();
		$data['kelompok_rab'] = $this->modelapp->getData("*","kelompok_item",['id_kategori'=>1,"status"=>"a"])->result();
		$this->pages('kelola_rab/v_tambah_rab',$data);
	}
	public function tambahUnit($id)
	{
		$data['title']= "Tambah RAB";
		$data['data_id']= $id;
		$get_properti = $this->modelapp->getData("*","rab_properti",['id_rab'=>$id])->row();
		$data['kembali'] = $get_properti->id_properti;
		$data['menus'] = $this->rolemenu->getMenus();
		$data['kelompok_rab'] = $this->modelapp->getData("*","kelompok_item",['id_kategori'=> 2,"status"=>"a"])->result();
		$this->pages('kelola_rab/view_tambah_rab_unit',$data);
	}
	public function coreTambah()
	{
		$config = $this->validate();
		$id_rab =  $this->input->post('txt_hidden',true);
		if ($this->form_validation->run() == false) {
			$this->tambah($id_rab);
		} else {
			$input = $this->input();
			$input += ["id_rab"=>$id_rab];
			$query = $this->modelapp->insertData($input,"detail_rab");
			if ($query) {
				$sql = $this->modelapp->getData("SUM(total_harga) as total_harga","detail_rab",['id_rab'=>$id_rab])->row();
				$query_total = $this->modelapp->updateData(['total_anggaran'=>$sql->total_harga],'rab_properti',['id_rab'=>$id_rab]);
				$this->session->set_flashdata("success","Berhasil ditambahkan");
				redirect("rab/tambah/".$id_rab);
			}
		}
	}
	public function coreTambahUnit()
	{
		$config = $this->validate();
		$id_rab =  $this->input->post('txt_hidden',true);
		if ($this->form_validation->run() == false) {
			$this->tambah($id_rab);
		} else {
			$input = $this->input();
			$input += ["id_rab"=>$id_rab];
			$query = $this->modelapp->insertData($input,"detail_rab");
			if ($query) {
				$sql = $this->modelapp->getData("SUM(total_harga) as total_harga","detail_rab",['id_rab'=>$id_rab])->row();
				$query_total = $this->modelapp->updateData(['total_anggaran'=>$sql->total_harga],'rab_properti',['id_rab'=>$id_rab]);
				$this->session->set_flashdata("success","Berhasil ditambahkan");
				redirect("rab/tambahunit/".$id_rab);
			}
		}
	}
	public function hapus($id_detail)
	{
		$this->security->xss_clean($id_detail);
		$get_id = $this->modelapp->getData("*","detail_rab",["id_detail"=>$id_detail]);
		if ($get_id->num_rows() > 0) {
			$result = $get_id->row();
			$query = $this->modelapp->deleteData(["id_detail"=>$id_detail],'detail_rab');
			if ($query) {
				$sql = $this->modelapp->getData("SUM(total_harga) as total_harga","detail_rab",['id_rab'=>$result->id_rab])->row();
				$query_total = $this->modelapp->updateData(['total_anggaran'=>$sql->total_harga],'rab_properti',['id_rab'=>$result->id_rab]);
				$this->session->set_flashdata("success","Berhasil dihapus");
				$href = $this->modelapp->getData("id_properti","rab_properti",["id_rab"=>$result->id_rab])->row_array();
				redirect("rab/properti/".$href["id_properti"]);
			}
		}
	}
	public function hapusUnit($id_detail)
	{
		$this->security->xss_clean($id_detail);
		$get_id = $this->modelapp->getData("*","detail_rab",["id_detail"=>$id_detail]);
		if ($get_id->num_rows() > 0) {
			$result = $get_id->row();
			$query = $this->modelapp->deleteData(["id_detail"=>$id_detail],'detail_rab');
			if ($query) {
				$sql = $this->modelapp->getData("SUM(total_harga) as total_harga","detail_rab",['id_rab'=>$result->id_rab])->row();
				$query_total = $this->modelapp->updateData(['total_anggaran'=>$sql->total_harga],'rab_properti',['id_rab'=>$result->id_rab]);
				$this->session->set_flashdata("success","Berhasil dihapus");
				$href = $this->modelapp->getData("id_properti","rab_properti",["id_rab"=>$result->id_rab])->row_array();
				redirect("rab/unit/".$href["id_properti"]);
			}
		}
	}
	public function edit($id_detail)
	{
		$data['title']= "Ubah RAB";
		$data['menus'] = $this->rolemenu->getMenus();
		$data['k'] = $this->modelapp->getData("*","detail_rab",["id_detail"=>$id_detail])->row();
		$getProperti = $this->M_kelola_rab->getDataWhere('rab_properti',['id_rab'=>$data['k']->id_rab])->row();
		$data['kembali'] = $getProperti->id_properti;
		$data['kelompok_rab'] = $this->modelapp->getData("*","kelompok_item",['id_kategori'=> 1,"status"=>"a"])->result();
		$this->pages('kelola_rab/v_edit_rab',$data);
	}
	public function editUnit($id_detail)
	{
		$data['title']= "Ubah RAB";
		$data['menus'] = $this->rolemenu->getMenus();
		$data['k'] = $this->modelapp->getData("*","detail_rab",["id_detail"=>$id_detail])->row();
		$get_properti = $this->modelapp->getData("*","rab_properti",['id_rab'=>$data['k']->id_rab])->row();
		$data['kembali'] = $get_properti->id_properti;
		$data['kelompok_rab'] = $this->modelapp->getData("*","kelompok_item",['id_kategori'=> 2,"status"=>"a"])->result();
		$this->pages('kelola_rab/view_edit_rab_unit',$data);
	}
	public function coreUbah()
	{
		$id_detail = $this->input->post('id_detail',true);
		$config = $this->validate();
		$id_rab =  $this->input->post('txt_hidden',true);
		if ($this->form_validation->run() == false) {
			$this->edit($id_rab);
		} else{
			if (!empty($id_detail)) {
				$data = $this->input();
				$query = $this->modelapp->updateData($data,"detail_rab",["id_detail"=>$id_detail]);
				if ($query) {
					$result_rab = $this->modelapp->getData("id_rab","detail_rab",["id_detail"=>$id_detail])->row();
					$result_sum = $this->modelapp->getData("SUM(total_harga) as total_harga","detail_rab",["id_rab"=>$result_rab->id_rab])->row();
					$update_total = $this->modelapp->updateData(["total_anggaran"=>$result_sum->total_harga],"rab_properti",["id_rab"=>$result_sum->total_harga]);
					$this->session->set_flashdata("success","Berhasil diubah");
					redirect("rab/edit/".$id_detail);
				}
			}else{
				$this->session->set_flashdata("failed","Item tidak ditemukan");
				redirect("rab/edit/".$id_detail);
			}
		}
	}
	public function coreUbahUnit()
	{
		$id_detail = $this->input->post('id_detail',true);
		$config = $this->validate();
		$id_rab =  $this->input->post('txt_hidden',true);
		if ($this->form_validation->run() == false) {
			$this->editUnit($id_rab);
		} else{
			if (!empty($id_detail)) {
				$data = $this->input();
				$query = $this->modelapp->updateData($data,"detail_rab",["id_detail"=>$id_detail]);
				if ($query) {
					$result_rab = $this->modelapp->getData("id_rab","detail_rab",["id_detail"=>$id_detail])->row();
					$result_sum = $this->modelapp->getData("SUM(total_harga) as total_harga","detail_rab",["id_rab"=>$result_rab->id_rab])->row();
					$update_total = $this->modelapp->updateData(["total_anggaran"=>$result_sum->total_harga],"rab_properti",["id_rab"=>$result_sum->total_harga]);
					$this->session->set_flashdata("success","Berhasil diubah");
					redirect("rab/editunit/".$id_detail);
				}
			}else{
				$this->session->set_flashdata("failed","Item tidak ditemukan");
				redirect("rab/editunit/".$id_detail);
			}
		}
	}
	
	public function printRab()
	{ 
		$id = $this->uri->segment(3);
		$this->load->library('Pdf');
		$this->load->helper('date');
		$data['img'] = getCompanyLogo();
		$data["rab"] = $this->modelapp->getData('*',"rab_properti",["id_rab"=>$id])->row();
		$data['kelompok_rab'] = $this->modelapp->getData('*',"kelompok_item", ["id_kategori"=>1])->result_array();
		$data["logo"] = $this->modelapp->getData('*',"properti",["id_properti"=>$data["rab"]->id_properti])->row_array();
		$data["pembuat"] = $this->modelapp->getData('*',"user",["id_user"=>$_SESSION["id_user"]])->row_array();
		// $this->load->view('print/print_rab', $data);
		$this->pdf->load_view('RAB Properti', 'print/print_rab', $data);
	}
	public function printRabUnit()
	{ 
		$id = $this->uri->segment(3);
		$this->load->library('Pdf');
		$this->load->helper('date');
		$data['kelompok_rab'] = $this->M_kelola_rab->getDataWhere("kelompok_item", ["id_kategori"=>2])->result_array();
		$data["rab"] = $this->M_kelola_rab->getDataWhere("rab_properti",["id_rab"=>$id])->row();
		$data["logo"] = $this->M_kelola_rab->getDataWhere("properti",["id_properti"=>$data["rab"]->id_properti])->row_array();
		$data["pembuat"] = $this->M_kelola_rab->getDataWhere("user",["id_user"=>$_SESSION["id_user"]])->row_array();
		// $this->load->view('print/print_rab_properti', $data);
		$this->pdf->load_view('RAB Properti', 'print/print_rab', $data);
	}
	public function ubahRab()
	{
		$id = $this->input->post('input_hidden',true);
		$properti = $this->input->post('input_hidden2',true);
		$this->form_validation->set_rules('nama_rab', 'Nama', 'trim|required|min_length[3]|max_length[18]');
		if (isset($_POST['properti'])) {
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error',form_error());
				redirect('rab/properti/'.$properti);
			} else {
				$input = [
					"nama_rab"=>$this->input->post('nama_rab',true)
				];
				$query = $this->modelapp->updateData($input,'rab_properti',['id_rab'=>$id]);
				if ($query) {
					$this->session->set_flashdata('success',"Data berhasil ditambahkan");
					redirect('rab/properti/'.$properti);
				} else {
					$this->session->set_flashdata('failed',"Tidak ada perubahan");
					redirect('rab/properti/'.$properti);
				}
			}
		}
		if (isset($_POST['properti'])) {
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error',form_error());
				redirect('rab/unit/'.$properti);
			} else {
				$input = [
					"nama_rab"=>$this->input->post('nama_rab',true)
				];
				$query = $this->modelapp->updateData($input,'rab_properti',['id_rab'=>$id]);
				if ($query) {
					$this->session->set_flashdata('success',"Data berhasil ditambahkan");
					redirect('rab/unit/'.$properti);
				} else {
					$this->session->set_flashdata('failed',"Tidak ada perubahan");
					redirect('rab/unit/'.$properti);
				}
			}
		}
	}

	private function pages($page,$data)
	{
		$this->load->view('partials/part_navbar',$data);
		$this->load->view('partials/part_sidebar',$data);
		$this->load->view($page,$data);
		$this->load->view('partials/part_footer',$data);
	}

	private function validate()
	{
		$this->form_validation->set_rules('nama_detail', 'Nama Detail', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('volume', 'Volume', 'trim|required|numeric|max_length[3]');
		$this->form_validation->set_rules('satuan', 'Satuan', 'trim|required|max_length[15]');
		$this->form_validation->set_rules('harga_satuan', 'Harga Satuan', 'trim|required|max_length[9]');
		$this->form_validation->set_rules('select_kelompok', 'Kategori Kelompok', 'trim|required');
	}

	private function input()
	{
		$data = [
			'nama_detail'=>$this->input->post('nama_detail',true),
			'volume'=>$this->input->post('volume',true),
			'satuan'=>$this->input->post('satuan',true),
			'harga_satuan'=>$this->input->post('harga_satuan',true),
			'total_harga'=>(int) $this->input->post('volume',true) * $this->input->post('harga_satuan',true),
			'id_kelompok'=>$this->input->post('select_kelompok',true)
		];
		return $data;
	}

}