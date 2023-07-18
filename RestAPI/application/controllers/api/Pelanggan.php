<?php
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';


class Pelanggan extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pelanggan_model','pelanggan');

        $this->methods['index_get']['limit'] = 10;
    }

    public function index_get()
    {
        $id_pelanggan=$this->get('id_pelanggan');
        if ($id_pelanggan === null)
        {
        $pelanggan = $this->pelanggan->getPelanggan();

        }else{
            $pelanggan = $this->pelanggan->getPelanggan($id_pelanggan);
        }

        if ($pelanggan)
        {
            $this->response([
                'status' => TRUE,
                'data' => $pelanggan 
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
        $id_pelanggan = $this->delete('id_pelanggan');
        
        if ($id_pelanggan == null) {
            $this->response([
                'status' => FALSE,
                'massage' => 'provide id pelanggan '
            ], REST_Controller::HTTP_BAD_REQUEST);

        } else {
            if ( $this->pelanggan->deletePelanggan($id_pelanggan) > 0) 
            {
                // ok
                $this->response([
                    'status' => TRUE,
                    'id' => $id_pelanggan,
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
            'id_pelanggan' => $this->post('id_pelanggan'),
            'nama' => $this->post('nama'),
            'telepon' => $this->post('telepon'),
            'alamat' => $this->post('alamat')
            ];
            
            if( $this->pelanggan->createPelanggan($data) > 0) {
                $this->response([
                    'status' => TRUE,
                    'massage' => 'new pelanggan has been created.'
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
        $id_pelanggan = $this->put('id_pelanggan');
        $data = [
            'id_pelanggan' => $this->put('id_pelanggan'),
            'nama' => $this->put('nama'),
            'telepon' => $this->put('telepon'),
            'alamat' => $this->put('alamat')
            ];
            if( $this->pelanggan->updatePelanggan($data, $id_pelanggan) > 0) {
                $this->response([
                    'status' => TRUE, 
                    'massage' => 'data barang has been updated.'
                ], REST_Controller::HTTP_NO_CONTENT);
            } else {
                $this->response([
                    'status' => FALSE,
                    'massage' => 'failed to update data!!'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
    }

} 