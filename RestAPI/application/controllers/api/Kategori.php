<?php
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';


class Kategori extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kategori_model','kategori');

        $this->methods['index_get']['limit'] = 10;
    }

    public function index_get()
    {
        $id_kategori=$this->get('id_kategori');
        if ($id_kategori === null)
        {
        $kategori = $this->kategori->getKategori();

        }else{
            $kategori = $this->kategori->getKategori($id_kategori);
        }

        if ($kategori)
        {
            $this->response([
                'status' => TRUE,
                'data' => $kategori 
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
        $id_kategori = $this->delete('id_kategori');
        
        if ($id_kategori == null) {
            $this->response([
                'status' => FALSE,
                'massage' => 'provide id kategori '
            ], REST_Controller::HTTP_BAD_REQUEST);

        } else {
            if ( $this->kategori->deleteKategori($id_kategori) > 0) {
                // ok
                $this->response([
                    'status' => TRUE,
                    'id' => $id_kategori,
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
            'id_kategori' => $this->post('id_kategori'),
            'nama' => $this->post('nama'),
            'keterangan' => $this->post('keterangan')
            ];
            
            if( $this->kategori->createKategori($data) > 0) {
                $this->response([
                    'status' => TRUE,
                    'massage' => 'new kategori has been created.'
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
        $id_kategori = $this->put('id_kategori');
        $data = [
            'nama' => $this->put('nama'),
            'keterangan' => $this->put('keterangan')
            ];

            if( $this->kategori->updateKategori($data, $id_kategori) > 0) {
                $this->response([
                    'status' => TRUE, 
                    'massage' => 'data kategori has been updated.'
                ], REST_Controller::HTTP_NO_CONTENT);
            } else {
                $this->response([
                    'status' => FALSE,
                    'massage' => 'failed to update data!!'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
    }

} 