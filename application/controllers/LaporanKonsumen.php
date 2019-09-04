<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Laporankonsumen extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->rolemenu->init();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = 'Laporan';
        $data['menus'] = $this->rolemenu->getMenus();
        $data['img'] = getCompanyLogo();
        $data['total_konsumen'] = $this->modelapp->getData("COUNT(id_konsumen) as jumlah_konsumen","konsumen",["status_konsumen"=>"k"])->row_array();
        $this->page('laporan/view_konsumen',$data);
    }
    
    public function dataProses() //Fungsi Untuk Load Datatable
    {
        $this->load->model('Server_side','ssd');
        $column = "*";
        $tbl = "konsumen";
        $order = "nama_lengkap";
        $column_where = ['status_konsumen'=>'k'];
        $search = ['nama_lengkap'];
        $fetch_values = $this->ssd->makeDataTables($column,$tbl,$search,$order,$column_where);
        $data = array();
        foreach ($fetch_values as $value) {
            $sub = array();
            $sub[] = $value->id_card;
            $sub[] = $value->nama_lengkap;
            $sub[] = $value->jenis_kelamin == 'l' ? 'Laki - laki' : 'Perempuan';
            $sub[] = $value->telp;
            $sub[] = $value->email;
            $sub[] = $value->alamat;
            $sub[] = '<a href="'.base_url('laporankonsumen/detail/'.$value->id_konsumen).'" class="btn btn-icons btn-inverse-info"><i class="fa fa-info"></i></a><a href="'.base_url()."laporankonsumen/printkonsumen/".$value->id_konsumen.'" class="btn btn-icons btn-inverse-warning mx-2"><i class="fa fa-print"></i></a>';
            $data[] = $sub;
        }
        $output = array(
            'draw'=>intval($this->input->post('draw')),
            'recordsTotal'=>intval($this->ssd->get_all_datas($tbl,$column_where)),
            'recordsFiltered'=>intval($this->ssd->get_filtered_datas($column,$tbl,$search,$order,$column_where)),
            'data'=> $data
        );
        return $this->output->set_output(json_encode($output));
    }
    public function detail($id)
    {
        $this->load->helper('date');
        $data['title'] = 'Detail Konsumen';
        $data['img'] = getCompanyLogo();
        $data['menus'] = $this->rolemenu->getMenus();
        $data['doc_konsumen'] = $this->modelapp->getJoinData("*","persyaratan_konsumen",['kelompok_persyaratan'=>'kelompok_persyaratan.id_sasaran = persyaratan_konsumen.kelompok_persyaratan'],['id_konsumen'=>$id])->result_array();
        $data['konsumen'] = $this->modelapp->getData("*","konsumen",['id_konsumen'=>$id])->row_array();
        $data['trans'] = $this->modelapp->getData("*","tbl_transaksi",['id_konsumen'=>$id,'status_transaksi !='=>'s'])->row_array();
        $this->page("laporan/view_detail",$data);
    }

    public function printKonsumen($id)
    {
        $this->load->library('Pdf');
        $this->load->helper('date');
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

    public function printDoc($id)
    {
        $data_konsumen = $this->modelapp->getJoinData('*','persyaratan_konsumen',['kelompok_persyaratan'=>'persyaratan_konsumen.kelompok_persyaratan = kelompok_persyaratan.id_sasaran'],['id_persyaratan'=>$id])->row_array();
        $data['link'] = base_url('assets/uploads/files/konsumen/'.$data_konsumen['file']);
        $data['name'] = $data_konsumen['kelompok_persyaratan'].'.pdf'; 
        $this->load->view('print/custom_print', $data);
    }
    
    // Private function 
    private function page($core_page,$data){
        $this->load->view('partials/part_navbar',$data);
        $this->load->view('partials/part_sidebar',$data);
        $this->load->view($core_page,$data);
        $this->load->view('partials/part_footer',$data);
    }
    
}

/* End of file Laporan_cuy.php */