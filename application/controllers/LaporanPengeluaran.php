<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Laporanpengeluaran extends CI_Controller 
{
    
    public function __construct()
    {
        parent::__construct();
        $this->rolemenu->init();
    }
    public function index()
    {
        $data['title'] = 'Laporan Pengeluaran';
        $data['menus'] = $this->rolemenu->getMenus();
        $data['img'] = getCompanyLogo();
        $data["kelompok"] = $this->modelapp->getData("*","kelompok_item",["id_kategori"=>3])->result();
        $data['pengeluaran'] = $this->modelapp->getData('SUM(total_harga) as total','tbl_pengeluaran',['status_owner'=>'sl','status_manager'=>'sl'])->row_array();
        $this->pages("laporan/pengeluaran/view_pengeluaran",$data);
    }

    public function dataProses() //Fungsi Untuk Load Datatable
    {
        $where = $this->whereData();
        $this->load->model('Server_side','ssd');
        $column = "*";
        $tbl = "tbl_pengeluaran";
        $order = "id_pengeluaran";
        $fetch_values = $this->ssd->makeDataTables($column,$tbl,null,$order,null,$where);
        $data = array();
        foreach ($fetch_values as $value) {
            $sub = array();
            $sub[] = $value->nama_pengeluaran;
            $sub[] = $value->nama_kelompok;
            $sub[] = $value->volume." ".$value->satuan;
            $sub[] = number_format($value->harga_satuan,2,",",".");
            $sub[] = number_format($value->total_harga,2,",",".");
            $sub[] = $value->nama_properti;
            $sub[] = $value->nama_unit;
            $sub[] = $value->nama_lengkap;
            $sub[] = $value->tgl_buat;
            $sub[] = '<a href="'.base_url('assets/uploads/images/pengeluaran/'.$value->bukti_kwitansi).'" data-lightbox="data'.$value->id_pengeluaran.'"><img src="'.base_url('assets/uploads/images/pengeluaran/'.$value->bukti_kwitansi).'"></a>';
            $sub[] = '<a href="'.base_url('laporanpengeluaran/printpengeluaran/'.$value->id_pengeluaran).'" class="btn btn-icons btn-inverse-warning mx-2"><i class="fa fa-print"></i></a>';
            $data[] = $sub;
        }
        $output = array(
            'draw'=>intval($this->input->post('draw')),
            'recordsTotal'=>intval($this->ssd->get_all_datas($tbl,$where)),
            'recordsFiltered'=>intval($this->ssd->get_filtered_datas($column,$tbl,null,$order,null,$where)),
            'data'=> $data
        );
        return $this->output->set_output(json_encode($output));
    }
    
    public function printAll()
    {
        $this->load->library('Pdf');
        $this->load->helper('date');
        $data['img'] = getCompanyLogo();
        $where = $this->whereData();
        $data['pengeluaran'] = $this->modelapp->getData("*","tbl_pengeluaran",$where)->result_array();
        // $this->load->view("print/print_pengeluaran",$where);
        $this->pdf->load_view('Semua Pengeluaran','print/print_all_pengeluaran',$data);
    }
    public function printPengeluaran($id_pengeluaran)
    {
        $this->load->library('Pdf');
        $this->load->helper('date');
        $data['img'] = getCompanyLogo();
        $where = ["id_pengeluaran"=>$id_pengeluaran];
        $data['detail_bayar'] = $this->modelapp->getData("*","tbl_pengeluaran",$where)->row_array();
        $this->pdf->load_view('Pengeluaran','print/print_pengeluaran',$data);
    }
    // This function is private. so , anyone cannot to access this function from web based
    private function pages($core_page,$data) 
    {
        $this->load->view('partials/part_navbar',$data);
        $this->load->view('partials/part_sidebar',$data);
        $this->load->view($core_page,$data);
        $this->load->view('partials/part_footer',$data);
    }
    private function whereData()
    {
        $where = [];
        $session = $this->session->userdata("id_akses");
        if (isset($_POST["id_kelompok"]) || isset($_POST["tgl_mulai"]) || isset($_POST["tgl_akhir"])) {
            $id_kelompok = $this->input->post('id_kelompok',true);
            $tgl_mulai = $this->input->post('tgl_mulai',true);
            $tgl_akhir = $this->input->post('tgl_akhir',true);
            if (!empty($id_kelompok)) {
                $where += ["id_kelompok"=>$id_kelompok];
            }
            if ((!empty($tgl_mulai)) && (empty($tgl_akhir))) {
                $where += ["tgl_buat >="=>$tgl_mulai]; 
            }
            else if ((!empty($tgl_akhir)) && (empty($tgl_mulai))) {
                $where += ["tgl_buat <="=>$tgl_akhir]; 
            }
            else if((!empty($tgl_mulai)) && (!empty($tgl_akhir))){
                $where += ["tgl_buat >="=>$tgl_mulai,"tgl_buat <="=>$tgl_akhir]; 
            }
        }
        if ($session != 1) {
            $where += ["id_properti"=>$this->session->userdata('id_properti')];
        }
        $where += ['status_owner'=>'sl','status_manager'=>'sl'];
        return $where;
    }
}

/* End of file Laporan_Keuangan.php */