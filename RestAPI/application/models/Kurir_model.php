<?php

class Kurir_model extends CI_Model
{
    public function getKurir($id_kurir =null)
    {
        if ( $id_kurir ==null){
        return $this->db->get('kurir')->result_array();
    
        } else{
            return $this->db->get_where('kurir', ['id_kurir' => $id_kurir])->result_array();
            
        }
    }

    public function deleteKurir($id_kurir)
    {
        $this->db->delete('kurir', ['id_kurir' => $id_kurir]);
        return $this->db->affected_rows();
    }

    public function createKurir($data)
    {
        $this->db->insert('kurir', $data);
        return $this->db->affected_rows();
    }

    public function updateKurir($data, $id_kurir)
    {
        $this->db->update ('kurir', $data, ['id_kurir' =>$id_kurir]);
        return $this->db->affected_rows();
    }
}