<?php

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

defined('BASEPATH') OR exit('No direct script access allowed');

class Produksi extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        // load model & membuat alias 'produksi'
        $this->load->model('Produksi_model', 'produksi');
    }
    
    public function index_get() {
        $id_produksi = $this->get('id_produksi');

        if($id_produksi === null) {
            $produksi = $this->produksi->getProduksi();
        } else {
            $produksi = $this->produksi->getProduksi($id_produksi);
        }

        if($produksi) {
            $this->response([
                'status' => TRUE,
                'data' => $produksi
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'id not found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_delete()
    {
        $id_produksi = $this->delete('id_produksi');

        if($id_produksi === null) {
            $this->response([
                'status' => FALSE,
                'message' => 'provide an id'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if($this->produksi->deleteProduksi($id_produksi) > 0) {
                $this->response([
                    'status' => TRUE,
                    'id_produksi' => $id_produksi,
                    'message' => 'deleted.'
                    // jika HTTP_NO_CONTENT maka response tidak akan di tampilkan, solusi ganti ->  HTTP_OK
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'id not found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_post()
    {
        $data = [
            'nama_barang' => $this->post('nama_barang'),
            'stock' => $this->post('stock'),
            'tanggal' => $this->post('tanggal'),
            'pabrik' => $this->post('pabrik'),
            'id_gudang_fk' => $this->post('id_gudang')
        ];

        if($this->produksi->createProduksi($data) > 0) {
            $this->response([
                'status' => TRUE,
                'message' => 'new produksi has been created'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'failed to create new data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {
        $id_produksi = $this->put('id_produksi');
        $data = [
            'nama_barang' => $this->put('nama_barang'),
            'stock' => $this->put('stock'),
            'tanggal' => $this->put('tanggal'),
            'pabrik' => $this->put('pabrik'),
            'id_gudang_fk' => $this->put('id_gudang')
        ];

        if($this->produksi->updateProduksi($data, $id_produksi) > 0) {
            $this->response([
                'status' => TRUE,
                'message' => 'Produksi has been updated'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'failed to update data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}

?>