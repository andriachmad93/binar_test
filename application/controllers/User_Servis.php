<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class User_Servis extends REST_Controller{

	public function __construct()
	{
		parent::__construct();
        $this->load->database();
        $this->load->model('Model_basic');
        $this->methods['User_Servis_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['User_Servis_post']['limit'] = 500;
        $this->methods['User_Servis_put']['limit'] = 500; // 100 requests per hour per user/key
        $this->methods['User_Servis_delete']['limit'] = 50; // 50 requests per hour per user/key
	}

	public function User_Servis_get()
	{
		$users = $this->Model_basic->select_all_api('user_servis');
        $id = $this->get('id');

        if ($id === NULL) {
            if ($users) {
                $this->response($users, REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'Tidak ada data User'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }

        $id = (string) $id;
        if ($id <= 0) {
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
        }

        $user = NULL;

        if (!empty($users)) {
            foreach ($users as $key => $value) {
                if (isset($value['id']) && $value['id'] === $id) {
                    $user = $value;
                }
            }
        }

        if (!empty($user)) {
            $this->set_response($user, REST_Controller::HTTP_OK);
        }else{
            $this->set_response([
                'status' => FALSE,
                'message' => 'Data User tidak ada'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
	}

	public function User_Servis_post()
	{
		$check_email = $this->Model_basic->select_where('user_servis','email',$this->input->post('email'))->result();

		if ($check_email == NULL) {
			$photo = $this->input->post('photo');
			$tanggal = date('Y-m-d H:i:s', time());
			$kode1 = rand(1,10);
			$kode2 = rand(21,30);
			$kode3 = rand(31,40);
			$kode4 = rand(40,100);

			if ($photo == NULL) {
				$data = array(
					'nama' => $this->input->post('nama'),
					'email' => $this->input->post('email'),
					'nohp' => $this->input->post('nohp'),
					'password' => $this->encrypt->encode($this->input->post('password')),
					'k1' => $kode1,
					'k2' => $kode2,
					'k3' => $kode3,
					'k4' => $kode4,
					'status_user' => 0,
					'date_created' => $tanggal,
					'date_updated' => $tanggal
				);
				$this->Model_basic->insert_all('user_servis',$data);
				$this->set_response($data, REST_Controller::HTTP_CREATED);
			}
		}else{
			$this->set_response('Mohon Maaf Akun E-Mail yang anda daftarkan sudah terdaftar di Sistem Kami Terima Kasih', REST_Controller::HTTP_CREATED);
		}
	}
}