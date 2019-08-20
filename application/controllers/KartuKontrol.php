<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class KartuKontrol extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->rolemenu->init();
        $this->load->model('Model_laporan',"Mlaporan");   
    }
    
    public function index()
    {
        $data["title"] = "Kartu Kontrol";
        $data['menus'] = $this->rolemenu->getMenus();
        $data['img'] = getCompanyLogo();
        $data['properti'] = $this->modelapp->getData('*',"properti")->result();
        $data['unit'] = $this->modelapp->getData('*',"unit")->result();
        $this->pages("kartu_kontrol/view_kontrol",$data);
    }

    public function dataProses() //Fungsi Untuk Load Datatable
    {
        if (isset($_POST["id_properti"]) || isset($_POST["id_unit"]) || isset($_POST["tgl_mulai"]) || isset($_POST["tgl_akhir"])) {
            $where = ['status_transaksi !='=>'s'];
            if (!empty($_POST["id_properti"])) {
                $where += ['id_properti'=>$_POST['id_properti']];
            }
            if (!empty($_POST["id_unit"])) {
                $where += ['id_unit'=>$_POST['id_unit']];
            }
            if ((!empty($_POST["tgl_mulai"])) && (empty($_POST["tgl_akhir"]))) {
                $where += ['tgl_transaksi >='=>$_POST['tgl_mulai']];
            } elseif ((empty($_POST["tgl_mulai"])) && (!empty($_POST["tgl_akhir"]))) {
                $where += ['tgl_transaksi <='=>$_POST['tgl_akhir']];
            } elseif ((!empty($_POST["tgl_mulai"])) && (!empty($_POST["tgl_akhir"]))) {
                $where += ['tgl_transaksi >='=>$_POST['tgl_mulai'],'tgl_transaksi <='=>$_POST['tgl_akhir']];
            }
        }else{
            $where = ['status_transaksi !='=>'s'];
        }
        $this->load->model('Server_side','ssd');
        $column = "id_transaksi,no_spr,nama_lengkap,nama_unit,status_transaksi,tgl_transaksi,status_tj,status_um,status_ccl";
        $tbl = "tbl_transaksi";
        $order = "id_transaksi";
        $search = ['nama_lengkap'];
        $fetch_values = $this->ssd->makeDataTables($column,$tbl,$search,$order,null,$where);
        $data = array();
        foreach ($fetch_values as $value) {
            $sub = array();
            $sub[] = $value->no_spr;
            $sub[] = $value->nama_lengkap;
            $sub[] = $value->nama_unit;
            $sub[] = ($value->status_tj == "bs") ? '<span class="badge badge-success">Belum Selesai</span>' : '<span class="badge badge-success">Selesai</span>' ;
            $sub[] = ($value->status_um == "bs") ? '<span class="badge badge-warning">Belum Selesai</span>' : '<span class="badge badge-warning">Selesai</span>' ;
            $sub[] = ($value->status_ccl == "bs") ? '<span class="badge badge-info">Belum Selesai</span>' : '<span class="badge badge-info">Selesai</span>' ;
            $sub[] = '<span class="badge badge-primary">'.$value->status_transaksi == 's' ? 'sementara' : ($value->status_transaksi == 'p' ? 'pending' : 'selesai').'</span>';
            $sub[] = $value->tgl_transaksi;
            $sub[] = '<a href="'.base_url()."kartukontrol/detail/".$value->id_transaksi.'" class="btn btn-icons btn-inverse-info"><i class="fa fa-info"></i></a>';
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

    public function detail()
    {
        $id = $this->uri->segment(3);
        $data["title"] = "Detail Kontrol";
        $data['menus'] = $this->rolemenu->getMenus();
        $data['img'] = getCompanyLogo();
        $data["detail_kontrol"] = $this->modelapp->getData("*","tbl_pembayaran",["id_transaksi"=>$id])->result();
        $data["transaksi"] = $this->modelapp->getData('*',"tbl_transaksi",["id_transaksi"=>$id])->row();
        $data["bayar_tj"] = $this->modelapp->getData("SUM(total_bayar) as tanda_jadi","tbl_pembayaran",["id_transaksi"=>$id,'jenis_pembayaran'=>1])->row();
        $data["bayar_um"] = $this->modelapp->getData("SUM(total_bayar) as uang_muka","tbl_pembayaran",["id_transaksi"=>$id,'jenis_pembayaran'=>2])->row();
        $data["bayar_cicilan"] = $this->modelapp->getData("SUM(total_bayar) as cicilan","tbl_pembayaran",["id_transaksi"=>$id,'jenis_pembayaran'=>3])->row();
        $data["realisasi"] = $this->modelapp->getData("SUM(hutang) as hutang,SUM(total_bayar) as pemasukan","tbl_pembayaran",["id_transaksi"=>$id])->row();
        $this->pages("kartu_kontrol/view_detail_kontrol",$data);
    }

    public function history($id)
    {
        $data['title'] = "History Pembayaran";
        $data['menus'] = $this->rolemenu->getMenus();
        $data['img'] = getCompanyLogo();
        $data["id_pembayaran"] = $id;
        $data["pembayaran"] = $this->modelapp->getData("*","pembayaran",["id_pembayaran"=>$id])->row_array();
        $data["detail"] = $this->modelapp->getData("*","detail_pembayaran",["id_pembayaran"=>$id,'status_owner'=>'sl'])->result_array();
        $this->pages("kartu_kontrol/view_history",$data);
    }

    public function selesai($id)
    {
        $get_data = $this->modelapp->getData('id_transaksi','tbl_transaksi',['id_transaksi'=>$id]);
        if ($get_data->num_rows() > 0) {
            $data_transaksi = $get_data->row_array();
            $query_update = $this->modelapp->updateData(['status_transaksi'=>'sl'],'transaksi',['id_transaksi'=>$data_transaksi['id_transaksi']]);
            if ($query_update) {
                $this->session->set_flashdata('success','Data berhasil diubah');
                redirect('kartukontrol/detail/'.$data_transaksi['id_transaksi']);
            }
        } else {
            $this->session->set_flashdata('failed','Data Tidak Ditemukan');
            redirect('kartukontrol/detail/'.$id);
        }
    }

    public function getUnit()
    {
        $id = $this->input->post('params1');
        $html = "<option value=''> -- Units -- </option>";
        if (!empty($id)) {
            $query = $this->modelapp->getData("id_unit,nama_unit,id_properti","unit",["id_properti"=>$id])->result();
            foreach ($query as $key => $value) {
                $html .= '<option value="'.$value->id_unit.'"> '.$value->nama_unit.' </option>';
            }
            $data["html"] = $html;
        } else {
            $data['html'] = $html;
        }
        return $this->output->set_output(json_encode($data));
    }
    
    // Pages
    private function pages($core_page,$data){
        $this->load->view('partials/part_navbar',$data);
        $this->load->view('partials/part_sidebar',$data);
        $this->load->view($core_page,$data);
        $this->load->view('partials/part_footer',$data);
    }
}

/* End of file KartuKontrol.php */