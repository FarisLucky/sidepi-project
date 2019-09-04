<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Followcalon extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->rolemenu->init();
    }

    public function index()
    {
        $data['title'] = 'Follow Calon';
        $data['menus'] = $this->rolemenu->getMenus();
        $data['img'] = getCompanyLogo();
        $data['follow_calon_konsumen'] = $this->modelapp->getData('*','tbl_follow')->result_array();
        $this->pages('follow_calon_konsumen/v_follow_calon_konsumen', $data);
    }

    public function hapus($id)
    {
        $value = ['id_follow' => $id];
        $get_data = $this->modelapp->getData('id_follow','follow_up',['id_follow'=>$id]);
        if ($get_data->num_rows() > 0) {
            $query = $this->modelapp->deleteData($value,'follow_up');
            if ($query) {
                $this->session->set_flashdata('success','Data berhasil dihapus');
                redirect('followcalon');
            } else {
                $this->session->set_flashdata('success','Data Gagal dihapus');
                redirect('followcalon');
            }
        } else {
            $this->session->set_flashdata('success','Data tidak ditemukan');
            redirect('followcalon');
        }
    }

    public function tambah()
    {
        $data['title'] = 'Tambah Follow';
        $data['menus'] = $this->rolemenu->getMenus();
        $data['img'] = getCompanyLogo();
        $data['calon'] = $this->modelapp->getData('*','konsumen',['status_konsumen'=>'ck'])->result_array();
        $this->pages('follow_calon_konsumen/v_tambah', $data);
    }

    public function coreTambah()
    {
        $this->form_validation->set_rules('val_nama_konsumen', "Nama Konsumen", "required", ['required' => 'Nama Konsumen tidak boleh kosong!!']);
        $this->form_validation->set_rules('val_media', "Media", "required", ['required' => 'Media tidak boleh kosong!!']);
        $this->form_validation->set_rules('val_keterangan', "keterangan", "trim|required", ['required' => 'Keterangan Tidak Boleh Kosong !!']);
        $this->form_validation->set_rules('val_hasil', "hasil", "required", ['required' => 'Hasil Tidak Boleh Kosong !!']);
        if ($this->form_validation->run() == false) {
            $this->tambah();
        } else {
            $post = [
                'id_konsumen' => $this->input->post('val_nama_konsumen', true),
                'tgl_follow' => date('Y-m-d'),
                'media' => $this->input->post('val_media', true),
                'keterangan' => $this->input->post('val_keterangan', true),
                'hasil_follow' => $this->input->post('val_hasil', true),
                'id_user' => $this->session->userdata('id_user'),
            ];
            $query = $this->modelapp->insertData($post,'follow_up');
            if ($query) {
                $this->session->set_flashdata('success','Data berhasil ditambahkan');
                redirect('followcalon/tambah');
            } else {
                $this->session->set_flashdata('failed','Data gagal ditambahkan');
                redirect('followcalon/tambah');
            }
        }
    }
    public function ubah($id)
    {
        $where = array('id_follow' => $id);
        $data['title'] = 'Edit Follow Calon Konsumen';
        $data['menus'] = $this->rolemenu->getMenus();
        $data['img'] = getCompanyLogo();
        $data['follow_calon_konsumen'] = $this->modelapp->getData('*','follow_up',$where)->row_array();
        $data['media'] = ['Whatsapp', 'Facebook', 'Instagram'];
        $data['konsumen'] = $this->modelapp->getData('id_konsumen,nama_lengkap','konsumen',['status_konsumen'=>'ck'])->result_array();
        $this->load->view('partials/part_navbar', $data);
        $this->load->view('partials/part_sidebar', $data);
        $this->load->view('follow_calon_konsumen/v_edit_follow_calon_konsumen', $data);
        $this->load->view('partials/part_footer', $data);
    }

    public function corePerbarui()
    {
        $id = $this->input->post('input_hidden',true);
        $this->form_validation->set_rules('edit_nama_konsumen', "Nama Konsumen", "required", ['required' => 'Nama Konsumen tidak boleh kosong!!']);

        $this->form_validation->set_rules('edit_media', "Media", "required", ['required' => 'Media tidak boleh kosong!!']);

        $this->form_validation->set_rules('edit_keterangan', "keterangan", "trim|required", ['required' => 'Keterangan Tidak Boleh Kosong !!']);

        $this->form_validation->set_rules('edit_hasil', "hasil", "required", ['required' => 'Hasil Tidak Boleh Kosong !!']);

        if ($this->form_validation->run() == false) {
            $this->ubah($id);
        } else {
            $post = [
                'id_konsumen' => $this->input->post('edit_nama_konsumen', true),
                'media' => $this->input->post('edit_media', true),
                'keterangan' => $this->input->post('edit_keterangan', true),
                'hasil_follow' => $this->input->post('edit_hasil', true)
            ];
            $query = $this->modelapp->updateData($post,'follow_up',['id_follow'=>$id]);
            if ($query) {
                $this->session->set_flashdata('success','Data berhasil diubah');
                redirect('followcalon/ubah/'.$id);
            } else {
                $this->session->set_flashdata('success','Data gagal diubah');
                redirect('followcalon/ubah/'.$id);
            }
        }
    }
    private function pages($path,$data)
    {
        $this->load->view('partials/part_navbar', $data);
        $this->load->view('partials/part_sidebar', $data);
        $this->load->view($path, $data);
        $this->load->view('partials/part_footer', $data);
    }
}