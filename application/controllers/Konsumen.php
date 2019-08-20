<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Konsumen extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->rolemenu->init();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = 'Konsumen';
        $data['menus'] = $this->rolemenu->getMenus();
        $data['konsumen'] = $this->modelapp->getData("*",'konsumen',['status_konsumen'=>'k','id_user'=>$this->session->userdata('id_user')])->result();
        $this->pages("konsumen/view_konsumen",$data);
    }

    public function dataProses() //Fungsi Untuk Load Datatable
    {
        $this->load->model('Server_side','ssd');
        $column = "*";
        $tbl = "konsumen";
        $order = "nama_lengkap";
        $having = ['status_konsumen'=>'k'];
        $search = ['nama_lengkap'];
        $fetch_values = $this->ssd->makeDataTables($column,$tbl,$search,$order,$having);
        $data = array();
        foreach ($fetch_values as $value) {
            $sub = array();
            $sub[] = $value->id_type.' '.$value->id_card;
            $sub[] = $value->nama_lengkap;
            $sub[] = $value->jenis_kelamin == 'l' ? 'Laki - laki' : 'Perempuan';
            $sub[] = $value->telp;
            $sub[] = $value->email;
            $sub[] = $value->alamat;
            $sub[] = '<a href="'.base_url('konsumen/ubah/'.$value->id_konsumen).'" class="btn btn-icons btn-inverse-info btn-details"><i class="fa fa-edit"></i></a><a href="'.base_url()."konsumen/printkonsumen/".$value->id_konsumen.'" class="btn btn-icons btn-inverse-warning mx-2"><i class="fa fa-print"></i></a>';
            $data[] = $sub;
        }
        $output = array(
            'draw'=>intval($this->input->post('draw')),
            'recordsTotal'=>intval($this->ssd->get_all_datas($tbl,$having)),
            'recordsFiltered'=>intval($this->ssd->get_filtered_datas($column,$tbl,$search,$order,$having)),
            'data'=> $data
        );
        return $this->output->set_output(json_encode($output));
    }
    
    public function ubah($id)
    {
        $data['title'] = 'Ubah Data';
        $data['menus'] = $this->rolemenu->getMenus();
        $data['doc_konsumen'] = $this->modelapp->getJoinData("*","persyaratan_konsumen",['kelompok_persyaratan'=>'kelompok_persyaratan.id_sasaran = persyaratan_konsumen.kelompok_persyaratan'],['id_konsumen'=>$id])->result_array();
        $data['kelompok'] = $this->modelapp->getData("*","kelompok_persyaratan",['kategori_persyaratan'=>'konsumen'])->result_array();
        $data['konsumen'] = $this->modelapp->getData("*","konsumen",['id_konsumen'=>$id])->row_array();
        $this->pages('konsumen/view_edit', $data);
    }

    public function coreUbah()
    {
        $id = $this->input->post("val_id_konsumen",true);
        $this->validate();
        if ($this->form_validation->run() == false) {
            $this->edit($id);
        }else{
            $input = $this->inputData();
            $config = $this->initImage();
            $this->load->library('upload', $config);
            if ($_FILES['img_foto']['name'] != "") {
                $query = $this->modelapp->getData("foto_ktp","konsumen",["id_konsumen"=>$id])->row_array();
                if ($query["foto_ktp"] != "default.jpg") {
                    $path = "./assets/uploads/images/konsumen/".$query['foto_ktp'];
                    if (file_exists($path) && !is_dir($path)) {
                        unlink($path);
                    }
                }
                if ($this->upload->do_upload('img_foto')) {
                    $img = $this->upload->data();
                    $input += ["foto_ktp"=>$img['file_name']];
                    $query = $this->modelapp->updateData($input,"konsumen",["id_konsumen"=> $id]);
                    if ($query) {
                        $this->session->set_flashdata("success","Data berhasil diubah");
                        redirect('konsumen/edit/'.$id);
                    }
                }else {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata("error",$error);
                    $this->edit($id);
                }
            }else{
                $query = $this->modelapp->updateData($input,"konsumen",["id_konsumen"=> $id]);
                if ($query) {
                    $this->session->set_flashdata("success","Data berhasil diubah");
                    redirect('konsumen/edit/'.$id);
                }
            }
        }
    }

    public function coreTambahSyarat()
    {
        $id = $this->input->post('input_hidden',true);
        
        $get_konsumen = $this->modelapp->getData('id_konsumen','konsumen',['id_konsumen'=>$id]);
        if ($get_konsumen->num_rows() > 0) {
            $data_konsumen = $get_konsumen->row_array();
            $this->form_validation->set_rules('kelompok', 'Kelompok Persyaratan', 'trim|required');

            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('error',form_error('kelompok'));
                $this->ubah($data_konsumen['id_konsumen']);
            } else {
                if (!empty($_FILES['file_img']['name'])) {
                    
                    $config['upload_path'] = './assets/uploads/files/konsumen/';
                    $config['allowed_types'] = 'pdf';
                    $config['encrypt_name'] = true;
                    $config['max_size']  = '1024';
                    $config['max_width']  = '1024';
                    $config['max_height']  = '768';
                    
                    $this->load->library('upload', $config);
                    
                    if ( ! $this->upload->do_upload('file_img')) {
                        $error = array('error' => $this->upload->display_errors());
                        $this->session->set_flashdata('error',$error['error']);
                        $this->ubah($data_konsumen['id_konsumen']);
                    } else {
                        $data = array('upload_data' => $this->upload->data());
                        $input = [
                            'kelompok_persyaratan'=>$this->input->post('kelompok',true),
                            'id_konsumen'=>$data_konsumen['id_konsumen'],
                            'id_user'=>$_SESSION['id_user'],
                            'file'=>$data['upload_data']['file_name']
                        ];
                        $query_update = $this->modelapp->insertData($input,'persyaratan_konsumen');
                        if ($query_update) {
                            $this->session->set_flashdata('success','berhasil ditambahkan');
                            redirect('konsumen/ubah/'.$data_konsumen['id_konsumen']);
                        } else {
                            $this->session->set_flashdata('failed','Gagal ditambahkan');
                            redirect('konsumen/ubah/'.$data_konsumen['id_konsumen']);
                        }
                    }
                } else {
                    $this->session->set_flashdata('error','Data tidak boleh kosong');
                    redirect('konsumen/ubah/'.$id);
                }
            }
        } else {
            $this->session->set_flashdata('failed','Data Konsumen tidak ditemukan');
            redirect('konsumen/ubah/'.$id);
        }
        
    }
    public function coreTambahFile()
    {
        $id = $this->input->post('input_hidden',true);
        $data_konsumen = $this->modelapp->getData('id_konsumen','persyaratan_konsumen',['id_persyaratan'=>$id])->row_array();
        $config['upload_path'] = './assets/uploads/files/konsumen/';
        $config['allowed_types'] = 'pdf';
        $config['encrypt_name'] = true;
        $config['max_size']  = '1024';
        $config['max_width']  = '1024';
        $config['max_height']  = '768';
        
        $this->load->library('upload', $config);
        
        if ( ! $this->upload->do_upload('file_upload')){
            $error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('error',$error['error']);
            $this->ubah($data_konsumen['id_konsumen']);
        } else {
            $data = array('upload_data' => $this->upload->data());
            $input = [
                'file'=>$data['upload_data']['file_name']
            ];
            $query_update = $this->modelapp->updateData($input,'persyaratan_konsumen',['id_persyaratan'=>$id]);
            if ($query_update) {
                $this->session->set_flashdata('success','berhasil ditambahkan');
                redirect('konsumen/ubah/'.$data_konsumen['id_konsumen']);
            }
        }
        
    }

    public function hapusSyarat($id,$konsumen)
    {
        $id_persyaratan = $id;
        $get_persyaratan = $this->modelapp->getData('id_persyaratan,id_konsumen,file','persyaratan_konsumen',['id_persyaratan'=>$id_persyaratan]);
        if ($get_persyaratan->num_rows() > 0) {
            $data_persyaratan = $get_persyaratan->row_array();
            $query_delete = $this->modelapp->deleteData(['id_persyaratan'=>$data_persyaratan['id_persyaratan']],'persyaratan_konsumen');
            if ($query_delete) {
                $this->session->set_flashdata('success','Data berhasil dihapus');
                redirect('konsumen/ubah/'.$data_persyaratan['id_konsumen']);
            }
        } else {
            $this->session->set_flashdata('failed','Data tidak ditemukan');
            redirect('konsumen/ubah/'.$konsumen);
        }
    }
    
    public function hapusFile($id,$konsumen)
    {
        $id_persyaratan = $id;
        $get_persyaratan = $this->modelapp->getData('id_persyaratan,id_konsumen,file','persyaratan_konsumen',['id_persyaratan'=>$id_persyaratan]);
        if ($get_persyaratan->num_rows() > 0) {
            $data_persyaratan = $get_persyaratan->row_array();
            $path = './assets/uploads/files/konsumen/'.$data_persyaratan['file'];
            if (file_exists($path) && !is_dir($path)) {
                unlink($path);
            }
            $query_delete = $this->modelapp->updateData(['file'=>''],'persyaratan_konsumen',['id_persyaratan'=>$data_persyaratan['id_persyaratan']]);
            if ($query_delete) {
                $this->session->set_flashdata('success','File berhasil dihapus');
                redirect('konsumen/ubah/'.$data_persyaratan['id_konsumen']);
            }
        } else {
            $this->session->set_flashdata('failed','Data tidak ditemukan');
            redirect('konsumen/ubah/'.$konsumen);
        }
    }

    public function printKonsumen($id)
    {
        $this->load->library('Pdf');
        $input = $id;
        $get_data = $this->modelapp->getData('*','konsumen',['id_konsumen'=>$input]);
        if ($get_data->num_rows() > 0) {
            $data['rs_konsumen'] = $get_data->row_array();
            $data['img'] = getCompanyLogo();
            // $this->load->view("print/print_konsumen",$data);
            $this->pdf->load_view('Print Konsumen','print/print_konsumen',$data);
        } else {
            $this->session->set_flashdata('failed','Data tidak ditemukan');
        }
    }

    private function validate()
    {
        $this->form_validation->set_rules('val_id_type', 'Type Card', 'trim|required');
        $this->form_validation->set_rules('val_id_card', "Id card", "trim|required|numeric");
        $this->form_validation->set_rules('val_nama_konsumen', "Nama Konsumen", "trim|required");
        $this->form_validation->set_rules('val_alamat', "Alamat", "trim|required");
        $this->form_validation->set_rules('val_nomor_telepon', "nomor telepon", "trim|required|numeric");
        $this->form_validation->set_rules('val_email', "Email", "trim|required|valid_email");
        $this->form_validation->set_rules('val_npwp', "NPWP", "trim");
        $this->form_validation->set_rules('val_pekerjaan', "Pekerjaan", "trim");
        $this->form_validation->set_rules('val_telepon_kantor', "Telepon Kantor", "trim|numeric");
        $this->form_validation->set_rules('val_alamat_kantor', "Alamat Kantor", "trim");
    }
    
    private function inputData()
    {
        $post = [
            'id_type' => $this->input->post('val_id_type',true), //val_id_type : name yang ada di view
            'id_card' => $this->input->post('val_id_card',true),
            'nama_lengkap' => $this->input->post('val_nama_konsumen',true),
            'alamat' => $this->input->post('val_alamat',true),
            'telp' => $this->input->post('val_nomor_telepon',true),
            'email' => $this->input->post('val_email',true),
            'npwp' => $this->input->post('val_npwp',true),
            'status_konsumen' => "ck",
            'pekerjaan' => $this->input->post('val_pekerjaan',true),
            'alamat_kantor' => $this->input->post('val_alamat_kantor',true),
            'telp_kantor' => $this->input->post('val_telepon_kantor',true),
            'tgl_buat'=>date('Y-m-d H:i:s'),
            'id_user' => $this->session->userdata('id_user')
        ];
        return $post;
    }
    
    private function pages($path,$data)
    {
        $this->load->view('partials/part_navbar', $data);
        $this->load->view('partials/part_sidebar', $data);
        $this->load->view($path, $data);
        $this->load->view('partials/part_footer', $data);
    }
    private function initImage()
    {
        $config['upload_path'] = "./assets/uploads/images/konsumen/";
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['encrypt_name'] = true;
        $config['max_size']  = '1048';
        $config['max_width']  = '1024';
        $config['max_height']  = '768';
        return $config;
    }
}