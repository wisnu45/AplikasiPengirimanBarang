<?php
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';


class Barang extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Barang_model','barang');

        $this->methods['index_get']['limit'] = 10;
    }

    public function index_get()
    {
        $id_barang=$this->get('id_barang');
        if ($id_barang === null)
        {
        $barang = $this->barang->getBarang();

        }else{
            $barang = $this->barang->getBarang($id_barang);
        }

        if ($barang)
        {
            $this->response([
                'status' => TRUE,
                'data' => $barang 
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
        $id_barang = $this->delete('id_barang');
        
        if ($id_barang == null) {
            $this->response([
                'status' => FALSE,
                'massage' => 'provide id barang '
            ], REST_Controller::HTTP_BAD_REQUEST);

        } else {
            if ( $this->barang->deleteBarang($id_barang) > 0) {
                // ok
                $this->response([
                    'status' => TRUE,
                    'id' => $id_barang,
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
            'id_barang' => $this->post('id_barang'),
            'nama' => $this->post('nama'),
            'satuan' => $this->post('satuan'),
            'del_no' => $this->post('del_no'),
            'id_kategori' => $this->post('id_kategori')
            ];
            
            if( $this->barang->createBarang($data) > 0) {
                $this->response([
                    'status' => TRUE,
                    'massage' => 'new barang has been created.'
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
        $id_barang = $this->put('id_barang');
        $data = [
            'nama' => $this->put('nama'),
            'satuan' => $this->put('satuan'),
            'del_no' => $this->put('del_no'),
            'id_kategori' => $this->put('id_kategori')
            ];

            if( $this->barang->updateBarang($data, $id_barang) > 0) {
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