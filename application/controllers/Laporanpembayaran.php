<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Laporanpembayaran extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->rolemenu->init();
    }

    public function index()
    {
        $data['title'] = 'Laporan';
        $data['menus'] = $this->rolemenu->getMenus();
        $data['img'] = getCompanyLogo();
        $data['bayar'] = $this->modelapp->getData('*','detail_pembayaran',['status_owner'=>'sl','status_manager'=>'sl'])->row_array();
        $this->page('laporan/bayar/view_bayar',$data);
    }
    
    public function dataProses() //Fungsi Untuk Load Datatable
    {
        $this->load->helper('date');
        $this->load->model('Server_side','ssd');
        $column = "*";
        $tbl = "tbl_detail_pembayaran";
        $order = "id_detail";
        $having = ['status_owner'=>'sl','status_manager'=>'sl'];
        $search = ['ide_detail'];
        $fetch_values = $this->ssd->makeDataTables($column,$tbl,$search,$order,$having);
        $data = array();
        foreach ($fetch_values as $value) {
            $d = DateTime::createFromFormat('Y-m-d H:i:s',$value->tgl_bayar);
            $sub = array();
            $sub[] = $value->nama_pembayaran;
            $sub[] = $value->nama_properti;
            $sub[] = $value->nama_unit;
            $sub[] = number_format($value->jumlah_bayar,2,',','.');
            $sub[] = $value->no_rekening;
            $sub[] = '<a href="'.base_url('assets/uploads/images/pembayaran/'.$value->bukti_bayar).'" data-lightbox="data"><img src="'.base_url('assets/uploads/images/pembayaran/'.$value->bukti_bayar).'"></a>';
            $sub[] = $value->nama_lengkap;
            $sub[] = tanggal($d->format('d'),$d->format('m'),$d->format('Y')).' '.$d->format('H:i:s');
            $sub[] = '<a href="'.base_url('laporanpembayaran/printdata/'.$value->id_detail).'" class="btn btn-icons btn-inverse-warning target="blank"><i class="fa fa-print"></i></a>';
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

    public function printData($id_detail)
    {
        $this->load->library('Pdf');
        $this->load->helper('date');
        $data['img'] = getCompanyLogo();
        $where = ["id_detail" => $id_detail];
        $data['detail_bayar'] = $this->modelapp->getData("*", "tbl_detail_pembayaran", $where)->row_array();
        $data['bayar'] = $this->modelapp->getData("hutang,total_bayar,total_tagihan", "tbl_pembayaran", ['id_pembayaran'=>$data['detail_bayar']['id_pembayaran']])->row_array();
        // $this->load->view('print/print_tandajadi', $data);
        $this->pdf->load_view('Kwitansi', 'print/print_bayar', $data);
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