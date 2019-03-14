<?php

class Actioncard_model extends CI_Model
{
    public function get_action_cards($limit, $start, $order, $order_method, $where)
    {
        if ($where != null) {
            $this->db->where($where);
        }

        $this->db->limit($limit, $start);
        $this->db->order_by($order, $order_method);

        return $this->db->get('action_cards')->result();
    }

    public function all_action_cards()
    {
        return $this->db->get('action_cards')->result();
    }

    public function actions_count($where)
    {
        if ($where != null) {
            $this->db->where($where);
        }
        $query = $this->db->get("action_cards");

        return $query->num_rows();
    }

    public function action_responses_count($where)
    {
        $this->db->where($where);
        $query = $this->db->get("action_responses");
        return $query->num_rows();
    }

    public function get_responses($limit, $start, $order, $order_method, $where)
    {
        if ($where != null) {
            $this->db->where($where);
        }

        $this->db->limit($limit, $start);
        $this->db->order_by($order, $order_method);

        return $this->db->get('action_responses')->result();
    }

    public function get_action_package($where)
    {
        $this->db->select('action_card_package_id');
        $this->db->where($where);
        return $this->db->get('action_cards')->result();
    }

    public function count_response($action_id)
    {
        $this->db->select('response_id');
        $this->db->distinct('response_id');
        $this->db->where('action_id', $action_id);
        $query = $this->db->get("action_responses");
        
        return $query->num_rows();
    }

    public function edit_package_name($action_id)
    {
        $package_name = $this->input->post('new_package_name');

        $card_data = array(
            'action_card_package' => $package_name,
        );

        $this->db->set($card_data);
        $this->db->where('action_card_id', $action_id);

        if ($this->db->update('action_cards')) {
            $response_data = array(
                'action_package' => $package_name,
            );
            $this->db->set($response_data);
            $this->db->where('action_id', $action_id);

            if ($this->db->update('action_responses')) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
