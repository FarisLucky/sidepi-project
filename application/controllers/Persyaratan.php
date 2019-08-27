<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Persyaratan extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->rolemenu->init();
        $this->load->library("form_validation");
    }
    public function index()
    {
        $data['title'] = 'Persyaratan';
        $data['menus'] = $this->rolemenu->getMenus();
        $data['img'] = getCompanyLogo();
        $data["persyaratan"] = $this->modelapp->getData("*","kelompok_persyaratan")->result();
        $this->pages("persyaratan/view_syarat",$data);
    }
    public function tambah() {
        $data['title'] = 'Tambah Persyaratan';
        $data['menus'] = $this->rolemenu->getMenus();
        $data['img'] = getCompanyLogo();
        $this->pages("persyaratan/view_tambah",$data);
    }

    public function coreTambah()
    {
        $config = $this->validate();
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $this->tambah();
        } else {
            $input = [
                "nama_kelompok"=>$this->input->post("nama",true),
                "kategori_persyaratan"=>$this->input->post("type",true),
                "keterangan"=>$this->input->post("ket",true)
            ];
            $query = $this->modelapp->insertData($input,'kelompok_persyaratan');
            if ($query) {
                $this->session->set_flashdata('success', 'Data Berhasil ditambahkan');
                redirect('persyaratan');
            }
        }
        
    }
    
    public function ubah($id) {
        $data['title'] = 'Ubah Persyaratan';
        $data['menus'] = $this->rolemenu->getMenus();
        $data['img'] = getCompanyLogo();
        $data["persyaratan"] = $this->modelapp->getData('*','kelompok_persyaratan',['id_sasaran'=>$id])->row();
        $this->pages("persyaratan/view_ubahs",$data);
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
    // This function is private. so , anyone cannot to access this function from web based
    private function pages($core_page,$data){
        $this->load->view('partials/part_navbar',$data);
        $this->load->view('partials/part_sidebar',$data);
        $this->load->view($core_page,$data);
        $this->load->view('partials/part_footer',$data);
    }
    private function validate()
    {
        $config = array (
            array(
                'field' => 'nama',
                'label' => 'Nama Persyaratan',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'type',
                'label' => 'Type persyaratan',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'ket',
                'label' => 'Keterangan',
                'rules' => 'trim|required'
            )
        );
        return $config;
    }
}

/* End of file Laporan_Keuangan.php */