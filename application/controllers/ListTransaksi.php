<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class ListTransaksi extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->rolemenu->init();
    }
    public function index()
    {
        $data['title'] = 'Laporan Transaksi';
        $data['menus'] = $this->rolemenu->getMenus();
        $data['img'] = getCompanyLogo();
        $data["properti"] = $this->modelapp->getData("*","properti")->result();
        $data["sementara"] = $this->modelapp->getData("COUNT(id_transaksi) as sementara","transaksi",['status_transaksi'=>'s'])->row_array();
        $data["progress"] = $this->modelapp->getData("COUNT(id_transaksi) as progress","transaksi",['status_transaksi'=>'p'])->row_array();
        $data["selesai"] = $this->modelapp->getData("COUNT(id_transaksi) as selesai","transaksi",['status_transaksi'=>'sl'])->row_array();
        $this->pages("laporan/transaksi/view_transaksi_unit",$data);
    }

    public function dataProses() //Fungsi Untuk Load Datatable
    {
        $where = [];
        if (isset($_POST["id_properti"]) || isset($_POST["id_unit"]) || isset($_POST["tgl_mulai"]) || isset($_POST["tgl_akhir"])) {
          if (!empty($_POST["id_properti"])) {
              $where += ['id_properti'=>$_POST['id_properti']];
          }
          if (!empty($_POST["id_unit"])) {
            $where += ['id_unit'=>$_POST['id_unit']];
          }
          if ((!empty($_POST["tgl_mulai"])) && (empty($_POST["tgl_akhir"]))) {
            $where += ['tgl_transaksi >='=>$_POST['tgl_mulai']];
          }
          else if ((!empty($_POST["tgl_akhir"])) && (empty($_POST["tgl_mulai"]))) {
            $where += ['tgl_transaksi <='=>$_POST['tgl_akhir']];
          }
          else if((!empty($_POST['tgl_mulai'])) && (!empty($_POST['tgl_akhir']))){
            $where += ['tgl_transaksi >='=>$_POST['tgl_mulai'],'tgl_transaksi'=>$_POST['tgl_akhir']];
          }
          $where += ['status_transaksi !='=>'s'];
        }
        else{
          $where += ['status_transaksi !='=>'s'];
        }
        $this->load->model('Server_side','ssd');
        $column = "*";
        $tbl = "tbl_transaksi";
        $order = "id_transaksi";
        $search = ['nama_lengkap'];
        $fetch_values = $this->ssd->makeDataTables($column,$tbl,$search,$order,null,$where);
        $data = array();
        foreach ($fetch_values as $value) {
            if (file_exists('assets/uploads/files/spk/'.$value->sp3k)) {
                $btn = '<a href="'.base_url('listtransaksi/printspk/'.$value->id_transaksi).'" class="btn btn-sm btn-inverse-success mr-2" target="blank"><i class="fa fa-print"></i> SP3K</a>';
            } else {
                $btn = '';
            }
            if ($value->kunci == "l") {
                $kunci="terkunci";
                $btn .= '<button type="button" class="btn btn-icons btn-inverse-danger" onclick="setItem(\''.base_url('listtransaksi/unlock/'.$value->id_transaksi).'\',\'Buka\')"><i class="fa fa-unlock"></i></button>';
            } else {
                $kunci="terbuka";
                $btn .="";
            }
            $status = $value->status_transaksi == 'p' ? 'progress' : ($value->status_transaksi == 's' ? 'sementara' : 'selesai'); 
            $sub = array();
            $sub[] = $value->no_spr;
            $sub[] = $value->nama_lengkap;
            $sub[] = $value->nama_unit;
            $sub[] = $value->tgl_transaksi;
            $sub[] = '<div class="badge badge-info">'.$status.'</badge>';
            $sub[] = '<div class="badge badge-dark">'.$kunci.'</badge>';
            $sub[] = '<a href="'.base_url('listtransaksi/getdetail/'.$value->id_transaksi).'" class="btn btn-icons btn-inverse-info" data-id="'.$value->id_transaksi.'"><i class="fa fa-info"></i></a><a href="'.base_url('listtransaksi/printspr/'.$value->id_transaksi).'" class="btn btn-inverse-warning mx-2"><i class="fa fa-print"></i> SPR</a>'.$btn;
            $data[] = $sub;
        }
        $output = array(
            'draw'=>intval($this->input->post('draw')),
            'recordsTotal'=>intval($this->ssd->get_all_datas($tbl,$where)),
            'recordsFiltered'=>intval($this->ssd->get_filtered_datas($column,$tbl,$search,$order,null,$where)),
            'data'=> $data
        );
        return $this->output->set_output(json_encode($output));
    }
    public function getUnit()
    {
        $id = $this->input->post('params1');
        $query = $this->modelapp->getData("id_unit,nama_unit,id_properti","unit",["id_properti"=>$id,'status_unit !='=>'bt'])->result();
        $html = "<option value=''> -- Units -- </option>";
        foreach ($query as $key => $value) {
            $html .= '<option value="'.$value->id_unit.'"> '.$value->nama_unit.' </option>';
        }
        $data["html"] = $html;
        return $this->output->set_output(json_encode($data));
        
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

    public function unlock($id)
    {
        $input = $id;
        $get_data = $this->modelapp->getData('id_transaksi','transaksi',['id_transaksi'=>$input]);
        if ($get_data->num_rows() > 0) {
            $rs_transaksi = $get_data->row_array();
            $query = $this->modelapp->updateData(["kunci"=>"u"],"transaksi",["id_transaksi"=>$rs_transaksi['id_transaksi']]);
            if ($query) {
                $this->session->set_flashdata('success','Data berhasil diubah');
                redirect('listtransaksi');
            } else {
                $this->session->set_flashdata('failed','Data tidak ada perubahan');
                redirect('listtransaksi');
            }
        } else {
            $this->session->set_flashdata('failed','Data tidak ditemukan');
            redirect('listtransaksi');
        }
    }

    public function printSpr()
    {
        $this->load->library('Pdf');
        $id = $this->uri->segment(3);
        if (!empty($id)) {
            $session = $this->session->userdata('id_properti');
            $where = ['id_transaksi'=>$id];
            $data['img'] = getCompanyLogo();
            $getData = $this->modelapp->getData("id_konsumen,id_unit,pembuat","tbl_transaksi",$where)->row_array();
            $data["konsumen"] = $this->modelapp->getData("*","konsumen",["id_konsumen"=>$getData['id_konsumen']])->row_array();
            $data["unit"] = $this->modelapp->getData("*","tbl_unit",["id_unit"=>$getData['id_unit']])->row_array();
            $data['spr'] = $this->modelapp->getData("setting_spr","tbl_properti",['id_properti'=>$session])->row_array();
            $data['pembuat'] = $getData['pembuat'];
            // $this->load->view('print/print_spr',$data);
            $this->pdf->load_view('Surat SPR','print/print_spr',$data);
        }
    }

    public function printSpk($id)
    {
        $data_transaksi = $this->modelapp->getData('sp3k,no_spr,nama_lengkap','tbl_transaksi',['id_transaksi'=>$id])->row_array();
        $data['link'] = base_url('assets/uploads/files/spk/'.$data_transaksi['sp3k']);
        $data['name'] = 'SP3k '.$data_transaksi['nama_lengkap'].' Transaksi ('.$data_transaksi['no_spr'].').pdf';
        $this->load->view('print/custom_print', $data);
    }

    public function getJumlah()
    {
        $id = $this->input->post('id',true);
        $data["s"] = $this->modelapp->getData("COUNT(id_transaksi) as s","tbl_transaksi",['status_transaksi'=>'s','id_properti'=>$id])->row_array();
        $data["p"] = $this->modelapp->getData("COUNT(id_transaksi) as p","tbl_transaksi",['status_transaksi'=>'p','id_properti'=>$id])->row_array();
        $data["sl"] = $this->modelapp->getData("COUNT(id_transaksi) as sl","tbl_transaksi",['status_transaksi'=>'sl','id_properti'=>$id])->row_array();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
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