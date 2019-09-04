<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Laporanmarketing extends CI_Controller {

  
  public function __construct()
  {
    parent::__construct();
    $this->rolemenu->init();
  }
  
  public function index()
  {
    $data['title'] = 'Laporan Marketing';
    $data['menus'] = $this->rolemenu->getMenus();
    $data['img'] = getCompanyLogo();
    $data['marketing'] = $this->modelapp->getData('id_user,nama_lengkap,no_hp,email','user',['id_akses'=>'4'])->result_array();
    $data['total'] = $this->modelapp->getData('COUNT(id_akses) as total','user',['id_akses'=>'4'])->row_array();
    $this->pages('laporan/marketing/view_marketing.php',$data);
  }

  public function detailUnit($id)
  {
    $input = $this->security->xss_clean($id);
    $data['title'] = 'Detail Marketing';
    $data['menus'] = $this->rolemenu->getMenus();
    $data['img'] = getCompanyLogo();
    $data['marketing'] = $this->modelapp->getData('*','user',['id_user'=>$input])->row_array();
    $data['transaksi'] = $this->modelapp->getData('no_spr,nama_unit,nama_properti,tgl_transaksi,total_kesepakatan,type_bayar,status_transaksi','tbl_transaksi',['id_user'=>$id])->result_array();
    $this->pages('laporan/marketing/view_detail.php',$data);
  }

  // Private function 
  private function pages($core_page,$data){
    $this->load->view('partials/part_navbar',$data);
    $this->load->view('partials/part_sidebar',$data);
    $this->load->view($core_page,$data);
    $this->load->view('partials/part_footer',$data);
  }
  // End Page

}

/* End of file Controllername.php */