<?php

require APPPATH . 'libraries/REST_Controller.php';
//header

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST,GET");

class Student extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("api/Student_model");
        $this->load->helper(array("authorization", "jwt_helper"));
    }

    public function register_post() {

        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->name) && isset($data->email) && isset($data->phone) && isset($data->password) && isset($data->gender) && isset($data->branch_id)) {
            if ($this->Student_model->email_adress_exit($data->email)) {
                $this->response(array(
                    "status" => 0,
                    "message" => "this is email already registration"
                        ), parent::HTTP_NOT_FOUND);
            } else {
                $student_data = array(
                    "name" => $data->name,
                    "email" => $data->email,
                    "phone" => $data->phone,
                    "password" => password_hash($data->password, PASSWORD_DEFAULT),
                    "gender" => $data->gender,
                    "branch_id" => $data->branch_id
                );

                if ($this->Student_model->create_registration($student_data)) {
                    $this->response(array(
                        "status" => 1,
                        "message" => "create data "
                            ), parent::HTTP_OK);
                } else {
                    $this->response(array(
                        "status" => 0,
                        "message" => " data not insert in database"
                    ));
                }
            }
        } else {
            $this->response(array(
                "status" => 0,
                "message" => " all field will be needed"
                    ), parent::HTTP_NOT_FOUND);
        }
    }

    public function list_get() {

        $student_list = $this->Student_model->list_student();
        if (count($student_list) > 0) {
            $this->response(array(
                "status" => 1,
                "message" => "all student list registration",
                "data" => $student_list
                    ), parent::HTTP_OK);
        } else {
            $this->response(array(
                "status" => 0,
                "message" => " not fount data"
                    ), parent::HTTP_NOT_FOUND);
        }
    }

    public function student_data_put() {
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->id) && isset($data->email) && isset($data->phone) && isset($data->name) && isset($data->gender) && isset($data->branch_id)) {
            $student_update = array(
                "name" => $data->name,
                "email" => $data->email,
                "phone" => $data->phone,
                "gender" => $data->gender,
                "branch_id" => $data->branch_id
            );

            if ($this->Student_model->update_student($data->id, $student_update)) {
                $this->response(array(
                    "status" => 1,
                    "message" => "update succefully"
                        ), parent::HTTP_OK);
            } else {
                $this->response(array(
                    "status" => 0,
                    "message" => " not update of data student"
                        ), self::HTTP_INTERNAL_SERVER_ERROR);
                $this->response(array(
                    "status" => 0,
                    "message" => "all filed will be needed"
                ));
            }
        }
    }

    public function delete_student_delete() {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->id)) {
            if (!empty($this->Student_model->student_id_exit($data->id))) {
                if ($this->Student_model->delete_student($data->id)) {
                    $this->response(array(
                        "status" => 1,
                        "message" => "Delete succfully of student"
                            ), parent::HTTP_OK);
                } else {
                    $this->response(array(
                        "status" => 0,
                        "message" => " student detalies not deleted"
                            ), parent::HTTP_INTERNAL_SERVER_ERROR);
                }
            } else {
                $this->response(array(
                    "status" => 0,
                    "message" => " id will not exit of data base"
                        ), parent::HTTP_NOT_FOUND);
            }
        } else {
            $this->response(array(
                "status" => 0,
                "message" => " id will be nedded"
                    ), parent::HTTP_NOT_FOUND);
        }
    }

    public function login_post() {

        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->email) && isset($data->password)) {
            $email = $data->email;
            $password = $data->password;
            $studnt_detailes = $this->Student_model->email_adress_exit($email);
            if (!empty($studnt_detailes)) {
                if (password_verify($password, $studnt_detailes->password)) {
                    $token = authorization::generateToken((array) $studnt_detailes);
                    $this->response(array(
                        "status" => 1,
                        "message" => "login successfully ",
                        "token" => $token
                            ), parent::HTTP_OK);
                } else {
                    $this->response(array(
                        "status" => 0,
                        "message" => "password dint match of "
                            ), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array(
                    "status" => 0,
                    "message" => "email does not exite"
                        ), parent::HTTP_NOT_FOUND);
            }
        } else {
            $this->response(array(
                "status" => 0,
                "message" => "all field will be needed"
                    ), parent::HTTP_NOT_FOUND);
        }
    }

    public function student_detalies_get() {

        $headers = $this->input->request_headers();
        $token = $headers['Authorization'];
        try {
            $student_data = authorization::validateToken($token);

            if ($student_data === false) {
                $this->response(array(
                    "status" => 0,
                    "message" => "unauthorized token access"
                        ), parent::HTTP_UNAUTHORIZED);
            } else {
                $this->response(array(
                    "status" => 1,
                    "message" => "student all data",
                    "data" => $student_data
                        ), parent::HTTP_OK);
            }
        } catch (Exception $ex) {
            $this->response(array(
                "status" => 0,
                "message" => $ex->getMessage()
                    ), parent::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
?>

