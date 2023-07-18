<?php

class User_model extends CI_Model
{
    //Untuk Mengambil Data User
    public function getUser($id_user =null)
    {
        if ( $id_user ==null){
        return $this->db->get('user')->result_array();
    
        } else{
            return $this->db->get_where('user', ['id_user' => $id_user])->result_array();
            
        }
    }

    //Untuk Menghapus Data User
    public function deleteUser($id_user)
    {
        $this->db->delete('user', ['id_user' => $id_user]);
        return $this->db->affected_rows();
    }

    //Untuk Membuat Data User Baru
    public function createUser($data)
    {
        $this->db->insert('user', $data);
        return $this->db->affected_rows();
    }

    //Untuk Mengubah Data User
    public function updateUser($data, $id_user)
    {
        $this->db->update ('user', $data, ['id_user' =>$id_user]);
        return $this->db->affected_rows();
    }
}