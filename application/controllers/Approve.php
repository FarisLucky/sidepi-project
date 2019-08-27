<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Approve extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->rolemenu->init();
    }
    public function index()
    {
        $this->load->helper('date');
        $data['title'] = 'Approve Pembayaran';
        $data['menus'] = $this->rolemenu->getMenus();
        $data['img'] = getCompanyLogo();
        $data['approve_bayar'] = $this->modelapp->getData("*","tbl_detail_pembayaran",["status_owner"=>"p"],'id_detail','DESC')->result();
        $this->pages("approve/view_approve_pembayaran",$data);
    }
    
    public function accept($id)
    {
        $input = $id;
        $get_detail = $this->modelapp->getData("id_detail,id_pembayaran,jumlah_bayar,status_owner","detail_pembayaran",["id_detail"=>$input]);
        if ($get_detail->num_rows() > 0) {
            $data_detail = $get_detail->row_array();
            $data_bayar = $this->modelapp->getData('hutang,total_bayar','pembayaran',['id_pembayaran'=>$data_detail['id_pembayaran']])->row_array();
            if ($data_detail['jumlah_bayar'] > $data_bayar['hutang'] ) {
                $this->session->set_flashdata('error','Jumlah Bayar terlalu besar');
                redirect('approve');
            } else {
                $hutang = $data_bayar['hutang'] - $data_detail['jumlah_bayar'];
                $ttl_bayar = $data_bayar['total_bayar'] + $data_detail['jumlah_bayar'];
                $this->modelapp->updateData(['status_owner'=>'sl'],'detail_pembayaran',['id_detail'=>$data_detail['id_detail']]);
                $query_update = $this->modelapp->updateData(['hutang'=>$hutang,'total_bayar'=>$ttl_bayar],'pembayaran',['id_pembayaran'=>$data_detail['id_pembayaran']]);
                if ($query_update) {
                    $data_status = $this->modelapp->getData('status_owner,status_manager','detail_pembayaran',['id_detail'=>$data_detail['id_detail']])->row_array();
                    if ($data_status['status_owner'] == 'sl') {
                        $data_pembayaran = $this->modelapp->getData('hutang,jenis_pembayaran,id_transaksi','pembayaran',['id_pembayaran'=>$data_detail['id_pembayaran']])->row_array();
                        if ($data_pembayaran['hutang'] == '0') {
                            $this->modelapp->updateData(['status'=>'sb'],'pembayaran',['id_pembayaran'=>$data_detail['id_pembayaran']]);
                            $this->ubahStatus($data_detail['id_pembayaran'],$data_pembayaran['jenis_pembayaran'],$data_pembayaran['id_transaksi']);
                        }
                        $this->session->set_flashdata('success','Data berhasil disimpan');
                        redirect('approve');
                    } else {
                        $this->session->set_flashdata('success','Data berhasil disimpan');
                        redirect('approve');
                    }
                }
            }
        } else {
            $this->session->set_flashdata('failed','Data detail pembayaran tidak ditemukan');
            redirect('approve');
        }
    }

    public function reject($id)
    {
        $escp_id = $id;
        $get_data = $this->modelapp->getData('id_detail,id_pembayaran,jumlah_bayar','detail_pembayaran',['id_detail'=>$escp_id]);
        if ($get_data->num_rows()> 0) {
            $rs_detail = $get_data->row_array();
            $sql_reject = $this->modelapp->updateData(['status_owner'=>'s'],'detail_pembayaran',['id_detail'=>$rs_detail['id_detail']]);
            if ($sql_reject) {
                $this->session->set_flashdata('success','Data berhasil diubah');
                redirect('approve');
            }
        } else {
            $this->session->set_flashdata('failed','Data tidak ditemukan');
            redirect('approve');
        }
    }

    private function ubahStatus($id_pembayaran,$jenis_pembayaran,$transaksi)
    {
        $data_status = $this->modelapp->getData('COUNT(id_pembayaran) as total','pembayaran',['id_transaksi'=>$transaksi,'jenis_pembayaran'=>$jenis_pembayaran])->row_array();
        $total_lunas = $this->modelapp->getData('COUNT(id_pembayaran) as total','pembayaran',['id_transaksi'=>$transaksi,'jenis_pembayaran'=>$jenis_pembayaran,'status'=>'sb'])->row_array();
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