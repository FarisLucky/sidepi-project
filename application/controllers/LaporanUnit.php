<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class LaporanUnit extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->rolemenu->init();
        //Do your magic here
    }
    
    public function index()
    {
        $id = $this->session->userdata("id_properti");
        $data['title'] = 'Laporan Unit';
        $data['menus'] = $this->rolemenu->getMenus();
        $data['img'] = getCompanyLogo();
        if ($_SESSION['id_akses'] === "1") {
            $data['unit'] = $this->modelapp->getData('*','unit')->result();
        }else{
            $data['unit'] = $this->modelapp->getData('*','unit',['id_properti'=>$id])->result_array();
            $data['site_plan'] = $this->modelapp->getData('foto_properti','properti',['id_properti'=>$id])->row_array();
            $data["list_unit"] = $this->modelapp->getData("nama_unit,status_unit","unit",["id_properti"=>$id])->result();
        }
        $data['sasaran_unit'] = $this->modelapp->getData("id_sasaran,nama_kelompok","kelompok_persyaratan",['kategori_persyaratan'=>'unit'])->result();
        $data["properti"] = $this->modelapp->getData('*','tbl_properti')->result();
        $this->pages("laporan/view_unit",$data);
    }

    public function dataProses() //Fungsi Untuk Load Datatable
    {
        $where = $this->whereData();
        $this->load->model('Server_side','ssd');
        $column = "*";
        $tbl = "tbl_unit";
        $order = "id_unit";
        $fetch_values = $this->ssd->makeDataTables($column,$tbl,null,$order,null,$where);
        $data = array();
        foreach ($fetch_values as $value) {
            if ($value->status_unit == "bt") {
                $status = '<span class="badge badge-info">Belum Terjual</span>';
            } elseif ($value->status_unit == 'b') {
                $status = '<span class="badge badge-warning">Booking</span>';
            } else {
                $status = '<span class="badge badge-success">Sudah Terjual</span>';
            }
            $sub = array();
            $sub[] = $value->nama_unit;
            $sub[] = $value->nama_properti;
            $sub[] = $value->type;
            $sub[] = $value->luas_tanah." ".$value->satuan_tanah;
            $sub[] = $value->luas_bangunan." ".$value->satuan_bangunan;
            $sub[] = number_format($value->harga_unit,2,",",".");
            $sub[] = $status;
            $sub[] = '<img src="'.base_url('assets/uploads/images/unit_properti/'.$value->foto_unit).'">';
            $sub[] = '<a href="'.base_url('laporanunit/detail/'.$value->id_unit).'" class="btn btn-success"><i class="fa fa-info"></i> Detail</a>';
            $data[] = $sub;
        }
        $output = array(
            'draw'=>intval($this->input->post('draw')),
            'recordsTotal'=>intval($this->ssd->get_all_datas($tbl,$where)),
            'recordsFiltered'=>intval($this->ssd->get_filtered_datas($column,$tbl,null,$order,null,$where)),
            'data'=> $data
        );
        return $this->output->set_output(json_encode($output));
    }
    
    public function printUnit()
    {
        $where = $this->whereData();
        $this->load->library('Pdf');
        $data['img'] = getCompanyLogo();
        $data['unit'] = $this->modelapp->getData("*","tbl_unit",$where)->result_array();
        // $this->load->view('print/print_unit',$data);
        $this->pdf->load_view('List Unit','print/print_unit',$data,'landscape');
    }

    public function getUnit()
    {
        $id = $this->input->post('params1',true);
        if (!empty($id)) {
            $result = $this->modelapp->getData("id_unit,nama_unit","unit",["id_properti"=>$id])->result();
            $data["html"] = "<option value=''>-- Pilih Unit --</option>";
            foreach ($result as $key => $value) {
                $data["html"] .= "<option value='".$value->id_unit."'>".$value->nama_unit."</option>";
            }
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    
    public function detail($id) //Menampilkan Form Tambah
    {
        $data['title'] = 'Detail Unit';
        $data['menus'] = $this->rolemenu->getMenus();
        $data['img'] = getCompanyLogo();
        $data['unit'] = $this->modelapp->getData("*","unit",["id_unit"=>$id])->row();
        $data['detail_unit'] = $this->modelapp->getData("*","kelompok_persyaratan",["kategori_persyaratan"=>"unit"])->result();
        $data['get_unit'] = $this->modelapp->getData("*","persyaratan_unit",["id_unit"=>$id])->result();
        $this->pages("laporan/view_detail_unit",$data); 
    }
    
    public function getJumlah()
    {
        $id = $this->session->userdata('id_properti');
        $data['total'] = $this->modelapp->getData('COUNT(*) as total','unit',['id_properti'=>$id])->row_array();
        $data['bt'] = $this->modelapp->getData('COUNT(id_unit) as bt','unit',['status_unit'=>'bt','id_properti'=>$id])->row_array();
        $data['b'] = $this->modelapp->getData('COUNT(id_unit) as b','unit',['status_unit'=>'b','id_properti'=>$id])->row_array();
        $data['t'] = $this->modelapp->getData('COUNT(id_unit) as t','unit',['status_unit'=>'t','id_properti'=>$id])->row_array();
        return $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    
    private function pages($url ,$data)
    {
        $this->load->view('partials/part_navbar', $data);
        $this->load->view('partials/part_sidebar', $data);
        $this->load->view($url, $data);
        $this->load->view('partials/part_footer', $data);
    }
    
    private function whereData()
    {
        $where = [];
        $session = $this->session->userdata("id_akses");
        if ( isset($_POST["properti"]) || isset($_POST["id_unit"])) {
            $properti = $this->input->post('id_properti',true);
            $id_unit = $this->input->post('id_unit',true);
            if (!empty($properti)) {
                $where = ['id_properti'=>$properti];
            }
            if (!empty($id_unit)) {
                $where = ['id_unit'=>$id_unit]; 
            }
        }
        if ($session != 1) {
            $where = ["id_properti"=>$this->session->userdata('id_properti')];
        }
        return $where;
    }
}

/* End of file laporan.php */