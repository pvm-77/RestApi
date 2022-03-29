<?php

class Crud_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function saverecords($fname, $lname) {
        $query = "insert into user (fname,lname) values('$fname','$lname')";
        // return $this->db->insert("user", $fname, $lname);
        return $this->db->query($query);
    }

}
