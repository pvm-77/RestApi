<?php

class Student_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function create_registration($data) {
        return $this->db->insert("tbl_student", $data);
    }

    public function list_student() {
        $this->db->select("student.*,branch.name as branch_name");
        $this->db->from("tbl_student as student");
        $this->db->join("tbl_branches as branch", "branch.id=student.branch_id");
        $query = $this->db->get();
        return $query->result();
    }

    public function email_adress_exit($email) {
        $this->db->select("*");
        $this->db->from("tbl_student");
        $this->db->where("email", $email);
        $query = $this->db->get();
        return $query->row();
    }

    public function update_student($student_id, $student_data) {
        $this->db->where("id", $student_id);
        $this->db->update("tbl_student", $student_data);
    }

    public function delete_student($id) {
        $this->db->where("id", $id);
        return $this->db->delete("tbl_student");
    }

    public function student_id_exit($id) {
        $this->db->select("*");
        $this->db->from("tbl_student");
        $this->db->where("id", $id);
        $query = $this->db->get();
        return $query->row();
    }

}
?>

