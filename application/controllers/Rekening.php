<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rekening extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->rolemenu->init();
        $this->load->library("form_validation");
    }
    public function index()
    {
        $data['title'] = 'Rekening';
        $data['menus'] = $this->rolemenu->getMenus();
        $data['img'] = getCompanyLogo();
        $data["rekening"] = $this->modelapp->getData("*","rekening_properti")->result_array();
        $this->pages("rekening/view_rekening",$data);
    }
    public function tambah() {
        $data['title'] = 'Tambah Rekening';
        $data['menus'] = $this->rolemenu->getMenus();
        $data['img'] = getCompanyLogo();
        $this->pages("rekening/view_tambah",$data);
    }

    public function coreTambah()
    {
        $this->validate();
        if ($this->form_validation->run() == false) {
            $this->tambah();
        } else {
            $input = $this->input();
            if ($_POST['lock'] == 'l') {
                $input += ['status'=>'1'];
            } else {
                $input += ['status'=>'0'];
            }
            $query_insert = $this->modelapp->insertData($input,'rekening_properti');
            if ($query_insert) {
                $this->session->set_flashdata('success','Data berhasil ditambahkan');
                redirect('rekening/tambah');
            } else {
                $this->session->set_flashdata('failed','Data gagal ditambahkan');
                redirect('rekening/tambah');
            }
        }
    }
    
    public function ubah($id) {
        $data['title'] = 'Ubah Rekening';
        $data['menus'] = $this->rolemenu->getMenus();
        $data['img'] = getCompanyLogo();
        $data["rek"] = $this->modelapp->getData('*','rekening_properti',['id_rekening'=>$id])->row_array();
        $this->pages("rekening/view_ubah",$data);
    }

    public function coreUbah()
    {
        $id = $this->input->post("input_hidden",true);
        $config = $this->validate();
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $this->ubah($id);
        } else {
            $input = [
                "nama_kelompok"=>$this->input->post("nama",true),
                "kategori_persyaratan"=>$this->input->post("type",true),
                "keterangan"=>$this->input->post("ket",true)
            ];
            if ($_POST['lock'] == 'l') {
                $input += ['status'=>'1'];
            } else {
                $input += ['status'=>'0'];
            }
            $query = $this->modelapp->updateData($input,'kelompok_persyaratan',['id_sasaran'=>$id]);
            if ($query) {
                $this->session->set_flashdata('success', 'Data Berhasil diubah');
                redirect('persyaratan');
            }
        }
        
    }
    public function hapus($id)
    {
        $status;
        $input = $id;
        $get_data = $this->modelapp->getData('id_sasaran,status','kelompok_persyaratan');
        if ($get_data->num_rows() > 0) {
            $rs_sasaran = $get_data->row();
            if ($rs_sasaran->status == 'a') {
                $status = 't';
            } else {
                $status = 'a';
            }
            $query = $this->modelapp->deleteData('kelompok_persyaratan',['id_sasaran'=>$rs_sasaran->id_sasaran]);
            if ($query) {
                $this->session->set_flashdata('success','Data berhasil diUbah');
                redirect('persyaratan');
            }
        } else {
            $this->session->set_flashdata('failed','Data tidak ditemukan');
            redirect('persyaratan');
        }
    }

    public function coreStatus($id)
    {
        $input = $id;
        $get_data = $this->modelapp->getData('id_rekening,status','rekening_properti',['id_rekening'=>$input]);
        if ($get_data->num_rows() > 0) {
            $rs_rekening = $get_data->row_array();
            if ($rs_rekening['status'] == '0') {
                $data_update = ['status'=>'1'];
            } else {
                $data_update = ['status'=>'0'];
            }
            $query_update = $this->modelapp->updateData($data_update,'rekening_properti',['id_rekening'=>$rs_rekening['id_rekening']]);
            if ($query_update) {
                $this->session->set_flashdata('success','Data berhasil diubah');
                redirect('rekening');
            }
        } else {
            $this->session->set_flashdata('failed','Data tidak ditemukan');
            redirect('rekening');
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
        $this->form_validation->set_rules('no_rek', 'No Rekening', 'trim|required|min_length[3]|max_length[16]');
        $this->form_validation->set_rules('bank', 'Bank', 'trim|required|max_length[10]');
        $this->form_validation->set_rules('pemilik', 'Pemilik Rekening', 'trim|required|min_length[5]|max_length[25]');
    }
    private function input()
    {
        return [
            'no_rekening'=>$this->input->post('no_rek',true),
            'bank'=>$this->input->post('bank',true),
            'pemilik'=>$this->input->post('pemilik',true),
        ];
    }
}

/* End of file Laporan_Keuangan.php */