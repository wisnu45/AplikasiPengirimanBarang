<?php
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';


class Detail_Pengiriman extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Detail_Pengiriman_model','detail_pengiriman');

        $this->methods['index_get']['limit'] = 10;
    }

    public function index_get()
    {
        $id_detail=$this->get('id_detail');
        if ($id_detail === null)
        {
        $detail_pengiriman = $this->detail_pengiriman->getDetail_Pengiriman();

        }else{
            $detail_pengiriman = $this->detail_pengiriman->getBarang($id_detail);
        }

        if ($detail_pengiriman)
        {
            $this->response([
                'status' => TRUE,
                'data' => $detail_pengiriman 
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
        $id_detail = $this->delete('id_detail');
        
        if ($id_detail == null) {
            $this->response([
                'status' => FALSE,
                'massage' => 'provide id detail '
            ], REST_Controller::HTTP_BAD_REQUEST);

        } else {
            if ( $this->detail_pengiriman->deleteDetail_Pengiriman($id_detail) > 0) {
                // ok
                $this->response([
                    'status' => TRUE,
                    'id' => $id_detail,
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
            'id_detail' => $this->post('id_detail'),
            'id_pengiriman' => $this->post('id_pengiriman'),
            'id_barang' => $this->post('id_barang'),
            'qty' => $this->post('qty')
            ];
            
            if( $this->detail_pengiriman->createDetail_Pengiriman($data) > 0) {
                $this->response([
                    'status' => TRUE,
                    'massage' => 'new Detail_Pengiriman has been created.'
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
        $id_detail = $this->put('id_detail');
        $data = [
            'id_pengiriman' => $this->put('id_pengiriman'),
            'id_barang' => $this->put('id_barang'),
            'qty' => $this->put('qty')
            ];

            if( $this->detail_pengiriman->updateDetail_Pengiriman($data, $id_detail) > 0) {
                $this->response([
                    'status' => TRUE, 
                    'massage' => 'data Detail_Pengiriman has been updated.'
                ], REST_Controller::HTTP_NO_CONTENT);
            } else {
                $this->response([
                    'status' => FALSE,
                    'massage' => 'failed to update data!!'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
    }

} 