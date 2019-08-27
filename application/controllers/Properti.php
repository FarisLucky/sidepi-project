<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Properti extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->rolemenu->init();
        $this->load->library('form_validation');
    }
    
    public function index()
    {
        $data['title'] = 'Properti';
        $data['menus'] = $this->rolemenu->getMenus();
        $data['img'] = getCompanyLogo();
        $this->page('properti/view_properti',$data);
    }

    public function dataProperti() //Fungsi Untuk Load Datatable
    {
        $this->load->model('Server_side','ssd');
        $column = "*"; //column you want to get
        $tbl = "tbl_properti"; //tbl you want
        $order = "nama_properti"; //colmun you to ordering
        $search = ['nama_properti','status']; //search data
        $fetch_values = $this->ssd->makeDataTables($column,$tbl,$search,$order);
        $data = array();
        foreach ($fetch_values as $value) {
            $properti = $this->modelapp->getData('*','rab_properti',['id_properti'=>$value->id_properti,'type'=>'p']);
            $unit = $this->modelapp->getData('*','rab_properti',['id_properti'=>$value->id_properti,'type'=>'u']);
            if ($value->status != 'publish') {
                $this->status = '<a href="'.base_url().'properti/detailproperti/'.$value->id_properti.'" class="btn btn-icons btn-inverse-info mr-1" id="detail_data_properti"><i class="fa fa-info"></i></a><button type="button" class="btn btn-icons btn-inverse-danger mr-1" onclick="deleteItem('."'properti/hapus/$value->id_properti'".')"><i class="fa fa-trash"></i></button><button type="button" class="btn btn-sm btn-warning" onclick="setItem('."'properti/publish/$value->id_properti','publish'".')">Publish</button>';
            }else{
                $this->status = '<a href="'.base_url().'properti/detailproperti/'.$value->id_properti.'" class="btn btn-icons btn-inverse-info mr-1" id="detail_data_properti"><i class="fa fa-info"></i></a><a href="'.base_url()."rab/properti/".$value->id_properti.'" class="btn btn-sm btn-info mr-1" id="rab_data_properti">RAB Properti</a><a href="'.base_url()."rab/unit/".$value->id_properti.'" class="btn btn-sm btn-success mr-1" id="rab_data_unit">RAB Unit</button>';
            }
            $sub = array();
            $sub[] = $value->nama_properti;
            $sub[] = $value->luas_tanah;
            $sub[] = $value->no_rekening;
            $sub[] = $value->bank;
            $sub[] = '<img id="foto_properti" width="70px" src="'.base_url().'assets/uploads/images/properti/'.$value->foto_properti.'" class="" alt="">';
            $sub[] = $this->status;
            $data[] = $sub;
        }
        $output = array(
            'draw'=>intval($this->input->post('draw')),
            'recordsTotal'=>intval($this->ssd->get_all_datas($tbl)),
            'recordsFiltered'=>intval($this->ssd->get_filtered_datas($column,$tbl,$search,$order)),
            'data'=> $data
        );
        return $this->output->set_output(json_encode($output));
    }

    public function detailProperti($id)
    {
        $data['menus'] = $this->rolemenu->getMenus();
        $data['title'] = 'Detail';
        $data['properti'] = $this->modelapp->getData("*","properti",["id_properti"=>$id])->row(); //Jangan DIUbah hanya bisa diganti berdasarkan id_dari sbu/menu ini !!
        $data["rekening"] = $this->modelapp->getData("*","rekening_properti")->result();
        $data['img'] = getCompanyLogo();
        $this->page('properti/view_detail_properti',$data);
    }

    public function tambah()
    {
        $data['menus'] = $this->rolemenu->getMenus();
        $data['title'] = 'Tambah';
        $data['img'] = getCompanyLogo();
        $data["rekening"] = $this->modelapp->getData('*','rekening_properti',['status'=>'1'])->result();
        $this->page('properti/view_tambah_properti',$data);
    }

    public function coreUbah() //Core Ubah
    {
        $id = $this->input->post("txt_id");
        $this->validate(); //fungsi validate ada dibawah
        if ($this->form_validation->run() == false) {
            $this->detailProperti($id);
        } else{
            $config = $this->uploadImg();
            $input = $this->input();
            $this->load->library('upload', $config);
            if (!empty($_FILES["foto"]["name"])) {
                if ($this->upload->do_upload("foto")){
                    $link = $this->modelapp->getData("logo_properti,foto_properti","tbl_properti",["id_properti"=>$id])->row();
                    if ($link->foto_properti != "default.jpg") {
                        $coba = $this->unlinkImg($link->foto_properti);
                    }
                    $upload2 = $this->upload->data();
                    $foto = $upload2['file_name'];
                    $input += ["foto_properti"=>$foto];
                    $query = $this->modelapp->updateData($input,"properti",["id_properti"=>$id]);
                    if ($query) {
                        if ($input['status'] == 'publish') {
                            $input_rab = $this->data_rab();
                            $input_rab += ['id_properti'=>$id,'type'=>'p'];
                            $query_rab = $this->modelapp->insertData($input_rab,"rab_properti"); //Insert Rab Perumahan
                            if ($query_rab) {
                                $input_rab['type'] = 'u';
                                $this->modelapp->insertData($input_rab,"rab_properti"); //Insert Rab Unit Perumahan
                                $this->session->set_flashdata("success","Berhasil ditambahkan"); 
                                redirect("properti/detailproperti/".$id);
                            }
                        } else {   
                            $this->session->set_flashdata("success","Berhasil ditambahkan");
                            redirect("properti/detailproperti/".$id);
                        }
                    }  else {
                        $this->session->set_flashdata("failed","Tidak ada perubahan");
                        redirect("properti/detailproperti/".$id);
                    }
                }
                else{
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata("error",$error);
                    redirect("properti/detailproperti/".$id);
                }
            }else{
                $query = $this->modelApp->updateData($input,"properti",["id_properti"=>$id]);
                if ($query) {
                    if ($input['status'] == 'publish') {
                        $input_rab = $this->data_rab();
                        $input_rab += ['id_properti'=>$id,'type'=>'p'];
                        $query_rab = $this->modelapp->insertData($input_rab,"rab_properti"); //Insert Rab Perumahan
                        if ($query_rab) {
                            $input_rab['type'] = 'u';
                            $this->modelapp->insertData($input_rab,"rab_properti"); //Insert Rab Unit Perumahan
                            $this->session->set_flashdata("success","Berhasil ditambahkan"); 
                            redirect("properti/detailproperti/".$id);
                        }
                    } else {   
                        $this->session->set_flashdata("success","Berhasil ditambahkan");
                        redirect("properti/detailproperti/".$id);
                    }
                } else {
                    $this->session->set_flashdata("failed","Tidak ada perubahan");
                    redirect("properti/detailproperti/".$id);
                }
            }   
        }
    }

    public function coreTambah() //Core Tambah
    {
        $this->validate();
        if ($this->form_validation->run() == false) {
            $this->tambah();
        } else{
            $input = $this->input();
            $input += ["id_user"=>$this->session->userdata("id_user")];
            $config = $this->uploadImg();
            $this->load->library('upload', $config);
            if (!empty($_FILES["foto"]["name"])) {
                if ($this->upload->do_upload("foto")){
                    $upload1 = $this->upload->data();
                    $foto = $upload1["file_name"];
                    $input += ["foto_properti"=>$foto];
                    $db = $this->modelapp->insertData($input,"properti");
                    if ($db) {
                        if ($input['status'] == 'publish') {
                            $input_rab = $this->data_rab();
                            $input_rab += ['id_properti'=>$this->db->insert_id(),'type'=>'p'];
                            $query = $this->modelapp->insertData($input_rab,"rab_properti"); //Insert Rab Perumahan
                            if ($query) {
                                $input_rab['type'] = 'u';
                                $this->modelapp->insertData($input_rab,"rab_properti"); //Insert Rab Unit Perumahan
                                $this->session->set_flashdata("success","Berhasil ditambahkan"); 
                                redirect("properti");
                            }
                        } else {   
                            $this->session->set_flashdata("success","Berhasil ditambahkan");
                            redirect("properti");
                        }
                    }
                }else{
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata("error",$error);
                    $this->tambah();
                }
            }else{
                $input += ["foto_properti"=>"default.jpg"];
                $db = $this->modelapp->insertData($input,"properti");
                if ($db) {
                    $this->session->set_flashdata("success","Berhasil ditambahkan");
                    redirect("properti");
                }
            }
        }
    }

    public function hapus($id)
    {
        $input = $this->security->xss_clean($id);
        $get_data = $this->modelapp->getData("*","properti",["id_properti"=>$input]);
        if ($get_data->num_rows() > 0) {
            $result = $get_data->row();
            if ($result->foto_properti != "default.jpg") {
                $path = "./assets/uploads/images/properti/".$result->foto_properti;
                if (file_exists($path) && !is_dir($path)) {
                    unlink($path);
                }
            }
            $query = $this->modelapp->deleteData(["id_properti"=>$input],"properti");
            if ($query) {
                $this->session->set_flashdata("success","Berhasil dihapus");
                redirect("properti");
            }
        }else{
            $this->session->set_flashdata("failed","properti tidak ditemukan");
            redirect("properti");
        }
    }

    public function publish($id)
    {
        $input = $this->security->xss_clean($id);
        $get_data = $this->modelapp->getData("*","properti",["id_properti"=>$input]);
        if ($get_data->num_rows() > 0) {
            $rs_data = $get_data->row_array();
            $query = $this->modelapp->updateData(["status"=>"publish"],"properti",["id_properti"=>$input]);
            if ($query) {
                $input_rab = [
                    'nama_rab'=>$rs_data['nama_properti'],
                    'tgl_buat'=>date("Y-m-d"),
                    'total_anggaran'=>0,
                    'id_user'=>$_SESSION['id_user']
                ];
                $input_rab += ['id_properti'=>$input,'type'=>'p'];
                $query = $this->modelapp->insertData($input_rab,"rab_properti"); //Insert Rab Perumahan
                if ($query) {
                    $input_rab['type'] = 'u';
                    $this->modelapp->insertData($input_rab,"rab_properti"); //Insert Rab Unit Perumahan
                    $this->session->set_flashdata("success","Berhasil ditambahkan"); 
                    redirect("properti");
                } else {   
                    $this->session->set_flashdata("success","Berhasil ditambahkan");
                    redirect("properti");
                }
            }
        }else{
            $this->session->set_flashdata("failed","properti tidak ditemukan");
            redirect("properti");
        }
    }

    // private function to support other function
    private function validate()
    {
        $this->form_validation->set_rules('txt_nama','Nama','trim|required|max_length[50]');
        $this->form_validation->set_rules('txt_jumlah','Jumlah','trim|required|numeric');
        $this->form_validation->set_rules('txt_satuan','Satuan','trim|required|max_length[10]');
        $this->form_validation->set_rules('txt_luas','Luas Tanah','trim|required');
        $this->form_validation->set_rules('txt_rekening','Rekening','trim|required');
        $this->form_validation->set_rules('txt_status','Status','trim|required');
        $this->form_validation->set_rules('txt_alamat','Alamat','trim|required');
    }
    private function input()
    {
        $data = [
            'nama_properti'=>$this->input->post('txt_nama',true),
            'alamat'=>$this->input->post('txt_alamat',true),
            'luas_tanah'=>$this->input->post('txt_luas',true),
            'satuan_tanah'=>$this->input->post('txt_satuan',true),
            'jumlah_unit'=>$this->input->post('txt_jumlah',true),
            'rekening'=>$this->input->post('txt_rekening',true),
            'status'=>$this->input->post('txt_status',true),
            'setting_spr'=>$this->input->post('txt_spr'),
            'tgl_buat'=>date('Y-m-d')
        ];
        return $data;
    }
    private function data_rab()
    {
        $input = [
            'nama_rab'=>$this->input->post('txt_nama',true),
            'tgl_buat'=>date("Y-m-d"),
            'total_anggaran'=>0,
            'id_user'=>$_SESSION['id_user']
        ];
        return $input;
    }
    private function reArrayFoto(&$files) {
        $uploads = array();
        foreach($_FILES as $key0=>$FILES) {
            foreach($FILES as $key=>$value) {
                foreach($value as $key2=>$value2) {
                    $uploads[$key2][$key] = $value2;
                }
            }
        }
        $files = $uploads;
        return $uploads; // prevent misuse issue
    }
    private function unlinkImg($link)
    {
        $path = "./assets/uploads/images/properti/".$link;
        if (file_exists($path) && !is_dir($path)) {
            unlink($path);
        }
    }
    private function page($core_page,$data){
        $this->load->view('partials/part_navbar',$data);
        $this->load->view('partials/part_sidebar',$data);
        $this->load->view($core_page,$data);
        $this->load->view('partials/part_footer',$data);
    }
    private function uploadImg(){
        $config['upload_path'] = './assets/uploads/images/properti/';
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['encrypt_name'] = true;
        $config['max_size']  = '1024';
        $config['max_width']  = '1024';
        $config['max_height']  = '768';
        return $config;
    }
}

/* End of file Properti.php */