<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once "./application/modules/admin/controllers/Admin.php";

class Report extends admin
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = array(
            "title" => 'Reports',
            "page_header" => "Reports",
            "content" => $this->load->view("reports/all_reports", null, true),
            "check" => "comming-soon"
        );

        $this->load->view('layouts/layout', $data);
    }
}
