<?php
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class User extends REST_Controller
{

    //Untuk Mengambil Data Table User
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model','user');

        $this->methods['index_get']['limit'] = 20;
    }

    //Mengambil Data User
    public function index_get()
    {
        $id_user=$this->get('id_user');
        if ($id_user === null)
        {
        $user = $this->user->getUser();

        }else{
            $user = $this->user->getBarang($id_user);
        }

        if ($user)
        {
            $this->response([
                'status' => TRUE,
                'data' => $user 
            ], REST_Controller::HTTP_OK);
        } else{
            $this->response([
                'status' => FALSE,
                'massage' => 'id not found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
        
    }

    //Untuk Menghapus Data User
    public function index_delete()
    {
        $id_user = $this->delete('id_user');
        
        if ($id_user == null) {
            $this->response([
                'status' => FALSE,
                'massage' => 'provide id user '
            ], REST_Controller::HTTP_BAD_REQUEST);

        } else {
            if ( $this->user->deleteUser($id_user) > 0) {
                // ok
                $this->response([
                    'status' => TRUE,
                    'id' => $id_user,
                    'massage' => 'deleted.'
                ], REST_Controller::HTTP_NO_CONTENT);
            } else {
                $this->response([
                    'status' => FALSE,
                    'massage' => 'id not found!'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    //Untuk Membuat Data User Baru
    public function index_post()
    {
        $data = [
            'id_user' => $this->post('id_user'),
            'username' => $this->post('username'),
            'password' => $this->post('password'),
            'level' => $this->post('level')
            ];
            
            if( $this->user->createUser($data) > 0) {
                $this->response([
                    'status' => TRUE,
                    'massage' => 'new user has been created.'
                ], REST_Controller::HTTP_CREATED);
            } else {
                $this->response([
                    'status' => FALSE,
                    'massage' => 'failed to create new data!!'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
    }


    //Untuk Mengubah Data User
    public function index_put()
    {
        $id_user = $this->put('id_user');
        $data = [
            'username' => $this->post('username'),
            'password' => $this->post('password'),
            'level' => $this->post('level')
            ];
            
            if( $this->user->updateUser($data, $id_user) > 0) {
                $this->response([
                    'status' => TRUE, 
                    'massage' => 'data user has been updated.'
                ], REST_Controller::HTTP_NO_CONTENT);
            } else {
                $this->response([
                    'status' => FALSE,
                    'massage' => 'failed to update data!!'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
    }
}