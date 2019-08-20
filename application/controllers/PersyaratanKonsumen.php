<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class PersyaratanKonsumen extends CI_Controller {

  public function index()
  {
    $data['title'] = 'Persyaratan Konsumen';
    $data['menus'] = $this->rolemenu->getMenus();
    $data['konsumen'] = $this->modelapp->getData('*','konsumen',['status_konsumen'=>'k'])->result_array();
    $this->pages("persyaratan/view_konsumen",$data);
  }
  
  public function ubah($id)
  {
    $data['title'] = 'Ubah Persyaratan';
    $data['menus'] = $this->rolemenu->getMenus();
    $data['konsumen'] = $this->modelapp->getData('*','konsumen',['id_konsumen'=>$id])->row_array();
    $data['persyaratan'] = $this->modelapp->getData('*','kelompok_persyaratan',['kategori_persyaratan'=>'konsumen'])->result_array();
    $this->pages("persyaratan/view_ubah",$data);
  }

  public function coreUbah()
  {
    $id = $this->input->post('konsumen',true);
    $get_data = $this->modelapp->getData('*','konsumen',['id_konsumen'=>$id]);
    if ($get_data->num_rows() > 0) {
      $rs_konsumen = $get_data->row_array();
      $persyaratan = $this->input->post('persyaratan',true);
      if (!empty($persyaratan)) {
        $this->modelapp->deleteData(['id_konsumen'=>$rs_konsumen['id_konsumen']],'persyaratan_konsumen');
        foreach ($persyaratan as $key => $value) {
          $this->modelapp->insertData(['kelompok_persyaratan'=>$value,'id_konsumen'=>$rs_konsumen['id_konsumen']],'persyaratan_konsumen');
        }
        $this->session->set_flashdata('success','Data berhasil diubah');
        redirect('persyaratankonsumen/ubah/'.$rs_konsumen['id_konsumen']);
      } else {
        $this->session->set_flashdata('error','Pilih Persyaratan');
        redirect('persyaratankonsumen/ubah/'.$rs_konsumen['id_konsumen']);
      }
    } else {
      $this->session->set_flashdata('failed','Data tidak ditemukan');
      redirect('persyaratankonsumen/ubah/'.$rs_konsumen['id_konsumen']);
    }
  }
  private function pages($core_page,$data){
    $this->load->view('partials/part_navbar',$data);
    $this->load->view('partials/part_sidebar',$data);
    $this->load->view($core_page,$data);
    $this->load->view('partials/part_footer',$data);
}
}

/* End of file PersyaratanKonsumen.php */