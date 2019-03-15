<?php

class Action_model extends CI_Model
{
    public function save_action_card($json_object, $group_name, $control, $action_card_id = NULL)
    {
        if($control == 'save')
        {
            $action_card_unique_id = $json_object->data->actionId;

            $action_package_id = $json_object->data->actionPackageId;
            $group_unique_id = $json_object->data->groupId;
            $action_card_subscription_id = $json_object->subscriptionId;
            $action_card_object_id = $json_object->objectId;
            $action_card_responder_id = $json_object->data->responseId;
            $action_card_responder_phone = $json_object->data->responder;
            $action_card_responder_name = $json_object->data->responderName;
            $action_card_event_type = $json_object->eventType;

            $data = array(
                'action_card_unique_id' => $action_card_unique_id,
                'action_card_package' => $action_package_id,
                'group_unique_id' => $group_unique_id,
                'group_name' => $group_name,
                'action_card_subscription_id' => $action_card_subscription_id,
                'action_card_object_id' => $action_card_object_id,
                'action_card_responder_id' => $action_card_responder_id,
                'action_card_responder_phone' => $action_card_responder_phone,
                'action_card_responder_name' => $action_card_responder_name,
                'action_card_event_type' => $action_card_event_type,
                'created_at' => date('Y/m/d H:i:s'),
                'created_by' => 0,
            );

            $this->db->insert('action_cards', $data);
            $action_id = $this->db->insert_id();

            if ($action_id) {
                return $action_id;
            } else {
                return false;
            }
        }
        else if($control == 'update')
        {
            $action_card_responder_id = $json_object->data->responseId;
            $action_card_responder_phone = $json_object->data->responder;
            $action_card_responder_name = $json_object->data->responderName;

            $data = array(
                'action_card_responder_id' => $action_card_responder_id,
                'action_card_responder_phone' => $action_card_responder_phone,
                'action_card_responder_name' => $action_card_responder_name,
                'created_at' => date('Y/m/d H:i:s'),
            );

            $this->db->set($data);
            $this->db->where('action_card_id', $action_card_id);
            if ($this->db->update('action_cards')) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
        
    }

    public function save_action_created($json_object, $group_name)
    {
            $action_card_unique_id = $json_object->data->actionId;

            $action_package_title = $json_object->data->title;
            $group_unique_id = $json_object->data->groupId;
            $action_card_subscription_id = $json_object->subscriptionId;
            $action_card_object_id = $json_object->objectId;
            $action_card_event_type = $json_object->eventType;

            $data = array(
                'action_card_unique_id' => $action_card_unique_id,
                'action_card_package' => $action_package_title,
                'group_unique_id' => $group_unique_id,
                'group_name' => $group_name,
                'action_card_subscription_id' => $action_card_subscription_id,
                'action_card_object_id' => $action_card_object_id,
                'action_card_responder_id' => 'null',
                'action_card_responder_phone' => 'null',
                'action_card_responder_name' => 'null',
                'action_card_event_type' => $action_card_event_type,
                'created_at' => date('Y/m/d H:i:s'),
                'created_by' => 0,
            );

            $this->db->insert('action_cards', $data);
            $action_id = $this->db->insert_id();

            if ($action_id) {
                return $action_id;
            } else {
                return false;
            }
    }

    public function check_if_action_exists($action_card_unique_id)
    {
        $this->db->select('action_card_id, action_card_package');
        $this->db->where('action_card_unique_id', $action_card_unique_id);
        $query = $this->db->get('action_cards');

        if ($query->num_rows() > 0) {
            return ($query->result())[0];
        } else {
            return false;
        }

    }

    public function save_action_response_question($response_with_question, $json_object, $action_card_id, $group_details, $response_id, $event_id, $action_card_name = NULL)
    {
        //Location
        $latitude = '';
        $longitude = '';
        $location = '';

        //Group name and group type
        $group_name = $group_details[0]->group_name;
        $group_type = $group_details[0]->group_type;

        //other details
        $action_card_unique_id = $json_object->data->actionId;
        $group_unique_id = $json_object->data->groupId;
        $responder_phone = $json_object->data->responder;
        $responder_name = $json_object->data->responderName;
        $responder_id = $json_object->data->responseId;
        $action_package = $action_card_name == NULL ? $json_object->data->actionPackageId : $action_card_name;
        $package_id = $json_object->data->packageId;

        $action_question = $response_with_question->title;
        $action_question_type = $response_with_question->type;

        if ($action_question_type == "MultipleOption" || $action_question_type == "MultiOption") {
            $action_answer = json_encode($response_with_question->answer);
        } else if ($action_question_type == "SingleOption") {
            $answer = $response_with_question->answer;
            $action_answer = $answer[0];
        } else if ($action_question_type == "Location") {
            $loc = $response_with_question->answer;
            $latitude = array_key_exists('lt', $loc) ? $loc->lt : '';
            $longitude = array_key_exists('lg', $loc) ? $loc->lg : '';
            $location = array_key_exists('n', $loc) ? $loc->n : '';
            $action_answer = json_encode($loc);
        } else {
            $action_answer = $response_with_question->answer;
        }

        $data = array(
            'action_unique_id' => $action_card_unique_id,
            'action_id' => $action_card_id,
            'group_unique_id' => $group_unique_id,
            'group_name' => $group_name,
            'group_type' => $group_type,
            'response_id' => $response_id,
            'event_id' => $event_id,
            'action_package' => $action_package,
            'package_id' => $package_id,
            'responder_id' => $responder_id,
            'responder_phone' => $responder_phone,
            'responder_name' => $responder_name,
            'action_question' => $action_question,
            'action_answer' => $action_answer,
            'action_question_type' => $action_question_type,
            'response_latitude' => $latitude,
            'response_longitude' => $longitude,
            'response_location' => $location,
            'created_at' => date('Y/m/d H:i:s'),
        );
        // echo json_encode($data);die();
        $this->db->insert('action_responses', $data);
        $action_response_question_id = $this->db->insert_id();

        if ($action_response_question_id) {
            return $action_response_question_id;
        } else {
            return false;
        }
    }

}
