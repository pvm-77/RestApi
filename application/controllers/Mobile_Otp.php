<?php

//require APPPATH . 'libraries/TextClass.php';
header("Access-Control-Allow-Origin: *");

class Mobile_Otp extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('email');
        $this->load->library('user_agent');
        include APPPATH . 'libraries/TextClass.php';
        // $this->Mobile_number_otp();
    }

    public function index() {

        $this->load->helper('form');
        $this->load->view('mobileNumber');
    }

    public function Mobile_number_otp() {
        // print_r($_POST);
        switch ($_POST["action"]) {
            case "send_otp":
                // print_r($_POST);
                $mobile_number = $_POST['mobile_number'];

                $apiKey = urlencode('NjQzOTQ3NTQ2MTUwNDU3NTYxNTYzNDRmNTg0ZDU2MzI=');
                $Textlocal = new Textlocal(false, false, $apiKey);
               


                $numbers = array(
                    $mobile_number
                );
                $sender = 'PHPPOT';
                $otp = rand(100000, 999999);
                $_SESSION['session_otp'] = $otp;
                $message = "Your One Time Password is " . $otp;
                //$trt = $Textlocal->sendSms('ll', 'klt', 'kkkk');
                try {
                    $response = $Textlocal->sendSms($numbers, $message, $sender);
                    print_r($response);
                    $this->load->view('verficationMobile');
                    exit();
                } catch (Exception $e) {
                    die('Error: ' . $e->getMessage());
                }
                break;

            case "verify_otp":
                $otp = $_POST['otp'];

                if ($otp == $_SESSION['session_otp']) {
                    unset($_SESSION['session_otp']);
                    echo json_encode(array("type" => "success", "message" => "Your mobile number is verified!"));
                } else {
                    echo json_encode(array("type" => "error", "message" => "Mobile number verification failed"));
                }
                break;
        }
    }

}

?>