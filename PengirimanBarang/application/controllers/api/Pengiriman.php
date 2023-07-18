<?php
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Pengiriman extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pengiriman_model','pengiriman');

        $this->methods['index_get']['limit'] = 10;
    }

    public function index_get()
    {
        $id_pengiriman=$this->get('id_pengiriman');
        if ($id_pengiriman === null)
        {
        $pengiriman = $this->pengiriman->getPengiriman();

        }else{
            $pengiriman = $this->pengiriman->getPengiriman($id_pengiriman);
        }

        if ($pengiriman)
        {
            $this->response([
                'status' => TRUE,
                'data' => $pengiriman 
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
        $id_pengiriman = $this->delete('id_pengiriman');
        
        if ($id_pengiriman == null) {
            $this->response([
                'status' => FALSE,
                'massage' => 'provide id pengiriman '
            ], REST_Controller::HTTP_BAD_REQUEST);

        } else {
            if ( $this->barang->deletePengiriman($id_pengiriman) > 0) {
                // ok
                $this->response([
                    'status' => TRUE,
                    'id' => $id_pengiriman,
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
            'id_pengiriman' => $this->post('id_pengiriman'),
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