<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ListUnlockTransaksi extends CI_Controller 
{

  public function index()
  {
    $data['title'] = 'List Unlock Transaksi';
    $data['menus'] = $this->rolemenu->getMenus();
    $data['img'] = getCompanyLogo();
    $data["transaksi"] = $this->modelapp->getData("*","tbl_transaksi",["kunci"=>"u","status_transaksi"=>"p"])->result();
    $this->pages("laporan/transaksi/view_list_unlock",$data);
  }

  public function getDetail($id)
  {
    $this->load->helper('date');
    $data["title"] = "Detail Transaksi";
    $data['menus'] = $this->rolemenu->getMenus();
    if (!empty($id)) {
      $query = $this->modelapp->getData("*","tbl_transaksi",["id_transaksi"=>$id]);
      if ($query->num_rows() > 0) {
        $data["transaksi"] = $query->row();
        $data["konsumen"] = $this->modelapp->getData("*","konsumen",["id_konsumen"=>$data["transaksi"]->id_konsumen])->row();
        $data["unit"] = $this->modelapp->getData("*","unit",["id_unit"=>$data["transaksi"]->id_unit])->row();
        $data["detail_transaksi"] = $this->modelapp->getData("*","detail_transaksi",["id_transaksi"=>$data["transaksi"]->id_transaksi])->result();
      }
    }
    $this->pages("laporan/transaksi/view_detail",$data);
  }
    
  public function hapus($id)
  {
    $input = $id;
    $get_data = $this->modelapp->getData('nama_lengkap,id_transaksi,id_properti,id_konsumen','tbl_transaksi',['id_transaksi'=>$input]);
    if ($get_data->num_rows() > 0) {
      $rs_transaksi = $get_data->row_array();
      $rs_dp = $this->modelapp->getData('SUM(total_bayar) as total','pembayaran',['id_transaksi'=>$rs_transaksi['id_transaksi'],'jenis_pembayaran'=>'2'])->row_array();
      $total = ($rs_dp['total'] * 10) / 100;
      $query = $this->modelapp->deleteData(['id_transaksi'=>$rs_transaksi['id_transaksi']],'transaksi');
      if ($query) {
        $delete_konsumen = $this->modelapp->deleteData(['id_konsumen'=>$rs_transaksi['id_konsumen']],'konsumen');
        $input_data = [
          'nama_pengeluaran'=>'DP '.$rs_transaksi['nama_lengkap'],
          'volume'=>'1',
          'satuan'=>'transaksi',
          'harga_satuan'=>'0',
          'total_harga'=>$total,
          'bukti_kwitansi'=>'',
          'id_user'=>$_SESSION['id_user'],
          'id_properti'=>$rs_transaksi['id_properti'],
          'id_kelompok'=>'7',
          'tgl_buat'=>date('Y-m-d'),
        ];
        $insert_pengeluaran = $this->modelapp->insertData($input_data,'pengeluaran');
        if ($insert_pengeluaran) {
          $this->session->set_flashdata('success','Data berhasil dihapus');
          redirect('listunlocktransaksi');
        }
      } else {
        $this->session->set_flashdata('failed','Data gagal dihapus');
        redirect('listunlocktransaksi');
      }
    } else {
      $this->session->set_flashdata('failed','Data tidak ditemukan');
      redirect('listunlocktransaksi');
    }
  }
    
  private function pages($core_page,$data){
    $this->load->view('partials/part_navbar',$data);
    $this->load->view('partials/part_sidebar',$data);
    $this->load->view($core_page,$data);
    $this->load->view('partials/part_footer',$data);
  }
}

/* End of file ListUnlockTransaksi.php */