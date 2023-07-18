<?php

class Pelanggan_model extends CI_Model
{
    public function getPelanggan($id_pelanggan =null)
    {
        if ( $id_pelanggan ==null){
        return $this->db->get('pelanggan')->result_array();
    
        } else{
            return $this->db->get_where('pelanggan', ['id_pelanggan' => $id_pelanggan])->result_array();
            
        }
    }

    public function deletePelanggan($id_pelanggan)
    {
        $this->db->delete('pelanggan', ['id_pelanggan' => $id_pelanggan]);
        return $this->db->affected_rows();
    }

    public function createPelanggan($data)
    {
        $this->db->insert('pelanggan', $data);
        return $this->db->affected_rows();
    }

    public function updatePelanggan($data, $id_pelanggan)
    {
        $this->db->update ('pelanggan', $data, ['id_pelanggan' =>$id_pelanggan]);
        return $this->db->affected_rows();
    }
}