<?php

class Detail_Pengiriman_model extends CI_Model
{
    public function getDetail_Pengiriman($id_detail =null)
    {
        if ( $id_detail ==null){
        return $this->db->get('detail_pengiriman')->result_array();
    
        } else{
            return $this->db->get_where('detail_pengiriman', ['id_detail' => $id_detail])->result_array();
            
        }
    }

    public function deleteDetail_Pengiriman($id_detail)
    {
        $this->db->delete('detail_pengiriman', ['id_detail' => $id_detail]);
        return $this->db->affected_rows();
    }

    public function createDetail_Pengiriman($data)
    {
        $this->db->insert('detail_pengiriman', $data);
        return $this->db->affected_rows();
    }

    public function updateDetail_Pengiriman($data, $id_detail)
    {
        $this->db->update ('detail_pengiriman', $data, ['id_detail' =>$id_detail]);
        return $this->db->affected_rows();
    }
}