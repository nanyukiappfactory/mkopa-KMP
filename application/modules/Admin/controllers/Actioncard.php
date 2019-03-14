<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once "./application/modules/admin/controllers/Admin.php";
class Actioncard extends admin
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('actioncard_model');
        $this->load->model('site/site_model');
    }

    public function index($order = 'created_at', $order_method = 'DESC')
    {
        //pagination
        $segment = 5;

        $config = array();

        $config["per_page"] = 10;
        $config['num_links'] = 5;

        $start = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;

        $where = null;

        if ($this->session->userdata('search_params')) {
            $where = $this->session->userdata('search_params');
        }

        $action_cards = $this->actioncard_model->get_action_cards($config["per_page"], $start, $order, $order_method, $where);

        $config['full_tag_open'] = '<div class="pagging text-center"><nav aria-label="Page navigation example"><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav></div>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close'] = '</span></li>';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close'] = '</span></li>';

        $config["base_url"] = base_url() . "administration/all-actions/" . $order . "/" . $order_method;

        $config["total_rows"] = $this->actioncard_model->actions_count($where);

        $this->pagination->initialize($config);

        $v_data["action_cards"] = $action_cards;

        $v_data["links"] = $this->pagination->create_links();

        $v_data["counter"] = $start;
        $v_data["order_method"] = $order_method == "DESC" ? "ASC" : "DESC";

        $data = array(
            "title" => $this->site_model->display_page_title(),
            "page_header" => "Groups",
            "content" => $this->load->view("actions/all_actions", $v_data, true),
            "action_cards" => $v_data["action_cards"],
            "check" => "actions",
        );
        // var_dump($data);die();

        $this->load->view('layouts/layout', $data);
    }

    public function get_responses($action_id, $order = 'created_at', $order_method = 'DESC')
    {
        //pagination
        $segment = 6;

        $config = array();

        $config["per_page"] = 10;
        $config['num_links'] = 5;

        $start = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;

        $where = 'action_id = ' . $action_id;

        $action_responses = $this->actioncard_model->get_responses($config["per_page"], $start, $order, $order_method, $where);

        $config['full_tag_open'] = '<div class="pagging text-center"><nav aria-label="Page navigation example"><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav></div>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close'] = '</span></li>';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close'] = '</span></li>';

        $config["base_url"] = base_url() . "administration/all-responses/" . $action_id . "/" . $order . "/" . $order_method;

        $config["total_rows"] = $this->actioncard_model->action_responses_count($where);

        $this->pagination->initialize($config);

        $v_data["action_responses"] = $action_responses;

        $v_data['action_id'] = $action_id;

        $v_data["links"] = $this->pagination->create_links();

        $v_data["counter"] = $start;
        $v_data["order_method"] = $order_method == "DESC" ? "ASC" : "DESC";
        $v_data['count_response'] = $this->actioncard_model->count_response($action_id);

        $data = array(
            "title" => $this->site_model->display_page_title(),
            "page_header" => "Groups",
            "content" => $this->load->view("actions/all_responses", $v_data, true),
            "action_responses" => $v_data["action_responses"],
            "check" => "action_responses",
        );
        // var_dump($data);die();

        $this->load->view('layouts/layout', $data);
    }

    public function edit_package_name($action_id)
    {
        if ($this->actioncard_model->edit_package_name($action_id)) {
            $this->session->set_flashdata('success', 'Package name updated successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to update package name');
        }

        redirect('administration/all-actions');

    }
}
