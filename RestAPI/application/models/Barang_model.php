<?php

class Barang_model extends CI_Model
{
    public function getBarang($id_barang =null)
    {
        if ( $id_barang ==null){
        return $this->db->get('barang')->result_array();
    
        } else{
            return $this->db->get_where('barang', ['id_barang' => $id_barang])->result_array();
            
        }
    }

    public function deleteBarang($id_barang)
    {
        $this->db->delete('barang', ['id_barang' => $id_barang]);
        return $this->db->affected_rows();
    }

    public function createBarang($data)
    {
        $this->db->insert('barang', $data);
        return $this->db->affected_rows();
    }

    public function updateBarang($data, $id_barang)
    {
        $this->db->update ('barang', $data, ['id_barang' =>$id_barang]);
        return $this->db->affected_rows();
    }
}