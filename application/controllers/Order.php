<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Order extends REST_Controller{

	public function __construct()
	{
		parent::__construct();
        $this->load->database();
        $this->load->model('Model_basic');
        $this->methods['Order_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['Order_post']['limit'] = 500;
        $this->methods['Order_put']['limit'] = 500; // 100 requests per hour per user/key
        $this->methods['Order_delete']['limit'] = 50; // 50 requests per hour per user/key
	}

	public function Order_get()
	{
		$Orderes = $this->Model_basic->select_all_api('Order');
        $id = $this->get('id');

        if ($id === NULL) {
            if ($Orderes) {
                $this->response($Orderes, REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'Tidak ada data Order'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }

        $id = (string) $id;
        if ($id <= 0) {
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
        }

        $Order = NULL;

        if (!empty($Orderes)) {
            foreach ($Orderes as $key => $value) {
                if (isset($value['id']) && $value['id'] === $id) {
                    $Order = $value;
                }
            }
        }

        if (!empty($Order)) {
            $this->set_response($Order, REST_Controller::HTTP_OK);
        }else{
            $this->set_response([
                'status' => FALSE,
                'message' => 'Data Order tidak ada'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
	}

	public function Order_post()
	{
		$photo = $this->input->post('photo');
		$desktempat = $this->input->post('desktempat');
		$tanggal = date('Y-m-d H:i:s', time());

		if ($photo == NULL && $desktempat == NULL) {
			$data = array(
				'id_user' => $this->input->post('id_user'),
				'id_ojek' => 0,
				'lokasi_jemput' => $this->input->post('lokasi_jemput'),
				'lokasi_tujuan' => $this->input->post('lokasi_tujuan'),
                'status_order' => 0
				);
			$this->Model_basic->insert_all('order',$data);
			$this->set_response($data, REST_Controller::HTTP_CREATED);
		}
	}
}