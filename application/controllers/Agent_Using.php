<?php

class Agent_Using extends CI_Controller {

    public function __construct() {
        parent::__construct(); /* call CodeIgniter's default Constructor */
        $this->load->database(); /* load database libray manually */
        $this->load->model('Crud_model'); /* load Model */
        $this->load->helper('url');
    }

    public function index() {



        $this->load->library('user_agent');


        if ($this->agent->is_browser()) {
            $t=$_SERVER;
            
            $agent = $this->agent->browser() . ' ' . $this->agent->version();
           $rt['rt'] =$_SERVER['SERVER_ADDR'];
            $this->load->view('home/desktop',$rt);
        } elseif ($this->agent->is_robot()) {
            $agent = $this->agent->robot();
        } elseif ($this->agent->is_mobile()) {
            $agent = $this->agent->mobile();
            $this->load->view('home/mobile');
        } else {
            $agent = 'Unidentified User Agent';
            $this->load->view('home/robot');
        }



        echo $this->agent->platform();
    }

}
?>

