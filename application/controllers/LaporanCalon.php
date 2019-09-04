<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Laporancalon extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->rolemenu->init();
    }
    
    public function index()
    {
        $data['title'] = 'Laporan';
        $data['menus'] = $this->rolemenu->getMenus();
        $data['total_konsumen'] = $this->modelapp->getData("COUNT(id_konsumen) as jumlah_konsumen","konsumen",["status_konsumen"=>"ck"])->row_array();
        $this->page('laporan/view_calon',$data);
    }
    
    public function dataProses() //Fungsi Untuk Load Datatable
    {
        $this->load->model('Server_side','ssd');
        $column = "*";
        $tbl = "konsumen";
        $order = "nama_lengkap";
        $column_where = ['status_konsumen'=>'ck'];
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
            $sub[] = '<a href="'.base_url('laporancalon/detail/'.$value->id_konsumen).'" class="btn btn-sm btn-info btn-details"><i class="fa fa-info"></i> Detail</a><a href="'.base_url()."laporancalon/printCalon/".$value->id_konsumen.'" class="btn btn-sm btn-warning mx-2"><i class="fa fa-print"></i> Print</a>';
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
        $data['title'] = 'Detail Konsumen';
        $data['menus'] = $this->rolemenu->getMenus();
        $data['konsumen'] = $this->modelapp->getData('*','konsumen',['id_konsumen' => $id])->row_array();
        $data['sasaran'] = $this->modelapp->getData('*','kelompok_persyaratan')->result_array();
        $data['follow'] = $this->modelapp->getData('*','follow_up',['id_konsumen' => $id],'id_follow','ASCp
        ')->result_array();
        $this->page("laporan/view_detail_calon",$data);
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