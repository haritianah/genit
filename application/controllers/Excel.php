<?php

class excel extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_excel');
        $this->load->library('excel');
    }
}