<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Action extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Allow from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400'); // cache for 1 day
        }

        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
            }

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            }

            exit(0);
        }

        //Load models
        $this->load->model('action_model');
        $this->load->model('group_model');
    }

    public function index()
    {
        $params = $_SERVER['QUERY_STRING'];
        if ($params != null || $params != "") {
            $validation_token = str_replace('validationToken=', '', $params);
            echo ($validation_token);
        } else {
            $json_string = file_get_contents("php://input");

            $json_object = json_decode($json_string);

            if (is_array(json_decode($json_string, true))) {
                $event_type = $json_object->eventType;

                //fetch group
                $group_unique_id = $json_object->data->groupId;
                $group_details = $this->group_model->get_group_details($group_unique_id);
                $group_name = $group_details[0]->group_name;
                $action_card_unique_id = $json_object->data->actionId;

                if (strpos($event_type, 'Response') != false || strpos($event_type, 'response') != false) {

                    $if_action_exists = $this->action_model->check_if_action_exists($action_card_unique_id);

                    if ($if_action_exists == false) {
                        $action_card_id = $this->action_model->save_action_card($json_object, $group_name, 'save');

                        if ($action_card_id) {
                            $response_with_questions = $json_object->data->responseDetails->responseWithQuestions;
                            $response_id = $json_object->data->responseId;
                            $event_id = $json_object->eventId;

                            foreach ($response_with_questions as $key => $response_with_question) {
                                $action_response_question_id = $this->action_model->save_action_response_question($response_with_question, $json_object, $action_card_id, $group_details, $response_id, $event_id);
                            }

                            echo $action_response_question_id;
                        }
                    } else {

                        $action_card_id = $if_action_exists->action_card_id;

                        if ($this->action_model->save_action_card($json_object, $group_name, 'update', $action_card_id)) {

                            $action_card_name = $if_action_exists->action_card_package;

                            $response_with_questions = $json_object->data->responseDetails->responseWithQuestions;
                            $response_id = $json_object->data->responseId;
                            $event_id = $json_object->eventId;

                            foreach ($response_with_questions as $key => $response_with_question) {
                                $action_response_question_id = $this->action_model->save_action_response_question($response_with_question, $json_object, $action_card_id, $group_details, $response_id, $event_id, $action_card_name);
                            }

                            echo $action_response_question_id;
                        }
                    }

                } else if (strpos($event_type, 'Created') != false || strpos($event_type, 'Created') != false) {
                    $action_card_id = $this->action_model->save_action_created($json_object, $group_name);

                    echo $action_card_id;
                }
            } else {
                echo "No body was found";
            }
        }

    }
}
