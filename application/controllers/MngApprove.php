<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mngapprove extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->rolemenu->init();
    }
    public function index()
    {
        $data['title'] = 'Approve Pembayaran';
        $data['menus'] = $this->rolemenu->getMenus();
        $data['img'] = getCompanyLogo();
        $data['approve_bayar'] = $this->modelapp->getData("*","tbl_detail_pembayaran",['id_properti'=>$_SESSION['id_properti'],'status_owner !='=>'s','status_manager'=>'p'],'id_detail','DESC')->result();
        $this->pages("approvemng/view_approve_pembayaran",$data);
    }
    
    public function accept($id)
    {
        $input = $id;
        $get_detail = $this->modelapp->getData("id_detail,id_pembayaran,jumlah_bayar",'detail_pembayaran',["id_detail"=>$input]);
        if ($get_detail->num_rows() > 0) {
            $data_detail = $get_detail->row_array();
            $update = $this->modelapp->updateData(['status_manager'=>'sl'],'detail_pembayaran',['id_detail'=>$data_detail['id_detail']]);
            if ($update) {
                $this->session->set_flashdata('success','Data berhasil diubah');
                redirect('mngapprove');
            }
        } else {
            $this->session->set_flashdata('failed','Data detail pembayaran tidak ditemukan');
            redirect('mngapprove');
        }
    }
    
    private function ubahStatus($id_pembayaran,$jenis_pembayaran,$transaksi)
    {
        $data_status = $this->modelapp->getData('COUNT(id_pembayaran) as total','pembayaran',['id_pembayaran'=>$id_pembayaran,'jenis_pembayaran'=>$jenis_pembayaran])->row_array();
        $total_lunas = $this->modelapp->getData('COUNT(id_pembayaran) as total','pembayaran',['id_pembayaran'=>$id_pembayaran,'status'=>'sb'])->row_array();
        if ($data_status['total'] == $total_lunas['total']) {
            if ($jenis_pembayaran == '1') {
                $this->modelapp->updateData(['status_tj'=>'s'],'transaksi',['id_transaksi'=>$transaksi]);
            } elseif ($jenis_pembayaran == '2') {
                $this->modelapp->updateData(['status_um'=>'s'],'transaksi',['id_transaksi'=>$transaksi]);
            } else {
                $this->modelapp->updateData(['status_ccl'=>'s'],'transaksi',['id_transaksi'=>$transaksi]);
            }
        }
    }
    
    // This function is private. so , anyone cannot to access this function from web based
    private function pages($core_page,$data){
        $this->load->view('partials/part_navbar',$data);
        $this->load->view('partials/part_sidebar',$data);
        $this->load->view($core_page,$data);
        $this->load->view('partials/part_footer',$data);
    }

}

/* End of file Approve.php */