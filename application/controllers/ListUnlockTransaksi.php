<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ListUnlockTransaksi extends CI_Controller 
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
  }
  

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
    $get_data = $this->modelapp->getData('nama_lengkap,id_transaksi,id_properti,id_unit,id_konsumen','tbl_transaksi',['id_transaksi'=>$input]);
    if ($get_data->num_rows() > 0) {
      $rs_transaksi = $get_data->row_array();
      $rs_dp = $this->modelapp->getData('SUM(total_bayar) as total','pembayaran',['id_transaksi'=>$rs_transaksi['id_transaksi'],'jenis_pembayaran'=>'2'])->row_array();
      if ($rs_dp['total'] != '0') {
        redirect('listunlocktransaksi/datahapus/'.$rs_transaksi['id_transaksi']);
      } else {
        $delete_data = $this->modelapp->deleteData(['id_transaksi'=>$rs_transaksi['id_transaksi']],'transaksi');
        if ($delete_data) {
          $update = $this->modelapp->updateData(['status_unit'=>'bt'],'unit',['id_unit'=>$rs_transaksi['id_unit']]);
          $delete = $this->modelapp->deleteData(['id_konsumen'=>$rs_transaksi['id_konsumen']],'konsumen');
          $this->session->set_flashdata('success','Data berhasil dihapus');
          redirect('listunlocktransaksi');
        } else {
          $this->session->set_flashdata('failed','Data gagal dihapus');
          redirect('listunlocktransaksi');
        }
      }
    } else {
      $this->session->set_flashdata('failed','Data tidak ditemukan');
      redirect('listunlocktransaksi');
    }
  }

  public function dataHapus($input)
  {
    $id = $input;
    $data["title"] = "Detail Transaksi";
    $data['menus'] = $this->rolemenu->getMenus();
    $transaksi = $this->modelapp->getData('id_transaksi,nama_lengkap,id_unit,nama_unit','tbl_transaksi',['id_transaksi'=>$id])->row_array();
    $data['dp'] = $this->modelapp->getData('SUM(total_bayar) as total','pembayaran',['id_transaksi'=>$transaksi['id_transaksi'],'jenis_pembayaran'=>'2'])->row_array();
    $total = ($data['dp']['total'] * 10) / 100;
    $data['pengeluaran'] = [
      'nama_pengeluaran'=>'Dp dari '.$transaksi['nama_lengkap'],
      'volume'=>'1',
      'id_unit'=>$transaksi['id_unit'],
      'nama_unit'=>$transaksi['nama_unit'],
      'satuan'=>'transaksi',
      'harga_satuan'=>$total,
      'id_transaksi'=>$transaksi['id_transaksi']
    ];
    $this->pages('laporan/transaksi/tambah_pengeluaran',$data);
  }

  public function coreTambah()
  {
    $id = $this->input->post('input_hidden',true);
    $rs_transaksi = $this->modelapp->getData('id_unit,id_konsumen','tbl_transaksi',['id_transaksi'=>$input])->row_array();
		$this->form_validation->set_rules('nama_pengeluaran', 'Nama', 'trim|required|min_length[5]|max_length[50]');
		$this->form_validation->set_rules('volume', 'Jumlah', 'trim|required|numeric');
		$this->form_validation->set_rules('satuan', 'Satuan', 'trim|required|min_length[1]|max_length[10]');
		$this->form_validation->set_rules('harga_satuan', 'Harga', 'trim|required|numeric');
    
    if ($this->form_validation->run() == false) {
      $this->dataHapus($id);
    } else {
      $input_data = [
        'nama_pengeluaran'=>$this->input->post('nama_pengeluaran',true),
        'volume'=>$this->input->post('volume',true),
        'satuan'=>$this->input->post('satuan',true),
        'harga_satuan'=>$this->input->post('harga_satuan',true),
        'total_harga'=>$this->input->post('volume',true) * $this->input->post('harga_satuan',true),
        'id_user'=>$_SESSION['id_user'],
        'id_kelompok'=>'7',
        'tgl_buat'=>date('Y-m-d'),
        'status_owner'=>'sl',
        'status_manager'=>'s'
      ];
      $data_properti = $this->modelapp->getData('id_properti,id_unit','unit',['id_unit'=>$this->input->post('unit',true)])->row_array();
      $input_data += ['id_properti'=>$data_properti['id_properti'],'id_unit'=>$data_properti['id_unit']];

      $config['upload_path'] = './assets/uploads/images/pengeluaran/';
      $config['allowed_types'] = 'jpg|jpeg|png';
      $config['encrypt_name'] = true;
      $config['max_size']  = '1024';
      $config['max_width']  = '1024';
      $config['max_height']  = '768';

      $this->load->library('upload', $config);
      if ($_FILES['bukti_kwitansi']['name'] != "") {
				if ($this->upload->do_upload('bukti_kwitansi')) {
					$img = $this->upload->data();
					$input_data += ['bukti_kwitansi'=>$img['file_name']];
					$update = $this->modelapp->insertData($input_data,'pengeluaran'); //Tambah Pengeluaran
					if ($update) {
            $delete_transaksi = $this->modelapp->deleteData(['id_transaksi'=>$id],'transaksi');
            if ($delete_transaksi) {
              $update = $this->modelapp->updateData(['status_unit'=>'bt'],'unit',['id_unit'=>$rs_transaksi['id_unit']]);
              $delete = $this->modelapp->deleteData(['id_konsumen'=>$rs_transaksi['id_konsumen']],'konsumen');
              $this->session->set_flashdata('success','Data berhasil disimpan');
              redirect('listunlocktransaksi');
            }
					} else {
						$this->session->set_flashdata('failed','Data tidak ada perubahan');
						redirect('listunlocktransaksi');
					}
				}
				else{
					$error = $this->upload->display_errors();
					$this->session->set_flashdata('error', $error);
					redirect('listunlocktransaksi/datahapus/'.$id);
				}
			}else{
        $this->session->set_flashdata('failed', "Bukti bayar kosong");
				$this->dataHapus($id);
			}

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