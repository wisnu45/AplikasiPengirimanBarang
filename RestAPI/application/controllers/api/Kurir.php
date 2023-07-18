<?php
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';


class Kurir extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kurir_model','kurir');

        $this->methods['index_get']['limit'] = 30;
    }

    public function index_get()
    {
        $id_kurir=$this->get('id_kurir');
        if ($id_kurir === null)
        {
        $kurir = $this->kurir->getKurir();

        }else{
            $kurir = $this->kurir->getKurir($id_kurir);
        }

        if ($kurir)
        {
            $this->response([
                'status' => TRUE,
                'data' => $kurir 
            ], REST_Controller::HTTP_OK);
        } else{
            $this->response([
                'status' => FALSE,
                'massage' => 'id not found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
        
    }

    public function index_delete()
    {
        $id_kurir = $this->delete('id_kurir');
        
        if ($id_kurir == null) {
            $this->response([
                'status' => FALSE,
                'massage' => 'provide id kurir '
            ], REST_Controller::HTTP_BAD_REQUEST);

        } else {
            if ( $this->kurir->deleteKurir($id_kurir) > 0) {
                // ok
                $this->response([
                    'status' => TRUE,
                    'id' => $id_kurir,
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

    public function index_post()
    {
        $data = [
            'id_kurir' => $this->post('id_kurir'),
            'nama' => $this->post('nama'),
            'jenis_kelamin' => $this->post('jenis_kelamin'),
            'telepon' => $this->post('telepon'),
            'alamat' => $this->post('alamat'),
            'password' => $this->post('password'),
            ];
            
            if( $this->kurir->createKurir($data) > 0) {
                $this->response([
                    'status' => TRUE,
                    'massage' => 'new kurir has been created.'
                ], REST_Controller::HTTP_CREATED);
            } else {
                $this->response([
                    'status' => FALSE,
                    'massage' => 'failed to create new data!!'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
    }

    public function index_put()
    {
        $id_kurir = $this->put('id_kurir');
        $data = [
            'nama' => $this->put('nama'),
            'jenis_kelamin' => $this->put('jenis_kelamin'),
            'telepon' => $this->put('telepon'),
            'alamat' => $this->put('alamat'),
            'password' => $this->put('password'),
            ];

            if( $this->kurir->updateKurir($data, $id_kurir) > 0) {
                $this->response([
                    'status' => TRUE, 
                    'massage' => 'data kurir has been updated.'
                ], REST_Controller::HTTP_NO_CONTENT);
            } else {
                $this->response([
                    'status' => FALSE,
                    'massage' => 'failed to update data!!'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
    }

} 