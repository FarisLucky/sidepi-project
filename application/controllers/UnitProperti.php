<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Unitproperti extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->rolemenu->init();
        $this->load->library('form_validation');
    }
    
    public function index()
    {
        $data['menus'] = $this->rolemenu->getMenus();
        $data['title'] = 'Unit Properti';
        $data["site_plan"] = $this->modelapp->getData("foto_properti","properti",["id_properti"=>$_SESSION["id_properti"]])->row_array();
        $data["list_unit"] = $this->modelapp->getData("nama_unit,status_unit","unit",["id_properti"=>$_SESSION["id_properti"]])->result();
        $this->pages("unit_properti/view_unit",$data);
    }

    public function dataUnit() //Fungsi Untuk Load Datatable
    {
        $this->load->model('Server_side','ssd');
        $column = "*";
        $tbl = "unit";
        $order = "id_unit";
        $id_properti = $this->session->userdata('id_properti');
        $column_where = ["id_properti"=>$id_properti];
        $search = ['nama_unit'];
        $fetch_values = $this->ssd->makeDataTables($column,$tbl,$search,$order,$column_where);
        $data = array();
        $no = 1;
        foreach ($fetch_values as $value) {
            if ($value->status_unit == "t") {
                $status = "Terjual";
                $button = '<a href="'.base_url().'unitproperti/detail_unit/'.$value->id_unit.'" class="btn btn-icons btn-inverse-info mr-1"><i class="fa fa-info"></i></a>';
                $badge = "badge-success";
            } elseif ($value->status_unit == "b") {
                $status = "Booking";
                $button = '<a href="'.base_url().'unitproperti/detail_unit/'.$value->id_unit.'" class="btn btn-icons btn-inverse-info mr-1"><i class="fa fa-info"></i></a>';
                $badge = "badge-info";
            } else {
                $status = "Belum Terjual";
                $button = '<a href="'.base_url().'unitproperti/detailunit/'.$value->id_unit.'" class="btn btn-icons btn-inverse-info mr-1"><i class="fa fa-info"></i></a><button type="button" class="btn btn-icons btn-inverse-danger mr-1" onclick="deleteItem('."'unitproperti/corehapus/$value->id_unit'".')"><i class="fa fa-trash"></i></button>';
                $badge = "badge-primary";
            }
            $sub = array();
            $sub[] = $value->nama_unit;
            $sub[] = $value->type;
            $sub[] = $value->luas_tanah;
            $sub[] = $value->luas_bangunan;
            $sub[] = "Rp. ".number_format($value->harga_unit,2,',','.');
            $sub[] = '<small class="badge '.$badge.'">'.$status.'</small>';
            $sub[] = '<img id="foto_properti" width="250px" src="'.base_url().'assets/uploads/images/unit_properti/'.$value->foto_unit.'" class="img-thumbnail" alt="">';
            $sub[] = $button;
            $data[] = $sub;
            $no++;
        }
        $output = array(
            'draw'=>intval($this->input->post('draw')),
            'recordsTotal'=>intval($this->ssd->get_all_datas($tbl,$column_where)),
            'recordsFiltered'=>intval($this->ssd->get_filtered_datas($column,$tbl,$search,$order,$column_where)),
            'data'=> $data
        );
        return $this->output->set_output(json_encode($output));
    }

    public function tambah() //Menampilkan Form Tambah
    {
        $data['title'] = 'Tambah Unit';
        $data['menus'] = $this->rolemenu->getMenus();
        $data['img'] = getCompanyLogo();
        $this->pages("unit_properti/view_tambah_unit",$data); 
    }
    public function multiTambah() //Menampilkan Form Tambah
    {
        $data['title'] = 'Tambah Unit';
        $data['menus'] = $this->rolemenu->getMenus();
        $data['img'] = getCompanyLogo();
        $this->pages("unit_properti/view_tambah_multiunit",$data); 
    }
    public function detailUnit($id) //Menampilkan Form Tambah
    {
        $data['title'] = 'Detail Unit';
        $data['menus'] = $this->rolemenu->getMenus();
        $data['img'] = getCompanyLogo();
        $data['unit'] = $this->modelapp->getData("*","unit",["id_unit"=>$id])->row();
        $this->pages("unit_properti/view_detail_unit",$data); 
    }

    public function coreTambah() //Unit Core Tambah
    {
        $this->validate();
        if ($this->form_validation->run() == false) {
            $this->tambah();
        } else {
            $id_properti = $this->session->userdata('id_properti');
            $inputData = $this->inputData();
            $inputData += ["id_properti"=>$id_properti];
            $jumlah_unit = $this->modelapp->getData("jumlah_unit","properti",["id_properti"=>$id_properti])->row_array();
            $total_unit = $this->modelapp->getData("SUM(id_unit) as total_unit","unit",["id_properti"=>$id_properti])->row_array();

            if ($total_unit["total_unit"] >= $jumlah_unit["jumlah_unit"]){
                $this->session->set_flashdata("failed","Jumlah Unit sudah mencapai batas");
                $this->tambah();
            }else{
                $config = $this->imageInit('./assets/uploads/images/unit_properti/');
                $this->load->library('upload', $config);
                if ($_FILES['foto']['name'] != "") {
                    if ($this->upload->do_upload('foto')){
                        $img = $this->upload->data();
                        $inputData += ["foto_unit"=>$img['file_name']];
                        $query = $this->modelapp->insertData($inputData,"unit");
                        if ($query) {
                            $this->session->set_flashdata("success","Unit berhasil ditambahkan");
                            redirect("unitproperti/tambah");
                        }
                    }
                    else {
                        $error = $this->upload->display_errors();
                        $this->session->set_flashdata("error",$error);
                        $this->tambah();
                    }
                }
                else{
                    $inputData += ["foto_unit"=>"default.jpg"];
                    $act = $this->modelapp->insertData($inputData,"unit");
                    if ($act) {
                        $this->session->set_flashdata("success","Unit berhasil ditambahkan");
                        redirect("unitproperti/tambah");    
                    }
                    else{
                        $this->session->set_flashdata("failed","Gagal ditambahkan");
                        redirect("unitproperti/tambah");
                    }
                }
            }
        }
    }
    public function coreMultiTambah() //Unit Core Tambah
    {
        $this->validate();
        $this->form_validation->set_rules('txt_blok_awal','Blok Awal','trim|required|numeric|max_length[3]');
        $this->form_validation->set_rules('txt_jumlah_blok','Blok Akhir','trim|required|numeric|max_length[4]');
        if ($this->form_validation->run() == false) {
            $this->multiTambah();
        }else{
            $awal = (int) $this->input->post("txt_blok_awal",true);
            $jumlah = (int) $this->input->post("txt_jumlah_blok",true);
            $id_properti = $this->session->userdata("id_properti");
            $query = $this->modelapp->getData("jumlah_unit","properti",["id_properti"=>$id_properti])->row();
            $query_unit = $this->modelapp->getData("COUNT(id_unit) as jumlah_unit","unit",["id_properti"=>$id_properti])->row();
            if ($jumlah > 0) {
                if ($query_unit->jumlah_unit < $query->jumlah_unit) {
                    $sisa = ($query->jumlah_unit - $query_unit->jumlah_unit);
                    if ($jumlah > $sisa) {
                        $this->session->set_flashdata("error","Jumlah terlalu banyak");
                        $this->multiTambah();
                    }else{
                        $nama = $this->input->post("txt_nama",true);
                        $input = $this->inputData();
                        $input += ["id_properti"=>$id_properti];
                        $input += ["foto_unit"=>"default.jpg"];
                        $total = $awal + $jumlah;
                        for($i = $awal ; $i < $total ; $i++) {
                            $input["nama_unit"] = $nama.$i;
                            $this->modelapp->insertData($input,"unit");
                        }
                        $this->session->set_flashdata("success","Berhasil ditambahkan");
                        redirect("unitproperti/multitambah");
                    }
                }else{
                    $this->session->set_flashdata("error","Unit sudah Full");
                    $this->multiTambah();
                }
            }else{
                $this->session->set_flashdata("error","Jumlah blok harus lebih dari 0");
                $this->multiTambah();
            }
        }
    }

    public function coreDetail() //Unit Core Tambah
    {
        $this->validate();
        if ($this->form_validation->run() == false) {
            $this->detailUnit();
        }
        else{
            $id = $this->input->post("txt_id",true);
            $inputData = $this->inputData();
            $config = $this->imageInit("./assets/uploads/images/unit_properti/");
            $this->load->library('upload', $config);
            if ($_FILES['foto']['name'] != "") {
                if ($this->upload->do_upload('foto')){
                    $link = $this->modelapp->getData("foto_unit","unit",["id_unit"=>$id])->row();
                    $path = "./assets/uploads/images/unit_properti/".$link->foto_unit;
                    if (file_exists($path) && !is_dir($path)) {
                        if ($link != "default.jpg") {
                            unlink($path);
                        }
                    }
                    $img = $this->upload->data();
                    $inputData += ["foto_unit"=>$img["file_name"]];
                    $query = $this->modelapp->updateData($inputData,"unit",["id_unit"=>$id]);
                    if ($query) {
                        $this->session->set_flashdata("success","Berhasil diubah");
                        redirect("unitproperti/detailunit/".$id);
                    }
                } else {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata("error",$error);
                    $this->detailUnit();
                }
            }
            else{ 
                $act = $this->modelapp->updateData($inputData,"unit",["id_unit"=>$id]);
                if ($act) {
                    $this->session->set_flashdata("success","Berhasil diubah");
                    redirect("unitproperti/detailunit/".$id);
                }
            }
        }
    }

    public function coreHapus($id)
    {
        $input = $id;
        if (!empty($input)) {
            $image = $this->modelapp->getData("foto_unit","unit",["id_unit"=>$input])->row_array();
            if ($image["foto_unit"] != null) {
                if ($image['foto_unit'] != "default.jpg") {
                    $path = "./assets/uploads/images/unit_properti/".$image["foto_unit"];
                    if (file_exists($path) && !is_dir($path)) {
                        unlink($path);
                    }
                }
            }
            $query = $this->modelapp->deleteData(["id_unit"=>$input],"unit");
            if ($query) {   
                $this->session->set_flashdata("success","Berhasil dihapus");
                redirect("unitproperti");
            }
        } else {
            $this->session->set_flashdata("failed","Unit tidak ditemukan");
            redirect("unitproperti");
        }
    }
    // This function is private. so , anyone cannot to access this function from web based
    private function pages($core_page,$data){
        $this->load->view('partials/part_navbar',$data);
        $this->load->view('partials/part_sidebar',$data);
        $this->load->view($core_page,$data);
        $this->load->view('partials/part_footer',$data);
    }
    private function validate()
    {
        $this->form_validation->set_rules('txt_nama','Nama Unit','trim|required|max_length[15]');
        $this->form_validation->set_rules('txt_type','Type','trim|required|max_length[15]');
        $this->form_validation->set_rules('txt_tanah','Luas Tanah','trim|required|numeric');
        $this->form_validation->set_rules('satuan_tanah','Satuan Tanah','trim|required|max_length[5]');
        $this->form_validation->set_rules('txt_bangunan','Luas Bangunan','trim|required|numeric');
        $this->form_validation->set_rules('satuan_bangunan','Satuan Bangunan','trim|required|max_length[5]');
        $this->form_validation->set_rules('txt_harga','Harga','trim|required|numeric|max_length[9]');
        $this->form_validation->set_rules('txt_alamat','Alamat','trim|required');
        $this->form_validation->set_rules('txt_desc','Deskripsi','trim|required');
    }
    private function inputData()
    {
        $input = [
            "nama_unit"=> $this->input->post("txt_nama",true),
            'type'=>$this->input->post('txt_type',true),
            'luas_tanah'=>$this->input->post('txt_tanah',true),
            'satuan_tanah'=>$this->input->post('satuan_tanah',true),
            'luas_bangunan'=>$this->input->post('txt_bangunan',true),
            'satuan_bangunan'=>$this->input->post('satuan_bangunan',true),
            'harga_unit'=>$this->input->post('txt_harga',true),
            'alamat_unit'=>$this->input->post('txt_alamat',true),
            'tgl_buat'=>date("Y-m-d"),
            'status_unit'=>"bt",
            'deskripsi'=>$this->input->post('txt_desc',true),
            'id_user' => $this->session->userdata("id_user"),
        ];
        return $input;
    }
    private function imageInit($path)
    {
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['encrypt_name'] = true;
        $config['max_size']  = '2048';
        $config['max_width']  = '1024';
        $config['max_height']  = '768';
        return $config;
    }
}

/* End of file Unit_properti.php */