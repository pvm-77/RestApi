<?php

class Semester_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function create_project($data) {
        return $this->db->insert("tbl_semester_project", $data);
    }

    public function get_all_project() {
        $this->db->select("project.*,student.name as student_name,student.email as student_email");
        $this->db->from("tbl_semester_project as project");
        $this->db->join("tbl_student as student", "student.id=project.student_id", "INNER");
        $query = $this->db->get();
        return $query->result();
    }

    public function get_student_project($student_id) {
        $this->db->select("project.*,student.name as student_name,student.email as student_email");
        $this->db->from("tbl_semester_project as project");
        $this->db->join("tbl_student as student", "student.id=project.student_id", "INNER");
        $this->db->where("project.student_id", $student_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function delete_project($student_id) {
        $this->db->where("student_id", $student_id);
        return $this->db->delete("tbl_semester_project");
    }

}
?>

