<?php

class Email_controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('email');
        $this->load->library('user_agent');
    }

    public function index() {

        $this->load->helper('form');
        $this->load->view('emailsend');
    }

    public function send_mail() {
        
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => 'makboolk20@gmail.com', // change it to yours
            'smtp_pass' => '', // change it to yours
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
        );
        $this->email->initialize($config);

        $from_email = "makboolk20@gmail.com";
        $to_email = $this->input->post('email');

        //Load email library 


        $this->email->from($from_email);
        $this->email->to($to_email);
        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');

        //Send mail 
        if ($this->email->send()) {

            $this->session->set_flashdata("email_sent", "Email sent successfully.");
        } else {
            $this->session->set_flashdata("email_sent", "Error in sending Email.");
            $this->load->view('emailsend');
        }
    }

}

?>