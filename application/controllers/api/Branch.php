<?php

require APPPATH . 'libraries/REST_Controller.php';
//header

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST,GET");

class Branch extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("api/Branch_model");
    }

    public function create_post() {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->name)) {
            $branch_data = array(
                "name" => $data->name
            );
            if ($this->Branch_model->craete($branch_data)) {
                $this->response(array(
                    "status" => 1,
                    "message" => "Branch has beeen created"
                        ), parent::HTTP_OK);
            } else {
                $this->response(array(
                    "status" => 0,
                    "message" => "Branch has been faild"));
            }
        } else {
            $this->response(array(
                "status" => 0,
                "message" => "Branch name should be needed"
                    ), parent::HTTP_NOT_FOUND);
        }
    }

    public function list_get() {
        $branch_list = $this->Branch_model->get_all_branch();
        if (count($branch_list) > 0) {
            $this->response(array(
                "status" => 1,
                "message" => "Branch List",
                "data" => $branch_list
            ));
        } else {
            $this->response(array(
                "status" => 0,
                "message" => "No Data fount"
                    ), parent::HTTP_NOT_FOUND);
        }
    }

    public function delete_branch_delete() {
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->branch_id)) {
            if ($this->Branch_model->delete_branch($data->branch_id)) {
                $this->response(array(
                    "status" => 1,
                    "message" => "branch sucessfully Delete"
                        ), parent::HTTP_OK);
            } else {
                $this->response(array(
                    "status" => 0,
                    "message" => " Failed to Delete"
                        ), parent::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            $this->response(array(
                "status" => 0,
                'message' => "Branch id must be needed"
                    ), parent::HTTP_NOT_FOUND);
        }
    }

}
?>

