<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class ModelApp extends CI_Model {

    public function getData($select,$tbl,$where = null,$order=null,$order_by=null)
    {
        $this->db->select($select);
        $this->db->from($tbl);
        if ($where != null) {
            $this->db->where($where);
        }
        if ($order != null) {
            $this->db->order_by($order, $order_by);
        }
        return $this->db->get();
    }
    public function getJoinData($select,$tbl,$join,$where=null,$order=null,$order_by=null)
    {
        $this->db->select($select);
        $this->db->from($tbl);
        if (is_array($join)) {
            foreach ($join as $key => $value) {
                $this->db->join($key,$value,'inner');
            }
        }
        if ($where != null) {
            $this->db->where($where);
        }
        if ($order != null) {
            $this->db->order_by($order, $order_by);
        }
        return $this->db->get();
    }
    public function updateData($data,$tbl,$where)
    {
        $this->db->update($tbl,$data,$where);
        return $this->db->affected_rows();
    }
    public function insertData($data,$tbl)
    {
        $this->db->insert($tbl,$data);
        return $this->db->affected_rows();
    }
    public function deleteData($where,$tbl)
    {
        $this->db->where($where);
        $this->db->delete($tbl);
        return $this->db->affected_rows();
    }

    public function start_poll()
    {
        $time = $this->input->post('time',true);
        if (!is_numeric($time)) {
            return [];
        
        }
        $time = getdate($time);
        $time = $time['year'].'-'.$time['mon'].'-'.$time['mday'];
        while (true) {
            $this->db->select('*');
            $this->db->from('pengeluaran');
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                $msgs = [];
                foreach ($query->result_array() as $key => $value) {
                    $msgs[] = $value['nama_pengeluaran'];
                }
                return $msgs;
            }
            sleep(1);
        }
    }

}

/* End of file ModelApp.php */