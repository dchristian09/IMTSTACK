<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Mahasiswa extends REST_Controller{

    function __construct($config = 'rest'){
        parent::__construct($config);
        $this->load->model('Mahasiswamodel', 'model');
    }

    public function index_get(){
        $data = $this -> model -> getMahasiswa();
        $data2 = $this-> model -> getMahasiswa();
        $this->set_response([
            'status' => TRUE,
            'code' => 200,
            'message' => 'Success',
            'data' => $data
        ], REST_Controller::HTTP_OK);
        
    }

    public function sendmail_post(){
        $to_email = $this->post('email');
        $this->load->library('email');
        $this->email->from('dchristian@imtstack.com', 'IMT STACK');
        $this->email->to($to_email);
        $this->email->subject('INFORMASI PENTING DARI IMTSTACK');
        $this->email->message("
            <center>
                <h1 style='center'> Selamat bergabung di IMTSTACK!!! </h1>
                <img src='https://media.giphy.com/media/dZXzmKGKNiJtDxuwGg/giphy.gif' width='480' height='480' frameBorder='0'>
                <h3> Terima kasih telah mendaftar di IMTSTACK </h3>
                <h3> Kami berharap anda dapat menikmati IMTSTACK </h3>
            </center>
        ");

        if($this->email->send()){
            $this->set_response([
                'status' => TRUE,
                'code' => 200,
                'message'=> 'Email informasi penting berhasil dikirim, silahkan periksa inbox email Anda!'
                ], REST_Controller::HTTP_OK);
        }else{
            $this->set_response([
                'status' => FALSE,
                'code' => 404,
                'message' => 'Gagal mengirimkan email informasi!'
                ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}