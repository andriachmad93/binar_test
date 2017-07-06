<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Bantuan extends REST_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Model_basic');
        $this->methods['Bantuan_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['Bantuan_post']['limit'] = 500;
        $this->methods['Bantuan_put']['limit'] = 500; // 100 requests per hour per user/key
        $this->methods['Bantuan_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    public function Bantuan_post()
    {
        $tanggal = date('Y-m-d H:i:s', time());

        $data = array(
            'user_servis_id' => $this->input->post('id_user'),
            'isibantuan' => $this->input->post('isibantuan'),
            'date_created' => $tanggal
            );
        $this->Model_basic->insert_all('bantuan',$data);
        $this->set_response($data, REST_Controller::HTTP_CREATED);
    }
}