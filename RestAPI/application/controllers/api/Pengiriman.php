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

        $this->methods['index_get']['limit'] = 30;
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
                'massage' => 'provide id pengiriman'
            ], REST_Controller::HTTP_BAD_REQUEST);

        } else {
            if ( $this->pengiriman->deletePengiriman($id_pengiriman) > 0) {
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
            'tanggal' => $this->post('tanggal'),
            'id_pelanggan' => $this->post('id_pelanggan'),
            'id_kurir' => $this->post('id_kurir'),
            'no_kendaraan' => $this->post('no_kendaraan'),
            'no_po' => $this->post('no_po'),
            'keterangan' => $this->post('keterangan'),
            'penerima' => $this->post('penerima'),
            'poto' => $this->post('poto'),
            'status' => $this->post('status')
            ];
            
            if( $this->pengiriman->createPengiriman($data) > 0) {
                $this->response([
                    'status' => TRUE,
                    'massage' => 'new pengiriman has been created.'
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
        $id_pengiriman = $this->put('id_pengiriman');
        $data = [
            'id_pengiriman' => $this->put('id_pengiriman'),
            'tanggal' => $this->put('tanggal'),
            'id_pelanggan' => $this->put('id_pelanggan'),
            'id_kurir' => $this->put('id_kurir'),
            'no_kendaraan' => $this->put('no_kendaraan'),
            'no_po' => $this->put('no_po'),
            'keterangan' => $this->put('keterangan'),
            'penerima' => $this->put('penerima'),
            'poto' => $this->put('poto'),
            'status' => $this->put('status')
            ];

            if( $this->pengiriman->updatePengiriman($data, $id_pengiriman) > 0) {
                $this->response([
                    'status' => TRUE, 
                    'massage' => 'data pengiriman has been updated.'
                ], REST_Controller::HTTP_NO_CONTENT);
            } else {
                $this->response([
                    'status' => FALSE,
                    'massage' => 'failed to update data!!'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
    }
}