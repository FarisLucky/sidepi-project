<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ApprovePengeluaran extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->rolemenu->init();
    }
    
    public function index()
    {
        $this->load->helper('date');
        $data['title'] = 'Approve Pengeluaran';
        $data['menus'] = $this->rolemenu->getMenus();
        $data['img'] = getCompanyLogo();
        $data['approve_bayar'] = $this->modelapp->getData("*","tbl_pengeluaran",['status_owner'=>'p'],'id_pengeluaran','DESC')->result();
        $this->pages("approve/view_approve_pengeluaran",$data);
    }
    
    public function accept($id)
    {
        $input = $id;
        $get_pengeluaran = $this->modelapp->getData("id_pengeluaran","pengeluaran",["id_pengeluaran"=>$input]);
        if ($get_pengeluaran->num_rows() > 0) {
            $data_pengeluaran = $get_pengeluaran->row_array();
            $update_pengeluaran = $this->modelapp->updateData(['status_owner'=>'sl'],'pengeluaran',['id_pengeluaran'=>$data_pengeluaran['id_pengeluaran']]);
            if ($update_pengeluaran) {
                $this->session->set_flashdata('success','Data berhasil disimpan');
                redirect('approvepengeluaran');
            }
        } else {
            $this->session->set_flashdata('failed','Data Pengeluaran tidak ditemukan');
            redirect('approvepengeluaran');
        }
    }

    public function reject($id)
    {
        $input = $id;
        $get_pengeluaran = $this->modelapp->getData("id_pengeluaran","pengeluaran",["id_pengeluaran"=>$input]);
        if ($get_pengeluaran->num_rows() > 0) {
            $data_pengeluaran = $get_pengeluaran->row_array();
            $update_pengeluaran = $this->modelapp->updateData(['status_owner'=>'s'],'pengeluaran',['id_pengeluaran'=>$data_pengeluaran['id_pengeluaran']]);
            if ($update_pengeluaran) {
                $this->session->set_flashdata('success','Data berhasil disimpan');
                redirect('approvepengeluaran');
            }
        } else {
            $this->session->set_flashdata('failed','Data Pengeluaran tidak ditemukan');
            redirect('approvepengeluaran');
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