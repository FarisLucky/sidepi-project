<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Kelolauser extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->rolemenu->init();
        $this->load->library("form_validation");
    }

    public function index()
    {
        $data['title'] = 'User';
        $data['menus'] = $this->rolemenu->getMenus();
        $data['user'] = $this->modelapp->getData("*","tbl_users")->result();
        $data['img'] = getCompanyLogo();
        $this->pages('kelola_user/view_kelola_user',$data);
    }

    public function tambah() //Menampilkan Form Tambah
    {
        $data['title'] = 'Tambah User';
        $data['menus'] = $this->rolemenu->getMenus();
        $data['akses'] = $this->modelapp->getData("*","user_role")->result(); //Mengambil data role akses
        $data['img'] = getCompanyLogo();
        $this->pages('kelola_user/view_tambah_user',$data);
    }
    public function coreTambah() //Core Tambah
    {
        $this->validate();
        if ($this->form_validation->run() == false) {
            $this->tambah();
        } else {
            $input = $this->inputPost();
            $password = password_hash($this->input->post('txt_password', true), PASSWORD_DEFAULT);
            $input += ["password"=>$password,"foto_user"=>"default.jpg",'tanggal_buat'=>date('Y-m-d')];
            $act = $this->modelapp->insertData($input,"user");
            if ($act) {
                $this->session->set_flashdata('success', "Berhasil ditambahkan");
                redirect("kelolauser/tambah");
            }
        }
    }
    public function dataUsers() //Fungsi Untuk Load Datatable
    {
        $this->load->model('Server_side', 'ssd');
        $column = "*";
        $tbl = "tbl_users";
        $nama = "akses";
        $search = ['nama_lengkap', 'email', 'no_hp', 'status_user', 'akses'];
        $fetch_values = $this->ssd->makeDataTables($column, $tbl, $search, $nama);
        $data = array();
        foreach ($fetch_values as $value) {
            if ($value->akses != 'owner') {
                $this->status = '<a href="' . base_url() . 'kelolauser/detailuser/' . $value->id_user . '" class="btn btn-icons btn-inverse-info mx-2" id="detail_data_user"><i class="fa fa-info"></i></a><button type="button" class="btn btn-icons btn-inverse-danger" onclick="deleteItem('."'kelolauser/hapus/$value->id_user'".')"><i class="fa fa-trash"></i></button>';
                if ($value->status_user == 'aktif') {
                    $this->status .= '<button type="button" class="btn btn-sm btn-warning mx-2" onclick="setItem('."'kelolauser/aktifnonaktif/$value->id_user','Nonaktifkan'".')">Nonaktif</button>';
                } else {
                    $this->status .= '<button type="button" class="btn btn-sm btn-warning mx-2" onclick="setItem('."'kelolauser/aktifnonaktif/$value->id_user','Aktifkan'".')">Aktifkan</button>';
                }
                $this->status .= '<button class="btn btn-sm btn-success" onclick="getModal('."'$value->id_user'".')">Change Password</button>';
            } else {
                $this->status = '-';
            }
            $sub = array();
            $sub[] = $value->nama_lengkap;
            $sub[] = $value->Email;
            $sub[] = $value->no_hp;
            $sub[] = '<small class="badge badge-primary">' . $value->akses . '</small>';
            $sub[] = '<small class="badge badge-info">' . $value->status_user . '</small>';
            $sub[] = $this->status;
            $data[] = $sub;
        }
        $output = array(
            'draw' => intval($this->input->post('draw')),
            'recordsTotal' => intval($this->ssd->get_all_datas($tbl)),
            'recordsFiltered' => intval($this->ssd->get_filtered_datas($column, $tbl, $search, $nama)),
            'data' => $data
        );
        return $this->output->set_output(json_encode($output));
    }

    public function aktifNonaktif($id) //Fungsi Mengubah status User
    {
        $input = (int) $id;
        $get_status = $this->modelapp->getData("status_user","user",["id_user"=>$input]);
        if ($get_status->num_rows() > 0)  {
            $status = $get_status->row_array(); 
            if ($status["status_user"] == "aktif") {
                $set_status = "nonaktif";
            }else{
                $set_status = "aktif";
            }
            $query = $this->modelapp->updateData(["status_user"=>$set_status],"user",["id_user"=>$input]);
            if ($query) {
                $this->session->set_flashdata("success","Berhasil diubah");
                redirect("kelolauser");
            }else{
                $this->session->set_flashdata("failed","Gagal diubah");
                redirect("kelolauser");
            }
        }else{
            $this->session->set_flashdata("failed","User tidak ditemukan");
            redirect("kelolauser");
        }
    }

    public function detailUser($id) //FUngsi menampilkan form detail
    {
        $active = 'Detail User';
        $data['title'] = 'Detail User';
        $data['menus'] = $this->rolemenu->getMenus();
        $data['users'] = $this->modelapp->getData("*","tbl_users",["id_user"=>$id])->row();
        $data['properti'] = $this->modelapp->getData("id_properti,nama_properti,foto_properti","properti",["status"=>"publish"])->result();
        $data['img'] = getCompanyLogo();
        $this->pages('kelola_user/view_detail_user',$data);
    }
    public function userProperti() //Menambahkan user assign properti
    {
        $id = $this->input->post('hidden_user',true);
        $properti = $this->input->post('user_properti');
        if (isset($properti)) {
            $this->modelapp->deleteData(["id_user"=>$id],"user_assign_properti");
            foreach ($properti as $key => $value) {
                $this->modelapp->insertData(["id_properti"=>$value,"id_user"=>$id],"user_assign_properti");
            }
            $this->session->set_flashdata("success","Berhasil ditambahkan");
            redirect("kelolauser/detailuser/".$id);
        }else{
            $this->modelapp->deleteData(["id_user"=>$id],"user_assign_properti");
            $this->session->set_flashdata("success","Berhasil diubah");
            redirect("kelolauser/detailuser".$id);
        }
    }
    public function hapus($id) //Menghapus User
    {
        $foto = $this->modelapp->getData("foto_user","user",["id_user"=>$id])->row_array();
        $path = "./assets/uploads/images/profil/user/".$foto["foto_user"];
            if ($foto["foto_user"] != "default.jpg") {
            if (file_exists($path) && !is_dir($path)) {
                unlink($path);
            }
        }
        $hapus = $this->modelapp->deleteData(["id_user"=>$id],"user");
        if ($hapus) {
            $this->session->set_flashdata('success',"Berhasil dihapus");
            redirect("kelolauser");
        } else {
            $this->session->set_flashdata('failed',"Gagal dihapus");
            redirect("kelolauser");
        }
    }
    public function changePassword()
    {
        $this->form_validation->set_rules('pw_baru', 'Password Baru', 'trim|required');
        $this->form_validation->set_rules('confirm_pw_baru', 'Confirm Password', 'trim|required|matches[pw_baru]');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error',form_error('confirm_pw_baru'));
            redirect('kelolauser');
        } else{
            $id = $this->input->post('input_hidden',true);
            $new_pass = $this->input->post("pw_baru",true);
            $password = password_hash($new_pass, PASSWORD_DEFAULT);
            $change = $this->modelapp->updateData(["password"=>$password],"user",["id_user"=>$id]);
            if ($change) {
                $this->session->set_flashdata('success',"Data berhasil disimpan");
                redirect("kelolauser");
            } else {
                $this->session->set_flashdata('failed',"Tidak ada perubahan");
                redirect("kelolauser");
            }
        }
    }
    
    private function validate()
    {
        $this->form_validation->set_rules('txt_nama','Nama','trim|required|max_length[25]|min_length[3]');
        $this->form_validation->set_rules('txt_akses','Hak Akses','trim|required');
        $this->form_validation->set_rules('txt_telp','Telp','trim|required|max_length[13]|min_length[10]|greater_than[0]|is_unique[user.no_hp]');
        $this->form_validation->set_rules('txt_username','Username','trim|required|is_unique[user.username]|max_length[20]');
        $this->form_validation->set_rules('txt_email','Email','trim|required|valid_email|max_length[25]');
        $this->form_validation->set_rules('txt_status','Status','trim|required');
        $this->form_validation->set_rules('txt_password','Password','trim|required');
        $this->form_validation->set_rules('txt_retype_password','Password','trim|required|matches[txt_password]');
        $this->form_validation->set_rules('radio_jk','jenis kelamin','trim|required');
    }

    private function inputPost()
    {
        $input = [
            'nama_lengkap' => $this->input->post('txt_nama', true),
            'id_akses' => $this->input->post('txt_akses', true),
            'no_hp' => $this->input->post('txt_telp', true),
            'email' => $this->input->post('txt_email', true),
            'jenis_kelamin' => $this->input->post('radio_jk', true),
            'username' => $this->input->post('txt_username', true),
            'status_user' => $this->input->post('txt_status', true)
        ];
        return $input;
    }
    
    private function pages($page,$data)
    {
        $this->load->view('partials/part_navbar', $data);
        $this->load->view('partials/part_sidebar', $data);
        $this->load->view($page, $data);
        $this->load->view('partials/part_footer', $data);
    }
}

/* End of file Controllername.php */